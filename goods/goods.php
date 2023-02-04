<?php
	include_once "../tool/basic_data.php";

	$goods_id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_GET['id'])? $_GET['id'] : ''));

	if(strlen($goods_id) <= 0 || !is_numeric($goods_id)){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}
	
	$goods_sql = "
	select 
	title, 
	main_text, 
	member_price, 
	non_member_price, 
	delivery_fee, 
	origin, 
	number_of_additional_shipping_costs, 
	product_condition, 
	text_reserve, 
	image_reserve, 
	option_name 
	from goods where id = {$goods_id} AND deleted_or_not = 0
	";
	
	$goods_res = $connect->query($goods_sql) or die();

	if(!mysqli_num_rows($goods_res)){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}

	$goods_arr = mysqli_fetch_array($goods_res);

	$member_check = isset($_SESSION["member"]) ? $_SESSION["member"] : "";
?>

<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<?php echo $server_head; ?>
	<link rel="stylesheet" href="../css/goods.css">
	<script src="../js/goods.js" defer></script>
</head>
<body>
	<?php include_once "../tool/header.php"; ?>
	<div>
		<div class="goods_top">
			<div class="goods_top_left">
				<div>
					<?php
						$goods_img_sql = "select url from goods_img where goods_id = {$goods_id} ORDER BY image_order ASC";
						$goods_img_res = $connect->query("$goods_img_sql") or die();
						$goods_img_arr = [];
						while($goods_img = mysqli_fetch_array($goods_img_res)){
							array_push($goods_img_arr, $goods_img["url"]);
						}
					?>
					<div class="goods_top_image">
						<img class="goods_main_img" src="../img/goods_main/<?php echo $goods_img_arr[0]; ?>">
					</div>
					<?php
						if(count($goods_img_arr) > 1){
					?>
					<div class="goods_top_img_collection">
						<?php
							for ($i=0; $i < count($goods_img_arr); $i++) { 
						?>
						<img <?php echo $i==0 ? "class='img_choice'" : ""; ?> src="../img/goods_main/<?php echo $goods_img_arr[$i]; ?>">
						<?php
							}
						?>
					</div>
					<?php
						}
					?>
				</div>
				<div>
					리뷰수:12, 사용자 총 평점 4.7/5
				</div>
			</div>
			<div class="goods_top_right">
				<div class="goods_data_view">
					<h1><?php echo $goods_arr["title"]; ?></h1>
					<table>
						<tr>
							<td>판매가격</td>
							<td>
								<?php
									if(strlen($member_check) > 0){
								?>
								<input type="hidden" id="product_price" value="<?php echo $goods_arr["member_price"]; ?>">
								<del class="del_price"><?php echo number_format($goods_arr["non_member_price"]); ?>원</del>
								<span class="price">
									<span><?php echo number_format($goods_arr["member_price"]); ?></span>
									<span>원</span>
								</span>
								<?php
									}else{
								?>
								<input type="hidden" id="product_price" value="<?php echo $goods_arr["non_member_price"]; ?>">
								<span class="price">
									<span><?php echo number_format($goods_arr["non_member_price"]); ?></span>
									<span>원</span>
								</span>
								<del class="del_price">회원가:<?php echo number_format($goods_arr["member_price"]); ?>원</del>
								<?php
									}
								?>
							</td>
						</tr>
						<tr>
							<td>원산지</td>
							<td><?php echo $goods_arr["origin"]; ?></td>
						</tr>
						<tr>
							<td>텍스트 리뷰 적립금</td>
							<td><?php echo $goods_arr["text_reserve"]; ?></td>
						</tr>
						<tr>
							<td>포토 리뷰 적립금</td>
							<td><?php echo $goods_arr["image_reserve"]; ?></td>
						</tr>
						<tr>
							<td>배송방법</td>
							<td>택배</td>
						</tr>
						<tr>
							<td>배송비</td>
							<td>
								<span><?php echo $goods_arr["delivery_fee"]; ?>원</span>
								<span class="number_of_additional_shipping_costs">(<?php echo $goods_arr["number_of_additional_shipping_costs"]==0 ? "" : $goods_arr["number_of_additional_shipping_costs"]."개마다 부과 / "; ?>제주 추가 3000원, 제주 외 도서지역 추가 5000원)</span>
							</td>
						</tr>
						<?php
							if(strlen($goods_arr["option_name"]) > 0){
								$option_sql = "select id, name, price, situation from goods_option where goods_id = {$goods_id}";
								$option_res = $connect->query($option_sql) or die();
								if(mysqli_num_rows($option_res)){
								
						?>
						<tr>
							<td>필수 옵션</td>
							<td>
								<select name="option_select" onchange="option()">
									<option value="none"><?php echo $goods_arr["option_name"]; ?></option>
									<?php
										while($option = mysqli_fetch_array($option_res)){
									?>
									<option value="<?php echo $option["id"]; ?>" <?php echo $option["situation"] ? "disabled" : "";?>><?php echo $option["name"]; echo $option["price"] == 0 ? "" : "(+".number_format($option["price"])."원)"; echo $option["situation"] ? " 품절" : ""; ?></option>
									<?php
										}
									?>
								</select>
							</td>
						</tr>
						<tr class="option_tr">
							<td colspan="2">
								<ul class="option_goods">
								</ul>
							</td>
						</tr>
						<?php
								}
							}else{
						?>
						<tr>
							<td>수량</td>
							<td class="count">
								<button onclick="goods_count('down')" type="button">-</button>
								<input oninput="goods_number_check(this)" name="goods_count" type="number" value="1">
								<button onclick="goods_count('up')" type="button">+</button>
							</td>
						</tr>
						<?php
							}
						?>
						<tr>
							<td>
								<span>총 상품금액</span>
								<div class="help_tip">
									<div>
										<p>총 상품금액에 배송비는 포함되어 있지 않습니다.</p>
										<p>결제시 배송비가 추가될 수 있습니다.</p>
									</div>
								</div>
							</td>
							<td class="all_price_td">
								<span class="all_price"><?php echo strlen($goods_arr["option_name"]) > 0 ? "0" : (isset($_SESSION["member"]) ? number_format($goods_arr["member_price"]) : number_format($goods_arr["non_member_price"])); ?></span>
								<span>원</span>
							</td>
						</tr>
					</table>
				</div>
				<div class="goods_but_view">
					<button type="button">바로구매</button>
				</div>
			</div>
		</div>
	</div>
	<?php include_once "../tool/footer.php";?>
</body>
</html>