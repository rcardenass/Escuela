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

$rsPrograma = $objDatos->ObtenerProgramaSelAll();
$rowPrograma = $objDatos->PoblarProgramaSelAll($rsPrograma);

$rsArea = $objDatos->ObtenerAreaSelAll();
$rowArea = $objDatos->PoblarAreaSelAll($rsArea);

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);

$rsCurso = $objDatos->ObtenerCursoSelAll();
$rowCurso = $objDatos->PoblarCursoSelAll($rsCurso);
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
		<h1>Nuevo Curso-Grado</h1><hr /><br />	
		<form action="acainsertcursogrado.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('cboPrograma','','RisNum','cboArea','','RisNum','cboCurso','','RisNum','cboGrado','','RisNum');return document.MM_returnValue" autocomplete="Off">
		  <table width="420" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="250">Programa</td>
              <td width="150">Area</td>
            </tr>
            <tr>
              <td><label>
                <select name="cboPrograma" id="cboPrograma" style="width:200px">
                  <option value="">Seleccione</option>
                  <?php
do {  
?>
                  <option value="<?php echo $rowPrograma['CodProgramaAcademico']?>"><?php echo $rowPrograma['Programa']?></option>
                  <?php
} while ($rowPrograma = $objDatos->PoblarProgramaSelAll($rsPrograma));
?>
              </select>
              </label></td>
              <td width="150"><label>
                <select name="cboArea" id="cboArea" style="width:200px">
                  <option value="">Seleccione</option>
                  <?php
do {  
?>
                  <option value="<?php echo $rowArea['CodArea']?>"><?php echo $rowArea['NombreArea']?></option>
                  <?php
} while ($rowArea = $objDatos->PoblarAreaSelAll($rsArea));
?>
                </select>
              </label></td>
            </tr>
            <tr>
              <td>Curso</td>
              <td width="150">Grado</td>
            </tr>
            <tr>
              <td><select name="cboCurso" id="cboCurso" style="width:200px">
                <option value="">Seleccione</option>
                <?php
do {  
?>
                <option value="<?php echo $rowCurso['CodCurso']?>"><?php echo $rowCurso['NombreCurso']?></option>
                <?php
} while ($rowCurso = $objDatos->PoblarCursoSelAll($rsCurso));
?>
                                          </select></td>
              <td width="150"><select name="cboGrado" id="cboGrado" style="width:200px">
                <option value="">Seleccione</option>
                <?php
do {  
?>
                <option value="<?php echo $rowGrado['CodGrado']?>"><?php echo $rowGrado['NombreGrado']?></option>
                <?php
} while ($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado));
?>
              </select></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td width="150">&nbsp;</td>
            </tr>
          </table>
		  <div style="width:420px; text-align:right"><input type="submit" name="Submit" value="Aceptar" />&nbsp;&nbsp;&nbsp;<input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;acacursogrado.php&quot;'/></div>
		</form>
		<br />
		<span><? echo $_SESSION['TablaCursoGrado']; ?></span>
		<? 
		$_SESSION['TablaCursoGrado']=NULL;
		unset($_SESSION['TablaCursoGrado']); 
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

mysql_free_result($rsGrado);

mysql_free_result($rsCurso);

mysql_free_result($rsPrograma);

mysql_free_result($rsArea);
?>
