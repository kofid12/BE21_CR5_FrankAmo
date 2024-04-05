<?php
session_start();
require_once "db_connect.php";

// Check if admin session exists
if (!isset($_SESSION["adm"])) {
    header("Location: login.php"); // Redirect to login page if not logged in as admin
    exit;
}

// Initialize variables
$name = $description = $location = $photo = $size = $age = $vaccinated = $breed = $status = "";
$errors = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $photo = trim($_POST['photo']);
    $size = trim($_POST['size']);
    $age = trim($_POST['age']);
    $vaccinated = isset($_POST['vaccinated']) ? 1 : 0;
    $breed = trim($_POST['breed']);
    $status = trim($_POST['status']);

    // Basic form validation (you can add more validation as needed)
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    if (empty($description)) {
        $errors[] = "Description is required";
    }
    if (empty($location)) {
        $errors[] = "Location is required";
    }

    // If no validation errors, proceed to insert data into the database
    if (empty($errors)) {
        $sql = "INSERT INTO animals (name, description, location, photo, size, age, vaccinated, breed, status) 
                VALUES ('$name', '$description', '$location', '$photo', '$size', '$age', '$vaccinated', '$breed', '$status')";
        $result = mysqli_query($connect, $sql);

        if ($result) {
            // Redirect back to dashboard after successful creation
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Error creating animal: " . mysqli_error($connect);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Animal</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>

body {
            background-image: url('https://cdn.pixabay.com/photo/2023/12/15/21/47/cat-8451431_1280.jpg');
            background-size: cover;
            background-attachment: fixed;
            margin: 10px;
        }
</style>

<body>
    <div class="container mt-5">
        <h2>Create Animal</h2>
        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description"><?php echo $description; ?></textarea>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" id="location" name="location" value="<?php echo $location; ?>">
            </div>
            <div class="form-group">
                <label for="photo">Photo:</label>
                <input type="text" class="form-control" id="photo" name="photo" value="<?php echo $photo; ?>">
            </div>
            <div class="form-group">
                <label for="size">Size:</label>
                <input type="text" class="form-control" id="size" name="size" value="<?php echo $size; ?>">
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="text" class="form-control" id="age" name="age" value="<?php echo $age; ?>">
            </div>
            <div class="form-group">
                <label for="vaccinated">Vaccinated:</label>
                <input type="checkbox" id="vaccinated" name="vaccinated" value="1">
            </div>
            <div class="form-group">
                <label for="breed">Breed:</label>
                <input type="text" class="form-control" id="breed" name="breed" value="<?php echo $breed; ?>">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" class="form-control" id="status" name="status" value="<?php echo $status; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="dashboard.php" class="btn btn-secondary">Cancel</a> <!-- Cancel button -->
            <a href="dashboard.php" class="btn btn-warning">Back</a> 
        </form>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
