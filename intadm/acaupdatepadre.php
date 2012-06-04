<?php include("../seguridad.php");?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$Ubigeo=$_POST['cboDepartamento'].substr($_POST['cboProvincia'],2,2).substr($_POST['cboDistrito'],4,2);

if($objDatos->updatePadreFamilia($_POST['txtCodigo'],$_POST['txtApellidoPaterno'], $_POST['txtApellidoMaterno'], $_POST['txtNombres'], $_POST['txtFechaNacimiento'], $_POST['cboTipoDocumento'], $_POST['txtNumeroDocumento'], $Ubigeo, $_POST['txtDireccion'], $_POST['txtReferencia'], $_POST['txtTelefono'], $_POST['txtCelular'], $_POST['txtNextel'], $_POST['txtEmail'], $_SESSION['MM_Username'])){
    header("Location: acapadre.php");
}else{
    $_SESSION['TablaPadreFamilia']="No es posible grabar. Este registro ya existe &oacute; a ocurrido un error. Intentelo nuevamente!";
    header("Location: acaeditpadre.php?Codigo='".$_POST['txtCodigo']."'");
}
?>