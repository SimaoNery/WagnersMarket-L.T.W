DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS CONDITION;
DROP TABLE IF EXISTS SIZE;
DROP TABLE IF EXISTS ITEM;
DROP TABLE IF EXISTS MESSAGE;
DROP TABLE IF EXISTS WISHLIST;
DROP TABLE IF EXISTS CART;
DROP TABLE IF EXISTS CATEGORY;
DROP TABLE IF EXISTS ITEM_CATEGORY;
DROP TABLE IF EXISTS IMAGE;

-- Create USER table
CREATE TABLE USER (
    UserId INTEGER NOT NULL PRIMARY KEY,
    Name TEXT NOT NULL,
    Username TEXT NOT NULL,
    Password TEXT NOT NULL,
    Email TEXT NOT NULL,
    Admin BOOLEAN DEFAULT FALSE
);

-- Create CONDITION table
CREATE TABLE CONDITION (
    ConditionId INTEGER PRIMARY KEY,
    ConditionVal TEXT NOT NULL
);

-- Create SIZE table
CREATE TABLE SIZE (
    SizeId INTEGER PRIMARY KEY,
    SizeVal TEXT NOT NULL
);

-- Create ITEM table
CREATE TABLE ITEM (
    ItemId INTEGER NOT NULL PRIMARY KEY,
    UserId INTEGER NOT NULL,
    Title TEXT NOT NULL,
    Price FLOAT NOT NULL,
    Description TEXT NOT NULL,
    ConditionId INTEGER NOT NULL,
    SizeId INTEGER NOT NULL,
    Brand TEXT,
    CONSTRAINT PriceConstraint CHECK (Price > 0),
    FOREIGN KEY (UserId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ConditionId) REFERENCES CONDITION (ConditionId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (SizeId) REFERENCES SIZE (SizeId) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create MESSAGE table
CREATE TABLE MESSAGE (
    MessageId INTEGER NOT NULL PRIMARY KEY,
    AuthorId INTEGER NOT NULL,
    ReceiverId INTEGER NOT NULL,
    Content TEXT NOT NULL,
    Timestamp DATETIME NOT NULL,
    FOREIGN KEY (AuthorId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ReceiverId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create WISHLIST table
CREATE TABLE WISHLIST (
    UserId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ItemId) REFERENCES ITEM (ItemId) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT PK_Wishlist PRIMARY KEY (UserId, ItemId)
);

-- Create CART table
CREATE TABLE CART (
    UserId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (UserId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ItemId) REFERENCES ITEM (ItemId) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT PK_Cart PRIMARY KEY (UserId, ItemId)
);

-- Create CATEGORY table
CREATE TABLE CATEGORY (
    CategoryName TEXT NOT NULL,
    CategoryImage TEXT NOT NULL,
    CONSTRAINT Pk_CategoryName PRIMARY KEY (CategoryName)
);

CREATE TABLE ITEM_CATEGORY (
    CategoryId TEXT NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (CategoryId) REFERENCES CATEGORY (CategoryName) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ItemId) REFERENCES ITEM (ItemId) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT PK_ItemCategory PRIMARY KEY (CategoryId, ItemId)
);

CREATE TABLE IMAGE(
    Path TEXT NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (ItemId) REFERENCES ITEM (ItemId) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Pk_Path PRIMARY KEY (Path)
);

-- Inserting data into USER table
INSERT INTO USER (UserId, Name, Username, Password, Email, Admin) VALUES (1, 'Paulo Fidalgo', 'paulinho', 'password123', 'paulofidalgo@gmail.com', TRUE);
INSERT INTO USER (UserId, Name, Username, Password, Email, Admin) VALUES (2, 'Jane Smith', 'janesmith', 'securepwd', 'janesmith@example.com', FALSE);

-- Inserting data into CONDITION table
INSERT INTO CONDITION (ConditionId, ConditionVal) VALUES (1, 'New');
INSERT INTO CONDITION (ConditionId, ConditionVal) VALUES (2, 'Used');

-- Inserting data into SIZE table
INSERT INTO SIZE (SizeId, SizeVal) VALUES (1, 'Small');
INSERT INTO SIZE (SizeId, SizeVal) VALUES (2, 'Medium');
INSERT INTO SIZE (SizeId, SizeVal) VALUES (3, 'Large');

-- Inserting data into ITEM table
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, ConditionId, SizeId, Brand) VALUES (1, 1, 'T-shirt', 15.99, 'Comfortable cotton t-shirt', 1, 2, 'Nike');
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, ConditionId, SizeId, Brand) VALUES (2, 2, 'Jeans', 29.99, 'Classic blue jeans', 2, 3, 'Levi''s');

-- Inserting data into MESSAGE table
INSERT INTO MESSAGE (MessageId, AuthorId, ReceiverId, Content, Timestamp) VALUES (1, 1, 2, 'Hi Jane, I''m interested in your jeans.', '2024-04-12 10:00:00');
INSERT INTO MESSAGE (MessageId, AuthorId, ReceiverId, Content, Timestamp) VALUES (2, 2, 1, 'Hi John, sure! Let me know if you have any questions.', '2024-04-12 10:05:00');

-- Inserting data into WISHLIST table
INSERT INTO WISHLIST (UserId, ItemId) VALUES (1, 2);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (2, 1);

-- Inserting data into CART table
INSERT INTO CART (UserId, ItemId) VALUES (1, 1);
INSERT INTO CART (UserId, ItemId) VALUES (2, 2);

-- Inserting data into CATEGORY table
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Fashion', 'category_images/f12c3daebcdec7b46698bf46ce66831c.jpg');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Tech', 'category_images/computer-design-template-19fcbb354d2bd7bde0059de2c0ac1cca_screen.jpg');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('House', 'category_images/houses-logo-illustration-free-vector.jpg');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Vehicles', 'category_images/623448-auto-car-logo-template-vector-icone-gratis-vetor.jpg');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Leisure', 'category_images/500_F_164837045_YK4gjpzRiZyqnjmVa4304BSCrq3plKd9.jpg');

-- Inserting data into ITEM_CATEGORY table
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES (1, 1);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES (1, 2);

-- Inserting data into IMAGE table
