<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Movie</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
</head>

<body style="margin: 0;">
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
            <div class="description-container">
                <?php
                $servername = "localhost";
                $username = "f32ee";
                $password = "f32ee";
                $dbname = "f32ee";
                $target = $_POST["MovieID"];

                // Create connection
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }
                $sql = " SELECT * FROM Movies where MovieID=$target";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    echo '<div class="featured-content" style="background: linear-gradient(to bottom, rgba(0,0,0,0), #151515), url(' . $row["Poster"] . ');filter:blur(8px);">';
                    echo '</div>';
                    echo '<div class="poster">';
                    echo '<h1>' . $row["MovieName"] . '</h1>';
                    echo '<img src="' . $row["Poster"] . '">';
                    echo '</div>';
                    echo '<div class="description">';
                    echo '<dl>';
                    echo '<dt><b>Actors:</b> ' . $row["Actors"] . '</dt>';
                    echo '<dt><b> Directors:</b> ' . $row["Actors"] . '</dt>';
                    echo '<dt><b>Release Time:</b> ' . $row["ReleaseTime"] . '</dt>';
                    echo '<dt><b>Descriptions:</b></dt>';
                    echo '<dd>' . $row["Descriptions"] . '</dd>';
                    echo '</dl>';
                    echo '<hr class="solid">';
                    echo '<div class="trailer">';
                    echo '<h2> Trailer </h2>';
                    echo $row["Trailer"];
                    echo '</div>';
                    echo '<hr class="solid">';
                    echo '</div>';
                } else {
                    echo "sql error";
                }

                $sql = " SELECT TimeSlot from TimeSlotSeats where MovieID=$target";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    echo "sql error";
                }
                if (mysqli_num_rows($result) > 0) {
                    //$timeslot = mysqli_fetch_assoc($result);
                    $timeslot = $result;
                } else {
                    $timeslot = null;
                }
                mysqli_close($conn);
                ?>
                <div class="description">
                    <form id="bookForm" method="POST" action="seats.php">
                        <label for="timeslot">Choose a time:</label>
                        <select id="timeSlot" name="TimeSlot" form="bookForm">
                            <?php
                            if (!$timeslot) {
                                echo "<option>no Time slot</option>";
                            } else {
                                while ($row = mysqli_fetch_assoc($timeslot)) {
                                    echo '<option value="' . $row["TimeSlot"] . '">' . $row["TimeSlot"] . '</option>';
                                }
                                echo '</select>';
                                echo '<input type="hidden" name="MovieID" value="' . $target . '">';
                                echo '<input type="submit" value="Book!">';
                            }
                            ?>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <p>MOVIES, SHOWTIMES, TRAILERS AND MORE!</p><br>
            <p>Cenime&copy 2021</p>
        </footer>
    </div>


</body>

</html>