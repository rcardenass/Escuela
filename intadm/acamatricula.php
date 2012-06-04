<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php include('../funciones.php'); ?>
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

/*if(isset($_POST['cboAnio'])){
$_SESSION['Anio']=$_POST['cboAnio'];
$_SESSION['Grado']=$_POST['cboGrado'];
$_SESSION['Seccion']=$_POST['cboSeccion'];
$_SESSION['Buscar']=$_POST['txtBuscar'];
}else{
$_SESSION['Anio']="";
$_SESSION['Grado']="";
$_SESSION['Seccion']="";
$_SESSION['Buscar']="";
}*/

$rsAnio = $objDatos->ObtenerAnioTodosSelAll();
$rowAnio = $objDatos->PoblarAnioTodosSelAll($rsAnio);

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);

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
<script language="javascript" src="../js/jquery-1.3.min.js"></script>
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
<script language="javascript">
$(document).ready(function() {
    $().ajaxStart(function() {
        $('#loading').show();
        $('#lista').hide();
    }).ajaxStop(function() {
        $('#loading').hide();
        $('#lista').fadeIn('slow');
    });
    $('#form, #fat, #form1').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#lista').html(data);

            }
        })
        
        return false;
    }); 
})  
</script>
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
		<h1>Matricula</h1><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="php/acamatricula.php">
		<table width="640px" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  	<td width="70"><span class="label">Año</span></td>
            <td width="210"><span class="label">Grado</span></td>
            <td width="70"><span class="label">Sección</span></td>
            <td><span class="label">Alumno</span></td>
            <td width="70" align="right">&nbsp;</td>
			<td width="35" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td width="70">
			<select name="cboAnio" id="cboAnio" style="width:60px">
            <?php
			do {  
			?>
            <option value="<?php echo $rowAnio['CodAnio']?>">
			<?php echo $rowAnio['NombreAnio']?></option>
            <?php
			} while ($rowAnio = $objDatos->PoblarAnioTodosSelAll($rsAnio));
			?>
            </select>			</td>
            <td width="210">
            <select name="cboGrado" id="cboGrado" style="width:200px">
            <option value=""></option>
            <?php
			do { 
			?>
			<option value="<?php echo $rowGrado['CodGrado']?>">
			<?php echo $rowGrado['NombreGrado']?></option>
			<?php
			} while ($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado));
			?>
            </select>            </td>
            <td width="70"><select name="cboSeccion" id="cboSeccion" style="width:60px" wdg:subtype="DependentDropdown" 
			  wdg:type="widget" wdg:recordset="rsSeccion" wdg:displayfield="NombreSeccion" wdg:valuefield="CodSeccion" 
			  wdg:fkey="CodGrado" wdg:triggerobject="cboGrado">
            </select></td>
            <td>
			<input name="txtBuscar" type="text" id="txtBuscar" style="width:170px" maxlength="20" />			</td>
            <td width="70" align="right">
			<input type="submit" id="btBuscar" name="btBuscar" value="Buscar" />			</td>
			<td width="35" align="right">
			<a href="acanewmatricula.php" title="Nuevo"><img src="../imagenes/icono/add.png" width="32" border="0"/></a>			</td>
          </tr>
        </table>
		<div style="height:5px"></div>
		<div id="lista" style="width:95%"></div>
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
mysql_free_result($rsGrado);
mysql_free_result($rsSeccion);
mysql_free_result($rsAnio);
?>