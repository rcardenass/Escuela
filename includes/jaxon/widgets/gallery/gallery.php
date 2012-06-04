<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

	$KT_Gallery_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/jaxon/widgets folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_Gallery_uploadFileList = array(
		'../../../common/KT_common.php',
		'../../utils/json.php',
        'gallery.class.php',
        'gallery_functions.inc.php');

	for ($KT_Gallery_i=0;$KT_Gallery_i<sizeof($KT_Gallery_uploadFileList);$KT_Gallery_i++) {
		$KT_Gallery_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_Gallery_uploadFileList[$KT_Gallery_i];
		if (file_exists($KT_Gallery_uploadFileName)) {
			require_once($KT_Gallery_uploadFileName);
		} else {
			die(sprintf($KT_Gallery_uploadErrorMsg,$KT_Gallery_uploadFileList[$KT_Gallery_i]));
		}
	}

KT_session_start();
    
?>