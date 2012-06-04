<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT COUNT(*) AS Cantidad ";
$query_rsValida.= "FROM profesorcurso ";
$query_rsValida.= "WHERE CodAnio='".$_POST['cboAnio']."' ";
$query_rsValida.= "AND CodGrado='".$_POST['cboGrado']."' ";
$query_rsValida.= "AND CodSeccion='".$_POST['cboSeccion']."' ";
$query_rsValida.= "AND CodCurGra='".$_POST['cboCurso']."' ";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$Sql ="insert into profesorcurso (`CodProfesorCurso`, `CodPersonal`, `CodCurGra`, ";
	$Sql.="`CodAnio`, `CodNivel`, `CodGrado`, `CodSeccion`, `UsuarioCreacion`, `FechaCreacion`) ";
	$Sql.="values ('null', '".$_POST['txtCodigoProfesor']."', '".$_POST['cboCurso']."', '".$_POST['cboAnio']."', ";
	$Sql.="0, '".$_POST['cboGrado']."', '".$_POST['cboSeccion']."', '".$_SESSION['MM_Username']."', now()) ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());	
	mysql_free_result($rsValida);
	header("location: acaprofesorcurso.php");
}else{
	//echo "comentarios aqui....";
	$_SESSION['TablaProfesorCurso']="No es posible grabar. Este registro ya existe.";
	header("location: acanewprofesorcurso.php");	
}
?>