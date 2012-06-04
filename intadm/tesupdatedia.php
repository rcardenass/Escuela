<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsDia = "SELECT CodDia, FechaApertura, Estado FROM dia WHERE CodDia = '".$_GET['Codigo']."' ";
$rsDia = mysql_query($query_rsDia, $cn) or die(mysql_error());
$row_rsDia = mysql_fetch_assoc($rsDia);
$totalRows_rsDia = mysql_num_rows($rsDia);

mysql_select_db($database_cn, $cn);
$query_rsCaja = "SELECT COUNT(*) AS Cantidad FROM caja WHERE DATE_FORMAT(Fecha,'%d/%m/%Y')=DATE_FORMAT('".$row_rsDia['FechaApertura']."','%d/%m/%Y') and Estado=1 ";
$rsCaja = mysql_query($query_rsCaja, $cn) or die(mysql_error());
$row_rsCaja = mysql_fetch_assoc($rsCaja);
$totalRows_rsCaja = mysql_num_rows($rsCaja);

if($row_rsCaja['Cantidad']==0){
	mysql_select_db($database_cn, $cn);
	$query_rsUpdate = "update dia set Estado=0, FechaCierre=now(), UsuarioModificacion='".$_SESSION['MM_Username']."', ";
	$query_rsUpdate.= "FechaModificacion=now() where CodDia='".$_GET['Codigo']."'";
	$rsUpdate = mysql_query($query_rsUpdate, $cn) or die(mysql_error());
}else{
	?>
	<script>
		alert ("No es posible cerrar el día. Aun existen cajas sin cerrar");
		location.href="tesdia.php";
	</script>
	<?
}
mysql_free_result($rsDia);
mysql_free_result($rsCaja);

header("Location: tesdia.php");
?>