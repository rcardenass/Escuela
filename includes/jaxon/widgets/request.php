<?php
	if (isset($_GET['KT_ajax_request'])) {
    	require_once(dirname(__FILE__) . '/../../common/KT_common.php');
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
	}
?>
