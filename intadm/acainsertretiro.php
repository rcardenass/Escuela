<?php 
include("../seguridad.php");
include("../clases/datos.php");
$objDatos=new datos();

if($objDatos->InsertRetiro($_POST['txtCodAlumno'], $_POST['txtCodMatricula'], $_POST['cboColegio'], $_POST['txtMotivo'], $_POST['txtDescripcion'], $_SESSION['MM_Username'])==1){
	if($objDatos->UpdateRetiroMatricula($_POST['txtCodMatricula'],$_SESSION['MM_Username'])){
		header("Location: acaretirado.php");
	}else{
		$_SESSION['TablaRetirado']="Ocurrio un problema. Comunique al administrador que se genero el retiro del alumno, pero no se actualizo el estado de matricula. Informar al Proveedor";
		header("Location: acanewretiro.php?Codigo=".$_POST['txtCodMatricula']);
	}
	;
}else{
	$_SESSION['TablaRetirado']="No es posible Retirar a este alumno. Verifique la situación de su matricula o ya se encuentra retirado";
	header("Location: acanewretiro.php?Codigo=".$_POST['txtCodMatricula']);
}
?>