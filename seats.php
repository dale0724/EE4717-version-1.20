<?php
$servername = "localhost";
$username = "f32ee";
$password = "f32ee";
$dbname = "f32ee";
session_start();
if(!isset($_SESSION["valid_user"])){
    header("Location: logIn.html", TRUE, 301);
    exit();
}
$targetTimeSlot = $_POST["TimeSlot"];
$targetMovieID = $_POST["MovieID"];

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT Seats,Price FROM TimeSlotSeats where MovieID=$targetMovieID AND TimeSlot=\"".$targetTimeSlot."\"";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "sql error";
}
mysqli_close($conn);
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Seate</title>
    <link rel="stylesheet" href="seats/seats.css">
</head>

<body>
    <ul class="showcase">
        <li>
            <div class="seat"></div>
            <small>Available</small>
        </li>
        <li>
            <div class="seat selected"></div>
            <small>Choosed</small>
        </li>
        <li>
            <div class="seat occupied"></div>
            <small>Unavailable</small>
        </li>
    </ul>

    <div class="container">
        <div class="screen"></div>
        <div class="row">
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
        </div>

        <div class="row">
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
        </div>

        <div class="row">
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
        </div>

        <div class="row">
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
            <div class="seat"></div>
        </div>
    </div>

    <p class="text">Seats Num: <span id="count">0</span>, Total Price: $<span id="total">0</span>(<?php echo $row["Price"] . '/tickes)'; ?></p>
    <form method="POST" action="payment.php">
        <input type="hidden" id="MovieID" name="MovieID" value=<?php echo '"'.$targetMovieID.'"';?>>
        <input type="hidden" id="TimeSlot" name="TimeSlot" value=<?php echo '"'.$targetTimeSlot.'"';?>>
        <input type="hidden" id="FinalSeats" name="FinalSeats">
        <input type="hidden" id="FinalPrice" name="FinalPrice">
        <input type="hidden" id="ChosedSeats" name="ChosedSeats">
        <input type="submit" value="Confirm">
    </form>
    <script type="text/javascript">
        const container = document.querySelector('.container');
        const seats = document.querySelectorAll('.row .seat');
        const count = document.getElementById('count');
        const total = document.getElementById('total');
        const finalSeats = document.getElementById('FinalSeats');
        const finalPrice = document.getElementById('FinalPrice');
        const chosedSeats = document.getElementById('ChosedSeats');
        var currentSeats;
        var price;
        <?php
        echo "currentSeats=" . $row["Seats"] . ";";
        echo "console.log(currentSeats);";
        echo "price=" . $row["Price"] . ";";
        ?>

        // populateUI();
        init();

        //save selected movie index and price
        function setMovieData(movieIndex, moviePrice) {
            localStorage.setItem('selectedMovieIndex', movieIndex);
            localStorage.setItem('selectedMoviePrice', moviePrice);
        }

        //update total and count
        function updateSelectedCount() {
            const selectedSeats = document.querySelectorAll('.row .seat.selected');
            const seatsIndex = [...selectedSeats].map(seat => [...seats].indexOf(seat));
            seatsIndex.forEach((seat, index) => {
                currentSeats = currentSeats | (1 << seat);
            });
            // localStorage.setItem('selectedSeats', JSON.stringify(seatsIndex));
            const selectedSeatsCount = selectedSeats.length;
            count.innerText = selectedSeatsCount;
            total.innerText = selectedSeatsCount * price;
            finalSeats.value = seatsIndex.map(String).join(",");
            finalPrice.value = selectedSeatsCount * price;
            chosedSeats.value = seatsIndex.map(String).join(",");
            finalSeats.value = currentSeats;
            console.log(dec2bin(currentSeats))
            console.log(finalPrice.value)
            console.log(finalSeats.value)
        }

        function init() {
            if (currentSeats > 0) {
                seats.forEach((seat, index) => {
                    if (currentSeats & (1 << index)) {
                        seat.classList.add('occupied');
                    }
                });
            }

        }

        //get data from local storage & populate UI
        function populateUI() {
            const selectedSeats = JSON.parse(localStorage.getItem('selectedSeats'));

            if (selectedSeats !== null && selectedSeats.length > 0) {
                seats.forEach((seat, index) => {
                    if (selectedSeats.indexOf(index) > -1) {
                        seat.classList.add('selected');
                    }
                });
            }

            const selectedMovieIndex = localStorage.getItem('selectedMovieIndex');

            if (selectedMovieIndex !== null) {
                movieSelect.selectedIndex = selectedMovieIndex;
            }
        }

        //seat click event
        container.addEventListener('click', e => {
            if (e.target.classList.contains('seat') && !e.target.classList.contains('occupied')) {
                e.target.classList.toggle('selected');

                updateSelectedCount();
            }
        });

        function dec2bin(dec) {
            return (dec >>> 0).toString(2);
        }

        //initial count and total set
        updateSelectedCount();
    </script>
</body>

</html>