

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
            // DISPLAY CODE ERRORS!
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);

            date_default_timezone_set("America/Los_Angeles");   // Set time zone, was printing incorrect current time
            $dateNow = new DateTime;                            // Create a new DateTime object
            //echo $dateNow->format("Y-m-d") . "<br>";          // Format the DateTime object for printing with given format

            //echo "Todays Date: " . date("Y-m-d") . "<br><br>";  // prints unix timestamp w/ given format, diff from DateTime

            /* 
             * Check for prior values/errors, display if required
             * if 1st visit, and no error, then continue
            */

            $optionStr = "7";   // Dummy value for now, used to re-populate options if returned from pricepackage

            //print_r($_POST);
            //print_r($_GET);
            if (isset($_GET["date"])) { 
                // 0 - no date selected, -1 prior date selected
                $dateStr = $_GET["date"];
                // dateStr can be -1 (prior date), 0 no date selected, or prior selected date
                //echo "date string: $dateStr <br>";

                if ($dateStr == "-1") {
                    $dateErr = "Please select a date after today.";
                } elseif ($dateStr == "0") {
                    $dateErr = "Please select a date.";
                }

            }
            if (isset($_GET["option"])) {
                $optionStr = $_GET["option"];
                // optionStr can be 0 no option selected, or selected option
                //echo "option string: $optionStr <br>";
                if ($optionStr == "0") {
                    $optionErr = "1";
                    //echo "Setting optionErr<br>";
                }
            } else {
                $optionStr = "0";
            }

        ?>

        <!-- Logo Header-->
        <div class="container text-center">
            <img src="walnut-ridge-images/wr-logo.png" style="width:230px;height:150px; object-fit:contain">
        </div>

        <div class="container text-center">
            <h1>Check Availability</h1>
        </div>

        <div>
            <hr class="mx-auto">
        </div>

        <div class="container text-center">
            <form method="post" action="<?php 
                    // echo htmlspecialchars($_SERVER["PHP_SELF"]);
                    echo "pricePackages.php";
                    ?>">
                <div class="col-12 col-md-6 col-lg-4 mx-auto">
                    
                    <label class="form-label">Wedding Date</label>
                        <!-- have dateErr and dateStr.  dateErr only set on error. -->
                    <input type="date" class="form-control<?php if(isset($dateErr)) echo " is-invalid"; ?>" id="date" 
                        name="date" <?php if (isset($dateStr) && (empty($dateErr))) echo("value=\"$dateStr\"")  ?>>

                    <?php if (isset($dateErr)) 
                            echo "<div class=\"invalid-feedback\">$dateErr</div>";
                            ?>
                    
                </div>

                <div>
                    <hr class="mx-auto">
                </div>

                <div class="text-center">
                <label class="form-label">Rental Option</label>
                </div>

                <div class="row">
                    <div class="col">
                        <img src="walnut-ridge-images/la-sign.jpg" style="width:200px;height:200px; object-fit:cover;">
                        <p>Layered Arch</h4>
                    </div>
                    <div class="col">
                        <img src="walnut-ridge-images/mr-4.jpg" style="width:200px;height:200px; object-fit:cover;">
                        <p>Modern Round</p>
                    </div>
                    <div class="col">
                        <img src="walnut-ridge-images/vm-4.jpg" style="width:200px;height:200px; object-fit:cover;">
                        <p>Vintage Mirror</p>
                    </div>
                    <div class="col">
                        <img src="walnut-ridge-images/dw-2.jpg" style="width:200px;height:200px; object-fit:cover;">
                        <p>Dark Walnut</p>
                    </div>
                    <div class="col">
                        <img src="walnut-ridge-images/rw-2.jpg" style="width:200px;height:200px; object-fit:cover;">
                        <p>Rustic Wood</p>
                    </div>
                </div>


                


                <div class="col-12 col-lg-4 mx-auto">
                    <select class="form-select<?php if(isset($optionErr)) echo " is-invalid"; ?>" id="option" name="option">
                        <option value="0" <?php if($optionStr == "0") echo "selected"?>>Please select a rental option</option>
                        <option value="1" <?php if($optionStr == "1") echo "selected"?>>Layered Arch Wedding Set</option>
                        <option value="2" <?php if($optionStr == "2") echo "selected"?>>Modern Round Wedding Set</option>
                        <option value="3" <?php if($optionStr == "3") echo "selected"?>>Vintage Mirrors Wedding Set</option>
                        <option value="5" <?php if($optionStr == "5") echo "selected"?>>Rustic Wood Wedding Set</option>
                        <option value="4" <?php if($optionStr == "4") echo "selected"?>>Dark Walnut Wedding Set</option>
                    </select>
                    <?php if (isset($optionErr)) 
                            echo "<div class=\"invalid-feedback\">Please select an option</div>";
                            ?>
                </div>

                <div>
                    <hr class="mx-auto">
                </div>

                <div class="row mx-auto">
                    <div class="col-12">
                        <input type="submit" class="button" value="Check Availability" style="padding: 0.3em 1em;">
                        <!-- <button type="submit" class="btn btn-primary" value="Send" style="padding: 2px 1em;">Send Request</button> -->
                    </div>
                </div>


            </form>
        </div>

    </body>
</html>