<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php
$Sql="DELETE FROM permiso WHERE Usuario='".$_POST['txtUsuario']."' ";
$rsDel = mysql_query($Sql, $cn) or die(mysql_error());

$a=$_POST['chkopcion'];
$x=1;
foreach($a as $Programa){
	$A[$x]=$Programa;
	$x++;
}

for($z=1;$z<=$x-1;$z++){
	mysql_select_db($database_cn, $cn);
	$query_rsPadre = "SELECT IdPadre FROM programa WHERE Id = '".$A[$z]."' ";
	$rsPadre = mysql_query($query_rsPadre, $cn) or die(mysql_error());
	$row_rsPadre = mysql_fetch_assoc($rsPadre);
	$totalRows_rsPadre = mysql_num_rows($rsPadre);
	
	mysql_select_db($database_cn, $cn);
	$query_rsCantidad = "SELECT COUNT(*) AS Cantidad FROM programa a  ";
	$query_rsCantidad.= "INNER JOIN permiso b ON b.CodPrograma=a.Id WHERE b.Usuario='".$_POST['txtUsuario']."' ";
	$query_rsCantidad.= "and a.IdPadre='".$row_rsPadre['IdPadre']."' ";
	$rsCantidad = mysql_query($query_rsCantidad, $cn) or die(mysql_error());
	$row_rsCantidad = mysql_fetch_assoc($rsCantidad);
	$totalRows_rsCantidad = mysql_num_rows($rsCantidad);
	
	if($row_rsCantidad['Cantidad']==0){
		$Centinela=$A[$z];
		while($Centinela>0){
			mysql_select_db($database_cn, $cn);
			$query_rsPapa = "SELECT Id, NombrePrograma, IdPadre FROM programa WHERE Id = ".$Centinela." ";
			$rsPapa = mysql_query($query_rsPapa, $cn) or die(mysql_error());
			$row_rsPapa = mysql_fetch_assoc($rsPapa);
			$totalRows_rsPapa = mysql_num_rows($rsPapa);
			
			mysql_select_db($database_cn, $cn);
			$query_rsInsert = "insert permiso (CodPermiso, CodPrograma, Usuario, FechaCreacion) ";
			$query_rsInsert.= "values ('null', '".$row_rsPapa['Id']."', '".$_POST['txtUsuario']."', now()) ";
			$rsInsert = mysql_query($query_rsInsert, $cn) or die(mysql_error());
			
			$Centinela=$row_rsPapa['IdPadre'];
		}
	}else{
		mysql_select_db($database_cn, $cn);
		$query_rsInsert = "insert permiso (CodPermiso, CodPrograma, Usuario, FechaCreacion) ";
		$query_rsInsert.= "values ('null', '".$A[$z]."', '".$_POST['txtUsuario']."', now()) ";
		$rsInsert = mysql_query($query_rsInsert, $cn) or die(mysql_error());
	}
}
header("Location: cuepersonal.php");
?>
<?php
mysql_free_result($rsPadre);
?>