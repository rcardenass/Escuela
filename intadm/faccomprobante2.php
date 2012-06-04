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

$rsComprobante=$objDatos->ObtenerComprobanteOperacionSelAll($_GET['xyz']);
$row_Comprobante=$objDatos->PoblarComprobanteOperacionSelAll($rsComprobante);
$totalRows_rsComprobante=mysql_num_rows($rsComprobante);

mysql_select_db($database_cn, $cn);
$query_rsCab = "SELECT a.CodAlumno, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno, (SELECT concat(y.Nombregrado,' - ',z.NombreSeccion,' - ',x.NombreAnio) FROM matricula w INNER JOIN anio x ON x.CodAnio=w.CodAnio INNER JOIN grado y ON y.Codgrado=w.Codgrado INNER JOIN seccion z ON z.CodSeccion=w.CodSeccion WHERE w.CodAlumno=a.CodAlumno ORDER BY CodMatricula DESC limit 1) AS Datos FROM alumno a WHERE a.CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
$rsCab = mysql_query($query_rsCab, $cn) or die(mysql_error());
$row_rsCab = mysql_fetch_assoc($rsCab);
$totalRows_rsCab = mysql_num_rows($rsCab);


/*mysql_select_db($database_cn, $cn);
$query_rsDetalle = "SELECT CASE b.Tipo 	WHEN 'Pension' THEN (SELECT concat('Pension - ',x.NroPension) FROM programacionalumno x WHERE x.CodProgramacionAlumno=b.Codigo) 	WHEN 'concepto' THEN (SELECT y.NombreProducto FROM productos y WHERE y.CodProducto=b.Codigo) END AS Concepto, b.Cantidad, b.PrecioUnit, b.Cantidad*b.PrecioUnit AS Monto, b.Dscto, b.Mora, b.SubTotal FROM comprobante a INNER JOIN detallecomprobante b ON b.CodComprobante=a.CodComprobante WHERE a.CodAlumno='".$_SESSION['CajaCodAlumno']."' AND a.CodComprobante='".$_SESSION['CajaCodComprobante']."' ";
$rsDetalle = mysql_query($query_rsDetalle, $cn) or die(mysql_error());
$row_rsDetalle = mysql_fetch_assoc($rsDetalle);
$totalRows_rsDetalle = mysql_num_rows($rsDetalle);*/

mysql_select_db($database_cn, $cn);
$query_rsTotal = "SELECT SUM(b.SubTotal) as Total FROM comprobante a INNER JOIN detallecomprobante b ON b.CodComprobante=a.CodComprobante WHERE a.CodAlumno='".$_SESSION['CajaCodAlumno']."' AND a.CodComprobante='".$_SESSION['CajaCodComprobante']."' ";
$rsTotal = mysql_query($query_rsTotal, $cn) or die(mysql_error());
$row_rsTotal = mysql_fetch_assoc($rsTotal);
$totalRows_rsTotal = mysql_num_rows($rsTotal);
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
		<h1>
		<div style="width:100%">
			<div style="width:300px; height:auto; float:left; padding-top:20px">Comprobante</div>
			<div style="width:100px; height:auto; float:right; text-align:right">
				<a href="facalumno.php"><img src="../imagenes/icono/revert.png" border="0" title="Busca otro Alumno"/></a>
			</div>
		</div>
		 </h1><div style="height:30px"></div><hr /><br />
		<table width="600" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td valign="top">
			<table width="440" border="0" cellspacing="1" cellpadding="0">
              <tr>
                <td width="110">C&oacute;digo</td>
                <td width="284"><?php echo $row_rsCab['CodAlumno']; ?></td>
              </tr>
              <tr>
                <td width="110">Alumno</td>
                <td><?php echo $row_rsCab['Alumno']; ?></td>
              </tr>
              <tr>
                <td width="110">Grado - Secci&oacute;n </td>
                <td><?php echo $row_rsCab['Datos']; ?></td>
              </tr>
            </table></td>
            <td width="150"><img src="../imagenes/icono/levels_add.png" width="150" height="80" /></td>
          </tr>
          <tr>
            <td colspan="2">
			<div style="height:15px"></div>
			<? 
			if($totalRows_rsComprobante>0){ 
				do{
					$rsDetalle=$objDatos->ObtenerComprobantePrintSelAll($_SESSION['CajaCodAlumno'],$row_Comprobante['CodComprobante']);
					$row_Detalle=$objDatos->PoblarComprobantePrintSelAll($rsDetalle);
					
					$rsTotal=$objDatos->ObtenerComprobanteTotalSelId($_SESSION['CajaCodAlumno'],$row_Comprobante['CodComprobante']);
					$row_Total=$objDatos->PoblarComprobanteTotalSelId($rsTotal);
			?>
					<table width="600" border="1" cellspacing="1" cellpadding="0">
					  <tr>
						<td width="35" align="center">Item</td>
						<td>Concepto</td>
						<td width="60">Cantidad</td>
						<td width="70">Precio</td>
						<td width="70">Monto</td>
						<td width="50">Dscto</td>
						<td width="50">Mora</td>
						<td width="80" align="right">Sub-Total</td>
					  </tr>
					  <?php 
					  $i=1;
					  do { 
					  ?>
						<tr>
						  <td width="35" align="center"><?php echo $i; ?></td>
						  <td><?php echo $row_Detalle['Concepto']; ?></td>
						  <td width="60" align="center"><?php echo $row_Detalle['Cantidad']; ?></td>
						  <td width="70" align="right"><?php echo $row_Detalle['PrecioUnit']; ?></td>
						  <td width="70" align="right"><?php echo $row_Detalle['Monto']; ?></td>
						  <td width="50" align="right"><?php echo $row_Detalle['Dscto']; ?></td>
						  <td width="50" align="right"><?php echo $row_Detalle['Mora']; ?></td>
						  <td width="80" align="right"><?php echo $row_Detalle['SubTotal']; ?></td>
						</tr>
						<?php 
						$i++;
						} while ($row_Detalle=$objDatos->PoblarComprobantePrintSelAll($rsDetalle)); 
						?>
					  <tr>
						<td width="35">&nbsp;</td>
						<td>&nbsp;</td>
						<td width="60">&nbsp;</td>
						<td width="70">&nbsp;</td>
						<td width="70">&nbsp;</td>
						<td width="50">&nbsp;</td>
						<td width="50">
						<div style="height:15px"></div>
						Total
						</td>
						<td width="80" align="right">
						<div style="height:15px"></div>
						<?php echo "S/. ".$row_Total['Total']; ?>
						</td>
					  </tr>
					</table>
			<? 
				}while($row_Comprobante=$objDatos->PoblarComprobanteOperacionSelAll($rsComprobante));
			} 
			?>
			</td>
          </tr>
        </table>
		<br />
		<div style="width:600px; text-align:center">
		<a href="facimprimir2.php?Codigo=<?= $_GET['xyz']; ?>" rel="gb_page_center[650, 350]" title="Comprobante"><img src="../imagenes/icono/print.png" border="0" /></a>
		</div>
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
mysql_free_result($rsCab);
mysql_free_result($rsDetalle);
mysql_free_result($rsTotal);
?>
