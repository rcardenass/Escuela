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

$colname_rsCab = "-1";
if (isset($_GET['CodigoProfesorCurso'])) {
  $colname_rsCab = (get_magic_quotes_gpc()) ? $_GET['CodigoProfesorCurso'] : addslashes($_GET['CodigoProfesorCurso']);
}
mysql_select_db($database_cn, $cn);
$query_rsCab = sprintf("SELECT concat(f.NombreNivel,' ',a.NombreGrado) AS NombreGrado, e.NombreSeccion, c.NombreCurso, a.CodGrado, e.CodSeccion, b.CodCurGra, d.CodAnio FROM grado a INNER JOIN cursogrado b ON b.CodGrado=a.CodGrado INNER JOIN curso c ON c.CodCurso=b.CodCurso INNER JOIN profesorcurso d ON d.CodCurGra=b.CodCurGra INNER JOIN seccion e ON e.CodSeccion=d.CodSeccion INNER JOIN nivel f ON f.CodNivel=a.CodNivel WHERE d.CodProfesorCurso=%s", $colname_rsCab);
$rsCab = mysql_query($query_rsCab, $cn) or die(mysql_error());
$row_rsCab = mysql_fetch_assoc($rsCab);
$totalRows_rsCab = mysql_num_rows($rsCab);

mysql_select_db($database_cn, $cn);
$query_rsAlumnos = "SELECT b.CodMatricula, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumnos, case b.EstadoRetirado when 0 then 'Activo' else 'Retirado' end AS Estado, a.EmailPersonal as Email FROM alumno a INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno WHERE b.CodAnio='".$row_rsCab['CodAnio']."' AND b.CodGrado='".$row_rsCab['CodGrado']."' AND b.CodSeccion='".$row_rsCab['CodSeccion']."' ";
$rsAlumnos = mysql_query($query_rsAlumnos, $cn) or die(mysql_error());
$row_rsAlumnos = mysql_fetch_assoc($rsAlumnos);
$totalRows_rsAlumnos = mysql_num_rows($rsAlumnos);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templatedoc.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
	<h1>Mis Alumnos</h1><hr /><br />
	<table width="600" border="0" cellspacing="2" cellpadding="0">
	  <tr>
		<td><span class="label">Grado</span></td>
		<td><span class="label">Seccion</span></td>
		<td><span class="label">Curso</span></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td>
		<input type="text" name="txtNombreGrado" value="<?php echo $row_rsCab['NombreGrado']; ?>" style="width:180px" 
		readonly="true"/>
		</td>
		<td>
		<input type="text" name="txtNombreSeccion" value="<?php echo $row_rsCab['NombreSeccion']; ?>" 
		style="width:50px" readonly="true"/>
		</td>
		<td title="<?php echo $row_rsCab['NombreCurso']; ?>">
		<input type="text" name="txtNombreCurso" 
		value="<?php echo substr($row_rsCab['NombreCurso'], 0, 12); ?>" style="width:270px" readonly="true"/>
		</td>
		<td align="right">
		<input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;cursos.php&quot;'/>
		</td>
	  </tr>
	</table>

	
	<div style="height:10px"></div>
	<form id="form1" name="form1" method="post" action="escribir.php">
	<table class="table" width="600" border="0" cellspacing="2" cellpadding="0">
      <tr class="tr">
        <td width="30" align="center">
          <label>
          <input type="checkbox" name="checkbox2" value="checkbox" onClick="todos(this);"/>
          </label></td>
        <td width="50">
		<input name="txtCodigoCurso" type="hidden" id="txtCodigoCurso" value="<?php echo $row_rsCabecera['CodCurGra']; ?>" />
		</td>
        <td>Alumnos</td>
        <td width="45"><div align="center">Estado</div></td>
      </tr>
      <?php do { ?>
        <? Filas();?>
          <td width="30" align="center"><label>
            <input name="chkAlumno[]" type="checkbox" id="chkAlumno[]" value="<?php echo $row_rsAlumnos['Email']; ?>"/>
          </label></td>
          <td width="50">
		  <div style="padding-right:5px; text-align:right">
		  <strong><?php echo $row_rsAlumnos['CodMatricula']; ?></strong>
		  </div>
		  </td>
          <td><?php echo $row_rsAlumnos['Alumnos']; ?></td>
          <td width="45"><div align="center"><?php echo $row_rsAlumnos['Estado']; ?></div></td>
        </tr>
        <?php } while ($row_rsAlumnos = mysql_fetch_assoc($rsAlumnos)); ?>
    </table>
	<div style="height:5px; width:600px"></div>
	<div style="width:600px; height:23px; text-align:right">
		<div style="width:300px; height:23px; float:left; text-align:left">
		  <label><!--Activar Opción Enviar Email
			<input type="checkbox" value="acepto" 
			onclick="document.form1.enviar.disabled=!document.form1.enviar.disabled"/>-->
		  </label>
		</div>
		<div style="width:300px; height:23px; float:right; text-align:right">
		<input type="submit" name="enviar" value="Enviar Correo"/>
		</div>
	</div>
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
mysql_free_result($rsCab);
mysql_free_result($rsAlumnos);
?>
<script>
	function todos(chkbox)
	{
	for (var i=0;i < document.forms[0].elements.length;i++)
	{
	var elemento = document.forms[0].elements[i];
	if (elemento.type == "checkbox")
	{
	elemento.checked = chkbox.checked
	}
	}
	}
</script>