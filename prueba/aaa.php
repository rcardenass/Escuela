<?php require_once('../Connections/cn.php'); ?>
<?php
mysql_select_db($database_cn, $cn);
$query_rsTreeview = "SELECT Id, NombrePrograma as Nombre, IdPadre, Url FROM programa";
$rsTreeview = mysql_query($query_rsTreeview, $cn) or die(mysql_error());
$row_rsTreeview = mysql_fetch_assoc($rsTreeview);
$totalRows_rsTreeview = mysql_num_rows($rsTreeview);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>Destroydrop &raquo; Javascripts &raquo; Tree</title>
	<link rel="StyleSheet" href="dtree.css" type="text/css" />
	<script type="text/javascript" src="dtree.js"></script>
</head>
<body>
<h1><a href="/">Destroydrop</a> &raquo; <a href="/javascripts/">Javascripts</a> &raquo; <a href="/javascripts/tree/">Tree</a></h1>
<h2>Example</h2>
<div class="dtree">
	<p><a href="javascript: d.openAll();">open all</a> | <a href="javascript: d.closeAll();">close all</a></p>
	<script type="text/javascript">
		<!--
		d = new dTree('d');

		d.add(0,-1,'Inicio','example01.html');
		/*d.add(1,0,'Node 1','example01.html');
		d.add(2,0,'Node 2','example01.html');
		d.add(3,1,'Node 1.1','example01.html');
		d.add(4,0,'Node 3','example01.html');
		d.add(5,3,'Node 1.1.1','example01.html');
		d.add(6,5,'Node 1.1.1.1','example01.html');
		d.add(7,0,'Node 4','example01.html');
		d.add(8,1,'Node 1.2','example01.html');
		d.add(9,0,'My Pictures','example01.html','Pictures I\'ve taken over the years','','','img/imgfolder.gif');
		d.add(10,9,'The trip to Iceland','example01.html','Pictures of Gullfoss and Geysir');
		d.add(11,9,'Mom\'s birthday','example01.html');
		d.add(12,0,'Recycle Bin','example01.html','','','img/trash.gif');*/
		<?php do { ?>
			d.add(<?php echo $row_rsTreeview['Id']; ?>,<?php echo $row_rsTreeview['IdPadre']; ?>,'<?php echo $row_rsTreeview['Nombre']; ?>','<?php echo $row_rsTreeview['Url']; ?>');
  		<?php } while ($row_rsTreeview = mysql_fetch_assoc($rsTreeview)); ?>
		
		document.write(d);
		//-->
	</script>
</div>
<p><a href="mailto&#58;drop&#64;destroydrop&#46;com">&copy;2002-2003 Geir Landr&ouml;</a></p>
</body>
</html>
<?php
mysql_free_result($rsTreeview);
?>