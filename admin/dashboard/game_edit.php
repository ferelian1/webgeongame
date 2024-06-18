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
    
    // Fetching game data from database based on ID
    if (isset($_GET['id_game'])) {
        $game_id = $_GET['id_game'];
        $sql = "SELECT * FROM game WHERE id_game = '$game_id'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $game_data = $result->fetch_assoc();
        } else {
            echo "Game not found";
            exit();
        }
    }
    
    // Rest of your PHP code for handling the form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Escape user inputs to prevent SQL injection
        $game_name = mysqli_real_escape_string($conn, $_POST['game_name']);
        
        // Check if a new image has been uploaded
        if (isset($_FILES['game_img']) && $_FILES['game_img']['error'] == UPLOAD_ERR_OK) {
            $image_data = file_get_contents($_FILES['game_img']['tmp_name']);
            $image_data = mysqli_real_escape_string($conn, $image_data);
            // Update data in the database with new image
            $sql = "UPDATE game 
                    SET game_name = '$game_name', game_img = '$image_data' 
                    WHERE id_game = '$game_id'";
        } else {
            // Update data in the database without changing the image
            $sql = "UPDATE game 
                    SET game_name = '$game_name' 
                    WHERE id_game = '$game_id'";
        }
    
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    
        // Close connection
        $conn->close();
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Game</title>
        <!-- css -->
        <link rel="stylesheet" href="./css/style.css">
        <!-- bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
        <!-- data tables -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.bootstrap5.css">
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
                        <h2>Edit Game</h2>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="game_name" class="form-label">Game Name</label>
                                <input type="text" class="form-control" id="game_name" name="game_name" required value="<?php echo isset($game_data['game_name']) ? $game_data['game_name'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="game_img" class="form-label">Game Image</label>
                                <input type="file" class="form-control" id="game_img" name="game_img">
                                <?php if (isset($game_data['game_img'])): ?>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($game_data['game_img']); ?>" alt="Game Image" class="img-thumbnail mt-3" style="max-width: 200px;">
                                <?php endif; ?>
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
    </body>
    
    </html>
    
    
</div>
