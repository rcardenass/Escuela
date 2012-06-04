<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php include('funciones.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$_SESSION['Tipo']=$_POST['cboEstado'];
$_SESSION['Buscar']=$_POST['txtBuscar'];

mysql_select_db($database_cn, $cn);
$query_rsAlumnos = "SELECT CodUsuario, Login, concat(Apellidos,' ',Nombres) AS Alumno, Email, Codigo AS CodAlumno, case Estado when 1 then 'Activado' when 0 then 'Desactivado' end as Estado, Estado as Flag FROM usuario WHERE CodPerfil=1 AND (Estado='".$_SESSION['Tipo']."' or ''='".$_SESSION['Tipo']."') AND concat(Apellidos,' ',Nombres) LIKE '%".$_SESSION['Buscar']."%'";
$rsAlumnos = mysql_query($query_rsAlumnos, $cn) or die(mysql_error());
$row_rsAlumnos = mysql_fetch_assoc($rsAlumnos);
$totalRows_rsAlumnos = mysql_num_rows($rsAlumnos);
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
		<h1>Cuentas Estudiantes</h1><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="">
		  <table width="500" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="55"><span class="label">Estado</span></td>
              <td width="120"><select name="cboEstado" id="cboEstado" style="width:100px">
                <option value="" <?php if (!(strcmp("", $_SESSION['Tipo']))) {echo "selected=\"selected\"";} ?>>Todos</option>
                <option value="1" <?php if (!(strcmp(1, $_SESSION['Tipo']))) {echo "selected=\"selected\"";} ?>>Activo</option>
                <option value="0" <?php if (!(strcmp(0, $_SESSION['Tipo']))) {echo "selected=\"selected\"";} ?>>Cesado</option>
              </select></td>
              <td width="55"><span class="label">Buscar</span></td>
              <td>
                <input name="txtBuscar" type="text" id="txtBuscar" style="width:170px" value="<?php echo $_SESSION['Buscar']; ?>"/>              </td>
              <td align="right">
                <input type="submit" name="Submit" value="Buscar" />              </td>
            </tr>
          </table>
        </form>
		<div style="height:5px"></div>
		<table class="table" width="95%" border="0" cellspacing="2" cellpadding="0">
          <tr class="tr">
            <td width="50"><div style="width:40px; float:right; text-align:right; padding-right:5px">Id</div></td>
            <td>Usuario</td>
            <td>Alumno</td>
            <td>Email</td>
            <td width="90">Estado</td>
            <td width="32" align="center"><a href="cuenewalumno.php"><img src="../imagenes/icono/add.png" border="0" width="32" /></a></td>
          </tr>
          <?php 
		  if(!empty($totalRows_rsAlumnos)){
		  do {
		  ?>
          <? Filas();?>
            <td><div style="width:40px; float:right; text-align:right; padding-right:5px"><strong><?php echo $row_rsAlumnos['CodUsuario']; ?></strong></div></td>
            <td><?php echo $row_rsAlumnos['Login']; ?></td>
            <td><?php echo $row_rsAlumnos['Alumno']; ?></td>
            <td><?php echo $row_rsAlumnos['Email']; ?></td>
            <td width="90">
			<a onClick="return confirmaanular()" href="cueestadoalumno.php?Codigo=<?php echo $row_rsAlumnos['CodUsuario']; ?>" <? if($row_rsAlumnos['Flag']==1){ echo "style='color:#0000FF'"; }else{ echo "style='color:#FF0000'"; }  ?>><strong><?php echo $row_rsAlumnos['Estado']; ?></strong></a>
			</td>
            <td width="32" align="center"><a href="cueeditalumno.php?Codigo=<?= $row_rsAlumnos['CodUsuario']; ?>"><img src="../imagenes/icono/edit.png" border="0" width="22"/></a></td>
          </tr>
            <?php 
			} while ($row_rsAlumnos = mysql_fetch_assoc($rsAlumnos)); 
			}
			?>
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

mysql_free_result($rsAlumnos);
?>
<script LANGUAGE="JavaScript">
function confirmaanular(){
	var agree=confirm("¿Esta seguro de cambiar el estado?");
	if (agree)
	return true ;
	else
	return false ;
}
</script>