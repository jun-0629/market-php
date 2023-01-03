<?php
	session_start();
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
	<script src="../js/banner.js" defer></script>
	<link rel="stylesheet" href="../css/banner.css">
</head>
<body>
	<div class="parents_div">
		<?php include_once "../tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li><a href="banner_delete.php">삭제</a></li>
					<li><a href="banner_change.php">순서 변경</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<h1>배너 추가</h1>
				<div class="banner_add">
					<form action="banner_add_check.php" method="post" name="image_add" enctype="multipart/form-data">
						<table>
							<tr>
								<td>사진 업로드</td>
								<td>
									<input type="file" name="image" accept="image/*" onchange="preview(this)">
									<div class="ex_text">
										<div>이미지 비율 : 16:5</div>
										<div>EX)가로 : 1920px, 세로 : 600px</div>
										<div>EX)가로 : 1280px, 세로 : 400px</div>
									</div>
									<img class="preview_img"></img>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<button onclick="upload_img_form()" type="button">추가</button>
								</td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<div class="footer_text"><?php echo $server_footer; ?></div>
		</div>
	</div>
</body>
</html>