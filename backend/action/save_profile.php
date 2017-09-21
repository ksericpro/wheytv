<?php
//Save Uploaded Image

$image_field_name = 'file';
$image_max_size = 200000; //2M
try
{
	//Process other fields
	$display_name = $_POST['displayname'];
	$first_name = $_POST['firstname'];
	$last_name = $_POST['lastname'];
	$email = $_POST['newuseremail'];
	$password = $_POST['password1'];
	
	$json_normal = ',"displayname":"'.$display_name.'", "firstname":"'.$first_name.'", "lastname":"'.$last_name.
					'", "email":"'.$email.'", "password":"'.$password.'"';
	
	// Undefined | Multiple Files | $_FILES Corruption Attack
	// If this request falls under any of them, treat it invalid.
	$process_profile_image = true;
	
	if (!isset($_FILES[$image_field_name]['error']) ||
		is_array($_FILES[$image_field_name]['error'])) 
	{
		//throw new RuntimeException('Invalid parameters.');
		$process_profile_image = false;
	}
	
	if (!$process_profile_image) {
		echo '{"result":"ok", "filename":"", "remarks":"no profile image"'.
			 $json_normal.'}';
	}
    else {
		// Check $_FILES[$image_field_name]['error'] value.
		switch ($_FILES[$image_field_name]['error']) {
			case UPLOAD_ERR_OK:
				break;
			case UPLOAD_ERR_NO_FILE:
				throw new RuntimeException('No file sent.');
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				throw new RuntimeException('Exceeded filesize limit.');
			default:
				throw new RuntimeException('Unknown errors.');
		}
	
		// You should also check filesize here. 
		if ($_FILES[$image_field_name]['size'] > $image_max_size) {
			throw new RuntimeException('Exceeded filesize limit of '.$image_max_size);
		}

		// DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
		// Check MIME Type by yourself.
		$finfo = new finfo(FILEINFO_MIME_TYPE); //fileinfo.so must be enable in php.ini
		if (false === $ext = array_search(
			$finfo->file($_FILES[$image_field_name]['tmp_name']),
			array(
				'jpg' => 'image/jpeg',
				'png' => 'image/png',
				'gif' => 'image/gif',
			),
			true
		)) {
			throw new RuntimeException('Invalid file format.');
		}
	
		//Move uploaded file to target
		$target_path = $_SERVER["DOCUMENT_ROOT"]."/wheytv/uploads/";
		$ext = end((explode(".", basename( $_FILES[$image_field_name]['name']))));
		$filename = sprintf('%s.%s',
						sha1_file($_FILES[$image_field_name]['tmp_name']),
						$ext
						);
		$target_fullpath = $target_path.$filename;

		if(move_uploaded_file($_FILES[$image_field_name]['tmp_name'], $target_fullpath)) {
			echo '{"result":"ok", "filename":"'.$filename.'"'.$json_normal.'}';
		} else{
			throw new RuntimeException('Failed to move uploaded file '.$_FILES[$image_field_name]['name']);
		}
	
	}

} catch (RuntimeException $e) {
    echo $e->getMessage();
}
?>