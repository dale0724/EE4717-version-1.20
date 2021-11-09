<?php
session_start();
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Movie Design</title>
    <meta charset="UTF-8">
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
                            <select name="TimeSlot">
                                <option value="Morning">Morning</option>
                                <option value="Afternoon">Afternoon</option>
                                <option value="Evening">Evening</option>
                            </select>
                            <button type="submit" id="searchButton" value="Search">SEARCH</button>
                        </form>
                    </div>
                </ul>
            </div>
            <div class="profile-container">
                <?php
                if (isset($_SESSION["valid_user"])) {
                    echo  '<a href="profile.php"><img class="profile-picture" src="pics/profile.png" alt=""></a>';
                }
                ?>
                <div class="profile-text-container">
                    <?php
                    if (isset($_SESSION["valid_user"])) {
                        echo  '<span class="profile-text">' . $_SESSION["valid_user"] . '</span><a href="logout.php">&nbsp&nbsp&nbsp log out </a>';
                    } else {
                        echo '<a href="logIn.html"><span class="profile-text">LOGIN</span></a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="content-container">
            <div class="featured-content" style="background: linear-gradient(to bottom, rgba(0,0,0,0), #151515), url('pics/no-time-to-die.jpg');">
                <h1 class="movie-list-title">Welcome <?php echo $_SESSION["valid_user"] ?> !</h1>
            </div>
            <div class="profile-table-container">
                    <?php
                    $servername = "localhost";
                    $username = "f32ee";
                    $password = "f32ee";
                    $dbname = "f32ee";
                    $userID = $_SESSION["valid_user"];

                    // Create connection
                    $conn = mysqli_connect($servername, $username, $password, $dbname);
                    // Check connection
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    $sql = " SELECT * FROM Tickets where UserName='$userID'";
                    $result = mysqli_query($conn, $sql);
                    if ($result!=false) {
                        echo '<table>';
                        echo '<tr><td>Movie Name</td><td>Time Slot</td><td>Hall</td><td>Seats</td></tr>';
                        // output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            $MovieID = $row["MovieID"];
                            $sql = "SELECT MovieName FROM Movies where MovieID=$MovieID";
                            $nameResult = mysqli_query($conn, $sql);
                            if(mysqli_num_rows($nameResult) > 0){
                                while($nameRow = mysqli_fetch_assoc($nameResult)){
                                    $MovieName = $nameRow["MovieName"];
                                }
                                
                            }
                            else{
                                $MovieName = "sql error";
                            }
                            echo '<tr><td>'.$MovieName.'</td><td>'.$row["TimeSlot"].'</td><td>'.$row["Hall"].'</td><td>'.$row["Seat"].'</td></tr>';
                        }
                        echo "</table>";
                    } else {
                        echo "sql error";
                    }
                    mysqli_close($conn);
                    ?>
            </div>
        </div>
        <hr class="solid">
        <footer>
            <p>MOVIES, SHOWTIMES, TRAILERS AND MORE!</p><br>
            <p>Cenime&copy 2021</p>
        </footer> 
    </div>
</body>

</html>