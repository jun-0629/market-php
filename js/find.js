$("input[name='find']:radio").change(function () {
	const data = this.value;
	if(data === "email"){
		$(".hand_phone_view").css("display", "none");
		$(".email_view").css("display", "block");
	}else if(data === "hand_phone"){
		$(".email_view").css("display", "none");
		$(".hand_phone_view").css("display", "block");
	}
});

function number_check(obj){
	obj.value=obj.value.replace(/[^0-9]/g,'');
}

function moveFocus(num,here,next){
	let str = here.value.length;
	if(str == num){
		$("input[name='"+next+"']").focus();
	}
}