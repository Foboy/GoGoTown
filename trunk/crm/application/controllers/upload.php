<?php
class UpLoad extends Controller {
	/**
	 * 图片操作等级相关操作
	 */
	public function __construct() {
		parent::__construct ();
		
		// VERY IMPORTANT: All controllers/areas that should only be usable by logged-in users
		// need this line! Otherwise not-logged in users could do actions. If all of your pages should only
		// be usable by logged-in users: Put this line into libs/Controller->__construct
		// Auth::handleLogin();
	}
	/**
	 * 上传图片 输出参数：图片保存名称
	 */
	public function UpLoadImage() {
		$targetFolder = '/GoGoTown/trunk/crm/admin/upload'; // Relative to the root
		if (! empty ( $_FILES )) {
			$tempFile = $_FILES ['Filedata'] ['tmp_name'];
			$targetPath = $_SERVER ['DOCUMENT_ROOT'] . $targetFolder;
			if (! file_exists ( $targetPath )) {
				mkdir ( $_SERVER ['DOCUMENT_ROOT'] . $targetFolder );
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
				move_uploaded_file ( $tempFile, $targetFile );
			    echo $fileName; 
			} else {
				echo 'Invalid file type.';
			}
			
            //$url="http://localhost:8080/GoGoTown/trunk/crm/app.php";
			/* $data = array(
					'filepath'  => @$targetFile,
					'filename'=>@$fileName
			); */
            //$cfile = new CURLFile($targetFile,$fileParts ['extension'],'name');
            //$data= array(
            //    'id'=>123,
            //    'file'=>$cfile
            //);
            //UpLoad::uploadByCURL($data,$url);
		}
	}
	
	/**
	 * 修整图片
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
	 * 保存截屏图片
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
	
	/* 手动post提交 */
	private function uploadByCURL($post_data, $post_url) {
		$curl = curl_init ();
		curl_setopt ( $curl, CURLOPT_URL, $post_url );
		curl_setopt ( $curl, CURLOPT_POST, 1 );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post_data );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $curl, CURLOPT_USERAGENT, "Mozilla/5.0" );
		$result = curl_exec ( $curl );
		$error = curl_error($curl);
		print_r($result);
	}
}