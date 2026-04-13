<?php
	$dir = $_POST['path'];
	//echo $dir;
	//echo "file execute";

	$filename = $_FILES['file']['name'];
	$file_new_name="";
	if($filename!=''){
		$fl = $dir . $filename;
		if(file_exists($fl)) {			
			$file_extension=explode('.',$filename);
			$index=count($file_extension)-1;
			$random_id = mt_rand(1,99);
			$file = explode(".",$filename);
			$file_name = $file[0].$random_id;
			//echo $file_name;
			//echo "W";
			$changed_file_name = $file_name;
			//echo $changed_file_name;
			$file_new_name=$changed_file_name.".".$file_extension[$index];
			$new_file_with_dir=$dir.$file_new_name;
			//echo $file_new_name;
			//rename($fl, $new_file_with_dir);
			move_uploaded_file($_FILES["file"]["tmp_name"], $new_file_with_dir);
			echo $file_new_name;
		} else {
			move_uploaded_file($_FILES["file"]["tmp_name"], $fl);
			echo $filename;
		}
	}
	
?>