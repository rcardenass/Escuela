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

$rsConsultaProfesorCurso=$objDatos->ObtenerConsultaProfesorCursoSelAll($_POST['cboAnio'],$_POST['cboNivel'],$_POST['cboGrado'],$_POST['cboSeccion']);
$rowConsultaProfesorCurso=$objDatos->PoblarConsultaProfesorCursoSelAll($rsConsultaProfesorCurso);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../styleadm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table class="table" width="700" border="0" cellspacing="2" cellpadding="0">
  <tr class="tr">
    <td width="40"><div style="text-align:right; padding-right:3px">Nro</div></td>
    <td width="50"><div style="text-align:right; padding-right:3px">C&oacute;digo</div></td>
    <td width="180">Grado-Secci&oacute;n</td>
	<td>Profesor</td>
    <td>Curso</td>
  </tr>
  <? 
  $i=1;
  do{ 
  ?>
  <? Filas();?>
    <td width="40"><div style="text-align:right; padding-right:3px"><strong><?= $i; ?></strong></div></td>
    <td width="50"><div style="text-align:right; padding-right:3px"><?= $rowConsultaProfesorCurso['CodProfesorCurso']; ?></div></td>
    <td width="180"><?= utf8_encode($rowConsultaProfesorCurso['GradoSeccion']); ?></td>
	<td><?= utf8_encode($rowConsultaProfesorCurso['Profesor']); ?></td>
    <td><?= utf8_encode($rowConsultaProfesorCurso['NombreCurso']); ?></td>
  </tr>
  <? 
  $i++;
  }while($rowConsultaProfesorCurso=$objDatos->PoblarConsultaProfesorCursoSelAll($rsConsultaProfesorCurso)); 
  ?>
</table>
</body>
</html>
