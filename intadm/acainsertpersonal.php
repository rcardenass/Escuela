<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$UsuarioId=trim($_POST['txtNombres']).".".trim($_POST['txtApellidoPaterno']);
$Sql ="insert into `personal` ( ";
$Sql.="`CodPersonal`,`CodTipoPersonal`,`ApellidoPaterno`,`ApellidoMaterno`,`Nombres`, ";
$Sql.="`Sexo`,`CodTipoDocumento`,`NumeroDocumento`,`CodDepartamento`,`CodProvincia`, ";
$Sql.="`CodDistrito`,`Direccion`,`Referencia`,`Telefono`,`Celular`, ";
$Sql.="`Rpc`,`Rpm`,`Nextel`,`EmailPersonal`,`EmailInstitucional`, ";
$Sql.="`UsuarioId`,`UsuarioCreacion`,`FechaCreacion`) ";
$Sql.="values ( ";
$Sql.="'null','".$_POST['cboTipoPersonal']."','".$_POST['txtApellidoPaterno']."','".$_POST['txtApellidoMaterno']."','".$_POST['txtNombres']."', ";
$Sql.="'".$_POST['txtSexo']."','".$_POST['cboTipoDocumento']."','".$_POST['txtNumeroDocumento']."','".$_POST['cboDepartamento']."','".$_POST['cboProvincia']."', ";
$Sql.="'".$_POST['cboDistrito']."','".$_POST['txtDireccion']."','".$_POST['txtReferencia']."','".$_POST['txtTelefono']."','".$_POST['txtCelular']."', ";
$Sql.="'".$_POST['txtRpc']."','".$_POST['txtRpm']."','".$_POST['txtNextel']."','".$_POST['txtEmailPersonal']."','".$_POST['txtEmailInstitucional']."', ";
$Sql.="'".$UsuarioId."','".$_SESSION['MM_Username']."',now()) ";
mysql_select_db($database_cn, $cn);
$query_rsGrabar = $Sql;
$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
header("Location: acapersonal.php");
?>
