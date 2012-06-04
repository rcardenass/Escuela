<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$Sql ="update productos set ";
$Sql.="NombreProducto='".$_POST['txtProducto']."', ";
$Sql.="Precio='".$_POST['txtPrecio']."', ";
$Sql.="Descuento='".$_POST['txtDescuento']."', ";
$Sql.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
$Sql.="FechaModificacion=now() ";
$Sql.="where CodProducto=".$_POST['txtCodigoProducto'];


mysql_select_db($database_cn, $cn);
$query_rsGrabar = $Sql;
$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
header("location: facproducto.php");
?>