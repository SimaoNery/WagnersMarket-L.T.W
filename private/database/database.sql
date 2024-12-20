DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS ITEM;
DROP TABLE IF EXISTS SIZE;
DROP TABLE IF EXISTS CONDITION;
DROP TABLE IF EXISTS MESSAGE;
DROP TABLE IF EXISTS WISHLIST;
DROP TABLE IF EXISTS CART;
DROP TABLE IF EXISTS CATEGORY;
DROP TABLE IF EXISTS ITEM_CATEGORY;
DROP TABLE IF EXISTS IMAGE;
DROP TABLE IF EXISTS REVIEW;

-- Create USER table
CREATE TABLE USER (
    UserId INTEGER PRIMARY KEY AUTOINCREMENT,
    Name TEXT NOT NULL,
    Username TEXT UNIQUE NOT NULL,
    ProfilePic TEXT NOT NULL,
    Password TEXT NOT NULL,
    Email TEXT UNIQUE NOT NULL,
    Admin BOOLEAN DEFAULT FALSE
);

-- Create ITEM table
CREATE TABLE ITEM (
    ItemId INTEGER PRIMARY KEY AUTOINCREMENT,
    UserId INTEGER NOT NULL,
    Title TEXT NOT NULL,
    Price FLOAT NOT NULL,
    Description TEXT NOT NULL,
    Condition TEXT NOT NULL,
    Size TEXT NOT NULL,
    Brand TEXT NOT NULL,
    ImagePath TEXT NOT NULL,
    WishlistCounter INTEGER DEFAULT 0,
    Timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT PriceConstraint CHECK (Price > 0),
    FOREIGN KEY (UserId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (Condition) REFERENCES CONDITION (Condition) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (Size) REFERENCES SIZE (Size) ON DELETE CASCADE ON UPDATE CASCADE
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

-- Create MESSAGE table
CREATE TABLE MESSAGE (
    MessageId INTEGER PRIMARY KEY AUTOINCREMENT,
    AuthorId INTEGER NOT NULL,
    ReceiverId INTEGER NOT NULL,
    Content TEXT NOT NULL,
    Timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (AuthorId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ReceiverId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create WISHLIST table
CREATE TABLE WISHLIST (
    UserId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    Timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ItemId) REFERENCES ITEM (ItemId) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT PK_Wishlist PRIMARY KEY (UserId, ItemId)
);

-- Create CART table
CREATE TABLE CART (
    UserId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    Timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
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

-- Create TRANSACTION table
CREATE TABLE `TRANSACTION` (
    TransactionId INTEGER PRIMARY KEY AUTOINCREMENT,
    SellerId INTEGER NOT NULL,
    BuyerId INTEGER NOT NULL,
    Timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Price INTEGER NOT NULL,
    Address TEXT NOT NULL,
    FOREIGN KEY (SellerId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (BuyerId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Create TRANSACTION_ITEM table
CREATE TABLE TRANSACTION_ITEM (
    TransactionId INTEGER NOT NULL,
    ItemId INTEGER NOT NULL,
    PRIMARY KEY (TransactionId, ItemId),
    FOREIGN KEY (TransactionId) REFERENCES `TRANSACTION` (TransactionId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ItemId) REFERENCES ITEM (ItemId) ON DELETE CASCADE ON UPDATE CASCADE
);



CREATE TABLE ITEM_CATEGORY (
    CategoryId TEXT NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (CategoryId) REFERENCES CATEGORY (CategoryName) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (ItemId) REFERENCES ITEM (ItemId) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT PK_ItemCategory PRIMARY KEY (CategoryId, ItemId)
);

CREATE TABLE IMAGE(
    ImageId INTEGER PRIMARY KEY AUTOINCREMENT,
    Path TEXT NOT NULL,
    ItemId INTEGER NOT NULL,
    FOREIGN KEY (ItemId) REFERENCES ITEM (ItemId) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE REVIEW (
    ReviewId INTEGER PRIMARY KEY AUTOINCREMENT,
    BuyerId INTEGER NOT NULL,
    SellerId INTEGER NOT NULL,
    Rating INTEGER NOT NULL,
    Review TEXT NOT NULL,
    Timestamp DATETIME NOT NULL,
    FOREIGN KEY (BuyerId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (SellerId) REFERENCES USER (UserId) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT RatingValue CHECK (Rating >= 0 AND Rating <= 5)
);

-- Populate USER table
INSERT INTO USER (Name, Username, ProfilePic, Password, Email, Admin) VALUES ('Wagner','wagnerzimdojornelim', '../profile_pictures/profile_pic1.png','12345','wagner@gmail.com', true);
INSERT INTO USER (Name, Username, ProfilePic, Password, Email) VALUES ('Paulo','Paulim', '../profile_pictures/profile_pic2.png','12345','paulo@gmail.com');
INSERT INTO USER (Name, Username, ProfilePic, Password, Email) VALUES ('Simao','Simaum', '../profile_pictures/profile_pic3.png','12345','simao@gmail.com');
INSERT INTO USER (Name, Username, ProfilePic, Password, Email) VALUES ('Ana', 'Aninha', '../profile_pictures/profile_pic4.png', '12345', 'ana@gmail.com');
INSERT INTO USER (Name, Username, ProfilePic, Password, Email) VALUES ('Carlos', 'Carlinhos', '../profile_pictures/profile_pic5.png', '12345', 'carlos@gmail.com');
INSERT INTO USER (Name, Username, ProfilePic, Password, Email) VALUES ('Maria', 'Mariinha', '../profile_pictures/profile_pic6.png', '12345', 'maria@gmail.com');

-- Populate SIZE table
INSERT INTO SIZE (Size) VALUES ('Small');
INSERT INTO SIZE (Size) VALUES ('Medium');
INSERT INTO SIZE (Size) VALUES ('Large');

-- Populate CONDITION table
INSERT INTO CONDITION (Condition) VALUES ('Fair');
INSERT INTO CONDITION (Condition) VALUES ('Good');
INSERT INTO CONDITION (Condition) VALUES ('Very Good');
INSERT INTO CONDITION (Condition) VALUES ('Excellent/Like New');

-- Populate CATEGORY table
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Tops', '../category_images/tops.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Bottoms', '../category_images/bottoms.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Dresses', '../category_images/dresses.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Outerwear', '../category_images/outerwear.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Active/Sportswear', '../category_images/sportswear.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Swimwear', '../category_images/swimwear.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Accessories', '../category_images/accessories.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Footwear', '../category_images/footwear.png');
INSERT INTO CATEGORY (CategoryName, CategoryImage) VALUES ('Formal wear', '../category_images/formalwear.png');

-- Populate ITEM table
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (2, 'Striped T-shirt', 15.99, 'Classic black and white striped t-shirt.', 'Very Good', 'Small', 'Nike', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (2, 'Skinny Jeans', 29.99, 'Blue denim skinny jeans.', 'Good', 'Medium', 'Levi''s', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (3, 'Floral Dress', 39.99, 'Flowy floral print dress.', 'Excellent/Like New', 'Medium', 'Zara', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (3, 'Hooded Jacket', 49.99, 'Black hooded jacket for casual wear.', 'Fair', 'Large', 'Adidas', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (4, 'Plaid Shirt', 19.99, 'Casual plaid shirt for everyday wear.', 'Very Good', 'Small', 'Gap', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (4, 'Denim Shorts', 24.99, 'Classic denim shorts for summer.', 'Good', 'Small', 'Old Navy', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (4, 'Striped Sweater', 34.99, 'Cozy striped sweater for chilly days.', 'Very Good', 'Medium', 'H&M', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (5, 'Maxi Skirt', 29.99, 'Long flowy skirt for a bohemian look.', 'Excellent/Like New', 'Small', 'Forever 21', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (5, 'Polo Shirt', 22.99, 'Classic polo shirt for a preppy style.', 'Good', 'Small', 'Ralph Lauren', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (5, 'Cargo Pants', 39.99, 'Functional cargo pants with multiple pockets.', 'Fair', 'Medium', 'Columbia', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (6, 'Leather Jacket', 99.99, 'Stylish leather jacket for a timeless look.', 'Good', 'Large', 'Guess', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (6, 'Ruffle Blouse', 27.99, 'Feminine ruffle blouse with floral print.', 'Very Good', 'Small', 'Zara', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (6, 'Athletic Leggings', 19.99, 'Stretchy athletic leggings for workouts.', 'Good', 'Medium', 'Nike', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (2, 'Graphic T-shirt', 14.99, 'Cool graphic print t-shirt for casual wear.', 'Very Good', 'Small', 'Urban Outfitters', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (3, 'Vintage Denim Jacket', 59.99, 'Classic vintage denim jacket with distressed details.', 'Excellent/Like New', 'L', 'Wrangler', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (2, 'V-neck Sweater', 39.99, 'Soft v-neck sweater for a cozy feel.', 'Very Good', 'Medium', 'Gap', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (2, 'Chino Pants', 34.99, 'Classic chino pants for a polished look.', 'Good', 'Medium', 'Dockers', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (3, 'Wrap Dress', 49.99, 'Versatile wrap dress for any occasion.', 'Excellent/Like New', 'Medium', 'H&M', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (3, 'Parka Jacket', 79.99, 'Stylish parka jacket for winter warmth.', 'Good', 'Large', 'The North Face', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (4, 'Crop Top', 19.99, 'Trendy crop top for a fashionable look.', 'Very Good', 'Small', 'Forever 21', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (4, 'Cargo Shorts', 29.99, 'Cargo shorts with plenty of pockets.', 'Good', 'Small', 'American Eagle', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (4, 'Hoodie', 44.99, 'Comfy hoodie for casual days.', 'Very Good', 'Medium', 'Old Navy', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (5, 'Ankle Boots', 59.99, 'Stylish ankle boots for everyday wear.', 'Excellent/Like New', 'Large', 'Steve Madden', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (5, 'Button-down Shirt', 24.99, 'Classic button-down shirt for a smart look.', 'Good', 'Small', 'Banana Republic', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (5, 'Cargo Jacket', 69.99, 'Functional cargo jacket for outdoor adventures.', 'Fair', 'Large', 'Patagonia', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (6, 'Boho Dress', 54.99, 'Bohemian-style dress for a free-spirited vibe.', 'Good', 'Medium', 'Free People', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (6, 'Distressed Jeans', 44.99, 'Trendy distressed jeans for a casual look.', 'Very Good', 'Medium', 'American Eagle', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (6, 'Sneakers', 79.99, 'Versatile sneakers for everyday comfort.', 'Excellent/Like New', 'Medium', 'Nike', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (2, 'Graphic Hoodie', 34.99, 'Cool graphic print hoodie for a trendy look.', 'Good', 'Medium', 'Hollister', '../images/striped_tshirt.webp');
INSERT INTO ITEM (UserId, Title, Price, Description, Condition, Size, Brand, ImagePath) VALUES (3, 'Leather Boots', 89.99, 'Classic leather boots for timeless style.', 'Excellent/Like New', 'Medium', 'Timberland', '../images/striped_tshirt.webp');

-- Populate ITEM_CATEGORY table
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 1);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Bottoms', 2);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Dresses', 3);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Outerwear', 4);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 5);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Bottoms', 6);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 7);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Bottoms', 8);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 9);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Bottoms', 10);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Outerwear', 11);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 12);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Bottoms', 13);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 14);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Outerwear', 15);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 16);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Bottoms', 17);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Dresses', 18);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Outerwear', 19);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 20);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Bottoms', 21);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 22);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Footwear', 23);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 24);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Outerwear', 25);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Dresses', 26);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Bottoms', 27);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Footwear', 28);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Tops', 29);
INSERT INTO ITEM_CATEGORY (CategoryId, ItemId) VALUES ('Footwear', 30);

-- Populate IMAGE table
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 1);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 2);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 3);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 4);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 5);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 6);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 7);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 8);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 9);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 10);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 11);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 12);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 13);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 14);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 15);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 16);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 17);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 18);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 19);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 20);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 21);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 22);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 23);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 24);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 25);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 26);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 27);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 28);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 29);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 30);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 1);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 2);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 3);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 4);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 5);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 6);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 7);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 8);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 9);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 10);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 29);
INSERT INTO IMAGE (Path, ItemId) VALUES ('../images/striped_tshirt_1.webp', 30);


-- Populate WISHLIST table
INSERT INTO WISHLIST (UserId, ItemId) VALUES (2, 1);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (2, 3);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (2, 5);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (3, 7);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (3, 9);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (3, 11);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (4, 13);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (4, 15);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (4, 17);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (5, 19);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (5, 21);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (5, 23);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (6, 25);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (6, 27);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (6, 29);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (7, 2);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (7, 4);
INSERT INTO WISHLIST (UserId, ItemId) VALUES (7, 6);

-- Populate CART table
INSERT INTO CART (UserId, ItemId) VALUES (2, 2);
INSERT INTO CART (UserId, ItemId) VALUES (2, 4);
INSERT INTO CART (UserId, ItemId) VALUES (2, 6);
INSERT INTO CART (UserId, ItemId) VALUES (3, 8);
INSERT INTO CART (UserId, ItemId) VALUES (3, 10);
INSERT INTO CART (UserId, ItemId) VALUES (3, 12);
INSERT INTO CART (UserId, ItemId) VALUES (4, 14);
INSERT INTO CART (UserId, ItemId) VALUES (4, 16);
INSERT INTO CART (UserId, ItemId) VALUES (4, 18);
INSERT INTO CART (UserId, ItemId) VALUES (5, 20);
INSERT INTO CART (UserId, ItemId) VALUES (5, 22);
INSERT INTO CART (UserId, ItemId) VALUES (5, 24);
INSERT INTO CART (UserId, ItemId) VALUES (6, 26);
INSERT INTO CART (UserId, ItemId) VALUES (6, 28);
INSERT INTO CART (UserId, ItemId) VALUES (6, 30);
