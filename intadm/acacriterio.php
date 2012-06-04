<?php include("../seguridad.php");?>
<?php include('funciones.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$_SESSION['Anio']=$_POST['cboAnio'];
$_SESSION['Area']=$_POST['cboArea'];
$_SESSION['Grado']=$_POST['cboGrado'];

$rsAnio = $objDatos->ObtenerAnioSelAll();
$rowAnio = $objDatos->PoblarAnioSelAll($rsAnio);

$rsArea = $objDatos->ObtenerAreaSelAll();
$rowArea = $objDatos->PoblarAreaSelAll($rsArea);

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);

$rsCriterio = $objDatos->ObtenerCriterioSelAll($_SESSION['Anio'],$_SESSION['Area'],$_SESSION['Grado']);
$rowCriterio = $objDatos->PoblarCriterioSelAll($rsCriterio);
$totalRows_rsCriterio = mysql_num_rows($rsCriterio);
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
		<h1>Criterio</h1><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="acacriterio.php">
		<table width="570" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  	<td width="90"><span class="label">Año</span></td>
            <td><span class="label">Grado</span></td>
			<td><span class="label">Area</span></td>
            <td width="70" align="right">&nbsp;</td>
          </tr>
          <tr>
            <td width="90">
			<select name="cboAnio" id="cboAnio" style="width:80px">
             <?php
			do {  
			?>
			<option value="<?php echo $rowAnio['CodAnio']?>"
			<?php if (!(strcmp($rowAnio['CodAnio'], $_SESSION['Anio']))) {echo "selected=\"selected\"";} ?>>
			<?php echo $rowAnio['NombreAnio']?></option>
            <?php
			} while ($rowAnio = $objDatos->PoblarAnioSelAll($rsAnio));
?>
            </select>
			</td>
            <td>
            <select name="cboGrado" id="cboGrado" style="width:200px">
            <option value="" <?php if (!(strcmp("", $_SESSION['Grado']))) {echo "selected=\"selected\"";} ?>></option>
            <?php
			do {  
			?>
			<option value="<?php echo $rowGrado['CodGrado']?>"
			<?php if (!(strcmp($rowGrado['CodGrado'], $_SESSION['Grado']))) {echo "selected=\"selected\"";} ?>>
			<?php echo $rowGrado['NombreGrado']?></option>
            <?php
			} while ($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado));
			?>
            </select>
            </td>
			<td>
            <select name="cboArea" id="cboArea" style="width:200px">
            <option value="" <?php if (!(strcmp("", $_SESSION['Area']))) {echo "selected=\"selected\"";} ?>></option>
            <?php
			do {  
			?>
			<option value="<?php echo $rowArea['CodArea']?>"
			<?php if (!(strcmp($rowArea['CodArea'], $_SESSION['Area']))) {echo "selected=\"selected\"";} ?>>
			<?php echo $rowArea['NombreArea']?></option>
            <?php
			} while ($rowArea = $objDatos->PoblarAreaSelAll($rsArea));
			?>
            </select>
            </td>
            <td width="70" align="right"><input type="submit" name="Submit" value="Buscar" /></td>
          </tr>
        </table>
		<div style="height:5px"></div>
		<table class="table" width="98%" border="0" cellspacing="2" cellpadding="0">
          <tr class="tr">
            <td width="40"><div style="float:right; text-align:right; padding-right:5px">Id</div></td>
            <td width="40" align="center">A&ntilde;o</td>
			<td>Grado</td>
			<td>Area</td>
            <td>Criterio</td>
            <td width="30" align="center">%</td>
            <td colspan="2" align="center"><a href="acanewcriterio.php"><img src="../imagenes/icono/add.png" width="32" border="0"/></a></td>
          </tr>
          <?php 
		  if(!empty($totalRows_rsCriterio)){
		  do { 
		  ?>
            <? Filas();?>
              <td width="40" align="left"><div style="text-align:right; padding-right:5px"><strong><?php echo $rowCriterio['CodCriterio']; ?></strong></div></td>
              <td width="40" align="center"><?php echo $rowCriterio['NombreAnio']; ?></td>
              <td><?php echo $rowCriterio['NombreGrado']; ?></td>
			  <td><?php echo $rowCriterio['NombreArea']; ?></td>
              <td><?php echo $rowCriterio['NombreCriterio']; ?></td>
              <td width="30" align="center"><?php echo $rowCriterio['Porcentaje']; ?></td>
              <td width="30" align="center"><a href="acacriteriodetalle.php?Codigo=<?php echo $rowCriterio['CodCriterio']; ?>" rel="gb_page_center[650, 300]" title="Detalle de Cursos por Criterio"><img src="../imagenes/icono/search.png" width="22" border="0"/></a></td>
              <td width="30" align="center"><a href="acaeditcriterio.php?Codigo=<?php echo $rowCriterio['CodCriterio']; ?>"><img src="../imagenes/icono/edit.png" width="22" border="0" title="Editar"/></a></td>
            </tr>
            <?php 
			} while ($rowCriterio = $objDatos->PoblarCriterioSelAll($rsCriterio)); 
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

mysql_free_result($rsArea);

mysql_free_result($rsGrado);

mysql_free_result($rsCriterio);
?>
