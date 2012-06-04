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

mysql_select_db($database_cn, $cn);
$query_rsPerfil = "select CodPerfil, NombrePerfil from perfil where Estado=1 and CodPerfil in (1) ";
$rsPerfil = mysql_query($query_rsPerfil, $cn) or die(mysql_error());
$row_rsPerfil = mysql_fetch_assoc($rsPerfil);
$totalRows_rsPerfil = mysql_num_rows($rsPerfil);

mysql_select_db($database_cn, $cn);
$query_rsAlumno = "SELECT CodAlumno, concat(TRIM(ApellidoPaterno),' ',TRIM(ApellidoMaterno),' ',TRIM(Nombres)) AS Alumno FROM alumno WHERE Estado=1 ORDER BY concat(TRIM(ApellidoPaterno),' ',TRIM(ApellidoMaterno),' ',TRIM(Nombres)) ASC ";
$rsAlumno = mysql_query($query_rsAlumno, $cn) or die(mysql_error());
$row_rsAlumno = mysql_fetch_assoc($rsAlumno);
$totalRows_rsAlumno = mysql_num_rows($rsAlumno);

mysql_select_db($database_cn, $cn);
$query_rsEditar = "SELECT CodUsuario, Codigo AS CodAlumno, Estado FROM usuario WHERE CodUsuario='".$_GET['Codigo']."' GROUP by Codigo ";
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
		<h1>
		<div style="width:100%">
			<div style="width:300px; height:auto; float:left; padding-top:20px">Editar Cuenta Intranet</div>
			<div style="width:100px; height:auto; float:right; text-align:right">
				<a href="cuealumno.php"><img src="../imagenes/icono/revert.png" border="0" title="Alumno con cuenta"/></a>
			</div>
		</div>
	    </h1><div style="height:30px"></div><hr /><br />
        <form action="cueupdatealumno.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('cboUsuario','','RisNum','txtPassword','','R','txtRePassword','','R');return document.MM_returnValue" autocomplete="Off">
            <table width="350" cellpadding="0" cellspacing="2" border="0">
            <tr>
            	<td width="100">Perfil</td>
                <td><select name="cboPerfil" id="cboPerfil" style="width:150px">
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsPerfil['CodPerfil']?>"><?php echo $row_rsPerfil['NombrePerfil']?></option>
                  <?php
} while ($row_rsPerfil = mysql_fetch_assoc($rsPerfil));
  $rows = mysql_num_rows($rsPerfil);
  if($rows > 0) {
      mysql_data_seek($rsPerfil, 0);
	  $row_rsPerfil = mysql_fetch_assoc($rsPerfil);
  }
?>
                </select></td>
            </tr>
            <tr>
            	<td width="100">Usuario</td>
                <td><select name="cboUsuario" id="cboUsuario" style="width:250px" disabled="disabled">
                  <option value="" <?php if (!(strcmp("", $row_rsEditar['CodAlumno']))) {echo "selected=\"selected\"";} ?>>Seleccione</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsAlumno['CodAlumno']?>"<?php if (!(strcmp($row_rsAlumno['CodAlumno'], $row_rsEditar['CodAlumno']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsAlumno['Alumno']?></option>
                  <?php
} while ($row_rsAlumno = mysql_fetch_assoc($rsAlumno));
  $rows = mysql_num_rows($rsAlumno);
  if($rows > 0) {
      mysql_data_seek($rsAlumno, 0);
	  $row_rsAlumno = mysql_fetch_assoc($rsAlumno);
  }
?>
                </select></td>
            </tr>
            <tr>
            	<td width="100">Password</td>
                <td><input name="txtPassword" type="password" id="txtPassword" style="width:150px" /></td>
            </tr>
            <tr>
            	<td width="100">Re Password</td>
                <td><input name="txtRePassword" type="password" id="txtRePassword" style="width:150px"/></td>
            </tr>
            <tr>
              <td>
			  <input name="txtCodAlumno" type="hidden" id="txtCodAlumno" value="<?php echo $row_rsEditar['CodAlumno']; ?>" />
			  <input name="txtCodUsuario" type="hidden" id="txtCodUsuario" value="<?php echo $row_rsEditar['CodUsuario']; ?>" />
			  </td>
              <td>
			  	<div style="height:10px"></div>
                <input type="submit" name="Submit" value="Grabar"/>              </td>
            </tr>
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

mysql_free_result($rsEditar);
?>
