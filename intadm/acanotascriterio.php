<?php include("../seguridad.php");?>
<?php include('../funciones.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$_SESSION['Anio']=$_POST['cboAnio'];
$_SESSION['Grado']=$_POST['cboGrado'];
$_SESSION['Seccion']=$_POST['cboSeccion'];
$_SESSION['Curso']=$_POST['cboCurso'];
$_SESSION['Bimestre']=$_POST['cboBimestre'];
$_SESSION['Criterio']=$_POST['cboCriterio'];

$rsAnio = $objDatos->ObtenerAnioSelAll();
$rowAnio = $objDatos->PoblarAnioSelAll($rsAnio);

$rsGrado = $objDatos->ObtenerGradoSelAll();
$rowGrado = $objDatos->PoblarGradoSelAll($rsGrado);

$rsSeccion = $objDatos->ObtenerSeccionGradoSelAll();

$rsBimestre = $objDatos->ObtenerBimestreSelAll();
$rowBimestre = $objDatos->PoblarBimestreSelAll($rsBimestre);

$rsCursoGrado = $objDatos->ObtenerCursoGradoSelAll();

if(empty($_SESSION['Anio'])){
	$rsCriterioDependiente = $objDatos->ObtenerCriterioDependienteSelAll(0,0,0);
}else{
	$rsCriterioDependiente = $objDatos->ObtenerCriterioDependienteSelAll($_SESSION['Anio'],$_SESSION['Grado'],$_SESSION['Curso']);
}
$rowCriterioDependiente = $objDatos->PoblarCriterioDependienteSelAll($rsCriterioDependiente);

if(empty($_SESSION['Anio'])){
	$rsMatricula = $objDatos->ObtenerMatriculadoGradoSeccionSelAll(0,0,0);
}else{
	$rsMatricula = $objDatos->ObtenerMatriculadoGradoSeccionSelAll($_SESSION['Anio'],$_SESSION['Grado'],$_SESSION['Seccion']);
}
$rowMatricula = $objDatos->PoblarMatriculadoGradoSeccionSelAll($rsMatricula);
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
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rsSeccion = new WDG_JsRecordset("rsSeccion");
echo $jsObject_rsSeccion->getOutput();
//end JSRecordset

//begin JSRecordset
$jsObject_rsCursoGrado = new WDG_JsRecordset("rsCursoGrado");
echo $jsObject_rsCursoGrado->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
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
		<h1>Notas de Criterios</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="">
		<table width="700" border="0" cellspacing="2" cellpadding="0">
		  <tr>
			<td><span class="label">Año</span></td>
			<td><span class="label">Grado</span></td>
			<td><span class="label">Seccion</span></td>
			<td><span class="label">Curso</span></td>
		  </tr>
		  <tr>
			<td>
			<select name="cboAnio" id="cboAnio" style="width:150px">
			<!--<option value="">Seleccione</option>-->
			<? do{ ?>
				<option value="<? echo $rowAnio['CodAnio'];?>"
				<?php if (!(strcmp($rowAnio['CodAnio'], $_SESSION['Anio']))) {echo "selected=\"selected\"";} ?>>
				<? echo $rowAnio['NombreAnio'];?></option>
			<? }while($rowAnio = $objDatos->PoblarAnioSelAll($rsAnio)); ?>
			</select>
			</td>
			<td>
			<select name="cboGrado" id="cboGrado" style="width:200px">
			<!--<option value="">Seleccione</option>-->
			<? do{ ?>
				<option value="<? echo $rowGrado['CodGrado'];?>"
				<?php if (!(strcmp($rowGrado['CodGrado'], $_SESSION['Grado']))) {echo "selected=\"selected\"";} ?>><? echo $rowGrado['NombreGrado'];?>
				</option>
			<? }while($rowGrado = $objDatos->PoblarGradoSelAll($rsGrado)); ?>
			</select>
			</td>
			<td>
			<select name="cboSeccion" id="cboSeccion" wdg:subtype="DependentDropdown" wdg:type="widget" 
			wdg:recordset="rsSeccion" wdg:displayfield="NombreSeccion" wdg:valuefield="CodSeccion" 
			wdg:fkey="CodGrado" wdg:triggerobject="cboGrado" style="width:50px" wdg:selected="<?php echo $_SESSION['Seccion']; ?>" />
			</td>
			<td>
			<select name="cboCurso" id="cboCurso" wdg:subtype="DependentDropdown" wdg:type="widget" 
			wdg:recordset="rsCursoGrado" wdg:displayfield="NombreCurso" wdg:valuefield="CodCurGra" 
			wdg:fkey="CodGrado" wdg:triggerobject="cboGrado" style="width:247px" wdg:selected="<?php echo $_SESSION['Curso']; ?>">
			</select>
			</td>
		  </tr>
		  <tr>
			<td><span class="label">Bimestre</span></td>
			<td><span class="label">Criterio</span></td>
			<td></td>
			<td></td>
		  </tr>
		  <tr>
			<td>
			<select name="cboBimestre" id="cboBimestre" style="width:150px">
			<!--<option value="">Seleccione</option>-->
			<? do{ ?>
				<option value="<? echo $rowBimestre['CodBimestre'];?>"
				<?php if (!(strcmp($rowBimestre['CodBimestre'], $_SESSION['Bimestre']))) {echo "selected=\"selected\"";} ?>>
				<? echo $rowBimestre['NombreBimestre'];?></option>
			<? }while($rowBimestre = $objDatos->PoblarBimestreSelAll($rsBimestre)); ?>
			</select>
			</td>
			<td colspan="3">
			<select name="cboCriterio" id="cboCriterio" style="width:450px">
			<!--<option value="">Seleccione</option>-->
			<? do{ ?>
				<option value="<? echo $rowCriterioDependiente['CodCriterioCurso'];?>"
				<?php if (!(strcmp($rowCriterioDependiente['CodCriterioCurso'], $_SESSION['Criterio']))) {echo "selected=\"selected\"";} ?>>
				<? echo $rowCriterioDependiente['NombreCriterio'];?></option>
			<? }while($rowCriterioDependiente = $objDatos->PoblarCriterioDependienteSelAll($rsCriterioDependiente)); ?>
			</select>&nbsp;&nbsp;
			<input type="submit" name="Submit" value="Buscar" />
			</td>
			<!--<td></td>
			<td>
			<input type="submit" name="Submit" value="Enviar" />
			</td>-->
		  </tr>
		</table>
		<br />
		<?
		if(!empty($_SESSION['Anio']) and !empty($_SESSION['Grado']) and !empty($_SESSION['Seccion']) and !empty($_SESSION['Curso'])){
			$rsProfesor = $objDatos->ObtenerProfesorCursoSelId($_SESSION['Anio'],$_SESSION['Grado'],$_SESSION['Seccion'],$_SESSION['Curso']);
			$rowProfesor = $objDatos->PoblarProfesorCursoSelId($rsProfesor);
			echo "<span class='label'>Docente: ".$rowProfesor['Personal']."</span>";
		}

		if(empty($_SESSION['Grado'])){
			$IdGrado=1;
		}else{
			$IdGrado=$_SESSION['Grado'];
		}
		$rsNivelGrado = $objDatos->ObtenerNivelGradoSelId($IdGrado);
		$rowNivelGrado = $objDatos->PoblarNivelGradoSelId($rsNivelGrado);
		?>
		<table width="685" border="0" cellspacing="2" cellpadding="0" class="table">
		  <tr class="tr">
			<td width="50"><div style="padding-right:5px; text-align:right">Id</div></td>
			<td>Alumno</td>
			<td width="120"><div style="padding-right:5px; text-align:right">Nota de Criterio</div></td>
		  </tr>
		  <? 
		  if(!empty($_SESSION['Anio'])){
			  do{ 
			  ?>
			  <? Filas();?>
				<td width="50"><div style="padding-right:5px; text-align:right"><strong><? echo $rowMatricula['CodMatricula']; ?></strong></div></td>
				<td><? echo $rowMatricula['Alumno']; ?></td>
				<td width="120">
					<div style="padding-right:5px; text-align:right">
					<? 
					if(!empty($_SESSION['Criterio'])){
						if($rowNivelGrado['CodNivel']!=3){
							$rsNota = $objDatos->ObtenerNotaCriterioPrimariaSelAll($_SESSION['Anio'],$_SESSION['Grado'],$_SESSION['Seccion'],
							$_SESSION['Curso'],$rowProfesor['CodProfesorCurso'],$rowMatricula['CodMatricula'],$_SESSION['Bimestre'],$_SESSION['Criterio']);
							$rowNota = $objDatos->PoblarNotaCriterioPrimariaSelAll($rsNota);
							do{ 
								echo $rowNota['Nota']."&nbsp;";
							}while($rowNota = $objDatos->PoblarNotaCriterioPrimariaSelAll($rsNota));
						}else{
							$rsNota = $objDatos->ObtenerNotaCriterioSecundariaSelAll($_SESSION['Anio'],$_SESSION['Grado'],$_SESSION['Seccion'],
							$_SESSION['Curso'],$rowProfesor['CodProfesorCurso'],$rowMatricula['CodMatricula'],$_SESSION['Bimestre'],$_SESSION['Criterio']);
							$rowNota = $objDatos->PoblarNotaCriterioSecundariaSelAll($rsNota);
							do{ 
								echo $rowNota['Nota']."&nbsp;";
							}while($rowNota = $objDatos->PoblarNotaCriterioSecundariaSelAll($rsNota));
						}
					}
					?>
					</div>
				</td>
			  </tr>
			  <? 
			  }while($rowMatricula = $objDatos->PoblarMatriculadoGradoSeccionSelAll($rsMatricula));
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
?>
