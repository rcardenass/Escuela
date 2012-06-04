<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT COUNT(*) AS Cantidad FROM gradoseccion WHERE CodGrado='".$_POST['cboGrado']."' AND CodSeccion='".$_POST['cboSeccion']."' AND Estado=1";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$Sql ="insert into gradoseccion (`CodGraSec`, `CodGrado`, `CodSeccion`) ";
	$Sql.="values ('null', '".$_POST['cboGrado']."', '".$_POST['cboSeccion']."') ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	header("location: acagradoseccion.php");	
}else{
	$_SESSION['GradoSeccion']="No es posible grabar. Este registro ya existe.";
	header("location: acanewgradoseccion.php");	
}


mysql_free_result($rsValida);
?>