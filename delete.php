<?php
session_start();
require_once "db_connect.php";

// Check if admin session exists
if (!isset($_SESSION["adm"])) {
    header("Location: login.php"); // Redirect to login page if not logged in as admin
    exit;
}

// Check if animal ID is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php"); // Redirect to dashboard if animal ID is not provided
    exit;
}

// Get animal ID from the URL
$animalId = $_GET['id'];

// Fetch animal details from the database
$sql = "SELECT * FROM animals WHERE id = $animalId";
$result = mysqli_query($connect, $sql);
$animalData = mysqli_fetch_assoc($result);

// Check if animal with the provided ID exists
if (!$animalData) {
    echo "Animal not found.";
    exit;
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Delete animal from the database
    $deleteSql = "DELETE FROM animals WHERE id = $animalId";
    $deleteResult = mysqli_query($connect, $deleteSql);

    if ($deleteResult) {
        // Redirect back to dashboard after successful deletion
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error deleting animal: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Animal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Delete Animal</h2>
        <p>Are you sure you want to delete the following animal?</p>
        <p><strong>Name:</strong> <?php echo $animalData['name']; ?></p>
        <p><strong>Description:</strong> <?php echo $animalData['description']; ?></p>
        <form method="post">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a> <!-- Cancel button -->
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
