<?php
// Include the database connection file
require_once "db_connect.php";

// Check if the animal ID is provided in the URL
if (isset($_GET['id'])) {
    // Get the animal ID from the URL
    $animal_id = $_GET['id'];

    // Fetch the details of the animal from the database
    $sql = "SELECT * FROM animals WHERE id = $animal_id";
    $result = mysqli_query($connect, $sql);

    // Check if the query was successful
    if ($result) {
        // Check if at least one row was returned
        if (mysqli_num_rows($result) > 0) {
            // Fetch the animal details
            $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['name']; ?> Details</title>
    <!-- Add your CSS and Bootstrap CDN links here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .animal-name {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .animal-img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-4 animal-name"><?php echo $row['name']; ?></h1>
        <img src="<?php echo $row['photo']; ?>" class="animal-img" alt="<?php echo $row['name']; ?>">
        <div>
            <p>Age: <?php echo $row['age']; ?></p>
            <p>Location: <?php echo $row['location']; ?></p>
            <p>Description: <?php echo $row['description']; ?></p>
            <p>Size: <?php echo $row['size']; ?></p>
            <p>Vaccinated: <?php echo $row['vaccinated'] ? 'Yes' : 'No'; ?></p>
            <p>Breed: <?php echo $row['breed']; ?></p>
            <p>Status: <?php echo $row['status']; ?></p>
            <!-- Add other details as needed -->
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
            // No animal found with the provided ID
            echo "<p>No animal found with the provided ID.</p>";
        }
    } else {
        // Error in executing the SQL query
        echo "<p>Error: " . mysqli_error($connect) . "</p>";
    }

    // Close the database connection
    mysqli_close($connect);
} else {
    // No animal ID provided in the URL
    echo "<p>No animal ID provided.</p>";
}
?>
