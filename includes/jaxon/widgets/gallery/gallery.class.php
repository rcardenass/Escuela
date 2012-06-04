<?php
/*
	Copyright (c) InterAKT Online 2000-2006
*/

class Gallery {
	var $exportedMethods = array('getPhotoList', 'createThumbnail');
	var $config = array();
    var $location = 'bottom';
	var $id = '';
    var $showLoader = false;
	var $metaSource = '';
	var $rootNode = '';
	var $pictureNode = '';
	var $descriptionNode = '';

	
	function Gallery($id) {
		$this->id = $id;
        // init defaults for config
        $this->config['thumbnails'] = array(
			'width' => '60', 
			'height' => '40'
        );
	}

	function saveConfigToSession() {
		$copy = array_merge_recursive(array(), $this->config);
		if (!isset($_SESSION['Widgets.Gallery'])) {
			$_SESSION['Widgets.Gallery'] = array();
		}
		$_SESSION['Widgets.Gallery'][$this->id] = serialize($this->config);
	}

	function setDimensions($width, $height) {
		$this->config['dimensions'] = array('width' => $width, 'height' => $height);
	}

	function setFolder($folderName) {
		$folderName = KT_DynamicData($folderName, null, false, false);
		$this->config['client_photo_folder'] = $folderName;
		$this->config['photo_folder'] = KT_RealPath($folderName, true);
	}

	function setThumbnailSize($width, $height) {
		$this->config['thumbnails'] = array(
			'width' => $width, 
			'height' => $height
		);
	}
    
	function setImagePreviewSize($width, $height) {
		$this->config['preview'] = array(
			'width' => $width, 
			'height' => $height
		);
	}    
    
    function showThumbnailLoader($showLoader) {
        $this->showLoader = $showLoader;
    }

	function setNavLocation($location) {
		$this->location = $location;
	}

	function render() {
		$this->saveConfigToSession();
		$client_photo_folder = $this->config['client_photo_folder'];
		$c = ($this->location == 'bottom' ? 'glist_after' : 'glist_before');
		$contandnav = '
		<div class="glist clearfix '.$c.'">
		<div class="gleft"><a href="#"></a></div>
			<div class="gthumbs" id="'.$this->id.'_thumbs" style="width: '.($this->config['dimensions']['width']-20).'px;"></div>
			<div class="gright"><a href="#"></a></div>
		</div>';

		$content = '<div class="gcontent" id="'.$this->id.'_content" style="height: '.($this->config['dimensions']['height']).'px;"></div>';
		if ($this->location == 'bottom') {
			$contandnav =  $content . $contandnav;
		} else {
			$contandnav .= $content;
		}
			
		return '
	<div class="gallery" id="'.$this->id.'" style="width: '.($this->config['dimensions']['width']+2).'px;">
		'.$contandnav.'
	</div>
	<script  type="text/javascript">
        <!--
		'.$this->id.'_object = new Widgets.Gallery("'.$this->id.'", {
			"photo_folder": "'.$client_photo_folder.'", 
			"width": "'.$this->config['dimensions']['width'].'", 
			"height": "'.$this->config['dimensions']['height'].'", 
			"show_loading_indicator": '.($this->showLoader? 'true' : 'false').', 
			"meta_source": "'.$this->metaSource.'", 
			"picture_node": "'.$this->pictureNode.'", 
			"description_node": "'.$this->descriptionNode.'"
		});
        //-->
	</script>
';
	}

	function loadConfigFromSession() {
		if (isset($_SESSION['Widgets.Gallery']) && isset($_SESSION['Widgets.Gallery'][$this->id])) {
			$this->config = unserialize($_SESSION['Widgets.Gallery'][$this->id]);
		}
	}

	function createThumbnail($name) {
		$name = get_magic_quotes_gpc() ? stripslashes($name) : $name;
		$name = basename($name);
		$folderName = KT_RealPath($this->config['photo_folder'], true);
		$fullFileName = $folderName . $name;
		$folderName = KT_RealPath($this->config['photo_folder'], true);
		$thumb_path = $folderName . $GLOBALS['GAL_thumbnail_folder'];
		$info = KT_pathinfo($fullFileName);
		$fullThumbnailName = $info['filename'].'_'.$this->config['thumbnails']['width'].'x'.$this->config['thumbnails']['height'].'.'.$info['extension'];

		$image = new KT_image();
		$imageLib = '';
		if (isset($GLOBALS['KT_prefered_image_lib'])) {
			$imageLib = $GLOBALS['KT_prefered_image_lib'];
			$image->setPreferedLib($imageLib);
		}
		if ($imageLib == 'imagemagick') {
			if (isset($_SESSION['Widgets.Gallery']['config']['ExecPath'])) {
				$image->addCommand($_SESSION['Widgets.Gallery']['config']['ExecPath']);
			} else {
				if (isset($GLOBALS['KT_prefered_imagemagick_path'])) {
					$image->addCommand($GLOBALS['KT_prefered_imagemagick_path']);
				}
			}
		}
		$image->thumbnail($fullFileName, $thumb_path, $fullThumbnailName, $this->config['thumbnails']['width'], $this->config['thumbnails']['height'], true);
		$toret = array();
		if ($image->hasError()) {
			$errors = $image->getError();
			$errorLevel = !empty($GLOBALS['tNG_debug_mode'])?($GLOBALS['tNG_debug_mode'] == 'PRODUCTION'?0:1):1;
			$toret = array(
					'error' => $errors[$errorLevel]	
			);
		} else {
			$execPath = $image->getImageMagickPath();
			if (!isset($_SESSION['Widgets.Gallery']['config']['ExecPath'])) {
				$_SESSION['Widgets.Gallery']['config']['ExecPath'] = $execPath;
			}
			$thumbSizeArr = getimagesize($folderName . $GLOBALS['GAL_thumbnail_folder'] . $fullThumbnailName);
			$toret['thumbnail'] = array(
				'name' => $GLOBALS['GAL_thumbnail_folder'] . $fullThumbnailName, 
				'width' => $thumbSizeArr[0], 
				'height' => $thumbSizeArr[1]
			);
		}
		return $toret;
	}

	function getPhotoList() {
		if (!isset($this->config['photo_folder'])) {
			$arr = array(
				'error' => 'Photo folder is not set. Please check to see if you have cookies enabled.'
			);
			return $arr;
		}
		$folderName = KT_RealPath($this->config['photo_folder'], true);
		$thumb_path = $folderName . $GLOBALS['GAL_thumbnail_folder'];
		
		$folder = new KT_folder();
		$arr = $folder->readFolder($folderName, true); 
		if ($folder->hasError()) {
			$errors = $folder->getError();
			$errorLevel = !empty($GLOBALS['tNG_debug_mode'])?($GLOBALS['tNG_debug_mode'] == 'PRODUCTION'?0:1):1;
			$toret['error'] = $errors[$errorLevel];	
			return $toret;
		}

		$ret = array();
		foreach ($arr['files'] as $key => $value) {
			$fullFileName = $folderName . $value['name'];
			$info = KT_pathinfo($fullFileName);
			
			if (GAL_isImage($fullFileName)) {
				$fullThumbnailName = $info['filename'].'_'.$this->config['thumbnails']['width'].'x'.$this->config['thumbnails']['height'].'.'.$info['extension'];
				$imageDetails = GAL_getImageInfo($folderName, $value['name']);
				clearstatcache();
				if ($imageDetails['dateLastModified'] != @filemtime($folderName . $value['name'])) {
					GAL_deleteThumbnails($folderName, $value['name']);
					GAL_getImageInfo($folderName, $value['name']);
				}
				# if this image has a thumbnail already.
				if (!file_exists($thumb_path . $fullThumbnailName)) {
					$value['thumbnail'] = NULL;
				} else {
					ob_start();
					$thumbSizeArr = getimagesize($folderName . $GLOBALS['GAL_thumbnail_folder'] . $fullThumbnailName);
					$error = ob_get_contents();
					ob_end_clean();
					if (is_array($thumbSizeArr)){
							$value['thumbnail'] = array(
								'name' => $GLOBALS['GAL_thumbnail_folder'] . $fullThumbnailName, 
								'width' => $thumbSizeArr[0], 
								'height' => $thumbSizeArr[1]
							);
					}else{
							$value['thumbnail'] = array('error' => $error);
					}
				}
				if (is_readable($fullFileName)){
					$imageSizeArr = getimagesize($fullFileName);
					$value['width'] = $imageSizeArr[0];
					$value['height'] = $imageSizeArr[1];
				}else{
					$value['error'] = 'The '.$fullFileName. ' is not readable';
				}
				$ret[] = $value;
			} 
		}
		return $ret;
	}

	function setMetaSource($path) {
		$this->metaSource = KT_DynamicData($path, null);
	}
	function setPictureNode($xpath) {
		$this->pictureNode = $xpath;
	}
	function setDescriptionNode($xpath) {
		$this->descriptionNode = $xpath;
	}
}
?>
