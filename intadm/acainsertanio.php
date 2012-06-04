<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT COUNT(*) AS Cantidad FROM anio WHERE NombreAnio='".$_POST['txtAnio']."' ";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$Sql ="insert into anio (`CodAnio`, `NombreAnio`) ";
	$Sql.="values ('null', '".$_POST['txtAnio']."') ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	header("location: acaanio.php");
}else{
	$_SESSION['TablaAnio']="No es posible grabar. Este registro ya existe.";
	header("location: acanewanio.php");	
}
mysql_free_result($rsValida);
?>