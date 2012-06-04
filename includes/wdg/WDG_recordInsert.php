<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

require_once(dirname(realpath(__FILE__)).'/WDG.php');

$WDG_sessInsTest = &$_SESSION['WDG_sessInsTest'];
$vars = $WDG_sessInsTest[$_GET['id']];

require_once(dirname(realpath(__FILE__)).'/../../Connections/' . $vars['conn'] . '.php');

$KT_conn = ${$vars['conn']};
$KT_conndb = ${'database_' . $vars['conn']};

// mysql adodb abstraction layer
if (is_resource($KT_conn)) {
	$conn = new KT_Connection($KT_conn, $KT_conndb);
} else {
	$conn = &$KT_conn;
}
KT_setDbType($conn);

$el = KT_getRealValue('GET', 'el');
$text = KT_getRealValue('GET', 'text');

$sql = 'INSERT INTO ' . $vars['table'] . ' (' . KT_escapeFieldName($vars['updatefield']) . ') VALUES (' . KT_escapeForSql($text, 'STRING_TYPE') . ')';
$conn->Execute($sql);
$ERROR = $conn->ErrorMsg();

$sql = 'SELECT ' . KT_escapeFieldName($vars['idfield']) . ' AS id FROM ' . $vars['table'] . ' WHERE ' . KT_escapeFieldName($vars['updatefield']) . ' = ' . KT_escapeForSql($text, 'STRING_TYPE');
$rsName = $vars['rsName'];

$$rsName = $conn->Execute($sql);
${'row_' . $rsName} = ${$rsName}->fields;

$text = KT_escapeJS($text);

//JSRecordset($rsName);
?>
<html><body onLoad="parent.MXW_DynamicObject_reportDone('<?php echo $el; ?>', isError)">
<?php
if (${'row_' . $rsName}['id'] != '') {
?><script>
	var isError = false;
	var targetRSName = '<?php echo $rsName;?>';
	var targetEditableDropdownName = '<?php echo $el; ?>';
	var idfield = '<?php echo $vars['idfield']?>';
	var updatefield = '<?php echo $vars['updatefield']?>';
	var insertedID = '<?php echo KT_escapeJS(${'row_' . $rsName}['id']); ?>';
	var insertedValue = '<?php echo $text; ?>';

	for(dyninputname in parent[parent.$DYS_GLOBALOBJECT]) {
		updatedDynamicInput = parent[parent.$DYS_GLOBALOBJECT][dyninputname]
		if (!updatedDynamicInput || updatedDynamicInput && !updatedDynamicInput.oldinput) {
			continue;
		}
		recordsetName = parent.WDG_getAttributeNS(updatedDynamicInput.oldinput, 'recordset');
		if (targetRSName != recordsetName) {
			continue;
		}
	
		var newRow = [];
		newRow[idfield] = insertedID;
		newRow[updatefield] = insertedValue;
		updatedDynamicInput.recordset.Insert(
			newRow,
			parseInt(updatedDynamicInput._firstMatch, 10) + 1
		);

		if (targetEditableDropdownName == dyninputname) {
			updatedDynamicInput.oldinput.options.add(new parent.Option(insertedValue, insertedID));
			updatedDynamicInput.sel.options.add(new parent.Option(insertedValue, insertedID));
			updatedDynamicInput.addButton.disabled = true;
			updatedDynamicInput.oldinput.selectedIndex = updatedDynamicInput.oldinput.options.length - 1;
			updatedDynamicInput.sel.selectedIndex = updatedDynamicInput.sel.options.length - 1;
			updatedDynamicInput.oldinput.value = insertedID;
			updatedDynamicInput.newvalue = insertedID;
			parent.MXW_DynamicObject_syncSelection(dyninputname, false, true);
			updatedDynamicInput.edit.focus();	
		} else {
			updatedDynamicInput.oldinput.options.add(new parent.Option(insertedValue, insertedID));
			updatedDynamicInput.sel.options.add(new parent.Option(insertedValue, insertedID));
		}
	}
	var isComplete = true;
</script>
<?php
} else { ?>
<script>
window.onload = function() {
	parent.MXW_DynamicObject_reportDone('<?php echo $el ?>', true, '<?php echo KT_escapeJS($ERROR); ?>')	
}
</script>
<?php } ?>
</body>
</html>
