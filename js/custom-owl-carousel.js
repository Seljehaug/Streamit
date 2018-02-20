// $(function() {
$(window).on("load", function(){
	var $owl = $('.owl-carousel');
   // Add data-position to all .item elements in carousel.
   // Used when centering the in-focus tile
	$owl.each(function(){
		$(this).children().each(function(i){
			$(this).attr("data-position", i);
		});
	});

	$owl.owlCarousel({
		center: true,
		loop: true,
      responsive: {
         0: {
            items: 3,
            slideBy: 3,
         },
         700: {
            items: 4,
            slideBy: 3,
         },
         1000: {
            items: 6,
            slideBy: 3,
         }
      },
		nav: true,
		navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		// autoHeight: true,
		autoWidth: true,
		responsiveRefreshRate: 200
	});

   // Set width for tiles and in-focus tile
   var width;
   var tile_width;
   calcWidth();
   var in_focus_width = tile_width * 3;
	// if(width < 500){
	// 	in_focus_width = tile_width * 2.95;
	// }

	$(".carousel-item").each(function() {
		$(this).css("width", tile_width);
	});

	$(window).resize(function(){
		calcWidth();
		$(".carousel-item").each(function() {
			$(this).css("width", tile_width);
		});
	});

	// Fix glitch where carousel-item has not height, therefore not showing background-image
	$(".owl-item").each(function() {
		// take height of image, all images should have same height
		var carousel_height = $(this).find(".carousel-item img").height();
		$(this).height(carousel_height);

		$(this).find('.owl-item').each(function(){
			$(this).height(carousel_height);
		});
	});

	$(".owl-carousel").on("click", ".carousel-item", function (e) {
		e.preventDefault();
		var target = e.target;
		var parent = $(this).closest(".owl-item");

		var parent_height = parent.height();
		$(this).closest(".owl-carousel").height(parent_height);
		$(this).closest(".owl-carousel .owl-stage-outer").height(parent_height);
		$(this).closest(".owl-carousel .owl-stage").height(parent_height);

		// Resize the tiles appropriately
		$(".owl-item").removeClass("in-focus");
		$(parent).addClass("in-focus");
		$(".carousel-item").removeClass("selected");
		$(this).addClass("selected");
		$(".carousel-item").attr("style", "width:" + tile_width + "px;");
		// Give parent's height to the carousel-item to avoid it having 0 height
		$(this).attr("style", "width:" + in_focus_width + "px!important; height:" + parent_height + "px;");

		// Center the in-focus tile properly
		// Bad solution, some carousels use different values for some reason....
		// Should find a generic fix that works the same for every carousel
		var active_carousel = $(this).closest(".owl-carousel");
		var carousel_id = $(active_carousel).attr("id");
		var count = active_carousel.find(".owl-item").not(".cloned").length;

		active_carousel.trigger('to.owl.carousel', $(this).data('position') + 1);

      if($(parent).hasClass("in-focus")){
			// Add a Close icon to close selected item
			// Go back to showing 3 items instead of 1 full-width item
			// console.log("has in focus");
			$(".toggle-close").click(function(e){
				e.stopPropagation();
				$(this).closest(parent).removeClass("in-focus");
				$(this).closest(".carousel-item").removeClass("selected");
				$(".carousel-item").attr("style", "width:" + tile_width + "px;");
			});
      }
	});

   // Get window width
   function calcWidth(){
      width = $(".owl-carousel").width();
      if(width > 1000){
         tile_width = (width / 6);
      } else if (width > 700){
         tile_width = (width / 4);
      } else {
         // tile_width = (width / 2.98225);
			tile_width = (width / 2.78525);
      }
   }
});
