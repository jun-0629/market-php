<?php
	session_start();
	include_once "../tool/basic_data.php";
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$search = mysqli_real_escape_string($connect, htmlspecialchars(isset($_GET['search'])? $_GET['search'] : ''));
	$type = mysqli_real_escape_string($connect, htmlspecialchars(isset($_GET['type'])? $_GET['type'] : ''));

	if(strlen($search)===0){
		die("<script>location.href='member.php'; alert('검색할 상품 제목을 입력해 주세요.');</script>");
	}
	
	if(strlen($search)<2){
		die("<script>location.href='member.php'; alert('검색할 상품 제목을 2자 이상으로 입력해 주세요.');</script>");
	}

	if(!(
		$type === "id" || 
		$type === "email" || 
		$type === "name" || 
		$type === "address" || 
		$type === "hand_phone" || 
		$type === "phone_number" || 
		$type === "zip_code"
	)){
		die("<script>location.href='member.php'; alert('검색 타입이 잘못 설정되어 있습니다.');</script>");
	}

	$search_sql = "{$type} like '%{$search}%'";

	$count_sql = "select id, name, birthday, email, hand_phone from member where {$search_sql}";
	$count_res = $connect->query($count_sql) or die();

	if(!mysqli_num_rows($count_res)){
		die("<script>location.href='member.php'; alert('검색된 정보가 없습니다.');</script>");
	}

	$page = mysqli_real_escape_string($connect, htmlspecialchars(isset($_GET['page'])? $_GET['page'] : '')); //다음 페이지
	if(strlen($page) <= 0 && !is_numeric($page)){
		$page = 1;
	}

	$total_count = mysqli_num_rows($count_res);
	$number_of_data = 10; //데이터 보여줄 개수
	$page_view = 10; //페이지 이동 보여줄 개수
	$min_count = ($number_of_data*$page)-$number_of_data;

	$sql = "select id, name, birthday, email, hand_phone from member where {$search_sql} ORDER BY join_date DESC LIMIT {$min_count},{$number_of_data}";
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
	<link rel="stylesheet" href="../css/member.css">
	<script src="../js/member.js" defer></script>
</head>
<body>
	<div class="parents_div">
		<?php include_once "../tool/left_bar.php"; ?>
		<div class="right_bar">
			<div class="top_bar">
				<ul>
					<li><a href="member.php">전체목록</a></li>
				</ul>
				<a class="logout" href="../login/logout.php">로그아웃</a>
			</div>
			<div class="main_view">
				<div class="member_top">
					<h1>회원 관리</h1>
					<span class="search_view">
						<select name="search_type">
							<option value="id">아이디</option>
							<option value="email">이메일</option>
							<option value="name">이름</option>
							<option value="address">주소</option>
							<option value="cell_phone">핸드폰번호</option>
							<option value="phone_number">전화번호</option>
							<option value="zip_code">우편번호</option>
						</select>
						<input type="text" id="search" onkeyup="enter_search()">
						<button type="button" onclick="search_event()">검색</button>
					</span>
				</div>
				<div class="member_info">
					<table>
						<thead>
							<tr>
								<td>아이디</td>
								<td>이름</td>
								<td>생년월일</td>
								<td>이메일</td>
								<td>핸드폰 번호</td>
								<td>기타</td>
							</tr>
						</thead>
						<tbody>
							<?php
								while($data = mysqli_fetch_array($res)){
							?>
							<tr>
								<td><?php echo mb_substr($data["id"], '0', -4) . "****"; ?></td>
								<td><?php echo $data["name"]; ?></td>
								<td><?php echo $data["birthday"]; ?></td>
								<td><?php echo $data["email"]; ?></td>
								<td><?php echo $data["hand_phone"]; ?></td>
								<td>
									<a href="">강제탈퇴</a>
									<a href="">적립내역</a>
									<a href="member_more_information.php?id=<?php echo $data["id"]?>">상세보기</a>
								</td>
							</tr>
							<?php
								}
							?>
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