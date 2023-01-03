function preview(obj){
	let file = obj.files[0];
	let maxSize = 1024 * 1024;

	if (file.type.match('image.*')){
		if(file.size <= maxSize){
			let reader = new FileReader(); 
			reader.onload = function(e) {
				let _URL = window.URL || window.webkitURL;
				let img = new Image();
				img.src = _URL.createObjectURL(file);
				img.onload = function(){
					const width = img.width;
					const height = img.height;
					if(
						(width <= 700 && height <= 700)
					){
						$(".preview_img").attr("src", e.target.result);
					}else{
						$('input[name=image]').val('');
						$(".preview_img").attr("src", "");
						alert('이미지 사이즈는 가로 세로 최대 700px입니다.');
					}
				}
			}
			reader.readAsDataURL(file);
		}else{
			$('input[name=image]').val('');
			$(".preview_img").attr("src", "");
			alert(file.name+'의 이미지가 1MB 용량을 초과했습니다.');
		}
	}else{
		$('input[name=image]').val('');
		$(".preview_img").attr("src", "");
		alert('이미지 파일만 업로드 할 수 있습니다.');
	}
}

function popup_add_event(){
	let file = $("input[name=image]").val();

	if(file.length <= 0){
		$('input[name=image]').focus();
		alert("등록할 이미지를 선택해 주세요.");
	}else{
		document.popup_add.submit();
	}
}

function select_img_change(){
	const name = $("select[name=delete_img]").val();
	if(name === "none"){
		$(".preview_img").attr("src", "");
	}else{
		$(".preview_img").attr("src", "../../img/popup/"+name);
	}
}

function popup_delete_event(){
	const name = $("select[name=delete_img]").val();
	if(name === "none"){
		$("select[name=delete_img]").focus();
		alert("제거할 팝업 이미지를 선택해 주세요.");
	}else{
		document.popup_delete.submit();
	}
}

function reset_select_img_change(){
	const name = $("select[name=reset_img]").val();
	let url = $("select[name=reset_img]").find("option:selected").data("url");
	let mobile = $("select[name=reset_img]").find("option:selected").data("mobile");
	if(name === "none"){
		$(".preview_img").attr("src", "");
		$("input:checkbox[name=mobile]").prop("checked", false);
	}else{
		$(".preview_img").attr("src", "../../img/popup/"+name);
		$("input[name=url]").val(url);
		if(mobile===1){
			$("input:checkbox[name=mobile]").prop("checked", true);
		}else{
			$("input:checkbox[name=mobile]").prop("checked", false);
		}
	}
}

function popup_reset_event(){
	const name = $("select[name=reset_img]").val();
	if(name === "none"){
		$("select[name=reset_img]").focus();
		alert("수정할 팝업 이미지를 선택해 주세요.");
	}else{
		document.popup_reset.submit();
	}
}