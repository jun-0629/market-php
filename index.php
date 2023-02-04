<?php
	include_once "tool/basic_data.php";

	$member_check = isset($_SESSION["member"]) ? "member_price" : "non_member_price";
?>
<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<?php echo $server_head; ?>
	<script src="js/index.js" defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/index.css">
	<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

<body>
	<div class="popup_group">
		<?php 
			$pop_sql = "select name, url from popup";
			$pop_res = $connect->query($pop_sql) or die();
			if(mysqli_num_rows($pop_res)){
				$pop_count = 0;
				while($pop_data = mysqli_fetch_array($pop_res)){
					$pop_count++;
					if(!(isset($_COOKIE["pop_id_{$pop_count}"]) && $_COOKIE["pop_id_{$pop_count}"]==="true")){
		?>
		<div class="pop_up" id="pop_id_<?php echo $pop_count; ?>">
			<?php
				if(strlen($pop_data["url"]) > 0){
			?>
			<a href="<?php echo $pop_data["url"]; ?>">
				<img src="../img/popup/<?php echo $pop_data["name"]; ?>">
			</a>
			<?php }else{ ?>
				<img src="../img/popup/<?php echo $pop_data["name"]; ?>">
			<?php }?>
			<div class="button">
				<button type="button" onclick="cookie_pop_close(<?php echo $pop_count; ?>)">하루동안 닫기</button>
				<button type="button" onclick="pop_close(<?php echo $pop_count; ?>)">닫기</button>
			</div>
		</div>
		<?php
					}
				}
			}
		?>
	</div>
	<?php include "tool/header.php"?>
	<div class="main">
		<div class="slider">
			<?php
				$slider_sql = "select name from banner ORDER BY img_order ASC";
				$slider_res = $connect->query($slider_sql) or die();
				while($data = mysqli_fetch_array($slider_res)){
			?>
			<img src="img/slider/<?php echo $data["name"]; ?>">
			<?php } ?>
		</div>
		<div class="new_goods">
			<div class="new_goods_view">
				<div class="new_goods_text">
					<p>신규 상품 추천</p>
					<p>사계절마켓에서 추천하는 신규상품입니다.</p>
				</div>
				<ul>
					<?php
						$new_goods_index_sql = "select goods_id from index_goods_view where view_name = 'new_goods'";
						$new_goods_index_res = $connect->query($new_goods_index_sql) or die();
						while($new_goods_index = mysqli_fetch_array($new_goods_index_res)){
							$new_goods_sql = "select id, title, {$member_check} from goods where id = {$new_goods_index['goods_id']}";
							$new_goods_res = $connect->query($new_goods_sql) or die();
							$new_goods = mysqli_fetch_array($new_goods_res);
							$new_goods_img_sql = "select url from goods_img where goods_id = {$new_goods["id"]} AND image_order='1'";
							$new_goods_img_res = $connect->query($new_goods_img_sql) or die();						
					?>
					<li>
						<a href="goods/goods.php?id=<?php echo $new_goods["id"]; ?>">
							<img src="img/goods_main/<?php echo mysqli_fetch_array($new_goods_img_res)["url"]?>">
							<div>
								<p><?php echo $new_goods["title"]; ?></p>
								<p><?php echo number_format($new_goods["{$member_check}"]); ?>원</p>
							</div>
						</a>
					</li>
					<?php
						}
					?>
				</ul>
			</div>
		</div>
		<div class="event_goods">
			<div class="event_goods_view">
				<img src="img/main_img/event.jpg">
				<div class="event_goods_main">
					<div class="event_goods_text">
						<p>특가 할인 상품(무료배송)</p>
						<p>사계절마켓에서 특가 할인 상품을 준비했습니다.</p>
						<p>청정지역 강원도 양구에서 자란 농산물들을 특가 할인된 금액으로 받아보세요.</p>
					</div>
					<ul>
						<?php
							$event_goods_index_sql = "select goods_id from index_goods_view where view_name = 'sale_goods'";
							$event_goods_index_res = $connect->query($event_goods_index_sql) or die();
							while($event_goods_index = mysqli_fetch_array($event_goods_index_res)){
								$event_goods_sql = "select id, title, {$member_check} from goods where id = {$event_goods_index['goods_id']}";
								$event_goods_res = $connect->query($event_goods_sql) or die();
								$event_goods = mysqli_fetch_array($event_goods_res);
								$event_goods_img_sql = "select url from goods_img where goods_id = {$event_goods["id"]} AND image_order='1'";
								$event_goods_img_res = $connect->query($event_goods_img_sql) or die();	
						?>
						<li>
							<a href="goods/goods.php?id=<?php echo $event_goods["id"]; ?>">
								<img src="img/goods_main/<?php echo mysqli_fetch_array($event_goods_img_res)["url"]?>">
								<div class="event_goods_title"><?php echo $event_goods["title"]; ?></div>
								<div class="event_goods_price"><?php echo number_format($event_goods["{$member_check}"]); ?>원</div>
							</a>
						</li>
						<?php
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class="all_goods">
			<img src="img/main_img/all_item.jpg">
			<ul>
				<?php
					$all_goods_sql = "select id, title, member_price, non_member_price, short_description from goods where deleted_or_not = 0 LIMIT 5,6";
					$all_goods_res = $connect->query($all_goods_sql) or die();
					while($all_goods = mysqli_fetch_array($all_goods_res)){
						$all_goods_img_sql = "select url from goods_img where goods_id = {$all_goods["id"]} AND image_order='1'";
						$all_goods_img_res = $connect->query($all_goods_img_sql) or die();						
				?>
				<li>
					<a href="goods/goods.php?id=<?php echo $all_goods["id"]; ?>">
						<img src="img/goods_main/<?php echo mysqli_fetch_array($all_goods_img_res)["url"]?>">
						<p class="all_goods_title"><?php echo $all_goods["title"]; ?></p>
						<?php
							if(isset($_SESSION["member"])){
						?>
						<p class="all_goods_price"><?php echo number_format($all_goods["member_price"]); ?>원</p>
						<?php
							}else{
						?>
						<p  class="all_goods_price">
							<?php echo number_format($all_goods["non_member_price"]); ?>원
							<del>회원가:<?php echo number_format($all_goods["member_price"]); ?>원</del>
						</p>
						<?php
							}
						?>
						<p class="all_goods_short_description"><?php echo $all_goods["short_description"]?></p>
					</a>
				</li>
				<?php
					}
				?>
			</ul>
		</div>
	</div>
	<?php include "tool/footer.php"; ?>
</body>
</html>