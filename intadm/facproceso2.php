<?php 
include("../seguridad.php");
require_once('../Connections/cn.php');
include("../clases/datos.php");
$objDatos=new datos();

?>
<?php
switch ($_GET['Tipo']) {
    case 'Concepto':
        $Tipo="Concepto";
		
		if($objDatos->InsertConceptoaTemporal($_SESSION['CajaCodAlumno'],$_GET['Id'],$Tipo,$_SESSION['MM_Username'],$_GET['Modulo'])==1){
		}
        break;
    case 'Credito':
        $Tipo="Credito";
		
		if($objDatos->InsertCreditoaTemporal($_SESSION['CajaCodAlumno'],$_GET['Id'],$Tipo,$_SESSION['MM_Username'],$_GET['Modulo'])==1){
		}
        break;
    case 'Pension':
        $Tipo="Pension";
		
		if($objDatos->InsertPensionaTemporal($_SESSION['CajaCodAlumno'],$_GET['Id'],$Tipo,$_SESSION['MM_Username'],$_GET['Modulo'])==1){
		}
        break;
}
?>
<script>
/*function refresh(){*/
	window.parent.Item.location.reload();
/*	}
	setInterval("refresh()",20000)*/
</script>
<?
//header("location: concepto.php");
?>
<script>
	location.href="facconcepto2.php";
</script>