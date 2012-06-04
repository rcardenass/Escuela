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

$rsAnio = $objDatos->ObtenerAnioSelAll();
$rowAnio = $objDatos->PoblarAnioSelAll($rsAnio);

$rsNivel=$objDatos->ObtenerNivelSelAll();
$rowNivel = $objDatos->PoblarNivelSelAll($rsNivel);

$rsGrado = $objDatos->ObtenerNivelGradoSelAll();

$rsSeccion = $objDatos->ObtenerSeccionGradoSelAll();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templateadm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Gestion Escolar</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<script src="../js/jquery.js" type="text/javascript"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$("#btConsulta").click(function (){
	   var datos = $("#form1").serialize();//Serializamos los datos a enviar
	   $.ajax({
	   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
	   url: "php/conprofesorcurso.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
	   data: datos, //Variable que transferira los datos
	   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
	   beforeSend: function() {//Función que se ejecuta antes de enviar los datos
		  $("#lista").html("Procesando...."); //Mostrar mensaje que se esta procesando el script
	   },
	   dataType: "html",
	   success: function(datos){ //Funcion que retorna los datos procesados del script PHP
		   $('#lista').html(datos);
	   }
	   });
	});
});
</script>

<?php
//begin JSRecordset
$jsObject_rsGrado = new WDG_JsRecordset("rsGrado");
echo $jsObject_rsGrado->getOutput();

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
		<h1>Consulta de Profesor Cursos</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="">
		  <table width="510" border="0" cellspacing="2" cellpadding="0">
			<tr>
			  <td>A&ntilde;o</td>
			  <td>Nivel</td>
			  <td>Grado</td>
			  <td>Seccion</td>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td>
				<select name="cboAnio" id="cboAnio" style="width:60px">
				<?php
				do {  
				?>
				<option value="<?php echo $rowAnio['CodAnio']?>">
				<?php echo $rowAnio['NombreAnio']?></option>
				<?php
				} while ($rowAnio = $objDatos->PoblarAnioSelAll($rsAnio));
				?>
				</select>
			  </td>
			  <td>
			  <select name="cboNivel" id="cboNivel" style="width:100px">
			  	<?php
				do {  
				?>
				<option value="<?php echo $rowNivel['CodNivel']?>">
				<?php echo $rowNivel['NombreNivel']?></option>
				<?php
				} while ($rowNivel = $objDatos->PoblarNivelSelAll($rsNivel));
				?>
			  </select>
			  </td>
			  <td>
			  <select name="cboGrado" id="cboGrado" style="width:120px" wdg:subtype="DependentDropdown" 
			  wdg:type="widget" wdg:recordset="rsGrado" wdg:displayfield="NombreGrado" wdg:valuefield="CodGrado" 
			  wdg:fkey="CodNivel" wdg:triggerobject="cboNivel">
			  <option value=""></option>
              </select>
			  </td>
			  <td>
			  <select name="cboSeccion" id="cboSeccion" style="width:50px" wdg:subtype="DependentDropdown" 
			  wdg:type="widget" wdg:recordset="rsSeccion" wdg:displayfield="NombreSeccion" wdg:valuefield="CodSeccion" 
			  wdg:fkey="CodGrado" wdg:triggerobject="cboGrado">
			  <option value=""></option>
              </select>
			  </td>
			  <td align="right">
				<input type="button" id="btConsulta" name="btConsulta" value="Consultar" />
			  </td>
			  <td align="right">
				<input type="button" id="btReporte" name="btReporte" value="Reporte" 
				onclick="document.form1.action='reporte/repprofesorcurso.php'; document.form1.target='_blank'; document.form1.submit()";/>
			  </td>
			</tr>
		  </table>
		</form>
		<div style="height:5px"></div>
		<div id="lista" style="width:95%"></div>
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
mysql_free_result($rsNivel);
mysql_free_result($rsGrado);
mysql_free_result($rsSeccion);
?>
