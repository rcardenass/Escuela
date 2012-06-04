<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValidar = "SELECT count(*) as Cantidad FROM criterio where CodAnio='".$_POST['cboAnio']."' and CodArea='".$_POST['cboArea']."' and CodGrado='".$_POST['cboGrado']."' and NombreCriterio='".$_POST['txtCriterio']."' ";
$rsValidar = mysql_query($query_rsValidar, $cn) or die(mysql_error());
$row_rsValidar = mysql_fetch_assoc($rsValidar);
$totalRows_rsValidar = mysql_num_rows($rsValidar);

mysql_select_db($database_cn, $cn);
$query_rsValidaPocentaje = "SELECT SUM(Porcentaje) AS Porcentaje  FROM criterio WHERE CodAnio='".$_POST['cboAnio']."' AND CodArea='".$_POST['cboArea']."' AND CodGrado='".$_POST['cboGrado']."' ";
$rsValidaPocentaje = mysql_query($query_rsValidaPocentaje, $cn) or die(mysql_error());
$row_rsValidaPocentaje = mysql_fetch_assoc($rsValidaPocentaje);
$totalRows_rsValidaPocentaje = mysql_num_rows($rsValidaPocentaje);

if($row_rsValidar['Cantidad']==0){
	if($row_rsValidaPocentaje['Porcentaje']<100){
		if($row_rsValidaPocentaje['Porcentaje']+$_POST['cboPorcentaje']<=100){
			$Sql ="insert into criterio (`Codcriterio`, `CodAnio`, `CodArea`, `CodGrado`, `NombreCriterio`, `Porcentaje`, `UsuarioCreacion`, `FechaCreacion`) ";
			$Sql.="values ('null', '".$_POST['cboAnio']."', '".$_POST['cboArea']."', '".$_POST['cboGrado']."', '".$_POST['txtCriterio']."', '".$_POST['cboPorcentaje']."','".$_SESSION['MM_Username']."', now()) ";
			mysql_select_db($database_cn, $cn);
			$query_rsGrabar = $Sql;
			$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());

			//********** inicia llenar tabla "criteriocurso" **********//
			mysql_select_db($database_cn, $cn);
			$query_rsCriterio = "SELECT MAX(CodCriterio) AS CodCriterio FROM criterio";
			$rsCriterio = mysql_query($query_rsCriterio, $cn) or die(mysql_error());
			$row_rsCriterio = mysql_fetch_assoc($rsCriterio);
			$totalRows_rsCriterio = mysql_num_rows($rsCriterio);
			
			$IdCriterio=$row_rsCriterio['CodCriterio'];
			
			$Sql_CursoCriterio ="INSERT INTO criteriocurso (CodCriterio, CodCurGra, NroNotas, UsuarioCreacion, FechaCreacion) ";
			$Sql_CursoCriterio.="SELECT '".$IdCriterio."', CodCurGra, '".$_POST['txtNroNota']."', '".$_SESSION['MM_Username']."', now() ";
			$Sql_CursoCriterio.="FROM cursogrado ";
			$Sql_CursoCriterio.="WHERE CodGrado='".$_POST['cboGrado']."' ";
			$Sql_CursoCriterio.="and CodArea='".$_POST['cboArea']."' ";
			mysql_select_db($database_cn, $cn);
			$rsGrabar_CursoCriterio = $Sql_CursoCriterio;
			$rsGrabar2 = mysql_query($rsGrabar_CursoCriterio, $cn) or die(mysql_error());
			
			mysql_select_db($database_cn, $cn);
			$query_rsCriterioCurso = "SELECT b.CodCriterioCurso  FROM criterio a ";
			$query_rsCriterioCurso.= "INNER JOIN criteriocurso b ON b.CodCriterio=a.CodCriterio ";
			$query_rsCriterioCurso.= "WHERE a.CodAnio='".$_POST['cboAnio']."' AND a.CodArea='".$_POST['cboArea']."' ";
			$query_rsCriterioCurso.= "AND a.CodGrado='".$_POST['cboGrado']."' and b.CodCriterio='".$IdCriterio."' ";
			$query_rsCriterioCurso.= "ORDER BY b.CodCriterioCurso";
			$rsCriterioCurso = mysql_query($query_rsCriterioCurso, $cn) or die(mysql_error());
			$row_rsCriterioCurso = mysql_fetch_assoc($rsCriterioCurso);
			$totalRows_rsCriterioCurso = mysql_num_rows($rsCriterioCurso);
	
			do {
				for($x=1;$x<=$_POST['txtNroNota'];$x++){
					$Sql_NroEvaluacion ="insert into criterionronota (`CodCriterioNroNota`, `CodCriterioCurso`, `NroEvaluacion`, `UsuarioCreacion`, `FechaCreacion`) ";
					$Sql_NroEvaluacion.="values ('null', '".$row_rsCriterioCurso['CodCriterioCurso']."', '$x', '".$_SESSION['MM_Username']."', now() ) ";
					mysql_select_db($database_cn, $cn);
					$query_rsGrabarNroEvaluacion = $Sql_NroEvaluacion;
					$rsGrabarNroEvaluacio = mysql_query($query_rsGrabarNroEvaluacion, $cn) or die(mysql_error());
				}
			} while ($row_rsCriterioCurso = mysql_fetch_assoc($rsCriterioCurso));
		
			mysql_free_result($rsCriterio);
			mysql_free_result($rsValidar);
			mysql_free_result($rsCriterioCurso);
			//********** termina llenar tabla "criteriocurso" **********//
		
			header("location: acacriterio.php");
		}
	}
}else{
	echo "Comentario";
}
?>
