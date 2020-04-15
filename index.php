<?php
require_once "db_connect.php";
mysqli_query($conn, "SET NAMES UTF8");


function printBismillah($name, $arabic, $translate, $bangla){
	echo '<div class="card card-header bg-secondary">';
	echo '<h2 class="card-title text-warning" style="text-align: center;">';
	echo $name;
	echo '</h2>';

	echo '<div class="card-body">';

	echo '<div id="arabicLine" style="text-align: center;">';
	echo '<h3 dir="rtl" class="text-white">';
	echo $arabic . "<br>";
	echo "</h3>";
	echo '</div>';

	echo '<div id="translateLine" style="text-align: center;">';
	echo '<span class="text-white">';
	echo $translate . "<br>";
	echo "</span>";
	echo '</div>';

	echo '<div id="banglaLine" style="text-align: center;">';
	echo '<span class="text-white">';
	echo $bangla . "<br>";
	echo "</span>";
	echo '</div>';

	echo '</div>';
	echo '</div>';
}

function printAyat($ayat, $ayatA, $ayatT, $ayatB)
{
	echo '<div class="card ayat">';
	echo '<div class="card-body">';

	echo '<div id="arabicLine" style="text-align: right;">';
	echo '<p dir="rtl">';
	echo $ayatA . "<br>";
	echo "</p>";
	echo '</div>';

	echo '<div id="translateLine">';
	echo '<p>';
	echo $ayat . '. ' . $ayatT . "<br>";
	echo "</p>";
	echo '</div>';

	echo '<div id="banglaLine">';
	echo '<p>';
	echo $ayat . '. ' . $ayatB . "<br>";
	echo "</p>";
	echo '</div>';

	echo '</div>';
	echo '</div>';
}
?>

<!doctype html>

<html>

<head>
	<title>Bangla Al Quran</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<style>
		html {
			scroll-behavior: smooth;
		}

		.container-fluid {
			margin-top: 65px;
		}

		.card {
			margin: 10px;
		}

		#arabicLine p,
		#translateLine p,
		#banglaLine p {
			line-height: 1.8;
		}

		#arabicLine p {
			font-size: 20px;
		}

		#translateLine p {
			color: darkblue;
			font-size: 15px;
		}

		#banglaLine p {
			color: green;
			font-size: 15px;
		}

		.scrollable-menu {
			height: auto;
			max-height: 300px;
			overflow-x: hidden;
		}
	</style>
</head>

<body>
	<nav class="navbar fixed-top navbar-expand-sm navbar-dark bg-dark">
		<a class="navbar-brand" href="#">Bangla Al Quran</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						১. আল ফাতিহা
					</a>

					<div class="dropdown-menu scrollable-menu" aria-labelledby="navbarDropdown">
						<?php
						$sql = "SELECT sura,text FROM names";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0) {
							while ($row = mysqli_fetch_assoc($result)) {
								$sura = '#sura' . $row['sura'];
								echo '<a class="dropdown-item" href="' . $sura . '">' . $row['text'] . '</a>';
							}
						}
						?>
					</div>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
		</div>
	</nav>

	<div class="container-fluid">
		<?php

		$sql = "SELECT sura,text FROM names";
		$result = mysqli_query($conn, $sql);
		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				echo '<div class="card" id="sura' . $row["sura"] . '">';
				echo '<div class="card-body">';

				$arabic = mysqli_query($conn, "SELECT aya,text FROM arabic1 where sura=" . $row["sura"]);
				$translate = mysqli_query($conn, "SELECT text FROM pronunciation where sura=" . $row["sura"]);
				$bangla = mysqli_query($conn, "SELECT text FROM bangla1 where sura=" . $row["sura"]);

				if (mysqli_num_rows($arabic) > 0) {
					while ($ayatA = mysqli_fetch_assoc($arabic)) {
						$ayatT = mysqli_fetch_assoc($translate);
						$ayatB = mysqli_fetch_assoc($bangla);

						if ($ayatA["aya"] == 1 && $row["sura"] == 1) {
							$ba = $ayatA['text'];
							$bt = $ayatT['text'];
							$bb = $ayatB['text'];
							printBismillah($row['text'], $ba, $bt, $bb);
						}
						else if($ayatA["aya"] == 1) printBismillah($row['text'], $ba, $bt, $bb);

						printAyat($ayatA['aya'], $ayatA['text'], $ayatT['text'], $ayatB['text']);
					}
				}

				echo '</div>';
				echo '</div>';
			}
		}
		?>
	</div>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="script.js"></script>
</body>

</html>