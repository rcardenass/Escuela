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
<?php include('../../funciones.php'); ?>
<?php
include("../../clases/datos.php");
$objDatos=new datos();

$rsMovimiento=$objDatos->ObtenerMovimientoSelAll(1, 1, 1, $_POST['cboUsuario'], $_POST['txtFecha']);
$rowMovimiento=$objDatos->PoblarMovimientoSelAll($rsMovimiento);
$totalRows_rsMovimiento = mysql_num_rows($rsMovimiento);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../styleadm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table class="table" width="100%" border="0" cellspacing="2" cellpadding="0">
	<tr class="tr">
		<td width="30"><div style="text-align:right; padding-right:5px">Nro</div></td>
		<td width="120">Grado</td>
		<td>Alumno</td>
		<td width="80"><div style="text-align:right; padding-right:5px">Monto</div></td>
		<td width="70">Usuario</td>
		<td width="70">Fecha</td>
		<td width="80">Hora</td>
	</tr>
	<? if($totalRows_rsMovimiento==0){ ?>
	<tr>
    	<td colspan="7"><div style="text-align:left; padding-left:5px">No existen registros</div></td>
	</tr>
	<? } ?>
    <?
    if($totalRows_rsMovimiento>0){
    	$i=1;
        $Sum=0;
        do{
        ?>
			<? Filas();?>
            	<td width="30"><div style="text-align:right; padding-right:5px"><strong><? echo $i;?></strong></div></td>
				<td width="120"><? echo utf8_encode($rowMovimiento['Grado']);?></td>
				<td><? echo utf8_encode($rowMovimiento['Alumno']);?></td>
				<td width="80"><div style="text-align:right; padding-right:5px"><? echo $rowMovimiento['Monto'];?></div></td>
				<td width="70"><? echo $rowMovimiento['UsuarioCreacion'];?></td>
				<td width="70"><? echo $rowMovimiento['FechaCreacion'];?></td>
				<td width="80"><? echo $rowMovimiento['Hora'];?></td>
		  	</tr>
			<tr>
				<td width="30"></td>
				<td width="120"></td>
				<td colspan="5">
                                <?
                                $rsDetalle=$objDatos->ObtenerDetalleBoletaSelAll($rowMovimiento['CodComprobante']);
                                $rowDetalle=$objDatos->PoblarDetalleBoletaSelAll($rsDetalle);
                                $totalRows_rsDetalle = mysql_num_rows($rsDetalle);
                                ?>
				<div style="height:3px"></div>
					<div style="padding-left:150px">
					<table class="table" width="98%" border="0" cellspacing="2" cellpadding="0">
						<tr class="tr">
                                                    <td width="35"><div style="text-align: right; padding-right: 3px">Item</div></td>
							<td>Concepto</td>
                                                        <td width="60"><div style="text-align: right; padding-right: 5px">Total</div></td>
                                                        <td width="60"><div style="text-align: right; padding-right: 5px">Saldo</div></td>
						</tr>
                                                <?
                                                $k=1;
                                                if($totalRows_rsDetalle==0){
                                                ?>
                                                <tr>
                                                    <td colspan="4"><div style="text-align:left; padding-left:5px">No existen registros</div></td>
						</tr>
                                                <?
                                                }
                                                ?>
                                                <?
                                                if($totalRows_rsDetalle>0){
                                                do{

                                                ?>
						<tr onClick='this.style.background="#F5BB52"' onmouseover='this.style.background="#AED74E"' onmouseout='this.style.background="#ffffff"'>
							<td width="35"><div style="text-align: right; padding-right: 3px"><strong><? echo $k;?></strong></div></td>
							<td><? echo utf8_encode($rowDetalle['Concepto']);?></td>
							<td width="60"><div style="text-align: right; padding-right: 5px"><? echo $rowDetalle['SubTotal'];?></div></td>
							<td width="60"><div style="text-align: right; padding-right: 5px"><? echo $rowDetalle['Saldo'];?></div></td>
						</tr>
                                                <?
                                                $k++;
                                                }while($rowDetalle=$objDatos->PoblarDetalleBoletaSelAll($rsDetalle));
                                                }
                                                ?>
					</table>
					</div>
				<div style="height:15px"></div>
				</td>
			</tr>
            <?
            $k=0;
            $i++;
            $Sum=$Sum+$rowMovimiento['Monto'];
            } while($rowMovimiento=$objDatos->PoblarMovimientoSelAll($rsMovimiento));
            ?>
            <tr class="tr">
				<td width="30">&nbsp;</td>
				<td width="120">&nbsp;</td>
				<td>&nbsp;</td>
				<td width="70"><div style="text-align:right; padding-right:3px"><? echo number_format($Sum,2); ?></div></td>
				<td width="70">&nbsp;</td>
				<td width="70">&nbsp;</td>
				<td width="80">&nbsp;</td>
		  	</tr>
            <? }?>
</table>
</body>
</html>
<?
mysql_free_result($rsMovimiento);
?>