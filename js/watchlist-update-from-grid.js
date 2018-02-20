$(function(){
	$(".grid").on("click", ".grid-item", function (e) {
		e.preventDefault();
		console.log("hello");

		$(".btn-play").on("click", function(){
			window.location.href = "play.php";
		});

		$(".watchlist-add").unbind().on("click", function(e) {
			e.stopPropagation();
			var id = $(this).closest(".grid-item").attr("id");
			console.log("there");
			$.ajax({
				url: 'backend_watchlist.php',
				method: 'POST',
				data: {
					title_id: id
				},
			}).done(function(response){

			});
		});
	});
});
