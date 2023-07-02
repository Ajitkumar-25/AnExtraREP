<?php
// Get the form data
$name = $_POST['name'];
$age = $_POST['age'];
$weight = $_POST['weight'];
$email = $_POST['email'];
$healthReport = $_FILES['healthReport'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "health";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Upload the health report file
$targetDir = "uploads/";
$targetFile = $targetDir . basename($healthReport["name"]);

if (move_uploaded_file($healthReport["tmp_name"], $targetFile)) {
  // File upload successful, insert data into database
  $sql = "INSERT INTO health_reports (name, age, weight, email, report_path) VALUES ('$name', '$age', '$weight', '$email', '$targetFile')";
  if ($conn->query($sql) === TRUE) {
    echo "Health report submitted successfully!";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} else {
  echo "Error uploading the health report.";
}

$conn->close();
?>
