<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT COUNT(*) AS Cantidad FROM seccion WHERE NombreSeccion='".$_POST['txtSeccion']."' ";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$Sql ="insert into seccion (`CodSeccion`, `NombreSeccion`) ";
	$Sql.="values ('null', '".$_POST['txtSeccion']."') ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	header("location: acaseccion.php");
}else{
	$_SESSION['TablaSeccion']="No es posible grabar. Este registro ya existe.";
	header("location: acanewseccion.php");	
}

mysql_free_result($rsValida);
?>