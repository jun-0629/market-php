<?php
	session_start();
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$name = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['img_select'])? $_POST['img_select'] : ''));
	
	if(strlen($name) <= 0 || $name === "none"){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	unlink('../../img/slider/'.$name);
	$sql = "DELETE FROM `banner` WHERE name = '{$name}'";
	$connect->query($sql) or die();

	$sql = "select name from banner ORDER BY img_order ASC";
	$res = $connect->query($sql) or die();
	$i = 0;
	if(mysqli_num_rows($res)){
		while($data = mysqli_fetch_array($res)){
			$i++;
			$change_sql = "UPDATE `banner` SET img_order={$i} WHERE name='{$data['name']}'";
			$connect->query($change_sql) or die();
		}
	}
	die("<script>location.href='banner_delete.php'; alert('{$name}를 제거했습니다.');</script>");
?>