<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
/*$query_rsCabecera = "SELECT a.CodAlumno, Concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno, a.Direccion,  concat(b.NombreDepartamento,'-', c.NombreProvincia,'-',d.NombreDistrito) as Ubigeo, DATE_FORMAT(a.FechaNacimiento,'%d/%m/%Y') AS FecNac, a.Telefono, a.EmailPersonal AS Email FROM alumno a INNER JOIN departamento b ON b.CodDepartamento=a.CodDepartamento INNER JOIN provincia c ON c.CodProvincia=a.CodProvincia INNER JOIN distrito d ON d.CodDistrito=a.CodDistrito WHERE a.CodAlumno='".$_SESSION['TesoreriaCodAlumno']."' ";
*/
$query_rsCabecera = "SELECT a.CodAlumno, Concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno, a.Direccion,  concat(
(SELECT x.Nombre FROM ubigeo x WHERE x.CodDepartamento<>'00' AND x.CodProvincia='00' AND x.CodDistrito='00' AND x.CodDepartamento=LEFT(a.Ubigeo,2)),' - ', (SELECT x.Nombre FROM ubigeo x WHERE x.CodDepartamento<>'00' AND x.CodProvincia<>'00' AND x.CodDistrito='00' AND x.CodDepartamento=LEFT(a.Ubigeo,2) AND x.CodProvincia=RIGHT(LEFT(a.Ubigeo,4),2)),' - ', (SELECT x.Nombre FROM ubigeo x WHERE x.CodDepartamento<>'00' AND x.CodProvincia<>'00' AND x.CodDistrito<>'00' AND x.CodDepartamento=LEFT(a.Ubigeo,2) AND x.CodProvincia=RIGHT(LEFT(a.Ubigeo,4),2) AND x.CodDistrito=RIGHT(a.Ubigeo,2)) ) AS Ubigeo, DATE_FORMAT(a.FechaNacimiento,'%d/%m/%Y') AS FecNac, a.Telefono, a.EmailPersonal AS Email FROM alumno a WHERE a.CodAlumno='".$_SESSION['TesoreriaCodAlumno']."' ";
$rsCabecera = mysql_query($query_rsCabecera, $cn) or die(mysql_error());
$row_rsCabecera = mysql_fetch_assoc($rsCabecera);
$totalRows_rsCabecera = mysql_num_rows($rsCabecera);

mysql_select_db($database_cn, $cn);
$query_rsDeudaFiada = "SELECT  SUM(b.MontoPagar-b.MontoPagado-b.Descuento) AS Pagar FROM cuentacorriente a  INNER JOIN detallecuentacorriente b ON b.CodCuentaCorriente=a.CodCuentaCorriente  INNER JOIN productos c ON c.CodProducto=b.CodProducto  WHERE a.Estado=1  AND b.Estado=1  AND b.MontoPagar>b.MontoPagado+b.Descuento  AND a.CodAlumno='".$_SESSION['TesoreriaCodAlumno']."'";
$rsDeudaFiada = mysql_query($query_rsDeudaFiada, $cn) or die(mysql_error());
$row_rsDeudaFiada = mysql_fetch_assoc($rsDeudaFiada);
$totalRows_rsDeudaFiada = mysql_num_rows($rsDeudaFiada);

mysql_select_db($database_cn, $cn);
$query_rsDeudaPension = "SELECT SUM(a.Monto-a.Pagado) AS Pagar FROM programacionalumno a  INNER JOIN anio b ON b.CodAnio=a.CodAnio  INNER JOIN grado c ON c.CodGrado=a.CodGrado  WHERE a.CodAlumno='".$_SESSION['TesoreriaCodAlumno']."' AND a.Estado=1  AND a.Monto+a.Mora>a.Pagado ";
$query_rsDeudaPension.= "AND FechaTermino<now() ";
$rsDeudaPension = mysql_query($query_rsDeudaPension, $cn) or die(mysql_error());
$row_rsDeudaPension = mysql_fetch_assoc($rsDeudaPension);
$totalRows_rsDeudaPension = mysql_num_rows($rsDeudaPension);

mysql_select_db($database_cn, $cn);
$query_rsMoraPension = "SELECT SUM(a.Mora) AS Pagar FROM programacionalumno a  INNER JOIN anio b ON b.CodAnio=a.CodAnio  INNER JOIN grado c ON c.CodGrado=a.CodGrado  WHERE a.CodAlumno='".$_SESSION['TesoreriaCodAlumno']."' AND a.Estado=1  AND a.Monto+a.Mora>a.Pagado AND DATE_FORMAT(FechaTermino,'%d/%m/%Y')<DATE_FORMAT(now(),'%d/%m/%Y')";
$rsMoraPension = mysql_query($query_rsMoraPension, $cn) or die(mysql_error());
$row_rsMoraPension = mysql_fetch_assoc($rsMoraPension);
$totalRows_rsMoraPension = mysql_num_rows($rsMoraPension);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table width="600px" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="70">Código</td>
    <td><?php echo $row_rsCabecera['CodAlumno']; ?></td>
    <td width="60">&nbsp;</td>
    <td width="100">&nbsp;</td>
    <td width="50">&nbsp;</td>
    <td width="60">&nbsp;</td>
  </tr>
  <tr>
    <td width="70">Alumno</td>
    <td><?php echo $row_rsCabecera['Alumno']; ?></td>
    <td width="60">F. Nac.</td>
    <td width="100"><?php echo $row_rsCabecera['FecNac']; ?></td>
    <td width="50">Deuda</td>
    <td width="60"><?php echo number_format($row_rsDeudaFiada['Pagar']+$row_rsDeudaPension['Pagar'],2); ?></td>
  </tr>
  <tr>
    <td width="70">Ubigeo</td>
    <td><?php echo $row_rsCabecera['Ubigeo']; ?></td>
    <td width="60">Tel. Fijo </td>
    <td width="100"><?php echo $row_rsCabecera['Telefono']; ?></td>
    <td width="50">Mora</td>
    <td width="60"><?php echo  number_format($row_rsMoraPension['Pagar'],2); ?></td>
  </tr>
  <tr>
    <td width="70">Dirección</td>
    <td><?php echo $row_rsCabecera['Direccion']; ?></td>
    <td width="60">Email</td>
    <td width="100"><?php echo $row_rsCabecera['Email']; ?>&nbsp;</td>
    <td width="50">Total </td>
    <td width="60"><?php echo  number_format($row_rsDeudaFiada['Pagar']+$row_rsDeudaPension['Pagar']+$row_rsMoraPension['Pagar'],2); ?></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($rsCabecera);

mysql_free_result($rsDeudaFiada);

mysql_free_result($rsDeudaPension);

mysql_free_result($rsMoraPension);
?>
