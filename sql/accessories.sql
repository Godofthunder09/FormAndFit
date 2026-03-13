CREATE TABLE accessories (
    id VARCHAR(100) PRIMARY KEY,           -- unique ID (used in URLs)
    name VARCHAR(255) NOT NULL,            -- accessory name
    price DECIMAL(10,2) NOT NULL, 
    description TEXT,                      -- product description
    image_url_1 VARCHAR(255) NOT NULL,     -- main image
    image_url_2 VARCHAR(255),              -- second image
    image_url_3 VARCHAR(255),              -- third image
    image_url_4 VARCHAR(255),              -- optional fourth image
    alt_text VARCHAR(255),                 -- alt text for image
    buy_link VARCHAR(500)                  -- external purchase link
);
