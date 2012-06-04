<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$Sql ="update criterio set ";
/*$Sql.="CodAnio='".$_POST['cboAnio']."', ";
$Sql.="CodArea='".$_POST['cboArea']."', ";
$Sql.="CodGrado='".$_POST['cboGrado']."', ";*/
$Sql.="NombreCriterio='".$_POST['txtCriterio']."', ";
//$Sql.="Porcentaje='".$_POST['cboPorcentaje']."', ";
$Sql.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
$Sql.="FechaModificacion=now() ";
$Sql.="where CodCriterio=".$_POST['txtCodigoCriterio'];

mysql_select_db($database_cn, $cn);
$query_rsGrabar = $Sql;
$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());

header("location: acacriterio.php");
?>