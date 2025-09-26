-- MySQL schema for users API (CodeIgniter 3)

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Weather table to store fetched weather data (by city)
CREATE TABLE IF NOT EXISTS `weather` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `city` VARCHAR(150) NOT NULL,
  `temperature` DECIMAL(6,2) DEFAULT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `raw` JSON DEFAULT NULL,
  `fetched_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

