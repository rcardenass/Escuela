<?php require_once('../Connections/cn.php'); ?>
<?php include('../funciones.php'); ?>
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
<?php
mysql_select_db($database_cn, $cn);
$query_rsTreeview = "SELECT Id, NombrePrograma as Nombre, IdPadre, Url FROM programa WHERE CodPerfil=2 ";
$rsTreeview = mysql_query($query_rsTreeview, $cn) or die(mysql_error());
$row_rsTreeview = mysql_fetch_assoc($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$_SESSION['Bimestre']=$_POST['cboBimestre'];
$_SESSION['Criterio']=$_POST['cboCriterio'];
$_SESSION['Nota']=$_POST['cboNota'];

if (isset($_GET['CodigoProfesorCurso'])) {
	$CodigoProfesorCurso=$_GET['CodigoProfesorCurso'];
}else{
	$CodigoProfesorCurso=$_POST['txtCodigoProfesorCurso'];
}

mysql_select_db($database_cn, $cn);
$query_rsParametro = "SELECT a.CodAnio, a.CodGrado, a.CodSeccion, a.CodCurGra, b.CodArea FROM profesorcurso a INNER JOIN cursogrado b ON b.CodCurGra=a.CodCurGra WHERE a.CodProfesorCurso='".$CodigoProfesorCurso."'"; 
$rsParametro = mysql_query($query_rsParametro, $cn) or die(mysql_error());
$row_rsParametro = mysql_fetch_assoc($rsParametro);
$totalRows_rsParametro = mysql_num_rows($rsParametro);

$Anio=$row_rsParametro['CodAnio'];
$Area=$row_rsParametro['CodArea'];
$Grado=$row_rsParametro['CodGrado'];
$Seccion=$row_rsParametro['CodSeccion'];
$Curso=$row_rsParametro['CodCurGra'];

mysql_select_db($database_cn, $cn);
$query_rsCab = "SELECT a.NombreGrado, e.NombreSeccion, c.NombreCurso, a.CodNivel FROM grado a INNER JOIN cursogrado b ON b.CodGrado=a.CodGrado INNER JOIN curso c ON c.CodCurso=b.CodCurso INNER JOIN profesorcurso d ON d.CodCurGra=b.CodCurGra INNER JOIN seccion e ON e.CodSeccion=d.CodSeccion WHERE d.CodProfesorCurso='".$CodigoProfesorCurso."' " ;
$rsCab = mysql_query($query_rsCab, $cn) or die(mysql_error());
$row_rsCab = mysql_fetch_assoc($rsCab);
$totalRows_rsCab = mysql_num_rows($rsCab);

if($row_rsCab['CodNivel']==3){
	$Tabla="criterionota";
}else{
	$Tabla="criterionotaprimaria";
}

//$Sql ="SELECT  d.CodCurso, d.CodGrado, b.CodSeccion,  a.CodAlumno, b.CodMatricula, c.CodMatriculaCurso, ";
//$Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumnos, h.Nota, h.CodCriterioNota ";
//$Sql.="FROM alumno a ";
//$Sql.="INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno ";
//$Sql.="INNER JOIN seccion g ON g.CodSeccion=b.CodSeccion ";
//$Sql.="INNER JOIN matriculacurso c ON c.CodMatricula=b.CodMatricula ";
//$Sql.="INNER JOIN cursogrado d ON d.CodCurGra=c.CodCurGra ";
//$Sql.="INNER JOIN profesorcurso e ON e.CodCurGra=d.CodCurGra ";
//$Sql.="INNER JOIN personal f ON f.CodPersonal=e.CodPersonal AND f.CodTipoPersonal=2 ";
//$Sql.="INNER JOIN criterionota h ON h.CodMatriculaCurso=c.CodMatriculaCurso ";
//$Sql.="INNER JOIN criterionronota i ON i.CodCriterioNroNota=h.CodCriterioNroNota ";
//$Sql.="WHERE f.UsuarioId='".$_SESSION['MM_Username']."' ";
//$Sql.="AND d.CodGrado='".$Grado."' ";
//$Sql.="AND b.CodSeccion='".$Seccion."' ";
//$Sql.="AND d.CodCurGra='".$Curso."' ";
//$Sql.="AND h.CodBimestre='".$_POST['cboBimestre']."' ";	//Verificar
//$Sql.="AND h.CodCriterio='".$_POST['cboCriterio']."' ";	//Verificar
//$Sql.="AND i.CodCriterioNroNota='".$_POST['cboNota']."' ";
//$Sql.="GROUP by a.CodAlumno, b.CodMatricula ";
//$Sql.="ORDER BY concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) ";
	$Sql ="SELECT  d.CodCurso, d.CodGrado, b.CodSeccion,  a.CodAlumno, b.CodMatricula,  ";
	$Sql.="c.CodMatriculaCurso, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumnos, 0 as Nota ";
	$Sql.="FROM alumno a "; 
	$Sql.="INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno ";
	$Sql.="INNER JOIN seccion g ON g.CodSeccion=b.CodSeccion "; 
	$Sql.="INNER JOIN matriculacurso c ON c.CodMatricula=b.CodMatricula ";
	$Sql.="INNER JOIN cursogrado d ON d.CodCurGra=c.CodCurGra "; 
	$Sql.="INNER JOIN profesorcurso e ON e.CodCurGra=d.CodCurGra ";
	$Sql.="INNER JOIN personal f ON f.CodPersonal=e.CodPersonal ";
	$Sql.="WHERE f.UsuarioId='".$_SESSION['MM_Username']."' "; 
	$Sql.="AND d.CodGrado='".$Grado."' "; 
	$Sql.="AND b.CodSeccion='".$Seccion."' "; 
	$Sql.="AND d.CodCurGra='".$Curso."' "; 
	$Sql.="GROUP by b.CodMatricula "; 
	$Sql.="ORDER BY concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) ";

mysql_select_db($database_cn, $cn);
$query_rsAlumnos = $Sql;
$rsAlumnos = mysql_query($query_rsAlumnos, $cn) or die(mysql_error());
$row_rsAlumnos = mysql_fetch_assoc($rsAlumnos);
$totalRows_rsAlumnos = mysql_num_rows($rsAlumnos);

mysql_select_db($database_cn, $cn);
$query_rsBimestre = "SELECT CodBimestre, NombreBimestre FROM bimestre";
$rsBimestre = mysql_query($query_rsBimestre, $cn) or die(mysql_error());
$row_rsBimestre = mysql_fetch_assoc($rsBimestre);
$totalRows_rsBimestre = mysql_num_rows($rsBimestre);

mysql_select_db($database_cn, $cn);
$query_rsCriterio = "SELECT a.CodCriterio, b.CodCriterioCurso, a.NombreCriterio FROM criterio a inner join criteriocurso b on b.CodCriterio=a.CodCriterio WHERE a.CodAnio='".$Anio."' and a.CodArea='".$Area."' and a.CodGrado = '".$Grado."' and b.CodCurGra='".$Curso."' ";
$rsCriterio = mysql_query($query_rsCriterio, $cn) or die(mysql_error());
$row_rsCriterio = mysql_fetch_assoc($rsCriterio);
$totalRows_rsCriterio = mysql_num_rows($rsCriterio);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templatedoc.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEditableHeadTag --><!-- InstanceEndEditable -->
<link href="../styledoc.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="980px" border="0" align="center"><tr><td>
	<table width="980px" border="0" cellpadding="0">
		<tr>
			<td colspan="2"><? require_once("../cabecera.php"); ?></td>
		</tr>
		<tr>
			<td width="200" valign="top" class="Menu">
			<div style="padding-left:10px">	
				<div class="dtree">
					<div style="height:5px"></div>
					<a href="javascript: d.openAll();">Abrir todo</a> | <a href="javascript: d.closeAll();">Cerrar todo</a>
					<div style="height:10px"></div>
					<script type="text/javascript">
					d = new dTree('d');
					d.add(0,-1,'Inicio');
					<?php do { ?>
					d.add(<?php echo $row_rsTreeview['Id']; ?>,<?php echo $row_rsTreeview['IdPadre']; ?>,'<?php echo $row_rsTreeview['Nombre']; ?>','<?php echo $row_rsTreeview['Url']; ?>');
					<?php } while ($row_rsTreeview = mysql_fetch_assoc($rsTreeview)); ?>
					document.write(d);
					</script>
				</div>
			</div>
			<div style="height:10px"></div>
			</td>
			<td valign="top" class="Contenedor">
				<div style = "width: 99%; padding-left:5px" class="Contenedor">
				<!-- InstanceBeginEditable name="Contenido" -->
	<h1>Consultar Evaluaciones</h1><hr /><br />
	<form id="form1" name="form1" method="post" autocomplete="Off" action="">
	  <table width="600" border="0" cellspacing="2" cellpadding="0">
		<tr>
			<td><span class="label">Grado</span></td>
			<td><span class="label">Seccion</span></td>
			<td><span class="label">Curso</span></td>
		</tr>
		<tr>
			<td>
			<input type="text" name="txtNombreGrado" value="<?php echo $row_rsCab['NombreGrado']; ?>" style="width:150px" 
			readonly="true"/>
			</td>
			<td>
			<input type="text" name="txtNombreSeccion" value="<?php echo $row_rsCab['NombreSeccion']; ?>" 
			style="width:150px" readonly="true"/>
			</td>
			<td title="<?php echo $row_rsCab['NombreCurso']; ?>">
			<input type="text" name="txtNombreCurso" 
			value="<?php echo substr($row_rsCab['NombreCurso'], 0, 12); ?>" style="width:250px" readonly="true"/>
			</td>
		</tr>
		<tr>
			<td><span class="label">Bimestre</span></td>
			<td><span class="label">Criterio</span></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>
			<select name="cboBimestre" id="cboBimestre" style="width:154px">
            <?php
			do {  
			?><option value="<?php echo $row_rsBimestre['CodBimestre']?>"
			<?php if (!(strcmp($row_rsBimestre['CodBimestre'], $_SESSION['Bimestre']))) {echo "selected=\"selected\"";} ?>>
			<?php echo $row_rsBimestre['NombreBimestre']?></option>
			<?php
			} while ($row_rsBimestre = mysql_fetch_assoc($rsBimestre));
			  $rows = mysql_num_rows($rsBimestre);
			  if($rows > 0) {
				  mysql_data_seek($rsBimestre, 0);
				  $row_rsBimestre = mysql_fetch_assoc($rsBimestre);
			  }
			?>
            </select>
			</td>
			<td colspan="2">
			<select name="cboCriterio" id="cboCriterio" style="width:418px">
            <?php
			do {  
			?><option value="<?php echo $row_rsCriterio['CodCriterioCurso']?>"
			<?php if (!(strcmp($row_rsCriterio['CodCriterioCurso'], $_SESSION['Criterio']))) {echo "selected=\"selected\"";} ?>>
			<?php echo $row_rsCriterio['NombreCriterio']?></option>
			<?php
			} while ($row_rsCriterio = mysql_fetch_assoc($rsCriterio));
			  $rows = mysql_num_rows($rsCriterio);
			  if($rows > 0) {
				  mysql_data_seek($rsCriterio, 0);
				  $row_rsCriterio = mysql_fetch_assoc($rsCriterio);
			  }
			?>
            </select>
			</td>
			<!--<td>&nbsp;</td>-->
		</tr>
	  </table>
	  <div style="height:5px"></div>
	  <div style="padding-left:2px">
	  <input type="submit" name="Buscar" value="&nbsp;Ver&nbsp;" />&nbsp;&nbsp;
	  <input type="button" name="volver" id="volver" value="Volver"  
	  onclick='javascript: self.location.href=&quot;cursos.php&quot;'/>
	  </div>
			
	  <input name="txtCodigoAnio" type="hidden" id="txtCodigoAnio" value="<?php echo $_GET['CodigoAnio']; ?>" />
	  <input name="txtCodigoGrado" type="hidden" id="txtCodigoGrado" value="<?php echo $_GET['CodigoGrado']; ?>" />
	  <input name="txtCodigoSeccion" type="hidden" id="txtCodigoSeccion" value="<?php echo $_GET['CodigoSeccion']; ?>" />
      <input name="txtCodigoCurso" type="hidden" id="txtCodigoCurso" value="<?php echo $_GET['CodigoCurso']; ?>" />
      <input name="txtCodigoArea" type="hidden" id="txtCodigoArea" value="<?php echo $_GET['CodigoArea']; ?>"/>
      <br />
	  <table class="table" width="600" border="0" cellspacing="1" cellpadding="0">
      <tr class="tr">
        <td width="50"><div style="width:40px; float:right; text-align:right; padding-right:5px">Id</div></td>
        <td>Alumnos</td>
        <td width="130"><div style="padding-right:5px; text-align:right">Notas de Criterio</div></td>
      </tr>
      <?php do { ?>
        <? Filas();?>
          <td width="50">
		  <input name="txtCodigoMatricula[]" type="hidden" id="txtCodigoAlumno[]" value="<?php echo $row_rsAlumnos['CodMatricula']; ?>" />
          <input name="txtCodigoMatriculaCurso[]" type="hidden" id="txtCodigoMatriculaCurso[]" value="<?php echo $row_rsAlumnos['CodMatriculaCurso']; ?>"/>
		  <div style="width:40px; float:right; text-align:right; padding-right:5px">
		  <strong><?php echo $row_rsAlumnos['CodMatricula']; ?></strong>
		  </div>
		  </td>
          <td><?php echo $row_rsAlumnos['Alumnos']; ?></td>
          <td width="130" align="right">
		  <div style="padding-right:5px">
		  <?
		  mysql_select_db($database_cn, $cn);
		  $query_rsNota = "SELECT a.CodAnio, a.codGrado, a.CodSeccion, b.CodCurGra, c.CodProfesorCurso, c.Nota ";
		  $query_rsNota.= "FROM matricula a ";
		  $query_rsNota.= "INNER JOIN matriculacurso b ON b.CodMatricula=a.CodMatricula ";
		  $query_rsNota.= "INNER JOIN ".$Tabla." c ON c.CodMatricula=a.CodMatricula ";
		  $query_rsNota.= "WHERE a.CodAnio='".$Anio."' AND a.Codgrado='".$Grado."' ";
		  $query_rsNota.= "AND a.CodSeccion='".$Seccion."' AND b.CodCurGra='".$Curso."' ";
		  $query_rsNota.= "AND c.CodProfesorCurso='".$CodigoProfesorCurso."' AND  a.CodMatricula='".$row_rsAlumnos['CodMatricula']."' ";
		  $query_rsNota.= "and c.CodBimestre='".$_POST['cboBimestre']."' and c.CodCriterio='".$_POST['cboCriterio']."' ";
		  $rsNota = mysql_query($query_rsNota, $cn) or die(mysql_error());
		  $row_rsNota = mysql_fetch_assoc($rsNota);
		  $totalRows_rsNota = mysql_num_rows($rsNota);
		  ?>
          <table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <?php
		  do { // horizontal looper version 3
		  ?>
						<td><table width="25" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td><div style="padding-right:5px"><?php echo $row_rsNota['Nota']; ?></div></td>
								</tr>
									</table></td>
						<?php
			$row_rsNota = mysql_fetch_assoc($rsNota);
			if (!isset($nested_rsNota)) {
			  $nested_rsNota= 1;
			}
			if (isset($row_rsNota) && is_array($row_rsNota) && $nested_rsNota++ % 10==0) {
			  echo "</tr><tr>";
			}
		  } while ($row_rsNota); //end horizontal looper version 3
		  ?>
            </tr>
          </table>
		  </div>
		  </td>
        </tr>
        <?php } while ($row_rsAlumnos = mysql_fetch_assoc($rsAlumnos)); ?>
    </table>
    </form>
	<div style="height:30px"></div>
	<!-- InstanceEndEditable -->
				</div>
				<div style="height:10px"></div>
			</td>
		</tr>
		<tr>
			<td colspan="2"><? require_once("../pie.php"); ?></td>
		</tr>
	</table>
</td></tr></table>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsTreeview);

mysql_free_result($rsAlumnos);

mysql_free_result($rsBimestre);

mysql_free_result($rsCriterio);

mysql_free_result($rsNota);

mysql_free_result($rsCab);
?>