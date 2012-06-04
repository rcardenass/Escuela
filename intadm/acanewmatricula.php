<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
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

$rsAnio = $objDatos->ObtenerAnioTodosSelAll();
$rowAnio = $objDatos->PoblarAnioTodosSelAll($rsAnio);

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);

$rsSeccion = $objDatos->ObtenerSeccionGradoSelAll();

if(isset($_GET['Codigo'])){
	$rsAlumno = $objDatos->ObtenerAlumnoSelId($_GET['Codigo']);
	$rowAlumno = $objDatos->PoblarAlumnoSelId($rsAlumno);
}
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
<script type="text/JavaScript" src="../validar.js"></script>
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
		<h1>Nueva Matricula</h1>
		<hr /><br />	
		<form action="acainsertmatricula.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('txtAlumno','','R','cboAnio','','RisNum','cboGrado','','RisNum','cboSeccion','','RisNum','cboTurno','','R');return document.MM_returnValue" autocomplete="Off">
		  <table width="426" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="190">Alumno</td>
              <td width="150"><input name="txtCodigoAlumno" type="hidden" id="txtCodigoAlumno" value="<?php echo $rowAlumno['CodAlumno']; ?>" /></td>
            </tr>
            <tr>
              <td colspan="2">
			  <table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			  <td><label>
			  <input name="txtAlumno" type="text" id="txtAlumno" style="width:380px" disabled="disabled" value="<?php echo strtoupper($rowAlumno['Alumno']); ?>" /></label>
			  </td>
			  <td align="right">
			  <a href="acamatriculaalumno.php"><img src="../imagenes/icono/user.png" width="32" border="0" title="Buscar Alumno"/></a>
			  </td>
			  </tr>
			  </table>
			  </td>
            </tr>
            <tr>
              <td>A&ntilde;o</td>
              <td>Grado</td>
            </tr>
            <tr>
              <td>
			  	<select name="cboAnio" id="cboAnio" style="width:150px">
                <option value="">Seleccione</option>
                <?php
				do {  
				?>
                <option value="<?php echo $rowAnio['CodAnio']?>"><?php echo $rowAnio['NombreAnio']?></option>
                <?php
				} while ($rowAnio = $objDatos->PoblarAnioTodosSelAll($rsAnio));
				?>
                </select>
			  </td>
              <td>
                <select name="cboGrado" id="cboGrado" style="width:250px">
                <option value="">Seleccione</option>
                <?php
				do {  
				?><option value="<?php echo $rowGrado['CodGrado']?>"><?php echo $rowGrado['NombreGrado']?></option>
				<?php
				} while ($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado));
				?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td>Secci&oacute;n</td>
              <td>Turno</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboSeccion" id="cboSeccion" style="width:150px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsSeccion" wdg:displayfield="NombreSeccion" wdg:valuefield="CodSeccion" wdg:fkey="CodGrado" wdg:triggerobject="cboGrado">
				 <option>Seleccione</option>
                </select>
              </label></td>
              <td><label>
                <select name="cboTurno" id="cboTurno" style="width:250px">
                  <option>Seleccione</option>
                  <option value="M">Ma&ntilde;ana</option>
                  <option value="T">Tarde</option>
                  <option value="N">Noche</option>
                </select>
              </label></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
	  <div style="width:425px; text-align:right"><input type="submit" name="Submit" value="Aceptar" />&nbsp;&nbsp;&nbsp;<input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acamatricula.php&quot;'/></div>
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

mysql_free_result($rsAnio);

mysql_free_result($rsGrado);

mysql_free_result($rsSeccion);

if(isset($_GET['Codigo'])){
	mysql_free_result($rsAlumno);
}
?>
