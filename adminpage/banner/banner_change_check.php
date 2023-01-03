<?php
	session_start();
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$arr = isset($_POST['change'])? json_decode($_POST['change'], true) : '';
	
	if(!is_array($arr) || !count($arr)){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	foreach ($arr as $key => $value) {
		$i = $key+1;
		$change_sql = "UPDATE `banner` SET img_order={$i} WHERE name='{$value}'";
		$connect->query($change_sql) or die();
	}
	echo "success";
?>