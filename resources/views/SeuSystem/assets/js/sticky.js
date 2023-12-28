//===== Sticky

$(window).on('scroll', function (event) {
	var scroll = $(window).scrollTop();
	if (scroll < 20) {
		$(".navbar-area").removeClass("sticky");
		$(".navbar-area img").attr("src", "site-assets/images/logo.png");
	} else {
		$(".navbar-area").addClass("sticky");
		$(".navbar-area img").attr("src", "site-assets/images/logo-orig.png");
	}
});
