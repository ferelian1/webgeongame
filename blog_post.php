<?php
session_start();
include 'connection.php';

// Get blog post ID from query parameter
$id_blog = isset($_GET['id_blog']) ? intval($_GET['id_blog']) : 0;

// Fetch blog post details
$sql = "SELECT blog_post.title_blog, blog_post.content_blog, blog_post.date_blog, users.username 
        FROM blog_post 
        INNER JOIN users ON blog_post.username = users.id_user 
        WHERE blog_post.id_blog = $id_blog";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $post = $result->fetch_assoc();
} else {
    // Redirect to index if blog post not found
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logo.png">
    <title><?php echo htmlspecialchars($post['title_blog']); ?> - Geon Game Studio</title>
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
      <a href="index.php" class="w3-button w3-block w3-black">HOME</a>
    </div>
    <div class="w3-col s3">
      <a href="index.php#about" class="w3-button w3-block w3-black">ABOUT</a>
    </div>
    <div class="w3-col s3">
      <a href="index.php#games" class="w3-button w3-block w3-black">GAMES</a>
    </div>
    <div class="w3-col s3">
      <a href="index.php#blog" class="w3-button w3-block w3-black">BLOG</a>
    </div>
  </div>
</div>

<!-- Header with image -->


<!-- Blog Post Container -->
<div class="w3-container" id="blog">
  <div class="w3-content" style="max-width:1200px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide"><?php echo htmlspecialchars($post['title_blog']); ?></span></h5>
    
    <div class="w3-row-padding">
      <div class="w3-card w3-padding w3-margin">
        <div class="w3-container">
          <p class="w3-opacity">Published on <?php echo date('F d, Y', strtotime($post["date_blog"])); ?> by <?php echo htmlspecialchars($post['username']); ?></p>
          <p><?php echo nl2br($post['content_blog']); ?></p>
        </div>
      </div>
    </div>
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

