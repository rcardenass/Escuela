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

$rsMatricula = $objDatos->ObtenerMatriculaSelAll($_POST['cboAnio'],$_POST['cboGrado'],$_POST['cboSeccion'],$_POST['txtBuscar']);
$rowMatricula = $objDatos->PoblarMatriculaSelAll($rsMatricula);
$totalRows_rsMatricula = mysql_num_rows($rsMatricula);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Retirado {color: #FF0000}
-->
</style>
<link href="../../styleadm.css" rel="stylesheet" type="text/css">
</head>

<body>
<table class="table" width="100%" border="0" cellspacing="2" cellpadding="0">
	<tr class="tr">
    	<td width="50"><div style="width:40px; float:right; text-align:right; padding-right:5px">Id</div></td>
        <td width="50"><div style="text-align:center">A&ntilde;o</div></td>
		<td>Alumno</td>
		<td width="170">Grado</td>
        <td width="60" align="center">Secci&oacute;n</td>
        <td width="60">Turno</td>
        <td width="32" align="center">&nbsp;</td>
	</tr>
    <?php 
	if(!empty($totalRows_rsMatricula)){
		do { 
		?>
        <? Filas();?>
        	<td width="50">
			<div style="width:40px; float:right; text-align:right; padding-right:5px">
			<strong>
        <span <? if($rowMatricula['EstadoRetirado']==1){ echo "class='Retirado'"; }?>><?php echo $rowMatricula['CodMatricula']; ?></span>
                        </strong></div>
			</td>
            <td width="50"><div style="text-align:center"><span <? if($rowMatricula['EstadoRetirado']==1){ echo "class='Retirado'"; }?>><?php echo $rowMatricula['NombreAnio']; ?></span></div></td>
            <td><span <? if($rowMatricula['EstadoRetirado']==1){ echo "class='Retirado'"; }?>><?php echo utf8_encode($rowMatricula['Alumno']); ?></span></td>
            <td width="170"><span <? if($rowMatricula['EstadoRetirado']==1){ echo "class='Retirado'"; }?>><?php echo utf8_encode($rowMatricula['NombreGrado']); ?></span></td>
            <td width="60" align="center"><span <? if($rowMatricula['EstadoRetirado']==1){ echo "class='Retirado'"; }?>><?php echo $rowMatricula['NombreSeccion']; ?></span></td>
            <td width="60"><span <? if($rowMatricula['EstadoRetirado']==1){ echo "class='Retirado'"; }?>><?php echo $rowMatricula['Turno']; ?></span></td>
            <td width="32" align="center">
			<a href="acaeditmatricula.php?Codigo=<?php echo $rowMatricula['CodMatricula']; ?>">
			<img src="../imagenes/icono/edit.png" width="22" border="0" title="Editar"/></a>
			</td>
		</tr>
        <?php 
		} while ($rowMatricula = $objDatos->PoblarMatriculaSelAll($rsMatricula)); 
	}
	?>
</table>
</body>
</html>
<?
mysql_free_result($rsMatricula);
?>