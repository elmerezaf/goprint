ALTER TABLE category
ADD COLUMN cat_name_en VARCHAR(255) NULL AFTER cat_name,
ADD COLUMN cat_desc_en TEXT NULL AFTER cat_desc;
