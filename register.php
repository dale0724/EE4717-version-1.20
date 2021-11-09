<html>

<head>
	<title>Log in page</title>
	<link rel="stylesheet" href="style.css" />
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
                            <button type="submit" id="searchButton" value="Search" >SEARCH</button>
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
		<?php // register.php
		include "dbconnect.php";
		$username = $_POST['username'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM Users Where UserName = '$username'";
		//	echo "<br>". $sql. "<br>";
		$result = $dbcnx->query($sql);
		if ($result) {
			echo "Duplicated User Name!<br>";
			echo '<h2><a href="registration.html" style="color:black">Back<a/></h2>';
			exit;
		}
		$password = md5($password);
		// echo $password;
		$sql = "INSERT INTO Users(UserName, UserPassword) VALUES ('$username', '$password')";
		//	echo "<br>". $sql. "<br>";
		$result = $dbcnx->query($sql);
		if (!$result)
			echo "Your query failed.";
		else{
			session_start();
			$_SESSION['valid_user']=$username;
			echo '<h1> Welcome ' . $username . ". You are now registered </h1>";
			echo '<a href="home.php" style="color:#000;"> <h2> Home Page > </h2> </a>';
		}
			
		?>
	</div>

</body>

</html>