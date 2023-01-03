<?php
	session_start();
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$goods_id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['goods_id'])? $_POST['goods_id'] : '')); //상품 ID
	if(strlen($goods_id) <= 0 || !is_numeric($goods_id)){
		die("<script>location.href='goods_sale_delete.php'; alert('제거할 상품 ID를 선택해 주세요.');</script>");
	}

	$sql = "select id from index_goods_view where view_name = 'sale_goods' AND goods_id={$goods_id}";
	$res = $connect->query($sql) or die();
	
	if(!mysqli_num_rows($res)){
		die("<script>location.href='goods_sale_delete.php'; alert('ID : {$goods_id} 특가 할인 상품은 등록되어 있지 않습니다.');</script>");
	}

	$sql = "DELETE FROM index_goods_view WHERE view_name = 'sale_goods' AND goods_id={$goods_id}";
	$connect->query($sql) or die();
	die("<script>location.href='goods_sale_delete.php'; alert('ID : {$goods_id} 특가 할인 상품을 제거 했습니다.');</script>");
?>