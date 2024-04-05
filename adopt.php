<?php
session_start();
require_once "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user is logged in
    if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
        // If user is not logged in, redirect to login page
        header("Location: login.php");
        exit;
    }

    // Check if pet_id is set
    if (!isset($_POST["pet_id"])) {
        // If pet_id is not set, redirect to home page
        header("Location: home.php");
        exit;
    }

    // Retrieve user ID from session
    $userId = isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['adm'];

    // Sanitize and validate pet_id
    $petId = mysqli_real_escape_string($connect, $_POST["pet_id"]);

    // Check if the pet is already adopted by the user
    $checkSql = "SELECT * FROM pet_adoption WHERE user_id = $userId AND pet_id = $petId";
    $checkResult = mysqli_query($connect, $checkSql);
    if (!$checkResult) {
        die("Database query failed: " . mysqli_error($connect));
    }
    if (mysqli_num_rows($checkResult) > 0) {
        // If the pet is already adopted by the user, redirect to home page with a message
        $_SESSION['message'] = "You have already adopted this pet.";
        header("Location: home.php");
        exit;
    }

    // Insert adoption record into pet_adoption table
    $insertSql = "INSERT INTO pet_adoption (user_id, pet_id, adoption_date) VALUES ($userId, $petId, NOW())";
    $insertResult = mysqli_query($connect, $insertSql);
    if (!$insertResult) {
        die("Database query failed: " . mysqli_error($connect));
    }

    // Redirect to home page with a success message
    $_SESSION['message'] = "Congratulations! You have successfully adopted the pet.";
    header("Location: home.php");
    exit;
} else {
    // If accessed directly without POST request, redirect to home page
    header("Location: home.php");
    exit;
}

// Close the database connection
mysqli_close($connect);
?>
