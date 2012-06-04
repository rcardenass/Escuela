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

$_SESSION['Grado']=$_POST['cboGrado'];

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);

$rsCursoGrado=$objDatos->ObtenerCursoGradolistaSelAll($_SESSION['Grado']);
$rowCursoGrado=$objDatos->PoblarCursoGradoListaSelAll($rsCursoGrado);
$totalRows_rsCursoGrado = mysql_num_rows($rsCursoGrado);
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
				<h1>Curso - Grado</h1><hr /><br />
				<form id="form1" name="form1" method="post" autocomplete="Off" action="">
		<table width="320px" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  	<td width="50"><span class="label">Grado</span></td>
            <td>
              <select name="cboGrado" id="cboGrado" style="width:200px">
			  <option value="" <?php if (!(strcmp("", $_SESSION['Grado']))) {echo "selected=\"selected\"";} ?>>SELECCIONE</option>
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
            <td align="right">
              <input type="submit" name="Submit" value="Buscar" />
            </td>
          </tr>
        </table>
		<div style="height:5px"></div>
		<table class="table" width="95%" border="0" cellspacing="2" cellpadding="0">
          <tr class="tr">
            <td width="50px"><div style="width:40px; float:right; text-align:right; padding-right:5px">Id</div></td>
            <td width="70px" align="center">Programa</td>
			<td width="110px">Grado</td>
			<td width="200px">Area</td>
			<td>Curso</td>
			<td width="35px" align="center"><a href="acanewcursogrado.php"><img src="../imagenes/icono/add.png" width="32" border="0"/></a></td>
          </tr>
            <?php 
			if(!empty($totalRows_rsCursoGrado)){
			do { 
			?>
              <? Filas();?>
                <td width="50px">
				<div style="width:40px; float:right; text-align:right; padding-right:5px">
				<strong><?php echo $rowCursoGrado['CodCurGra']; ?></strong></div>
				</td>
                <td width="70px" align="center"><?php echo $rowCursoGrado['Programa']; ?></td>
				<td width="110px"><?php echo $rowCursoGrado['NombreGrado']; ?></td>
				<td width="200px"><?php echo $rowCursoGrado['NombreArea']; ?></td>
                <td><?php echo $rowCursoGrado['NombreCurso']; ?></td>
                <td width="35px" align="center">
				<?php 
				if($rowCursoGrado['Estado']==1){
					echo "<img src='../imagenes/icono/checkin.png' width='18' border='0'/>";
				}else{
					echo "<img src='../imagenes/icono/deny.png' width='18' border='0'/>";
				}
				?>
				</td>
              </tr>
              <?php 
			  } while ($rowCursoGrado=$objDatos->PoblarCursoGradoListaSelAll($rsCursoGrado));
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

mysql_free_result($rsCursoGrado);

mysql_free_result($rsGrado);
?>
