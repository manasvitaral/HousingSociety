<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'housing_society');

session_start();

// Connect to database
function getDBConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'login') {
        handleLogin();
    } elseif ($action === 'signup') {
        handleSignup();
    } else {
        header("Location: website.php?error=Invalid action");
        exit();
    }
}

function handleLogin() {
    $conn = getDBConnection();
    
    $user_id = $_POST['user_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    
    if (empty($user_id) || empty($password) || empty($role)) {
        header("Location: website.php?tab=login&error=All fields are required");
        exit();
    }
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        header("Location: website.php?tab=login&error=User not found");
        exit();
    }
    
    $user = $result->fetch_assoc();
    
    if (!password_verify($password, $user['password'])) {
        header("Location: website.php?tab=login&error=Invalid password");
        exit();
    }
    
    if ($user['role'] !== $role) {
        header("Location: website.php?tab=login&error=Invalid role for this user");
        exit();
    }
    
    // Store user in session
    $_SESSION['user'] = [
        'user_id' => $user['user_id'],
        'name' => $user['name'],
        'role' => $user['role']
    ];
    
    // Redirect to appropriate page based on role
    header("Location: website.php");
    exit();
}

function handleSignup() {
    $conn = getDBConnection();
    
    $name = $_POST['name'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    
    if (empty($name) || empty($user_id) || empty($password) || empty($role)) {
        header("Location: website.php?tab=create-account&error=All fields are required");
        exit();
    }
    
    // Check if user already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        header("Location: website.php?tab=create-account&error=User ID already exists");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, user_id, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $user_id, $hashed_password, $role);
    
    if ($stmt->execute()) {
        header("Location: website.php?tab=login&success=Account created successfully. Please login.");
        exit();
    } else {
        header("Location: website.php?tab=create-account&error=Error creating account");
        exit();
    }
}

// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: website.php");
    exit();
}
?>