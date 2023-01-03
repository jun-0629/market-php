<?php
	include_once "../tool/connect_db.php";
	$find_type = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['find_type'])? $_POST['find_type'] : ''));
	$name = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['name'])? $_POST['name'] : ''));
	$data_type = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['data_type'])? $_POST['data_type'] : ''));
	
	if(
		!($find_type === "email" || $find_type === "hand_phone") ||
		strlen($name) <= 0 ||
		strlen($data_type) <= 0
	){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	if($find_type === "email"){
		if(preg_match("/^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i", $data_type)){
			$sql = "SELECT id, join_date FROM member where name='{$name}' AND email='{$data_type}'";
		}else{
			die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
		}
	}else if($find_type === "hand_phone"){
		if(strlen($data_type) === 13){
			$sql = "SELECT id, join_date FROM member where name='{$name}' AND hand_phone='{$data_type}'";
		}else{
			die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
		}
	}

	$res = $connect->query($sql) or die();

	$arr = array();
	$count = 0;
	while($data = mysqli_fetch_array($res)){
		$count++;
		$arr[$count]["id"] = substr($data['id'], 0, -4) . "****";
		$arr[$count]["join_date"] = explode(' ', $data['join_date'])[0];
	}
	
	echo json_encode($arr);
?>