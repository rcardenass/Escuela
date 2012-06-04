<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
include("../clases/datos.php");
$objDatos=new datos();

//CREO EL REGISTRO DE OPERACION Y OBTENGO EL CODIGO
if($objDatos->InsertOperacion($_SESSION['MM_Username'])==1){
	$rsCodigoOperacion=$objDatos->ObtenerCodigoOperacionSelId();
	$row_CodigoOperacion=$objDatos->PoblarCodigoOperacionSelId($rsCodigoOperacion);
	$OperacionId=$row_CodigoOperacion['CodOperacion'];
}


//OBTENGO EL CODIGO DE CAJA QUE HACE EL COBRO
$rsCaja=$objDatos->ObtenerCodigoCajaSelId($_SESSION['MM_Username']);
$row_Caja=$objDatos->PoblarCodigoCajaSelId($rsCaja);

//OBTENGO LOS TIPOS DE RECIBOS QUE GENERARA EL SISTEMA
$rsRecibos=$objDatos->ObtenerTipoReciboSelAll($_SESSION['MM_Username']);
$row_Recibos=$objDatos->PoblarTipoReciboSelAll($rsRecibos);
$totalRows_rsRecibos = mysql_num_rows($rsRecibos);

if($totalRows_rsRecibos>0){	//PREGUNTA SI EXISTE RECIBOS PARA GENERAR
	do{
		
		//REGISTRA LA CABECERA DE COMPROBANTE
		if($objDatos->InsertComprobante($_SESSION['CajaCodAlumno'],$row_Recibos['CodTipoComprobante'],$_SESSION['MM_Username'],$row_Caja['CodCaja'],$OperacionId,0)==1){
			
			//OBTIENE EL CODIGO DE LA CABECERA DEL COMPROBANTE
			$rsCodigo=$objDatos->ObtenerCodigoComprobanteSelId($_SESSION['CajaCodAlumno'],$_SESSION['MM_Username']);
			$row_Codigo=$objDatos->PoblarCodigoComprobanteSelId($rsCodigo);
			
			//REGISTRA EL DETALLE DEL COMPROBANTE
			if($objDatos->InsertDetalleComprobante($row_Codigo['CodComprobante'],$_SESSION['MM_Username'],$_SESSION['CajaCodAlumno'],
			$row_Recibos['CodTipoComprobante'])==1){
				
				//LIMPIAR EL TEMPORAL DEL ALUMNO CON ESTE TIPO DE COMPROBANTE
				$objDatos->EliminarTemporal($_SESSION['MM_Username'],$_SESSION['CajaCodAlumno'],$row_Recibos['CodTipoComprobante']);
			}
		}else{
			echo "No entra a grabar comprobante<br>"; //MEJORAR ESTO......
		}
		
		//OBTENER EL DETALLE DE LA VENTA SEGUN EL TIPO DE COMPROBANTE (para ver si hay saldos)
		$rsDetalleFac=$objDatos->ObtenerDetalleComprobantePorTipoComprobanteSelAll($row_Recibos['CodTipoComprobante'],
		$_SESSION['CajaCodAlumno'],$row_Codigo['CodComprobante']);
		$row_DetalleFac=$objDatos->PoblarDetalleComprobantePorTipoComprobanteSelAll($rsDetalleFac);
		
		do{
			
			switch ($row_DetalleFac['Tipo']) {
				case "Concepto":
					if($row_DetalleFac['Suma']>$row_DetalleFac['SubTotal']){
					
						$rsCuentaCorriente=$objDatos->ObtenerCuentaCorrienteSelId($_SESSION['CajaCodAlumno']);
						$row_CuentaCorriente=$objDatos->PoblarCuentaCorrienteSelId($rsCuentaCorriente);
						
						$MontoPagar=$row_DetalleFac['Suma']-$row_DetalleFac['SubTotal'];
						
						$objDatos->InsertDetalleCuentaCorriente($row_CuentaCorriente['CodCuentaCorriente'],$row_DetalleFac['Codigo'],
						$MontoPagar,0,0,1,$_SESSION['MM_Username']);
						
						mysql_free_result($rsCuentaCorriente);
					}
				break;
				case "Credito":				
					$rsCuentaCorriente=$objDatos->ObtenerCuentaCorrienteSelId($_SESSION['CajaCodAlumno']);
					$row_CuentaCorriente=$objDatos->PoblarCuentaCorrienteSelId($rsCuentaCorriente);
					
					$objDatos->UpdateMontoPagadoDetalleCuentaCorriente($row_DetalleFac['Codigo'],$row_DetalleFac['SubTotal'],$_SESSION['MM_Username']);
				
					mysql_free_result($rsCuentaCorriente);
				break;
				case "Pension":
					$objDatos->UpdateMontoPagadoProgramacionAlumno($row_DetalleFac['Codigo'],$row_DetalleFac['SubTotal'],$_SESSION['MM_Username']);
				break;
			}
			
		}while($row_DetalleFac=$objDatos->PoblarDetalleComprobantePorTipoComprobanteSelAll($rsDetalleFac));
		
		
	}while($row_Recibos=$objDatos->PoblarTipoReciboSelAll($rsRecibos));
}
?>

<a href="faccomprobante2.php?xyz=<? echo $OperacionId; ?>" target="_parent">Comprobante Nuevo</a>