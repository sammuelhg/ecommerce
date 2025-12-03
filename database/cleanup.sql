-- Database Cleanup Script
-- Preserves: categories (fit, praia, croche, suplementos) and Kit product type
-- RUN THIS FROM MySQL CLIENT OR phpMyAdmin

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Delete all products and related data
DELETE FROM product_bundles;
DELETE FROM product_images;
DELETE FROM cart_items;
DELETE FROM order_items;
DELETE FROM products;

-- 2. Delete categories except preserved ones
DELETE FROM categories 
WHERE slug NOT IN ('fit', 'praia', 'croche', 'suplementos');

-- 3. Delete materials
DELETE FROM product_materials;

-- 4. Delete models
DELETE FROM product_models;

-- 5. Delete types except Kit
DELETE FROM product_types 
WHERE slug != 'kit' AND name != 'Kit';

SET FOREIGN_KEY_CHECKS = 1;

-- Verify preserved data
SELECT 'Categories:' as table_name, id, name, slug FROM categories;
SELECT 'Types:' as table_name, id, name, slug FROM product_types WHERE slug = 'kit' OR name = 'Kit';
