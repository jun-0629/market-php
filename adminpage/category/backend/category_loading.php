<?php
	session_start();
	include "../../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$loading_key = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_loading_key'])? $_POST['category_loading_key'] : ''));
	
	if(strlen($loading_key) > 0){
		if($loading_key == "none"){
			$sql = "SELECT * from category where char_length(category_key) = 2 ORDER BY category_key ASC";
		}else{
			$key_length = strlen($loading_key)+2;
			$sql = "SELECT * from category where category_key like '{$loading_key}%' and char_length(category_key) = {$key_length} ORDER BY category_key ASC";
		}
		$res = $connect->query($sql) or die();
		while($data = mysqli_fetch_array($res)){
			$id = "a".$data['id'];
			$arr[$id] = $data['category_name'];
		}
		echo json_encode($arr);
	}else{
		die("<script>location.href='../category_change.php'; alert('잘못된 접근입니다.');</script>");
	}
?>