<?php
    session_start();
        
        if(isset($_POST['submit_pass']) && $_POST['pass']){
            $pass=$_POST['pass'];
            if($pass=="password")
            { 
                $_SESSION['password']=$pass;
            }
             else
             {
                $error="Incorrect Password";
             }
        }
        
        if(isset($_POST['page_logout']))
        {
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
        
        if (count($_GET) > 0 && (isset($_GET['reservation_id']))) { // DISPLAY RESERVATION DETAILS
            
            $result = reservationDetails($_GET['reservation_id']);

            if ($row = mysqli_fetch_assoc($result)) {
                $reservationID = $row['reservation_id'];
                $set = $row['set'];
                $package = $row['package'];
                $date = $row['date'];/*
                $fname = $row['fname'];
                $lname = $row['lname'];
                $email = $row['email'];
                $phone = $row['phone'];*/
                
                // DISPLAY RESERVATION DATA
                //echo "Set: " . $set . ", Package: " . $package;
                ?>
            
                <div class="container pt-3 text-center">
                    <h3 class="admin">Customer(s) Info: </h3>

                    <form method="post" action="addCustomer.php" id="add_customer" style="text-align: right">
                        <input type="submit" name="add_customer" value="Add Customer">
                    </form>
                    
                    <?php $customerResults = getCustomersByReservation($reservationID); ?>
                    
                    
                    <table class="table mx-auto">
                    <?php while ($extrasRow = mysqli_fetch_assoc($customerResults)) { 
                    
                    /*
                        customers.customer_id AS customer_id, 
                        customers.first_name AS fname, 
                        customers.last_name AS lname, 
                        customers.email AS email, 
                        customers.phone AS phone                            
                    */ ?>
                    
                        <tr>
                            <td><?php echo $extrasRow['fname'] . " " . $extrasRow['lname']; ?></td>
                            <td><?php echo $extrasRow['email']; ?></td>
                            <td><?php echo $extrasRow['phone']; ?></td>
                            <td><?php echo $extrasRow['relationship']; ?></td>
                        </tr>
                        
                    <?php } ?>
                        
                    </table>
                    
                </div>
                <hr class="mx-auto">
                <?php
                
                $extrasResult = reservationExtras($_GET['reservation_id']);?>
                
                <h3 class="admin">Reservation Details </h3>
                
                <div class="container pt-3 text-center">
                    <p class="d-inline"><?php echo "$set" ?></p>
                    <p class="d-inline"><?php echo "$package" ?></p>
                    <p class="d-inline"><?php echo "$date" ?></p>
                </div>
                
                <table class='table table-striped w-50 mx-auto'>
                    <thead>
                        <tr class='text-center'><?php /*
                            <th scope='col'>Set</th>
                            <th scope='col'>Package</th>
                            <th scope='col'>Date</th> */ ?>
                            <th scope='col'>Product</th>
                            <th scope='col'>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($extrasRow = mysqli_fetch_assoc($extrasResult)) { 
                            $extraName = $extrasRow['extra_name'];
                            $extraPrice = $extrasRow['extra_price'];?>
                        <tr class='text-center'>
                            <td><?php echo $extraName; ?></td>
                            <td><?php echo $extraPrice; ?></td>
                        </tr>
                        <?php } // 104 ?>
                    </tbody>
                </table> 
                
                <h3 class="admin">Notes </h3>

                <?php

                $noteResults = getReservationNotes($reservationID);
                if (mysqli_num_rows($noteResults) > 0) {
                    
                    ?>
                    <table class="table table-striped mx-auto w-50">
                        <thead>
                            <tr><th>Note Date</th><th>Note</th></tr>
                        </thead>
                        <tbody>
                            <?php             
                            while ($row = mysqli_fetch_assoc($noteResults)) {
                                //$id = $row['id'];
                                ?>
                                <tr><td><?php echo $row['note_date']; ?></td><td><?php echo $row['note_text']; ?></td></tr><?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php } // 121 ?>

                <div class="container pt-3">
                    <a href="admin.php">
                    <i class="fa-solid fa-backward fa-xl"> Back</i>
                    </a>
                </div>
                
           <?php  }
            
            // DISPLAY RESERVATION NOTES
            // $noteResults
            
            // DISPLAY TEXTAREA INPUT FOR ADDITIONAL RESERVATION NOTES
            
        } else {            // DISPLAY RESERVATION LIST IN ASCENDING ORDER
        
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
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['numberCustomers']; ?></td>
                        </tr>
                        <?php }     // WHILE LOOP ?>
                    </tbody>
                </table> 
    
       <?php }              // END RESERVATIONS LIST ?>
       
        
        
        <form method="post" action="" id="logout_form">
            <input type="submit" name="page_logout" value="LOGOUT">
        </form>
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