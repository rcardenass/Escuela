<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT COUNT(*) AS Cantidad FROM curso WHERE NombreCurso='".$_POST['txtCurso']."' ";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$Sql ="insert into curso (`CodCurso`, `NombreCurso`) ";
	$Sql.="values ('null','".$_POST['txtCurso']."') ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	header("location: acacurso.php");
}else{
	$_SESSION['TablaCurso']="No es posible grabar. Este registro ya existe.";
	header("location: acanewcurso.php");	
}

mysql_free_result($rsValida);
?>