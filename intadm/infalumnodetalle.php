<?php include("../seguridad.php");?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$rsGeneral=$objDatos->ObtenerDetalleGeneralPagosSelAll($_GET['Codigo']);
$row_rsGeneral = $objDatos->PoblarDetalleGeneralPagosSelAll($rsGeneral);
$totalRows_rsGeneral = mysql_num_rows($rsGeneral);
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
		<h1>
		<div style="width:100%">
			<div style="width:300px; height:auto; float:left; padding-top:20px">Informe Detalle de Alumno</div>
			<div style="width:100px; height:auto; float:right; text-align:right">
				<a href="infalumno.php"><img src="../imagenes/icono/revert.png" border="0" title="Busca otro Alumno"/></a>
			</div>
		</div>
		 </h1><div style="height:30px"></div><hr /><br />
		 <div style="text-align:right;padding-right:5px"><a href="infalumnogeneral.php?Codigo=<? echo $_GET['Codigo'];?>"><img src="../imagenes/icono/preview.png" width="35" border="0" title="Informe General"/></a></div>
		<table width="700" border="0" cellspacing="2" cellpadding="0" class="table">
		  <tr class="tr">
			<td width="100"><div style="text-align:right;padding-right:10px">Comprobante</div></td>
			<td width="40"><div align="center">Tipo</div></td>
			<td width="80"><div style="text-align:right;padding-right:10px">Total</div></td>
			<td width="50"><div align="center">Caja</div></td>
			<td width="75"><div align="center">Operaci&oacute;n</div></td>
			<td width="80">Fecha</td>
			<td width="80">Hora</td>
			<td><div style="text-align:left;padding-left:10px">Usuario</div></td>
		  </tr>
		  <? if(empty($totalRows_rsGeneral)){ ?>
		  <tr>
			<td colspan="7"><div style="padding-left:5px">No existen datos</div></td>
		  </tr>
		  <? }?>
		  <? if($totalRows_rsGeneral>0){ ?>
		  <? do{?>
		  <tr>
			<td width="100">
			<div style="text-align:right;padding-right:10px">
			<? echo $row_rsGeneral['CodComprobante']; ?>			</div>			</td>
			<td width="40"><div align="center"><? echo $row_rsGeneral['CodTipoComprobante']; ?></div></td>
			<td width="80"><div style="text-align:right;padding-right:10px"><? echo $row_rsGeneral['SubTotal']; ?></div></td>
			<td width="50"><div align="center"><? echo $row_rsGeneral['CodCaja']; ?></div></td>
			<td width="75"><div align="center">
			  <blockquote>
			    <p><? echo $row_rsGeneral['CodOperacion']; ?></p>
			    </blockquote>
			</div></td>
			<td width="80"><? echo $row_rsGeneral['FechaCreacion']; ?></td>
			<td width="80"><? echo $row_rsGeneral['Hora']; ?></td>
			<td>
			<div style="text-align:left;padding-left:10px">
			    <? echo $row_rsGeneral['UsuarioCreacion']; ?>			</div>			</td>
		  </tr>
		  <tr>
			<td width="100">&nbsp;</td>
			<td width="40">&nbsp;</td>
			<td width="80">&nbsp;</td>
			<td colspan="5">
				<?
            	$rsDetalle=$objDatos->ObtenerDetalleBoletaSelAll($row_rsGeneral['CodComprobante']);
                $rowDetalle=$objDatos->PoblarDetalleBoletaSelAll($rsDetalle);
                $totalRows_rsDetalle = mysql_num_rows($rsDetalle);
                ?>
				<div style="height:3px"></div>
				<div style="padding-left:50px">
					<table class="table" width="98%" border="0" cellspacing="2" cellpadding="0">
						<tr class="tr">
							<td width="35"><div style="text-align: right; padding-right: 3px">Item</div></td>
							<td>Concepto</td>
							<td width="60"><div style="text-align: right; padding-right: 5px">Total</div></td>
							<td width="60"><div style="text-align: right; padding-right: 5px">Saldo</div></td>
						</tr>
                        <?
                        $k=1;
                        if($totalRows_rsDetalle==0){
                        ?>
                        <tr>
                        	<td colspan="4"><div style="text-align:left; padding-left:5px">No existen registros</div></td>
						</tr>
                        <?
                        }
                        ?>
                        <?
                        if($totalRows_rsDetalle>0){
                        do{
                        ?>
						<tr onClick='this.style.background="#F5BB52"' onmouseover='this.style.background="#AED74E"' onmouseout='this.style.background="#ffffff"'>
							<td width="35">
							<div style="text-align: right; padding-right: 3px"><strong><? echo $k;?></strong></div>
							</td>
							<td><? echo $rowDetalle['Concepto'];?></td>
							<td width="60">
							<div style="text-align: right; padding-right: 5px"><? echo $rowDetalle['SubTotal'];?></div>
							</td>
							<td width="60">
							<div style="text-align: right; padding-right: 5px"><? echo $rowDetalle['Saldo'];?></div>
							</td>
						</tr>
                        <?
                        $k++;
                        }while($rowDetalle=$objDatos->PoblarDetalleBoletaSelAll($rsDetalle));
                        }
                        ?>
					</table>
				</div>
				<div style="height:15px"></div>
			</td>
		  </tr>
		  <? 
		  $k=0;
          $i++;
		  }while($row_rsGeneral = $objDatos->PoblarDetalleGeneralPagosSelAll($rsGeneral));
		  ?>
		  <? }?>
		</table>
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
mysql_free_result($rsGeneral);
?>
