<?php
	include_once "../tool/basic_data.php";
	if(!isset($_SESSION["member"])){
		$return_url =  openssl_encrypt("../mypage/changing_information.php", 'aes-256-cbc', "login_return_url", false, str_repeat(chr(0), 16));
		die("<script>location.href='../login/login.php?return_url={$return_url}'; alert('로그인 후 이용해 주세요.');</script>");
	}

	$sql = "select name, birthday, email, zip_code, address, detailed_address, hand_phone, phone_number, sms_send_bool, email_send_bool from member where id = '{$_SESSION['member']}'";
	$res = $connect->query($sql) or die();

	if(mysqli_num_rows($res) != 1){
		die("<script>location.href='../login/logout.php'; alert('잘못된 접근입니다.');</script>");
	}

	if(!isset($_SESSION['password_revalidation_token']) || $_SESSION['password_revalidation_token'] != "changing:s5a6q2x532q!wenk23d5c2@a*3w2xc1vajkk84:information"){
		die("<script>location.href='mypage_pass.php'</script>");
	}

	$arr = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<?php echo $server_head; ?>
	<link rel="stylesheet" href="../css/changing_information.css">
	<link rel="stylesheet" href="../css/mypage_menu.css">
	<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
	<script src="../js/postcode.js" defer></script>
	<script src="../js/calender.js" defer></script>
	<script src="../js/changing_information.js" defer></script>
</head>
<body>
	<?php include "../tool/header.php"; ?>
	<div class="changing_information">
		<?php include "../tool/mypage_menu.php";?>
		<ul class="changing_information_data_view">
			<form action="changing_information_data.php" method="post" name="data_resetting">
				<li>
					<h1>회원 정보 수정</h1>
					<span class="essential_text">필수입력사항</span>
				</li>
				<li>
					<span>아이디</span>
					<span>
						<input type="text" value="<?php echo $_SESSION["member"]; ?>" readonly>
					</span>
				</li>
				<li>
					<span>비밀번호<span id="essential_check"></span></span>
					<span class="password_change_view">
						<button type="button" onclick="pass_change()">비밀번호 변경</button>
						<div class="first_child">
							<span>현재 비밀번호<span class="essential"></span></span>
							<input name="current_password" type="password" autocomplete="off" disabled>
						</div>
						<div>
							<span>새 비밀번호<span class="essential"></span></span>
							<input name="new_password" type="password" autocomplete="off" disabled>
							<div class="password_text">- 영문 대소문자/특수문자/숫자 포함 형태의 8~15자</div>
						</div>
						<div>
							<span>새 비밀번호 확인<span class="essential"></span></span>
							<input name="new_password_check" type="password" autocomplete="off" disabled>
						</div>
					</span>
				</li>
				<li>
					<span>이름<span class="essential"></span></span>
					<span><input type="text" name="name" value="<?php echo $arr["name"]; ?>"></span>
				</li>
				<li>
					<span>생년월일<span class="essential"></span></span>
					<span class="ui-check-date" data-term="70" data-point="down">
						<select name="birthday_y" data-default-option="선택" data-y_early="<?php echo explode("/", $arr["birthday"])[0]; ?>" data-unit="y"></select>년
						<select name="birthday_m" data-default-option="선택" data-m_early="<?php echo explode("/", $arr["birthday"])[1]; ?>" data-unit="m"></select>월
						<select name="birthday_d" data-default-option="선택" data-d_early="<?php echo explode("/", $arr["birthday"])[2]; ?>" data-unit="d"></select>일
					</span>
				</li>
				<li>
					<span>이메일<span class="essential"></span></span>
					<span><input type="email" name="email" value="<?php echo $arr["email"]; ?>"></span>
				</li>
				<li class="address_li">
					<span>주소<span class="essential"></span></span>
					<span class="address_data">
						<div>
							<input type="text" id="zip_code" name="zip_code" value="<?php echo $arr["zip_code"]; ?>" placeholder="우편번호" readonly>
							<button onclick="Postcode()" class="address_search" type="button">주소검색</button>
						</div>
						<div>
							<input type="text" id="addr" name="address" value="<?php echo $arr["address"]; ?>" placeholder="주소" readonly>
						</div>
						<div>
							<input type="text" id="addr1" name="detailed_address" value="<?php echo $arr["detailed_address"]; ?>" placeholder="나머지 주소(선택 입력 가능)">
						</div>
					</span>
				</li>
				<li>
					<span>핸드폰 번호<span class="essential"></span></span>
					<span class="number_data">
						<select name="hand_phone_1" data-hp="<?php echo explode("-", $arr["hand_phone"])[0]; ?>">
							<option value="010">010</option>
							<option value="011">011</option>
							<option value="016">016</option>
							<option value="017">017</option>
							<option value="019">019</option>
						</select>
						<span>-</span>
						<input value="<?php echo explode("-", $arr["hand_phone"])[1]; ?>" name="hand_phone_2" type="text" class="number_input" autocomplete="off" maxlength="4" minlength="4" oninput="number_check(this); moveFocus(4,this,'hand_phone_3');">
						<span>-</span>
						<input value="<?php echo explode("-", $arr["hand_phone"])[2]; ?>" name="hand_phone_3" type="text" class="number_input" autocomplete="off" maxlength="4" minlength="4" oninput="number_check(this)">
					</span>
				</li>
				<li>
					<span>전화번호</span>
					<span class="number_data">
						<select name="phone_number_1" data-pn="<?php echo isset(explode("-", $arr["phone_number"])[0]) ? explode("-", $arr["phone_number"])[0] : ""; ?>">
							<option value="02">02</option>
							<option value="031">031</option>
							<option value="032">032</option>
							<option value="033">033</option>
							<option value="041">041</option>
							<option value="042">042</option>
							<option value="043">043</option>
							<option value="044">044</option>
							<option value="051">051</option>
							<option value="052">052</option>
							<option value="053">053</option>
							<option value="054">054</option>
							<option value="055">055</option>
							<option value="061">061</option>
							<option value="062">062</option>
							<option value="063">063</option>
							<option value="064">064</option>
							<option value="070">070</option>
							<option value="010">010</option>
							<option value="011">011</option>
							<option value="016">016</option>
							<option value="017">017</option>
							<option value="019">019</option>
						</select>
						<span>-</span>
						<input value="<?php echo isset(explode("-", $arr["phone_number"])[1]) ? explode("-", $arr["phone_number"])[1] : ""; ?>" name="phone_number_2" type="text" class="number_input" autocomplete="off" maxlength="4" oninput="number_check(this); moveFocus(4,this,'phone_number_3');">
						<span>-</span>
						<input value="<?php echo isset(explode("-", $arr["phone_number"])[2]) ? explode("-", $arr["phone_number"])[2] : ""; ?>" name="phone_number_3" type="text" class="number_input" autocomplete="off" maxlength="4" oninput="number_check(this)">
					</span>
				</li>
				<li>
					<span>SMS 수신여부<span class="essential"></span></span>
					<span class="redio_span">
						<input value="sms_send_yes" name="sms_send" type="radio" id="sms_send_yes" <?php if($arr["sms_send_bool"]){ echo "checked"; }?>>
						<label for="sms_send_yes">수신함</label>
						<input value="sms_send_no" name="sms_send" type="radio" id="sms_send_no" <?php if(!$arr["sms_send_bool"]){ echo "checked"; }?>>
						<label for="sms_send_no">수신 안함</label>
					</span>
					<div class="send_text">- 쇼핑몰에서 제공하는 유익한 이벤트 소식을 문자로 받으실 수 있습니다.</div>
				</li>
				<li>
					<span>이메일 수신여부<span class="essential"></span></span>
					<span class="redio_span">
						<input value="email_send_yes" name="email_send" type="radio" id="email_send_yes" <?php if($arr["email_send_bool"]){ echo "checked"; }?>>
						<label for="email_send_yes">수신함</label>
						<input value="email_send_no" name="email_send" type="radio" id="email_send_no" <?php if(!$arr["email_send_bool"]){ echo "checked"; }?>>
						<label for="email_send_no">수신 안함</label>
					</span>	
					<div class="send_text">- 쇼핑몰에서 제공하는 유익한 이벤트 소식을 이메일로 받으실 수 있습니다.</div>
				</li>
				<li>
					<button onclick="reset_event()" class="set_but" type="button">회원정보수정</button>
					<button class="remove_member" type="button">회원탈퇴</button>
				</li>
			</form>
		</ul>
	</div>
	<?php include "../tool/footer.php"; ?>
</body>
</html>