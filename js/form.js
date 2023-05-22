let currentType = "";

const openModal = (type) => {
	currentType = type;

	if ($(".header-mobile").css("display") != "none") {
		$(".header-mobile").fadeOut(100);
	}

	if (type === "call") {
		$(".modal-body__header").text("ПЕРЕЗВОНИТЕ МНЕ");
		$(".g-modal-email").hide();
		$(".g-modal-email").removeAttr("required");
	} else {
		$(".modal-body__header").text("СТАТЬ ПАРТНЕРОМ?");
		$(".g-modal-email").show();
		$(".g-modal-email").attr("required", true);
	}

	$("html, body").css("overflow-y", "hidden");
	$(".modal").fadeIn(250);
}

$(".wallpaper-inner__button, .statistics__button, .quote2-content__button, .services__button").on("click", () => {
	openModal("partner");
});

$(".wallpaper-call, .contacts-wrapper__button, .header-mobile-social__button").on("click", () => {
	openModal("call");
});

$(".modal").on("click", e => {
	if ($(e.target).hasClass("modal")) {
		$("html, body").css("overflow-y", "auto");
		$(".modal").fadeOut(250, () => {
			$(".modal-body").show();
			$(".thanks-modal").hide();
			$(".modal input").val("");
		});
	}
});

$("input[name='phone']").on("focus", e => {
	if ($(e.target).val().trim() == "") {
		$(e.target).val("+ 7");
	}
});

$("input[name='phone']").on("keypress", e => {
	$(e.target).css("color", "black");
});

$("form").on("submit", e => {
	e.preventDefault();

	if ($(e.target).find("input[name='phone']").val().length < 4) {
		$(e.target).find("input[name='phone']").css("color", "red");
		return;
	}

	const formData = new FormData($(e.target)[0]);

	if ($(e.target).hasClass("main-form-wrapper")) {
		$(".modal-body").hide();
		$(".thanks-modal").show();
		$(".modal").fadeIn(250);
		$(".main-form-wrapper input").val("");
	} else {
		$(".modal-body").fadeOut(250, () => {
			$(".thanks-modal").fadeIn(250);
		});
	}

	ym(93309213,'reachGoal','send');

	$.ajax({
		url: '/amo/amo.php',
		type: 'POST',
		data: formData,
		success: function (data) {
			//console.log(data);
		},
		cache: false,
		contentType: false,
		processData: false,
		async: true
	});
});