<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsComprobante=$objDatos->ObtenerComprobanteOperacionSelAll($_GET['Codigo']);
$row_Comprobante=$objDatos->PoblarComprobanteOperacionSelAll($rsComprobante);
$totalRows_rsComprobante=mysql_num_rows($rsComprobante);

mysql_select_db($database_cn, $cn);
//$query_rsCabecera = "SELECT a.CodAlumno, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno, ( SELECT concat(y.Nombregrado,' - ',z.NombreSeccion,' - ',x.NombreAnio) FROM matricula w INNER JOIN anio x ON x.CodAnio=w.CodAnio INNER JOIN grado y ON y.Codgrado=w.Codgrado INNER JOIN seccion z ON z.CodSeccion=w.CodSeccion WHERE w.CodAlumno=a.CodAlumno ORDER BY CodMatricula DESC limit 1 ) AS Datos FROM alumno a WHERE a.codAlumno='".$_SESSION['CajaCodAlumno']."' ";
$query_rsCabecera = "Select CodCliente, Nombres, Direccion, Telefono from cliente where CodCliente=".$_GET['pqr']." ";
$rsCabecera = mysql_query($query_rsCabecera, $cn) or die(mysql_error());
$row_rsCabecera = mysql_fetch_assoc($rsCabecera);
$totalRows_rsCabecera = mysql_num_rows($rsCabecera);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CEP San Agustin</title>
</head>

<body>
<?
do{
	mysql_select_db($database_cn, $cn);
	$query_rsDetalle = "SELECT CASE b.Tipo 	WHEN 'Pension' THEN (SELECT concat('Pension - ',x.NroPension) FROM programacionalumno x WHERE x.CodProgramacionAlumno=b.Codigo) 	WHEN 'concepto' THEN (SELECT y.NombreProducto FROM productos y WHERE y.CodProducto=b.Codigo) END AS Concepto, b.Cantidad, b.PrecioUnit, b.Cantidad*b.PrecioUnit AS Monto, b.Dscto, b.Mora, b.SubTotal FROM comprobante a INNER JOIN detallecomprobante b ON b.CodComprobante=a.CodComprobante WHERE a.CodAlumno=".$_GET['pqr']." AND a.CodComprobante=".$row_Comprobante['CodComprobante']." ";
	$rsDetalle = mysql_query($query_rsDetalle, $cn) or die(mysql_error());
	$row_rsDetalle = mysql_fetch_assoc($rsDetalle);
	$totalRows_rsDetalle = mysql_num_rows($rsDetalle);
	
	mysql_select_db($database_cn, $cn);
	$query_rsTotal = "SELECT SUM(b.SubTotal) as Total FROM comprobante a INNER JOIN detallecomprobante b ON b.CodComprobante=a.CodComprobante WHERE a.CodAlumno=".$_GET['pqr']." AND a.CodComprobante=".$row_Comprobante['CodComprobante']." ";
	$rsTotal = mysql_query($query_rsTotal, $cn) or die(mysql_error());
	$row_rsTotal = mysql_fetch_assoc($rsTotal);
	$totalRows_rsTotal = mysql_num_rows($rsTotal);
?>
<table width="600" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td valign="top"><table width="440" border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="110">C&oacute;digo</td>
        <td width="284"><?php echo $row_rsCabecera['CodCliente']; ?></td>
      </tr>
      <tr>
        <td width="110">Alumno</td>
        <td><?php echo $row_rsCabecera['Nombres']; ?></td>
      </tr>
      <tr>
        <td width="110">Direcci&oacute;n </td>
        <td><?php echo $row_rsCabecera['Direccion']; ?></td>
      </tr>
      <tr>
        <td>Fecha - Hora</td>
        <td><? echo date("d/m/Y")."  ".date("h:i:s"); ?></td>
      </tr>
      <tr>
        <td>Usuario</td>
        <td><? echo $_SESSION['MM_Username']; ?></td>
      </tr>
    </table></td>
    <td width="150"><img src="../imagenes/icono/levels_add.png" width="150" height="100" title="Click aqui para imprimir" onclick="window.print(); "/></td>
  </tr>
  <tr>
    <td colspan="2"><div style="height:15px"></div>
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
            <td><?php echo $row_rsDetalle['Concepto']; ?></td>
            <td width="60" align="center"><?php echo $row_rsDetalle['Cantidad']; ?></td>
            <td width="70" align="right"><?php echo $row_rsDetalle['PrecioUnit']; ?></td>
            <td width="70" align="right"><?php echo $row_rsDetalle['Monto']; ?></td>
            <td width="50" align="right"><?php echo $row_rsDetalle['Dscto']; ?></td>
            <td width="50" align="right"><?php echo $row_rsDetalle['Mora']; ?></td>
            <td width="80" align="right"><?php echo $row_rsDetalle['SubTotal']; ?></td>
          </tr>
          <?php 
				$i++;
				} while ($row_rsDetalle = mysql_fetch_assoc($rsDetalle)); 
				?>
          <tr>
            <td width="35">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="60">&nbsp;</td>
            <td width="70">&nbsp;</td>
            <td width="70">&nbsp;</td>
            <td width="50">&nbsp;</td>
            <td width="50"><div style="height:15px"></div>
              Total </td>
            <td width="80" align="right"><div style="height:15px"></div>
                <?php echo "S/. ".$row_rsTotal['Total']; ?> </td>
          </tr>
      </table></td>
  </tr>
</table>
<?
}while($row_Comprobante=$objDatos->PoblarComprobanteOperacionSelAll($rsComprobante));
?>

</body>
</html>
<?php
mysql_free_result($rsCabecera);
mysql_free_result($rsDetalle);
mysql_free_result($rsTotal);
?>