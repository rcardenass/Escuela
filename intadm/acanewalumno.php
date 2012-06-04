<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
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

/*mysql_select_db($database_cn, $cn);
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
$totalRows_rsDistrito = mysql_num_rows($rsDistrito);*/

$rsDepartamento=$objDatos->ObtenerDepartamentoSelAll();
$row_Departamento=$objDatos->PoblarDepartamentoSelAll($rsDepartamento);

$rsProvincia=$objDatos->ObtenerProvinciaSelAll();
$row_Provincia=$objDatos->PoblarProvinciaSelAll($rsProvincia);

$rsDistrito=$objDatos->ObtenerDistritoSelAll();
$row_Distrito=$objDatos->PoblarDistritoSelAll($rsDistrito);

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
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/NumericInput.js"></script>
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
		<h1>Nuevo Alumno</h1><hr /><br />
		<form action="acainsertalumno.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('txtApellidoPaterno','','R','txtApellidoMaterno','','R','txtNombres','','R','txtFechaNacimiento','','R','cboTipoDocumento','','RisNum','txtNumeroDocumento','','NisNum','txtDireccion','','R','txtTelefono','','RisNum','txtEmailPersonal','','NisEmail','txtEmailInstitucional','','NisEmail','cboColegioAnterior','','RisNum');return document.MM_returnValue" autocomplete="Off">
          <table width="600" border="0" cellpadding="0" cellspacing="1">
            <tr>
              <td>C&oacute;digo Ugel </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <input name="txtCodigo" id="txtCodigo" value="" size="20" maxlength="14" wdg:negatives="no" wdg:subtype="NumericInput" wdg:type="widget" wdg:floats="no" wdg:spinner="no"/>
              </label></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Apellido Paterno </td>
              <td>Apellido Materno </td>
              <td>Nombres</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <input name="txtApellidoPaterno" type="text" id="txtApellidoPaterno" size="20" />
              </label></td>
              <td><label>
                <input name="txtApellidoMaterno" type="text" id="txtApellidoMaterno" size="20" />
              </label></td>
              <td colspan="2"><label>
                <input name="txtNombres" type="text" id="txtNombres" style="width:292px" maxlength="50" />
              </label></td>
            </tr>
            <tr>
              <td>Fecha Nacimiento </td>
              <td>Sexo</td>
              <td>Tipo de Documento </td>
              <td>Numero Documento </td>
            </tr>
            <tr>
              <td><label>
                <input name="txtFechaNacimiento" id="txtFechaNacimiento" value="" size="20" maxlength="10" wdg:subtype="SmartDate" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:restricttomask="no" wdg:defaultnow="no" wdg:spinner="no" wdg:type="widget" />
              </label></td>
              <td><label>
                <select name="cboSexo" id="cboSexo" style="width:144px">
                  <option value="F">Femenino</option>
                  <option value="M">Masculino</option>
                </select>
              </label></td>
              <td><label>
                <select name="cboTipoDocumento" id="cboTipoDocumento" style="width:144px">
				 <option>Seleccione</option>
                  <option value="0">Ninguno</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsTipoDocumento['CodTipoDocumento']?>"><?php echo $row_rsTipoDocumento['NombreTipodocumento']?></option>
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
              <td><input name="txtNumeroDocumento" type="text" id="txtNumeroDocumento" size="20" maxlength="15" /></td>
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
			  <select name="cboDistrito" id="cboDistrito" style="width:144px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsDistrito" wdg:displayfield="Nombre" wdg:valuefield="Suma3" wdg:fkey="Suma" wdg:triggerobject="cboProvincia" >
			  <option value="">Seleccione</option>
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
                <textarea name="txtDireccion"  style="width:590px" rows="2" id="txtDireccion"></textarea>
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
                <textarea name="txtReferencia" style="width:590px" rows="2" id="txtReferencia"></textarea>
              </label></td>
            </tr>
            <tr>
              <td>Telefono</td>
              <td>Colegio Anterior </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <input name="txtTelefono" type="text" id="txtTelefono" size="20" />
              </label></td>
              <td colspan="2"><label></label>                <label>
                <select name="cboColegioAnterior" id="cboColegioAnterior" style="width:295px">
                  <option>Seleccione</option>
                  <option value="0">Ninguno</option>
                </select>
              </label></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>Email Personal</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><label>
                <input name="txtEmailPersonal" type="text" id="txtEmailPersonal" style="width:590px" />
              </label>                <label></label>              <label></label>              <!--<input type="submit" name="Submit" value="Enviar" />--></td>
              </tr>
            <tr>
              <td>Email Institucional </td>
              <td>&nbsp;</td>
              <td><label></label></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><input name="txtEmailInstitucional" type="text" id="txtEmailInstitucional" style="width:590px" /></td>
              </tr>
          </table>
		  <div style="height:10px"></div>
		  <DIV style="width:595px; text-align:right">
		    <input type="submit" name="Submit2" value="Aceptar" />
		    &nbsp;&nbsp;&nbsp;<input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acaalumno.php&quot;'/>
		  </DIV>
		</form>
		<br />
		<span><? echo $_SESSION['TablaAlumno']; ?></span>
		<? 
		$_SESSION['TablaAlumno']=NULL;
		unset($_SESSION['TablaAlumno']); 
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

mysql_free_result($rsTipoDocumento);

mysql_free_result($rsTipoPersonal);

mysql_free_result($rsDepartamento);

mysql_free_result($rsProvincia);

mysql_free_result($rsDistrito);
?>
