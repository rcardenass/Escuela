<?php include("../seguridad.php");?>
<?php
$KT_relPath = "../";
  require_once("../includes/widgets/widgets_start.php");
?>
<?php 
include('../funciones.php');
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$_SESSION['Desde']=$_POST['txtDesde'];
$_SESSION['Hasta']=$_POST['txtHasta'];

$rsDia = $objDatos->ObtenerDiaSelAll($_SESSION['Desde'],$_SESSION['Hasta']);
$rowDia = $objDatos->PoblarDiaSelAll($rsDia);
$totalRows_rsDia = mysql_num_rows($rsDia);
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
<!-- InstanceEditableHeadTag -->

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
		<h1>Día</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="">
		  <table width="320" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td>Desde</td>
              <td>Hasta</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
              <input name="txtDesde" type="widget" id="txtDesde" style="width:80px" value="<?php echo $_SESSION['Desde']; ?>" maxlength="10" readonly="true" subtype="wcalendar" format="dd/mm/yyyy" skin="blue" language="es" label=".." mondayfirst="false" />
              </label></td>
              <td><label>
                <input name="txtHasta" type="widget" id="txtHasta" style="width:80px" value="<?php echo $_SESSION['Hasta']; ?>" maxlength="10" readonly="true" subtype="wcalendar" format="dd/mm/yyyy" skin="blue" language="es" label=".." mondayfirst="true"/>
              </label></td>
              <td align="right">
                <input type="submit" name="Submit" value="Buscar" />              </td>
            </tr>
          </table>
        
				<br />
		<table class="table" width="650" border="0" cellspacing="1" cellpadding="0">
          <tr class="tr">
            <td width="30">Id</td>
            <td>Fecha Apertura </td>
            <td>Hora</td>
            <td>Fecha Cierre </td>
            <td>Hora</td>
            <td>Estado</td>
			<td>Sit</td>
            <td>Usuario</td>
            <td width="35"><a href="tesnewdia.php"><img src="../imagenes/icono/add.png" width="32" border="0"/></a></td>
          </tr>
          <?php 
		  if(!empty($totalRows_rsDia)){
		  do { 
		  ?>
          <? Filas();?>
            <td width="30"><?php echo $rowDia['CodDia']; ?></td>
            <td><?php echo $rowDia['FechaApertura']; ?></td>
            <td><?php echo $rowDia['HoraApertura']; ?></td>
            <td><?php echo $rowDia['FechaCierre']; ?></td>
            <td><?php echo $rowDia['HoraCierre']; ?></td>
            <td><?php echo $rowDia['Estado']; ?></td>
			<td>
			<?php 
			if($rowDia['Situacion']>0){
				echo "<span style='color: #3333FF'><strong>".$rowDia['Situacion']."</strong></span>";
			}else{
				echo "<span style='color: #FF0000' title='No existen cajas abiertas'><strong>".$rowDia['Situacion']."</strong></span>";
			}
			?>
			</td>
            <td><?php echo $rowDia['UsuarioCreacion']; ?></td>
            <td width="35">
			<? if($rowDia['Estado']=="Abierto"){ ?>
				<a onClick="return cerrar()" href="tesupdatedia.php?Codigo=<?php echo $rowDia['CodDia']; ?>"><img src="../imagenes/icono/cpanel.png" width="22" border="0" title="Cerrar Día"/></a>
			<? }else{ ?>
				<img src="../imagenes/icono/deny.png" width="22" border="0" title="Día Cerrado"/>
			<? } ?>
			</td>
          </tr>
            <?php 
			} while ($rowDia = $objDatos->PoblarDiaSelAll($rsDia)); 
			}
			?>
        </table>
		</form>
		<br />
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
  require_once("../includes/widgets/widgets_end.php");
?>
<?php
mysql_free_result($rsTreeview);
mysql_free_result($rsDia);
?>
<script LANGUAGE="JavaScript">
	function cerrar()
	{
	var agree=confirm("¿Esta Seguro de cerrar el Día?");
	if (agree)
	return true ;
	else
	return false ;
	}
</script>