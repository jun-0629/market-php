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
	<link rel="stylesheet" href="../css/category.css">
</head>
<body>
	<div class="parents_div">
		<?php include_once "../tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li><a href="category_delete.php">제거</a></li>
					<li><a href="category_change.php">순서 변경</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<h1>카테고리 추가</h1>
				<div class="category_add_view">
					<form action="backend/add.php" method="post" name="add">
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
						<div>
							<input type="text" name="add_name" placeholder="카테고리 이름">
						</div>
						<button type="button" onclick="cadd()">추가</button>
					</form>
				</div>
			</div>
			<div class="footer_text"><?php echo $server_footer; ?></div>
		</div>
	</div>
</body>
</html>