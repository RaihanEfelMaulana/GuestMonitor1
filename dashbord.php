<?php
// Data menu untuk sidebar
$menuItems = [
    ['icon' => 'tachometer-alt', 'text' => 'Dashboard', 'active' => true, 'file' => 'dashbord.php'],
    ['icon' => 'users', 'text' => 'Data Sensor', 'file' => 'data.php'],
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Monitor</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            transition: all 0.3s; /* Add transition for smooth hiding/showing */
        }

        

        .navbar .toggle-sidebar {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
        }
        @keyframes slide {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        .slider-container {
            overflow: hidden;
            white-space: nowrap;
        }
        .slider {
            display: inline-block;
            animation: slide 10s linear infinite;
        }
        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
            border: 1px solid #ddd;
            margin-top: 5px;
        }
        .image-container img {
            max-width: 100%;
            max-height: 100%;
            display: flex;
        }
        .content {
            flex-grow: 1;
            background-color: #f4f6f9;
            padding: 20px;
        }

        /* Canvas Styles */
        .chart-container {
            width: 80%;
            max-width: 800px;
            height: 300px;
            margin: 10px auto; /* Margin auto untuk tengah horizontal */
            margin-left: 340px;
        }
        .button-container {
            text-align: right;
            margin : 20px;
        }

        .button-container button {
            padding: 10px 20px;
            background-color: #0077cc;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .button-container button:hover {
            background-color: #005fa3;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .button-container button:active {
            background-color: #004080;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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
        <div class="card">
            <div class="button-container">
                    <button id="openDoorButton">Unlock</button>
            </div>
            <div class="image-container" id="imageContainer">
                <!-- Gambar akan ditampilkan di sini -->
                <img src="" alt="Image" id="displayedImage">
            </div>

        <!-- Grafik akan ditampilkan di sini, di bawah konten -->
        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
    </div>
    </div>
    </div>

    <script>
        document.querySelector('.toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });

        document.addEventListener('DOMContentLoaded', function() {
            fetch('APIGrafik.php')
                .then(response => response.json())
                .then(data => {
                    const labels = data.map(item => item.date);
                    const counts = data.map(item => item.count);

                    const ctx = document.getElementById('myChart').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'line', // jenis grafik: line, bar, pie, dll.
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah Data per Hari',
                                data: counts,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                fill: false,
                                tension: 0.1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });

        document.addEventListener('DOMContentLoaded', function() {
            fetch('APIImages.php')
                .then(response => response.json())
                .then(data => {
                    const imageContainer = document.getElementById('imageContainer');
                    const displayedImage = document.getElementById('displayedImage');
                    let currentIndex = 0;

                    if (data.length > 0) {
                        displayedImage.src = data[currentIndex];
                        
                        setInterval(() => {
                            currentIndex = (currentIndex + 1) % data.length;
                            displayedImage.src = data[currentIndex];
                        }, 2000); // Ubah gambar setiap 3 detik
                    } else {
                        imageContainer.innerText = 'No images available.';
                    }
                })
                .catch(error => {
                    console.error('Error fetching images:', error);
                    document.getElementById('imageContainer').innerText = 'Failed to load images.';
                });
                document.getElementById('toggleNavbarButton').addEventListener('click', function() {
                const navbar = document.getElementById('sidebar');
                sidebar.classList.toggle('hidden');
            });
        });

        document.querySelector('.toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('collapsed');
        });

    </script>
</body>
</html>
