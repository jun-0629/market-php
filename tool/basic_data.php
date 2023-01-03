<?php
	date_default_timezone_set('Asia/Seoul'); //시간
	include_once "connect_db.php"; //mysql 접속 코드
	session_start(); //세션 사용가능
	$server_title = "쇼핑몰"; //홈페이지 타이틀 이름 설정
	$include_token = "rY3NFSiEypbDOAgQ0D0KOmwj0B8A9IYsyPE/PM8pFg4agj19aM54JxWWhqOzYPrN"; //header, footer 접근 제어
	$server_head = 
	"
	<link rel=\"stylesheet\" href=\"../css/header.css\">
	<link rel=\"stylesheet\" href=\"../css/footer.css\">
	<script src=\"https://code.jquery.com/jquery-3.5.1.js\"></script>
	<script src=\"../js/header.js\" defer></script>
	"; //서버 중복 header, footer css / 서버 중복 head 내용 추가 가능
?>