<?php
session_start();

if(isset($_SESSION["user"])){
    header("Location: home.php");
}

if(isset($_SESSION["adm"])){
    header("Location: dashboard.php");
}

require_once "db_connect.php";
require_once "file_upload.php";

$error = false;

function cleanInputs($input){ 
    $data = trim($input);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}

$fname = $lname = $email = $phone_number = $address = $password = "";
$fnameError = $lnameError = $emailError = $phoneError = $addressError = $passError = "";

if(isset($_POST["sign-up"])){
    $fname = cleanInputs($_POST["fname"]);
    $lname = cleanInputs($_POST["lname"]);
    $email = cleanInputs($_POST["email"]);
    $phone_number = cleanInputs($_POST["phone_number"]);
    $address = cleanInputs($_POST["address"]);
    $password = cleanInputs($_POST["password"]);

    $picture = "";

    if (!empty($_FILES['picture']['name'])) {
        // File upload handling
        $picture = fileUpload($_FILES["picture"]);
    } elseif (!empty($_POST['picture_url'])) {
        // URL input handling
        $picture_url = cleanInputs($_POST["picture_url"]);
        // You might want to validate the URL here
        $picture = array($picture_url, "URL");
    }

    if(empty($fname)){
        $error = true;
        $fnameError = "Please, enter your first name";
    } elseif(strlen($fname) < 3){
        $error = true;
        $fnameError = "Name must have at least 3 characters.";
    } elseif(!preg_match("/^[a-zA-Z\s]+$/", $fname)){
        $error = true;
        $fnameError = "Name must contain only letters and spaces.";
    }

    if(empty($lname)){
        $error = true;
        $lnameError = "Please, enter your last name";
    } elseif(strlen($lname) < 3){
        $error = true;
        $lnameError = "Last name must have at least 3 characters.";
    } elseif(!preg_match("/^[a-zA-Z\s]+$/", $lname)){
        $error = true;
        $lnameError = "Last name must contain only letters and spaces.";
    }

    if(empty($email)){
        $error = true;
        $emailError = "Please, enter your email";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $error = true;
        $emailError = "Please enter a valid email address";
    } else {
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) != 0){
            $error = true;
            $emailError = "Provided Email is already in use";
        }
    }

    if(empty($phone_number)){
        $error = true;
        $phoneError = "Please, enter your phone number";
    }

    if(empty($address)){
        $error = true;
        $addressError = "Please, enter your address";
    }

    if(empty($password)){
        $error = true;
        $passError = "Password can't be empty!";
    } elseif(strlen($password) < 6){
        $error = true;
        $passError = "Password must have at least 6 characters.";
    }

    if(!$error){
        $password = hash("sha256", $password);

        $sql = "INSERT INTO users (first_name, last_name, email, phone_number, address, picture, password) VALUES ('$fname','$lname', '$email', '$phone_number', '$address', '$picture[0]', '$password')";

        $result = mysqli_query($connect, $sql);

        if($result){
            echo "<div class='alert alert-success'>
                <p>New account has been created, $picture[1]</p>
            </div>";
        } else {
            echo "<div class='alert alert-danger'>
                <p>Something went wrong, please try again later ...</p>
            </div>";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<style>

body {
            background-image: url('https://cdn.pixabay.com/photo/2021/05/09/06/07/dog-6240043_1280.jpg');
            background-size: cover;
            background-attachment: fixed;
            margin: 10px;
        }
</style>
<body>
    <div class="container">
        <h1 class="text-center">Sign Up</h1>
        <form method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="fname" class="form-label">First name</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" value="<?= $fname ?>">
                <span class="text-danger"><?= $fnameError ?></span>
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last name</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" value="<?= $lname ?>">
                <span class="text-danger"><?= $lnameError ?></span>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>">
                <span class="text-danger"><?= $emailError ?></span>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone number</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone number" value="<?= $phone_number ?>">
                <span class="text-danger"><?= $phoneError ?></span>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?= $address ?>">
                <span class="text-danger"><?= $addressError ?></span>
            </div>
            <div class="mb-3">
                <label for="picture" class="form-label">Profile picture</label>
                <input type="file" class="form-control" id="picture" name="picture">
                <span class="text-muted">Or enter URL:</span>
                <input type="text" class="form-control mt-2" id="picture_url" name="picture_url" placeholder="Enter URL">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
                <span class="text-danger"><?= $passError ?></span>
            </div>
            <button name="sign-up" type="submit" class="btn btn-primary">Create account</button>
            
            <span>Already have an account? <a href="login.php">Sign in here</a></span>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
