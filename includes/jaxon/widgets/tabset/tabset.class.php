<?php
class Tabset {
	var $id = '';
	var $tabs = array();
	var $selected;
	var $options = array();

	function Tabset($id) {
		$this->id = $id;
		$this->options['has_width'] = false;
		$this->options['has_height'] = false;
	}

	function setDimensions($width, $height) {
		if ($width && $width != 0) {
			$this->options['dimensions']['width'] = $width;
			$this->options['has_width'] = true;
		}
		if ($height && $height != 0) {
			$this->options['dimensions']['height'] = $height;
			$this->options['has_height'] = true;
		}
	}

	function setTabFromUri() {
		if (isset($_GET[$this->id . '__tab'])) {
			$this->setSelected((int) $_GET[$this->id . '__tab']);
		} else {
			$this->setSelected(0);
		}
	}

	function addTab($title, $file) {
		$title = KT_DynamicData($title, null, '');
		$file = KT_DynamicData($file, null, '');
		array_push($this->tabs, array('title' => $title, 'file' => $file));
	}

	function setSelected($index) {
		if ($index > count($this->tabs)) {
			$this->selected = 0;
			return false;
		}
		$this->selected = $index;
	}

	function getNavigationSelectedClass($index) {
		return ($this->selected == $index) ? ' selected' : '' ;
	}
	function getContentSelectedClass($index) {
		return ($this->selected == $index) ? ' body_active': '' ;
	}

	function setAjaxStubContext() {
		$GLOBALS["stub_context"] = KT_Rel2AbsUrl(KT_getUri(), "",  $this->tabs[$this->selected]["file"], true);
		if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != "") {
			$GLOBALS["stub_context"] .= "?" . $_SERVER['QUERY_STRING'];
		} 
	}
	
	function resetAjaxStubContext() {
		unset($GLOBALS["stub_context"]);
	}
	
	function getFileName() {
        return basename($this->tabs[$this->selected]['file']);
	}
	
	function renderBegin() {
    	$this->setTabFromUri();
    	$this->setAjaxStubContext();
		$this->w = $this->h = '';
		if ($this->options['has_width']) {
			$this->w = 'width: ' . $this->options['dimensions']['width'].'px';
		}
		if ($this->options['has_height']) {
			$this->h = 'height: ' . $this->options['dimensions']['height'].'px';
		}
		$style = ($this->options['has_width'] || $this->options['has_height']) ? ('style="'.implode(';', array($this->w, $this->h)).';"') : '';
		$toret = '<div id="'.$this->id.'" class="tabset phprendering" '. (($this->options['has_width'])? ('style="'. $this->w): '') . '">';
		$toret .= '<ul class="tabset_tabs">';
		for ($i = 0; $i < count($this->tabs); $i++) {
			$toret .= '
				<li id="'.$this->id.'tab'.$i.'-tab" class="tab '. $this->getNavigationSelectedClass($i).'"><a id="link__'.$this->id.'tab'.$i.'" href="'. str_replace('&', '&amp;', KT_addReplaceParam(KT_getFullUri(), $this->id . '__tab', $i).'">'.$this->tabs[$i]['title']) .'</a></li>';
		}
		$toret .= '</ul>';
		for ($i = 0; $i < count($this->tabs); $i++) {
			$toret .= '
				<div id="'.$this->id.'tab'.$i.'-body" class="tabBody '.$this->getContentSelectedClass($i).'" '.(($this->options['has_width'] || $this->options['has_height']) ? ('style="'.implode(';', array($this->w, $this->h)).';overflow: auto;"') : '').'>
					<div class="tabContent">';
						if ($i == $this->selected) {
							break;
						}
			$toret .= '</div>
				</div>';
		}
		$this->prevDir = getcwd();
		chdir(dirname(realpath($this->tabs[$this->selected]['file'])));
		return $toret;
	}
	
	function renderEnd() {
		chdir($this->prevDir);
		$toret = '</div>
				</div>';
		for ($i = $this->selected + 1; $i < count($this->tabs); $i++) {
			$toret .= '
				<div id="'.$this->id.'tab'.$i.'-body" class="tabBody '.$this->getContentSelectedClass($i).'" '.(($this->options['has_width'] || $this->options['has_height']) ? ('style="'.implode(';', array($this->w, $this->h)).';overflow: auto;"') : '').'>
					<div class="tabContent"></div>
				</div>';
		}
		$toret .= '
			</div>
			<script  type="text/javascript">
            <!--
			var '.$this->id.' = new Widgets.Tabset("'.$this->id.'", [';
		$tmp = array();
		for ($i = 0; $i < count($this->tabs); $i++) {
			$tmp[] = '"' . $this->tabs[$i]['file'] . '"';
		}
		$toret .= implode(", ", $tmp);
		unset($this->options['has_width']);
		unset($this->options['has_height']);
		unset($this->options['dimensions']);
		$toret .= '], '.KT_json($this->options).');
            //-->
			</script>	
		';
		$this->resetAjaxStubContext();
		return $toret;
	}
}
?>