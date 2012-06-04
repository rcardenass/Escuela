<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php include('../funciones.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
if(!isset($_SESSION['TesoreriaCodAlumno'])){
	$_SESSION['TesoreriaCodAlumno']=$_GET['Codigo'];
}

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

mysql_select_db($database_cn, $cn);
$query_rsCredito = "SELECT a.CodCuentaCorriente, b.CodDetalleCuentaCorriente, c.CodProducto as Id, c.NombreProducto as Producto, b.MontoPagar as Pagar, b.MontoPagado as Pagado, b.Descuento as Dscto, DATE_FORMAT(b.FechaCreacion,'%d/%m/%Y') as FechaCreacion FROM cuentacorriente a INNER JOIN detallecuentacorriente b ON b.CodCuentaCorriente=a.CodCuentaCorriente INNER JOIN productos c ON c.CodProducto=b.CodProducto WHERE a.Estado=1 AND b.Estado=1 AND b.MontoPagar>b.MontoPagado+b.Descuento AND a.CodAlumno='".$_GET['Codigo']."' ";
$rsCredito = mysql_query($query_rsCredito, $cn) or die(mysql_error());
$row_rsCredito = mysql_fetch_assoc($rsCredito);
$totalRows_rsCredito = mysql_num_rows($rsCredito);

mysql_select_db($database_cn, $cn);
$query_rsPension = "SELECT a.CodProgramacionAlumno as Id, b.NombreAnio, c.NombreGrado, a.NroPension as Item, a.Monto, a.Mora, a.Pagado, a.Monto+a.Mora-a.Pagado as Total, DATE_FORMAT(a.FechaTermino,'%d/%m/%Y') as FechaTermino FROM programacionalumno a INNER JOIN anio b ON b.CodAnio=a.CodAnio INNER JOIN grado c ON c.CodGrado=a.CodGrado WHERE a.CodAlumno='".$_GET['Codigo']."' AND a.Estado=1 AND a.Monto+a.Mora>a.Pagado ";
//$query_rsPension.= "AND DATE_FORMAT(a.FechaTermino,'%d/%m/%Y')<DATE_FORMAT(now(),'%d/%m/%Y')";
$query_rsPension.= "and a.FechaTermino<now() ";
$query_rsPension.= "order by a.FechaTermino ";
$rsPension = mysql_query($query_rsPension, $cn) or die(mysql_error());
$row_rsPension = mysql_fetch_assoc($rsPension);
$totalRows_rsPension = mysql_num_rows($rsPension);

mysql_select_db($database_cn, $cn);
$query_rsDetallePension = "SELECT a.CodProgramacionAlumno AS Id, b.NombreAnio AS Anio, c.NombreGrado AS Grado, a.NroPension, a.Monto, a.Mora, a.Pagado, DATE_FORMAT(a.FechaInicio,'%d/%m/%Y') AS FechaInicio, DATE_FORMAT(a.FechaTermino,'%d/%m/%Y') AS FechaTermino, DATE_FORMAT(a.FechaModificacion,'%d/%m/%Y') as FechaModificacion FROM programacionalumno a INNER JOIN anio b ON b.CodAnio=a.CodAnio INNER JOIN grado c ON c.CodGrado=a.CodGrado WHERE a.CodAlumno='".$_GET['Codigo']."' AND a.Estado=1 order by b.NombreAnio, a.NroPension ";
$rsDetallePension = mysql_query($query_rsDetallePension, $cn) or die(mysql_error());
$row_rsDetallePension = mysql_fetch_assoc($rsDetallePension);
$totalRows_rsDetallePension = mysql_num_rows($rsDetallePension);

mysql_select_db($database_cn, $cn);
$query_rsCredito2 = "SELECT a.CodCuentaCorriente, b.CodDetalleCuentaCorriente, c.CodProducto as Id, c.NombreProducto as Producto, b.MontoPagar as Pagar, b.MontoPagado as Pagado, b.Descuento as Dscto, DATE_FORMAT(b.FechaCreacion,'%d/%m/%Y') as FechaCreacion FROM cuentacorriente a INNER JOIN detallecuentacorriente b ON b.CodCuentaCorriente=a.CodCuentaCorriente INNER JOIN productos c ON c.CodProducto=b.CodProducto WHERE a.Estado=1 AND b.Estado=1 AND b.MontoPagar>b.MontoPagado+b.Descuento AND a.CodAlumno='".$_GET['Codigo']."' ";
$rsCredito2 = mysql_query($query_rsCredito2, $cn) or die(mysql_error());
$row_rsCredito2 = mysql_fetch_assoc($rsCredito2);
$totalRows_rsCredito2 = mysql_num_rows($rsCredito2);
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
<link href="../includes/jaxon/widgets/tabset/css/tabset.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/tabset/js/tabset.js"></script>
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
		<h1>
		<div style="width:100%">
			<div style="width:300px; height:auto; float:left; padding-top:20px">Compromisos</div>
			<div style="width:100px; height:auto; float:right; text-align:right"><a href="tesalucompromiso.php"><img src="../imagenes/icono/revert.png" border="0" title="Busca otro Alumno"/></a></div>
		</div>
		 </h1><div style="height:30px"></div><hr /><br />
		 
		 <iframe name="Cabecera" id="Cabecera" src="tescabecera.php" width="650px" height="100px" marginheight="0" marginwidth="3" frameborder="0" scrolling="no"></iframe><br /><br />
		 
<div id="Compromiso" class="tabset htmlrendering" style="width:700px;height:430px;">
  <ul class="tabset_tabs">
      <li id="Compromisotab0-tab" class="tab selected"><a href="#">&nbsp;Resumen&nbsp;&nbsp;</a></li>
    <li id="Compromisotab1-tab" class="tab"><a href="#">&nbsp;Pensiones&nbsp;&nbsp;</a></li>
    <li id="Compromisotab2-tab" class="tab"><a href="#">&nbsp;Deudas&nbsp;&nbsp;</a></li>
  </ul>
  <div id="Compromisotab0-body" class="tabBody body_active">
    <div class="tabContent">
      <table class="table" width="500" border="0" cellspacing="2" cellpadding="0">
        <tr class="tr">
          <td width="50"><div style="float:right; padding-right:7px">Id</div></td>
          <td>Concepto</td>
          <td width="60"><div style="float:right; padding-right:10px">Costo</div></td>
          <td width="80">Fecha Venta</td>
        </tr>
        <?php 
			if(!empty($totalRows_rsCredito)){
			do { 
			?>
        <? Filas();?>
          <td width="50"><div style="float:right; padding-right:7px"><?php echo $row_rsCredito['Id']; ?></div></td>
          <td><?php echo $row_rsCredito['Producto']; ?></td>
          <td width="60"><div style="float:right; padding-right:10px"><?php echo $row_rsCredito['Pagar']; ?></div></td>
          <td width="75"><?php echo $row_rsCredito['FechaCreacion']; ?></td>
        </tr>
        <?php 
			  } while ($row_rsCredito = mysql_fetch_assoc($rsCredito)); 
			  }
			  ?>
      </table>
      <br /> 
	  	 <table class="table" width="500" border="0" cellspacing="2" cellpadding="0">
        <tr class="tr">
          <td>Pension</td>
          <td width="60"><div align="right">Pagar</div></td>
          <td width="50"><div align="right">Mora</div></td>
          <td width="60"><div align="right">Pagado</div></td>
          <td width="60"><div align="right">Total</div></td>
          <td width="80" align="center">Vence</td>
        </tr>
        <?php 
		if(!empty($totalRows_rsPension)){
		do { 
		?>
          <? Filas();?>
            <td><?php echo 'Pen. - '.$row_rsPension['Item']; ?></td>
            <td width="60" align="right"><?php echo $row_rsPension['Monto']; ?></td>
            <td width="50"  align="right"><?php echo $row_rsPension['Mora']; ?></td>
            <td width="60"  align="right"><?php echo $row_rsPension['Pagado']; ?></td>
            <td width="60" align="right"><?php echo $row_rsPension['Total']; ?></td>
            <td width="80" align="center"><?php echo $row_rsPension['FechaTermino']; ?></td>
          </tr>
          <?php 
		  } while ($row_rsPension = mysql_fetch_assoc($rsPension)); 
		  }else{
		  ?>
		  <tr>
            <td colspan="6" align="center">No existen pensiones vencidas</td>
          </tr>
		  <? } ?>
      </table>
	</div>
  </div>
  <div id="Compromisotab1-body" class="tabBody">
    <div class="tabContent"> 
	<table class="table" width="690" border="0" cellspacing="2" cellpadding="0">
      <tr class="tr">
        <td width="50"><div style="float:right; padding-right:7px">Id</div></td>
        <td width="40" align="center">A&ntilde;o</td>
        <td>Grado</td>
        <td width="30" align="center">Nro</td>
        <td width="60"><div style="float:right; padding-right:5px">Monto</div></td>
        <td width="60"><div style="float:right; padding-right:5px">Mora</div></td>
        <td width="60"><div style="float:right; padding-right:5px">Pagado</div></td>
        <td width="80" align="center">Desde</td>
        <td width="80" align="center">Hasta</td>
        <td width="90" align="center">Fecha Pago</td>
        <td></td>
      </tr>
      <?php do { ?>
        <? Filas();?>
          <td width="50"><div style="float:right; padding-right:7px"><?php echo $row_rsDetallePension['Id']; ?></div></td>
          <td width="40" align="center"><?php echo $row_rsDetallePension['Anio']; ?></td>
          <td><?php echo $row_rsDetallePension['Grado']; ?></td>
          <td width="30" align="center"><strong><?php echo $row_rsDetallePension['NroPension']; ?></strong></td>
          <td width="60"><div style="float:right; padding-right:5px"><?php echo $row_rsDetallePension['Monto']; ?></div></td>
          <td width="60"><div style="float:right; padding-right:5px"><?php echo $row_rsDetallePension['Mora']; ?></div></td>
          <td width="60"><div style="float:right; padding-right:5px"><?php echo $row_rsDetallePension['Pagado']; ?></div></td>
          <td width="80" align="center"><?php echo $row_rsDetallePension['FechaInicio']; ?></td>
          <td width="80" align="center"><?php echo $row_rsDetallePension['FechaTermino']; ?></td>
          <td width="90" align="center"><?php echo $row_rsDetallePension['FechaModificacion']; ?></td>
          <td align="center">
              <? if($row_rsDetallePension['Monto']+$row_rsDetallePension['Mora']==$row_rsDetallePension['Pagado']){ ?>
			<img src="../imagenes/icono/deny.png" border="0" width="22" title="No es posible modificar pensi�n"/>
			<? }else{ ?>
			<a href="teseditpension.php?Id=<?php echo $row_rsDetallePension['Id']; ?>" title="Modificar pensi&oacute;n"><img src="../imagenes/icono/edit.png" border="0" width="22"/></a>
			<? } ?>
          </td>
        </tr>
        <?php } while ($row_rsDetallePension = mysql_fetch_assoc($rsDetallePension)); ?>
    </table>
	</div>
  </div>
  <div id="Compromisotab2-body" class="tabBody">
    <div class="tabContent">
		<table class="table" width="500" border="0" cellspacing="2" cellpadding="0">
			<tr class="tr">
			  <td width="50"><div style="float:right; padding-right:7px">Id</div></td>
			  <td>Concepto</td>
			  <td width="70"><div style="float:right; padding-right:10px">Costo</div></td>
			  <td width="80">Fecha Venta</td>
			</tr>
			<?php 
			if(!empty($totalRows_rsCredito2)){
			do { 
			?>
			  <tr>
				<td width="50"><div style="float:right; padding-right:7px"><?php echo $row_rsCredito2['Id']; ?></div></td>
				<td><?php echo $row_rsCredito2['Producto']; ?></td>
				<td width="70"><div style="float:right; padding-right:10px"><?php echo $row_rsCredito2['Pagar']; ?></div></td>
				<td width="80"><?php echo $row_rsCredito2['FechaCreacion']; ?></td>
			  </tr>
			  <?php 
			  } while ($row_rsCredito2 = mysql_fetch_assoc($rsCredito2)); 
			  }
			  ?>
		  </table>
	</div>
  </div>
</div>
<script type="text/javascript">
	var Compromiso = new Widgets.Tabset('Compromiso', null);
</script>
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
mysql_free_result($rsCredito);
mysql_free_result($rsPension);
mysql_free_result($rsDetallePension);
mysql_free_result($rsCredito2);
?>
