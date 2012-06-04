<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$rsAnio = $objDatos->ObtenerAnioSelAll();
$rowAnio = $objDatos->PoblarAnioSelAll($rsAnio);

$rsArea = $objDatos->ObtenerAreaSelAll();
$rowArea = $objDatos->PoblarAreaSelAll($rsArea);

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);

$colname_rsEditar = "-1";
if (isset($_GET['Codigo'])) {
  $colname_rsEditar = (get_magic_quotes_gpc()) ? $_GET['Codigo'] : addslashes($_GET['Codigo']);
}
mysql_select_db($database_cn, $cn);
$query_rsEditar = sprintf("SELECT CodCriterio, CodAnio, CodArea, CodGrado, NombreCriterio, Porcentaje FROM criterio WHERE CodCriterio = %s", $colname_rsEditar);
$rsEditar = mysql_query($query_rsEditar, $cn) or die(mysql_error());
$row_rsEditar = mysql_fetch_assoc($rsEditar);
$totalRows_rsEditar = mysql_num_rows($rsEditar);
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
		<h1>Editar Criterio</h1>
		<hr />
		<br />
		<form action="acaupdatecriterio.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('cboAnio','','RisNum','cboArea','','RisNum','cboGrado','','RisNum','txtCriterio','','R','cboPorcentaje','','RisNum');return document.MM_returnValue" autocomplete="Off">
		  <table width="520" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="114">A&ntilde;o</td>
              <td width="214">Area</td>
              <td width="192">Grado</td>
            </tr>
            <tr>
              <td width="114">
              <select name="cboAnio" id="cboAnio" style="width:100px" disabled="disabled">
              <option value="" <?php if (!(strcmp("", $row_rsEditar['CodAnio']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
              <?php
			  do {  
			  ?>
			  <option value="<?php echo $rowAnio['CodAnio']?>"
			  <?php if (!(strcmp($rowAnio['CodAnio'], $row_rsEditar['CodAnio']))) {echo "selected=\"selected\"";} ?>>
			  <?php echo $rowAnio['NombreAnio']?></option>
              <?php
			  } while ($rowAnio = $objDatos->PoblarAnioSelAll($rsAnio));
			  ?>
              </select>              </td>
              <td width="214">
                <select name="cboArea" id="cboArea" style="width:200px" disabled="disabled">
                <option value="" <?php if (!(strcmp("", $row_rsEditar['CodArea']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                <?php
				do {  
				?><option value="<?php echo $rowArea['CodArea']?>"
				<?php if (!(strcmp($rowArea['CodArea'], $row_rsEditar['CodArea']))) {echo "selected=\"selected\"";} ?>>
				<?php echo $rowArea['NombreArea']?></option>
				<?php
				} while ($rowArea = $objDatos->PoblarAreaSelAll($rsArea));
				?>
                </select>              </td>
              <td width="192"><select name="cboGrado" id="cboGrado" style="width:200px" disabled="disabled">
                <option value="" <?php if (!(strcmp("", $row_rsEditar['CodGrado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                <?php
				do {  
				?>
                <option value="<?php echo $rowGrado['CodGrado']?>"
				<?php if (!(strcmp($rowGrado['CodGrado'], $row_rsEditar['CodGrado']))) {echo "selected=\"selected\"";} ?>> <?php echo $rowGrado['NombreGrado']?></option>
                <?php
				} while ($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado));
				?>
              </select></td>
            </tr>
            <tr>
              <td>Criterio</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="3"><input name="txtCriterio" type="text" id="txtCriterio" style="width:512px" value="<?php echo $row_rsEditar['NombreCriterio']; ?>"/>                <label></label></td>
            </tr>
            <tr>
              <td>Porcentaje</td>
              <td><input name="txtCodigoCriterio" type="hidden" id="txtCodigoCriterio" value="<?php echo $row_rsEditar['CodCriterio']; ?>" /></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboPorcentaje" id="cboPorcentaje" style="width:100px" disabled="disabled">
                  <option value="10" <?php if (!(strcmp(10, $row_rsEditar['Porcentaje']))) {echo "selected=\"selected\"";} ?>>Diez</option>
                  <option value="20" <?php if (!(strcmp(20, $row_rsEditar['Porcentaje']))) {echo "selected=\"selected\"";} ?>>Veinte</option>
                  <option value="30" <?php if (!(strcmp(30, $row_rsEditar['Porcentaje']))) {echo "selected=\"selected\"";} ?>>Treinta</option>
                  <option value="40" <?php if (!(strcmp(40, $row_rsEditar['Porcentaje']))) {echo "selected=\"selected\"";} ?>>Cuarenta</option>
                  <option value="50" <?php if (!(strcmp(50, $row_rsEditar['Porcentaje']))) {echo "selected=\"selected\"";} ?>>Cincuenta</option>
                  <option value="60" <?php if (!(strcmp(60, $row_rsEditar['Porcentaje']))) {echo "selected=\"selected\"";} ?>>Sesente</option>
                  <option value="70" <?php if (!(strcmp(70, $row_rsEditar['Porcentaje']))) {echo "selected=\"selected\"";} ?>>Setenta</option>
                  <option value="80" <?php if (!(strcmp(80, $row_rsEditar['Porcentaje']))) {echo "selected=\"selected\"";} ?>>Ochenta</option>
                  <option value="90" <?php if (!(strcmp(90, $row_rsEditar['Porcentaje']))) {echo "selected=\"selected\"";} ?>>Noventa</option>
                  <option value="100" <?php if (!(strcmp(100, $row_rsEditar['Porcentaje']))) {echo "selected=\"selected\"";} ?>>Cien</option>
              </select>
              </label></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
		  <DIV style="height:10px"></DIV>
		  <DIV style="width:518px; text-align:right">
		    <input type="submit" name="Submit2" value="Aceptar" />
		    &nbsp;&nbsp;&nbsp;<input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acacriterio.php&quot;'/>
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

mysql_free_result($rsAnio);

mysql_free_result($rsArea);

mysql_free_result($rsGrado);

mysql_free_result($rsEditar);
?>
