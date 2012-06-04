<?php include("../seguridad.php");?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

if(isset($_GET['Codigo'])){
	$rsMatricula = $objDatos->ObtenerMatriculaAlumnoSelId($_GET['Codigo']);
	$rowMatricula = $objDatos->PoblarMatriculaAlumnoSelId($rsMatricula);
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
		<h1>Nuevo Alumno a Retirar</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="acainsertretiro.php" onsubmit="MM_validateForm('txtAlumno','','R','txtMotivo','','R','cboColegio','','R','txtDescripcion','','R');return document.MM_returnValue" autocomplete="Off">
		<? if(isset($_SESSION['TablaRetirado'])){ ?>
		<span class="Contenedor" style="width: 99%; padding-left:5px"><span><? echo $_SESSION['TablaRetirado']; ?></span></span>
		<div style="height:20px"></div>
		<? 
		$_SESSION['TablaRetirado']=NULL;
		unset($_SESSION['TablaRetirado']); 
		?>
		<? }?>
		  <table width="400" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td><span class="label">Alumno</span></td>
              <td><input name="txtCodMatricula" type="hidden" id="txtCodMatricula" value="<? echo $rowMatricula['CodMatricula']; ?>" />
                <input name="txtCodAlumno" type="hidden" id="txtCodAlumno" value="<? echo $rowMatricula['CodAlumno']; ?>"/></td>
            </tr>
            <tr>
              <td><label>
                <input name="txtAlumno" type="text" id="txtAlumno" style="width:330px" value="<? echo strtoupper($rowMatricula['Alumno']); ?>" 
				readonly="true"/>
              </label></td>
              <td align="right">
                <a href="acaretiroalumno.php"><img src="../imagenes/icono/user.png" width="32" border="0" title="Buscar Alumno"/></a>			  </td>
            </tr>
            <tr>
              <td><span class="label">Motivo de Retiro</span></td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <input name="txtMotivo" type="text" id="txtMotivo" style="width:330px"/>
              </label></td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><span class="label">Colegio donde sera trasladado</span></td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboColegio" id="cboColegio" style="width:334px">
				<option value="11">Colegio de Prueba</option>
                </select>
              </label></td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><span class="label">Descripci&oacute;n</span></td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <textarea name="txtDescripcion" rows="10" id="txtDescripcion" style="width:330px"></textarea>
              </label></td>
              <td align="right">&nbsp;</td>
            </tr>
          </table>
		  <div style="height:20px"></div>
		  <input type="submit" name="Submit" value="Retirar" />
		  <input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acaretirado.php&quot;'/>
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
if(isset($_GET['Codigo'])){
	mysql_free_result($rsMatricula);
}
?>
