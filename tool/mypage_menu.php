<?php
	if(!isset($include_token) || $include_token !== "rY3NFSiEypbDOAgQ0D0KOmwj0B8A9IYsyPE/PM8pFg4agj19aM54JxWWhqOzYPrN"){
		die("<script>location.href='../index.php'; alert('잘못된 접근입니다.');</script>");
	}
?>
<div class="mypage_menu">
	<div class="member_name"><strong><?php echo $_SESSION["member"]; ?></strong>님</div>
	<div class="member_rating"><strong>일반회원</strong></div>
	<div class="mypage_view">마이페이지</div>
	<div><a href="">주문내역조회</a></div>
	<div class="bottom_line"><a href="">찜한 상품</a></div>
	<div><a href="">회원정보수정</a></div>
	<div><a href="">적립금</a></div>
	<div><a href="">Q&A</a></div>
	<div><a href="">배송 주소록 관리</a></div>
</div>