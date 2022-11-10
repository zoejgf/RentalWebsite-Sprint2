<?php

require "db-access.php";
$results = queryReservations();

while ($row = mysqli_fetch_assoc($result)) {
    $reservationID = $row['reservation_id'];
    $set = $row['set'];
    $package = $row['package'];
    $date = $row['date'];
    $customerID = $row['customer_id'];
    $first = $row['fname'];
    $last = $row['lname'];
    $phone = $row['phone'];
    $email = $row['email'];
    
    echo "<p>$reservationID, $set, $package, $date, $customerID, $first, $last, $phone, $email</p>";
}






?>