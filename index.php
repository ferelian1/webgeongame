<?php
session_start();
include 'connection.php';

// Fetch categories
$sql_categories = "SELECT id_category, category_name FROM category";
$result_categories = $conn->query($sql_categories);

// Fetch games
$sql_games = "SELECT game_name, game_img FROM game";
$result_games = $conn->query($sql_games);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/png" href="images/logo.png">
<title>Geon Game Studio</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/foundation.css"> <!-- Include Foundation CSS -->
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inconsolata">
</head>
<body>

<!-- Links (sit on top) -->
<div class="w3-top">
  <div class="w3-row w3-padding w3-black">
    <div class="w3-col s3">
      <a href="#" class="w3-button w3-block w3-black">HOME</a>
    </div>
    <div class="w3-col s3">
      <a href="#about" class="w3-button w3-block w3-black">ABOUT</a>
    </div>
    <div class="w3-col s3">
      <a href="#games" class="w3-button w3-block w3-black">GAMES</a>
    </div>
    <div class="w3-col s3">
      <a href="#blog" class="w3-button w3-block w3-black">BLOG</a>
    </div>
  </div>
</div>

<!-- Header with image -->
<header class="bgimg w3-display-container w3-grayscale-min" id="home">
  <div class="w3-display-bottomleft w3-center w3-padding-large w3-hide-small">
    <span class="w3-tag">Stay tuned for updates!</span>
  </div>
  <div class="w3-display-middle w3-center">
    <span class="w3-text-white" style="font-size:90px">Geon Game</span>
  </div>
  <div class="w3-display-bottomright w3-center w3-padding-large">
    <span class="w3-text-grey">geon game studio</span>
  </div>
</header>

<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-grayscale w3-large">

<!-- About Container -->
<div class="w3-container" id="about">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-64"><span class="w3-tag w3-wide">ABOUT GEON GAME STUDIO</span></h5>
    <p>Geon Game Studio come from the nature of indie game development, simple but has profound vision. With a focus on some pixel art and an affinity for cubes, our game brings on a new quest to redefine gaming experiences. We strive to capture players with immersive worlds that brings the ordinary, and offering a fresh perspective and an unforgettable journey. Join us as we deliver you into the endless realms of creativity and adventure. Welcome to Geon Game Studio.</p>
    <p>In addition to developing games, we are passionate about creating immersive gaming experiences for players around the world.</p>
    <div class="w3-panel w3-leftbar w3-light-grey">
      <p><i>"Its okay to be different but has something that no one has."</i></p>
      <p>Founder: Hitoku/M Ferelian</p>
    </div>
  </div>
</div>

<!-- Games Container -->
<div class="w3-container" id="games">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">OUR GAMES</span></h5>
    <div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit>
      <ul class="orbit-container">
        <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
        <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
        
        <?php
        if ($result_games->num_rows > 0) {
            $first = true;
            while ($row = $result_games->fetch_assoc()) {
                $game_name = htmlspecialchars($row['game_name']);
                $game_img = base64_encode($row['game_img']);
                echo '<li class="orbit-slide'.($first ? ' is-active' : '').'">
                        <div class="w3-card w3-padding w3-margin">
                          <img src="data:image/jpeg;base64,' . $game_img . '" alt="' . $game_name . '" ">
                          <h2>' . $game_name . '</h2>
                        </div>
                      </li>';
                $first = false;
            }
        } else {
            echo "<p>No games found.</p>";
        }
        ?>
      </ul>
    </div>
  </div>
</div>

<!-- Blog Container -->
<div class="w3-container" id="blog">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">OUR BLOG</span></h5>
    <!-- Carousel for Categories -->
    <div class="orbit" role="region" aria-label="Category Carousel" data-orbit>
      <ul class="orbit-container">
        <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
        <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>

        <?php
        if ($result_categories->num_rows > 0) {
            $first = true;
            while ($row = $result_categories->fetch_assoc()) {
                echo '<li class="orbit-slide'.($first ? ' is-active' : '').'">
                        <div class="w3-card w3-padding w3-margin">
                          <h2>' . htmlspecialchars($row['category_name']) . '</h2>
                          <p>Discover all our posts related to ' . htmlspecialchars($row['category_name']) . '.</p>
                          <a href="category_post.php?category_id=' . htmlspecialchars($row['id_category']) . '" class="w3-button w3-black">Read More</a>
                        </div>
                      </li>';
                $first = false;
            }
        } else {
            echo "<p>No categories found.</p>";
        }
        ?>
      </ul>
    </div>
  </div>
</div>

<!-- Contact/Area Container -->
<div class="w3-container" id="contact" style="padding-bottom:32px;">
  <div class="w3-content" style="max-width:700px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">CONTACT US</span></h5>
    <p>Find us at GDM, Malang, Indonesia.</p>
    <p><strong>Email:</strong> info@geongamestudio.com</p>
    <p><strong>Phone:</strong> +1 234 567 8901</p>
    <p><strong>Follow us:</strong> <a href="#">Twitter</a>, <a href="#">Facebook</a>, <a href="#">Instagram</a></p>
    <p>Have any questions or inquiries? Feel free to reach out!</p>
  </div>
</div>

<!-- End page content -->
</div>

<!-- Footer -->
<footer class="w3-center w3-light-grey w3-padding-48 w3-large">
  <p>Powered by <a href="https://www.geongamestudio.com" title="Geon Game Studio" target="_blank" class="w3-hover-text-green">Geon Game Studio</a></p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/foundation/6.2.4/foundation.min.js"></script> <!-- Include Foundation JS -->
<script>
$(document).foundation();
</script>

</body>
</html>
