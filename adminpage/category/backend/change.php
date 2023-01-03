<?php
	session_start();
	include "../../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	if(isset($_POST['change_key']) && count($_POST['change_key']) > 0){
		$change_key_arr = $_POST['change_key'];

		foreach ($change_key_arr as $key => $value) {
			$check_key = mysqli_real_escape_string($connect, htmlspecialchars($key));
			break;
		}
		$sql = "SELECT category_key FROM category WHERE id={$check_key}";
		$res = $connect->query($sql) or die();
		
		$category_key_check = mysqli_fetch_array($res)["category_key"];

		if(strlen($category_key_check) == 2){
			$max_num = 2;
			$key_code = substr($category_key_check, 0,2);
			$sql_where = "1";
		}else if(strlen($category_key_check) == 4){
			$max_num = 4;
			$key_code = substr($category_key_check, 0,2);
			$sql_where = "category_key like '{$key_code}%' AND char_length(category_key) >= 4";
		}else if(strlen($category_key_check) == 6){
			$max_num = 6;
			$key_code = substr($category_key_check, 0,4);
			$sql_where = "category_key like '{$key_code}%' AND char_length(category_key) = 6";
		}

		$sql = "SELECT id, category_key FROM category WHERE {$sql_where}";
		$res = $connect->query($sql) or die();
		while($data = mysqli_fetch_array($res)){
			$arr[$data["id"]] = $data["category_key"];
		}

		foreach ($arr as $key => $value) {
			if(strlen($value) === $max_num){
				foreach ($arr as $key_1 => $value_1) {
					if(substr($value_1, 0, $max_num) === $value){
						$change_key[$key][$key_1] = $value_1;
					}
				}
			}
		}

		foreach ($change_key as $key => $value) {
			$category_start_key = substr($change_key[$key][$key], 0, $max_num-2);
			foreach ($change_key[$key] as $key_1 => $value_1) {
				$change_key_code = $category_start_key.$change_key_arr[$key];
				$key_change_code = substr_replace($change_key[$key][$key_1], $change_key_code, 0, $max_num);
				$sql_update = "UPDATE `category` SET `category_key`='{$key_change_code}' WHERE id = {$key_1}";
				$connect->query($sql_update) or die();

			}
		}
		echo "location.reload(); alert('카테고리 순서를 변경했습니다.');";
	}else{
		die("<script>location.href='../category_add.php'; alert('잘못된 접근입니다.');</script>");
	}
?>