<?php
session_start();

// Include connection.php to establish database connection
include '../connection.php';

// Check if user is logged in
if(isset($_SESSION['login_user']) && $_SESSION['login_user'] == 'master') {
    $username = $_SESSION['login_user'];
} else {
    // Redirect to login page if user is not logged in or not "master"
    header("location: ../login.php");
    exit();
}

// Get the username from the session
$username = $_SESSION['login_user'];

// Check if ID is set in the URL
if(isset($_GET['id_category'])) {
    // Escape the ID to prevent SQL injection
    $id_category = mysqli_real_escape_string($conn, $_GET['id_category']);

    // Delete user from the database
    $sql = "DELETE FROM category WHERE id_category = '$id_category'";
    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting category: " . $conn->error;
    }
} else {
    // If ID is not set, redirect to a page where user list is displayed
    header("location: user_list.php");
    exit();
}

// Close connection
$conn->close();
?>
