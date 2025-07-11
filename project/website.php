<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>HOUSING SOCIETY MANAGEMENT</title>
<style>
  /* Reset and base */
  body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f7f9fc;
    color: #333;
  }
  h1 {
    text-align: center;
    margin-top: 40px;
    font-weight: 700;
    color: #2c3e50;
    text-transform: uppercase;
    letter-spacing: 2px;
  }
  /* Tab container */
  .tab-container {
    max-width: 900px;
    margin: 30px auto 50px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    overflow: hidden;
  }
  /* Tab buttons */
  .tab-buttons {
    display: flex;
    background: DarkOrchid;
    flex-wrap: wrap;
  }
  .tab-buttons button {
  background: DarkOrchid;
  border: none;
  border-radius: 6px;
  color: white;
  cursor: pointer;
  flex: 1;
  font-size: 1rem;
  font-weight: 600;
  margin: 2px;
  min-width: 120px;
  outline: none;
  padding: 15px 10px;
  /* transition: background 0.3s ease;*/
}

  .tab-buttons button:hover {
    background: BlueViolet;
  }
  .tab-buttons button.active {
    background: DarkMagenta;
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
    color: #34495e;
  }
  input[type="text"],
  input[type="password"],
  select, textarea {
    padding: 10px 12px;
    font-size: 1rem;
    border: 1.8px solid #bdc3c7;
    border-radius: 6px;
    transition: border-color 0.3s ease;
  }
  input[type="text"]:focus,
  input[type="password"]:focus,
  select:focus, textarea:focus {
    outline: none;
    border-color: #1abc9c;
    box-shadow: 0 0 6px #1abc9c88;
  }
  button.submit-btn {
    background: BlueViolet;
    border: none;
    color: white;
    font-weight: 700;
    padding: 12px 0;
    font-size: 1.1rem;
    border-radius: 6px;
    cursor: pointer;
   /* transition: background 0.3s ease; */
  }
  button.submit-btn:hover {
    background: DarkOrchid;
  }
  /* Centered text for welcome tab */
  .welcome-msg {
    text-align: center;
    font-size: 1.1rem;
    color: #2c3e50;
    margin-top: 40px;
  }
  /* Error message styling */
  .error-msg {
    color: #e74c3c;
    font-weight: 600;
    font-size: 0.9rem;
  }
  /* Resident and Committee features */
  .features {
    margin-top: 20px;
  }
  /* Create account link style */
  .create-account-link {
    text-align: center;
    margin-top: 20px;
  }
  .create-account-link a {
    cursor: pointer;
    color: BlueViolet;
    font-weight: 600;
    text-decoration: underline;
  }
  /* Logout button style */
  .logout-btn {
    position: absolute;
    right: 15px;
    top: 15px;
    background: DarkViolet;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: 600;
    z-index: 100;
  }
  .logout-btn:hover {
    background: Purple; 
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
    border: 1px solid #bdc3c7;
    padding: 8px 4px;
    text-align: center;
    /*text-style: wrap;*/
    font-size: 0.9rem;
  }
  #maintenance-table th, #complaints-table th,
  #committee-complaints-table th {
    background: #dcd6f7;
    font-weight: 700;
   /* text-style: warp; */
  }
  #maintenance-table td.status-cell,
  #complaints-table td.status-cell {
    cursor: pointer;
  }
  .resident-id-display {
    font-weight: bold;
    margin-bottom: 10px;
    font-size: 1.1rem;
    color: #2c3e50;
  }
  /* Content display styles */
  .content-list {
    list-style-type: none;
    padding: 0;
  }
  .content-item {
    background: #f8f9fa;
    padding: 15px;
    margin-bottom: 10px;
    border-radius: 5px;
    border-left: 4px solid BlueViolet;
  }
  .content-item h4 {
    margin-top: 0;
    color: #2c3e50;
  }
  .content-item p {
    margin-bottom: 0;
    color: Ascent;
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
  border: 1px solid #ddd;
  border-radius: 5px;
  overflow: hidden;
  position: relative;
}

.photo-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.photo-title {
  padding: 10px;
  background-color: #f8f9fa;
  font-weight: 500;
}

.delete-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: rgba(255, 0, 0, 0.7);
  color: white;
  border: none;
  border-radius: 50%;
  width: 30px;
  height: 30px;
  cursor: pointer;
  display: none;
}

.photo-card:hover .delete-btn {
  display: block;
}
  /* Responsive */
  @media (max-width: 540px) {
    .tab-buttons button {
      min-width: 100%;
      margin: 4px 0;
    }
    #maintenance-table, #complaints-table, #committee-complaints-table {
      font-size: 0.75rem;
    }
  }
</style>
</head>
<body>

<h1>Housing Society Management</h1>

<div class="tab-container">
  <div id="tab-buttons" class="tab-buttons">
    <button id="tab-home-btn" class="active" type="button" onclick="showTab('home')">HOME</button>
    <button id="tab-login-btn" type="button" onclick="showTab('login')">LOGIN</button>
  </div>

  <div id="home" class="tab active">
    <div class="welcome-msg">
      <p>Welcome to the Housing Society Management Portal.</p>
      <p>Please login to continue.</p>
    </div>
  </div>

  <div id="login" class="tab">
    <h3 style="text-align:center; color:#34495e;">Login</h3>
    <form id="login-form" action="code.php" method="POST">
      <input type="hidden" name="action" value="login">
        <label for="login-userid">User ID</label>
        <input type="text" id="login-userid" name="user_id" required autocomplete="username" />

        <label for="login-password">Password</label>
        <input type="password" id="login-password" name="password" required autocomplete="current-password" />

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
        <input type="text" id="signin-name" name="name" required autocomplete="name" />

        <label for="signin-userid">User ID</label>
        <input type="text" id="signin-userid" name="user_id" required autocomplete="username" />

        <label for="signin-password">Password</label>
        <input type="password" id="signin-password" name="password" required autocomplete="new-password" />

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

  <!-- Resident tabs -->
  <div id="notices" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Society Notices</h3>
    <div class="notices-container" id="notices-container">
      <!-- Notices will be loaded here dynamically -->
    </div>
  </div>

  <div id="gallery" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Gallery</h3>
    <div class="gallery-container" id="gallery-container">
      <!-- Photos will be loaded here dynamically -->
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

  <!-- Committee tabs -->
  <div id="committee-notices" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Upload Notice</h3>
    <form id="upload-notice-form" onsubmit="uploadNotice(event)">
      <label for="notice-title">Notice Title</label>
      <input type="text" id="notice-title" name="title" required />
    
      <label for="notice-file">PDF File</label>
      <input type="file" id="notice-file" name="notice-file" accept=".pdf" required />
    
      <button type="submit" class="submit-btn">Upload Notice</button>
    </form>
    <div id="notice-message" class="error-msg" aria-live="polite"></div>
  
    <h4>Current Notices</h4>
    <div class="notices-container" id="committee-notices-container">
      <!-- Notices will be loaded here dynamically -->
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
  
  // Remove the onsubmit handlers from your forms and let them submit normally
// Just keep the form validation
// At the start of your script, check for URL parameters
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const success = urlParams.get('success');
    const tab = urlParams.get('tab');
    
    if (error) {
        // Show error in appropriate tab
        if (tab === 'login') {
            document.getElementById('login-error').textContent = error;
            showTab('login');
        } else if (tab === 'create-account') {
            document.getElementById('signin-error').textContent = error;
            showTab('create-account');
        }
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
    <?php endif; ?>
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

  // Fake user data for login validation
  //const usersDB = [
    //{ user_id: 'admin', password: 'admin123', role: 'committee', name: 'Admin User' },
    //{ user_id: 'resident1', password: 'res123', role: 'resident', name: 'John Resident' },
    //{ user_id: 'resident2', password: 'res234', role: 'resident', name: 'Jane Resident' }
  //];

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
      createTabButton('home', 'HOME');
      createTabButton('login', 'LOGIN');
      showTab('home');
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
    btn.textContent = label;
    btn.onclick = () => showTab(tabId);
    tabButtonsDiv.appendChild(btn);
  }

  // Shows a tab by id, hides others and highlights appropriate button
  function showTab(tabId) {
    // Hide all tabs
    document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
    // Show selected tab
    const tab = document.getElementById(tabId);
    if (tab) {
      tab.classList.add('active');
      
      if (tabId === 'maintenance' && currentUser) {
        if(currentUser.role === 'resident'){
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
      } else if (tabId === 'notices' && currentUser?.role === 'resident') {
        renderNoticesForResident();
      } else if (tabId === 'gallery' && currentUser?.role === 'resident') {
        renderGalleryForResident();
      } else if (tabId === 'complaints' && currentUser?.role === 'resident') {
        renderResidentComplaints();
      } else if (tabId === 'committee-notices' && currentUser?.role === 'committee') {
        renderCommitteeNotices();
      } else if (tabId === 'committee-gallery' && currentUser?.role === 'committee') {
        renderCommitteeGallery();
      } else if (tabId === 'committee-complaints' && currentUser?.role === 'committee') {
        renderCommitteeComplaints();
      }
    }
    // Update button active status
    document.querySelectorAll('.tab-buttons button').forEach(btn => btn.classList.remove('active'));
    const btn = document.getElementById(`tab-${tabId}-btn`);
    if (btn) btn.classList.add('active');
  }

  // Render notices for resident (shows all notices from committee)
  function renderNoticesForResident() {
  const container = document.getElementById('notices-container');
  container.innerHTML = '';
  
  if (notices.length === 0) {
    container.innerHTML = '<p>No notices available.</p>';
    return;
  }
  
  notices.forEach(notice => {
    const noticeCard = document.createElement('div');
    noticeCard.className = 'content-item';
    noticeCard.innerHTML = `
      <h4>${notice.title}</h4>
      <p>Uploaded on: ${notice.date}</p>
      <a href="${notice.fileUrl}" target="_blank" class="view-btn" style="display:inline-block; margin-top:10px;">View PDF</a>
    `;
    container.appendChild(noticeCard);
  });
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

  // Render committee's view of notices
  function renderCommitteeNotices() {
  const container = document.getElementById('committee-notices-container');
  container.innerHTML = '';
  
  if (notices.length === 0) {
    container.innerHTML = '<p>No notices uploaded yet.</p>';
    return;
  }
  
  notices.forEach((notice, index) => {
    const noticeCard = document.createElement('div');
    noticeCard.className = 'content-item';
    noticeCard.innerHTML = `
      <h4>${notice.title}</h4>
      <p>Uploaded on: ${notice.date}</p>
      <div style="margin-top:10px;">
        <a href="${notice.fileUrl}" target="_blank" class="view-btn" style="display:inline-block;">View PDF</a>
        <button onclick="deleteNotice(${notice.id})" style="float:right; background:#e74c3c; color:white; border:none; padding:2px 8px; border-radius:3px;">Delete</button>
      </div>
    `;
    container.appendChild(noticeCard);
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

  // Notices upload
  function uploadNotice(event) {
  event.preventDefault();
  const messageElem = document.getElementById('notice-message');
  messageElem.textContent = '';
  
  const title = document.getElementById('notice-title').value.trim();
  const fileInput = document.getElementById('notice-file');
  
  if (!title || !fileInput.files[0]) {
    messageElem.textContent = 'Please fill all fields and select a PDF file.';
    return;
  }

  const file = fileInput.files[0];
  const fileName = file.name;
  const fileUrl = URL.createObjectURL(file);

  const newNotice = {
    id: notices.length + 1,
    title: title,
    filename: fileName,
    fileUrl: fileUrl,
    uploadedBy: currentUser.user_id,
    date: new Date().toLocaleDateString() + ' ' + new Date().toLocaleTimeString()
  };

  notices.unshift(newNotice);
  renderCommitteeNotices();
  renderNoticesForResident();
  document.getElementById('upload-notice-form').reset();
  alert("Notice uploaded successfully!");
}

  // Delete notices
  function deleteNotice(id) {
  if (confirm("Are you sure you want to delete this notice?")) {
    notices = notices.filter(notice => notice.id !== id);
    renderCommitteeNotices();
    renderNoticesForResident();
  }
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

  //function logout() {
    //currentUser = null;
    //renderTabButtons('guest');
    //showTab('home');
  //}

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