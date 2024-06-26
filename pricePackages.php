<?php
        // DISPLAY CODE ERRORS IN DEVELOPMENT!
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        // -----------------------------------
        require './db-access.php';
        require './pkg-mgmt.php';
        //require 'db-access.php';
        //require 'pkg-mgmt.php';
        
        session_start();
        /*
        if(isset($_COOKIE['user1']))
            {
            echo 'Thanks for booking with us, '.$_COOKIE['user1'];
            echo ' ! ';
            echo 'Reminder, your delivery is on: '.$_COOKIE['userdate'];
            }
          */  
        
        $responseText = "";

        date_default_timezone_set("America/Los_Angeles");   // Set time zone, was printing incorrect current time
        $dateNow = new DateTime;                            // Create a new DateTime object
        //echo $dateNow->format("Y-m-d") . "<br>";          // Format the DateTime object for printing with given format

        // POST values indicates form submission from checkAvail.php, 
        // verify values present, and validate if required
        if (count($_POST) > 0) {        // we have post variables 
            
            if (!isset($_POST["date"])) {           // Is a value NOT set for "date", if so, that's an error
                $dateErr = 0;
            } else {
                if (empty($_POST["date"])) {        // if value is set, but empty, that is also an error
                    $dateErr = 0;
                } else {                
                    $date = new DateTime($_POST["date"]);   // current date, used to verify entered date as appropriate
                    $dateStr = $date->format("Y-m-d");      // selected date

                    if ($dateNow >= $date) {        // Is the entered date earlier than required, if so, error
                        $dateErr = -1;              // error code for prior date, -1
                    } 
                }
            }

            if (!isset($_POST["set"])) {         // is a value NOT set for "option", if so, error
                $setErr = "Please select a rental option.";
                $setStr = "0";
            } else {
                if (empty($_POST["set"])) {      // triggers if option not selected from checkAvail.php
                    $setErr = "Please select a rental option.";
                    $setStr = "0";               // set error code
                } else {
                    if ($_POST["set"] == 0) { 
                        $setErr = "Please select a rental option.";
                        $setStr = "0";
                    } else {                        // save previuosly entered value if redirect, re-populate form as required
                        $setStr = $_POST["set"];
                    }
                }
            }

            // IF WE HAVE AN ERROR, MUST REDIRECT BACK TO checkAvail.php
            if ($setStr == "0" || isset($dateErr)) { 
                
                $responseText .= "set=$setStr";

                if (isset($dateErr))
                    $responseText .= "&date=$dateErr";
                else
                    $responseText .= "&date=$dateStr";
                
                //error_log($responseText);

                header("Location: checkAvail.php?$responseText");

            }

            // TODO: We have good data, lets check that this set is available on the given date.
            // IF not, we will have to redirect back to checkAvail
            if (!packageAvailable($setStr, $dateStr)) {
                $responseText = "&date=$dateStr" . "&setMessage=" . getSetName($setStr) . " is not available for the selected date.  Please choose another date or set.";
                //echo "Package " . $setStr . " is NOT available on " . $dateStr . "<br>";
                //echo "responseText: " . $responseText . "<br>";
                header("Location: checkAvail.php?$responseText");
            } 
            // else {
            //     echo "Package " . $setStr . " is available on " . $dateStr;
            // }

            
        // WE HAVE GET VARIABLES INSTEAD, means redirected back from chooseExtras.php w/ errors
        } elseif (count($_GET) > 0) {       
            $setStr = $_GET["option"];
            $dateStr = $_GET["date"];
            $packageErr = $_GET["package"];    // if 0, means we did not select.  error, test below

        } else {
            header("Location: checkAvail.php");
            // echo "We have NO post variables, first visit to page";
            
            $setStr = 0;
        }


        /*
            1 - Layered Arch Packages
            2 - Modern Round 
            3 - Vintage Mirror
            4 - Dark Walnut
            5 - Rustic Wood
        */


        // We are good so far, do we have package availability on this date?  If not, return w/ an error code
        $datearray = explode("-",$dateStr); // parse date month for inventory use
        $month = $datearray[1];             // parse date month for inventory use

       

    ?>

<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Walnut Ridge Wedding Rentals - Choose your Package</title>
    
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

        <!-- Image Header-->
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
                        <!-- <a class="is-active crumb" href="pricePackages.php"> -->
                            Price Packages
                        <!-- </a> -->
                    </li>
                    <li class="breadcrumb-item">
                        <!-- <a href="chooseExtras.php"> -->
                            <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                        <!-- </a> -->
                        <!-- <a class="crumb" href="chooseExtras.php"> -->
                            Extras
                        <!-- </a> -->
                    </li>
                    <li class="breadcrumb-item">
                        <!-- <a href="reserve.php"> -->
                            <i class="fa-regular fa-address-card" aria-hidden="true"></i>
                        <!-- </a> -->
                        <!-- <a class="crumb" href="reserve.php"> -->
                            Reserve
                        <!-- </a> -->
                    </li>
                </ol>
            </nav>
        </div>
        <!-- end breadcrumb code -->

        <div class="container text-center">
            <h1>Select Your Package</h1>
        </div>

        <div>
            <hr class="mx-auto">
        </div>

        <div class="container text-center">


            <div id="layeredArchPriceSelect" <?php if ($setStr == "1") echo "style=\"display: block;\"";?>> <!-- PARENT DIV -->

                <div class="row">
                    <div class="col-12">
                        <h1>LAYERED ARCH RENTAL PACKAGES</h1>
                        <h2>Pricing includes delivery & tear down (30 mile radius of Orrville, OH)</h2>
                        <p>Delivery  & tear down is available beyond the 30 miles for an additional fee.</p>
                    </div>
                </div>
        
                <div class="row">
                    <div class="col-12">
                        <div class="container col-sm-8">
        
                            <h2>Your Dream Package:</h2>
                            <button class="collapsible">FULL SET Rental $849</button>
                            <div class="content">
                                <h2>INCLUDES EACH OF THE FOLLOWING ITEMS</h2>
                                <ul>
                                    <li>Customized welcome sign (choice of trellis half arch or smooth half arch insert up to 25 words text)</li>
                                    <li>3 piece seating chart half arch set (print service for cards is available for a small additional fee)</li>
                                    <li>Table numbers 1-30</li>
                                    <li>Gold Card Terrarium with choice of “Gifts & Cards” sign</li>
                                    <li>5 “Reserved” signs</li>
                                    <li>Up to 2 Double Half Arch Small signs (“Gifts & Cards,” “Take One,” “Don't Mind if I Do,” “In Loving Memory”)</li>
                                    <li>Up to 2 Sunset Small signs (“Please Sign Our Guestbook,” “Gifts & Cards,” “In Loving Memory”)</li>
                                    <li>1 Double Half Arch Medium sign (“Cheers,” “The Bar,” “Guestbook,” or Custom Acrylic Text)</li>
                                    <li>1 Double Full Arch Medium sign (“Signature Drinks,” or Custom Acrylic Text) </li>
                                    <li>Unplugged Ceremony sign</li>
                                    <li>Hairpin Record Player Prop</li>
                                    <li>"Mr & Mrs" Custom Head Table Keepsake is a free gift in addition to the items above</li>
                                </ul>
                            </div>
        
                            <h2>Our 2nd Offer:</h2>
                            <button class="collapsible">PICK 6 Rental $749</button>
                            <div class="content">
                                <h2>CHOOSE FROM 6 OF THE FOLLOWING ITEMS</h2>
                                <ul>
                                    <li>Customized welcome sign (choice of trellis half arch or smooth half arch insert up to 25 words text)</li>
                                    <li>3 piece seating chart half arch set (print service for cards is available for a small additional fee)</li>
                                    <li>Table numbers 1-30</li>
                                    <li>Gold Card Terrarium with choice of “Gifts & Cards” sign</li>
                                    <li>5 “Reserved” signs</li>
                                    <li>Up to 2 Double Half Arch Small signs (“Gifts & Cards,” “Take One,” “Don't Mind if I Do,” “In Loving Memory”)</li>
                                    <li>Up to 2 Sunset Small signs (“Please Sign Our Guestbook,” “Gifts & Cards,” “In Loving Memory”)</li>
                                    <li>1 Double Half Arch Medium sign (“Cheers,” “The Bar,” “Guestbook,” or Custom Acrylic Text)</li>
                                    <li>1 Double Full Arch Medium sign (“Signature Drinks,” or Custom Acrylic Text) </li>
                                    <li>Unplugged Ceremony sign</li>
                                    <li>Hairpin Record Player Prop</li>
                                    <li>"Mr & Mrs" Custom Head Table Keepsake is a free gift in addition to the items above</li>
                                </ul>
                            </div>
        
                            <h2>Our Third Offer:</h2>
                            <button class="collapsible">PICK 4 Rental $699</button>
                            <div class="content">
                                <h2>CHOOSE FROM 4 OF THE FOLLOWING ITEMS</h2>
                                <ul>
                                    <li>Customized welcome sign (choice of trellis half arch or smooth half arch insert up to 25 words text)</li>
                                    <li>3 piece seating chart half arch set (print service for cards is available for a small additional fee)</li>
                                    <li>Table numbers 1-30</li>
                                    <li>Gold Card Terrarium with choice of “Gifts & Cards” sign</li>
                                    <li>5 “Reserved” signs</li>
                                    <li>Up to 2 Double Half Arch Small signs (“Gifts & Cards,” “Take One,” “Don't Mind if I Do,” “In Loving Memory”)</li>
                                    <li>Up to 2 Sunset Small signs (“Please Sign Our Guestbook,” “Gifts & Cards,” “In Loving Memory”)</li>
                                    <li>1 Double Half Arch Medium sign (“Cheers,” “The Bar,” “Guestbook,” or Custom Acrylic Text)</li>
                                    <li>1 Double Full Arch Medium sign (“Signature Drinks,” or Custom Acrylic Text) </li>
                                    <li>Unplugged Ceremony sign</li>
                                    <li>Hairpin Record Player Prop</li>
                                    <li>"Mr & Mrs" Custom Head Table Keepsake is a free gift in addition to the items above</li>
                                </ul>
                            </div>
                    
                        </div>
                    </div>
                    <!--</div>-->

                    
                    <div>
                        <hr class="mx-auto">
                    </div>

                    <form method="post" action="chooseExtras.php">
                        <div class="col-12 col-lg-4 mx-auto">
                            <select class="form-select<?php if(isset($packageErr)) echo " is-invalid"; ?>" id="option" name="package">
                                <option value="0" selected>Please select a rental option</option>
                                <option value="1">Layered Arch Full Set Rental $849</option>
                                <option value="2">Layered Arch Pick 6 Rental $749</option>
                                <option value="3">Layered Arch Pick 4 Rental $699</option>
                            
                            </select>

                            <?php if (isset($packageErr)) 
                            echo "<div class=\"invalid-feedback\">Please select a rental option</div>";
                            ?>

                            <input type="hidden" name="set" value="<?php echo $setStr ?>">
                            <input type="hidden" name="date" value="<?php echo $dateStr ?>">    

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
            </div>
        

            <div id="modernRoundPriceSelect" <?php if ($setStr == "2") echo "style=\"display: block;\"";?>>

                <h1>Modern Round</h1>
                <div class="row">
                    <div class="col-12">
                        <h1>MODERN ROUND RENTAL PACKAGES</h1>
                        <h2>Pricing includes delivery & tear down (30 mile radius of Orrville, OH)</h2>
                        <p>Delivery  & tear down is available beyond the 30 miles for an additional fee.</p>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-12">
                        <div class="container col-sm-8">
            
                            <h2>Your Dream Package:</h2>
                            <button class="collapsible">FULL SET Rental $799</button>
                            <div class="content">
                                <h2>INCLUDES EACH OF THE FOLLOWING ITEMS</h2>
                                <ul>
                                    <li>Large Custom Welcome (round center becomes a keepsake)</li>
                                    <li>Large Magnetic Rectangular (“Find Your Seat”, “Cocktails”, “Let’s Party”, or customize)</li>
                                    <li>Table numbers 1-30</li>
                                    <li>Modern Locking Card Box or Vintage Industrial Typewriter Rental
                                        with custom message to guests (up to 100 words)</li>
                                    <li>Set of “Reserved” signs (5)</li>
                                    <li>2 Selections of Small Square Bracket Signs
                                        (“In Loving Memory”, “Gifts & Cards”, “Take One”, and/or customize)</li>
                                    <li>2 Selections of Small Horizontal Bracket Signs
                                        (“Guestbook”, “Programs”, “Mr. & Mrs”. “Take One”, “Gifts and Cards”,  and/or customize)</li>
                                    <li>1 Medium Table Top  (“Unplugged Ceremony”, or Magnetic Sign with “Cocktails”
                                        heading,  “In Loving Memory” heading or customize.</li>
                                    <li>All Full Set Rental Clients receive 1 SMALL COMPLIMENTARY 3-D CUSTOMIZATION
                                        on a small sign in addition to their Round Welcome Sign Keepsake</li>
                                </ul>
                            </div>
            
                            <h2>Our 2nd Offer:</h2>
                            <button class="collapsible">PICK 6 Rental $699</button>
                            <div class="content">
                                <h2>CHOOSE FROM 6 OF THE FOLLOWING ITEMS</h2>
                                <ul>
                                    <li>Large Custom Welcome (round center becomes a keepsake)</li>
                                    <li>Large Magnetic Rectangular (“Find Your Seat”, “Cocktails”, “Let’s Party”, or customize)</li>
                                    <li>Table numbers 1-30</li>
                                    <li>Modern Locking Card Box or Vintage Industrial Typewriter Rental
                                        with custom message to guests (up to 100 words)</li>
                                    <li>Set of “Reserved” signs (5)</li>
                                    <li>2 Selections of Small Square Bracket Signs
                                        (“In Loving Memory”, “Gifts & Cards”, “Take One”, and/or customize)</li>
                                    <li>2 Selections of Small Horizontal Bracket Signs
                                        (“Guestbook”, “Programs”, “Mr. & Mrs”. “Take One”, “Gifts and Cards”,  and/or customize)</li>
                                    <li>1 Medium Table Top  (“Unplugged Ceremony”, or Magnetic Sign with “Cocktails”
                                        heading,  “In Loving Memory” heading or customize.</li>
                                    <li>All Full Set Rental Clients receive 1 SMALL COMPLIMENTARY 3-D CUSTOMIZATION
                                        on a small sign in addition to their Round Welcome Sign Keepsake</li>
                                </ul>
                            </div>
            
                            <h2>Our Third Offer:</h2>
                            <button class="collapsible">PICK 4 Rental $599</button>
                            <div class="content">
                                <h2>CHOOSE FROM 4 OF THE FOLLOWING ITEMS</h2>
                                <ul>
                                    <li>Large Custom Welcome (round center becomes a keepsake)</li>
                                    <li>Large Magnetic Rectangular (“Find Your Seat”, “Cocktails”, “Let’s Party”, or customize)</li>
                                    <li>Table numbers 1-30</li>
                                    <li>Modern Locking Card Box or Vintage Industrial Typewriter Rental
                                        with custom message to guests (up to 100 words)</li>
                                    <li>Set of “Reserved” signs (5)</li>
                                    <li>2 Selections of Small Square Bracket Signs
                                        (“In Loving Memory”, “Gifts & Cards”, “Take One”, and/or customize)</li>
                                    <li>2 Selections of Small Horizontal Bracket Signs
                                        (“Guestbook”, “Programs”, “Mr. & Mrs”. “Take One”, “Gifts and Cards”,  and/or customize)</li>
                                    <li>1 Medium Table Top  (“Unplugged Ceremony”, or Magnetic Sign with “Cocktails”
                                        heading,  “In Loving Memory” heading or customize.</li>
                                    <li>All Full Set Rental Clients receive 1 SMALL COMPLIMENTARY 3-D CUSTOMIZATION
                                        on a small sign in addition to their Round Welcome Sign Keepsake</li>
                                </ul>
                            </div>
            
                            <h2>EXTRAS:</h2>
                            <button class="collapsible">A’ la Carte Modern Round Welcome Sign Rental $275 </button>
                            <div class="content">
                                <h2>A’ la Carte Modern Round Welcome Sign</h2>
                                <ul>
                                    <li>ncludes design fee and round center keepsake.
                                        This price does not include delivery. ($500 minimum order for delivery.)</li>
                                </ul>
                                <p>NOTE:  Welcome Sign Customization is included in all package pricing.
                                    Additional Customization of Magnetic Headings or entire pieces will
                                    be subject to added design and supply fees. </p>
                            </div>
            
                        </div>
                    </div>
                </div>
            
                <div>
                    <hr class="mx-auto">
                </div>

                <form method="post" action="chooseExtras.php">
                    <div class="col-12 col-lg-4 mx-auto">
                        <select class="form-select<?php if(isset($packageErr)) echo " is-invalid"; ?>" id="option" name="package">
                            <option value="0" selected>Please select a rental option</option>
                            <option value="1">Full Set Rental $799</option>
                            <option value="2">Pick 6 Rental $699</option>
                            <option value="3">Pick 4 Rental $599</option>
                        
                        </select>

                        <?php if (isset($packageErr)) 
                            echo "<div class=\"invalid-feedback\">Please select a rental option</div>";
                            ?>

                        <input type="hidden" name="set" value="<?php echo $setStr ?>">
                        <input type="hidden" name="date" value="<?php echo $dateStr ?>">    

                    </div>

                    <div class="form-check form-check-inline p-3" id="extrasCheck">
                        <input class="form-check-input" type="checkbox"  name="checks[]" id="modernSign" value="modernSign">
                        <label class="form-check-label" for="modernRound">
                          Include the Modern Round Sign
                          <img src="walnut-ridge-images/IMG_7338.jpg" alt="round sign display" style="width:200px;height:250px;object-fit:cover;padding:15px 0 15px 0;"">
                        </label>
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

            <!--Next package-->


            <div id="vintageMirrorPriceSelect" <?php if ($setStr == "3") echo "style=\"display: block;\"";?>>

                <h1>Vintage Mirror</h1>
                <div class="row">
                    <div class="col-12">
                        <div class="container col-sm-8">
        
                            <h2>Package 1:</h2>
                            <button class="collapsible">Vintage Mirror Platinum Package Rental $849</button>
                            <div class="content">
                                <h2>PRICING INCLUDES DELIVERY AND TEARDOWN WITHIN A 30 MILE RADIUS OF ORRVILLE, OH
                                    INCLUDES ALL OF THE FOLLOWING 11 ITEMS</h2>
                                <ul>
                                    <li>Welcome Sign with custom names & date & large wrought iron easel</li>
                                    <li>Antique Typewriter Rental with customized message (100 words or less)</li>
                                    <li>Choice of Linen Seating Chart Stringer or Large Custom Mirror for gold seal application</li>
                                    <li>Gold Card Terrarium with choice of “Gifts & Cards” sign</li>
                                    <li>Table Numbers 1-30</li>
                                    <li>Leather Domed Trunk with “cards” mirror with stand</li>
                                    <li>Up to 2 Sunset Small signs (“Please Sign Our Guestbook,” “Gifts & Cards,” “In Loving Memory”)</li>
                                    <li>“Enjoy the Moment- no photography please” mirror with stand</li>
                                    <li>“Guestbook” mirror with stand </li>
                                    <li> “Take One” small vanity mirror</li>
                                    <li>1 Large Full Custom Mirror (50 words or less) with large wrought iron easel</li>
                                    <li>1 Medium Full Custom Mirror (20 words or less)  with large wrought iron easel</li>
                                    <li>1 Small Custom Mirror (10 words or less) with wrought iron easel</li>
                                </ul>
                            </div>
        
                            <h2>Package 2:</h2>
                            <button class="collapsible">Vintage Mirror Gold Package Rental $799</button>
                            <div class="content">
                                <h2>PRICING INCLUDES DELIVERY AND TEARDOWN WITH A 30 MILE RADIUS OF ORRVILLE, OH.
                                    INCLUDES ALL THE FOLLOWING 8 ITEMS</h2>
                                <ul>
                                    <li>Welcome Sign with custom names & date & large wrought iron easel</li>
                                    <li>Antique Typewriter Rental with customized message (100 words or less)</li>
                                    <li>Table numbers 1-30</li>
                                    <li>Choice of Linen Seating Chart Stringer or Large Custom Mirror for gold seal application</li>
                                    <li>Leather Domed Trunk with “cards” mirror with stand</li>
                                    <li>“Enjoy the Moment- no photography please” mirror with stand</li>
                                    <li>“Guestbook” mirror with stand</li>
                                    <li>“Take One” small vanity mirror</li>
                                </ul>
                            </div>
        
                            <h2>Package 3:</h2>
                            <button class="collapsible">Vintage Mirror Pick 6 Rental Package $649</button>
                            <div class="content">
                                <h2>PRICING INCLUDES DELIVERY AND TEARDOWN WITH A 30 MILE RADIUS OF ORRVILLE, OH.
                                    INCLUDES ALL THE FOLLOWING 8 ITEMS</h2>
                                <ul>
                                    <li>Welcome Sign with custom names & date & large wrought iron easel</li>
                                    <li>Antique Typewriter Rental with customized message (100 words or less)</li>
                                    <li>Table numbers 1-30</li>
                                    <li>Pair of 2 Linen Stringers with wrought iron easels </li>
                                    <li>Large Custom Mirror for gold seal application</li>
                                    <li>Leather Domed Trunk with “cards” mirror with stand</li>
                                    <li>“Enjoy the Moment- no photography please” mirror with stand</li>
                                    <li>“Guestbook” mirror with stand</li>
                                    <li>“Take One” small vanity mirror</li>
                                </ul>
                            </div>
        
                            <h2>Package 4:</h2>
                            <button class="collapsible">Vintage Mirror Pick 4 Rental Package $599</button>
                            <div class="content">
                                <h2>PRICING INCLUDES DELIVERY AND TEARDOWN WITH A 30 MILE RADIUS OF ORRVILLE, OH.
                                    CHOOSE 4 OF THE FOLLOWING ITEMS…</h2>
                                <ul>
                                    <li>Welcome Sign with custom names & date & large wrought iron easel</li>
                                    <li>Antique Typewriter Rental with customized message (100 words or less)</li>
                                    <li>Table numbers 1-30</li>
                                    <li>Pair of 2 Linen Stringers with wrought iron easels </li>
                                    <li>Large Custom Mirror for gold seal application</li>
                                    <li>Leather Domed Trunk with “cards” mirror with stand</li>
                                    <li>“Enjoy the Moment- no photography please” mirror with stand</li>
                                    <li>“Guestbook” mirror with stand</li>
                                    <li>“Take One” small vanity mirror</li>
                                </ul>
                            </div>
        
                            <h2>Additional Custom Mirrors</h2>
                            <button class="collapsible"></button>
                            <div class="content">
                                <ul>
                                    <li>SMALL (up to 12 words) $40</li>
                                    <li>MEDIUM (up to 24 words) $60</li>
                                    <li>LARGE (up to 60 words) $80 </li>
                                    <li>More words may be added depending on the design.  Additional words may require an additional fee.</li>
        
                                </ul>
                            </div>
        
                        </div>
                    </div>
                </div>
                <div>
                    <hr class="mx-auto">
                </div>

                <form method="post" action="chooseExtras.php">
                    <div class="col-12 col-lg-4 mx-auto">
                        <select class="form-select<?php if(isset($packageErr)) echo " is-invalid"; ?>" id="option" name="package">
                            <option value="0" selected>Please select a rental option</option>
                            <option value="1">Vintage Mirror Platinum Package Rental $849</option>
                            <option value="2">Vintage Mirror Gold Package Rental $799</option>
                            <option value="3">Vintage Mirror Pick 6 Rental $649</option>
                            <option value="4">Vintage Mirror Pick 4 Rental $599</option>
                        
                        </select>

                        <?php if (isset($packageErr)) 
                            echo "<div class=\"invalid-feedback\">Please select a rental option</div>";
                            ?>

                        <input type="hidden" name="set" value="<?php echo $setStr ?>">
                        <input type="hidden" name="date" value="<?php echo $dateStr ?>">    

                    </div>

                    <div class="container text-center">
                        <div class="form-check form-check-inline p-3" id="extrasCheck">
                            <input class="form-check-input" type="checkbox"  name="checks[]" value="smallModernSign" id="smallModernSign">
                            <label class="form-check-label" for="smallModernSign">
                              Include Small Custom Mirror
                              <img src="walnut-ridge-images\_DSC0713.jpeg" alt="small custom sign display" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                            at $40.00
                            </label>
                        </div>
    
                        <div class="form-check form-check-inline p-3" id="extrasCheck">
                            <input class="form-check-input" type="checkbox"  name="checks[]" value="medModernSign" id="medModernSign">
                            <label class="form-check-label" for="medModernSign">
                              Medium Custom Mirror
                              <img src="walnut-ridge-images\_DSC0762.jpeg" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                              additional $60
                            </label>
                        </div>

                        <div class="form-check form-check-inline p-3" id="extrasCheck">
                            <input class="form-check-input" type="checkbox"  name="checks[]" value="larModernSign" id="larModernSign">
                            <label class="form-check-label" for="larModernSign">
                              Include Large Custom Mirror
                              <img src="walnut-ridge-images\_DSC0676.jpeg" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                              at $80
                            </label>
                        </div>
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

            <!--Next package-->

            <div id="darkWalnutPriceSelect" <?php if ($setStr == "4") echo "style=\"display: block;\"";?>>

                <div class="row">
                    <h1>Dark Walnut</h1>
                    <div class="col-12">
                        <div class="container col-sm-8">
        
                            <h2>Package 1:</h2>
                            <button class="collapsible">Dark-Walnut Full set $299</button>
                            <div class="content">
                                <ul>
                                    <li>“Welcome to Our Beginning” Round (24” diameter, with easel) or Rectangular (35.5” x 21” with easel)</li>
                                    <li>“Find your Seat”  (35.5” x 21” organizer with 30 clips & easel) </li>
                                    <li>Table Numbers, double-sided (Numbers 1-30, 3.5” x 9”)</li>
                                    <li>Antique Jug with “Honeymoon Fund” (jug & mini-hanger, 4.75” x 10”) (2pc)</li>
                                    <li>“Mr. & Mrs.” Head Table Sign with small easel 7.25” x 22.5”</li>
                                    <li>“We know that you would be here today if Heaven weren’t so far away”  (10” x 10.5” memorial sign or seat saver with small easel)</li>
                                    <li>“Here comes the Bride” ring bearer carrier  (10.25” x 17.25” with cord)</li>
                                    <li>“Better” & “Together” Chair Hangers (with cord 10.25” x 17.25”) (2pc)</li>
                                    <li>“Please Sign our Guestbook” (self standing 7.25” x 16”) </li>
                                    <li> “Just Married” & “Thank You” (reversible photo-shoot prop 7.25” x 31”)</li>
                                    <li>“Take One” (7.25” x 7.25”)</li>
                                    <li>“Programs” (7.25” x 16”)</li>
                                    <li>“Enjoy the Moment, no photography please” 10.5” x 17” with small easel</li>
                                    <li>8 Reserved signs (3.5” x 12”  4 with cord hanger option) (8pc)</li>
                                    <li>Antique Leather and Wooden Trunk with “Cards” Banner</li>
                                </ul>
                            </div>
        
                            <h2>Package 2:</h2>
                            <button class="collapsible">Dark-Walnut "No Seating" Rental $245</button>
                            <div class="content">
                                <ul>
                                    <li>“Welcome to Our Beginning” Round (24” diameter, with easel) or Rectangular (35.5” x 21” with easel)</li>
                                    <li>Antique Jug with “Honeymoon Fund” (jug & mini-hanger, 4.75” x 10”) (2pc)</li>
                                    <li>“Mr. & Mrs.” Head Table Sign with small easel 7.25” x 22.5”</li>
                                    <li>“We know that you would be here today if Heaven weren’t so far away”  (10” x 10.5” memorial sign or seat saver with small easel)</li>
                                    <li>“Here comes the Bride” ring bearer carrier  (10.25” x 17.25” with cord)</li>
                                    <li>“Better” & “Together” Chair Hangers (with cord 10.25” x 17.25”) (2pc)</li>
                                    <li>“Please Sign our Guestbook” (self standing 7.25” x 16”) </li>
                                    <li> “Just Married” & “Thank You” (reversible photo-shoot prop 7.25” x 31”)</li>
                                    <li>“Take One” (7.25” x 7.25”)</li>
                                    <li>“Programs” (7.25” x 16”)</li>
                                    <li>“Enjoy the Moment, no photography please” 10.5” x 17” with small easel</li>
                                    <li>8 Reserved signs (3.5” x 12”  4 with cord hanger option) (8pc)</li>
                                    <li>Antique Leather and Wooden Trunk with “Cards” Banner</li>
                                </ul>
                            </div>
        
                            <h2>Package 3:</h2>
                            <button class="collapsible">Dark-Walnut You Pick 4 Rental Package $199</button>
                            <div class="content">
                                <ul>
                                    <li>“Welcome to Our Beginning” Round (24” diameter, with easel) or Rectangular (35.5” x 21” with easel)</li>
                                    <li>“Find your Seat”  (35.5” x 21” organizer with 30 clips & easel) </li>
                                    <li>Table Numbers, double-sided (Numbers 1-30, 3.5” x 9”)</li>
                                    <li>Antique Jug with “Honeymoon Fund” (jug & mini-hanger, 4.75” x 10”) (2pc)</li>
                                    <li>“Mr. & Mrs.” Head Table Sign with small easel 7.25” x 22.5”</li>
                                    <li>“We know that you would be here today if Heaven weren’t so far away”  (10” x 10.5” memorial sign or seat saver with small easel)</li>
                                    <li>“Here comes the Bride” ring bearer carrier  (10.25” x 17.25” with cord)</li>
                                    <li>“Better” & “Together” Chair Hangers (with cord 10.25” x 17.25”) (2pc)</li>
                                    <li>“Please Sign our Guestbook” (self standing 7.25” x 16”) </li>
                                    <li> “Just Married” & “Thank You” (reversible photo-shoot prop 7.25” x 31”)</li>
                                    <li>“Take One” (7.25” x 7.25”)</li>
                                    <li>“Programs” (7.25” x 16”)</li>
                                    <li>“Enjoy the Moment, no photography please” 10.5” x 17” with small easel</li>
                                    <li>8 Reserved signs (3.5” x 12”  4 with cord hanger option) (8pc)</li>
                                    <li>Antique Leather and Wooden Trunk with “Cards” Banner</li>
                                </ul>
                            </div>
        
                        </div>
                    </div>
                </div>
                <div>
                    <hr class="mx-auto">
                </div>

                <form method="post" action="chooseExtras.php">
                    <div class="col-12 col-lg-4 mx-auto">
                        <select class="form-select<?php if(isset($packageErr)) echo " is-invalid"; ?>" id="option" name="package">
                            <option value="0" selected>Please select a rental option</option>
                            <option value="1">Dark-Walnut Full set $299</option>
                            <option value="2">Dark-Walnut "No Seating" Set $245/option>
                            <option value="3">Dark-Walnut Pick 4 Rental $199</option>
                
                        </select>

                        <?php if (isset($packageErr)) 
                            echo "<div class=\"invalid-feedback\">Please select a rental option</div>";
                            ?>

                        <input type="hidden" name="set" value="<?php echo $setStr ?>">
                        <input type="hidden" name="date" value="<?php echo $dateStr ?>">    

                    </div>

                    <div class="container text-center">
                        <div class="form-check form-check-inline p-3" id="extrasCheck">
                            <input class="form-check-input" type="checkbox"  name="checks[]" value="aisleRunner" id="aisleRunner">
                            <label class="form-check-label" for="aisleRunner">
                                Include Aisle Runner Add-On
                              <img src="walnut-ridge-images\DSC_3378.NEF.jpg" alt="small custom sign display" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                            $99 extra
                            </label>
                        </div>
    
                        <div class="form-check form-check-inline p-3" id="extrasCheck">
                            <input class="form-check-input" type="checkbox"  name="checks[]" value="typeWriter" id="typeWriter">
                            <label class="form-check-label" for="typeWriter">
                                Include Vintage Typewriter
                              <img src="walnut-ridge-images\Donnie+Rosie+Photo+1-9647.jpg" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                            $99 extra
                            </label>
                        </div>
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


            <div id="rusticWoodPriceSelect" <?php if ($setStr == "5") echo "style=\"display: block;\"";?>>

                <div class="row">
                
                    <h1>Rustic Wood</h1>
                    <div class="col-12">
                        <div class="container col-sm-8">
        
                            <h2>Package 1:</h2>
                            <button class="collapsible">Rustic Wood Full set $299</button>
                            <div class="content">
                                <ul>
                                    <li>“Welcome to Our Beginning” Round (24” diameter, with easel) or Rectangular (35.5” x 21” with easel)</li>
                                    <li>“Find your Seat”  (35.5” x 21” organizer with 30 clips & easel) </li>
                                    <li>Table Numbers, double-sided (Numbers 1-30, 3.5” x 9”)</li>
                                    <li>Antique Jug with “Honeymoon Fund” (jug & mini-hanger, 4.75” x 10”) (2pc)</li>
                                    <li>“Mr. & Mrs.” Head Table Sign with small easel 7.25” x 22.5”</li>
                                    <li>“We know that you would be here today if Heaven weren’t so far away”  (10” x 10.5” memorial sign or seat saver with small easel)</li>
                                    <li>“Here comes the Bride” ring bearer carrier  (10.25” x 17.25” with cord)</li>
                                    <li>“Better” & “Together” Chair Hangers (with cord 10.25” x 17.25”) (2pc)</li>
                                    <li>“Please Sign our Guestbook” (self standing 7.25” x 16”) </li>
                                    <li> “Just Married” & “Thank You” (reversible photo-shoot prop 7.25” x 31”)</li>
                                    <li>“Take One” (7.25” x 7.25”)</li>
                                    <li>“Programs” (7.25” x 16”)</li>
                                    <li>“Enjoy the Moment, no photography please” 10.5” x 17” with small easel</li>
                                    <li>8 Reserved signs (3.5” x 12”  4 with cord hanger option) (8pc)</li>
                                    <li>Antique Leather and Wooden Trunk with “Cards” Banner</li>
                                </ul>
                            </div>
        
                            <h2>Package 2:</h2>
                            <button class="collapsible">Rustic Wood "No Seating" Rental $245</button>
                            <div class="content">
                                <ul>
                                    <li>“Welcome to Our Beginning” Round (24” diameter, with easel) or Rectangular (35.5” x 21” with easel)</li>
                                    <li>Antique Jug with “Honeymoon Fund” (jug & mini-hanger, 4.75” x 10”) (2pc)</li>
                                    <li>“Mr. & Mrs.” Head Table Sign with small easel 7.25” x 22.5”</li>
                                    <li>“We know that you would be here today if Heaven weren’t so far away”  (10” x 10.5” memorial sign or seat saver with small easel)</li>
                                    <li>“Here comes the Bride” ring bearer carrier  (10.25” x 17.25” with cord)</li>
                                    <li>“Better” & “Together” Chair Hangers (with cord 10.25” x 17.25”) (2pc)</li>
                                    <li>“Please Sign our Guestbook” (self standing 7.25” x 16”) </li>
                                    <li> “Just Married” & “Thank You” (reversible photo-shoot prop 7.25” x 31”)</li>
                                    <li>“Take One” (7.25” x 7.25”)</li>
                                    <li>“Programs” (7.25” x 16”)</li>
                                    <li>“Enjoy the Moment, no photography please” 10.5” x 17” with small easel</li>
                                    <li>8 Reserved signs (3.5” x 12”  4 with cord hanger option) (8pc)</li>
                                    <li>Antique Leather and Wooden Trunk with “Cards” Banner</li>
                                </ul>
                            </div>
        
                            <h2>Package 3:</h2>
                            <button class="collapsible">Rustic Wood You Pick 4 Rental Package $199</button>
                            <div class="content">
                                <ul>
                                    <li>“Welcome to Our Beginning” Round (24” diameter, with easel) or Rectangular (35.5” x 21” with easel)</li>
                                    <li>“Find your Seat”  (35.5” x 21” organizer with 30 clips & easel) </li>
                                    <li>Table Numbers, double-sided (Numbers 1-30, 3.5” x 9”)</li>
                                    <li>Antique Jug with “Honeymoon Fund” (jug & mini-hanger, 4.75” x 10”) (2pc)</li>
                                    <li>“Mr. & Mrs.” Head Table Sign with small easel 7.25” x 22.5”</li>
                                    <li>“We know that you would be here today if Heaven weren’t so far away”  (10” x 10.5” memorial sign or seat saver with small easel)</li>
                                    <li>“Here comes the Bride” ring bearer carrier  (10.25” x 17.25” with cord)</li>
                                    <li>“Better” & “Together” Chair Hangers (with cord 10.25” x 17.25”) (2pc)</li>
                                    <li>“Please Sign our Guestbook” (self standing 7.25” x 16”) </li>
                                    <li> “Just Married” & “Thank You” (reversible photo-shoot prop 7.25” x 31”)</li>
                                    <li>“Take One” (7.25” x 7.25”)</li>
                                    <li>“Programs” (7.25” x 16”)</li>
                                    <li>“Enjoy the Moment, no photography please” 10.5” x 17” with small easel</li>
                                    <li>8 Reserved signs (3.5” x 12”  4 with cord hanger option) (8pc)</li>
                                    <li>Antique Leather and Wooden Trunk with “Cards” Banner</li>
                                </ul>
                            </div>
        
                        </div>
                    </div>
                </div>
                <div>
                    <hr class="mx-auto">
                </div>

                <form method="post" action="chooseExtras.php">
                    <div class="col-12 col-lg-4 mx-auto">
                        <select class="form-select<?php if(isset($packageErr)) echo " is-invalid"; ?>" id="option" name="package">
                            <option value="0" selected>Please select a rental option</option>
                            <option value="1">Rustic Wood Full Package Rental $299</option>
                            <option value="2">Rustic Wood "No Seating" Rental $245/option>
                            <option value="3">Rustic Wood "You Pick 4" Rental $199</option>
                
                        </select>

                        <?php if (isset($packageErr)) 
                            echo "<div class=\"invalid-feedback\">Please select a rental option</div>";
                            ?>

                        <input type="hidden" name="set" value="<?php echo $setStr ?>">
                        <input type="hidden" name="date" value="<?php echo $dateStr ?>">    
                        

                    </div>
                    
      


                    <div class="container text-center">
                        <div class="form-check form-check-inline p-3" id="extrasCheck">
                            <input class="form-check-input" type="checkbox"  name="checks[]" value="aisleRunner" id="aisleRunner">
                            <label class="form-check-label" for="aisleRunner">
                                Include Aisle Runner Add-On
                              <img src="walnut-ridge-images\DSC_3378.NEF.jpg" alt="small custom sign display" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                            $99 extra
                            </label>
                        </div>
    
                        <div class="form-check form-check-inline p-3" id="extrasCheck">
                            <input class="form-check-input" type="checkbox"  name="checks[]" value="typeWriter" id="typeWriter">
                            <label class="form-check-label" for="typeWriter">
                                Include Vintage Type Writter
                              <img src="walnut-ridge-images\Donnie+Rosie+Photo+1-9647.jpg" style="width:100px;height:150px;object-fit:cover;padding:15px 0 15px 0;">
                            $99 extra
                            </label>
                        </div>
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
            

        </div>
        
        <!--script for collapsibles to work-->
                <script>
                var coll = document.getElementsByClassName("collapsible");
                var i;

                for (i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var content = this.nextElementSibling;
                        if (content.style.maxHeight){
                            content.style.maxHeight = null;
                        } else {
                            content.style.maxHeight = content.scrollHeight + "px";
                        }
                    });
                }
                </script>

    </body>
</html>