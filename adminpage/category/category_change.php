<?php
	session_start();
	include "../tool/connect_db.php";
	include_once "../tool/basic_data.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
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
	<script defer src="../js/category.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../css/category.css">
</head>
<body>
	<div class="parents_div">
		<?php include_once "../tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li><a href="category_add.php">추가</a></li>
					<li><a href="category_delete.php">제거</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<h1>카테고리 순서 변경</h1>
				<div class="category_add_view">
					<div class="select_div">
						<select name="category_1" onchange="category_change(this)">
							<option value="none">1차 카테고리</option>
							<?php
								$sql = "SELECT category_key, category_name FROM category WHERE CHAR_LENGTH(category_key) = 2 ORDER BY category_key ASC";
								$res = $connect->query($sql) or die();
								while ($data = mysqli_fetch_array($res)) {
									echo "<option value=\"{$data["category_key"]}\">{$data["category_name"]}</option>";
								}
							?>
						</select>
						<select name="category_2" onchange="category_change(this)">
							<option value="none">2차 카테고리</option>
						</select>
						<select name="category_3">
							<option value="none">3차 카테고리</option>
						</select>
					</div>
					<ul class="category_change_view">
					</ul>
					<div class="but_div">
						<button class="loading_but" type="button" onclick="category_loading()">불러오기</button>
						<button class="change_but" type="button" onclick="key_change()">변경하기</button>
					</div>
				</div>
			</div>
			<div class="footer_text"><?php echo $server_footer; ?></div>
		</div>
	</div>
</body>
</html>