<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php include('funciones.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsConcepto = "SELECT CodProducto as Id, CodTipoProducto, NombreProducto as Producto, Precio-Descuento AS Precio, Descuento as Dscto FROM productos where Estado=1 ORDER BY NombreProducto ASC";
$rsConcepto = mysql_query($query_rsConcepto, $cn) or die(mysql_error());
$row_rsConcepto = mysql_fetch_assoc($rsConcepto);
$totalRows_rsConcepto = mysql_num_rows($rsConcepto);

mysql_select_db($database_cn, $cn);
$query_rsCredito = "SELECT a.CodCuentaCorriente, b.CodDetalleCuentaCorriente as Id, c.CodProducto, c.NombreProducto as Producto, b.MontoPagar-b.MontoPagado-b.Descuento as Pagar, b.Descuento as Dscto FROM cuentacorriente a INNER JOIN detallecuentacorriente b ON b.CodCuentaCorriente=a.CodCuentaCorriente INNER JOIN productos c ON c.CodProducto=b.CodProducto WHERE a.Estado=1 AND b.Estado=1 and b.MontoPagar>b.MontoPagado+b.Descuento AND a.CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
$rsCredito = mysql_query($query_rsCredito, $cn) or die(mysql_error());
$row_rsCredito = mysql_fetch_assoc($rsCredito);
$totalRows_rsCredito = mysql_num_rows($rsCredito);

mysql_select_db($database_cn, $cn);
$query_rsPension = "SELECT a.CodProgramacionAlumno as Id, b.NombreAnio, c.NombreGrado, a.NroPension as Item, a.Monto, a.Mora, a.Pagado, a.Monto+a.Mora-a.Pagado as Total  FROM programacionalumno a INNER JOIN anio b ON b.CodAnio=a.CodAnio INNER JOIN grado c ON c.CodGrado=a.CodGrado WHERE a.CodAlumno='".$_SESSION['CajaCodAlumno']."' AND a.Estado=1 AND a.Monto+a.Mora>a.Pagado ";
////$query_rsPension.= "AND DATE_FORMAT(a.FechaTermino,'%d/%m/%Y')<DATE_FORMAT(now(),'%d/%m/%Y') ";
//$query_rsPension.= "AND a.FechaTermino<now() ";
$query_rsPension.= "order by a.FechaTermino ";
$rsPension = mysql_query($query_rsPension, $cn) or die(mysql_error());
$row_rsPension = mysql_fetch_assoc($rsPension);
$totalRows_rsPension = mysql_num_rows($rsPension);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gesti�n Escolar</title>
<link href="../includes/jaxon/widgets/tabset/css/tabset.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/tabset/js/tabset.js"></script>
<link href="../styleadm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div style="height:5px"></div>
<div id="Concepto" class="tabset htmlrendering" style="width:253px;height:420px;">
  <ul class="tabset_tabs">
    <li id="Conceptotab0-tab" class="tab selected"><a href="#">Pensiones</a></li>
	<li id="Conceptotab1-tab" class="tab"><a href="#">Cr&eacute;dito</a></li>
	<li id="Conceptotab2-tab" class="tab"><a href="#">Conceptos</a></li>
  </ul>
  <div id="Conceptotab2-body" class="tabBody">
    <div class="tabContent">
	 <table class="table" width="<? if($totalRows_rsConcepto>20){ echo 228;}else{ echo 240; } ?>" border="0" cellspacing="2" cellpadding="0">
       <tr class="tr">
         <td>Concepto</td>
         <td width="45"><div align="right">Costo</div></td>
       </tr>
       <?php 
	   if(!empty($totalRows_rsConcepto)){
	   do { 
	   ?>
         <? Filas();?>
           <td><a href="facproceso.php?Id=<?php echo $row_rsConcepto['Id']; ?>&&Tipo=Concepto" title="<?php echo $row_rsConcepto['Producto']; ?>"><?php echo $row_rsConcepto['Producto']; ?></a></td>
           <td width="45"><div align="right"><?php echo $row_rsConcepto['Precio']; ?></div></td>
         </tr>
         <?php 
		 } while ($row_rsConcepto = mysql_fetch_assoc($rsConcepto)); 
		 }
		 ?>
     </table> 
	</div>
  </div>
  <div id="Conceptotab1-body" class="tabBody">
    <div class="tabContent"> 
      <table class="table" width="240" border="0" cellspacing="2" cellpadding="0">
        <tr class="tr">
          <td width="20">Id</td>
          <td>Concepto</td>
          <td width="45">Costo</td>
        </tr>
        <?php 
		if(!empty($totalRows_rsCredito)){
		do { 
		?>
          <? Filas();?>
            <td width="20"><?php echo $row_rsCredito['Id']; ?></td>
            <td><a href="facproceso.php?Id=<?php echo $row_rsCredito['Id']; ?>&&Tipo=Credito" title="<?php $row_rsCredito['Producto']; ?>"><?php echo $row_rsCredito['Producto']; ?></a></td>
            <td width="45"><?php echo $row_rsCredito['Pagar']; ?></td>
          </tr>
          <?php 
		  } while ($row_rsCredito = mysql_fetch_assoc($rsCredito)); 
		  }
		  ?>
      </table>
      <p>&nbsp;</p>
    </div>
  </div>
  <div id="Conceptotab0-body" class="tabBody body_active">
    <div class="tabContent">
      <table class="table" width="240" border="0" cellspacing="2" cellpadding="0">
        <tr class="tr">
          <td width="55">Pension</td>
          <td width="50"><div align="right">Pagar</div></td>
          <td width="35"><div align="right">Mora</div></td>
          <td width="50"><div align="right">Pagado</div></td>
          <td width="50"><div align="right">Total</div></td>
        </tr>
        <?php 
		if(!empty($totalRows_rsPension)){
		do { 
		?>
          <? Filas();?>
            <td width="55"><a href="facproceso.php?Id=<?php echo $row_rsPension['Id']; ?>&&Tipo=Pension" title="<?php echo "Pension - ".$row_rsPension['Item']; ?>"><?php echo 'Pen - '.$row_rsPension['Item']; ?></a></td>
            <td width="50" align="right"><?php echo $row_rsPension['Monto']; ?></td>
            <td width="35"  align="right"><?php echo $row_rsPension['Mora']; ?></td>
            <td width="50"  align="right"><?php echo $row_rsPension['Pagado']; ?></td>
            <td width="50" align="right"><?php echo $row_rsPension['Total']; ?></td>
          </tr>
          <?php 
		  } while ($row_rsPension = mysql_fetch_assoc($rsPension)); 
		  }
		  ?>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
	var Concepto = new Widgets.Tabset('Concepto', null);
</script>
</body>
</html>
<?php
mysql_free_result($rsConcepto);

mysql_free_result($rsCredito);

mysql_free_result($rsPension);
?>
