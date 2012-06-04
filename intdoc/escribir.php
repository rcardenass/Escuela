<?php require_once('../Connections/cn.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
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

$MM_restrictGoTo = "../error.php";
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
mysql_select_db($database_cn, $cn);
$query_rsTreeview = "SELECT Id, NombrePrograma as Nombre, IdPadre, Url FROM programa WHERE CodPerfil=2 ";
$rsTreeview = mysql_query($query_rsTreeview, $cn) or die(mysql_error());
$row_rsTreeview = mysql_fetch_assoc($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);
?>
<?
//$Usuario=$_SESSION['MM_Username'];
$Perfil=1;
$Id=$_POST['chkAlumno'];
					
mysql_select_db($database_cn, $cn);
$query_rsDelete = "delete FROM envioemail where UsuarioCreacion='".$_SESSION['MM_Username']."' ";
$rsDelete = mysql_query($query_rsDelete, $cn) or die(mysql_error());
		
if(isset($_POST['chkAlumno'])){
	$i1=0;
	foreach($Id as $valor1){
		$A[$i1]=$valor1;
		mysql_select_db($database_cn, $cn);
		$query_rsGrabar = "insert into envioemail (`CodEnvio`, `CodPerfil`, `CodigoUsuario`, ";
		$query_rsGrabar.= "`UsuarioCreacion`, `FechaCreacion`) ";
		$query_rsGrabar.= "values ('null', ".$Perfil.", '".$A[$i1]."', ";
		$query_rsGrabar.= "'".$_SESSION['MM_Username']."', now()) ";
		$rsGrabar = mysql_query($query_rsGrabar, $cn) or die(mysql_error());
		$i1++;
	}
}else{
	header("cursos.php");
}
					

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/templatedoc.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Documento sin t&iacute;tulo</title>
<link rel="stylesheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>
<!-- InstanceEndEditable -->
<link href="../styledoc.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="980px" border="0" align="center"><tr><td>
	<table width="980px" border="0" cellpadding="0">
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
		<form action="insertescribir.php" method="post" name="form1" id="form1" autocomplete="Off" onsubmit="MM_validateForm('txtRemitente','','R','txtDestinatario','','R','txtMensaje','','R');return document.MM_returnValue">
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
				onclick='javascript: self.location.href=&quot;cursos.php&quot;'/>
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
