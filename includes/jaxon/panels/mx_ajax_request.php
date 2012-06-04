<?php
if (KT_is_ajax_request()) {
	$jaxon__all_panels = array_keys($GLOBALS['ctrl']->panels);
	$jaxon__real_panels = array();
	$strlens = array();
	$contents = '';
	$start_index = 0;

	for ($jaxon__i = 0; $jaxon__i < count($jaxon__all_panels); $jaxon__i++) {
		$panelId = $jaxon__all_panels[$jaxon__i];
		$panelObj = & $ctrl->getPanel($panelId);
		
		$must_return = $panelObj->stateFromUrl;

		if (in_array($panelId, $GLOBALS['panels_from_lc']) && !isset($_GET['KT_tooltip'])) {
			$must_return = true;
		}

		if ($must_return) {

			$tmp_arr = array('panels' => array($panelId => array('start' => 0, 'current_state'=> $panelObj->currentState)));
			header('Kt_json: ' . KT_json($tmp_arr));

			ob_start();
			$panelObj->renderBegin();
			require($panelObj->getFileName());
			$panelObj->renderEnd();
			$content = ob_get_contents();
			ob_end_clean();

			$content_js = $ctrl->renderJsBindings(false);
       
			$contents .= $content . $content_js;
            
			$strlen_content = strlen($content);
			$strlen_content_js = strlen($content_js);
			$strlen_all = $strlen_content + $strlen_content_js;

			$strlens[$panelId] = array(
				'start'=> $start_index, 
				'current_state'=> $panelObj->currentState,
				'end' => ($start_index + $strlen_all),
				'content' => $strlen_content,
				'content_js' => $strlen_content_js
			);

			$start_index += $strlen_all;
		}
	}
	
	$tmp_arr = array('panels' => $strlens, 'title' => $ctrl->title);
	
	// do not cache AJAX Requests
	$seconds_expire  = -86400;
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
	header('Kt_json: ' . KT_json($tmp_arr));
	
	echo $contents;

	die();
}
?>
