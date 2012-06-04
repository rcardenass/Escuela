<?php
/*
	Copyright (c) InterAKT Online 2000-2006. All rights reserved.
*/

	$KT_SHL_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_SHL_uploadFileList = array('KT_Shell.class.php', '../resources/KT_Resources.php');

	for ($KT_SHL_i=0;$KT_SHL_i<sizeof($KT_SHL_uploadFileList);$KT_SHL_i++) {
		$KT_SHL_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_SHL_uploadFileList[$KT_SHL_i];
		if (file_exists($KT_SHL_uploadFileName)) {
			require_once($KT_SHL_uploadFileName);
		} else {
			die(sprintf($KT_SHL_uploadErrorMsg,$KT_SHL_uploadFileList[$KT_SHL_i]));
		}
	}

?>
