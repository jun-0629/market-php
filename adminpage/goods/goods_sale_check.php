<?php
	session_start();
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$goods_id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['goods_id'])? $_POST['goods_id'] : '')); //상품 ID
	if(strlen($goods_id) <= 0 || !is_numeric($goods_id)){
		die("<script>location.href='goods_sale.php'; alert('상품 ID를 입력해주세요.');</script>");
	}

	$sql = "select id from index_goods_view where view_name = 'sale_goods'";
	$res = $connect->query($sql) or die();
	
	if(mysqli_num_rows($res) >= 3){
		die("<script>location.href='goods_sale.php'; alert('특가 할인 상품은 최대 3개까지만 등록 가능합니다.');</script>");
	}

	$sql = "select id from index_goods_view where view_name = 'sale_goods' and goods_id = {$goods_id}";
	$res = $connect->query($sql) or die();
	if(mysqli_num_rows($res)){
		die("<script>location.href='goods_sale.php'; alert('ID : {$goods_id} 상품은 이미 등록되어 있습니다.');</script>");
	}

	$sql = "select id from goods where deleted_or_not = 0 and id = {$goods_id}";
	$res = $connect->query($sql) or die();

	if(!mysqli_num_rows($res)){
		die("<script>location.href='goods_sale.php'; alert('ID : {$goods_id} 상품은 존재하지 않습니다.');</script>");
	}

	$sql = "INSERT INTO index_goods_view(goods_id, view_name) VALUES ({$goods_id}, 'sale_goods')";
	$connect->query($sql) or die();
	die("<script>location.href='goods_sale.php'; alert('ID : {$goods_id} 상품을 특가 할인 상품에 등록했습니다.');</script>");
?>