<?php
	session_start();
	include_once "../tool/basic_data.php";
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$count_sql = "select deleted_or_not from goods where deleted_or_not = 0";
	$count_res = $connect->query($count_sql) or die();

	$page = mysqli_real_escape_string($connect, htmlspecialchars(isset($_GET['page'])? $_GET['page'] : '')); //다음 페이지
	if(strlen($page) <= 0 && !is_numeric($page)){
		$page = 1;
	}

	$total_count = mysqli_num_rows($count_res);
	$number_of_data = 5; //데이터 보여줄 개수
	$page_view = 10; //페이지 이동 보여줄 개수
	$min_count = ($number_of_data*$page)-$number_of_data;

	$sql = "select id, title, member_price, non_member_price, product_condition from goods where deleted_or_not = 0 ORDER BY id DESC LIMIT {$min_count},{$number_of_data}";
	$res = $connect->query($sql) or die();
	
	$page_count = ceil($total_count/$number_of_data);
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
	<div class="parents_div">
		<?php include_once "../tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li><a href="goods_add.php">상품 추가</a></li>
					<li><a href="goods_new.php">신규 상품 등록</a></li>
					<li><a href="goods_new_delete.php">신규 상품 제거</a></li>
					<li><a href="goods_sale.php">특가 할인 상품 등록</a></li>
					<li><a href="goods_sale_delete.php">특가 할인 상품 제거</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<div class="goods_top_view">
					<h1>상품 목록</h1>
					<span class="search_view">
						<input type="text" id="search" onkeyup="enter_search()" placeholder="상품 제목">
						<button type="button" onclick="search_event()">검색</button>
					</span>
				</div>
				<div class="goods_list">
					<table>
						<thead>
							<tr>
								<td>이미지</td>
								<td>제목</td>
								<td>가격</td>
								<td>상태</td>
								<td>별점</td>
								<td>기타</td>
							</tr>
						</thead>
						<tbody>
							<?php
								while($data = mysqli_fetch_array($res)){
							?>
							<tr>
								<td class="main_img">
									<?php
										$sql_img = "select url from goods_img where goods_id={$data['id']} and image_order='1'";
										$res_img = $connect->query($sql_img) or die();
									?>
									<img src="../../img/goods_main/<?php echo mysqli_fetch_array($res_img)["url"]; ?>">
								</td>
								<td>
									<?php echo $data["title"]; ?>
								</td>
								<td>
									<div class="member">회원 가격 : <?php echo number_format($data["member_price"]); ?>원</div>
									<div>비회원 가격 : <?php echo number_format($data["non_member_price"]); ?>원</div>
								</td>
								<td>
									<?php if($data["product_condition"]){?>
										판매중
									<?php }else{ ?>
										품절
									<?php } ?>
								</td>
								<td></td>
								<td>
									<div>
										<a href="goods_modification.php?id=<?php echo $data['id']; ?>">수정</a>
									</div>
									<div>
										<a href="goods_Information.php?id=<?php echo $data['id']; ?>">정보</a>
									</div>
									<div>
										<a href="goods_delete.php?id=<?php echo $data['id']; ?>">삭제</a>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="paga_view">
						<?php
							$for = ceil($page/$page_view);
							
							$for_min = ($page_view*($for))+1-$page_view;
							$for_max = ($page_view*($for));
							$for_max = $page_count < $for_max ? $page_count : $for_max;
							
							if(1 < $page){
						?>
							<a class="arrow" href="?page=1">《</a>
							<a class="arrow" href="?page=<?php echo $page-1; ?>">〈</a>
						<?php
							}
							for ($i=$for_min; $i <= $for_max; $i++) { 
						?>
						<a <?php if($page == $i){ echo "class='page_check'"; } ?> href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
						<?php
							}
						?>
						<?php
							if($page_count > $page){
						?>
						<a class="arrow" href="?page=<?php echo $page+1; ?>">〉</a>
						<a class="arrow" href="?page=<?php echo $page_count; ?>">》</a>
						<?php
							}
						?>
					</div>
				</div>
			</div>
			<div class="footer_text"><?php echo $server_footer; ?></div>
		</div>
	</div>
</body>
</html>