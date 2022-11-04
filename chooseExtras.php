<?php
        // DISPLAY CODE ERRORS!
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require __DIR__ . '/pkg-upgrades.php';

        date_default_timezone_set("America/Los_Angeles");   // Set time zone, was printing incorrect current time
        
        // Form Submission from pricePackages.php
        if (count($_POST) > 0) {
            // we have post variables
            // Save date & option for either hidden fields, or redirect on error back to pricePackages.php
            $date = $_POST["date"];    
            $set = $_POST["set"];
            
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
            // Validation error, GET parameters set
            
            
        } else {
            header("Location: checkAvail.php");
        }

        $datearray = explode("-",$date);
        $month = $datearray[1];

        /* 
        Date retrieved to this point, with some keys below.
            $month - selected month for wedding rental
            $date - full date selected by user
            $set - selected option from checkAvail page
            $package - selected package from pricePackages page (listed below)
            
         
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
        <script src="https://kit.fontawesome.com/3cd733d9ed.js" crossorigin="anonymous"></script>        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>    


    </head>
    <body>
        <!------- Logo Header ------>
        <div class="container text-center">
            <img src="walnut-ridge-images/wr-logo.png" style="width:260px;height:110px; object-fit:cover;">
        </div>
        <div class="container text-center">
            <h1>Choose Your Extras</h1>
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
                        <!-- <a class="is-active crumb" href="chooseExtras.php"> -->
                            Extras
                        <!-- </a> -->
                    </li>
                    <li class="breadcrumb-item">
                        <a href="reserve.php">
                            <i class="fa-regular fa-address-card" aria-hidden="true"></i>
                        </a>
                        <a class="crumb" href="reserve.php">
                            Reserve
                        </a>
                    </li>
                </ol>
            </nav>
        </div>
        <!-- end breadcrumb code -->

        <form method="post" action="reserve.php">

            <?php
                //name="checks[]"
                // https://makitweb.com/get-checked-checkboxes-value-with-php/
                if (!empty($_POST['checks'])) {
                    foreach($_POST['checks'] as $CHECK) {
                        // cycle through selected checkboxes, and put into stack of hidden fields
                        echo "<input type=\"hidden\" name=\"checks[]\" value=\"$CHECK\" > ";
                    }
                }
                echo "\n";
                echo "<input type=\"hidden\" name=\"date\" value=\"$date\" >";
                echo "<input type=\"hidden\" name=\"set\" value=\"$set\" >";
                //echo "<input type=\"hidden\" name=\"package\" value=\"$package\" >";

            ?>
            <div class="container text-center">
                <?php if ($month != "2") { // If February, do not show the vintage couch ?>
                <div class="form-check form-check-inline p-3" id="vintageCouch">
                    <input class="form-check-input" type="checkbox" name="extras[]" value="couch" id="vintageCouch">
                    <label class="form-check-label" for="vintageCouch">
                    Vintage Couch
                    <img src="walnut-ridge-images/da-1.jpg" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                    $99 add on
                    </label>
                </div> <?php } ?>
                
                <?php if ($month != "3") { // If March, do not show the jugs ?>
                <div class="form-check form-check-inline p-3" id="antiqueJugs">
                    <input class="form-check-input" type="checkbox" name="extras[]" value="antique" id="antiqueJugs">
                    <label class="form-check-label" for="antiqueJugs">
                    Antique Gallon Jugs
                    <img src="walnut-ridge-images/da-8.jpg" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                    $4 each
                    </label>
                </div>
                <div class="form-check form-check-inline p-3" id="wineJugs">
                    <input class="form-check-input" type="checkbox" name="extras[]" value="wine" id="wineJugs">
                    
                    <label class="form-check-label" for="wineJugs">
                    XL Wine Jugs
                    <img src="walnut-ridge-images/da-4.jpg" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                    $20 each
                    </label>
                </div> <?php } ?>
                <br>
                
                <?php if ($month != "4") { // jars not available in April ?>
                <div class="form-check form-check-inline p-3" id="clearBall">
                    <input class="form-check-input" type="checkbox" name="extras[]" value="clearJars" id="clearBall">
                    <label class="form-check-label" for="clearBall">
                    Clear Antique Ball Jars
                    <img src="walnut-ridge-images/da-7.jpg" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                    $30/50 Jars (Assorted)
                    </label>
                </div>
                <div class="form-check form-check-inline p-3" id="blueBall">
                    <input class="form-check-input" type="checkbox" name="extras[]" value="blueJars" id="blueBall">
                    <label class="form-check-label" for="blueBall">
                    Blue Antique Ball Jars
                    <img src="walnut-ridge-images/da-6.jpg" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                    $30/25 Jars (Assorted)
                    </label>
                </div> <?php } ?>
            </div>

            <?php if ($month != "5") { // delivery not available in May ?>
            <div class="container text-center">
                <div class="form-check form-check-inline p-3" id="delivery">
                    <input type="checkbox" name="extras[]" value="delivery" class="btn-check" id="btn-check" autocomplete="off">
                    <label class="btn btn-primary" for="btn-check">
                        <i class="fa-solid fa-truck-fast" aria-hidden="true"></i>
                        Add Delivery
                    </label>
                </div>
            </div><?php } ?>

            

            <div id="upgradeOffer">

                <?php 

                $upgrades = processPackageUpgrades($set, $package);
                //echo implode(" ", $upgrades);
                // echo $upgrades["name"];
                // echo $upgrades["difference"];
                // echo $upgrades["description"];

                if(count($upgrades) > 0) {
                    ?>
                        <!--html-->
                        <div class="p-2">
                            <hr class="mx-auto">
                        </div>
                        
                        <h2>Your Current Package: </h2>
                        <div class="container text-center">
                        <div class="form-check-inline" id="upgrade1">
                                <input class="form-check-input text-center" type="radio" name="package" id="package" value="<?php echo $package ?>" checked>
                                <label class="form-check-label" for="package">
                    <?php 
                        echo $upgrades["currentPack"];
                    ?>
                        </div>

                        <h3>Upgrade your package: </h3>
                        <div class="container upgradePack text-center">
                            <div class="form-check form-check-inline" id="upgrade1">
                                <input class="form-check-input" type="radio" name="package" id="package" value="<?php echo $upgrades["id"] ?>">
                                <label class="form-check-label" for="package">
                    <?php
                    
                    echo $upgrades["name"]."<br>Additional $".$upgrades["difference"]."<br>".$upgrades["description"];
                    ?>
                                </label>
                            </div>
                        </div>
                    <?php
                    if(isset($upgrades["name1"])) {
                        
                    ?>
                        <div class="container upgradePack text-center">
                            <div class="form-check-inline" id="upgrade2">
                                <input class="form-check-input" type="radio" name="package" id="package" value="<?php echo $upgrades["id"] ?>">
                                <label class="form-check-label" for="package">
                    <?php
                        echo $upgrades["name1"]."<br>Additional $".$upgrades["difference1"]."<br>".$upgrades["description1"];

                    ?>
                                </label>
                            </div>
                        </div>
                    <?php
                        if(isset($upgrades["name2"])) {

                    ?>
                        <div class="container upgradePack text-center">
                            <div class="form-check-inline" id="upgrade3">
                                <input class="form-check-input" type="radio" name="package" id="package" value="<?php echo $upgrades["id"] ?>">
                                <label class="form-check-label" for="package">
                    <?php
                            echo $upgrades["name2"]."<br>Additional $".$upgrades["difference2"]."<br>".$upgrades["description2"];

                    ?>
                                </label>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    
                }
                    
                ?> 
                
            </div>

            <div class="p-2">
                <hr class="mx-auto">
            </div>

            <div class="row mx-auto text-center">
                <div class="col-12">
                    <input type="submit" class="button" value="Submit" style="margin: auto; padding: 0.3em 1em;">
                    <!-- <button type="submit" class="btn btn-primary" value="Send" style="padding: 2px 1em;">Send Request</button> -->
                </div>
            </div>
        </form>
    </body>
</html>