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

mysql_select_db($database_cn, $cn);
$query_rsMontos = "SELECT CodMonto, Monto FROM montos ORDER BY CodMonto ASC";
$rsMontos = mysql_query($query_rsMontos, $cn) or die(mysql_error());
$row_rsMontos = mysql_fetch_assoc($rsMontos);
$totalRows_rsMontos = mysql_num_rows($rsMontos);

$rsCaja=$objDatos->ObtenerCodigoCajaSelId($_SESSION['MM_Username']);
$row_Caja=$objDatos->PoblarCodigoCajaSelId($rsCaja);

mysql_select_db($database_cn, $cn);
/*$query_rsVentas = "SELECT a.CodAlumno, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno, SUM(c.SubTotal) AS Subtotal FROM alumno a INNER JOIN comprobante b ON b.CodAlumno=a.CodAlumno INNER JOIN detallecomprobante c ON c.CodComprobante=b.CodComprobante WHERE b.UsuarioCreacion='".$_SESSION['MM_Username']."' and b.CodCaja='".$row_Caja['CodCaja']."' AND DATE_FORMAT(b.FechaCreacion,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y') GROUP by a.CodAlumno, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres)";*/
$query_rsVentas = "SELECT b.CodAlumno, CASE b.TipoModulo WHEN 0 THEN concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) WHEN 1 THEN concat('*',rtrim(d.Nombres)) END AS Alumno, SUM(c.SubTotal) AS Subtotal FROM alumno a RIGHT JOIN comprobante b ON b.CodAlumno=a.CodAlumno AND TipoModulo=0 INNER JOIN detallecomprobante c ON c.CodComprobante=b.CodComprobante LEFT JOIN cliente d ON d.CodCliente=b.CodAlumno AND b.TipoModulo=1 WHERE b.UsuarioCreacion='".$_SESSION['MM_Username']."' AND b.CodCaja=".$row_Caja['CodCaja']." AND DATE_FORMAT(b.FechaCreacion,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y') GROUP by b.CodAlumno, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) ";
$rsVentas = mysql_query($query_rsVentas, $cn) or die(mysql_error());
$row_rsVentas = mysql_fetch_assoc($rsVentas);
$totalRows_rsVentas = mysql_num_rows($rsVentas);

$rsCaja=$objDatos->ObtenerCodigoCajaSelId($_SESSION['MM_Username']);
$row_Caja=$objDatos->PoblarCodigoCajaSelId($rsCaja);
$totalRows_Caja=mysql_num_rows($rsCaja);

$a=$_POST['txtCantidad'];
$x=0;
foreach($a as $Cantidad){
	if(empty($Cantidad)){
		$A[$x]=0;
	}else{
		$A[$x]=$Cantidad;
	}
	//echo $x."= ".$A[$x]."<br>";
	$x++;
}
?>
<?
$Egreso=0;
if($totalRows_Caja>0){
    $rsMontoEgreso=$objDatos->ObtenerMontoEgresoSelId($row_Caja['CodCaja'],$_SESSION['MM_Username']);
    $row_MontoEgreso=$objDatos->PoblarMontoEgresoSelId($rsMontoEgreso);
    $Egreso=$row_MontoEgreso['Monto'];
}
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
		<!--<h1>Arqueo de Caja</h1><hr /><br />-->
		<h1>
		<div style="width:100%">
			<div style="width:300px; height:auto; float:left; padding-top:20px">Verificaci&oacute;n de Arqueo de Caja</div>
			<div style="width:100px; height:auto; float:right; text-align:right">
				<a href="tescaja.php"><img src="../imagenes/icono/revert.png" border="0" title="Ir a Caja"/></a>
			</div>
		</div>
	    </h1><div style="height:30px"></div><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="">
		<div style="width:600px">
			<div style="width:300px; float:left">
			<!--<form id="form1" name="form1" method="post" autocomplete="Off" action="">-->
				<table class="table" width="280" border="0" cellspacing="2" cellpadding="0">
				  <tr class="tr">
					<td width="30">Id
				    <input name="txtCodCaja" type="hidden" id="txtCodCaja" value="<?php echo $_POST['txtCodCaja']; ?>"/></td>
					<td width="70" align="right">Monto&nbsp;&nbsp;&nbsp;</td>
					<td width="70">Cantidad</td>
					<td align="right">SubTotal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				  </tr>
				  <?php 
				  $i=0; $Sum=0;
				  do { 
				  ?>
				  <tr>
					<td width="30"><?php echo $row_rsMontos['CodMonto']; ?>
				    <input name="txtCodMonto[]" type="hidden" id="txtCodMonto[]" value="<?php echo $row_rsMontos['CodMonto']; ?>" /></td>
					<td width="70" align="right"><strong><?php echo $row_rsMontos['Monto']; ?>
					  <input name="txtMonto[]" type="hidden" id="txtMonto[]" value="<?php echo $row_rsMontos['Monto']; ?>" />
					  &nbsp;&nbsp;&nbsp;</strong></td>
					<td width="70">
					  <input name="txtCantidad[]" type="text" id="txtCantidad[]" 
					  style="width:50px; text-align:right; padding-right:5px" maxlength="4" 
					  value="<?php echo $A[$i]; ?>" readonly="true"/>
					</td>
					<td align="right">
					  <input name="txtSubTotal[]" type="text" id="txtSubTotal[]" maxlength="7" 
					  style="width:70px; text-align:right; padding-right:5px" 
					  value="<? echo number_format($row_rsMontos['Monto']*$A[$i],2,".",""); ?>" readonly="true"/>
					</td>
				  </tr>
					<?php  
					$Sum=$Sum+$row_rsMontos['Monto']*$A[$i];
					$i++; 
					} while ($row_rsMontos = mysql_fetch_assoc($rsMontos)); 
					?>
				  <tr class="tr">
					<td width="30">&nbsp;</td>
					<td width="70" align="right">&nbsp;&nbsp;&nbsp;</td>
					<td width="70">&nbsp;</td>
					<td align="right"><? echo number_format($Sum,2,".",""); ?>&nbsp;&nbsp;</td>
				  </tr>
				</table>
			<!--</form>-->
			</div>
			<div style="width:300px; float:right; background:#FF99CC">
				  <table class="table" width="400" border="0" cellspacing="2" cellpadding="0">
                    <tr class="tr">
                        <td width="40"><div style="text-align: right; padding-right: 5px">Id</div></td>
                      <td>Alumno</td>
                      <td width="60" align="right"><div style="padding-right:5px">Total</div></td>
                    </tr>
                    <?php 
					$Venta=0;
					do { 
					?>
                    <tr>
                      <td width="40"><div style="text-align: right; padding-right: 5px"><?php echo $row_rsVentas['CodAlumno']; ?></div></td>
                      <td><?php echo $row_rsVentas['Alumno']; ?></td>
                      <td width="60" align="right"><div style="padding-right:5px"><?php echo $row_rsVentas['Subtotal']; ?></div></td>
                    </tr>
                    <?php 
					$Venta=$Venta+$row_rsVentas['Subtotal'];
					} while ($row_rsVentas = mysql_fetch_assoc($rsVentas)); 
					?>
					<tr class="tr">
                      <td width="30">&nbsp;</td>
                      <td>&nbsp;</td>
                      <td width="60" align="right"><div style="padding-right:5px"><? echo number_format($Venta-$Egreso,2,".",""); ?></div></td>
                    </tr>
                  </table>
			</div>
		</div>
		<div style="width:300px; height:295px"></div>
		<div style="width:278px; text-align:right">
                    
			<? //if($Sum>0){ ?>
				<? if(number_format($Sum,2,".","")==number_format($Venta-$Egreso,2,".","")){ ?>
				<input type="button" name="Submit" value="Grabar" onclick="document.form1.action='tesinsertarqueo.php'; document.form1.submit()"; />
				<? }else{ ?>
					El efectivo no coincide con las ventas
				<? } ?>
			<? //}else{ ?>
				<!--<script>
					location.href="arqueo.php";
				</script>-->
			<? //} ?>
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

mysql_free_result($rsVentas);
?>
<script language="javascript">
function multiplica(var i) {
	a=document.form1;
	a.txtSubTotal[i].value=parseInt(a.txtMonto[i].value)+parseInt(a.txtCantidad[i].value);

}
</script>