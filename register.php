<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Nama Website</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .card {
            width: 100%;
            max-width: 330px;
            padding: 15px;
            margin: auto;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            background-color: #fff;
        }
        .card-title {
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 500;
        }
        .form-label {
            font-weight: 500;
        }
        .btn-register {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        .btn-register:hover {
            background-color: #45a049;
            border-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="card">
        <h4 class="card-title">Guest Monitor - Register</h4>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form id="registerForm">
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-register btn-block">Register</button>
        </form>
        <p class="mt-3 mb-0 text-center">
            Already have an account? 
            <a href="login.php" class="text-primary">Login here</a>
        </p>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            var formData = new FormData(this);

            fetch('APIregister.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert('Registration successful! Redirecting to login page.');
                    window.location.href = 'login.php';
                } else {
                    alert('Registration failed: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
