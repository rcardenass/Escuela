<?php include("../seguridad.php");?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsClaveActual = $objDatos->ObtenerClaveSelId($_SESSION['MM_Username'],md5($_POST['txtContraActual']));
$row_rsClaveActual = $objDatos->PoblarClaveSelId($rsClaveActual);
$totalRows_rsClaveActual = mysql_num_rows($rsClaveActual);

if($row_rsClaveActual['Cantidad']==1){
	if($_POST['txtNuevaContra']==$_POST['txtReNuevaContra']){
		if($objDatos->UpdateClaveUsuario($_SESSION['MM_Username'],md5($_POST['txtNuevaContra']),$_SESSION['MM_Username'])){
			header("Location: default.php");
		}else{
			header("Location: cueeditclave.php?a=a");
		}
	}else{
		header("Location: cueeditclave.php?a=b");
	}
}else{
	header("Location: cueeditclave.php?a=c");
}
?>