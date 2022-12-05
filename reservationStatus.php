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
        
        if (count($_GET) > 0 && (isset($_GET['reservation_id'])) && (isset($_GET['change_status']))) { // DISPLAY RESERVATION/STATUS DETAILS
            
            // echo "GET, RESRVATION_ID, and CHANGE_STATUS all set";
            
            // Change reservation status
            updateReservationStatus($_GET['reservation_id'], $_GET['change_status']);
           
       } // END IF ISSET-RESERVATION_ID && ISSET-CHANGE_STATUS
       
       if (count($_GET) > 0 && (isset($_GET['reservation_id']))) {
           
           //z echo "GET, RESERVATION_ID set";
           
            $result = reservationDetails($_GET['reservation_id']);

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
            
                <div class="container pt-3 text-center">
                    <h3 class="admin">Customer(s) Info: </h3>

                    
                    <?php $customerResults = getCustomersByReservation($reservationID); ?>
                    
                    
                    <?php while ($extrasRow = mysqli_fetch_assoc($customerResults)) {   ?>
                        <div class="text-center">
                            <p class="d-inline admin"><?php echo $extrasRow['fname'] . " " . $extrasRow['lname']; ?></p>
                            <p class="d-inline admin"><?php echo $extrasRow['email']; ?></p>
                            <p class="d-inline admin"><?php echo $extrasRow['phone']; ?></p>
                            <p class="d-inline admin"><?php echo $extrasRow['relationship']; ?></p>
                        </div>
                        
                    <?php } ?>
                    
                </div>
                <hr class="mx-auto w-75">
                <?php
                
                $extrasResult = reservationExtras($_GET['reservation_id']);?>
                
                <h3 class="admin">Reservation Details </h3>
                
                <table class="mx-auto w-75 mb-4">
                    <tr>
                        <td class=""><?php echo "$set" ?></td>
                        <td class="text-center"><?php echo "$package" ?></td>
                        <td class="text-center"><?php echo "$date" ?></td>
                    </tr>
                </table>
                
                <hr class="mx-auto w-75">
                
                <h3 class="admin pt-2">Change Reservation Status</h3>

                <div class="container py-3 text-center">
                    <p class="px-2 admin">Current Status: <?php echo "$status" ?></p>
                    <?php if ($status != 'unconfirmed') { ?>
                        <p class="p2-5">
                            <a href="reservationStatus.php?reservation_id=<?php echo $_GET['reservation_id'] ?>&change_status=unconfirmed">change status to unconfirmed</a>
                        </p>
                    <?php } 
                    if ($status != 'confirmed') { ?>
                        <p class="ps-5">
                            <a href="reservationStatus.php?reservation_id=<?php echo $_GET['reservation_id'] ?>&change_status=confirmed">change status to confirmed</a>
                        </p>
                    <?php } 
                    if ($status != 'cancelled') { ?>
                    <p class="ps-5">    
                        <a href="reservationStatus.php?reservation_id=<?php echo $_GET['reservation_id'] ?>&change_status=cancelled">change status to cancelled</a>
                    </p>
                    <?php } ?> 
                </div>

        
                <?php // Display 'Back to Admin Page' && Logout options ?>
                <div class="row w-75 mx-auto mt-5">
                    <div class="col-6 ps-0 pt-3">
                        <a href="admin.php?reservation_id=<?php echo $_GET['reservation_id'] ?>">Back to Reservation Details Page</a>
                    </div>
                    <div class="col-6 position-relative">
                        <form method="post" action="" id="logout_form" class="text-center p-4">
                        <input class="position-absolute top-25 end-0" type="submit" name="page_logout" value="LOGOUT">
                        </form>    
                    </div>
                    
                </div>

                <?php /*
                <div class="container pt-3">
                    <a href="admin.php">
                    <i class="fa-solid fa-backward fa-lg"> Back</i>
                    </a>
                </div>
                */ ?>
            
           <?php 
            }   // END mysqli_fetch_assoc line 164
        } // END IF ISSET-RESERVATION_ID
       
       ?>
       
        <?php /*
        
        <form method="post" action="" id="logout_form" class="text-center p-4">
            <input type="submit" name="page_logout" value="LOGOUT">
        </form>
        */ ?>
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
