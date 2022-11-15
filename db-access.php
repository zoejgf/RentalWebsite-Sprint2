<?php
    
    require '/home/redgreen/db.php';     // Live Version
    //require __DIR__ . 'db.php';



    /*
     * This returns an array of rows containing invidual reservations
     */
    function queryReservationsAsc() {
        global $cnxn;                       // from imported file db.php
        $sql = "SELECT reservation.reservation_id AS reservation_id, 
            reservation.reservation_set AS 'set', 
            reservation.reservation_package AS package, 
            reservation.reservation_date AS date, 
            customers.customer_id AS customer_id, 
            customers.first_name AS fname, 
            customers.last_name AS lname, 
            customers.email AS email, 
            customers.phone AS phone 
        FROM reservation 
            INNER JOIN customers ON 
            reservation.reservation_customer = customers.customer_id
            ORDER BY date ASC";
        
        $result = mysqli_query($cnxn, $sql);
        return $result;
        /*
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
        */
    }
    // END SAMPLE QUERY
    
    //  queryReservations();    // Test queryReservations

    function queryReservationsDesc() {
        global $cnxn;                       // from imported file db.php
        $sql = "SELECT reservation.reservation_id AS reservation_id, 
            reservation.reservation_set AS 'set', 
            reservation.reservation_package AS package, 
            reservation.reservation_date AS date, 
            customers.customer_id AS customer_id, 
            customers.first_name AS fname, 
            customers.last_name AS lname, 
            customers.email AS email, 
            customers.phone AS phone 
        FROM reservation 
            INNER JOIN customers ON 
            reservation.reservation_customer = customers.customer_id
            ORDER BY date DESC";
        
        $result = mysqli_query($cnxn, $sql);
        return $result;
        /*
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
        */
    }

    /*
     * This returns an associative array containing reservation details
     */
    function reservationDetails($reservationID) {
        global $cnxn;                       // from imported file db.php
        $sql = "SELECT reservation.reservation_id AS reservation_id, 
                    reservation.reservation_set AS 'set', 
                    reservation.reservation_package AS 'package', 
                    reservation.reservation_date AS 'date', 
                    extras.name AS extra_name, extras.price AS extra_price
            FROM reservation 
                INNER JOIN ordered_extras ON reservation.reservation_id = ordered_extras.reservation_id
                INNER JOIN extras ON ordered_extras.extras_id = extras.extras_id
            WHERE
                reservation.reservation_id = $reservationID;";
                
        $result = mysqli_query($cnxn, $sql);
        return $result;

        /*
        while ($row = mysqli_fetch_assoc($result)) {
            $reservationID = $row['reservation_id'];
            $set = $row['set'];
            $package = $row['package'];
            $date = $row['date'];
            $extraName = $row['extra_name'];
            $extraPrice = $row['extra_price'];
            
            echo "<p>$reservationID, $set, $package, $date, $extraName, $extraPrice</p>";
        } */       
    }

    //reservationDetails(2);   // Test reservationDetails function

    /*
     * Add a Customer to the database given firstname, lastname, email, and phone
     * All values are Strings.
     */
    function addCustomer($first, $last, $email, $phone) {
        global $cnxn; 

        $sql = "insert into customers (first_name, last_name, email, phone) 
            values ('$first', '$last', '$email', '$phone')";
        
        $result = mysqli_query($cnxn, $sql);
    }

    //addCustomer('Jane', 'Smith', 'jane@hotmail.com', '555-555-5432');   // Test function addCustomer()

    /*
     * Add a Resrvation to the database given customerID, reservationSet, reservationPackage, and Date
     */
    function addReservation($customerID, $reservationSet, 
        $reservationPackage, $reservationDate) {
        global $cnxn; 

        $sql = "insert into reservation (reservation_customer, 
            reservation_set, reservation_package, reservation_date)
        values 
            ($customerID, '$reservationSet', 
            '$reservationPackage', '$reservationDate')";
        
        $result = mysqli_query($cnxn, $sql);
    }
    
    // test addReservation
    // addReservation(2, 'Modern Round', 'Full Set Rental', '2023-07-22');
    
    function packageAvailable($packageID, $date) {
        global $cnxn;                       // from imported file db.php
        $sql = "";
                
        $result = mysqli_query($cnxn, $sql);
        
        return $result;        
    }

?>
