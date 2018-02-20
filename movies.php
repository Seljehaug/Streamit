<!DOCTYPE html>
<html lang="en">

<head></head>
<title>StreamIt</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Google Font: Roboto-->
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
<!-- Styles-->
<link rel="stylesheet" type="text/css" href="css/normalize.css">
<link rel="stylesheet" type="text/css" href="css/styles.css">
<!-- jQuery 3.1.1-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<!-- imagesloaded plugin-->
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<!-- Custom js-->
<script src="js/grid-functionality.js"></script>
<script src="js/watchlist-update-from-grid.js"></script>

<?php
require_once("connect.php");

// Select all movies
$query = "SELECT titles.*, GROUP_CONCAT(genres.name) AS genre_names
	FROM titles
	INNER JOIN genres_in_titles ON genres_in_titles.title_id = titles.title_id
	INNER JOIN genres ON genres_in_titles.genre_id = genres.genre_id
	WHERE titles.type = 'movie'
	GROUP BY titles.title_id";
$stmnt = $db->query($query);
$movies = $stmnt->fetchAll(PDO::FETCH_OBJ);
?>

<body id="index">
	<div class="inner">
		<div id="navbar-wrapper">
			<div class="nav">
				<ul>
					<li class="logo"> <a href="index.php">Stream<span>It</span></a></li>
					<li class="link"><a href="movies.php">Movies</a></li>
					<li class="link"><a href="tv-shows.php">Tv-Shows</a></li>
				</ul>
				<div class="search">
					<input type="text" name="search" placeholder="Search">
				</div>
			</div>
		</div>
		<section class="grid">
			<?php foreach ($movies as $movie):
				$genres = explode(",", $movie->genre_names);
				$genres_formatted = implode(", ", $genres); ?>
				<div class="grid-item" id="<?=$movie->title_id?>">
					<div class="img"><img src="<?=$movie->main_img?>"></div>
					<div class="bkg-img" style="background-image: url('<?=$movie->background_img?>');"></div>
					<div class="overlay">
						<div class="info">
							<p class="title-text"><?=$movie->title_name?> <span class="year">(<?=$movie->year?>)</span></p>
							<p class="desc"><?=$movie->description?></p>
							<div class="info-bar">
								<p class="age-limit"><?=$movie->age?></p>
								<p class="duration"><?=$movie->duration?></p>
								<p class="genre"><?=$genres_formatted?></p>
							</div>
							<div class="buttons">
								<div class="btn btn-play"><span><a href="play.php">Play</a></span></div>
								<div class="btn watchlist-add"><span>Watchlist</span></div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach ?>
		</section>
	</div>
</body>

</html>
