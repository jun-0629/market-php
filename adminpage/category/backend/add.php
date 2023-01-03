<?php
	session_start();
	include "../../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$add_category_name = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['add_name'])? $_POST['add_name'] : ''));
	$category_1 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_1'])? $_POST['category_1'] : ''));
	$category_2 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_2'])? $_POST['category_2'] : ''));
	$category_3 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_3'])? $_POST['category_3'] : ''));
	if(strlen($category_1) == 0 || strlen($category_2) == 0 || strlen($category_3) == 0){
		die("<script>location.href='../category_add.php'; alert('잘못된 접근입니다.');</script>");
	}else if(strlen($add_category_name) == 0){
		die("<script>location.href='../category_add.php'; alert('카테고리 이름을 입력해주세요.');</script>");
	}

	if($category_1 == "none"){
		$sql_where = "CHAR_LENGTH(category_key) = 2";
		$key_start = "";
	}else if($category_2 == "none"){
		$sql_where = "category_key like '{$category_1}%' AND CHAR_LENGTH(category_key) = 4";
		$key_start = $category_1;
	}else if($category_3 == "none"){
		$sql_where = "category_key like '{$category_2}%' AND CHAR_LENGTH(category_key) = 6";
		$key_start = $category_2;
	}else{
		die("<script>location.href='../category_add.php'; alert('최대 3단까지만 가능합니다.');</script>");
	}

	$sql = "SELECT category_key FROM category WHERE {$sql_where}";
	$res = $connect->query($sql) or die();

	if(mysqli_num_rows($res) < 10){
		$key = $key_start.'0'.mysqli_num_rows($res)+1;
	}else{
		$key = $key_start.mysqli_num_rows($res)+1;
	}

	if(isset($key) && strlen($key) > 1 && isset($add_category_name)){
		$sql_add = "insert into category(category_key, category_name)";
		$sql_add .= " values ('{$key}', '{$add_category_name}')";
		$connect->query($sql_add) or die();
		echo "<script>location.href='../category_add.php'; alert('추가 했습니다.');</script>";
	}
?>