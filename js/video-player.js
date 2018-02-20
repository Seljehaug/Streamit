$(function(){
	var video_container = $(".player")[0]; // Converting from jquery object to DOM object
	var video = $("#video")[0];
	var toggle_play = $(".btn-toggle-play");
	var seek_slider = $(".seek-slider");
	var current_time = $(".current-time");
	var duration = $(".duration");
	var toggle_mute = $(".btn-toggle-mute");
	var volume_slider = $(".volume-slider");
	var toggle_fullscreen = $(".btn-toggle-fullscreen");
	var player_controls = $(".player-controls");
	var player_width = $(".player").width();
	var player_height = $(".player").height();
	var saved_volume_level;
	// Fix minutes showing NaN before pressing play
	$("#video").on("loadedmetadata", function() {
		video.currentTime = 0;
		current_time.html("00:00");
		var duration_mins = Math.floor(video.duration / 60);
		var duration_seconds = Math.round(video.duration - duration_mins * 60);
		if(duration_mins < 10) { duration_mins = "0" + duration_mins; }
		if(duration_seconds < 10) { duration_seconds = "0" + duration_seconds; }
		duration.html(duration_mins + ":" + duration_seconds);
	});

	toggle_play.on("click", function(){
		togglePlay();
	});

	seek_slider.on("input", function(){
		videoSeek();
	});

	$("#video").on("timeupdate", function(){
		updateSeekSlider();
	});

	toggle_mute.on("click", function(){
		toggleMute();
	});

	volume_slider.on("input", function(){
		setVolume();
	});

	toggle_fullscreen.on("click", function(){
		toggleFullScreen();
	});

	$(".player").on("mousemove", function(e){
		if(is_fullscreen){
			if( (e.pageX <= 3) || (e.pageX >= ($(window).width() - 3)) || (e.pageY <= 3) ) {
				console.log(e.pageX);
				hideControls();
			}else{
				showControls();
			}
		}
	});

	// Check if mobile or tablet
	if (/Mobi/i.test(navigator.userAgent) || /Anroid/i.test(navigator.userAgent)) {
		// console.log("mobile");
	}

	$(".player").on("touchend", function(e){
		if(is_fullscreen){
			var clicked = $(e.target);
			if(!(clicked.parent().is(".player-controls"))){
				e.preventDefault();
				$(".player-controls").toggleClass("show");
			}
		}
	});

	function showControls(){ $(".player-controls").addClass("show"); }
	function hideControls(){ $(".player-controls").removeClass("show"); }

	function togglePlay(){
		if(video.paused){
			video.play();
			toggle_play.removeClass("icon-play");
			toggle_play.addClass("icon-pause");
		}else{
			video.pause();
			toggle_play.removeClass("icon-pause");
			toggle_play.addClass("icon-play");
		}
	}

	function videoSeek(){
		var seek_to = video.duration * (seek_slider.val() / 100);
		video.currentTime = seek_to;
	}

	function updateSeekSlider(){
		var new_time = video.currentTime * (100 / video.duration);
		seek_slider.val(new_time);

		var current_mins = Math.floor(video.currentTime / 60);
		var current_seconds = Math.floor(video.currentTime - current_mins * 60);
		var duration_mins = Math.floor(video.duration / 60);
		var duration_seconds = Math.round(video.duration - duration_mins * 60);
		if(current_mins < 10) { current_mins = "0" + current_mins; }
		if(current_seconds < 10) { current_seconds = "0" + current_seconds; }
		if(duration_mins < 10) { duration_mins = "0" + duration_mins; }
		if(duration_seconds < 10) { duration_seconds = "0" + duration_seconds; }

		current_time.html(current_mins + ":" + current_seconds);
		duration.html(duration_mins + ":" + duration_seconds);
	}

	function toggleMute(){
		saved_volume_level = video.volume;
		if(video.muted){
			video.muted = false;
			volume_slider.val(saved_volume_level * 100);
			toggle_mute.removeClass("icon-volume-off");
			toggle_mute.addClass("icon-volume-on");
		}
		else {
			video.muted = true;
			volume_slider.val(0);
			toggle_mute.removeClass("icon-volume-on");
			toggle_mute.addClass("icon-volume-off");
		}
	}

	function setVolume(){
		video.volume = volume_slider.val() / 100;
		if(video.volume === 0){
			video.muted = true;
			toggle_mute.removeClass("icon-volume-on");
			toggle_mute.addClass("icon-volume-off");
		}
		if(video.volume > 0){
			video.muted = false;
			toggle_mute.removeClass("icon-volume-off");
			toggle_mute.addClass("icon-volume-on");
		}
	}

	var is_fullscreen = false;
	function toggleFullScreen(){
		if(!is_fullscreen){
			if(video_container.requestFullScreen){
				video_container.requestFullScreen();
			}
			else if (video_container.webkitRequestFullScreen){
				video_container.webkitRequestFullScreen();
			}
			else if (video_container.mozRequestFullScreen){
				video_container.mozRequestFullScreen();
			}
			else if(video_container.msRequestFullscreen){
				video_container.msRequestFullscreen();
			}
			is_fullscreen = true;
			$(".player").addClass("full-screen-active");
		}
		else{
			if(document.cancelFullScreen) {
				document.cancelFullScreen();
			}
			else if(document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			}
			else if(document.webkitCancelFullScreen) {
				document.webkitCancelFullScreen();
			}
			else if(document.msCancelFullScreen){
				document.msCancelFullScreen();
			}
			is_fullscreen = false;
			$(".player").removeClass("full-screen-active");
			}
		}
});
