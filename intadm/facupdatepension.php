<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$Sql ="update pensiones set ";
$Sql.="Estado='".$_POST['cboEstado']."', ";
if($_POST['cboEstado']==1){
	$Sql.="Aprobar='".$_POST['cboAprobar']."', ";
}
$Sql.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
$Sql.="FechaModificacion=now() ";
$Sql.="where CodPension=".$_POST['txtCodigoPension'];


mysql_select_db($database_cn, $cn);
$query_rsGrabar = $Sql;
$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
header("location: facpension.php");
?>