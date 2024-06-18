<?php
session_start();
include('../connection.php');

// Check if user is logged in
if (!isset($_SESSION['login_user'])) {
    // Redirect to login page if user is not logged in
    header("location: ../login.php");
    exit();
}

// Rest of your PHP code for handling the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs to prevent SQL injection
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $reference = mysqli_real_escape_string($conn, $_POST['reference']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);

    // Fetch the id_user based on the provided username
    $user_query = "SELECT id_user FROM users WHERE username = '$username'";
    $user_result = $conn->query($user_query);
    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $user_id = $user_row['id_user'];

        // Handle image links in the content
        $content_with_image_links = handleImageLinks($conn, $content);

        // Insert data into database
        $sql = "INSERT INTO blog_post (title_blog, content_blog, reference, category, username, date_blog) 
                VALUES ('$title', '$content_with_image_links', '$reference', '$category', '$user_id', '$date')";

        $front_image = '';
        if ($_FILES['front_image']['error'] == 0) {
            $image_data = file_get_contents($_FILES['front_image']['tmp_name']);
            $front_image = mysqli_real_escape_string($conn, $image_data);
        }

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: User not found";
    }

    // Close connection
    $conn->close();
}

// Function to handle image links in the content and save them to the database
function handleImageLinks($conn, $content) {
    // Regular expression to match image tags
    $pattern = '/<img[^>]+src="([^"]+)"[^>]*>/';
    preg_match_all($pattern, $content, $matches);

    // Check if there are any image matches
    if (!empty($matches[1])) {
        foreach ($matches[1] as $image_url) {
            // Insert the image link into the database
            $sql = "INSERT INTO uploads (image_link) VALUES ('$image_url')";
            $conn->query($sql);
        }
    }

    // Return the content with image links unchanged
    return $content;
}
?>