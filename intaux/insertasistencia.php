<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "5";
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
<?
$CodigoMatricula=$_POST['txtCodigoMatricula'];
$Asistencia=$_POST['optAsistecia'];

mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT COUNT(*) AS Cantidad FROM asistencia WHERE CodAnio='".$_POST['cboAnio']."' AND CodGrado='".$_POST['cboGrado']."' AND CodSeccion='".$_POST['cboSeccion']."' AND DATE_FORMAT(FechaAsistencia,'%d/%m/%Y')=DATE_FORMAT(CURDATE(),'%d/%m/%Y')";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$x=1;
	foreach($CodigoMatricula as $a){
		$A[$x]=$a;
		$x++;
	}
	
	$y=1;
	foreach($Asistencia as $b){
		$B[$y]=$b;
		$y++;
	}
	
	for($i=1;$i<$x;$i++){
		$Sql ="insert into asistencia (`CodAsistencia`, `CodAnio`, `CodGrado`, `CodSeccion`, ";
		$Sql.="`CodMatricula`, `Marca`, `FechaAsistencia`, `UsuarioCreacion`, `FechaCreacion` ) ";
		$Sql.="values ('null', '".$_POST['cboAnio']."', '".$_POST['cboGrado']."', '".$_POST['cboSeccion']."', ";
		$Sql.=" '".$A[$i]."', '".$B[$i]."', now(), '".$_SESSION['MM_Username']."', now() )";
		mysql_select_db($database_cn, $cn);
		$query_rsGrabar = $Sql;
		$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	}
}
header("Location: asistencia.php");
?>
<?php
mysql_free_result($rsValida);
?>