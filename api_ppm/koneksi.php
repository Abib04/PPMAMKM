<?php
$servername = "localhost";
$username = "ppm_2020";
$password = "";
$db = "ppm_2020";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
