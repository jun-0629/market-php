<?php
	session_start();
	include_once "../tool/connect_db.php";

	$certification_number = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['certification_number'])? $_POST['certification_number'] : ''));
	$id = isset($_SESSION['password_find_id']) ? $_SESSION['password_find_id'] : '';
	$name = isset($_SESSION['password_find_name']) ? $_SESSION['password_find_name'] : '';
	$data_info = isset($_SESSION['password_find_data']) ? $_SESSION['password_find_data'] : '';
	$back_page = explode("/", $_SERVER["HTTP_REFERER"]);
	$back_page = $back_page[count($back_page)-2]."/".$back_page[count($back_page)-1];

	if( //보안코드 라인 추가요망
		$back_page != "find/certification.php" || 
		!isset($_SESSION['password_find_token']) || 
		$_SESSION['password_find_token'] != "find:2b2cef355e59e37f71c396d9c910a1fa:password" || 
		strlen($id) <= 0 || 
		strlen($name) <= 0 ||
		strlen($data_info) <= 0
	){
		unset_session();
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	if( //인증번호를 받았는지 체크
		!isset($_SESSION['authentication_key']) ||
		!isset($_SESSION['authentication_time'])
	){
		$arr["code"] = "0001";
		$arr["message"] = "인증번호를 받아주세요.";
		die(json_encode($arr));
	}
	
	if(preg_match("/^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i", $data_info)){
		$sql = "select id from member where id='{$id}' and name='{$name}' and email='{$data_info}'";
	}else if(preg_match("/^(010|011|016|017|018|019)-[0-9]{4}-[0-9]{4}$/", $data_info)){
		$sql = "select id from member where id='{$id}' and name='{$name}' and hand_phone='{$data_info}'";
	}else{
		unset_session();
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}
	
	$res = $connect->query($sql) or die();
	if(mysqli_num_rows($res) != 1){ //데이터베이스에 유저가 존재하는지 확인
		unset_session();
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	//인증번호 유효시간 체크
	$second = 600; //600 = 10분
	$time = date("YmdHis")-$_SESSION['authentication_time'];
	if($time > $second){
		$arr["code"] = "0002";
		$arr["message"] = "인증번호 유호 시간이 지났습니다.";
		unset($_SESSION['authentication_time']);
		unset($_SESSION['authentication_key']);
		die(json_encode($arr));
	}

	if (password_verify($certification_number, $_SESSION['authentication_key'])){ //인증번호 맞는지 체크
		$arr["code"] = "0000";
		$arr["message"] = "success";
		unset($_SESSION['authentication_error']);
		unset($_SESSION['authentication_time']);
		unset($_SESSION['authentication_key']);
		$_SESSION['password_find_token'] = "change:das1d98q5amd321q354wq75f4asp4a2q:password";
		echo json_encode($arr);
	}else{
		$_SESSION['authentication_error']++;
		if($_SESSION['authentication_error'] >= 3){
			$arr["code"] = "0003";
			$arr["message"] = "인증번호를 3번을 틀려 인증번호를 재전송 후 다시 시도해 주십시오";
			unset($_SESSION['authentication_time']);
			unset($_SESSION['authentication_key']);
			$_SESSION['authentication_error'] = 0;
			echo json_encode($arr);
		}else{
			$count_num = $_SESSION['authentication_error'];
			$arr["code"] = "0004";
			$arr["message"] = "입력하신 인증번호가 일치하지 않습니다. 정확한 인증번호를 입력해주세요. (3/{$count_num})";
			echo json_encode($arr);
		}
		die();
	}


	function unset_session(){ //잘못된 접근으로 인한 세션 제거 함수
		unset($_SESSION['password_find_token']);
		unset($_SESSION['authentication_time']);
		unset($_SESSION['authentication_key']);
		unset($_SESSION['password_find_id']);
		unset($_SESSION['password_find_name']);
		unset($_SESSION['password_find_data']);
		unset($_SESSION['authentication_error']);
	}
?>