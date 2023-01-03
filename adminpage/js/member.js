function search_event(){
	const type = $("select[name=search_type]").val();
	const search = $("#search").val();
	if(search.length <= 0){
		$("#search").focus();
		alert("검색할 정보를 입력해주세요.");
	}else if(search.length < 2){
		$("#search").focus();
		alert("검색할 정보를 2자 이상으로 입력해주세요.");
	}else{
		location.href='member_search.php?search='+search+'&type='+type;
	}
}

function enter_search(){
	if (window.event.keyCode == 13) {
		search_event();
	}
}