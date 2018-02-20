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
<!-- Owl css, include before any js -->
<link rel="stylesheet" href="lib/owl/owl.carousel.min.css">
<!-- jQuery 3.2.1-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<!-- Owl js -->
<script src="lib/owl/owl.carousel.min.js"></script>
<!-- imagesloaded plugin-->
<script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
<!-- Custom js-->
<script src="js/custom-owl-carousel.js"></script>
<script src="js/watchlist-update.js"></script>

<?php
session_start();
// For the watchlist
$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'];

require_once("connect.php");
?>

<body id="index">
<div class="inner">
	<div id="navbar-wrapper">
		<div class="nav">
			<ul>
				<li class="logo"><a href="index.php">Stream<span>It</span></a></li>
				<li class="link"><a href="movies.php">Movies</a></li>
				<li class="link"><a href="tv-shows.php">Tv-Shows</a></li>
				<!-- <li class="link"><a href="#">Profile</a></li> -->
			</ul>
			<div class="search">
				<input type="text" name="search" placeholder="Search">
			</div>
		</div>
	</div>

	<section class="titles-overview">
		<h2 class="category-heading">Watchlist</h2>
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
		$titles = $stmnt->fetchAll(PDO::FETCH_OBJ);
		?>
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

		<h2 class="category-heading">Sci-Fi and Fantasy</h2>
		<?php
		// sci fi and fantasy
		$query = "SELECT titles.*, GROUP_CONCAT(genres.name) AS genre_names
			FROM titles
			INNER JOIN genres_in_titles ON genres_in_titles.title_id = titles.title_id
			INNER JOIN genres ON genres_in_titles.genre_id = genres.genre_id
			WHERE genres.genre_id = 2 OR genres.genre_id = 5
			GROUP BY titles.title_id ";
		$stmnt = $db->query($query);
		$titles = $stmnt->fetchAll(PDO::FETCH_OBJ);
		?>
		<div id="carousel-scifi" class="owl-carousel owl-theme">
			<?php foreach ($titles as $title):
				$genres = explode(",", $title->genre_names);
				$genres_formatted = implode(", ", $genres); ?>
				<div class="carousel-item" id="<?=$title->title_id?>">
					<div class="img"><img src="<?=$title->main_img?>"></div>
					<div class="bkg-img" style="background-image: url('<?=$title->background_img?>');"></div>
					<div class="overlay">
						<div class="info">
							<p class="title-text"><?=$title->title_name?> <span class="year">(<?=$title->year?>)</span></p>
							<p class="desc"><?=$title->description?></p>
							<div class="info-bar">
								<p class="age-limit"><?=$title->age?></p>
								<p class="duration"><?=$title->duration?></p>
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
		</diV>

		<h2 class="category-heading">Action Movies</h2>
		<?php
		// Action movies
		$query = "SELECT titles.*, GROUP_CONCAT(genres.name) AS genre_names
			FROM titles
			INNER JOIN genres_in_titles ON genres_in_titles.title_id = titles.title_id
			INNER JOIN genres ON genres_in_titles.genre_id = genres.genre_id
			WHERE genres.genre_id = 1 AND titles.type = 'movie'
			GROUP BY titles.title_id";
		$stmnt = $db->query($query);
		$titles = $stmnt->fetchAll(PDO::FETCH_OBJ);
		?>
		<div id="carousel-action" class="owl-carousel owl-theme">
			<?php foreach ($titles as $title):
				$genres = explode(",", $title->genre_names);
				$genres_formatted = implode(", ", $genres); ?>
				<div class="carousel-item" id="<?=$title->title_id?>">
					<div class="img"><img src="<?=$title->main_img?>"></div>
					<div class="bkg-img" style="background-image: url('<?=$title->background_img?>');"></div>
					<div class="overlay">
						<div class="info">
							<p class="title-text"><?=$title->title_name?> <span class="year">(<?=$title->year?>)</span></p>
							<p class="desc"><?=$title->description?></p>
							<div class="info-bar">
								<p class="age-limit"><?=$title->age?></p>
								<p class="duration"><?=$title->duration?></p>
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

		<h2 class="category-heading">Popular Tv-shows</h2>
		<?php
		// Tv shows
		$query = "SELECT titles.*, GROUP_CONCAT(genres.name) AS genre_names
			FROM titles
			INNER JOIN genres_in_titles ON genres_in_titles.title_id = titles.title_id
			INNER JOIN genres ON genres_in_titles.genre_id = genres.genre_id
			WHERE titles.type = 'tv'
			GROUP BY titles.title_id";
		$stmnt = $db->query($query);
		$titles = $stmnt->fetchAll(PDO::FETCH_OBJ);;
		?>
		<div id="carousel-tv-shows" class="owl-carousel owl-theme">
			<?php foreach ($titles as $title):
				$genres = explode(",", $title->genre_names);
				$genres_formatted = implode(", ", $genres); ?>
				<div class="carousel-item" id="<?=$title->title_id?>">
					<div class="img"><img src="<?=$title->main_img?>"></div>
					<div class="bkg-img" style="background-image: url('<?=$title->background_img?>');"></div>
					<div class="overlay">
						<div class="info">
							<p class="title-text"><?=$title->title_name?> <span class="year">(<?=$title->year?> - <?=$title->year_end?>)</span></p>
							<p class="desc"><?=$title->description?></p>
							<div class="info-bar">
								<p class="age-limit"><?=$title->age?></p>
								<p class="duration"><?=$title->seasons?></p>
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

	<!-- <footer>
		<p>&copy; 2017 Christoffer Seljehaug | cs_seljehaug@hotmail.com</p>
	</footer> -->
</div>
</body>
</html>
