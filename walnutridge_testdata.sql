
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
    
    
/*
create table extras (
    extras_id int NOT NULL PRIMARY KEY,
    name varchar(30),
    price decimal(10,2)
);
*/
delete from extras;

insert into extras (name, price) values ('Modern Sign', 275);
insert into extras (name, price) values ('Small Modern Sign', 40);
insert into extras (name, price) values ('Medium Modern Sign', 60);
insert into extras (name, price) values ('Large Modern Sign', 80);
insert into extras (name, price) values ('Aisle Runner', 99);
insert into extras (name, price) values ('TypeWriter', 99);
insert into extras (name, price) values ('Delivery', 0);
insert into extras (name, price) values ('Couch', 99);
insert into extras (name, price) values ('Antique', 4);
insert into extras (name, price) values ('Wine', 20);
insert into extras (name, price) values ('Clear Jars', 30);
insert into extras (name, price) values ('Blue Jars', 30);

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

insert into reservation (reservation_customer, reservation_set, reservation_package, reservation_date)
    values (1, 'Layered Arch Package', 'Pick 6 Rental', '2022-12-31');

insert into reservation (reservation_customer, reservation_set, reservation_package, reservation_date)
    values (1, 'Modern Round Package', 'Pick 4 Rental', '2022-12-30');

insert into reservation (reservation_customer, reservation_set, reservation_package, reservation_date)
    values (2, 'Vintage Mirror Package', 'Platinum Package', '2023-03-24');

insert into reservation (reservation_customer, reservation_set, reservation_package, reservation_date)
    values (3, 'Rustic Wood Package', 'Rustic Wood Full Set', '2023-05-27');

insert into reservation (reservation_customer, reservation_set, reservation_package, reservation_date)
    values (4, 'Dark Walnut Package', 'Pick 4 Rental', '2022-06-12');
    
insert into reservation (reservation_customer, reservation_set, reservation_package, reservation_date)
    values (1, 'Vintage Mirror Package', 'Gold Package Rental', '2022-12-31');    

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
insert into ordered_extras (reservation_id, extras_id) values (1,5);
insert into ordered_extras (reservation_id, extras_id) values (2,3);
insert into ordered_extras (reservation_id, extras_id) values (2,6);
insert into ordered_extras (reservation_id, extras_id) values (2,4);
insert into ordered_extras (reservation_id, extras_id) values (3,1);

/* insert into ordered_extras (reservation_id, extras_id) values (); */




