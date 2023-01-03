function email_send(){
	$.ajax({
		url: 'email_send.php',
		type: 'post',
		async: false,
		dataType: 'json',
		success:function(data){
			alert(data["message"]);
		}
	});
}

function verification_check(){
	const certification_number = $("input[name=certification_number]").val();
	if(certification_number.length > 0){
		$.ajax({
			url: 'email_verification_check.php',
			type: 'post',
			async: false,
			dataType: 'json',
			data:{
				certification_number: certification_number
			},
			success:function(data){
				if(data["code"] === "0000" && data["message"] === "success"){
					location.href='password_reset.php';
				}else{
					alert(data["message"]);
				}
			}
		});
	}else{
		alert("인증번호를 입력해주세요.");
	}
}

function find_cancel(){
	location.href='find_password.php';
}