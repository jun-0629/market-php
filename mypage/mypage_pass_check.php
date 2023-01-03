<?php
	session_start();
	include_once "../tool/connect_db.php";

	$back_page = explode("/", $_SERVER["HTTP_REFERER"]);
	$back_page = $back_page[count($back_page)-2]."/".$back_page[count($back_page)-1];

	$check_password = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['check_password'])? $_POST['check_password'] : ''));

	if(!isset($_SESSION["member"]) || $back_page != "mypage/mypage_pass.php" || strlen($check_password) <= 0 || isset($_SESSION['password_revalidation_token'])){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$sql = "select password from member where id = '{$_SESSION['member']}'";
	$res = $connect->query($sql) or die();

	if(mysqli_num_rows($res) != 1){
		die("<script>location.href='../login/logout.php'; alert('잘못된 접근입니다.');</script>");
	}

	$password = mysqli_fetch_array($res)["password"];
	if (password_verify($check_password, $password)){
		$_SESSION['password_revalidation_token'] = "changing:s5a6q2x532q!wenk23d5c2@a*3w2xc1vajkk84:information";
		die("<script>location.href='changing_information.php';</script>");
	}else{
		die("<script>location.href='mypage_pass.php'; alert('비밀번호가 틀렸습니다.');</script>");
	}
?>