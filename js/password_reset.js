function find_cancel(){
	location.href='find_password.php';
}

function password_reset(){
	const password = $("input[name=password]").val();
	const password_check = $("input[name=password_check]").val();
	const password_rule = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;
	
	if(password.length <= 0){
		$('input[name=password]').focus();
		alert("새 비밀번호를 입력해주세요.");
	}else if (!password_rule.test(password)){
		$('input[name=password]').focus();
		alert("영문 대소문자/특수문자/숫자 포함 형태의 8~15자로 입력해 주세요.");
	}else if(password_check.length <= 0){
		$('input[name=password_check]').focus();
		alert("새 비밀번호 확인을 입력해주세요.");
	}else if(password != password_check){
		$('input[name=password_check]').focus();
		alert("새 비밀번호 확인이 정확하지 않습니다. 다시 입력해주세요.");
	}else if(confirm("비밀번호를 변경하시겠습니까?")){
		document.password_change_form.submit();
	}
}