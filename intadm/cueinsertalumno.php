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
	$query_rsAlumno = "SELECT CodAlumno, concat(TRIM(ApellidoPaterno),' ',TRIM(ApellidoMaterno)) AS Apellidos, ";
	$query_rsAlumno.= "Nombres, EmailPersonal, concat(left(TRIM(Nombres),1),'.',TRIM(ApellidoPaterno),CodAlumno) AS Login ";
	$query_rsAlumno.= "FROM alumno WHERE CodAlumno='".$_POST['cboUsuario']."' ";
	$rsAlumno = mysql_query($query_rsAlumno, $cn) or die(mysql_error());
	$row_rsAlumno = mysql_fetch_assoc($rsAlumno);
	$totalRows_rsAlumno = mysql_num_rows($rsAlumno);
	
	$Sql ="insert into usuario (CodUsuario, Apellidos, Nombres, CodPerfil, Email, Login, Password, Codigo, UsuarioCreacion, FechaCreacion) ";
	$Sql.="values ('null', '".$row_rsAlumno['Apellidos']."', '".$row_rsAlumno['Nombres']."', '".$_POST['cboPerfil']."', ";
	$Sql.="'".$row_rsAlumno['EmailPersonal']."', '".$row_rsAlumno['Login']."', ";
	$Sql.="'".md5(trim($_POST['txtPassword']))."', '".$_POST['cboUsuario']."', '".$_SESSION['MM_Username']."', now()) ";
	mysql_select_db($database_cn, $cn);
	$query_rsGrabar = $Sql;
	$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
		
	mysql_free_result($rsAlumno);
	
	$objDatos->UpdateUsuarioAlumno($_POST['cboUsuario'],$row_rsAlumno['Login'],$_SESSION['MM_Username']);
	
	header("Location: cuealumno.php");
}else{
	$_SESSION['TablaUsuario']="No es posible grabar. Este registro ya existe.";
	header("Location: cuenewalumno.php");
}
?>
<?php
mysql_free_result($rsValida);
?>