-- Residents Table
CREATE TABLE residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    location_id INT,
    age_group VARCHAR(50),
    gender VARCHAR(50),
    interests JSON,
    FOREIGN KEY (location_id) REFERENCES areas(id)
);

-- Areas Table
CREATE TABLE areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    local_council_id INT,
    FOREIGN KEY (local_council_id) REFERENCES local_councils(id)
);

-- Products Table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT,
    category VARCHAR(100),
    price DECIMAL(10, 2),
    health_benefits TEXT,
    certifications JSON,
    business_id INT,
    FOREIGN KEY (business_id) REFERENCES businesses(id)
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

-- Businesses Table
CREATE TABLE businesses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    contact_info TEXT
);

-- Local Councils Table
CREATE TABLE local_councils (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    contact_info TEXT
);

-- Certifications Table (Optional)
CREATE TABLE certifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    certification_name VARCHAR(255)
);


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    address VARCHAR(255),
    city VARCHAR(100),
    postcode VARCHAR(20),
    role ENUM('business', 'resident', 'council') NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE local_council (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    area_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE areas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    council_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    resident_count INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (council_id) REFERENCES local_council(id) ON DELETE CASCADE
);

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
    business_name VARCHAR(255) NOT NULL,
    registration_number VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
