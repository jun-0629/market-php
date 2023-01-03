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
	<link rel="stylesheet" href="../css/popup.css">
	<script src="../js/popup.js" defer></script>
</head>
<body>
	<div class="parents_div">
		<?php include_once "../tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li><a href="popup_delete.php">제거</a></li>
					<li><a href="popup_reset.php">수정</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<h1>팝업 추가</h1>
				<div class="popup">
					<table>
						<form action="popup_add_check.php" method="post" name="popup_add" enctype="multipart/form-data">
							<tr>
								<td>이미지 업로드</td>
								<td>
									<input type="file" name="image" onchange="preview(this)">
									<p>이미지 최대 사이지는 가로 세로 700PX입니다.</p>
									<div>
										<img class="preview_img" src="">
									</div>
								</td>
							</tr>
							<tr>
								<td>클릭시 이동할 URL</td>
								<td>
									<input name="url" type="text">
								</td>
							</tr>
							<tr>
								<td>모바일 버전 적용</td>
								<td>
									<input name="mobile" type="checkbox">
								</td>
							</tr>
						</form>
						<tr>
							<td colspan="2">
								<button onclick="popup_add_event()" type="button">추가</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="footer_text"><?php echo $server_footer; ?></div>
		</div>
	</div>
</body>
</html>