<?php
session_start();
require_once 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan data POST ada sebelum mengaksesnya
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['user'] = $email;
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "fail", "message" => "Invalid username or password."]);
        }
    } else {
        echo json_encode(["status" => "fail", "message" => "Email and password are required."]);
    }
}
?>
