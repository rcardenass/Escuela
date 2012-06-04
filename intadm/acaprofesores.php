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

$_SESSION['Buscar']=$_POST['txtBuscar'];

mysql_select_db($database_cn, $cn);
$query_rsProfesor = "SELECT a.CodPersonal, Concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Profesor, a.Telefono, a.Celular FROM personal a WHERE CodTipoPersonal=2 AND Concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,'',a.Nombres) LIKE '%".$_SESSION['Buscar']."%' ";
$rsProfesor = mysql_query($query_rsProfesor, $cn) or die(mysql_error());
$row_rsProfesor = mysql_fetch_assoc($rsProfesor);
$totalRows_rsProfesor = mysql_num_rows($rsProfesor);
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
		<h1>Profesor</h1><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="">
		<table width="410px" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="55px"><span class="label">Buscar</span></td>
            <td width="220px">
              <input name="txtBuscar" type="text" id="txtBuscar" style="width:220px" maxlength="20" value="<? echo $_SESSION['Buscar'];?>" />
            </td>
            <td align="right">
              <input type="submit" name="Submit" value="Buscar" />
            </td>
			<td align="right">
              <input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acanewprofesorcurso.php&quot;'/>
            </td>
          </tr>
        </table>
		<div style="height:5px"></div>
		<div style="overflow:auto; width:90%; height:350px">
		<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr class="tr">
            <td width="30px"><div style="width:40px; float:right; text-align:right; padding-right:5px"><strong>Id</strong></div></td>
            <td>Profesor</td>
			<td width="80">Teléfono</td>
            <td width="80">Celular</td>
            <td width="30px">&nbsp;</td>
          </tr>
          <?php do { ?>
            <tr>
              <td width="30px"><div style="width:40px; float:right; text-align:right; padding-right:5px"><strong><?php echo $row_rsProfesor['CodPersonal']; ?></strong></div></td>
              <td><?php echo $row_rsProfesor['Profesor']; ?></td>
              <td width="80"><?php echo $row_rsProfesor['Telefono']; ?></td>
              <td width="80"><?php echo $row_rsProfesor['Celular']; ?></td>
              <td width="30px" align="center"><a href="acanewprofesorcurso.php?Codigo=<?php echo $row_rsProfesor['CodPersonal']; ?>"><img src="../imagenes/icono/user.png" width="20" border="0" title="Copiar"/></a></td>
            </tr>
            <?php } while ($row_rsProfesor = mysql_fetch_assoc($rsProfesor)); ?>
        </table>
		</div>
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

mysql_free_result($rsProfesor);
?>
