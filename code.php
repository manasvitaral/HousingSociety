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
    } elseif ($action === 'upload_photo') {
        handlePhotoUpload();
    } elseif ($action === 'submit_complaint') {  
        handleComplaintSubmission();             
    } elseif ($action === 'update_complaint_status') {  
        updateComplaintStatus();                         
    } elseif ($action === 'update_maintenance_status') {  
        updateMaintenanceStatus();                         
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

//#############---NOTICE_START---############
// Handle notice upload
function handleNoticeUpload() {
    // Validate user role
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        $_SESSION['error'] = "Unauthorized access";
        header("Location: website.php?tab=login");
        exit();
    }

    // Validate form inputs
    $title = $_POST['title'] ?? '';
    $file = $_FILES['notice-file'] ?? null;

    if (empty($title) || !$file || $file['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Invalid file or title";
        header("Location: website.php?tab=committee-notices");
        exit();
    }

    // Validate file type (PDF only)
    $allowedTypes = ['application/pdf'];
    if (!in_array($file['type'], $allowedTypes)) {
        $_SESSION['error'] = "Only PDF files are allowed";
        header("Location: website.php?tab=committee-notices");
        exit();
    }

    // Validate file size (max 5MB)
    $maxSize = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $maxSize) {
        $_SESSION['error'] = "File size exceeds 5MB limit";
        header("Location: website.php?tab=committee-notices");
        exit();
    }
    // Read file content instead of moving file
    $fileContent = file_get_contents($file['tmp_name']);
    $fileType = $file['type'];
    
    $conn = getDBConnection();
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
//###########---NOTICE_END---##############

//##########3---GALLERY_START---##########
// Handle gallery photo upload
function handlePhotoUpload() {
    // Validate user role
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        $_SESSION['error'] = "Unauthorized access";
        header("Location: website.php");
        exit();
    }

    // Validate form inputs
    $title = $_POST['title'] ?? '';
    $file = $_FILES['photo'] ?? null;

    if (empty($title) || !$file || $file['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Invalid file or title";
        header("Location: website.php?tab=committee-gallery");
        exit();
    }

    // Validate file type (PNG only)
    $allowedTypes = ['image/png','image/jpeg'];
    $allowedExtension = ['png','jpeg','jpg'];

    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Get the actual file type using finfo (more reliable than $_FILES['type'])
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $detected = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array ($fileExtension, $allowedExtension) || !in_array ($detected, $allowedTypes)) {
        $_SESSION['error'] = "Only PNG or JPEG files are allowed";
        header("Location: website.php?tab=committee-gallery");
        exit();
    }

    // Use the file type from $_FILES for validation
    $fileType = $file['type'];
    if (!in_array($fileType, $allowedTypes)) {
        $_SESSION['error'] = "Only PNG or JPEG files are allowed. Your file type: " . $fileType;
        header("Location: website.php?tab=committee-gallery");
        exit();
    }

    // Validate file size (max 5MB)
    $maxSize = 5 * 1024 * 1024; // 5MB
    if ($file['size'] > $maxSize) {
        $_SESSION['error'] = "File size exceeds 5MB limit";
        header("Location: website.php?tab=committee-gallery");
        exit();
    }

    // Read file content
    $fileContent = file_get_contents($file['tmp_name']);
    
    $conn = getDBConnection();

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO gallery (title, file_name, file_size, file_type, file_content, uploaded_by) 
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
        $_SESSION['success'] = "Photo uploaded successfully";
    } else {
        $_SESSION['error'] = "Database error: " . $conn->error;
    }
    
    header("Location: website.php?tab=committee-gallery");
    exit();
}

// Get all gallery photos
function getGalleryPhotos() {
    if (!isset($_SESSION['user'])) {
        header("Location: website.php");
        exit();
    }

    $conn = getDBConnection();
    $photos = [];

    $query = "SELECT g.photo_id, g.title, g.file_name, g.file_size, 
                     g.created_at, u.name as uploaded_by_name, g.uploaded_by
              FROM gallery g 
              JOIN users u ON g.uploaded_by = u.user_id 
              ORDER BY g.created_at DESC";

    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $photos[] = $row;
        }
        $result->free();
    } else {
        die("Database error: " . $conn->error);
    }

    $conn->close();
    return $photos;
}

// Handle photo viewing
if (isset($_GET['action']) && $_GET['action'] === 'view_photo' && isset($_GET['id'])) {
    if (!isset($_SESSION['user'])) {
        http_response_code(403);
        exit("Unauthorized access");
    }

    $photoId = (int)$_GET['id'];
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT file_name, file_type, file_content, file_size FROM gallery WHERE photo_id = ?");
    $stmt->bind_param("i", $photoId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $photo = $result->fetch_assoc();

        // Clean output buffer
        if (ob_get_level()) {
            ob_end_clean();
        }

        header("Content-Type: " . $photo['file_type']);
        header('Content-Disposition: inline; filename="' . $photo['file_name'] . '"');
        header('Content-Length: ' . $photo['file_size']);
        echo $photo['file_content'];
        exit;
    } else {
        http_response_code(404);
        exit("Photo not found");
    }
}

// Handle photo deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete_photo' && isset($_GET['id'])) {
    // Verify user is logged in and has committee role
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        $_SESSION['error'] = 'Unauthorized access';
        header("Location: website.php");
        exit();
    }

    $conn = getDBConnection();
    $photoId = (int)$_GET['id'];
    
    // Delete from database
    $stmt = $conn->prepare("DELETE FROM gallery WHERE photo_id = ?");
    $stmt->bind_param("i", $photoId);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Photo deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting photo';
    }
    
    if ($_SESSION['user']['role'] === 'committee') {
        header("Location: website.php?tab=committee-gallery");
    } else {
        header("Location: website.php?tab=gallery");
    }
    exit();
}

// Handle photo title update
/*
if (isset($_POST['action']) && $_POST['action'] === 'update_photo_title' && isset($_POST['id'])) {
    // Verify user is logged in and has committee role
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
        exit();
    }

    $photoId = (int)$_POST['id'];
    $newTitle = trim($_POST['title'] ?? '');
    
    if (empty($newTitle)) {
        echo json_encode(['success' => false, 'message' => 'Title cannot be empty']);
        exit();
    }

    $conn = getDBConnection();
    $stmt = $conn->prepare("UPDATE gallery SET title = ? WHERE photo_id = ?");
    $stmt->bind_param("si", $newTitle, $photoId);
*/

// Handle AJAX request for gallery photos
if (isset($_GET['action']) && $_GET['action'] === 'get_gallery_photos') {
    if (!isset($_SESSION['user'])) {
        echo '<p>Please login to view gallery.</p>';
        exit();
    }

    $photos = getGalleryPhotos();

    if (empty($photos)) {
        echo '<p>No photos found.</p>';
        exit();
    }

    $isCommittee = ($_SESSION['user']['role'] === 'committee');
    
    echo '<div class="gallery-container">';
    
    foreach ($photos as $photo) {
        $fileSize = $photo['file_size'];
        if ($fileSize >= 1048576) {
            $sizeText = round($fileSize / 1048576, 2) . ' MB';
        } elseif ($fileSize >= 1024) {
            $sizeText = round($fileSize / 1024, 2) . ' KB';
        } else {
            $sizeText = $fileSize . ' bytes';
        }
        $date = date('d M Y H:i', strtotime($photo['created_at']));

        echo '<div class="photo-card">';
        echo '<img src="code.php?action=view_photo&id=' . $photo['photo_id'] . '" alt="' . htmlspecialchars($photo['title']) . '">';
        echo '<div class="photo-details">';
        
        if ($isCommittee) {
            echo '<div class="editable-title" data-id="' . $photo['photo_id'] . '">';
            echo '<span class="title-text">' . htmlspecialchars($photo['title']) . '</span>';
            echo '<input type="text" class="title-edit" value="' . htmlspecialchars($photo['title']) . '" style="display:none;">';
            echo '</div>';
        } else {
            echo '<div class="photo-title">' . htmlspecialchars($photo['title']) . '</div>';
        }
        
        echo '<div class="photo-meta">';
        echo '<span>Uploaded by: ' . htmlspecialchars($photo['uploaded_by_name']) . '</span><br>';
        echo '<span>Date: ' . $date . '</span>';
        echo '</div>';
        
        echo '<div class="photo-actions">';
        echo '<a href="code.php?action=view_photo&id=' . $photo['photo_id'] . '" target="_blank" class="view-btn">View</a>';
        if ($isCommittee) {
            echo '<button onclick="deletePhoto(' . $photo['photo_id'] . ')" class="delete-btn">Delete</button>';
        }
        echo '</div>';
        
        echo '</div>';
        echo '</div>';
    }
    
    echo '</div>';
    exit();
}
//##########---GALLERY_END---###########3

//###########---COMPLAINTS_START---##############
// Handle complaint submission
function handleComplaintSubmission() {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'resident') {
        $_SESSION['error'] = "Unauthorized access";
        header("Location: website.php?tab=login");
        exit();
    }

    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $user_id = $_SESSION['user']['user_id'];

    if (empty($title) || empty($description)) {
        $_SESSION['error'] = "Title and description are required";
        header("Location: website.php?tab=complaints");
        exit();
    }

    $conn = getDBConnection();
    $status = 'pending';
    $stmt = $conn->prepare("INSERT INTO complaints (title, description, uploaded_by, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $user_id, $status);

    if ($stmt->execute()) {
        $complaint_id = $stmt->insert_id;
        $q = $conn->prepare("SELECT created_at FROM complaints WHERE complaint_id = ?");
        $q->bind_param("i", $complaint_id);
        $q->execute();
        $r = $q->get_result();
        $row = $r->fetch_assoc();
        $created_at = $row['created_at'];
        $status_history = "pending:-" . $created_at;
        $u = $conn->prepare("UPDATE complaints SET status_history = ? WHERE complaint_id = ?");
        $u->bind_param("si", $status_history, $complaint_id);
        $u->execute();

        $_SESSION['success'] = "Complaint submitted successfully";
    } else {
        $_SESSION['error'] = "Error submitting complaint: " . $conn->error;
    }
    header("Location: website.php?tab=complaints");
    exit();
}

// Get complaints for resident specific
function getResidentComplaints($user_id) {
    $conn = getDBConnection();
    $complaints = [];
    
    $stmt = $conn->prepare("SELECT complaint_id, title, description, status, created_at, status_history FROM complaints WHERE uploaded_by = ? ORDER BY created_at DESC");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
    
    return $complaints;
}

// Get all complaints for committee
function getAllComplaints() {
    $conn = getDBConnection();
    $complaints = [];
    
    $query = "SELECT c.complaint_id, c.title, c.description, c.status, c.created_at, c.status_history, c.uploaded_by, u.name as user_name 
              FROM complaints c 
              JOIN users u ON c.uploaded_by = u.user_id 
              ORDER BY c.created_at DESC";
    
    $result = $conn->query($query);
    
    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
    
    return $complaints;
}

// Update complaint status
function updateComplaintStatus() {

    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        $_SESSION['error'] = "Unauthorized access";
        header("Location: website.php?tab=login");
        exit();
    }

    $complaint_id = $_POST['complaint_id'] ?? '';
    $new_status = $_POST['status'] ?? '';

    if (empty($complaint_id) || empty($new_status)) {
        $_SESSION['error'] = "Invalid request";
        header("Location: website.php?tab=committee-complaints");
        exit();
    }

    $conn = getDBConnection();
    $updated_by = $_SESSION['user']['user_id'];

    $check_stmt = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
    $check_stmt->bind_param("s", $updated_by);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    if ($result->num_rows === 0) {
        $_SESSION['error'] = "Invalid user session";
        header("Location: website.php?tab=login");
        exit();
    }

    // Get current status_history
    $stmt = $conn->prepare("SELECT status_history FROM complaints WHERE complaint_id = ?");
    $stmt->bind_param("i", $complaint_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $complaint = $result->fetch_assoc();

    $current_timestamp = date('Y-m-d');
    $current_history = $complaint['status_history'];
    if (!empty($current_history)) {
        $current_history .= ',';
    }
    $status_history = $current_history . $new_status . ':-' . $current_timestamp;

    $stmt = $conn->prepare("UPDATE complaints SET status = ?, status_history = ?, updated_by = ? WHERE complaint_id = ?");
    $stmt->bind_param("sssi", $new_status, $status_history, $updated_by, $complaint_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Complaint status updated successfully";
    } else {
        $_SESSION['error'] = "Error updating complaint status: " . $conn->error;
    }

    header("Location: website.php?tab=committee-complaints");
    exit();
}

// Handle complaint status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_complaint_status') {
    updateComplaintStatus();
}

// AJAX endpoint to get complaints for resident
if (isset($_GET['action']) && $_GET['action'] === 'get_resident_complaints') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'resident') {
        echo '<tr><td colspan="3">Unauthorized access</td></tr>';
        exit();
    }
    
    $complaints = getResidentComplaints($_SESSION['user']['user_id']);
    renderResidentComplaintsTable($complaints);
    exit();
}

// AJAX endpoint to get all complaints for committee
if (isset($_GET['action']) && $_GET['action'] === 'get_all_complaints') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        echo '<tr><td colspan="5">Unauthorized access</td></tr>';
        exit();
    }
    
    $complaints = getAllComplaints();
    renderCommitteeComplaintsTable($complaints);
    exit();
}

// Render resident complaints table
function renderResidentComplaintsTable($complaints) {

if (empty($complaints)) {
        echo '<tr><td colspan="3">No complaints submitted yet.</td></tr>';
        return;
    }
    
    foreach ($complaints as $complaint) {
        $duration_text = getDurationText($complaint['status_history'], $complaint['created_at']);
        
        echo '<tr>';
        echo '<td>' . htmlspecialchars($complaint['title']) . '</td>';
        echo '<td>' . htmlspecialchars($complaint['status']) . '</td>';
        echo '<td>' . $duration_text . '</td>';
        echo '</tr>';
    }
}

// Render committee complaints table
function renderCommitteeComplaintsTable($complaints) {

if (empty($complaints)) {
        echo '<tr><td colspan="5">No complaints submitted yet.</td></tr>';
        return;
    }
    
    foreach ($complaints as $complaint) {
        $duration_text = getDurationText($complaint['status_history'], $complaint['created_at']);

        echo '<tr>';
        echo '<td>' . htmlspecialchars($complaint['uploaded_by']) . '<br><small>' . htmlspecialchars($complaint['user_name']) . '</small></td>';
        echo '<td>' . htmlspecialchars($complaint['title']) . '</td>';
        echo '<td>' . htmlspecialchars($complaint['description']) . '</td>';
        echo '<td>';
        echo '<select class="status-select" data-complaint-id="' . $complaint['complaint_id'] . '">';
        echo '<option value="pending" ' . ($complaint['status'] === 'pending' ? 'selected' : '') . '>Pending</option>';
        echo '<option value="in-progress" ' . ($complaint['status'] === 'in-progress' ? 'selected' : '') . '>In Progress</option>';
        echo '<option value="resolved" ' . ($complaint['status'] === 'Resolved' ? 'selected' : '') . '>Resolved</option>';
        echo '</select>';
        echo '</td>';
        echo '<td>' . $duration_text . '</td>';
        echo '</tr>';
    }

}

// Helper function to generate duration text from status_history string
function getDurationText($status_history, $created_at) {

if (empty($status_history)) {
        return 'No history available';
    }
    $result = '';
    $entries = explode(',', $status_history);
    
    foreach ($entries as $entry) {
        if (strpos($entry, ':-') !== false) {
            $parts = explode(':-', $entry, 2);
            $status = trim($parts[0]);
            $timestamp = trim($parts[1]);
            $formatted_time = date('d M Y', strtotime($timestamp));
            $result .= '<div class="status-history-item">' . $status . ':- ' . $formatted_time . '</div>';
        } else {
            // For backward compatibility with old format
            $result .= '<div class="status-history-item">' . $entry . '</div>';
        }
    }
    return $result;
}

//###########---COMPLAINTS_END---##############

//########---MAINTENANCE_START---###########
// Get all residents for committee dropdown
function getAllResidents() {
    $conn = getDBConnection();
    $residents = [];
    
    $query = "SELECT user_id, name FROM users WHERE role = 'resident' ORDER BY name";
    $result = $conn->query($query);
    
    while ($row = $result->fetch_assoc()) {
        $residents[] = $row;
    }
    
    return $residents;
}
// AJAX endpoint to get all residents for committee dropdown
if (isset($_GET['action']) && $_GET['action'] === 'get_all_residents') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        echo '<option value="">Unauthorized access</option>';
        exit();
    }
    
    $residents = getAllResidents();
    foreach ($residents as $resident) {
        echo '<option value="' . $resident['user_id'] . '">' . $resident['name'] . ' (' . $resident['user_id'] . ')</option>';
    }
    exit();
}
// Get maintenance data for resident (for resident view)
function getResidentMaintenance($user_id) {
    $conn = getDBConnection();
    $maintenance = [];
    
    $current_year = date('Y');
    $stmt = $conn->prepare("SELECT * FROM maintenance WHERE resident_id = ? AND year = ? ORDER BY month");
    $stmt->bind_param("si", $user_id, $current_year);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $maintenance[] = $row;
    }
    
    return $maintenance;
}

// Get maintenance data for a specific resident (for committee)
function getMaintenanceForCommittee($user_id) {
    $conn = getDBConnection();
    $maintenance = [];
    
    $current_year = date('Y');
    $stmt = $conn->prepare("SELECT * FROM maintenance WHERE resident_id = ? AND year = ? ORDER BY month");
    $stmt->bind_param("si", $user_id, $current_year);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $maintenance[] = $row;
    }
    
    return $maintenance;
}
// Handle maintenance status update (add this function)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_maintenance_status') {
    updateMaintenanceStatus();
}
// Update maintenance status
// Add this function to handle individual maintenance updates
function updateMaintenanceStatus() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        echo "Unauthorized access";
        exit();
    }
    
    $resident_id = $_POST['resident_id'] ?? '';
    $year = $_POST['year'] ?? '';
    $month = $_POST['month'] ?? '';
    $type = $_POST['type'] ?? '';
    $status = $_POST['status'] ?? '';
    $updated_by = $_SESSION['user']['user_id'];
    
    if (empty($resident_id) || empty($year) || empty($month) || empty($type)) {
        echo "Invalid parameters";
        exit();
    }
    
    // Convert month name to number
    $month_names = ['APR' => 4, 'MAY' => 5, 'JUN' => 6, 'JUL' => 7, 'AUG' => 8, 
                   'SEPT' => 9, 'OCT' => 10, 'NOV' => 11, 'DEC' => 12, 
                   'JAN' => 1, 'FEB' => 2, 'MAR' => 3];
    $month_number = $month_names[$month] ?? 0;
    
    if ($month_number === 0) {
        echo "Invalid month";
        exit();
    }
    
    $conn = getDBConnection();
    
    // Check if record exists
    $check_stmt = $conn->prepare("SELECT record_id FROM maintenance WHERE resident_id = ? AND year = ? AND month = ? AND type = ?");
    $check_stmt->bind_param("siis", $resident_id, $year, $month_number, $type);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Update existing record
        $stmt = $conn->prepare("UPDATE maintenance SET status = ?, updated_by = ? WHERE resident_id = ? AND year = ? AND month = ? AND type = ?");
        $stmt->bind_param("sssiis", $status, $updated_by, $resident_id, $year, $month_number, $type);
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO maintenance (resident_id, year, month, type, status, updated_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siisss", $resident_id, $year, $month_number, $type, $status, $updated_by);
    }
    
    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Database error: " . $conn->error;
    }
    
    $conn->close();
    exit();
}
/*
function updateMaintenanceStatus() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        $_SESSION['error'] = 'Unauthorized access';
        header("Location: website.php?tab=committee-maintenance");
        exit();
    }
    
    $resident_id = $_POST['resident_id'] ?? '';
    $year = $_POST['year'] ?? '';
    $month = $_POST['month'] ?? '';
    $type = $_POST['type'] ?? '';
    $status = $_POST['status'] ?? '';
    $updated_by = $_SESSION['user']['user_id'];
    
    if (empty($resident_id) || empty($year) || empty($month) || empty($type)) {
        $_SESSION['error'] = 'Invalid parameters';
        header("Location: website.php?tab=committee-maintenance");
        exit();
    }
    
    // Convert month name to number
    $month_names = ['APR' => 4, 'MAY' => 5, 'JUN' => 6, 'JUL' => 7, 'AUG' => 8, 
                   'SEPT' => 9, 'OCT' => 10, 'NOV' => 11, 'DEC' => 12, 
                   'JAN' => 1, 'FEB' => 2, 'MAR' => 3];
    $month_number = $month_names[$month] ?? 0;
    
    if ($month_number === 0) {
        $_SESSION['error'] = 'Invalid month';
        header("Location: website.php?tab=committee-maintenance");
        exit();
    }
    
    $conn = getDBConnection();
    
    // Check if record exists
    $check_stmt = $conn->prepare("SELECT record_id FROM maintenance WHERE resident_id = ? AND year = ? AND month = ? AND type = ?");
    $check_stmt->bind_param("siis", $resident_id, $year, $month_number, $type);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Update existing record
        $stmt = $conn->prepare("UPDATE maintenance SET status = ?, updated_by = ? WHERE resident_id = ? AND year = ? AND month = ? AND type = ?");
        $stmt->bind_param("sssiis", $status, $updated_by, $resident_id, $year, $month_number, $type);
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO maintenance (resident_id, year, month, type, status, updated_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siisss", $resident_id, $year, $month_number, $type, $status, $updated_by);
    }
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Maintenance status updated successfully';
    } else {
        $_SESSION['error'] = 'Error updating maintenance status: ' . $conn->error;
    }
    
    header("Location: website.php?tab=committee-maintenance");
    exit();
}
    */

// Render resident maintenance table
function renderResidentMaintenanceTable($maintenance_data) {
    $months = ['APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEPT', 'OCT', 'NOV', 'DEC', 'JAN', 'FEB', 'MAR'];
    $month_numbers = [4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3];
    
    // Initialize arrays for maintenance and parking
    $maintenance_status = array_fill(0, 12, 'no');
    $parking_status = array_fill(0, 12, 'no');
    
    // Fill in the status from database
    foreach ($maintenance_data as $record) {
        $month_index = array_search($record['month'], $month_numbers);
        if ($month_index !== false) {
            if ($record['type'] === 'maintenance') {
                $maintenance_status[$month_index] = $record['status'];
            } elseif ($record['type'] === 'parking') {
                $parking_status[$month_index] = $record['status'];
            }
        }
    }
    
    // Convert status values to display format (symbols for residents)
    $display_status = array(
        'no' => '-',
        'paid' => '✓',
        'unpaid' => '✗'
    );
    
    // Maintenance row
    echo '<tr>';
    echo '<td>Maintenance</td>';
    foreach ($maintenance_status as $status) {
        $display_value = isset($display_status[$status]) ? $display_status[$status] : '-';
        echo '<td>' . htmlspecialchars($display_value) . '</td>';
    }
    echo '</tr>';
    
    // Parking row
    echo '<tr>';
    echo '<td>Parking Fees</td>';
    foreach ($parking_status as $status) {
        $display_value = isset($display_status[$status]) ? $display_status[$status] : '-';
        echo '<td>' . htmlspecialchars($display_value) . '</td>';
    }
    echo '</tr>';
}
/*
function renderResidentMaintenanceTable($maintenance_data) {
    $months = ['APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEPT', 'OCT', 'NOV', 'DEC', 'JAN', 'FEB', 'MAR'];
    $month_numbers = [4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3];
    
    // Initialize arrays for maintenance and parking
    $maintenance_status = array_fill(0, 12, 'no');
    $parking_status = array_fill(0, 12, 'no');
    
    // Fill in the status from database
    foreach ($maintenance_data as $record) {
        $month_index = array_search($record['month'], $month_numbers);
        if ($month_index !== false) {
            if ($record['type'] === 'maintenance') {
                $maintenance_status[$month_index] = $record['status'];
            } elseif ($record['type'] === 'parking') {
                $parking_status[$month_index] = $record['status'];
            }
        }
    }
    
    // Convert status values to display format (symbols for residents)
    $display_status = array(
        'no' => '-',
        'paid' => '✔',
        'unpaid' => '✘'
    );
    
    // Maintenance row
    echo '<tr>';
    echo '<td>Maintenance</td>';
    foreach ($maintenance_status as $status) {
        echo '<td>' . htmlspecialchars($display_status[$status] ?? '-') . '</td>';
    }
    echo '</tr>';
    
    // Parking row
    echo '<tr>';
    echo '<td>Parking Fees</td>';
    foreach ($parking_status as $status) {
        echo '<td>' . htmlspecialchars($display_status[$status] ?? '-') . '</td>';
    }
    echo '</tr>';
}
*/

// AJAX endpoint to get maintenance data for resident
if (isset($_GET['action']) && $_GET['action'] === 'get_resident_maintenance') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'resident') {
        echo '<tr><td colspan="13">Unauthorized access</td></tr>';
        exit();
    }
    
    $maintenance_data = getResidentMaintenance($_SESSION['user']['user_id']);
    renderResidentMaintenanceTable($maintenance_data);
    exit();
}
// Render committee maintenance table
function renderCommitteeMaintenanceTable($maintenance_data, $resident_id) {
    $current_year = date('Y');
    $months = ['APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEPT', 'OCT', 'NOV', 'DEC', 'JAN', 'FEB', 'MAR'];
    $month_numbers = [4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3];
    
    // Initialize arrays for maintenance and parking
    $maintenance_status = array_fill(0, 12, 'no');
    $parking_status = array_fill(0, 12, 'no');
    
    // Fill in the status from database
    foreach ($maintenance_data as $record) {
        $month_index = array_search($record['month'], $month_numbers);
        if ($month_index !== false) {
            if ($record['type'] === 'maintenance') {
                $maintenance_status[$month_index] = $record['status'];
            } elseif ($record['type'] === 'parking') {
                $parking_status[$month_index] = $record['status'];
            }
        }
    }
    
    // Maintenance row with dropdowns (text values for committee)
    echo '<tr>';
    echo '<td>Maintenance</td>';
    foreach ($months as $index => $month) {
        echo '<td>';
        echo '<select class="maintenance-select" data-resident-id="' . $resident_id . '" data-year="' . $current_year . '" data-month="' . $month . '" data-type="maintenance">';
        echo '<option value="no" ' . ($maintenance_status[$index] === 'no' ? 'selected' : '') . '>-</option>';
        echo '<option value="paid" ' . ($maintenance_status[$index] === 'paid' ? 'selected' : '') . '>Paid</option>';
        echo '<option value="unpaid" ' . ($maintenance_status[$index] === 'unpaid' ? 'selected' : '') . '>Unpaid</option>';
        echo '</select>';
        echo '</td>';
    }
    echo '</tr>';
    
    // Parking row with dropdowns (text values for committee)
    echo '<tr>';
    echo '<td>Parking Fees</td>';
    foreach ($months as $index => $month) {
        echo '<td>';
        echo '<select class="maintenance-select" data-resident-id="' . $resident_id . '" data-year="' . $current_year . '" data-month="' . $month . '" data-type="parking">';
        echo '<option value="no" ' . ($parking_status[$index] === 'no' ? 'selected' : '') . '>-</option>';
        echo '<option value="paid" ' . ($parking_status[$index] === 'paid' ? 'selected' : '') . '>Paid</option>';
        echo '<option value="unpaid" ' . ($parking_status[$index] === 'unpaid' ? 'selected' : '') . '>Unpaid</option>';
        echo '</select>';
        echo '</td>';
    }
    echo '</tr>';
}

// AJAX endpoint to get maintenance data for committee
if (isset($_GET['action']) && $_GET['action'] === 'get_resident_maintenance_for_committee') {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'committee') {
        echo '<tr><td colspan="13">Unauthorized access</td></tr>';
        exit();
    }
    
    $user_id = $_GET['user_id'] ?? '';
    if (empty($user_id)) {
        echo '<tr><td colspan="13">Invalid resident ID</td></tr>';
        exit();
    }
    
    $maintenance_data = getMaintenanceForCommittee($user_id);
    renderCommitteeMaintenanceTable($maintenance_data, $user_id);
    exit();
}

//#########---MAINTENANCE_END---##############

//#########
// Handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: website.php");
    exit();
}
?>