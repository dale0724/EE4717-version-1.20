<?php
  session_start();
  
  // store to test if they *were* logged in
  $old_user = $_SESSION['valid_user'];  
  unset($_SESSION['valid_user']);
  session_destroy();
?>
<html>
<head>
    <title>Logout</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
  <div class="navbar">
  <div class="navbar-container">
        <div class="logo-container">
            <h1 class="logo"><a href="home.php">CENIME</h1>
        </div>
        <div class="menu-container">
            <ul class="menu-list">
                <li class="menu-list-item"><a href="home.php">HOME</a></li>
                <li class="menu-list-item"><a href="now-showing.php">NOW SHOWING</a></li>
                <li class="menu-list-item"><a href="upcoming.php">UPCOMING</a></li>
                <div>
                    <form class="searchForm" method="POST" action="search.php">
                        <input type="text" placeholder="Try search morning" id="movieName" name="searchitem" size="45">
                        <button type="submit" id="searchButton" value="Search">SEARCH</button>
                    </form>
                </div>
            </ul>
        </div>
        <div class="profile-container">
            <img class="profile-picture" src="pics/profile.png" alt="">
            <div class="profile-text-container">
                <span class="profile-text"><a href="logIn.html">LOGIN</a></span>
            </div>
        </div>
  </div>
  </div>
  <div class="login-container">
    <h1>Log out</h1>
    <?php 
      if (!empty($old_user))
      {
        echo 'Logged out.<br />';
      }
      else
      {
        // if they weren't logged in but came to this page somehow
        echo 'You were not logged in, and so have not been logged out.<br />'; 
      }
    ?> 
    <a href="logIn.html" style="color:#000;">Back to log in page</a>
  </div>
</body>
</html>