<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php include('funciones.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$_SESSION['Anio']=$_POST['cboAnio'];
$_SESSION['Grado']=$_POST['cboGrado'];
$_SESSION['Seccion']=$_POST['cboSeccion'];

mysql_select_db($database_cn, $cn);
$query_rsAnio = "SELECT CodAnio, NombreAnio FROM anio ORDER BY CodAnio desc";
$rsAnio = mysql_query($query_rsAnio, $cn) or die(mysql_error());
$row_rsAnio = mysql_fetch_assoc($rsAnio);
$totalRows_rsAnio = mysql_num_rows($rsAnio);

mysql_select_db($database_cn, $cn);
//$query_rsGrado = "SELECT CodGrado, NombreGrado FROM grado WHERE Estado = 1 ORDER BY CodNivel ASC";
$query_rsGrado = "SELECT a.CodGrado, concat(rtrim(b.NombreNivel),'  ',rtrim(a.NombreGrado)) AS NombreGrado FROM grado a INNER JOIN nivel b ON b.CodNivel=a.CodNivel WHERE a.Estado = 1 AND b.Estado=1 ";
$rsGrado = mysql_query($query_rsGrado, $cn) or die(mysql_error());
$row_rsGrado = mysql_fetch_assoc($rsGrado);
$totalRows_rsGrado = mysql_num_rows($rsGrado);

mysql_select_db($database_cn, $cn);
$query_rsSeccion = "SELECT a.CodSeccion, a.NombreSeccion, b.CodGrado FROM seccion a INNER JOIN gradoseccion b ON b.CodSeccion=a.CodSeccion where a.Estado=1 and b.Estado=1";
$rsSeccion = mysql_query($query_rsSeccion, $cn) or die(mysql_error());
$row_rsSeccion = mysql_fetch_assoc($rsSeccion);
$totalRows_rsSeccion = mysql_num_rows($rsSeccion);

mysql_select_db($database_cn, $cn);
/*$query_rsPension = "SELECT d.NombreAnio,b.NombreGrado,c.NombreSeccion, a.FlagMora,a.Mora,a.Estado FROM pensiones a INNER JOIN grado b ON b.CodGrado=a.CodGrado INNER JOIN seccion c ON c.CodSeccion=a.CodSeccion INNER JOIN anio d ON d.CodAnio=a.CodAnio WHERE a.CodAnio='10'";*/
$query_rsPension = "SELECT a.CodPension, d.NombreAnio,concat(e.NombreNivel,' ',b.NombreGrado) as NombreGrado ,c.NombreSeccion, ";
$query_rsPension .= "case a.FlagMora when 1 then 'Si' else 'No' end as FlagMora ,a.Mora, case a.Estado when 0 then 'Desactivado' when 1 then 'Activado' end as Estado, case Aprobar when 0 then 'Pendiente' when 1 then 'Aprobado' end as Aprobar ";
$query_rsPension .= "FROM pensiones a ";
$query_rsPension .= "INNER JOIN grado b ON b.CodGrado=a.CodGrado ";
$query_rsPension .= "INNER JOIN seccion c ON c.CodSeccion=a.CodSeccion ";
$query_rsPension .= "INNER JOIN anio d ON d.CodAnio=a.CodAnio ";
$query_rsPension .= "inner join nivel e on e.CodNivel=b.CodNivel ";
$query_rsPension .= "WHERE a.CodAnio='".$_SESSION['Anio']."' ";
$query_rsPension .= "and (a.CodGrado='".$_SESSION['Grado']."' or ''='".$_SESSION['Grado']."') ";
$query_rsPension .= "and (a.CodSeccion='".$_SESSION['Seccion']."' or ''='".$_SESSION['Seccion']."') ";
$rsPension = mysql_query($query_rsPension, $cn) or die(mysql_error());
$row_rsPension = mysql_fetch_assoc($rsPension);
$totalRows_rsPension = mysql_num_rows($rsPension);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templateadm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Gestion Escolar</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>

<script type="text/javascript">
    /*var GB_ROOT_DIR = "http://mydomain.com/greybox/";*/
	var GB_ROOT_DIR = "../greybox/"
</script>
<script type="text/javascript" src="../greybox/AJS.js"></script>
<script type="text/javascript" src="../greybox/AJS_fx.js"></script>
<script type="text/javascript" src="../greybox/gb_scripts.js"></script>
<link href="../greybox/gb_styles.css" rel="stylesheet" type="text/css" />

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
		<h1>Programación de Pensiones</h1><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="facpension.php">
		  <table width="510" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td>A&ntilde;o</td>
              <td>Grado</td>
              <td>Secci&oacute;n</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboAnio" id="cboAnio" style="width:70px">
                  <?php
do {  
?><option value="<?php echo $row_rsAnio['CodAnio']?>"<?php if (!(strcmp($row_rsAnio['CodAnio'], $_SESSION['Anio']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsAnio['NombreAnio']?></option>
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
              <td><label>
                <select name="cboGrado" id="cboGrado" style="width:200px">
                  <option value="" <?php if (!(strcmp("", $_SESSION['Grado']))) {echo "selected=\"selected\"";} ?>></option>
                  <?php
do {  
?><option value="<?php echo $row_rsGrado['CodGrado']?>"<?php if (!(strcmp($row_rsGrado['CodGrado'], $_SESSION['Grado']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsGrado['NombreGrado']?></option>
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
              <td><label>
              <select name="cboSeccion" id="cboSeccion" style="width:150px; height:20px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsSeccion" wdg:displayfield="NombreSeccion" wdg:valuefield="CodSeccion" wdg:fkey="CodGrado" wdg:triggerobject="cboGrado" wdg:selected="<?php echo $_SESSION['Seccion'] ?>">
			  <option value=""></option>
              </select>
              </label></td>
              <td align="right">
                <input type="submit" name="Submit" value="Buscar" />			  </td>
            </tr>
          </table>
		<br />
		<table width="700" class="table" border="0" cellspacing="1" cellpadding="0">
          <tr class="tr">
            <td width="50">A&ntilde;o</td>
            <td>Grado</td>
            <td>Secci&oacute;n</td>
            <td width="100">Genera Mora</td>
            <td width="80">Mora</td>
            <td width="80">Estado</td>
			<td width="70">Aprobar</td>
			<td colspan="2" align="center"><a href="facnewpension.php"><img src="../imagenes/icono/add.png" width="32" border="0"/></a></td>
          </tr>
          <?php 
		  if(!empty($totalRows_rsPension)){
		  do { 
		  ?>
          <? Filas();?>
            <td width="50"><?php echo $row_rsPension['NombreAnio']; ?></td>
            <td><?php echo $row_rsPension['NombreGrado']; ?></td>
            <td><?php echo $row_rsPension['NombreSeccion']; ?></td>
            <td width="100"><?php echo $row_rsPension['FlagMora']; ?></td>
            <td width="80"><?php echo $row_rsPension['Mora']; ?></td>
            <td width="80"><?php echo $row_rsPension['Estado']; ?></td>
			<td width="70"><?php echo $row_rsPension['Aprobar']; ?></td>
			<td width="30" align="center">
					<a href="faceditpension.php?Codigo=<?php echo $row_rsPension['CodPension']; ?>">
					<img src="../imagenes/icono/edit.png" width="22" border="0" title="Editar"/></a>			</td>
			<td width="30" align="center">
					<a href="facdetallepension.php?Codigo=<?php echo $row_rsPension['CodPension']; ?>" rel="gb_page_center[520, 320]" 
					title="Detalle de Programación de Pensiones">
					<img src="../imagenes/icono/search.png" width="22" border="0" title="Ver"/></a>			</td>
          </tr>
            <?php 
			} while ($row_rsPension = mysql_fetch_assoc($rsPension)); 
			}
			?>
        </table>
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

mysql_free_result($rsPension);
?>
