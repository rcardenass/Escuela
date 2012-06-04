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

if(isset($_POST['cbTipoPersonoal'])){
	$_SESSION['Tipo']=$_POST['cbTipoPersonoal'];
	$_SESSION['Buscar']=$_POST['txtBuscar'];
}else{
	$_SESSION['Tipo']="";
	$_SESSION['Buscar']="";
}

mysql_select_db($database_cn, $cn);
$query_rsTipo = "SELECT CodTipoPersonal, NombreTipoPersonal FROM tipopersonal";
$rsTipo = mysql_query($query_rsTipo, $cn) or die(mysql_error());
$row_rsTipo = mysql_fetch_assoc($rsTipo);
$totalRows_rsTipo = mysql_num_rows($rsTipo);

mysql_select_db($database_cn, $cn);
$query_rsPersonal = "SELECT a.CodPersonal, left(b.NombreTipoPersonal,3) AS TipoPersonal,  Concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Personal, a.Telefono, a.Celular, a.EmailPersonal FROM personal a INNER JOIN tipopersonal b ON b.CodTipoPersonal=a.CodTipoPersonal WHERE (b.CodTipoPersonal='".$_SESSION['Tipo']."' or ''='".$_SESSION['Tipo']."') AND Concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,'',a.Nombres) LIKE '%".$_SESSION['Buscar']."%' order by b.NombreTipoPersonal,  Concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) ";
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
				<h1>Personal</h1><hr /><br />
				<form id="form1" name="form1" method="post" autocomplete="Off" action="">
		<table width="430px" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  	<td width="35px"><span class="label">Tipo</span></td>
            <td>
              <select name="cbTipoPersonoal" id="cbTipoPersonoal" style="width:120px">
                <option value=""></option>
                <?php
do {  
?>
                <option value="<?php echo $row_rsTipo['CodTipoPersonal']?>"<?php if (!(strcmp($row_rsTipo['CodTipoPersonal'], $_SESSION['Tipo']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsTipo['NombreTipoPersonal']?></option>
                <?php
} while ($row_rsTipo = mysql_fetch_assoc($rsTipo));
  $rows = mysql_num_rows($rsTipo);
  if($rows > 0) {
      mysql_data_seek($rsTipo, 0);
	  $row_rsTipo = mysql_fetch_assoc($rsTipo);
  }
?>
              </select>
            </td>
            <td width="55px"><span class="label">Buscar</span></td>
            <td>
              <input name="txtBuscar" type="text" id="txtBuscar" value="<?php echo $_SESSION['Buscar'] ?>" size="21" maxlength="20" />
            </td>
            <td align="right">
              <input type="submit" name="Submit" value="Buscar" />
            </td>
          </tr>
        </table>
		<div style="height:5px"></div>
		<table class="table" width="750px" border="0" cellspacing="2" cellpadding="0">
          <tr class="tr">
            <td width="30"><div style="width:40px; float:right; text-align:right; padding-right:5px">Id</div></td>
            <td width="40" align="center">Tipo</td>
			<td>Personal</td>
			<td width="70">Telefono</td>
            <td width="80">Celular</td>
            <td>Email</td>
            <td width="31" align="center"><a href="acanewpersonal.php"><img src="../imagenes/icono/aadduser.png" width="32" border="0"/></a></td>
          </tr>
            <?php 
			if(!empty($totalRows_rsPersonal)){
			do { 
			?>
              <? Filas();?>
                <td width="30"><div style="width:40px; float:right; text-align:right; padding-right:5px"><strong><?php echo $row_rsPersonal['CodPersonal']; ?></strong></div></td>
                <td width="40" align="center"><?php echo $row_rsPersonal['TipoPersonal']; ?></td>
                <td><?php echo $row_rsPersonal['Personal']; ?></td>
                <td width="70"><?php echo $row_rsPersonal['Telefono']; ?></td>
                <td width="80"><?php echo $row_rsPersonal['Celular']; ?></td>
                <td><?php echo $row_rsPersonal['EmailPersonal']; ?></td>
                <td width="31" align="center"><a href="acaeditpersonal.php?Codigo=<?php echo $row_rsPersonal['CodPersonal']; ?>"><img src="../imagenes/icono/edit.png" width="22" border="0" title="Editar"/></a></td>
              </tr>
              <?php 
			  } while ($row_rsPersonal = mysql_fetch_assoc($rsPersonal)); 
			  }
			  ?>
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

mysql_free_result($rsPersonal);

mysql_free_result($rsTipo);
?>