
<?php //authmain.php
include "dbconnect.php";
session_start();

if (isset($_POST['username']) && isset($_POST['password']))
{
  // if the user has just tried to log in
  $username = $_POST['username'];
  $password = $_POST['password'];
/*
  $db_conn = new mysqli('localhost', 'webauth', 'webauth', 'auth');
  if (mysqli_connect_errno()) {
   echo 'Connection to database failed:'.mysqli_connect_error();
   exit();
  }
*/
$password = md5($password);
  $query = 'select * from Users '
           ."where UserName='$username' "
           ." and UserPassword='$password'";
// echo "<br>" .$query. "<br>";
  $result = $dbcnx->query($query);
  if ($result->num_rows >0 )
  {
    // if they are in the database register the user id
    $_SESSION['valid_user'] = $username;    
  }
  $dbcnx->close();
}
?>
<html>
<head>
    <title>Movie Design</title>
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
      <?php
        if (isset($_SESSION['valid_user']))
        {
          echo '<h1>You are logged in as: '.$_SESSION['valid_user'].'</h1> <br />';
          echo '<h2><a href="home.php" style="color:#000;">Go to main page ></a></h2><br />';
          echo '<a href="logout.php" style="color:#000;">Log out</a>';
        }
        else
        {
          if (isset($username))
          {
            // if they've tried and failed to log in
            echo 'Could not log you in.<br />';
          }
          else 
          {
            // they have not tried to log in yet or have logged out
            echo 'You are not logged in.<br />';
          }

          // provide form to log in 
          echo '<form method="post" action="logIn.php">';
          echo '<div class="login-container">';
          echo '<h1>LOGIN</h1> <br /><br />';
          echo '<input class ="login" type=text name="username" required placeholder="username"><br /><br />';
          echo '<input class ="login" type=password id="password" name="password" required placeholder="password"><br /><br />';
          echo '<input class ="login" type="submit" value="LOGIN" style="background-color:#4dbf00"> <br /><br />';
          echo '</div></form>';
        }
      ?>
    </div>

<br />
</body>
</html>