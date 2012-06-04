<?php
//MX Widgets3 include
require_once('../../includes/wdg/WDG.php');
?><?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "4";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../error.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php include('../../funciones.php'); ?>
<?php 
include("../../clases/datos.php");
$objDatos=new datos();

/*$rsAlumno = $objDatos->ObtenerAlumnoSelAll($_POST['txtBuscar']);
$rowAlumno = $objDatos->PoblarAlumnoSelAll($rsAlumno);
$totalRows_rsAlumno = mysql_num_rows($rsAlumno);*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../styleadm.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript" src="../../validar.js"></script>

<script src="../../includes/common/js/base.js" type="text/javascript"></script>
<script src="../../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../../includes/wdg/classes/NumericInput.js"></script>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
</head>

<body>
<form name="form1" method="post" action="acainsertcriterio2.php" onsubmit="MM_validateForm('txtCriterio','','R','txtPorcentaje','','RisNum','txtNroNota','','RisNum');return document.MM_returnValue" autocomplete="Off">
  <table width="100%" border="0" cellspacing="2" cellpadding="0" class="table">
    <tr class="tr">
      <td width="30"><div align="center">N&ordm;</div></td>
      <td>Criterio</td>
      <td width="60">%</td>
      <td width="60">N&ordm; Notas </td>
    </tr>
	<? for($x=1;$x<=$_POST['txtNroCriterio'];$x++){?>
    <tr>
      <td width="30"><div align="center"><? echo $x;?>
          <input name="txtCodigo[<? $x;?>]" type="hidden" id="txtCodigo[<? $x;?>]" />
      </div></td>
      <td><label>
        <input name="txtCriterio[<? $x;?>]" type="text" id="txtCriterio[<? $x;?>]" style="width:98%" />
      </label></td>
      <td width="60"><label>
        <input name="txtPorcentaje[<? $x;?>]" id="txtPorcentaje[<? $x;?>]" style="width:40px" value="" maxlength="3" wdg:subtype="NumericInput" wdg:negatives="no" wdg:type="widget" wdg:floats="no" wdg:spinner="no" />
      </label></td>
      <td width="60"><label>
        <input name="txtNroNota[<? $x;?>]" id="txtNroNota[<? $x;?>]" style="width:40px" value="" maxlength="2" wdg:subtype="NumericInput" wdg:negatives="no" wdg:type="widget" wdg:floats="no" wdg:spinner="no" />
      </label></td>
    </tr>
	<? }?>
	<tr>
      <td width="30"><input name="txtAnio" type="hidden" id="txtAnio" value="<? echo $_POST['txtAnio']; ?>" />
        <input name="txtArea" type="hidden" id="txtArea" value="<? echo $_POST['txtArea']; ?>" />
        <input name="txtGrado" type="hidden" id="txtGrado" value="<? echo $_POST['txtGrado']; ?>" />
      <input name="txtNroCriterio" type="hidden" id="txtNroCriterio" value="<? echo $_POST['txtNroCriterio']; ?>" /></td>
      <td colspan="3"><label>
        <input type="submit" name="Submit" value="Grabar" />
      </label></td>
    </tr>
  </table>
</form>
</body>
</html>
