<?php
session_start();

// Include connection.php to establish database connection
include 'connection.php';

// Check if the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form 
    $myusername = mysqli_real_escape_string($conn,$_POST['username']);
    $mypassword = mysqli_real_escape_string($conn,$_POST['password']); 
    
    // Retrieve the hashed password from the database
    $sql = "SELECT id_user, password FROM users WHERE username = '$myusername'";
    $result = mysqli_query($conn, $sql);
    
    if($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        echo "Hashed Password from Database: " . $hashed_password . "<br>";
        echo "Hashed Password Entered during Login: " . password_hash($mypassword, PASSWORD_DEFAULT) . "<br>";
        
        // Verify the hashed password
        if(password_verify($mypassword, $hashed_password)) {
            $_SESSION['login_user'] = $myusername;
            header("location: index.php");
            exit(); // Ensure that script execution stops after redirecting
        } else {
            $error = "Your Login Name or Password is invalid";
        }
    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                        Login
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
                            <button type="submit" class="btn btn-primary">Login</button>
                            <a href="signup.php" class="btn btn-secondary">Sign Up</a>
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
