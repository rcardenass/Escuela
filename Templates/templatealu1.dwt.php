<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsTreeview = "SELECT Id, NombrePrograma as Nombre, IdPadre, Url FROM programa WHERE CodPerfil=1 ";
$rsTreeview = mysql_query($query_rsTreeview, $cn) or die(mysql_error());
$row_rsTreeview = mysql_fetch_assoc($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- TemplateBeginEditable name="doctitle" -->
<title>Documento sin t&iacute;tulo</title>
<link rel="StyleSheet" href="../treeview/dtree.css" type="text/css" />
<script type="text/javascript" src="../treeview/dtree.js"></script>
<!-- TemplateEndEditable -->
<!-- TemplateBeginEditable name="head" --><!-- TemplateEndEditable -->
</head>

<body>
<div style = "display: table; margin-left: auto; margin-right: auto; width: 90%; background-color:#66FF00">
    <div style = "height: 45px; width: 100%; background-color:#FF3300">Cabecera</div>
    <div style = "float: left; height: 450px; width: 20%; background-color:#99CCFF">
		<div style="padding-left:10px">
			<div class="dtree">
			<p><a href="javascript: d.openAll();">abrir todo</a> | <a href="javascript: d.closeAll();">cerrar todo</a></p>
			<script type="text/javascript">
				<!--
				d = new dTree('d');
		
				d.add(0,-1,'Inicio');
				/*d.add(1,0,'Node 1','');
				d.add(2,0,'Node 2','prueba2.php');
				d.add(3,1,'Node 1.1','');
				d.add(4,0,'Node 3','prueba4.php');
				d.add(5,3,'Node 1.1.1','');
				d.add(6,5,'Node 1.1.1.1','prueba3.php');
				d.add(7,0,'Node 4','prueba5.php');
				d.add(8,1,'Node 1.2','prueba.php');
				d.add(9,0,'My Pictures','','Pictures I\'ve taken over the years','','','../treeview/img/imgfolder.gif');
				d.add(10,9,'The trip to Iceland','prueba3.php','Pictures of Gullfoss and Geysir');
				d.add(11,9,'Mom\'s birthday','prueba2.php');
				d.add(12,0,'Recycle Bin','prueba3.php','','','../treeview/img/trash.gif');*/
				<?php do { ?>
				d.add(<?php echo $row_rsTreeview['Id']; ?>,<?php echo $row_rsTreeview['IdPadre']; ?>,'<?php echo $row_rsTreeview['Nombre']; ?>','<?php echo $row_rsTreeview['Url']; ?>');
  				<?php } while ($row_rsTreeview = mysql_fetch_assoc($rsTreeview)); ?>
				
				document.write(d);
				//-->
			</script>
			</div>
		</div>
	</div>
    <div style = "float: right; height: 450px; width: 80%; background-color:#999999">
		<div style = "height: 450px; width: 99%; padding-left:5px">
		<!-- TemplateBeginEditable name="Contenido" -->
		<!-- TemplateEndEditable -->	
		</div>
	</div>
    <div style = "clear: both; height: 35px; width: 100%; background-color:#00FF00">Pie</div>
</div> 
</body>
</html>
<?php
mysql_free_result($rsTreeview);
?>
