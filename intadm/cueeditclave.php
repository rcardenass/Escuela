<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);
?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsPersonal = "SELECT b.NombrePerfil, a.Apellidos, a.Nombres, a.Password, a.Codigo FROM usuario a INNER JOIN perfil b ON b.CodPerfil=a.CodPerfil WHERE a.Login='".$_SESSION['MM_Username']."' ";
$rsPersonal = mysql_query($query_rsPersonal, $cn) or die(mysql_error());
$row_rsPersonal = mysql_fetch_assoc($rsPersonal);
$totalRows_rsPersonal = mysql_num_rows($rsPersonal);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templateadm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Gestion Escolar</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<script type="text/JavaScript" src="../validar.js"></script>
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
		<h1>Modificar Contraseña</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="cueupdateclave.php" autocomplete="Off" onsubmit="MM_validateForm('txtPerfil','','R','txtUsuario','','R','txtContraActual','','R','txtNuevaContra','','R','txtReNuevaContra','','R');return document.MM_returnValue">
		<? if(!empty($_GET['a'])){ ?>
			<?
			switch ($_GET['a']) {
				case "a":
					$Msj="Los datos no fueron actualizados";
					break;
				case "b":
					$Msj="Las contraseñas no son iguales";
					break;
				case "c":
					$Msj="La contraseña actual no es correcta";
					break;
			}
			?>
			<div style="width:500px; height:25px; background-color:#99FFCC; border:double">
				<div style="height:5px"></div>
				<div style="padding-left:10px"><strong><? echo $Msj; ?></strong></div>
			</div>
			<div style="height:10px"></div>
		<? }?>
		  <table width="500" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td width="190"><span class="label">Perfil</span></td>
            <td><label>
              <input name="txtPerfil" type="text" id="txtPerfil" value="<? echo $row_rsPersonal['NombrePerfil'];?>" readonly="true"/>
            </label></td>
            </tr>
          <tr>
            <td width="190"><span class="label">Usuario</span></td>
            <td><label>
              <input name="txtUsuario" type="text" id="txtUsuario" value="<? echo $row_rsPersonal['Apellidos']." ".$row_rsPersonal['Nombres']; ?>" style="width:250px" readonly="true" />
            </label></td>
            </tr>
          <tr>
            <td width="190"><span class="label">Contrase&ntilde;a Actual</span></td>
            <td><label>
              <input name="txtContraActual" type="password" id="txtContraActual" style="width:250px" />
            </label></td>
            </tr>
          <tr>
            <td width="190"><span class="label">Nueva Contrase&ntilde;a</span></td>
            <td><label>
            <input name="txtNuevaContra" type="password" id="txtNuevaContra" style="width:250px"/>
            </label></td>
            </tr>
          <tr>
            <td width="190"><span class="label">Repita Nueva Contrase&ntilde;a</span></td>
            <td><label>
              <input name="txtReNuevaContra" type="password" id="txtReNuevaContra" style="width:250px"/>
            </label></td>
            </tr>
          <tr>
            <td width="190">&nbsp;</td>
            <td><label>
              <input type="submit" name="Submit" value="Cambiar Contrase&ntilde;a" />
            </label></td>
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
?>
