<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$colname_rsMensaje = "-1";
if (isset($_GET['Codigo'])) {
  $colname_rsMensaje = (get_magic_quotes_gpc()) ? $_GET['Codigo'] : addslashes($_GET['Codigo']);
}
mysql_select_db($database_cn, $cn);
$query_rsMensaje = sprintf("SELECT a.CodMensaje, a.De, a.Para, a.Asunto, a.FechaEnvio, c.NombrePerfil, b.Mensaje FROM mensaje a inner join detallemensaje b on b.CodMensaje=a.CodMensaje inner join perfil c on c.CodPerfil=a.CodPerfil WHERE a.CodMensaje = %s", $colname_rsMensaje);
$rsMensaje = mysql_query($query_rsMensaje, $cn) or die(mysql_error());
$row_rsMensaje = mysql_fetch_assoc($rsMensaje);
$totalRows_rsMensaje = mysql_num_rows($rsMensaje);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<h2><?php echo $row_rsMensaje['Asunto']; ?></h2>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h3><?php echo "De: ".$row_rsMensaje['De']; ?></h3></td>
    <td align="right"><?php echo $row_rsMensaje['FechaEnvio']; ?></td>
  </tr>
</table>
<br />
<?php echo "Para: ".$row_rsMensaje['Para']; ?>
<hr />
<?php echo $row_rsMensaje['Mensaje']; ?>
</body>
</html>
<?php
mysql_free_result($rsMensaje);
?>
