<?php
	session_start();
	include_once "../tool/basic_data.php";
	include_once "../tool/connect_db.php";

	if(!isset($_SESSION["admin"])){
		die("<script>location.href='../login/login.php'; alert('로그인 후 이용할 수 있습니다.');</script>");
	}

	$id = mysqli_real_escape_string($connect, htmlspecialchars(isset($_GET['id'])? $_GET['id'] : ''));

	if(strlen($id)===0){
		die("<script>location.href='member.php'; alert('잘못된 접근입니다.');</script>");
	}
	$sql = "select * from member where id = '{$id}'";
	$res = $connect->query($sql) or die();
	if(!mysqli_num_rows($res)){
		die("<script>location.href='member.php'; alert('{$id}의 아이디는 존재하지 않습니다.');</script>");
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
					<h1><?php echo $id; ?>의 정보</h1>
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
				<div class="member_more_information">
					<table>
						<tbody>
							<?php
								$data = mysqli_fetch_array($res);
							?>
							<tr>
								<td>아이디</td>
								<td><?php echo $data["id"]; ?></td>
							</tr>
							<tr>
								<td>이름</td>
								<td><?php echo $data["name"]; ?></td>
							</tr>
							<tr>
								<td>생년월일</td>
								<td><?php echo $data["birthday"]; ?></td>
							</tr>
							<tr>
								<td>이메일</td>
								<td><?php echo $data["email"]; ?></td>
							</tr>
							<tr>
								<td>우편번호</td>
								<td><?php echo $data["zip_code"]; ?></td>
							</tr>
							<tr>
								<td>주소</td>
								<td><?php echo $data["address"]; ?></td>
							</tr>
							<tr>
								<td>상세 주소</td>
								<td><?php echo $data["detailed_address"]; ?></td>
							</tr>
							<tr>
								<td>핸드폰 번호</td>
								<td><?php echo $data["hand_phone"]; ?></td>
							</tr>
							<tr>
								<td>전화번호</td>
								<td><?php echo $data["phone_number"]; ?></td>
							</tr>
							<tr>
								<td>적립금</td>
								<td></td>
							</tr>
							<tr>
								<td>가입일자</td>
								<td><?php echo $data["join_date"]; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="footer_text"><?php echo $server_footer; ?></div>
		</div>
	</div>
</body>
</html>