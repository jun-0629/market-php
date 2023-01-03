<?php
	include_once "../tool/connect_db.php";

	$back_page = explode("/", $_SERVER["HTTP_REFERER"]);
	$back_page = $back_page[count($back_page)-2]."/".$back_page[count($back_page)-1];
	$id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['id'])? $_POST['id'] : ''));

	if($back_page !== "signup/join.php" || strlen($id) <= 0){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}
	
	$sql = "select id from member where id = '{$id}'";
	$res = $connect->query($sql) or die();

	if(mysqli_num_rows($res) === 0){
		die("success");
	}else{
		die("overlap");
	}
?>