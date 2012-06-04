<?php include("../seguridad.php");?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
<?
include("../clases/datos.php");
$objDatos=new datos();

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$rsProducto = $objDatos->ObtenerProductoSelId($_GET['Codigo']);
$rowProducto = $objDatos->PoblarProductoSelId($rsProducto);
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
<script type="text/javascript" src="../validar.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/NumericInput.js"></script>
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
		<h1>Editar Concepto</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="cueupdateconcepto.php" autocomplete="Off" onsubmit="MM_validateForm('txtConcepto','','R','txtPrecio','','RisNum');return document.MM_returnValue">
			<table width="350" border="0" cellspacing="2" cellpadding="0">
			  <tr>
				<td><span class="label">Concepto</span></td>
				<td>
				<input type="text" name="txtConcepto" id="txtConcepto" style="width:250px" 
				value="<? echo $rowProducto['NombreProducto']; ?>" readonly="true"/>				</td>
			  </tr>
			  <tr>
				<td><span class="label">Precio</span></td>
				<td><input name="txtPrecio" id="txtPrecio" style="width:50px" wdg:negatives="no" wdg:subtype="NumericInput" wdg:type="widget" wdg:floats="yes" wdg:spinner="no" value="<? echo $rowProducto['Precio']; ?>"/></td>
			  </tr>
			  <tr>
				<td><span class="label">Dscto</span></td>
				<td><input name="txtDescuento" id="txtDescuento" style="width:50px" value="<? echo $rowProducto['Descuento']; ?>" wdg:subtype="NumericInput" wdg:type="widget" wdg:negatives="no" wdg:floats="yes" wdg:spinner="no"/></td>
			  </tr>
			  <tr>
			    <td><span class="label">Estado</span></td>
			    <td><label>
			      <input name="chkEstado" type="checkbox" id="chkEstado"
				  <? if($rowProducto['Estado']==1){ echo "checked='checked'";} ?> />
			    </label></td>
			    </tr>
			  <tr>
				<td><input type="hidden" name="txtCodigo" value="<? echo $rowProducto['CodProducto']; ?>"/></td>
				<td>
				<input type="submit" name="Submit" value="Grabar" />
				&nbsp;&nbsp;&nbsp;
				<input type="button" name="button" id="button" value="Volver"  
				onclick='javascript: self.location.href=&quot;cueconcepto.php&quot;'/>				</td>
			  </tr>
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
?>
