<?php
$servername = "localhost";
$username = "root"; // Change to your database username
$password = "bekalvaish272005"; // Change to your database password
$dbname = "airlinemanagementsystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aadhar = $_POST["aadhar"];

    // Check if Aadhar exists
    $sql = "SELECT * FROM bookings WHERE aadhar = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $aadhar);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Cancel the flight
        $sql = "DELETE FROM bookings WHERE aadhar = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $aadhar);

        if ($stmt->execute()) {
            // ✅ Fix: Redirect to logedup.html
            header("Location: logedup.html");
                 exit(); // Ensure script stops execution after redirect
        }
         else {
            echo "Error: " . $stmt->error;
        }
    }
$stmt->close();
$conn->close();
}
?>