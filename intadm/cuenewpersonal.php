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
$query_rsPerfil = "select CodPerfil, NombrePerfil from perfil where Estado=1 and CodPerfil in (2,4,5) ";
$rsPerfil = mysql_query($query_rsPerfil, $cn) or die(mysql_error());
$row_rsPerfil = mysql_fetch_assoc($rsPerfil);
$totalRows_rsPerfil = mysql_num_rows($rsPerfil);

mysql_select_db($database_cn, $cn);
$query_rsPersonal = "SELECT CodPersonal, concat(TRIM(ApellidoPaterno),' ',TRIM(ApellidoMaterno),' ',TRIM(Nombres)) AS Personal FROM personal WHERE Estado=1 ORDER BY concat(TRIM(ApellidoPaterno),' ',TRIM(ApellidoMaterno),' ',TRIM(Nombres)) ASC ";
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
			<div style="width:300px; height:auto; float:left; padding-top:20px">Nueva Cuenta Intranet</div>
			<div style="width:100px; height:auto; float:right; text-align:right">
				<a href="cuepersonal.php"><img src="../imagenes/icono/revert.png" border="0" title="Personal con cuenta"/></a>
			</div>
		</div>
	    </h1><div style="height:30px"></div><hr /><br />
        <form action="cueinsertpersonal.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('cboPerfil','','RisNum','cboUsuario','','RisNum','txtPassword','','R','txtRePassword','','R');return document.MM_returnValue" autocomplete="Off">
            <table width="350" cellpadding="0" cellspacing="2" border="0">
            <tr>
            	<td width="100">Perfil</td>
                <td><select name="cboPerfil" id="cboPerfil" style="width:150px">
				<option value="">Seleccione</option>
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
                <td><select name="cboUsuario" id="cboUsuario" style="width:250px">
				<option value="">Seleccione</option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsPersonal['CodPersonal']?>"><?php echo $row_rsPersonal['Personal']?></option>
                  <?php
} while ($row_rsPersonal = mysql_fetch_assoc($rsPersonal));
  $rows = mysql_num_rows($rsPersonal);
  if($rows > 0) {
      mysql_data_seek($rsPersonal, 0);
	  $row_rsPersonal = mysql_fetch_assoc($rsPersonal);
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
              <td>&nbsp;</td>
              <td>
			  	<div style="height:10px"></div>
                <input type="submit" name="Submit" value="Grabar"/>
              </td>
            </tr>
          </table>
        </form>
        <br />
		<span><? echo $_SESSION['TablaUsuario']; ?></span>
		<? 
		$_SESSION['TablaUsuario']=NULL;
		unset($_SESSION['TablaUsuario']); 
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
mysql_free_result($rsPerfil);
mysql_free_result($rsPersonal);
?>
