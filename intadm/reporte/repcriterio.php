<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "4";
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
<?php require_once('../../Connections/cn.php'); ?>
<?
include ('class.ezpdf.php');
include ('../../clases/datos.php');

mysql_select_db($database_cn, $cn);
$query_rsCabecera = "SELECT
e.NombreAnio, d.NombreNivel, 
case '".$_POST['cboGrado']."' when '' then 'Todos' else b.NombreGrado end as NombreGrado, 
case '".$_POST['cboArea']."' when '' then 'Todos' else c.NombreArea end as NombreArea
FROM criterio a
INNER JOIN grado b ON b.CodGrado=a.CodGrado
INNER JOIN area c ON c.CodArea=a.CodArea
INNER JOIN nivel d ON d.CodNivel=b.CodNivel
INNER JOIN anio e ON e.CodAnio=a.CodAnio
WHERE a.CodAnio='".$_POST['cboAnio']."'
AND d.CodNivel='".$_POST['cboNivel']."'
AND (a.CodGrado='".$_POST['cboGrado']."' OR ''='".$_POST['cboGrado']."')
AND (a.CodArea='".$_POST['cboArea']."' OR ''='".$_POST['cboArea']."')
GROUP by e.NombreAnio, d.NombreNivel";
$rsCabecera = mysql_query($query_rsCabecera, $cn) or die(mysql_error());
$row_rsCabecera = mysql_fetch_assoc($rsCabecera);
$totalRows_rsCabecera = mysql_num_rows($rsCabecera);

$objDatos=new datos();

$rsCriterio=$objDatos->ObtenerConsultaCriterioSelAll($_POST['cboAnio'],$_POST['cboNivel'],$_POST['cboGrado'],$_POST['cboArea']);
$rowCriterio=$objDatos->PoblarConsultaCriterioSelAll($rsCriterio);

$pdf =& new Cezpdf('a4');
$pdf->selectFont('fonts/helvetica.afm');
$datacreator = array (
                    'Title'=>'Ejemplo PDF',
                    'Author'=>'rcardenas',
                    'Subject'=>'PDF con Tablas',
                    'Creator'=>'rcardenas@hotmail.com',
                    'Producer'=>'http://'
                    );
$pdf->addInfo($datacreator);

do{
	$data[] = array('Grado'=>$rowCriterio['Grado'], 'NombreArea'=>$rowCriterio['NombreArea'], 'NombreCriterio'=>$rowCriterio['NombreCriterio'], 'Porcentaje'=>$rowCriterio['Porcentaje'], 'Nro'=>$rowCriterio['Nro']);
}while($rowCriterio=$objDatos->PoblarConsultaCriterioSelAll($rsCriterio));

$titles = array('Grado'=>'<b>Grado</b>', 'NombreArea'=>'<b>NombreArea</b>', 'NombreCriterio'=>'<b>NombreCriterio</b>', 'Porcentaje'=>'<b>Porcentaje</b>', 'Nro'=>'<b>Nro</b>');

$pdf->ezText("<b>Criterios de Evaluación</b>\n",16);
$pdf->ezText("Año: ".$row_rsCabecera['NombreAnio'],11);
$pdf->ezText("Nivel: ".$row_rsCabecera['NombreNivel'],11);
$pdf->ezText("Grado: ".$row_rsCabecera['NombreGrado'],11);
$pdf->ezText("Area: ".$row_rsCabecera['NombreArea'],11);
$pdf->ezText("Auditoria: ".$_SESSION['MM_Username']." - ".date("d/m/Y")." - ".date("H:i:s")."\n",11);

$pdf->ezTable($data,$titles,'',$options );
$pdf->ezStream();
?>
<?php
mysql_free_result($rsCabecera);
mysql_free_result($rsCriterio);
?>