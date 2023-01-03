<?php
	include_once "../tool/basic_data.php";
	unset($_SESSION['password_find_token']);
	unset($_SESSION['authentication_time']);
	unset($_SESSION['authentication_key']);
	unset($_SESSION['password_find_id']);
	unset($_SESSION['password_find_name']);
	unset($_SESSION['password_find_data']);
	unset($_SESSION['authentication_error']);
?>

<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<script src="../js/find.js" defer></script>
	<script src="../js/find_password.js" defer></script>
	<?php echo $server_head; ?>
	<link rel="stylesheet" href="../css/find.css">
</head>
<body>
	<?php include "../tool/header.php"; ?>
	<div class="find">
		<h1>비밀번호 찾기</h1>
		<div class="find_view">
			<ul>
				<form action="certification.php" method="post" name="find_password_form">
					<li class="text_center">
						<h2>비밀번호 찾기</h2>
					</li>
					<li class="text_center sub_text">가입하신 방법에 따라 아이디 찾기가 가능합니다.</li>
					<li class="text_center radio_check_view">
						<span>
							<input type="radio" name="find" id="email" value="email" checked>
							<label for="email">이메일</label>
						</span>
						<span>
							<input type="radio" name="find" id="hand_phone" value="hand_phone">
							<label for="hand_phone">휴대폰번호</label>
						</span>
					</li>
					<li class="data_view">
						<span class="first_span">아이디</span>
						<span class="last_span">
							<input name="id" type="text">
						</span>
					</li>
					<li class="data_view">
						<span class="first_span">이름</span>
						<span class="last_span">
							<input name="name" type="text">
						</span>
					</li>
					<li class="data_view email_view">
						<span class="first_span">이메일로 찾기</span>
						<span class="last_span">
							<input name="email" type="email">
						</span>
					</li>
					<li class="data_view hand_phone_view">
						<span class="first_span">휴대폰번호로 찾기</span>
						<span class="last_span">
						<input name="hand_phone_1" type="text" minlength="3" maxlength="3" oninput="number_check(this); moveFocus(3,this,'hand_phone_2');">
							<span>-</span>
							<input name="hand_phone_2" type="text" minlength="4" maxlength="4" oninput="number_check(this); moveFocus(4,this,'hand_phone_3');">
							<span>-</span>
							<input name="hand_phone_3" type="text" minlength="4" maxlength="4" oninput="number_check(this);">
						</span>
					</li>
				</form>
				<li>
					<button onclick="password_find_but()" class="find_but" type="button">확인</button>
				</li>
			</ul>
		</div>
	</div>
	<?php include "../tool/footer.php"; ?>
</body>
</html>