<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "3";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../error.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php 
include('../../funciones.php'); 
include("../../clases/datos.php");
$objDatos=new datos();

$rsMatricula=$objDatos->ObtenerUltimaMatriculaSelId($_SESSION['Hijo']);
$row_Matricula=$objDatos->PoblarUltimaMatriculaSelId($rsMatricula);

$rsNroCriterio=$objDatos->ObtenerNroNotaCriterioSelAll($_POST['cboArea'], $row_Matricula['CodAnio'], $row_Matricula['CodGrado']);
$row_NroCriterio=$objDatos->PoblarNroNotaCriterioSelAll($rsNroCriterio);
$totalRows_rsNroCriterio = mysql_num_rows($rsNroCriterio);

$rsNroCriterio2=$objDatos->ObtenerNroNotaCriterioSelAll($_POST['cboArea'], $row_Matricula['CodAnio'], $row_Matricula['CodGrado']);
$row_NroCriterio2=$objDatos->PoblarNroNotaCriterioSelAll($rsNroCriterio2);
$totalRows_rsNroCriterio2 = mysql_num_rows($rsNroCriterio2);

$rsNroCriterio3=$objDatos->ObtenerNroNotaCriterioSelAll($_POST['cboArea'], $row_Matricula['CodAnio'], $row_Matricula['CodGrado']);
$row_NroCriterio3=$objDatos->PoblarNroNotaCriterioSelAll($rsNroCriterio3);
$totalRows_rsNroCriterio3 = mysql_num_rows($rsNroCriterio3);




$rsNroNota=$objDatos->ObtenerSumaNotaCriterioSelAll($_POST['cboArea'], $row_Matricula['CodAnio'] ,$row_Matricula['CodGrado']);
$row_NroNota=$objDatos->PoblarSumaNotaCriterioSelAll($rsNroNota);

$rsCurso=$objDatos->ObtenerCursoPorAreaAlumnoSelAll($_SESSION['Hijo'], $row_Matricula['CodAnio'] ,$row_Matricula['CodGrado'], $row_Matricula['CodSeccion'], $_POST['cboArea']);
$row_Curso=$objDatos->PoblarCursoPorAreaAlumnoSelAll($rsCurso);
$totalRows_rsCurso = mysql_num_rows($rsCurso);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<? if(!empty($_POST['cboBimestre']) and !empty($_POST['cboArea'])){ ?>
<table border="0" cellspacing="2" cellpadding="0" class="table">
    <? for($i=1;$i<=2;$i++){ ?>
    <tr <? if($i==1){ echo "class='tr'"; } ?>>
        <? if($i==1){ ?>
        <td width="350" colspan="2"><div style="padding-left:3px">Criterios</div></td>
	<? }else{?>
	<td width="350" colspan="2"><div style="padding-left:3px">Nro de Notas</div></td>
	<? }?>

        <? if($i==1){ ?>
            <? do{ ?>
            	<td valign="top" <? if($row_NroCriterio['NroNota']==1){ echo "width='30'"; }else{ echo "colspan='".$row_NroCriterio['NroNota']."'"; }?>>
				<div style="text-align:justify; padding-left:3px; padding-right:3px"><? echo utf8_encode($row_NroCriterio['NombreCriterio']); ?></div>
				</td>
            <? }while($row_NroCriterio=$objDatos->PoblarNroNotaCriterioSelAll($rsNroCriterio)); ?>
        <? }else{?>
            <? do{ ?>
				<? 
				$rsNroNotaPorCriterio=$objDatos->ObtenerNroNotaPorCriterioSelAll($row_NroCriterio2['CodCriterio']);
				$row_NroNotaPorCriterio=$objDatos->PoblarNroNotaPorCriterioSelAll($rsNroNotaPorCriterio);
				do{ 
				?>
                	<td width="30" align="center"><? echo $row_NroNotaPorCriterio['NroEvaluacion']; ?></td>
				<? }while($row_NroNotaPorCriterio=$objDatos->PoblarNroNotaPorCriterioSelAll($rsNroNotaPorCriterio)); ?>
            <? }while($row_NroCriterio2=$objDatos->PoblarNroNotaCriterioSelAll($rsNroCriterio2)); ?>
        <? }?>
    </tr>
  <? } ?>
  <? do{ ?>
  <? Filas();?>
    <td width="150"><div style="padding-left:3px">Area</div></td>
    <td width="200"><div style="padding-left:3px"><? echo $row_Curso['NombreCurso']; ?></div></td>
    <? do{ ?>
		<? 
		$rsNroNotaPorCriterio2=$objDatos->ObtenerNroNotaPorCriterioSelAll($row_NroCriterio3['CodCriterio']);
		$row_NroNotaPorCriterio2=$objDatos->PoblarNroNotaPorCriterioSelAll($rsNroNotaPorCriterio2);
		do{
			$rsEvaluacion=$objDatos->ObtenerEvaluacionCriterioSelId(1, $_POST['cboBimestre'], $_POST['cboArea'], $row_NroNotaPorCriterio2['CodCriterio']);
            $row_Evaluacion=$objDatos->PoblarEvaluacionCriterioSelId($rsEvaluacion);
		?>
    		<td width="30" align="center"><? echo $row_Evaluacion['Nota']; ?></td>
		<? }while($row_NroNotaPorCriterio2=$objDatos->PoblarNroNotaPorCriterioSelAll($rsNroNotaPorCriterio2)); ?>
    <? }while($row_NroCriterio3=$objDatos->PoblarNroNotaCriterioSelAll($rsNroCriterio3)); ?>
  </tr>
  <? }while($row_Curso=$objDatos->PoblarCursoPorAreaAlumnoSelAll($rsCurso)); ?>
</table>
</body>
<? 
}else{
	echo "No es posible mostrar nformaci&oacute;n de evaluaci&oacute;n. Por favor seleccione <strong>Bimestre</strong> y <strong>Area</strong>";
}
?>
</html>
