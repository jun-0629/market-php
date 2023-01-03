function find_id_but(){
	const name = $("input[name='name']").val();
	let radio_check = $("input[name='find']:checked").val();

	if(name.length > 0){
		if(radio_check === "email"){
			const email = $("input[name='email']").val();
			const email_rule = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
			if(email.length > 0){
				if(email_rule.test(email)){
					find_id_ajax(radio_check, name, email);
				}else{
					$("input[name='email']").focus();
					alert("이메일 형식으로 작성해 주세요.");
				}
			}else{
				$("input[name='email']").focus();
				alert("이메일을 입력해 주세요.");
			}
		}else if(radio_check === "hand_phone"){
			const hand_phone_1 = $("input[name='hand_phone_1']").val();
			const hand_phone_2 = $("input[name='hand_phone_2']").val();
			const hand_phone_3 = $("input[name='hand_phone_3']").val();
			const num_rule = /^[0-9]+$/;
			if(hand_phone_1.length === 0 || hand_phone_2.length === 0 || hand_phone_3.length === 0){
				$("input[name='hand_phone_1']").focus();
				alert('휴대전화 번호를 입력해주세요.');
			}else if(hand_phone_1.length != 3){
				$("input[name='hand_phone_1']").focus();
				alert('휴대전화 번호 첫 번째 항목을 3자로 해주세요.');
			}else if(hand_phone_2.length != 4){
				$("input[name='hand_phone_2']").focus();
				alert('휴대전화 번호 두 번째 항목을 4자로 해주세요.');
			}else if(hand_phone_3.length != 4){
				$("input[name='hand_phone_3']").focus();
				alert('휴대전화 번호 세 번째 항목을 4자로 해주세요.');
			}else if(!num_rule.test(hand_phone_1) || !num_rule.test(hand_phone_2) || !num_rule.test(hand_phone_3)){
				$("input[name='hand_phone_1']").focus();
				alert('휴대전화 번호는 숫자만 입력이 가능합니다.');
			}else{
				const data_type = hand_phone_1+"-"+hand_phone_2+"-"+hand_phone_3;
				find_id_ajax(radio_check, name, data_type);
			}
		}
	}else{
		$("input[name='name']").focus();
		alert("이름을 입력해 주세요.");
	}
}

function find_id_ajax(find_type, name, data_type){
	$.ajax({
		url: 'find_id_check.php',
		type: 'post',
		dataType: 'json',
		data:{
			'find_type': find_type,
			'name': name,
			'data_type': data_type
		},
		success:function(data){
			if(Object.keys(data).length != 0){
				if(find_type === "email"){
					$("td.data_type_output").text("이메일 :");
				}else if(find_type === "hand_phone"){
					$("td.data_type_output").text("휴대폰번호 :");
				}
				$("div.find_data_input_view").remove();
				$(".find_data_output_view").css("display", "block");
				$(".id_count_text").html("다음정보로 가입된 아이디가 총 <span class='emphasis'>"+Object.keys(data).length+"</span>개 있습니다.");
				$("td.name_data").text(name);
				$("td.email_data").text(data_type);
				for(let index in data) {
					$("table.data_info").append("<tr><td colspan='2'><input type='radio' name='find_id' id='"+index+"'><label for='"+index+"'>"+data[index]["id"]+"(개인회원, "+data[index]["join_date"]+" 가입)</label></td></tr>");
				}
				$("input:radio[name='find_id']#1").prop('checked', true); 
			}else{
				alert("입력하신 정보로 가입 된 회원 아이디는 존재하지 않습니다.");
			}
		}
	});
}