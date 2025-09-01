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
    } elseif ($action === 'upload_notice') {
        handleNoticeUpload();
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
    
    if (!password_verify($password, $user['hashed_password'])) {
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

/*
function handleSignup() {
    $conn = getDBConnection();
    
    $name = $_POST['name'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if (empty($name) || empty($user_id) || empty($password) || empty($role) || empty($email)) {
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
    $stmt = $conn->prepare("INSERT INTO users (name, user_id, password, hashed_password, email, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $user_id, $password, $hashed_password, $email, $role);
    
    if ($stmt->execute()) {
        header("Location: website.php?tab=login&success=Account created successfully. Please login.");
        exit();
    } else {
        header("Location: website.php?tab=create-account&error=Error creating account");
        exit();
    }
}
*/

/*
function handleSignup() {
    $conn = getDBConnection();
    
    $name = $_POST['name'] ?? '';
    $building = $_POST['building'] ?? '';
    $room = $_POST['room'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $email = $_POST['email'] ?? '';
    
    if (empty($name) || empty($building) || empty($room) || empty($password) || empty($role) || empty($email)) {
        header("Location: website.php?tab=create-account&error=All fields are required");
        exit();
    }
    
    // Generate user ID from building and room
    $user_id = generateUserId($building, $room);
    
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
    $stmt = $conn->prepare("INSERT INTO users (name, user_id, password, hashed_password, email, role, building, room) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $user_id, $password, $hashed_password, $email, $role, $building, $room);
    
    if ($stmt->execute()) {
        header("Location: website.php?tab=login&success=Account created successfully. Please login. Your User ID is: " . $user_id);
        exit();
    } else {
        header("Location: website.php?tab=create-account&error=Error creating account");
        exit();
    }
}
*/

function handleSignup() {
    $conn = getDBConnection();
    
    $name = $_POST['name'] ?? '';
    $building = $_POST['building'] ?? '';
    $room = $_POST['room'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $email = $_POST['email'] ?? '';
    
    // Individual field validation with specific error messages
    if (empty($name)) {
        header("Location: website.php?tab=create-account&error=Full name is required");
        exit();
    }
    
    if (empty($building)) {
        header("Location: website.php?tab=create-account&error=Building number is required");
        exit();
    }
    
    // Validate building format
    if (!empty($building) && !preg_match('/^[A-Z]-[0-9]{1,3}$/', $building)) {
        header("Location: website.php?tab=create-account&error=Building format should be Letter-Number (e.g., C-49)");
        exit();
    }
    
    if (empty($room)) {
        header("Location: website.php?tab=create-account&error=Room number is required");
        exit();
    }
    
    // Validate room format
    if (!empty($room) && !preg_match('/^[0-9]{1,2}\/[0-9]{1,3}$/', $room)) {
        header("Location: website.php?tab=create-account&error=Room format should be Floor/Room (e.g., 2/10)");
        exit();
    }
    
    if (empty($password)) {
        header("Location: website.php?tab=create-account&error=Password is required");
        exit();
    }
    
    // Validate password strength (optional)
    if (strlen($password) < 6) {
        header("Location: website.php?tab=create-account&error=Password must be at least 6 characters long");
        exit();
    }
    
    if (empty($role)) {
        header("Location: website.php?tab=create-account&error=Please select a role");
        exit();
    }
    
    if (empty($email)) {
        header("Location: website.php?tab=create-account&error=Email address is required");
        exit();
    }
    
    // Validate email format
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: website.php?tab=create-account&error=Please enter a valid email address");
        exit();
    }
    
    // Generate user ID from building and room
    $user_id = generateUserId($building, $room);
    
    // Check if user already exists
    $stmt = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        header("Location: website.php?tab=create-account&error=User ID already exists. Please check your building and room details");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, user_id, password, hashed_password, email, role, building, room) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $name, $user_id, $password, $hashed_password, $email, $role, $building, $room);
    
    if ($stmt->execute()) {
        header("Location: website.php?tab=login&success=Account created successfully. Please login. Your User ID is: " . $user_id);
        exit();
    } else {
        header("Location: website.php?tab=create-account&error=Error creating account: " . $conn->error);
        exit();
    }
}

// Helper function to generate user ID from building and room
function generateUserId($building, $room) {
    // Extract building letter and number (e.g., C-49 becomes C and 49)
    $building_parts = explode('-', $building);
    $building_letter = $building_parts[0];
    $building_number = $building_parts[1] ?? '';
    
    // Extract floor and room number (e.g., 2/10 becomes 2 and 10)
    $room_parts = explode('/', $room);
    $floor = $room_parts[0] ?? '';
    $room_number = $room_parts[1] ?? '';
    
    // Combine to form user ID (e.g., C49210)
    return $building_letter . $building_number . $floor . $room_number;
}

//#########
// Handle notice upoad
function handleNoticeUpload() {
    // Validate user role
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        $_SESSION['error'] = "Unauthorized access";
        header("Location: website.php");
        exit();
    }

    // Validate form inputs
    $title = $_POST['title'] ?? '';
    $file = $_FILES['notice-file'] ?? null;

    if (empty($title) || !$file || $file['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Invalid file or title";
        header("Location: website.php");
        exit();
    }

    // Validate file type (PDF only)
    $allowedTypes = ['application/pdf'];
    if (!in_array($file['type'], $allowedTypes)) {
        $_SESSION['error'] = "Only PDF files are allowed";
        header("Location: website.php");
        exit();
    }

    // Validate file size (max 5MB)
    $maxSize = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $maxSize) {
        $_SESSION['error'] = "File size exceeds 5MB limit";
        header("Location: website.php");
        exit();
    }

    // Prepare file storage
    //$fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
    //$fileName = uniqid('notice_', true) . '.' . $fileExt;
    //$uploadDir = __DIR__ . '/uploads/notices/';
    //$filePath = 'uploads/notices/' . $fileName;
    //$absolutePath = $uploadDir . $fileName;

    // Create directory if missing
    //if (!is_dir($uploadDir)) {
      //  mkdir($uploadDir, 0777, true);
    //}

    // Read file content instead of moving file
    $fileContent = file_get_contents($file['tmp_name']);
    $fileType = $file['type'];
    
    $conn = getDBConnection();

    // Move file and save to database
    /*if (move_uploaded_file($file['tmp_name'], $absolutePath)) {
        $stmt = $conn->prepare("INSERT INTO notices (title, file_path, file_name, file_size, uploaded_by) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssis", 
            $title, 
            $filePath,
            $file['name'], 
            $file['size'], 
            $_SESSION['user']['user_id']
        );
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Notice uploaded successfully";
        } else {
            unlink($absolutePath);
            $_SESSION['error'] = "Database error: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "File upload failed";
    }*/

    $stmt = $conn->prepare("INSERT INTO notices (title, file_name, file_size, file_type, file_content, uploaded_by) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", 
        $title, 
        $file['name'],
        $file['size'],
        $fileType,
        $fileContent,
        $_SESSION['user']['user_id']
    );
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Notice uploaded successfully";
    } else {
        $_SESSION['error'] = "Database error: " . $conn->error;
    }
    
    header("Location: website.php?tab=committee-notices");
    exit();
}

function getNotices() {
    if (!isset($_SESSION['user'])) {
        header("Location: website.php");
        exit();
    }

    $conn = getDBConnection();
    $notices = [];

    // FIXED QUERY: Added full_name as uploaded_by_name
    $query = "SELECT n.notice_id, n.title, n.file_name, 
                     n.file_size, n.created_at, u.name as uploaded_by_name, n.uploaded_by
              FROM notices n 
              JOIN users u ON n.uploaded_by = u.user_id 
              ORDER BY n.created_at DESC";

    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $notices[] = $row;
        }
        $result->free();
    } else {
        die("Database error: " . $conn->error);
    }

    $conn->close();
    return $notices;
}

//Handle notice retrival
/*if (isset($_GET['action']) && $_GET['action'] === 'view_notice' && isset($_GET['id'])) {
    $notices = getNotices();
    
    if (empty($notices)) {
        echo '<p>No notices found.</p>';
    } else {
        echo '<table class="notices-table">';
        echo '<thead><tr>
                <th>Title</th>
                <th>File Name</th>
                <th>Size</th>
                <th>Uploaded By</th>
                <th>Date</th>
                <th>Action</th>
              </tr></thead>';
        echo '<tbody>';
        
        foreach ($notices as $notice) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($notice['title']) . '</td>';
            echo '<td>' . htmlspecialchars($notice['file_name']) . '</td>';
            echo '<td>' . formatFileSize($notice['file_size']) . '</td>';
            echo '<td>' . htmlspecialchars($notice['uploaded_by_name']) . '</td>';
            echo '<td>' . date('d M Y H:i', strtotime($notice['created_at'])) . '</td>';
            echo '<td class="actions">';
            echo '<a href="code.php?action=view_notice&id=' . $notice['notice_id'] . '" target="_blank" class="view-btn">View</a>';
            
            // Add delete button for committee members
            if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'committee') {
                echo '<button onclick="deleteNotice(' . (int)$notice['notice_id'] . ')" class="delete-btn">Delete</button>';
            }
            
            echo '</td>';
            echo '</tr>';
        }
        
        echo '</tbody></table>';
    }
    exit(); 
    
    // Verify authentication
    if (!isset($_SESSION['user'])) {
        die("Unauthorized access");
    }

    $noticeId = (int)$_GET['id'];
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT file_name, file_type, file_content 
                           FROM notices WHERE notice_id = ?");
    $stmt->bind_param("i", $noticeId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $notice = $result->fetch_assoc();
        
        // Output file directly
        header("Content-Type: " . $notice['file_type']);
        header("Content-Disposition: inline; filename=\"" . $notice['file_name'] . "\"");
        echo $notice['file_content'];
        exit;
    } else {
        http_response_code(404);
        echo "Notice not found";
    }
    
}

function formatFileSize($bytes) {
    if ($bytes >= 1048576) {
        return round($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return round($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}*/
//@@@@
if (isset($_GET['action']) && $_GET['action'] === 'view_notice' && isset($_GET['id'])) {
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        exit("Unauthorized access");
    }

    $noticeId = (int)$_GET['id'];
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT file_name, file_type, file_content, file_size FROM notices WHERE notice_id = ?");
    $stmt->bind_param("i", $noticeId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $notice = $result->fetch_assoc();

        // Clean output buffer
        if (ob_get_level()) {
            ob_end_clean();
        }

        header("Content-Type: " . $notice['file_type']);
        header('Content-Disposition: inline; filename="' . $notice['file_name'] . '"');
        header('Content-Length: ' . $notice['file_size']);
        echo $notice['file_content'];
        exit;
    } else {
        http_response_code(404);
        exit("Notice not found");
    }
}
//@@@@
// Add this block to enable AJAX fetching of notices as HTML
if (isset($_GET['action']) && $_GET['action'] === 'get_notices') {
    if (!isset($_SESSION['user'])) {
        echo '<p>Please login to view notices.</p>';
        exit();
    }

    $notices = getNotices();

    if (empty($notices)) {
        echo '<p>No notices found.</p>';
        exit();
    }

    echo '<div class="table-responsive">';
    echo '<table class="notice-table">';
    echo '<thead>
            <tr>
                <th>Title</th>
                <th>File Name</th>
                <th>Size</th>
                <th>Uploaded By</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
          </thead>';
    echo '<tbody>';

    foreach ($notices as $notice) {
        $fileSize = $notice['file_size'];
        if ($fileSize >= 1048576) {
            $sizeText = round($fileSize / 1048576, 2) . ' MB';
        } elseif ($fileSize >= 1024) {
            $sizeText = round($fileSize / 1024, 2) . ' KB';
        } else {
            $sizeText = $fileSize . ' bytes';
        }
        $date = date('d M Y H:i', strtotime($notice['created_at']));

        echo '<tr>';
        echo '<td>' . htmlspecialchars($notice['title']) . '</td>';
        echo '<td>' . htmlspecialchars($notice['file_name']) . '</td>';
        echo '<td>' . $sizeText . '</td>';
        echo '<td>' . htmlspecialchars($notice['uploaded_by_name']) . '</td>';
        echo '<td>' . $date . '</td>';
        echo '<td class="actions">';
        echo '<a href="code.php?action=view_notice&id=' . $notice['notice_id'] . '" target="_blank" class="view-btn">View</a>';
        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'committee') {
            echo '<button onclick="deleteNotice(' . (int)$notice['notice_id'] . ')" class="delete-btn">Delete</button>';
        }
        echo '</td>';
        echo '</tr>';
    }
    echo '</tbody></table></div>';
    exit();
}

// Handle notice deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete_notice' && isset($_GET['id'])) {
    // Verify user is logged in and has committee role
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        $_SESSION['error'] = 'Unauthorized access';
        header("Location: website.php");
        exit();
    }

    $conn = getDBConnection();
    $noticeId = (int)$_GET['id'];
    
    // First get the file path to delete the physical file
    /* $stmt = $conn->prepare("SELECT file_path FROM notices WHERE notice_id = ?");
    $stmt->bind_param("i", $noticeId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['error'] = 'Notice not found';
        header("Location: website.php");
        exit();
    }
    
    $notice = $result->fetch_assoc();
    $filePath = $notice['file_path'];
    
    // Delete from database
    $stmt = $conn->prepare("DELETE FROM notices WHERE notice_id = ?");
    $stmt->bind_param("i", $noticeId);
    
    if ($stmt->execute()) {
        // Delete the file if it exists
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $_SESSION['success'] = 'Notice deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting notice';
    } */
    
    // Directly delete from database
    $stmt = $conn->prepare("DELETE FROM notices WHERE notice_id = ?");
    $stmt->bind_param("i", $noticeId);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Notice deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting notice';
    }
    
    // Redirect back to the notices page
    if ($_SESSION['user']['role'] === 'committee') {
        header("Location: website.php?tab=committee-notices");
    } else {
        header("Location: website.php?tab=notices");
    }
    exit();
}
//#########
// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: website.php");
    exit();
}
?>