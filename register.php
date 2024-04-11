<?php
// Assuming you have a database connection established
$hostname = 'localhost';
$database = 'dairy';
$username = 'root';
$password = '';

$conn = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables to avoid undefined index warnings
$f_id = $f_name = $f_locality = $f_ac = $f_phone = $f_photo = $last_paid = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set in the $_POST array
    $f_id = isset($_POST['f_id']) ? mysqli_real_escape_string($conn, $_POST['f_id']) : '';
    $f_name = isset($_POST['f_name']) ? mysqli_real_escape_string($conn, $_POST['f_name']) : '';
    $f_locality = isset($_POST['f_locality']) ? mysqli_real_escape_string($conn, $_POST['f_locality']) : '';
    $f_ac = isset($_POST['f_ac']) ? mysqli_real_escape_string($conn, $_POST['f_ac']) : '';
    $f_phone = isset($_POST['f_phone']) ? mysqli_real_escape_string($conn, $_POST['f_phone']) : '';

    // Check if the file upload was successful
    if (isset($_FILES['f_photo']['error']) && $_FILES['f_photo']['error'] == UPLOAD_ERR_OK) {
        // Assuming you have uploaded the photo using a file input with name 'f_photo'
        $f_photo = mysqli_real_escape_string($conn, file_get_contents($_FILES['f_photo']['tmp_name']));
    }

    // Assuming you have received the last_paid date as a string in the format 'YYYY-MM-DD'
    $last_paid = isset($_POST['last_paid']) ? mysqli_real_escape_string($conn, $_POST['last_paid']) : '';

    // Insert data into the farmers table
    $sql = "INSERT INTO farmers (f_id, f_name, f_locality, f_ac, f_phone, f_photo, last_paid) 
            VALUES ('$f_id', '$f_name', '$f_locality', '$f_ac', '$f_phone', '$f_photo', '$last_paid')";

    if (mysqli_query($conn, $sql)) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Farmer Registration Form</title>
</head>
<body>

<div class="container mt-5">
    <div class="card w-50 mx-auto"> <!-- Set width to 50% and center it with mx-auto -->
        <div class="card-header bg-success text-white"> <!-- Change primary to success -->
            <h2 class="mb-0">Farmer Registration Form</h2>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="f_id">National ID:</label>
                    <input type="text" class="form-control" id="f_id" name="f_id" required>
                </div>
                <div class="form-group">
                    <label for="f_name">All Names:</label>
                    <input type="text" class="form-control" id="f_name" name="f_name" required>
                </div>
                <div class="form-group">
                    <label for="f_locality">Location Name:</label>
                    <input type="text" class="form-control" id="f_locality" name="f_locality" required>
                </div>
                <div class="form-group">
                    <label for="f_ac">Bank Account Number:</label>
                    <input type="text" class="form-control" id="f_ac" name="f_ac" required>
                </div>
                <div class="form-group">
                    <label for="f_phone">Official Phone Number:</label>
                    <input type="tel" class="form-control" id="f_phone" name="f_phone" required>
                </div>
                <div class="form-group">
		            <label for="f_photo">Photo:</label>
		            <input type="file" class="form-control-file" id="f_photo" name="f_photo" accept="image/*">
		        </div>
                <button type="submit" class="btn btn-success">Submit</button> <!-- Change primary to success -->
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
