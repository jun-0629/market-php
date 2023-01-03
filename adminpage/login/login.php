<?php
	session_start();

	include_once "../tool/basic_data.php";

	if(isset($_SESSION["admin"])){
		die("<script>location.href='../index.php'; alert('이미 로그인이 되어 있습니다.');</script>");
	}
?>

<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<link rel="stylesheet" href="../css/login.css">
	<script src="../js/login.js" defer></script>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>
<body>
	<div class="login">
		<div class="top_img">
			<img src="../../img/main_img/log.svg">
		</div>
		<form action="login_check.php" method="post" name="login_send">
			<ul>
				<li>
					<input onkeydown="enter_event()" name="id" type="text" placeholder="아이디">
				</li>
				<li>
					<input onkeydown="enter_event()" name="password" type="password" placeholder="비밀번호" autocomplete="off">
				</li>
				<li>
					<button onclick="login_event()" type="button">로그인</button>
				</li>
			</ul>
		</form>
	</div>
</body>
</html>