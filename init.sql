CREATE DATABASE IF NOT EXISTS advertisement_db;
USE advertisement_db;

CREATE TABLE IF NOT EXISTS advertisements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ad_title VARCHAR(255) NOT NULL,
    ad_category VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    contact_email VARCHAR(100) NOT NULL,
    ad_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO advertisements (ad_title, ad_category, price, contact_email, ad_text) VALUES
('Продам ноутбук HP', 'Электроника', 25000.00, 'seller@example.com', 'Отличное состояние, б/у 1 год.'),
('Сниму квартиру в центре', 'Недвижимость', 30000.00, 'rent@example.com', 'Ищу 2-х комнатную квартиру в центре города.');