$(function() { 
	$(".goods_top_img_collection img").mouseover(function(){ 
		$(".goods_main_img").attr("src", this.src);
		$(".goods_top_img_collection img").css("border", "none");
		$(".goods_top_img_collection img").css("opacity", "0.4");
		this.style.border="2px solid rgb(0, 0, 0)";
		this.style.opacity="1";
	});
});

function option(){
	const option = $("select[name=option_select]").val();
	$("select[name=option_select]").val("none");
	const view = $(".option_tr td");
	const list = $(".option_goods");
	const product_price = $("#product_price").val();
	if(option !== "none"){
		if(!$("#opstion_id_"+option).length){
			if(view.css("display") !== "table-cell"){
				view.css("display", "table-cell");
			}
			$.ajax({
				url: 'option.php',
				type: 'post',
				dataType: 'json',
				data:{
					'option_id': option,
					'goods_id': getParameters("id")
				},
				success:function(data){
					const price = Number(data[1])+Number(product_price);
					list.append(
						'<li id="opstion_id_'+data[2]+'" data-id="'+data[2]+'">'+
							'<input type="hidden" id="option_price_'+data[2]+'" value="'+data[1]+'">'+
							'<div>'+data[0]+'</div>'+
							'<div class="option_bottom">'+
								'<span class="count">'+
									'<button onclick="option_count(\'down\', '+data[2]+')" type="button">-</button>'+
									'<input oninput="number_check(this, '+data[2]+')" name="option_count_'+data[2]+'" type="number" value="1">'+
									'<button onclick="option_count(\'up\', '+data[2]+')" type="button">+</button>'+
								'</span>'+
								'<span class="option_right">'+
									'<span><strong class="product_price_'+data[2]+'">'+String(price).replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'</strong>원</span>'+
									'<img onclick="option_delete('+data[2]+')" class="option_delete" src="../img/main_img/x.svg">'+
								'</span>'+
							'</div>'+
						'</li>'
					);
					option_all_price();
				}
			});
		}else{
			alert("이미 선택한 옵션입니다.");
		}
	}
}

function option_delete(id){
	const option_goods_ul = $(".option_goods");
	$("#opstion_id_"+id).remove();
	if(option_goods_ul.children().length === 0){
		$(".option_tr td").css("display", "none");
	}
	option_all_price();
}

let getParameters = function (paramName) {
	let returnValue;
	let url = location.href;
	let parameters = (url.slice(url.indexOf('?') + 1, url.length)).split('&');

	for (let i = 0; i < parameters.length; i++) {
		let varName = parameters[i].split('=')[0];
		if (varName.toUpperCase() == paramName.toUpperCase()) {
			returnValue = parameters[i].split('=')[1];
			return decodeURIComponent(returnValue);
		}
	}
};

function option_count(type, id){
	const count = $("input[name=option_count_"+id+"]");
	const product_price_view = $(".product_price_"+id);
	const product_price = $("#product_price").val();
	const option_price = $("#option_price_"+id).val();
	if(isNaN(count.val())){
		count.val(1);
	}
	if(isNaN(count.val()) || count.val().length <= 0 || count.val() < 1){
		count.val(1);
	}
	if(isNaN(count.val()) || count.val().length > 3 || count.val() > 999){
		count.val(999);
	}
	if(type==="up"){
		if(count.val() < 999){
			count.val(Number(count.val())+1);
		}
	}else if(type==="down"){
		if(count.val() > 1){
			count.val(Number(count.val())-1);
		}
	}
	product_price_view.text( String((Number(product_price) + Number(option_price)) * Number(count.val())).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
	option_all_price();
}

function number_check(obj, id){ //숫자만 가능하게
	if(isNaN(obj.value) || obj.value.length <= 0 || obj.value < 1){
		obj.value = 1;
	}
	if(isNaN(obj.value) || obj.value.length > 3 || obj.value > 999){
		obj.value = 999;
	}
	
	const product_price_view = $(".product_price_"+id);
	const count = $("input[name=option_count_"+id+"]");
	const product_price = $("#product_price").val();
	const option_price = $("#option_price_"+id).val();

	product_price_view.text( String((Number(product_price) + Number(option_price)) * Number(count.val())).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
	option_all_price();
}

function option_all_price(){
	if($(".option_goods").children().length <= 0){
		$(".all_price").text("0");
		return;
	}
	let all_price = 0;
	const product_price = $("#product_price").val();
	$(".option_goods").children().each(function(){
		const id = $(this).data("id");
		const count = $("input[name=option_count_"+id+"]").val();
		const option_price = $("#option_price_"+id).val();

		all_price += (Number(product_price) + Number(option_price)) * Number(count);
	});
	$(".all_price").text(String(all_price).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}

function goods_count(type){
	const count = $("input[name=goods_count]");
	const product_price = $("#product_price").val();
	if(isNaN(count.val())){
		count.val(1);
	}
	if(isNaN(count.val()) || count.val().length <= 0 || count.val() < 1){
		count.val(1);
	}
	if(isNaN(count.val()) || count.val().length > 3 || count.val() > 999){
		count.val(999);
	}
	if(type==="up"){
		if(count.val() < 999){
			count.val(Number(count.val())+1);
		}
	}else if(type==="down"){
		if(count.val() > 1){
			count.val(Number(count.val())-1);
		}
	}
	$(".all_price").text( String(Number(product_price) * Number(count.val())).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}

function goods_number_check(obj){ //숫자만 가능하게
	if(isNaN(obj.value) || obj.value.length <= 0 || obj.value < 1){
		obj.value = 1;
	}
	if(isNaN(obj.value) || obj.value.length > 3 || obj.value > 999){
		obj.value = 999;
	}

	const count = $("input[name=goods_count]");
	const product_price = $("#product_price").val();

	$(".all_price").text( String(Number(product_price) * Number(count.val())).replace(/\B(?=(\d{3})+(?!\d))/g, ","));
}