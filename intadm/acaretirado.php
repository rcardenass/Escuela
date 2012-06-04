<?php include("../seguridad.php");?>
<?php include("../funciones.php"); ?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$rsAnio = $objDatos->ObtenerAnioTodosSelAll();
$rowAnio = $objDatos->PoblarAnioTodosSelAll($rsAnio);
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
<script language="javascript">
$(document).ready(function() {
    $().ajaxStart(function() {
        $('#loading').show();
        $('#lista').hide();
    }).ajaxStop(function() {
        $('#loading').hide();
        $('#lista').fadeIn('slow');
    });
    $('#form, #fat, #form1').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#lista').html(data);

            }
        })
        
        return false;
    }); 
})  
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
		<h1>Alumnos Retirados</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="php/acaretirado.php">
		  <table width="450PX" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="80"><span class="label">A&ntilde;o</span></td>
              <td><span class="label">Alumno</span></td>
              <td>&nbsp;</td>
              <td width="40">&nbsp;</td>
            </tr>
            <tr>
              <td width="80"><label>
                <select name="cboAnio" id="cboAnio" style="width:70px">
				<? do{ ?>
				<option value="<? echo $rowAnio['CodAnio']; ?>"><? echo $rowAnio['NombreAnio']; ?></option>
				<? }while($rowAnio = $objDatos->PoblarAnioTodosSelAll($rsAnio));?>
                </select>
              </label></td>
              <td><label>
                <input name="txtBuscar" type="text" id="txtBuscar" style="width:250px"/>
              </label></td>
              <td align="right">
                <label>
                <input type="submit" name="Submit" value="Buscar" />
                </label></td>
              <td width="40" align="right"><a href="acanewretiro.php"><img src="../imagenes/icono/add.png" border="0" width="31" title="Agregar nuevo Retiro"/></a></td>
            </tr>
          </table>
		  <div style="height:5px"></div>
		<div id="lista" style="width:95%"></div>
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
?>
