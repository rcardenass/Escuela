<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?><?php include("../seguridad.php");?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$rsAnio = $objDatos->ObtenerAnioSelAll();
$rowAnio = $objDatos->PoblarAnioSelAll($rsAnio);

$rsArea = $objDatos->ObtenerAreaSelAll();
$rowArea = $objDatos->PoblarAreaSelAll($rsArea);

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets"><!-- InstanceBegin template="/Templates/templateadm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Gestion Escolar</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<script type="text/JavaScript" src="../validar.js"></script>
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
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/NumericInput.js"></script>
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
		<div style="height:10px"></div>		</td>
		<td valign="top" class="Contenedor">
		<div style = "width: 99%; padding-left:5px" class="Contenedor">
		<!-- InstanceBeginEditable name="Contenido" -->
		<h1>Nuevo Criterio</h1>
		<hr /><br />
		<form id="form1" name="form1" method="post" action="php/acalistanewcriterio.php" onsubmit="MM_validateForm('cboAnio','','RisNum','cboGrado','','RisNum','cboArea','','RisNum','txtNroCriterio','','R');return document.MM_returnValue" autocomplete="Off">
		<table width="700" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="110">A&ntilde;o</td>
            <td width="210">Grado</td>
            <td width="210">Area</td>
            <td width="80">N&ordf; Criterio </td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="110"><select name="cboAnio" id="cboAnio" style="width:100px">
              <option value="">Seleccione</option>
              <?php
do {  
?>
              <option value="<?php echo $rowAnio['CodAnio']?>"><?php echo $rowAnio['NombreAnio']?></option>
              <?php
} while ($rowAnio = $objDatos->PoblarAnioSelAll($rsAnio));
?>
            </select></td>
            <td width="210"><select name="cboGrado" id="cboGrado" style="width:200px">
              <option value="">Seleccione</option>
              <?php
do {  
?>
              <option value="<?php echo $rowGrado['CodGrado']?>"><?php echo $rowGrado['NombreGrado']?></option>
              <?php
} while ($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado));
?>
            </select></td>
            <td width="210"><select name="cboArea" id="cboArea" style="width:200px">
              <option value="">Seleccione</option>
              <?php
do {  
?>
              <option value="<?php echo $rowArea['CodArea']?>"><?php echo $rowArea['NombreArea']?></option>
              <?php
} while ($rowArea = $objDatos->PoblarAreaSelAll($rsArea));
?>
            </select></td>
            <td width="80"><label>
              <input name="txtNroCriterio" id="txtNroCriterio" style="width:50px" value="" maxlength="2" wdg:negatives="no" wdg:subtype="NumericInput" wdg:type="widget" wdg:floats="no" wdg:spinner="no" />
            </label></td>
            <td>
              <input type="submit" name="Submit" value="Listar" />
            </td>
          </tr>
        </table>
		<div style="height:5px"></div>
		<div id="lista" style="width:95%"></div>
        </form>		
		<!-- InstanceEndEditable -->		</div>
		<div style="height:10px"></div>		</td>
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
