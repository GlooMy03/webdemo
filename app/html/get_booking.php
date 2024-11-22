<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "mellanova_hotel";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
 
$sql = "SELECT * FROM booking";
$result = $conn->query($sql);
 
$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Access-Control-Allow-Origin: *'); // Membolehkan akses dari semua origin
header('Content-Type: application/json');
echo json_encode($data);
 
$conn->close();
?>