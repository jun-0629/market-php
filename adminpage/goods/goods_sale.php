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
	<link rel="stylesheet" href="../css/goods_view.css">
	<script src="../js/goods_index.js" defer></script>
</head>
<body>
	<div class="parents_div">
		<?php include_once "../tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li><a href="goods.php">상품 목록</a></li>
					<li><a href="goods_add.php">상품 추가</a></li>
					<li><a href="goods_new.php">신규 상품 등록</a></li>
					<li><a href="goods_new_delete.php">신규 상품 제거</a></li>
					<li><a href="goods_sale_delete.php">특가 할인 상품 제거</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<h1>특가 할인 상품 등록(index)</h1>
				<div class="good_view">
					<table>
						<tr>
							<td>등록된 상품 ID</td>
							<td>
								<select>
									<option>상품 ID</option>
									<?php
										$new_sql = "select goods_id from index_goods_view where view_name = 'sale_goods'";
										$new_res = $connect->query($new_sql) or die();
										while($data = mysqli_fetch_array($new_res)){
									?>
									<option><?php echo $data["goods_id"]; ?></option>
									<?php
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>상품 ID</td>
							<td>
								<form action="goods_sale_check.php" method="post" name="goods_view_check">
									<input name="goods_id" oninput="number_check(this)" type="text">
								</form>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<button onclick="goods_new_add()" type="button">등록</button>
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