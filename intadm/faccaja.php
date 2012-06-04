<?php include("../seguridad.php");?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

if(!isset($_SESSION['CajaCodAlumno'])){
	$_SESSION['CajaCodAlumno']=$_GET['Codigo'];
}

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
		<h1>
		<div style="width:100%">
			<div style="width:300px; height:auto; float:left; padding-top:20px">Modulo de Caja</div>
			<div style="width:100px; height:auto; float:right; text-align:right">
				<a href="facalumno.php"><img src="../imagenes/icono/revert.png" border="0" title="Busca otro Alumno"/></a>
			</div>
		</div>
		 </h1><div style="height:30px"></div><hr /><br />
		 <table width="860" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="60" height="100" valign="top">
			<iframe name="Cabecera" id="Cabecera" src="faccabecera.php" width="600px" height="100px" marginheight="0" marginwidth="3" frameborder="0" scrolling="no"></iframe>
			</td>
            <td rowspan="2" valign="top"><iframe name="Concepto" id="Concepto" src="facconcepto2.php" width="260px" height="433px" marginheight="0" marginwidth="3" frameborder="0" scrolling="no"></iframe></td>
          </tr>
          <tr>
            <td width="60" height="330" valign="top">
			<iframe name="Item" id="Item" src="facitem2.php" width="600px" height="330px" marginheight="0" marginwidth="3" frameborder="0" scrolling="no"></iframe>
			</td>
          </tr>
        </table>
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
