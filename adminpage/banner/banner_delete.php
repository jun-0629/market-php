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
	<script src="../js/banner_delete.js" defer></script>
	<link rel="stylesheet" href="../css/banner.css">
</head>
<body>
	<div class="parents_div">
		<?php include_once "../tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li><a href="banner.php">추가</a></li>
					<li><a href="banner_change.php">순서 변경</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<h1>배너 제거</h1>
				<div class="banner_add">
					<form action="banner_delete_check.php" method="post" name="image_delete">
						<table>
							<tr>
								<td>사진 선택</td>
								<td>
									<select name="img_select" onchange="select_change_image()">
										<option value="none">선택</option>
										<?php
											$sql = "select name from banner";
											$res = $connect->query($sql) or die();
											while($data = mysqli_fetch_array($res)){
										?>
										<option value="<?php echo $data["name"]; ?>"><?php echo $data["name"]; ?></option>
										<?php } ?>
									</select>
									<div>
										<img class="preview_img"></img>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<button onclick="banner_delete()" type="button">제거</button>
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