/*
Fields include: name, email, phone, set, package, extras (this could be 1 field or multiple), 
estimated cost, date and status (unconfirmed, confirmed, cancelled) Compare the table you 
created to the form data at the end of the PHP reservation process - consider any changes/adjustments 
needed to either group of data to promote a clean/direct handoff Write a .sql file that 
populates 10-12 reservations into the table, removing all old structure and data and replacing 
it with the preset 10-12 "dummy data" items
*/

/* int value +/- 2147483647 */
/*
 Sets, i.e. Dark Walnut and Layered Arch
 Packages, i.e. Pick 6 or Pick 4
*/

/*
cpanel database, 
db: redgreen_wedding
user: redgreen_php
pw: redtomatoes
*/


drop table if exists customers;
drop table if exists reservation;
drop table if exists ordered_extras;
drop table if exists extras;

create table reservation (
    reservation_id int NOT NULL,
    reservation_customer int NOT NULL,
    reservation_set varchar(10),
    reservation_package varchar(10),
    reservation_date DATETIME,
    PRIMARY KEY (reservation_id),
    FOREIGN KEY (reservation_customer) REFERENCES customers(customer_id)
);

create table extras (
    extras_id int NOT NULL,
    name varchar(30),
    price decimal(10,2),
    PRIMARY KEY (extras_id)
);

create table ordered_extras (
    ordered_extras_id int NOT NULL,
    reservation_id int NOT NULL,
        FOREIGN KEY (reservation_id) REFERENCES reservation(reservation_id),
    extras_id int NOT NULL,
        FOREIGN KEY (extras_id) REFERENCES extras(extras_id)
);

create table customers (
    customer_id int NOT NULL,
    first_name varchar(30) NOT NULL,
    last_name varchar(30) NOT NULL,
    email varchar(50),
    phone varchar(20)
);

