<?php 
include 'connection.php';
include 'ClearSession.php';
include 'GeoCode.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $pharmacy_name = $_POST['pharmacy_name'];
    $pharmacy_liscense = $_POST['pharmacy_liscense'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $address = $_POST['address'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Get coordinates from geocode function
    $coordinates = geocodeAddress($address);

    if ($coordinates) {
        $latitude = $coordinates['latitude'];
        $longitude = $coordinates['longitude'];
        
        // Prepare SQL query with placeholders
        $sql = "INSERT INTO pharmacy (pharmacy_name, pharmacy_liscense_number, phone_number, email, password, address, longitude, latitude) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        if ($stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("ssssssss", $pharmacy_name, $pharmacy_liscense, $phone, $email, $hashed_password, $address, $longitude, $latitude);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Pharmacy added successfully";
                // Redirect to homepage
                header("Location: ../views/PHhomepage.php");
                exit();  // Ensure no further code is executed after the redirect
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error: Could not prepare the SQL statement.";
        }
    } else {
        echo "Error: Could not geocode address.";
    }
}

$conn->close();
?>
