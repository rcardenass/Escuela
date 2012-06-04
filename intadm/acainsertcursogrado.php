<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT count(*) as Cantidad FROM cursogrado WHERE CodProgramaAcademico='".$_POST['cboPrograma']."' AND CodArea='".$_POST['cboArea']."' AND CodCurso='".$_POST['cboCurso']."' AND CodGrado='".$_POST['cboGrado']."' and Estado=1 ";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$Sql ="insert into cursogrado (`CodCurGra`, `CodProgramaAcademico`, `CodArea`, `CodGrado`, `CodCurso`) ";
	$Sql.="values ('null', '".$_POST['cboPrograma']."', '".$_POST['cboArea']."', '".$_POST['cboGrado']."', '".$_POST['cboCurso']."') ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	header("location: acacursogrado.php");
}else{
	$_SESSION['TablaCursoGrado']="No es posible grabar. Este registro ya existe.";
	header("location: acanewcursogrado.php");	
}
mysql_free_result($rsValida);
?>