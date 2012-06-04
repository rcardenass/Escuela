<?php require_once('../Connections/cn.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "5";
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
$query_rsTreeview = "SELECT Id, NombrePrograma as Nombre, IdPadre, Url FROM programa WHERE CodPerfil=5 ";
$rsTreeview = mysql_query($query_rsTreeview, $cn) or die(mysql_error());
$row_rsTreeview = mysql_fetch_assoc($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);

$_SESSION['Anio']=$_POST['cboAnio'];
$_SESSION['Grado']=$_POST['cboGrado'];
$_SESSION['Seccion']=$_POST['cboSeccion'];
$_SESSION['Fecha']=$_POST['txtFecha'];

mysql_select_db($database_cn, $cn);
$query_rsAnio = "SELECT CodAnio, NombreAnio FROM anio where Estado=1 ORDER BY CodAnio DESC";
$rsAnio = mysql_query($query_rsAnio, $cn) or die(mysql_error());
$row_rsAnio = mysql_fetch_assoc($rsAnio);
$totalRows_rsAnio = mysql_num_rows($rsAnio);

mysql_select_db($database_cn, $cn);
$query_rsGrado = "SELECT CodGrado, NombreGrado FROM grado WHERE Estado = 1 ORDER BY CodNivel ASC";
$rsGrado = mysql_query($query_rsGrado, $cn) or die(mysql_error());
$row_rsGrado = mysql_fetch_assoc($rsGrado);
$totalRows_rsGrado = mysql_num_rows($rsGrado);

mysql_select_db($database_cn, $cn);
$query_rsSeccion = "SELECT  a.CodSeccion, b.CodGrado, a.NombreSeccion FROM seccion a INNER JOIN gradoseccion b ON b.CodSeccion=a.CodSeccion";
$rsSeccion = mysql_query($query_rsSeccion, $cn) or die(mysql_error());
$row_rsSeccion = mysql_fetch_assoc($rsSeccion);
$totalRows_rsSeccion = mysql_num_rows($rsSeccion);


mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT COUNT(*) AS Cantidad FROM asistencia WHERE CodAnio='".$_POST['cboAnio']."' AND CodGrado='".$_POST['cboGrado']."' AND CodSeccion='".$_POST['cboSeccion']."' AND DATE_FORMAT(FechaAsistencia,'%d/%m/%Y')='".$_POST['txtFecha']."' ";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	$Sql ="SELECT a.CodAlumno, b.CodMatricula, ";
	$Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno ";
	$Sql.="FROM alumno a ";
	$Sql.="INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno ";
	$Sql.="WHERE b.CodAnio='".$_POST['cboAnio']."' ";
	$Sql.="AND b.CodGrado='".$_POST['cboGrado']."' ";
	$Sql.="AND b.CodSeccion='".$_POST['cboSeccion']."' ";
}else{
	$Sql ="SELECT a.CodAlumno, b.CodMatricula, ";
	$Sql.="concat(a.ApellidoPaterno,' - ',a.ApellidoMaterno,' - ',a.Nombres) AS Alumno, c.Marca ";
	$Sql.="FROM alumno a ";
	$Sql.="INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno ";
	$Sql.="INNER JOIN asistencia c ON c.CodMatricula=b.CodMatricula ";
	$Sql.="WHERE b.CodAnio='".$_POST['cboAnio']."' ";
	$Sql.="AND b.CodGrado='".$_POST['cboGrado']."' ";
	$Sql.="AND b.CodSeccion='".$_POST['cboSeccion']."' ";
	$Sql.="AND DATE_FORMAT(c.FechaAsistencia,'%d/%m/%Y')='".$_POST['txtFecha']."' ";
}

mysql_select_db($database_cn, $cn);
/*$query_rsLista = "SELECT a.CodAlumno, b.CodMatricula,  concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno FROM alumno a INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno WHERE b.CodAnio='".$_POST['cboAnio']."' AND b.CodGrado='".$_POST['cboGrado']."' AND b.CodSeccion='".$_POST['cboSeccion']."' ";*/
$query_rsLista =$Sql;
$rsLista = mysql_query($query_rsLista, $cn) or die(mysql_error());
$row_rsLista = mysql_fetch_assoc($rsLista);
$totalRows_rsLista = mysql_num_rows($rsLista);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templateaux.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEditableHeadTag -->
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
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<!-- InstanceEndEditable -->
<link href="../styleaux.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div style = "display: table; margin-left: auto; margin-right: auto; width: 90%; background-color:#66FF00">
    <div style = "height: 105px; width: 100%; background-color:#FF3300" class="Logo">Cabecera</div>
    <div style = "float: left; height: 450px; width: 20%; background-color:#99CCFF" class="Menu">
		<div style="padding-left:10px">
			<div class="dtree">
			<p><a href="javascript: d.openAll();">abrir todo</a> | <a href="javascript: d.closeAll();">cerrar todo</a></p>
			<script type="text/javascript">
				<!--
				d = new dTree('d');
		
				d.add(0,-1,'Inicio');
				/*d.add(1,0,'Node 1','');
				d.add(2,0,'Node 2','prueba2.php');
				d.add(3,1,'Node 1.1','');
				d.add(4,0,'Node 3','prueba4.php');
				d.add(5,3,'Node 1.1.1','');
				d.add(6,5,'Node 1.1.1.1','prueba3.php');
				d.add(7,0,'Node 4','prueba5.php');
				d.add(8,1,'Node 1.2','prueba.php');
				d.add(9,0,'My Pictures','','Pictures I\'ve taken over the years','','','../treeview/img/imgfolder.gif');
				d.add(10,9,'The trip to Iceland','prueba3.php','Pictures of Gullfoss and Geysir');
				d.add(11,9,'Mom\'s birthday','prueba2.php');
				d.add(12,0,'Recycle Bin','prueba3.php','','','../treeview/img/trash.gif');*/
				<?php do { ?>
				d.add(<?php echo $row_rsTreeview['Id']; ?>,<?php echo $row_rsTreeview['IdPadre']; ?>,'<?php echo $row_rsTreeview['Nombre']; ?>','<?php echo $row_rsTreeview['Url']; ?>');
  				<?php } while ($row_rsTreeview = mysql_fetch_assoc($rsTreeview)); ?>
				
				document.write(d);
				//-->
			</script>
			</div>
		</div>
	</div>
    <div style = "float: right; height: 450px; width: 80%; background-color:#9999FF">
		<div style = "height: 450px; width: 99%; padding-left:5px"><!-- InstanceBeginEditable name="Contenido" -->
		<h1>Consultar Asistencia</h1><hr /><br />
		<form id="form1" name="form1" method="post" action="">
		  <table width="560" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><label class="label">Año</label></td>
              <td><label class="label">Grado</label></td>
              <td><label class="label">Sección</label></td>
              <td><label class="label">Fecha</label></td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td><select name="cboAnio" id="cboAnio" style="width:80px">
                <?php
do {  
?><option value="<?php echo $row_rsAnio['CodAnio']?>"<?php if (!(strcmp($row_rsAnio['CodAnio'], $_SESSION['Anio']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsAnio['NombreAnio']?></option>
                <?php
} while ($row_rsAnio = mysql_fetch_assoc($rsAnio));
  $rows = mysql_num_rows($rsAnio);
  if($rows > 0) {
      mysql_data_seek($rsAnio, 0);
	  $row_rsAnio = mysql_fetch_assoc($rsAnio);
  }
?>
                            </select></td>
              <td><select name="cboGrado" id="cboGrado" style="width:150px">
                <?php
do {  
?><option value="<?php echo $row_rsGrado['CodGrado']?>"<?php if (!(strcmp($row_rsGrado['CodGrado'], $_SESSION['Grado']))) {echo "selected=\"selected\"";} ?>><?php echo $row_rsGrado['NombreGrado']?></option>
                <?php
} while ($row_rsGrado = mysql_fetch_assoc($rsGrado));
  $rows = mysql_num_rows($rsGrado);
  if($rows > 0) {
      mysql_data_seek($rsGrado, 0);
	  $row_rsGrado = mysql_fetch_assoc($rsGrado);
  }
?>
                            </select></td>
              <td><select name="cboSeccion" id="cboSeccion" style="width:150px" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsSeccion" wdg:displayfield="NombreSeccion" wdg:valuefield="CodSeccion" wdg:fkey="CodGrado" wdg:triggerobject="cboGrado" wdg:selected="<?php echo $_SESSION['Seccion']; ?>">
              </select></td>
              <td><label>
                <input name="txtFecha" id="txtFecha" style="width:65px" title="dd/mm/yy" value="<?php echo $_SESSION['Fecha']; ?>" maxlength="10" wdg:mondayfirst="false" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" wdg:readonly="true"/>
              </label></td>
              <td align="right"><input type="submit" name="Submit" value="Aceptar" /></td>
            </tr>
          </table>
		  <br />
		  <table width="80%" border="0" cellspacing="1" cellpadding="0" class="table">
            <tr class="tr">
              <td width="50">&nbsp;</td>
              <td>Alumno</td>
              <td width="120">&nbsp;A&nbsp;&nbsp;&nbsp;B&nbsp;&nbsp;&nbsp;C&nbsp;&nbsp;&nbsp;D&nbsp;&nbsp;&nbsp;E</td>
            </tr>
            <?php 
			if(!empty($totalRows_rsLista)){
			do { 
			?>
            <tr>
              <td width="50"><?php echo $row_rsLista['CodMatricula']; ?>
              <input name="txtCodigoMatricula[]" type="hidden" id="txtCodigoMatricula[]" value="<?php echo $row_rsLista['CodMatricula']; ?>" /></td>
              <td><?php echo $row_rsLista['Alumno']; ?></td>
              <td width="120">
                <label>
                  <input <?php if (!(strcmp($row_rsLista['Marca'],"1"))) {echo "checked=\"checked\"";} ?> name="optAsistecia[<?php echo $row_rsLista['CodMatricula']; ?>]" type="radio" value="1" disabled="disabled"/>
                </label>
                <label>
                  <input <?php if (!(strcmp($row_rsLista['Marca'],"2"))) {echo "checked=\"checked\"";} ?> type="radio" name="optAsistecia[<?php echo $row_rsLista['CodMatricula']; ?>]" value="2" disabled="disabled"/>
                </label>
                <label>
                  <input <?php if (!(strcmp($row_rsLista['Marca'],"3"))) {echo "checked=\"checked\"";} ?> type="radio" name="optAsistecia[<?php echo $row_rsLista['CodMatricula']; ?>]" value="3" disabled="disabled"/>
                </label>
                <label>
                  <input <?php if (!(strcmp($row_rsLista['Marca'],"4"))) {echo "checked=\"checked\"";} ?> type="radio" name="optAsistecia[<?php echo $row_rsLista['CodMatricula']; ?>]" value="4" disabled="disabled"/>
                </label>
                <label>
                  <input <?php if (!(strcmp($row_rsLista['Marca'],"5"))) {echo "checked=\"checked\"";} ?> type="radio" name="optAsistecia[<?php echo $row_rsLista['CodMatricula']; ?>]" value="5" disabled="disabled"/>
                </label>            
			  </td>
            </tr>
              <?php 
			  } while ($row_rsLista = mysql_fetch_assoc($rsLista));
			  } 
			  ?>
          </table>
		  <div style="width:80%; height:5px"></div>
	<!--<div style="width:80%">
		<div style="width:170px; float:left">
			<label>Activar Opción Grabar
			<input name="checkbox" type="checkbox" 
			onclick="document.form1.enviar.disabled=!document.form1.enviar.disabled" value="acepto"  
			<? 
			/*if(isset($_POST['cboSeccion'])){
				
			}else{ 
				echo "disabled='disabled' ";
			}*/
			?> />
</label>
		</div>
		<div style="width:300px; float:right; text-align:right">
			<input type="button" value="Grabar" name="enviar" disabled="disabled"  
			onclick="document.form1.action='insertasistencia.php'; document.form1.submit()"; />
		</div>
	</div>-->
        </form>
		<!-- InstanceEndEditable -->	
		</div>
	</div>
    <div style = "clear: both; height: 50px; width: 100%; background-color:#00FF00" class="Pie">Pie</div>
</div> 
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsTreeview);

mysql_free_result($rsAnio);

mysql_free_result($rsGrado);

mysql_free_result($rsSeccion);

mysql_free_result($rsLista);

mysql_free_result($rsValida);
?>
