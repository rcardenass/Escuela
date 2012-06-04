
<?php require_once('../Connections/cn.php'); ?>
<?php
//MX Widgets3 include
require_once('../includes/wdg/WDG.php');

mysql_select_db($database_cn, $cn);
$query_rsDep = "SELECT CodDepartamento, Nombre FROM ubigeo WHERE CodDepartamento<>'00' AND CodProvincia='00' AND CodDistrito='00'";
$rsDep = mysql_query($query_rsDep, $cn) or die(mysql_error());
$row_rsDep = mysql_fetch_assoc($rsDep);
$totalRows_rsDep = mysql_num_rows($rsDep);

mysql_select_db($database_cn, $cn);
$query_rsProv = "SELECT CodDepartamento, CodProvincia, concat(CodDepartamento,'',CodProvincia) AS Suma, Nombre FROM ubigeo WHERE CodDepartamento<>'00' AND CodProvincia<>'00' AND CodDistrito='00'";
$rsProv = mysql_query($query_rsProv, $cn) or die(mysql_error());
$row_rsProv = mysql_fetch_assoc($rsProv);
$totalRows_rsProv = mysql_num_rows($rsProv);

mysql_select_db($database_cn, $cn);
$query_rsDist = "SELECT CodDepartamento, CodProvincia, CodDistrito, concat(CodDepartamento,'',CodProvincia) AS Suma, concat(CodDepartamento,'',CodProvincia,'',CodDistrito) AS Suma3, Nombre FROM ubigeo WHERE CodDepartamento<>'00' AND CodProvincia<>'00' AND CodDistrito<>'00'";
$rsDist = mysql_query($query_rsDist, $cn) or die(mysql_error());
$row_rsDist = mysql_fetch_assoc($rsDist);
$totalRows_rsDist = mysql_num_rows($rsDist);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:wdg="http://www.interaktonline.com/MXWidgets">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/javascript" src="../includes/common/js/sigslot_core.js"></script>
<script src="../includes/common/js/base.js" type="text/javascript"></script>
<script src="../includes/common/js/utility.js" type="text/javascript"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/MXWidgets.js.php"></script>
<script type="text/javascript" src="../includes/wdg/classes/JSRecordset.js"></script>
<script type="text/javascript" src="../includes/wdg/classes/DependentDropdown.js"></script>
<?php
//begin JSRecordset
$jsObject_rsProv = new WDG_JsRecordset("rsProv");
echo $jsObject_rsProv->getOutput();
//end JSRecordset
?>
<link href="../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<?php
//begin JSRecordset
$jsObject_rsDist = new WDG_JsRecordset("rsDist");
echo $jsObject_rsDist->getOutput();
//end JSRecordset
?>
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <label>
  <select name="Dep" id="Dep">
    <?php
do {  
?>
    <option value="<?php echo $row_rsDep['CodDepartamento']?>"><?php echo $row_rsDep['Nombre']?></option>
    <?php
} while ($row_rsDep = mysql_fetch_assoc($rsDep));
  $rows = mysql_num_rows($rsDep);
  if($rows > 0) {
      mysql_data_seek($rsDep, 0);
	  $row_rsDep = mysql_fetch_assoc($rsDep);
  }
?>
  </select>
  </label>
  <label>
  <select name="Prov" id="Prov" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsProv" wdg:displayfield="Nombre" wdg:valuefield="Suma" wdg:fkey="CodDepartamento" wdg:triggerobject="Dep">
  </select>
  </label>
  <label>
  <select name="Dist" id="Dist" wdg:subtype="DependentDropdown" wdg:type="widget" wdg:recordset="rsDist" wdg:displayfield="Nombre" wdg:valuefield="Suma3" wdg:fkey="Suma" wdg:triggerobject="Prov">
  </select>
  </label>
  <label>
  <textarea name="textarea"><?php echo $row_rsDist['Suma']; ?></textarea>
  </label>
</form>
</body>
</html>

<?php
echo "150108<br>";
echo substr(150108,4,2);

mysql_free_result($rsDep);

mysql_free_result($rsProv);

mysql_free_result($rsDist);
?>


