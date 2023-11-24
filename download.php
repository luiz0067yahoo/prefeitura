<?php
if(isset($_GET["file"])){
	$file_url=str_replace("../", "",str_replace("../", "",$_GET["file"]));
	try{
		$base_url=realpath(".");
		$extenssions_exec = array("php", "ini", "htacess", "cgi","sh","bin","asp","bat","dll","so","exe","msi","jar","class","asp","sql","css","js","html"); 
		$extension_file=strtolower(pathinfo($base_url.DIRECTORY_SEPARATOR.$file_url)['extension']);
		$file_name_=pathinfo($base_url.DIRECTORY_SEPARATOR.$file_url)['filename'];
		$extension_found=in_array($extension_file, $extenssions_exec);
		$full_path=$base_url.DIRECTORY_SEPARATOR.$file_url;
		echo $base_url.DIRECTORY_SEPARATOR.$file_url;
		if(!$extension_found){
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.$file_name_.".".$extension_file.'"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($full_path));
			ob_clean();
			flush();
			readfile($full_path);
			exit();
		}
	}
	catch (Exception $e) {}
}
?>