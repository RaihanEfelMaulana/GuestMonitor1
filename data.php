<?php
require_once 'conn.php'; // Menggunakan file koneksi yang sudah ada

// Data menu untuk sidebar
$menuItems = [
    ['icon' => 'tachometer-alt', 'text' => 'Dashboard', 'file' => 'dashbord.php'],
    ['icon' => 'users', 'text' => 'Data Sensor', 'active' => true, 'file' => 'data.php'],
    ['icon' => 'sign-out-alt', 'text' => 'Logout', 'file' => 'login.php'],
];

// Fungsi untuk membuat item menu
function createMenuItem($item) {
    $activeClass = $item['active'] ?? false ? 'active' : '';
    $file = $item['file'] ?? '#';
    return "
        <li class='nav-item {$activeClass}'>
            <a class='nav-link' href='{$file}'>
                <i class='fas fa-{$item['icon']}'></i>
                <span>{$item['text']}</span>
            </a>
        </li>
    ";
}

// Ambil data gambar dari database
$sql = "SELECT id, gambar, waktu FROM dashboard";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Monitor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 200px;
            background-color: #343a40;
            color: #fff;
            transition: all 0.3s;
        }
        .sidebar.hidden {
            display: none;
        }

        .sidebar .logo {
            padding: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            background-color: #2c3136;
        }

        .sidebar .nav {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar .nav-item {
            position: relative;
        }

        .sidebar .nav-link {
            display: block;
            padding: 15px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-item.active .nav-link {
            color: #fff;
            background-color: #0077cc;
        }

        /* Main Content Styles */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #0077cc;
            color: #fff;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .toggle-sidebar {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
        }

        .content {
            flex-grow: 1;
            background-color: #f4f6f9;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .table-container {
            width: 100%;
            max-width: 1000px;
            margin: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #f0f0f0; /* Warna abu-abu */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center; /* Rata tengah */
            font-size: 16px;
        }

        th {
            background-color: #a0a0a0; /* Warna abu-abu yang lebih gelap untuk header */
            color: #fff;
        }
        
        img {
            max-width: 100px;
            height: auto;
        }

        .upload-form {
            margin-bottom: 20px;
        }

        .upload-form form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .upload-form label {
            margin-bottom: 10px;
        }

        .upload-form input[type="file"] {
            margin-bottom: 10px;
        }

        .upload-form input[type="submit"] {
            padding: 5px 10px;
            background-color: #0077cc;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="sidebar" id="sidebar">
        <div class="logo">Guest Monitor</div>
        <ul class="nav">
            <?php
            foreach ($menuItems as $item) {
                echo createMenuItem($item);
            }
            ?>
        </ul>
    </nav>

    <div class="main-content">
    <nav class="navbar" id="navbar">
        <button class="toggle-sidebar" id="toggleNavbarButton">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
        <div class="content">
            <div class="table-container">
            <div class="card">
            <h4 class="card-title"">Data Tamu</h4>
        </div>
                <table>
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Hari/Tanggal</th>
                            <th>Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>{$row['id']}</td>";
                                echo "<td>{$row['waktu']}</td>";
                                echo "<td><img src='uploads/{$row['gambar']}' alt='Image'></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No images found in the uploads directory.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });
        document.getElementById('toggleNavbarButton').addEventListener('click', function() {
                const navbar = document.getElementById('sidebar');
                sidebar.classList.toggle('hidden');
        });
    </script>
</body>
</html>
