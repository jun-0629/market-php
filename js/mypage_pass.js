function pass_check(){
	const pass = $("input[name=check_password]").val();
	if(pass.length > 0){
		document.pass_check_form.submit();
	}else{
		alert("비밀번호를 입력해 주세요.");
	}
}