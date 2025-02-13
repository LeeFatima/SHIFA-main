<?php
include 'connection.php';

if (!isset($_SESSION['pharmacy_id'])) {
    header("Location: login.php");
    exit;
}

$pharmacy_id = $_SESSION['pharmacy_id'];

$sql = "SELECT * FROM pharmacy WHERE pharmacy_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pharmacy_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pharmacy = $result->fetch_assoc();

    // تحديد الصورة، إذا لم تكن موجودة يتم عرض صورة افتراضية
    $profile_image = !empty($pharmacy['profile_image']) ? $pharmacy['profile_image'] : 'client.jpg';
?>

<div class="pharmacy-info">
    <!-- عرض صورة البروفايل -->
    <img src="../public/images/<?php echo htmlspecialchars($profile_image); ?>" alt="Pharmacy Profile" class="profile-img">
    
    <p><strong>Name:</strong> <?php echo htmlspecialchars($pharmacy['pharmacy_name']); ?></p>
    <p><strong>License Number:</strong> <?php echo htmlspecialchars($pharmacy['pharmacy_liscense_number']); ?></p>
    <p><strong>Phone:</strong> <?php echo htmlspecialchars($pharmacy['phone_number']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($pharmacy['email']); ?></p>
</div>

<?php
} else {
    echo "<p class='error-message'>Pharmacy not found!</p>";
}

$stmt->close();
$conn->close();
?>