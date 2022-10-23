<?php
        // DISPLAY CODE ERRORS!
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        date_default_timezone_set("America/Los_Angeles");   // Set time zone, was printing incorrect current time
        
        // Form Submission from pricePackages.php
        if (count($_POST) > 0) {
            // we have post variables
            // Save date & option for either hidden fields, or redirect on error back to pricePackages.php
            $date = $_POST["date"];    
            $option = $_POST["option"];
            $package = $_POST["package"];
            /*if (!empty($_POST["checks"]))
                $addOns = $_POST["checks"];*/

            
            // ERROR CHECK - PACKAGE PRESENT?  IF NOT, REDIRECT BACK
            if (!isset($_POST["package"])) {
                header("Location: pricePackages.php?date=$date&option=$option");   // redirect back to pricePackages, date = 1 indicates error
            } else {
                $package = $_POST["package"];
                if ($package == "0") {
                    // did not select a rental option
                   header("Location: pricePackages.php?date=$date&option=$option&package=0");   // redirect back to pricePackages, package = 0 indicates error
                }

                $package = $_POST["package"];
            }

        } else {
            // Houston, we have a problem.
            
            
        }

        $totalPrice = 0;

        /*
         * Add Ons from pricePackages.php
        */
        function returnAddOnText($c) {
            if ($c == "modernSign")
                return "Modern Round Sign";
            if ($c == "smallModernSign")
                return "Small Custom Mirror";
            if ($c == "medModernSign")
                return "Medium Custom Mirror";
            if ($c == "larModernSign")
                return "Large Custom Mirror";
            if ($c == "aisleRunner")
                return "Aisle Runner";
            if ($c == "typeWriter")
                return "Vintage Type Writer";
        }

        function returnAddOnPrice($c) {
            global $totalPrice;

            if ($c == "modernSign")
                $returnPrice = 0;
            if ($c == "smallModernSign")
                $returnPrice = 0;
            if ($c == "medModernSign")
                $returnPrice = 0;
            if ($c == "larModernSign")
                $returnPrice = 0;
            if ($c == "aisleRunner")
                $returnPrice = 99;
            if ($c == "typeWriter")
                $returnPrice = 99;
            
            $totalPrice += $returnPrice;
            return $returnPrice;
        }

    
        // PROCESS PACKAGE PRICES
        if (isset($option) && isset($package)) {
            
            if ($option == "1") {
                $packageName = "Layered Arch Package, ";
                if ($package == "1") {
                    $packageName .= "Full Set Rental";
                    $packagePrice = "849.0";
                } elseif ($package == "2") {
                    $packageName .= "Pick 6 Rental";
                    $packagePrice = "749.0";
                } elseif ($package == "3") {
                    $packageName .= "Pick 4 Rental";
                    $packagePrice = "699.0";
                }
            }
            
            if ($option == "2") {
                $packageName = "Modern Round Package, ";
                if ($package == "1") {
                    $packageName .= "Full Set Rental";
                    $packagePrice = 799.0;
                } elseif ($package == "2") {
                    $packageName .= "Pick 6 Rental";
                    $packagePrice = 699.0;
                } elseif ($package == "3") {
                    $packageName .= "Pick 4 Rental";
                    $packagePrice = 599.0;
                }
            }

            if ($option == "3") {
                $packageName = "Vintage Mirror Package, ";
                if ($package == "1") {
                    $packageName = "Platinum Package";
                    $packagePrice = 849.0;
                } elseif ($package == "2") {
                    $packageName = "Gold Package";
                    $packagePrice = 799.0;
                } elseif ($package == "3") {
                    $packageName = "Pick 6 Package";
                    $packagePrice = 649.0;
                } elseif ($package == "4") {
                    $packageName = "Pick 4 Package";
                    $packagePrice = 599.0;
                }
            }            

            if ($option == "4") {
                $packageName = "Dark Walnut Package, ";
                if ($package == "1") {
                    $packageName = "Full Set Rental";
                    $packagePrice = 299.0;
                } elseif ($package == "2") {
                    $packageName = "No Seating Rental";
                    $packagePrice = 245.0;
                } elseif ($package == "3") {
                    $packageName = "Pick 4 Rental";
                    $packagePrice = 199.0;
                }
            }

            if ($option == "5") {
                $packageName = "Rustic Wood Package, ";
                if ($package == "1") {
                    $packageName = "Full Set";
                    $packagePrice = 299.0;
                } elseif ($package == "2") {
                    $packageName = "No Seating";
                    $packagePrice = 245.0;
                } elseif ($package == "3") {
                    $packageName = "Pick 4";
                    $packagePrice = 199.0;
                }
            }

            $totalPrice += $packagePrice;
        }

        // PROCESS EXTRAS
        // name="extras[]"
        //      values - delivery/?, couch/99, antique/4-ea, wine/20-ea, clearJars/30, blueJars/30
        // select wineJugs, and antiqueJugs with quantity for each
        function returnExtraPrice($e) {
            $returnPrice = 0;
            if ($e == "delivery") {
                $returnPrice = 0;
            }
            if ($e == "couch") {
                $returnPrice = 99;
            }
            if ($e == "antique") {
                $returnPrice = 4; //    return "4 x qty";
            }
            if ($e == "wine") {
                $returnPrice = 20; //    return "20 x qty";
            } 
            if ($e == "clearJars") { 
                $returnPrice = 30;
            }
            if ($e == "blueJars") { 
                $returnPrice = 30;
            }

            global $totalPrice;
            $totalPrice += $returnPrice;
            return $returnPrice;
        }

        function returnExtraName($e) {
            if ($e == "delivery") return "Rental Delivery";
            if ($e == "couch") return "Vintage Couch";
            if ($e == "antique") return "Antique Gallon Jugs (/ea)";
            if ($e == "wine") return "XL Wine Jugs (/ea)";
            if ($e == "clearJars") return "Clear Antique Ball Jars";
            if ($e == "blueJars") return "Blue Antique Ball Jars";
        }
        
        /*
            Pricing - we have 
                checkAvail.php - choose wedding set, no pricing

                pricePackages.php - choose package, sets price.  includes add-ons, listed in checks[] array



        */

/*          // WORKING WITH AN ARRAY OF VALUES IN CHECKS, i.e. checks[0], checks[1], etc....
                if (!empty($_POST['checks'])) {
                    foreach($_POST['checks'] as $CHECK) {
                        // cycle through selected checkboxes, and put into stack of hidden fields
                        echo "<input type=\"hidden\" name=\"checks[]\" value=\"$CHECK\" > ";
                    }
                    echo "\n";
                }
                */
        /* 
        Date retrieved to this point, with some keys below.
            $month - selected month for wedding rental
            $date - full date selected by user
            $option - selected option from checkAvail page
            $package - selected package from pricePackages page (listed below)
            $check[] - add-ons from pricePackages page
            $extras[] - extras selected from chooseExtras.php

         
        Checkboxes and their respective packages (Packages w/ their Extras from pricePackages.php)
            Modern Round - modernRound
            Vintage Mirror - smallModernSign, medModernSign, larModernSign
            Dark Walnut - aisleRunner, typeWriter
            Rustic Wood - aisleRunner, typeWriter
            Use function isset() to check for presence
            stored in array checks[]
     
        From pricePackages.php, package selection possibilities
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
            echo "\$package: $package<br>\$option: $option<br>\$date: $date<br><br>";



        ?>
        <!------- Logo Header ------>
        <div class="container text-center">
            <img src="walnut-ridge-images/wr-logo.png" style="width:230px;height:150px; object-fit:contain">
        </div>

        <!------ Previously selected information will be shown FROM php ------>

        <div class="container" style="width:70%">
            <form class="px-4 mt-3 g-3">
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
                            <div class="col-5 h6"><?php echo "$" . returnExtraPrice($EXTRA); ?></div>
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
                
                <div class="row">
                    <div class="col-6 col-md-6 mt-3">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control" type="text" id="name" name="name">
                    </div>
                
                    <div class="col-6 col-md-6 mt-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input class="form-control" type="tel" id="phone" name="phone">
                    </div>

                    <div class="col-12 mt-3">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" type="email" id="email" name="email">
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