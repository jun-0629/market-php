<?php
	include_once "../tool/basic_data.php";

	$back_page = explode("/", $_SERVER["HTTP_REFERER"]);
	$back_page = $back_page[count($back_page)-2]."/".$back_page[count($back_page)-1];

	$find = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['find'])? $_POST['find'] : ''));
	$id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['id'])? $_POST['id'] : ''));
	$name = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['name'])? $_POST['name'] : ''));
	$password_find_token = isset($_SESSION['password_find_token'])? $_SESSION['password_find_token'] : '';
	
	if($back_page != "find/find_password.php" || strlen($id) <= 0 || strlen($name) <= 0 || $password_find_token === "change:das1d98q5amd321q354wq75f4asp4a2q:password"){
		unset($_SESSION['password_find_token']);
		unset($_SESSION['authentication_time']);
		unset($_SESSION['authentication_key']);
		unset($_SESSION['password_find_id']);
		unset($_SESSION['password_find_name']);
		unset($_SESSION['password_find_data']);
		unset($_SESSION['authentication_error']);
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	if($find === "email"){
		$email = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['email'])? $_POST['email'] : ''));
		if(preg_match("/^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i", $email)){
			$data_info = $email;
			$sql = "select id from member where id = '{$id}' and name = '{$name}' and email = '{$email}'";
		}else{
			die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
		}
	}else if($find === "hand_phone"){
		$hand_phone_1 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['hand_phone_1'])? $_POST['hand_phone_1'] : ''));
		$hand_phone_2 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['hand_phone_2'])? $_POST['hand_phone_2'] : ''));
		$hand_phone_3 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['hand_phone_3'])? $_POST['hand_phone_3'] : ''));
		if(strlen($hand_phone_1) === 3 && strlen($hand_phone_2) === 4 && strlen($hand_phone_3) === 4){
			$data_info = $hand_phone_1."-".$hand_phone_2."-".$hand_phone_3;
			$sql = "select id from member where id = '{$id}' and name = '{$name}' and hand_phone = '{$data_info}'";
		}else{
			die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
		}
	}else{
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}
	
	$res = $connect->query($sql) or die();
	if(mysqli_num_rows($res) === 0){
		die("<script>location.href='../find/find_password.php'; alert('입력하신 [아이디 : {$id}]로 가입된 회원은 존재하지 않습니다.');</script>");
	}

	$_SESSION['password_find_token'] = "find:2b2cef355e59e37f71c396d9c910a1fa:password";
	$_SESSION['password_find_id'] = $id;
	$_SESSION['password_find_name'] = $name;
	$_SESSION['password_find_data'] = $data_info;
	if(!isset($_SESSION['authentication_error'])){
		$_SESSION['authentication_error'] = 0;
	}
?>

<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<?php if($find === "email"){ ?>	
	<script src="../js/email_authentication.js" defer></script>
	<?php } ?>
	<?php echo $server_head; ?>
	<link rel="stylesheet" href="../css/certification.css">
</head>
<body>
	<?php include "../tool/header.php"; ?>
	<div class="certification">
		<h1>비밀번호 찾기</h1>
		<div class="certification_view">
			<ul>
				<li>
					<h2>본인확인 인증</h2>
				</li>
				<li class="information_view">
					<span>본인확인 인증</span>
					<span>
						<?php
							if($find === "email"){
								echo "이메일";
							}else if($find === "hand_phone"){
								echo "휴대폰";
							}
						?>
					</span>
				</li>
				<li class="information_view">
					<span>
						<?php
							if($find === "email"){
								echo "이메일";
							}else if($find === "hand_phone"){
								echo "휴대폰 번호";
							}
						?>
					</span>
					<span>
						<span class="data_info"><?php echo $data_info; ?></span>
						<button type="button" class="code_receive" onclick="<?php echo $find === 'email' ? 'email_send()' : 'hand_phone_send()'; ?>">인증번호 받기</button>
					</span>
				</li>
				<li class="information_view">
					<span>인증번호</span>
					<span>
						<input name="certification_number" type="text">
					</span>
				</li>
				<li class="information_view">
					<span class="text">1회 발송된 인증번호의 유효 시간은 10분이며, 1회 인증번호 발송 후 30초 이후에 재전송이 가능합니다.</span>
				</li>
				<li>
					<button onclick="verification_check()" type="button">확인</button>
					<button onclick="find_cancel()" type="button">취소</button>
				</li>
			</ul>
		</div>
	</div>
	<?php include "../tool/footer.php"; ?>
</body>
</html>