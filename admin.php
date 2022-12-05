<?php
    session_start();
    
    if(isset($_POST['submit_pass']) && $_POST['pass']) {
        $pass=$_POST['pass'];
        if($pass=="password") { 
            $_SESSION['password']=$pass;
        } else {
            $error="Incorrect Password";
        }
    }
    
    if(isset($_POST['page_logout'])) {
        unset($_SESSION['password']);
    }
    
?>

<!DOCTYPE html> 
<html lang="en-US">
    <!--password protected page-->
    
        
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>
    
        <link href="style.css" rel="stylesheet" type="text/css"/>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.typekit.net/kir2pvu.css">
        <script src="https://kit.fontawesome.com/3cd733d9ed.js" crossorigin="anonymous"></script>        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

       <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>    

    </head>
    <body>
        <?php
        if(isset($_SESSION['password']))    // =="password"
        {
            
        ?>
          
          <?php
        
        
         // DISPLAY CODE ERRORS!
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
        require "db-access.php";
        
        // ----------------------------------------------------------------------------------------------- RESERVATION_ID, ADD_NOTE present, ADD NOTE TO RESERVATION
        if (count($_POST) > 0 && (isset($_POST['reservation_id'])) 
                && (isset($_POST['note_text'])) ) { 
        
            
            $reservationID = $_POST['reservation_id'];
        
            addReservationNote($reservationID, $_POST['note_text']);
            
            // Done so that a refresh of the current page does not re-submit the form data (i.e. add a duplicate note)
            echo "<meta http-equiv='refresh' content='0 url=admin.php?reservation_id=$reservationID'>";
            
        }
        
        // ----------------------------------------------------------------------------------------------- RESERVATION_ID present, DISPLAY RESERVATION DETAILS
        if ((count($_GET) > 0 && (isset($_GET['reservation_id'])) || isset($reservationID))) { // DISPLAY RESERVATION DETAILS
        
            // Test, may have been set in posting a NOTE using the POST method
            if (!isset($reservationID)) {
                $reservationID = $_GET['reservation_id'];
            }
            
            $result = reservationDetails($reservationID);

            if ($row = mysqli_fetch_assoc($result)) {
                $reservationID = $row['reservation_id'];
                $set = $row['set'];
                $package = $row['package'];
                $date = $row['date'];
                $status = $row['status'];
                /*
                $fname = $row['fname'];
                $lname = $row['lname'];
                $email = $row['email'];
                $phone = $row['phone'];*/
                
                // DISPLAY RESERVATION DATA
                //echo "Set: " . $set . ", Package: " . $package;
                ?>
                <div class="row w-75 mx-auto">
                    <div class="col-6 ps-0 pt-0">
                        <a href="admin.php">Back to Admin Page</a>
                    </div>  
                </div>
                <div class="container pt-3 text-center">
                    <h3 class="admin">Customer(s) Info: </h3>

                    
                    <?php $customerResults = getCustomersByReservation($reservationID); ?>
                    
                    
                    <?php while ($extrasRow = mysqli_fetch_assoc($customerResults)) { 
                    
                    /*
                        customers.customer_id AS customer_id, 
                        customers.first_name AS fname, 
                        customers.last_name AS lname, 
                        customers.email AS email, 
                        customers.phone AS phone                            
                    */ ?>
                        <div class="text-center">
                            <p class="d-inline"><?php echo $extrasRow['fname'] . " " . $extrasRow['lname']; ?></p>
                            <p class="d-inline"><?php echo $extrasRow['email']; ?></p>
                            <p class="d-inline"><?php echo $extrasRow['phone']; ?></p>
                            <p class="d-inline"><?php echo $extrasRow['relationship']; ?></p>
                        </div>
                        <form method="post" action="addCustomer.php" id="add_customer" style="padding:15px;text-align: center">
                            <input type="submit" name="add_customer" value="Add Customer">
                        </form>
                        
                    <?php } ?>
                    
                </div>
                <hr class="mx-auto">
                <?php
                
                $extrasResult = reservationExtras($reservationID);?>
                
                <h3 class="admin">Reservation Details </h3>
                <?php /* Paul - 12/4, placed inside table to include status
                <div class="container py-3 text-center">
                    <p class="d-inline px-2"><?php echo "$set" ?></p>
                    <p class="d-inline px-2"><?php echo "$package" ?></p>
                    <p class="d-inline px-2" style="border: 1px solid green;"><?php echo "$date" ?></p>
                    <p class="d-inline px-2"><?php echo "$status" ?></p>
                </div>
                */ ?>
                <table class="mx-auto w-75">
                    <tr>
                        <td class=""><?php echo "$set" ?></td>
                        <td class="text-center"><?php echo "$package" ?></td>
                        <td class="text-center"><?php echo "$date" ?></td>
                        <td class="text-end"><a href="reservationStatus.php?reservation_id=<?php echo $reservationID ?>"><?php echo "$status" ?></a></td>
                    </tr>
                </table>
                
                <hr class="mx-auto w-75">
                <h3 class="admin">Extras</h2>
                <?php while ($extrasRow = mysqli_fetch_assoc($extrasResult)) { 
                            $extraName = $extrasRow['extra_name'];
                            ?>
                       <p class=""><?php echo $extraName ?></p>
                        <?php } ?>
                
                
                <hr class="mx-auto w-75">
                
                <div class="mx-auto w-75">
                    <h3 class="admin">Notes </h3>
                </div>
                
                <div id="addNote" class="mt-3 w-75 mx-auto">
                    <form action="admin.php" method="POST">
                        <div class="col-12 col-md-6 mt-3 w-100">
                            <label for="note" class="form-label">Add a Note to Reservation</label>
                            <textarea class="form-control w-100" id="note" name="note_text" rows="5"></textarea>
                            <input type="hidden" name="reservation_id" value="<?php echo $reservationID ?>" >
                            
                        </div>
                        <div class="col-12">
                            <input type="submit" class="mt-3" value="Add Note" style="margin: auto; padding: 0.3em 1em;">
                        </div>
                    </form>
                </div>

                <?php

                $noteResults = getReservationNotes($reservationID);
                
                if (mysqli_num_rows($noteResults) > 0) {
                    
                    ?>
                    <table class="table table-striped mx-auto w-75">
                        <thead>
                            <tr><th>Note Date</th><th>Note</th></tr>
                        </thead>
                        <tbody>
                            <?php             
                            while ($row = mysqli_fetch_assoc($noteResults)) {
                                //$id = $row['id'];
                                ?>
                                <tr><td class="text-nowrap"><?php echo $row['note_date']; ?></td><td><?php echo $row['note_text']; ?></td></tr><?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php } // 121 ?>

                <?php /*
                <div class="container pt-3">
                    <a href="admin.php">
                    <i class="fa-solid fa-backward fa-lg"> Back</i>
                    </a>
                </div> */ ?>
                
           <?php  }
            
            // DISPLAY RESERVATION NOTES
            // $noteResults
            
            // DISPLAY TEXTAREA INPUT FOR ADDITIONAL RESERVATION NOTES
            
        } else {      // -----------------------------------------------------------------------------------  NO RESERVATION_ID PARAMS, DISPLAY RESERVATIONS LIST ASC ORDER
        
    
            $results = queryReservationsAsc();
            
            //     ?>
            <!--//echo "<p>$reservationID, $set, $package, $date, $customerID, $first, $last, $phone, $email</p>";-->
            <table class='table table-striped'>
                <thead>
                    <tr class='text-center'>
                        <th scope='col'>Reservation ID</th>
                        <th scope='col'>Set</th>
                        <th scope='col'>Package</th>
                        <th scope='col'>Date</th>
                        <th scope='col'>Customer ID</th>
                        <th scope='col'>First Name</th>
                        <th scope='col'>Last Name</th>
                        <th scope='col'>Phone Number</th>
                        <th scope='col'>Email</th>
                        <th scope='col'>Status</th>
                        <th scope='col'>Customers</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($results))
                                
                    // reservation.reservation_id AS reservation_id, 
                    
                    // reservation.status AS status,
                    // COUNT(reservation_customers.customer) AS numberCustomers
                    
                    { ?>
                    <tr class='text-center'>
                        <td><a href="admin.php?reservation_id=<?php echo $row['reservation_id']; ?>">ID: <?php echo $row['reservation_id']; ?></a></td>
                        <td><?php echo $row['set']; ?></td>
                        <td><?php echo $row['package']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['customer_id']; ?></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td><?php echo $row['lname']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                            <?php if ($row['status'] == 'confirmed') {
                                echo "<td class=\"text-success\">";
                            } else if ($row['status'] == 'unconfirmed') {
                                echo "<td class=\"text-dark\">";
                            } else if ($row['status'] == 'cancelled') {
                                echo "<td class=\"text-warning\">";
                            } 
                            echo $row['status']; ?>
                        </td>
                        <td><?php echo $row['numberCustomers']; ?></td>
                    </tr>
                    <?php }     // WHILE LOOP ?>
                </tbody>
            </table> 
    
       <?php }              // END RESERVATIONS LIST ?>
       
        
        <?php // Display 'Back to Admin Page' && Logout options ?>
        
        <div class="row w-75 mx-auto mt-5">
            <div class="col-6 ps-0 pt-3">
                <a href="admin.php">Back to Admin Page</a>
            </div>
            <div class="col-6 position-relative">
                <form method="post" action="" id="logout_form" class="text-center p-4">
                <input class="position-absolute top-25 end-0" type="submit" name="page_logout" value="LOGOUT">
                </form>    
            </div>
            
        </div>
        
        <?php
        
        } // END IF-STATEMENT SESSION CONTAINS CORRECT PASSWORD
        else
        { // PRESENT LOGIN PAGE
            ?>
            <form method="post" action="" id="login_form" style="text-align:center">
              <h1>LOGIN TO PROCEED</h1>
              <p>Password: </p>
              <input type="password" name="pass" placeholder="*******">
              <input type="submit" name="submit_pass" value="LOG IN">
             
             </form>
            
            <?php
            
        }
        ?>
        
    </body>
</html>