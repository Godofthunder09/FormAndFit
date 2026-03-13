<?php
session_start();
// Ensure the path to the database connection file is correct
require_once '../database/db_connection.php'; 

$login_error = '';

// Check if the user is already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: admin_master.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $login_error = 'Please enter both username and password.';
    } else {
        // Query the database for the user
        $query = "SELECT id, username, password_hash FROM admin_users WHERE username = ?";
        $stmt = mysqli_prepare($con, $query);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);

            // Verify password using password_verify()
            if ($user && password_verify($password, $user['password_hash'])) {
                // Login successful
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                // Redirect to the dashboard
                header('Location: admin_master.php');
                exit;
            } else {
                $login_error = 'Invalid username or password.';
            }
        } else {
            $login_error = 'Database error during query preparation.';
        }
    }
}

// HTML for the login form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md">
        <div class="bg-white p-8 rounded-xl shadow-2xl border-t-4 border-red-600">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-6">
                Admin Panel Login
            </h2>
            <p class="text-sm text-center text-gray-600 mb-8">
                Enter your credentials to manage the product catalog.
            </p>

            <?php if ($login_error): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline"><?php echo $login_error; ?></span>
                </div>
            <?php endif; ?>

            <form class="space-y-6" action="login.php" method="POST">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input id="username" name="username" type="text" autocomplete="username" required
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm pr-10">
                        
                        <button type="button" id="togglePassword" 
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-red-600 transition duration-150"
                                aria-label="Show password">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off">
                                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.73-1.66a3 3 0 1 1-5.1-5.1"></path>
                                <line x1="1" y1="1" x2="23" y2="23"></line>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                    Sign in
                </button>
            </form>
        </div>
    </div>
    
    <script>
        document.getElementById('togglePassword').addEventListener('click', function (e) {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle the SVG icon (optional, but good for UX)
            const icon = document.getElementById('eyeIcon');
            if (type === 'text') {
                // Change to 'eye' icon
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
                icon.setAttribute('class', 'feather feather-eye');
                this.setAttribute('aria-label', 'Hide password');
            } else {
                // Change back to 'eye-off' icon
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.73-1.66a3 3 0 1 1-5.1-5.1"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
                icon.setAttribute('class', 'feather feather-eye-off');
                this.setAttribute('aria-label', 'Show password');
            }
        });
    </script>
</body>
</html>
<?php
// Safely close the database connection
if (isset($con) && $con && mysqli_ping($con)) {
    mysqli_close($con);
}
?>

