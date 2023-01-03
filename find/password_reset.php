<?php
	include_once "../tool/basic_data.php";

	$id = isset($_SESSION['password_find_id']) ? $_SESSION['password_find_id'] : '';
	$name = isset($_SESSION['password_find_name']) ? $_SESSION['password_find_name'] : '';
	$data_info = isset($_SESSION['password_find_data']) ? $_SESSION['password_find_data'] : '';
	$back_page = explode("/", $_SERVER["HTTP_REFERER"]);
	$back_page = $back_page[count($back_page)-2]."/".$back_page[count($back_page)-1];

	if( //보안코드 라인 추가요망
		isset($_SESSION['authentication_time']) || 
		isset($_SESSION['authentication_key']) || 
		isset($_SESSION['authentication_error']) || 
		$back_page != "find/certification.php" || 
		!isset($_SESSION['password_find_token']) || 
		$_SESSION['password_find_token'] != "change:das1d98q5amd321q354wq75f4asp4a2q:password" || 
		strlen($id) <= 0 || 
		strlen($name) <= 0 ||
		strlen($data_info) <= 0
	){
		unset_session();
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
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

<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<?php echo $server_head; ?>
	<link rel="stylesheet" href="../css/password_reset.css">
	<script src="../js/password_reset.js" defer></script>
</head>
<body>
	<?php include "../tool/header.php"; ?>
	<div class="reset">
		<h1>비밀번호 찾기</h1>
		<div class="reset_view">
			<ul>
				<li>
					<h2>비밀번호 재설정</h2>
				</li>
				<form action="password_change.php" method="post" name="password_change_form">
					<li class="information_view">
						<span>아이디</span>
						<span class="data_info"><?php echo $id; ?></span>
					</li>
					<li class="information_view">
						<span>새 비밀번호</span>
						<span>
							<input name="password" type="password" autocomplete="off">
						</span>
					</li>
					<li class="information_view">
						<span class="text_view">영문 대소문자/특수문자/숫자 포함 형태의 8~15자</span>
					</li>
					<li class="information_view">
						<span>새 비밀번호 확인</span>
						<span>
							<input name="password_check" type="password" autocomplete="off">	
						</span>
					</li>
				</form>
				<li>
					<button onclick="password_reset()" type="button">비밀번호 변경</button>
					<button onclick="find_cancel()" type="button">취소</button>
				</li>
			</ul>
		</div>
	</div>
	<?php include "../tool/footer.php"; ?>
</body>
</html>