<?php
session_start();
include "../connection.php";

// Check if user is logged in and is "master"
if(isset($_SESSION['login_user']) && $_SESSION['login_user'] == 'master') {
    $username = $_SESSION['login_user'];
} else {
    // Redirect to login page if user is not logged in or not "master"
    header("location: ../login.php");
    exit();
}

// SQL query to select categories
$sql = "SELECT id_category, category_name FROM category";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <!-- css -->
    <link rel="stylesheet" href="../css/style.css">
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
                    
                    <table id="mytable" class="table table-success table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id_category"] . "</td>
                        <td>" . $row["category_name"] . "</td>
                        <td>
                            <a href='category_edit.php?id_category=" . $row['id_category'] . "' class='btn btn-primary btn-sm'>Edit</a>
                            <a href='delete_category.php?id_category=" . $row['id_category'] . "' class='btn btn-danger btn-sm'>Delete</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php $conn->close(); ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- Data tables -->
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function () {
            $('#mytable').DataTable();
        });
    </script>
</body>

</html>
