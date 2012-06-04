<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
//$query_rsRevision = "SELECT COUNT(*) AS Cantidad FROM caja WHERE UsuarioCreacion='".$_SESSION['MM_Username']."' AND Estado=1 ";
$query_rsRevision = "SELECT COUNT(*) AS Cantidad FROM caja WHERE Estado=1 ";
$query_rsRevision.= "AND DATE_FORMAT(Fecha,'%d/%m/%Y')<DATE_FORMAT(now(),'%d/%m/%Y') ";
$rsRevision = mysql_query($query_rsRevision, $cn) or die(mysql_error());
$row_rsRevision = mysql_fetch_assoc($rsRevision);
$totalRows_rsRevision = mysql_num_rows($rsRevision);

if($row_rsRevision['Cantidad']==0){
	mysql_select_db($database_cn, $cn);
	$query_rsValida = "SELECT CodDia, Estado FROM dia WHERE Estado = 1 AND DATE_FORMAT(FechaApertura,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y')";
	$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
	$row_rsValida = mysql_fetch_assoc($rsValida);
	$totalRows_rsValida = mysql_num_rows($rsValida);
	
	if($totalRows_rsValida==1){
		mysql_select_db($database_cn, $cn);
		$query_rsExiste = "SELECT COUNT(*) AS Cantidad FROM caja WHERE CodDia='".$row_rsValida['CodDia']."' AND DATE_FORMAT(Fecha,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y') AND Estado = 1 and UsuarioCreacion='".$_SESSION['MM_Username']."' ";
		$rsExiste = mysql_query($query_rsExiste, $cn) or die(mysql_error());
		$row_rsExiste = mysql_fetch_assoc($rsExiste);
		$totalRows_rsExiste = mysql_num_rows($rsExiste);
	
		if($row_rsExiste['Cantidad']==0){
			$Sql ="insert into caja (CodCaja, CodDia, Fecha, CajaChica, UsuarioCreacion, FechaCreacion )";
			$Sql.="values ('null', '".$row_rsValida['CodDia']."', now(), '".$_POST['txtCajaChica']."', '".$_SESSION['MM_Username']."', now() )";
			mysql_select_db($database_cn, $cn);
			$query_rsGrabar = $Sql;
			$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
			
			header("Location: tescaja.php");
		}else{
			$_SESSION['TablaCaja']="No es posible grabar. Este registro ya existe.";
			header("location: tesnewcaja.php");	
		}
		mysql_free_result($rsExiste);
	}else{
		?>
		<script>
		alert ("No se ha aperturado el día. Comuniquese con el Administrador");
		location.href="tesnewcaja.php";
		</script>
		<?
	}
	mysql_free_result($rsValida);
}else{
	?>
	<script>
	alert ("No es posible abrir caja. Comuniquese con el Administrador");
	location.href="tescaja.php";
	</script>
	<?
}
mysql_free_result($rsRevision);
?>