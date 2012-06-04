<?php 
include("../seguridadpadre.php");
include('../funciones.php'); 

include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuPadreSelAll();
$row_rsTreeview = $objDatos->PoblarMenuPadreSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$rsPadre=$objDatos->ObtenerPadreFamiliaSelId2($_SESSION['MM_Username']);
$row_Padre=$objDatos->PoblarPadreFamiliaSelId2($rsPadre);

$rsHijo=$objDatos->ObtenerHijosDePadreSelAll($row_Padre['CodPadreFamilia'], $row_Padre['Tipo']);
$row_Hijo=$objDatos->PoblarHijosDePadreSelAll($rsHijo);

if(isset($_GET['Id'])){
	$_SESSION['Hijo']=$_GET['Id'];
}

$rsMatricula=$objDatos->ObtenerUltimaMatriculaSelId($_SESSION['Hijo']);
$row_Matricula=$objDatos->PoblarUltimaMatriculaSelId($rsMatricula);

$rs_Companiero=$objDatos->ObtenerCompanierosAlumnoSelAll($_SESSION['Hijo'], $row_Matricula['CodAnio'] ,$row_Matricula['CodGrado'], $row_Matricula['CodSeccion']);
$row_Companiero=$objDatos->PoblarCompanierosAlumnoSelAll($rs_Companiero);
$totalRows_rsCompaniero = mysql_num_rows($rs_Companiero);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templatepad.dwt.php" codeOutsideHTMLIsLocked="false" -->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Intranet del Padre de Familia</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
<link href="../stylepad.css" rel="stylesheet" type="text/css" />
<script type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<div style = "display: table; margin-left: auto; margin-right: auto; width: 90%" class="Menu">
    <div style = "height: 201px; width: 100%;">
      <? require_once("../cabecerapadre.php"); ?>
    </div>
	<!--<div style="height:2px;"></div>-->
    <div style = "float: left; height:100%; width: 20%" class="Menu">
	  <div style="padding-left:10px">	
			<div class="dtree">
				<div style="height:5px"></div>
				<a href="javascript: d.openAll();">Abrir todo</a> | <a href="javascript: d.closeAll();">Cerrar todo</a>
				<div style="height:10px"></div>
				<span class="label">Hijos</span>
				<form id="form1" name="form1" method="post" action="">
					<select name="menu1" onchange="MM_jumpMenu('parent',this,0)" style="width:94%">
						<? if(!isset($_SESSION['Hijo'])){ ?>
                    	<option value="" <?php if (!(strcmp("", $_SESSION['Hijo']))) {echo "selected=\"selected\"";} ?>>
						Seleccione</option>
						<? } ?>
						<? do{ ?>
                    	<option value="default.php?Id=<? echo $row_Hijo['CodAlumno'];?>"
						<?php if (!(strcmp($row_Hijo['CodAlumno'], $_SESSION['Hijo']))) {echo "selected=\"selected\"";} ?>>
						<? echo $row_Hijo['Alumno'];?>
						</option>
                        <? }while($row_Hijo=$objDatos->PoblarHijosDePadreSelAll($rsHijo)); ?>
					</select>
				</form>
				<div style="height:10px"></div>
				
				<? if(isset($_SESSION['Hijo'])){ ?>
				<script type="text/javascript">
					d = new dTree('d');
					d.add(0,-1,'Inicio','default.php');
					<?php do { ?>
					d.add(<?php echo $row_rsTreeview['Id']; ?>,<?php echo $row_rsTreeview['IdPadre']; ?>,'<?php echo $row_rsTreeview['Nombre']; ?>','<?php echo $row_rsTreeview['Url']; ?>');
					<?php } while ($row_rsTreeview = $objDatos->PoblarMenuPadreSelAll($rsTreeview)); ?>
					document.write(d);
				</script>
				<? }?>
			</div>
	  </div>
		<div style="height:10px"></div>
  </div>
    <div style = "float: right; height: 100%; width: 80%; overflow:hidden" class="Contenedor">
		<div style = "width: 99%; height: 100%; padding-left:5px">
		<!-- InstanceBeginEditable name="Contenido" -->
		<h1>Compa&ntilde;eros de mi Hijo </h1><hr /><br />
		<table width="450" border="0" cellspacing="2" cellpadding="0" class="table">
          <tr class="tr">
            <td width="60"><div style="text-align:right; padding-right:5px">C&oacute;digo</div></td>
            <td>Alumnos</td>
          </tr>
          <? if(empty($totalRows_rsCompaniero)){ ?>
          <tr>
            <td colspan="2"><div style="text-align:left; padding-left:5px">No hay registros</div></td>
          </tr>
          <? } ?>
          <? if($totalRows_rsCompaniero>0){ ?>
          <? do{ ?>
          <tr>
            <td width="60"><div style="text-align:right; padding-right:5px"><strong><? echo $row_Companiero['CodAlumno']?></strong></div></td>
            <td><? echo $row_Companiero['Alumno']?></td>
          </tr>
          <? }while($row_Companiero=$objDatos->PoblarCompanierosAlumnoSelAll($rs_Companiero)); ?>
          <? } ?>
        </table>
		<!-- InstanceEndEditable -->		
		</div>
		<div style="height:10px"></div>
	</div>
    <div style = "clear: both; height: 35px; width: 100%">
	<!--<div style="height:2px;"></div>-->
	<? require_once("../pie.php"); ?>
	</div>
</div> 
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsTreeview);
?>
