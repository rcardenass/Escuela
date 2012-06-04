<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$a=$_POST['txtCodigo'];
$b=$_POST['txtTotal'];

$i=1;
foreach($a as $Codigo){
	$A[$i]=$Codigo;
	$i++;
}

$i2=1;
foreach($b as $Total){
	$B[$i2]=$Total;
	$i2++;
}

for($j=1;$j<$i;$j++){
	mysql_select_db($database_cn, $cn);
	$query_rsValida = "SELECT CodTemporal, Monto FROM temporal WHERE UsuarioCreacion='".$_SESSION['MM_Username']."' and CodTemporal = '".$A[$j]."' ";
	$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
	$row_rsValida = mysql_fetch_assoc($rsValida);
	$totalRows_rsValida = mysql_num_rows($rsValida);
	
	if($row_rsValida['Monto']>=$B[$j]){
		$Sql ="update temporal set Total='".$B[$j]."' where CodTemporal='".$A[$j]."' and UsuarioCreacion='".$_SESSION['MM_Username']."' "; 
		mysql_select_db($database_cn, $cn);
		$query_Update = $Sql;
		$Update = mysql_query($query_Update, $cn) or die(mysql_error());
	}else{
	?>
	<script>
	alert ("El valor debe ser menor al Monto <? echo $row_rsValida['Monto']; ?> ");
	location.href="facitem2.php";
	</script>
	<?
	}
	mysql_free_result($rsValida);
}

header("Location: facitem2.php");
?>