<?php require_once('../Connections/cn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
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
<?php
$UsuarioId=$_SESSION['MM_Username'];
mysql_select_db($database_cn, $cn);
$query_rsCursos = "SELECT b.CodCurGra, c.NombreCurso as Curso FROM matriculacurso a INNER JOIN cursogrado b ON b.CodCurGra=a.CodCurGra INNER JOIN curso c ON c.CodCurso=b.CodCurso INNER JOIN matricula d ON d.CodMatricula=a.CodMatricula INNER JOIN alumno e ON e.CodAlumno=d.CodAlumno WHERE e.UsuarioId='$UsuarioId' group by b.CodCurGra ";
$rsCursos = mysql_query($query_rsCursos, $cn) or die(mysql_error());
$row_rsCursos = mysql_fetch_assoc($rsCursos);
$totalRows_rsCursos = mysql_num_rows($rsCursos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templatealu.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Intranet del Alumno</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
<link href="../styleadm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div style = "display: table; margin-left: auto; margin-right: auto; width: 90%; background-color:#66FF00">
    <div style = "height: 105px; width: 100%; background-color:#FF3300" class="Logo">Cabecera</div>
	<div style = "float: left; height: 450px; width: 100%; background-color:#cccccc">
		<div style = "float: left; height: 450px; width: 20%; background-color:#CC6699" class="Menu">
		  <table width="150px" border="0" cellspacing="0" cellpadding="0">
		  	<tr>
              <td width="20">&nbsp;</td>
              <td>Mis Cursos</td>
            </tr>
            <?php do { ?>
            <tr>
              <td width="20">&nbsp;</td>
              <td><a href="curso.php?Codigo=<?php echo $row_rsCursos['CodCurGra']; ?>"><?php echo $row_rsCursos['Curso']; ?></a></td>
            </tr>
              <?php } while ($row_rsCursos = mysql_fetch_assoc($rsCursos)); ?>
          </table>
		  <div style="height:10px"></div>
		  <table width="150" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20">#</td>
              <td>Mis Compañeros</td>
            </tr>
            <tr>
              <td width="20">&nbsp;</td>
              <td><a href="lista.php">Participantes</a></td>
            </tr>
          </table>
		  <? if(isset($_GET['Codigo'])){?>
		  &nbsp;
		  <table width="150" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20">#</td>
              <td>Actividades</td>
            </tr>
  			<!--          <tr>
              <td width="20">&nbsp;</td>
              <td>Materiales del Curso </td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>Foro</td>
            </tr>-->
            <tr>
              <td>&nbsp;</td>
              <td><a href="mensaje.php?Codigo=<?php echo $_GET['Codigo']; ?>">Msjs del Docente </a></td>
            </tr>
            <!--<tr>
              <td>&nbsp;</td>
              <td>Link de Interes </td>
            </tr>-->
          </table>
		  <? }?>
		  &nbsp;
		  <table width="150" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20">#</td>
              <td>Administraci&oacute;n</td>
            </tr>
			<? if(isset($_GET['Codigo'])){?>
            <tr>
              <td width="20">&nbsp;</td>
              <td><a href="evaluacion.php?Codigo=<?php echo $_GET['Codigo']; ?>">Notas Actuales</a></td>
            </tr>
			<? }?>
            <tr>
              <td>&nbsp;</td>
              <td><a href="asistencia.php">Record de Asistencia</a></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><a href="../cerrar.php">Salir</a></td>
            </tr>
          </table>
		</div>
		<div style = "float: left; height: 450px; width: 59%; background-color:#9999CC; padding-left:5px">
			<!-- InstanceBeginEditable name="Cuerpo" -->
			Cuerpo
			<!-- InstanceEndEditable -->			
		</div>
		<div style = "float: right; height: 450px; width: 20%; background-color:#cccccc">ccc</div>
	</div>
	<div style = "height: 50px; width: 100%; background-color:#FF3300" class="Pie">Pie</div>
</div>	
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsCursos);
?>
