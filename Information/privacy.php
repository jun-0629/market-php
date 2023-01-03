<?php
	include "../tool/basic_data.php";
?>

<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<?php echo $server_head; ?>
	<link rel="stylesheet" href="../css/Information.css">
</head>
<body>
	<?php include "../tool/header.php"; ?>
	<div class="text_div">
		<h1>개인정보취급방침</h1>
		<div>
			<?php include "../tool/privacy.php"; ?>
		</div>
	</div>
	<?php include "../tool/footer.php"; ?>
</body>
</html>