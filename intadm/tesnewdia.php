<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  /*$insertSQL = sprintf("INSERT INTO dia (Fecha, UsuarioCreacion, FechaCreacion) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['txtDia'], "date"),
                       GetSQLValueString($_SESSION['MM_Username'], "text"),
                       GetSQLValueString(now(), "date"));*/
	mysql_select_db($database_cn, $cn);
	$query_rsVerificaCierre = "SELECT COUNT(*) AS Cantidad FROM dia WHERE Estado=1 ORDER BY FechaApertura DESC limit 1 ";
	$rsVerificaCierre = mysql_query($query_rsVerificaCierre, $cn) or die(mysql_error());
	$row_rsVerificaCierre = mysql_fetch_assoc($rsVerificaCierre);
	$totalRows_rsVerificaCierre = mysql_num_rows($rsVerificaCierre);					   				   
	
	if($row_rsVerificaCierre['Cantidad']==0){
		mysql_select_db($database_cn, $cn);
		$query_rsValida = "SELECT COUNT(*) AS Cantidad FROM dia WHERE DATE_FORMAT(FechaApertura,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y') ";
		$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
		$row_rsValida = mysql_fetch_assoc($rsValida);
		$totalRows_rsValida = mysql_num_rows($rsValida);					   
						   
		if($row_rsValida['Cantidad']==0){
			//$Fecha=substr($_POST['txtDia'], -4, 4).'-'.substr($_POST['txtDia'], 3, 2).'-'.substr($_POST['txtDia'], 0, 2);
			$insertSQL = "INSERT INTO dia (FechaApertura, UsuarioCreacion, FechaCreacion) VALUES (now(), '".$_SESSION['MM_Username']."', now())";
			mysql_select_db($database_cn, $cn);
			$Result1 = mysql_query($insertSQL, $cn) or die(mysql_error());
			
			$insertGoTo = "tesdia.php";
			if (isset($_SERVER['QUERY_STRING'])) {
				$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
				$insertGoTo .= $_SERVER['QUERY_STRING'];
			}
			header(sprintf("Location: %s", $insertGoTo));
		}else{
			$_SESSION['TablaDia']="No es posible grabar. Este registro ya existe.";
		}
	}else{
		$_SESSION['TablaDia']="Existe un día pendiente de cerrar. No es posible abrir el día";
	}
}
?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);
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
<!-- InstanceEditableHeadTag -->
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
		<h1>Nuevo Día</h1><hr /><br />
		<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1" onsubmit="MM_validateForm('txtDia','','R');return document.MM_returnValue" autocomplete="Off">
		  <table width="320" border="0" cellspacing="1" cellpadding="0">
            <tr>
              <td width="30">Dia</td>
              <td><label>
                <input name="txtDia" id="txtDia" style="width:80px" value="" maxlength="10" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:type="widget" wdg:mondayfirst="false" wdg:singleclick="true" wdg:restricttomask="no" wdg:readonly="true" />
              </label></td>
              <td align="right">
                <input type="submit" name="Submit" value="Generar Día" />              </td>
              <td align="right">
                <input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;tesdia.php&quot;'/>
              </td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1">
		</form>
		<br />
		<span><? echo $_SESSION['TablaDia']; ?></span>
		<? 
		$_SESSION['TablaDia']=NULL;
		unset($_SESSION['TablaDia']); 
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
?>
