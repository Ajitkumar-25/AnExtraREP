<?php
$email = $_GET['email'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "health";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch the health report file path from the database
$sql = "SELECT report_path FROM health_reports WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $reportPath = $row['report_path'];

  // Download the health report file
  if (file_exists($reportPath)) {
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename='health_report.pdf'");
    readfile($reportPath);
  } else {
    echo "Health report not found.";
  }
} else {
  echo "No health report found for the specified email.";
}

$conn->close();
?>
