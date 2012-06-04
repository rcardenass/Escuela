<?php 
include("../seguridad.php");
require_once('../Connections/cn.php'); 
include("../clases/datos.php");
$objDatos=new datos();

$Fecha=substr($_POST['txtFechaNacimiento'], -4, 4).'-'.substr($_POST['txtFechaNacimiento'], 3, 2).'-'.substr($_POST['txtFechaNacimiento'], 0, 2);

if($objDatos->UpdateAlumno($_POST['txtCodigoAlumno'],$_POST['txtApellidoPaterno'],$_POST['txtApellidoMaterno'],$_POST['txtNombres'],$Fecha,$_POST['cboSexo'],$_POST['cboTipoDocumento'],$_POST['txtNumeroDocumento'],$_POST['cboDistrito'],$_POST['txtDireccion'],$_POST['txtReferencia'],$_POST['txtTelefono'],$_POST['txtEmailPersonal'],$_POST['txtEmailInstitucional'],$_POST['cboColegioAnterior'],$_POST['txtCodigoUgel'],$_SESSION['MM_Username'])){
	header("Location: acaalumno.php");
}else{
	$_SESSION['TablaAlumno']="No es posible actualizar. Por favor intentelo nuevamente!";
	header("location: acaeditalumno.php?Codigo=".$_POST['txtCodigo']);
}
?>