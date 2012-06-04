<?php
$KT_relPath = "../";
  require_once("../includes/widgets/widgets_start.php");
?>
<?php include("../seguridad.php");?>
<?
include("../clases/datos.php");
$objDatos=new datos();

$rsStock = $objDatos->ObtenerStockCabeceraDetalleSelId($_GET['Codigo']);
$row_rsStock = $objDatos->PoblarStockCabeceraDetalleSelId($rsStock);

if(isset($_POST['txtCodProducto'])){
	if(ActualizaStock($_POST['txtCodProducto'],$_POST['txtStock'],$_POST['txtStockAnterior'],$_POST['txtAgregarStock'],$_SESSION['MM_Username'])){
		$Menzaje="El Stock se incremento correctamente";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../styleadm.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript" src="../validar.js"></script>
</head>

<body>
<? if(!isset($_POST['txtCodProducto'])){ ?>
	<table width="500" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="140"><span class="label">Producto</span></td>
    <td>
      <input name="txtProducto" type="text" id="txtProducto" value="<? echo $row_rsStock['NombreProducto'];?>" style="width:330px" readonly="true"/>
   </td>
  </tr>
  <tr>
    <td width="140"><span class="label">Tipo Producto</span></td>
    <td><input name="txtTipoProducto" type="text" id="txtTipoProducto" value="<? echo $row_rsStock['NombreTipoProducto'];?>" style="width:200px" readonly="true"/></td>
  </tr>
  <tr>
    <td width="140"><span class="label">Tipo Comprobante</span></td>
    <td><input name="txtTipoComprobante" type="text" id="txtTipoComprobante" value="<? echo $row_rsStock['NombreTipoComprobante'];?>" style="width:200px" readonly="true"/></td>
  </tr>
</table>
<br/>
<form id="form1" name="form1" method="post" action="" autocomplete="Off" onsubmit="MM_validateForm('txtStok','','RisNum','txtStockAnterior','','RisNum','txtAgregarStock','','RisNum');return document.MM_returnValue">
<table width="500" border="0" cellspacing="1" cellpadding="0">
<tr>
<td width="140" class="label">Stock Actual</td>
<td>
  <input name="txtStock" type="widget" id="txtStock" value="<? echo $row_rsStock['Stock'];?>" subtype="numericInput" negative="true" allowfloat="false" readonly="true" />
</td>
</tr>
<tr>
<td width="140" class="label">Stock Anterior</td>
<td>
  <input name="txtStockAnterior" type="widget" id="txtStockAnterior" value="<? echo $row_rsStock['StockOriginal'];?>" readonly="true" subtype="numericInput" negative="true" allowfloat="false" />
</td>
</tr>
<tr>
<td width="140" class="label">Agregar Stock</td>
<td>
  <input name="txtAgregarStock" type="widget" id="txtAgregarStock" subtype="numericInput" negative="true" allowfloat="false" />
</td>
</tr>
<tr>
<td width="140"><input name="txtCodProducto" type="hidden" id="txtCodProducto" value="<? echo $row_rsStock['CodProducto'];?>"/></td>
<td>
  <input type="submit" name="Submit" value="Actualizar" />
</td>
</tr>
</table>
</form>
<? 
}else{ 
	echo "<div style='text-align:center'>".$Menzaje."</div>";
}
?>
</body>
</html>
<?php
  require_once("../includes/widgets/widgets_end.php");
  
  
  function ActualizaStock($CodProducto,$Stock,$StockOriginal,$NroAgregado,$Usuario){
	$log=false;
	$objDatos=new datos();
	if($objDatos->UpdateStock($CodProducto,$Stock,$StockOriginal,$NroAgregado,$Usuario)){
		$log=true;
	}
	return $log;
}
?>