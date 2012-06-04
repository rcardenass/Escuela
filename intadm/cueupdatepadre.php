<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php

if($_POST['txtPassword']==$_POST['txtRePassword']){
	$Sql ="update usuario set ";
	$Sql.="Password='".md5($_POST['txtPassword'])."', ";
	$Sql.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
	$Sql.="FechaModificacion=now() ";
	$Sql.="where Codigo='".$_POST['txtCodPadre']."' and CodPerfil in (3) ";
	mysql_select_db($database_cn, $cn);
	$query_rsUpdate = $Sql;
	$rsUpdate = mysql_query($query_rsUpdate, $cn) or die(mysql_error());
	header("Location: cuepadre.php");
}else{
	header("Location: cueeditpadre.php?Codigo=".$_POST['txtCodUsuario']." ");
}


?>