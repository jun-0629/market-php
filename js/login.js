function login_check(){
	const id = $('input[name=id]').val();
	const password = $('input[name=password]').val();
	if(id.length != 0){
		if(password.length != 0){
			document.login.submit();
		}else{
			$('input[name=password]').focus();
			$('.id_check_text').text("");
			$('.password_check_text').text("비밀번호를 입력해 주세요.");
		}
	}else{
		$('input[name=id]').focus();
		$('.password_check_text').text("");
		$('.id_check_text').text("아이디를 입력해 주세요.");
	}
}

function enter_login(){
	if(event.keyCode === 13){
		login_check();
	}
}