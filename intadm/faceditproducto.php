<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

mysql_select_db($database_cn, $cn);
$query_rsTipoProducto = "SELECT CodTipoProducto, NombreTipoProducto FROM tipoproducto WHERE Estado = 0 ORDER BY NombreTipoProducto ASC";
$rsTipoProducto = mysql_query($query_rsTipoProducto, $cn) or die(mysql_error());
$row_rsTipoProducto = mysql_fetch_assoc($rsTipoProducto);
$totalRows_rsTipoProducto = mysql_num_rows($rsTipoProducto);

$colname_rsEditar = "-1";
if (isset($_GET['Codigo'])) {
  $colname_rsEditar = (get_magic_quotes_gpc()) ? $_GET['Codigo'] : addslashes($_GET['Codigo']);
}
mysql_select_db($database_cn, $cn);
$query_rsEditar = sprintf("SELECT CodProducto, CodTipoProducto, NombreProducto, Precio, Descuento, Estado, UsuarioCreacion, FechaCreacion, UsuarioModificacion, FechaModificacion FROM productos WHERE CodProducto = %s", $colname_rsEditar);
$rsEditar = mysql_query($query_rsEditar, $cn) or die(mysql_error());
$row_rsEditar = mysql_fetch_assoc($rsEditar);
$totalRows_rsEditar = mysql_num_rows($rsEditar);
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
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/NumericInput.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
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
		<h1>Editar Producto</h1><hr /><br />
		<form action="facupdateproducto.php" autocomplete="Off" method="post" name="form1" id="form1" onsubmit="MM_validateForm('cboTipoProducto','','RisNum','txtProducto','','R','txtPrecio','','RisNum','txtDescuento','','RisNum');return document.MM_returnValue">
		  <table width="300" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td>Tipo Producto 
              <input name="txtCodigoProducto" type="hidden" id="txtCodigoProducto" value="<?php echo $row_rsEditar['CodProducto']; ?>" /></td>
            </tr>
            <tr>
              <td><label>
                <select name="cboTipoProducto" id="cboTipoProducto" style="width:200px" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $row_rsEditar['CodTipoProducto']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsTipoProducto['CodTipoProducto']?>"<?php if (!(strcmp($row_rsTipoProducto['CodTipoProducto'], $row_rsEditar['CodTipoProducto']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsTipoProducto['NombreTipoProducto']?></option>
                  <?php
} while ($row_rsTipoProducto = mysql_fetch_assoc($rsTipoProducto));
  $rows = mysql_num_rows($rsTipoProducto);
  if($rows > 0) {
      mysql_data_seek($rsTipoProducto, 0);
	  $row_rsTipoProducto = mysql_fetch_assoc($rsTipoProducto);
  }
?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td>Producto</td>
            </tr>
            <tr>
              <td><label>
                <input name="txtProducto" type="text" id="txtProducto" style="width:200px" value="<?php echo $row_rsEditar['NombreProducto']; ?>"/>
              </label></td>
            </tr>
            <tr>
              <td>Precio</td>
            </tr>
            <tr>
              <td><label>
                <input name="txtPrecio" id="txtPrecio" style="width:50px" value="<?php echo $row_rsEditar['Precio']; ?>" maxlength="7" wdg:negatives="no" wdg:subtype="NumericInput" wdg:type="widget" wdg:floats="yes" wdg:spinner="no"/>
              </label></td>
            </tr>
            <tr>
              <td>Descuento</td>
            </tr>
            <tr>
              <td><label>
                <input name="txtDescuento" id="txtDescuento" style="width:50px" value="<?php echo $row_rsEditar['Descuento']; ?>" maxlength="7" wdg:negatives="no" wdg:subtype="NumericInput" wdg:type="widget" wdg:floats="yes" wdg:spinner="no"/>
              </label></td>
            </tr>
          </table>
		  <div style="width:200px; text-align:right">
                <input type="submit" name="Submit" value="Aceptar" />&nbsp;&nbsp;
	    <input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;facproducto.php&quot;'/>
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

mysql_free_result($rsTipoProducto);

mysql_free_result($rsEditar);
?>
