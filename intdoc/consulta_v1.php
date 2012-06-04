<?php require_once('../Connections/cn.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
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
$query_rsCabecera = "SELECT a.NombreGrado, e.NombreSeccion, c.NombreCurso FROM grado a INNER JOIN cursogrado b ON b.CodGrado=a.CodGrado INNER JOIN curso c ON c.CodCurso=b.CodCurso INNER JOIN profesorcurso d ON d.CodCurGra=b.CodCurGra INNER JOIN seccion e ON e.CodSeccion=d.CodSeccion WHERE d.CodProfesorCurso='".$CodigoProfesorCurso."' " ;
$rsCabecera = mysql_query($query_rsCabecera, $cn) or die(mysql_error());
$row_rsCabecera = mysql_fetch_assoc($rsCabecera);
$totalRows_rsCabecera = mysql_num_rows($rsCabecera);

$Sql ="SELECT  d.CodCurso, d.CodGrado, b.CodSeccion,  a.CodAlumno, b.CodMatricula, c.CodMatriculaCurso, ";
$Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumnos, h.Nota, h.CodCriterioNota ";
$Sql.="FROM alumno a ";
$Sql.="INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno ";
$Sql.="INNER JOIN seccion g ON g.CodSeccion=b.CodSeccion ";
$Sql.="INNER JOIN matriculacurso c ON c.CodMatricula=b.CodMatricula ";
$Sql.="INNER JOIN cursogrado d ON d.CodCurGra=c.CodCurGra ";
$Sql.="INNER JOIN profesorcurso e ON e.CodCurGra=d.CodCurGra ";
$Sql.="INNER JOIN personal f ON f.CodPersonal=e.CodPersonal AND f.CodTipoPersonal=2 ";
$Sql.="INNER JOIN criterionota h ON h.CodMatriculaCurso=c.CodMatriculaCurso ";
$Sql.="INNER JOIN criterionronota i ON i.CodCriterioNroNota=h.CodCriterioNroNota ";
$Sql.="WHERE f.UsuarioId='".$_SESSION['MM_Username']."' ";
$Sql.="AND d.CodGrado='".$Grado."' ";
$Sql.="AND b.CodSeccion='".$Seccion."' ";
$Sql.="AND d.CodCurGra='".$Curso."' ";
$Sql.="AND h.CodBimestre='".$_POST['cboBimestre']."' ";	//Verificar
$Sql.="AND h.CodCriterio='".$_POST['cboCriterio']."' ";	//Verificar
$Sql.="AND i.CodCriterioNroNota='".$_POST['cboNota']."' ";
$Sql.="GROUP by a.CodAlumno, b.CodMatricula ";
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

mysql_select_db($database_cn, $cn);
$query_rsNumeroNotas = "SELECT CodCriterioNroNota, CodCriterioCurso, NroEvaluacion FROM criterionronota ";
$rsNumeroNotas = mysql_query($query_rsNumeroNotas, $cn) or die(mysql_error());
$row_rsNumeroNotas = mysql_fetch_assoc($rsNumeroNotas);
$totalRows_rsNumeroNotas = mysql_num_rows($rsNumeroNotas);
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
<!-- InstanceEditableHeadTag -->
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rsNumeroNotas = new WDG_JsRecordset("rsNumeroNotas");
echo $jsObject_rsNumeroNotas->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<!-- InstanceEndEditable -->
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
	  <table width="602px" border="0" cellspacing="2" cellpadding="0">
        <tr>
          <td width="55">Grado</td>
          <td width="125"><?php echo $row_rsCabecera['NombreGrado']; ?></td>
          <td width="55">Secci&oacute;n</td>
          <td width="145"><?php echo $row_rsCabecera['NombreSeccion']; ?></td>
          <td width="45">Curso</td>
          <td title="<?php echo $row_rsCabecera['NombreCurso']; ?>"><?php echo substr($row_rsCabecera['NombreCurso'], 0, 12); ?></td> 
          <td width="65" align="right"><input type="button" name="volver" id="volver" value="Volver&nbsp;"  
			onclick='javascript: self.location.href=&quot;cursos.php&quot;'/></td>
          </tr>
        <tr>
          <td width="55">Bimestre</td>
          <td width="125"><label>
            <select name="cboBimestre" id="cboBimestre" style="width:120px">
              <?php
do {  
?><option value="<?php echo $row_rsBimestre['CodBimestre']?>"<?php if (!(strcmp($row_rsBimestre['CodBimestre'], $_SESSION['Bimestre']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsBimestre['NombreBimestre']?></option>
              <?php
} while ($row_rsBimestre = mysql_fetch_assoc($rsBimestre));
  $rows = mysql_num_rows($rsBimestre);
  if($rows > 0) {
      mysql_data_seek($rsBimestre, 0);
	  $row_rsBimestre = mysql_fetch_assoc($rsBimestre);
  }
?>
            </select>
          </label></td>
          <td width="55">Criterio</td>
          <td width="145"><label>
            <select name="cboCriterio" id="cboCriterio" style="width:140px">
              <?php
do {  
?><option value="<?php echo $row_rsCriterio['CodCriterioCurso']?>"<?php if (!(strcmp($row_rsCriterio['CodCriterioCurso'], $_SESSION['Criterio']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsCriterio['NombreCriterio']?></option>
              <?php
} while ($row_rsCriterio = mysql_fetch_assoc($rsCriterio));
  $rows = mysql_num_rows($rsCriterio);
  if($rows > 0) {
      mysql_data_seek($rsCriterio, 0);
	  $row_rsCriterio = mysql_fetch_assoc($rsCriterio);
  }
?>
            </select>
          </label></td>
          <td width="45">Nota </td>
          <td><label>
            <select name="cboNota" id="cboNota" style="width:50px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsNumeroNotas" wdg:displayfield="NroEvaluacion" wdg:valuefield="CodCriterioNroNota" wdg:fkey="CodCriterioCurso" wdg:triggerobject="cboCriterio" wdg:selected="<?php echo $_SESSION['Nota'] ?>">
            </select>
          </label></td>
          <td width="65" align="right"><label>
            <input type="submit" name="Buscar" value="Buscar" />
          </label></td>
          </tr>
      </table>
	  <input name="txtCodigoAnio" type="hidden" id="txtCodigoAnio" value="<?php echo $_GET['CodigoAnio']; ?>" />
	  <input name="txtCodigoGrado" type="hidden" id="txtCodigoGrado" value="<?php echo $_GET['CodigoGrado']; ?>" />
	  <input name="txtCodigoSeccion" type="hidden" id="txtCodigoSeccion" value="<?php echo $_GET['CodigoSeccion']; ?>" />
      <input name="txtCodigoCurso" type="hidden" id="txtCodigoCurso" value="<?php echo $_GET['CodigoCurso']; ?>" />
      <input name="txtCodigoArea" type="hidden" id="txtCodigoArea" value="<?php echo $_GET['CodigoArea']; ?>"/>
      <br />
	  <table class="table" width="600" border="0" cellspacing="1" cellpadding="0">
      <tr class="tr">
        <td width="30">&nbsp;</td>
        <td width="40">&nbsp;</td>
        <td>Alumnos</td>
        <td width="45"><div align="center">Nota</div></td>
      </tr>
      <?php do { ?>
        <tr>
          <td width="30"><input name="txtCodigoMatricula[]" type="hidden" id="txtCodigoAlumno[]" value="<?php echo $row_rsAlumnos['CodMatricula']; ?>" />
            <input name="txtCodigoMatriculaCurso[]" type="hidden" id="txtCodigoMatriculaCurso[]" value="<?php echo $row_rsAlumnos['CodMatriculaCurso']; ?>"/></td>
          <td width="40"><?php echo $row_rsAlumnos['CodMatricula']; ?></td>
          <td><?php echo $row_rsAlumnos['Alumnos']; ?></td>
          <td width="45"><div align="center">
          <?php echo $row_rsAlumnos['Nota']; ?>
          </div></td>
        </tr>
        <?php } while ($row_rsAlumnos = mysql_fetch_assoc($rsAlumnos)); ?>
    </table>
    </form>
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

mysql_free_result($rsNumeroNotas);

mysql_free_result($rsCabecera);
?>