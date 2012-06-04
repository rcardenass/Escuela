<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsProgramacion = "SELECT CodProgramacionAlumno, CodAlumno, CodAnio, CodGrado, CodSeccion, NroPension, Monto, Mora, Pagado, FechaInicio, FechaTermino, Estado, UsuarioCreacion, FechaCreacion, UsuarioModificacion, FechaModificacion FROM programacionalumno WHERE CodProgramacionAlumno = '".$_POST['txtCodigo']."' ";
$rsProgramacion = mysql_query($query_rsProgramacion, $cn) or die(mysql_error());
$row_rsProgramacion = mysql_fetch_assoc($rsProgramacion);
$totalRows_rsProgramacion = mysql_num_rows($rsProgramacion);

$FechaInicio=substr($_POST['txtDesde'], -4, 4).'-'.substr($_POST['txtDesde'], 3, 2).'-'.substr($_POST['txtDesde'], 0, 2);
$FechaTermino=substr($_POST['txtHasta'], -4, 4).'-'.substr($_POST['txtHasta'], 3, 2).'-'.substr($_POST['txtHasta'], 0, 2);

$Sql ="insert into programacionalumno (CodProgramacionAlumno, CodAlumno, CodAnio, CodGrado, CodSeccion, ";
$Sql.="NroPension, Monto, Mora, Pagado, FechaInicio, FechaTermino, UsuarioCreacion, FechaCreacion, Referencia) ";
$Sql.="values ('null', '".$row_rsProgramacion['CodAlumno']."', '".$row_rsProgramacion['CodAnio']."', ";
$Sql.="'".$row_rsProgramacion['CodGrado']."', '".$row_rsProgramacion['CodSeccion']."', '".$row_rsProgramacion['NroPension']."', ";
$Sql.="'".$_POST['txtMonto']."', '".$_POST['txtMora']."', '".$_POST['txtPagado']."', ";
$Sql.="'".$FechaInicio."', '".$FechaTermino."', ";
$Sql.="'".$_SESSION['MM_Username']."', now(), '".$_POST['txtCodigo']."') ";
mysql_select_db($database_cn, $cn);
$query_rsGrabar = $Sql;
$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());

$Qry ="update programacionalumno set ";
$Qry.="Estado=0, ";
$Qry.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
$Qry.="FechaModificacion=now() ";
$Qry.="where CodProgramacionAlumno='".$_POST['txtCodigo']."' ";
mysql_select_db($database_cn, $cn);
$query_rsUpdate = $Qry;
$rsUpdate = mysql_query($query_rsUpdate, $cn) or die(mysql_error());

mysql_free_result($rsProgramacion);

header("Location: tescompromiso.php?Codigo=".$row_rsProgramacion['CodAlumno']." ");
?>