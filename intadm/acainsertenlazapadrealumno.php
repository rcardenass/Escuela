<?php include("../seguridad.php");?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsPadre=$objDatos->ObtenerPadreFamiliaSelId($_SESSION['CodPadreFamilia']);
$row_Padre=$objDatos->PoblarPadreFamiliaSelId($rsPadre);

if($objDatos->UpdateAlumnoPadreFamilia($_SESSION['CodPadreFamilia'], $_POST['txtCodigoAlumno'], $row_Padre['Tipo'], $_SESSION['MM_Username'])){
    header("Location: acapadre.php");
}else{
	echo "Ocurrio un error. Comunicar al administrador!";
}
?>