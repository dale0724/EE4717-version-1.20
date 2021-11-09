<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cinema Home</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
</head>

<body style="margin:0">
<div class="navbar">
        <div class="navbar-container">
            <div class="logo-container">
                <h1 class="logo"><a href="main.php">CENIME</h1>
            </div>
            <div class="menu-container">
                <ul class="menu-list">
                    <li class="menu-list-item"><a href="main.php">HOME</a></li>
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
        <div class="description">
            <?php
            $servername = "localhost";
            $username = "f32ee";
            $password = "f32ee";
            $dbname = "f32ee";
            $movieID = $_POST["MovieID"];
            $timeSlot = $_POST["TimeSlot"];
            $chosedSeats = $_POST["ChosedSeats"];
            $finalPrice = $_POST["FinalPrice"];
            $finalSeats = $_POST["FinalSeats"];
            // echo $movieID."<br>";
            // echo $timeSlot."<br>";
            // echo $chosedSeats."<br>";
            // echo $finlaPrice."<br>";
            // echo $finalSeats."<br>";

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = " SELECT * FROM TimeSlotSeats where MovieID=$movieID AND TimeSlot=\"".$timeSlot."\"";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $timeSeat = mysqli_fetch_assoc($result);
            } else {
                echo "sql error";
            }
            $sql = "SELECT * FROM Movies where MovieID=$movieID";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $movie = mysqli_fetch_assoc($result);
                echo '<div class="login-container">';
                echo '<img src="' . $movie["Poster"] . '"style="width:300px;">';
                echo '<dl>';
                echo '<dt>Name: ' . $movie["MovieName"] . '</dt>';
                echo '<dt>Time: ' . $timeSlot . '</dt>';
                echo '<dt>Hall:' . $timeSeat["Hall"] . '</dt>';
                echo '<dt>Seats: ' . $chosedSeats . '</dt>';
                echo '<dt>Total Price: $' . $finalPrice . '</dt>';
                echo '</dl>';
                echo '</div>';
            } else {
                echo "sql error";
            }
            mysqli_close($conn);
            ?>
            <form class="login-container" method="POST" action="success.php">
                <table style="width:100%">
                    <tr>
                        <th>*Card Holder:</th>
                        <th><input type="text" name="cardName" class="input" id="inputName" size=25 required placeholder="Enter name"></th>
                    </tr>
                    <tr>
                        <th>*Card Number:</th>
                        <th><input type="text" name="cardNum" class="input" id="inputNum" size=25 required placeholder="xxxx-xxxx-xxxx-xxxx"></th>
                    </tr>
                    <tr>
                        <th>*cvc:</th>
                        <th><input type="text" name="cardCvc" class="input" id="inputCvc" size=25 required placeholder="xxx"></th>
                    </tr>
                    <tr>
                        <th>*Card expiry date:</th>
                        <th><input type="month" name="cardExpiry" class="input" id="inputDate"></th>
                    </tr>
                    <tr>
                        <th>*Email:</th>
                        <th><input type="email" name="cardEmail" class="input" id="inputEmail" size=25 require placeholder="usearname@domain.com"></th>
                    </tr>
                </table>
                <input type="hidden" id="MovieID" name="MovieID" value=<?php echo '"'.$movieID.'"';?>>
                <input type="hidden" id="TimeSlot" name="TimeSlot" value=<?php echo '"'.$timeSlot.'"';?>>
                <input type="hidden" id="FinalSeats" name="FinalSeats" value=<?php echo '"'.$finalSeats.'"';?>>
                <input type="hidden" id="FinalPrice" name="FinalPrice" value=<?php echo '"'.$finalPrice.'"';?>>
                <input type="hidden" id="ChosedSeats" name="ChosedSeats" value=<?php echo '"'.$chosedSeats.'"';?>>
                <div class="login-container">
                    <input class="login" type="submit" id="payButton" value="Pay">
                </div>
            </form>
        </div>
        <footer>
            <p>MOVIES, SHOWTIMES, TRAILERS AND MORE!</p><br/ >
            <p>Cenime&copy 2021</p>
        </footer> 
        <script type="text/javascript" src="Validation.js"></script>
    </div>

</body>

</html>