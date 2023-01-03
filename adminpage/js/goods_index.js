function goods_new_add(){
	const id = $("input[name=goods_id]").val();
	if(id.length <= 0){
		$("input[name=goods_id]").focus();
		alert("신규 상품을 등록할 상품의 ID를 입력해주세요.");
	}else if(isNaN(id)){
		$("input[name=goods_id]").focus();
		alert("숫자만 입력이 가능합니다.");
	}else{
		document.goods_view_check.submit();
	}
}

function number_check(obj){
	obj.value=obj.value.replace(/[^0-9]/g,'');
}

function goods_new_delete(){
	const id = $("select[name=goods_id]").val();
	if(id.length <= 0){
		$("select[name=goods_id]").focus();
		alert("새로고침 후 재시도 해주세요.");
	}else if(id == "none"){
		$("select[name=goods_id]").focus();
		alert("제거할 신규 상품 ID를 선택해 주세요.");
	}else{
		document.goods_view_check.submit();
	}
}