<div>
    <?php
    session_start();
    
    // Include connection.php to establish database connection
    include '../connection.php';
    
    // Check if user is logged in
    if (!isset($_SESSION['login_user'])) {
        // Redirect to login page if user is not logged in
        header("location: ../login.php");
        exit();
    }
    
    // Get the username from the session
    $username = $_SESSION['login_user'];
    
    // Get the current date
    $current_date = date('Y-m-d');
    
    // Fetching blog data from database based on ID
    if (isset($_GET['id_blog'])) {
        $blog_id = $_GET['id_blog'];
        $sql = "SELECT * FROM blog_post WHERE id_blog = '$blog_id'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $blog_data = $result->fetch_assoc();
        } else {
            echo "Blog not found";
            exit();
        }
    }
    
    // Rest of your PHP code for handling the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Escape user inputs to prevent SQL injection
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $content = mysqli_real_escape_string($conn, $_POST['content']);
        $reference = mysqli_real_escape_string($conn, $_POST['reference']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
    
        // Handle image links in the content
        $content_with_image_links = handleImageLinks($conn, $content);
    
        // Update data in the database
        $sql = "UPDATE blog_post 
                SET title_blog = '$title', content_blog = '$content_with_image_links', reference = '$reference', category = '$category', date_blog = '$date' 
                WHERE id_blog = '$blog_id'";
    
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
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
    
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Blog Post</title>
        <!-- css -->
        <link rel="stylesheet" href="./css/style.css">
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
        <!-- data tables -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.css">
        <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    </head>
    
    <body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="flex-shrink-0 p-3" style="width: flex;">
                    <a href="/"
                        class="d-flex align-items-center pb-3 mb-3 link-body-emphasis text-decoration-none border-bottom">
                        <svg class="bi pe-none me-2" width="30" height="24">
                            <use xlink:href="#bootstrap"></use>
                        </svg>
                        <span class="fs-5 fw-semibold">Admin WEB</span>
                    </a>
                    <ul class="list-unstyled ps-0">
                        <li class="mb-1">
                            <a href="../index.php"
                                class="btn btn-toggle d-inline-flex align-items-center rounded border-0">
                                Home
                            </a>
                        </li>
                        <li class="mb-1">
                            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                                Dashboard
                            </button>
                            <div class="collapse" id="dashboard-collapse">
                                    <li><a href="./blog_post.php"
                                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Blog
                                            Post</a></li>
                                    <li><a href="./blog_form.php"
                                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Blog
                                            Form</a></li>
                                    <?php if ($username == 'master'): ?>
                                        <li><a href="./category_post.php"
                                                class="link-body-emphasis d-inline-flex text-decoration-none rounded">Category Post</a></li>
                                        <li><a href="./category_form.php"
                                                class="link-body-emphasis d-inline-flex text-decoration-none rounded">Category Form</a></li>
                                        <li><a href="./game_post.php"
                                                class="link-body-emphasis d-inline-flex text-decoration-none rounded">Game Post</a></li>
                                        <li><a href="./game_form.php"
                                                class="link-body-emphasis d-inline-flex text-decoration-none rounded">Game Form</a></li>
                                        <li><a href="./show_user.php"
                                                class="link-body-emphasis d-inline-flex text-decoration-none rounded">Show User</a></li>
                                        <li><a href="./user_new.php"
                                                class="link-body-emphasis d-inline-flex text-decoration-none rounded">Add User</a></li>
                                    <?php endif; ?>
                            </div>
                        </li>

                        <li class="border-top my-3"></li>
                        <li class="mb-1">
                            <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed"
                                data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                                Account
                            </button>
                            <div class="collapse" id="account-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="#"
                                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Profile</a>
                                    </li>
                                    <li><a href="../logout.php"
                                            class="link-body-emphasis d-inline-flex text-decoration-none rounded">Log
                                            out</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            

    
                <!-- Main content -->
                <div class="col-9">
                    <div class="container mt-5">
                        <h2>Edit Blog Post</h2>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required value="<?php echo isset($blog_data['title_blog']) ? $blog_data['title_blog'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" id="content" name="content" required><?php echo isset($blog_data['content_blog']) ? $blog_data['content_blog'] : ''; ?></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="reference" class="form-label">Reference</label>
                                <input type="text" class="form-control" id="reference" name="reference" value="<?php echo isset($blog_data['reference']) ? $blog_data['reference'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category" required>
                                    <?php
                                    // Fetch category names from the database
                                    $category_query = "SELECT id_category, category_name FROM category";
                                    $category_result = $conn->query($category_query);
                                    if ($category_result->num_rows > 0) {
                                        // Output options for each category
                                        while ($row = $category_result->fetch_assoc()) {
                                            $selected = isset($blog_data['category']) && $blog_data['category'] == $row['id_category'] ? 'selected' : '';
                                            echo "<option value='" . $row['id_category'] . "' $selected>" . $row['category_name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required value="<?php echo isset($blog_data['date_blog']) ? $blog_data['date_blog'] : $current_date; ?>">
                            </div>
    
                            <!-- Automatically select the username from the login -->
                            <input type="hidden" name="username" value="<?php echo $username; ?>">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </form>
                        </div>
            </div>
        </div>
    
        <!-- Include Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Initialize CKEditor
            CKEDITOR.replace('content');
        </script>
    </body>
    
    </html>
    
    
</div>