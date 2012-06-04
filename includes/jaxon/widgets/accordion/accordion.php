<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_Accordion_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/jaxon/widgets folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_Accordion_uploadFileList = array(
		'../../utils/json.php',
		'../../../common/KT_common.php',
        'accordion.class.php');

	for ($KT_Accordion_i=0;$KT_Accordion_i<sizeof($KT_Accordion_uploadFileList);$KT_Accordion_i++) {
		$KT_Accordion_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_Accordion_uploadFileList[$KT_Accordion_i];
		if (file_exists($KT_Accordion_uploadFileName)) {
			require_once($KT_Accordion_uploadFileName);
		} else {
			die(sprintf($KT_Accordion_uploadErrorMsg,$KT_Accordion_uploadFileList[$KT_Accordion_i]));
		}
	}
    KT_session_start();
?>