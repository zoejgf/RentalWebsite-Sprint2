
/* GOOD */
delete from customers;

insert into customers (first_name, last_name, email, phone) values (
    'John',
    'Smith',
    'john@email.com',
    '425-555-1111');
    

insert into customers (first_name, last_name, email, phone) values (
    'Jane',
    'Doe',
    'jane@email.com',
    '425-555-2222');
    

insert into customers (first_name, last_name, email, phone) values (
    'Michael',
    'Jones',
    'michael@email.com',
    '425-555-3333');
    

insert into customers (first_name, last_name, email, phone) values (
    'Suzie',
    'Jackson',
    'suzie@email.com',
    '425-555-4444');
    

insert into customers (first_name, last_name, email, phone) values (
    'Sally',
    'Smith',
    'sally@email.com',
    '425-555-5555');
    
    
/*
create table extras (
    extras_id int NOT NULL PRIMARY KEY,
    name varchar(30),
    price decimal(10,2)
);
*/
delete from extras;
/*
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
*/
/*
create table reservation (
    reservation_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    reservation_customer int NOT NULL,
        CONSTRAINT fk_customer FOREIGN KEY (reservation_customer) REFERENCES customers(customer_id),
    reservation_set varchar(10),
    reservation_package varchar(10),
    reservation_date DATETIME                   Format: YYYY-MM-DD
);
*/

insert into reservation (reservation_set, reservation_package, reservation_date)
    values ('Layered Arch Package', 'Pick 6 Rental', '2022-12-31');

insert into reservation (reservation_set, reservation_package, reservation_date)
    values ('Modern Round Package', 'Pick 4 Rental', '2022-12-30');

insert into reservation (reservation_set, reservation_package, reservation_date)
    values ('Vintage Mirror Package', 'Platinum Package', '2023-03-24');

insert into reservation (reservation_set, reservation_package, reservation_date)
    values ('Rustic Wood Package', 'Rustic Wood Full Set', '2023-05-27');

insert into reservation (reservation_set, reservation_package, reservation_date)
    values ('Dark Walnut Package', 'Pick 4 Rental', '2022-06-12');
    
insert into reservation (reservation_set, reservation_package, reservation_date)
    values ('Vintage Mirror Package', 'Gold Package Rental', '2022-12-31');    


/*

create table reservation_customers (
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    customer int NOT NULL,
        CONSTRAINT fk_rc_customer FOREIGN KEY (customer) REFERENCES customers(customer_id),
    reservation int NOT NULL,
        CONSTRAINT fk_rc_reservation FOREIGN KEY (reservation) REFERENCES reservation(reservation_id),
    relationship VARCHAR(30)
);
*/

insert into reservation_customers (customer, reservation, relationship) values
    (1, 1, 'Wedding Planner');

insert into reservation_customers (customer, reservation, relationship) values
    (1, 2, 'Wedding Planner');    

insert into reservation_customers (customer, reservation, relationship) values
    (2, 3, 'Bride');

insert into reservation_customers (customer, reservation, relationship) values
    (3, 4, 'Groom');

insert into reservation_customers (customer, reservation, relationship) values
    (4, 5, 'Bride');

insert into reservation_customers (customer, reservation, relationship) values
    (1, 6, 'Wedding Planner');

insert into reservation_customers (customer, reservation, relationship) values
    (5, 1, 'Bride');


/*

create table ordered_extras (
    ordered_extras_id int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    reservation_id int NOT NULL,
        CONSTRAINT fk_reservation FOREIGN KEY (reservation_id) REFERENCES reservation(reservation_id),
    extras_id int NOT NULL,
        CONSTRAINT fk_extras FOREIGN KEY (extras_id) REFERENCES extras(extras_id)
);
*/

insert into ordered_extras (reservation_id, extras_id) values (1,2);
insert into ordered_extras (reservation_id, extras_id) values (1,4);
insert into ordered_extras (reservation_id, extras_id) values (2,3);
insert into ordered_extras (reservation_id, extras_id) values (2,1);
insert into ordered_extras (reservation_id, extras_id) values (3,1);
insert into ordered_extras (reservation_id, extras_id) values (3,5);

/* insert into ordered_extras (reservation_id, extras_id) values (); */

insert into notes(reservation_id, note_text) values (1, "John is looking for a reference for circus clowns.");
insert into notes(reservation_id, note_text) values (2, "No more clowns, John is asking for a White Stallion.");




