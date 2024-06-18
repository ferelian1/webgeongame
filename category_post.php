<?php
session_start();
include 'connection.php';

// Get category from query parameter
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;

// Fetch category name
$category_query = "SELECT category_name FROM category WHERE id_category = $category_id";
$category_result = $conn->query($category_query);
$category_name = "Category";
if ($category_result->num_rows > 0) {
    $category_row = $category_result->fetch_assoc();
    $category_name = $category_row['category_name'];
}

// Fetch blog posts for the given category
$sql = "SELECT blog_post.id_blog, blog_post.title_blog, blog_post.content_blog, blog_post.date_blog, users.username 
        FROM blog_post 
        INNER JOIN users ON blog_post.username = users.id_user 
        WHERE blog_post.category = $category_id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logo.png">
    <title><?php echo $category_name; ?> - Geon Game Studio</title>
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


<!-- Blog Posts Container -->
<div class="w3-container" id="blog">
  <div class="w3-content" style="max-width:1200px">
    <h5 class="w3-center w3-padding-48"><span class="w3-tag w3-wide"><?php echo $category_name; ?> BLOG POSTS</span></h5>
    
    <div class="w3-row-padding">
    <?php
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<div class='w3-third w3-margin-bottom'>
                    <div class='w3-card'>
                        <div class='w3-container'>
                            <h3>" . htmlspecialchars($row["title_blog"]) . "</h3>
                            <p class='w3-opacity'>" . date('F d, Y', strtotime($row["date_blog"])) . "</p>
                           
                            <p><a href='blog_post.php?id_blog=" . htmlspecialchars($row["id_blog"]) . "' class='w3-button w3-black w3-block'>Read More</a></p>
                        </div>
                    </div>
                  </div>";
        }
    } else {
        echo "<p>No blog posts found in this category.</p>";
    }
    $conn->close();
    ?>
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
