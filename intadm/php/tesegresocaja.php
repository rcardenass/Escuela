<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "4";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../../error.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
include("../../clases/datos.php");
$objDatos=new datos();

$rsEgreso = $objDatos->ObtenerEgresoCajaSelAll($_SESSION['MM_Username'],$_POST['txtFecha']);
$row_rsEgreso = $objDatos->PoblarEgresoCajaSelAll($rsEgreso);
$totalRows_rsEgreso = mysql_num_rows($rsEgreso);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
    <table class="table" width="100%" border="0" cellspacing="2" cellpadding="0">
    <tr class="tr">
        <td width="120"><div style="text-align: left; padding-left: 5px">Usuario</div></td>
    <td width="50"><div style="text-align: center;">Caja</div></td>
    <td>Para</td>
    <td width="80"><div style="text-align: right; padding-right: 10px">Entrega</div></td>
    <td width="80">Fecha</td>
    <td width="60">Hora</td>
  </tr>
  <?
  if($totalRows_rsEgreso==0){
  ?>
  <tr>
      <td colspan="6"><div style="padding-left: 15px">No hay registros</div></td>
  </tr>
  <?
  }
  if($totalRows_rsEgreso>0){
      do{
          ?>
          <tr>
            <td width="120"><div style="text-align: left; padding-left: 5px"><? echo $row_rsEgreso['UsuarioCreacion']; ?></div></td>
            <td width="50"><div style="text-align: center;"><? echo $row_rsEgreso['CodCaja']; ?></div></td>
            <td title="<? echo $row_rsEgreso['Descripcion']; ?>"><? echo $row_rsEgreso['Para']; ?></td>
            <td width="80"><div style="text-align: right; padding-right: 10px"><? echo $row_rsEgreso['Entrega']; ?></div></td>
            <td width="80"><? echo $row_rsEgreso['FechaCreacion']; ?></td>
            <td width="60"><? echo $row_rsEgreso['HoraCreacion']; ?></td>
          </tr>
          <?
      }while($row_rsEgreso = $objDatos->PoblarEgresoCajaSelAll($rsEgreso));
  }
  ?>
</table>
</body>

</html>
