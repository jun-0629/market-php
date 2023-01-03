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
		<h1>이용안내</h1>
		<div>
			<br>
			<div>
				<strong>회원가입 안내</strong>
				<div>
					[회원가입] 메뉴를 통해 이용약관, 개인정보보호정책 동의 및 일정 양식의 가입항목을 기입함으로써 회원에 가입되며, 가입 즉시 서비스를 무료로 이용하실 수 있습니다.<br>
					주문하실 때에 입력해야하는 각종 정보들을 일일이 입력하지 않으셔도 됩니다. 회원을 위한 이벤트 및 각종 할인행사에 참여하실 수 있습니다.
				</div>
			</div>
			<br>
			<div>
				<strong>주문 안내</strong>
				<div>
					상품주문은 다음단계로 이루어집니다.<br>
					<br>
					- Step1: 상품검색<br>
					- Step2: 장바구니에 담기<br>
					- Step3: 회원ID 로그인 또는 비회원 주문<br>
					- Step4: 주문서 작성<br>
					- Step5: 결제방법선택 및 결제<br>
					- Step6: 주문 성공 화면 (주문번호)<br>
					<br>
					비회원 주문인경우 6단계에서 주문번호와 승인번호(카드결제시)를 꼭 메모해 두시기 바랍니다. 단, 회원인 경우 자동 저장되므로 따로 관리하실 필요가 없습니다.<br>
				</div>
			</div>
			<br>
			<div>
				<strong>배송안내</strong>
				<div>
					배송 방법 : 택배<br>
					배송 지역 : 전국지역<br>
					배송 비용 : 가격마다 다름<br>
					배송 기간 : 2일 ~ 3일<br>
					배송 안내 : - 산간벽지나 도서지방은 별도의 추가금액을 지불하셔야 하는 경우가 있습니다.<br>
					고객님께서 주문하신 상품은 입금 확인후 배송해 드립니다. 다만, 상품종류에 따라서 상품의 배송이 다소 지연될 수 있습니다.<br>
				</div>
			</div>
			<br>
			<div>
				<strong>교환/반품 안내</strong>
				<div>
					신선식품은 특성상 반품(교환)이 절대 불가합니다.<br>
					물품 이상시 부분출고 및 부분환불 진행 물품수거 필요시 반품 진행합니다.<br>
				</div>
			</div>
		</div>
	</div>
	<?php include "../tool/footer.php"; ?>
</body>
</html>