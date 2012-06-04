<?php require_once('../Connections/cn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../error.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsTreeview = "SELECT Id, NombrePrograma as Nombre, IdPadre, Url FROM programa WHERE CodPerfil=2 ";
$rsTreeview = mysql_query($query_rsTreeview, $cn) or die(mysql_error());
$row_rsTreeview = mysql_fetch_assoc($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

//$UsuarioDocente=$_SESSION['MM_Username'];
mysql_select_db($database_cn, $cn);
$query_rsMiGrado = "SELECT a.CodGrado, a.NombreGrado, d.NombreNivel ";
$query_rsMiGrado.= "FROM grado a ";
$query_rsMiGrado.= "INNER JOIN profesorcurso b ON b.CodGrado=a.CodGrado ";
$query_rsMiGrado.= "INNER JOIN personal c ON c.CodPersonal=b.CodPersonal ";
$query_rsMiGrado.= "INNER JOIN nivel d ON d.CodNivel=a.CodNivel ";
$query_rsMiGrado.= "WHERE c.UsuarioId='".$_SESSION['MM_Username']."' ";
$query_rsMiGrado.= "AND c.CodTipoPersonal=2 ";
$query_rsMiGrado.= "GROUP BY a.CodGrado, a.NombreGrado ";
$rsMiGrado = mysql_query($query_rsMiGrado, $cn) or die(mysql_error());
$row_rsMiGrado = mysql_fetch_assoc($rsMiGrado);
$totalRows_rsMiGrado = mysql_num_rows($rsMiGrado);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templatedoc.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
<link href="../styledoc.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="980px" border="0" align="center"><tr><td>
	<table width="980px" border="0" cellpadding="0">
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
	<h1>Mis Cursos</h1><hr /><br />
	<table>
    <?php 
	do {
		echo "<tr>";
			echo"<td>".$row_rsMiGrado['NombreGrado']." de ".$row_rsMiGrado['NombreNivel']."<td/>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
		echo "</tr>";
		//$IdGrado=$row_rsMiGrado['CodGrado'];
		mysql_select_db($database_cn, $cn);
		$query_rsMiSeccion ="SELECT a.CodSeccion, a.NombreSeccion ";
		$query_rsMiSeccion.="FROM seccion a ";
		$query_rsMiSeccion.="INNER JOIN profesorcurso b ON b.CodSeccion=a.CodSeccion ";
		$query_rsMiSeccion.="INNER JOIN personal c ON c.CodPersonal=b.CodPersonal ";
		$query_rsMiSeccion.="WHERE c.CodTipoPersonal=2 ";
		$query_rsMiSeccion.="AND c.UsuarioId='".$_SESSION['MM_Username']."' ";
		$query_rsMiSeccion.="AND b.CodGrado='".$row_rsMiGrado['CodGrado']."' ";
		$query_rsMiSeccion.="GROUP by a.CodSeccion, a.NombreSeccion ";
		$rsMiSeccion = mysql_query($query_rsMiSeccion, $cn) or die(mysql_error());
		$row_rsMiSeccion = mysql_fetch_assoc($rsMiSeccion);
		$totalRows_rsMiSeccion = mysql_num_rows($rsMiSeccion);
		do{
			echo "<tr>";
				echo"<td>&nbsp;</td>";
				echo "<td>".$row_rsMiSeccion['NombreSeccion']."</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
			echo "</tr>";
			//$IdSeccion=$row_rsMiSeccion['CodSeccion'];
			mysql_select_db($database_cn, $cn);
			$query_rsMiCurso ="SELECT a.CodGrado, a.CodSeccion, c.CodCurso, ";
			$query_rsMiCurso.="b.CodCurGra, a.CodProfesorCurso, c.NombreCurso, b.CodArea ";
			$query_rsMiCurso.="FROM profesorcurso a ";
			$query_rsMiCurso.="INNER JOIN cursogrado b ON b.CodCurGra=a.CodCurGra ";
			$query_rsMiCurso.="INNER JOIN curso c ON c.CodCurso=b.CodCurso ";
			$query_rsMiCurso.="INNER JOIN personal d ON d.CodPersonal=a.CodPersonal ";
			$query_rsMiCurso.="WHERE d.CodTipoPersonal=2 "; 
			$query_rsMiCurso.="and d.UsuarioId='".$_SESSION['MM_Username']."' ";
			$query_rsMiCurso.="and a.CodGrado='".$row_rsMiGrado['CodGrado']."' ";
			$query_rsMiCurso.="and a.CodSeccion='".$row_rsMiSeccion['CodSeccion']."' ";
			$rsMiCurso = mysql_query($query_rsMiCurso, $cn) or die(mysql_error());
			$row_rsMiCurso = mysql_fetch_assoc($rsMiCurso);
			$totalRows_rsMiCurso = mysql_num_rows($rsMiCurso);
			do{
				echo "<tr>";
					echo"<td>&nbsp;</td>";
					echo "<td>&nbsp;</td>";
					echo "<td>".$row_rsMiCurso['NombreCurso']."</td>";
					echo "<td><a href='alumnos.php?CodigoProfesorCurso=".$row_rsMiCurso['CodProfesorCurso']."' title='Alumnos del Curso'><img src='../imagenes/icono/user.png' width='32' height='32' border='0' /></a></td>";		
					echo "<td><a href='registro.php?CodigoProfesorCurso=".$row_rsMiCurso['CodProfesorCurso']."' title='Notas del Curso'><img src='../imagenes/icono/stats.png' width='32' height='32' border='0' /></a></td>";
					echo "<td><a href='consulta.php?&CodigoProfesorCurso=".$row_rsMiCurso['CodProfesorCurso']."' title='Consultar Notas del Curso'><img src='../imagenes/icono/informe.png' width='32' height='32' border='0' /></a></td>";
				echo "</tr>";
			} while ($row_rsMiCurso = mysql_fetch_assoc($rsMiCurso)); 		
		} while ($row_rsMiSeccion = mysql_fetch_assoc($rsMiSeccion)); 	
	} while ($row_rsMiGrado = mysql_fetch_assoc($rsMiGrado)); 
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
mysql_free_result($rsMiGrado);
mysql_free_result($rsMiSeccion);
mysql_free_result($rsMiCurso);
?>
