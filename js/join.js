function join_event(){
	const id = $("input[name=id]").val();
	const password = $("input[name=password]").val();
	const password_check = $("input[name=password_check]").val();
	const name = $("input[name=name]").val();
	const birthday_y = $("select[name=birthday_y]").val();
	const birthday_m = $("select[name=birthday_m]").val();
	const birthday_d = $("select[name=birthday_d]").val();
	const email = $("input[name=email]").val();
	const zip_code = $("input[name=zip_code]").val();
	const address = $("input[name=address]").val();
	const hand_phone_1 = $("select[name=hand_phone_1]").val();
	const hand_phone_2 = $("input[name=hand_phone_2]").val();
	const hand_phone_3 = $("input[name=hand_phone_3]").val();
	const terms_of_service =  $('input[name=terms_of_service]').is(":checked");
	const privacy =  $('input[name=privacy]').is(":checked");
	const id_rule = /^.*(?=^.{5,15}$)[a-zA-Z]+[a-zA-Z0-9]/;
	const password_rule = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;
	const email_rule = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;

	if(id.length <= 0){
		$('input[name=id]').focus();
		alert("아이디를 입력해 주세요.");
	}else if(!id_rule.test(id)){
		$('input[name=id]').focus();
		alert("아이디는 영문자로 시작하는 5~15자 영문자 또는 숫자이어야 합니다.");
	}else if(id_check_ajax(id) !== "success"){
		$('input[name=id]').focus();
		alert(id+"는 이미 사용중인 아이디입니다.");
	}else if(password.length <= 0){
		$('input[name=password]').focus();
		alert("비밀번호를 입력해 주세요.");
	}else if (!password_rule.test(password)){
		$('input[name=password]').focus();
		alert("비밀번호는 영문 대소문자/특수문자/숫자 포함 형태의 8~15자로 입력해 주세요.");
	}else if(password_check.length <= 0){
		$('input[name=password_check]').focus();
		alert("비밀번호 확인을 입력해 주세요.");
	}else if(password != password_check){
		$('input[name=password_check]').focus();
		alert("비밀번호와 비밀번호 확인이 일치하지 않습니다.");
	}else if(name.length <= 0){
		$('input[name=name]').focus();
		alert("이름을 입력해 주세요.");
	}else if(birthday_y=="default" || birthday_m=="default" || birthday_d=="default"){
		$('select[name=birthday_y]').focus();
		alert("생년월일을 선택해 주세요.");
	}else if(email.length <= 0){
		$('input[name=email]').focus();
		alert("이메일을 입력해 주세요.");
	}else if(!email_rule.test(email)){
		$('input[name=email]').focus();
		alert('이메일 형식으로 작성해 주세요.');
	}else if(zip_code.length !== 5 || address.length <= 0){
		$('input[name=zip_code]').focus();
		alert('주소를 입력해 주세요.');
	}else if(hand_phone_1.length <= 0 || hand_phone_2.length <= 0 || hand_phone_3.length <= 0){
		$('select[name=hand_phone_1]').focus();
		alert('핸드폰 번호를 입력해 주세요.');
	}else if(hand_phone_1.length !== 3 || hand_phone_2.length !== 4 || hand_phone_3.length !== 4){
		$('select[name=hand_phone_1]').focus();
		alert('핸드폰 번호를 제대로 입력해 주세요.');
	}else if(!terms_of_service){
		$('input[name=terms_of_service]').focus();
		alert('이용약관에 동의를 하셔야 회원가입을 하실 수 있습니다.');
	}else if(!privacy){
		$('input[name=privacy]').focus();
		alert('개인정보 수집 및 이용에 동의를 하셔야 회원가입을 하실 수 있습니다.');
	}else{
		document.join_post.submit();
	}
}

function moveFocus(num,here,next){
	let str = here.value.length;
	if(str == num){
		next.focus();
	}
}

function number_check(obj){
	obj.value=obj.value.replace(/[^0-9]/g,'');
}

function all_check_event(){
	const all_checkbox = $('input[id=all_check]').is(":checked");
	let check_bool = false;
	if(all_checkbox){
		check_bool = true;
	}

	$("input:checkbox[name=terms_of_service]").prop("checked", check_bool);
	$("input:checkbox[name=privacy]").prop("checked", check_bool);
	$("input:checkbox[name=sms_send]").prop("checked", check_bool);
	$("input:checkbox[name=email_send]").prop("checked", check_bool);
}

function checkbox_check(){
	const Terms_of_service = $('input[name=terms_of_service]').is(":checked");
	const privacy = $('input[name=privacy]').is(":checked");
	const sms_send = $('input[name=sms_send]').is(":checked");
	const email_send = $('input[name=email_send]').is(":checked");

	if(Terms_of_service && privacy && sms_send && email_send){
		$("input[id=all_check]").prop("checked", true);
	}else{
		$("input[id=all_check]").prop("checked", false);
	}
}

function id_check_view(obj){
	const id = $(obj).val();
	const check_view = $(".check_view");
	const id_rule = /^.*(?=^.{5,15}$)[a-zA-Z]+[a-zA-Z0-9]/;
	if(id.length > 0){
		if(id_rule.test(id)){
			const check = id_check_ajax(id);
			if(check === "success"){
				check_view.text(id+"는 사용 가능한 아이디입니다.");
				check_view.css("color", "rgb(0, 0, 0)");
			}else if(check === "overlap"){
				check_view.text(id+"는 이미 사용중인 아이디입니다.");
				check_view.css("color", "rgb(216, 86, 51)");
			}else{
				alert("아이디를 다시 입력해주세요.");
				check_view.text("");
				check_view.css("color", "rgb(216, 86, 51)");
			}
		}else{
			check_view.text("아이디는 영문자로 시작하는 5~15자 영문자 또는 숫자로 입력해 주세요.");
			check_view.css("color", "rgb(216, 86, 51)");
		}
	}else{
		check_view.text("아이디를 입력해 주세요.");
		check_view.css("color", "rgb(216, 86, 51)");
	}
}

function id_check_ajax(id){
	let return_data;
	$.ajax({
		url: 'id_duplicate_check.php',
		type: 'post',
		dataType: 'text',
		async: false,
		data:{
			'id': id
		},
		success:function(data){
			return_data = data;
		}
	});
	return return_data;
}

function password_check_event(){
	const password = $('input[name=password]').val();
	const password_check = $('input[name=password_check]').val();
	const passwrod_text = $('.password_check_view');
	const password_rule = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;

	if (password.length === 0 && password_check.length === 0) {
		passwrod_text.text('');
	}else{
		if(password.length > 0){
			if(password_check.length > 0){
				if (password !== password_check) {
					passwrod_text.css("color", "rgb(216, 86, 51)");
					passwrod_text.text('비밀번호가 일치하지 않습니다.');
				}else{
					if(password_rule.test(password)){
						passwrod_text.css("color", "rgb(0, 0, 0)");
						passwrod_text.text('비밀번호가 동일합니다.');
					}else{
						passwrod_text.css("color", "rgb(216, 86, 51)");
						passwrod_text.text('비밀번호는 영문 대소문자/특수문자/숫자 포함 형태의 8~15자로 입력해 주세요.');
					}
				}
			}else{
				passwrod_text.text('');
			}
		}else{
			passwrod_text.css("color", "rgb(216, 86, 51)");
			passwrod_text.text('비밀번호를 입력해 주세요.');
		}
	}
}