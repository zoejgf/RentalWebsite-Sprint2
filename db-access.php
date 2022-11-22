<?php
    
    // require __DIR__ . '/db.php';      // Dev Version
    require '/home/redgreen/db.php';     // Live Version
    
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
            customers.customer_id AS customer_id, 
            customers.first_name AS fname, 
            customers.last_name AS lname, 
            customers.email AS email, 
            customers.phone AS phone 
        FROM reservation
        INNER JOIN customers ON 
            reservation.reservation_customer = customers.customer_id
        WHERE
            reservation.reservation_id = $reservationID;";
                
        $result = mysqli_query($cnxn, $sql);
        return $result;

        /*
        if ($row = mysqli_fetch_assoc($result)) {
            $reservationID = $row['reservation_id'];
            $set = $row['set'];
            $package = $row['package'];
            $date = $row['date'];
            
            echo "<p>$reservationID, $set, $package, $date</p>";
        } */       
    }
    
    
    function reservationExtras($reservationID) {
        global $cnxn;                       // from imported file db.php
        $sql = "SELECT reservation.reservation_id AS reservation_id, 
            extras.name AS extra_name, extras.price AS extra_price 
        FROM reservation 
            INNER JOIN ordered_extras ON reservation.reservation_id = ordered_extras.reservation_id 
            INNER JOIN extras ON ordered_extras.extras_id = extras.extras_id 
        WHERE reservation.reservation_id = $reservationID;";
                
        $result = mysqli_query($cnxn, $sql);
        return $result;

        /*
        while ($row = mysqli_fetch_assoc($result)) {
            $reservationID = $row['reservation_id'];
            $extraName = $row['extra_name'];
            $extraPrice = $row['extra_price'];
            
            echo "<p>$reservationID, $set, $package, $date, $extraName, $extraPrice</p>";
        } */       
    }

    //reservationDetails(2);   // Test reservationDetails function

    /*
     * Add a Customer to the database given firstname, lastname, email, and phone
     * All values are Strings.  Returns the ID of the customer just added.
     */
    function addCustomer($first, $last, $email, $phone) {
        global $cnxn; 

        $sql = "insert into customers (first_name, last_name, email, phone) 
            values ('$first', '$last', '$email', '$phone')";
        
        $result = mysqli_query($cnxn, $sql);
        
        if ($result) {
            $last_id = mysqli_insert_id($cnxn);
            return $last_id;
        } else {
            return 0;
        }
    }

    //addCustomer('Jane', 'Smith', 'jane@hotmail.com', '555-555-5432');   // Test function addCustomer()

    /*
     * Add a Resrvation to the database given customerID, reservationSet, reservationPackage, and Date
     * returns ID of reservation just created, or 0 on SQL error.
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
        if ($result) {
            $last_id = mysqli_insert_id($cnxn);
            return $last_id;
        } else {
            return 0;
        }
    }

    /*
     * For a given Reservation ID, add the reserved exras for that reservation.
     */
    function addReservationExtras($reservationID, $extras) {
        //insert into ordered_extras (reservation_id, extras_id) values (1,2)
        global $cnxn; 

        foreach ($extras as &$extra) {
            //echo "$extra <br>";
            $sql = "insert into ordered_extras 
            (reservation_id, extras_id) values ($reservationID,$extra)";
        
            $result = mysqli_query($cnxn, $sql);
        }
    }

    /* If a customer exists, return their customer_id, otherwise return 0 */
    function customerExists($fname, $email, $phone) {
        global $cnxn;

        $sql = "SELECT customer_id FROM customers WHERE 
            first_name='$fname' AND (email='$email' OR phone='$phone')";

        $result = mysqli_query($cnxn, $sql);

        //return $result;
        if ($row = mysqli_fetch_assoc($result)) {
            $customer_id = $row['customer_id'];
            return $customer_id;
        }
        
        return 0;
    }

    /*
     * Add a note for a given reservationID reservation
    */
    function addReservationNote($reservationID, $note) {
        $sql = "insert into notes (reservation_id, note_text) values ($reservationID, $note)";
        global $cnxn;
    
        $result = mysqli_query($cnxn, $sql);
    }

    
    /*
     * Adds a note to a given reservation
     */
    function getReservationNotes($reservationID) {
        global $cnxn;                       // from imported file db.php
        $sql = "SELECT id, note_text FROM
            notes WHERE reservation_id = $reservationID";
                
        $result = mysqli_query($cnxn, $sql);
        return $result;

        /*
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $noteText = $row['note_text'];
            
            echo "<p>$id, $noteText</p>";
        } */ 
    }

    
    /*
     * packageAvailable(int packageID, DATE date) 
     * This function returns a bool value on whether there are packages available.
     * It takes in an int id for set/package, and a date to test for.  The set
     * has to be available for 2 days prior and after the event to be considered
     * available.
     */
    function packageAvailable($packageID, $date) {
        global $cnxn;                       // from imported file db.php
        $package = "";
        $avail = 0;

        //echo "packageAvailable(), PackageID: " . $packageID . "<br>";

        switch ($packageID) {
            case 1:
                $package = "Layered Arch Package";
                $avail = 1;     // Note: Layered Arch, Modern Round can only be booked once
                break;
            case 2:
                $package = "Modern Round Package";
                $avail = 1;     // Note: Layered Arch, Modern Round can only be booked once
                break;
            case 3:
                $package = "Vintage Mirror Package";
                $avail = 2;     // Note: Dark Walnut, Rustic Wood and Vintage Mirror sets can be booked twice at the same time    
                break;
            case 4:
                $package = "Dark Walnut Package";
                $avail = 2;     // Note: Dark Walnut, Rustic Wood and Vintage Mirror sets can be booked twice at the same time    
                break;
            case 5:
                $package = "Rustic Wood Package";
                $avail = 2;     // Note: Dark Walnut, Rustic Wood and Vintage Mirror sets can be booked twice at the same time    
                break;
            default:
                return 0;   // incorrect packageID, return 0 availability
        }
        
        $sql = "select count(*) AS count FROM reservation WHERE reservation_set = '$package' AND 
            reservation_date >= ('$date' - INTERVAL 2 DAY) AND reservation_date <= ('$date' + INTERVAL 2 DAY);";
        
        $result = mysqli_query($cnxn, $sql);
        
        if ($row = mysqli_fetch_assoc($result)) {
            if ($row['count']) {
                //echo "packageAvailable(), has " . $avail . " sets, " . $row['count'] . " are being used.<br>";
                $avail = $avail - $row['count'];        // e.g. Rustic Wood w/ 2x packages on offer, and 1 is reserved.  Leaves us with one remaining.
            }
        }
            
        return (boolean)$avail;     // returns true if 1 or more packages avail, false otherwise
    }

    /*
     * Return a list of all extras offered.  The column 'available' holds true or false, indicating whether
     * that extra is available on that date.
     */
    function getExtrasStatus($date) {
        global $cnxn;                       // from imported file db.php

        $sql = "SELECT 
                extras.extras_id AS id, 
                extras.name AS name, 
                extras.price AS price,
                extras.image_url AS url,
                extras.form_value AS form_value,
                extras.form_id AS form_id,
                reservation.reservation_id AS resID,
                reservation.reservation_date AS date,
                0 AS available
            FROM extras
            INNER JOIN ordered_extras ON extras.extras_id = ordered_extras.extras_id
            INNER JOIN reservation ON ordered_extras.reservation_id = reservation.reservation_id
            WHERE 
                reservation.reservation_date >= ('$date' - INTERVAL 2 DAY) AND
                reservation.reservation_date <= ('$date' + INTERVAL 2 DAY)
            UNION 
            SELECT 
                extras.extras_id AS id, 
                extras.name AS name, 
                extras.price AS price,
                extras.image_url AS url,
                extras.form_value AS form_value,
                extras.form_id AS form_id,
                '' AS resID,
                '' AS date,
                1 AS available
            FROM extras
            INNER JOIN ordered_extras ON extras.extras_id = ordered_extras.extras_id
            INNER JOIN reservation ON ordered_extras.reservation_id = reservation.reservation_id
            WHERE extras.extras_id NOT IN (
                SELECT 
                    extras.extras_id
                FROM extras
                INNER JOIN ordered_extras ON extras.extras_id = ordered_extras.extras_id
                INNER JOIN reservation ON ordered_extras.reservation_id = reservation.reservation_id
                WHERE 
                    reservation.reservation_date >= ('$date' - INTERVAL 2 DAY) AND
                    reservation.reservation_date <= ('$date' + INTERVAL 2 DAY)
                )
                
            ORDER BY id;";

        $result = mysqli_query($cnxn, $sql);
        
        return $result;

        /*
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $url = $row['url'];
            $formValue = $row['form_value'];
            $formID = $row['form_id'];
            $resID = $row['resID'];
            $resDate = $row['date'];
            $available = $row['available'];
        } */ 
        
    }


    /*
     * dateAvailability($date)
     * This function returns an associated array of sets and the availability for each on a given date.
     * e.g. $set[1] = 0, indicates there is no availability for set 1 on the given date.
     * e.g. $set[2] = 1, indicates one set is available for the given date
     */
    function dateAvailability($date) {
        global $cnxn;                       // from imported file db.php
                
        $sql = "select reservation_set AS 'set', count(DISTINCT('reservation_set')) AS 'count' FROM reservation WHERE 
            reservation_date >= ('$date' - INTERVAL 2 DAY) AND reservation_date <= ('$date' + INTERVAL 2 DAY) 
            GROUP BY reservation_set";
        
        $result = mysqli_query($cnxn, $sql);

        $setArray = array();
        while ($row = mysqli_fetch_assoc($result)) {

            $set = $row['set'];
            
            // Determine setID returned from DB for this row
            switch ($set) {
                case "Layered Arch Package":
                    $set = 1;
                    break;
                case "Modern Round Package":
                    $set = 2;
                    break;
                case "Vintage Mirror Package":
                    $set = 3;
                    break;
                case "Dark Walnut Package":
                    $set = 4;
                    break;
                case "Rustic Wood Package":
                    $set = 5;
                    break;
            }

            // assign set count to setID in associative array
            $setArray[$set] = $row['count'];
        }

        return $setArray;
    }
    /*
    $result = queryReservationsDesc();
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


            /*
            1 - Layered Arch Packages
                1 - Full Set Rental, $849
                2 - Pick 6 Rental, $749
                3 - Pick 4 Rental, $699

            2 - Modern Round 
                1 - Full Set Rental 799
                2 - Pick 6 Rental 699
                3 - Pick 4 Rental 599
            
            3 - Vintage Mirror
                1 - Platinum Package 849
                2 - Gold Package 799
                3 - Pick 6 649
                4 - Pick 4 599

            4 - Dark Walnut
                1 - Full Set 299
                2 - No Seating 245
                3 - Pick 4 199

            5 - Rustic Wood
                1 - Full Set 299
                2 - No Seating 245
                3 - Pick 4 199
                */
                
    //reservationDetails(6);
    
?>
