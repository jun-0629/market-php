function password_find_but(){
	const radio_check = $("input[name='find']:checked").val(),
	id = $("input[name=id]").val(), 
	name = $("input[name=name]").val();
	let data = "";

	if(id.length <= 0){
		$("input[name='id']").focus();
		alert("아이디를 입력해 주세요.");
		return
	}

	if(name.length <= 0){
		$("input[name='name']").focus();
		alert("이름을 입력해 주세요.");
		return
	}

	if(radio_check === "email"){
		const email_rule = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
		const email = $("input[name=email]").val();
		if(email.length > 0){
			if(email_rule.test(email)){
				data = $("input[name=email]").val();
			}else{
				$("input[name='email']").focus();
				alert("이메일 형식으로 작성해 주세요.");
				return
			}
		}else{
			$("input[name='email']").focus();
			alert("이메일을 입력해주세요.");
			return
		}
	}else if(radio_check === "hand_phone"){
		const hand_phone_1 = $("input[name='hand_phone_1']").val();
		const hand_phone_2 = $("input[name='hand_phone_2']").val();
		const hand_phone_3 = $("input[name='hand_phone_3']").val();
		const num_rule = /^[0-9]+$/;
		if(hand_phone_1.length === 0 || hand_phone_2.length === 0 || hand_phone_3.length === 0){
			$("input[name='hand_phone_1']").focus();
			alert('휴대전화 번호를 입력해주세요.');
			return
		}else if(hand_phone_1.length != 3){
			$("input[name='hand_phone_1']").focus();
			alert('휴대전화 번호 첫 번째 항목을 3자로 해주세요.');
			return
		}else if(hand_phone_2.length != 4){
			$("input[name='hand_phone_2']").focus();
			alert('휴대전화 번호 두 번째 항목을 4자로 해주세요.');
			return
		}else if(hand_phone_3.length != 4){
			$("input[name='hand_phone_3']").focus();
			alert('휴대전화 번호 세 번째 항목을 4자로 해주세요.');
			return
		}else if(!num_rule.test(hand_phone_1) || !num_rule.test(hand_phone_2) || !num_rule.test(hand_phone_3)){
			$("input[name='hand_phone_1']").focus();
			alert('휴대전화 번호는 숫자만 입력이 가능합니다.');
			return
		}else{
			data = hand_phone_1+"-"+hand_phone_2+"-"+hand_phone_3;
		}
	}

	document.find_password_form.submit();
}