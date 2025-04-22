-- Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NOT NULL,
    pricing_category ENUM('affordable', 'moderate', 'premium') NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    health_benefits TEXT NOT NULL,
    certifications TEXT NOT NULL,
    product_type ENUM('product', 'services') NOT NULL,
    quantity INT NOT NULL,
    business_id INT NOT NULL,
    prod_cat_id INT NOT NULL,
    FOREIGN KEY (business_id) REFERENCES businesses(id),
    FOREIGN KEY (prod_cat_id) REFERENCES product_category(id)
);

-- Product Category Table
CREATE TABLE product_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL
);

-- Residents Interest Table
CREATE TABLE residents_interest (
    prod_cat_id INT,
    resident_id INT,
    PRIMARY KEY (prod_cat_id, resident_id),
    FOREIGN KEY (prod_cat_id) REFERENCES product_category(id),
    FOREIGN KEY (resident_id) REFERENCES residents(id)
);

-- Votes Table
CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resident_id INT,
    product_id INT,
    vote BOOLEAN,
    FOREIGN KEY (resident_id) REFERENCES residents(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) UNIQUE NOT NULL,
    address VARCHAR(255),
    city VARCHAR(100),
    postcode VARCHAR(20),
    role ENUM('business', 'resident', 'council') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Local Council Table
CREATE TABLE local_council (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Areas Table
CREATE TABLE areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    council_id INT NOT NULL,
    name VARCHAR(255) UNIQUE NOT NULL,
    resident_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (council_id) REFERENCES local_council(id) ON DELETE CASCADE
);

-- Residents Table
CREATE TABLE residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    age_group VARCHAR(10) NOT NULL,
    user_id INT NOT NULL,
    area_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (area_id) REFERENCES areas(id) ON DELETE CASCADE
);

CREATE TABLE businesses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    business_name VARCHAR(255) UNIQUE NOT NULL,
    registration_number VARCHAR(255) UNIQUE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
.


-- Product Category Table
CREATE TABLE product_category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL
);


-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) UNIQUE NOT NULL,
    address VARCHAR(255),
    city VARCHAR(100),
    postcode VARCHAR(20),
    role ENUM('business', 'resident', 'council') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- business
CREATE TABLE businesses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    business_name VARCHAR(255) UNIQUE NOT NULL,
    registration_number VARCHAR(255) UNIQUE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);




-- products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE,
    description TEXT,
    pricing_category ENUM('affordable', 'moderate', 'premium') NOT NULL,
    price DECIMAL(10, 2),
    health_benefits TEXT,
    certifications TEXT,
    product_type ENUM('product', 'services') NOT NULL,
    quantity INT,
    image_name VARCHAR(25),
    business_id INT,
    prod_cat_id INT,
    FOREIGN KEY (business_id) REFERENCES businesses(id),
    FOREIGN KEY (prod_cat_id) REFERENCES product_category(id)
);


-- Local Council Table
CREATE TABLE local_council (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
-- Areas Table
CREATE TABLE areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    council_id INT NOT NULL,
    name VARCHAR(255) UNIQUE NOT NULL,
    resident_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (council_id) REFERENCES local_council(id) ON DELETE CASCADE
);


-- Residents Table
CREATE TABLE residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    age_group VARCHAR(10) NOT NULL,
    user_id INT NOT NULL,
    area_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (area_id) REFERENCES areas(id) ON DELETE CASCADE
);

-- Residents Interest Table
CREATE TABLE residents_interest (
    prod_cat_id INT,
    resident_id INT,
    PRIMARY KEY (prod_cat_id, resident_id),
    FOREIGN KEY (prod_cat_id) REFERENCES product_category(id),
    FOREIGN KEY (resident_id) REFERENCES residents(id)
);

-- Votes Table
CREATE TABLE votes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resident_id INT NOT NULL,
    product_id INT NOT NULL,
    vote BOOLEAN NOT NULL,
    FOREIGN KEY (resident_id) REFERENCES residents(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- ALTER TABLE votes
-- ADD UNIQUE KEY resident_product_unique (resident_id, product_id);