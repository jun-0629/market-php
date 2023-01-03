<?php
	session_start();
	include_once "../tool/connect_db.php";

	if(strpos($_SERVER["HTTP_REFERER"], "login/login.php") === false){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['id'])? $_POST['id'] : ''));
	$password = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['password'])? $_POST['password'] : ''));

	$return_url = isset($_GET["return_url"]) ? $_GET["return_url"] : "";
	if(strlen($return_url) > 0){
		$url = openssl_decrypt($return_url, 'aes-256-cbc', "login_return_url", false, str_repeat(chr(0), 16));
		$return_url_check = "?return_url={$return_url}";
	}else{
		$url = "../index.php";
	}

	if(strlen($id) > 0 && strlen($password) > 0){
		if(!isset($_SESSION['member'])){
			$sql = "SELECT password FROM member WHERE id = '{$id}'";
			$res = $connect->query($sql) or die();
			if(mysqli_num_rows($res) === 1){
				if (password_verify($password, mysqli_fetch_array($res)['password'])){
					$_SESSION['member'] = $id;
					echo "<script>location.href='{$url}';</script>";
				}else{
					die("<script>location.href='login.php{$return_url_check}'; alert('아이디 또는 비밀번호가 틀렸습니다.');</script>");
				}
			}else{
				die("<script>location.href='login.php{$return_url_check}'; alert('아이디 또는 비밀번호가 틀렸습니다.');</script>");
			}
		}else{
			die("<script>location.href='{$url}'; alert('이미 로그인이 되어있습니다.');</script>");
		}
	}else{
		die("<script>location.href='login.php{$return_url_check}'; alert('아이디 혹은 비밀번호를 입력해 주세요.');</script>");
	}
?>