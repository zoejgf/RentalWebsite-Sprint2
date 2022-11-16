# Documentation for db-access.php

```function queryReservationsAsc()```

This function returns an array of rows ocntaining individual reservations, sorted by
date in ascending order.
:heavy_minus_sign:	returns a complete list of reservations in ascending order 

---
 
```function queryReservationsDesc()```

This function returns an array of rows ocntaining individual reservations, sorted by
date in descending order.
:heavy_minus_sign:	returns a complete list of reservations in descending order
 
---
 
```function reservationDetails($reservationID)```

Given a reservation ID, this function returns an associative array containing the details 
for that specific reservation
:heavy_minus_sign:	returns details for a specified reservation
 
---
 
```function addCustomer($first, $last, $email, $phone)```

Given a firstName, lastName, email address, and phone number (all String values), this 
function adds a Customer to the database.
:heavy_plus_sign: adds a Customer to the database

---
 
```function addReservation($customerID, $reservationSet, $reservationPackage, $reservationDate)```

Add a Resrvation to the database given customerID, reservationSet, reservationPackage, and Date
of the reservation.
:heavy_plus_sign: adds reservation to database

---

```function customerExists($fname, $email, $phone)```

Returns a boolean value indicating whether this customer already exists in the database 
or not.  The first name must equal, as well as either the email address or phone number
for the test to return true.  Otherwise a false is returned.
:heavy_minus_sign: returns boolean indicating that a customer exists already or not

---

```function packageAvailable($packageID, $date) ```

This function returns a bool value on whether there are packages available for the given
packageID and Date.  It takes in an int id for set/package, and a String value for the 
date (YYYY-MM-DD) to test for.  The set has to be available for 2 days prior to and after 
the event to be considered available.   
:heavy_minus_sign: returns boolean indicating a package is available for a given date or not

---

```dateAvailability($date)```

This function returns an associated array of sets and the availability for each on a given date.
e.g. $set[1] = 0, indicates there is no availability for set 1 on the given date.
e.g. $set[2] = 1, indicates one set is available for the given date
The purpose of this function is to return set availability for a given date via a javascript call
on checkAvail.php page when a user selects a date. This would allow the page to display set 
availability *while* the user is making their set selection, and not have to wait for an error
message after they click the submit button.
:heavy_minus_sign: returns an associated array of sets and their availability for a given date



