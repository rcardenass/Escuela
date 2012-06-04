<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT COUNT(*) AS Cantidad FROM grado WHERE CodNivel='".$_POST['cboNivel']."' AND NombreGrado='".$_POST['txtGrado']."' AND Estado=1";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$Sql ="insert into grado (`CodGrado`, `CodNivel`, `NombreGrado`) ";
	$Sql.="values ('null', '".$_POST['cboNivel']."', '".$_POST['txtGrado']."') ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	header("location: acagrado.php");
}else{
	$_SESSION['TablaGrado']="No es posible grabar. Este registro ya existe.";
	header("location: acanewgrado.php");	
}
mysql_free_result($rsValida);
?>