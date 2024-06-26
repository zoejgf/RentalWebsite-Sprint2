<?php 

    session_start(); // use current or existing session
    
    // destroy the session
    session_destroy(); 
    /*
    if(isset($_COOKIE['user1']))
            {
            echo 'Thanks for booking with us, '.$_COOKIE['user1'];
            echo ' ! ';
            echo 'Reminder, your delivery is on: '.$_COOKIE['userdate'];
            }
    */
      if(isset($_COOKIE['userdate']))
            {
                $_POST["date"] = $_POST['userdate'];
            
            }
            
            
            if(isset($_COOKIE['userset']))
            {
                $set = $_POST['userset'];
            
            }
?>

<!DOCTYPE html> 
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Walnut Ridge Wedding Rentals - Choose your Set</title>
    
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

            $setStr = "7";   // Dummy value for now, used to re-populate options if returned from pricepackage

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

            if (isset($_GET["set"])) {
                $setStr = $_GET["set"];
                echo "setStr = " . $setStr;
                // setStr can be 0 no set selected, or selected set
                
                if ($setStr == "0") {
                    $setErr = "1";
                    //echo "Setting optionErr<br>";
                }
            } else {
                $setStr = "0";
            }

            if (isset($_GET["message"])) {
                $message = $_GET["message"];
            }

            if (isset($_GET["setMessage"])) {
                $message = $_GET["setMessage"];
            }

        ?>


        <header>
            <!--Responsive Offcanvas Navbar-->
            <nav class="navbar navbar-expand-lg" style="background-color:rgba(187, 181, 181);">
                <a class="navbar-brand"  href="index.html">
                    <img src="walnut-ridge-images/wr-logo.png" alt="Walnut Ridge Rentals" width="220px" height="100px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg" aria-controls="navbarOffcanvasLg">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="navbarOffcanvasLg" aria-labelledby="navbarOffcanvasLgLabel">
                    <div class="offcanvas-header justify-content-end">
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body justify-content-end">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">About Our Service</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Meet the Owners</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Wedding Rentals
                            </a>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="layered-arch.html">Layered Arch</a></li>
                              <li><a class="dropdown-item" href="modern-round.html">Modern Round</a></li>
                              <li><a class="dropdown-item" href="vintage-mirror.html">Vintage Mirror</a></li>
                              <li><a class="dropdown-item" href="dark-walnut.html">Dark Walnut</a></li>
                              <li><a class="dropdown-item" href="rustic-wood.html">Rustic Wood</a></li>
                              <li><a class="dropdown-item" href="extras.html">Extras</a></li>
                            </ul>
                          </li>
                        <li class="nav-item">
                            <a class="nav-link" href="gallery.html">Photo Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="avail" href="checkAvail.php">Check Availability</a>
                        </li>
                    </ul>
                    </div>
                </div>
              </nav>
        </header>

        <!-- Logo Header
        <div class="container text-center">
            <img src="walnut-ridge-images/wr-logo.png" style="width:230px;height:150px; object-fit:contain">
        </div> -->

        <!-- Breadcrumb -->
        <div class="container pt-3">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">                
            <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item visited">
                        <!-- <a href="checkAvail.php"> -->
                            <i class="fa-regular fa-calendar-check" aria-hidden="true"></i>
                        <!-- </a> -->
                        <!-- <a class="is-active crumb" href="checkAvail.php"> -->
                            Check Availability
                        <!-- </a> -->
                    </li>
                    <li class="breadcrumb-item">
                        <a href="pricePackages.php">
                            <i class="fa-solid fa-hand-holding-dollar" aria-hidden="true"></i>
                        </a>
                        <a class="crumb" href="pricePackages.php">
                            Price Packages
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="chooseExtras.php">
                            <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                        </a>
                        <a class="crumb" href="chooseExtras.php">
                            Extras
                        </a>
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
        
    

        <div class="container text-center pt-4">
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
            <!-- <form>
                <div class="col-12 col-md-6 col-lg-4 mx-auto">
                    <label class="form-label">Wedding Date</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div> -->

                <div>
                    <hr class="mx-auto">
                </div>

                <div class="text-center">
                <label class="form-label">Rental Option</label>
                </div>

                <div class="container-fluid">
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
                </div>

                


                <div class="col-12 col-lg-4 mx-auto">
                    <select class="form-select<?php if(isset($setErr) || (isset($message))) echo " is-invalid"; ?>" id="option" name="set">
                        <option value="0" <?php if($setStr == "0") echo "selected"?>>Please select a rental option</option>
                        <option value="1" <?php if($setStr == "1") echo "selected"?>>Layered Arch Wedding Set</option>
                        <option value="2" <?php if($setStr == "2") echo "selected"?>>Modern Round Wedding Set</option>
                        <option value="3" <?php if($setStr == "3") echo "selected"?>>Vintage Mirrors Wedding Set</option>
                        <option value="4" <?php if($setStr == "4") echo "selected"?>>Dark Walnut Wedding Set</option>
                        <option value="5" <?php if($setStr == "5") echo "selected"?>>Rustic Wood Wedding Set</option>
                    </select>
                    <?php if (isset($setErr)) 
                            echo "<div class=\"invalid-feedback\">Please select an option</div>";
                            ?>
                    <?php if (isset($message))
                            echo "<div class=\"invalid-feedback\">$message</div>";
                            ?>
                      
                </div>
                <!-- <div class="col-12 col-lg-4 mx-auto">
                    <select class="form-select" id="option" name="option">
                        <option selected>Please select a rental option</option>
                        <option value="1">Layered Arch Wedding Set</option>
                        <option value="2">Modern Round Wedding Set</option>
                        <option value="3">Vintage Mirrors Wedding Set</option>
                        <option value="4">Rustic Wood Wedding Set</option>
                        <option value="5">Dark Walnut Wedding Set</option>
                    </select>
                </div> -->

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