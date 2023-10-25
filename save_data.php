<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "safco";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the POST request
$productDescription = $_POST['productDescription'];
$kg = $_POST['kg'];
$qty = $_POST['qty'];
$unitPrice = $_POST['unitPrice'];
$total = $_POST['total'];

// Insert data into the database
$sql = "INSERT INTO records (productDescription, kg, qty, unitPrice, total) VALUES ('$productDescription', '$kg', $qty, $unitPrice, '$total')";

if ($conn->query($sql) === TRUE) {
    echo "Data saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
