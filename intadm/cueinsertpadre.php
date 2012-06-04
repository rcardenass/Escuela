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
	$query_rsPadre = "SELECT CodPadreFamilia, concat(TRIM(ApellidoPaterno),' ',TRIM(ApellidoMaterno)) AS Apellidos, ";
	$query_rsPadre.= "Nombres, Email, concat(left(TRIM(Nombres),1),TRIM(ApellidoPaterno),CodPadreFamilia) AS Login ";
	$query_rsPadre.= "FROM padrefamilia WHERE CodPadreFamilia='".$_POST['cboUsuario']."' ";
	$rsPadre = mysql_query($query_rsPadre, $cn) or die(mysql_error());
	$row_rsPadre = mysql_fetch_assoc($rsPadre);
	$totalRows_rsPadre = mysql_num_rows($rsPadre);
	
	$Sql ="insert into usuario (CodUsuario, Apellidos, Nombres, CodPerfil, Email, Login, Password, Codigo, UsuarioCreacion, FechaCreacion) ";
	$Sql.="values ('null', '".$row_rsPadre['Apellidos']."', '".$row_rsPadre['Nombres']."', '".$_POST['cboPerfil']."', ";
	$Sql.="'".$row_rsPadre['Email']."', '".$row_rsPadre['Login']."', ";
	$Sql.="'".md5(trim($_POST['txtPassword']))."', '".$_POST['cboUsuario']."', '".$_SESSION['MM_Username']."', now()) ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
		
	mysql_free_result($rsPadre);
	
	$objDatos->UpdateUsuarioPadre($_POST['cboUsuario'],$row_rsPadre['Login'],$_SESSION['MM_Username']);
	
	header("Location: cuepadre.php");
}else{
	$_SESSION['TablaUsuario']="No es posible grabar. Este registro ya existe.";
	header("Location: cuenewpadre.php");
}
?>
<?php
mysql_free_result($rsValida);
?>