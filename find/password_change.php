<?php
	session_start();
	include_once "../tool/connect_db.php";

	$id = isset($_SESSION['password_find_id']) ? $_SESSION['password_find_id'] : '';
	$name = isset($_SESSION['password_find_name']) ? $_SESSION['password_find_name'] : '';
	$data_info = isset($_SESSION['password_find_data']) ? $_SESSION['password_find_data'] : '';
	$password = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['password'])? $_POST['password'] : ''));
	$password_check = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['password_check'])? $_POST['password_check'] : ''));
	$back_page = explode("/", $_SERVER["HTTP_REFERER"]);
	$back_page = $back_page[count($back_page)-2]."/".$back_page[count($back_page)-1];
	
	if(
		isset($_SESSION['authentication_time']) || 
		isset($_SESSION['authentication_key']) || 
		isset($_SESSION['authentication_error']) || 
		$back_page != "find/password_reset.php" || 
		!isset($_SESSION['password_find_token']) || 
		$_SESSION['password_find_token'] != "change:das1d98q5amd321q354wq75f4asp4a2q:password" || 
		strlen($id) <= 0 || 
		strlen($name) <= 0 ||
		strlen($data_info) <= 0 || 
		strlen($password) <= 0 || 
		strlen($password_check) <= 0 ||
		!($password === $password_check) ||
		!preg_match("/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/", $password)
	){
		unset_session();
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	if(preg_match("/^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i", $data_info)){
		$sql = "select id from member where id='{$id}' and name='{$name}' and email='{$data_info}'";
		$data_code = "email='{$data_info}'";
	}else if(preg_match("/^(010|011|016|017|018|019)-[0-9]{4}-[0-9]{4}$/", $data_info)){
		$sql = "select id from member where id='{$id}' and name='{$name}' and hand_phone='{$data_info}'";
		$data_code = "hand_phone='{$data_info}'";
	}else{
		unset_session();
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$res = $connect->query($sql) or die();
	if(mysqli_num_rows($res) != 1){ //데이터베이스에 유저가 존재하는지 확인
		unset_session();
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$encrypted_passwd = password_hash($password, PASSWORD_DEFAULT);
	$sql = "UPDATE member SET password = '{$encrypted_passwd}' WHERE id = '{$id}' AND name = '{$name}' AND {$data_code};";
	$connect->query($sql) or die();
	unset_session();
	echo "<script>alert('비밀번호가 변경되었습니다.');location.href='../login/login.php';</script>";

	function unset_session(){ //잘못된 접근으로 인한 세션 제거 함수
		unset($_SESSION['password_find_token']);
		unset($_SESSION['authentication_time']);
		unset($_SESSION['authentication_key']);
		unset($_SESSION['password_find_id']);
		unset($_SESSION['password_find_name']);
		unset($_SESSION['password_find_data']);
		unset($_SESSION['authentication_error']);
	}
?>