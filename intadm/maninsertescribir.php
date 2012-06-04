<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsEnviar = "SELECT CodEnvio, CodPerfil, CodigoUsuario FROM envioemail where UsuarioCreacion='". $_SESSION['MM_Username']."' and Estado=1 ";
$rsEnviar = mysql_query($query_rsEnviar, $cn) or die(mysql_error());
$row_rsEnviar = mysql_fetch_assoc($rsEnviar);
$totalRows_rsEnviar = mysql_num_rows($rsEnviar);

//Enviar el mensaje a buzon de los alumnos
do{ //El estado es (Sin leer=0 y Leido=1)
	mysql_select_db($database_cn, $cn);
	$query_rsMensaje = "insert into mensaje (`CodMensaje`, `De`, `Para`, `Asunto`, `CodCurGra`, ";
	$query_rsMensaje.= "`FechaEnvio`, `CodPerfil`, `TipoMensaje`, `UsuarioCreacion`, FechaCreacion) ";
	$query_rsMensaje.= "values ('null', '".$_SESSION['MM_Username']."', ";
	$query_rsMensaje.= "'".$row_rsEnviar['CodigoUsuario']."', '".$_POST['txtDestinatario']."', ";
	$query_rsMensaje.= "'".$_POST['txtCodigoCurso']."' ,now(), 1, 'Interno', '".$_SESSION['MM_Username']."', now() ) ";
	$rsMensaje = mysql_query($query_rsMensaje, $cn) or die(mysql_error());
	
	mysql_select_db($database_cn, $cn);
	$query_rsCodMensaje = "SELECT MAX(CodMensaje) AS CodigoMensaje FROM mensaje WHERE UsuarioCreacion='". $_SESSION['MM_Username']."' ";
	$rsCodMensaje = mysql_query($query_rsCodMensaje, $cn) or die(mysql_error());
	$row_rsCodMensaje = mysql_fetch_assoc($rsCodMensaje);
	$totalRows_rsCodMensaje = mysql_num_rows($rsCodMensaje);
	
	mysql_select_db($database_cn, $cn);
	$query_rsDmensaje = "insert into detallemensaje (`CodDetalleMensaje`, `CodMensaje`, `Mensaje`) ";
	$query_rsDmensaje.= "values ('null', ".$row_rsCodMensaje['CodigoMensaje'].", '".$_POST['txtMensaje']."') ";
	$rsDmensaje = mysql_query($query_rsDmensaje, $cn) or die(mysql_error());
	
} while ($row_rsEnviar = mysql_fetch_assoc($rsEnviar));
//Enviar el mensaje a buzon de los alumnos



////Enviar el mensaje a buzon correo de los alumnos
//do{
//	Envio($row_rsEnviar['CodigoUsuario'], $_POST['txtDestinatario'], $_POST['txtMensaje']);
//} while ($row_rsEnviar = mysql_fetch_assoc($rsEnviar));
////Enviar el mensaje a buzon correo de los alumnos


mysql_select_db($database_cn, $cn);
$query_rsUpdate = "update envioemail set Estado=0 where UsuarioCreacion='". $_SESSION['MM_Username']."' and Estado=1 ";
$rsUpdate = mysql_query($query_rsUpdate, $cn) or die(mysql_error());


header("location: default.php");

/*function Envio($Correo, $Asunto, $Mensaje){
	//define the receiver of the email
	$to = $Correo;
	//define the subject of the email
	$subject = $Asunto; 
	//define the message to be sent. Each line should be separated with \n
	$message = $Mensaje; 
	//define the headers we want passed. Note that they are separated with \r\n
	$headers = "From: ruben@example.com\r\nReply-To: cardenas@example.com";
	//send the email
	$mail_sent = @mail( $to, $subject, $message, $headers );
	//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed" 
	echo $mail_sent ? "Mail enviado" : "Mail fallado";
}*/

mysql_free_result($rsEnviar);
mysql_free_result($rsCodMensaje);
?>