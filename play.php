<!DOCTYPE html>
<html lang="en">

<head></head>
<title>StreamIt</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Google Font: Roboto-->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
<!-- Font Awesome -->
<script src="https://use.fontawesome.com/5314d8a4c9.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Styles-->
<link rel="stylesheet" type="text/css" href="css/normalize.css">
<link rel="stylesheet" type="text/css" href="css/styles.css">
<link rel="stylesheet" type="text/css" href="css/video-player.css">
<!-- jQuery 3.2.1-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<!-- Owl 2 -->
<link rel="stylesheet" href="lib/owl/owl.carousel.min.css">
<script src="lib/owl/owl.carousel.min.js"></script>
<!-- Custom js-->
<script src="js/video-player.js"></script>
<script src="js/custom-owl-carousel.js"></script>
<script src="js/watchlist-update.js"></script>

<?php
session_start();
// For the watchlist
$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'];

require_once("connect.php");
?>

<body id="video-player">
	<div class="inner">
		<div id="navbar-wrapper">
			<div class="nav">
				<ul>
					<li class="logo"><a href="index.php">Stream<span>It</span></a></li>
					<li class="link"><a href="movies.php">Movies</a></li>
					<li class="link"><a href="tv-shows.php">Tv-Shows</a></li>
				</ul>
				<div class="search">
					<input type="text" name="search" placeholder="Search">
				</div>
			</div>
		</div>

		<section class="player">
			<video id="video" src="video/interstellar.mp4" class="player-video viewer"></video>
			<div class="player-controls">
				<button class="btn-toggle-play icon icon-play">Play/pause</button>
				<input class="seek-slider" type="range" min="0" max="100" value="0" step="1">
				<p class="time"><span class="current-time"></span> / <span class="duration"></span></p>
				<button class="btn-toggle-mute icon icon-volume-on">Mute</button>
				<input class="volume-slider" type="range" min="0" max="100" value="100" step="1">
				<button class="btn-toggle-fullscreen icon icon-fullscreen">Full screen</button>
			</div>
		</section>

		<section class="suggestions titles-overview">
			<h2>You might also like...</h2>
			<?php
			// Select all titles in watchlist
			$query = "SELECT titles.*, GROUP_CONCAT(genres.name) AS genre_names
				FROM watchlists
				INNER JOIN titles on titles.title_id = watchlists.title_id
				INNER JOIN genres_in_titles ON genres_in_titles.title_id = titles.title_id
				INNER JOIN genres ON genres_in_titles.genre_id = genres.genre_id
				INNER JOIN users ON users.user_id = watchlists.user_id
				WHERE users.user_id = ?
				GROUP BY titles.title_id";
			$stmnt = $db->prepare($query);
			$stmnt->execute(array($user_id));
			$titles = $stmnt->fetchAll(PDO::FETCH_OBJ);?>

			<div id="carousel-watchlist" class="owl-carousel owl-theme">
				<?php foreach ($titles as $title):
					$genres = explode(",", $title->genre_names);
					$genres_formatted = implode(", ", $genres); ?>
					<div class="carousel-item" id="<?=$title->title_id?>">
						<div class="img"><img src="<?=$title->main_img?>"></div>
						<div class="bkg-img" style="background-image: url('<?=$title->background_img?>');"></div>
						<div class="overlay">
							<div class="info">
								<?php if ($title->type == "movie") { echo "<p class='title-text'>$title->title_name <span class='year'>($title->year)</span></p>"; }
								if($title->type == "tv") {  echo "<p class='title-text'>$title->title_name <span class='year'>($title->year - $title->year_end)</span></p>"; }?>
								<p class="desc"><?=$title->description?></p>
								<div class="info-bar">
									<p class="age-limit"><?=$title->age?></p>
									<?php
									if($title->duration != null){echo "<p class='duration'>$title->duration</p>";}
									if($title->seasons != null){echo "<p class='duration'>$title->seasons seasons</p>";}
									?>
									<p class="genre"><?=$genres_formatted?></p>
								</div>
								<div class="buttons">
									<div class="btn btn-play"><span>Play</span></div>
									<div class="btn watchlist-add"><span>Watchlist</span></div>
								</div>
								<i class="fa fa-times toggle-close"></i>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>

		</section>
	</div>
</body>
</html>
