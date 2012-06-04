<?php include("../seguridad.php");?>
<?php
$KT_relPath = "../";
  require_once("../includes/widgets/widgets_start.php");
?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$rsCaja=$objDatos->ObtenerCodigoCajaSelId($_SESSION['MM_Username']);
$row_Caja=$objDatos->PoblarCodigoCajaSelId($rsCaja);
$totalRows_Caja=  mysql_num_rows($rsCaja);

$rsValidaEgreso=$objDatos->ObtenerExisteEgresoSelId($row_Caja['CodCaja'],$_SESSION['MM_Username']);
$row_ValidaEgreso=$objDatos->PoblarExisteEgresoSelId($rsValidaEgreso);

$rsMontoDisponible=$objDatos->ObtenerMontoDisponibleSelId($_SESSION['MM_Username']);
$row_MontoDisponible=$objDatos->PoblarMontoDisponibleSelId($rsMontoDisponible);

$rsMontoEgreso=$objDatos->ObtenerMontoEgresoSelId($row_Caja['CodCaja'],$_SESSION['MM_Username']);
$row_MontoEgreso=$objDatos->PoblarMontoEgresoSelId($rsMontoEgreso);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templateadm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Gestion Escolar</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<script type="text/javascript" src="../validar.js"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
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
		<h1>Nuevo Egresos de Caja</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="tesinsertegresocaja.php" Autocomplete="Off" 
                      onsubmit="MM_validateForm('cboAutorizado','','R','txtPara','','R','txtDisponible','','R','txtSalida','','R','txtDescripcion','','R');return document.MM_returnValue">
		  <table width="440" border="0" cellspacing="2" cellpadding="0">
			<tr>
                            <td colspan="2">
                                Codigo de Caja: <strong><? if(!empty($row_Caja['CodCaja'])){ echo $row_Caja['CodCaja']; }else { echo "No existe caja abierta para el Usuario"; } ?></strong>
                                <div style="height: 10px"></div>
                            </td>
			</tr>
                      <tr>
                          <td><input name="txtCodCaja" type="hidden" id="txtCodCaja" value="<? echo $row_Caja['CodCaja']; ?>" />Autorizado Por </td>
			  <td>Para</td>
			</tr>
			<tr>
			  <td><label>
				<select name="cboAutorizado" id="cboAutorizado" style="width:200px">
                                    <option value="">Seleccione</option>
                                    <option value="Wilfredo Galvez">Wilfredo Galvez</option>
                                    <option value="Gloria Flores">Gloria Flores</option>
				</select>
			  </label></td>
			  <td><label>
				<input type="text" name="txtPara" style="width:200px" />
			  </label></td>
			</tr>
			<tr>
			  <td>Disponible</td>
			  <td>Salida</td>
			</tr>
			<tr>
			  <td>
                            <label>
                                <input type="widget" name="txtDisponible" style="width:70px" subtype="numericInput" negative="false" allowfloat="true" readonly="true"
                                       value="<? if ($row_ValidaEgreso['Cantidad']==0){ echo $row_MontoDisponible['Monto']; } else { echo $row_MontoDisponible['Monto']-$row_MontoEgreso['Monto']; } ?>" />
                            </label>
                          </td>
			  <td><label>
                                  <input type="widget" name="txtSalida" style="width:70px" value="0" subtype="numericInput" negative="false" allowfloat="true" title="el egreso debe ser mayor que cero y menor o igual que el monto disponible"/>
			  </label></td>
			</tr>
			<tr>
			  <td>Descripcion</td>
			  <td>&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="2"><label>
				<textarea name="txtDescripcion" rows="5"  style="width:415px"></textarea>
			  </label></td>
			</tr>
		  </table>
		  <div style="height:5px"></div>
		  <div style="width:300px">
                      <!--<input type="button" id="btGrabar" name="btGrabar" value="Grabar" <?php //if($totalRows_Caja==0){ echo "disabled='disabled'"; }?> />-->
                      <input type="submit" name="Submit" value="Grabar" <?php if($totalRows_Caja==0){ echo "disabled='disabled'"; }?> />
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <input type="button" id="btVolver" name="btVolver" value="Volver" 
				onclick="document.form1.action='tesegresocaja.php'; document.form1.submit()" />
		  </div>
		</form>
                <br />
		<span><? echo $_SESSION['TablaEgresoCaja']; ?></span>
		<?
		$_SESSION['TablaEgresoCaja']=NULL;
		unset($_SESSION['TablaEgresoCaja']);
		?>
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
  require_once("../includes/widgets/widgets_end.php");
?>
<?php
mysql_free_result($rsTreeview);
?>
