<?php
	session_start();
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['id'])? $_POST['id'] : '')); //상품 ID
	$password = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['password'])? $_POST['password'] : '')); //비밀번호
	if(strlen($id) <= 0 || strlen($password) <= 0){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$goods_sql = "select id from goods where id = {$id} and deleted_or_not=0";
	$goods_res = $connect->query($goods_sql) or die();
	if(!mysqli_num_rows($goods_res)){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$admin_sql = "select password from admin where id = '{$_SESSION["admin"]}'";
	$admin_res = $connect->query($admin_sql);

	if(mysqli_num_rows($admin_res) !== 1){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	if (!password_verify($password, mysqli_fetch_array($admin_res)['password'])){
		die("wrong password");
	}

	$delete_sql = "DELETE FROM goods_option WHERE goods_id = {$id}";
	$connect->query($delete_sql) or die();

	$change_sql = "UPDATE goods SET deleted_or_not=1 WHERE id = {$id}";
	$connect->query($change_sql) or die();

	die("success");
?>