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
						(width === 1280 && height === 400) ||
						(width === 1920 && height === 600)
					){
						$(".preview_img").attr("src", e.target.result);
					}else{
						$('input[name=image]').val('');
						$(".preview_img").attr("src", "");
						alert(file.name+'의 이미지 비율이 맞지 않습니다.');
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

function upload_img_form(){
	let file = $("input[name=image]").val();
	if(file.length <= 0){
		$('input[name=image]').focus();
		alert("등록할 이미지를 선택해 주세요.");
	}else{
		document.image_add.submit();
	}
}