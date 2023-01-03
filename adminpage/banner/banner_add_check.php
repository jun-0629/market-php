<?php
	session_start();
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}
	
	if(!is_array($_FILES["image"]) || count($_FILES) !== 1){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}
	
	$filename = $_FILES['image']['name'];
	$tmpfile = $_FILES['image']['tmp_name'];
	$filename_ext = explode('.',$filename)[count(explode('.',$filename))-1];
	$allow_file = array("jpg", "png", "bmp", "gif");
	$maxsize = 1024*1024;
	
	if(in_array($filename_ext, $allow_file)) {
		if(filesize($tmpfile) <= $maxsize){
			$count_sql = "select img_order from banner";
			$count_res = $connect->query($count_sql) or die();
			$count = mysqli_num_rows($count_res)+1;

			$change_name = date("YmdHis").mt_rand().".".$filename_ext;
			$file_path= "../../img/slider/{$change_name}";
			move_uploaded_file($tmpfile, $file_path);
			$resize_file = getimagesize($file_path);
			if($resize_file["mime"] == 'image/png'){
				$image = imagecreatefrompng($file_path);
			}else if($resize_file["mime"] == "image/gif"){
				$image = imagecreatefromgif($file_path);
			}else{
				$image = imagecreatefromjpeg($file_path);
			}
			imagejpeg($image, $file_path, 90);
			$sql_img = "insert into banner(img_order, name)";
			$sql_img .= " values ({$count}, '{$change_name}')";
			$connect->query($sql_img) or die();
			die("<script>location.href='banner.php'; alert('배너 이미지를 추가했습니다.');</script>");
		}else{
			die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
		}
	}else{
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}
?>