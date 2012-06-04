<?php //require_once('../Connections/cn.php'); ?>
<?php
/*mysql_select_db($database_cn, $cn);
$query_rsCcorriente = "SELECT CodAlumno FROM alumno";
$rsCcorriente = mysql_query($query_rsCcorriente, $cn) or die(mysql_error());
$row_rsCcorriente = mysql_fetch_assoc($rsCcorriente);
$totalRows_rsCcorriente = mysql_num_rows($rsCcorriente);*/

function CuentaCorriente($CodAlumno, $Usuario)
{
	require_once('../Connections/cn.php');
	mysql_select_db($database_cn, $cn);
	$Sql = "insert into cuentacorriente (CodCuentaCorriente, CodAlumno, UsuarioCreacion, FechaCreacion) ";
	$Sql .="values ('null', '".$CodAlumno."', '".$Usuario."', now())";
	$rsGrabar = mysql_query($Sql, $cn) or die(mysql_error());
}

?>