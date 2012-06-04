<?php include("../seguridad.php");?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$rsTDocumento = $objDatos->ObtenerTipoDocumentoSelAll();
$row_rsTDocumento = $objDatos->ObtenerTipoDocumentoSelAll($rsTDocumento);

$rsDepartamento=$objDatos->ObtenerDepartamentoSelAll();
$row_Departamento=$objDatos->PoblarDepartamentoSelAll($rsDepartamento);

$rsProvincia=$objDatos->ObtenerProvinciaSelAll();
$row_Provincia=$objDatos->PoblarProvinciaSelAll($rsProvincia);

$rsDistrito=$objDatos->ObtenerDistritoSelAll();
$row_Distrito=$objDatos->PoblarDistritoSelAll($rsDistrito);
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
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<?php
//begin JSRecordset
$jsObject_rsProvincia = new WDG_JsRecordset("rsProvincia");
echo $jsObject_rsProvincia->getOutput();
//end JSRecordset
?>
<?php
//begin JSRecordset
$jsObject_rsDistrito = new WDG_JsRecordset("rsDistrito");
echo $jsObject_rsDistrito->getOutput();
//end JSRecordset
?>
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
		<h1>Nuevo Padre de Familia</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="acainsertpadre.php" autocomplete="off" onsubmit="MM_validateForm('cboTipo','','R','txtApellidoPaterno','','R','txtApellidoMaterno','','R','txtNombres','','R',
		'cboTipoDocumento','','RisNum','txtNumeroDocumento','','NisNum',
'cboDepartamento','','R','cboProvincia','','R','cboDistrito','','R',	
'txtDireccion','','R','txtReferencia','','R',
'txtTelefono','','NisNum','txtCelular','','NisNum',
'txtEmail','','NisEmail');return document.MM_returnValue">
		<table width="550" border="0" cellspacing="1" cellpadding="0">
          <tr>
            <td>Tipo Padres </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><label>
              <select name="cboTipo" id="cboTipo" style="width:144px">
                <option value="">Seleccione</option>
				<option value="P">Padre</option>
                <option value="M">Madre</option>
              </select>
            </label></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Apellido Paterno </td>
            <td>Apellido Materno </td>
            <td>Nombres</td>
            </tr>
          <tr>
            <td><label>
			  <input name="txtApellidoPaterno" type="text" id="txtApellidoPaterno" size="20" />
            </label></td>
            <td><label>
              <input name="txtApellidoMaterno" type="text" id="txtApellidoMaterno" size="20" />
            </label></td>
            <td><label>
              <input name="txtNombres" type="text" id="txtNombres" size="20" maxlength="50" />
            </label></td>
            </tr>
          <tr>
            <td>Fecha Nacimiento </td>
            <td>Tipo Documento </td>
            <td>Numero Documento </td>
            </tr>
          <tr>
            <td><label>
<input name="txtFechaNacimiento" id="txtFechaNacimiento" value="" size="20" maxlength="10" wdg:subtype="SmartDate" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:restricttomask="no" wdg:defaultnow="yes" wdg:spinner="no" wdg:type="widget" style="width:70px" />
            </label></td>
            <td><label>
              <select name="cboTipoDocumento" id="cboTipoDocumento" style="width:144px">
                <option>Seleccione</option>
                <option value="0">Ninguno</option>
                <? while($row_rsTDocumento = $objDatos->PoblarTipoDocumentoSelAll($rsTDocumento)){ ?>
                <option value="<?php echo $row_rsTDocumento['CodTipoDocumento']?>"><?php echo $row_rsTDocumento['NombreTipoDocumento']?></option>
                <? }?>
              </select>
            </label></td>
            <td><input name="txtNumeroDocumento" type="text" id="txtNumeroDocumento" size="20" maxlength="15" /></td>
            </tr>
          <tr>
            <td>Departamento</td>
            <td>Provincia</td>
            <td>Distrito</td>
            </tr>
          <tr>
            <td><label>
              <select name="cboDepartamento" id="cboDepartamento" style="width:144px">
			  	<option value="">Seleccione</option>
                  <? while($row_Departamento=$objDatos->PoblarDepartamentoSelAll($rsDepartamento)){ ?>
                  <option value="<?php echo $row_Departamento['CodDepartamento']?>"><?php echo $row_Departamento['Nombre']?></option>
                  <? } ?>
              </select>
            </label></td>
            <td><label>
			  <select name="cboProvincia" id="cboProvincia" style="width:144px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsProvincia" wdg:displayfield="Nombre" wdg:valuefield="Suma" wdg:fkey="CodDepartamento" wdg:triggerobject="cboDepartamento" >
			  <option value="">Seleccione</option>
			  </select>
            </label></td>
            <td><label>
			  <select name="cboDistrito" id="cboDistrito" style="width:144px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsDistrito" wdg:displayfield="Nombre" wdg:valuefield="CodDistrito" wdg:fkey="Suma" wdg:triggerobject="cboProvincia" >
			  <option value="">Seleccione</option>
			  </select>
            </label></td>
            </tr>
          <tr>
            <td>Direcci&oacute;n</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td colspan="3"><label>
              <textarea name="txtDireccion"  style="width:505px" rows="2" id="txtDireccion"></textarea>
            </label></td>
            </tr>
          <tr>
            <td>Referencia</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td colspan="3"><label>
              <textarea name="txtReferencia" style="width:505px" rows="2" id="txtReferencia"></textarea>
            </label></td>
            </tr>
          <tr>
            <td>Telefono</td>
            <td>Celular</td>
            <td>Nextel</td>
            </tr>
          <tr>
            <td><label>
              <input name="txtTelefono" type="text" id="txtTelefono" size="20"/>
            </label></td>
            <td><label>
              <input name="txtCelular" type="text" id="txtCelular" size="20"/>
            </label></td>
            <td><label>
              <input name="txtNextel" type="text" id="txtNextel" size="20"/>
            </label></td>
            </tr>
          <tr>
            <td>Email</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td colspan="3"><label>
              <input name="txtEmail" type="text" id="txtEmail" style="width:505px"/>
            </label></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
        </table>
		<DIV style="width:509px; text-align:right">
		    <input type="submit" name="Submit2" value="Aceptar" />
		    &nbsp;&nbsp;&nbsp;<input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acapadre.php&quot;'/>
		  </DIV>
        </form>
		<br />
		<span><? echo $_SESSION['TablaPadreFamilia']; ?></span>
		<? 
		$_SESSION['TablaPadreFamilia']=NULL;
		unset($_SESSION['TablaPadreFamilia']); 
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
mysql_free_result($rsTreeview);
?>
