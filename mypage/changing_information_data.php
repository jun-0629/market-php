<?php
	session_start();
	include_once "../tool/connect_db.php";

	$back_page = explode("/", $_SERVER["HTTP_REFERER"]);
	$back_page = $back_page[count($back_page)-2]."/".$back_page[count($back_page)-1];

	//필수 변수
	$name = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['name'])? $_POST['name'] : ''));
	$birthday_y = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['birthday_y'])? $_POST['birthday_y'] : ''));
	$birthday_m = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['birthday_m'])? $_POST['birthday_m'] : ''));
	$birthday_d = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['birthday_d'])? $_POST['birthday_d'] : ''));
	$email = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['email'])? $_POST['email'] : ''));
	$zip_code = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['zip_code'])? $_POST['zip_code'] : ''));
	$address = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['address'])? $_POST['address'] : ''));
	$hand_phone_1 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['hand_phone_1'])? $_POST['hand_phone_1'] : ''));
	$hand_phone_2 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['hand_phone_2'])? $_POST['hand_phone_2'] : ''));
	$hand_phone_3 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['hand_phone_3'])? $_POST['hand_phone_3'] : ''));
	$sms_send = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['sms_send'])? $_POST['sms_send'] : ''));
	$email_send = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['email_send'])? $_POST['email_send'] : ''));
	//필수 변수 아님
	$detailed_address = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['detailed_address'])? $_POST['detailed_address'] : ''));
	$phone_number_1 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['phone_number_1'])? $_POST['phone_number_1'] : ''));
	$phone_number_2 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['phone_number_2'])? $_POST['phone_number_2'] : ''));
	$phone_number_3 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['phone_number_3'])? $_POST['phone_number_3'] : ''));
	$current_password = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['current_password'])? $_POST['current_password'] : ''));
	$new_password = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['new_password'])? $_POST['new_password'] : ''));
	$new_password_check = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['new_password_check'])? $_POST['new_password_check'] : ''));

	if(!isset($_SESSION["member"]) || 
	!isset($_SESSION['password_revalidation_token']) || 
	$_SESSION['password_revalidation_token'] != "changing:s5a6q2x532q!wenk23d5c2@a*3w2xc1vajkk84:information" || 
	$back_page !== "mypage/changing_information.php" || 
	strlen($name) <= 0 || 
	strlen($birthday_y) !== 4 || 
	strlen($birthday_m) <= 0 || 
	strlen($birthday_d) <= 0 || 
	strlen($email) < 5 || 
	!preg_match("/^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i", $email) || 
	strlen($zip_code) !== 5 || 
	strlen($address) <= 0 || 
	strlen($hand_phone_1) !== 3 || 
	strlen($hand_phone_2) !== 4 || 
	strlen($hand_phone_3) !== 4 || 
	!($email_send === "email_send_yes" || $email_send === "email_send_no") ||
	!($sms_send === "sms_send_yes" || $sms_send === "sms_send_no")
	){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$sql = "select password from member where id = '{$_SESSION['member']}'";
	$res = $connect->query($sql) or die();
	if(mysqli_num_rows($res) !== 1){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$birthday = $birthday_y."/".$birthday_m."/".$birthday_d;
	$hand_phone = $hand_phone_1."-".$hand_phone_2."-".$hand_phone_3;
	$phone_number = "";
	$sms_send_bool = 'null';
	$email_send_bool = 'null';

	if(
		(strlen($phone_number_1) === 2 || strlen($phone_number_1) === 3) && 
		(strlen($phone_number_2) === 3 || strlen($phone_number_2) === 4) && 
		strlen($phone_number_3) === 4
	){
		$phone_number = $phone_number_1."-".$phone_number_2."-".$phone_number_3;
	}

	if($sms_send === "sms_send_yes"){
		$sms_send_bool = 1;
	}

	if($email_send === "email_send_yes"){
		$email_send_bool = 1;
	}

	$update_sql = "UPDATE member SET name='{$name}', birthday='{$birthday}', email='{$email}', zip_code='{$zip_code}', address='{$address}', detailed_address='{$detailed_address}', hand_phone='{$hand_phone}', phone_number='{$phone_number}', sms_send_bool={$sms_send_bool}, email_send_bool={$email_send_bool}";

	if(
		strlen($current_password) > 0 &&
		strlen($new_password) > 0 &&
		strlen($new_password_check) > 0 &&
		preg_match("/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/", $new_password) &&
		$new_password === $new_password_check
	){
		if(password_verify($current_password, mysqli_fetch_array($res)['password'])){
			$encryption_password = password_hash($new_password, PASSWORD_DEFAULT);

			$update_sql .= ", password='{$encryption_password}'";
		}else{
			die("<script>location.href='changing_information.php'; alert('현재 비밀번호가 틀렸습니다.');</script>");
		}
	}

	$update_sql .= " where id = '{$_SESSION['member']}';";

	$connect->query($update_sql) or die();
	unset($_SESSION['password_revalidation_token']);
	die("<script>location.href='../index.php'; alert('회원 정보를 수정했습니다.');</script>");
?>