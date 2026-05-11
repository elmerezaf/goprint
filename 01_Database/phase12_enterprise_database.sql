-- ======================
-- GoPrint Enterprise Database
-- Manual SQL Development | Foreign Key Constraints
-- For Hong Kong Users (Traditional Chinese)
-- ======================
CREATE DATABASE IF NOT EXISTS goprint_db DEFAULT CHARSET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE goprint_db;

-- 1. Product Category Table
CREATE TABLE category (
    cat_id INT PRIMARY KEY AUTO_INCREMENT COMMENT '分類ID',
    cat_name VARCHAR(50) NOT NULL COMMENT '分類名稱',
    cat_desc TEXT COMMENT '分類描述',
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT '創建時間'
) COMMENT='印刷產品分類';

-- 2. Product Table
CREATE TABLE product (
    pro_id INT PRIMARY KEY AUTO_INCREMENT COMMENT '產品ID',
    cat_id INT NOT NULL COMMENT '所屬分類ID',
    pro_name VARCHAR(100) NOT NULL COMMENT '產品名稱',
    pro_price DECIMAL(10,2) NOT NULL COMMENT '單價',
    pro_stock INT DEFAULT 999 COMMENT '庫存',
    pro_desc TEXT COMMENT '產品詳情',
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT '上架時間',
    FOREIGN KEY (cat_id) REFERENCES category(cat_id) ON DELETE CASCADE
) COMMENT='印刷產品列表';

-- 3. Customer Table
CREATE TABLE customer (
    cus_id INT PRIMARY KEY AUTO_INCREMENT COMMENT '客戶ID',
    cus_name VARCHAR(50) NOT NULL COMMENT '客戶姓名',
    cus_phone VARCHAR(20) UNIQUE NOT NULL COMMENT '手機號',
    cus_email VARCHAR(100) COMMENT '郵箱',
    cus_address TEXT COMMENT '地址',
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT '註冊時間'
) COMMENT='客戶資訊';

-- 4. Order Master Table (Core Business Table)
CREATE TABLE orders (
    order_id VARCHAR(32) PRIMARY KEY COMMENT '訂單編號',
    cus_id INT NOT NULL COMMENT '客戶ID',
    order_amount DECIMAL(10,2) NOT NULL COMMENT '訂單總金額',
    order_status TINYINT DEFAULT 0 COMMENT '0待支付 1已支付 2已完成 3已取消',
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT '下單時間',
    FOREIGN KEY (cus_id) REFERENCES customer(cus_id) ON DELETE CASCADE
) COMMENT='訂單主表';

-- 5. Order Item Table
CREATE TABLE order_item (
    item_id INT PRIMARY KEY AUTO_INCREMENT COMMENT '明細ID',
    order_id VARCHAR(32) NOT NULL COMMENT '訂單編號',
    pro_id INT NOT NULL COMMENT '產品ID',
    pro_num INT NOT NULL COMMENT '購買數量',
    pro_price DECIMAL(10,2) NOT NULL COMMENT '下單時單價',
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (pro_id) REFERENCES product(pro_id) ON DELETE CASCADE
) COMMENT='訂單商品明細';

-- 6. Website Message Table
CREATE TABLE message (
    msg_id INT PRIMARY KEY AUTO_INCREMENT COMMENT '留言ID',
    msg_name VARCHAR(50) NOT NULL COMMENT '留言人',
    msg_email VARCHAR(100) NOT NULL COMMENT '郵箱',
    msg_content TEXT NOT NULL COMMENT '留言內容',
    msg_status TINYINT DEFAULT 0 COMMENT '0未讀 1已讀',
    create_time DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT '留言時間'
) COMMENT='客戶留言反饋';

-- 7. Admin User Table
CREATE TABLE admin (
    admin_id INT PRIMARY KEY AUTO_INCREMENT COMMENT '管理員ID',
    admin_user VARCHAR(50) UNIQUE NOT NULL COMMENT '賬號',
    admin_pwd VARCHAR(255) NOT NULL COMMENT '密碼',
    admin_role VARCHAR(20) DEFAULT 'admin' COMMENT '角色'
) COMMENT='系統管理員';

-- ======================
-- Insert Test Data (Traditional Chinese for HK Users)
-- ======================
INSERT INTO category (cat_name, cat_desc) VALUES 
('商務印刷','名片、單張、畫冊、書刊'),
('包裝設計','禮盒、包裝袋、標籤、彩盒');

INSERT INTO product (cat_id, pro_name, pro_price, pro_desc) VALUES
(1,'高檔名片印刷',98.00,'300g銅版紙 雙面彩色印刷'),
(1,'A4宣傳單打印',150.00,'1000張 高清快速印刷'),
(2,'產品包裝盒',299.00,'定制瓦楞紙包裝 免費設計');

INSERT INTO customer (cus_name, cus_phone, cus_email) VALUES
('陳大文','13800138000','chan@test.com'),
('李小明','13900139000','lee@test.com');

INSERT INTO admin (admin_user, admin_pwd) VALUES ('admin','123456');