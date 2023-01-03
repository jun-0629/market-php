function search_event(){
	const search = $("#search").val();
	if(search.length > 0){
		if(search.length >= 2){
			location.href='goods_search.php?search='+search;
		}else{
			$("#search").focus();
			alert("검색할 상품 제목을 2자 이상으로 입력해 주세요.");
		}
	}else{
		$("#search").focus();
		alert("검색할 상품 제목을 입력해 주세요.");
	}
}

function enter_search(){
	if (window.event.keyCode == 13) {
		search_event();
	}
}