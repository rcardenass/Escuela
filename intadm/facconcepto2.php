<?php 
include("../seguridad.php");
include('funciones.php');
include("../clases/datos.php");
$objDatos=new datos();

$rsConcepto=$objDatos->ObtenerConceptoSelAll();
$row_Concepto=$objDatos->PoblarConceptoSelAll($rsConcepto);
$totalRows_rsConcepto = mysql_num_rows($rsConcepto);

$rsCredito=$objDatos->ObtenerCreditoSelAll($_SESSION['CajaCodAlumno']);
$row_Credito=$objDatos->PoblarCreditoSelAll($rsCredito);
$totalRows_rsCredito = mysql_num_rows($rsCredito);

$rsPension=$objDatos->ObtenerPensionSelAll($_SESSION['CajaCodAlumno']);
$row_Pension=$objDatos->PoblarPensionSelAll($rsPension);
$totalRows_rsPension = mysql_num_rows($rsPension);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	<li id="Conceptotab1-tab" class="tab"><a href="#">Conceptos</a></li>
  </ul>
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
            <td width="55"><a href="facproceso2.php?Id=<?php echo $row_Pension['Id']; ?>&&Tipo=Pension&&Modulo=0" title="<?php echo "Pension - ".$row_Pension['Item']; ?>"><?php echo 'Pen - '.$row_Pension['Item']; ?></a></td>
            <td width="50" align="right"><?php echo $row_Pension['Monto']; ?></td>
            <td width="35"  align="right"><?php echo $row_Pension['Mora']; ?></td>
            <td width="50"  align="right"><?php echo $row_Pension['Pagado']; ?></td>
            <td width="50" align="right"><?php echo $row_Pension['Total']; ?></td>
          </tr>
          <?php 
		  } while ($row_Pension=$objDatos->PoblarPensionSelAll($rsPension)); 
		  }
		  ?>
      </table>
	  <div style="height:10px"></div>
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
            <td width="20"><?php echo $row_Credito['Id']; ?></td>
            <td><a href="facproceso2.php?Id=<?php echo $row_Credito['Id']; ?>&&Tipo=Credito&&Modulo=0" title="<?php $row_Credito['Producto']; ?>"><?php echo $row_Credito['Producto']; ?></a></td>
            <td width="45"><?php echo $row_Credito['Pagar']; ?></td>
          </tr>
          <?php 
		  } while ($row_Credito=$objDatos->PoblarCreditoSelAll($rsCredito)); 
		  }
		  ?>
      </table>
    </div>
  </div>
  <div id="Conceptotab1-body" class="tabBody">
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
           <td><a href="facproceso2.php?Id=<?php echo $row_Concepto['Id']; ?>&&Tipo=Concepto&&Modulo=0" title="<?php echo $row_Concepto['Producto']; ?>"><?php echo $row_Concepto['Producto']; ?></a></td>
           <td width="45"><div align="right"><?php echo $row_Concepto['Precio']; ?></div></td>
         </tr>
         <?php 
		 } while ($row_Concepto=$objDatos->PoblarConceptoSelAll($rsConcepto)); 
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
