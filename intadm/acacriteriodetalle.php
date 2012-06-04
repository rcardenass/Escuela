<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$colname_rsCriterioCurso = "-1";
if (isset($_GET['Codigo'])) {
  $colname_rsCriterioCurso = (get_magic_quotes_gpc()) ? $_GET['Codigo'] : addslashes($_GET['Codigo']);
}
mysql_select_db($database_cn, $cn);
$query_rsCriterioCurso = sprintf("SELECT b.CodCriterioCurso, c.NombreGrado, e.NombreCurso, a.NombreCriterio, a.Porcentaje, b.NroNotas FROM criterio a INNER JOIN criteriocurso b ON b.CodCriterio=a.CodCriterio INNER JOIN grado c ON c.CodGrado=a.CodGrado INNER JOIN cursogrado d ON d.CodCurGra=b.CodCurGra INNER JOIN  curso e ON e.CodCurso=d.CodCurso WHERE a.CodCriterio= %s", $colname_rsCriterioCurso);
$rsCriterioCurso = mysql_query($query_rsCriterioCurso, $cn) or die(mysql_error());
$row_rsCriterioCurso = mysql_fetch_assoc($rsCriterioCurso);
$totalRows_rsCriterioCurso = mysql_num_rows($rsCriterioCurso);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../styleadm.css" rel="stylesheet" type="text/css" />

</head>
<body>
<h1>Cursos por Criterio</h1><hr /><br />
<table class="table" width="95%" border="0" cellspacing="2" cellpadding="0" >
  <tr class="tr">
    <td>Grado</td>
    <td>Curso</td>
    <td>Criterio</td>
    <td>Porcentaje</td>
    <td width="70"><div align="center">Nro Notas </div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_rsCriterioCurso['NombreGrado']; ?></td>
      <td><?php echo $row_rsCriterioCurso['NombreCurso']; ?></td>
      <td><?php echo $row_rsCriterioCurso['NombreCriterio']; ?></td>
      <td><?php echo $row_rsCriterioCurso['Porcentaje']; ?></td>
      <td width="70"><div align="center"><?php echo $row_rsCriterioCurso['NroNotas']; ?></div></td>
    </tr>
    <?php } while ($row_rsCriterioCurso = mysql_fetch_assoc($rsCriterioCurso)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($rsCriterioCurso);
?>
