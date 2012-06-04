<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

$colname_rsEditDetallePension = "-1";
if (isset($_GET['Id'])) {
  $colname_rsEditDetallePension = (get_magic_quotes_gpc()) ? $_GET['Id'] : addslashes($_GET['Id']);
}
mysql_select_db($database_cn, $cn);
$query_rsEditDetallePension = "SELECT CodDetallePension, CodPension, NroPension, Monto, DATE_FORMAT(FechaInicio,'%d/%m/%Y') as FechaInicio, DATE_FORMAT(FechaTermino,'%d/%m/%Y') as FechaTermino FROM detallepension WHERE CodDetallePension = '".$_GET['Id']."' ";
$rsEditDetallePension = mysql_query($query_rsEditDetallePension, $cn) or die(mysql_error());
$row_rsEditDetallePension = mysql_fetch_assoc($rsEditDetallePension);
$totalRows_rsEditDetallePension = mysql_num_rows($rsEditDetallePension);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/JavaScript" src="../validar.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/NumericInput.js"></script>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/SmartDate.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/Calendar.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar_stripped.js"></script>
<script type="text/javascript" src="../includes/wdg/calendar/calendar-setup_stripped.js"></script>
<script src="../includes/resources/calendar.js"></script>
<link href="../styleadm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h1>Editar Programación de Pago del mes</h1><hr /><br />
<form action="facupdatedetallepension.php" method="post" name="form1" id="form1" onsubmit="MM_validateForm('txtMonto','','RisNum','txtDesde','','R','txtHasta','','R');return document.MM_returnValue">
  <table width="250" border="0" cellspacing="1" cellpadding="0">
    <tr>
      <td width="80">Nro Pensi&oacute;n </td>
      <td width="167">&nbsp;&nbsp;&nbsp;<?php echo $row_rsEditDetallePension['NroPension']; ?></td>
    </tr>
    <tr>
      <td>Monto</td>
      <td><label>
        <input name="txtMonto" id="txtMonto" style="width:70px" value="<?php echo $row_rsEditDetallePension['Monto']; ?>" maxlength="7" wdg:subtype="NumericInput" wdg:negatives="no" wdg:type="widget" wdg:floats="yes" wdg:spinner="no"/>
      </label></td>
    </tr>
    <tr>
      <td>Desde</td>
      <td><label>
        <input name="txtDesde" id="txtDesde" style="width:100px" value="<?php echo $row_rsEditDetallePension['FechaInicio']; ?>" maxlength="10" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" wdg:readonly="true"/>
      </label></td>
    </tr>
    <tr>
      <td>Hasta</td>
      <td><label>
        <input name="txtHasta" id="txtHasta" style="width:100px" value="<?php echo $row_rsEditDetallePension['FechaTermino']; ?>" maxlength="10" wdg:subtype="Calendar" wdg:mask="<?php echo $KT_screen_date_format; ?>" wdg:mondayfirst="false" wdg:type="widget" wdg:singleclick="false" wdg:restricttomask="no" wdg:readonly="true"/>
      </label></td>
    </tr>
    <tr>
      <td><input name="txtId" type="hidden" id="txtId" value="<?php echo $row_rsEditDetallePension['CodDetallePension']; ?>" />
      <input name="txtCodigo" type="hidden" id="txtCodigo" value="<?php echo $_GET['Codigo']; ?>" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div style="width:217px; text-align:right">
   <input type="submit" name="Submit" value="Enviar" />&nbsp;&nbsp;
	    <input type="button" name="button" id="button" value="Volver"  
		onclick='javascript: self.location.href=&quot;facdetallepension.php?Codigo=<?php echo $_GET['Codigo']; ?>&quot;'/>
  </div>
</form>
</body>
</html>
<?php
mysql_free_result($rsEditDetallePension);
?>
