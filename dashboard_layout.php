<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>TNSCHE Dashboard</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .openbtn {
      font-size: 14px;
      cursor: pointer;
      background-color: #999;
      color: white;
      padding: 10px 10px;
      border: none;
      border-radius: 5px;
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 1100;
    }

    .sidebar {
      height: 100%;
      width: 250px;
      position: fixed;
      left: -250px;
      top: 0;
      background-color: #2c3e50;
      overflow-x: hidden;
      transition: 0.3s;
      padding-top: 60px;
      z-index: 1000;
    }

    .sidebar.active {
      left: 0;
    }

    .sidebar ul {
      list-style-type: none;
      padding: 0;
    }

    .sidebar ul li {
      margin: 10px 0;
      text-align: center;
    }

    .sidebar ul li button {
      width: 80%;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 6px;
      background-color: #3498db;
      color: white;
      border: none;
      cursor: pointer;
      transition: background 0.3s;
    }

    .sidebar ul li button:hover {
      background-color: #2980b9;
    }

    .main-container {
      margin-left: 0;
      margin-top: 60px;
      padding: 20px;
      transition: margin-left 0.3s;
    }

    .main-container.shifted {
      margin-left: 250px;
    }

    #content {
      background: #f4f4f4;
      padding: 20px;
      min-height: 80vh;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    /* Sticky header (optional) */
     header {
      background-color: #007bff;
      color: white;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: nowrap;
    }

    .header-img {
      height: 100px;
      width: 100px;
      object-fit: contain;
    }

    .header-text {
      text-align: center;
      flex-grow: 1;
    }

    .header-text h1 {
      margin: 0;
      font-size: 1.8rem;
    }

    .header-text h2 {
      margin: 0;
      font-size: 1.2rem;
      font-weight: normal;
    }

    .container {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 30px;
    }

    h2 {
      text-align: center;
      color: #FFFBF0;
    }
  </style>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- Header -->
<header>
  <img style="margin-left:225px;" src="TN_LOGO.png" alt="Left Logo" class="header-img">
  <div class="header-text">
    <h1>TAMILNADU STATE COUNCIL FOR HIGHER EDUCATION</h1>
    <h2><span lang="ta">தமிழ்நாடு மாநில உயர்கல்வி மன்றம்</span></h2>
  </div>
  <img src="tnschelogo.png" alt="Right Logo" class="header-img">
</header>

<!-- Menu Toggle -->
<button class="openbtn" onclick="toggleSidebar()">☰ Menu</button>

<!-- Sidebar -->
<div id="sidebar" class="sidebar">
  <ul>
    <li><button onclick="loadPage('institutions.php')">Institutions</button></li>
    <li><button onclick="loadPage('dashboard2.php')">Dashboard</button></li>
    <li><button onclick="loadPage('positive_feedback.php')" style="background-color: #28a745;">Positive Feedback</button></li>
    <li><button onclick="loadPage('negative_feedback.php')" style="background-color: #dc3545;">Negative Feedback</button></li>
  </ul>
</div>

<!-- Main Container -->
<div id="main" class="main-container">
 
  <div id="content">
 

    <h3>Welcome</h3>
    <p>Select a menu option to load content.</p>
  </div>
 
</div>

<script>
function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const main = document.getElementById("main");
  sidebar.classList.toggle("active");
  main.classList.toggle("shifted");
}
/*
function loadPage(page) {
 fetch(page)
    .then(response => {
      if (!response.ok) throw new Error("Network error");
      return response.text();
    })
    .then(html => {
		     document.getElementById("content").innerHTML = html;
    })
    .catch(err => {
      document.getElementById("content").innerHTML = "<p>Error loading content.</p>";
      console.error(err);
    });
}
*/

function loadPage(page) {
  fetch(page)
    .then(response => {
      if (!response.ok) throw new Error("Network error");
      return response.text();
    })
    .then(html => {
      const content = document.getElementById("content");
      content.innerHTML = html;

      // Manually re-insert and run scripts
      const scripts = content.querySelectorAll("script");
      scripts.forEach(oldScript => {
        const newScript = document.createElement("script");
        newScript.text = oldScript.textContent;
        document.body.appendChild(newScript).parentNode.removeChild(newScript);
      });
    })
    .catch(err => {
      document.getElementById("content").innerHTML = "<p>Error loading content.</p>";
      console.error(err);
    });
}

</script>

</body>
</html>
