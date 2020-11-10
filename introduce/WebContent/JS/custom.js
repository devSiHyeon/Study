$(function () {
	var goPage;
	var topPos;

	$("nav li > a").click(function (e) {
		e.preventDefault();
		goPage = $(this).attr("href");
		// console.log(goPage);
		topPos = $(goPage).offset().top;
		// console.log(topPos);
		$("html, body").stop().animate({scrollTop: topPos}, 800);
	});

	$(window).scroll(function() {
		var t = $(this).scrollTop();
		var index = 0;
		$("nav li").removeClass("active");
		if(t < $("#career").offset().top) {
			$("nav li:eq(0)").addClass("active");
			index=0;
		} else if (t < $("#portfolio").offset().top) {
			$("nav li:eq(1)").addClass("active");
			index=1;
		} else if (t < $("#contact").offset().top) {
			$("nav li:eq(2)").addClass("active");
			index=2;
		} else {
			$("nav li:eq(3)").addClass("active");
			index=3;
		}
		$("nav li span").appendTo("nav li:eq(" + index + ") > a ");
	});

});

 