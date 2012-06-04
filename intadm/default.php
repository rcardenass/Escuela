<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php include('../funciones.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

mysql_select_db($database_cn, $cn);
$query_rsMensajes = "SELECT a.CodMensaje, a.De, a.Asunto, DATE_FORMAT(a.FechaEnvio,'%d/%m/%Y') as FechaEnvio FROM mensaje a INNER JOIN usuario b ON b.Login=a.Para WHERE a.Para='".$_SESSION['MM_Username']."' ";
$rsMensajes = mysql_query($query_rsMensajes, $cn) or die(mysql_error());
$row_rsMensajes = mysql_fetch_assoc($rsMensajes);
$totalRows_rsMensajes = mysql_num_rows($rsMensajes);
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

<link href="../includes/jaxon/widgets/tabset/css/tabset.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../includes/kore/kore.js"></script>
<script type="text/javascript" src="../includes/jaxon/widgets/tabset/js/tabset.js"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
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
		<h1>Bienvenidos</h1><hr /><br />
		<div id="Principal" class="tabset htmlrendering" style="width:750px;height:300px;">
		  <ul class="tabset_tabs">
			<li id="Principaltab1-tab" class="tab selected"><a href="#">Mensajes</a></li>
			<li id="Principaltab2-tab" class="tab"><a href="#">Reglamento</a></li>
			<li id="Principaltab3-tab" class="tab"><a href="#">Cumplea&ntilde;os</a></li>
		  </ul>
		  <div id="Principaltab0-body" class="tabBody body_active">
			<div class="tabContent"> 
			<div style="height:5px"></div> 
			<table class="table" width="99%" border="0" cellpadding="0" cellspacing="2">
			<tr class="tr">
				<td width="100px">De</td>
				<td>Asunto</td>
				<td width="100px">Fecha</td>
                                <td width="30px" align="center"><a href="menlistausuario.php"><img src="../imagenes/icono/add.png" width="25" border="0" title="Nuevo Mensaje"/></a></td>
			</tr>
			<? if($totalRows_rsMensajes==0){ ?>
			<tr>
				<td colspan="4"><div style="width:100%">No hay mensajes</div></td>
			</tr>
			<? } ?>
			<? if($totalRows_rsMensajes>0){ ?>
			<? do{ ?>
			<? Filas();?>
				<td width="100px"><? echo $row_rsMensajes['De']; ?></td>
				<td><strong><? echo $row_rsMensajes['Asunto']; ?></strong></td>
				<td width="100px"><? echo $row_rsMensajes['FechaEnvio']; ?></td>
				<td width="30px" align="center">
				<a href="mendetallemensaje.php?Codigo=<?php echo $row_rsMensajes['CodMensaje']; ?>" rel="gb_page_center[520, 320]" 
					title="Detalle de Mensaje">
					<img src="../imagenes/icono/search.png" width="22" border="0" title="Ver"/></a>
				</td>
			</tr>
			<? } while($row_rsMensajes = mysql_fetch_assoc($rsMensajes)); ?>
			<? } ?>
			</table>
			</div>
		  </div>
		  <div id="Principaltab1-body" class="tabBody">
			<div class="tabContent"> &quot;Mensajes&quot; region content here. </div>
		  </div>
		  <div id="Principaltab2-body" class="tabBody">
			<div class="tabContent"> &quot;Reglamento&quot; region content here. </div>
		  </div>
		</div>
		<script type="text/javascript">
			var Principal = new Widgets.Tabset('Principal', null);
		</script>
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
mysql_free_result($rsMensajes);
?>