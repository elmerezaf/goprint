-- 為 orders 表添加結帳所需欄位
-- 請在 phpMyAdmin 或 MySQL CLI 中執行此 SQL

ALTER TABLE orders
    ADD COLUMN IF NOT EXISTS address VARCHAR(255) NULL AFTER email,
    ADD COLUMN IF NOT EXISTS city VARCHAR(255) NULL AFTER address,
    ADD COLUMN IF NOT EXISTS postal_code VARCHAR(255) NULL AFTER city,
    ADD COLUMN IF NOT EXISTS payment_method VARCHAR(255) NOT NULL DEFAULT 'stripe' AFTER postal_code,
    ADD COLUMN IF NOT EXISTS shipping_method VARCHAR(255) NOT NULL DEFAULT 'standard' AFTER payment_method,
    ADD COLUMN IF NOT EXISTS notes TEXT NULL AFTER shipping_method,
    ADD COLUMN IF NOT EXISTS design_token VARCHAR(255) NULL AFTER notes,
    ADD COLUMN IF NOT EXISTS printing_side VARCHAR(255) NOT NULL DEFAULT '單面' AFTER material,
    ADD COLUMN IF NOT EXISTS binding VARCHAR(255) NOT NULL DEFAULT '無' AFTER printing_side;

-- 執行完後可以用以下 SQL 確認欄位是否添加成功：
-- SHOW COLUMNS FROM orders;
