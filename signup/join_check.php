<?php
	session_start();
	include_once "../tool/connect_db.php";

	$back_page = explode("/", $_SERVER["HTTP_REFERER"]);
	$back_page = $back_page[count($back_page)-2]."/".$back_page[count($back_page)-1];

	$id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['id'])? $_POST['id'] : '')); //필수
	$password = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['password'])? $_POST['password'] : '')); //필수
	$password_check = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['password_check'])? $_POST['password_check'] : '')); //필수
	$name = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['name'])? $_POST['name'] : '')); //필수
	$birthday_y = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['birthday_y'])? $_POST['birthday_y'] : '')); //필수
	$birthday_m = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['birthday_m'])? $_POST['birthday_m'] : '')); //필수
	$birthday_d = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['birthday_d'])? $_POST['birthday_d'] : '')); //필수
	$email = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['email'])? $_POST['email'] : '')); //필수
	$zip_code = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['zip_code'])? $_POST['zip_code'] : '')); //필수
	$address = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['address'])? $_POST['address'] : '')); //필수
	$hand_phone_1 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['hand_phone_1'])? $_POST['hand_phone_1'] : '')); //필수
	$hand_phone_2 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['hand_phone_2'])? $_POST['hand_phone_2'] : '')); //필수
	$hand_phone_3 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['hand_phone_3'])? $_POST['hand_phone_3'] : '')); //필수

	$detailed_address = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['detailed_address'])? $_POST['detailed_address'] : '')); //필수 아님
	$phone_number_1 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['phone_number_1'])? $_POST['phone_number_1'] : '')); //필수 아님
	$phone_number_2 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['phone_number_2'])? $_POST['phone_number_2'] : '')); //필수 아님
	$phone_number_3 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['phone_number_3'])? $_POST['phone_number_3'] : '')); //필수 아님
	$sms_send = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['sms_send'])? $_POST['sms_send'] : '')); //필수 아님
	$email_send = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['email_send'])? $_POST['email_send'] : '')); //필수 아님
	
	if(
		$back_page !== "signup/join.php" || 
		strlen($id) <= 0 || 
		!preg_match("/^.*(?=^.{5,15}$)[a-zA-Z]+[a-zA-Z0-9]/", $id) ||
		strlen($password) <= 0 || 
		!preg_match("/^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/", $password) || 
		strlen($password_check) <= 0 || 
		$password !== $password_check || 
		strlen($name) <= 0 || 
		strlen($birthday_y) !== 4 || 
		strlen($birthday_m) <= 0 || 
		strlen($birthday_d) <= 0 || 
		strlen($email) <= 0 || 
		!preg_match("/^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i", $email) || 
		strlen($zip_code) !== 5 || 
		strlen($address) <= 0 || 
		strlen($hand_phone_1) !== 3 || 
		strlen($hand_phone_2) !== 4 || 
		strlen($hand_phone_3) !== 4
	){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$sql = "select id from member where id = '{$id}'";
	$res = $connect->query($sql) or die();
	if(mysqli_num_rows($res)){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$hand_phone = $hand_phone_1."-".$hand_phone_2."-".$hand_phone_3;
	$phone_number = "";
	$encrypted_password = password_hash($password, PASSWORD_DEFAULT);
	$birthday = $birthday_y."/".$birthday_m."/".$birthday_d;
	if(
		(strlen($phone_number_1) === 2 || strlen($phone_number_1) === 3) &&
		(strlen($phone_number_2) === 3 || strlen($phone_number_2) === 4) &&
		strlen($phone_number_3) === 4
	){
		$phone_number = $phone_number_1."-".$phone_number_2."-".$phone_number_3;
	}

	if($sms_send === "on"){
		$sms_send = 1;
	}else{
		$sms_send = "null";
	}

	if($email_send === "on"){
		$email_send = 1;
	}else{
		$email_send = "null";
	}

	$sql = "insert into member(id, password, name, birthday, email, zip_code, address, detailed_address, hand_phone, phone_number, sms_send_bool, email_send_bool)";
	$sql .= " values ('{$id}', '{$encrypted_password}', '{$name}', '{$birthday}', '{$email}', '{$zip_code}', '{$address}', '{$detailed_address}', '{$hand_phone}', '{$phone_number}', {$sms_send}, {$email_send})";
	$connect->query($sql) or die();

	$_SESSION['member'] = $id;
	echo "<script>location.href='../index.php';</script>";
?>