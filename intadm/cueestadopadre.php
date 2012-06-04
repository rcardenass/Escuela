<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$colname_rsEstado = "-1";
if (isset($_GET['Codigo'])) {
  $colname_rsEstado = (get_magic_quotes_gpc()) ? $_GET['Codigo'] : addslashes($_GET['Codigo']);
}
mysql_select_db($database_cn, $cn);
$query_rsEstado = sprintf("SELECT Estado FROM usuario WHERE CodUsuario = %s", $colname_rsEstado);
$rsEstado = mysql_query($query_rsEstado, $cn) or die(mysql_error());
$row_rsEstado = mysql_fetch_assoc($rsEstado);
$totalRows_rsEstado = mysql_num_rows($rsEstado);

$Sql ="update usuario set ";
if($row_rsEstado['Estado']==1){
	$Sql.="Estado=0, ";
}else{
	$Sql.="Estado=1, ";
}
$Sql.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
$Sql.="FechaModificacion=now() ";
$Sql.="where CodUsuario='".$_GET['Codigo']."' ";
mysql_select_db($database_cn, $cn);
$query_rsUpdate = $Sql;
$rsUpdate = mysql_query($query_rsUpdate, $cn) or die(mysql_error());

mysql_free_result($rsEstado);

header("Location: cuepadre.php");

?>