<?php
	include_once "../tool/connect_db.php";

	$back_page = explode("/", $_SERVER["HTTP_REFERER"]);
	$back_page = $back_page[count($back_page)-2]."/".$back_page[count($back_page)-1];
	$option_id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['option_id'])? $_POST['option_id'] : ''));
	$goods_id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['goods_id'])? $_POST['goods_id'] : ''));
	if(
		$back_page !== "goods/goods.php?id=".$goods_id || 
		strlen($option_id) <= 0 ||
		!is_numeric($option_id) ||
		strlen($goods_id) <= 0 ||
		!is_numeric($goods_id)
	){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$sql = "select id, price, name from goods_option where id = {$option_id} AND goods_id = {$goods_id}";
	$res = $connect->query($sql) or die();
	if(mysqli_num_rows($res)===1){
		$data = mysqli_fetch_array($res);

		$arr = [$data["name"], $data["price"], $data["id"]];
		echo json_encode($arr);
	}else{
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}
?>