<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_Collapsible_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/jaxon/widgets folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_Collapsible_uploadFileList = array(
		'../../utils/json.php',
		'../../../common/KT_common.php',
        'collapsible.class.php');

	for ($KT_Collapsible_i=0;$KT_Collapsible_i<sizeof($KT_Collapsible_uploadFileList);$KT_Collapsible_i++) {
		$KT_Collapsible_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_Collapsible_uploadFileList[$KT_Collapsible_i];
		if (file_exists($KT_Collapsible_uploadFileName)) {
			require_once($KT_Collapsible_uploadFileName);
		} else {
			die(sprintf($KT_Collapsible_uploadErrorMsg,$KT_Collapsible_uploadFileList[$KT_Collapsible_i]));
		}
	}
    KT_session_start();
?>