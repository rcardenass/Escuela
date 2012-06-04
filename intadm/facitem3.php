<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsItem = "SELECT CodTemporal, Tipo, Codigo, Concepto, Cantidad, PrecioUnit, Monto, Dscto, Mora, Total, UsuarioCreacion, FechaCreacion FROM temporal where UsuarioCreacion='".$_SESSION['MM_Username']."' and CodAlumno=0 ";
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
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
</head>

<body>
<form action="facinsertproceso3.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('txtNombres','','R','txtDireccion','','R');return document.MM_returnValue" autocomplete="Off">
    <table width="590" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="60">Nombres</td>
        <td width="374"><label>
          <input name="txtNombres" type="text" id="txtNombres" style="width:350px"/>
        </label></td>
        <td width="40">Fecha</td>
        <td width="80"><?php echo date("d-m-Y");?></td>
      </tr>
      <tr>
        <td width="60">Direcci&oacute;n</td>
        <td><label>
          <input name="txtDireccion" type="text" id="txtDireccion" style="width:350px"/>
        </label></td>
        <td width="40">Hora</td>
        <td width="80"><?php echo date("H:i:s");?></td>
      </tr>
      <tr>
        <td width="60">Tel&eacute;fono</td>
        <td><label>
          <input name="txtTelefono" type="text" id="txtTelefono" />
        </label></td>
        <td width="40">&nbsp;</td>
        <td width="80">&nbsp;</td>
      </tr>
    </table>
	<div style="height:15px"></div>
  <div style="height:25px">
    <input type="submit" name="Submit" value="Grabar" <? if($row_rsExisteCaja['Cantidad']==1){ if(empty($totalRows_rsItem)){ echo "disabled='disabled'"; } }else{ echo "disabled='disabled' title='Debe abrir Caja para Facturar'"; } ?> />
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
        <td><?php echo $row_rsItem['Concepto']; ?></td>
        <td><?php echo $row_rsItem['Cantidad']; ?></td>
        <td><?php echo $row_rsItem['PrecioUnit']; ?></td>
        <td><?php echo $row_rsItem['Monto']; ?></td>
        <td><?php echo $row_rsItem['Dscto']; ?></td>
        <td><?php echo $row_rsItem['Mora']; ?></td>
        <td width="60"><label>
          <input name="txtTotal[]" type="text" id="txtTotal[]" style="width:60px; height:20px; font-size:15px; background:#FFCC66" onclick="modificar(this)" value="<?php echo $row_rsItem['Total']; ?>" maxlength="7" readonly="true" disabled="disabled"/>
        </label></td>
        <td width="35" align="center"><a onclick="return confirmaborar()" href="facdelitem3.php?Codigo=<?php echo $row_rsItem['CodTemporal']; ?>"><img src="../imagenes/icono/trash.png" width="32" border="0" title="Eliminar"/></a></td>
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