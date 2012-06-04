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

mysql_select_db($database_cn, $cn);
$query_rsUsuario = "select Login from usuario where CodPerfil=4 and Codigo='".$_GET['Codigo']."' ";
$rsUsuario = mysql_query($query_rsUsuario, $cn) or die(mysql_error());
$row_rsUsuario = mysql_fetch_assoc($rsUsuario);
$totalRows_rsUsuario = mysql_num_rows($rsUsuario);

mysql_select_db($database_cn, $cn);
$query_rsPermso = "SELECT Id, NombrePrograma, IdPadre, Programa FROM programa where CodPerfil=4";
$rsPermso = mysql_query($query_rsPermso, $cn) or die(mysql_error());
$row_rsPermso = mysql_fetch_assoc($rsPermso);
$totalRows_rsPermso = mysql_num_rows($rsPermso);
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
		<h1>Listado de Opciones de Intranet Administrativa</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="cuepermisoinsert.php">
		  <input type="submit" name="Submit" value="Grabar">
		  <table class="table" width="500" border="0" cellspacing="2" cellpadding="0">
          <tr class="tr">
              <td width="50"><div style="text-align: right; padding-right: 10px">Id</div></td>
            <td>Nombre Programa</td>
            <td width="50">Padre</td>
            <td width="70">Programa</td>
            <td width="20"><input name="txtUsuario" type="hidden" id="txtUsuario" value="<? echo $row_rsUsuario['Login']; ?>" /></td>
          </tr>
          <?php do { ?>
		  <?
			if($row_rsPermso['Programa']==1){
				Filas();	
			}else{
				echo "<tr>";
			}
		  ?>
                      <td width="50"><div style="text-align: right; padding-right: 10px"><strong><?php echo $row_rsPermso['Id']; ?></strong></div></td>
            <td><?php 
			if($row_rsPermso['Programa']==1){
				echo "<div style='float:left; padding-left:30px; color: #0000FF'>".$row_rsPermso['NombrePrograma']."</div>";
			}else{
				echo $row_rsPermso['NombrePrograma'];
			}
			?></td>
            <td width="50"><?php echo $row_rsPermso['IdPadre']; ?></td>
            <td width="70"><?php echo $row_rsPermso['Programa']; ?></td>
            <td width="20">
			<? 
			if($row_rsPermso['Programa']==1){
				mysql_select_db($database_cn, $cn);
				$query_rsExiste = "SELECT COUNT(*) Existe FROM permiso ";
				$query_rsExiste.= "WHERE Usuario='".$row_rsUsuario['Login']."'  ";
				$query_rsExiste.= "and CodPrograma='".$row_rsPermso['Id']."' ";
				$rsExiste = mysql_query($query_rsExiste, $cn) or die(mysql_error());
				$row_rsExiste = mysql_fetch_assoc($rsExiste);
				$totalRows_rsExiste = mysql_num_rows($rsExiste);
					
				if($row_rsExiste['Existe']==1){
					echo "<input type='checkbox' id='chkopcion[]' name='chkopcion[]' value='".$row_rsPermso['Id']."' checked='checked'/>";
				}else{
					echo "<input type='checkbox' id='chkopcion[]' name='chkopcion[]' value='".$row_rsPermso['Id']."'/>";
				}
			} 
			?>			
			</td>
          </tr>
            <?php } while ($row_rsPermso = mysql_fetch_assoc($rsPermso)); ?>
        </table>
		</form>
		<div style="height:20px"></div>
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

mysql_free_result($rsPermso);
?>
