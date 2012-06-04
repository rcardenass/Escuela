<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php //include("funciones.php"); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT COUNT(*) AS Cantidad FROM matricula WHERE CodAnio='".$_POST['cboAnio']."' AND CodAlumno='".$_POST['txtCodigoAlumno']."' AND EstadoRetirado=0 ";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$Sql ="insert into matricula (`CodMatricula`, `CodAlumno`, `CodAnio`, `CodGrado`, `CodSeccion`, `Turno`, `UsuarioCreacion`, `FechaCreacion`) ";
	$Sql.="values ('null', '".$_POST['txtCodigoAlumno']."', '".$_POST['cboAnio']."', '".$_POST['cboGrado']."', '".$_POST['cboSeccion']."', '".$_POST['cboTurno']."','".$_SESSION['MM_Username']."', now()) ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
	
	
	//****************************** CREA PROGRAMACION DE CURSOS ******************************//
	mysql_select_db($database_cn, $cn);
	$query_rsCodigoMatricula ="SELECT  MAX(CodMatricula) AS CodMatricula ";
	$query_rsCodigoMatricula.="FROM matricula ";
	$query_rsCodigoMatricula.="where CodAlumno='".$_POST['txtCodigoAlumno']."' ";
	$query_rsCodigoMatricula.="and CodGrado='".$_POST['cboGrado']."' ";
	$query_rsCodigoMatricula.="and CodSeccion='".$_POST['cboSeccion']."' ";
	$rsCodigoMatricula = mysql_query($query_rsCodigoMatricula, $cn) or die(mysql_error());
	$row_rsCodigoMatricula = mysql_fetch_assoc($rsCodigoMatricula);
	$totalRows_rsCodigoMatricula = mysql_num_rows($rsCodigoMatricula);
	
	$IdMatricula=$row_rsCodigoMatricula['CodMatricula'];
	
	$Sql_Matricule_Curso ="INSERT INTO matriculacurso (CodMatricula, CodCurGra, UsuarioCreacion, FechaCreacion) ";
	$Sql_Matricule_Curso.="SELECT $IdMatricula, b.CodCurGra, '".$_SESSION['MM_Username']."', now() ";
	$Sql_Matricule_Curso.="FROM curso a ";
	$Sql_Matricule_Curso.="INNER JOIN cursogrado b ON b.CodCurso=a.CodCurso ";
	$Sql_Matricule_Curso.="WHERE b.CodGrado='".$_POST['cboGrado']."' ";
	mysql_select_db($database_cn, $cn);
	$rsGrabar2 = mysql_query($Sql_Matricule_Curso, $cn) or die(mysql_error());
	
	mysql_free_result($rsCodigoMatricula);
	//****************************** termina crea cursos ******************************//
	
	
	//****************************** CREA CUENTA CORRIENTE ******************************//
	mysql_select_db($database_cn, $cn);
	$query_rsValidaCcorriente = "select count(*) as Cantidad from cuentacorriente where CodAlumno='".$_POST['txtCodigoAlumno']."' ";
	$rsValidaCcorriente = mysql_query($query_rsValidaCcorriente, $cn) or die(mysql_error());
	$row_rsValidaCcorriente = mysql_fetch_assoc($rsValidaCcorriente);
	$totalRows_rsValidaCcorriente = mysql_num_rows($rsValidaCcorriente);
	
	if($row_rsValidaCcorriente['Cantidad']==0){
		//CuentaCorriente($_POST['txtCodigoAlumno'],$_SESSION['MM_Username']);
		$Sqlcc = "insert into cuentacorriente (CodCuentaCorriente, CodAlumno, UsuarioCreacion, FechaCreacion) ";
		$Sqlcc .="values ('null', '".$_POST['txtCodigoAlumno']."', '".$_SESSION['MM_Username']."', now())";
		mysql_select_db($database_cn, $cn);
		$rsGrabarcc = mysql_query($Sqlcc, $cn) or die(mysql_error());
	}
	//****************************** termina cuenta corriente ******************************//
	
	
	//****************************** CREA PROGRAMACION DE PAGOS ******************************//
	$Sql_Programacion_Pension ="INSERT INTO programacionalumno (CodAlumno, CodAnio, CodGrado, CodSeccion, NroPension, Monto, FechaInicio, FechaTermino, UsuarioCreacion, FechaCreacion) ";
	$Sql_Programacion_Pension.="SELECT '".$_POST['txtCodigoAlumno']."', a.CodAnio, a.CodGrado, a.CodSeccion, b.NroPension, b.Monto, b.FechaInicio, b.FechaTermino, '".$_SESSION['MM_Username']."', now() ";
	$Sql_Programacion_Pension.="FROM pensiones a ";
	$Sql_Programacion_Pension.="INNER JOIN detallepension b ON b.CodPension=a.CodPension ";
	$Sql_Programacion_Pension.="WHERE a.CodAnio='".$_POST['cboAnio']."' ";
	$Sql_Programacion_Pension.="AND a.CodGrado='".$_POST['cboGrado']."' ";
	$Sql_Programacion_Pension.="AND a.CodSeccion='".$_POST['cboSeccion']."' ";
	$Sql_Programacion_Pension.="AND a.Estado=1 "; 	//revisar
	$Sql_Programacion_Pension.="AND a.Aprobar=1 ";	//revisar
	mysql_select_db($database_cn, $cn);
	$rsGrabar_Programacion_Pension = mysql_query($Sql_Programacion_Pension, $cn) or die(mysql_error());
	//****************************** termina cronograma de pagos ******************************//
	
	
	mysql_free_result($rsValida);
	mysql_free_result($rsValidaCcorriente);
	
	header("location: acamatricula.php");
}else{
	echo "comentarios aqui....";
}
?>