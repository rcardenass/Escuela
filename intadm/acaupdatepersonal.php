<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$Sql ="update personal set ";
$Sql.="ApellidoPaterno='".$_POST['txtApellidoPaterno']."', ";
$Sql.="ApellidoMaterno='".$_POST['txtApellidoMaterno']."', ";
$Sql.="Nombres='".$_POST['txtNombres']."', ";
$Sql.="Sexo='".$_POST['cboSexo']."', ";
$Sql.="CodTipoDocumento='".$_POST['cboTipoDocumento']."', ";
$Sql.="NumeroDocumento='".$_POST['txtNumeroDocumento']."', ";
$Sql.="CodDepartamento='".$_POST['cboDepartamento']."', ";
$Sql.="CodProvincia='".$_POST['cboProvincia']."', ";
$Sql.="CodDistrito='".$_POST['cboDistrito']."', ";
$Sql.="Direccion='".$_POST['txtDireccion']."', ";
$Sql.="Referencia='".$_POST['txtReferencia']."', ";
$Sql.="Telefono='".$_POST['txtTelefono']."', ";
$Sql.="Celular='".$_POST['txtCelular']."', ";
$Sql.="Rpc='".$_POST['txtRpc']."', ";
$Sql.="Rpm='".$_POST['txtRpm']."', ";
$Sql.="Nextel='".$_POST['txtNextel']."', ";
$Sql.="EmailPersonal='".$_POST['txtEmailPersonal']."', ";
$Sql.="EmailInstitucional='".$_POST['txtEmailInstitucional']."', ";
$Sql.="UsuarioModificacion='".$_POST['txtUsuarioCreacion']."', ";
$Sql.="FechaModificacion=now() ";
$Sql.="where CodPersonal=".$_POST['txtCodigo'];

mysql_select_db($database_cn, $cn);
$query_rsGrabar = $Sql;
$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
header("Location: acapersonal.php");
?>
