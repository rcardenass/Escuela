<?php include("../seguridad.php");?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

if($_POST['txtDisponible']>=$_POST['txtSalida'] && $_POST['txtSalida']>0 ){
    if($objDatos->InsertEgresoCaja($_POST['txtCodCaja'], $_POST['cboAutorizado'], $_POST['txtPara'], $_POST['txtDisponible'], $_POST['txtSalida'], $_POST['txtDescripcion'], $_SESSION['MM_Username'])){
        header("Location: tesegresocaja.php");
    } else{
        $_SESSION['TablaEgresoCaja']="Ocurrio un error al grabar. Intentelo nuevamente.";
        header("location: tesnewegresocaja.php");
    }
}else{
    $_SESSION['TablaEgresoCaja']="El monto a retirar no concuerda con los disponible o es cero. Intentelo nuevamente.";
    header("location: tesnewegresocaja.php");
}
?>