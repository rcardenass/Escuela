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
//$query_rsAnio = "SELECT CodAnio, NombreAnio FROM anio WHERE Estado = 1 ORDER BY NombreAnio DESC";
$query_rsAnio = "SELECT CodAnio, NombreAnio FROM anio ORDER BY NombreAnio DESC";
$rsAnio = mysql_query($query_rsAnio, $cn) or die(mysql_error());
$row_rsAnio = mysql_fetch_assoc($rsAnio);
$totalRows_rsAnio = mysql_num_rows($rsAnio);

mysql_select_db($database_cn, $cn);
//$query_rsGrado = "SELECT CodGrado, NombreGrado FROM grado WHERE Estado = 1 ORDER BY CodNivel ASC";
$query_rsGrado = "SELECT a.CodGrado, concat(rtrim(b.NombreNivel),'  ',rtrim(a.NombreGrado)) AS NombreGrado FROM grado a INNER JOIN nivel b ON b.CodNivel=a.CodNivel WHERE a.Estado = 1 AND b.Estado=1 ORDER BY a.CodNivel ASC";
$rsGrado = mysql_query($query_rsGrado, $cn) or die(mysql_error());
$row_rsGrado = mysql_fetch_assoc($rsGrado);
$totalRows_rsGrado = mysql_num_rows($rsGrado);

mysql_select_db($database_cn, $cn);
$query_rsSeccion = "SELECT a.CodSeccion, a.NombreSeccion, b.CodGrado FROM seccion a INNER JOIN gradoseccion b ON b.CodSeccion=a.CodSeccion where a.Estado=1 and b.Estado=1";
$rsSeccion = mysql_query($query_rsSeccion, $cn) or die(mysql_error());
$row_rsSeccion = mysql_fetch_assoc($rsSeccion);
$totalRows_rsSeccion = mysql_num_rows($rsSeccion);

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
<script type="text/JavaScript" src="../validar.js"></script>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/NumericInput.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<?php
//begin JSRecordset
$jsObject_rsSeccion = new WDG_JsRecordset("rsSeccion");
echo $jsObject_rsSeccion->getOutput();
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
		<h1>Nueva Programación de Pensiones</h1><hr /><br />
		<form action="facinsertpension.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('cboAnio','','RisNum','cboGrado','','RisNum','cboSeccion','','RisNum','txtMora','','RisNum','txtNroMeses','','RisNum');return document.MM_returnValue" autocomplete="Off">
          <table width="300" border="0" cellspacing="1" cellpadding="0"> 
            <tr>
              <td width="90">A&ntilde;o</td>
              <td width="207"><label>
                <select name="cboAnio" id="cboAnio" style="width:70px">
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsAnio['CodAnio']?>"><?php echo $row_rsAnio['NombreAnio']?></option>
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
                <select name="cboGrado" id="cboGrado" style="width:200px">
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsGrado['CodGrado']?>"><?php echo $row_rsGrado['NombreGrado']?></option>
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
                <select name="cboSeccion" id="cboSeccion" style="width:200px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsSeccion" wdg:displayfield="NombreSeccion" wdg:valuefield="CodSeccion" wdg:fkey="CodGrado" wdg:triggerobject="cboGrado">
                </select>
              </label></td>
            </tr>
            <tr>
              <td>Genera Mora </td>
              <td><select name="cboFlagMora" id="cboFlagMora" style="width:100px">
                <option value="0">Sin Mora</option>
                <option value="1">Con Mora</option>
                            </select></td>
            </tr>
            <tr>
              <td>Mora</td>
              <td><input name="txtMora" id="txtMora" style="width:50px" value="" maxlength="7" wdg:negatives="no" wdg:subtype="NumericInput" wdg:type="widget" wdg:floats="yes" wdg:spinner="no"/></td>
            </tr>
            <tr>
              <td>Nro Meses </td>
              <td><label>
                <input name="txtNroMeses" type="text" id="txtNroMeses" maxlength="2" style="width:50px"/>
              </label></td>
            </tr>
          </table>
		  <div style="width:290px; text-align:right">
			  <input type="submit" name="Submit" value="Aceptar" />&nbsp;&nbsp;
	    <input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;facpension.php&quot;'/>
		  </div>
		</form>
		<br />
		<span><? echo $_SESSION['TablaPension']; ?></span>
		<? 
		$_SESSION['TablaPension']=NULL;
		unset($_SESSION['TablaPension']); 
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

mysql_free_result($rsAnio);

mysql_free_result($rsGrado);

mysql_free_result($rsSeccion);
?>
