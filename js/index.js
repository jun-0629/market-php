$(document).ready(function(){
	$('.slider').bxSlider({
		auto: true,
		speed: 500,
		pause: 4000,
		stopAutoOnClick: false,
		controls: false,
		pauseOnFocus: false,
		touchEnabled: false
	});
});

function pop_close(num){
	$("#pop_id_"+num).remove();
}

function cookie_pop_close(num){
	setCookie("pop_id_"+num, "true", 1);
	$("#pop_id_"+num).remove();
}

$(function(){
	$('.pop_up').draggable();
});

function setCookie(key, value, expiredays) {
	let todayDate = new Date();
	todayDate.setDate(todayDate.getDate() + expiredays); // 현재 시각 + 일 단위로 쿠키 만료 날짜 변경
	document.cookie = key + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";";
}