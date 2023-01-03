<?php
	session_start();
	include "../../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}
	
	$key = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_key'])? $_POST['category_key'] : ''));

	if(strlen($key) == 2 || strlen($key) == 4){
		$num = strlen($key)+2;
	
		$sql = "SELECT * FROM category WHERE category_key like '{$key}%' AND CHAR_LENGTH(category_key) = {$num} ORDER BY category_key ASC;";
		$res = $connect->query($sql) or die();
		while ($data = mysqli_fetch_array($res)) {
			$arr[$data["category_key"]] = $data["category_name"];
		}
		echo json_encode($arr);
	}else{
		die("<script>location.href='../category_add.php'; alert('잘못된 접근입니다.');</script>");
	}
?>