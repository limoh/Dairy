<?php
include '../incl/header.incl.php';
include '../incl/conn.incl.php';
include '../incl/functions.php';


if (isset($_GET['code'])) {
    $verificationCode = $_GET['code'];

    // Check if the verification code exists in the database
    $query = "SELECT * FROM `employees` WHERE `email_verification_code` = '$verificationCode' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // Update the user's email verification status
        $updateQuery = "UPDATE `employees` SET `email_verified` = 1 WHERE `email_verification_code` = '$verificationCode'";
        mysqli_query($conn, $updateQuery);

        echo "Your email has been verified successfully!";
    } else {
        echo "Invalid verification code.";
    }
} else {
    echo "Verification code is missing.";
}


$footer = '../incl/footer.incl.php';
include ("$footer");
?>
