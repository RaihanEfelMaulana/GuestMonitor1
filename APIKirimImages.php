<?php
require_once 'conn.php'; // Menggunakan file koneksi yang sudah ada

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Path to store uploaded images
    $targetDir = "uploads/";
    
    // Generate a unique file name
    $uniqueName = uniqid() . '-' . basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $uniqueName;

    // Upload file to server
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        // Insert image file name into database
        $sql = "INSERT INTO dashboard (gambar) VALUES ('$uniqueName')";

        if ($conn->query($sql) === TRUE) {
            echo json_encode(["status" => "success", "message" => "The file has been uploaded and inserted into database successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Sorry, there was an error uploading your file."]);
    }

    // Close connection
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
