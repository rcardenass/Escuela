<?php require_once('Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsCabecera = "SELECT upper(a.Apellidos) as Apellidos, upper(a.Nombres) as Nombres, upper(b.NombrePerfil) as NombrePerfil, upper(a.Codigo) as Codigo, upper(a.Login) as Login FROM usuario a INNER JOIN perfil b ON b.CodPerfil=a.CodPerfil WHERE a.CodPerfil='".$_SESSION['MM_UserGroup']."' AND a.Login='".$_SESSION['MM_Username']."' ";
$rsCabecera = mysql_query($query_rsCabecera, $cn) or die(mysql_error());
$row_rsCabecera = mysql_fetch_assoc($rsCabecera);
$totalRows_rsCabecera = mysql_num_rows($rsCabecera);

switch ($_SESSION['MM_UserGroup']){
    case 1:
        $carpeta="alumno";
        break;
    case 2:
        $carpeta="personal";
        break;
    case 3:
        $carpeta="padre";
        break;
	case 4:
       	$carpeta="personal";
        break;
	case 5:
       	$carpeta="personal";
        break;
	}
	
define("PATH_NO_PHOTO_LARGE",  "http://www.cepsanagustin.com/intranet/imagenes/personal/sombra.jpg");
?>
<style type="text/css">
<!--
.Estilo1 {font-size: 20px}
-->
</style>
<link href="styleadm.css" rel="stylesheet" type="text/css" />
<?
// Obtenemos y traducimos el nombre del día
$dia=date("l");
if ($dia=="Monday") $dia="Lunes";
if ($dia=="Tuesday") $dia="Martes";
if ($dia=="Wednesday") $dia="Miércoles";
if ($dia=="Thursday") $dia="Jueves";
if ($dia=="Friday") $dia="Viernes";
if ($dia=="Saturday") $dia="Sabado";
if ($dia=="Sunday") $dia="Domingo";

// Obtenemos el número del día
$dia2=date("d");

// Obtenemos y traducimos el nombre del mes
$mes=date("F");
if ($mes=="January") $mes="Enero";
if ($mes=="February") $mes="Febrero";
if ($mes=="March") $mes="Marzo";
if ($mes=="April") $mes="Abril";
if ($mes=="May") $mes="Mayo";
if ($mes=="June") $mes="Junio";
if ($mes=="July") $mes="Julio";
if ($mes=="August") $mes="Agosto";
if ($mes=="September") $mes="Setiembre";
if ($mes=="October") $mes="Octubre";
if ($mes=="November") $mes="Noviembre";
if ($mes=="December") $mes="Diciembre";

// Obtenemos el año
$ano=date("Y");

// Imprimimos la fecha completa
//echo "$dia $dia2 de $mes de $ano";
?>
<table width="100%" height="110" border="0" cellspacing="0" cellpadding="0" class="Logo">
	<tr>
    	<td width="100px" align="center">
			<a href="default.php"><img src="../imagenes/sistema/insignia.png" width="80" border="0"/></a>
		</td>
        <td>
			<span class="Estilo1">CEP San Agustin</span>
		</td>
		<td>
		  <div style="float:right; padding-right:15px">
				<table width="220" border="0" cellspacing="1" cellpadding="0">
				  <tr>
					<td valign="top">
					<div style="height:5px"></div>
					<span class="NombreUsuario"><? echo $row_rsCabecera['Apellidos']; ?></span>
					<div style="height:6px"></div>
					<span class="NombreUsuario"><? echo $row_rsCabecera['Nombres']; ?></span>
					<div style="height:6px"></div>
					<span class="NombreUsuario"><? echo "USUARIO: ".$row_rsCabecera['Login']; ?></span>
					<div style="height:6px"></div>
					<span class="NombreUsuario"><? echo "PERFIL: ".$row_rsCabecera['NombrePerfil']; ?></span>
					<div style="height:6px"></div>
					<span class="NombreUsuario"><? echo "C&Oacute;DIGO: ".$row_rsCabecera['Codigo']; ?></span>
					</td>
					<td width="90" align="right">
					<img width="80" height="90" border="0" src="<?php $link_photo_car = "imagenes/".$carpeta."/".$_SESSION['MM_Username']."jpg"; 
					if (!is_array(@getimagesize($link_photo_car))){ 
						$show_path_photo_car = PATH_NO_PHOTO_LARGE; // Photo unavailable 
					}else { 
						$show_path_photo_car = $link_photo_car; 
					} 
					echo $show_path_photo_car;?>" id="Foto" name="Foto"/>
					</td>
				  </tr>
				  
				</table>
			</div>
		</td>
    </tr>
</table>
<div style="height:17px; background:#7EACCA; text-align:right; padding-right:15px" class="NombreFecha"><? echo "$dia $dia2 de $mes de $ano"; ?></div>
<?php
mysql_free_result($rsCabecera);
?>

