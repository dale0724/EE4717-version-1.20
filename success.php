<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Template</title>
    <link rel="stylesheet" href="style.css">
</head>

<body style="margin: 0;">
    <div class="navbar">
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
        <div class="description" style="text-align: center;">
            <?php
            $servername = "localhost";
            $dbusername = "f32ee";
            $password = "f32ee";
            $dbname = "f32ee";
            session_start();
            $movieID = $_POST["MovieID"];
            $timeSlot = $_POST["TimeSlot"];
            $chosedSeats = $_POST["ChosedSeats"];
            $finalPrice = $_POST["FinalPrice"];
            $finalSeats = $_POST["FinalSeats"];
            $username = $_SESSION["valid_user"];

            // Create connection
            $conn = mysqli_connect($servername, $dbusername, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT Hall FROM TimeSlotSeats WHERE MovieID=$movieID and TimeSlot='$timeSlot'";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                $hall = $row["Hall"];
            }

            $sql = " INSERT INTO Tickets (TicketID,MovieID,TotalPrice,Seat,TimeSlot,UserName,Hall) VALUES (NULL,$movieID,$finalPrice,'$chosedSeats','$timeSlot','$username',$hall)";
            $result = mysqli_query($conn, $sql);
            if ($result) {
            } else {
                echo "sql error";
            }
            $sql = " UPDATE TimeSlotSeats SET Seats=$finalSeats where MovieID=$movieID AND TimeSlot='$timeSlot'";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo '<h1>Sucess!</h1>';
            } else {
                echo "sql error";
            }
            mysqli_close($conn);
            ?>
        </div>

</body>

</html>