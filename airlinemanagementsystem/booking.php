<?php
$servername = "localhost";
$username = "root"; // Change to your actual DB username
$password = "bekalvaish272005"; // Change to your actual DB password
$dbname = "airlinemanagementsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data securely
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aadhar = isset($_POST['aadhar']) ? trim($_POST['aadhar']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $nationality = isset($_POST['nationality']) ? trim($_POST['nationality']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $source = isset($_POST['source']) ? trim($_POST['source']) : '';
    $destination = isset($_POST['destination']) ? trim($_POST['destination']) : '';
    $flight_name = isset($_POST['flight_name']) ? trim($_POST['flight_name']) : '';
    $flight_code = isset($_POST['flight_code']) ? trim($_POST['flight_code']) : '';
    $date_of_travel = isset($_POST['date_of_travel']) ? trim($_POST['date_of_travel']) : '';

    // Validate required fields
    if (empty($aadhar) || empty($name) || empty($nationality) || empty($address) || empty($gender) || empty($source) || empty($destination) || empty($flight_name) || empty($flight_code) || empty($date_of_travel)) {
        die("Error: All fields are required.");
    }

    // Check if booking already exists for this Aadhar number
    $sql = "SELECT * FROM bookings WHERE aadhar = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $aadhar);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Booking exists, update the record
        $sql = "UPDATE bookings SET 
                name=?, nationality=?, address=?, gender=?, source=?, destination=?, flight_name=?, flight_code=?, date_of_travel=?
                WHERE aadhar=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $name, $nationality, $address, $gender, $source, $destination, $flight_name, $flight_code, $date_of_travel, $aadhar);
    } else {
        // No existing booking, insert new record
        $sql = "INSERT INTO bookings (aadhar, name, nationality, address, gender, source, destination, flight_name, flight_code, date_of_travel)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $aadhar, $name, $nationality, $address, $gender, $source, $destination, $flight_name, $flight_code, $date_of_travel);
    }

    // Execute the query
    if ($stmt->execute()) {
        header("Location: logedup.html"); // Redirect to confirmation page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>