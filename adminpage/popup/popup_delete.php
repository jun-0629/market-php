<?php
	session_start();
	include_once "../tool/basic_data.php";
	include_once "../tool/connect_db.php";

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
					<li><a href="popup.php">추가</a></li>
					<li><a href="popup_reset.php">수정</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<h1>팝업 제거</h1>
				<div class="popup">
					<table>
						<form action="popup_delete_check.php" method="post" name="popup_delete">
							<tr>
								<td>이미지</td>
								<td>
									<select name="delete_img" onchange="select_img_change()">
										<option value="none">선택</option>
										<?php
											$sql = "select name from popup";
											$res = $connect->query($sql) or die();
											while($data = mysqli_fetch_array($res)){
										?>
										<option value="<?php echo $data["name"]; ?>"><?php echo $data["name"]; ?></option>
										<?php } ?>
									</select>
									<div>
										<img class="preview_img" src="">
									</div>
								</td>
							</tr>
						</form>
						<tr>
							<td colspan="2">
								<button onclick="popup_delete_event()" type="button">제거</button>
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