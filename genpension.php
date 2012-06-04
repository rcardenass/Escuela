<?php require_once('Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsGrado = "SELECT CodGrado, CodNivel, NombreGrado FROM grado where CodNivel in (2,3) ORDER BY CodGrado ASC";
$rsGrado = mysql_query($query_rsGrado, $cn) or die(mysql_error());
$row_rsGrado = mysql_fetch_assoc($rsGrado);
$totalRows_rsGrado = mysql_num_rows($rsGrado);

do { 
	mysql_select_db($database_cn, $cn);
	$query_rsMatricula = "SELECT  CodMatricula, CodAlumno, CodAnio, CodGrado, CodSeccion, Turno, EstadoRetirado ";
	$query_rsMatricula.= "FROM matricula a WHERE a.CodGrado='".$row_rsGrado['CodGrado']."' ";
	$query_rsMatricula.= "AND NOT EXISTS (SELECT * FROM programacionalumno x WHERE x.CodAlumno=a.CodAlumno) ";
	$rsMatricula = mysql_query($query_rsMatricula, $cn) or die(mysql_error());
	$row_rsMatricula = mysql_fetch_assoc($rsMatricula);
	$totalRows_rsMatricula = mysql_num_rows($rsMatricula);
	
	do{
		
		$Sql_Pension ="INSERT INTO programacionalumno (CodAlumno, CodAnio, CodGrado, CodSeccion, NroPension, Monto, FechaInicio, FechaTermino, UsuarioCreacion, FechaCreacion) ";
		$Sql_Pension.="SELECT '".$row_rsMatricula['CodAlumno']."', a.CodAnio, a.CodGrado, a.CodSeccion, b.NroPension, b.Monto, b.FechaInicio, b.FechaTermino, 'ruben.cardenas', now() ";
		$Sql_Pension.="FROM pensiones a ";
		$Sql_Pension.="INNER JOIN detallepension b ON b.CodPension=a.CodPension ";
		$Sql_Pension.="WHERE a.CodAnio='".$row_rsMatricula['CodAnio']."' ";
		$Sql_Pension.="AND a.CodGrado='".$row_rsMatricula['CodGrado']."' ";
		$Sql_Pension.="AND a.CodSeccion='".$row_rsMatricula['CodSeccion']."' ";
		$Sql_Pension.="AND a.Estado=1 "; 	//revisar
		$Sql_Pension.="AND a.Aprobar=1 ";	//revisar
		mysql_select_db($database_cn, $cn);
		$rsGrabar_Pension = mysql_query($Sql_Pension, $cn) or die(mysql_error());
		
	} while ($row_rsMatricula = mysql_fetch_assoc($rsMatricula)); 	
} while ($row_rsGrado = mysql_fetch_assoc($rsGrado)); 
?>


<?php
mysql_free_result($rsGrado);
mysql_free_result($rsMatricula);
?>
