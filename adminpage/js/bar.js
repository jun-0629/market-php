$(document).ready(function() {
	let floatPosition = parseInt($("#move_div").css('top'));
	let div_height = parseInt($("#move_div").css('height'));
	$(window).scroll(function() {
		let max_height = parseInt($(".left_bar").css('height'));
		let scrollTop = $(window).scrollTop();
		let newPosition = scrollTop + "px";
		if(max_height-div_height > scrollTop){
			if(floatPosition < scrollTop){
				$("#move_div").css('top', newPosition);
			}else{
				$("#move_div").css('top', floatPosition+"px");
			}
		}
	}).scroll();
});