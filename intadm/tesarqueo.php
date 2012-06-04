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
$query_rsMontos = "SELECT CodMonto, Monto FROM montos ORDER BY CodMonto ASC";
$rsMontos = mysql_query($query_rsMontos, $cn) or die(mysql_error());
$row_rsMontos = mysql_fetch_assoc($rsMontos);
$totalRows_rsMontos = mysql_num_rows($rsMontos);
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
		<!--<h1>Arqueo de Caja</h1><hr /><br />-->
		<h1>
		<div style="width:100%">
			<div style="width:300px; height:auto; float:left; padding-top:20px">Arqueo de Caja</div>
			<div style="width:100px; height:auto; float:right; text-align:right">
				<a href="tescaja.php"><img src="../imagenes/icono/revert.png" border="0" title="Ir a Caja"/></a>
			</div>
		</div>
	    </h1><div style="height:30px"></div><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="tesvalidaarqueo.php">
		<table class="table" width="280" border="0" cellspacing="2" cellpadding="0">
          <tr class="tr">
            <td width="30">Id
            <input name="txtCodCaja" type="hidden" id="txtCodCaja" value="<?php echo $_GET['Codigo']; ?>" /></td>
            <td width="70" align="right">Monto&nbsp;&nbsp;&nbsp;</td>
            <td width="70">Cantidad</td>
            <td align="right">SubTotal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <?php 
		  $i=0;
		  do { 
		  ?>
          <tr>
            <td width="30"><?php echo $row_rsMontos['CodMonto']; ?></td>
            <td width="70" align="right"><strong><?php echo $row_rsMontos['Monto']; ?>
              <input name="txtMonto[]" type="hidden" id="txtMonto[]" value="<?php echo $row_rsMontos['Monto']; ?>" />
              &nbsp;&nbsp;&nbsp;</strong></td>
            <td width="70"><label>
              <input name="txtCantidad[<?= $i; ?>]" id="txtCantidad[<?= $i; ?>]" style="width:50px; text-align:right; padding-right:5px" value="" maxlength="4" wdg:negatives="no" wdg:subtype="NumericInput" wdg:type="widget" wdg:floats="yes" wdg:spinner="no" />
            </label></td>
            <td align="right"><label>
              <input name="txtSubTotal[]" type="text" id="txtSubTotal[]" maxlength="7" style="width:70px" disabled="disabled"/>
            </label></td>
          </tr>
            <?php  
			$i++;
			} while ($row_rsMontos = mysql_fetch_assoc($rsMontos)); 
			?>
		  <tr class="tr">
            <td width="30">
            
            <td width="70">&nbsp;</td>
            <td width="70">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>	
        </table>
		<div style="width:280px; height:10px"></div>
		<div style="width:278px; text-align:right">
			<input type="submit" name="Submit" value="Grabar" />
			<!--<input type="button" name="Submit" value="Grabar" 
			onclick="document.form1.action='validaarqueo.php'; document.form1.submit()"; />-->
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
mysql_free_result($rsMontos);
?>
<script language="javascript">
function multiplica(var i) {
	
	/*var Monto=document.getElementById("txtMonto").value;
	var Cantidad=document.getElementById("txtCantidad").value;
	txtSubTotal
	document.getElementById("txtSubTotal").value=Monto*Cantidad;*/
	
	/*var Monto = document.form1.txtMonto[0].value;
	var Cantidad = document.form1.txtCantidad[0].value;
	document.form1.txtSubTotal[0].value=Monto*Cantidad;*/
	//document.write(Monto*Cantidad);
	
	a=document.form1;
	a.txtSubTotal[i].value=parseInt(a.txtMonto[i].value)+parseInt(a.txtCantidad[i].value);

}
</script>