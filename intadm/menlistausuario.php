<?php include("../seguridad.php");?>
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

$_SESSION['Perfil']=$_POST['cboPerfil'];
$_SESSION['Grado']=$_POST['cboGrado'];
$_SESSION['Seccion']=$_POST['cboSeccion'];

$rsPerfil = $objDatos->ObtenerPerfilSelAll();
$rowPerfil = $objDatos->PoblarPerfilSelAll($rsPerfil);

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);

$rsSeccion = $objDatos->ObtenerSeccionGradoSelAll();

if(!empty($_POST['cboPerfil'])){
	$rsUsuario = $objDatos->ObtenerUsuarioAlumnoEmailSelAll($_POST['cboPerfil'],$_POST['cboGrado'],$_POST['cboSeccion']);
	$rowUsuario = $objDatos->PoblarUsuarioAlumnoEmailSelAll($rsUsuario);
	$totalRows_rsUsuario = mysql_num_rows($rsUsuario);
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
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<?php
//begin JSRecordset
$jsObject_rsSeccion = new WDG_JsRecordset("rsSeccion");
echo $jsObject_rsSeccion->getOutput();
//end JSRecordset
?>
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
		<h1>Contactos</h1><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="menlistausuario.php">
		<table>
		<tr>
			<td>Perfil</td>
			<td>Grado</td>
			<td>Seccion</td>
		</tr>
		<tr>
			<td>
			<select name="cboPerfil" id="cboPerfil" style="width:150px">
			<? do{ ?>
				<option value="<?php echo $rowPerfil['CodPerfil']?>" 
				<?php if (!(strcmp($rowPerfil['CodPerfil'], $_SESSION['Perfil']))) {echo "selected=\"selected\"";} ?>>
				<?php echo $rowPerfil['NombrePerfil']?></option>
			<? }while($rowPerfil = $objDatos->PoblarAlumnoSelAll($rsPerfil)); ?>
			</select>
			</td>
			<td>
			<select name="cboGrado" id="cboGrado" style="width:170px">
			<? do{ ?>
				<option value="<?php echo $rowGrado['CodGrado']?>" 
				<?php if (!(strcmp($rowGrado['CodGrado'], $_SESSION['Grado']))) {echo "selected=\"selected\"";} ?>>
				<?php echo $rowGrado['NombreGrado']?></option>
			<? } while ($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado)); ?>
			</select>
			</td>
			<td>
			<select name="cboSeccion" id="cboSeccion" style="width:100px" wdg:subtype="DependentDropdown" 
			wdg:type="widget" wdg:recordset="rsSeccion" wdg:displayfield="NombreSeccion" wdg:valuefield="CodSeccion" 
			wdg:fkey="CodGrado" wdg:triggerobject="cboGrado" wdg:selected="<?php echo $_SESSION['Seccion']; ?>">
            </select>
			</td>
			<td><input type="submit" name="Submit" value="Buscar" /></td>
		</tr>
		</table>
		<br>
		<? if($totalRows_rsUsuario>0){?>
		<div style="width:600px; text-align:left">
		<input type="button" name="Submit" value="Grabar" onclick="document.form1.action='menescribir.php'; document.form1.submit()"; />
		</div>
		<? } ?>
		<div style="height:3px"></div>
		<table class="table" width="600px" border="0" cellpadding="0" cellspacing="2">
    <tr class="tr">
      <td width="50">Codigo</td>
      <td width="150">Usuario</td>
      <td>Nombres</td>
      <td width="30">
	  <? if($totalRows_rsUsuario>0){?>
	  <div align="center"><input type="checkbox" name="checkbox2" value="checkbox" onClick="todos(this);"/></div>
	  <? } ?>
	  </td>
    </tr>
	<? if($totalRows_rsUsuario==0){?>
    <tr>
      <td colspan="4">No hay registros </td>
    </tr>
	<? }?>
	<? if($totalRows_rsUsuario>0){?>
	<? do{ ?>
    <? Filas();?>
      <td width="50"><div style="text-align:right; padding-right:3px"><strong><? echo $rowUsuario['Codigo']; ?></strong></div></td>
      <td width="150"><? echo $rowUsuario['Usuario']; ?></td>
      <td><? echo $rowUsuario['Nombres']; ?></td>
      <td width="30">
        <div align="center">
		  <input name="chkUsuario[]" type="checkbox" id="chkUsuario[]" value="<?php echo $rowUsuario['Usuario']; ?>"/>
        </div>
      </td>
    </tr>
	<? } while($rowUsuario = $objDatos->PoblarUsuarioAlumnoEmailSelAll($rsUsuario)); ?>
	<? }?>
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
mysql_free_result($rsPerfil);
mysql_free_result($rsGrado);
mysql_free_result($rsSeccion);
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