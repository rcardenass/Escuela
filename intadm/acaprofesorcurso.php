<?php include("../seguridad.php");?>
<?php include('funciones.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$_SESSION['Anio']=$_POST['cboAnio'];
$_SESSION['Grado']=$_POST['cboGrado'];
$_SESSION['Seccion']=$_POST['cboSeccion'];
$_SESSION['Buscar']=$_POST['txtBuscar'];

$rsAnio = $objDatos->ObtenerAnioSelAll();
$rowAnio = $objDatos->PoblarAnioSelAll($rsAnio);

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);

$rsSeccion = $objDatos->ObtenerSeccionGradoSelAll();

$rsProfesorCurso = $objDatos->ObtenerProfesorCursoSeAll($_SESSION['Anio'],$_SESSION['Grado'],$_SESSION['Seccion'],$_SESSION['Buscar']);
$rowProfesorCurso = $objDatos->PoblarProfesorCursoSelAll($rsProfesorCurso);
$totalRows_rsProfesor = mysql_num_rows($rsProfesorCurso);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templateadm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Gestion Escolar</title>
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
$jsObject_rsSeccion = new WDG_JsRecordset("rsSeccion");
echo $jsObject_rsSeccion->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<!-- InstanceEndEditable -->
<link href="../styleadm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="90%" border="0" align="center"><tr><td>
	<table width="100%" border="0" cellpadding="0">
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
		<h1>Profesor - Curso</h1><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="acaprofesorcurso.php">
		<table width="650px" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  	<td width="90"><span class="label">Año</span></td>
            <td width="170"><span class="label">Grado</span></td>
            <td width="170"><span class="label">Sección</span></td>
            <td><span class="label">Profesor</span></td>
            <td width="70" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td width="90">
			<select name="cboAnio" id="cboAnio" style="width:80px">
              	<?php
				do {  
				?><option value="<?php echo $rowAnio['CodAnio']?>"
				<?php if (!(strcmp($rowAnio['CodAnio'], $_SESSION['Anio']))) {echo "selected=\"selected\"";} ?>>
				<?php echo $rowAnio['NombreAnio']?></option>
				<?php
				} while ($rowAnio = $objDatos->PoblarAnioSelAll($rsAnio));
				?>
            </select>
			</td>
            <td width="170">
              <select name="cboGrado" id="cboGrado" style="width:150px">
                <option value="" <?php if (!(strcmp("", $_SESSION['Grado']))) {echo "selected=\"selected\"";} ?>></option>
                <?php
				do {  
				?><option value="<?php echo $rowGrado['CodGrado']?>"
				<?php if (!(strcmp($rowGrado['CodGrado'], $_SESSION['Grado']))) {echo "selected=\"selected\"";} ?>>
				<?php echo $rowGrado['NombreGrado']?></option>
				<?php
				} while ($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado));
				?>
              </select>
            </td>
            <td width="170"><label>
              <select name="cboSeccion" id="cboSeccion" style="width:150px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsSeccion" wdg:displayfield="NombreSeccion" wdg:valuefield="CodSeccion" wdg:fkey="CodGrado" wdg:triggerobject="cboGrado" wdg:selected="<?php echo $_SESSION['Seccion']; ?>">
			  <option value=""></option>
              </select>
            </label></td>
            <td><input name="txtBuscar" type="text" id="txtBuscar" style="width:170px" value="<?php echo $_SESSION['Buscar'] ?>" maxlength="20" /></td>
            <td width="70" align="right"><input type="submit" name="Submit" value="Buscar" /></td>
          </tr>
        </table>
		<div style="height:5px"></div>
		<table class="table" width="700px" border="0" cellspacing="2" cellpadding="0">
          <tr class="tr">
            <td width="50" align="left"><div style="width:40px; float:right; text-align:right; padding-right:5px">Id</div></td>
            <td width="40" align="center">A&ntilde;o</td>
            <td>Grado</td>
            <td width="60" align="center">Sección</td>
            <td>Profesor</td>
            <td>Curso</td>
            <td width="32" align="center"><a href="acanewprofesorcurso.php"><center><img src="../imagenes/icono/add.png" width="32" border="0"/></center></a></td>
          </tr>
          <?php 
		  if(!empty($totalRows_rsProfesor)){
		  do { 
		  ?>
          <? Filas();?>
            <td width="50" align="left"><div style="width:40px; float:right; text-align:right; padding-right:5px"><strong><?php echo $rowProfesorCurso['CodProfesorCurso']; ?></strong></div></td>
            <td width="40" align="center"><?php echo $rowProfesorCurso['NombreAnio']; ?></td>
            <td><?php echo $rowProfesorCurso['NombreGrado']; ?></td>
            <td width="60" align="center"><?php echo $rowProfesorCurso['NombreSeccion']; ?></td>
            <td><?php echo $rowProfesorCurso['Profesor']; ?></td>
            <td><?php echo $rowProfesorCurso['NombreCurso']; ?></td>
            <td width="32"><a href="acaeditprofesorcurso.php?Codigo=<?php echo $rowProfesorCurso['CodProfesorCurso']; ?>"><center><img src="../imagenes/icono/edit.png" width="22" border="0" title="Editar"/></center></a></td>
          </tr>
          <?php 
		  } while ($rowProfesorCurso = $objDatos->PoblarProfesorCursoSelAll($rsProfesorCurso)); 
		  }
		  ?>
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

mysql_free_result($rsProfesorCurso);

mysql_free_result($rsGrado);

mysql_free_result($rsSeccion);

mysql_free_result($rsAnio);
?>