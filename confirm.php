<?php
        // DISPLAY CODE ERRORS!
        //ini_set('display_errors', 1);
        //ini_set('display_startup_errors', 1);
        //error_reporting(E_ALL);
        
        session_start();
        
        // Was commented out to debug SQL connection issues
        if (isset($_SESSION['confirmed'])) {
        //if (false) {
                        
            ?>
                        
            <!DOCTYPE html>
            <html lang="en-US">
                <head>
                    <meta charset="utf-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1">
            
                    <title>Walnut Ridge Wedding Rentals - Reservation Confirmation</title>
                
                    <link href="style.css" rel="stylesheet" type="text/css"/>
            
                    <!-- Fonts -->
                    <link rel="stylesheet" href="https://use.typekit.net/kir2pvu.css">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            
                <!-- CSS only -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
            
                    <!-- JavaScript Bundle with Popper -->
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>    
            
                </head>
                <body>
            
                    <?php 
                        //echo "\$package: $package<br>\$set: $set<br>\$date: $date<br><br>";
                    ?>
                    <!------- Logo Header ------>
                    <div class="container text-center">
                        <img src="walnut-ridge-images/wr-logo.png" style="width:230px;height:150px; object-fit:contain">
                    </div>
            
                    <!------ Previously selected information will be shown FROM php ------>
            
                    <div class="container" style="width:70%">
                        
                        <div class="row">
                            <class="col-12">
                                <h3>Thank You - Your reservation was previously confirmed.</h3>
                            </class>
                        </div>            
                        
                        <div class="row">
                            <div class="col-12 text-center">
                                <p>Your reservation has been previously confirmed.  To edit your reservation, please 
                                contact us by phone or email.</p>
                                
                                <p>Thank You for your confidence in our service.</p>
                            </div>
                        </div>
                        
                            
                    </div>
                </body>
            </html>
                        
                        
            <?php
            
        } else {
            
            $_SESSION['confirmed'] = true;
            
            // Import separate functions file
            require __DIR__ . '/db-access.php';
            require __DIR__ . '/pkg-mgmt.php';
        
    
            date_default_timezone_set("America/Los_Angeles");   // Set time zone, was printing incorrect current time
            
            
            //  SAVE RESERVATION TO DATABASE ----------------------------------------
            
            
            // Form Submission from pricePackages.php
            if (count($_POST) > 0) {
                // we have post variables
                // Save date & option for either hidden fields, or redirect on error back to pricePackages.php
                $date = $_POST["date"];    
                $set = $_POST["set"];
                $package = $_POST["package"];
                /*if (!empty($_POST["checks"]))
                    $addOns = $_POST["checks"];*/
                //$name = $_POST["name"];
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $email = $_POST["email"];
                $phone = $_POST["phone"];
                
                // ERROR CHECK - Empty Values?
                $error = false;
                $return = "reserve.php?";
                $errorMsgs = array();
                
                if (strlen($fname) < 2) {
                    $error = true;
                    array_push($errorMsgs, "Please include your First Name");
                } 
                $return .= "fname=$fname";
                
                if (strlen($lname) < 2) {
                    $error = true;
                    array_push($errorMsgs, "Please include your Last Name");
                } 
                $return .= "&lname=$lname";
                
                if (strlen($phone) < 10) {
                    $error = true;
                    array_push($errorMsgs, "Please include a valid Phone Number");
                } 
                $return .= "&phone=$phone";
                
                if (strlen($email) < 6) {
                    $error = true;
                    array_push($errorMsgs, "Please include your Email Address");
                } 
                $return .= "&email=$email";
                
                
                // ERROR CHECK - PACKAGE PRESENT?  IF NOT, REDIRECT BACK
                if (!isset($_POST["package"])) {
                    header("Location: pricePackages.php?date=$date&set=$set");   // redirect back to pricePackages, date = 1 indicates error
                } else {
                    $package = $_POST["package"];
                    if ($package == "0") {
                        // did not select a rental option
                       header("Location: pricePackages.php?date=$date&set=$set&package=0");   // redirect back to pricePackages, package = 0 indicates error
                    }
    
                    $package = $_POST["package"];
                }

                
                // We have an error from empty/missing values, add date/set/package, and return
                if ($error) {
                    $return .= "&set=$set";
                    $return .= "&package=$package";
                    $return .= "&date=$date";

                    if (isset($errorMsgs)) {
                        if (!empty($errorMsgs)) {
                            $return .= buildGetArray('errorMsgs', $errorMsgs);
                        }
                    }

                    // include options and extras
                    if (isset($_POST['extras'])) {
                        $return .= buildGetArray('extras', $_POST['extras']);
                    }
                    
                    if (isset($_POST['checks'])) {
                        $return .= buildGetArray('checks', $_POST['checks']);
                    }

                    header("Location: $return");
                    exit;   // ensure we execute no more code after redirect
                            // was populating database w/ erroneous data
                }
    
            }  elseif (count($_GET) > 0) {
                // Not Used
            } else {
                // We have no form data at all, how did we get here
                header("Location: checkAvail.php");
            }
            
            $totalPrice = 0;
    
            // Values passed in by reference, changed within function
            processPackageNamesPrices($packageName, $packagePrice, $totalPrice, $set, $package);
    
            $customerID = customerExists($fname, $email, $phone);
            $names = getSetPackageName($set, $package);
            $relationship = '';     // TODO: Take in customers relationship to the wedding (i.e. Bride, Planner, etc.)
            
            if (!isset($_POST['extras'])) {
                $_POST['extras'] = null;
            }
            
            if($customerID == 0)
            {
                $customerID = addCustomer($fname, $lname, $email, $phone);
                $reservationID = addReservation($customerID, $names['setName'], $names['packageName'], $date, $relationship);
                
                if ($reservationID != 0) {
                    addReservationExtras($reservationID, $_POST['extras']);
                } else {
                    $error = "Internal system error, reservation was not saved.  Please try again, or contact us for help.";
                }
                
            } else {
                $reservationID = addReservation($customerID, $names['setName'], $names['packageName'], $date, $relationship);
                
                if ($reservationID != 0) {
                    addReservationExtras($reservationID, $_POST['extras']);
                } else {
                    $error = "Internal system error, reservation was not saved.  Please try again, or contact us for help.";
                }
            }          
            
            //  SEND CONFIRMATION EMAIL ----------------------------------------------
            
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: <webmaster@example.com>' . "\r\n";
            $headers .= 'Cc: myboss@example.com' . "\r\n";
            $to = $email;
            $subject = "HTML email";
            
            //start email layout
            $addOns = "";
    
            if (!empty($_POST['checks'])) {
                    foreach($_POST['checks'] as $CHECK) {
                $addOns .= returnAddOnText($CHECK) . ", ";
                //$addOns .= returnAddOnPrice($CHECK);
                    } 
            }
        
            // values for extras - delivery/?, couch/99, antique/4-ea, wine/20-ea, clearJars/30, blueJars/30
            if (!empty($_POST['extras'])) {
                foreach($_POST['extras'] as $EXTRA) {
                    $addOns .= returnExtraNameFromID($EXTRA) . ", ";
                    //$addOns .= returnExtraPrice($EXTRA, $totalPrice);
                }
            }
            
            $message = "
            <!DOCTYPE html>
                <body>
                    <table>
                        <tr>
                            <th style='padding:5px;text-align:left;border-bottom:1px solid #ddd;'>Name</th>
                            <td style='padding:5px;border-left:1px solid #ddd;border-bottom:1px solid #ddd;'>$fname $lname</td>
                        </tr>
                        <tr>
                            <th style='padding:5px;text-align:left;border-bottom:1px solid #ddd;'>Phone Number</th>
                            <td style='padding:5px;border-left:1px solid #ddd;border-bottom:1px solid #ddd;'>$phone</td>
                        </tr>
                        <tr>
                            <th style='padding:5px;text-align:left;border-bottom:1px solid #ddd;'>Package Selected</th>
                            <td style='padding:5px;border-left:1px solid #ddd;border-bottom:1px solid #ddd;'>$packageName</td>
                        </tr>
                        <tr>
                            <th style='padding:5px;text-align:left;border-bottom:1px solid #ddd;'>Price</th>
                            <td style='padding:5px;border-left:1px solid #ddd;border-bottom:1px solid #ddd;'>\$$packagePrice</td>
                        </tr>
                        <tr>
                            <th style='padding:5px;text-align:left;border-bottom:1px solid #ddd;'>Email</th>
                            <td style='padding:5px;border-left:1px solid #ddd;border-bottom:1px solid #ddd;'>$email</td>
                        </tr>
                        <tr>
                            <th style='padding:5px;text-align:left;border-bottom:1px solid #ddd;'>Extras:</th>
                            <td style='padding:5px;border-left:1px solid #ddd;border-bottom:1px solid #ddd;'>$addOns</td>
                        </tr>
                    </table>
                </body>
            </html>
            "; //end email layout
            
            //sending email
            mail($to,$subject,$message,$headers);
            
        ?>
        
<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Walnut Ridge Wedding Rentals - Reservation Confirmation</title>
    
        <link href="style.css" rel="stylesheet" type="text/css"/>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.typekit.net/kir2pvu.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>    

    </head>
    <body>

        <?php 
            //echo "\$package: $package<br>\$set: $set<br>\$date: $date<br><br>";
        ?>
        <!------- Logo Header ------>
        <div class="container text-center">
            <img src="walnut-ridge-images/wr-logo.png" style="width:230px;height:150px; object-fit:contain">
        </div>

        <!------ Previously selected information will be shown FROM php ------>
        
        <?php
            if (isset($error) && $error) { ?>
                <div class="container" style="width:70%">
            
            <div class="row">
                <class="col-12">
                    <h3><?php echo $error ?></h3>
                </class>
            </div>
                
        <?php
            } else {        // if-error-else block
        ?>
        <div class="container" style="width:70%">
            
            <div class="row">
                <class="col-12">
                    <h3>Thank You - Your reservation has been confirmed.</h3>
                </class>
            </div>            
            
            <div class="row">
                <div class="col-12 col-sm-6 mt-3 pe-sm-5 text-center text-sm-end text-sm-start ">
                    <span class="fw-bolder">Name:</span> <?php echo $fname . " " . $lname?>        
                </div>
                <div class="col-12 col-sm-6 mt-3 ps-sm-5 text-center text-sm-start ">
                    <span class="fw-bolder">Phone:</span> <?php echo $phone ?>        
                </div>
                <div class="col-12 text-center mt-3">
                <span class="fw-bolder">Email:</span> <?php echo $email ?>        
                </div>
            </div>
            <div class="row">
                <div class="col-5 mt-3 text-end h6">
                    <?php echo "$packageName"; ?>
                </div>
                <div class="col-2"></div>
                <div class="col-5 mt-3 h6">
                    <?php echo "\$" . number_format($packagePrice,2,'.',','); ?>
                </div>
                <?php
                    if (!empty($_POST['checks'])) {
                        foreach($_POST['checks'] as $CHECK) { ?>
                        <div class="col-5 text-end h6"><?php echo returnAddOnText($CHECK)?></div>
                        <div class="col-2"></div>
                        <div class="col-5 h6"><?php echo "$" . number_format(returnAddOnPrice($CHECK), 2, '.', ',') ?></div>
                            <?php
                        } 
                    }
                    // values for extras - delivery/?, couch/99, antique/4-ea, wine/20-ea, clearJars/30, blueJars/30
                    if (!empty($_POST['extras'])) {
                        foreach($_POST['extras'] as $EXTRA) { ?>
                        <div class="col-5 text-end h6"> <?php echo returnExtraNameFromID($EXTRA); ?></div>
                        <div class="col-2"></div>
                        <div class="col-5 h6"><?php echo "$" . number_format(returnExtraPriceByID($EXTRA, $totalPrice),2,'.',','); ?></div>
                        <?php
                        }
                    }
                    ?>
                <div class="col-5 mt-3 text-end h6 fw-bolder">
                    Total Price (extra w/ multiple Jugs): 
                </div>
                <div class="col-2"></div>
                <div class="col-5 mt-3 h6 fw-bolder">
                    <?php echo "\$" . number_format($totalPrice, 2, '.', ','); ?>
                </div>

            </div>
                
        </div>
        
        <?php } // end if-error-else block ?>
    </body>
</html>

<?php } ?>