<?php
    session_start();
        
        if(isset($_POST['submit_pass']) && $_POST['pass']){
            $pass=$_POST['pass'];
            if($pass=="red123")
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
        if($_SESSION['password']=="red123")
        {
            
        ?>
          
          <?php
        
        
         // DISPLAY CODE ERRORS!
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
        require "db-access.php";
        
        if (count($_GET) > 0 && (isset($_GET['reservation_id']))) {
            
            $result = reservationDetails($_GET['reservation_id']);

            if ($row = mysqli_fetch_assoc($result)) {
                $reservationID = $row['reservation_id'];
                $set = $row['set'];
                $package = $row['package'];
                $date = $row['date'];
                $customer_id = $row['customer_id'];
                $fname = $row['fname'];
                $lname = $row['lname'];
                $email = $row['email'];
                $phone = $row['phone'];
                
                // DISPLAY RESERVATION DATA
                //echo "Set: " . $set . ", Package: " . $package;
                ?>
            
                <div class="container pt-3 text-center">
                    <h3>Customer Info: </h3>
                    <p class="d-inline"><?php echo "$fname $lname" ?></p>
                    <p class="d-inline"><?php echo $email?></p>
                    <p class="d-inline"><?php echo $phone ?></p>
                </div>
                <hr class="mx-auto">
                <?php
                
                $extrasResult = reservationExtras($_GET['reservation_id']);?>
                
                <table class='table table-striped'>
                    <thead>
                        <tr class='text-center'>
                            <th scope='col'>Set</th>
                            <th scope='col'>Package</th>
                            <th scope='col'>Date</th>
                            <th scope='col'>Product</th>
                            <th scope='col'>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($extrasRow = mysqli_fetch_assoc($extrasResult)) { 
                            $extraName = $extrasRow['extra_name'];
                            $extraPrice = $extrasRow['extra_price'];?>
                        <tr class='text-center'>
                            <td><?php echo $set; ?></td>
                            <td><?php echo $package; ?></td>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $extraName; ?></td>
                            <td><?php echo $extraPrice; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table> 
                <div class="container pt-3">
                    <a href="admin.php">
                    <i class="fa-solid fa-backward fa-xl"> Back</i>
                    </a>
                </div>
                
                <!--while ($extrasRow = mysqli_fetch_assoc($extrasResult)) {-->
                <!--    $reservationID = $extrasRow['reservation_id'];-->
                <!--    $extraName = $extrasRow['extra_name'];-->
                <!--    $extraPrice = $extrasRow['extra_price'];-->
                    
                <!--    echo "<div class=\"row\">";-->
                <!--    echo "<p>$reservationID, $set, $package, $date, $extraName, $extraPrice</p>";-->
                <!--    echo "</div>";-->
                <!--}-->
           <?php }
            
            // DISPLAY RESERVATION NOTES
            
            
            // DISPLAY TEXTAREA INPUT FOR ADDITIONAL RESERVATION NOTES
            
        } else {
        
                $results = queryReservationsAsc();
                
                // while ($row = mysqli_fetch_assoc($result)) {
                //     $reservationID = $row['reservation_id'];
                //     $set = $row['set'];
                //     $package = $row['package'];
                //     $date = $row['date'];
                //     $customerID = $row['customer_id'];
                //     $first = $row['fname'];
                //     $last = $row['lname'];
                //     $phone = $row['phone'];
                //     $email = $row['email'];
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($results)) { ?>
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
                        </tr>
                        <?php } ?>
                    </tbody>
                </table> 
    
       <?php } ?>
       
        
        
        <form method="post" action="" id="logout_form">
            <input type="submit" name="page_logout" value="LOGOUT">
        </form>
        <?php
        
        }
        else
        {
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