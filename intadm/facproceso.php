<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
switch ($_GET['Tipo']) {
    case 'Concepto':
        $Tipo="Concepto";
		
		mysql_select_db($database_cn, $cn);
		$query_rsConcepto = "SELECT CodProducto, CodTipoProducto, NombreProducto, Precio, Descuento as Dscto, Precio-Descuento as Total ";
		$query_rsConcepto.= "FROM productos WHERE Estado = 1 and CodProducto='".$_GET['Id']."' ";
		$rsConcepto = mysql_query($query_rsConcepto, $cn) or die(mysql_error());
		$row_rsConcepto = mysql_fetch_assoc($rsConcepto);
		$totalRows_rsConcepto = mysql_num_rows($rsConcepto);
		
		$Sql ="insert into temporal (CodTemporal, CodAlumno, Tipo, Codigo, Concepto, Cantidad, PrecioUnit, Monto, ";
		$Sql.="Dscto, Mora, Total, UsuarioCreacion, FechaCreacion) ";
		$Sql.="values ('null', '".$_SESSION['CajaCodAlumno']."', '".$Tipo."', '".$row_rsConcepto['CodProducto']."', ";
		$Sql.="'".$row_rsConcepto['NombreProducto']."', 1, '".$row_rsConcepto['Precio']."', '".$row_rsConcepto['Precio']."', ";
		$Sql.="'".$row_rsConcepto['Dscto']."', 0.00, ".$row_rsConcepto['Total'].", '".$_SESSION['MM_Username']."', now()) ";
		mysql_select_db($database_cn, $cn);
		$query_rsGrabar = $Sql;
		$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
		
		mysql_free_result($rsConcepto);
        break;
    case 'Credito':
        $Tipo="Credito";
		
		mysql_select_db($database_cn, $cn);
		$query_rsValidaC = "SELECT COUNT(*) AS Existe FROM temporal WHERE Tipo='Credito' ";
		$query_rsValidaC.= "AND UsuarioCreacion='".$_SESSION['MM_Username']."' ";
		$query_rsValidaC.= "and CodAlumno='".$_SESSION['CajaCodAlumno']."' and Codigo='".$_GET['Id']."' ";
		$rsValidaC = mysql_query($query_rsValidaC, $cn) or die(mysql_error());
		$row_rsValidaC = mysql_fetch_assoc($rsValidaC);
		$totalRows_rsValidaC = mysql_num_rows($rsValidaC);
		
		if($row_rsValidaC['Existe']==0){
			mysql_select_db($database_cn, $cn);
			$query_rsCredito = "SELECT b.CodDetalleCuentaCorriente, c.CodProducto, c.CodTipoProducto,  ";
			$query_rsCredito.= "c.NombreProducto, b.MontoPagar-b.MontoPagado as Precio, b.Descuento AS Dscto ";
			$query_rsCredito.= "FROM cuentacorriente a ";
			$query_rsCredito.= "INNER JOIN detallecuentacorriente b ON b.CodCuentaCorriente=a.CodCuentaCorriente ";
			$query_rsCredito.= "INNER JOIN productos c ON c.CodProducto=b.CodProducto ";
			$query_rsCredito.= "WHERE CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
			$query_rsCredito.= "AND b.CodDetalleCuentaCorriente='".$_GET['Id']."' ";
			$rsCredito = mysql_query($query_rsCredito, $cn) or die(mysql_error());
			$row_rsCredito = mysql_fetch_assoc($rsCredito);
			$totalRows_rsCredito = mysql_num_rows($rsCredito);
			
			$Sql ="insert into temporal (CodTemporal, CodAlumno, Tipo, Codigo, Concepto, Cantidad, PrecioUnit, Monto, ";
			$Sql.="Dscto, Mora, Total, UsuarioCreacion, FechaCreacion) ";
			$Sql.="values ('null', '".$_SESSION['CajaCodAlumno']."', '".$Tipo."', '".$row_rsCredito['CodDetalleCuentaCorriente']."', ";
			$Sql.="'".$row_rsCredito['NombreProducto']."', 1, '".$row_rsCredito['Precio']."', '".$row_rsCredito['Precio']."', ";
			$Sql.="'".$row_rsCredito['Dscto']."', 0.00, '".$row_rsCredito['Precio']."', '".$_SESSION['MM_Username']."', now()) ";
			mysql_select_db($database_cn, $cn);
			$query_rsGrabar = $Sql;
			$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
		
			mysql_free_result($rsCredito);	
		}
		
		mysql_free_result($rsValidaC);
        break;
    case 'Pension':
        $Tipo="Pension";
		
		mysql_select_db($database_cn, $cn);
		$query_rsValida = "SELECT COUNT(*) AS Existe FROM temporal WHERE Tipo='Pension' ";
		$query_rsValida.= "AND UsuarioCreacion='".$_SESSION['MM_Username']."' ";
		$query_rsValida.= "and CodAlumno='".$_SESSION['CajaCodAlumno']."' and Codigo='".$_GET['Id']."' ";
		$rsValida = mysql_query($query_rsValida, $cn) or die(mysql_error());
		$row_rsValida = mysql_fetch_assoc($rsValida);
		$totalRows_rsValida = mysql_num_rows($rsValida);
		
		if($row_rsValida['Existe']==0){
			mysql_select_db($database_cn, $cn);
			$query_rsPension = "SELECT a.CodProgramacionAlumno AS Id, b.NombreAnio, c.NombreGrado,  ";
			$query_rsPension.= "concat('Pensión',' - ',a.NroPension) AS Item, ";
			$query_rsPension.= "a.Monto, a.Mora, a.Pagado, a.Monto+a.Mora-a.Pagado AS Total ";
			$query_rsPension.= "FROM programacionalumno a ";
			$query_rsPension.= "INNER JOIN anio b ON b.CodAnio=a.CodAnio ";
			$query_rsPension.= "INNER JOIN grado c ON c.CodGrado=a.CodGrado ";
			$query_rsPension.= "WHERE a.CodAlumno='".$_SESSION['CajaCodAlumno']."' ";
			$query_rsPension.= "AND a.Estado=1 AND a.Monto+a.Mora>a.Pagado ";
			$query_rsPension.= "AND a.CodProgramacionAlumno='".$_GET['Id']."' ";
			$rsPension = mysql_query($query_rsPension, $cn) or die(mysql_error());
			$row_rsPension = mysql_fetch_assoc($rsPension);
			$totalRows_rsPension = mysql_num_rows($rsPension);
			
			$Sql ="insert into temporal (CodTemporal, CodAlumno, Tipo, Codigo, Concepto, Cantidad, ";
			$Sql.="PrecioUnit, Monto, Dscto, Mora, Total, UsuarioCreacion, FechaCreacion) ";
			$Sql.="values ('null', '".$_SESSION['CajaCodAlumno']."', '".$Tipo."', '".$row_rsPension['Id']."', '".$row_rsPension['Item']."', 1, ";
			$Sql.="'".$row_rsPension['Total']."', '".$row_rsPension['Total']."', 0.00, '".$row_rsPension['Mora']."', ";
			$Sql.="'".$row_rsPension['Total']."', '".$_SESSION['MM_Username']."', now())";
			mysql_select_db($database_cn, $cn);
			$query_rsGrabar = $Sql;
			$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
			
			mysql_free_result($rsPension);
		}
		mysql_free_result($rsValida);
        break;
}
?>
<script>
/*function refresh(){*/
	window.parent.Item.location.reload();
/*	}
	setInterval("refresh()",20000)*/
</script>
<?
//header("location: concepto.php");
?>
<script>
	location.href="facconcepto.php";
</script>