<?php
	session_start();
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$name = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['delete_img'])? $_POST['delete_img'] : ''));
	
	if(strlen($name) <= 0 || $name === "none"){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}
	
	unlink('../../img/popup/'.$name);
	$sql = "DELETE FROM popup WHERE name = '{$name}'";
	$connect->query($sql) or die();

	die("<script>location.href='popup_delete.php'; alert('팝업 {$name}를 제거했습니다.');</script>");
?>