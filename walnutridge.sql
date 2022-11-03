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


drop table if exists customer;

create table order (
    order_id int NOT NULL,
    order_customer int NOT NULL,
    order_set varchar(10),
    order_package varchar(10),
    PRIMARY KEY (order_id),
    FOREIGN KEY (order_customer)
);

create table extras (
    extras_id int NOT NULL,
    name varchar(30),
    price decimal(10,2),
    PRIMARY KEY (extras_id)
)

create table ordered_extras (
    ordered_extras_id int NOT NULL,
    order_id int FOREIGN KEY REFERENCES order(order_id),
    extras_id int FOREGIN KEY REFERENCES extras(extras_id)
);

create table customers (
    customer_id int NOT NULL,
    first_name varchar(30) NOT NULL,
    last_name varchar(30) NOT NULL,
    email varchar(50),
    phone varchar(20)
);

