-- Create scammers table
CREATE TABLE scammers (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    Telegram_Name TEXT,
    Twitter TEXT,
    Name TEXT,
    Whatsapp TEXT,
    Binance_ID TEXT,
    USDT_Address TEXT,
    BTC_Address TEXT,
    Paypal_ID TEXT,
    Email TEXT,
    Notes TEXT
);

-- Create admin users table
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
);

-- Insert default admin user (username: admin, password: admin)
INSERT INTO users (username, password) VALUES (
    'admin',
    '$2y$10$3d2DKi9TGBSmxrdG8RGLqOV5NHmW0ENdCavM8TbGnE8M52co/ROmG'
);
