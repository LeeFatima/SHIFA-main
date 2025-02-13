CREATE TABLE pharmacy (
    pharmacy_id INT PRIMARY KEY AUTO_INCREMENT,
    pharmacy_name VARCHAR (100) Not NULL,
    pharmacy_liscense_number VARCHAR(20)  UNIQUE Not NULL,
    phone_number VARCHAR (20) Not NULL,
    email VARCHAR (100)  UNIQUE Not NULL,
    password VARCHAR (255) Not NULL,
    address VARCHAR (255) Not NULL

)
