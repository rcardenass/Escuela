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
$query_rsCursos = "SELECT b.CodCurGra, c.NombreCurso as Curso, d.CodAnio, d.CodGrado, d.CodSeccion, d.CodMatricula FROM matriculacurso a INNER JOIN cursogrado b ON b.CodCurGra=a.CodCurGra INNER JOIN curso c ON c.CodCurso=b.CodCurso INNER JOIN matricula d ON d.CodMatricula=a.CodMatricula INNER JOIN alumno e ON e.CodAlumno=d.CodAlumno WHERE e.UsuarioId='$UsuarioId' group by b.CodCurGra ";
$rsCursos = mysql_query($query_rsCursos, $cn) or die(mysql_error());
$row_rsCursos = mysql_fetch_assoc($rsCursos);
$totalRows_rsCursos = mysql_num_rows($rsCursos);

$Sql ="SELECT CodAsistencia, DATE_FORMAT(FechaAsistencia,'%d/%m/%Y') AS Fecha, ";
$Sql.="CASE DAYOFWEEK(FechaAsistencia) ";
$Sql.="WHEN 1 THEN 'Domingo' ";
$Sql.="WHEN 2 THEN 'Lunes' ";
$Sql.="WHEN 3 THEN 'Martes' ";
$Sql.="WHEN 4 THEN 'Miercoles' ";
$Sql.="WHEN 5 THEN 'Jueves' ";
$Sql.="WHEN 6 THEN 'Viernes' ";
$Sql.="WHEN 7 THEN 'Sabado' END AS Dia, ";
$Sql.="CASE Marca ";
$Sql.="WHEN 1 THEN 'Asistio Temprano' ";
$Sql.="WHEN 2 THEN 'Tardanza Justificada' ";
$Sql.="WHEN 3 THEN 'Tardanza Injustificada' ";
$Sql.="WHEN 4 THEN 'Falta Justificada' ";
$Sql.="WHEN 5 THEN 'Falta Injustificada' END AS Marca ";
$Sql.="FROM asistencia ";
$Sql.="WHERE CodMatricula='".$row_rsCursos['CodMatricula']."' ";
if(isset($_POST['cboMes'])){
	$Sql.="and right(left(DATE_FORMAT(FechaAsistencia,'%d/%m/%Y'),5),2)='".$_POST['cboMes']."' ";
}else{
	$Sql.="and right(left(DATE_FORMAT(FechaAsistencia,'%d/%m/%Y'),5),2)='".date(n)."' ";
}
$Sql.="ORDER BY FechaAsistencia desc ";

mysql_select_db($database_cn, $cn);
/*$query_rsAsistencia = "SELECT CodAsistencia, DATE_FORMAT(FechaAsistencia,'%d/%m/%Y') AS Fecha,  CASE DAYOFWEEK(FechaAsistencia) 	WHEN 1 THEN 'Domingo' WHEN 2 THEN 'Lunes'	WHEN 3 THEN 'Martes' 	WHEN 4 THEN 'Miercoles' 	WHEN 5 THEN 'Jueves' WHEN 6 THEN 'Viernes' WHEN 7 THEN 'Sabado' END AS Dia,  CASE Marca WHEN 1 THEN 'Asistio Temprano' WHEN 2 THEN 'Tardanza Justificada' WHEN 3 THEN 'Tardanza Injustificada' WHEN 4 THEN 'Falta Justificada' WHEN 5 THEN 'Falta Injustificada' END AS Marca FROM asistencia WHERE CodMatricula='".$row_rsCursos['CodMatricula']."' ORDER BY FechaAsistencia desc";*/
$query_rsAsistencia = $Sql;
$rsAsistencia = mysql_query($query_rsAsistencia, $cn) or die(mysql_error());
$row_rsAsistencia = mysql_fetch_assoc($rsAsistencia);
$totalRows_rsAsistencia = mysql_num_rows($rsAsistencia);
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
			<h1>Mis Asistencias</h1><hr /><br />
			<form id="form1" name="form1" method="post" action="">
			  <table width="200" border="0" cellspacing="1" cellpadding="0">
                <tr>
                  <td><label>
                  <select name="cboMes" id="cboMes" style="width:100px">
                    <option value="02" <?php if (!(strcmp(02, date(n)))) {echo "selected=\"selected\"";} ?>>Febrero</option>
                    <option value="03" <?php if (!(strcmp(03, date(n)))) {echo "selected=\"selected\"";} ?>>Marzo</option>
                    <option value="04" <?php if (!(strcmp(04, date(n)))) {echo "selected=\"selected\"";} ?>>Abril</option>
                    <option value="05" <?php if (!(strcmp(05, date(n)))) {echo "selected=\"selected\"";} ?>>Mayo</option>
                    <option value="06" <?php if (!(strcmp(06, date(n)))) {echo "selected=\"selected\"";} ?>>Junio</option>
                    <option value="07" <?php if (!(strcmp(07, date(n)))) {echo "selected=\"selected\"";} ?>>Julio</option>
                    <option value="08" <?php if (!(strcmp(08, date(n)))) {echo "selected=\"selected\"";} ?>>Agosto</option>
                    <option value="09" <?php if (!(strcmp(09, date(n)))) {echo "selected=\"selected\"";} ?>>Setiembre</option>
                    <option value="10" <?php if (!(strcmp(10, date(n)))) {echo "selected=\"selected\"";} ?>>Octubre</option>
                    <option value="11" <?php if (!(strcmp(11, date(n)))) {echo "selected=\"selected\"";} ?>>Noviembre</option>
                    <option value="12" <?php if (!(strcmp(12, date(n)))) {echo "selected=\"selected\"";} ?>>Diciembre</option>
                  </select>
                  </label></td>
                  <td align="right"><label>
                    <input type="submit" name="Submit" value="Aceptar" />
                  </label></td>
                </tr>
              </table>
			  <div style="height:10px"></div>
			<table width="400" border="0" cellspacing="1" cellpadding="0" class="table">
              <tr class="tr">
                <td width="90">Fecha</td>
                <td width="100">D&iacute;a</td>
                <td>Marcaci&oacute;n</td>
              </tr>
              <?php do { ?>
              <tr>
                <td width="90"><?php echo $row_rsAsistencia['Fecha']; ?></td>
                <td width="100"><?php echo $row_rsAsistencia['Dia']; ?></td>
                <td><?php echo $row_rsAsistencia['Marca']; ?></td>
              </tr>
                <?php } while ($row_rsAsistencia = mysql_fetch_assoc($rsAsistencia)); ?>
            </table>
			</form>
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
mysql_free_result($rsAsistencia);
?>