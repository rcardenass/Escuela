<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsValida = "SELECT count(*) as Cantidad FROM usuario where Codigo='".$_POST['cboUsuario']."' and CodPerfil='".$_POST['cboPerfil']."' ";
$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
$row_rsValida = mysql_fetch_assoc($rsValida);
$totalRows_rsValida = mysql_num_rows($rsValida);

if($row_rsValida['Cantidad']==0){
	mysql_select_db($database_cn, $cn);
	$query_rsPersonal = "SELECT CodPersonal, concat(TRIM(ApellidoPaterno),' ',TRIM(ApellidoMaterno)) AS Apellidos, ";
	$query_rsPersonal.= "Nombres, EmailPersonal, ";
	$query_rsPersonal.= "concat(left(Nombres,1),TRIM(ApellidoPaterno),CodPersonal) AS Login ";
	$query_rsPersonal.= "FROM personal WHERE CodPersonal='".$_POST['cboUsuario']."' ";
	$rsPersonal = mysql_query($query_rsPersonal, $cn) or die(mysql_error());
	$row_rsPersonal = mysql_fetch_assoc($rsPersonal);
	$totalRows_rsPersonal = mysql_num_rows($rsPersonal);
	
	$Sql ="insert into usuario (CodUsuario, Apellidos, Nombres, CodPerfil, Email, Login, Password, Codigo, UsuarioCreacion, FechaCreacion) ";
	$Sql.="values ('null', '".$row_rsPersonal['Apellidos']."', '".$row_rsPersonal['Nombres']."', '".$_POST['cboPerfil']."', ";
	$Sql.="'".$row_rsPersonal['EmailPersonal']."', '".$row_rsPersonal['Login']."', ";
	$Sql.="'".md5(trim($_POST['txtPassword']))."', '".$_POST['cboUsuario']."', '".$_SESSION['MM_Username']."', now()) ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
		
	mysql_free_result($rsPersonal);
	
	$objDatos->UpdateUsuarioPersonal($_POST['cboUsuario'],$row_rsPersonal['Login'],$_SESSION['MM_Username']);
	
	header("Location: cuepersonal.php");
}else{
	$_SESSION['TablaUsuario']="No es posible grabar. Este registro ya existe.";
	header("Location: cuenewpersonal.php");
}
?>
<?php
mysql_free_result($rsValida);
?>