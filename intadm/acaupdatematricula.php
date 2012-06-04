<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$Sql ="update matricula set ";
$Sql.="CodGrado='".$_POST['cboGrado']."', ";
$Sql.="CodSeccion='".$_POST['cboSeccion']."', ";
$Sql.="Turno='".$_POST['cboTurno']."', ";
$Sql.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
$Sql.="FechaModificacion=now() ";
$Sql.="where CodMatricula=".$_POST['txtCodigoMatricula'];


mysql_select_db($database_cn, $cn);
$query_rsGrabar = $Sql;
$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
header("location: acamatricula.php");
?>