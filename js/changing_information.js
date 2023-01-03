$(document).ready(function(){
	const y_e = new Number($('select[name=birthday_y]').data("y_early"));
	const m_e = new Number($('select[name=birthday_m]').data("m_early"));
	const d_e = new Number($('select[name=birthday_d]').data("d_early"));
	const hp = $('select[name=hand_phone_1]').data("hp");
	const pn = $('select[name=phone_number_1]').data("pn");
		
	$("select[name=birthday_y] option[value='"+y_e+"']").attr("selected", true);
	$("select[name=birthday_m] option[value='"+m_e+"']").attr("selected", true);
	$("select[name=birthday_d] option[value='"+d_e+"']").attr("selected", true);
	$("select[name=hand_phone_1] option[value='"+hp+"']").attr("selected", true);
	$("select[name=phone_number_1] option[value='"+pn+"']").attr("selected", true);
});

function number_check(obj){
	obj.value=obj.value.replace(/[^0-9]/g,'');
}

function moveFocus(num,here,next){
	let str = here.value.length;
	if(str == num){
		$("input[name="+next+"]").focus();
	}
}

function reset_event(){
	const name = $("input[name=name]").val();
	const birthday_y = $("select[name=birthday_y]").val();
	const birthday_m = $("select[name=birthday_m]").val();
	const birthday_d = $("select[name=birthday_d]").val();
	const email = $("input[name=email]").val();
	const zip_code =  $('input[name=zip_code]').val();
	const address =  $('input[name=address]').val();
	const hand_phone_2 =  $('input[name=hand_phone_2]').val();
	const hand_phone_3 =  $('input[name=hand_phone_3]').val();
	const sms_send = $('input:radio[name=sms_send]').is(':checked');
	const email_send = $('input:radio[name=email_send]').is(':checked');
	const current_password = $("input[name=current_password]").val();
	const new_password = $("input[name=new_password]").val();
	const new_password_check = $("input[name=new_password_check]").val();
	const email_rule = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
	const password_rule = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;

	if(name.length <= 0){
		$('input[name=name]').focus();
		alert("이름을 입력해 주세요.");
	}else if($(".password_change_view div").css("display") != "none" && current_password.length <= 0){
		$('input[name=current_password]').focus();
		alert("현재 비밀번호를 입력해 주세요.");
	}else if($(".password_change_view div").css("display") != "none" && new_password.length <= 0){
		$('input[name=new_password]').focus();
		alert("새 비밀번호를 입력해 주세요.");
	}else if ($(".password_change_view div").css("display") != "none" && !password_rule.test(new_password)){
		$('input[name=new_password]').focus();
		alert("새 비밀번호는 영문 대소문자/특수문자/숫자 포함 형태의 8~15자로 입력해 주세요.");
	}else if($(".password_change_view div").css("display") != "none" && new_password_check.length <= 0){
		$('input[name=new_password_check]').focus();
		alert("새 비밀번호 확인을 입력해 주세요.");
	}else if($(".password_change_view div").css("display") != "none" && new_password != new_password_check){
		$('input[name=new_password_check]').focus();
		alert("새 비밀번호와 새 비밀번호 확인이 일치하지 않습니다.");
	}else if(birthday_y === "default"){
		$("select[name=birthday_y]").focus();
		alert("생일에 년도를 선택해 주세요.");
	}else if(birthday_m === "default"){
		$("select[name=birthday_m]").focus();
		alert("생일에 월을 선택해 주세요.");
	}else if(birthday_d === "default"){
		$("select[name=birthday_d]").focus();
		alert("생일에 일을 선택해 주세요.");
	}else if(email.length <= 0){
		$('input[name=email]').focus();
		alert("이메일을 입력해 주세요.");
	}else if(!email_rule.test(email)){
		$('input[name=email]').focus();
		alert('이메일 형식으로 작성해 주세요.');
	}else if(zip_code.length <= 0 || address.length <= 0){
		$('input[name=zip_code]').focus();
		alert('주소를 입력해 주세요.');
	}else if(hand_phone_2.length <= 0 || hand_phone_3.length <= 0){
		$('input[name=hand_phone_2]').focus();
		alert('핸드폰 번호를 입력해 주세요.');
	}else if(hand_phone_2.length != 4 || hand_phone_3.length != 4 ){
		$('input[name=hand_phone_2]').focus();
		alert('핸드폰 번호를 제대로 입력해 주세요.');
	}else if(!sms_send){
		$('input:radio[name=sms_send]').focus();
		alert('SMS 수신여부를 선택해주세요.');
	}else if(!email_send){
		$('input:radio[name=email_send]').focus();
		alert('이메일 수신여부를 선택해주세요.');
	}else{
		document.data_resetting.submit();
	}
}

function pass_change(){
	const current_password = $("input[name=current_password]");
	const new_password = $("input[name=new_password]");
	const new_password_check = $("input[name=new_password_check]");
	current_password.val("");
	new_password.val("");
	new_password_check.val("");
	if(current_password.is(":disabled") && new_password.is(":disabled") && new_password_check.is(":disabled")){
		current_password.attr("disabled", false);
		new_password.attr("disabled", false);
		new_password_check.attr("disabled", false);
		$(".password_change_view div").css("display", "block");
		$("#essential_check").addClass("essential");
	}else{
		current_password.attr("disabled", true);
		new_password.attr("disabled", true);
		new_password_check.attr("disabled", true);
		$(".password_change_view div").css("display", "none");
		$("#essential_check").removeClass("essential");
	}
}