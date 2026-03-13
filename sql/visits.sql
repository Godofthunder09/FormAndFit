CREATE TABLE cu_visits (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    visit_time DATETIME NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    region VARCHAR(255),
    city VARCHAR(255),
    country_code VARCHAR(10),
    user_agent TEXT,
    landing_page VARCHAR(255),
    page_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Note: To populate 'region' and 'country_code', you would need to implement 
-- a GeoIP lookup service (like GeoLite2 or a third-party API) on your frontend 
-- tracking script, which is beyond the scope of this admin file.
-- The admin page assumes these fields are already available.