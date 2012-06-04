<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_Service_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/jaxon/widgets folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_Service_uploadFileList = array(
		'../../common/KT_common.php',
		'../utils/json.php',
		'serviceutils.class.php',
		'service.class.php',
		'ajaxservice.class.php');

	for ($KT_Service_i=0;$KT_Service_i<sizeof($KT_Service_uploadFileList);$KT_Service_i++) {
		$KT_Service_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_Service_uploadFileList[$KT_Service_i];
		if (file_exists($KT_Service_uploadFileName)) {
			require_once($KT_Service_uploadFileName);
		} else {
			die(sprintf($KT_Service_uploadErrorMsg,$KT_Service_uploadFileList[$KT_Service_i]));
		}
	}
    
?>