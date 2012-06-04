<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT COUNT(*) AS Cantidad FROM pensiones WHERE Estado=1 and CodAnio='".$_POST['cboAnio']."' AND CodGrado='".$_POST['cboGrado']."' AND CodSeccion='".$_POST['cboSeccion']."' ";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$Sql ="insert into pensiones (`CodPension`, `CodAnio`, `CodGrado`, `CodSeccion`, `FlagMora`, `Mora`, `NroMeses`, `UsuarioCreacion`, `FechaCreacion`) ";
	$Sql.="values ('null', '".$_POST['cboAnio']."', '".$_POST['cboGrado']."', '".$_POST['cboSeccion']."', '".$_POST['cboFlagMora']."', '".$_POST['txtMora']."', '".$_POST['txtNroMeses']."', '".$_SESSION['MM_Username']."', now()) ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	
	
	mysql_select_db($database_cn, $cn);
	$query_rsCodPension = "SELECT max(CodPension) as CodigoPension FROM pensiones";
	$rsCodPension = mysql_query($query_rsCodPension, $cn) or die(mysql_error());
	$row_rsCodPension = mysql_fetch_assoc($rsCodPension);
	$totalRows_rsCodPension = mysql_num_rows($rsCodPension);
	
	for($i=1;$i<=$_POST['txtNroMeses'];$i++){
		$SqlD ="insert into detallepension (`CodDetallePension`, `CodPension`, `NroPension`, ";
		$SqlD .="`Monto`, `FechaInicio`, `FechaTermino`, `UsuarioCreacion`, `FechaCreacion`) ";
		$SqlD .="values ('null', '".$row_rsCodPension['CodigoPension']."', '".$i."', 0, now(), now(), '".$_SESSION['MM_Username']."', now()) ";
		mysql_select_db($database_cn, $cn);
		$query_rsGrabarD = $SqlD;
		$rsGrabarD = mysql_query($query_rsGrabarD, $cn) or die(mysql_error());
	}
	header("location: facpension.php");
}else{
	$_SESSION['TablaPension']="No es posible grabar. Este registro ya existe.";
	header("location: facnewpension.php");	
}

mysql_free_result($rsValida);

mysql_free_result($rsCodPension);
?>