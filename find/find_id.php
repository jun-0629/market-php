<?php
	include_once "../tool/basic_data.php"
?>

<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<script src="../js/find.js" defer></script>
	<script src="../js/find_id.js" defer></script>
	<?php echo $server_head; ?>
	<link rel="stylesheet" href="../css/find.css">
	<link rel="stylesheet" href="../css/find_id.css">
</head>
<body>
	<?php include "../tool/header.php"; ?>
	<div class="find">
		<h1>아이디 찾기</h1>
		<div class="find_view">
			<ul>
				<li class="text_center">
					<h2>아이디 찾기</h2>
				</li>
				<div class="find_data_input_view">
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
					<li>
						<button class="find_but" onclick="find_id_but()" type="button">확인</button>
					</li>
				</div>
				<div class="find_data_output_view">
					<li class="find_data_output_sub_text">고객님 아이디 찾기가 완료 되었습니다.</li>
					<li>
						<table>
							<tr>
								<td>
									<p>저희 쇼핑몰을 이용해주셔서 감사합니다.</p>
									<p class="id_count_text"></p>
								</td>
							</tr>
							<tr>
								<td>
									<table class="data_info">
										<tr>
											<td>이름 :</td>
											<td class="name_data"></td>
										</tr>
										<tr>
											<td class="data_type_output"></td>
											<td class="email_data"></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</li>
					<li class="data_info_btn">
						<a class="login_page_but" href="../login/login.php">로그인</a>
						<a class="find_password_page_btn" href="find_password.php">비밀번호 찾기</a>
					</li>
				</div>
			</ul>
		</div>
	</div>
	<?php include "../tool/footer.php"; ?>
</body>
</html>