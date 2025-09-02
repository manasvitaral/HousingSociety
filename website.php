<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" href="Titlelogo.png" type="image/png">
<title>SocietySphere</title>
<style>
  /* Reset and base */
  body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #FFF0F5; /* Lavender Blush */
    color: #6A0DAD; /* Royal Purple */ 
  }
  .header-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-top: 40px;
  }

  .logo {
    height: 50px;
    width: auto;
  }

  h1 {
    font-weight: 700;
    color: #6A0DAD; /* Royal Purple */
    text-transform: uppercase;
    letter-spacing: 2px;
    margin: 0;
  }
  /* Tab container */
  .tab-container {
    max-width: 600px;
    margin: 30px auto 50px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(106, 13, 173, 0.1); /* Royal Purple shadow */
    overflow: hidden;
  }
  /* Tab buttons */
  .tab-buttons {
    display: flex;
    background: #6A0DAD; /* Royal Purple */
    flex-wrap: wrap;
  }
  .tab-buttons button {
    flex: 1;
    padding: 15px 10px;
    border: none;
    background: #6A0DAD; /* Royal Purple */
    color: #B57EDC; /* Lavender */
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.3s ease;
    min-width: 120px;
    margin: 2px;
    border-radius:6px;
  }
   
  .tab-buttons button img.tab-logo {
    height: 25px;
    width: auto;
    margin-right: 8px;
    vertical-align: middle;
  }
  .tab-buttons button:hover {
    background: #800080; /* Purple */
  }
  .tab-buttons button.active {
    background: #B57EDC; /* Lavender */
    color: white;
    font-weight: 700;
  }
  /* Tab content */
  .tab {
    display: none;
    padding: 30px 25px 40px;
    position: relative;
  }
  .tab.active {
    display: block;
  }
  /* Forms */
  form {
    display: flex;
    flex-direction: column;
    gap: 18px;
  }
  label {
    font-weight: 600;
    margin-bottom: 6px;
    color: #800080; /* Purple */
  }
  input[type="text"],
  input[type="password"],
  input[type="email"],
  select, textarea {
    padding: 10px 12px;
    font-size: 1rem;
    border: 1.8px solid #B57EDC; /* Lavender */
    border-radius: 6px;
    transition: border-color 0.3s ease;
  }
  input[type="text"]:focus,
  input[type="password"]:focus,
  select:focus, textarea:focus {
    outline: none;
    border-color: #800080; /* Purple */
    box-shadow: 0 0 6px rgba(128, 0, 128, 0.3); /* Purple shadow */
  }
  button.submit-btn {
    background: #800080; /* Purple */
    border: none;
    color: white;
    font-weight: 700;
    padding: 12px 0;
    font-size: 1.1rem;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
  }
  button.submit-btn:hover {
    background: #B57EDC; /* Lavender */
  }
  /* Centered text for welcome tab */
  .welcome-msg {
    text-align: center;
    font-size: 1.1rem;
    color: #6A0DAD; /* Royal Purple */
    margin-top: 40px;
  }
  /* Error message styling */
  .error-msg {
    color: #e74c3c;
    font-weight: 600;
    font-size: 0.9rem;
  }
  /* Create account link style */
  .create-account-link {
    text-align: center;
    margin-top: 20px;
  }
  .create-account-link a {
    cursor: pointer;
    color: #800080; /* Purple */
    font-weight: 600;
    text-decoration: underline;
  }
  /* Logout button style */
  .logout-btn {
    position: absolute;
    right: 15px;
    top: 15px;
    background: #6A0DAD; /* Royal Purple */
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
    z-index: 100;
  }
  .logout-btn:hover {
    background: #800080; /* Purple */ 
  }
  /* Tables */
  .table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }

  .table-responsive table {
    min-width: 600px;
    width: 100%;
    margin-bottom: 0;
    border: 3px ridge #B57EDC; /* Lavender */
    border-collapse: collapse;
  }

  .table-responsive table th,
  .table-responsive table td {
    border: 2px solid #B57EDC;  /* Lavender */
    padding: 8px;
    text-align: left;
  }

  .table-responsive table th {
    background-color: #E6E6FA;   /* Light Lavender */
  }
  /* Maintenance Table */
  #maintenance-table, #complaints-table, #committee-complaints-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    table-layout: fixed;
  }
  #maintenance-table th, #maintenance-table td,
  #complaints-table th, #complaints-table td,
  #committee-complaints-table th, #committee-complaints-table td {
    border: 1px solid #B57EDC; /* Lavender */
    padding: 8px 4px;
    text-align: center;
    white-space: normal;
    overflow-wrap: break-word;
    font-size: 0.9rem;
  }
  #maintenance-table th, #complaints-table th,
  #committee-complaints-table th {
    background: #E6E6FA; /* Light Lavender */
    font-weight: 700;
    color: #6A0DAD; /* Royal Purple */
  }
  .resident-id-display {
    font-weight: bold;
    margin-bottom: 10px;
    font-size: 1.1rem;
    color: #6A0DAD; /* Royal Purple */
  }
  /* Content display styles */
  .content-list {
    list-style-type: none;
    padding: 0;
  }
  
  /* Notice specific styles */
  .content-item {
    background: #F5F0FA; /* Very Pale Purple */
    border-left: 4px solid #B57EDC; /* Lavender */
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 4px;
  }

  .view-btn {
    display: inline-block;
    background: #800080; /* Purple */
    color: white;
    padding: 6px 12px;
    border-radius: 4px;
    text-decoration: none;
    margin-top: 10px;
  }
  .view-btn:hover {
    background: #B57EDC; /* Lavender */
  }

  .delete-btn {
    background-color: #6A0DAD; /* Royal Purple */
    color: white;
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 10px;
    display: none;
  }
  .delete-btn:hover {
    background: #9a0007; /* Dark Red (unchanged) */ 
  }

  .committee-user .delete-btn {
    display: inline-block;
  }

  .actions {
    display: flex;
    gap: 10px;
  }
  .success-msg {
    color: #2ecc71;
    font-weight: 600;
    margin: 10px 0;
  }
  
  .content-item h4 {
    margin-top: 0;
    color: #6A0DAD; /* Royal Purple */
  }
  .content-item p {
    margin-bottom: 0;
    color: #800080; /* Purple */
    font-weight: normal;
  }
  /* Gallery Styling */
  .gallery-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
  }

  .photo-card {
    border: 1px solid #B57EDC; /* Lavender */
    border-radius: 5px;
    overflow: hidden;
    position: relative;
    background: white;
  }

  .photo-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .photo-title {
    padding: 10px;
    background-color: #E6E6FA; /* Pale Purple */
    font-weight: 500;
    color: #6A0DAD; /* Royal Purple */
  }

  /* Responsive */
  @media (max-width: 320px) {
    .tab-buttons button {
      min-width: 100%;
      margin: 4px 0;
      padding: 10px;

    }
    .table-responsive table th, 
    .table-responsive table td {
      padding: 6px 4px;
      font-size: 0.85rem;
    }
    
    .view-btn, .delete-btn {
      padding: 4px 8px;
      font-size: 0.8rem;
    }
  }
 @media (max-width: 500px){
   .tab-buttons button span.tab-label {
      display: none;
    }
    .tab-logo {
      margin-right: 0 !important;
    }
  }
</style>
</head>
<body>

<div class="header-container">
    <img src="Titlelogo.png" alt="Society Sphere Logo" class="logo">
    <h1>Society Sphere</h1>
</div>

<div class="tab-container">
  <div id="tab-buttons" class="tab-buttons">
    <button id="tab-login-btn" type="button" onclick="showTab('login')">LOGIN</button>
  </div>
  <div id="login" class="tab">
    <h3 style="text-align:center; color:#34495e;">Login</h3>
    <form id="login-form" action="code.php" method="POST">
      <input type="hidden" name="action" value="login">
        <label for="login-userid">User ID</label>
        <input type="text" id="login-userid" name="user_id" required autocomplete="username" placeholder="Enter your UserId"/>

        <label for="login-password">Password</label>
        <input type="password" id="login-password" name="password" required autocomplete="current-password" placeholder="Enter your password"/>

        <label for="login-role">Role</label>
        <select id="login-role" name="role" required>
            <option value="" disabled selected>Select role</option>
            <option value="committee">Committee</option>
            <option value="resident">Resident</option>
        </select>

        <div id="login-error" class="error-msg">
          <?php if (isset($_GET['tab']) && $_GET['tab'] === 'login' && isset($_GET['error'])): ?>
            <?php echo htmlspecialchars($_GET['error']); ?>
          <?php endif; ?>
        </div>

        <button type="submit" class="submit-btn">Login</button>
    </form>
    <div class="create-account-link">
        <a onclick="showCreateAccountForm()">Create Account</a>
    </div>
  </div>
<div id="create-account" class="tab">
    <h3 style="text-align:center; color:#34495e;">Create Account</h3>
    <form id="signin-form" action="code.php" method="POST">
      <input type="hidden" name="action" value="signup">

        <label for="signin-name">Full Name</label>
        <input type="text" id="signin-name" name="name" required autocomplete="name" placeholder="Enter your full name">
        
        <label for="signin-email">Email Address</label>
        <input type="email" id="signin-email" name="email" required autocomplete="email" placeholder="Enter your email address">

        <label for="signin-building">Building Number</label>
        <input type="text" id="signin-building" name="building" required pattern="[A-Z]-[0-9]{1,3}" placeholder="Format: Letter-Number (e.g., C-00)">
        
        <label for="signin-room">Room Number</label>
        <input type="text" id="signin-room" name="room" required pattern="[0-9]{1,2}/[0-9]{1,3}" placeholder="Format: Floor/Room (e.g., 0/00)">

        <label for="signin-password">Password</label>
        <input type="password" id="signin-password" name="password" required autocomplete="new-password" placeholder="Create a strong password">

        <label for="signin-role">Role</label>
        <select id="signin-role" name="role" required>
            <option value="" disabled selected>Select role</option>
            <option value="committee">Committee</option>
            <option value="resident">Resident</option>
        </select>

        <div id="signin-error" class="error-msg">
          <?php if (isset($_GET['tab']) && $_GET['tab'] === 'create-account' && isset($_GET['error'])): ?>
            <?php echo htmlspecialchars($_GET['error']); ?>
          <?php endif; ?>
        </div>
        <button type="submit" class="submit-btn">Create Account</button>
    </form>
</div>

  <!-- Resident tabs  
  ############# -->
  <div id="notices" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Society Notices</h3>
    <div class="notices-container" id="notices-container">
        //--- Notices will be loaded using javascript 
        <div id="notice-error-message" class="error-msg" style="display: none";>
        </div>
    </div>
</div>

  <div id="gallery" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Gallery</h3>
    <div class="gallery-container" id="gallery-container">
      // Photos will be loaded here dynamically
    </div>
  </div>

  <div id="complaints" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Submit Complaint</h3>
    <form id="complaint-form" onsubmit="submitComplaint(event)">
      <label for="complaint-title">Title</label>
      <input type="text" id="complaint-title" name="title" required />
      
      <label for="complaint-description">Description</label>
      <textarea id="complaint-description" name="description" rows="4" required></textarea>
      
      <button type="submit" class="submit-btn">Submit Complaint</button>
    </form>
    <div id="complaint-message" class="error-msg" aria-live="polite"></div>
    
    <h4>All Complaints</h4>
    <table id="complaints-table" aria-label="All Complaints">
      <thead>
        <tr>
          <th>Complaint ID</th>
          <th>Complaint</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="complaints-table-body">
        <!-- rows generated by JS -->
      </tbody>
    </table>
  </div>
  <div id="committee-notices" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Upload Notice</h3>
    <form action="code.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload_notice">
        <label for="notice-title">Notice Title</label>
        <input type="text" id="notice-title" name="title" required>
        
        <label for="notice-file">PDF File (max 5MB)</label>
        <input type="file" id="notice-file" name="notice-file" accept=".pdf" required>
        
        <button type="submit" class="submit-btn">Upload Notice</button>
    </form>
    
    <h4>Current Notices</h4>
    <div class="notices-container" id="committee-notices-container">
        <!-- Notices loaded dynamically by JavaScript -->
        <div id="notice-error-message" class="error-msg" style="display: none;">
        </div>
    </div>
</div>

  <div id="committee-gallery" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Upload Photo</h3>
    <form id="upload-photo-form" onsubmit="uploadPhoto(event)">
      <label for="photo-title">Title</label>
      <input type="text" id="photo-title" name="title" required />
    
      <label for="photo">Photo (PNG)</label>
      <input type="file" id="photo" name="photo" accept=".png" required />
    
      <button type="submit" class="submit-btn">Upload Photo</button>
    </form>
    <div id="photo-message" class="error-msg" aria-live="polite"></div>
    
    <h4>Current Photos</h4>
    <div class="gallery-container" id="committee-gallery-container">
      <!-- Photos will be loaded here dynamically -->
    </div>
  </div>

  <div id="committee-complaints" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Complaints Management</h3>
    <table id="committee-complaints-table" aria-label="Complaints Management">
      <thead>
        <tr>
          <th>Complaint ID</th>
          <th>Complaint</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="committee-complants-table-body">
        <!-- rows generated by JS -->
      </tbody>
    </table>
    <button type="button" class="submit-btn" style="margin-top: 15px;" onclick="saveComplaintStatuses()">Save Complaint Statuses</button>
    <div id="status-message" class="error-msg" aria-live="polite"></div>
  </div>

  <!-- Maintenance Tab -->
  <div id="maintenance" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Maintenance Status</h3>
    <div id="resident-id-display" class="resident-id-display"></div>
    <div id="resident-selector" style="margin-bottom:10px;"></div>
    <table id="maintenance-table" aria-label="Maintenance and Parking Fees Status">
      <thead>
        <tr>
          <th>Type</th>
          <th>APR</th>
          <th>MAY</th>
          <th>JUN</th>
          <th>JUL</th>
          <th>AUG</th>
          <th>SEPT</th>
          <th>OCT</th>
          <th>NOV</th>
          <th>DEC</th>
          <th>JAN</th>
          <th>FEB</th>
          <th>MAR</th> 
        </tr>
      </thead>
      <tbody id="maintenance-table-body">
        <!-- rows generated by JS -->
      </tbody>
    </table>
    <div id="maintenance-message" class="error-msg" aria-live="polite"></div>
  </div>

</div>
<script>
  // Shows a tab by id, hides others and highlights appropriate button
  function showTab(tabId) {
    // Hide all tabs
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    
    // Show selected tab
    const tab = document.getElementById(tabId);
    if (tab) {
        tab.classList.add('active');
    }
    
    // Update button active status
    document.querySelectorAll('.tab-buttons button').forEach(btn => {
        btn.classList.remove('active');
        if (btn.id === `tab-${tabId}-btn`) {
            btn.classList.add('active');
        }
    });
    
    // Add committee class to body if user is committee
    if (currentUser && currentUser.role === 'committee') {
        document.body.classList.add('committee-user');
    } else {
        document.body.classList.remove('committee-user');
    }
    
    // Additional logic for loading content based on the tab
    if (currentUser) {
        if (tabId === 'maintenance') {
            if (currentUser.role === 'resident') {
                renderResidentIdDisplay(currentUser.user_id);
                renderMaintenanceForResident(currentUser.user_id);
                clearResidentSelector();
            } else if (currentUser.role === 'committee') {
                clearResidentIdDisplay();
                renderResidentSelector();
                // Default to first resident if exists
                const residents = Object.keys(maintenanceData);
                if (residents.length > 0) {
                    document.getElementById('resident-select').value = residents[0];
                    renderMaintenanceForCommittee(residents[0]);
                }
            }
        } else if (tabId === 'notices' && currentUser.role === 'resident') {
            loadNoticesForResident();
        } else if (tabId === 'gallery' && currentUser.role === 'resident') {
            renderGalleryForResident();
        } else if (tabId === 'complaints' && currentUser.role === 'resident') {
            renderResidentComplaints();
        } else if (tabId === 'committee-notices' && currentUser.role === 'committee') {
            loadNoticesForCommittee();
        } else if (tabId === 'committee-gallery' && currentUser.role === 'committee') {
            renderCommitteeGallery();
        } else if (tabId === 'committee-complaints' && currentUser.role === 'committee') {
            renderCommitteeComplaints();
        }
    }
}
  // Remove the onsubmit handlers from your forms and let them submit normally
// Just keep the form validation
// At the start of your script, check for URL parameters
document.addEventListener('DOMContentLoaded', function() {
    showTab('login');

    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const success = urlParams.get('success');
    const tab = urlParams.get('tab');
    
    if (tab === 'login') {
        //document.getElementById('login-error').textContent = error;
        showTab('login');
    } else if (tab === 'create-account') {
        // document.getElementById('signin-error').textContent = error;
        showTab('create-account');
    }
    
    if (success) {
        alert(success);
    }
    
    // Check PHP session for logged in user
    <?php if (isset($_SESSION['user'])): ?>
        currentUser = {
            user_id: '<?php echo $_SESSION['user']['user_id']; ?>',
            name: '<?php echo $_SESSION['user']['name']; ?>',
            role: '<?php echo $_SESSION['user']['role']; ?>'
        };
        renderTabButtons(currentUser.role);
        // Show appropriate default tab based on role
      if (currentUser.role === 'resident') {
        showTab('notices');
      } else if (currentUser.role === 'committee') {
        document.body.classList.add('committee-user');
        showTab('committee-notices');
      }
    <?php else: ?>
      renderTabButtons('guest');
    <?php endif; ?>
});
    
// Email validation
const emailField = document.getElementById('signin-email');
const emailError = document.getElementById('email-error');
//const emailPattern = /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(?:2(?:5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(?:2(?:5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/i;

const emailPattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

        
emailField.addEventListener('blur', function() {
const email = emailField.value;
//const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
if (email && !emailPattern.test(email)) {
    emailError.style.display = 'block';
    emailField.style.borderColor = '#e74c3c';
    } else {
        emailError.style.display = 'none';
        emailField.style.borderColor = '#ddd';
    }
});
        
// Form validation before submission
document.getElementById('signin-form').addEventListener('submit', function(event) {
    const email = emailField.value;
    //const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
    if (!emailPattern.test(email)) {
        event.preventDefault();
        emailError.style.display = 'block';
        emailField.style.borderColor = '#e74c3c';
        emailField.focus();
        }
});

// Add validation for building and room format
document.getElementById('signin-building').addEventListener('blur', function() {
    const building = this.value;
    const pattern = /^[A-Z]-[0-9]{2}$/;
    
    if (building && !pattern.test(building)) {
        this.style.borderColor = '#e74c3c';
        alert('Building format should be Letter-Number (e.g., C-49)');
    } else {
        this.style.borderColor = '#ddd';
    }
});

document.getElementById('signin-room').addEventListener('blur', function() {
    const room = this.value;
    const pattern = /^[0-9]{1,2}\/[0-9]{2}$/;
    
    if (room && !pattern.test(room)) {
        this.style.borderColor = '#e74c3c';
        alert('Room format should be Floor/Room (e.g., 2/10)');
    } else {
        this.style.borderColor = '#ddd';
    }
});

// Update form validation to include building and room
document.getElementById('signin-form').addEventListener('submit', function(event) {
    const building = document.getElementById('signin-building').value;
    const room = document.getElementById('signin-room').value;
    const buildingPattern = /^[A-Z]-[0-9]{2}$/;
    const roomPattern = /^[0-9]{1,2}\/[0-9]{2}$/;
    
    if (!buildingPattern.test(building)) {
        event.preventDefault();
        alert('Please enter a valid building number (e.g., C-49)');
        document.getElementById('signin-building').focus();
        return;
    }
    
    if (!roomPattern.test(room)) {
        event.preventDefault();
        alert('Please enter a valid room number (e.g., 2/10)');
        document.getElementById('signin-room').focus();
        return;
    }
});

// Modify your logout function
function logout() {
    window.location.href = 'code.php?action=logout';
}
  
  let currentUser = null;

  // Tab definitions for roles
  const tabsForResident = [
    { id: 'notices', label: 'Notices' },
    { id: 'gallery', label: 'Gallery' },
    { id: 'complaints', label: 'Complaints' },
    { id: 'maintenance', label: 'Maintenance' }
  ];

  const tabsForCommittee = [
    { id: 'committee-notices', label: 'Notices' },
    { id: 'committee-gallery', label: 'Gallery' },
    { id: 'committee-complaints', label: 'Complaints' },
    { id: 'maintenance', label: 'Maintenance' }
  ];

  // Sample maintenance data for multiple residents
  let maintenanceData = {
    resident1: {
      maintenance: ['-','-','-','-','-','-','-','-','-','-','-','-'],
      parking: ['-','-','-','-','-','-','-','-','-','-','-','-']
    },
    resident2: {
      maintenance: ['-','-','-','-','-','-','-','-','-','-','-','-'],
      parking: ['-','-','-','-','-','-','-','-','-','-','-','-']
    }
  };

  // Data storage for notices, gallery and complaints
  let notices = [];
  let galleryPhotos = [];
  let complaints = [];

  // Renders tab buttons as per current role or guest (home, login)
  function renderTabButtons(role = 'guest') {
    const tabButtonsDiv = document.querySelector('.tab-buttons');
    tabButtonsDiv.innerHTML = ''; // Clear buttons

    if (role === 'guest') {
      // Guest tabs: home and login
      createTabButton('login', 'LOGIN');
      showTab('login');
    } else if (role === 'resident') {
      tabsForResident.forEach(tab => createTabButton(tab.id, tab.label));
      showTab(tabsForResident[0].id);
    } else if (role === 'committee') {
      tabsForCommittee.forEach(tab => createTabButton(tab.id, tab.label));
      showTab(tabsForCommittee[0].id);
    }
  }

  // Helper to create a tab button
  function createTabButton(tabId, label) {
    const tabButtonsDiv = document.querySelector('.tab-buttons');
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.id = `tab-${tabId}-btn`;
    // Add logo
    const logo = document.createElement('img');
    logo.className = 'tab-logo';
    // Add Label Span
    const labelSpan = document.createElement('span');
    labelSpan.className = 'tab-label';
    labelSpan.textContent = ' ' + label;

    // Add logo for Notices tab
  if (label === 'Notices' || tabId === 'committee-notices') {
    logo.src = 'NoticeLogo.png'; // Use the same logo as your header
    logo.alt = 'Notices Tab Logo';
  }
  else if (label === 'Gallery' || tabId === 'committee-gallery') {
    logo.src = 'GalleryLogo.png'; // Use the same logo as your header
    logo.alt = 'Gallery Tab Logo';
  }
  else if (label === 'Complaints' || tabId === 'committee-complaints') {
    logo.src = 'ComplaintLogo.png'; // Use the same logo as your header
    logo.alt = 'Complaints Tab Logo';
  }
  else if (label === 'Maintenance') {
    logo.src = 'MaintenanceLogo.png'; // Use the same logo as your header
    logo.alt = 'Maintenance Tab Logo';
  }
    //btn.textContent = label;
    btn.appendChild(logo);
    btn.appendChild(labelSpan);
    btn.onclick = () => showTab(tabId);
    tabButtonsDiv.appendChild(btn);
  }

// Render notices
function renderNotices(notices, isCommittee = false) {
    const container = document.getElementById(isCommittee ? 'committee-notices-container' : 'notices-container');
    
    if (!notices || notices.length === 0) {
        container.innerHTML = '<p>No notices found.</p>';
        return;
    }
    
    let html = `
    <div class="table-responsive">
        <table class="notice-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>File Name</th>
                    <th>Size</th>
                    <th>Uploaded By</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    `;
    
    notices.forEach(notice => {
        // Format file size
        let fileSize = notice.file_size;
        let sizeText = '';
        if (fileSize >= 1048576) {
            sizeText = (fileSize / 1048576).toFixed(2) + ' MB';
        } else if (fileSize >= 1024) {
            sizeText = (fileSize / 1024).toFixed(2) + ' KB';
        } else {
            sizeText = fileSize + ' bytes';
        }
        
        // Format date
        const date = new Date(notice.created_at);
        const formattedDate = date.toLocaleDateString('en-US', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        html += `
            <tr>
                
                <td>${notice.title}</td>
                <td>${notice.file_name}</td>
                <td>${sizeText}</td>
                <td>${notice.uploaded_by_name}</td>
                <td>${formattedDate}</td>
                <td class="actions">
                    <a href="code.php?action=view_notice&id=${notice.notice_id}" target="_blank" class="view-btn">View</a>
                    ${isCommittee ? `<button onclick="deleteNotice(${notice.notice_id})" class="delete-btn">Delete</button>` : ''}
                </td>
            </tr>
        `;
    });
    
    html += `
            </tbody>
        </table>
     </div>
    `;
    
    container.innerHTML = html;
 }
// Update the loadNoticesForResident and loadNoticesForCommittee functions:
async function loadNoticesForResident() {
    const container = document.getElementById('notices-container');
    container.innerHTML = '<p>Loading notices...</p>';
    
    //const notices = await fetchNotices();
    //renderNotices(notices, false);
    // Fetch pre-rendered HTML from server
    //const response = await fetch('code.php?action=get_notices');
    //container.innerHTML = await response.text();
    try {
        const response = await fetch('code.php?action=get_notices');
        container.innerHTML = await response.text();
    } catch (error) {
        container.innerHTML = '<p class="error-msg">Error loading notices</p>';
    }
}

async function loadNoticesForCommittee() {
    const container = document.getElementById('committee-notices-container');
    container.innerHTML = '<p>Loading notices...</p>';
    
    //const notices = await fetchNotices();
    //renderNotices(notices, true);
    // Fetch pre-rendered HTML from server
    //const response = await fetch('code.php?action=get_notices');
    //container.innerHTML = await response.text();
    try {
        const response = await fetch('code.php?action=get_notices');
        container.innerHTML = await response.text();
    } catch (error) {
        container.innerHTML = '<p class="error-msg">Error loading notices</p>';
    }
}

// Delete notice function
function deleteNotice(noticeId) {
    if (confirm('Are you sure you want to delete this notice?')) {
        window.location.href = 'code.php?action=delete_notice&id=' + noticeId;
    }
}
  // Render resident's gallery
  function renderGalleryForResident() {
  const container = document.getElementById('gallery-container');
  container.innerHTML = '';
  
  if (galleryPhotos.length === 0) {
    container.innerHTML = '<p>No photos available in gallery.</p>';
    return;
  }
  
  galleryPhotos.forEach((photo, index) => {
    const photoCard = document.createElement('div');
    photoCard.className = 'photo-card';
    photoCard.innerHTML = `
      <img src="${photo.imageUrl}" alt="${photo.title}">
      <div class="photo-title">${photo.title}</div>
    `;
    container.appendChild(photoCard);
  });
}

  // Render resident's complaints
  function renderResidentComplaints() {
    const tbody = document.getElementById('complaints-table-body');
    tbody.innerHTML = '';
    
    if (complaints.length === 0) {
      tbody.innerHTML = '<tr><td colspan="3">No complaints submitted yet.</td></tr>';
      return;
    }
    
    complaints.forEach(complaint => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${complaint.userId}</td>
        <td>${complaint.title}</td>
        <td>${complaint.status}</td>
      `;
      tbody.appendChild(tr);
    });
  }
  // Render committee's view of gallery
  function renderCommitteeGallery() {
  const container = document.getElementById('committee-gallery-container');
  container.innerHTML = '';
  
  if (galleryPhotos.length === 0) {
    container.innerHTML = '<p>No photos uploaded yet.</p>';
    return;
  }
  
  galleryPhotos.forEach((photo, index) => {
    const photoCard = document.createElement('div');
    photoCard.className = 'photo-card';
    photoCard.innerHTML = `
      <img src="${photo.imageUrl}" alt="${photo.title}">
      <div class="photo-title">${photo.title}</div>
      <button class="delete-btn" onclick="deletePhoto(${index})">X</button>
    `;
    container.appendChild(photoCard);
  });
}

  // Render committee's view of complaints
  function renderCommitteeComplaints() {
    const tbody = document.getElementById('committee-complaints-table-body');
    tbody.innerHTML = '';
    
    if (complaints.length === 0) {
      tbody.innerHTML = '<tr><td colspan="3">No complaints submitted yet.</td></tr>';
      return;
    }
    
    complaints.forEach((complaint, index) => {
      const tr = document.createElement('tr');
      
      // Create status select dropdown
      const statusSelect = document.createElement('select');
      statusSelect.style.minWidth = '100px';
      ['pending', 'in-progress', 'resolved'].forEach(status => {
        const option = document.createElement('option');
        option.value = status;
        option.textContent = status;
        if (status === complaint.status) option.selected = true;
        statusSelect.appendChild(option);
      });
      
      statusSelect.onchange = () => {
        complaints[index].status = statusSelect.value;
      };
      
      tr.innerHTML = `
        <td>${complaint.userId}</td>
        <td>${complaint.title}</td>
      `;
      
      const statusCell = document.createElement('td');
      statusCell.appendChild(statusSelect);
      tr.appendChild(statusCell);
      
      tbody.appendChild(tr);
    });
  }

  // Save complaint statuses
  function saveComplaintStatuses() {
    alert('Complaint statuses saved successfully.');
    // Here you can add backend connection to persist changes
    renderCommitteeComplaints();
  }

  // Display resident ID above the table for residents
  function renderResidentIdDisplay(userId) {
    const displayDiv = document.getElementById('resident-id-display');
    displayDiv.textContent = `Resident ID: ${userId}`;
  }

  // Clear resident ID display (for committee)
  function clearResidentIdDisplay() {
    const displayDiv = document.getElementById('resident-id-display');
    displayDiv.textContent = '';
  }

  // Render resident selector for committee
  function renderResidentSelector() {
    const selectorDiv = document.getElementById('resident-selector');
    selectorDiv.innerHTML = '';
    
    const label = document.createElement('label');
    label.textContent = 'Select Resident:';
    label.htmlFor = 'resident-select';
    selectorDiv.appendChild(label);
    
    const select = document.createElement('select');
    select.id = 'resident-select';
    select.style.marginLeft = '10px';
    select.style.padding = '5px';
    
    const residents = Object.keys(maintenanceData);
    residents.forEach(residentId => {
      const option = document.createElement('option');
      option.value = residentId;
      option.textContent = residentId;
      select.appendChild(option);
    });
    
    select.onchange = () => {
      renderMaintenanceForCommittee(select.value);
    };
    
    selectorDiv.appendChild(select);
    
    const saveBtn = document.createElement('button');
    saveBtn.type = 'button';
    saveBtn.textContent = 'Save Changes';
    saveBtn.className = 'submit-btn';
    saveBtn.style.marginLeft = '15px';
    saveBtn.style.padding = '5px 10px';
    saveBtn.onclick = () => {
      alert('Maintenance statuses saved successfully.');
      // Here you can add backend connection to persist changes
    };
    selectorDiv.appendChild(saveBtn);
  }

  // Clear resident selector (for residents)
  function clearResidentSelector() {
    const selectorDiv = document.getElementById('resident-selector');
    selectorDiv.innerHTML = '';
  }

 function showCreateAccountForm() {
    renderTabButtons('guest');
    showTab('create-account');
  }

  // Complaint submission
  function submitComplaint(event) {
    event.preventDefault();
    const messageElem = document.getElementById('complaint-message');
    messageElem.textContent = '';
    
    const title = document.getElementById('complaint-title').value.trim();
    const description = document.getElementById('complaint-description').value.trim();

    if (!title || !description) {
      messageElem.textContent = 'Please fill all fields.';
      return;
    }
    
    // Add new complaint
    complaints.push({
      userId: currentUser.user_id,
      title: title,
      description: description,
      status: 'pending',
      date: new Date().toLocaleDateString() + ' ' + new Date().toLocaleTimeString()
    });
    
    alert(`Complaint "${title}" has been submitted.`);
    document.getElementById('complaint-form').reset();
    renderResidentComplaints();
  }
  // Photo upload
  function uploadPhoto(event) {
  event.preventDefault();
  const messageElem = document.getElementById('photo-message');
  messageElem.textContent = '';
  
  const title = document.getElementById('photo-title').value.trim();
  const fileInput = document.getElementById('photo');

  if (!title || fileInput.files.length === 0) {
    messageElem.textContent = 'Please fill all fields and select a photo.';
    return;
  }
  
  const file = fileInput.files[0];
  const reader = new FileReader();
  
  reader.onload = (e) => {
    const now = new Date();
    galleryPhotos.unshift({
      title: title,
      imageUrl: e.target.result,
      date: now.toLocaleDateString() + ' ' + now.toLocaleTimeString()
    });
    
    alert(`Photo "${title}" has been uploaded.`);
    document.getElementById('upload-photo-form').reset();
    renderCommitteeGallery();
    renderGalleryForResident();
  };
  
  reader.readAsDataURL(file);
}

  // Delete photo
  function deletePhoto(index) {
    if (confirm('Are you sure you want to delete this photo?')) {
      galleryPhotos.splice(index, 1);
      renderCommitteeGallery();
    }
  }
  function showError(message) {
    const errorDiv = document.getElementById('notice-error-message');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
    setTimeout(() => errorDiv.style.display = 'none', 5000);
  }
  
  // Render maintenance for resident (shows only their own data)
  function renderMaintenanceForResident(userId) {
    const tbody = document.getElementById('maintenance-table-body');
    tbody.innerHTML = '';
    const data = maintenanceData[userId];
    if (!data) {
      tbody.innerHTML = '<tr><td colspan="13">No maintenance data found.</td></tr>';
      return;
    }
    
    // Maintenance row
    const trMaintenance = document.createElement('tr');
    const tdMaintenanceLabel = document.createElement('td');
    tdMaintenanceLabel.textContent = 'Maintenance';
    trMaintenance.appendChild(tdMaintenanceLabel);
    
    // Maintenance months cells
    for(let i = 0; i < 12; i++) {
      const tdMonth = document.createElement('td');
      tdMonth.textContent = data.maintenance[i];
      trMaintenance.appendChild(tdMonth);
    }
    tbody.appendChild(trMaintenance);
    
    // Parking row
    const trParking = document.createElement('tr');
    const tdParkingLabel = document.createElement('td');
    tdParkingLabel.textContent = 'Parking Fees';
    trParking.appendChild(tdParkingLabel);
    
    // Parking months cells
    for(let i = 0; i < 12; i++) {
      const tdMonth = document.createElement('td');
      tdMonth.textContent = data.parking[i];
      trParking.appendChild(tdMonth);
    }
    tbody.appendChild(trParking);
  }

  // Render maintenance for committee (shows selected resident's data with editing capability)
  function renderMaintenanceForCommittee(userId) {
    const tbody = document.getElementById('maintenance-table-body');
    tbody.innerHTML = '';
    const data = maintenanceData[userId];
    if (!data) {
      tbody.innerHTML = '<tr><td colspan="13">No maintenance data found.</td></tr>';
      return;
    }
    
    // Maintenance row with dropdown selectors
    const trMaintenance = document.createElement('tr');
    const tdMaintenanceLabel = document.createElement('td');
    tdMaintenanceLabel.textContent = 'Maintenance';
    trMaintenance.appendChild(tdMaintenanceLabel);
    
    // Maintenance months cells with dropdowns
    for(let i = 0; i < 12; i++) {
      const tdMonth = document.createElement('td');
      const monthSelect = createStatusSelect(data.maintenance[i], (newVal) => {
        maintenanceData[userId].maintenance[i] = newVal;
      });
      tdMonth.appendChild(monthSelect);
      trMaintenance.appendChild(tdMonth);
    }
    tbody.appendChild(trMaintenance);
    
    // Parking row with dropdown selectors
    const trParking = document.createElement('tr');
    const tdParkingLabel = document.createElement('td');
    tdParkingLabel.textContent = 'Parking Fees';
    trParking.appendChild(tdParkingLabel);
    
    // Parking months cells with dropdowns
    for(let i = 0; i < 12; i++) {
      const tdMonth = document.createElement('td');
      const monthSelect = createStatusSelect(data.parking[i], (newVal) => {
        maintenanceData[userId].parking[i] = newVal;
      });
      tdMonth.appendChild(monthSelect);
      trParking.appendChild(tdMonth);
    }
    tbody.appendChild(trParking);
  }

  // Helper function to create a status select dropdown
  function createStatusSelect(currentValue, onChange) {
    const select = document.createElement('select');
    const options = ['-', '✔', '✘'];
    
    options.forEach(option => {
      const opt = document.createElement('option');
      opt.value = option;
      opt.textContent = option;
      if (option === currentValue) {
        opt.selected = true;
      }
      select.appendChild(opt);
    });
    
    select.onchange = () => {
      onChange(select.value);
    };
    
    return select;
  }

  // Initialize the application by rendering the guest view
  renderTabButtons('guest');
</script>

</body>
</html>