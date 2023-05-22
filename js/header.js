$(".burger-contacts").click(() => {
	$(".header-mobile").fadeIn(250);
});

$(".header-mobile__close").click(() => {
	$(".header-mobile").fadeOut(250);
});

$(".header-menu a").on("click", e => {
	$([document.documentElement, document.body]).animate({
		scrollTop: $($(e.target).attr("href")).offset().top - 140
	}, 100);
	return false;
});

$(".header-mobile-menu a").on("click", e => {
	$(".header-mobile").fadeOut(100);
	$([document.documentElement, document.body]).animate({
		scrollTop: $($(e.target).attr("href")).offset().top
	}, 100);
	return false;
});