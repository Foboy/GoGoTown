
<?php
print_r($_FILES);
 $uploaddir = 'F:/test/';
$uploadfile = $uploaddir .time().'.'.$_FILES['file']['type'] ;
if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
	echo "File is valid, and was successfully uploaded.\n";
} else {
	echo "Possible file upload attack!\n";
}

echo 'Here is some more debugging info:'; 
?>