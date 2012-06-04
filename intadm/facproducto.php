<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$_SESSION['TipoProducto']=$_POST['cboTipoProducto'];
$_SESSION['Buscar']=$_POST['txtBuscar'];

mysql_select_db($database_cn, $cn);
$query_rsTipoProducto = "SELECT CodTipoProducto, NombreTipoProducto FROM tipoproducto WHERE Estado = 0 ORDER BY NombreTipoProducto ASC";
$rsTipoProducto = mysql_query($query_rsTipoProducto, $cn) or die(mysql_error());
$row_rsTipoProducto = mysql_fetch_assoc($rsTipoProducto);
$totalRows_rsTipoProducto = mysql_num_rows($rsTipoProducto);

mysql_select_db($database_cn, $cn);
/*$query_rsProducto = "SELECT a.CodProducto, a.NombreProducto, a.Precio, a.Descuento, a.Estado FROM productos a INNER JOIN tipoproducto b ON b.CodTipoProducto=a.CodTipoProducto WHERE b.CodTipoProducto='1' AND a.NombreProducto LIKE '%'";*/
$query_rsProducto = "SELECT a.CodProducto, a.NombreProducto, a.Precio, a.Descuento, case a.Estado when 0 then 'Activado' else 'Desactivado' end as Estado ";
$query_rsProducto .="FROM productos a ";
$query_rsProducto .="INNER JOIN tipoproducto b ON b.CodTipoProducto=a.CodTipoProducto ";
$query_rsProducto .="WHERE a.Estado=0 and b.Estado=0 ";
$query_rsProducto .="AND (b.CodTipoProducto='".$_SESSION['TipoProducto']."' or ''='".$_SESSION['TipoProducto']."') ";
$query_rsProducto .="AND a.NombreProducto LIKE '%".$_SESSION['Buscar']."%' ";
$rsProducto = mysql_query($query_rsProducto, $cn) or die(mysql_error());
$row_rsProducto = mysql_fetch_assoc($rsProducto);
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
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
		<h1>Productos</h1><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="facproducto.php">
		  <table width="400" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td><span class="label">Tipo Producto</span></td>
              <td><span class="label">Producto</span></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboTipoProducto" id="cboTipoProducto" style="width:150px">
                  <option value="" <?php if (!(strcmp("", $_SESSION['TipoProducto']))) {echo "selected=\"selected\"";} ?>></option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsTipoProducto['CodTipoProducto']?>"<?php if (!(strcmp($row_rsTipoProducto['CodTipoProducto'], $_SESSION['TipoProducto']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsTipoProducto['NombreTipoProducto']?></option>
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
              <td><label>
                <input name="txtBuscar" type="text" id="txtBuscar" maxlength="50" style="width:170px"/>
              </label></td>
              <td align="right"><label>
                <input type="submit" name="Submit" value="Buscar" />
              </label></td>
            </tr>
          </table>
                <br/>
				<table class="table" width="500" border="0" cellspacing="1" cellpadding="0">
                  <tr class="tr">
                    <td width="50">Id</td>
                    <td>Producto</td>
                    <td width="50">Costo</td>
                    <td width="50">Dscto</td>
                    <td width="100">Estado</td>
                    <td width="30" align="center"><a href="facnewproducto.php"><img src="../imagenes/icono/add.png" width="32" border="0"/></a></td>
                  </tr>
                  <?php 
				  if(!empty($totalRows_rsProducto)){
				  do { 
				  ?>
                  <tr>
                    <td width="50"><?php echo $row_rsProducto['CodProducto']; ?></td>
                    <td><?php echo $row_rsProducto['NombreProducto']; ?></td>
                    <td width="50"><?php echo $row_rsProducto['Precio']; ?></td>
                    <td width="50"><?php echo $row_rsProducto['Descuento']; ?></td>
                    <td width="100"><?php echo $row_rsProducto['Estado']; ?></td>
                    <td width="30" align="center">
					<a href="faceditproducto.php?Codigo=<?php echo $row_rsProducto['CodProducto']; ?>">
					<img src="../imagenes/icono/edit.png" width="22" border="0" title="Editar"/></a>
					</td>
                  </tr>
                    <?php 
					} while ($row_rsProducto = mysql_fetch_assoc($rsProducto)); 
					}
					?>
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

mysql_free_result($rsTipoProducto);

mysql_free_result($rsProducto);
?>
