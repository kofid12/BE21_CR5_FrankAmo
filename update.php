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

// Handle update request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $photo = $_POST['photo'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $age = $_POST['age'];
    $vaccinated = isset($_POST['vaccinated']) ? 1 : 0; // Convert checkbox value to 1 or 0
    $breed = $_POST['breed'];
    $status = $_POST['status'];

    // Update animal in the database
    $updateSql = "UPDATE animals SET 
                    name = '$name', 
                    photo = '$photo', 
                    location = '$location', 
                    description = '$description', 
                    size = '$size', 
                    age = '$age', 
                    vaccinated = '$vaccinated', 
                    breed = '$breed', 
                    status = '$status' 
                  WHERE id = $animalId";
    $updateResult = mysqli_query($connect, $updateSql);

    if ($updateResult) {
        // Redirect back to dashboard after successful update
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error updating animal: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Animal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>

body {
            background-image: url('https://cdn.pixabay.com/photo/2019/08/07/14/11/dog-4390885_1280.jpg');
            background-size: cover;
            background-attachment: fixed;
            margin: 10px;
        }
</style>

<body>
    <div class="container mt-5">
        <h2>Update Animal</h2>
        <form method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $animalData['name']; ?>">
            </div>
            <div class="form-group">
                <label for="photo">Photo URL:</label>
                <input type="text" class="form-control" id="photo" name="photo" value="<?php echo $animalData['photo']; ?>">
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo $animalData['location']; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"><?php echo $animalData['description']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="size">Size:</label>
                <input type="text" class="form-control" id="size" name="size" value="<?php echo $animalData['size']; ?>">
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="text" class="form-control" id="age" name="age" value="<?php echo $animalData['age']; ?>">
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="vaccinated" name="vaccinated" <?php echo $animalData['vaccinated'] ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="vaccinated">Vaccinated</label>
                </div>
            </div>
            <div class="form-group">
                <label for="breed">Breed:</label>
                <input type="text" class="form-control" id="breed" name="breed" value="<?php echo $animalData['breed']; ?>">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" class="form-control" id="status" name="status" value="<?php echo $animalData['status']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a> <!-- Cancel button -->
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
