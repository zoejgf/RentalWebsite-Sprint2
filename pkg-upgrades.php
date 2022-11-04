<?php


    function processPackageUpgrades($set,
            $package
            ) {
        
        // empty array - to be populated
        $upgrades = [];
        if (isset($set) && isset($package)) {
            
            if ($set == "1") {
                if ($package == "2") {
                    $upgrades["currentPack"] = "Layered Arch Pick 6 Rental";

                    $upgrades["name"] = "Layered Arch Full Set Rental";
                    $upgrades["difference"] = 100;
                    $upgrades["description"] = "Receive an additional 6 items";
                    $upgrades["id"] = 1;
                }
                if ($package == "3") {
                    $upgrades["currentPack"] = "Layered Arch Pick 4 Rental";

                    $upgrades["name"] = "Layered Arch Full Set Rental";
                    $upgrades["difference"] = 250;
                    $upgrades["description"] = "Receive an additional 6 items";
                    $upgrades["id"] = 1;

                    $upgrades["name1"] = "Layered Arch Pick 6 Rental";
                    $upgrades["difference1"] = 150;
                    $upgrades["description1"] = "Receive an additional 2 items";
                    $upgrades["id"] = 2;
                }
            }
            
            if ($set == "2") {
                if ($package == "2") {
                    $upgrades["currentPack"] = "Modern Round Pick 6 Rental";
                    $upgrades["name"] = "Full Set Rental";
                    $upgrades["difference"] = 100;
                    $upgrades["description"] = "Receive an additional 6 items";
                    $upgrades["id"] = 1;
                }
                if ($package == "3") {
                    $upgrades["currentPack"] = "Modern Round Pick 4 Rental";
                    $upgrades["name"] = "Full Set Rental";
                    $upgrades["difference"] = 100;
                    $upgrades["description"] = "Receive an additional 6 items";
                    
                    $upgrades["name"] = "Pick 6 Rental";
                    $upgrades["difference"] = 200;
                    $upgrades["description"] = "Receive an additional 6 items";
                    $upgrades["id"] = 2;
                }
            }

            if ($set == "3") {
                if ($package == "2") {
                    $upgrades["name"] = "Vintage Mirror Platinum Rental";
                    $upgrades["difference"] = 150;
                    $upgrades["description"] = "Includes 3 Additional Custom Mirrors";
                    $upgrades["id"] = 1;
                }
                if ($package == "3") {
                    $upgrades["name"] = "Vintage Mirror Platinum Rental";
                    $upgrades["difference"] = 200;
                    $upgrades["description"] = "Includes 3 Additional Custom Mirrors";
                    $upgrades["id"] = 1;

                    $upgrades["name1"] = "Vintage Mirror Gold Rental";
                    $upgrades["difference1"] = 150;
                    $upgrades["description1"] = "Includes All Items *excludes custom mirrors*";
                    $upgrades["id"] = 2;
                }
                if ($package == "4") {
                    $upgrades["name"] = "Vintage Mirror Platinum Rental";
                    $upgrades["difference"] = 250;
                    $upgrades["description"] = "Includes 3 Additional Custom Mirrors";
                    $upgrades["id"] = 1;

                    $upgrades["name1"] = "Vintage Mirror Gold Rental";
                    $upgrades["difference1"] = 200;
                    $upgrades["description1"] = "Includes All Items *excludes custom mirrors*";
                    $upgrades["id"] = 2;

                    $upgrades["name2"] = "Vintage Mirror Pick 6 Rental";
                    $upgrades["difference2"] = 50;
                    $upgrades["description2"] = "Receive an additional 2 items *excludes custom mirrors";
                    $upgrades["id"] = 3;

                }

            }            

            if ($set == "4") {
                if ($package == "2") {
                    $upgrades["name"] = "Full Set";
                    $upgrades["difference"] = 54;
                    $upgrades["description"] = "Includes All 14 Items";
                    $upgrades["id"] = 1;
                }
                if ($package == "3") {
                    $upgrades["name"] = "Full Set";
                    $upgrades["difference"] = 100;
                    $upgrades["description"] = "Includes All 14 Items";
                    $upgrades["id"] = 1;

                    $upgrades["name1"] = "No Seating Set";
                    $upgrades["difference1"] = 46;
                    $upgrades["description1"] = "Includes all items except seating sign";
                    $upgrades["id"] = 2;
                }
            }

            if ($set == "5") {
                if ($package == "2") {
                    $upgrades["name"] = "Rustic Wood Full Package";
                    $upgrades["difference"] = 54;
                    $upgrades["description"] = "Includes All 15 Items";
                    $upgrades["id"] = 1;
                }
                if ($package == "3") {
                    $upgrades["name"] = "Rustic Wood Full Package";
                    $upgrades["difference"] = 100;
                    $upgrades["description"] = "Includes All 15 Items";
                    $upgrades["id"] = 1;

                    $upgrades["name1"] = "Rustic Wood No Seating Rental";
                    $upgrades["difference1"] = 46;
                    $upgrades["description1"] = "Includes all items except seating sign";
                    $upgrades["id"] = 2;
                }
            }

        }
        return $upgrades;
    }

    

?>