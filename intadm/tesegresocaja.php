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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templateadm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Gestion Escolar</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<script src="../js/jquery.js" type="text/javascript"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$("#btBuscar").click(function (){
	   var datos = $("#form1").serialize();//Serializamos los datos a enviar
	   $.ajax({
	   type: "POST", //Establecemos como se van a enviar los datos puede POST o GET
	   url: "php/tesegresocaja.php", //SCRIPT que procesara los datos, establecer ruta relativa o absoluta
	   data: datos, //Variable que transferira los datos
	   contentType: "application/x-www-form-urlencoded", //Tipo de contenido que se enviara
	   beforeSend: function() {//Funci�n que se ejecuta antes de enviar los datos
		  $("#lista").html("Procesando...."); //Mostrar mensaje que se esta procesando el script
	   },
	   dataType: "html",
	   success: function(datos){ //Funcion que retorna los datos procesados del script PHP
		   $('#lista').html(datos);
	   }
	   });
	});
});
</script>
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
		<h1>Egresos de Caja</h1><hr /><br />
		<form action="" method="post" name="form1" id="form1" autocomplete="Off">
		  <table width="260" border="0" cellspacing="0" cellpadding="0">
			<tr>
                            <td width="90"><span class="label">Fecha</span></td>
			  <td width="210"><span class="label">Caja</span></td>
			  <td>&nbsp;</td>
                          <td width="60">&nbsp;</td>
			</tr>
			<tr>
			  <td width="110">
				<input name="txtFecha" type="widget" value="" size="10" subtype="smartdate" mask="DD/MM/YYYY" />
			  </td>
			  <td width="210">
				<input name="txtCaja" type="widget" value="" size="5" subtype="numericInput" negative="false" allowfloat="false" width="15px"/>
			  </td>
			  <td align="right">
				<input type="button" id="btBuscar" name="btBuscar" value="Buscar" />
			  </td>
                          <td width="60" align="right">
                              <a href="tesnewegresocaja.php"><img src="../imagenes/icono/add.png" width="30" border="0" /></a>
			  </td>
			</tr>
		  </table>
		  <div style="height:5px"></div>
		  <div id="lista" style="width:98%"></div>
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
  require_once("../includes/widgets/widgets_end.php");
?>
<?php
mysql_free_result($rsTreeview);
?>
