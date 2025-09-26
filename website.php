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
  /* access container */
  .access-container {
    max-width: 900px;
    margin: 30px auto 50px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 8px 16px rgba(106, 13, 173, 0.1); /* Royal Purple shadow */
    overflow: hidden;
  }
  /* Tab container */
  .tab-container {
    max-width: 900px;
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
  /* Home Tab Styles */
.welcome-section {
    text-align: center;
    margin-bottom: 30px;
    padding: 20px;
    background: #F5F0FA;
    border-radius: 8px;
}

.welcome-section h2 {
    color: #6A0DAD;
    margin-bottom: 10px;
}

.latest-updates-section {
    margin-bottom: 30px;
}

.latest-updates-section h3 {
    color: #6A0DAD;
    border-bottom: 2px solid #B57EDC;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

/* Enhanced Home Tab Styles */
.activities-container {
    max-height: 450px; /* Increased height */
    overflow-y: auto;
    border: 1px solid #B57EDC;
    border-radius: 8px;
    padding: 15px;
    background: #FAFAFA;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    padding: 15px; /* Increased padding */
    margin-bottom: 12px;
    background: #F9F6FF;
    border-left: 4px solid #6A0DAD;
    border-radius: 6px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(106, 13, 173, 0.1);
}

.activity-item:hover {
    transform: translateX(3px);
    background: #F5F0FA;
    box-shadow: 0 4px 8px rgba(106, 13, 173, 0.15);
}

.activity-icon {
    font-size: 1.5rem;
    margin-right: 15px;
    flex-shrink: 0;
}

.activity-content {
    flex-grow: 1;
}

.activity-message {
    font-weight: 500;
    color: #6A0DAD;
    margin-bottom: 6px;
    line-height: 1.5; /* Better line spacing for longer messages */
    word-wrap: break-word; /* Handle long titles */
}

.activity-time {
    font-size: 0.82rem;
    color: #800080;
    font-style: italic;
    opacity: 0.8;
}

.activities-loading {
    text-align: center;
    color: #800080;
    font-style: italic;
    padding: 20px;
}

.quick-stats-section h3 {
    color: #6A0DAD;
    border-bottom: 2px solid #B57EDC;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.quick-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}
/* For committee users who have 4 stat cards */
.committee-user .quick-stats {
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
}
.stat-card {
    background: #F5F0FA;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    border-left: 4px solid #6A0DAD;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #6A0DAD;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    color: #800080;
}

/* Scrollbar styling for activities container */
.activities-container::-webkit-scrollbar {
    width: 6px;
}

.activities-container::-webkit-scrollbar-track {
    background: #F5F0FA;
    border-radius: 3px;
}

.activities-container::-webkit-scrollbar-thumb {
    background: #B57EDC;
    border-radius: 3px;
}

.activities-container::-webkit-scrollbar-thumb:hover {
    background: #6A0DAD;
}
/* About Tab Specific Styles */
.about-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 10px;
}

.about-header {
    text-align: center;
    margin-bottom: 30px;
    padding: 20px;
    background: linear-gradient(135deg, #F5F0FA 0%, #E6E6FA 100%);
    border-radius: 10px;
    border-left: 5px solid #6A0DAD;
}

.about-header h2 {
    color: #6A0DAD;
    margin-bottom: 10px;
    font-size: 2rem;
}

.tagline {
    font-size: 1.2rem;
    color: #800080;
    font-weight: 500;
}

.about-content {
    display: flex;
    flex-direction: column;
    gap: 30px;
}

.mission-section {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    padding: 25px;
    background: #F9F6FF;
    border-radius: 8px;
    border-left: 4px solid #B57EDC;
}

.section-icon {
    font-size: 2.5rem;
    flex-shrink: 0;
}

.mission-section h3 {
    color: #6A0DAD;
    margin-bottom: 10px;
}

.mission-section p {
    color: #555;
    line-height: 1.6;
    font-size: 1.05rem;
}

.benefits-section h3,
.features-section h3 {
    color: #6A0DAD;
    border-bottom: 2px solid #B57EDC;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.benefits-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.benefit-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(106, 13, 173, 0.1);
    border: 1px solid #E6E6FA;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.benefit-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(106, 13, 173, 0.15);
}

.benefit-icon {
    font-size: 2rem;
    margin-bottom: 15px;
}

.benefit-card h4 {
    color: #6A0DAD;
    margin-bottom: 10px;
    font-size: 1.2rem;
}

.benefit-card p {
    color: #666;
    line-height: 1.5;
}

.features-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.feature-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 15px;
    background: #F5F0FA;
    border-radius: 6px;
    transition: background 0.3s ease;
}

.feature-item:hover {
    background: #E6E6FA;
}

.feature-bullet {
    font-size: 1.5rem;
    flex-shrink: 0;
}

.feature-text {
    color: #555;
    line-height: 1.5;
}

.committee-section {
    margin-top: 20px;
}

.committee-card {
    background: linear-gradient(135deg, #6A0DAD 0%, #800080 100%);
    color: white;
    padding: 25px;
    border-radius: 10px;
    text-align: center;
}

.committee-card h3 {
    margin-bottom: 15px;
    font-size: 1.5rem;
}

.committee-card p {
    line-height: 1.6;
    margin-bottom: 15px;
}

.committee-signature {
    font-style: italic;
    font-weight: 500;
    margin-top: 20px;
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
  #complaints-table td:nth-child(3),
  #committee-complaints-table td:nth-child(5) {
    font-size: 0.85rem;
    line-height: 1.4;
    text-align: left;
    padding: 8px 4px;
  }

  .status-history-item {
    margin-bottom: 5px;
    padding: 3px 5px;
    background-color: #f8f9fa;
    border-radius: 3px;
    border-left: 3px solid #6A0DAD;
  }

  .status-history-item:last-child {
    margin-bottom: 0;
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

/* Gallery specific styles */
.gallery-container {
    display: grid;
    grid-template-columns: 1fr; /* Only 1 column 1 photo per row */
    gap: 15px;
    margin-top: 20px;
}

.photo-card {
    border: 1px solid #B57EDC; /* Lavender */
    border-radius: 5px;
    overflow: hidden;
    position: relative;
    background: white;
    display: flex;
    flex-direction: row;
    transition: transform 0.2s ease;
    max-width: 100%;
}

.photo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(106, 13, 173, 0.2);
}

.photo-card img {
    width: 250px;
    height: 200px;
    object-fit: cover;
    flex-shrink: 0; /* Prevent image from shrinking */
}

.photo-details {
    padding: 15px;
    background-color: #E6E6FA;
    flex-grow: 1; /* Allows details section to expand */
    display: flex;
    flex-direction: column;
}

.photo-title {
    font-weight: 500;
    color: #6A0DAD; /* Royal Purple */
    margin-bottom: 8px;
    word-break: break-word;
    font-size: 1.1rem; /* Slightly smaller font */
    line-height: 1.4;  /* Handle long titles */
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Limit to 2 lines */
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.6em; /* Ensure consistent height */
}

.photo-meta {
    font-size: 0.85rem;
    color: #6A0DAD; /* Royal Purple */
    display: flex;
    flex-direction: column;
    gap: 5px;    
    margin-top: auto; /* Push meta to bottom */   
}

.photo-meta span {
    display: block;
    margin-bottom: 3px;
}

.photo-actions {
    margin-top: 10px;
    display: flex;
    justify-content: flex-end;
    gap: 8px; /* Add gap between buttons */
}

/* Editable title styles */
.editable-title {
    position: relative;
    margin-bottom: 8px;
}

.title-text {
    cursor: pointer;
    font-weight: 500;
    color: #6A0DAD; /* Royal Purple */
    word-break: break-word;
    padding: 2px 5px;
    border: 1px dashed transparent;
}

.title-text:hover {
    border-color: #6A0DAD; /* Royal Purple */
    background-color: #F5F0FA; /* Very Pale Purple */
}

.title-edit {
    width: 100%;
    padding: 2px 5px;
    font-size: 1rem;
    border: 1px solid #6A0DAD; /* Royal Purple */
    border-radius: 3px;
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
 @media (max-width: 480px) {
      .about-header h2 {
        font-size: 1.7rem;
    }
    
    .tagline {
        font-size: 1rem;
    }
    
    .mission-section,
    .benefit-card,
    .feature-item {
        padding: 15px;
    }
      .gallery-container {
          grid-template-columns: 1fr; /* Single column on mobile */
      }
      .photo-card img {
          height: 180px; /* Taller images on mobile */
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
 @media (max-width: 768px) {
    .quick-stats,
    .committee-user .quick-stats {
        grid-template-columns: 1fr;
    }
    
    .activity-item {
        flex-direction: column;
        text-align: center;
    }
    
    .activity-icon {
        margin-right: 0;
        margin-bottom: 10px;
    }
    .mission-section {
        flex-direction: column;
        text-align: center;
    }
    
    .benefits-grid {
        grid-template-columns: 1fr;
    }
    
    .feature-item {
        flex-direction: column;
        text-align: center;
    }
    .photo-card {
        flex-direction: column; /* Stack vertically on mobile */
    }
    
    .photo-card img {
        width: 100%; /* Full width on mobile */
        height: 200px;
    }
    
    .gallery-container {
        grid-template-columns: 1fr; /* Still 1 column on mobile */
    }
  }
 @media (max-width: 1024px) {
      .gallery-container {
          grid-template-columns: repeat(3, 1fr); /* 3 columns on medium screens */
      }
      .committee-user .quick-stats {
        grid-template-columns: repeat(2, 1fr);
    }
  }
</style>
</head>
<body>

<div class="header-container">
    <img src="Titlelogo.png" alt="Society Sphere Logo" class="logo">
    <h1>Society Sphere</h1>
</div>

<div class="access-container">
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
</div>

<div class="tab-container">
  <!-- tabs  
  ############# -->
  <div id="home" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    
    <div class="welcome-section">
        <h2>Welcome to SocietySphere</h2>
        <p>Connecting Residents, Strengthening Community.</p>
        <p>Your one-stop destination for a seamless society living experience.</p>
    </div>
    
    <div class="latest-updates-section">
        <h3>Latest Community Updates</h3>
        <div id="latest-activities-container" class="activities-container">
            <!-- Activities will be loaded here dynamically -->
            <p>Loading latest activities...</p>
        </div>
    </div>
    
    <div class="quick-stats-section">
        <h3>Quick Overview</h3>
        <div id="quick-stats" class="quick-stats">
            <!-- Quick stats will be loaded here -->
        </div>
    </div>
</div>

  <div id="about" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    
    <div class="about-container">
        <div class="about-header">
            <h2>About SocietySphere Portal</h2>
            <p class="tagline">Transparency and Convenience at Your Fingertips</p>
        </div>
        
        <div class="about-content">
            <div class="mission-section">
                <div class="section-icon">🎯</div>
                <h3>Our Mission</h3>
                <p>This online portal is an initiative by the Managing Committee to modernize our communication and management processes. Our goal is to foster greater transparency, improve efficiency, and provide you with instant access to important information, 24/7.</p>
            </div>
            
            <div class="benefits-section">
                <h3>Key Benefits</h3>
                <div class="benefits-grid">
                    <div class="benefit-card">
                        <div class="benefit-icon">🔒</div>
                        <h4>Secure Platform</h4>
                        <p>This secure platform is designed to streamline society operations and enhance connectivity among all residents.</p>
                    </div>
                    
                    <div class="benefit-card">
                        <div class="benefit-icon">⚡</div>
                        <h4>Efficient Management</h4>
                        <p>Automated processes reduce administrative burdens and save time for both residents and committee members.</p>
                    </div>
                    
                    <div class="benefit-card">
                        <div class="benefit-icon">🌐</div>
                        <h4>24/7 Accessibility</h4>
                        <p>Access important notices, maintenance information, and community updates anytime, anywhere.</p>
                    </div>
                    
                    <div class="benefit-card">
                        <div class="benefit-icon">🤝</div>
                        <h4>Enhanced Connectivity</h4>
                        <p>Better communication channels between residents and the managing committee for a harmonious community.</p>
                    </div>
                </div>
            </div>
            
            <div class="features-section">
                <h3>What You Can Do</h3>
                <div class="features-list">
                    <div class="feature-item">
                        <span class="feature-bullet">📋</span>
                        <div class="feature-text">
                            <strong>View Society Notices:</strong> Stay updated with the latest announcements and circulars.
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-bullet">📸</span>
                        <div class="feature-text">
                            <strong>Browse Community Gallery:</strong> View photos of society events and activities.
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-bullet">📝</span>
                        <div class="feature-text">
                            <strong>Submit Complaints:</strong> Report issues and track their resolution status.
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <span class="feature-bullet">💰</span>
                        <div class="feature-text">
                            <strong>Check Maintenance Status:</strong> View your maintenance and parking fee payment records.
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="committee-section">
                <div class="committee-card">
                    <h3>Committee Message</h3>
                    <p>We are committed to leveraging technology to improve the quality of life in our society. SocietySphere represents our dedication to transparent governance and resident convenience.</p>
                    <p class="committee-signature">- The Managing Committee</p>
                </div>
            </div>
        </div>
    </div>
</div>

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
    <!-- Photos will be loaded here dynamically -->
  </div>
</div>

<div id="complaints" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Submit Complaint</h3>
    <form id="complaint-form" method="POST" action="code.php">
        <input type="hidden" name="action" value="submit_complaint">
        <label for="complaint-title">Title</label>
        <input type="text" id="complaint-title" name="title" required />
        
        <label for="complaint-description">Description</label>
        <textarea id="complaint-description" name="description" rows="4" required></textarea>
        
        <button type="submit" class="submit-btn">Submit Complaint</button>
    </form>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-msg"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-msg"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <h4>Your Complaints</h4>
    <div class="table-responsive">
        <table id="complaints-table" aria-label="Your Complaints">
            <thead>
                <tr>
                    <th>Complaint</th>
                    <th>Status</th>
                    <th>Status History</th>
                </tr>
            </thead>
            <tbody id="complaints-table-body">
                <!-- rows will be loaded by JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Resident Maintenance Tab -->
<div id="maintenance" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Maintenance Status</h3>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-msg"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-msg"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <div id="resident-id-display" class="resident-id-display"></div>
    
    <div class="table-responsive">
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
                <!-- rows will be loaded by JavaScript -->
            </tbody>
        </table>
    </div>
    
    <div id="maintenance-message" class="error-msg" aria-live="polite"></div>
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
  <form id="upload-photo-form" action="code.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="upload_photo">
    <label for="photo-title">Title</label>
    <input type="text" id="photo-title" name="title" required />
    
    <label for="photo">Photo (PNG or JPEG only, max 5MB)</label>
    <input type="file" id="photo" name="photo" accept=".png,.jpeg,.jpg" required />
    
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
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-msg"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-msg"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <div class="table-responsive">
        <table id="committee-complaints-table" aria-label="Complaints Management">
            <thead>
                <tr>
                    <th>Resident</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Status History</th>
                </tr>
            </thead>
            <tbody id="committee-complaints-table-body">
                <!-- rows will be loaded by JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Committee Maintenance Tab -->
<div id="committee-maintenance" class="tab">
    <button class="logout-btn" onclick="logout()">Logout</button>
    <h3>Maintenance Management</h3>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-msg"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-msg"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <div id="committee-resident-selector" style="margin-bottom:20px;">
        <label for="committee-resident-select">Select Resident:</label>
        <select id="committee-resident-select" style="margin-left: 10px; padding: 5px; min-width: 200px;">
            <option value="">Loading...</option>
        </select>
    </div>
    
    <div class="table-responsive">
        <table id="committee-maintenance-table" aria-label="Maintenance and Parking Fees Management">
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
            <tbody id="committee-maintenance-table-body">
                <!-- rows will be loaded by JavaScript -->
            </tbody>
        </table>
    </div>
    
    <form id="maintenance-update-form" method="POST" action="code.php" style="margin-top: 20px;">
        <input type="hidden" name="action" value="update_maintenance_status">
        <input type="hidden" id="selected-resident-id" name="resident_id" value="">
        <button type="button" class="submit-btn" onclick="saveAllMaintenanceChanges()">Save Changes</button>
    </form>
    
    <div id="committee-maintenance-message" class="error-msg" aria-live="polite"></div>
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
        if (tabId === 'home') {
            loadLatestActivities();
            loadQuickStats();
        } else if (tabId === 'maintenance' && currentUser.role === 'resident') {
            loadMaintenanceData();
        } else if (tabId === 'committee-maintenance' && currentUser.role === 'committee') {
            loadCommitteeMaintenanceInterface();
        } else if (tabId === 'notices' && currentUser.role === 'resident') {
            loadNoticesForResident();
        } else if (tabId === 'gallery' && currentUser.role === 'resident') {
            loadGalleryPhotos(false);
        } else if (tabId === 'complaints' && currentUser.role === 'resident') {
            loadResidentComplaints();
        } else if (tabId === 'committee-notices' && currentUser.role === 'committee') {
            loadNoticesForCommittee();
        } else if (tabId === 'committee-gallery' && currentUser.role === 'committee') {
            loadGalleryPhotos(true);
        } else if (tabId === 'committee-complaints' && currentUser.role === 'committee') {
            loadCommitteeComplaints();
        }
    }
}

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

     // Show home tab for all users regardless of role
if (currentUser.role === 'committee') {
  document.body.classList.add('committee-user');
}
showTab('home'); // Same home tab for all roles
    <?php else: ?>
      renderTabButtons('guest');
    <?php endif; ?>
});
    
// Email validation
const emailField = document.getElementById('signin-email');
const emailError = document.getElementById('email-error');
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
        alert('Valid building number format: C-Building number (e.g., C-00)');
    } else {
        this.style.borderColor = '#ddd';
    }
});

document.getElementById('signin-room').addEventListener('blur', function() {
    const room = this.value;
    const pattern = /^[0-9]{1,2}\/[0-9]{2}$/;
    
    if (room && !pattern.test(room)) {
        this.style.borderColor = '#e74c3c';
        alert('Valid room number format: Floor number/Room number (e.g., 0/00)');
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
        alert('Valid building number format: C-Building number (e.g., C-00)');
        document.getElementById('signin-building').focus();
        return;
    }
    
    if (!roomPattern.test(room)) {
        event.preventDefault();
        alert('Valid room number format: Floor number/Room number (e.g., 0/00)');
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
    { id: 'home', label: 'Home' },
    { id: 'about', label: 'About Us' },
    { id: 'notices', label: 'Notices' },
    { id: 'gallery', label: 'Gallery' },
    { id: 'complaints', label: 'Complaints' },
    { id: 'maintenance', label: 'Maintenance' }
];

const tabsForCommittee = [
    { id: 'home', label: 'Home' },
    { id: 'about', label: 'About Us' },
    { id: 'committee-notices', label: 'Notices' },
    { id: 'committee-gallery', label: 'Gallery' },
    { id: 'committee-complaints', label: 'Complaints' },
    { id: 'committee-maintenance', label: 'Maintenance' }
];

  // Data storage for notices, gallery and complaints
  let notices = [];
  let galleryPhotos = [];
  let complaints = [];
  let maintenanceChanges = [];

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
  if (label === 'Home') {
    logo.src = 'HomeLogo.png'; // Use the same logo as your header
    logo.alt = 'Home Tab Logo';
  }  
  else if (label === 'About Us') {
    logo.src = 'AboutUsLogo.png'; // Use the same logo as your header
    logo.alt = 'About Us Tab Logo';
  }
  else if (label === 'Notices' || tabId === 'committee-notices') {
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

//###########---HOME_START---###################
// Enhanced load latest activities function
async function loadLatestActivities() {
    const container = document.getElementById('latest-activities-container');
    container.innerHTML = '<div class="activities-loading">Loading latest activities...</div>';
    
    try {
        const response = await fetch('code.php?action=get_latest_activities');
        const content = await response.text();
        
        if (response.ok) {
            container.innerHTML = content;
        } else {
            container.innerHTML = '<p class="error-msg">Unable to load activities. Please try again later.</p>';
        }
    } catch (error) {
        console.error('Error loading activities:', error);
        container.innerHTML = '<p class="error-msg">Network error loading activities.</p>';
    }
}

// Load quick stats based on user role
async function loadQuickStats() {
    const statsContainer = document.getElementById('quick-stats');
    
    try {
        const response = await fetch('code.php?action=get_quick_stats');
        statsContainer.innerHTML = await response.text();
    } catch (error) {
        // Fallback to placeholder stats if there's an error
        if (currentUser.role === 'resident') {
            statsContainer.innerHTML = `
                <div class="stat-card">
                    <div class="stat-number">...</div>
                    <div class="stat-label">Pending Complaints</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">...</div>
                    <div class="stat-label">Unpaid Maintenance</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">...</div>
                    <div class="stat-label">New Notices</div>
                </div>
            `;
        } else if (currentUser.role === 'committee') {
            statsContainer.innerHTML = `
                <div class="stat-card">
                    <div class="stat-number">...</div>
                    <div class="stat-label">Total Complaints</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">...</div>
                    <div class="stat-label">Pending Complaints</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">...</div>
                    <div class="stat-label">Total Residents</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">...</div>
                    <div class="stat-label">Unpaid Maintenance</div>
                </div>
            `;
        }
    }
}

// Placeholder functions for loading actual stats (you can implement these later)
async function loadResidentQuickStats() {
    // Implement AJAX call to get resident-specific stats
    // For now, using placeholder values
    document.getElementById('pending-complaints').textContent = '...';
    document.getElementById('unpaid-maintenance').textContent = '...';
    document.getElementById('new-notices').textContent = '...';
}

async function loadCommitteeQuickStats() {
    // Implement AJAX call to get committee stats
    // For now, using placeholder values
    document.getElementById('total-complaints').textContent = '...';
    document.getElementById('pending-complaints').textContent = '...';
    document.getElementById('total-residents').textContent = '...';
}
//##########---HOME_END---####################### 


//##########---NOTICE_START---#####################
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

//##########---NOTICE_END---#################

//##########---GALLERY_START---##############
// Load gallery photos
async function loadGalleryPhotos(isCommittee = false) {
    const container = document.getElementById(isCommittee ? 'committee-gallery-container' : 'gallery-container');
    container.innerHTML = '<p>Loading photos...</p>';
    
    try {
        const response = await fetch('code.php?action=get_gallery_photos');
        container.innerHTML = await response.text();
        
        // Add event listeners for editable titles if committee
        if (isCommittee) {
            setupEditableTitles();
        }
    } catch (error) {
        container.innerHTML = '<p class="error-msg">Error loading photos</p>';
    }
}

// Setup editable titles for committee
function setupEditableTitles() {
    const editableTitles = document.querySelectorAll('.editable-title');
    
    editableTitles.forEach(container => {
        const textSpan = container.querySelector('.title-text');
        const editInput = container.querySelector('.title-edit');
        
        textSpan.addEventListener('click', () => {
            textSpan.style.display = 'none';
            editInput.style.display = 'block';
            editInput.focus();
        });
        
        editInput.addEventListener('blur', () => {
            saveTitleChange(container);
        });
        
        editInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                saveTitleChange(container);
            } else if (e.key === 'Escape') {
                editInput.value = textSpan.textContent;
                editInput.style.display = 'none';
                textSpan.style.display = 'inline';
            }
        });
    });
}

// Save title change
async function saveTitleChange(container) {
    const textSpan = container.querySelector('.title-text');
    const editInput = container.querySelector('.title-edit');
    const photoId = container.dataset.id;
    const newTitle = editInput.value.trim();
    
    if (newTitle === textSpan.textContent || newTitle === '') {
        editInput.style.display = 'none';
        textSpan.style.display = 'inline';
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('action', 'update_photo_title');
        formData.append('id', photoId);
        formData.append('title', newTitle);
        
        const response = await fetch('code.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            textSpan.textContent = newTitle;
            editInput.style.display = 'none';
            textSpan.style.display = 'inline';
        } else {
            alert('Error: ' + result.message);
            editInput.value = textSpan.textContent;
            editInput.style.display = 'none';
            textSpan.style.display = 'inline';
        }
    } catch (error) {
        alert('Error updating title');
        editInput.value = textSpan.textContent;
        editInput.style.display = 'none';
        textSpan.style.display = 'inline';
    }
}

// Delete photo
function deletePhoto(photoId) {
    if (confirm('Are you sure you want to delete this photo?')) {
        window.location.href = 'code.php?action=delete_photo&id=' + photoId;
    }
}

// Handle photo upload
async function uploadPhoto(event) {
    event.preventDefault();
    const messageElem = document.getElementById('photo-message');
    messageElem.textContent = '';
    
    const title = document.getElementById('photo-title').value.trim();
    const fileInput = document.getElementById('photo');

    if (!title || fileInput.files.length === 0) {
        messageElem.textContent = 'Please fill all fields and select a photo.';
        return;
    }
    
    const formData = new FormData();
    formData.append('action', 'upload_photo');
    formData.append('title', title);
    formData.append('photo', fileInput.files[0]);
    
    try {
        const response = await fetch('code.php', {
            method: 'POST',
            body: formData
        });
        
        if (response.ok) {
            alert('Photo uploaded successfully');
            document.getElementById('upload-photo-form').reset();
            loadGalleryPhotos(true); // Reload gallery for committee
        } else {
            messageElem.textContent = 'Error uploading photo';
        }
    } catch (error) {
        messageElem.textContent = 'Error uploading photo';
    }
}
//##########---GALLERY_END---#################

//##########---COMPLAINT_START---##########

// Load complaints for resident
async function loadResidentComplaints() {
    try {
        const response = await fetch('code.php?action=get_resident_complaints');
        document.getElementById('complaints-table-body').innerHTML = await response.text();
    } catch (error) {
        document.getElementById('complaints-table-body').innerHTML = '<tr><td colspan="3">Error loading complaints</td></tr>';
    }
}

// Load all complaints for committee
async function loadCommitteeComplaints() {
    try {
        const response = await fetch('code.php?action=get_all_complaints');
        document.getElementById('committee-complaints-table-body').innerHTML = await response.text();
        
        // Add event listeners for status dropdowns
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {
                updateComplaintStatus(this.dataset.complaintId, this.value);
            });
        });
    } catch (error) {
        document.getElementById('committee-complaints-table-body').innerHTML = '<tr><td colspan="5">Error loading complaints</td></tr>';
    }
}

// Update complaint status
async function updateComplaintStatus(complaintId, status) {

const formData = new FormData();
    formData.append('action', 'update_complaint_status');
    formData.append('complaint_id', complaintId);
    formData.append('status', status);
    
    try {
        const response = await fetch('code.php', {
            method: 'POST',
            body: formData
        });
        
        if (response.redirected) {
            window.location.href = response.url;
        } else {
            loadCommitteeComplaints(); // Reload the complaints
        }
    } catch (error) {
        alert('Error updating complaint status');
    }
}
//#########---COMPLAINY_END---###########

//##########---MAINTENANCE_START---###########
async function loadMaintenanceData() {
    if (currentUser.role === 'resident') {
        renderResidentIdDisplay(currentUser.user_id);
        await loadResidentMaintenance();
    } else if (currentUser.role === 'committee') {
        await loadCommitteeMaintenanceInterface();
    }
}

// Load maintenance for resident
async function loadResidentMaintenance() {
    try {
        const response = await fetch('code.php?action=get_resident_maintenance');
        document.getElementById('maintenance-table-body').innerHTML = await response.text();
    } catch (error) {
        document.getElementById('maintenance-table-body').innerHTML = '<tr><td colspan="13">Error loading maintenance data</td></tr>';
    }
}
// Load maintenance for committee
async function loadCommitteeMaintenance(userId) {
    try {
        const response = await fetch(`code.php?action=get_resident_maintenance_for_committee&user_id=${userId}`);
        
        if (response.ok) {
            document.getElementById('committee-maintenance-table-body').innerHTML = await response.text();
            
            // Clear previous changes
            maintenanceChanges = [];
            
            // Add event listeners for dropdowns
            document.querySelectorAll('.maintenance-select').forEach(select => {
                select.addEventListener('change', function() {
                    const changeData = {
                        residentId: this.dataset.residentId,
                        year: this.dataset.year,
                        month: this.dataset.month,
                        type: this.dataset.type,
                        status: this.value,
                        element: this
                    };
                    
                    // Remove existing change for same field if exists
                    maintenanceChanges = maintenanceChanges.filter(change => 
                        !(change.residentId === changeData.residentId &&
                          change.year === changeData.year &&
                          change.month === changeData.month &&
                          change.type === changeData.type)
                    );
                    
                    // Add new change
                    maintenanceChanges.push(changeData);
                    
                    // Highlight changed field
                    this.style.backgroundColor = '#fff9c4';
                });
            });
        } else {
            document.getElementById('committee-maintenance-table-body').innerHTML = '<tr><td colspan="13">Error loading maintenance data</td></tr>';
        }
    } catch (error) {
        document.getElementById('committee-maintenance-table-body').innerHTML = '<tr><td colspan="13">Error loading maintenance data</td></tr>';
    }
}

// Load committee maintenance interface
async function loadCommitteeMaintenanceInterface() {
    try {
        // Load residents list
        const response = await fetch('code.php?action=get_all_residents');
        const residentSelect = document.getElementById('committee-resident-select');
        
        if (response.ok) {
            residentSelect.innerHTML = '<option value="">Select Resident</option>' + await response.text();
        } else {
            residentSelect.innerHTML = '<option value="">Error loading residents</option>';
        }
        
        // Add event listener for resident selection
        residentSelect.addEventListener('change', function() {
            if (this.value) {
                document.getElementById('selected-resident-id').value = this.value;
                loadCommitteeMaintenance(this.value);
            } else {
                document.getElementById('committee-maintenance-table-body').innerHTML = '<tr><td colspan="13">Please select a resident</td></tr>';
            }
        });
        
        // Clear table initially
        document.getElementById('committee-maintenance-table-body').innerHTML = '<tr><td colspan="13">Please select a resident</td></tr>';
        
    } catch (error) {
        document.getElementById('committee-resident-select').innerHTML = '<option value="">Error loading residents</option>';
    }
}

// Get all residents for committee dropdown
async function getAllResidents() {
   try {
        const response = await fetch('code.php?action=get_all_residents');
        const optionsHtml = await response.text();
        const parser = new DOMParser();
        const doc = parser.parseFromString(optionsHtml, 'text/html');
        return Array.from(doc.querySelectorAll('option')).map(option => ({
            value: option.value,
            text: option.textContent
        }));
    } catch (error) {
        return [];
    }
}

// Render resident selector for committee
async function renderResidentSelector() {
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
    
    // Add loading option initially
    const loadingOption = document.createElement('option');
    loadingOption.value = '';
    loadingOption.textContent = 'Loading...';
    select.appendChild(loadingOption);
    
    selectorDiv.appendChild(select);
    
    // Load residents
    const residents = await getAllResidents();
    
    // Clear loading option and add actual residents
    select.innerHTML = '';
    residents.forEach(resident => {
        const option = document.createElement('option');
        option.value = resident.value;
        option.textContent = resident.text;
        select.appendChild(option);
    });
    
    // Add event listener
    select.addEventListener('change', async () => {
        await loadCommitteeMaintenance(select.value);
    });
    
    // Load maintenance for first resident by default
    if (residents.length > 0) {
        await loadCommitteeMaintenance(residents[0].value);
    }
}

// Save all maintenance changes
async function saveAllMaintenanceChanges() {
    if (maintenanceChanges.length === 0) {
        alert('No changes to save.');
        return;
    }
    
    try {
        // Submit all changes via fetch API
        for (let i = 0; i < maintenanceChanges.length; i++) {
            const change = maintenanceChanges[i];
            
            const formData = new FormData();
            formData.append('action', 'update_maintenance_status');
            formData.append('resident_id', change.residentId);
            formData.append('year', change.year);
            formData.append('month', change.month);
            formData.append('type', change.type);
            formData.append('status', change.status);
            
            const response = await fetch('code.php', {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) {
                throw new Error('Failed to update maintenance status');
            }
            
            // Reset background color
            change.element.style.backgroundColor = '';
        }
        
        alert('All changes saved successfully!');
        maintenanceChanges = []; // Clear changes array
        
        // Reload current resident's data
        const selectedResidentId = document.getElementById('committee-resident-select').value;
        if (selectedResidentId) {
            loadCommitteeMaintenance(selectedResidentId);
        }
        
    } catch (error) {
        alert('Error saving changes: ' + error.message);
    }
}

async function updateMaintenanceStatus(residentId, year, month, type, status) { // Changed to residentId
const formData = new FormData();
    formData.append('action', 'update_maintenance_status');
    formData.append('resident_id', residentId);
    formData.append('year', year);
    formData.append('month', month);
    formData.append('type', type);
    formData.append('status', status);
    
    try {
        const response = await fetch('code.php', {
            method: 'POST',
            body: formData
        });
        
        return response.ok;
    } catch (error) {
        console.error('Error updating maintenance status:', error);
        return false;
    }
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

// Clear resident selector (for residents)
function clearResidentSelector() {
    const selectorDiv = document.getElementById('resident-selector');
    selectorDiv.innerHTML = '';
}
//###########---MAINTENANCE_END---###########

 function showCreateAccountForm() {
    renderTabButtons('guest');
    showTab('create-account');
  }
  // Initialize the application by rendering the guest view
  renderTabButtons('guest');
</script>

</body>
</html>