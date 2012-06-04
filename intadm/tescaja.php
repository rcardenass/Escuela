<?php include("../seguridad.php");?>
<?php
$KT_relPath = "../";
  require_once("../includes/widgets/widgets_start.php");
?>
<?php
include('../funciones.php'); 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$_SESSION['Dia']=$_POST['txtDia'];

$rsCaja = $objDatos->ObtenerCajaSelAll($_SESSION['MM_Username'],$_SESSION['Dia']);
$rowCaja = $objDatos->PoblarCajaSelAll($rsCaja);
$totalRows_rsCaja = mysql_num_rows($rsCaja);
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
		<h1>Apertura y Cierre de Caja</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="">
		  <table width="220" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td width="30">D&iacute;a</td>
              <td><input name="txtDia" type="widget" id="txtDia" style="width:80px" title="Por Ejem: <? echo date("d/m/Y"); ?>" value="<?php echo $_SESSION['Dia']; ?>" readonly="true" subtype="wcalendar" format="dd/mm/yyyy" skin="blue" language="es" label=".." mondayfirst="false"/></td>
              <td align="right"><input type="submit" name="Submit" value="Buscar" /></td>
            </tr>
          </table>
		  <br />
          <table class="table" width="650" border="0" cellspacing="1" cellpadding="0">
            <tr class="tr">
              <td width="50"><div style="width:40px; float:right; text-align:right; padding-right:5px">Id</div></td>
              <td>Fecha </td>
              <td>Caja Chica</td>
              <td>Monto Cierre </td>
              <td>Estado</td>
              <td>Usuario</td>
              <td width="35"><a href="tesnewcaja.php"><img src="../imagenes/icono/plugin.png" width="32" border="0"/></a></td>
            </tr>
            <?php 
		  	if(!empty($totalRows_rsCaja)){
				do { 
			?>
            <? Filas();?>
              <td width="50"><div style="width:40px; float:right; text-align:right; padding-right:5px"><strong><?php echo $rowCaja['CodCaja']; ?></strong></div></td>
              <td><?php echo $rowCaja['Fecha']; ?></td>
              <td><?php echo $rowCaja['CajaChica']; ?></td>
              <td><?php echo $rowCaja['MontoCierre']; ?></td>
              <td><?php echo $rowCaja['Estado']; ?></td>
              <td><?php echo $rowCaja['UsuarioCreacion']; ?></td>
              <td width="35">
			  <? if($rowCaja['Estado']=='Abierto'){ ?>
					<a href="tesarqueo.php?Codigo=<?php echo $rowCaja['CodCaja']; ?>">
				  		<img src="../imagenes/icono/module.png" width="22" border="0" title="Cerrar Caja"/>
				  	</a>
			  <? }else{ ?>
			  		<img src="../imagenes/icono/deny.png" width="22" border="0" title="Caja Cerrada"/>
			  <? } ?>
			  </td>
            </tr>
              <?php 
			  } while ($rowCaja = $objDatos->PoblarCajaSelAll($rsCaja)); 
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
  require_once("../includes/widgets/widgets_end.php");
?>
<?php
mysql_free_result($rsTreeview);

mysql_free_result($rsCaja);
?>
<script LANGUAGE="JavaScript">
	function cerrar()
	{
	var agree=confirm("¿Esta Seguro de cerrar el Día?");
	if (agree)
	return true ;
	else
	return false ;
	}
</script>