<?php
	include_once "../tool/basic_data.php";
	$return_url = isset($_GET["return_url"]) ? $_GET["return_url"] : "";
	if(strlen($return_url) > 0){
		$return_url = "?return_url={$return_url}";
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
	<?php echo $server_head; ?>
	<script src="../js/login.js" defer></script>
</head>
<body>
	<?php include "../tool/header.php"; ?>
	<div class="main">
		<div class="login_view">
			<h2>로그인</h2>
			<form action="login_check.php<?php echo $return_url; ?>" name="login" method="post">
				<input onkeydown="enter_login()" type="text" name="id" placeholder="아이디">
				<div class="id_check_text"></div>
				<input onkeydown="enter_login()" type="password" name="password" placeholder="비밀번호" autocomplete="off">
				<div class="password_check_text"></div>
				<button onclick="login_check()" class="login_btn" type="button">로그인</button>
			</form>
			<ul class="login_sub_function">
				<li>
					<a href="../signup/join.php">회원가입</a>
				</li>
				<li>
					<a href="../find/find_id.php">아이디 찾기</a>
				</li>
				<li>
					<a href="../find/find_password.php">비밀번호 찾기</a>
				</li>
			</ul>
		</div>
		<div class="order_meeting">
			<h3>비회원주문 / 주문조회</h3>
			<p>주문자명과 주문번호를 아래에 입력해주세요.</p>
			<table class="order_info_table">
				<tr>
					<td>
						<div>
							<span>주문자명</span>
							<input type="text">
						</div>
						<div>
							<span>주문번호</span>
							<input type="text">
						</div>
						<div>
							<span>비밀번호</span>
							<input type="password" autocomplete="off">
						</div>
					</td>
					<td>
						<button type="button">확인</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<?php include "../tool/footer.php"; ?>
</body>
</html>