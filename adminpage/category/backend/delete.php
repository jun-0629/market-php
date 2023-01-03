<?php
	session_start();
	include "../../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$category_1 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_1'])? $_POST['category_1'] : ''));
	$category_2 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_2'])? $_POST['category_2'] : ''));
	$category_3 = mysqli_real_escape_string($connect, htmlspecialchars(isset($_POST['category_3'])? $_POST['category_3'] : ''));

	if(strlen($category_1) == 0 || strlen($category_2) == 0 || strlen($category_3) == 0){
		die("<script>location.href='../category_delete.php'; alert('잘못된 접근입니다.');</script>");
	}

	if($category_3 != "none"){ //3차 카테고리 삭제
		$category_like_key = substr($category_3, 0, 4);
		$categoy_delete_key = $category_3;
		$select_sql_where = "WHERE category_key like '{$category_like_key}%' AND CHAR_LENGTH(category_key) = 6";
		$max_num = 6;
		$list_num = "3";
	}else if($category_2 != "none"){ //2차 카테고리 삭제
		$category_like_key = substr($category_2, 0, 2);
		$categoy_delete_key = $category_2;
		$select_sql_where = "WHERE category_key like '{$category_like_key}%' AND CHAR_LENGTH(category_key) >= 4";
		$max_num = 4;
		$list_num = "2";
	}else if($category_1 != "none"){ //1차 카테고리 삭제
		$categoy_delete_key = $category_1;
		$select_sql_where = "";
		$max_num = 2;
		$list_num = "1";
	}else{
		die("<script>location.href='../category_delete.php'; alert('삭제할 카테고리를 선택해주세요.');</script>");
	}

	$sql_name = "SELECT category_name FROM category where category_key = '{$categoy_delete_key}'";
	$res_name = $connect->query($sql_name) or die();

	$category_name = mysqli_fetch_array($res_name)['category_name'];

	$sql = "DELETE FROM `category` WHERE category_key like '{$categoy_delete_key}%'";
	$connect->query($sql) or die();

	$sql = "SELECT id, category_key FROM category {$select_sql_where}";
	$res = $connect->query($sql) or die();

	if(mysqli_num_rows($res) > 0){
		while ($data = mysqli_fetch_array($res)) {
			$arr[$data["id"]] = $data["category_key"];
		}
		
		foreach ($arr as $key => $value) {
			if(strlen($value) === $max_num){
				foreach ($arr as $key_1 => $value_1) {
					if(substr($value_1, 0, $max_num) === $value){
						$change_key[$value][$key_1] = $value_1;
					}
				}
			}
		}
		ksort($change_key);
			
		$count_key = 0;
		foreach ($change_key as $key => $value) {
			$count_key++;
			if($count_key < 10){
				$change_key_code = $max_num===2 ? "0".$count_key : $category_like_key."0".$count_key;
			}else{
				$change_key_code = $max_num===2 ? $count_key : $category_like_key.$count_key;
			}
			foreach ($change_key[$key] as $key_1 => $value_1) {
				$key_change_code = substr_replace($change_key[$key][$key_1], $change_key_code, 0, $max_num);
				$sql_update = "UPDATE `category` SET `category_key`='{$key_change_code}' WHERE id = {$key_1}";
				$connect->query($sql_update) or die();
			}
		}
	}
	echo "<script>location.href='../category_delete.php'; alert('{$list_num}차 카테고리를 삭제했습니다. (이름 : {$category_name})');</script>";
?>