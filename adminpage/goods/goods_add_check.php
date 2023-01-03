<?php
	session_start();
	date_default_timezone_set('Asia/Seoul'); //시간
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$title = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['title'])? $_POST['title'] : '')); //상품 제목
	$short_description = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['short_description'])? $_POST['short_description'] : '')); //상품 간단 설명
	$member_price = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['member_price'])? $_POST['member_price'] : '')); //회원 가격
	$non_member_price = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['non_member_price'])? $_POST['non_member_price'] : '')); //비회원 가격
	$delivery_fee = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['delivery_fee'])? $_POST['delivery_fee'] : '')); //배송비
	$number_of_additional_shipping_costs = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['number_of_additional_shipping_costs'])? $_POST['number_of_additional_shipping_costs'] : '')); //추가 배송비 개수
	$origin = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['origin'])? $_POST['origin'] : '')); //원산지
	$text_reserve = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['text_reserve'])? $_POST['text_reserve'] : '')); //텍스트 리뷰 적립금
	$image_reserve = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['image_reserve'])? $_POST['image_reserve'] : '')); //이미지 리뷰 적립금
	$product_condition = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['product_condition'])? $_POST['product_condition'] : '')); //상품 상태
	$category_1 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_1'])? $_POST['category_1'] : '')); //1차 카테고리
	$category_2 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_2'])? $_POST['category_2'] : '')); //2차 카테고리
	$category_3 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_3'])? $_POST['category_3'] : '')); //3차 카테고리
	$main_text = isset($_POST['main_text'])? $_POST['main_text'] : ''; //상품 설명
	$option_json = isset($_POST['option_json'])? json_decode($_POST['option_json'], true) : ''; //옵션

	if(
		strlen($title) <= 0 || 
		strlen($short_description) <= 0 || 
		strlen($member_price) <= 0 || 
		strlen($non_member_price) <= 0 || 
		strlen($delivery_fee) <= 0 || 
		strlen($number_of_additional_shipping_costs) <= 0 || 
		strlen($origin) <= 0 || 
		strlen($text_reserve) <= 0 || 
		strlen($image_reserve) <= 0 || 
		strlen($product_condition) <= 0 || 
		strlen($category_1) <= 0 || 
		strlen($category_2) <= 0 || 
		strlen($category_3) <= 0 || 
		strlen($main_text) <= 0
	){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	if($category_3 != "none"){
		$sql = "select id from category where category_key = '{$category_3}'";
		$res = $connect->query($sql) or die();
	}else if($category_2 != "none"){
		$sql = "select id from category where category_key = '{$category_2}'";
		$res = $connect->query($sql) or die();
	}else if($category_1 != "none"){
		$sql = "select id from category where category_key = '{$category_1}'";
		$res = $connect->query($sql) or die();
	}

	if($product_condition == "true"){
		$product_condition = 1;
	}else{
		$product_condition = 0;
	}

	$category = mysqli_fetch_array($res)["id"]; //카테고리 id
	$date =  date("Y-m-d H:i:s"); // 현재시간
	if(is_array($option_json) && count($option_json) > 0){
		$option_basic_name = $option_json[0]["basic_name"];
	}else{
		$option_basic_name = "";
	}

	$sql = "insert into goods(title, short_description, main_text, member_price, non_member_price, delivery_fee, origin, number_of_additional_shipping_costs, product_condition, text_reserve, image_reserve, option_name, category_id, registration_date)";
	$sql .= " values ('{$title}', '{$short_description}', '{$main_text}', {$member_price}, {$non_member_price}, {$delivery_fee}, '{$origin}', {$number_of_additional_shipping_costs}, {$product_condition}, {$text_reserve}, {$image_reserve}, '{$option_basic_name}', {$category}, '{$date}')";
	$connect->query($sql) or die();

	$sql_id = "select id from goods where title='{$title}' and short_description='{$short_description}' and registration_date='{$date}'";
	$res_id = $connect->query($sql_id) or die();

	if(mysqli_num_rows($res_id) === 1){
		$goods_id = mysqli_fetch_array($res_id)["id"];

		if(is_array($option_json) && count($option_json) > 0){
			for ($i=0; $i < count($option_json); $i++) { 
				$option_name = $option_json[$i]["name"];
				$option_price = $option_json[$i]["price"];
				$option_situation = $option_json[$i]["situation"];
				if(strlen($option_name) > 0 && strlen($option_price) > 0 && ($option_situation == "true" || $option_situation == "false")){
					if($option_situation == "true"){
						$option_situation = "null";
					}else{
						$option_situation = 1;
					}
					$option_sql = "INSERT INTO goods_option(goods_id, name, price, situation) VALUES ({$goods_id},'{$option_name}','{$option_price}',{$option_situation})";
					$connect->query($option_sql) or die();
				}
			}
		}

		for ($i=0; $i < count($_FILES); $i++) { 
			$filename = $_FILES['img_'.$i]['name'];
			$tmpfile = $_FILES['img_'.$i]['tmp_name'];
			$filename_ext = explode('.',$filename)[count(explode('.',$filename))-1];
			$allow_file = array("jpg", "png", "bmp", "gif");

			if(in_array($filename_ext, $allow_file)) {
				$image_order = $i+1;
				$change_name = date("YmdHis").mt_rand().".".$filename_ext;
				$file_path= "../../img/goods_main/{$change_name}";
				move_uploaded_file($tmpfile, $file_path);
				$resize_file = getimagesize($file_path);
				if($resize_file["mime"] == 'image/png'){
					$image = imagecreatefrompng($file_path);
				}else if($resize_file["mime"] == "image/gif"){
					$image = imagecreatefromgif($file_path);
				}else{
					$image = imagecreatefromjpeg($file_path);
				}
				imagejpeg($image, $file_path, 80);
				$sql_img = "insert into goods_img(goods_id, url, image_order)";
				$sql_img .= " values ({$goods_id}, '{$change_name}', {$image_order})";
				$connect->query($sql_img) or die();
			}
		}
	}
	echo "success";
?>	