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
	<script src="../js/banner_change.js" defer></script>
	<link rel="stylesheet" href="../css/banner.css">
	<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="parents_div">
		<?php include_once "../tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li><a href="banner.php">추가</a></li>
					<li><a href="banner_delete.php">삭제</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<h1>배너 순서 변경</h1>
				<div class="banner_add">
					<form action="banner_add_check.php" method="post" name="image_add" enctype="multipart/form-data">
						<table>
							<tr>
								<td>순서 변경</td>
								<td>
									<ul class="banner_change_view">
										<?php
											$sql = "select name from banner ORDER BY img_order ASC";
											$res = $connect->query($sql) or die();
											while($data = mysqli_fetch_array($res)){
										?>
										<li style="background-image: url('../../img/slider/<?php echo $data["name"]; ?>');"><?php echo $data["name"]; ?></li>
										<?php } ?>
									</ul>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<button onclick="change_image()" type="button">변경</button>
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