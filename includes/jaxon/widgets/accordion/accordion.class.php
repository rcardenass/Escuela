<?php
class Accordion {
	var $id = '';
	var $regions = array();
	var $selected;
	var $options = array();

	function Accordion($id) {
		$this->id = $id;
	}

	function setRegionFromUri() {
		if (isset($_GET[$this->id . '__region'])) {
			$this->setSelected((int) $_GET[$this->id . '__region']);
		} else {
			$this->setSelected(0);
		}
	}

	function setDimensions($width, $height) {
		$this->options['dimensions'] = array('width' => $width, 'height' => $height);
	}

	function addRegion($title, $file) {
		$title = KT_DynamicData($title, null, '');
		$file = KT_DynamicData($file, null, '');
		array_push($this->regions, array('title' => $title, 'file' => $file));
	}

	function setSelected($index) {
		if ($index > count($this->regions)) {
			$this->selected = 0;
			return false;
		}
		$this->selected = $index;
	}

	function getSelectedClass($index) {
		return ($this->selected == $index) ? ' selected' : '' ;
	}

	function setAjaxStubContext() {
		$GLOBALS["stub_context"] = KT_Rel2AbsUrl(KT_getUri(), "",  $this->regions[$this->selected]["file"], true);
		if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != "") {
			$GLOBALS["stub_context"] .= "?" . $_SERVER['QUERY_STRING'];
		} 
	}
	
	function resetAjaxStubContext() {
		unset($GLOBALS["stub_context"]);
	}
	
	function getFileName() {
        return basename($this->regions[$this->selected]['file']);
	}

	function renderBegin() {
        $this->setRegionFromUri();
        $this->setAjaxStubContext();
		$toret = '<div id="'.$this->id.'" class="accordion phprendering" style="width: '.$this->options['dimensions']['width'].'px; height: '.$this->options['dimensions']['height'].'px;">';
		for ($i = 0; $i < count($this->regions); $i++) {
			$toret .= '
				<div class="region '. $this->getSelectedClass($i).'">
					<h3><a  id="link__'.$this->id.'region'.$i.'" href="'. KT_addReplaceParam(KT_getFullUri(), $this->id . '__region', $i).'">'.$this->regions[$i]['title'].'</a></h3>
					<div id="'.$this->id.'region'.$i.'-body" class="accordionBody">
						<div class="accordionContent"> ';
						if($i == $this->selected) {
							break;
						}
			$toret .= '	</div>
					</div>
				</div>';
		}
		
		$this->prevDir = getcwd();
		chdir(dirname(realpath($this->regions[$this->selected]['file'])));
		return $toret;
	}
	
	function renderEnd() {
		chdir($this->prevDir);		
		$toret = '	</div>
				</div>
			</div>';
		for ($i = $this->selected + 1; $i < count($this->regions); $i++) {
			$toret .= '
				<div class="region '. $this->getSelectedClass($i).'">
					<h3><a  id="link__'.$this->id.'region'.$i.'" href="'. str_replace('&', '&amp;', KT_addReplaceParam(KT_getFullUri(), $this->id . '__region', $i)).'">'.$this->regions[$i]['title'].'</a></h3>
					<div id="'.$this->id.'region'.$i.'-body" class="accordionBody">
						<div class="accordionContent">
						</div>
					</div>
				</div>';
		}
		$toret .= '
			</div>
			<script  type="text/javascript">
            <!--
			var '.$this->id.' = new Widgets.Accordion("'.$this->id.'", [';
		$tmp = array();
		for ($i = 0; $i < count($this->regions); $i++) {
			$tmp[] = '"' . $this->regions[$i]['file'] . '"';
		}
		$toret .= implode(", ", $tmp);
		$toret .= '], '.KT_json($this->options).');
            //-->
			</script>	
		';
		$this->resetAjaxStubContext();
		return $toret;
	}
	
}
?>