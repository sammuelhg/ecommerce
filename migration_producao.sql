-- =====================================================
-- LOSFIT MIGRATION SCRIPT - PRODUCAO HOSTINGER
-- Gerado em: 2025-12-05
-- 
-- INSTRUCOES:
-- 1. Acesse phpMyAdmin da Hostinger
-- 2. Selecione o banco: u488238372_losfit
-- 3. Va em "Importar"
-- 4. Selecione este arquivo
-- 5. Clique em "Executar"
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;

-- Limpar tabelas existentes (usar DELETE ao invés de TRUNCATE para evitar erros de FK)
DELETE FROM `wishlist_items`;
DELETE FROM `cart_items`;
DELETE FROM `order_items`;
DELETE FROM `orders`;
DELETE FROM `product_images`;
DELETE FROM `product_bundles`;
DELETE FROM `product_variations`;
DELETE FROM `products`;
DELETE FROM `product_colors`;
DELETE FROM `product_sizes`;
DELETE FROM `product_types`;
DELETE FROM `product_models`;
DELETE FROM `product_materials`;
DELETE FROM `product_groups`;
DELETE FROM `categories`;
DELETE FROM `users`;
DELETE FROM `sessions`;
DELETE FROM `password_reset_tokens`;
DELETE FROM `store_settings`;
DELETE FROM `cache`;
DELETE FROM `cache_locks`;
DELETE FROM `migrations`;

-- ============================================
-- CATEGORIAS
-- ============================================
INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'ModaFit', 'fit', 'Moda fitness, roupas e acessórios para treino e atividades físicas', 1, '2025-11-30 05:14:13', '2025-11-30 05:14:13'),
(2, NULL, 'ModaPraia', 'praia', 'Biquínis, maiôs, sungas, saídas de praia e acessórios para a praia', 1, '2025-11-30 05:14:13', '2025-11-30 05:14:13'),
(3, NULL, 'ModaCrochê', 'croche', 'Peças artesanais em crochê: roupas, bolsas, chapéus e acessórios para casa', 1, '2025-11-30 05:14:13', '2025-11-30 05:14:13'),
(4, NULL, 'Suplementos', 'suplementos', 'Encontre a maior variedade de Suplementos Alimentares, vitaminas, proteínas e produtos nutricionais das melhores marcas, incluindo a nossa linha exclusiva LosfitNutri.', 1, '2025-11-30 05:14:13', '2025-11-30 05:14:13'),
(5, 4, 'LosfitNutri', 'losfitnutri', 'Marca própria de suplementos', 1, '2025-11-30 12:13:10', '2025-12-04 02:15:06');

-- ============================================
-- CORES
-- ============================================
INSERT INTO `product_colors` (`id`, `name`, `code`, `hex_code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Preto', 'PRT', '#000000', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(2, 'Azul', 'AZL', '#0000FF', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(3, 'Rosa', 'ROS', '#FFC0CB', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(4, 'Verde', 'VRD', '#008000', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(5, 'Cinza', 'CIN', '#808080', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(6, 'Vermelho', 'VER', '#FF0000', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(7, 'Amarelo', 'AMA', '#FFFF00', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(8, 'Colorido', 'COL', '#FFFFFF', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(9, 'Bege', 'BEG', '#F5F5DC', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(10, 'Branco', 'BRA', '#FFFFFF', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(11, 'Marrom', 'MAR', '#A52A2A', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(12, 'Baunilha', 'BAU', '#F3E5AB', 1, '2025-12-02 15:13:50', '2025-12-02 16:03:28'),
(13, 'Transparente', 'TRA', '#FFFFFF', 1, '2025-12-02 15:13:50', '2025-12-02 16:03:05'),
(14, 'Bonina', 'BON', '#DC143C', 1, '2025-12-02 15:13:50', '2025-12-02 15:42:31'),
(15, 'Limão', 'LIM', '#00FF00', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(16, 'Natural', 'NAT', '#F0E68C', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(17, 'Chocolate', 'CHO', '#661f00', 1, '2025-12-03 14:20:31', '2025-12-03 14:20:31');

-- ============================================
-- TAMANHOS
-- ============================================
INSERT INTO `product_sizes` (`id`, `name`, `code`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'P', 'P', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(2, 'M', 'M', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(3, 'G', 'G', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(4, 'GG', 'GG', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(5, 'Único', 'UNI', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(6, '1kg', '1KG', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(7, '300g', '300G', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(8, '250g', '250G', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(9, '120 cápsulas', '120C', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(10, '60 cápsulas', '60C', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50');

-- ============================================
-- TIPOS DE PRODUTO
-- ============================================
INSERT INTO `product_types` (`id`, `name`, `code`, `is_active`, `created_at`, `updated_at`) VALUES
(31, 'Kit', 'KIT', 1, '2025-12-02 15:13:22', '2025-12-02 15:13:22'),
(32, 'Camiseta', 'CAM', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(33, 'Legging', 'LEG', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(34, 'Top', 'TOP', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(35, 'Short', 'SHO', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(36, 'Jaqueta', 'JAQ', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(37, 'Biquíni', 'BIQ', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(38, 'Sunga', 'SUN', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(39, 'Maiô', 'MAI', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(40, 'Short Praia', 'SHP', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(41, 'Canga', 'CAN', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(42, 'Blusa', 'BLU', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(43, 'Saia', 'SAI', 1, '2025-12-02 15:13:49', '2025-12-02 15:13:49'),
(44, 'Vestido', 'VES', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(45, 'Whey Protein', 'WHE', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(46, 'Creatina', 'CRE', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(47, 'Pré-Treino', 'PRE', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(48, 'BCAA', 'BCA', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(49, 'Multivitamínico', 'MUL', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50');

-- ============================================
-- MODELOS DE PRODUTO
-- ============================================
INSERT INTO `product_models` (`id`, `name`, `code`, `is_active`, `created_at`, `updated_at`) VALUES
(41, 'DryFit', 'DRY', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(42, 'High Waist', 'HWA', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(43, 'Racerback', 'RAC', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(44, 'Running', 'RUN', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(45, 'Corta-Vento', 'CVT', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(46, 'Cortininha', 'CTN', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(47, 'Slip', 'SLP', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(48, 'Frente Única', 'FUN', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(49, 'Surf', 'SRF', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(50, 'Retangular', 'RET', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(51, 'Boho', 'BOH', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(52, 'Halter', 'HAL', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(53, 'Midi', 'MID', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(54, 'Tradicional', 'TRD', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(55, 'Longo', 'LNG', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(56, 'Concentrado', 'CON', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(57, 'Monohidratada', 'MNH', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(58, 'Booster', 'BST', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(59, '2:1:1', '211', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(60, 'Complexo', 'CPX', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50');

-- ============================================
-- MATERIAIS
-- ============================================
INSERT INTO `product_materials` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(33, 'Poliéster', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(34, 'Poliamida', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(35, 'Elastano', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(36, 'Microfibra', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(37, 'Nylon', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(38, 'Lycra', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(39, 'Lycra Premium', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(40, 'Viscose', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(41, 'Linha Premium', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(42, 'Algodão', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(43, 'Barbante', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(44, 'Linha Soft', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(45, 'Algodão Natural', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(46, 'Soro de Leite', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(47, 'Creatina Pura', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(48, 'Cafeína', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(49, 'Aminoácidos', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50'),
(50, 'Vitaminas e Minerais', 1, '2025-12-02 15:13:50', '2025-12-02 15:13:50');

-- ============================================
-- SUPER ADMIN - sammuelhg@gmail.com
-- ============================================
INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `google_id`, `facebook_id`, `phone`, `taxvat`, `address`, `birth_date`, `is_admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sammuel Henrique', 'sammuelhg@gmail.com', NULL, NULL, NULL, '(31) 99416-1000', NULL, NULL, NULL, 1, NOW(), '$2y$10$6FopYpf/m1DPRItmI4FXMuwm4.KMp5kFHyabR8OSatsVLQ.8j.uIq', NULL, NOW(), NOW());

-- ============================================
-- PRODUTOS (sem product_group_id - coluna não existe em produção)
-- ============================================
INSERT INTO `products` (`id`, `category_id`, `product_type_id`, `product_model_id`, `product_material_id`, `product_color_id`, `product_size_id`, `color`, `attribute`, `size`, `brand`, `name`, `slug`, `sku`, `ean`, `description`, `marketing_description`, `price`, `compare_at_price`, `cost_price`, `old_price`, `stock`, `weight`, `height`, `width`, `length`, `is_active`, `condition`, `warranty`, `origin`, `ncm`, `is_offer`, `image`, `created_at`, `updated_at`) VALUES
(79, 5, 45, 56, 46, 17, 6, '', '', '', NULL, 'Whey Protein Concentrado Em Soro De Leite – Chocolate Tamanho 1kg', 'whey-protein-concentrado-em-soro-de-leite-chocolate-tamanho-1kg', 'SUP-WHE-0001-CHO-1KG', NULL, '', '', 80.00, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930b6bf61925_1764800191.webp', '2025-12-04 01:16:31', '2025-12-04 01:16:34'),
(80, 5, 45, 56, 46, 12, 6, 'Baunilha', NULL, '1kg', NULL, 'Whey Protein Concentrado Em Soro De Leite – Baunilha Tamanho 1kg', 'whey-protein-concentrado-em-soro-de-leite-baunilha-tamanho-1kg', 'SUP-WHE-0002-BAU-1KG', NULL, '', '', 80.00, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930bccacc57a_1764801738.webp', '2025-12-04 01:30:26', '2025-12-04 01:42:18'),
(81, 5, 45, 56, 46, 15, 6, 'Natural', NULL, '1kg', NULL, 'Whey Protein Concentrado Em Soro De Leite – Limão Tamanho 1kg', 'whey-protein-concentrado-em-soro-de-leite-limao-tamanho-1kg', 'SUP-WHE-0003-LIM-1KG', NULL, '', '', 80.00, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930bfd8db337_1764802520.webp', '2025-12-04 01:31:19', '2025-12-04 01:55:21'),
(82, 4, 45, 56, 46, 16, 6, 'Natural', NULL, '1kg', NULL, 'Whey Protein Concentrado Em Soro De Leite – Natural Tamanho 1kg', 'whey-protein-concentrado-em-soro-de-leite-natural-tamanho-1kg', 'SUP-WHE-0009-NAT-1KG', NULL, '', '', 80.00, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930bfbe67e40_1764802494.webp', '2025-12-04 01:49:54', '2025-12-04 02:09:57'),
(83, 3, 42, 48, 43, 3, 3, '', 'Exuberante trançada', '', NULL, 'Blusa Frente Única Em Barbante Exuberante Trançada – Rosa Tamanho G', 'blusa-frente-unica-em-barbante-exuberante-trancada-rosa-tamanho-g', 'CRO-BLU-0005-ROS-G', NULL, '', '', 150.00, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c2ba9254b_1764803258.webp', '2025-12-04 01:58:32', '2025-12-04 02:07:38'),
(84, 3, 42, 48, 43, 4, 3, 'Verde', 'Exuberante trançada', 'G', NULL, 'Blusa Frente Única Em Barbante Exuberante Trançada – Verde Tamanho G', 'blusa-frente-unica-em-barbante-exuberante-trancada-verde-tamanho-g', 'CRO-BLU-0006-VRD-G', NULL, '', '', 150.00, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c2d45248a_1764803284.webp', '2025-12-04 01:59:22', '2025-12-04 02:08:04'),
(85, 3, 42, 48, 43, 2, 3, 'Azul', 'Exuberante trançada', 'G', NULL, 'Blusa Frente Única Em Barbante Exuberante Trançada – Azul Tamanho G', 'blusa-frente-unica-em-barbante-exuberante-trancada-azul-tamanho-g', 'CRO-BLU-0007-AZU-G', NULL, '', '', 150.00, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c2ea9a0a1_1764803306.webp', '2025-12-04 02:03:23', '2025-12-04 02:08:26'),
(86, 3, 42, 54, 45, 1, 1, 'Preto', 'Elegante', 'G', NULL, 'Blusa Tradicional Em Algodão Natural Elegante – Preto Tamanho P', 'blusa-tradicional-em-algodao-natural-elegante-preto-tamanho-p', 'CRO-BLU-0008-PRT-P', NULL, '', '', 150.00, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c3013ff64_1764803329.webp', '2025-12-04 02:05:22', '2025-12-04 02:08:49'),
(87, 2, 37, 49, 39, 10, 2, '', 'Super confortável', '', NULL, 'Biquíni Surf Em Lycra Premium Super Confortável – Branco Tamanho M', 'biquini-surf-em-lycra-premium-super-confortavel-branco-tamanho-m', 'PRA-BIQ-0010-BRA-M', NULL, '', '', 70.00, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c5d742191_1764804055.webp', '2025-12-04 02:18:04', '2025-12-04 02:34:56'),
(88, 2, 37, 49, 39, 7, 3, 'Amarelo', 'Super confortável', 'G', NULL, 'Biquíni Surf Em Lycra Premium Super Confortável – Amarelo Tamanho G', 'biquini-surf-em-lycra-premium-super-confortavel-amarelo-tamanho-g', 'PRA-BIQ-0011-AMA-G', NULL, '', '', 70.00, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c8e099054_1764804832.webp', '2025-12-04 02:18:33', '2025-12-04 02:33:52'),
(89, 2, 37, 49, 39, 3, 1, 'Rosa', 'Super confortável', 'P', NULL, 'Biquíni Surf Em Lycra Premium Super Confortável – Rosa Tamanho P', 'biquini-surf-em-lycra-premium-super-confortavel-rosa-tamanho-p', 'PRA-BIQ-0012-ROS-P', NULL, '', '', 70.00, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c9685b57d_1764804968.webp', '2025-12-04 02:19:05', '2025-12-04 02:36:08'),
(90, 2, 37, 49, 39, 1, 1, 'Preto', 'Super confortável', 'P', NULL, 'Biquíni Surf Em Lycra Premium Super Confortável – Preto Tamanho P', 'biquini-surf-em-lycra-premium-super-confortavel-preto-tamanho-p', 'PRA-BIQ-0013-PRT-P', NULL, '', '', 70.00, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, NULL, '2025-12-04 02:19:38', '2025-12-04 02:36:59'),
(91, 1, 33, 41, 36, 5, 2, '', 'Brilhe na Academia', '', NULL, 'Legging Dryfit Em Microfibra Brilhe Na Academia – Cinza Tamanho M', 'legging-dryfit-em-microfibra-brilhe-na-academia-cinza-tamanho-m', 'FIT-LEG-0014-CIN-M', NULL, '', '', 128.99, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/ai-generated/pollinations_6930cc24ae7f2_1764805668.jpg', '2025-12-04 02:45:26', '2025-12-04 02:47:58'),
(92, 1, 33, 41, 36, 8, 2, 'Colorido', 'Brilhe na Academia', 'M', NULL, 'Legging Dryfit Em Microfibra Brilhe Na Academia – Colorido Tamanho M', 'legging-dryfit-em-microfibra-brilhe-na-academia-colorido-tamanho-m', 'FIT-LEG-0015-COL-M', NULL, '', '', 128.99, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/ai-generated/pollinations_6930cc614dc6b_1764805729.jpg', '2025-12-04 02:45:55', '2025-12-04 02:48:56'),
(93, 1, 33, 41, 36, 6, 2, 'Vermelho', 'Brilhe na Academia', 'M', NULL, 'Legging Dryfit Em Microfibra Brilhe Na Academia – Vermelho Tamanho M', 'legging-dryfit-em-microfibra-brilhe-na-academia-vermelho-tamanho-m', 'FIT-LEG-0016-VER-M', NULL, '', '', 128.99, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/ai-generated/pollinations_6930cc82db029_1764805762.jpg', '2025-12-04 02:46:15', '2025-12-04 02:49:30'),
(94, 1, 33, 41, 36, 4, 5, 'Vermelho', 'Brilhe na Academia', 'Único', NULL, 'Legging Dryfit Em Microfibra Brilhe Na Academia – Verde Tamanho Único', 'legging-dryfit-em-microfibra-brilhe-na-academia-verde-tamanho-unico', 'FIT-LEG-0017-VRD-UNI', NULL, '', '', 128.99, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/ai-generated/pollinations_6930cca770f96_1764805799.jpg', '2025-12-04 02:46:33', '2025-12-04 02:50:03');

-- ============================================
-- IMAGENS DOS PRODUTOS
-- ============================================
INSERT INTO `product_images` (`id`, `product_id`, `path`, `is_main`, `order`, `created_at`, `updated_at`) VALUES
(19, 79, 'products/6930b6bf61925_1764800191.webp', 1, 0, '2025-12-04 01:16:34', '2025-12-04 01:16:34'),
(25, 80, 'products/6930bccacc57a_1764801738.webp', 1, 0, '2025-12-04 01:42:18', '2025-12-04 01:42:18'),
(29, 82, 'products/6930bfbe67e40_1764802494.webp', 1, 0, '2025-12-04 01:54:54', '2025-12-04 01:54:54'),
(30, 81, 'products/6930bfd8db337_1764802520.webp', 1, 0, '2025-12-04 01:55:21', '2025-12-04 01:55:21'),
(37, 83, 'products/6930c2ba9254b_1764803258.webp', 1, 0, '2025-12-04 02:07:38', '2025-12-04 02:07:38'),
(38, 84, 'products/6930c2d45248a_1764803284.webp', 1, 0, '2025-12-04 02:08:04', '2025-12-04 02:08:04'),
(39, 85, 'products/6930c2ea9a0a1_1764803306.webp', 1, 0, '2025-12-04 02:08:26', '2025-12-04 02:08:26'),
(40, 86, 'products/6930c3013ff64_1764803329.webp', 1, 0, '2025-12-04 02:08:49', '2025-12-04 02:08:49'),
(42, 87, 'products/6930c5d742191_1764804055.webp', 1, 0, '2025-12-04 02:20:55', '2025-12-04 02:20:55'),
(45, 88, 'products/6930c8e099054_1764804832.webp', 1, 0, '2025-12-04 02:33:52', '2025-12-04 02:33:52'),
(48, 89, 'products/6930c9685b57d_1764804968.webp', 1, 0, '2025-12-04 02:36:08', '2025-12-04 02:36:08'),
(49, 90, 'products/ai-generated/pollinations_6930c993418bf_1764805011.jpg', 1, 1, '2025-12-04 02:36:51', '2025-12-04 02:36:51'),
(50, 91, 'products/ai-generated/pollinations_6930cc24ae7f2_1764805668.jpg', 1, 1, '2025-12-04 02:47:48', '2025-12-04 02:47:48'),
(51, 92, 'products/ai-generated/pollinations_6930cc614dc6b_1764805729.jpg', 1, 1, '2025-12-04 02:48:49', '2025-12-04 02:48:49'),
(52, 93, 'products/ai-generated/pollinations_6930cc82db029_1764805762.jpg', 1, 1, '2025-12-04 02:49:22', '2025-12-04 02:49:22'),
(53, 94, 'products/ai-generated/pollinations_6930cca770f96_1764805799.jpg', 1, 1, '2025-12-04 02:49:59', '2025-12-04 02:49:59');

-- ============================================
-- CONFIGURACOES DA LOJA
-- ============================================
INSERT INTO `store_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'store_address', 'Rua das Academias\r\nBelo Horizonte', 'text', '2025-12-02 15:59:07', '2025-12-03 22:57:45'),
(2, 'store_cnpj', '125489547562', 'text', '2025-12-02 15:59:07', '2025-12-03 22:20:23'),
(3, 'color_primary', '#00008a', 'color', '2025-12-02 15:59:07', '2025-12-03 04:02:22'),
(4, 'color_secondary', '#6c757d', 'color', '2025-12-02 15:59:07', '2025-12-02 15:59:07'),
(5, 'color_accent', '#ffc107', 'color', '2025-12-02 15:59:07', '2025-12-02 15:59:07'),
(6, 'color_background', '#ffffff', 'color', '2025-12-02 15:59:07', '2025-12-02 16:00:13'),
(7, 'store_phone', '31994161000', 'text', '2025-12-03 22:57:45', '2025-12-03 22:57:45'),
(9, 'color_category_bar', '#f5f7ff', 'color', '2025-12-03 22:57:45', '2025-12-04 01:46:46'),
(11, 'modal_about', 'A Losfit é uma marca criada para quem busca estilo, conforto e autenticidade.', 'text', '2025-12-04 00:41:54', '2025-12-04 00:41:54'),
(13, 'modal_contact', 'WhatsApp: (31) 99416-1000 | Email: contato@losfit.com.br', 'text', '2025-12-04 00:41:54', '2025-12-04 00:41:54');

-- ============================================
-- MIGRATIONS (sincronizar com producao)
-- ============================================
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_11_28_000018_create_categories_table', 1),
(5, '2025_11_28_000019_create_products_table', 1),
(6, '2025_11_28_000020_create_orders_table', 1),
(7, '2025_11_28_000021_create_order_items_table', 1),
(8, '2025_11_28_064046_add_is_admin_to_users_table', 1),
(9, '2025_11_28_071659_add_profile_fields_to_users_table', 1),
(10, '2025_11_28_090000_add_offer_fields_to_products_table', 1),
(11, '2025_11_29_121312_add_marketing_description_to_products_table', 1),
(12, '2025_11_29_122156_add_marketplace_fields_to_products_table', 1),
(13, '2025_11_29_212123_create_product_variations_table', 1),
(14, '2025_11_29_212125_add_indexes_to_products_table', 1),
(15, '2025_11_29_212500_add_gtin_to_product_variations_table', 1),
(16, '2025_11_29_213204_create_product_types_table', 1),
(17, '2025_11_29_213208_create_product_materials_table', 1),
(18, '2025_11_29_213210_create_product_models_table', 1),
(19, '2025_11_29_221855_add_product_attributes_to_products_table', 1),
(20, '2025_11_29_235046_add_description_to_categories_table', 2),
(21, '2025_11_30_002255_add_social_fields_to_users_table', 3),
(32, '2025_11_30_013416_create_cart_items_table', 4),
(33, '2025_11_30_013416_create_wishlist_items_table', 4),
(34, '2025_11_30_023424_create_store_settings_table', 4),
(35, '2025_11_30_075455_add_attribute_to_products_table', 4),
(36, '2025_11_30_085650_add_parent_id_to_categories_table', 4),
(37, '2025_11_30_103000_create_product_bundles_table', 4),
(38, '2025_12_01_012555_create_product_images_table', 4),
(39, '2025_12_01_110539_add_pricing_fields_to_products_table', 4),
(40, '2025_12_02_115601_create_product_colors_table', 4),
(41, '2025_12_02_115604_create_product_sizes_table', 4),
(42, '2025_12_02_160328_add_color_and_size_ids_to_products_table', 5),
(43, '2025_12_02_174500_add_parent_product_to_products_table', 6),
(44, '2025_12_02_194050_create_product_groups_table', 6),
(45, '2025_12_02_194052_add_product_group_id_to_products_table', 6),
(46, '2025_12_04_001904_add_taxvat_to_users_table', 7),
(47, '2025_12_04_091317_add_oauth_columns_to_users_table', 8),
(49, '2025_12_04_091702_add_oauth_columns_to_users_table', 9),
(50, '2025_12_04_093100_add_avatar_to_users_table', 10);

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

-- =====================================================
-- FIM DO SCRIPT
-- LEMBRE-SE: Apos importar, faca upload das imagens!
-- Pasta local: storage/app/public/products/
-- Pasta remota: ~/domains/losfit.com.br/public_html/storage/app/public/products/
-- =====================================================
