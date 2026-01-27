<?php
// --- Database connection settings ---
$host = "localhost";          // your DB host
$dbname = "your_database";    // your DB name
$user = "your_username";      // your DB username
$pass = "your_password";      // your DB password

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Handle form submission ---
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $petName = $_POST['petName'] ?? '';
    $price = $_POST['price'] ?? 0;
    $customerName = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $address = $_POST['address'] ?? '';
    $paymentMethod = $_POST['paymentMethod'] ?? '';

    // Insert into database using prepared statement
    $stmt = $conn->prepare("INSERT INTO orders (pet_name, price, customer_name, email, address, payment_method) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssss", $petName, $price, $customerName, $email, $address, $paymentMethod);

    if ($stmt->execute()) {
        $message = "Order successfully submitted!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

// --- Optional: display message ---
if ($message) {
    echo "<p style='color:green;font-weight:bold;'>$message</p>";
}
?>
