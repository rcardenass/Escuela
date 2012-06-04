<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_panels_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_panels_uploadFileList = array(
		'PanelController.class.php', 
		'Panel.class.php', 
		'../utils/json.php', 
	);

	for ($KT_panels_i=0;$KT_panels_i<sizeof($KT_panels_uploadFileList);$KT_panels_i++) {
		$KT_panels_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_panels_uploadFileList[$KT_panels_i];
		if (file_exists($KT_panels_uploadFileName)) {
			require_once($KT_panels_uploadFileName);
		} else {
			die(sprintf($KT_panels_uploadErrorMsg, $KT_panels_uploadFileList[$KT_panels_i]));
		}
	}
?>
