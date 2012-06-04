<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?
include("../clases/datos.php");
$objDatos=new datos();

if(empty($_POST['chkEstado'])){
	$Estado=0;
}else{
	$Estado=1;
}

if($objDatos->UpdateProducto($_POST['txtCodigo'],$_POST['txtPrecio'],$_POST['txtDescuento'],$Estado,$_SESSION['MM_Username'])){
	header("Location: cueconcepto.php");
}else{
	header("Location: cueeditconcepto.php?Codigo=".$_POST['txtCodigo']." ");
}
?>