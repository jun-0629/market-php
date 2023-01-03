function login_event(){
	const id = $("input[name=id]").val();
	const password = $("input[name=password]").val();
	if(id.length <= 0){
		$("input[name=id]").focus();
		alert("아이디를 입력해주세요.");
	}else if(password.length <= 0){
		$("input[name=password]").focus();
		alert("비밀번호를 입력해주세요.");
	}else{
		document.login_send.submit();
	}
}

function enter_event(){
	if(event.keyCode === 13){
		login_event();
	}
}