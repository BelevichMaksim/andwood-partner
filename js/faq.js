const questions = $(".faq-questions-item__answer");

for (let item of questions) {
	$(item).data("height", $(item).height());
	$(item).data("isOpened", false);
	$(item).css("height", "0px");
}

$(".faq-questions-item-header__button").on("click", e => {
	let thisAnswer = $(e.currentTarget).parent().parent().find(".faq-questions-item__answer");
	if (!$(thisAnswer).data("isOpened")) {
		$(thisAnswer).css("height", `${$(thisAnswer).data("height") + 56}px`);
		$(thisAnswer).data("isOpened", true);
		$(e.currentTarget).addClass("faq-questions-item-header__button-opened");
	} else {
		$(thisAnswer).css("height", "0px");
		$(thisAnswer).data("isOpened", false);
		$(e.currentTarget).removeClass("faq-questions-item-header__button-opened");
	}
});