-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 09/12/2025 às 15:32
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ecommerce_hp`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('7b52009b64fd0a2a49e6d8a939753077792b0554', 'i:1;', 1765285821),
('7b52009b64fd0a2a49e6d8a939753077792b0554:timer', 'i:1765285821;', 1765285821),
('902ba3cda1883801594b6e1b452790cc53948fda', 'i:1;', 1765278878),
('902ba3cda1883801594b6e1b452790cc53948fda:timer', 'i:1765278878;', 1765278878);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `campaign_opens`
--

CREATE TABLE `campaign_opens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `newsletter_campaign_id` bigint(20) UNSIGNED NOT NULL,
  `newsletter_email_id` bigint(20) UNSIGNED DEFAULT NULL,
  `newsletter_subscriber_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, NULL, 'ModaFit', 'fit', 'Moda fitness, roupas e acessórios para treino e atividades físicas', 1, '2025-11-30 05:14:13', '2025-11-30 05:14:13'),
(2, NULL, 'ModaPraia', 'praia', 'Biquínis, maiôs, sungas, saídas de praia e acessórios para a praia', 1, '2025-11-30 05:14:13', '2025-11-30 05:14:13'),
(3, NULL, 'ModaCrochê', 'croche', 'Peças artesanais em crochê: roupas, bolsas, chapéus e acessórios para casa', 1, '2025-11-30 05:14:13', '2025-11-30 05:14:13'),
(4, NULL, 'Suplementos', 'suplementos', 'Encontre a maior variedade de Suplementos Alimentares, vitaminas, proteínas e produtos nutricionais das melhores marcas, incluindo a nossa linha exclusiva LosfitNutri.', 1, '2025-11-30 05:14:13', '2025-11-30 05:14:13'),
(5, 4, 'LosfitNutri', 'losfitnutri', 'Marca própria de suplementos', 1, '2025-11-30 12:13:10', '2025-12-04 02:15:06');

-- --------------------------------------------------------

--
-- Estrutura para tabela `email_cards`
--

CREATE TABLE `email_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_role` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `whatsapp` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `email_cards`
--

INSERT INTO `email_cards` (`id`, `name`, `sender_name`, `sender_role`, `instagram`, `whatsapp`, `website`, `slogan`, `photo`, `is_default`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Dra. Jacqueline Maria Bergsten', 'Dra. Jacqueline Maria Bergsten', 'CEO - Loja losfit.com.br', 'losfit1000', '', 'www.losfit.com.br', 'Saúde • Foco • Resultado', 'email-cards/693760a839a53_1765236904.jpg', 1, 1, '2025-12-05 19:26:08', '2025-12-09 08:24:38'),
(3, 'loja', 'Loja Losfit ', 'Moda Fit, Moda Praia, Moda Crochê, Acessórios e Suplementos', 'losfit1000', NULL, 'losfit.com.br', 'A Elegância veste o conforto e a saúde!', NULL, 0, 1, '2025-12-05 20:42:59', '2025-12-09 01:10:07'),
(4, 'João Marcos', 'João Marcos', 'Estrategista Digital', '', '', '', '', 'email-cards/693337cb374ca_1764964299.jpg', 0, 1, '2025-12-05 21:25:22', '2025-12-09 08:24:38'),
(5, 'Sammuel Gomes', 'Sammuel Gomes', 'Tecnologia e Web Marketing', 'onlinesammuel', '31994161000', 'sammuel.com.br', 'Fazendo a mágica acontecer!', 'email-cards/693339bbd4ff6_1764964795.jpg', 0, 1, '2025-12-05 22:05:32', '2025-12-09 08:24:27'),
(6, 'testecard', 'testecard', 'testecardcargo', 'testecardinsta', '31994161000', 'sammuel.com.br', 'vamos deploy!', 'email-cards/69376630cc52d_1765238320.png', 0, 1, '2025-12-09 02:58:02', '2025-12-09 08:24:16');

-- --------------------------------------------------------

--
-- Estrutura para tabela `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `body`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Camp1', 'camp1venda', '<!DOCTYPE html>\n<html lang=\"pt-BR\">\n<head>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n    <title>Sua Campanha</title>\n    <style>\n        /* Reset básico */\n        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }\n        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }\n        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }\n        table { border-collapse: collapse !important; }\n        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }\n\n        /* Estilos do Botão */\n        .button-link {\n            background-color: #007bff; /* Cor do botão */\n            color: #ffffff !important;\n            text-decoration: none;\n            padding: 12px 24px;\n            border-radius: 5px;\n            display: inline-block;\n            font-weight: bold;\n        }\n        \n        /* Media Queries para Mobile */\n        @media screen and (max-width: 600px) {\n            .email-container { width: 100% !important; }\n            .fluid-img { width: 100% !important; max-width: 100% !important; height: auto !important; }\n            .padding-mobile { padding-left: 15px !important; padding-right: 15px !important; }\n        }\n    </style>\n</head>\n<body style=\"margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;\">\n\n    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n        <tr>\n            <td style=\"padding: 20px 0; text-align: center;\">\n                \n                <table role=\"presentation\" class=\"email-container\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" style=\"margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);\">\n                    \n                    <tr>\n                        <td style=\"background-color: #333333; padding: 30px; text-align: center; color: #ffffff;\">\n                            <h1 style=\"margin: 0; font-size: 24px;\">SUA LOGO AQUI</h1>\n                        </td>\n                    </tr>\n\n                    <tr>\n                        <td class=\"padding-mobile\" style=\"padding: 40px 30px; text-align: left; color: #555555; line-height: 1.6;\">\n                            \n                            <h2 style=\"color: #333333; margin-top: 0;\">Olá, {{ $user->name }}!</h2>\n                            \n                            <p>Esperamos que você esteja bem.</p>\n                            \n                            <p>Estamos entrando em contato para apresentar nossa nova campanha exclusiva para você. Preparamos algo especial que vai ajudar você a alcançar seus objetivos.</p>\n                            \n                            <p>Não perca a oportunidade de conferir as novidades que acabaram de chegar.</p>\n\n                            <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 30px 0;\">\n                                <tr>\n                                    <td align=\"center\" style=\"border-radius: 5px;\" bgcolor=\"#007bff\">\n                                        <a href=\"https://seu-site.com.br\" class=\"button-link\" target=\"_blank\" style=\"font-family: Arial, sans-serif; font-size: 16px;\">\n                                            CONFIRMAR MEU INTERESSE\n                                        </a>\n                                    </td>\n                                </tr>\n                            </table>\n\n                            <p>Se tiver alguma dúvida, basta responder a este e-mail.</p>\n                            \n                            <p style=\"margin-bottom: 0;\">Atenciosamente,<br><strong>Equipe da Empresa</strong></p>\n                        </td>\n                    </tr>\n\n                    <tr>\n                        <td style=\"background-color: #eeeeee; padding: 20px; text-align: center; font-size: 12px; color: #888888;\">\n                            <p style=\"margin: 0 0 10px 0;\">&copy; 2024 Nome da Sua Empresa. Todos os direitos reservados.</p>\n                            \n                            <p style=\"margin: 0;\">\n                                Este e-mail foi enviado para: \n                                <a href=\"mailto:{{ $user->email }}\" style=\"color: #007bff; text-decoration: none;\">{{ $user->email }}</a>\n                            </p>\n                            \n                            <p style=\"margin-top: 10px;\">\n                                <a href=\"#\" style=\"color: #888888; text-decoration: underline;\">Descadastrar</a>\n                            </p>\n                        </td>\n                    </tr>\n\n                </table>\n                </td>\n        </tr>\n    </table>\n\n</body>\n</html>', 'vendas', '2025-12-09 12:43:55', '2025-12-09 12:43:55');

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `grid_rules`
--

CREATE TABLE `grid_rules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` int(10) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `col_span` int(11) NOT NULL DEFAULT 1,
  `configuration` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`configuration`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `grid_rules`
--

INSERT INTO `grid_rules` (`id`, `position`, `type`, `col_span`, `configuration`, `is_active`, `created_at`, `updated_at`) VALUES
(18, 5, 'card.newsletter_form', 3, '{\"text_color\":\"text-dark\",\"bg_color\":\"bg-light\",\"image\":\"newsletter-assets\\/FFtMRXBFHgtWkaEGG6RsPcb38qSMM0fGs1gNO79B.png\",\"campaign_id\":\"2\",\"title\":\"Newsletter\",\"text\":\"<p class=\\\"text-dark small lh-sm\\\">\\n                                 Ganhe <strong class=\\\"text-danger\\\">15% OFF<\\/strong> na 1\\u00aa compra!\\n                 <\\/p>\",\"button_text\":\"QUERO MEU DESCONTO\",\"btn_color\":\"btn-success\"}', 1, '2025-12-09 07:00:38', '2025-12-09 14:38:37'),
(20, 9, 'marketing_banner', 2, '{\"text_color\":\"text-white\",\"bg_color\":\"bg-primary\",\"image\":\"newsletter-assets\\/yiHRPOdoa4rx1a16hGVulYjajY2gFo4XG9Zzsy5Z.png\",\"image_style\":\"background\",\"title\":\"Promo\\u00e7\\u00e3o do coqueiro\",\"text\":\"Ganhe um coqueiro de pel\\u00facia! Me pergunte como!\",\"link\":\"http:\\/\\/localhost:8000\\/admin\\/grid\",\"bg_class\":\"bg-primary text-white\",\"btn_color\":\"btn-danger\",\"button_text\":\"Ver Oferta!\"}', 1, '2025-12-09 13:23:43', '2025-12-09 16:55:16'),
(21, 2, 'card.product_highlight', 1, '{\"product_id\":81}', 1, '2025-12-09 14:42:25', '2025-12-09 14:43:40'),
(22, 3, 'card.product_special', 1, '{\"product_id\":79,\"badge_type\":\"best_buy\"}', 1, '2025-12-09 14:45:09', '2025-12-09 14:46:32');

-- --------------------------------------------------------

--
-- Estrutura para tabela `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(2, 'default', '{\"uuid\":\"95b7cf35-2086-4839-903f-3e10650dc514\",\"displayName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\RecordCampaignOpen\\\":4:{s:10:\\\"campaignId\\\";i:1;s:12:\\\"subscriberId\\\";i:1;s:9:\\\"ipAddress\\\";s:9:\\\"127.0.0.1\\\";s:9:\\\"userAgent\\\";s:111:\\\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\\\";}\"},\"createdAt\":1765159504,\"delay\":null}', 0, NULL, 1765159504, 1765159504),
(3, 'default', '{\"uuid\":\"40ef373a-d978-4cba-877e-98270ccd5e02\",\"displayName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\RecordCampaignOpen\\\":4:{s:10:\\\"campaignId\\\";i:1;s:12:\\\"subscriberId\\\";i:1;s:9:\\\"ipAddress\\\";s:9:\\\"127.0.0.1\\\";s:9:\\\"userAgent\\\";s:111:\\\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\\\";}\"},\"createdAt\":1765159522,\"delay\":null}', 0, NULL, 1765159522, 1765159522),
(4, 'default', '{\"uuid\":\"0142c09c-9974-48eb-947b-76913ed81147\",\"displayName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\RecordCampaignOpen\\\":4:{s:10:\\\"campaignId\\\";i:1;s:12:\\\"subscriberId\\\";i:1;s:9:\\\"ipAddress\\\";s:9:\\\"127.0.0.1\\\";s:9:\\\"userAgent\\\";s:111:\\\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\\\";}\"},\"createdAt\":1765159557,\"delay\":null}', 0, NULL, 1765159557, 1765159557),
(5, 'default', '{\"uuid\":\"158a68e2-d6cd-40b4-9de4-22c66e255da5\",\"displayName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\RecordCampaignOpen\\\":4:{s:10:\\\"campaignId\\\";i:1;s:12:\\\"subscriberId\\\";i:1;s:9:\\\"ipAddress\\\";s:9:\\\"127.0.0.1\\\";s:9:\\\"userAgent\\\";s:111:\\\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\\\";}\"},\"createdAt\":1765159565,\"delay\":null}', 0, NULL, 1765159565, 1765159565),
(6, 'default', '{\"uuid\":\"3f4a8186-7a35-45ab-9a60-54ad6d21aab7\",\"displayName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\RecordCampaignOpen\\\":4:{s:10:\\\"campaignId\\\";i:1;s:12:\\\"subscriberId\\\";i:1;s:9:\\\"ipAddress\\\";s:9:\\\"127.0.0.1\\\";s:9:\\\"userAgent\\\";s:111:\\\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\\\";}\"},\"createdAt\":1765159596,\"delay\":null}', 0, NULL, 1765159596, 1765159596),
(7, 'default', '{\"uuid\":\"16de7e3f-e0b2-4b9b-955d-9b5f03cbc15f\",\"displayName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\RecordCampaignOpen\\\":4:{s:10:\\\"campaignId\\\";i:1;s:12:\\\"subscriberId\\\";i:1;s:9:\\\"ipAddress\\\";s:9:\\\"127.0.0.1\\\";s:9:\\\"userAgent\\\";s:111:\\\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\\\";}\"},\"createdAt\":1765161462,\"delay\":null}', 0, NULL, 1765161462, 1765161462),
(8, 'default', '{\"uuid\":\"6682f8d2-5f24-463e-a81c-5f7925de9d63\",\"displayName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\RecordCampaignOpen\\\":4:{s:10:\\\"campaignId\\\";i:1;s:12:\\\"subscriberId\\\";i:1;s:9:\\\"ipAddress\\\";s:9:\\\"127.0.0.1\\\";s:9:\\\"userAgent\\\";s:111:\\\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\\\";}\"},\"createdAt\":1765161698,\"delay\":null}', 0, NULL, 1765161698, 1765161698),
(9, 'default', '{\"uuid\":\"8aade814-2948-4092-889b-e1293965e375\",\"displayName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\RecordCampaignOpen\",\"command\":\"O:27:\\\"App\\\\Jobs\\\\RecordCampaignOpen\\\":4:{s:10:\\\"campaignId\\\";i:1;s:12:\\\"subscriberId\\\";i:1;s:9:\\\"ipAddress\\\";s:9:\\\"127.0.0.1\\\";s:9:\\\"userAgent\\\";s:111:\\\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\\\";}\"},\"createdAt\":1765208699,\"delay\":null}', 0, NULL, 1765208699, 1765208699);

-- --------------------------------------------------------

--
-- Estrutura para tabela `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `utm_source` varchar(255) DEFAULT NULL,
  `utm_medium` varchar(255) DEFAULT NULL,
  `utm_campaign` varchar(255) DEFAULT NULL,
  `utm_content` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `link_items`
--

CREATE TABLE `link_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` text DEFAULT NULL,
  `color` varchar(50) DEFAULT 'white',
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `link_items`
--

INSERT INTO `link_items` (`id`, `title`, `url`, `icon`, `color`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Visite nosso Site Oficial', 'https://losfit.com.br', '<i class=\"bi bi-house\"></i>', 'gold', 1, 1, '2025-12-05 23:32:34', '2025-12-09 02:02:48'),
(2, 'WhatsApp (31) 99416-1000', 'https://wa.me/5531994161000', '<i class=\"bi bi-whatsapp\"></i>', 'green', 2, 1, '2025-12-05 23:32:34', '2025-12-06 00:25:35'),
(3, 'Instagram', 'https://www.instagram.com/losfit1000', '<i class=\"bi bi-instagram\"></i>', 'instagram', 3, 1, '2025-12-05 23:32:34', '2025-12-06 01:28:39'),
(4, 'Ver Catálogo Completo', 'https://losfit.com.br/loja', '<i class=\"bi bi-bag-heart\"></i>', 'black', 4, 1, '2025-12-05 23:32:34', '2025-12-09 02:03:09'),
(9, 'Promoções de Natal', 'http://losfit/presentes', '<i class=\"bi bi-gift\"></i>', 'white', 5, 1, '2025-12-06 01:53:04', '2025-12-08 01:17:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

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
(50, '2025_12_04_093100_add_avatar_to_users_table', 10),
(51, '2025_12_05_153826_create_email_cards_table', 11),
(52, '2025_12_05_174744_add_photo_to_email_cards_table', 12),
(53, '2025_12_05_191324_add_whatsapp_to_email_cards_table', 13),
(54, '2025_12_05_201711_create_link_items_table', 14),
(55, '2025_12_05_204410_add_icon_to_link_items_table', 15),
(56, '2025_12_05_210014_change_icon_column_to_text_in_link_items', 16),
(57, '2025_12_05_222444_change_color_to_string_in_link_items', 17),
(58, '2025_12_06_103407_add_card_type_to_products_table', 18),
(59, '2025_12_06_104916_create_grid_rules_table', 19),
(60, '2025_12_06_142529_create_newsletter_subscribers_table', 20),
(61, '2025_12_06_142548_create_newsletter_campaigns_table', 20),
(63, '2025_12_06_144803_add_source_to_newsletter_subscribers_table', 21),
(64, '2025_12_07_222638_create_campaign_opens_table', 22),
(65, '2025_12_08_095151_create_stories_table', 23),
(66, '2025_12_08_213908_create_leads_table', 24),
(67, '2025_12_09_025815_add_utm_columns_to_leads_and_subscribers_tables', 25),
(68, '2025_12_09_040506_add_card_and_products_to_campaigns_table', 26),
(70, '2025_12_09_050458_add_slug_to_newsletter_campaigns_table', 27),
(71, '2025_12_09_053229_create_newsletter_sequences_tables', 28),
(72, '2025_12_09_054134_add_promo_image_to_newsletter_campaigns', 28),
(73, '2025_12_09_055326_create_newsletter_campaign_subscriber_table', 28);

-- --------------------------------------------------------

--
-- Estrutura para tabela `newsletter_campaigns`
--

CREATE TABLE `newsletter_campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email_card_id` bigint(20) UNSIGNED DEFAULT NULL,
  `promo_image_url` varchar(255) DEFAULT NULL,
  `show_promo_image_in_email` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `newsletter_campaigns`
--

INSERT INTO `newsletter_campaigns` (`id`, `subject`, `slug`, `sent_at`, `status`, `created_at`, `updated_at`, `email_card_id`, `promo_image_url`, `show_promo_image_in_email`) VALUES
(2, 'teste1', 'teste1', '2025-12-08 13:45:59', 'sent', '2025-12-08 13:45:38', '2025-12-09 13:04:25', NULL, '/storage/newsletter-promos/Xa7UAO40HvwRauDJog1XCQEkP0UASaeonXbSXwPW.png', 1),
(3, 'teste2', 'teste2', NULL, 'draft', '2025-12-09 05:41:22', '2025-12-09 16:09:47', NULL, '/storage/newsletter-promos/ihL7ahR1AZxfVm9vnJJtuWAfrPjEE4HKBit9zB1u.png', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `newsletter_campaign_subscriber`
--

CREATE TABLE `newsletter_campaign_subscriber` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `newsletter_campaign_id` bigint(20) UNSIGNED NOT NULL,
  `newsletter_subscriber_id` bigint(20) UNSIGNED NOT NULL,
  `current_email_id` bigint(20) UNSIGNED DEFAULT NULL,
  `started_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_email_sent_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `newsletter_emails`
--

CREATE TABLE `newsletter_emails` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `newsletter_campaign_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `delay_in_hours` int(11) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `newsletter_emails`
--

INSERT INTO `newsletter_emails` (`id`, `newsletter_campaign_id`, `subject`, `body`, `delay_in_hours`, `sort_order`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 'teste1', '<!DOCTYPE html>\n<html lang=\"pt-BR\">\n<head>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n    <title>Sua Campanha</title>\n    <style>\n        /* Reset básico */\n        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }\n        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }\n        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }\n        table { border-collapse: collapse !important; }\n        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }\n\n        /* Estilos do Botão */\n        .button-link {\n            background-color: #007bff; /* Cor do botão */\n            color: #ffffff !important;\n            text-decoration: none;\n            padding: 12px 24px;\n            border-radius: 5px;\n            display: inline-block;\n            font-weight: bold;\n        }\n        \n        /* Media Queries para Mobile */\n        @media screen and (max-width: 600px) {\n            .email-container { width: 100% !important; }\n            .fluid-img { width: 100% !important; max-width: 100% !important; height: auto !important; }\n            .padding-mobile { padding-left: 15px !important; padding-right: 15px !important; }\n        }\n    </style>\n</head>\n<body style=\"margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;\">\n\n    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n        <tr>\n            <td style=\"padding: 20px 0; text-align: center;\">\n                \n                <table role=\"presentation\" class=\"email-container\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" style=\"margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);\">\n                    \n                    <tr>\n                        <td style=\"background-color: #333333; padding: 30px; text-align: center; color: #ffffff;\">\n                            <h1 style=\"margin: 0; font-size: 24px;\">SUA LOGO AQUI</h1>\n                        </td>\n                    </tr>\n\n                    <tr>\n                        <td class=\"padding-mobile\" style=\"padding: 40px 30px; text-align: left; color: #555555; line-height: 1.6;\">\n                            \n                            <h2 style=\"color: #333333; margin-top: 0;\">Olá, {{ $user->name }}!</h2>\n                            \n                            <p>Esperamos que você esteja bem.</p>\n                            \n                            <p>Estamos entrando em contato para apresentar nossa nova campanha exclusiva para você. Preparamos algo especial que vai ajudar você a alcançar seus objetivos.</p>\n                            \n                            <p>Não perca a oportunidade de conferir as novidades que acabaram de chegar.</p>\n\n                            <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 30px 0;\">\n                                <tr>\n                                    <td align=\"center\" style=\"border-radius: 5px;\" bgcolor=\"#007bff\">\n                                        <a href=\"https://seu-site.com.br\" class=\"button-link\" target=\"_blank\" style=\"font-family: Arial, sans-serif; font-size: 16px;\">\n                                            CONFIRMAR MEU INTERESSE\n                                        </a>\n                                    </td>\n                                </tr>\n                            </table>\n\n                            <p>Se tiver alguma dúvida, basta responder a este e-mail.</p>\n                            \n                            <p style=\"margin-bottom: 0;\">Atenciosamente,<br><strong>Equipe da Empresa</strong></p>\n                        </td>\n                    </tr>\n\n                    <tr>\n                        <td style=\"background-color: #eeeeee; padding: 20px; text-align: center; font-size: 12px; color: #888888;\">\n                            <p style=\"margin: 0 0 10px 0;\">&copy; 2024 Nome da Sua Empresa. Todos os direitos reservados.</p>\n                            \n                            <p style=\"margin: 0;\">\n                                Este e-mail foi enviado para: \n                                <a href=\"mailto:{{ $user->email }}\" style=\"color: #007bff; text-decoration: none;\">{{ $user->email }}</a>\n                            </p>\n                            \n                            <p style=\"margin-top: 10px;\">\n                                <a href=\"#\" style=\"color: #888888; text-decoration: underline;\">Descadastrar</a>\n                            </p>\n                        </td>\n                    </tr>\n\n                </table>\n                </td>\n        </tr>\n    </table>\n\n</body>\n</html>', 0, 0, 'sent', '2025-12-08 13:45:38', '2025-12-09 08:23:50'),
(3, 3, 'teste2', '', 0, 0, 'draft', '2025-12-09 05:41:22', '2025-12-09 08:08:03'),
(7, 2, 'teste1 - Passo 4', '', 24, 3, 'pending', '2025-12-09 12:51:47', '2025-12-09 12:51:47'),
(8, 2, 'teste1 - Passo 3', '', 24, 2, 'pending', '2025-12-09 13:02:58', '2025-12-09 13:02:58'),
(9, 3, 'camp1venda', '<!DOCTYPE html>\n<html lang=\"pt-BR\">\n<head>\n    <meta charset=\"UTF-8\">\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n    <title>Sua Campanha</title>\n    <style>\n        /* Reset básico */\n        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }\n        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }\n        img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }\n        table { border-collapse: collapse !important; }\n        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; }\n\n        /* Estilos do Botão */\n        .button-link {\n            background-color: #007bff; /* Cor do botão */\n            color: #ffffff !important;\n            text-decoration: none;\n            padding: 12px 24px;\n            border-radius: 5px;\n            display: inline-block;\n            font-weight: bold;\n        }\n        \n        /* Media Queries para Mobile */\n        @media screen and (max-width: 600px) {\n            .email-container { width: 100% !important; }\n            .fluid-img { width: 100% !important; max-width: 100% !important; height: auto !important; }\n            .padding-mobile { padding-left: 15px !important; padding-right: 15px !important; }\n        }\n    </style>\n</head>\n<body style=\"margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;\">\n\n    <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n        <tr>\n            <td style=\"padding: 20px 0; text-align: center;\">\n                \n                <table role=\"presentation\" class=\"email-container\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"600\" style=\"margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1);\">\n                    \n                    <tr>\n                        <td style=\"background-color: #333333; padding: 30px; text-align: center; color: #ffffff;\">\n                            <h1 style=\"margin: 0; font-size: 24px;\">SUA LOGO AQUI</h1>\n                        </td>\n                    </tr>\n\n                    <tr>\n                        <td class=\"padding-mobile\" style=\"padding: 40px 30px; text-align: left; color: #555555; line-height: 1.6;\">\n                            \n                            <h2 style=\"color: #333333; margin-top: 0;\">Olá, {{ $user->name }}!</h2>\n                            \n                            <p>Esperamos que você esteja bem.</p>\n                            \n                            <p>Estamos entrando em contato para apresentar nossa nova campanha exclusiva para você. Preparamos algo especial que vai ajudar você a alcançar seus objetivos.</p>\n                            \n                            <p>Não perca a oportunidade de conferir as novidades que acabaram de chegar.</p>\n\n                            <table role=\"presentation\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"margin: 30px 0;\">\n                                <tr>\n                                    <td align=\"center\" style=\"border-radius: 5px;\" bgcolor=\"#007bff\">\n                                        <a href=\"https://seu-site.com.br\" class=\"button-link\" target=\"_blank\" style=\"font-family: Arial, sans-serif; font-size: 16px;\">\n                                            CONFIRMAR MEU INTERESSE\n                                        </a>\n                                    </td>\n                                </tr>\n                            </table>\n\n                            <p>Se tiver alguma dúvida, basta responder a este e-mail.</p>\n                            \n                            <p style=\"margin-bottom: 0;\">Atenciosamente,<br><strong>Equipe da Empresa</strong></p>\n                        </td>\n                    </tr>\n\n                    <tr>\n                        <td style=\"background-color: #eeeeee; padding: 20px; text-align: center; font-size: 12px; color: #888888;\">\n                            <p style=\"margin: 0 0 10px 0;\">&copy; 2024 Nome da Sua Empresa. Todos os direitos reservados.</p>\n                            \n                            <p style=\"margin: 0;\">\n                                Este e-mail foi enviado para: \n                                <a href=\"mailto:{{ $user->email }}\" style=\"color: #007bff; text-decoration: none;\">{{ $user->email }}</a>\n                            </p>\n                            \n                            <p style=\"margin-top: 10px;\">\n                                <a href=\"#\" style=\"color: #888888; text-decoration: underline;\">Descadastrar</a>\n                            </p>\n                        </td>\n                    </tr>\n\n                </table>\n                </td>\n        </tr>\n    </table>\n\n</body>\n</html>', 24, 1, 'pending', '2025-12-09 15:46:26', '2025-12-09 16:00:36'),
(10, 3, 'teste2 - Passo 3', '3', 24, 2, 'pending', '2025-12-09 15:46:46', '2025-12-09 15:46:58');

-- --------------------------------------------------------

--
-- Estrutura para tabela `newsletter_email_product`
--

CREATE TABLE `newsletter_email_product` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `newsletter_email_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `newsletter_email_product`
--

INSERT INTO `newsletter_email_product` (`id`, `newsletter_email_id`, `product_id`, `sort_order`) VALUES
(1, 2, 79, 0),
(2, 2, 82, 1),
(3, 2, 83, 2),
(4, 2, 91, 3),
(5, 10, 80, 0),
(6, 10, 81, 1),
(7, 10, 82, 2),
(8, 3, 82, 0),
(9, 3, 81, 1),
(10, 3, 80, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL DEFAULT 'grid',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `utm_source` varchar(255) DEFAULT NULL,
  `utm_medium` varchar(255) DEFAULT NULL,
  `utm_campaign` varchar(255) DEFAULT NULL,
  `utm_content` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`id`, `email`, `source`, `is_active`, `created_at`, `updated_at`, `utm_source`, `utm_medium`, `utm_campaign`, `utm_content`) VALUES
(1, 'sammuelhg@gmail.com', 'grid', 1, '2025-12-06 17:31:04', '2025-12-06 17:31:04', NULL, NULL, NULL, NULL),
(2, 'vinocrata@gmail.com', 'grid', 1, '2025-12-06 17:35:46', '2025-12-06 17:35:46', NULL, NULL, NULL, NULL),
(3, 'losfit1000@gmail.com', 'footer', 1, '2025-12-07 23:09:43', '2025-12-09 05:36:34', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `total_price` decimal(10,2) NOT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('losfit1000@gmail.com', '$2y$12$e6MSbZnmDmaqeWSBC016ne4sGHpkznCj2FGRX.dz47kjBuUl0LUzO', '2025-12-07 23:46:48'),
('sammuelhg@gmail.com', '$2y$12$zOQtgWevrou6AtVDg06Q3elH8cIv0zZUypo.PjBz3F1rX2InS.EMK', '2025-12-07 22:40:04'),
('vinocrata@gmail.com', '$2y$12$T9V.GtMy4zo8t16/QIcCd.FhqnVRvsEDLfX5rpFOw/X6EpNiio2lC', '2025-12-07 23:46:19');

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `product_group_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_material_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_size_id` bigint(20) UNSIGNED DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `attribute` varchar(100) DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `ean` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `marketing_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_at_price` decimal(10,2) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `weight` decimal(8,3) DEFAULT NULL,
  `height` decimal(8,2) DEFAULT NULL,
  `width` decimal(8,2) DEFAULT NULL,
  `length` decimal(8,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `condition` enum('new','used','refurbished') NOT NULL DEFAULT 'new',
  `warranty` varchar(255) DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `ncm` varchar(255) DEFAULT NULL,
  `is_offer` tinyint(1) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `products`
--

INSERT INTO `products` (`id`, `category_id`, `product_group_id`, `product_type_id`, `product_model_id`, `product_material_id`, `product_color_id`, `product_size_id`, `color`, `attribute`, `size`, `brand`, `name`, `slug`, `sku`, `ean`, `description`, `marketing_description`, `price`, `compare_at_price`, `cost_price`, `old_price`, `stock`, `weight`, `height`, `width`, `length`, `is_active`, `condition`, `warranty`, `origin`, `ncm`, `is_offer`, `image`, `created_at`, `updated_at`) VALUES
(79, 5, NULL, 45, 56, 46, 17, 6, '', '', '', NULL, 'Whey Protein Concentrado Em Soro De Leite – Chocolate Tamanho 1kg', 'whey-protein-concentrado-em-soro-de-leite-chocolate-tamanho-1kg', 'SUP-WHE-0001-CHO-1KG', NULL, '', '', 80.00, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930b6bf61925_1764800191.webp', '2025-12-04 01:16:31', '2025-12-04 01:16:34'),
(80, 5, NULL, 45, 56, 46, 12, 6, 'Baunilha', NULL, '1kg', NULL, 'Whey Protein Concentrado Em Soro De Leite – Baunilha Tamanho 1kg', 'whey-protein-concentrado-em-soro-de-leite-baunilha-tamanho-1kg', 'SUP-WHE-0002-BAU-1KG', NULL, '', '', 80.00, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930bccacc57a_1764801738.webp', '2025-12-04 01:30:26', '2025-12-04 01:42:18'),
(81, 5, NULL, 45, 56, 46, 15, 6, 'Natural', NULL, '1kg', NULL, 'Whey Protein Concentrado Em Soro De Leite – Limão Tamanho 1kg', 'whey-protein-concentrado-em-soro-de-leite-limao-tamanho-1kg', 'SUP-WHE-0003-LIM-1KG', NULL, '', '', 80.00, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930bfd8db337_1764802520.webp', '2025-12-04 01:31:19', '2025-12-04 01:55:21'),
(82, 4, NULL, 45, 56, 46, 16, 6, 'Natural', NULL, '1kg', NULL, 'Whey Protein Concentrado Em Soro De Leite – Natural Tamanho 1kg', 'whey-protein-concentrado-em-soro-de-leite-natural-tamanho-1kg', 'SUP-WHE-0009-NAT-1KG', NULL, '', '', 80.00, NULL, NULL, NULL, 20, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930bfbe67e40_1764802494.webp', '2025-12-04 01:49:54', '2025-12-04 02:09:57'),
(83, 3, NULL, 42, 48, 43, 3, 3, '', 'Exuberante trançada', '', NULL, 'Blusa Frente Única Em Barbante Exuberante Trançada – Rosa Tamanho G', 'blusa-frente-unica-em-barbante-exuberante-trancada-rosa-tamanho-g', 'CRO-BLU-0005-ROS-G', NULL, '', '', 150.00, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c2ba9254b_1764803258.webp', '2025-12-04 01:58:32', '2025-12-04 02:07:38'),
(84, 3, NULL, 42, 48, 43, 4, 3, 'Verde', 'Exuberante trançada', 'G', NULL, 'Blusa Frente Única Em Barbante Exuberante Trançada – Verde Tamanho G', 'blusa-frente-unica-em-barbante-exuberante-trancada-verde-tamanho-g', 'CRO-BLU-0006-VRD-G', NULL, '', '', 150.00, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c2d45248a_1764803284.webp', '2025-12-04 01:59:22', '2025-12-04 02:08:04'),
(85, 3, NULL, 42, 48, 43, 2, 3, 'Azul', 'Exuberante trançada', 'G', NULL, 'Blusa Frente Única Em Barbante Exuberante Trançada – Azul Tamanho G', 'blusa-frente-unica-em-barbante-exuberante-trancada-azul-tamanho-g', 'CRO-BLU-0007-AZU-G', NULL, '', '', 150.00, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c2ea9a0a1_1764803306.webp', '2025-12-04 02:03:23', '2025-12-04 02:08:26'),
(86, 3, NULL, 42, 54, 45, 1, 1, 'Preto', 'Elegante', 'G', NULL, 'Blusa Tradicional Em Algodão Natural Elegante – Preto Tamanho P', 'blusa-tradicional-em-algodao-natural-elegante-preto-tamanho-p', 'CRO-BLU-0008-PRT-P', NULL, '', '', 150.00, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c3013ff64_1764803329.webp', '2025-12-04 02:05:22', '2025-12-04 02:08:49'),
(87, 2, NULL, 37, 49, 39, 10, 2, '', 'Super confortável', '', NULL, 'Biquíni Surf Em Lycra Premium Super Confortável – Branco Tamanho M', 'biquini-surf-em-lycra-premium-super-confortavel-branco-tamanho-m', 'PRA-BIQ-0010-BRA-M', NULL, '', '', 70.00, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c5d742191_1764804055.webp', '2025-12-04 02:18:04', '2025-12-04 02:34:56'),
(88, 2, NULL, 37, 49, 39, 7, 3, 'Amarelo', 'Super confortável', 'G', NULL, 'Biquíni Surf Em Lycra Premium Super Confortável – Amarelo Tamanho G', 'biquini-surf-em-lycra-premium-super-confortavel-amarelo-tamanho-g', 'PRA-BIQ-0011-AMA-G', NULL, '', '', 70.00, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c8e099054_1764804832.webp', '2025-12-04 02:18:33', '2025-12-04 02:33:52'),
(89, 2, NULL, 37, 49, 39, 3, 1, 'Rosa', 'Super confortável', 'P', NULL, 'Biquíni Surf Em Lycra Premium Super Confortável – Rosa Tamanho P', 'biquini-surf-em-lycra-premium-super-confortavel-rosa-tamanho-p', 'PRA-BIQ-0012-ROS-P', NULL, '', '', 70.00, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/6930c9685b57d_1764804968.webp', '2025-12-04 02:19:05', '2025-12-04 02:36:08'),
(90, 2, NULL, 37, 49, 39, 1, 1, 'Preto', 'Super confortável', 'P', NULL, 'Biquíni Surf Em Lycra Premium Super Confortável – Preto Tamanho P', 'biquini-surf-em-lycra-premium-super-confortavel-preto-tamanho-p', 'PRA-BIQ-0013-PRT-P', NULL, '', '', 70.00, NULL, NULL, NULL, 50, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, NULL, '2025-12-04 02:19:38', '2025-12-04 02:36:59'),
(91, 1, NULL, 33, 41, 36, 5, 2, '', 'Brilhe na Academia', '', NULL, 'Legging Dryfit Em Microfibra Brilhe Na Academia – Cinza Tamanho M', 'legging-dryfit-em-microfibra-brilhe-na-academia-cinza-tamanho-m', 'FIT-LEG-0014-CIN-M', NULL, '', '', 128.99, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/ai-generated/pollinations_6930cc24ae7f2_1764805668.jpg', '2025-12-04 02:45:26', '2025-12-04 02:47:58'),
(92, 1, NULL, 33, 41, 36, 8, 2, 'Colorido', 'Brilhe na Academia', 'M', NULL, 'Legging Dryfit Em Microfibra Brilhe Na Academia – Colorido Tamanho M', 'legging-dryfit-em-microfibra-brilhe-na-academia-colorido-tamanho-m', 'FIT-LEG-0015-COL-M', NULL, '', '', 128.99, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/ai-generated/pollinations_6930cc614dc6b_1764805729.jpg', '2025-12-04 02:45:55', '2025-12-04 02:48:56'),
(93, 1, NULL, 33, 41, 36, 6, 2, 'Vermelho', 'Brilhe na Academia', 'M', NULL, 'Legging Dryfit Em Microfibra Brilhe Na Academia – Vermelho Tamanho M', 'legging-dryfit-em-microfibra-brilhe-na-academia-vermelho-tamanho-m', 'FIT-LEG-0016-VER-M', NULL, '', '', 128.99, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/ai-generated/pollinations_6930cc82db029_1764805762.jpg', '2025-12-04 02:46:15', '2025-12-04 02:49:30'),
(94, 1, NULL, 33, 41, 36, 4, 5, 'Vermelho', 'Brilhe na Academia', 'Único', NULL, 'Legging Dryfit Em Microfibra Brilhe Na Academia – Verde Tamanho Único', 'legging-dryfit-em-microfibra-brilhe-na-academia-verde-tamanho-unico', 'FIT-LEG-0017-VRD-UNI', NULL, '', '', 128.99, NULL, NULL, NULL, 10, NULL, NULL, NULL, NULL, 1, 'new', NULL, NULL, NULL, 0, 'products/ai-generated/pollinations_6930cca770f96_1764805799.jpg', '2025-12-04 02:46:33', '2025-12-04 02:50:03');

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_bundles`
--

CREATE TABLE `product_bundles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kit_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_colors`
--

CREATE TABLE `product_colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(3) NOT NULL,
  `hex_code` varchar(7) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `product_colors`
--

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_groups`
--

CREATE TABLE `product_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('sibling','kit') NOT NULL,
  `kit_price` decimal(10,2) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`items`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `product_images`
--

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_materials`
--

CREATE TABLE `product_materials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `product_materials`
--

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_models`
--

CREATE TABLE `product_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `product_models`
--

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `product_sizes`
--

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_types`
--

CREATE TABLE `product_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(3) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `product_types`
--

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

-- --------------------------------------------------------

--
-- Estrutura para tabela `product_variations`
--

CREATE TABLE `product_variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(50) NOT NULL,
  `gtin` varchar(13) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  `model` varchar(10) NOT NULL,
  `color` varchar(10) NOT NULL,
  `size` varchar(5) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('2VvFfmXYLezIM5cVteNSObXkCVlWiZvBo10v4qlK', NULL, '127.0.0.1', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWTloUHFHYmFkY3lsM25sY3pya04xTThNUU9QZDdTSGpsbDJnVko2QyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zaG9wIjtzOjU6InJvdXRlIjtzOjg6InNob3AubmV3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1765281126),
('xe2cuy2WmR61kxbQbnftOsVvsgxSvgPOWCcPSpcF', 12, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSHY0d1dadVhSOG02ZHA1anZPNGxQdk1yaUFTUldQbjRqSnhtUllIQSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9zaG9wIjtzOjU6InJvdXRlIjtzOjg6InNob3AubmV3Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7fQ==', 1765288818),
('xZfPXxkFxzGxrCKDrgbO9lFemSprAkF9p3G1MTxn', 7, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiY0tWYUpYb21MM3ZUSzRkc09nTm80VXdOSFBjcXkyc3VBWmZzYnVNdSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2FkbWluL3N0b3JpZXMiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozNToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2FkbWluL3N0b3JpZXMiO3M6NToicm91dGUiO3M6MTk6ImFkbWluLnN0b3JpZXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O30=', 1765285107);

-- --------------------------------------------------------

--
-- Estrutura para tabela `store_settings`
--

CREATE TABLE `store_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `store_settings`
--

INSERT INTO `store_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'store_address', 'Rua das Academias\r\nBelo Horizonte', 'text', '2025-12-02 15:59:07', '2025-12-03 22:57:45'),
(2, 'store_cnpj', '125489547562', 'text', '2025-12-02 15:59:07', '2025-12-03 22:20:23'),
(3, 'color_primary', '#00008a', 'color', '2025-12-02 15:59:07', '2025-12-03 04:02:22'),
(4, 'color_secondary', '#6c757d', 'color', '2025-12-02 15:59:07', '2025-12-02 15:59:07'),
(5, 'color_accent', '#ffc107', 'color', '2025-12-02 15:59:07', '2025-12-02 15:59:07'),
(6, 'color_background', '#ffffff', 'color', '2025-12-02 15:59:07', '2025-12-02 16:00:13'),
(7, 'store_phone', '31994161000', 'text', '2025-12-03 22:57:45', '2025-12-03 22:57:45'),
(8, 'google_maps_embed_url', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d607.2810245771751!2d-43.88735253507937!3d-19.842866561251554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa685930a8dac6d%3A0x85f0337143c85000!2sMy%20Mall%20Parque%20Real!5e1!3m2!1spt-BR!2sbr!4v1764791831815!5m2!1spt-BR!2sbr\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'text', '2025-12-03 22:57:45', '2025-12-03 22:57:45'),
(9, 'color_category_bar', '#f5f7ff', 'color', '2025-12-03 22:57:45', '2025-12-04 01:46:46'),
(10, 'ai_image_prompt_template', 'Professional e-commerce product photography of {product_name}, {category} category product, {type} type, {model} model, {size} size, {flavor} color, {material} style. Studio lighting, clean white background, product centered, front view, label visible and readable, high resolution, professional packshot, 8k quality, photorealistic', 'text', '2025-12-04 00:41:54', '2025-12-04 02:23:56'),
(11, 'modal_about', 'A Losfit é uma marca criada para quem busca estilo, conforto e autenticidade. Desde o início, nossa missão sempre foi oferecer produtos que combinam qualidade, design moderno e preço justo, conectando pessoas a uma experiência de compra simples, rápida e confiável.\r\n\r\nTrabalhamos com curadoria de produtos selecionados, fornecedores certificados e processos rigorosos de qualidade, garantindo que cada item entregue reflita nossos valores: confiança, transparência e compromisso com o cliente.\r\n\r\nHoje, atuamos com foco em inovação, atendimento humanizado e evolução constante. Cada coleção, cada detalhe e cada melhoria no nosso site nasce com um propósito: proporcionar a você uma experiência inesquecível de compra online.', 'text', '2025-12-04 00:41:54', '2025-12-04 00:41:54'),
(12, 'modal_careers', 'A Losfit está em constante crescimento, e buscamos pessoas apaixonadas por tecnologia, varejo e experiência do cliente. Valorizamos profissionais criativos, responsáveis e comprometidos com o que fazem.\r\n\r\nSe você deseja fazer parte de uma equipe dinâmica, colaborativa e focada em resultados, envie seu currículo para:\r\n\r\n📧 E-mail para vagas: vagas@losfit.com.br\r\n\r\nAssunto: “Trabalhe Conosco – Nome da Vaga”\r\n\r\nÁreas que frequentemente abrimos vagas:\r\n\r\nAtendimento ao Cliente\r\n\r\nLogística & Expedição\r\n\r\nCriação & Design\r\n\r\nSocial Media\r\n\r\nGestão de Produtos\r\n\r\nTI & Desenvolvimento\r\n\r\nSe não encontrar uma vaga aberta no momento, envie seu currículo mesmo assim! Mantemos um banco de talentos sempre atualizado.', 'text', '2025-12-04 00:41:54', '2025-12-04 00:41:54'),
(13, 'modal_contact', 'Estamos aqui para ajudar você!\r\nSe tiver dúvidas, sugestões ou precisar de suporte, fale com nossa equipe pelos canais oficiais abaixo:\r\n\r\n📱 WhatsApp: (31) 99416-1000\r\n📧 E-mail: contato@losfit.com.br\r\n\r\n📍 Horário de atendimento: Segunda a Sexta, das 09h às 18h\r\n\r\nRedes Sociais\r\nSiga-nos para acompanhar lançamentos, promoções e novidades exclusivas:\r\n\r\n📸 Instagram: @losfit1000', 'text', '2025-12-04 00:41:54', '2025-12-04 00:41:54'),
(14, 'modal_returns', 'A Losfit trabalha para garantir sua total satisfação. Se o produto recebido não atendeu às suas expectativas, não se preocupe — nossa política de trocas e devoluções é simples e transparente.\r\n\r\n✔ Trocas por tamanho ou modelo:\r\nPrazo de até 7 dias corridos após o recebimento.\r\n\r\n✔ Devolução por arrependimento:\r\nPrazo de até 7 dias corridos, conforme o Código de Defesa do Consumidor.\r\n\r\n✔ Produto com defeito:\r\nPrazo de até 30 dias para solicitar análise e substituição.\r\n\r\nRequisitos obrigatórios:\r\n\r\nProduto sem sinais de uso\r\n\r\nEtiquetas e embalagem original\r\n\r\nNota fiscal ou comprovante de compra\r\n\r\nPara solicitar, envie e-mail para:\r\n📧 trocas@losfit.com.br\r\n\r\nAssunto: “Troca/Devolução – Nº do Pedido”\r\n\r\nNossa equipe retornará com todas as instruções e o código de postagem grátis (quando aplicável).', 'text', '2025-12-04 00:41:54', '2025-12-04 00:41:54'),
(15, 'modal_faq', '1️⃣ O produto é original?\r\nSim! Trabalhamos com fornecedores homologados e produtos 100% originais.\r\n\r\n2️⃣ Quanto tempo demora para chegar?\r\nO prazo varia conforme a região, mas normalmente entre 7 e 15 dias úteis. O prazo exato aparece no checkout.\r\n\r\n3️⃣ Como acompanho meu pedido?\r\nAssim que o pedido for enviado, você recebe um código de rastreio no e-mail ou WhatsApp.\r\n\r\n4️⃣ Posso trocar se não servir?\r\nClaro! Aceitamos trocas por tamanho, modelo ou cor dentro do prazo estabelecido.\r\n\r\n5️⃣ É seguro comprar na Losfit?\r\nSim. Nosso site possui certificado SSL, gateways de pagamento seguros e proteção de dados.\r\n\r\n6️⃣ Quais formas de pagamento vocês aceitam?\r\nPix, cartão de crédito (parcelamento disponível) e boleto bancário.\r\n\r\n7️⃣ Como falar com o suporte?\r\nVia e-mail (suporte@losfit.com.br\r\n) ou WhatsApp. Nosso time responde rápido!', 'text', '2025-12-04 00:41:54', '2025-12-04 00:41:54'),
(16, 'email_sender_name', 'Jacqueline Maria Bergsten', 'text', '2025-12-05 18:42:14', '2025-12-05 18:42:14'),
(17, 'email_sender_role', 'CEO', 'text', '2025-12-05 18:42:14', '2025-12-05 18:42:14'),
(18, 'email_instagram', 'losfit1000', 'text', '2025-12-05 18:42:14', '2025-12-05 18:42:14'),
(19, 'email_website', 'www.losfit.com.br', 'text', '2025-12-05 18:42:15', '2025-12-05 18:42:15'),
(20, 'email_slogan', 'A Elegância veste o estilo!', 'text', '2025-12-05 18:42:15', '2025-12-05 18:42:15'),
(21, 'email_card_id', '1', 'text', '2025-12-05 20:56:43', '2025-12-06 01:07:40'),
(22, 'links_page_title', 'LosFit 1000', 'text', '2025-12-06 00:14:28', '2025-12-06 00:14:28'),
(23, 'links_page_subtitle', 'A Elegância veste o Estilo', 'text', '2025-12-06 00:14:28', '2025-12-08 01:18:28'),
(24, 'store_logo', 'http://localhost:8000/storage/uploads/settings/logo.png', 'image', '2025-12-08 00:33:54', '2025-12-08 00:49:54'),
(25, 'footer_logo', 'http://localhost:8000/storage/uploads/settings/sol.png', 'image', '2025-12-08 01:04:13', '2025-12-08 01:04:13'),
(26, 'email_logo', 'http://localhost:8000/storage/uploads/settings/logo-email.png', 'image', '2025-12-09 01:39:00', '2025-12-09 01:39:00'),
(27, 'profile_logo', 'http://localhost:8000/storage/uploads/settings/logo-redonda-trans.png', 'image', '2025-12-09 01:39:00', '2025-12-09 01:39:00'),
(28, 'favicon', 'http://localhost:8000/storage/uploads/settings/favicon.ico', 'image', '2025-12-09 01:41:27', '2025-12-09 01:41:27'),
(29, 'security_certificates', '[\"http:\\/\\/localhost:8000\\/storage\\/uploads\\/settings\\/certificates\\/IUyuictBW8Y4zlNroNNPvNrCP7TY77pwJoe577ez.png\",\"http:\\/\\/localhost:8000\\/storage\\/uploads\\/settings\\/certificates\\/IUyuictBW8Y4zlNroNNPvNrCP7TY77pwJoe577ez.png\",\"http:\\/\\/localhost:8000\\/storage\\/uploads\\/settings\\/certificates\\/ZZzeOLIz0kxKbHdhljPBjRqvOJSMz33lbT0BqYVX.png\",\"http:\\/\\/localhost:8000\\/storage\\/uploads\\/settings\\/certificates\\/ZZzeOLIz0kxKbHdhljPBjRqvOJSMz33lbT0BqYVX.png\"]', 'json', '2025-12-09 05:29:31', '2025-12-09 05:30:40');

-- --------------------------------------------------------

--
-- Estrutura para tabela `stories`
--

CREATE TABLE `stories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `stories`
--

INSERT INTO `stories` (`id`, `title`, `subtitle`, `image_path`, `link_url`, `expires_at`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Dra. Jacqueline', 'Conheça minha história', '/storage/stories/BvxlRfa8oxfymxzOGICiemD5JOPfx3K36frkmkBJ.jpg', '/minha-historia', '2025-12-10 15:57:43', 1, 0, '2025-12-08 13:17:51', '2025-12-09 15:58:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `taxvat` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `google_id`, `facebook_id`, `phone`, `taxvat`, `address`, `birth_date`, `is_admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 'Sammuel Henque Ferreira Gomes', 'sammuelhg@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocIA13BZi-1ai4yaBv5hOwurBhfGe8ZXb5CRws9J8DLVDaC-L-Sy=s96-c', '114857707516784083594', '10229218207573044', '(31) 99416-1000', '039.204.876-05', NULL, NULL, 0, NULL, NULL, NULL, '2025-11-30 05:03:56', '2025-12-04 16:02:33'),
(12, 'Vinocracia Clube de Vinhos', 'vinocrata@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocJz-FmNFD75jLSHNi_7GxQRmxhCnbSxGJW-yUCSr5qDnFiv5YOC=s96-c', '104586627428385381885', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-12-05 18:21:17', '2025-12-05 18:21:17'),
(13, 'Los Fit', 'losfit1000@gmail.com', 'https://lh3.googleusercontent.com/a/ACg8ocKr7IXHii49mPWh28JJuIrNLbYOOR875sbFxAq7Q680-LmsQQ=s96-c', '106851467777243218374', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-12-07 22:42:23', '2025-12-07 22:42:23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Índices de tabela `campaign_opens`
--
ALTER TABLE `campaign_opens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_open_tracking` (`newsletter_campaign_id`,`newsletter_subscriber_id`,`newsletter_email_id`),
  ADD KEY `campaign_opens_newsletter_subscriber_id_foreign` (`newsletter_subscriber_id`),
  ADD KEY `camp_opens_camp_sub_idx` (`newsletter_campaign_id`,`newsletter_subscriber_id`),
  ADD KEY `campaign_opens_newsletter_email_id_foreign` (`newsletter_email_id`);

--
-- Índices de tabela `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Índices de tabela `email_cards`
--
ALTER TABLE `email_cards`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `grid_rules`
--
ALTER TABLE `grid_rules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `grid_rules_position_unique` (`position`);

--
-- Índices de tabela `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Índices de tabela `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `leads_email_unique` (`email`),
  ADD KEY `leads_status_index` (`status`),
  ADD KEY `leads_utm_source_index` (`utm_source`),
  ADD KEY `leads_utm_medium_index` (`utm_medium`);

--
-- Índices de tabela `link_items`
--
ALTER TABLE `link_items`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `newsletter_campaigns`
--
ALTER TABLE `newsletter_campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newsletter_campaigns_email_card_id_foreign` (`email_card_id`);

--
-- Índices de tabela `newsletter_campaign_subscriber`
--
ALTER TABLE `newsletter_campaign_subscriber`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `camp_sub_unique_enrollment` (`newsletter_campaign_id`,`newsletter_subscriber_id`),
  ADD KEY `newsletter_campaign_subscriber_newsletter_subscriber_id_foreign` (`newsletter_subscriber_id`),
  ADD KEY `newsletter_campaign_subscriber_current_email_id_foreign` (`current_email_id`);

--
-- Índices de tabela `newsletter_emails`
--
ALTER TABLE `newsletter_emails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newsletter_emails_newsletter_campaign_id_foreign` (`newsletter_campaign_id`);

--
-- Índices de tabela `newsletter_email_product`
--
ALTER TABLE `newsletter_email_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `newsletter_email_product_newsletter_email_id_foreign` (`newsletter_email_id`),
  ADD KEY `newsletter_email_product_product_id_foreign` (`product_id`);

--
-- Índices de tabela `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletter_subscribers_email_unique` (`email`),
  ADD KEY `newsletter_subscribers_utm_source_index` (`utm_source`),
  ADD KEY `newsletter_subscribers_utm_medium_index` (`utm_medium`);

--
-- Índices de tabela `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Índices de tabela `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Índices de tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_name_index` (`name`),
  ADD KEY `products_slug_index` (`slug`),
  ADD KEY `products_product_type_id_foreign` (`product_type_id`),
  ADD KEY `products_product_model_id_foreign` (`product_model_id`),
  ADD KEY `products_product_material_id_foreign` (`product_material_id`),
  ADD KEY `products_product_color_id_foreign` (`product_color_id`),
  ADD KEY `products_product_size_id_foreign` (`product_size_id`),
  ADD KEY `products_product_group_id_foreign` (`product_group_id`);

--
-- Índices de tabela `product_bundles`
--
ALTER TABLE `product_bundles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_bundles_kit_id_product_id_unique` (`kit_id`,`product_id`),
  ADD KEY `product_bundles_product_id_foreign` (`product_id`);

--
-- Índices de tabela `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_colors_code_unique` (`code`);

--
-- Índices de tabela `product_groups`
--
ALTER TABLE `product_groups`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Índices de tabela `product_materials`
--
ALTER TABLE `product_materials`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `product_models`
--
ALTER TABLE `product_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_models_code_unique` (`code`);

--
-- Índices de tabela `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_sizes_code_unique` (`code`);

--
-- Índices de tabela `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_types_code_unique` (`code`);

--
-- Índices de tabela `product_variations`
--
ALTER TABLE `product_variations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variations_sku_unique` (`sku`),
  ADD KEY `product_variations_sku_index` (`sku`),
  ADD KEY `product_variations_model_index` (`model`),
  ADD KEY `product_variations_product_id_size_color_index` (`product_id`,`size`,`color`);

--
-- Índices de tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Índices de tabela `store_settings`
--
ALTER TABLE `store_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_settings_key_unique` (`key`);

--
-- Índices de tabela `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_google_id_unique` (`google_id`),
  ADD UNIQUE KEY `users_facebook_id_unique` (`facebook_id`);

--
-- Índices de tabela `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlist_items_user_id_foreign` (`user_id`),
  ADD KEY `wishlist_items_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `campaign_opens`
--
ALTER TABLE `campaign_opens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `email_cards`
--
ALTER TABLE `email_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `grid_rules`
--
ALTER TABLE `grid_rules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `link_items`
--
ALTER TABLE `link_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT de tabela `newsletter_campaigns`
--
ALTER TABLE `newsletter_campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `newsletter_campaign_subscriber`
--
ALTER TABLE `newsletter_campaign_subscriber`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `newsletter_emails`
--
ALTER TABLE `newsletter_emails`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `newsletter_email_product`
--
ALTER TABLE `newsletter_email_product`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT de tabela `product_bundles`
--
ALTER TABLE `product_bundles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `product_groups`
--
ALTER TABLE `product_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de tabela `product_materials`
--
ALTER TABLE `product_materials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `product_models`
--
ALTER TABLE `product_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de tabela `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de tabela `product_variations`
--
ALTER TABLE `product_variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `store_settings`
--
ALTER TABLE `store_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `stories`
--
ALTER TABLE `stories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `wishlist_items`
--
ALTER TABLE `wishlist_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `campaign_opens`
--
ALTER TABLE `campaign_opens`
  ADD CONSTRAINT `campaign_opens_newsletter_campaign_id_foreign` FOREIGN KEY (`newsletter_campaign_id`) REFERENCES `newsletter_campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `campaign_opens_newsletter_email_id_foreign` FOREIGN KEY (`newsletter_email_id`) REFERENCES `newsletter_emails` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `campaign_opens_newsletter_subscriber_id_foreign` FOREIGN KEY (`newsletter_subscriber_id`) REFERENCES `newsletter_subscribers` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `newsletter_campaigns`
--
ALTER TABLE `newsletter_campaigns`
  ADD CONSTRAINT `newsletter_campaigns_email_card_id_foreign` FOREIGN KEY (`email_card_id`) REFERENCES `email_cards` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `newsletter_campaign_subscriber`
--
ALTER TABLE `newsletter_campaign_subscriber`
  ADD CONSTRAINT `newsletter_campaign_subscriber_current_email_id_foreign` FOREIGN KEY (`current_email_id`) REFERENCES `newsletter_emails` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `newsletter_campaign_subscriber_newsletter_campaign_id_foreign` FOREIGN KEY (`newsletter_campaign_id`) REFERENCES `newsletter_campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `newsletter_campaign_subscriber_newsletter_subscriber_id_foreign` FOREIGN KEY (`newsletter_subscriber_id`) REFERENCES `newsletter_subscribers` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `newsletter_emails`
--
ALTER TABLE `newsletter_emails`
  ADD CONSTRAINT `newsletter_emails_newsletter_campaign_id_foreign` FOREIGN KEY (`newsletter_campaign_id`) REFERENCES `newsletter_campaigns` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `newsletter_email_product`
--
ALTER TABLE `newsletter_email_product`
  ADD CONSTRAINT `newsletter_email_product_newsletter_email_id_foreign` FOREIGN KEY (`newsletter_email_id`) REFERENCES `newsletter_emails` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `newsletter_email_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `product_colors` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_product_group_id_foreign` FOREIGN KEY (`product_group_id`) REFERENCES `product_groups` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_product_material_id_foreign` FOREIGN KEY (`product_material_id`) REFERENCES `product_materials` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_product_model_id_foreign` FOREIGN KEY (`product_model_id`) REFERENCES `product_models` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_product_size_id_foreign` FOREIGN KEY (`product_size_id`) REFERENCES `product_sizes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_product_type_id_foreign` FOREIGN KEY (`product_type_id`) REFERENCES `product_types` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `product_bundles`
--
ALTER TABLE `product_bundles`
  ADD CONSTRAINT `product_bundles_kit_id_foreign` FOREIGN KEY (`kit_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_bundles_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `wishlist_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
