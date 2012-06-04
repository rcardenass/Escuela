<?php
/*
	Copyright (c) InterAKT Online 2000-2006. All rights reserved.
*/

	$KT_IMG_uploadErrorMsg = '<strong>File not found:</strong> <br />%s<br /><strong>Please upload the includes/ folder to the testing server.</strong> <br /><a href="http://www.interaktonline.com/error/?error=upload_includes" onclick="return confirm(\'Some data will be submitted to InterAKT. Do you want to continue?\');" target="KTDebugger_0">Online troubleshooter</a>';
	$KT_IMG_uploadFileList = array('KT_Image.class.php', '../../KT_common.php', '../resources/KT_Resources.php', '../folder/KT_Folder.php', '../shell/KT_Shell.php');

	for ($KT_IMG_i=0;$KT_IMG_i<sizeof($KT_IMG_uploadFileList);$KT_IMG_i++) {
		$KT_IMG_uploadFileName = dirname(realpath(__FILE__)). '/' . $KT_IMG_uploadFileList[$KT_IMG_i];
		if (file_exists($KT_IMG_uploadFileName)) {
			require_once($KT_IMG_uploadFileName);
		} else {
			die(sprintf($KT_IMG_uploadErrorMsg,$KT_IMG_uploadFileList[$KT_IMG_i]));
		}
	}

?>
