<?php
	session_start();
	include_once "tool/basic_data.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
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
	<link rel="stylesheet" href="css/index.css">
</head>
<body>
	<div class="parents_div">
		<?php include_once "tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li></li>
				</ul>
				<a class="logout" href="login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
			</div>
			<div class="footer_text"><?php echo $server_footer; ?></div>
		</div>
	</div>
</body>
</html>