function select_change_image(){
	const val = $("select[name=img_select]").val();
	if(val === "none"){
		$(".preview_img").attr("src", "");
	}else{
		$(".preview_img").attr("src", "../../img/slider/"+val);
	}
}

function banner_delete(){
	const val = $("select[name=img_select]").val();
	if(val === "none"){
		alert("제거할 사진을 선택해 주세요.");
	}else{
		document.image_delete.submit();
	}
}