<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>TNSCHE</title>
  <style>

    header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #f2f2f2;
      padding: 10px 20px;
    }

    .header-img {
      width: 80px;
      height: auto;
    }

    .header-text {
      text-align: center;
      flex-grow: 1;
    }

    .header-text h1 {
      margin: 0;
      font-size: 22px;
    }

    .header-text h2 {
      margin: 0;
      font-size: 18px;
      color: #555;
    }

    /* Menu Styles */
    nav {
      background-color: #004080;
    }

    .menu {
      display: flex;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .menu > li {
      position: relative;
    }

    .menu > li > a {
      display: block;
      padding: 14px 20px;
      color: white;
      text-decoration: none;
    }

    .menu > li:hover {
      background-color: #003366;
    }

    .dropdown {
      display: none;
      position: absolute;
      background-color: #ffffff;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      min-width: 180px;
      z-index: 1;
    }

    .dropdown a {
      color: #333;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown a:hover {
      background-color: #f1f1f1;
    }

    .menu li:hover .dropdown {
      display: block;
    }
  </style>
</head>
<body>

  <header>
    <img src="TN_LOGO.png" alt="Left Logo" class="header-img">
    <div class="header-text">
      <h1>TAMILNADU STATE COUNCIL FOR HIGHER EDUCATION</h1>
      <h2><span lang="ta">தமிழ்நாடு மாநில உயர்கல்வி மன்றம்</span></h2>
    </div>
    <img src="tnschelogo.png" alt="Right Logo" class="header-img">
  </header>

  <nav>
    <ul class="menu">
      <li><a href="#">Home</a></li>
      <li>
        <a href="#">About</a>
        <ul class="dropdown">
          <li><a href="#">Vision & Mission</a></li>
          <li><a href="#">Members</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </li>
      <li>
        <a href="#">Programs</a>
        <ul class="dropdown">
          <li><a href="#">UG Programs</a></li>
          <li><a href="#">PG Programs</a></li>
          <li><a href="#">Research</a></li>
        </ul>
      </li>
      <li><a href="#">Notifications</a></li>
      
      <li><a href="#">QR code</a> 
        <ul class="dropdown">
          <li><a href="newedit.php">Add Instituition</a></li>
          <li><a href="onlineqr.php">QR Code Generation</a></li>
          <li><a href="dashboard_layout.php">Dash Board</a></li>
          
        </ul>
      </li>
      <li><a href="#">Login</a></li>
    </ul>
  </nav>

</body>
</html>
