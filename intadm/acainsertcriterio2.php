<?php include("../seguridad.php");?>
<?
$a=$_POST['txtCriterio'];
$b=$_POST['txtPorcentaje'];
$c=$_POST['txtNroNota'];

$x=1;
foreach($a as $Criterio){
	$A[$x]=$Criterio;
	echo "Criterio: ".$A[$x]."<br>";
	$x++;
}

$y=1;
foreach($b as $Porcentaje){
	$B[$y]=$Porcentaje;
	echo "Porcentaje: ".$B[$y]."<br>";
	$y++;
}

$z=1;
foreach($c as $NroNota){
	$C[$z]=$NroNota;
	echo "NroNota: ".$C[$z]."<br>";
	$z++;
}

if($_POST['txtNroCriterio']>0){
	for($Vuelta=1;$Vuelta<=$_POST['txtNroCriterio'];$Vuelta++){
		$rsValidad = $objDatos->ObtenerValidaCriterioSelId($_POST['txtAnio'],$_POST['txtArea'],$_POST['txtGrado'],$A[$Vuelta]);
		$rowValidad = $objDatos->PoblarValidaCriterioSelId($rsValidad);
		
		$rsValidadPorcentaje = $objDatos->ObtenerValidaPorcentajeCriterioSelId($_POST['txtAnio'],$_POST['txtArea'],$_POST['txtGrado']);
		$rowValidadPorcentaje = $objDatos->PoblarValidaPorcentajeCriterioSelId($rsValidadPorcentaje);
		
		if($rowValidad['Cantidad']==0){
			if($rowValidadPorcentaje['Porcentaje']<100){
				if($rowValidadPorcentaje['Porcentaje']+$B[$Vuelta]<=100){
					if($objDatos->InsertCriterio($_POST['txtAnio'],$_POST['txtArea'],$_POST['txtGrado'],$A[$Vuelta],$B[$Vuelta],$_SESSION['MM_Username'])==1){
					//
					}
					
					//********** inicia llenar tabla "criteriocurso" **********//
					$rsIdCriterio = $objDatos->ObtenerCodigoCriterioSelId();
					$rowIdCriterio = $objDatos->PoblarCodigoCriterioSelId($rsIdCriterio);
					
					if($objDatos->InsertCriterioCurso($rowIdCriterio['CodCriterio'],$C[$Vuelta],$_POST['txtGrado'],$_POST['txtArea'],$_SESSION['MM_Username'])==1){
					//
					}
					//Me quede aqui...
					
					//********** termina llenar tabla "criteriocurso" **********//
					
				}
			}
		}
	}
}
?>