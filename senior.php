<?php
// Include the database connection file
require_once "db_connect.php";

// Fetch senior animals from the database
$sql = "SELECT * FROM animals WHERE age > 8"; // Assuming senior animals are those older than 8 years
$result = mysqli_query($connect, $sql);

// Check if senior animals were found
if ($result && mysqli_num_rows($result) > 0) {
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Animals</title>
    <!-- Add your CSS and Bootstrap CDN links here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Senior Animals</h1>
        <div class="row">
            <?php
            // Loop through the fetched senior animals and display their details
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <img src="<?php echo $row['photo']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text">Age: <?php echo $row['age']; ?></p>
                            <p class="card-text">Location: <?php echo $row['location']; ?></p>
                            <p class="card-text">Description: <?php echo $row['description']; ?></p>
                            <p class="card-text">Size: <?php echo $row['size']; ?></p>
                            <p class="card-text">Vaccinated: <?php echo $row['vaccinated'] ? 'Yes' : 'No'; ?></p>
                            <p class="card-text">Breed: <?php echo $row['breed']; ?></p>
                            <p class="card-text">Status: <?php echo $row['status']; ?></p>
                            <!-- Add more details if needed -->
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <!-- Add your JavaScript and Bootstrap CDN links here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php
} else {
    // No senior animals found
    echo "<p>No senior animals found.</p>";
}

// Close the database connection
mysqli_close($connect);
?>
