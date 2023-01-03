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
		url: '../category/backend/category_select_change.php',
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
			}
		}
	});
}

let oEditors = []; //네이버 스마트에디터 설정
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "ir1",
	sSkinURI: "../tool/smarteditor/SmartEditor2Skin.html",
	fCreator: "createSEditor2",
	htParams: { fOnBeforeUnload : function(){}}
});

let storedFiles = []; //메인 이미지 설정
function addfile(obj){
	const att_zone_li = $(".att_zone").children('li').length;
	let num = [];
	$(".att_zone > span").remove();
	if(att_zone_li < 5 && att_zone_li+obj.files.length <= 5 && obj.files.length <= 5){
		let files = obj.files;
		
		for (let i = 0; i < files.length; i++) {
			let readImg = new FileReader();
			let file = files[i];
			let maxSize = 1024 * 1024;
			if (file.type.match('image.*')){
				if(file.size <= maxSize){
					readImg.onload = (function(file) {
						return function(e) {
							$(".att_zone").children().each(function(){
								num.push($(this).data("number"));
							});
							let arr_count = num.length > 0 ? Math.max.apply(null, num)+1 : 1;
							storedFiles[arr_count] = file;
							$('.att_zone').append(
							"<li data-number='"+arr_count+"' data-img_name>"+
								"<img src ='"+e.target.result+"'>"+
								"<div class='delete_goods_img' onclick='main_img_delete("+arr_count+")'>X</div>"+
							"</li>"
							);
						};
					})(file);
					readImg.readAsDataURL(file);
				}else{
					alert(file.name+'의 이미지가 1MB 용량을 초과했습니다.');
				}
			}else{
				alert('이미지 파일만 업로드 할 수 있습니다.');
			}
		}
	}else{
		alert('상품 이미지는 5개까지만 등록이 가능합니다.');
	}
}

//메인 이미지 드래그로 업로드 가능하게 해주는 이벤트
const drop = document.querySelector(".att_zone");
drop.ondrop = (e) => {
	e.preventDefault();

	const files = e.dataTransfer;
	addfile(files);
}
drop.ondragover = (e) => {
	e.preventDefault();
}

function main_img_delete(num){ //메인 이미지 선택 삭제
	const key = num;
	storedFiles[key] = "";
	$(".att_zone li[data-number="+num+"]").remove();
	if($(".att_zone li").length <= 0){
		$(".att_zone").append('<span>파일을 첨부 하려면 파일 선택 버튼을 클릭하거나 파일을 드래그앤드롭 하세요.</span>')
	}
}

if($('.att_zone').length){ //list 드래그 가능하게
	$(".att_zone").sortable({
	});
}

function number_check(obj){ //숫자만 가능하게
	obj.value=obj.value.replace(/[^0-9]/g,'');
}

function data_upload(){ //goods_add.php 에서 데이터 전송할때 쓰는 함수
	let data = new FormData();
	let count = 0,
	result = true;

	const title  = $("input[name=title]");
	const short_description  = $("input[name=short_description]");
	const member_price  = $("input[name=member_price]");
	const non_member_price  = $("input[name=non_member_price]");
	const delivery_fee  = $("input[name=delivery_fee]");
	const number_of_additional_shipping_costs  = $("input[name=number_of_additional_shipping_costs]");
	const origin  = $("input[name=origin]");
	const text_reserve  = $("input[name=text_reserve]");
	const image_reserve  = $("input[name=image_reserve]");
	const product_condition  = $("select[name=product_condition]");
	const category_1  = $("select[name=category_1]");
	const category_2  = $("select[name=category_2]");
	const category_3  = $("select[name=category_3]");
	const main_text  = oEditors.getById["ir1"].getIR();
	const att_zone_li = $(".att_zone").children('li').length;
	const option = $(".goods_option table tbody").children('tr').length;
	const option_basic_name = $("input[name=option_basic_name]");

	if(title.val().length <= 0){
		title.focus();
		alert("상품 이름을 입력해주세요.");
		return;
	}
	if(short_description.val().length <= 0){
		short_description.focus();
		alert("상품 설명을 입력해주세요.");
		return;
	}
	if(member_price.val().length <= 0){
		member_price.focus();
		alert("회원 가격을 입력해주세요.");
		return;
	}
	if(non_member_price.val().length <= 0){
		non_member_price.focus();
		alert("비회원 가격을 입력해주세요.");
		return;
	}
	if(delivery_fee.val().length <= 0){
		delivery_fee.focus();
		alert("배송비를 입력해주세요.");
		return;
	}
	if(number_of_additional_shipping_costs.val().length <= 0){
		number_of_additional_shipping_costs.focus();
		alert("배송비 추가 상품 개수를 입력해주세요.");
		return;
	}
	if(origin.val().length <= 0){
		origin.focus();
		alert("원산지를 입력해주세요.");
		return;
	}
	if(text_reserve.val().length <= 0){
		text_reserve.focus();
		alert("텍스트 리뷰 적립금을 입력해주세요.");
		return;
	}
	if(image_reserve.val().length <= 0){
		image_reserve.focus();
		alert("이미지 리뷰 적립금을 입력해주세요.");
		return;
	}
	if(!(product_condition.val() === "true" || product_condition.val() === "false")){
		product_condition.focus();
		alert("상품 상태를 제대로 선택해주세요.");
		return;
	}
	if(category_1.val() === "none" && category_2.val() === "none" && category_3.val() === "none"){
		category_1.focus();
		alert("카테고리를 선택해주세요.");
		return;
	}
	if(option > 0){
		let option_count = 0;
		if(option_basic_name.val().length > 0){
			$(".goods_option table tbody").children().each(function(){
				option_count++;
				const option_name = $(this).children('td:eq(0)').children('input[name=option_name]');
				const option_price = $(this).children('td:eq(1)').children('input[name=option_price]');
				const option_situation = $(this).children('td:eq(2)').children('select[name=option_situation]');
				if(option_name.val().length <= 0){
					option_name.focus();
					alert("옵션 "+option_count+"번에 옵션 이름을 입력해 주세요.");
					return false;
				}
				if(option_price.val().length <= 0){
					option_price.focus();
					alert("옵션 "+option_count+"번에 옵션 가격을 입력해 주세요.");
					return false;
				}
				if(!(option_situation.val() === "true" || option_situation.val() === "false")){
					option_situation.focus();
					alert("옵션 "+option_count+"번에 옵션 상태를 선택해 주세요.");
					return false;
				}
				if(option_count===option){
					result = false;
					return result;
				}
			});
		}else{
			option_basic_name.focus();
			alert("상품 옵션 기본 이름을 입력해 주세요.");
			return;
		}
	}else{
		result = false;
	}
	if(!result){
		if(main_text == "" || main_text == null || main_text == '&nbsp;' || main_text == '<br>' || main_text == '<br />' || main_text == '<p>&nbsp;</p>' || main_text == "<p><br></p>"){
			alert("상품 설명을 입력해주세요.");
			return;
		}
		if(att_zone_li <= 0){
			alert("상품 이미지를 등록해주세요.");
			return;
		}
		data.append('title', title.val());
		data.append('short_description', short_description.val());
		data.append('member_price', member_price.val());
		data.append('non_member_price', non_member_price.val());
		data.append('delivery_fee', delivery_fee.val());
		data.append('number_of_additional_shipping_costs', number_of_additional_shipping_costs.val());
		data.append('origin', origin.val());
		data.append('text_reserve', text_reserve.val());
		data.append('image_reserve', image_reserve.val());
		data.append('product_condition', product_condition.val());
		data.append('category_1', category_1.val());
		data.append('category_2', category_2.val());
		data.append('category_3', category_3.val());
		data.append('main_text', main_text);

		$(".att_zone").children().each(function(){
			data.append('img_'+count, storedFiles[$(this).data("number")]);
			count++;
		});

		let option_arr = [];
		$(".goods_option table tbody").children().each(function(){
			const option_name = $(this).children('td:eq(0)').children('input[name=option_name]').val();
			const option_price = $(this).children('td:eq(1)').children('input[name=option_price]').val();
			const option_situation = $(this).children('td:eq(2)').children('select[name=option_situation]').val();
			let jsonObj = new Object();
			jsonObj.basic_name = option_basic_name.val();
			jsonObj.name = option_name;
			jsonObj.price = option_price;
			jsonObj.situation = option_situation;
			option_arr.push(jsonObj);
		});
		data.append('option_json', JSON.stringify(option_arr));

		$.ajax({
			url: 'goods_add_check.php',
			type: 'POST',
			contentType: false,
			data: data,
			dataType: 'text',
			processData: false,
			cache: false,
			success:function(val){
				if(val.includes('success')){
					location.href='goods.php';
					alert('상품을 등록했습니다.');
				}
			}
		});
	}
}

function data_reset(){ //상품 수정 에서 데이터 전송할때 쓰는 함수
	let data = new FormData();
	let count = 1,
	img_arr = [],
	result = true;

	const title  = $("input[name=title]");
	const short_description  = $("input[name=short_description]");
	const member_price  = $("input[name=member_price]");
	const non_member_price  = $("input[name=non_member_price]");
	const delivery_fee  = $("input[name=delivery_fee]");
	const number_of_additional_shipping_costs  = $("input[name=number_of_additional_shipping_costs]");
	const origin  = $("input[name=origin]");
	const text_reserve  = $("input[name=text_reserve]");
	const image_reserve  = $("input[name=image_reserve]");
	const product_condition  = $("select[name=product_condition]");
	const category_1  = $("select[name=category_1]");
	const category_2  = $("select[name=category_2]");
	const category_3  = $("select[name=category_3]");
	const main_text  = oEditors.getById["ir1"].getIR();
	const att_zone_li = $(".att_zone").children('li').length;
	const option = $(".goods_option table tbody").children('tr').length;
	const option_basic_name = $("input[name=option_basic_name]");

	if(title.val().length <= 0){
		title.focus();
		alert("상품 이름을 입력해주세요.");
		return;
	}
	if(short_description.val().length <= 0){
		short_description.focus();
		alert("상품 설명을 입력해주세요.");
		return;
	}
	if(member_price.val().length <= 0){
		member_price.focus();
		alert("회원 가격을 입력해주세요.");
		return;
	}
	if(non_member_price.val().length <= 0){
		non_member_price.focus();
		alert("비회원 가격을 입력해주세요.");
		return;
	}
	if(delivery_fee.val().length <= 0){
		delivery_fee.focus();
		alert("배송비를 입력해주세요.");
		return;
	}
	if(number_of_additional_shipping_costs.val().length <= 0){
		number_of_additional_shipping_costs.focus();
		alert("배송비 추가 상품 개수를 입력해주세요.");
		return;
	}
	if(origin.val().length <= 0){
		origin.focus();
		alert("원산지를 입력해주세요.");
		return;
	}
	if(text_reserve.val().length <= 0){
		text_reserve.focus();
		alert("텍스트 리뷰 적립금을 입력해주세요.");
		return;
	}
	if(image_reserve.val().length <= 0){
		image_reserve.focus();
		alert("이미지 리뷰 적립금을 입력해주세요.");
		return;
	}
	if(!(product_condition.val() === "true" || product_condition.val() === "false")){
		product_condition.focus();
		alert("상품 상태를 제대로 선택해주세요.");
		return;
	}
	if(category_1.val() === "none" && category_2.val() === "none" && category_3.val() === "none"){
		category_1.focus();
		alert("카테고리를 선택해주세요.");
		return;
	}
	if(option > 0){
		let option_count = 0;
		if(option_basic_name.val().length > 0){
			$(".goods_option table tbody").children().each(function(){
				option_count++;
				const option_name = $(this).children('td:eq(0)').children('input[name=option_name]');
				const option_price = $(this).children('td:eq(1)').children('input[name=option_price]');
				const option_situation = $(this).children('td:eq(2)').children('select[name=option_situation]');
				if(option_name.val().length <= 0){
					option_name.focus();
					alert("옵션 "+option_count+"번에 옵션 이름을 입력해 주세요.");
					return false;
				}
				if(option_price.val().length <= 0){
					option_price.focus();
					alert("옵션 "+option_count+"번에 옵션 가격을 입력해 주세요.");
					return false;
				}
				if(!(option_situation.val() === "true" || option_situation.val() === "false")){
					option_situation.focus();
					alert("옵션 "+option_count+"번에 옵션 상태를 선택해 주세요.");
					return false;
				}
				if(option_count===option){
					result = false;
					return result;
				}
			});
		}else{
			option_basic_name.focus();
			alert("상품 옵션 기본 이름을 입력해 주세요.");
			return;
		}
	}else{
		result = false;
	}
	if(!result){
		if(main_text == "" || main_text == null || main_text == '&nbsp;' || main_text == '<br>' || main_text == '<br />' || main_text == '<p>&nbsp;</p>' || main_text == "<p><br></p>"){
			alert("상품 설명을 입력해주세요.");
			return;
		}
		if(att_zone_li <= 0){
			alert("상품 이미지를 등록해주세요.");
			return;
		}

		data.append('title', title.val());
		data.append('short_description', short_description.val());
		data.append('member_price', member_price.val());
		data.append('non_member_price', non_member_price.val());
		data.append('delivery_fee', delivery_fee.val());
		data.append('number_of_additional_shipping_costs', number_of_additional_shipping_costs.val());
		data.append('origin', origin.val());
		data.append('text_reserve', text_reserve.val());
		data.append('image_reserve', image_reserve.val());
		data.append('product_condition', product_condition.val());
		data.append('category_1', category_1.val());
		data.append('category_2', category_2.val());
		data.append('category_3', category_3.val());
		data.append('main_text', main_text);
		data.append('id', getParameter("id"));

		$(".att_zone").children().each(function(){
			let jsonObj = new Object();
			jsonObj.count = count;

			if($(this).data("img_name").length > 0){
				jsonObj.type = "existence";
				jsonObj.name = $(this).data("img_name");
			}else{
				data.append('img_'+count, storedFiles[$(this).data("number")]);
				jsonObj.type = "new";
			}
			count++;
			img_arr.push(jsonObj);
		});
		data.append('img_json', JSON.stringify(img_arr));

		let option_arr = [];
		$(".goods_option table tbody").children().each(function(){
			const option_name = $(this).children('td:eq(0)').children('input[name=option_name]').val();
			const option_price = $(this).children('td:eq(1)').children('input[name=option_price]').val();
			const option_situation = $(this).children('td:eq(2)').children('select[name=option_situation]').val();
			let jsonObj = new Object();
			jsonObj.basic_name = option_basic_name.val();
			jsonObj.name = option_name;
			jsonObj.price = option_price;
			jsonObj.situation = option_situation;
			option_arr.push(jsonObj);
		});
		data.append('option_json', JSON.stringify(option_arr));

		$.ajax({
			url: 'goods_modification_check.php',
			type: 'POST',
			contentType: false,
			data: data,
			dataType: 'text',
			processData: false,
			cache: false,
			success:function(val){
				if(val.includes('success')){
					location.reload();
					alert('상품을 수정했습니다.');
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

window.onload = function(){ //수정본에서 카테고리 기본 설정
	if(window.location.href.match("adminpage/goods/goods_modification.php")){
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
}

function add_option(){
	$(".goods_option table tbody").append(
		'<tr>'+
			'<td>'+
				'<input name="option_name" type="text">'+
			'</td>'+
			'<td>'+
				'<input name="option_price" oninput="number_check(this)" type="text">'+
			'</td>'+
			'<td>'+
				'<select name="option_situation">'+
					'<option value="true">판매</option>'+
					'<option value="false">품절</option>'+
				'</select>'+
			'</td>'+
			'<td>'+
				'<button type="button" onclick="delete_option(this)">x</button>'+
			'</td>'+
		'</tr>'
	);
}

function delete_option(obj){
	$(obj).closest('tr').remove();
}