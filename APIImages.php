<?php
require_once 'conn.php';

// Mengambil data gambar yang hanya ada pada hari ini
$sql = "SELECT gambar FROM dashboard WHERE DATE(waktu) = CURDATE()";
$result = $conn->query($sql);

$images = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $images[] = 'uploads/' . $row['gambar'];
    }
}

echo json_encode($images);
?>
