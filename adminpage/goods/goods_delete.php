<?php
	session_start();
	include_once "../tool/basic_data.php";
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}
	$id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_GET['id'])? $_GET['id'] : '')); //상품 ID

	if(strlen($id) <= 0 && is_numeric($id)){
		die("<script>location.href='goods.php'; alert('상품을 선택해주세요.');</script>");
	}

	$sql = "select * from goods where id = {$id} and deleted_or_not=0";
	$res = $connect->query($sql) or die();
	
	if(!mysqli_num_rows($res)){
		die("<script>location.href='goods.php'; alert('상품을 선택해주세요.');</script>");
	}
	$goods_data = mysqli_fetch_array($res);
?>

<!DOCTYPE html>
<html lang="kr">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $server_title; ?></title>
	<?php echo $server_head; ?>
	<link rel="stylesheet" href="../css/goods_add.css">
	<script src="../js/goods_view.js" defer></script>
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
					<li><a href="goods_sale.php">특가 할인 상품 등록</a></li>
					<li><a href="goods_sale_delete.php">특가 할인 상품 제거</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<h1>상품 삭제</h1>
				<div class="goods_add">
					<table>
						<tr>
							<td>상품 ID</td>
							<td>
								<input type="text" value="<?php echo $id; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>상품 제목</td>
							<td>
								<input type="text" value="<?php echo $goods_data["title"]; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>상품 소개</td>
							<td>
								<input type="text" value="<?php echo $goods_data["short_description"]; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>회원 가격</td>
							<td>
								<input type="text" value="<?php echo $goods_data["member_price"]; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>비회원 가격</td>
							<td>
								<input type="text" value="<?php echo $goods_data["non_member_price"]; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>배송비</td>
							<td>
								<input type="text" value="<?php echo $goods_data["delivery_fee"]; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>추가 배송비 개수</td>
							<td>
								<input type="text" value="<?php echo $goods_data["number_of_additional_shipping_costs"]; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>원산지</td>
							<td>
								<input type="text" value="<?php echo $goods_data["origin"]; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>텍스트 리뷰 적립금</td>
							<td>
								<input type="text" value="<?php echo $goods_data["text_reserve"]; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>이미지 리뷰 적립금</td>
							<td>
								<input type="text" value="<?php echo $goods_data["image_reserve"]; ?>" readonly>
							</td>
						</tr>
						<tr>
							<td>상품 상태</td>
							<td>
								<select onFocus="this.initialSelect = this.selectedIndex;" onChange="this.selectedIndex = this.initialSelect;">
									<option value="true" <?php if($goods_data['product_condition']){ echo 'selected'; }?>>정상</option>
									<option value="false" <?php if(!$goods_data['product_condition']){ echo 'selected'; }?>>품절</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>카테고리</td>
							<td>
								<?php
									$sql_category = "select category_key from category where id = {$goods_data["category_id"]}";
									$res_category = $connect->query($sql_category) or die();
									$category_key = mysqli_num_rows($res_category)?mysqli_fetch_array($res_category)["category_key"]:"";
									$category_key = str_split($category_key, 2);
								?>
								<select name="category_1" onFocus="this.initialSelect = this.selectedIndex;" onchange="this.selectedIndex = this.initialSelect;" data-catagory="<?php echo isset($category_key[0])?$category_key[0]:"";?>">
									<option value="none">1차 카테고리</option>
									<?php
										$sql = "SELECT category_key, category_name FROM category WHERE CHAR_LENGTH(category_key) = 2 ORDER BY category_key ASC";
										$res = $connect->query($sql) or die();
										while ($data = mysqli_fetch_array($res)) {
											echo "<option value=\"{$data["category_key"]}\">{$data["category_name"]}</option>";
										}
									?>
								</select>
								<select name="category_2" onFocus="this.initialSelect = this.selectedIndex;" onchange="this.selectedIndex = this.initialSelect;" data-catagory="<?php echo isset($category_key[1])?$category_key[1]:"";?>">
									<option value="none">2차 카테고리</option>
								</select>
								<select name="category_3" onFocus="this.initialSelect = this.selectedIndex;" onchange="this.selectedIndex = this.initialSelect;" data-catagory="<?php echo isset($category_key[2])?$category_key[2]:"";?>">
									<option value="none">3차 카테고리</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>옵션</td>
							<td class="goods_option">
								<div>
									<input type="text" name="option_basic_name" placeholder="옵션 명 ex)컬러" value="<?php echo $goods_data["option_name"]; ?>" readonly>
								</div>
								<table>
									<thead>
										<tr>
											<td>이름</td>
											<td>가격</td>
											<td>상태</td>
										</tr>
									</thead>
									<tbody>
										<?php
											$option_sql = "select name, price, situation from goods_option where goods_id = '{$id}'";
											$option_res = $connect->query($option_sql) or die();
											if(mysqli_num_rows($option_res)){
												while($option_data = mysqli_fetch_array($option_res)){
										?>
										<tr>
											<td>
												<input name="option_name" type="text" value="<?php echo $option_data["name"]; ?>" readonly>
											</td>
											<td>
												<input name="option_price" oninput="number_check(this)" type="text" value="<?php echo $option_data["price"]; ?>" readonly>
											</td>
											<td>
												<select name="option_situation" onFocus="this.initialSelect = this.selectedIndex;" onchange="this.selectedIndex = this.initialSelect;">
													<option value="true" <?php echo $option_data["situation"]?"selected":""; ?>>판매</option>
													<option value="false" <?php echo $option_data["situation"]?"selected":""; ?>>품절</option>
												</select>
											</td>
										</tr>
										<?php
												}
											}
										?>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>상품 설명</td>
							<td style="padding: 10px; height: 300px;">
								<div style="overflow-y:scroll; height:100%;">
									<?php echo $goods_data["main_text"]; ?>
								</div>
							</td>
						</tr>
						<tr>
							<td>상품 이미지</td>
							<td class="image_preview">
								<ul class='att_zone1'>
									<?php
										$img_sql = "select url from goods_img where goods_id='{$goods_data['id']}'";
										$img_res = $connect->query($img_sql) or die();
										$img_count = 1;
										while($img_data = mysqli_fetch_array($img_res)){
									?>
									<li data-number="<?php echo $img_count; ?>" data-img_name="<?php echo $img_data["url"]; ?>">
										<img src ="../../img/goods_main/<?php echo $img_data["url"]; ?>">
									</li>
									<?php
											$img_count++;
										}
									?>
								</ul>
							</td>
						</tr>
						<tr>
							<td>비밀번호</td>
							<td>
								<input name="password" type="password" autocomplete="off">
							</td>
						</tr>
						<tr>
							<td colspan="2" class="add_but">
								<button type="button" onclick="goods_delete()">삭제</button>
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