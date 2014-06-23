<?php
class UpLoad extends Controller {
	/**
	 * 鍥剧墖鎿嶄綔绛夌骇鐩稿叧鎿嶄綔
	 */
	public function __construct() {
		parent::__construct ();
		
		// VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
		// need this line! Otherwise not-logged in users could do actions. If all of your pages should only
		// be usable by logged-in users: Put this line into libs/Controller->__construct
		// Auth::handleLogin();
	}
	/**
	 * 涓婁紶鍥剧墖 杈撳嚭鍙傛暟锛氬浘鐗囦繚瀛樺悕绉�
	 */
	public function UpLoadImage() {
		$targetFolder = '/crm/admin/upload'; // Relative to the root
		if (! empty ( $_FILES )) {
			$tempFile = $_FILES ['Filedata'] ['tmp_name'];
			$targetPath = $_SERVER ['DOCUMENT_ROOT'] . $targetFolder;
			if (!file_exists ( $targetPath )) {
				mkdir ($targetPath);
			}
			$fileName = time () . $_FILES ['Filedata'] ['name'];
			$targetFile = rtrim ( $targetPath, '/' ) . '/' . $fileName;
			// Validate the file type
			$fileTypes = array (
					'jpg',
					'jpeg',
					'gif',
					'png' 
			); // File extensions
			$fileParts = pathinfo ( $_FILES ['Filedata'] ['name'] );
			if (in_array ( $fileParts ['extension'], $fileTypes )) {
				if(move_uploaded_file ( $tempFile, iconv ( 'UTF-8', 'gb2312', $targetFile ) )){
					
					$src = realpath (iconv ( 'UTF-8', 'gb2312', $targetFile ));
					$url = "http://192.168.0.47/Api32/GoCurrency/uploadImg";
					$data = array (
							'file' => '@' . $src ,
							'fileObjName'=>'file'
					);
					UpLoad::UploadByCURL ( $data, $url ); 
				}
			} else {
				echo 'Invalid file type.';
			}
			
			/*php 5.5 $cfile = new CURLFile ( $targetFile, $fileParts ['extension'], 'name' );
			$data = array (
					'file' => $cfile 
			); */
		}
	}
	
	/**
	 * 淇暣鍥剧墖
	 */
	public function ResizeImage() {
		$filename = $_POST ['filename'];
		$src = $_SERVER ['DOCUMENT_ROOT'] . '/GoGoTown/trunk/crm/admin/upload/' . $filename;
		$imageSize = getimagesize ( $src );
		if ($imageSize [0] > 300 || $imageSize [1] > 300) {
			$jpeg_quality = 90;
			if ($imageSize [0] > $imageSize [1]) {
				$targ_w = 500;
				$scale = $targ_w / $imageSize [0];
				$targ_h = $imageSize [1] * $scale;
			} else {
				$targ_h = 500;
				$scale = $targ_h / $imageSize [1];
				$targ_w = $imageSize [0] * $scale;
			}
			
			$img_r = imagecreatefromjpeg ( $src );
			$dst_r = ImageCreateTrueColor ( $targ_w, $targ_h );
			imagecopyresampled ( $dst_r, $img_r, 0, 0, 0, 0, $targ_w, $targ_h, $imageSize [0], $imageSize [1] );
			imagejpeg ( $dst_r, $src, $jpeg_quality );
		}
	}
	
	/**
	 * 淇濆瓨鎴睆鍥剧墖
	 */
	public function SaveScreenshotImage() {
		$targ_w = $targ_h = 150;
		$jpeg_quality = 90;
		$filename = $_POST ['filename'];
		$src = 'upload/' . $filename;
		/*
		 * $start = strrpos($filename,'.'); $length = strlen($filename); $dst = substr($filename, 0,$length-$start);
		 */
		$dst = 'upload/' . time () . '.jpg';
		$img_r = imagecreatefromjpeg ( $src );
		$dst_r = ImageCreateTrueColor ( $targ_w, $targ_h );
		
		imagecopyresampled ( $dst_r, $img_r, 0, 0, $_POST ['x'], $_POST ['y'], $targ_w, $targ_h, $_POST ['w'], $_POST ['h'] );
		
		imagejpeg ( $dst_r, $dst, $jpeg_quality );
		header ( "Content-type:image/jpeg" );
		imagejpeg ( $dst_r );
		imagedestroy ( $dst_r );
	}
	
	/* 鎵嬪姩post鎻愪氦 */
	private function UploadByCURL($post_data, $post_url) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $post_url );
		curl_setopt ( $curl, CURLOPT_POST, 1 );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post_data );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $curl, CURLOPT_USERAGENT, "Mozilla/5.0" );
		$result = curl_exec ( $curl );
		$error = curl_error ( $curl );
		curl_close ( $curl );
		print_r($result);
	}
}