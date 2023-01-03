<?php
	include_once "../tool/basic_data.php";
	if(isset($_SESSION["member"])){
		die("<script>location.href='../index.php'; alert('로그아웃 후 이용해 주세요.');</script>");
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
	<link rel="stylesheet" href="../css/join.css">
	<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
	<script src="../js/postcode.js" defer></script>
	<script src="../js/calender.js" defer></script>
	<script src="../js/join.js" defer></script>
<body>
	<?php include "../tool/header.php"?>
	<div class="join">
		<div class="join_top">
			<h1>회원가입</h1>
			<span class="essential_text">필수입력사항</span>
		</div>
		<form action="join_check.php" method="post" name="join_post">
			<table>
				<tr>
					<td>아이디<span class="essential"></span></td>
					<td>
						<input onchange="id_check_view(this)" name="id" type="text">
						<div class="check_view"></div>
						<div class="join_rule_text">- 영문자로 시작하는 5~15자 영문자 또는 숫자</div>
					</td>
				</tr>
				<tr>
					<td>비밀번호<span class="essential"></span></td>
					<td>
						<input onchange="password_check_event()" name="password" type="password" autocomplete="off">
						<div class="join_rule_text">- 영문 대소문자/특수문자/숫자 포함 형태의 8~15자</div>
					</td>
				</tr>
				<tr>
					<td>비밀번호 확인<span class="essential"></span></td>
					<td>
						<input onchange="password_check_event()" name="password_check" type="password" autocomplete="off">
						<div class="password_check_view"></div>
					</td>
				</tr>
				<tr>
					<td>이름<span class="essential"></span></td>
					<td>
						<input name="name" type="text">
					</td>
				</tr>
				<tr>
					<td>생년월일<span class="essential"></span></td>
					<td class="ui-check-date" data-term="70" data-point="down">
						<select name="birthday_y" data-default-option="선택" data-unit="y"></select>년
						<select name="birthday_m" data-default-option="선택" data-unit="m"></select>월
						<select name="birthday_d" data-default-option="선택" data-unit="d"></select>일
					</td>
				</tr>
				<tr>
					<td>이메일<span class="essential"></span></td>
					<td>
						<input name="email" type="email">
					</td>
				</tr>
				<tr>
					<td>주소<span class="essential"></span></td>
					<td>
						<div class="zip_code_div">
							<input type="text" id="zip_code" name="zip_code" placeholder="우편번호" readonly>
							<button onclick="Postcode()" type="button">주소검색</button>
						</div>
						<div class="addr_margin">
							<input type="text" id="addr" name="address" placeholder="주소" readonly>
						</div>
						<div>
							<input type="text" id="addr1" name="detailed_address" placeholder="나머지 주소(선택 입력 가능)">
						</div>
					</td>
				</tr>
				<tr>
					<td>핸드폰 번호<span class="essential"></span></td>
					<td class="phone">
						<select name="hand_phone_1">
							<option value="010">010</option>
							<option value="011">011</option>
							<option value="016">016</option>
							<option value="017">017</option>
							<option value="019">019</option>
						</select>
						<span>-</span>
						<input name="hand_phone_2" type="text" class="number_input" autocomplete="off" maxlength="4" minlength="4" oninput="number_check(this); moveFocus(4,this,this.form.hand_phone_3);">
						<span>-</span>
						<input name="hand_phone_3" type="text" class="number_input" autocomplete="off" maxlength="4" minlength="4" oninput="number_check(this)">
					</td>
				</tr>
				<tr>
					<td>전화번호</td>
					<td class="phone">
						<select name="phone_number_1">
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
						<input name="phone_number_2" type="text" class="number_input" autocomplete="off" maxlength="4" oninput="number_check(this); moveFocus(4,this,this.form.phone_number_3);">
						<span>-</span>
						<input name="phone_number_3" type="text" class="number_input" autocomplete="off" maxlength="4" oninput="number_check(this)">
					</td>
				</tr>
				<tr></tr>
			</table>
			<div class="agree_view">
				<div>
					<h2>전체 동의</h2>
					<div class="all_check_view">
						<label for="all_check">이용약관 및 개인정보수집 및 이용, 쇼핑정보 수신(선택)에 모두 동의합니다.</label>
						<input type="checkbox" id="all_check" onclick="all_check_event()">
					</div>
				</div>
				<div>
					<h3>[필수] 이용약관</h3>
					<div class="check_text_view">
						<?php include_once "../tool/Terms_of_service.php"; ?>
					</div>
					<div class="checkbox_view">
						<label for="terms_of_service">이용약관에 동의하십니까?</label>
						<input type="checkbox" name="terms_of_service" id="terms_of_service" onclick="checkbox_check()">
					</div>
				</div>
				<div>
					<h3>[필수] 개인정보 수집 및 이용</h3>
					<div class="check_text_view">
						<?php include_once "../tool/privacy.php"; ?>
					</div>
					<div class="checkbox_view">
						<label for="privacy">개인정보 수집 및 이용에 동의하십니까?</label>
						<input type="checkbox" name="privacy" id="privacy" onclick="checkbox_check()">
					</div>
				</div>
				<div>
					<h3>[선택] SMS, 이메일 수신이용</h3>
					<div class="check_text_view">
						<br>
						<p>할인쿠폰 및 혜택, 이벤트, 신상품 소식 등 쇼핑몰에서 제공하는 유익한 쇼핑정보를 SMS나 이메일로 받아보실 수 있습니다.</p>
						<p>단, 주문/거래 정보 및 주요 정책과 관련된 내용은 수신동의 여부와 관계없이 발송됩니다.</p>
						<p>선택 약관에 동의하지 않으셔도 회원가입은 가능하며, 회원가입 후 회원정보수정 페이지에서 언제든지 수신여부를 변경하실 수 있습니다.</p>
					</div>
					<div class="checkbox_view">
						<label for="sms_send">SMS 수신을 동의 하십니까?</label>
						<input type="checkbox" name="sms_send" id="sms_send" onclick="checkbox_check()">
						<label for="email_send">이메일 수신을 동의 하십니까?</label>
						<input type="checkbox" name="email_send" id="email_send" onclick="checkbox_check()">
					</div>
				</div>
			</div>
		</form>
		<div class="join_button_view">
			<button type="button" onclick="join_event()">회원가입</button>
		</div>
	</div>
	<?php include "../tool/footer.php"; ?>
</body>
</html>