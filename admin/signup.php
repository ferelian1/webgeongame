

<?php
session_start();

// Include connection.php to establish database connection
include 'connection.php';

// Check if the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the special token
    $special_token = "ferelana753";
    if ($_POST['token'] !== $special_token) {
        $error = "Invalid special token.";
    } else {
        // Validate other form fields
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $repeat_password = mysqli_real_escape_string($conn, $_POST['repeat_password']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        // Check if passwords match
        if ($password !== $repeat_password) {
            $error = "Passwords do not match.";
        } else {
            // Hash the password using password_hash() with PASSWORD_DEFAULT
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashed_password', '$email')";
            if (mysqli_query($conn, $sql)) {
                // Redirect to login page after successful sign-up
                header("location: login.php");
                exit();
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Sign Up
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" class="form-control" id="username" name="username">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="repeat_password" class="form-label">Repeat Password:</label>
                                <input type="password" class="form-control" id="repeat_password" name="repeat_password">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="token" class="form-label">Special Token:</label>
                                <input type="text" class="form-control" id="token" name="token">
                            </div>
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </form>
                        <?php if(isset($error)) { ?>
                            <div class="alert alert-danger mt-3" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
