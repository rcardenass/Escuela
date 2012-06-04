<?php include("../seguridad.php");?>
<?php include("../funciones.php"); ?>
<?php
//MX Widgets3 include
require_once("../includes/wdg/WDG.php");
?>
<?
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

if(isset($_POST['txtBuscar'])){
	$_SESSION['Buscar']=$_POST['txtBuscar'];
}else{
	$_SESSION['Buscar']="";
}

$rsProducto = $objDatos->ObtenerProductoSelAll($_SESSION['Buscar']);
$rowProducto = $objDatos->PoblarProductoSelAll($rsProducto);
$totalRows_rsProducto = mysql_num_rows($rsProducto);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templateadm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Gestion Escolar</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>

<script type="text/javascript">
    /*var GB_ROOT_DIR = "http://mydomain.com/greybox/";*/
	var GB_ROOT_DIR = "../greybox/"
</script>
<script type="text/javascript" src="../greybox/AJS.js"></script>
<script type="text/javascript" src="../greybox/AJS_fx.js"></script>
<script type="text/javascript" src="../greybox/gb_scripts.js"></script>
<link href="../greybox/gb_styles.css" rel="stylesheet" type="text/css" />
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEditableHeadTag -->
<style type="text/css">
<!--
.Rojo {color: #FF0000; font-size:12px;}
-->
</style>
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
		<h1>Conceptos</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="" autocomplete="Off">
			<table width="400" border="0" cellspacing="2" cellpadding="0">
			  <tr>
				<td width="55px"><span class="label">Buscar</span></td>
				<td><input type="text" name="txtBuscar" id="txtBuscar" style="width:260px" value="<?= $_SESSION['Buscar']; ?>"/></td>
				<td><input type="submit" name="Submit" value="Buscar" /></td>
			  </tr>
			</table>
			<br />
			<table class="table" width="700px" border="0" cellspacing="2" cellpadding="0">
			  <tr class="tr">
				<td width="50"><div style="width:40px; float:right; text-align:right; padding-right:5px">Id</div></td>
				<td>Conceptos</td>
				<td width="80"><div style="text-align:right; padding-right:5px">Costo</div></td>
				<td width="50" align="center">Dscto</td>
				<td width="60"><div style="text-align:right; padding-right:5px">Valor</div></td>
				<td width="70" align="center">Estado</td>
				<td width="50" align="center">Stock</td>
				<td width="40" align="center"><a href="cuenewconcepto.php" title="Agregar Concepto"><img src="../imagenes/icono/add.png" width="28" border="0" /></a></td>
			  </tr>
			  <? if(empty($totalRows_rsProducto)){ ?>
			  <tr>
				<td colspan="8"><div style="padding-left:15px">No existen registros</div></td>
				</tr>
			  <? }else{ ?>
				  <? do{ ?>
				  <? Filas(); ?>
					<tr><td width="50">
					<div style="width:40px; float:right; text-align:right; padding-right:5px">
					<strong><? echo $rowProducto['CodProducto']; ?></strong>				</div>
					</td>
					<td>
					<? if($rowProducto['FlagStock']=="Si"){?>
						<a href="cuestockedit.php?Codigo=<? echo $rowProducto['CodProducto']; ?>" title="Stock" rel="gb_page_center[520, 250]">
							<? echo $rowProducto['NombreProducto']; ?>						</a>
					<? }else{ ?>
						<? echo $rowProducto['NombreProducto']; ?>
					<? }?>					</td>
					<td width="80"><div style="text-align:right; padding-right:5px"><? echo $rowProducto['Precio']; ?></div></td>
					<td width="50"><div style="text-align:right; padding-right:5px"><? echo $rowProducto['Descuento']; ?></div></td>
					<td width="60"><div style="text-align:right; padding-right:5px"><strong><?= number_format($rowProducto['Precio']-$rowProducto['Descuento'],2,".",""); ?></strong></div></td>
					<td width="70" align="center"><span class="Rojo"><? echo $rowProducto['Estado']; ?></span></td>
					<td width="50" align="center"><? echo $rowProducto['FlagStock']; ?></td>
					<td width="40" align="center"><a href="cueeditconcepto.php?Codigo=<?= $rowProducto['CodProducto']; ?>" title="Editar Concepto"><img src="../imagenes/icono/edit.png" width="22" border="0" /></a></td>
				  </tr>
				  <? }while($rowProducto = $objDatos->PoblarProductoSelAll($rsProducto)); ?>
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
?>
