<?php
        // DISPLAY CODE ERRORS!
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        session_start();
        
        // Import separate functions file
        require __DIR__ . '/pkg-mgmt.php';

        date_default_timezone_set("America/Los_Angeles");   // Set time zone, was printing incorrect current time
        
        // Form Submission from pricePackages.php
        if (count($_POST) > 0) {
            // we have post variables
            // Save date & option for either hidden fields, or redirect on error back to pricePackages.php
            $date = $_POST["date"];    
            $set = $_POST["set"];
            $package = $_POST["package"];
            /*if (!empty($_POST["checks"]))
                $addOns = $_POST["checks"];*/

            
            // ERROR CHECK - PACKAGE PRESENT?  IF NOT, REDIRECT BACK
            if (!isset($_POST["package"])) {
                header("Location: pricePackages.php?date=$date&option=$set");   // redirect back to pricePackages, date = 1 indicates error
            } else {
                $package = $_POST["package"];
                if ($package == "0") {
                    // did not select a rental option
                   header("Location: pricePackages.php?date=$date&option=$set&package=0");   // redirect back to pricePackages, package = 0 indicates error
                }

                $package = $_POST["package"];
            }

        } elseif (count($_GET) > 0) {
            // TODO - add error-correcting message-code here, present below.
            //$errorMsg = $_GET['errorMsg'];
            //echo $errorMsg . "<br><br>";
            $date = $_GET['date'];
            $set = $_GET['set'];
            $package = $_GET['package'];
            $fname = $_GET['fname'];
            $lname = $_GET['lname'];
            $email = $_GET['email'];
            $phone = $_GET['phone'];
            /*
             * Form values possibly passed back in associative GET array are
             * fname, lname, email, phone
             */
        } else {
            header("Location: checkAvail.php");
        }

        $totalPrice = 0;
        $packageName = "";
        $packagePrice = 0;
        processPackageNamesPrices($packageName, $packagePrice, $totalPrice, $set, $package);


?>




<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Walnut Ridge Wedding Rentals - Add Contact information</title>
    
        <link href="style.css" rel="stylesheet" type="text/css"/>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://use.typekit.net/kir2pvu.css">
        <script src="https://kit.fontawesome.com/3cd733d9ed.js" crossorigin="anonymous"></script>        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <img src="walnut-ridge-images/wr-logo.png" style="width:260px;height:110px; object-fit:cover;">
        </div>

        <!-- Breadcrumb -->
        <div class="container pt-3">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">                
            <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item visited">
                        <!-- <a href="checkAvail.php"> -->
                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                        <!-- </a> -->
                        <!-- <a class="crumb" href="checkAvail.php"> -->
                            Check Availability
                        <!-- </a> -->
                    </li>
                    <li class="breadcrumb-item visited">
                        <!-- <a href="pricePackages.php"> -->
                            <i class="fa-solid fa-hand-holding-dollar" aria-hidden="true"></i>
                        <!-- </a> -->
                        <!-- <a class="crumb" href="pricePackages.php"> -->
                            Price Packages
                        <!-- </a> -->
                    </li>
                    <li class="breadcrumb-item visited">
                        <!-- <a href="chooseExtras.php"> -->
                            <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                        <!-- </a> -->
                        <!-- <a class="crumb" href="chooseExtras.php"> -->
                            Extras
                        <!-- </a> -->
                    </li>
                    <li class="breadcrumb-item visited">
                        <!-- <a href="reserve.php"> -->
                            <i class="fa-regular fa-address-card" aria-hidden="true"></i>
                        <!-- </a> -->
                        <!-- <a class="is-active crumb" href="reserve.php"> -->
                            Reserve
                        <!-- </a> -->
                    </li>
                </ol>
            </nav>
        </div>
        <!-- end breadcrumb code -->

        <!------ Previously selected information will be shown FROM php ------>

        <div class="container" style="width:70%">

            <form class="px-4 mt-3 g-3" method="post" action="confirm.php">
                <?php // If we have an error message, display
                    if (isset($_GET['errorMsgs'])) {
                        if (!empty($_GET['errorMsgs']))
                        ?>

                <div class="row">
                    <div class="col-12">
                        <div class="text-danger fs-5 text-center">
                            <?php 
                            foreach($_GET['errorMsgs'] AS $msg) {
                            
                            echo $msg . "<br>"; 
                            }
                            ?>

                        </div>
                    </div>
                </div>
                    <?php  }
                ?>
                <?php
                    //name="checks[]"
                    // https://makitweb.com/get-checked-checkboxes-value-with-php/
                    $checks;    // can be from POST or GET (returning w/ error message)
                    if (!empty($_POST['checks'])) {
                        $checks = $_POST['checks'];
                    } else if (!empty($_GET['checks'])) {
                        $checks = $_GET['checks'];
                    }
                    if (!empty($checks)) {
                        foreach($checks as $CHECK) {
                            // cycle through selected checkboxes, and put into stack of hidden fields
                            echo "<input type=\"hidden\" name=\"checks[]\" value=\"$CHECK\" > ";
                        }
                    }

                    // values for extras - delivery/?, couch/99, antique/4-ea, wine/20-ea, clearJars/30, blueJars/30
                    $extras;
                    if (!empty($_POST['extras'])) {
                        $extras = $_POST['extras'];
                    } else if (!empty($_GET['extras'])) {
                        $extras = $_GET['extras'];
                    }
                    if (!empty($extras)) {
                        foreach($extras as $EXTRA) {
                            echo "<input type=\"hidden\" name=\"extras[]\" value=\"$EXTRA\" > ";
                        }
                    }

                    echo "\n";
                    echo "<input type=\"hidden\" name=\"date\" value=\"$date\" >";
                    echo "<input type=\"hidden\" name=\"set\" value=\"$set\" >";
                    echo "<input type=\"hidden\" name=\"package\" value=\"$package\" >";

                ?>

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
                
                <div class="row">
                    <div class="col-6 col-md-6 mt-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input class="form-control" type="text" id="fname" name="fname"
                            <?php if (!empty($fname)) echo "value=\"$fname\""; ?>>
                    </div>

                    <div class="col-6 col-md-6 mt-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input class="form-control" type="text" id="lname" name="lname"
                            <?php if (!empty($lname)) echo "value=\"$lname\""; ?>>
                    </div>
                
                    <div class="col-6 col-md-6 mt-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input class="form-control" type="tel" id="phone" name="phone"
                            <?php if (!empty($phone)) echo "value=\"$phone\""; ?>>
                    </div>

                    <div class="col-12 mt-3">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" type="email" id="email" name="email"
                            <?php if (!empty($email)) echo "value=\"$email\""; ?>>
                    </div>

                </div>

                <div class="row mx-auto text-center">
                    <div class="col-12">
                        <input type="submit" class="button" value="Reserve" style="margin: auto; padding: 0.3em 1em;">
                        <!-- <button type="submit" class="btn btn-primary" value="Send" style="padding: 2px 1em;">Send Request</button> -->
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>