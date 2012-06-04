<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

mysql_select_db($database_cn, $cn);
$query_rsAnio = "SELECT CodAnio, NombreAnio FROM anio WHERE Estado = 1 ORDER BY NombreAnio DESC";
$rsAnio = mysql_query($query_rsAnio, $cn) or die(mysql_error());
$row_rsAnio = mysql_fetch_assoc($rsAnio);
$totalRows_rsAnio = mysql_num_rows($rsAnio);

mysql_select_db($database_cn, $cn);
$query_rsGrado = "SELECT a.CodGrado, concat(rtrim(b.NombreNivel),'  ',rtrim(a.NombreGrado)) AS NombreGrado FROM grado a INNER JOIN nivel b ON b.CodNivel=a.CodNivel WHERE a.Estado = 1 AND b.Estado=1 ORDER BY a.CodNivel ASC";
$rsGrado = mysql_query($query_rsGrado, $cn) or die(mysql_error());
$row_rsGrado = mysql_fetch_assoc($rsGrado);
$totalRows_rsGrado = mysql_num_rows($rsGrado);

mysql_select_db($database_cn, $cn);
$query_rsSeccion = "SELECT a.CodSeccion, a.NombreSeccion, b.CodGrado FROM seccion a INNER JOIN gradoseccion b ON b.CodSeccion=a.CodSeccion where a.Estado=1 and b.Estado=1";
$rsSeccion = mysql_query($query_rsSeccion, $cn) or die(mysql_error());
$row_rsSeccion = mysql_fetch_assoc($rsSeccion);
$totalRows_rsSeccion = mysql_num_rows($rsSeccion);

mysql_select_db($database_cn, $cn);
$query_rsEdit = "SELECT CodPension, CodAnio, CodGrado, CodSeccion, FlagMora, Mora, NroMeses, Estado, Aprobar, UsuarioModificacion, FechaModificacion FROM pensiones WHERE CodPension = '".$_GET['Codigo']."' ";
$rsEdit = mysql_query($query_rsEdit, $cn) or die(mysql_error());
$row_rsEdit = mysql_fetch_assoc($rsEdit);
$totalRows_rsEdit = mysql_num_rows($rsEdit);
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
<!-- InstanceEditableHeadTag -->
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rsSeccion = new WDG_JsRecordset("rsSeccion");
echo $jsObject_rsSeccion->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
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
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/NumericInput.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
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
		<h1>Editar Programación de Pensiones</h1><hr /><br />
		<form action="facupdatepension.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('cboAnio','','RisNum','cboGrado','','RisNum','cboSeccion','','RisNum','txtMora','','RisNum');return document.MM_returnValue" autocomplete="Off">
          <table width="300" border="0" cellspacing="1" cellpadding="0"> 
            <tr>
              <td width="90">A&ntilde;o</td>
              <td width="207"><label>
                <select name="cboAnio" id="cboAnio" style="width:70px" disabled="disabled">
                  <?php
do {  
?><option value="<?php echo $row_rsAnio['CodAnio']?>"<?php if (!(strcmp($row_rsAnio['CodAnio'], $row_rsEdit['CodAnio']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsAnio['NombreAnio']?></option>
                  <?php
} while ($row_rsAnio = mysql_fetch_assoc($rsAnio));
  $rows = mysql_num_rows($rsAnio);
  if($rows > 0) {
      mysql_data_seek($rsAnio, 0);
	  $row_rsAnio = mysql_fetch_assoc($rsAnio);
  }
?>
              </select>
              </label></td>
            </tr>
            <tr>
              <td>Grado</td>
              <td><label>
                <select name="cboGrado" id="cboGrado" style="width:200px" disabled="disabled">
                  <?php
do {  
?><option value="<?php echo $row_rsGrado['CodGrado']?>"<?php if (!(strcmp($row_rsGrado['CodGrado'], $row_rsEdit['CodGrado']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsGrado['NombreGrado']?></option>
                  <?php
} while ($row_rsGrado = mysql_fetch_assoc($rsGrado));
  $rows = mysql_num_rows($rsGrado);
  if($rows > 0) {
      mysql_data_seek($rsGrado, 0);
	  $row_rsGrado = mysql_fetch_assoc($rsGrado);
  }
?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td>Secci&oacute;n</td>
              <td><label>
              <select name="cboSeccion" disabled="disabled" id="cboSeccion" style="width:200px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsSeccion" wdg:displayfield="NombreSeccion" wdg:valuefield="CodSeccion" wdg:fkey="CodGrado" wdg:triggerobject="cboGrado" wdg:selected="<?php echo $row_rsEdit['CodSeccion']; ?>">
              </select>
              </label></td>
            </tr>
            <tr>
              <td>Genera Mora </td>
              <td><select name="cboFlagMora" id="cboFlagMora" style="width:100px" disabled="disabled">
                <option value="0" <?php if (!(strcmp(0, $row_rsEdit['FlagMora']))) {echo "selected=\"selected\"";} ?>>Sin Mora</option>
                <option value="1" <?php if (!(strcmp(1, $row_rsEdit['FlagMora']))) {echo "selected=\"selected\"";} ?>>Con Mora</option>
                            </select></td>
            </tr>
            <tr>
              <td>Mora</td>
              <td><input name="txtMora" id="txtMora" style="width:50px" value="<?php echo $row_rsEdit['Mora']; ?>" maxlength="7" wdg:negatives="no" wdg:subtype="NumericInput" wdg:type="widget" wdg:floats="yes" wdg:spinner="no" disabled="disabled"/></td>
            </tr>
            <tr>
              <td>Nro Meses </td>
              <td><label>
                <input name="txtNroMeses" type="text" disabled="disabled" id="txtNroMeses" style="width:50px" value="<?php echo $row_rsEdit['NroMeses']; ?>" maxlength="2"/>
              </label></td>
            </tr>
			<tr>
              <td>Estado 
              <input name="txtCodigoPension" type="hidden" id="txtCodigoPension" value="<?php echo $row_rsEdit['CodPension']; ?>" /></td>
              <td>
			  	<select name="cboEstado" id="cboEstado" style="width:100px" <?php if($row_rsEdit['Estado']==0){ echo 'disabled="disabled"'; } ?>>
                <option value="0" <?php if (!(strcmp(0, $row_rsEdit['Estado']))) {echo "selected=\"selected\"";} ?>>Desactivado</option>
                <option value="1" <?php if (!(strcmp(1, $row_rsEdit['Estado']))) {echo "selected=\"selected\"";} ?>>Activado</option>
                </select>
			  </td>
            </tr>
			<tr>
			  <td>Aprobar</td>
			  <td>
			    <select name="cboAprobar" id="cboAprobar" style="width:100px" <?php if($row_rsEdit['Estado']==0){ echo 'disabled="disabled"'; }else{ if($row_rsEdit['Aprobar']==1){ echo 'disabled="disabled"'; } } ?> >
			      <option value="0" <?php if (!(strcmp(0, $row_rsEdit['Aprobar']))) {echo "selected=\"selected\"";} ?>>Pendiente</option>
			      <option value="1" <?php if (!(strcmp(1, $row_rsEdit['Aprobar']))) {echo "selected=\"selected\"";} ?>>Aprobado</option>
              </select>
			  </td>
		    </tr>
			<tr>
			  <td>&nbsp;</td>
			  <td>&nbsp;</td>
		    </tr>
          </table>
		  <div style="width:290px; text-align:right">
		    <input type="submit" name="Submit" value="Aceptar" <?php if($row_rsEdit['Estado']==0){ echo 'disabled="disabled"'; } ?>/>
		    &nbsp;&nbsp;
	    <input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;facpension.php&quot;'/>
		  </div>
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

mysql_free_result($rsAnio);

mysql_free_result($rsGrado);

mysql_free_result($rsSeccion);

mysql_free_result($rsEdit);
?>