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
	<link rel="stylesheet" href="../css/goods_add.css">
	<script src="../js/goods_add.js" defer></script>
	<script type="text/javascript" src="../tool/smarteditor/js/service/HuskyEZCreator.js" charset="utf-8"></script>
	<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div class="parents_div">
		<?php include_once "../tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li><a href="goods.php">상품 목록</a></li>
					<li><a href="goods_new.php">신규 상품 등록</a></li>
					<li><a href="goods_new_delete.php">신규 상품 제거</a></li>
					<li><a href="goods_sale.php">특가 할인 상품 등록</a></li>
					<li><a href="goods_sale_delete.php">특가 할인 상품 제거</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<h1>상품 추가</h1>
				<div class="goods_add">
					<table>
						<tr>
							<td>상품 제목</td>
							<td>
								<input name="title" type="text">
							</td>
						</tr>
						<tr>
							<td>상품 소개</td>
							<td>
								<input name="short_description" type="text">
							</td>
						</tr>
						<tr>
							<td>회원 가격</td>
							<td>
								<input name="member_price" oninput="number_check(this)" type="text">
							</td>
						</tr>
						<tr>
							<td>비회원 가격</td>
							<td>
								<input name="non_member_price" oninput="number_check(this)" type="text">
							</td>
						</tr>
						<tr>
							<td>배송비</td>
							<td>
								<input name="delivery_fee" oninput="number_check(this)" type="text">
							</td>
						</tr>
						<tr>
							<td>추가 배송비 개수</td>
							<td>
								<input name="number_of_additional_shipping_costs" oninput="number_check(this)" type="text">
							</td>
						</tr>
						<tr>
							<td>원산지</td>
							<td>
								<input name="origin" type="text">
							</td>
						</tr>
						<tr>
							<td>텍스트 리뷰 적립금</td>
							<td>
								<input name="text_reserve" oninput="number_check(this)" type="text">
							</td>
						</tr>
						<tr>
							<td>이미지 리뷰 적립금</td>
							<td>
								<input name="image_reserve" oninput="number_check(this)" type="text">
							</td>
						</tr>
						<tr>
							<td>상품 상태</td>
							<td>
								<select name="product_condition">
									<option value="true">정상</option>
									<option value="false">품절</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>카테고리</td>
							<td>
								<select name="category_1" onchange="category_change(this)">
									<option value="none">1차 카테고리</option>
									<?php
										$sql = "SELECT category_key, category_name FROM category WHERE CHAR_LENGTH(category_key) = 2 ORDER BY category_key ASC";
										$res = $connect->query($sql) or die();
										while ($data = mysqli_fetch_array($res)) {
											echo "<option value=\"{$data["category_key"]}\">{$data["category_name"]}</option>";
										}
									?>
								</select>
								<select name="category_2" onchange="category_change(this)">
									<option value="none">2차 카테고리</option>
								</select>
								<select name="category_3">
									<option value="none">3차 카테고리</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>옵션</td>
							<td class="goods_option">
								<div>
									<input type="text" name="option_basic_name" placeholder="옵션 명 ex)컬러">
									<button type="button" onclick="add_option()">+</button>
								</div>
								<table>
									<thead>
										<tr>
											<td>이름</td>
											<td>가격</td>
											<td>상태</td>
											<td>삭제</td>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>상품 설명</td>
							<td>
								<textarea name="ir1" id="ir1" rows="10" cols="100"></textarea>
							</td>
						</tr>
						<tr>
							<td>상품 이미지</td>
							<td class="image_preview">
								<input class="file_class" onchange="addfile(this);" id="file_input" name="product_image[]" type='file' multiple='multiple' accept="image/*">
								<ul class='att_zone'>
									<span>파일을 첨부 하려면 파일 선택 버튼을 클릭하거나 파일을 드래그앤드롭 하세요.</span>
								</ul>
							</td>
						</tr>
						<tr>
							<td colspan="2" class="add_but">
								<button type="button" onclick="data_upload()">확인</button>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="footer_text"><?php echo $server_footer; ?></div>
		</div>
	</div>
</script>
</script>
</body>
</html>