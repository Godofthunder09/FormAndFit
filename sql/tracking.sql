CREATE TABLE product_clicks (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NULL COMMENT 'The ID of the logged-in customer (NULL if not logged in)',
    customer_name VARCHAR(255) NULL COMMENT 'The name of the customer if logged in (for quick reporting)',
    product_id VARCHAR(50) NOT NULL COMMENT 'The unique ID of the product clicked',
    product_name VARCHAR(255) NOT NULL,
    product_category VARCHAR(50) NOT NULL COMMENT 'e.g., hoodies, accessories, tshirts',
    click_type ENUM('buy', 'share') NOT NULL COMMENT 'Type of interaction: buy or share',
    click_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ip_address VARCHAR(45) NOT NULL COMMENT 'User IP address (for region estimation)',
    region_info VARCHAR(255) NULL COMMENT 'Optional: For storing geo-location derived from IP'
);