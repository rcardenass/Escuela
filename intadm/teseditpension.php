<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$KT_relPath = "../";
  require_once("../includes/widgets/widgets_start.php");
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

mysql_select_db($database_cn, $cn);
$query_rsPension = "SELECT a.CodProgramacionAlumno AS Id, b.NombreAnio AS Anio, c.NombreGrado AS Grado, a.NroPension, a.Monto, a.Mora, a.Pagado, DATE_FORMAT(a.FechaInicio,'%d/%m/%Y') AS FechaInicio, DATE_FORMAT(a.FechaTermino,'%d/%m/%Y') AS FechaTermino, a.CodAlumno FROM programacionalumno a INNER JOIN anio b ON b.CodAnio=a.CodAnio INNER JOIN grado c ON c.CodGrado=a.CodGrado WHERE a.CodProgramacionAlumno='".$_GET['Id']."' ";
$rsPension = mysql_query($query_rsPension, $cn) or die(mysql_error());
$row_rsPension = mysql_fetch_assoc($rsPension);
$totalRows_rsPension = mysql_num_rows($rsPension);
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
			<div style="width:300px; height:auto; float:left; padding-top:20px">Modificar Pensión</div>
			<div style="width:100px; height:auto; float:right; text-align:right"><a href="tescompromiso.php?Codigo=<?= $row_rsPension['CodAlumno'] ?>"><img src="../imagenes/icono/revert.png" border="0" title="Busca otro Alumno"/></a></div>
		</div>
	    </h1><div style="height:30px"></div><hr /><br />
		<form action="tesupdatepension.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('txtNroPension','','RisNum','txtMonto','','RisNum','txtMora','','RisNum','txtPagado','','RisNum','txtDesde','','R','txtHasta','','R');return document.MM_returnValue" autocomplete="Off">
		  <table width="300" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="90">A&ntilde;o
              <input name="txtCodigo" type="hidden" id="txtCodigo" value="<?php echo $row_rsPension['Id']; ?>" /></td>
              <td width="204"><label>
                <input name="txtAnio" type="text" id="txtAnio" value="<?php echo $row_rsPension['Anio']; ?>" style="width:60px" readonly="true"/>
              </label></td>
            </tr>
            <tr>
              <td>Grado</td>
              <td><label>
                <input name="txtGrado" type="text" id="txtGrado" value="<?php echo $row_rsPension['Grado']; ?>" style="width:200px" readonly="true"/>
              </label></td>
            </tr>
            <tr>
              <td>Nro Pensi&oacute;n </td>
              <td><label>
                <input name="txtNroPension" type="widget" id="txtNroPension" value="<?php echo $row_rsPension['NroPension']; ?>" subtype="numericInput" negative="false" allowfloat="false" style="width:60px" readonly="true"/>
              </label></td>
            </tr>
            <tr>
              <td>Monto</td>
              <td><label>
                <input name="txtMonto" type="widget" id="txtMonto" value="<?php echo $row_rsPension['Monto']; ?>" subtype="numericInput" negative="false" allowfloat="true" style="width:60px"/>
              </label></td>
            </tr>
            <tr>
              <td>Mora</td>
              <td><label>
                <input name="txtMora" type="widget" id="txtMora" value="<?php echo $row_rsPension['Mora']; ?>" subtype="numericInput" negative="false" allowfloat="true" style="width:60px"/>
              </label></td>
            </tr>
            <tr>
              <td>Pagado</td>
              <td><label>
                <input name="txtPagado" type="widget" id="txtPagado" value="<?php echo $row_rsPension['Pagado']; ?>" subtype="numericInput" negative="false" allowfloat="true" style="width:60px"/>
              </label></td>
            </tr>
            <tr>
              <td>Desde</td>
              <td><label>
                <input name="txtDesde" type="widget" id="txtDesde" value="<?php echo $row_rsPension['FechaInicio']; ?>" readonly="true" subtype="wcalendar" format="dd/mm/yyyy" skin="blue" language="es" label=".." mondayfirst="false" style="width:70px" />
              </label></td>
            </tr>
            <tr>
              <td>Hasta</td>
              <td><label>
                <input name="txtHasta" type="widget" id="txtHasta" value="<?php echo $row_rsPension['FechaTermino']; ?>" readonly="true" subtype="wcalendar" format="dd/mm/yyyy" skin="blue" language="es" label=".." mondayfirst="false" style="width:70px" />
              </label></td>
            </tr>
          </table>
		  <div style="height:10px"></div>
		  <div style="padding-left:95px"><input type="button" name="Submit" value="Modificar" onclick="javascript:validar();"/></div>
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
  require_once("../includes/widgets/widgets_end.php");
?>
<?php
mysql_free_result($rsTreeview);
mysql_free_result($rsPension);
?>
<script>
function validar(){
	if (confirm("¿Estas seguro de modificar esta Pensión?")){
    	document.form1.submit()
   	}else{
       	alert("Piensa lo que haces antes de apretar el botón");
    }
}
</script>