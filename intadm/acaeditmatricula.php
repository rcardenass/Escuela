<?php include("../seguridad.php");?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$rsEditar = $objDatos->ObtenerMatriculaSelId($_GET['Codigo']);
$rowEditar = $objDatos->PoblarMatriculaSelId($rsEditar);

$rsAnio = $objDatos->ObtenerAnioTodosSelAll();
$rowAnio = $objDatos->PoblarAnioTodosSelAll($rsAnio);

$rsGrado = $objDatos->ObtenerGradoSelId($rowEditar['CodGrado']);
$rowGrado = $objDatos->PoblarGradoSelId($rsGrado);

$rsSeccion = $objDatos->ObtenerSeccionGradoSelAll2($rowEditar['CodGrado']);
$rowSeccion = $objDatos->PoblarSeccionGradoSelAll2($rsSeccion);
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
		<h1>Editar Matricula</h1>
		<hr /><br />	
		<form action="acaupdatematricula.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('txtAlumno','','R','cboAnio','','RisNum','cboGrado','','RisNum','cboSeccion','','RisNum','cboTurno','','R');return document.MM_returnValue" autocomplete="Off">
		  <table width="426" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="170">Alumno</td>
              <td width="150">
			  <input name="txtCodigoAlumno" type="hidden" id="txtCodigoAlumno" value="<?php echo $rowEditar['CodAlumno']; ?>" />
              <input name="txtCodigoMatricula" type="hidden" id="txtCodigoMatricula" value="<?php echo $rowEditar['CodMatricula']; ?>" />
			  </td>
            </tr>
            <tr>
              <td colspan="2"><label>
                <input name="txtAlumno" type="text" id="txtAlumno" style="width:380px" disabled="disabled" 
				value="<?php echo strtoupper($rowEditar['Alumno']); ?>" />&nbsp;
            	<div style="width:32px; float:right">
              	<img src="../imagenes/icono/user.png" width="32" border="0" title="Buscar Alumno"/>
			  	</div>
			</label>
			</td>
            </tr>
            <tr>
              <td>A&ntilde;o</td>
              <td>Grado</td>
            </tr>
            <tr>
              <td>
			  <select name="cboAnio" id="cboAnio" style="width:150px" disabled="disabled">
              <option value="" <?php if (!(strcmp("", $rowEditar['CodAnio']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
              <?php 
			  do {  
			  ?>
			  	<option value="<?php echo $rowAnio['CodAnio']?>"
				<?php if (!(strcmp($rowAnio['CodAnio'], $rowEditar['CodAnio']))) {echo "selected=\"selected\"";} ?>>
				<?php echo $rowAnio['NombreAnio']?></option>
			  <?php 
			  } while($rowAnio = $objDatos->PoblarAnioTodosSelAll($rsAnio)); 
			  ?>
              </select>
			  </td>
              <td>
                <select name="cboGrado" id="cboGrado" style="width:250px" disabled="disabled">
                <option value="" <?php if (!(strcmp("", $rowEditar['CodGrado']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
				<?php
				do {  
				?><option value="<?php echo $rowGrado['CodGrado']?>"
				<?php if (!(strcmp($rowGrado['CodGrado'], $rowEditar['CodGrado']))) {echo "selected=\"selected\"";} ?>>
				<?php echo $rowGrado['NombreGrado']?></option>
				<?php
				} while ($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado));
				?>
                </select>
            	</td>
            </tr>
            <tr>
              <td>Secci&oacute;n</td>
              <td>Turno</td>
            </tr>
            <tr>
              <td><label>
				<select name="cboSeccion" id="cboSeccion" style="width:150px">
                <option value="" <?php if (!(strcmp("", $rowEditar['CodSeccion']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
				<?php
				do {  
				?><option value="<?php echo $rowSeccion['CodSeccion']?>"
				<?php if (!(strcmp($rowSeccion['CodSeccion'], $rowEditar['CodSeccion']))) {echo "selected=\"selected\"";} ?>>
				<?php echo $rowSeccion['NombreSeccion']?></option>
				<?php
				} while ($rowSeccion = $objDatos->PoblarSeccionGradoSelAll2($rsSeccion));
				?>
                </select>
              </label></td>
              <td><label>
                <select name="cboTurno" id="cboTurno" style="width:250px">
                  <option value="" <?php if (!(strcmp("", $rowEditar['Turno']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                  <option value="M" <?php if (!(strcmp("M", $rowEditar['Turno']))) {echo "selected=\"selected\"";} ?>>Ma&ntilde;ana</option>
                  <option value="T" <?php if (!(strcmp("T", $rowEditar['Turno']))) {echo "selected=\"selected\"";} ?>>Tarde</option>
                  <option value="N" <?php if (!(strcmp("N", $rowEditar['Turno']))) {echo "selected=\"selected\"";} ?>>Noche</option>
              </select>
              </label></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </table>
	  <div style="width:422px; text-align:right"><input type="submit" name="Submit" value="Aceptar" />&nbsp;&nbsp;&nbsp;<input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acamatricula.php&quot;'/></div>
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
mysql_free_result($rsEditar);
?>
