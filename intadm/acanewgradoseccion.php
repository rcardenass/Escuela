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

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);

mysql_select_db($database_cn, $cn);
$query_rsSeccion = "SELECT CodSeccion, NombreSeccion FROM seccion where Estado=1 ORDER BY NombreSeccion ASC";
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
		<h1>Nuevo Grado-Secci�n</h1><hr /><br />	
		<form action="acainsertgradoseccion.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('cboGrado','','RisNum','cboSeccion','','RisNum');return document.MM_returnValue" autocomplete="Off">
		  <table width="480" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>Grado</td>
              <td>Secci&oacute;n</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboGrado" id="cboGrado" style="width:180px">
                <option value="">Seleccione</option>
                <?php
				do {  
				?>
                <option value="<?php echo $rowGrado['CodGrado']?>"><?php echo $rowGrado['NombreGrado']?></option>
                <?php
				} while ($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado));
				?>
              </select>
              </label></td>
              <td><label>
              <select name="cboSeccion" id="cboSeccion" style="width:150px">
                <option value="">Selecciones</option>
                <?php
do {  
?>
                <option value="<?php echo $row_rsSeccion['CodSeccion']?>"><?php echo $row_rsSeccion['NombreSeccion']?></option>
                <?php
} while ($row_rsSeccion = mysql_fetch_assoc($rsSeccion));
  $rows = mysql_num_rows($rsSeccion);
  if($rows > 0) {
      mysql_data_seek($rsSeccion, 0);
	  $row_rsSeccion = mysql_fetch_assoc($rsSeccion);
  }
?>
              </select>
              </label></td>
              <td align="right">
                <input type="submit" name="Submit" value="Aceptar" />              </td>
              <td align="right">
               <input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acagradoseccion.php&quot;'/>              </td>
            </tr>
          </table>
		</form>
		<br />
		<span><? echo $_SESSION['GradoSeccion']; ?></span>
		<? 
		$_SESSION['GradoSeccion']=NULL;
		unset($_SESSION['GradoSeccion']); 
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

mysql_free_result($rsGrado);

mysql_free_result($rsSeccion);
?>
