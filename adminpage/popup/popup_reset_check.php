<?php
	session_start();
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$name = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['reset_img'])? $_POST['reset_img'] : ''));
	$url = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['url'])? $_POST['url'] : ''));
	$mobile = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['mobile'])? $_POST['mobile'] : ''));


	if(strlen($name) <= 0 || $name === "none"){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$mobile = $mobile==="on"?1:'null';
	$sql = "UPDATE popup SET url='{$url}',mobile={$mobile} WHERE name='{$name}'";
	$connect->query($sql) or die();

	die("<script>location.href='popup_reset.php'; alert('[name:{$name}] 팝업을 수정했습니다.');</script>");
?>