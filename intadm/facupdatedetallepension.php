<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$FechaInicio=substr($_POST['txtDesde'], -4, 4).'-'.substr($_POST['txtDesde'], 3, 2).'-'.substr($_POST['txtDesde'], 0, 2);
$FechaTermino=substr($_POST['txtHasta'], -4, 4).'-'.substr($_POST['txtHasta'], 3, 2).'-'.substr($_POST['txtHasta'], 0, 2);

$Sql ="update detallepension set ";
$Sql.="Monto='".$_POST['txtMonto']."', ";
$Sql.="FechaInicio='".$FechaInicio."', ";
$Sql.="FechaTermino='".$FechaTermino."', ";
$Sql.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
$Sql.="FechaModificacion=now() ";
$Sql.="where CodDetallePension=".$_POST['txtId'];

mysql_select_db($database_cn, $cn);
$query_rsGrabar = $Sql;
$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());

header("location: facdetallepension.php?Codigo=".$_POST['txtCodigo']);
?>