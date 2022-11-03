<?php
        // DISPLAY CODE ERRORS!
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

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
            $name = $_POST["name"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            
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

        }  elseif (count($_GET) > 0) {
            // Not Used
        } else {
            header("Location: checkAvail.php");
        }

        $totalPrice = 0;

        // Values passed in by reference, changed within function
        processPackageNamesPrices($packageName, $packagePrice, $totalPrice, $set, $package);
$to = "Alferez-Ruiz.Jeconiah@student.greenriver.edu";
$subject = "HTML email";

$message = "<!DOCTYPE html>
<body>
<div>
$name        
$phone         
$email         
$packageName
\$$packagePrice";

        
            if (!empty($_POST['checks'])) {
                foreach($_POST['checks'] as $CHECK) { ?>
            <?php $message .= returnAddOnText($CHECK)?></div>
            <?php $message .= returnAddOnPrice($CHECK)?></div>
                    <?php
                } 
            }
            // values for extras - delivery/?, couch/99, antique/4-ea, wine/20-ea, clearJars/30, blueJars/30
            if (!empty($_POST['extras'])) {
                foreach($_POST['extras'] as $EXTRA) { ?>
                <?php $message .= returnExtraName($EXTRA); ?></div>
                <?php $message .= returnExtraPrice($EXTRA, $totalPrice); ?></div>
                <?php
                }
            }
            ?>
        
        
            <?php $message .= "\$$totalPrice"; ?>
        
    </body>
</html>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@example.com>' . "\r\n";
$headers .= 'Cc: myboss@example.com' . "\r\n";

mail($to,$subject,$message,$headers);

?>




<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title></title>
    
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
                <div class="col-12 col-sm-6 mt-3 pe-sm-5 text-center text-sm-end text-sm-start ">
                    <span class="fw-bolder">Name:</span> <?php echo $name ?>        
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
                    <?php echo "\$$packagePrice"; ?>
                </div>
                <?php
                    if (!empty($_POST['checks'])) {
                        foreach($_POST['checks'] as $CHECK) { ?>
                        <div class="col-5 text-end h6"><?php echo returnAddOnText($CHECK)?></div>
                        <div class="col-2"></div>
                        <div class="col-5 h6"><?php echo "$" . returnAddOnPrice($CHECK)?></div>
                            <?php
                        } 
                    }
                    // values for extras - delivery/?, couch/99, antique/4-ea, wine/20-ea, clearJars/30, blueJars/30
                    if (!empty($_POST['extras'])) {
                        foreach($_POST['extras'] as $EXTRA) { ?>
                        <div class="col-5 text-end h6"> <?php echo returnExtraName($EXTRA); ?></div>
                        <div class="col-2"></div>
                        <div class="col-5 h6"><?php echo "$" . returnExtraPrice($EXTRA, $totalPrice); ?></div>
                        <?php
                        }
                    }
                    ?>
                <div class="col-5 mt-3 text-end h6 fw-bolder">
                    Total Price (extra w/ multiple Jugs): 
                </div>
                <div class="col-2"></div>
                <div class="col-5 mt-3 h6 fw-bolder">
                    <?php echo "\$$totalPrice"; ?>
                </div>

            </div>
                
        </div>
    </body>
</html>