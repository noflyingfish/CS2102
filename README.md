# CS2102
CS2102 Database sem1 18/19, Project topic: Crowdfunding


Schema 

CREATE TABLE users (
name VARCHAR(64) NOT NULL,
email VARCHAR(128) PRIMARY KEY,
password VARCHAR(32) NOT NULL
);

CREATE TABLE admin (
name VARCHAR(64) NOT NULL,
email VARCHAR(128) PRIMARY KEY,
password VARCHAR(32) NOT NULL
);

CREATE TABLE project (
id SERIAL PRIMARY KEY,
curr$ INT DEFAULT 0,
total$ INT NOT NULL,
title VARCHAR(64) NOT NULL,
description TEXT,
start_date DATE DEFAULT CURRENT_DATE,
end_date DATE NOT NULL,
CHECK (end_date >= start_date),
CHECK (total$ >= curr$),
own VARCHAR(128) NOT NULL,
FOREIGN KEY (own) REFERENCES users(email) 
);


CREATE TABLE support (
email VARCHAR(128),
id INT,
amt_supported INT NOT NULL,
FOREIGN KEY (email) REFERENCES users(email),
FOREIGN KEY (id) REFERENCES project(id)
);


CREATE TABLE moderate(    //is this table a bit useless?
    email VARCHAR(128),
    id INT,
    FOREIGN KEY (email) REFERENCES users(email),
    FOREIGN KEY (id) REFERENCES project(id)
);

CREATE TABLE keywords (
    id integer,
word varchar(64),
FOREIGN KEY (id) REFERENCES project(id),
PRIMARY KEY (id, word)
);




