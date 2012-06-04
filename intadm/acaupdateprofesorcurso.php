<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$Sql ="update profesorcurso set ";
$Sql.="CodCurGra='".$_POST['cboCurso']."', ";
$Sql.="CodAnio='".$_POST['cboAnio']."', ";
$Sql.="CodGrado='".$_POST['cboGrado']."', ";
$Sql.="CodSeccion='".$_POST['cboSeccion']."', ";
$Sql.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
$Sql.="FechaModificacion=now() ";
$Sql.="where CodProfesorCurso=".$_POST['txtCodigoProfesorCurso'];

mysql_select_db($database_cn, $cn);
$query_rsGrabar = $Sql;
$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
header("location: acaprofesorcurso.php");
?>