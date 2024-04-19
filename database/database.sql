DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS ITEM;
DROP TABLE IF EXISTS SIZE;
DROP TABLE IF EXISTS CONDITION;
DROP TABLE IF EXISTS BRAND;
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


-- Create ITEM table
CREATE TABLE ITEM (
    ItemId INTEGER NOT NULL,
    UserId INTEGER NOT NULL,
    Title TEXT NOT NULL,
    Price FLOAT NOT NULL,
    Description TEXT NOT NULL,
    Condition TEXT NOT NULL,
    Size TEXT NOT NULL,
    Brand TEXT NOT NULL,
    ImagePath TEXT NOT NULL,
    WishlistCounter INTEGER NOT NULL,
    CONSTRAINT PK_ItemId PRIMARY KEY (ItemId),
    CONSTRAINT PriceConstraint CHECK (Price > 0),
    FOREIGN KEY (UserId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (Condition) REFERENCES CONDITION (Condition) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (Size) REFERENCES SIZE (Size) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (Brand) REFERENCES BRAND ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create SIZE table
CREATE TABLE SIZE (
    Size TEXT NOT NULL,
    CONSTRAINT PK_ItemId PRIMARY KEY (Size)
);

-- Create CONDITION table
CREATE TABLE CONDITION (
    Condition TEXT NOT NULL,
    CONSTRAINT PK_Condition PRIMARY KEY (Condition)
);

-- Create BRAND table
CREATE TABLE BRAND (
    Brand TEXT NOT NULL,
    CONSTRAINT PK_Brand PRIMARY KEY (Brand)
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


-- Inserting data into ITEM table
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, Condition, Size, Brand, ImagePath, WishlistCounter) VALUES (1, 1, 'T-shirt', 15.99, 'Comfortable cotton t-shirt', 'New', 'Small', 'Nike', 'images/tshirt.png', 0);
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, Condition, Size, Brand, ImagePath, WishlistCounter) VALUES (2, 2, 'Samsung A23', 450, 'Samsung A23-Specs', 'New', 'Medium', 'Samsung', 'images/samsung-galaxy-a23-5g-4gb-64gb-dual-sim-azul-claro.jpg', 2);
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, Condition, Size, Brand, ImagePath, WishlistCounter) VALUES (3, 1, 'Toyota Corolla', 10.000, 'Toyota Corolla-Description','Used', 'Medium', 'Toyota', 'images/2023-toyota-corolla-zr-hybrid-hatch-silver-1.jpg', 1);
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, Condition, Size, Brand, ImagePath, WishlistCounter) VALUES (4, 2, 'Football', 10, 'Classic Football','New', 'Small', 'Viper', 'images/Football-l1600.jpg', 0);
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, Condition, Size, Brand, ImagePath, WishlistCounter) VALUES (5, 1, 'Hammer', 7, 'Double Headed Hammer', 'Used', 'Medium', 'Sparta', 'images/double_hammer_1000x380.webp', 0);
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, Condition, Size, Brand, ImagePath, WishlistCounter) VALUES (6, 2, 'Dog Food', 45, 'Bag of Dog Food', 'New', 'Small', 'Pedigree', 'images/DogFood.jpg', 0);
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, Condition, Size, Brand, ImagePath, WishlistCounter) VALUES (7, 1, 'Desk', 35, 'Simple White Desk', 'New', 'Small', 'Ikea', 'images/ikea_micke_desk__suitable_for__1646211721_b1d62fdb_progressive.jpg', 0);
INSERT INTO ITEM (ItemId, UserId, Title, Price, Description, Condition, Size, Brand, ImagePath, WishlistCounter) VALUES (8, 2, 'Toy', 16, 'Spiderman Toy', 'Used', 'Small', 'Continente', 'images/www.toysrus.jpeg', 0);


--Inserting data into SIZE table
INSERT INTO SIZE (Size) VALUES ('Small');
INSERT INTO SIZE (Size) VALUES ('Medium');
INSERT INTO SIZE (Size) VALUES ('Large');

--Inserting data into CONDITION table
INSERT INTO CONDITION (Condition) VALUES ('Used');
INSERT INTO CONDITION (Condition) VALUES ('New');

--Inserting data into BRAND table
INSERT INTO BRAND (Brand) VALUES ('Nike');
INSERT INTO BRAND (Brand) VALUES ('Samsung');
INSERT INTO BRAND (Brand) VALUES ('Toyota');
INSERT INTO BRAND (Brand) VALUES ('Viper');
INSERT INTO BRAND (Brand) VALUES ('Sparta');
INSERT INTO BRAND (Brand) VALUES ('Pedigree');
INSERT INTO BRAND (Brand) VALUES ('Ikea');
INSERT INTO BRAND (Brand) VALUES ('Continente');


-- Inserting data into MESSAGE table
INSERT INTO MESSAGE (MessageId, AuthorId, ReceiverId, Content, Timestamp) VALUES (1, 1, 2, 'Hi Jane, I''m interested in your jeans.', '2024-04-12 10:00:00');
INSERT INTO MESSAGE (MessageId, AuthorId, ReceiverId, Content, Timestamp) VALUES (2, 2, 1, 'Hi John, sure! Let me know if you have any questions.', '2024-04-12 10:05:00');

-- Inserting data into WISHLIST table
INSERT INTO WISHLIST (UserId, ItemId) VALUES (1, 3);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (1, 2);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (2, 2);


-- Inserting data into CART table
INSERT INTO CART (UserId, ItemId) VALUES (1, 1);
INSERT INTO CART (UserId, ItemId) VALUES (2, 2);

-- Inserting data into CATEGORY table
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Fashion', 'category_images/dress-icon-logo-design-template-vector.jpg');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Technology', 'category_images/Untitled.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Vehicles', 'category_images/pngtree-vector-car-icon-png-image_1834527.jpg');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Sports', 'category_images/2525535-200.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('ToolsAndEquipment', 'category_images/tools-icon.webp');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Animals', 'category_images/151542-200.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('FurnitureAndHome', 'category_images/1311796-200.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('BabiesAndChildren', 'category_images/3890909-200.png');

-- Inserting data into ITEM_CATEGORY table
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Fashion', 1);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Technology', 2);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Vehicles', 3);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Sports', 4);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('ToolsAndEquipment', 2);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Animals', 2);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('FurnitureAndHome', 7);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('BabiesAndChildren', 4);


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