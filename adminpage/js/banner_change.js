if($('.banner_change_view').length){ //list 드래그 가능하게
	$(".banner_change_view").sortable({
	});
}

function change_image(){
	const length = $(".banner_change_view li").length;
	let arr = [];
	if(length){
		$(".banner_change_view").children().each(function(){
			arr.push($(this).text());
		});
		$.ajax({
			url: 'banner_change_check.php',
			type: 'POST',
			data: {
				change: JSON.stringify(arr)
			},
			dataType: 'text',
			success:function(val){
				if(val==="success"){
					location.reload();
					alert("배너 순서를 변경했습니다.");
				}
			}
		});
	}else{
		alert("순서는 변경할 배너 이미지가 없습니다.");
	}
}