<?php include("../seguridad.php");?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

if(isset($_GET['Codigo'])){
  $_SESSION['CodPadreFamilia']=$_GET['Codigo'];  
}
$rsPadre=$objDatos->ObtenerPadreFamiliaSelId($_SESSION['CodPadreFamilia']);
$row_Padre=$objDatos->PoblarPadreFamiliaSelId($rsPadre);

$rsHijo=$objDatos->ObtenerHijosDePadreSelAll($_SESSION['CodPadreFamilia'], $row_Padre['Tipo']);
$row_Hijo=$objDatos->PoblarHijosDePadreSelAll($rsHijo);
$totalRows_rsHijo = mysql_num_rows($rsHijo);

if(isset($_GET['Codigo1'])){
    $rsAlumno=$objDatos->ObtenerAlumnoSelId($_GET['Codigo1']);
    $row_Alumno=$objDatos->PoblarAlumnoSelId($rsAlumno);
}


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
			<div style="width:650px; height:auto; float:left; padding-top:20px">Hijos de <? echo strtoupper($row_Padre['ApellidoPaterno']." ".$row_Padre['ApellidoMaterno']." ".$row_Padre['Nombres']); ?></div>
			<div style="width:100px; height:auto; float:right; text-align:right">
				<a href="acapadre.php"><img src="../imagenes/icono/revert.png" border="0" title="Volver"/></a>			</div>
		</div>
		</h1><div style="height:30px"></div><hr /><br>
		<table width="500" border="0" cellspacing="2" cellpadding="0" class="table">
          <tr class="tr">
            <td width="50"><div style="text-align:right; padding-right:5px">Id</div></td>
            <td>Alumno</td>
            <td width="50" align="center">A&ntilde;o</td>
            <td width="50" align="center">Estado</td>
          </tr>
          <? if(empty($totalRows_rsHijo)){?>
          <tr>
            <td colspan="4"><div style="text-align:left; padding-left:5px">No hay registros</div></td>
          </tr>
          <? }else{ ?>
	  <? do{ ?>
          <tr>
            <td width="50"><div style="text-align:right; padding-right:5px"><? echo $row_Hijo['CodAlumno']; ?></div></td>
            <td><? echo $row_Hijo['Alumno']; ?></td>
            <td width="50" align="center"><? echo $row_Hijo['Anio']; ?></td>
            <td width="50" align="center"><? echo $row_Hijo['Estado']; ?></td>
          </tr>
         <? }while($row_Hijo=$objDatos->PoblarHijosDePadreSelAll($rsHijo)); ?>
         <? }?>
        </table>
		<br />
		<form id="form1" name="form1" method="post" action="acainsertenlazapadrealumno.php" autocomplete="Off" onsubmit="MM_validateForm('txtAlumno','','R');return document.MM_returnValue">
		<table width="400" border="0" cellspacing="2" cellpadding="0">
          <tr>
            <td>
              <label>
                  <input name="txtAlumno" type="text" id="txtAlumno" style="width:280px" disabled="disabled" value="<? echo strtoupper($row_Alumno['Alumno']); ?>"/>
                <input name="txtCodigoAlumno" type="hidden" id="txtCodigoAlumno" value="<? echo $row_Alumno['CodAlumno']; ?>" />
                </label>			</td>
            <td align="right"><a href="acaalumnovinculapadre.php"><img src="../imagenes/icono/search.png" width="25" border="0" title="Buscar Alumno"/></a></td>
            <td width="80" align="right">
              <input type="submit" name="Submit" value="Asociar" />              </td>
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
