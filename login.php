<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}
if (isset($_SESSION["adm"])) {
    header("Location: dashboard.php");
    exit;
}
require_once "db_connect.php";
$error = false;
if (isset($_POST["sign-in"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Sanitize inputs
    $email = htmlspecialchars(strip_tags($email));
    $password = htmlspecialchars(strip_tags($password));
    // Hash the password
    $password = hash("sha256", $password);
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        if ($password == $row['password']) {
            if ($row['is_admin'] == 1) {
                $_SESSION["adm"] = $row['id'];
                header("Location: dashboard.php");
                exit;
            } else {
                $_SESSION["user"] = $row['id'];
                header("Location: home.php");
                exit;
            }
        } else {
            $error = true;
            $errorMsg = "Invalid email or password!";
        }
    } else {
        $error = true;
        $errorMsg = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<style>
      body {
            background-image: url('https://cdn.pixabay.com/photo/2015/02/25/17/56/cat-649164_1280.jpg');
            background-size: cover;
            background-attachment: fixed;
            margin: 10px;
        }
</style>
<body>
    <div class="container">
        <h1 class="text-center">Login</h1>
        <form method="post" autocomplete="off">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email address" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
            </div>
            <?php if ($error) : ?>
                <div class="alert alert-danger"><?= $errorMsg ?></div>
            <?php endif; ?>
            <button name="sign-in" type="submit" class="btn btn-primary">Sign in</button>
            <span>Don't have an account? <a href="register.php">Sign up here</a></span>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>