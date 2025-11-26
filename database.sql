CREATE DATABASE IF NOT EXISTS toko_cendawan;
USE toko_cendawan;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE,
  password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS suppliers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(150),
  alamat TEXT,
  kontak VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode VARCHAR(50) UNIQUE,
  nama VARCHAR(200),
  kategori VARCHAR(100),
  harga DECIMAL(12,2),
  stok INT DEFAULT 0,
  id_supplier INT,
  FOREIGN KEY (id_supplier) REFERENCES suppliers(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS sales (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
  total DECIMAL(14,2)
);

CREATE TABLE IF NOT EXISTS sales_detail (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_sale INT,
  id_product INT,
  qty INT,
  subtotal DECIMAL(14,2),
  FOREIGN KEY (id_sale) REFERENCES sales(id) ON DELETE CASCADE,
  FOREIGN KEY (id_product) REFERENCES products(id)
);

-- default admin
INSERT INTO users (username, password) VALUES ('admin', 'admin123')
ON DUPLICATE KEY UPDATE username=username;
