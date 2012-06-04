<?php include("../seguridad.php");?>
<?php require_once('../Connections/cn.php'); ?>
<?php 
include("../clases/datos.php");
$objDatos=new datos();
?>
<?php
$rsTreeview = $objDatos->ObtenerMenuAdministrativoSelAll($_SESSION['MM_Username']);
$row_rsTreeview = $objDatos->PoblarMenuAdministrativoSelAll($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);
?>
<?
//$Usuario=$_SESSION['MM_Username'];
$Perfil=$_POST['cboPerfil'];
$Id=$_POST['chkUsuario'];
					
mysql_select_db($database_cn, $cn);
$query_rsDelete = "delete FROM envioemail where UsuarioCreacion='".$_SESSION['MM_Username']."' ";
$rsDelete = mysql_query($query_rsDelete, $cn) or die(mysql_error());
		
if(isset($_POST['chkUsuario'])){
	$i1=0;
	foreach($Id as $valor1){
		$A[$i1]=$valor1;
		mysql_select_db($database_cn, $cn);
		$query_rsGrabar = "insert into envioemail (`CodEnvio`, `CodPerfil`, `CodigoUsuario`, ";
		$query_rsGrabar.= "`UsuarioCreacion`, `FechaCreacion`) ";
		$query_rsGrabar.= "values ('null', ".$_POST['cboPerfil'].", '".$A[$i1]."', ";
		$query_rsGrabar.= "'".$_SESSION['MM_Username']."', now()) ";
		$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
		$i1++;
	}
}else{
	header("default.php");
}
					

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templateadm.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Gestion Escolar</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script type="text/JavaScript" src="../validar.js"></script>
<!-- InstanceEndEditable -->
<link href="../styleadm.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="90%" border="0" align="center"><tr><td>
	<table width="100%" border="0" cellpadding="0">
		<tr>
			<td colspan="2"><? require_once("../cabecera.php"); ?></td>
		</tr>
		<tr>
		<td width="200" valign="top" class="Menu">
		<div style="padding-left:10px">	
			<div class="dtree">
				<div style="height:5px"></div>
				<a href="javascript: d.openAll();">Abrir todo</a> | <a href="javascript: d.closeAll();">Cerrar todo</a>
				<div style="height:10px"></div>
				<script type="text/javascript">
					d = new dTree('d');
					d.add(0,-1,'Inicio');
					<?php do { ?>
						d.add(<?php echo $row_rsTreeview['Id']; ?>,<?php echo $row_rsTreeview['IdPadre']; ?>,'<?php echo $row_rsTreeview['Nombre']; ?>','<?php echo $row_rsTreeview['Url']; ?>');
					<?php } while ($row_rsTreeview = mysql_fetch_assoc($rsTreeview)); ?>
					document.write(d);
				</script>
			</div>
		</div>
		<div style="height:10px"></div>
		</td>
		<td valign="top" class="Contenedor">
		<div style = "width: 99%; padding-left:5px" class="Contenedor">
		<!-- InstanceBeginEditable name="Contenido" -->
		<h1>Nuevo Mensaje</h1><hr /><br />
		<form action="maninsertescribir.php" method="post" name="form1" id="form1" autocomplete="Off" onsubmit="MM_validateForm('txtRemitente','','R','txtDestinatario','','R','txtMensaje','','R');return document.MM_returnValue">
		  <table width="400" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="60"><span class="label">De</span></td>
              <td width="10"><span class="label">:</span></td>
              <td><label>
                <input name="txtRemitente" type="text" id="txtRemitente" style="width:330px" value="<? echo $_SESSION['MM_Username'];?>" readonly="true"/>
              </label></td>
            </tr>
            <tr>
              <td width="60"><span class="label">Asunto</span></td>
              <td width="10"><span class="label">:</span></td>
              <td><label>
                <input name="txtDestinatario" type="text" id="txtDestinatario" style="width:330px"/>
              </label></td>
            </tr>
            <tr>
              <td width="60"><span class="label">Mensaje</span></td>
              <td width="10"><span class="label">:</span></td>
              <td><input name="txtCodigoCurso" type="hidden" id="txtCodigoCurso" value="<?php echo $_POST['txtCodigoCurso']; ?>"/></td>
            </tr>
            <tr>
              <td colspan="3"><label>
                <textarea name="txtMensaje" rows="12" id="txtMensaje" style="width:400px"></textarea>
              </label></td>
            </tr>
          </table>
		  <div style="height:5px"></div>
		  <div style="width:406px">
			  <div style="width:203px; float:right; text-align:right">
				<label>
				<input type="submit" name="Enviar" value="Enviar" />&nbsp;&nbsp;
				<input type="button" name="button" id="button" value="Volver"  
				onclick='javascript: self.location.href=&quot;menlistausuario.php&quot;'/>
				</label>
			  </div>
		  </div>
        </form>
		<div style="height:30px"></div>
		<!-- InstanceEndEditable -->
		</div>
		<div style="height:10px"></div>
		</td>
		</tr>
		<tr>
			<td colspan="2"><? require_once("../pie.php"); ?></td>
		</tr>
	</table>
</td></tr></table>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($rsTreeview);
?>
