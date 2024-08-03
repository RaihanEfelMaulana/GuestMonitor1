<?php
include 'conn.php';

// Query untuk mengambil data dari 7 hari terakhir
$sql = "SELECT DATE(waktu) AS date, COUNT(*) AS count 
        FROM dashboard 
        WHERE DATE(waktu) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        GROUP BY DATE(waktu) 
        ORDER BY DATE(waktu) DESC";

$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = ["status" => "error", "message" => "No data found"];
}

echo json_encode($data);

$conn->close();
?>
