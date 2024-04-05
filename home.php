<?php
session_start();
require_once "db_connect.php";

// Fetch all animals from the database
$sql = "SELECT * FROM animals";
$result = mysqli_query($connect, $sql);

// Check for database query errors
if (!$result) {
    die("Database query failed: " . mysqli_error($connect));
}

// Initialize variables to store user email and profile picture
$userEmail = '';
$profilePicture = '';

// Check if user is logged in
if (isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
    // Retrieve user's email address and profile picture URL from the database
    $userId = isset($_SESSION['user']) ? $_SESSION['user'] : $_SESSION['adm'];
    $query = "SELECT email, picture FROM users WHERE id = $userId";
    $resultUser = mysqli_query($connect, $query);
    if (!$resultUser) {
        die("Database query failed: " . mysqli_error($connect));
    }
    if (mysqli_num_rows($resultUser) > 0) {
        $row = mysqli_fetch_assoc($resultUser);
        $userEmail = $row['email'];
        $profilePicture = $row['picture'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Adoption</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('https://cdn.pixabay.com/photo/2021/12/07/18/30/cat-6853848_1280.jpg');
            background-size: cover;
            background-attachment: fixed;
            margin: 10px;
        }
        .animal-card {
            margin-bottom: 20px;
        }

        .animal-photo {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .animal-details {
            padding: 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="nav-item mr-auto">
                <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
            </div>
            <a class="navbar-brand" href="#">FrankPets</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="senior.php">Senior Animals</a>
                    </li>
                    <?php if (isset($_SESSION["user"]) || isset($_SESSION["adm"])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <span class="navbar-text"><?php echo $userEmail; ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-5 mb-4">Pets available</h1>
        <div class="row">
            <?php
            // Check if there are any animals
            if (mysqli_num_rows($result) > 0) {
                // Iterate through each animal record
                while ($row = mysqli_fetch_assoc($result)) {
                    // Append HTML for each animal card using Bootstrap cards
                    echo '<div class="col-md-4">
                            <div class="card animal-card">
                                <img src="' . $row['photo'] . '" alt="' . $row['name'] . '" class="card-img-top animal-photo">
                                <div class="card-body animal-details">
                                    <h5 class="card-title">' . $row['name'] . '</h5>
                                    <p class="card-text"><strong>Location:</strong> ' . $row['location'] . '</p>
                                    <p class="card-text"><strong>Description:</strong> ' . $row['description'] . '</p>
                                    <p class="card-text"><strong>Size:</strong> ' . $row['size'] . '</p>
                                    <p class="card-text"><strong>Age:</strong> ' . $row['age'] . '</p>
                                    <p class="card-text"><strong>Vaccinated:</strong> ' . ($row['vaccinated'] ? 'Yes' : 'No') . '</p>
                                    <p class="card-text"><strong>Breed:</strong> ' . $row['breed'] . '</p>
                                    <p class="card-text"><strong>Status:</strong> ' . $row['status'] . '</p>
                                    <form method="post" action="adopt.php">
                                        <input type="hidden" name="pet_id" value="' . $row['id'] . '">
                                        <button type="submit" class="btn btn-primary" onclick="return confirm(\'Are you sure you want to adopt this pet?\');">Take me home</button>
                                        <a href="details.php?id=' . $row['id'] . '" class="btn btn-warning">Details</a>
                                    </form>
                                </div>
                            </div>
                        </div>';
                }
            } else {
                // If no animals are found
                echo '<div class="col-md-12">No animals available for adoption.</div>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Close the database connection
mysqli_close($connect);
?>
