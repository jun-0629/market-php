window.onload = function(){ //수정본에서 카테고리 기본 설정
	let category_1 = $("select[name=category_1]").data("catagory");
	let category_2 = $("select[name=category_2]").data("catagory");
	let category_3 = $("select[name=category_3]").data("catagory");

	if(category_1.length > 0){
		$('select[name=category_1]').val(category_1).prop("selected",true);
		ajax_change(category_1, 2);
	}
	if(category_1.length > 0 && category_2.length > 0){
		category_2 = category_1+""+category_2;
		$('select[name=category_2]').val(category_2).prop("selected",true);
		ajax_change(category_2, 3);
	}
	if(category_1.length > 0 && category_2.length > 0 && category_3.length > 0){
		category_3 = category_2+""+category_3;
		$('select[name=category_3]').val(category_3).prop("selected",true);
	}

	function ajax_change(category_key, category_num){
		$.ajax({
			url: '../category/backend/category_select_change.php',
			type: 'post',
			async: false,
			dataType: 'json',
			data:{
				'category_key': category_key
			},
			success:function(data){
				if(data.length != 0){
					for(let index in data) {
						let option = $("<option value="+index+">"+data[index]+"</option>");
						$("select[name=category_"+category_num+"]").append(option);
					}
				}
			}
		});
	}
}

function goods_delete(){
	const id = getParameter("id");
	const password = $("input[name=password]").val();
	if(id.length <= 0){
		alert("잘못된 접근입니다.");
		return;
	}else if(password.length <= 0){
		$("input[name=password]").focus();
		alert("비밀번호를 입력해 주세요.");
		return;
	}else{
		$.ajax({
			url: 'goods_delete_check.php',
			type: 'post',
			dataType: 'text',
			data:{
				'id': id,
				'password': password
			},
			success:function(data){
				if(data.includes('wrong password')){
					$("input[name=password]").focus();
					alert('비밀번호가 틀렸습니다.');
				}else if(data.includes('success')){
					location.href='goods.php';
					alert('상품 ID: '+id+' 상품을 삭제했습니다.');
				}
			}
		});
	}
}

function getParameter(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}