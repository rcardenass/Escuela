<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php 
$a=$_POST['txtCodMonto'];
$b=$_POST['txtMonto'];
$c=$_POST['txtCantidad'];
$d=$_POST['txtSubTotal'];

$i=0;
foreach($a as $CodMonto){
	$A[$i]=$CodMonto;
	//echo "CodMonto ".$A[$i]."<br>";
	$i++;
}

$i2=0;
foreach($b as $Monto){
	$B[$i2]=$Monto;
	//echo "Monto ".$B[$i2]."<br>";
	$i2++;
}

$i3=0;
foreach($c as $Cantidad){
	$C[$i3]=$Cantidad;
	//echo "Cantidad ".$C[$i3]."<br>";
	$i3++;
}

$i4=0; $Total=0;
foreach($d as $SubTotal){
	$D[$i4]=$SubTotal;
	//echo "SubTotal ".$D[$i4]."<br>";
	$Total=$Total+$SubTotal;
	$i4++;
}

for($j=0;$j<=$i-1;$j++){
	$Sql ="insert into arqueo (CodArqueo, CodCaja, CodMoneda, Moneda, Cantidad, Total, UsuarioCreacion, FechaCreacion) ";
	$Sql.="values ('null', '".$_POST['txtCodCaja']."', '".$A[$j]."', '".$B[$j]."', '".$C[$j]."', '".$D[$j]."', '".$_SESSION['MM_Username']."', now()) ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
}

$Sql_Update ="Update caja set Estado=0, MontoCierre='".$Total."', UsuarioModificacion='".$_SESSION['MM_Username']."', ";
$Sql_Update.="FechaModificacion=now() where CodCaja='".$_POST['txtCodCaja']."' ";
mysql_select_db($database_cn, $cn);
$query_rsUpdate = $Sql_Update;
$rsUpdate = mysql_query($query_rsUpdate, $cn) or die(mysql_error());

header("Location: tescaja.php");
?>