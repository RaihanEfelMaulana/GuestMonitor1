<?php
session_start();
require_once 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan data POST ada sebelum mengaksesnya
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];

        // Cek apakah email sudah ada di database
        $sql_check = "SELECT * FROM users WHERE email = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            echo json_encode(["status" => "fail", "message" => "Email already registered."]);
        } else {
            // Masukkan data user baru ke database
            $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $username, $password, $email);

            if ($stmt->execute()) {
                $_SESSION['user'] = $email;
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "fail", "message" => "Registration failed. Please try again."]);
            }
        }
    } else {
        echo json_encode(["status" => "fail", "message" => "Email, username, and password are required."]);
    }
} else {
    echo json_encode(["status" => "fail", "message" => "Invalid request method."]);
}
?>
