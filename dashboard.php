<?php
session_start();
require_once "db_connect.php";

// Check if admin session exists
if (!isset($_SESSION["adm"])) {
    header("Location: login.php"); // Redirect to login page if not logged in as admin
    exit;
}

// Fetch admin details
$adminId = $_SESSION["adm"];
$sql = "SELECT * FROM users WHERE id = $adminId";
$result = mysqli_query($connect, $sql);
$adminData = mysqli_fetch_assoc($result);

// Logout logic
if (isset($_POST["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Fetch admin profile picture
$profilePicture = '';
if (isset($_SESSION["adm"])) {
    // Retrieve admin's profile picture URL from the database
    $query = "SELECT picture FROM users WHERE id = $adminId";
    $profileResult = mysqli_query($connect, $query);
    if (!$profileResult) {
        die("Database query failed: " . mysqli_error($connect));
    }
    if (mysqli_num_rows($profileResult) > 0) {
        $row = mysqli_fetch_assoc($profileResult);
        $profilePicture = $row['picture'];
    } else {
        $profilePicture = ""; // Set default profile picture if not found
    }
}

// Fetch all animals from the database
$sql = "SELECT * FROM animals";
$result = mysqli_query($connect, $sql);

// Check for database query errors
if (!$result) {
    die("Database query failed: " . mysqli_error($connect));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>

body {
            background-image: url('https://cdn.pixabay.com/photo/2023/04/08/08/38/cat-7908955_1280.jpg');
            background-size: cover;
            background-attachment: fixed;
            margin: 10px;
        }
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <?php if (isset($_SESSION["adm"])) : ?>
                <div class="nav-item mr-3">
                    <?php if (!empty($profilePicture)) : ?>
                        <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
                    <?php else : ?>
                        <!-- Default profile picture if not found -->
                        <img src="https://cdn.pixabay.com/photo/2016/11/21/14/30/man-1845715_1280.jpg" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Welcome, <?php echo $adminData['first_name'] . ' ' . $adminData['last_name']; ?></a>
                    </li>
                    <li class="nav-item">
                        <form method="post">
                            <button type="submit" name="logout" class="btn btn-link">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Animal Management</h2>
        <div class="row">
            <?php
            // Check if there are any animals
            if (mysqli_num_rows($result) > 0) {
                // Iterate through each animal record
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display animal details
                    echo '<div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <img src="' . $row['photo'] . '" class="card-img-top" alt="' . $row['name'] . '">
                                <div class="card-body">
                                    <p class="card-text"><strong>Name:</strong> ' . $row['name'] . '</p>
                                    <p class="card-text"><strong>Description:</strong> ' . $row['description'] . '</p>
                                    <p class="card-text"><strong>Location:</strong> ' . $row['location'] . '</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                        <a href="details.php?id=' . $row['id'] . '" class="btn btn-warning">Details</a>
                                            <a href="update.php?id=' . $row['id'] . '" class="btn btn-secondary">Update</a>
                                            <a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                // If no animals are found
                echo "No animals available.";
            }
            ?>
        </div>
        <a href="create.php" class="btn btn-primary">Create New Animal</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
