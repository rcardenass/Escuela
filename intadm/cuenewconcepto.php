<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?
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

if(trim($_POST['txtConcepto'])!='' and trim($_POST['txtPrecio'])!=''){
	
	if($_POST['chkStock']=="checkbox"){ $Stock=1;}else{ $Stock=0;}
	
	if(Grabar($_POST['cboTipoProducto'], $_POST['cboTipoComprobante'], $_POST['txtConcepto'], $_POST['txtPrecio'], $_SESSION['MM_Username'], $Stock)){
		$rsProducto = $objDatos->ObtenerMaximoProductoSelId($_SESSION['MM_Username']);
		$row_rsProducto = $objDatos->PoblarMaximoProductoSelId($rsProducto);
		
		$objDatos->InsertStock($row_rsProducto['Maximo'],0,$_SESSION['MM_Username']);
		
		header("Location: cueconcepto.php");
	}
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
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/NumericInput.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<!-- InstanceEditableHeadTag -->
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
		<h1>Nuevo Concepto</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="" autocomplete="Off" onsubmit="MM_validateForm('txtConcepto','','R','txtPrecio','','RisNum','cboTipoProducto','','R','cboTipoComprobante','','R');return document.MM_returnValue">
			<table width="390" border="0" cellspacing="2" cellpadding="0">
			  <tr>
				<td width="105"><span class="label">Concepto</span></td>
				<td><input type="text" name="txtConcepto" id="txtConcepto" style="width:250px"/></td>
			  </tr>
			  <tr>
				<td width="105"><span class="label">Precio</span></td>
				<td><input name="txtPrecio" id="txtPrecio" style="width:50px" value="" wdg:negatives="no" wdg:subtype="NumericInput" wdg:type="widget" wdg:floats="yes" wdg:spinner="no"/></td>
			  </tr>
			  <tr>
			    <td width="105"><span class="label">Producto</span></td>
			    <td><label>
			      <select name="cboTipoProducto" id="cboTipoProducto" style="width:150px">
			        <option value="">SELECCIONE</option>
			        <option value="1">MATRICULA</option>
			        <option value="2">VARIOS</option>
			        </select>
			    </label></td>
			    </tr>
			  <tr>
			    <td width="105"><span class="label">Comprobante</span></td>
			    <td><label>
			      <select name="cboTipoComprobante" id="cboTipoComprobante" style="width:150px">
			        <option value="">SELECCIONE</option>
			        <option value="1">BOLETA</option>
			        <option value="2">RECIBO</option>
			        </select>
			    </label></td>
			    </tr>
			  <tr>
			    <td width="105"><span class="label">Stock</span></td>
			    <td><label>
			      <input name="chkStock" type="checkbox" id="chkStock" value="checkbox" />
			    </label></td>
			    </tr>
			  <tr>
				<td width="105">&nbsp;</td>
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
<?
function Grabar($TipoProducto,$TipoComprobante,$Nombre,$Precio,$Usuario,$Stock){
	$log=false;
	$objDatos=new datos();
	if($objDatos->InsertProducto($TipoProducto,$TipoComprobante,$Nombre,$Precio,$Usuario,$Stock)==1){
		$log=true;
	}
	return $log;
}
?>