<?php


require_once(dirname(__FILE__) . "/" . "../../../common/KT_common.php");
KT_session_start();

require_once(dirname(__FILE__) . "/" . "gallery.class.php");
require_once(dirname(__FILE__) . "/" . "gallery_functions.inc.php");
require_once(dirname(__FILE__) . "/" . "../../services/service.php");
require_once(dirname(__FILE__) . "/" . "../../../common/lib/file/KT_File.php");
require_once(dirname(__FILE__) . "/" . "../../../common/lib/folder/KT_Folder.php");
require_once(dirname(__FILE__) . "/" . "../../../common/lib/image/KT_Image.php");
require_once(dirname(__FILE__) . "/" . "../../../common/lib/resources/KT_Resources.php");
require_once(dirname(__FILE__) . "/" . "../../../common/lib/shell/KT_Shell.php");

if (isset($_GET['gallery_id'])) {
	$g = new Gallery($_GET['gallery_id']);
	$g->loadConfigFromSession();
	$s = new Service($g);

	$s->setMandatoryParams('gallery_id');
	
	// do not cache AJAX Requests
	$seconds_expire  = -86400; //one day ago
    KT_sendExpireHeader($seconds_expire);            
		
	$isOpera = false;
	if (isset($_SERVER) && isset($_SERVER['HTTP_USER_AGENT'])) {
		if (stristr($_SERVER['HTTP_USER_AGENT'], 'opera/9.')) {
			$isOpera = true;
		}
	}
	if (isset($_SERVER['HTTP_KT_CHARSET'])) {
		header('Content-Type: text/' . (!$isOpera ? 'jaxon' : 'plain') . '; charset='.$_SERVER['HTTP_KT_CHARSET']);
	} else {
		header('Content-Type: text/' . (!$isOpera ? 'jaxon' : 'plain') . '');
	}

	echo $s->execute();
} else {
	// do not cache AJAX Requests
	$seconds_expire  = -86400; //one day ago
    KT_sendExpireHeader($seconds_expire);            
    

	$isOpera = false;
	if (isset($_SERVER) && isset($_SERVER['HTTP_USER_AGENT'])) {
		if (stristr($_SERVER['HTTP_USER_AGENT'], 'opera/9.')) {
			$isOpera = true;
		}
	}
	if (isset($_SERVER['HTTP_KT_CHARSET'])) {
		header('Content-Type: text/' . (!$isOpera ? 'jaxon' : 'plain') . '; charset='.$_SERVER['HTTP_KT_CHARSET']);
	} else {
		header('Content-Type: text/' . (!$isOpera ? 'jaxon' : 'plain') . '');
	}
	ServiceUtils::showMissingParamsError("gallery", array('gallery_id'));
}
?>
