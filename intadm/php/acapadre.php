<?php
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

$MM_restrictGoTo = "../error.php";
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

$rsPadre = $objDatos->ObtenerPadreFamiliaSelAll($_POST['txtBuscar']);
$rowPadre = $objDatos->PoblarPadreFamiliaSelAll($rsPadre);
$totalRows_rsPadre = mysql_num_rows($rsPadre);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../styleadm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="2" cellpadding="0" class="table">
  <tr class="tr">
    <td width="40">&nbsp;</td>
    <td width="40" align="center">Tipo</td>
    <td>Padre de Familia </td>
    <td width="150">Telefonos</td>
    <td width="180">Email</td>
    <td width="20" align="center">#</td>
    <td width="30">&nbsp;</td>
    <td width="30">&nbsp;</td>
  </tr>
  <? if(empty($totalRows_rsPadre)){ ?>
  <tr>
    <td colspan="8"><div style="padding-left:5px">No existen registros</div></td>
  </tr>
  <? } ?>
  <? if($totalRows_rsPadre>0){ ?>
  <? do{ ?>
  <? Filas();?>
    <tr><td width="40"><div style="text-align:right; padding-right:5px"><strong><? echo $rowPadre['CodPadreFamilia']; ?></strong></div></td>
    <td width="40" align="center"><? echo $rowPadre['Tipo']; ?></td>
    <td><? echo utf8_encode($rowPadre['Padre']); ?></td>
    <td width="150"><? echo $rowPadre['Telefonos']; ?></td>
    <td width="180"><? echo utf8_encode($rowPadre['Email']); ?></td>
    <td width="20" align="center"><? echo $rowPadre['Nro']; ?></td>
    <td width="30" align="center"><a href="acaeditpadre.php?Codigo=<? echo $rowPadre['CodPadreFamilia']; ?>"><img src="../imagenes/icono/edit.png" width="20" border="0" title="Editar"/></a></td>
    <td width="30" align="center"><a href="acaenlazapadrealumno.php?Codigo=<? echo $rowPadre['CodPadreFamilia']; ?>"><img src="../imagenes/icono/links.png" width="20" border="0" title="Enlazar"></a></td>
  </tr>
  <? }while($rowPadre = $objDatos->PoblarPadreFamiliaSelAll($rsPadre)); ?>
  <? } ?>
</table>
</body>
</html>
