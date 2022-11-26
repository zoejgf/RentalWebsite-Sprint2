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

drop table if exists reservation_customers;
drop table if exists ordered_extras;
drop table if exists reservation;
drop table if exists extras;
drop table if exists customers;
drop table if exists notes;

create table customers (
    customer_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name varchar(30) NOT NULL,
    last_name varchar(30) NOT NULL,
    email varchar(50),
    phone varchar(20)
);

create table reservation (
    reservation_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    /*reservation_customer int NOT NULL,
        CONSTRAINT fk_customer FOREIGN KEY (reservation_customer) REFERENCES customers(customer_id),*/
    reservation_set varchar(30),
    reservation_package varchar(30),
    reservation_date DATE,
    status varchar(20) DEFAULT 'unconfirmed'
);

create table reservation_customers (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    customer int NOT NULL,
        CONSTRAINT fk_rc_customer FOREIGN KEY (customer) REFERENCES customers(customer_id),
    reservation int NOT NULL,
        CONSTRAINT fk_rc_reservation FOREIGN KEY (reservation) REFERENCES reservation(reservation_id),
    relationship VARCHAR(30)
);

create table extras (
    extras_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(30),
    price decimal(10,2),
    image_url varchar(30),
    form_value varchar(15),
    form_id varchar(15)
);

create table ordered_extras (
    ordered_extras_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    reservation_id int NOT NULL,
        CONSTRAINT fk_ordered_extras_reservation FOREIGN KEY (reservation_id) REFERENCES reservation(reservation_id),
    extras_id int NOT NULL,
        CONSTRAINT fk_extras FOREIGN KEY (extras_id) REFERENCES extras(extras_id)
);

create table notes (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    reservation_id int NOT NULL,
        CONSTRAINT fk_notes_reservation FOREIGN KEY (reservation_id) REFERENCES reservation(reservation_id),
    note_text varchar(5000),     /* less than 64k for TEXT type */
    note_date DATE default now()
);
