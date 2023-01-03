<?php
	session_start();
	include_once "../tool/connect_db.php";

	if(strpos($_SERVER["HTTP_REFERER"], "login/login.php") === false){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	if(isset($_SESSION["admin"])){
		die("<script>location.href='../index.php'; alert('이미 로그인이 되어 있습니다.');</script>");
	}

	$id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['id'])? $_POST['id'] : ''));
	$password = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['password'])? $_POST['password'] : ''));

	if(strlen($id) <= 0 || strlen($password) <= 0){
		die("<script>location.href='login.php'; alert('아이디 혹은 비밀번호를 입력해주세요.');</script>");
	}

	$sql = "select password from admin where id= '{$id}'";
	$res = $connect->query($sql) or die();

	if(mysqli_num_rows($res) !== 1){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	if (!password_verify($password, mysqli_fetch_array($res)['password'])){
		die("<script>location.href='login.php'; alert('아이디 또는 비밀번호가 틀렸습니다.');</script>");
	}

	$_SESSION['admin'] = $id;
	echo "<script>location.href='../index.php';</script>";
?>