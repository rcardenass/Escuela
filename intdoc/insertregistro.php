<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
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

$MM_restrictGoTo = "../error.php";
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
<?php require_once('../Connections/cn.php'); ?>
<?php
/*$Anio=$_POST['txtCodigoAnio'];
$Grado=$_POST['txtCodigoGrado'];
$Seccion=$_POST['txtCodigoSeccion'];
$Curso=$_POST['txtCodigoCurso'];
$Area=$_POST['txtCodigoArea'];
$Bimestre=$_POST['cboBimestre'];
$Criterio=$_POST['cboCriterio'];
$Nota=$_POST['cboNota'];
$Usuario=$_SESSION['kt_login_user'];
*/
$Matricula=$_POST['txtCodigoMatricula']; 			//Array Matricula
$MatriculaCurso=$_POST['txtCodigoMatriculaCurso']; 	//Array MatriculaCurso
$Nota=$_POST['txtNota']; 							//Array Nota

$x=1;
foreach($Matricula as $a){
	$A[$x]=$a;
	$x++;
}

$y=1;
foreach($MatriculaCurso as $b){
	$B[$y]=$b;
	$y++;
}

$z=1;
foreach($Nota as $c){
	$C[$z]=$c;
	$z++;
}

if($_POST['txtCodigoNivel']==3){
	for($i=1;$i<$x;$i++){
		$Sql ="insert into criterionota (`CodCriterioNota`, `CodCriterio`, `CodMatricula`, ";
		$Sql.="`CodMatriculaCurso`, `CodProfesorCurso`, `CodBimestre`, `CodGrado`, ";
		$Sql.="`CodSeccion`, `CodCurGra`,`CodCriterioNroNota`,`Nota`, `UsuarioCreacion`, `FechaCreacion` ) ";
		$Sql.="values ('null', '".$_POST['cboCriterio']."', ".$A[$i].", ".$B[$i].", ";
		$Sql.="'".$_POST['txtCodigoProfesorCurso']."', '".$_POST['cboBimestre']."', ";
		$Sql.="'".$_POST['txtCodigoGrado']."', '".$_POST['txtCodigoSeccion']."', '".$_POST['txtCodigoCurso']."', ";
		$Sql.="'".$_POST['cboNota']."', ".$C[$i].", '".$_SESSION['MM_Username']."' , now()) ";
		mysql_select_db($database_cn, $cn);
		$query_rsGrabar = $Sql;
		$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	}
}else{
	for($i=1;$i<$x;$i++){
		$Sql ="insert into criterionotaprimaria (`CodCriterioNota`, `CodCriterio`, `CodMatricula`, ";
		$Sql.="`CodMatriculaCurso`, `CodProfesorCurso`, `CodBimestre`, `CodGrado`, ";
		$Sql.="`CodSeccion`, `CodCurGra`,`CodCriterioNroNota`,`Nota`, `UsuarioCreacion`, `FechaCreacion` ) ";
		$Sql.="values ('null', '".$_POST['cboCriterio']."', ".$A[$i].", ".$B[$i].", ";
		$Sql.="'".$_POST['txtCodigoProfesorCurso']."', '".$_POST['cboBimestre']."', ";
		$Sql.="'".$_POST['txtCodigoGrado']."', '".$_POST['txtCodigoSeccion']."', '".$_POST['txtCodigoCurso']."', ";
		$Sql.="'".$_POST['cboNota']."', '".$C[$i]."', '".$_SESSION['MM_Username']."' , now()) ";
		mysql_select_db($database_cn, $cn);
		$query_rsGrabar = $Sql;
		$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	}
}

header("Location: registro.php?CodigoProfesorCurso=".$_POST['txtCodigoProfesorCurso']." ");
 ?>
