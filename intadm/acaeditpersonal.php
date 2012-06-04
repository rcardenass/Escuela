<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

mysql_select_db($database_cn, $cn);
$query_rsTipoDocumento = "SELECT CodTipoDocumento, NombreTipodocumento FROM tipodocumento where Estado=1";
$rsTipoDocumento = mysql_query($query_rsTipoDocumento, $cn) or die(mysql_error());
$row_rsTipoDocumento = mysql_fetch_assoc($rsTipoDocumento);
$totalRows_rsTipoDocumento = mysql_num_rows($rsTipoDocumento);

mysql_select_db($database_cn, $cn);
$query_rsTipoPersonal = "SELECT CodTipoPersonal, NombreTipoPersonal FROM tipopersonal";
$rsTipoPersonal = mysql_query($query_rsTipoPersonal, $cn) or die(mysql_error());
$row_rsTipoPersonal = mysql_fetch_assoc($rsTipoPersonal);
$totalRows_rsTipoPersonal = mysql_num_rows($rsTipoPersonal);

mysql_select_db($database_cn, $cn);
$query_rsDepartamento = "SELECT CodDepartamento, NombreDepartamento FROM departamento ORDER BY NombreDepartamento ASC";
$rsDepartamento = mysql_query($query_rsDepartamento, $cn) or die(mysql_error());
$row_rsDepartamento = mysql_fetch_assoc($rsDepartamento);
$totalRows_rsDepartamento = mysql_num_rows($rsDepartamento);

mysql_select_db($database_cn, $cn);
$query_rsProvincia = "SELECT CodProvincia, CodDepartamento, NombreProvincia FROM provincia ORDER BY NombreProvincia ASC";
$rsProvincia = mysql_query($query_rsProvincia, $cn) or die(mysql_error());
$row_rsProvincia = mysql_fetch_assoc($rsProvincia);
$totalRows_rsProvincia = mysql_num_rows($rsProvincia);

mysql_select_db($database_cn, $cn);
$query_rsDistrito = "SELECT CodDistrito, CodProvincia, NombreDistrito FROM distrito ORDER BY NombreDistrito ASC";
$rsDistrito = mysql_query($query_rsDistrito, $cn) or die(mysql_error());
$row_rsDistrito = mysql_fetch_assoc($rsDistrito);
$totalRows_rsDistrito = mysql_num_rows($rsDistrito);

$colname_rsEditar = "-1";
if (isset($_GET['Codigo'])) {
  $colname_rsEditar = (get_magic_quotes_gpc()) ? $_GET['Codigo'] : addslashes($_GET['Codigo']);
}
mysql_select_db($database_cn, $cn);
$query_rsEditar = sprintf("SELECT CodPersonal, CodTipoPersonal, ApellidoPaterno, ApellidoMaterno, Nombres, Sexo, CodTipoDocumento, NumeroDocumento, CodDepartamento, CodProvincia, CodDistrito, Direccion, Referencia, Telefono, Celular, Rpc, Rpm, Nextel, EmailPersonal, EmailInstitucional, UsuarioId, Estado FROM personal WHERE CodPersonal = %s", $colname_rsEditar);
$rsEditar = mysql_query($query_rsEditar, $cn) or die(mysql_error());
$row_rsEditar = mysql_fetch_assoc($rsEditar);
$totalRows_rsEditar = mysql_num_rows($rsEditar);

$_SESSION['Buscar']=$_POST['txtBuscar'];
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
<!-- InstanceBeginEditable name="head" -->
<script type="text/JavaScript" src="../validar.js"></script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rsProvincia = new WDG_JsRecordset("rsProvincia");
echo $jsObject_rsProvincia->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rsDistrito = new WDG_JsRecordset("rsDistrito");
echo $jsObject_rsDistrito->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rsDistrito = new WDG_JsRecordset("rsDistrito");
echo $jsObject_rsDistrito->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rsProvincia = new WDG_JsRecordset("rsProvincia");
echo $jsObject_rsProvincia->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
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
		<h1>Editar Personal</h1>
		<hr /><br />
		<form action="acaupdatepersonal.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('txtApellidoPaterno','','R','txtApellidoMaterno','','R','txtNombres','','R','txtNumeroDocumento','','RisNum','txtTelefono','','RisNum','txtCelular','','RisNum','txtRpc','','NisNum','txtRpm','','NisNum','txtEmailPersonal','','NisEmail','txtEmailInstitucional','','NisEmail','txtDireccion','','R','txtReferencia','','R');return document.MM_returnValue" autocomplete="Off">
          <table width="600" border="0" cellpadding="0" cellspacing="1">
            <tr>
              <td>Tipo Personal </td>
              <td>Apellido Paterno </td>
              <td>Apellido Materno </td>
              <td>Nombres</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboTipoPersonal" id="cboTipoPersonal" style="width:144px" disabled="disabled">
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsTipoPersonal['CodTipoPersonal']?>"<?php if (!(strcmp($row_rsTipoPersonal['CodTipoPersonal'], $row_rsEditar['CodTipoPersonal']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsTipoPersonal['NombreTipoPersonal']?></option>
<?php
} while ($row_rsTipoPersonal = mysql_fetch_assoc($rsTipoPersonal));
  $rows = mysql_num_rows($rsTipoPersonal);
  if($rows > 0) {
      mysql_data_seek($rsTipoPersonal, 0);
	  $row_rsTipoPersonal = mysql_fetch_assoc($rsTipoPersonal);
  }
?>
</select>
              </label></td>
              <td><label>
                <input name="txtApellidoPaterno" type="text" id="txtApellidoPaterno" value="<?php echo $row_rsEditar['ApellidoPaterno']; ?>" size="20" />
              </label></td>
              <td><label>
                <input name="txtApellidoMaterno" type="text" id="txtApellidoMaterno" value="<?php echo $row_rsEditar['ApellidoMaterno']; ?>" size="20" />
              </label></td>
              <td><input name="txtNombres" type="text" id="txtNombres" value="<?php echo $row_rsEditar['Nombres']; ?>" size="20" /></td>
            </tr>
            <tr>
              <td>Sexo</td>
              <td>Tipo de Documento </td>
              <td>Numero Documento </td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboSexo" id="cboSexo" style="width:144px">
                  <option value="F" <?php if (!(strcmp("F", $row_rsEditar['Sexo']))) {echo "selected=\"selected\"";} ?>>Femenino</option>
                  <option value="M" <?php if (!(strcmp("M", $row_rsEditar['Sexo']))) {echo "selected=\"selected\"";} ?>>Masculino</option>
</select>
              </label></td>
              <td><label>
                <select name="cboTipoDocumento" id="cboTipoDocumento" style="width:144px">
                  <?php
do {  
?><option value="<?php echo $row_rsTipoDocumento['CodTipoDocumento']?>"<?php if (!(strcmp($row_rsTipoDocumento['CodTipoDocumento'], $row_rsEditar['CodTipoDocumento']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsTipoDocumento['NombreTipodocumento']?></option>
                  <?php
} while ($row_rsTipoDocumento = mysql_fetch_assoc($rsTipoDocumento));
  $rows = mysql_num_rows($rsTipoDocumento);
  if($rows > 0) {
      mysql_data_seek($rsTipoDocumento, 0);
	  $row_rsTipoDocumento = mysql_fetch_assoc($rsTipoDocumento);
  }
?>
</select>
              </label></td>
              <td><label>
                <input name="txtNumeroDocumento" type="text" id="txtNumeroDocumento" value="<?php echo $row_rsEditar['NumeroDocumento']; ?>" size="20" />
              </label></td>
              <td><input name="txtCodigo" type="hidden" id="txtCodigo" value="<?php echo $row_rsEditar['CodPersonal']; ?>" /><input name="txtUsuarioCreacion" type="hidden" id="txtUsuarioCreacion" value="<?php echo $_SESSION['MM_Username']; ?>" /></td>
            </tr>
            <tr>
              <td>Departamento</td>
              <td>Provincia</td>
              <td>Distrito</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboDepartamento" id="cboDepartamento" style="width:144px">
                  <?php
do {  
?><option value="<?php echo $row_rsDepartamento['CodDepartamento']?>"<?php if (!(strcmp($row_rsDepartamento['CodDepartamento'], $row_rsEditar['CodDepartamento']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsDepartamento['NombreDepartamento']?></option>
                  <?php
} while ($row_rsDepartamento = mysql_fetch_assoc($rsDepartamento));
  $rows = mysql_num_rows($rsDepartamento);
  if($rows > 0) {
      mysql_data_seek($rsDepartamento, 0);
	  $row_rsDepartamento = mysql_fetch_assoc($rsDepartamento);
  }
?>
              </select>
              </label></td>
              <td><label>
                <select name="cboProvincia" id="cboProvincia" style="width:144px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsProvincia" wdg:displayfield="NombreProvincia" wdg:valuefield="CodProvincia" wdg:fkey="CodDepartamento" wdg:triggerobject="cboDepartamento" wdg:selected="<?php echo $row_rsEditar['CodProvincia']; ?>">
                </select>
              </label></td>
              <td><label>
                <select name="cboDistrito" id="cboDistrito" style="width:144px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsDistrito" wdg:displayfield="NombreDistrito" wdg:valuefield="CodDistrito" wdg:fkey="CodProvincia" wdg:triggerobject="cboProvincia" wdg:selected="<?php echo $row_rsEditar['CodDistrito']; ?>">
              </select>
              </label></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Direccion</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><label>
                <textarea name="txtDireccion"  style="width:590px" rows="2" id="txtDireccion"><?php echo $row_rsEditar['Direccion']; ?></textarea>
              </label></td>
            </tr>
            <tr>
              <td>Referencia</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><label>
                <textarea name="txtReferencia" style="width:590px" rows="2" id="txtReferencia"><?php echo $row_rsEditar['Referencia']; ?></textarea>
              </label></td>
            </tr>
            <tr>
              <td>Telefono</td>
              <td>Celular</td>
              <td>Rpc</td>
              <td>Rpm</td>
            </tr>
            <tr>
              <td><label>
                <input name="txtTelefono" type="text" id="txtTelefono" value="<?php echo $row_rsEditar['Telefono']; ?>" size="20" />
              </label></td>
              <td><label>
                <input name="txtCelular" type="text" id="txtCelular" value="<?php echo $row_rsEditar['Celular']; ?>" size="20" />
              </label></td>
              <td><label>
              <input name="txtRpc" type="text" id="txtRpc" value="<?php echo $row_rsEditar['Rpc']; ?>" size="20" />
              </label></td>
              <td><input name="txtRpm" type="text" id="txtRpm" value="<?php echo $row_rsEditar['Rpm']; ?>" size="20" /></td>
            </tr>
            <tr>
              <td>Nextel</td>
              <td>Email Personal</td>
              <td>Email Institucional </td>
              <td>Estado</td>
            </tr>
            <tr>
              <td><label>
                <input name="txtNextel" type="text" id="txtNextel" value="<?php echo $row_rsEditar['Nextel']; ?>" size="20" />
              </label></td>
              <td><label>
                <input name="txtEmailPersonal" type="text" id="txtEmailPersonal" value="<?php echo $row_rsEditar['EmailPersonal']; ?>" size="20" />
              </label></td>
              <td><input name="txtEmailInstitucional" type="text" id="txtEmailInstitucional" value="<?php echo $row_rsEditar['EmailInstitucional']; ?>" size="20" /></td>
              <td><!--<input type="submit" name="Submit" value="Enviar" />-->
                <label>
                <select name="cboEstado" id="cboEstado" style="width:144px">
                  <option value="1" <?php if (!(strcmp(1, $row_rsEditar['Estado']))) {echo "selected=\"selected\"";} ?>>Activo</option>
                  <option value="0" <?php if (!(strcmp(0, $row_rsEditar['Estado']))) {echo "selected=\"selected\"";} ?>>Cesado</option>
                </select>
              </label></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
		  <DIV style="width:593px; text-align:right">
		    <input type="submit" name="Submit2" value="Aceptar" />
		    &nbsp;&nbsp;&nbsp;<input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acapersonal.php&quot;'/>
		  </DIV>
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

mysql_free_result($rsTipoDocumento);

mysql_free_result($rsTipoPersonal);

mysql_free_result($rsDepartamento);

mysql_free_result($rsProvincia);

mysql_free_result($rsDistrito);

mysql_free_result($rsEditar);
?>
