$(function(){
	$(".grid-item").click(function(e){
		$(".grid .grid-item").removeClass("selected");
		$(this).addClass("selected");
		var sibling;
		var height;

		$('html,body').animate({
			scrollTop: $(this).offset().top - 120},
		'1800');

		var item = $(this).closest(".grid-item");
		if ($(item).next().length) {
			// Set height to the same as next sibling
			sibling = item.next(".grid-item");
			height = sibling.height();
			item.css("height", height);
		}else{
			// does not have a next element, get height of previous instead
			sibling = item.prev(".grid-item");
			height = sibling.height();
			item.css("height", height);
		}

	});
});
