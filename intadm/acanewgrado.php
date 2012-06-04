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
$query_rsNivel = "SELECT CodNivel, NombreNivel FROM nivel where Estado=1 ORDER BY CodNivel ASC";
$rsNivel = mysql_query($query_rsNivel, $cn) or die(mysql_error());
$row_rsNivel = mysql_fetch_assoc($rsNivel);
$totalRows_rsNivel = mysql_num_rows($rsNivel);
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
		<h1>Nuevo Grado</h1><hr /><br />	
		<form action="acainsertgrado.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('cboNivel','','RisNum','txtGrado','','R');return document.MM_returnValue" autocomplete="Off">
		  <table width="400" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>Nivel</td>
              <td>Grado</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboNivel" id="cboNivel" style="width:100px">
                  <option value="Seleccione"></option>
                  <?php
do {  
?>
                  <option value="<?php echo $row_rsNivel['CodNivel']?>"><?php echo $row_rsNivel['NombreNivel']?></option>
                  <?php
} while ($row_rsNivel = mysql_fetch_assoc($rsNivel));
  $rows = mysql_num_rows($rsNivel);
  if($rows > 0) {
      mysql_data_seek($rsNivel, 0);
	  $row_rsNivel = mysql_fetch_assoc($rsNivel);
  }
?>
                </select>
              </label></td>
              <td><label>
                <input name="txtGrado" type="text" id="txtGrado" style="width:150px" />
              </label></td>
              <td align="right">
                <input type="submit" name="Submit" value="Aceptar" />              </td>
              <td align="right">
               <input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acagrado.php&quot;'/>              </td>
            </tr>
          </table>
        </form>
		<br />
		<span><? echo $_SESSION['TablaGrado']; ?></span>
		<? 
		$_SESSION['TablaGrado']=NULL;
		unset($_SESSION['TablaGrado']); 
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

mysql_free_result($rsNivel);
?>
