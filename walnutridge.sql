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
    email varchar(75),
    phone varchar(20)
);

create table reservation (
    reservation_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    /*reservation_customer int NOT NULL,
        CONSTRAINT fk_customer FOREIGN KEY (reservation_customer) REFERENCES customers(customer_id),*/
    reservation_set varchar(50),
    reservation_package varchar(50),
    reservation_date DATE,
    status varchar(30) DEFAULT 'unconfirmed'
);

create table reservation_customers (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    customer int NOT NULL,
        CONSTRAINT fk_rc_customer FOREIGN KEY (customer) REFERENCES customers(customer_id),
    reservation int NOT NULL,
        CONSTRAINT fk_rc_reservation FOREIGN KEY (reservation) REFERENCES reservation(reservation_id),
    relationship VARCHAR(75)
);

create table extras (
    extras_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name varchar(30),
    price decimal(10,2),
    image_url varchar(50),
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
    note_date DATETIME default now()
);

/* Adding extras to the database (NOTE: is form_value used?)
 * 1. insert item into db (live or below), must have a form_value and form_id value
 * 2. 
 */
insert into extras (name, price, image_url, form_value, form_id) 
    values ('Clear Antique Ball Jars', 30, 'walnut-ridge-images/da-7.jpg', 'clearJars', 'clearBall');
insert into extras (name, price, image_url, form_value, form_id) 
    values ('Blue Antique Ball Jars', 30, 'walnut-ridge-images/da-6.jpg', 'blueJars', 'blueBall');
insert into extras (name, price, image_url, form_value, form_id) 
    values ('Vintage Couch', 99, 'walnut-ridge-images/da-1.jpg', 'couch', 'vintageCouch');
insert into extras (name, price, image_url, form_value, form_id) 
    values ('Antique Gallon Jugs', 4, 'walnut-ridge-images/da-8.jpg', 'antique', 'antiqueJugs');
insert into extras (name, price, image_url, form_value, form_id) 
    values ('XL Wine Jugs', 20, 'walnut-ridge-images/da-4.jpg', 'wine', 'wineJugs');
insert into extras (name, price, image_url, form_value, form_id) 
    values ('Hexagon Arbor', 350, 'walnut-ridge-images/IMG_5617.jpg', 'arbor', 'arbor');
