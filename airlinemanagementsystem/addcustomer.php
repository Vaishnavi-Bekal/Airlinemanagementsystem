<?php
$servername = "localhost";
$username = "root"; // Change to your actual DB username
$password = "bekalvaish272005"; // Change to your actual DB password
$dbname = "airlinemanagementsystem"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data securely
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $nationality = isset($_POST['nationality']) ? trim($_POST['nationality']) : '';
    $aadhar = isset($_POST['aadhar']) ? trim($_POST['aadhar']) : '';

    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';

    // Validate required fields
    if (empty($name) || empty($nationality) || empty($aadhar) ||  empty($gender) || empty($phone)|| empty($address)) {
        die("Error: All fields are required.");
    }

    // Insert data into the database using prepared statements
    $sql = "INSERT INTO addcustomer(name, nationality, aadhar, gender, phone,address)VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $nationality, $aadhar, $gender, $phone, $address);

    if ($stmt->execute()) {
        // ✅ Fix: Redirect to logedup.html
        header("Location: logedup.html");
             exit(); // Ensure script stops execution after redirect
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>