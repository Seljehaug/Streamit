$(function(){
	$(".owl-carousel").on("click", ".owl-item", function (e) {
		e.preventDefault();
		console.log("hello");
		var $carousel = $("#carousel-watchlist");

		// Calculate current width and height of other tiles
		width = $(".owl-carousel").width();
		var tile_width = (width / 6);
      if(width > 1000){ tile_width = (width / 6);}
		else if (width > 700){ tile_width = (width / 4);}
		else { tile_width = (width / 2.78525);}
		var tile_height = $(this).closest(".owl-item").height();

		$(".btn-play").on("click", function(){
			window.location.href = "play.php";
		});

		$(".watchlist-add").unbind().on("click", function(e) {
		// $(".watchlist-add").click(function(e) {
			e.stopPropagation();
			var id = $(this).closest(".carousel-item").attr("id");
			console.log("there");
			$.ajax({
				url: 'backend_watchlist.php',
				method: 'POST',
				data: {
					title_id: id
				},
				// async: false
			}).always(function(response){
				// console.log(response);
			}).done(function(response){
				// Get last data-position and increase by one
				var last_data_pos = 0;
				$("#carousel-watchlist").find(".owl-item").not(".cloned").find(".carousel-item").each(function(){
					var current_pos = $(this).attr("data-position");
					if(current_pos > last_data_pos){
						last_data_pos = current_pos;
					}
				});

				last_data_pos = parseInt(last_data_pos) + 1;

				if(response.task == "add"){
					var content = "<div class='carousel-item new-item' id='" + id + "' data-position='" + last_data_pos + "' style='width: " + tile_width + "px;'>";
					content += "<div class='img'> <img src='" + response.main_img + "' style='opacity: 1;'> </div>";
					content += "<div class='bkg-img' style='background-image: url(\"" + response.background_img + "\");'></div>";
					content += "<div class='overlay'>";
					content += "<div class='info'>";
					if(response.year_end !== null){ content += "<p class='title-text'>" + response.title_name + "<span class='year'> (" + response.year + " - " + response.year_end + ")</span></p>"; }
					else { content += "<p class='title-text'>" + response.title_name + "<span class='year'> (" + response.year + ")</span></p>"; }
					content += "<p class='desc'>" + response.description + "</p>";
					content += "<div class='info-bar'>";
					content += "<p class='age-limit'>" + response.age + "</p>";
					if(response.duration !== null){ content += "<p class='duration'>" + response.duration + "</p>"; }
					if(response.seasons !== null){ content += "<p class='duration'>" + response.seasons + " seasons</p>"; }
					content += "<p class='genre'>" + response.genre_names + "</p>";
					content += "</div>";
					content += "<div class='buttons'><div class='btn btn-play'><span>Play</span></div><div class='btn watchlist-add'><span>Watchlist</span></div></div><i class='fa fa-times toggle-close'></i>";
					content += "</div>";
					content += "</div>";
					content += "</div>";

					$carousel.owlCarousel('add', content).owlCarousel('update');
					$carousel.trigger("refresh.owl.carousel");
				}

				if(response.task == "delete"){
					$carousel.find("[id='"+ id +"']").closest(".owl-item").html("");
					$carousel.trigger("refresh.owl.carousel");
				}

				// If an item recently added to watchlist is clicked, remove it
				$(".new-item .btn.watchlist-add").click(function(){
					var delete_id = $(this).closest(".carousel-item").attr("id");
					console.log(delete_id);
					$(this).closest(".owl-carousel").find(".new-item#"+delete_id+"").closest(".owl-item").html("");
					$carousel.trigger("refresh.owl.carousel");
				});
			});
		});
	});
});
