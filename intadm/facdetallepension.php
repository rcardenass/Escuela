<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php include('../funciones.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsPension ="SELECT b.NombreAnio, concat(e.NombreNivel,' ',c.NombreGrado) as NombreGrado, d.NombreSeccion, a.Aprobar FROM pensiones a INNER JOIN anio b ON b.CodAnio=a.CodAnio INNER JOIN grado c ON c.CodGrado=a.CodGrado INNER JOIN seccion d ON d.CodSeccion=a.CodSeccion inner join nivel e on e.CodNivel=c.CodNivel WHERE a.CodPension='".$_GET['Codigo']."' ";
$rsPension = mysql_query($query_rsPension, $cn) or die(mysql_error());
$row_rsPension = mysql_fetch_assoc($rsPension);
$totalRows_rsPension = mysql_num_rows($rsPension);

mysql_select_db($database_cn, $cn);
$query_rsDetallePension = "SELECT CodDetallePension, CodPension, NroPension, Monto, DATE_FORMAT(FechaInicio,'%d/%m/%Y') as FechaInicio, DATE_FORMAT(FechaTermino,'%d/%m/%Y') as FechaTermino, Estado FROM detallepension WHERE CodPension = '".$_GET['Codigo']."' ORDER BY NroPension ASC ";
$rsDetallePension = mysql_query($query_rsDetallePension, $cn) or die(mysql_error());
$row_rsDetallePension = mysql_fetch_assoc($rsDetallePension);
$totalRows_rsDetallePension = mysql_num_rows($rsDetallePension);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestion Escolar</title>
<link href="../styleadm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="450" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><span class="label">A&ntilde;o: </span></td>
    <td><?php echo $row_rsPension['NombreAnio']; ?></td>
    <td><span class="label">Grado: </span></td>
    <td><?php echo $row_rsPension['NombreGrado']; ?></td>
    <td><span class="label">Secci&oacute;n: </span></td>
    <td><?php echo $row_rsPension['NombreSeccion']; ?></td>
  </tr>
</table>
<br/>
<table class="table" width="500" border="0" cellspacing="1" cellpadding="0">
  <tr class="tr">
      <td width="50"><div style="text-align: right; padding-right: 3px">Id</div></td>
    <td width="30" align="center">Nro</td>
    <td>Monto</td>
    <td>Desde</td>
    <td>Hasta</td>
    <td width="30">&nbsp;</td>
  </tr>
  <?php do { ?>
    <? Filas();?>
      <td width="50"><div style="text-align: right; padding-right: 3px"><?php echo $row_rsDetallePension['CodDetallePension']; ?></div></td>
      <td width="30" align="center"><strong><?php echo $row_rsDetallePension['NroPension']; ?></strong></td>
      <td><?php echo $row_rsDetallePension['Monto']; ?></td>
      <td><span style="color:#003399"><?php echo $row_rsDetallePension['FechaInicio']; ?></span></td>
      <td><span style="color:#FF0000"><?php echo $row_rsDetallePension['FechaTermino']; ?></span></td>
      <td width="30" align="center">
	   <?php if($row_rsPension['Aprobar']==0){ ?>
	  <a href="faceditdetallepension.php?Id=<?php echo $row_rsDetallePension['CodDetallePension']; ?>&&Codigo=<?php echo $_GET['Codigo']; ?>"><img src="../imagenes/icono/config.png" width="22" height="22" border="0" title="Configurar Programa <?php echo $row_rsDetallePension['NroPension']; ?>"/></a>
	  <?php }else{ ?>
	  <img src="../imagenes/icono/checkin2.png" width="22" height="22" border="0" title="Programaci�n Aprobada"/>
	  <?php } ?>
	  </td>
    </tr>
    <?php } while ($row_rsDetallePension = mysql_fetch_assoc($rsDetallePension)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsDetallePension);

mysql_free_result($rsPension);
?>
