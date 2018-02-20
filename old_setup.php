<?php
require_once("connect.php");

// Delete database if it already exists
$query = 'DROP DATABASE IF EXISTS test';
if ($db->exec($query)===false){
	die('Query failed(1):' . $db->errorInfo()[2]);
}

// Create database
$query = 'CREATE DATABASE IF NOT EXISTS test CHARACTER SET utf8 COLLATE utf8_general_ci';
// Runs query. Returns false if some error has happened.
// exec returns number of rows affected by the query. If query does not actually affect any rows
// this can be 0. Must therefore check for false to see if something wrong happened with the query
if ($db->exec($query)===false){
	die('Query failed(2):' . $db->errorInfo()[2]);
}

// Select the database
$query = 'USE test';
if ($db->exec($query)===false){
	die('Can not select db:' . $db->errorInfo()[2]);
}

// Delete users table if it alrady exists
$query = 'DROP TABLE IF EXISTS users';
if ($db->exec($query)===false){
	die('Query failed(3):' . $db->errorInfo()[2]);
}

// Create table for users
$query = 'CREATE TABLE IF NOT EXISTS users (
	user_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	mail varchar(100) NOT NULL,
	password varchar(255) NOT NULL
	)';

if ($db->exec($query)===false){
	die('Query failed(4):' . $db->errorInfo()[2]);
}

// Delete articles table if it already exists
// $query = 'DROP TABLE IF EXISTS movies';
// if ($db->exec($query)===false){
// 	die('Query failed(5):' . $db->errorInfo()[2]);
// }
//
// // Create articles table
// $query = 'CREATE TABLE IF NOT EXISTS movies (
// 	movie_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
// 	title varchar(250) NOT NULL,
// 	year int NOT NULL,
// 	description text,
// 	main_img varchar(250) NOT NULL,
// 	background_img varchar(250) NOT NULL,
// 	age int NOT NULL,
// 	duration varchar(100)
// 	)';
//
// if ($db->exec($query)===false){
// 	die('Query failed(6):' . $db->errorInfo()[2]);
// }

// Delete tv table if it already exists
// $query = 'DROP TABLE IF EXISTS tv';
// if ($db->exec($query)===false){
// 	die('Query failed(7):' . $db->errorInfo()[2]);
// }
//
// // Create tv table
// $query = 'CREATE TABLE IF NOT EXISTS tv (
// 	tv_show_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
// 	title varchar(250) NOT NULL,
// 	year_start int NOT NULL,
// 	year_end int,
// 	description text,
// 	main_img varchar(250) NOT NULL,
// 	background_img varchar(250) NOT NULL,
// 	age int NOT NULL,
// 	seasons int
// 	)';
//
// if ($db->exec($query)===false){
// 	die('Query failed(8):' . $db->errorInfo()[2]);
// }

// Create titles table
$query = 'CREATE TABLE IF NOT EXISTS titles (
	title_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title_name varchar(250) NOT NULL,
	type varchar (100) NOT NULL,
	year int NOT NULL,
	year_end int,
	description text,
	main_img varchar(250) NOT NULL,
	background_img varchar(250) NOT NULL,
	age int NOT NULL,
	duration int,
	seasons int
	)';

if ($db->exec($query)===false){
	die('Query failed(8):' . $db->errorInfo()[2]);
}


// Delete genres table if it alrady exists
$query = 'DROP TABLE IF EXISTS genres';
if ($db->exec($query)===false){
	die('Query failed(9):' . $db->errorInfo()[2]);
}

// Create genres table
$query = 'CREATE TABLE IF NOT EXISTS genres (
	genre_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name varchar(100) NOT NULL
	)';

if ($db->exec($query)===false){
	die('Query failed(10):' . $db->errorInfo()[2]);
}

// Delete genres_in_movies table if it alrady exists
// $query = 'DROP TABLE IF EXISTS genres_in_movies';
// if ($db->exec($query)===false){
// 	die('Query failed(11):' . $db->errorInfo()[2]);
// }
//
// // Create genres_in_movies table
// $query = 'CREATE TABLE IF NOT EXISTS genres_in_movies (
// 	genre_movie_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
// 	movie_id int(11) NOT NULL,
// 	genre_id int(11) NOT NULL,
// 	FOREIGN KEY (genre_id) REFERENCES genres (genre_id),
// 	FOREIGN KEY (movie_id) REFERENCES movies (movie_id)
// 	)';
//
// if ($db->exec($query)===false){
// 	die('Query failed(12):' . $db->errorInfo()[2]);
// }

// Delete genres_in_tv table if it alrady exists
// $query = 'DROP TABLE IF EXISTS genres_in_tv';
// if ($db->exec($query)===false){
// 	die('Query failed(13):' . $db->errorInfo()[2]);
// }
//
// // Create genres_in_tv table
// $query = 'CREATE TABLE IF NOT EXISTS genres_in_tv (
// 	genre_tv_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
// 	tv_show_id int(11) NOT NULL,
// 	genre_id int(11) NOT NULL,
// 	FOREIGN KEY (genre_id) REFERENCES genres (genre_id),
// 	FOREIGN KEY (tv_show_id) REFERENCES tv (tv_show_id)
// 	)';
//
// if ($db->exec($query)===false){
// 	die('Query failed(14):' . $db->errorInfo()[2]);
// }

// Delete genres_in_titles table if it alrady exists
$query = 'DROP TABLE IF EXISTS genres_in_titles';
if ($db->exec($query)===false){
	die('Query failed(15):' . $db->errorInfo()[2]);
}

// Create genres_in_titles table
$query = 'CREATE TABLE IF NOT EXISTS genres_in_titles (
	genre_title_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	title_id int(11) NOT NULL,
	genre_id int(11) NOT NULL,
	FOREIGN KEY (genre_id) REFERENCES genres (genre_id),
	FOREIGN KEY (title_id) REFERENCES titles (title_id)
	)';

if ($db->exec($query)===false){
	die('Query failed(16):' . $db->errorInfo()[2]);
}

// --------- INSERT DATA TO TABLES --------------
// Array containing user data
// All of these users have the same password: 'Password123'
$password = password_hash('Password123', PASSWORD_DEFAULT);
$users_array = array(
	array("cs_seljehaug@hotmail.com", $password)
);

// Inserting user data
$sql = "INSERT INTO users (mail, password) values (?,?)";
$query = $db->prepare($sql);

foreach($users_array as $user)
{
	$query->execute($user);
}

// Array containing movies
// $movies_array = array(
// 	array("The Departed", 2006, "An undercover cop and a mole in the police attempt to identify each other while infiltrating an Irish gang in South Boston",
// 	"img/movies/the_departed.jpg", "img/movies/the_departed_banner2.jpg", 15, "2hr 31min"),
// 	array("Logan: The Wolverine", 2017, "Logan's attempts to hide from the world and his legacy are upended when a young mutant arrives, pursued by dark forces",
// 	"img/movies/logan.jpg", "img/movies/logan_banner2.jpg", 15, "2h 17min"),
// 	array("Interstellar", 2014, "A team of explorers travel through a wormhole in space in an attempt to ensure humanity's survival",
// 	"img/movies/interstellar.jpg", "img/movies/interstellar_banner.jpg", 11, "2h 49min"),
// 	array("Forrest Gump", 1994, "While not intelligent, Forrest Gump has accidentally been present at many historic moments, but his true love, Jenny Curran, eludes him",
// 	"img/movies/forrest_gump.jpg", "img/movies/forrest_gump_banner.jpg", 11, "2h 22min"),
// 	array("Rogue One", 2016, "The Rebel Alliance makes a risky move to steal the plans for the Death Star, setting up the epic saga to follow",
// 	"img/movies/star_wars.jpg", "img/movies/star_wars_banner2.jpg", 12, "2h 13min"),
// 	array("Cast Away", 2000, "A FedEx executive must transform himself physically and emotionally to survive a crash landing on a deserted island",
// 	"img/movies/cast_away.jpg", "img/movies/cast_away_banner2.jpg", 11, "2hr 23min"),
// 	array("Inception", 2010, "A thief, who steals corporate secrets through use of dream-sharing technology, is given the inverse task of planting an idea into the mind of a CEO",
// 	"img/movies/inception.jpg", "img/movies/inception_banner.jpg", 15, "2h 28min"),
// 	array("The Revenant", 2015, "A frontiersman on a fur trading expedition in the 1820s fights for survival after being mauled by a bear and left for dead by members of his own hunting team",
// 	"img/movies/the_revenant.jpg", "img/movies/the_revenant_banner.jpg", 15, "2hr 36min"),
// 	array("The Lord of the Rings: The Fellowship of the Ring", 2001, "A meek Hobbit from the Shire and eight companions set out on a journey to destroy the powerful One Ring",
// 	"img/movies/lotr.jpg", "img/movies/lotr_banner.jpg", 11, "2h 58min"),
// 	array("Mad Max: Fury Road", 2015, "A woman rebels against a tyrannical ruler in postapocalyptic Australia in search for her home-land with the help of a group of female prisoners, a psychotic worshipper, and a drifter named Max",
// 	"img/movies/mad_max.jpg", "img/movies/mad_max_banner.png", 15, "2h"),
// 	array("The Martian", 2015, "An astronaut becomes stranded on Mars after his team assume him dead, and must rely on his ingenuity to find a way to signal to Earth that he is alive",
// 	"img/movies/the_martian.jpg", "img/movies/the_martian_banner.jpg", 11, "2h 24min"),
// 	array("Wonder Woman", 2017, "When a pilot crashes and tells of conflict in the outside world, Diana, princess of the Amazons, leaves home to fight a war to end all wars",
// 	"img/movies/wonder_woman.jpg", "img/movies/wonder_woman_banner.jpg", 12, "2h 21min"),
// 	array("The Bourne Identity", 2002, "A man is picked up by a fishing boat, bullet-riddled and suffering from amnesia, before racing to elude assassins and regain his memory.",
// 	"img/movies/bourne.jpg", "img/movies/bourne_banner.jpg", 15, "1h 59min"),
// 	array("The Matrix", 1999, "A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.",
// 	"img/movies/the_matrix.jpg", "img/movies/the_matrix_banner.jpg", 15, "2h 16min"),
// 	array("Dunkirk", 2017, "Allied soldiers from Belgium, the British Empire and France are surrounded by the German Army, and evacuated during a fierce battle in World War II.",
// 	"img/movies/dunkirk.jpg", "img/movies/dunkirk_banner.jpg", 12, "1h 46min"),
// 	array("The Avengers", 2012, "Earth's mightiest heroes must come together and learn to fight as a team if they are to stop the mischievous Loki and his alien army from enslaving humanity.",
// 	"img/movies/the_avengers.jpg", "img/movies/the_avengers_banner.jpg", 11, "2h 23min"),
// 	array("Deadpool", 2016, "A fast-talking mercenary with a morbid sense of humor is subjected to a rogue experiment that leaves him with accelerated healing powers and a quest for revenge.",
// 	"img/movies/deadpool.jpg", "img/movies/deadpool_banner.png", 15, "1h 48min"),
// 	array("Star Trek", 2009, "The brash James T. Kirk tries to live up to his father's legacy with Mr. Spock keeping him in check as a vengeful Romulan from the future creates black holes to destroy the Federation one planet at a time.",
// 	"img/movies/star_trek.jpg", "img/movies/star_trek_banner.jpg", 11, "2h 7min")
// );
//
// // Inserting movies data
// $sql = "INSERT INTO movies (title, year, description, main_img, background_img, age, duration) values (?,?,?,?,?,?,?)";
// $query = $db->prepare($sql);
//
// foreach($movies_array as $movie)
// {
// 	$query->execute($movie);
// }

// Array containing tv shows
// $tv_array = array(
// 	array("Battlestar Galactica", 2004, 2009, "When an old enemy, the Cylons, resurface and obliterate the 12 colonies, the crew of the aged Galactica protect a small civilian fleet - the last of humanity - as they journey toward the fabled 13th colony, Earth.",
// 	"img/tv/battlestar_galactica.jpg", "img/tv/battlestar_galactica_banner.jpg", 15, 4),
// 	array("Breaking Bad", 2008, 20013, "A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine in order to secure his family's future.",
// 	"img/tv/breaking_bad.jpg", "img/tv/breaking_bad_banner.jpg", 15, 5),
// 	array("Doctor Who", 2005, null, "The further adventures of the time travelling alien adventurer, a Time Lord/Lady known as the Doctor who can change appearance and gender, and his/her companions.",
// 	"img/tv/doctor_who.jpg", "img/tv/doctor_who_banner.jpg", 11, 10),
// 	array("Game of Thrones", 2011, null, "Nine noble families fight for control over the mythical lands of Westeros, while a forgotten race returns after being dormant for thousands of years.",
// 	"img/tv/game_of_thrones.jpg", "img/tv/game_of_thrones_banner.jpg", 15, 7),
// 	array("House of Cards", 2013, null, "A Congressman works with his equally conniving wife to exact revenge on the people who betrayed him.",
// 	"img/tv/house_of_cards.jpg", "img/tv/house_of_cards_banner.jpg", 15, 5),
// 	array("Legion", 2017, null, "David Haller is a troubled young man diagnosed as schizophrenic, but after a strange encounter, he discovers special powers that will change his life forever.",
// 	"img/tv/legion.jpg", "img/tv/legion_banner.jpg", 15, 1),
// 	array("Lost", 2004, 2010, "The survivors of a plane crash are forced to work together in order to survive on a seemingly deserted tropical island.",
// 	"img/tv/lost.jpg", "img/tv/lost_banner.jpg", 15, 6),
// 	array("Sherlock", 2010, null, "A modern update finds the famous sleuth and his doctor partner solving crime in 21st century London.",
// 	"img/tv/sherlock.jpg", "img/tv/sherlock_banner.jpg", 15, 4),
// 	array("Stranger Things", 2016, null, "When a young boy disappears, his mother, a police chief, and his friends must confront terrifying forces in order to get him back.",
// 	"img/tv/stranger_things.jpg", "img/tv/stranger_things_banner.jpg", 11, 2),
// 	array("Taboo", 2017, null, "Adventurer James Keziah Delaney returns to London during the War of 1812 to rebuild his late father's shipping empire. However, both the government and his biggest competitor want his inheritance at any cost - even murder.",
// 	"img/tv/taboo.jpg", "img/tv/taboo_banner.jpg", 15, 1),
// 	array("The Walking Dead", 2010, null, "Sheriff Deputy Rick Grimes wakes up from a coma to learn the world is in ruins, and must lead a group of survivors to stay alive.",
// 	"img/tv/the_walking_dead.jpg", "img/tv/the_walking_dead_banner.jpg", 18, 8),
// 	array("Westworld", 2016, null, "Set at the intersection of the near future and the reimagined past, explore a world in which every human appetite, no matter how noble or depraved, can be indulged without consequence.",
// 	"img/tv/westworld.jpg", "img/tv/westworld_banner.jpg", 15, 1)
// );
//
// // Inserting movies data
// $sql = "INSERT INTO tv (title, year_start, year_end, description, main_img, background_img, age, seasons) values (?,?,?,?,?,?,?,?)";
// $query = $db->prepare($sql);
//
// foreach($tv_array as $show)
// {
// 	$query->execute($show);
// }

// Array containing genres
$genres_array = array(
	array("Action"), array("Sci-Fi"), array("Drama"), array("Thriller"), array("Fantasy"), array("Romance"), array("Adventure"),
	array("Crime"), array("Comedy"), array("Family"), array("Mystery"), array("Horror"), array("History")
);

// Inserting genres data
$sql = "INSERT INTO genres (name) values (?)";
$query = $db->prepare($sql);

foreach($genres_array as $genre)
{
	$query->execute($genre);
}

// Array containing genres_in_movies
// 1: Action, 2: Sci-Fi, 3: Drama, 4: Thriller, 5: Fantasy, 6: Romance, 7: Adventure, 8: Crime,
// 9: Comedy, 10: Family, 11: Mystery, 12: Horror, 13: History
// $genres_in_movies_array = array(
// 	array(1, 3), array(1, 6), array(1, 8),
// 	array(2, 1), array(2, 3), array(2, 2),
// 	array(3, 7), array(3, 3), array(3, 2),
// 	array(4, 9), array(4, 3), array(4, 6),
// 	array(5, 1), array(5, 7), array(5, 2),
// 	array(6, 7), array(6, 3), array(6, 6),
// 	array(7, 1), array(7, 7), array(7, 2),
// 	array(8, 7), array(8, 3), array(8, 4),
// 	array(9, 7), array(9, 3), array(9, 5),
// 	array(10, 7), array(10, 3), array(10, 5),
// 	array(11, 7), array(11, 3), array(11, 2),
// 	array(12, 1), array(12, 7), array(12, 5),
// 	array(13, 1), array(13, 11), array(13, 4),
// 	array(14, 1), array(14, 2),
// 	array(15, 1), array(15, 3), array(15, 13),
// 	array(16, 1), array(16, 7), array(16, 2),
// 	array(17, 1), array(17, 7), array(17, 9),
// 	array(18, 1), array(18, 7), array(18, 2)
// );
//
// // Inserting genres data
// $sql = "INSERT INTO genres_in_movies (movie_id, genre_id) values (?,?)";
// $query = $db->prepare($sql);
//
// foreach($genres_in_movies_array as $gim)
// {
// 	$query->execute($gim);
// }

// Array containing genres_in_tv
// 1: Action, 2: Sci-Fi, 3: Drama, 4: Thriller, 5: Fantasy, 6: Romance, 7: Adventure, 8: Crime,
// 9: Comedy, 10: Family, 11: Mystery, 12: Horror, 13: History
// $genres_in_tv_array = array(
// 	array(1, 1), array(1, 7), array(1, 3),
// 	array(2, 8), array(2, 3), array(2, 4),
// 	array(3, 7), array(3, 3), array(3, 10),
// 	array(4, 7), array(4, 3), array(4, 5),
// 	array(5, 3),
// 	array(6, 1), array(6, 3), array(6, 2),
// 	array(7, 7), array(7, 3), array(7, 5),
// 	array(8, 8), array(8, 3), array(8, 11),
// 	array(9, 3), array(9, 5), array(9, 12),
// 	array(10, 3), array(10, 11), array(10, 4),
// 	array(11, 3), array(11, 12), array(11, 4),
// 	array(12, 3), array(12, 11), array(12, 2),
// );
//
// // Inserting genres_in_tv data
// $sql = "INSERT INTO genres_in_tv (tv_show_id, genre_id) values (?,?)";
// $query = $db->prepare($sql);
//
// foreach($genres_in_tv_array as $git)
// {
// 	$query->execute($git);
// }

// Array containing titles
// title_name, type, year, year_end*, description, main_img, background_img, age, duration*, seasons*
$titles_array = array(
	array("The Departed", "movie", 2006, null, "An undercover cop and a mole in the police attempt to identify each other while infiltrating an Irish gang in South Boston",
	"img/movies/the_departed.jpg", "img/movies/the_departed_banner2.jpg", 15, "2hr 31min", null),
	array("Logan: The Wolverine", "movie", 2017, null, "Logan's attempts to hide from the world and his legacy are upended when a young mutant arrives, pursued by dark forces",
	"img/movies/logan.jpg", "img/movies/logan_banner2.jpg", 15, "2h 17min", null),
	array("Interstellar", "movie", 2014, null, "A team of explorers travel through a wormhole in space in an attempt to ensure humanity's survival",
	"img/movies/interstellar.jpg", "img/movies/interstellar_banner.jpg", 11, "2h 49min", null),
	array("Forrest Gump", "movie", 1994, null, "While not intelligent, Forrest Gump has accidentally been present at many historic moments, but his true love, Jenny Curran, eludes him",
	"img/movies/forrest_gump.jpg", "img/movies/forrest_gump_banner.jpg", 11, "2h 22min", null),
	array("Rogue One", "movie", 2016, null, "The Rebel Alliance makes a risky move to steal the plans for the Death Star, setting up the epic saga to follow",
	"img/movies/star_wars.jpg", "img/movies/star_wars_banner2.jpg", 12, "2h 13min", null),
	array("Cast Away", "movie", 2000, null, "A FedEx executive must transform himself physically and emotionally to survive a crash landing on a deserted island",
	"img/movies/cast_away.jpg", "img/movies/cast_away_banner2.jpg", 11, "2hr 23min", null),
	array("Inception", "movie", 2010, null, "A thief, who steals corporate secrets through use of dream-sharing technology, is given the inverse task of planting an idea into the mind of a CEO",
	"img/movies/inception.jpg", "img/movies/inception_banner.jpg", 15, "2h 28min", null),
	array("The Revenant", "movie", 2015, null, "A frontiersman on a fur trading expedition in the 1820s fights for survival after being mauled by a bear and left for dead by members of his own hunting team",
	"img/movies/the_revenant.jpg", "img/movies/the_revenant_banner.jpg", 15, "2hr 36min", null),
	array("The Lord of the Rings: The Fellowship of the Ring", "movie", 2001, null, "A meek Hobbit from the Shire and eight companions set out on a journey to destroy the powerful One Ring",
	"img/movies/lotr.jpg", "img/movies/lotr_banner.jpg", 11, "2h 58min", null),
	array("Mad Max: Fury Road", "movie", 2015, null, "A woman rebels against a tyrannical ruler in postapocalyptic Australia in search for her home-land with the help of a group of female prisoners, a psychotic worshipper, and a drifter named Max",
	"img/movies/mad_max.jpg", "img/movies/mad_max_banner.png", 15, "2h", null),
	array("The Martian", "movie", 2015, null, "An astronaut becomes stranded on Mars after his team assume him dead, and must rely on his ingenuity to find a way to signal to Earth that he is alive",
	"img/movies/the_martian.jpg", "img/movies/the_martian_banner.jpg", 11, "2h 24min", null),
	array("Wonder Woman", "movie", 2017, null, "When a pilot crashes and tells of conflict in the outside world, Diana, princess of the Amazons, leaves home to fight a war to end all wars",
	"img/movies/wonder_woman.jpg", "img/movies/wonder_woman_banner.jpg", 12, "2h 21min", null),
	array("The Bourne Identity", "movie", 2002, null, "A man is picked up by a fishing boat, bullet-riddled and suffering from amnesia, before racing to elude assassins and regain his memory.",
	"img/movies/bourne.jpg", "img/movies/bourne_banner.jpg", 15, "1h 59min", null),
	array("The Matrix", "movie", 1999, null, "A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.",
	"img/movies/the_matrix.jpg", "img/movies/the_matrix_banner.jpg", 15, "2h 16min", null),
	array("Dunkirk", "movie", 2017, null, "Allied soldiers from Belgium, the British Empire and France are surrounded by the German Army, and evacuated during a fierce battle in World War II.",
	"img/movies/dunkirk.jpg", "img/movies/dunkirk_banner.jpg", 12, "1h 46min", null),
	array("The Avengers", "movie", 2012, null, "Earth's mightiest heroes must come together and learn to fight as a team if they are to stop the mischievous Loki and his alien army from enslaving humanity.",
	"img/movies/the_avengers.jpg", "img/movies/the_avengers_banner.jpg", 11, "2h 23min", null),
	array("Deadpool", "movie", 2016, null, "A fast-talking mercenary with a morbid sense of humor is subjected to a rogue experiment that leaves him with accelerated healing powers and a quest for revenge.",
	"img/movies/deadpool.jpg", "img/movies/deadpool_banner.png", 15, "1h 48min", null),
	array("Star Trek", "movie", 2009, null, "The brash James T. Kirk tries to live up to his father's legacy with Mr. Spock keeping him in check as a vengeful Romulan from the future creates black holes to destroy the Federation one planet at a time.",
	"img/movies/star_trek.jpg", "img/movies/star_trek_banner.jpg", 11, "2h 7min", null),
	array("Battlestar Galactica", "tv", 2004, 2009, "When an old enemy, the Cylons, resurface and obliterate the 12 colonies, the crew of the aged Galactica protect a small civilian fleet - the last of humanity - as they journey toward the fabled 13th colony, Earth.",
	"img/tv/battlestar_galactica.jpg", "img/tv/battlestar_galactica_banner.jpg", 15, null, 4),
	array("Breaking Bad", "tv", 2008, 20013, "A high school chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine in order to secure his family's future.",
	"img/tv/breaking_bad.jpg", "img/tv/breaking_bad_banner.jpg", 15, null, 5),
	array("Doctor Who", "tv", 2005, null, "The further adventures of the time travelling alien adventurer, a Time Lord/Lady known as the Doctor who can change appearance and gender, and his/her companions.",
	"img/tv/doctor_who.jpg", "img/tv/doctor_who_banner.jpg", 11, null, 10),
	array("Game of Thrones", "tv", 2011, null, "Nine noble families fight for control over the mythical lands of Westeros, while a forgotten race returns after being dormant for thousands of years.",
	"img/tv/game_of_thrones.jpg", "img/tv/game_of_thrones_banner.jpg", 15, null, 7),
	array("House of Cards", "tv", 2013, null, "A Congressman works with his equally conniving wife to exact revenge on the people who betrayed him.",
	"img/tv/house_of_cards.jpg", "img/tv/house_of_cards_banner.jpg", 15, null, 5),
	array("Legion", "tv", 2017, null, "David Haller is a troubled young man diagnosed as schizophrenic, but after a strange encounter, he discovers special powers that will change his life forever.",
	"img/tv/legion.jpg", "img/tv/legion_banner.jpg", 15, null, 1),
	array("Lost", 2004, "tv", 2010, "The survivors of a plane crash are forced to work together in order to survive on a seemingly deserted tropical island.",
	"img/tv/lost.jpg", "img/tv/lost_banner.jpg", 15, null, 6),
	array("Sherlock", "tv", 2010, null, "A modern update finds the famous sleuth and his doctor partner solving crime in 21st century London.",
	"img/tv/sherlock.jpg", "img/tv/sherlock_banner.jpg", 15, null, 4),
	array("Stranger Things", "tv", 2016, null, "When a young boy disappears, his mother, a police chief, and his friends must confront terrifying forces in order to get him back.",
	"img/tv/stranger_things.jpg", "img/tv/stranger_things_banner.jpg", 11, null, 2),
	array("Taboo", "tv", 2017, null, "Adventurer James Keziah Delaney returns to London during the War of 1812 to rebuild his late father's shipping empire. However, both the government and his biggest competitor want his inheritance at any cost - even murder.",
	"img/tv/taboo.jpg", "img/tv/taboo_banner.jpg", 15, null, 1),
	array("The Walking Dead", "tv", 2010, null, "Sheriff Deputy Rick Grimes wakes up from a coma to learn the world is in ruins, and must lead a group of survivors to stay alive.",
	"img/tv/the_walking_dead.jpg", "img/tv/the_walking_dead_banner.jpg", 18, null, 8),
	array("Westworld", "tv", 2016, null, "Set at the intersection of the near future and the reimagined past, explore a world in which every human appetite, no matter how noble or depraved, can be indulged without consequence.",
	"img/tv/westworld.jpg", "img/tv/westworld_banner.jpg", 15, null, 1)
);

// Inserting titles data
$sql = "INSERT INTO titles (title_name, type, year, year_end, description, main_img, background_img, age, duration, seasons)
	values (?,?,?,?,?,?,?,?,?,?)";

$query = $db->prepare($sql);
foreach($titles_array as $title)
{
	$query->execute($title);
}

// Array containing genres in titles
// 1: Action, 2: Sci-Fi, 3: Drama, 4: Thriller, 5: Fantasy, 6: Romance, 7: Adventure, 8: Crime,
// 9: Comedy, 10: Family, 11: Mystery, 12: Horror, 13: History
$genres_in_titles_array = array(
	array(1, 3), array(1, 6), array(1, 8),
	array(2, 1), array(2, 3), array(2, 2),
	array(3, 7), array(3, 3), array(3, 2),
	array(4, 9), array(4, 3), array(4, 6),
	array(5, 1), array(5, 7), array(5, 2),
	array(6, 7), array(6, 3), array(6, 6),
	array(7, 1), array(7, 7), array(7, 2),
	array(8, 7), array(8, 3), array(8, 4),
	array(9, 7), array(9, 3), array(9, 5),
	array(10, 7), array(10, 3), array(10, 5),
	array(11, 7), array(11, 3), array(11, 2),
	array(12, 1), array(12, 7), array(12, 5),
	array(13, 1), array(13, 11), array(13, 4),
	array(14, 1), array(14, 2),
	array(15, 1), array(15, 3), array(15, 13),
	array(16, 1), array(16, 7), array(16, 2),
	array(17, 1), array(17, 7), array(17, 9),
	array(18, 1), array(18, 7), array(18, 2),
	array(19, 1), array(19, 7), array(19, 3),
	array(20, 8), array(20, 3), array(20, 4),
	array(21, 7), array(21, 3), array(21, 10),
	array(22, 7), array(22, 3), array(22, 5),
	array(23, 3),
	array(24, 1), array(24, 3), array(24, 2),
	array(25, 7), array(25, 3), array(25, 5),
	array(26, 8), array(26, 3), array(26, 11),
	array(27, 3), array(27, 5), array(27, 12),
	array(28, 3), array(28, 11), array(28, 4),
	array(29, 3), array(29, 12), array(29, 4),
	array(30, 3), array(30, 11), array(30, 2),
);

// Inserting genres_in_tv data
$sql = "INSERT INTO genres_in_titles (title_id, genre_id) values (?,?)";
$query = $db->prepare($sql);

foreach($genres_in_titles_array as $git)
{
	$query->execute($git);
}
