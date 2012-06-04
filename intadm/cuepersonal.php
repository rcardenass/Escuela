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

$_SESSION['Tipo']=$_POST['cboTipoPersonal'];
$_SESSION['Buscar']=$_POST['txtBuscar'];

mysql_select_db($database_cn, $cn);
$query_rsPersonal ="SELECT a.CodPersonal, case a.Estado when 1 then 'A' when 0 then 'C' end as Estado, ";
$query_rsPersonal.="concat(TRIM(a.ApellidoPaterno),' ',TRIM(a.ApellidoMaterno),' ',TRIM(a.Nombres)) AS Personal, ";
$query_rsPersonal.="b.Email, b.CodPerfil, lower(b.Login) as Login ";
$query_rsPersonal.="FROM personal a ";
$query_rsPersonal.="INNER JOIN usuario b ON b.Codigo=a.CodPersonal ";
$query_rsPersonal.="WHERE b.CodPerfil IN (2,4,5) ";
$query_rsPersonal.="AND (a.Estado='".$_SESSION['Tipo']."' or ''='".$_SESSION['Tipo']."') ";
$query_rsPersonal.="AND concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) LIKE '%".$_SESSION['Buscar']."%' ";
$query_rsPersonal.="GROUP by a.CodPersonal ";
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
		<h1>Cuentas Personal</h1><hr /><br />
		<form id="form1" name="form1" method="post" autocomplete="Off" action="">
		<table width="500px" border="0" cellspacing="2" cellpadding="0">
          <tr>
		  	<td width="55"><span class="label">Estado</span></td>
            <td width="120">
              <select name="cboTipoPersonal" id="cboTipoPersonal" style="width:100px">
                <option value="" <?php if (!(strcmp("", $_SESSION['Tipo']))) {echo "selected=\"selected\"";} ?>>Todos</option>
                <option value="1"<?php if (!(strcmp(1, $_SESSION['Tipo']))) {echo "selected=\"selected\"";} ?>>Activos</option>
                <option value="0" <?php if (!(strcmp(0, $_SESSION['Tipo']))) {echo "selected=\"selected\"";} ?>>Cesados</option>
            </select>            </td>
            <td width="55"><span class="label">Buscar</span></td>
            <td><input name="txtBuscar" type="text" id="txtBuscar" value="<?php echo $_SESSION['Buscar'] ?>" style="width:170px" maxlength="20" /></td>
            <td align="right">
              <input type="submit" name="Submit" value="Buscar" />            </td>
          </tr>
        </table>
		</form>
		<div style="height:5px"></div>
		<table class="table" width="95%" border="0" cellspacing="2" cellpadding="0">
          <tr class="tr">
            <td width="50"><div style="width:40px; float:right; text-align:right; padding-right:5px">Id</div></td>
            <td width="15" align="center"></td>
			<td width="100" align="left">Usuario</td>
			<td>Personal</td>
			<td width="200">Email</td>
            <td width="100">Tipo</td>
            <td colspan="2" width="32" align="center"><a href="cuenewpersonal.php"><img src="../imagenes/icono/add.png" border="0" width="32" title="Nueva Cuenta"/></a></td>
          </tr>
            <?php 
			if(!empty($totalRows_rsPersonal)){
			do{
            ?>
            <? Filas();?>
              <td width="50"><div style="width:40px; float:right; text-align:right; padding-right:5px"><strong><?php echo $row_rsPersonal['CodPersonal']; ?></strong></div></td>
              <td width="15" align="center"><?php echo $row_rsPersonal['Estado']; ?></td>
			  <td width="100" align="left"><?php echo $row_rsPersonal['Login']; ?></td>
              <td>
			  <a href="cuepermiso.php?Codigo=<?php echo $row_rsPersonal['CodPersonal'];?>">
			  	<?php echo $row_rsPersonal['Personal']; ?>
			  </a>
			  </td>
              <td width="200"><?php echo $row_rsPersonal['Email']; ?></td>
              <td width="100">
              <?
              mysql_select_db($database_cn, $cn);
              $query_rsPerfil = "SELECT a.CodUsuario, LEFT(b.NombrePerfil,3) AS Perfil, b.NombrePerfil as Title, a.Estado FROM usuario a INNER JOIN perfil b ON b.CodPerfil=a.CodPerfil WHERE Codigo='".$row_rsPersonal['CodPersonal']."' ";
              $rsPerfil = mysql_query($query_rsPerfil, $cn) or die(mysql_error());
              $row_rsPerfil = mysql_fetch_assoc($rsPerfil);
              $totalRows_rsPerfil = mysql_num_rows($rsPerfil);
              ?>
              <?php 
              do{
			  	if($row_rsPerfil['Estado']==1){
                echo "<a onClick='return confirmaanular()' href=cueestadoaperfil.php?Codigo=".$row_rsPerfil['CodUsuario']." title=".$row_rsPerfil['Title']." style='color:#0000FF'><strong>".$row_rsPerfil['Perfil']." </strong></a>";
				}else{
				echo "<a onClick='return confirmaanular()' href=cueestadoaperfil.php?Codigo=".$row_rsPerfil['CodUsuario']." title=".$row_rsPerfil['Title']." style='color:#FF0000'><strong>".$row_rsPerfil['Perfil']." </strong></a>";		
				}
              }while($row_rsPerfil = mysql_fetch_assoc($rsPerfil));
			  mysql_free_result($rsPerfil);
              ?>
              </td>
              <td width="16" align="center"><a href="cueeditpersonal.php?Codigo=<?php echo $row_rsPersonal['CodPersonal']; ?>"><img src="../imagenes/icono/edit.png" width="22" border="0" title="Editar"/></a></td>
			  <td width="16" align="center"><a onClick="return confirmaeliminar()" href="cuedelpersonal.php?Codigo=<?php echo $row_rsPersonal['CodPersonal']; ?>"><img src="../imagenes/icono/trash.png" width="22" border="0" title="Eliminar"/></a></td>
            </tr>
            <?php
            }while($row_rsPersonal = mysql_fetch_assoc($rsPersonal));
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
mysql_free_result($rsPersonal);
?>
<script LANGUAGE="JavaScript">
function confirmaanular(){
	var agree=confirm("�Esta seguro de anular este perfil?");
	if (agree)
	return true ;
	else
	return false ;
}
function confirmaeliminar(){
	var agree=confirm("�Esta seguro de eliminar todos los perfiles?");
	if (agree)
	return true ;
	else
	return false ;
}
</script>