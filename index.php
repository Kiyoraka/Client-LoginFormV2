<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: welcome.php");
    exit;
}

// Define credentials (in a real application, these would be stored securely)
$valid_username = "admin";
$valid_password = "password123";

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Validate credentials
    if ($username === $valid_username && $password === $valid_password) {
        // Start session and store login status
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        
        // Handle remember me
        if (isset($_POST['remember']) && $_POST['remember'] == 'on') {
            setcookie('username', $username, time() + (86400 * 30), "/"); // 30 days
        }
        
        header("Location: welcome.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login v2</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <div class="logo-container">
                <img src="assets/img/logo.png" alt="Main Logo" class="logo">
                <h2>Client Login</h2>
            </div>
            <?php if (!empty($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Username" 
                           value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>" 
                           required>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <i class="fas fa-eye-slash toggle-password"></i>
                </div>
                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember" <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>>
                        Remember me
                    </label>
                    <a href="#">Forgot Password?</a>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="register-link">
                Don't have an account? <a href="#">Register here</a>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        document.querySelector('.toggle-password').addEventListener('click', function() {
            const password = document.querySelector('#password');
            if (password.type === 'password') {
                password.type = 'text';
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            } else {
                password.type = 'password';
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            }
        });
    </script>
</body>
</html>