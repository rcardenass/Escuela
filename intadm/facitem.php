<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsItem = "SELECT CodTemporal, Tipo, Codigo, Concepto, Cantidad, PrecioUnit, Monto, Dscto, Mora, Total, UsuarioCreacion, FechaCreacion FROM temporal where UsuarioCreacion='".$_SESSION['MM_Username']."' and CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
$rsItem = mysql_query($query_rsItem, $cn) or die(mysql_error());
$row_rsItem = mysql_fetch_assoc($rsItem);
$totalRows_rsItem = mysql_num_rows($rsItem);

mysql_select_db($database_cn, $cn);
$query_rsExisteCaja = "SELECT COUNT(a.CodCaja) AS Cantidad FROM caja a INNER JOIN dia b ON b.CodDia=a.CodDia WHERE a.Estado=1 AND b.Estado=1 AND DATE_FORMAT(Fecha,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y') AND a.UsuarioCreacion='".$_SESSION['MM_Username']."' ";
$rsExisteCaja = mysql_query($query_rsExisteCaja, $cn) or die(mysql_error());
$row_rsExisteCaja = mysql_fetch_assoc($rsExisteCaja);
$totalRows_rsExisteCaja = mysql_num_rows($rsExisteCaja);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gestión Escolar</title>
<link href="../styleadm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" autocomplete="Off" action="facupdateproceso.php">
  <div style="height:25px">
    <input type="submit" name="Submit2" value="Actualizar" disabled="disabled" onclick="grabar()"/>
  &nbsp;&nbsp;&nbsp;
  <input type="button" name="Submit" value="Grabar" <? if($row_rsExisteCaja['Cantidad']==1){ if(empty($totalRows_rsItem)){ echo "disabled='disabled'"; } }else{ echo "disabled='disabled' title='Debe abrir Caja para Facturar'"; } ?> onclick="document.form1.action='facinsertproceso.php'; document.form1.submit()"; />
  </div>
  <table class="table" width="595" border="0" cellpadding="0" cellspacing="2">
    <tr class="tr">
      <td>Item</td>
      <td>Concepto</td>
      <td>Cant.</td>
      <td>Precio</td>
      <td>Monto</td>
      <td>Dscto</td>
      <td>Mora</td>
      <td width="60">Total</td>
      <td><input name="txtCodigoAlumno" type="hidden" id="txtCodigoAlumno" value="<?php echo $_SESSION['CajaCodAlumno']; ?>" /></td>
    </tr>
    <?php 
	if(!empty($totalRows_rsItem)){
	do { 
	?>
      <tr>
        <td><input name="txtCodigo[]" type="hidden" id="txtCodigo[]" value="<?php echo $row_rsItem['CodTemporal']; ?>" />
        <?php echo $row_rsItem['CodTemporal']; ?></td>
        <td><?php echo utf8_decode($row_rsItem['Concepto']); ?></td>
        <td><?php echo $row_rsItem['Cantidad']; ?></td>
        <td><?php echo $row_rsItem['PrecioUnit']; ?></td>
        <td><?php echo $row_rsItem['Monto']; ?></td>
        <td><?php echo $row_rsItem['Dscto']; ?></td>
        <td><?php echo $row_rsItem['Mora']; ?></td>
        <td width="60"><label>
          <input name="txtTotal[]" type="text" id="txtTotal[]" style="width:60px; height:20px; font-size:15px; background:#FFCC66" onclick="modificar(this)" value="<?php echo $row_rsItem['Total']; ?>" maxlength="7"/>
        </label></td>
        <td width="35" align="center">
		<a onClick="return confirmaborar()" href="facdelitem.php?Codigo=<?php echo $row_rsItem['CodTemporal']; ?>"><img src="../imagenes/icono/trash.png" width="32" border="0" title="Eliminar"/></a>
		</td>
      </tr>
      <?php 
	  } while ($row_rsItem = mysql_fetch_assoc($rsItem)); 
	  }
	  ?>
  </table>
</form>
</body>
</html>
<?php
mysql_free_result($rsItem);

mysql_free_result($rsExisteCaja);
?>
<script LANGUAGE="JavaScript">
	function confirmaborar()
	{
	var agree=confirm("Esta Seguro de eliminar este Item? Este Proceso es Irreversible.");
	if (agree)
	return true ;
	else
	return false ;
	}
</script>
<script type="text/javascript">
	function modificar() {
		/*document.getElementById("formulario").submit();*/
		document.form1.Submit2.disabled=false;
		document.form1.Submit.disabled=true;
	}
	function grabar() {
		/*document.getElementById("formulario").submit();*/
		document.form1.Submit2.disabled=false;
		document.form1.Submit.disabled=false;
	}
</script>