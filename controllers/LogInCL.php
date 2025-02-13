<?php 


include 'connection.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT client_id, password FROM clients WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    if (password_verify($password, $hashed_password)) {
        // Store login data in session
        $_SESSION['email'] = $email;
        $_SESSION['client_id'] = $row['client_id']; 

        // Redirect with JavaScript to store sessionStorage values
        echo "<script>
            sessionStorage.setItem('user_role', 'client'); 
            sessionStorage.setItem('user_id', '{$row['client_id']}');
            window.location.href = '../views/CLhomepage.php';
        </script>";
    } else {
        echo "Email or password is incorrect";
    }
} else {
    echo "Email or password is incorrect";
}

$stmt->close();
$conn->close();
?>
