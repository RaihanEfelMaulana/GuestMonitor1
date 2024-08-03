<?php
require_once 'conn.php'; // Menggunakan file koneksi yang sudah ada

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["unlock"])) {
        // Code to unlock the door
        $command = $_POST["unlock"];
        
        if ($command == "open") {
            // Logic to trigger the IoT device to unlock the door
            // This could be done using a HTTP request to the device or a serial communication
            // Here, you would include the specific code to interact with your IoT device
            echo json_encode(["status" => "success", "message" => "Door unlocked successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid unlock command."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "No unlock command provided."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
