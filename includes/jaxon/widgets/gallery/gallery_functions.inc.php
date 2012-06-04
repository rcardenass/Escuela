<?php

	$GAL_thumbnail_folder = 'thumbnails/';

	function GAL_isImage($n) {
        $arr = @getimagesize($n);
		if (is_array($arr)) {
            if (strpos($n,'.') !== false) {
                $ext = explode('.',$n);
                $ext = array_pop($ext);
            } else {
                $ext = '';
            }
            return in_array(strtolower($ext), array('gif','xbm','png','jpeg','jpg','jpe','jfif','tiff','tif','bmp'));
		} else {
			return false;
		}
	}

	function GAL_getImageInfo($folder, $file) {
		$thumbFolder = $folder . $GLOBALS['GAL_thumbnail_folder'];
		$fileName = $file . '.meta';
		$ret = array();
		$ret['dateLastModified'] = -1;
		
		clearstatcache();
		if (!file_exists($thumbFolder . $fileName)) {
			$dateLastModified = @filemtime($folder . $file);
			$f = @fopen($thumbFolder . $fileName, 'wb');
			if (is_resource($f)) {
				fwrite($f, $dateLastModified);
				fclose($f);
			}
			$ret['dateLastModified'] = $dateLastModified;
		} else {
			$f = @fopen($thumbFolder . $fileName, 'rb');
			if (is_resource($f)) {
				$dateLastModified = trim(@fread($f, filesize($thumbFolder . $fileName)));
				fclose($f);
			}
			$ret['dateLastModified'] = $dateLastModified;
		}
		flush();
		return $ret;
	}

	/**
	 * Delete the thumbnails of an image.
	 * @param string $folder absolute path of the folder which contains the image
	 * @param string $file the image file name
	 * @return nothing
	 * @access public
	 */
	function GAL_deleteThumbnails($folder, $oldName) {
		$thumbFolder = $folder . $GLOBALS['GAL_thumbnail_folder'];
		if ($oldName != '') {
			$path_info = KT_pathinfo($oldName);
			$regexp = '/'.preg_quote($path_info['filename'],'/').'_\d+x\d+';
			if ($path_info['extension'] != "") {
				$regexp	.= '\.'.preg_quote($path_info['extension'],'/');
			}
			$regexp	.= '/';
			
			$folderObj = new KT_folder();
			$entry = $folderObj->readFolder($thumbFolder, false); 
			if (!$folderObj->hasError()) {
				foreach($entry['files'] as $key => $fDetail) {
					if (preg_match($regexp, $fDetail['name'])) {
						@unlink($thumbFolder . $fDetail['name']);
					}
				}
			}
			GAL_deleteImageInfo($folder, $oldName);
		}
	}

	/**
	 * Delete the informations file of an image.
	 * @param string $folder absolute path of the folder which contains the image
	 * @param string $file the image file name
	 * @return nothing
	 * @access public
	 */
	function GAL_deleteImageInfo($folder, $file) {
		$thumbFolder = $folder . $GLOBALS['GAL_thumbnail_folder'];
		$fileName = $file . '.meta';
		@unlink($thumbFolder . $fileName);
	}

?>