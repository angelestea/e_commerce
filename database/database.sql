CREATE DATABASE e_commerce;
USE e_commerce;

CREATE TABLE users(
id              int(255) auto_increment not null,
name          varchar(100) not null,
last_name       varchar(255),
email           varchar(255) not null,
password        varchar(255) not null,
role             varchar(20),
image          varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id),
CONSTRAINT uq_email UNIQUE(email)  
)ENGINE=InnoDb;


CREATE TABLE categories(
id              int(255) auto_increment not null,
name          varchar(100) not null,
CONSTRAINT pk_categories PRIMARY KEY(id) 
)ENGINE=InnoDb;

INSERT INTO categories VALUES(null, 'Trucker');
INSERT INTO categories VALUES(null, 'Classic');
INSERT INTO categories VALUES(null, 'Boina');
INSERT INTO categories VALUES(null, 'Modern');

CREATE TABLE products(
id              int(255) auto_increment not null,
id_category    int(255) not null,
name          varchar(100) not null,
description     text,
price          float(100,2) not null,
stock           int(255) not null,
ofert          varchar(2),
date           date not null,
image          varchar(255),
CONSTRAINT pk_categories PRIMARY KEY(id),
CONSTRAINT fk_product_category FOREIGN KEY(id_category) REFERENCES categories(id) ON DELETE CASCADE
)ENGINE=InnoDb;


CREATE TABLE orders(
id              int(255) auto_increment not null,
id_user      int(255) not null,
province       varchar(100) not null,
location       varchar(100) not null,
address       varchar(255) not null,
price           float(200,2) not null,
state          varchar(20) not null,
date           date,
hour            time,
CONSTRAINT pk_orders PRIMARY KEY(id),
CONSTRAINT fk_pedido_usuario FOREIGN KEY(id_user) REFERENCES users(id)ON DELETE CASCADE
)ENGINE=InnoDb;

CREATE TABLE order_lines(
id              int(255) auto_increment not null,
id_order       int(255) NOT NULL,
id_product     int(255) NOT NULL,
unities        int(255) NOT NULL,
CONSTRAINT pk_order_lines PRIMARY KEY(id),
CONSTRAINT fk_order_line FOREIGN KEY(id_order) REFERENCES orders(id) ON DELETE CASCADE, 
CONSTRAINT fk_product_line FOREIGN KEY(id_product) REFERENCES products(id) ON DELETE CASCADE
)ENGINE=InnoDb;




