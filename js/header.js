$(".category_name_ul li").hover(
	function () {
		$(this).find('ul').css("display", "block");
		$(this).find('ul li ul').css("display", "none");
		$(this).find("ul").css("min-height", $(this).closest("ul").css("height"));
	},
	function () { 
		$(this).find('ul').css("display", "none");
		$(this).find('ul li ul').css("display", "none");
	}
);