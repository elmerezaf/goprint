ALTER TABLE product
ADD COLUMN pro_name_en VARCHAR(255) NULL AFTER pro_name,
ADD COLUMN pro_desc_en TEXT NULL AFTER pro_desc;
