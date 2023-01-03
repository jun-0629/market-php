<?php
	include_once "../tool/basic_data.php";
	if(!isset($_SESSION["member"])){
		$return_url =  openssl_encrypt("../mypage/mypage_pass.php", 'aes-256-cbc', "login_return_url", false, str_repeat(chr(0), 16));
		die("<script>location.href='../login/login.php?return_url={$return_url}'; alert('로그인 후 이용해 주세요.');</script>");
	}
?>

<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<?php echo $server_head; ?>
	<link rel="stylesheet" href="../css/mypage_pass.css">
	<script src="../js/mypage_pass.js" defer></script>
</head>
<body>
	<?php include "../tool/header.php"; ?>
	<div class="pass_check">
		<h1>회원정보수정</h1>
		<h2>비밀번호 재확인</h2>
		<p>회원님의 개인 정보 보안을 위해 비밀번호를 다시 한번 입력해 주세요.</p>
		<div class="info_view">
			<div class="width_length">
				<div class="data_view">
					<span>아이디</span>
					<span class="text_color"><?php echo $_SESSION["member"]; ?></span>
				</div>
				<div class="data_view">
					<span>비밀번호</span>
					<span>
						<form action="mypage_pass_check.php" method="post" name="pass_check_form">
							<input type="password" autocomplete="off" name="check_password">
						</form>
					</span>
				</div>
				<div class="text_div">회원님의 개인 정보 보안을 위해 비밀번호를 다시 한번 입력해 주세요.</div>
				<div class="button_view">
					<button onclick="pass_check()" type="button">확인</button>
				</div>
			</div>
		</div>
	</div>
	<?php include "../tool/footer.php"; ?>
</body>
</html>