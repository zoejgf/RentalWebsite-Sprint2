<?php


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
            $returnPrice = 275;
        if ($c == "smallModernSign")
            $returnPrice = 40;
        if ($c == "medModernSign")
            $returnPrice = 60;
        if ($c == "larModernSign")
            $returnPrice = 80;
        if ($c == "aisleRunner")
            $returnPrice = 99;
        if ($c == "typeWriter")
            $returnPrice = 99;
        
        $totalPrice += $returnPrice;
        return $returnPrice;
    }

    function processPackageNamesPrices(&$packageName, 
            &$packagePrice, 
            &$totalPrice,
            $set,
            $package
            ) {

        // PROCESS PACKAGE PRICES
        if (isset($set) && isset($package)) {
            
            if ($set == "1") {
                $packageName = "Layered Arch Package, ";
                if ($package == "1") {
                    $packageName .= "Layered Arch Full Set Rental";
                    $packagePrice = "849.0";
                } elseif ($package == "2") {
                    $packageName .= "Layered Arch Pick 6 Rental";
                    $packagePrice = "749.0";
                } elseif ($package == "3") {
                    $packageName .= "Layered Arch Pick 4 Rental";
                    $packagePrice = "699.0";
                }
            }
            
            if ($set == "2") {
                $packageName = "Modern Round Package, ";
                if ($package == "1") {
                    $packageName .= "Modern Round Full Set Rental";
                    $packagePrice = 799.0;
                } elseif ($package == "2") {
                    $packageName .= "Modern Round Pick 6 Rental";
                    $packagePrice = 699.0;
                } elseif ($package == "3") {
                    $packageName .= "Modern Round Pick 4 Rental";
                    $packagePrice = 599.0;
                }
            }

            if ($set == "3") {
                $packageName = "Vintage Mirror Package, ";
                if ($package == "1") {
                    $packageName = "Vintage Mirror Platinum Package";
                    $packagePrice = 849.0;
                } elseif ($package == "2") {
                    $packageName = "Vintage Mirror Gold Package";
                    $packagePrice = 799.0;
                } elseif ($package == "3") {
                    $packageName = "Vintage Mirror Pick 6 Package";
                    $packagePrice = 649.0;
                } elseif ($package == "4") {
                    $packageName = "Vintage Mirror Pick 4 Package";
                    $packagePrice = 599.0;
                }
            }            

            if ($set == "4") {
                $packageName = "Dark Walnut Package, ";
                if ($package == "1") {
                    $packageName = "Dark Walnut Full Set Rental";
                    $packagePrice = 299.0;
                } elseif ($package == "2") {
                    $packageName = "Dark Walnut No Seating Rental";
                    $packagePrice = 245.0;
                } elseif ($package == "3") {
                    $packageName = "Dark Walnut Pick 4 Rental";
                    $packagePrice = 199.0;
                }
            }

            if ($set == "5") {
                $packageName = "Rustic Wood Package, ";
                if ($package == "1") {
                    $packageName = "Rustic Wood Full Set";
                    $packagePrice = 299.0;
                } elseif ($package == "2") {
                    $packageName = "Rustic Wood No Seating";
                    $packagePrice = 245.0;
                } elseif ($package == "3") {
                    $packageName = "Rustic Wood Pick 4";
                    $packagePrice = 199.0;
                }
            }

            $totalPrice += $packagePrice;
        }
    }

    function returnExtraPrice($e, &$totalPrice) {
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

        //global $totalPrice;
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
        Date retrieved to this point, with some keys below.
            $month - selected month for wedding rental
            $date - full date selected by user
            $set - selected option from checkAvail page
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