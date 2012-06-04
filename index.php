<?php require_once('Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsPerfil = "SELECT CodPerfil, NombrePerfil FROM perfil where Estado=1";
$rsPerfil = mysql_query($query_rsPerfil, $cn) or die(mysql_error());
$row_rsPerfil = mysql_fetch_assoc($rsPerfil);
$totalRows_rsPerfil = mysql_num_rows($rsPerfil);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['txtUsuario'])) {
  $loginUsername=$_POST['txtUsuario'];
  $password=md5($_POST['txtClave']);
  $perfil=$_POST['cboPerfil'];
  $MM_fldUserAuthorization = "CodPerfil";
  
  switch ($_POST['cboPerfil']){
    case 1:
        $intranet="intalu/default.php";
        break;
    case 2:
        $intranet="intdoc/default.php";
        break;
    case 3:
        $intranet="intpad/default.php";
        break;
	case 4:
       	$intranet="intadm/default.php";
        break;
	case 5:
       	$intranet="intaux/default.php";
        break;
	}
  $MM_redirectLoginSuccess = $intranet;
  
  $MM_redirectLoginFailed = "error.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_cn, $cn);
  	
  $LoginRS__query=sprintf("SELECT Login, Password, CodPerfil FROM usuario where Estado=1 AND Login='%s' AND Password='%s' AND CodPerfil='%s' ",
  get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password), get_magic_quotes_gpc() ? $perfil : addslashes($perfil)); 
   
  $LoginRS = mysql_query($LoginRS__query, $cn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'CodPerfil');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script type="text/JavaScript" src="validar.js"></script>
<SCRIPT LANGUAGE="JavaScript"> 
<!-- begin script
function Validar(Netscape, Explorer) {
	if ((navigator.appVersion.substring(0,3) >= Netscape && navigator.appName == 'Netscape') ||      
      (navigator.appVersion.substring(0,3) >= Explorer && navigator.appName.substring(0,9) == 'Microsoft'))
    return true;
	else return false;
}
//  end script -->
</SCRIPT>
<link href="stylelogin.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div style="height:120px"></div>
<div style = "display: table; margin-left: auto; margin-right: auto; width: 600px">
	<div style = "clear: both; height: 30px; width: 100%">
		<div style = "float: left; height: 30px; width: 23px" class="EsquinaSupIzq"></div>
		<div style = "float: left; height: 30px; width: 554px" class="SuperiorCentro">
		<div style="height:4px"></div>
			<strong>Sistema de Gestión Escolar</strong>
		</div>
		<div style = "float: right; height: 30px; width: 23px" class="EsquinaSupDer"></div>
	</div>
    <div style = "float: left; height: 140px; width: 175px; background-color:#006666">
		<img name="Perfil" src="0.jpg" width="175" height="140" />
	</div>
    <div style = "float: left; height: 140px; width: 175px; background:url(imagenes/sistema/fondologin.jpg)"></div>
	<div style = "float: right; height: 140px; width: 250px; background-color:#CCCCCC">
	<div style="padding-left:5px">
	 <form action="<?php echo $loginFormAction; ?>" method="POST" name="form1" id="form1" onsubmit="MM_validateForm('cboPerfil','','R','txtUsuario','','R','txtClave','','R');return document.MM_returnValue" autocomplete="Off">
	 <!--<IMG NAME="imagen" SRC="0.jpg" BORDER=0 WIDTH=50 HEIGHT=50>-->
        <table width="240" border="0" cellspacing="3" cellpadding="0">
          <tr>
            <td>Perfil</td>
            <td><label>
              <select name="cboPerfil" id="cboPerfil" style="width:148px; height:22px" 
			  onChange ="if (Validar(3.0,4.0)) 	Perfil.src=form1.cboPerfil.options[form1.cboPerfil.selectedIndex].value;">
                <option value="0.jpg">Seleccione</option>
                <?php
do {  
?>
                <option value="<?php echo $row_rsPerfil['CodPerfil']?>.jpg"><?php echo $row_rsPerfil['NombrePerfil']?></option>
                <?php
} while ($row_rsPerfil = mysql_fetch_assoc($rsPerfil));
  $rows = mysql_num_rows($rsPerfil);
  if($rows > 0) {
      mysql_data_seek($rsPerfil, 0);
	  $row_rsPerfil = mysql_fetch_assoc($rsPerfil);
  }
?>
              </select>
            </label></td>
          </tr>
          <tr>
            <td>Usuario</td>
            <td><label>
              <input name="txtUsuario" type="text" id="txtUsuario" />
            </label></td>
          </tr>
          <tr>
            <td>Contrase&ntilde;a</td>
            <td><label>
              <input name="txtClave" type="password" id="txtClave" />
            </label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>
				<div style="padding-left:77px">
				<input type="submit" name="Submit" value="Ingresar" />
				</div>
            </td>
          </tr>
        </table>
	  </form>
	</div>
    </div>
    <div style = "clear: both; height: 30px; width: 100%; background-color:#ffffff">
		<div style = "clear: both; float: right; height: 30px; width: 350px; background-color:#FF6633">
			<div style = "float: left; height: 30px; width: 23px" class="EsquinaInfIzq"></div>
			<div style = "float: left; height: 30px; width: 304px" class="InferiorCentro"></div>
			<div style = "float: right; height: 30px; width: 23px" class="EsquinaInfDer"></div>	
		</div>
	</div>
</div> 
</body>
</html>
<?php
mysql_free_result($rsPerfil);
?>