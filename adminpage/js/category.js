function cadd() { //카테고리 추가 버튼 이벤튼
	const input_category_name = $('input[name=add_name]').val();
	if(input_category_name.length <= 0){
		alert("카테고리 이름을 적어주세요.");
	}else if($("select[name=category_3]").val() == "none"){
		document.add.submit();
	}else{
		alert("카테고리 추가는 최대 3차 카테고리까지만 가능합니다.");
	}
	console.log($("select[name=category_2]").val());
}

function category_change(obj){ //카테고리 select태그 변경
	let select_data = $(obj).val();
	let category_num = select_data.length == 2 ? 2 : 3;
	let selete_name = $(obj).attr('name');
	let option_s = "";

	if(selete_name == "category_1"){
		$("select[name=category_2]").empty();
		$("select[name=category_3]").empty();
		option_s = $("<option value=\"none\">2차 카테고리</option>");
		$("select[name=category_2]").append(option_s);
		option_s = $("<option value=\"none\">3차 카테고리</option>");
		$("select[name=category_3]").append(option_s);
	}else if(selete_name == "category_2"){
		$("select[name=category_3]").empty();
		option_s = $("<option value=\"none\">3차 카테고리</option>");
		$("select[name=category_3]").append(option_s);
	}

	$.ajax({
		url: 'backend/category_select_change.php',
		type: 'post',
		dataType: 'json',
		data:{
			'category_key': select_data
		},
		success:function(data){
			if(data.length != 0){
				for(let index in data) {
					let option = $("<option value="+index+">"+data[index]+"</option>");
					$("select[name=category_"+category_num+"]").append(option);
				}
				if(!location.pathname.includes("category_delete.php")){
					$("select[name=category_3] option").prop('disabled',true);
				}
				$("select[name=category_3] option:eq(0)").prop('disabled',false);
			}
		}
	});
}

function category_loading(){ //카테고리 ul li추가
	let category_1 = $('select[name=category_1]').val();
	let category_2 = $('select[name=category_2]').val();
	let loading_key;
	if(category_1 == 'none'){ //1차 카테고리 불러오기
		loading_key = "none";
	}else if(category_2 == 'none'){ //2차 카테고리 불러오기
		loading_key = category_1;
	}else{ //3차 카테고리 불러오기
		loading_key = category_2;
	}

	$.ajax({
		url: 'backend/category_loading.php',
		type: 'post',
		dataType: 'json',
		data:{
			'category_loading_key': loading_key
		},
		success:function(data){
			if(data.length != 0){
				$(".category_change_view").empty();
				for(let index in data) {
					let li = $("<li class='ui-sortable-handle' data-id="+index.substr(1, 2)+">"+data[index]+"</li>");
					$(".category_change_view").append(li);
				}
			}
		}
	});
}

if($('.category_change_view').length){ //list 드래그 가능하게
	$(".category_change_view").sortable({
	});
}
 
function key_change(){ //카테고리 순서 변경 이벤트
	let count = 0;
	let key_json = new Object();
	$(".category_change_view").children().each(function(){
		let set_key_code = "";
		count++;
		if(count < 10){
			set_key_code = "0"+count.toString();
		}else{
			set_key_code = count.toString();
		}
		key_json[$(this).data("id").toString()] = set_key_code;
	});
	if(Object.keys(key_json).length > 0){
		$.ajax({
			url: 'backend/change.php',
			type: 'post',
			dataType: 'script',
			data:{
				'change_key': key_json
			}
		});
	}else{
		alert("순서를 변경할 카테고리를 선택해주세요.");
	}
}

function cdelete(){ //카테고리 삭제 이벤트
	let category_1_val = $("select[name=category_1]").val();
	let category_2_val = $("select[name=category_2]").val();
	let category_3_val = $("select[name=category_3]").val();
	if (category_1_val != "none" || category_2_val != "none" || category_3_val != "none") {
		document.delete.submit();
	}else{
		alert("삭제할 카테고리를 선택해주세요.");
	}
}