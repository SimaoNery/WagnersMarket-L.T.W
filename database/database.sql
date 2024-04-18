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
    ProfilePic TEXT NOT NULL,
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
    ImageId NOT NULL,
    Path TEXT NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (ItemId) REFERENCES ITEM (ItemId) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT Pk_ImageId PRIMARY KEY (ImageId)
);

-- Inserting data into USER table
INSERT INTO USER (UserId, Name, Username, ProfilePic, Password, Email, Admin) VALUES (1, 'Paulo Fidalgo', 'paulinho', 'profile_pictures/1600w-kpZhUIzCx_w.webp', 'password123', 'paulofidalgo@gmail.com', TRUE);
INSERT INTO USER (UserId, Name, Username, ProfilePic, Password, Email, Admin) VALUES (2, 'Jane Smith', 'janesmith', 'profile_pictures/pexels-photo-771742.webp', 'securepwd', 'janesmith@example.com', FALSE);

-- Inserting data into CONDITION table
INSERT INTO CONDITION (ConditionId, ConditionVal) VALUES (1, 'New');
INSERT INTO CONDITION (ConditionId, ConditionVal) VALUES (2, 'Used');

-- Inserting data into SIZE table
INSERT INTO SIZE (SizeId, SizeVal) VALUES (1, 'Small');
INSERT INTO SIZE (SizeId, SizeVal) VALUES (2, 'Medium');
INSERT INTO SIZE (SizeId, SizeVal) VALUES (3, 'Large');

-- Inserting data into ITEM table
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, ConditionId, SizeId, Brand) VALUES (1, 1, 'T-shirt', 15.99, 'Comfortable cotton t-shirt', 1, 2, 'Nike');
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, ConditionId, SizeId, Brand) VALUES (2, 2, 'Samsung A23', 450, 'Samsung A23-Specs', 2, 1, 'Samsung');
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, ConditionId, SizeId, Brand) VALUES (3, 1, 'Toyota Corolla', 10.000, 'Toyota Corolla-Description', 2, 3, 'Toyota');
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, ConditionId, SizeId, Brand) VALUES (4, 2, 'Football', 10, 'Classic Football', 1, 2, 'Viper');
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, ConditionId, SizeId, Brand) VALUES (5, 1, 'Hammer', 7, 'Double Headed Hammer', 2, 1, 'Sparta');
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, ConditionId, SizeId, Brand) VALUES (6, 2, 'Dog Food', 45, 'Bag of Dog Food', 1, 2, 'Pedigree');
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, ConditionId, SizeId, Brand) VALUES (7, 1, 'Desk', 35, 'Simple White Desk', 1, 2, 'Ikea');
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, ConditionId, SizeId, Brand) VALUES (8, 2, 'Toy', 16, 'Spiderman Toy', 1, 1, 'Continente');

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
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Fashion', 'category_images/dress-icon-logo-design-template-vector.jpg');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Technology', 'category_images/Untitled.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Vehicles', 'category_images/pngtree-vector-car-icon-png-image_1834527.jpg');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Sports', 'category_images/2525535-200.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Tools and Equipment', 'category_images/tools-icon.webp');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Animals', 'category_images/151542-200.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Furniture and Home', 'category_images/1311796-200.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Babies and Children', 'category_images/3890909-200.png');

-- Inserting data into ITEM_CATEGORY table
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES (1, 1);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES (1, 2);

-- Inserting data into IMAGE table
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (1,'images/tshirt.png', 1);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (2,'images/202868.jpg', 1);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (3,'images/8252262.webp', 1);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (4,'images/15407337_350_A.jpg', 1);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (5,'images/AR4997-101.jpg', 1);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (6,'images/images.jpeg', 1);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (7,'images/samsung-galaxy-a23-5g-4gb-64gb-dual-sim-azul-claro.jpg', 2);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (8,'images/2023-toyota-corolla-zr-hybrid-hatch-silver-1.jpg', 3);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (9,'images/Football-l1600.jpg', 4);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (10,'images/double_hammer_1000x380.webp', 5);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (11,'images/DogFood.jpg', 6);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (12,'images/ikea_micke_desk__suitable_for__1646211721_b1d62fdb_progressive.jpg', 7);
INSERT INTO IMAGE (ImageId, Path, ItemId) VALUES (13,'images/www.toysrus.jpeg', 8);