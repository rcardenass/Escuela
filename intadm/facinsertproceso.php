<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

$rsCaja=$objDatos->ObtenerCodigoCajaSelId($_SESSION['MM_Username']);
$row_Caja=$objDatos->PoblarCodigoCajaSelId($rsCaja);

$Sql ="insert into comprobante (CodComprobante, CodAlumno, CodTipoComprobante, UsuarioCreacion, FechaCreacion, CodCaja, TipoModulo) ";
$Sql.="values ('null', '".$_SESSION['CajaCodAlumno']."', 100, '".$_SESSION['MM_Username']."', now(), '".$row_Caja['CodCaja']."',0) ";
mysql_select_db($database_cn, $cn);
$query_Grabar = $Sql;
$Grabar = mysql_query($query_Grabar, $cn) or die(mysql_error());

//****************************** CREA DETALLE DE COMPROBANTE ******************************//
	mysql_select_db($database_cn, $cn);
	$query_rsCodigoComprobante ="SELECT  MAX(CodComprobante) AS CodComprobante ";
	$query_rsCodigoComprobante.="FROM comprobante ";
	$query_rsCodigoComprobante.="where CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
	$query_rsCodigoComprobante.="and UsuarioCreacion='".$_SESSION['MM_Username']."' ";
	$rsCodigoComprobante = mysql_query($query_rsCodigoComprobante, $cn) or die(mysql_error());
	$row_rsCodigoComprobante = mysql_fetch_assoc($rsCodigoComprobante);
	$totalRows_rsCodigoComprobante = mysql_num_rows($rsCodigoComprobante);
	
	$IdComprobante=$row_rsCodigoComprobante['CodComprobante'];
	$_SESSION['CajaCodComprobante']=$row_rsCodigoComprobante['CodComprobante'];
	
	$Sql_Detalle ="INSERT INTO detallecomprobante (CodComprobante, Tipo, Codigo, Cantidad, PrecioUnit, Dscto, Mora, SubTotal, UsuarioCreacion, FechaCreacion) ";
	$Sql_Detalle.="SELECT '".$IdComprobante."', Tipo, Codigo, Cantidad, PrecioUnit, Dscto, Mora, Total, '".$_SESSION['MM_Username']."', now() ";
	$Sql_Detalle.="FROM temporal ";
	$Sql_Detalle.="WHERE UsuarioCreacion='".$_SESSION['MM_Username']."' and CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
	mysql_select_db($database_cn, $cn);
	$rsGrabar_Detalle = $Sql_Detalle;
	$rsGrabar2 = mysql_query($rsGrabar_Detalle, $cn) or die(mysql_error());
	
	mysql_free_result($rsCodigoComprobante);
	
	mysql_select_db($database_cn, $cn);
	$query_rsDelTemporal = "delete from  temporal where UsuarioCreacion='".$_SESSION['MM_Username']."' and CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
	$rsDelTemporal = mysql_query($query_rsDelTemporal, $cn) or die(mysql_error());
	
	mysql_select_db($database_cn, $cn);
	$query_rsDetFac = "SELECT b.CodDetalleComprobante, b.CodComprobante, b.Tipo, b.Codigo, ";
	$query_rsDetFac.= "b.Cantidad, b.PrecioUnit, b.Dscto, b.Mora, (b.Cantidad*b.PrecioUnit)-b.Dscto+b.Mora AS Suma, ";
	$query_rsDetFac.= "b.SubTotal, b.UsuarioCreacion, b.FechaCreacion ";
	$query_rsDetFac.= "FROM comprobante a inner join detallecomprobante b on b.CodComprobante=a.CodComprobante ";
	$query_rsDetFac.= "where a.CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
	$query_rsDetFac.= "and a.CodComprobante='".$IdComprobante."' ";
	$rsDetFac = mysql_query($query_rsDetFac, $cn) or die(mysql_error());
	$row_rsDetFac = mysql_fetch_assoc($rsDetFac);
	$totalRows_rsDetFac = mysql_num_rows($rsDetFac);
	
	do { 
		switch ($row_rsDetFac['Tipo']) {
		case "Concepto":
			if($row_rsDetFac['Suma']>$row_rsDetFac['SubTotal']){
			
				$query_rsCcorriente = "SELECT CodCuentaCorriente FROM cuentacorriente where CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
				$rsCcorriente = mysql_query($query_rsCcorriente, $cn) or die(mysql_error());
				$row_rsCcorriente = mysql_fetch_assoc($rsCcorriente);
				$totalRows_rsCcorriente = mysql_num_rows($rsCcorriente);
				
				$IdCuentaCorriente=$row_rsCcorriente['CodCuentaCorriente'];
				$MontoPagar=$row_rsDetFac['Suma']-$row_rsDetFac['SubTotal'];
				
				$Sql_Dcc ="insert into detallecuentacorriente (CodDetalleCuentaCorriente, CodCuentaCorriente, CodProducto, "; 
				$Sql_Dcc.="MontoPagar, UsuarioCreacion, FechaCreacion) ";
				$Sql_Dcc.="values ('null', '".$IdCuentaCorriente."', '".$row_rsDetFac['Codigo']."', ";
				$Sql_Dcc.="'".$MontoPagar."', '".$_SESSION['MM_Username']."', now()) ";
				mysql_select_db($database_cn, $cn);
				$query_Grabar_Dcc = $Sql_Dcc;
				$Grabar_Dcc = mysql_query($query_Grabar_Dcc, $cn) or die(mysql_error());
				
				mysql_free_result($rsCcorriente);
			}
			break;
		case "Credito":
				$query_rsCcorriente = "SELECT CodCuentaCorriente FROM cuentacorriente where CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
				$rsCcorriente = mysql_query($query_rsCcorriente, $cn) or die(mysql_error());
				$row_rsCcorriente = mysql_fetch_assoc($rsCcorriente);
				$totalRows_rsCcorriente = mysql_num_rows($rsCcorriente);
			
				$Sql_update ="update detallecuentacorriente set ";
				$Sql_update.="MontoPagado=MontoPagado+'".$row_rsDetFac['SubTotal']."', ";
				$Sql_update.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
				$Sql_update.="FechaModificacion=now() ";
				$Sql_update.="where CodDetalleCuentaCorriente='".$row_rsDetFac['Codigo']."' ";
				mysql_select_db($database_cn, $cn);
				$query_rsUpdate = $Sql_update;
				$rsUpdate = mysql_query($query_rsUpdate, $cn) or die(mysql_error());
			
				mysql_free_result($rsCcorriente);
			break;
		case "Pension":
			$Sql_update ="update programacionalumno set ";
			$Sql_update.="Pagado=Pagado+'".$row_rsDetFac['SubTotal']."', ";
			$Sql_update.="UsuarioModificacion='".$_SESSION['MM_Username']."', ";
			$Sql_update.="FechaModificacion=now() ";
			$Sql_update.="where CodProgramacionAlumno='".$row_rsDetFac['Codigo']."' ";
			mysql_select_db($database_cn, $cn);
			$query_rsUpdate = $Sql_update;
			$rsUpdate = mysql_query($query_rsUpdate, $cn) or die(mysql_error());
			break;
		}
	} while ($row_rsDetFac = mysql_fetch_assoc($rsDetFac));
	mysql_free_result($rsDetFac);
	//****************************** termina detalle de comprobante ******************************//

//header("Location: faccomprobante.php");
?>
<a href="faccomprobante.php" target="_parent">Comprobante</a>