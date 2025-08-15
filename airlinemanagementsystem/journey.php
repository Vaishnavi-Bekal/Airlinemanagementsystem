<?php
$servername = "localhost";
$username = "root"; // Change to your database username
$password = "bekalvaish272005"; // Change to your database password
$dbname = "airlinemanagementsystem";

// Establish Database Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aadhar = $_POST["aadhar"];

    // Fetch customer details
    $sql = "SELECT name,address,destination,flight_name, flight_code, date_of_travel FROM bookings WHERE aadhar = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $aadhar);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(["error" => "No booking found for this Aadhar number."]);
    }
    $stmt->close();
}

$conn->close();
?>