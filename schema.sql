CREATE DATABASE IF NOT EXISTS taskforce
CHARACTER SET utf8;

USE taskforce;

DROP TABLE IF EXISTS `task_files`;
DROP TABLE IF EXISTS `task_feedbacks`;
DROP TABLE IF EXISTS `task_responses`;
DROP TABLE IF EXISTS `task_messages`;
DROP TABLE IF EXISTS `tasks`;
DROP TABLE IF EXISTS `profile_favourites`;
DROP TABLE IF EXISTS `profile_settings`;
DROP TABLE IF EXISTS `profile_stats`;
DROP TABLE IF EXISTS `profile_categories`;
DROP TABLE IF EXISTS `profile_portfolios`;
DROP TABLE IF EXISTS `profiles`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `cities`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `categories` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE KEY,
    `alias` varchar(255) NOT NULL UNIQUE KEY
)  CHARSET=utf8;

CREATE TABLE `cities` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` varchar(255) NOT NULL UNIQUE KEY
)  CHARSET=utf8;

CREATE TABLE `users` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `email` varchar(255) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL
)  CHARSET=utf8;

CREATE TABLE `profiles` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` int unsigned NOT NULL UNIQUE KEY,
    `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `name` varchar(255) NOT NULL,
    `city_id` int unsigned NOT NULL,
    `avatar_path` varchar(255),
    `birthday` date,
    `info` TEXT,
    `phone` varchar(255),
    `skype` varchar(255),
    `telegram` varchar(255),
    `last_action` datetime,
    KEY `idx_fk_profiles_user` (`user_id`),
    KEY `idx_fk_profiles_city` (`city_id`),
    CONSTRAINT `fk_profiles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
    CONSTRAINT `fk_profiles_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`)
) CHARSET=utf8;

CREATE TABLE `profile_favourites` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `favored_by_id` int unsigned NOT NULL,
    `favourite_id` int unsigned NOT NULL,
    UNIQUE KEY `idx_favored_by_id_favourite_id` (`favored_by_id`,`favourite_id`),
    KEY `idx_fk_profile_favourites_profile` (`favourite_id`),
    CONSTRAINT `fk_favored_by_profile` FOREIGN KEY (`favored_by_id`) REFERENCES `profiles` (`id`),
    CONSTRAINT `fk_favourite_profile` FOREIGN KEY (`favourite_id`) REFERENCES `profiles` (`id`)
) CHARSET=utf8;

CREATE TABLE `profile_settings` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `profile_id` int unsigned NOT NULL,
    `notify_message` bool NOT NULL DEFAULT TRUE,
    `notify_start` bool NOT NULL DEFAULT TRUE,
    `notify_finish` bool NOT NULL DEFAULT TRUE,
    `notify_refuse` bool NOT NULL DEFAULT TRUE,
    `notify_feedback` bool NOT NULL DEFAULT TRUE,
    `hide_contacts` bool NOT NULL DEFAULT FALSE,
    `hide_profile` bool NOT NULL DEFAULT FALSE,
    KEY `idx_fk_profile_settings_profile` (`profile_id`),
    CONSTRAINT `fk_profile_settings_profile` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`)
) CHARSET=utf8;

CREATE TABLE `profile_stats` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `profile_id` int unsigned NOT NULL,
    `tasks_total` int unsigned NOT NULL DEFAULT 0,
    `tasks_failed` int unsigned NOT NULL DEFAULT 0,
    `views` int unsigned NOT NULL DEFAULT 0,
    `avg_rate` tinyint(1) unsigned NOT NULL DEFAULT 0,
    KEY `idx_fk_profile_stats_profile` (`profile_id`),
    CONSTRAINT `fk_profile_stats_profile` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`)
) CHARSET=utf8;

CREATE TABLE `profile_categories` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `profile_id` int unsigned NOT NULL,
    `category_id` int unsigned NOT NULL,
    UNIQUE KEY `idx_profile_id_category_id` (`profile_id`,`category_id`),
    KEY `idx_fk_profile_categories_category` (`category_id`),
    CONSTRAINT `fk_profile_categories_profile` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`),
    CONSTRAINT `fk_profile_categories_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) CHARSET=utf8;

CREATE TABLE `profile_portfolios` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `profile_id` int unsigned NOT NULL,
    `path` varchar(255) NOT NULL,
    KEY `idx_fk_profile_portfolios_profile` (`profile_id`),
    CONSTRAINT `fk_profile_portfolios_profile` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`)
)  CHARSET=utf8;

CREATE TABLE `tasks` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `profile_id` int unsigned NOT NULL,
    `category_id` int unsigned NOT NULL,
    `title` varchar(255) NOT NULL,
    `description` text NOT NULL,
    `budget` int unsigned,
    `expire_date` datetime,
    `city_id` int unsigned NOT NULL,
    `coordinate` point,
    `contractor_id` int unsigned,
    `start_time` datetime,
    `canceled_time` datetime,
    `failed_time` datetime,
    `status` tinyint,
    KEY `idx_fk_tasks_profile` (`profile_id`),
    KEY `idx_fk_tasks_category` (`category_id`),
    KEY `idx_fk_tasks_city` (`city_id`),
    CONSTRAINT `fk_tasks_profile` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`),
    CONSTRAINT `fk_tasks_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
    CONSTRAINT `fk_tasks_city` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`)
) CHARSET=utf8;
-- новое: expire_date > NOW() and start_time is null (and contractor_id is null)
-- отменено: canceled_time is not null (and contractor_id is null)
-- в работе: expire_date > NOW() and start_time is not null (and contractor_id is not null)
-- провалено: failed_time is not null and not exists (select 1 from task_feedbacks where task_id = id)
-- провалено: failed_time is not null and exists (select 1 from task_feedbacks where task_id = id)

CREATE TABLE `task_files` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `task_id` int unsigned NOT NULL,
    `name` varchar(255) NOT NULL,
    `path` varchar(255) NOT NULL,
    KEY `idx_fk_task_files_task` (`task_id`),
    CONSTRAINT `fk_task_files_task` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
)  CHARSET=utf8;

CREATE TABLE `task_feedbacks` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `task_id` int unsigned NOT NULL,
    `comment` text,
    `rate` tinyint(1) unsigned NOT NULL DEFAULT 0,
    KEY `idx_fk_task_feedbacks_task` (`task_id`),
    CONSTRAINT `fk_task_feedbacks_task` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
) CHARSET=utf8;

CREATE TABLE `task_responses` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `task_id` int unsigned NOT NULL,
    `profile_id` int unsigned NOT NULL,
    `price` int unsigned,
    `comment` text,
    `decline_time` datetime,
    KEY `idx_fk_task_responses_task` (`task_id`),
    KEY `idx_fk_task_responses_profile` (`profile_id`),
    CONSTRAINT `fk_task_responses_task` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`),
    CONSTRAINT `fk_task_responses_profile` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`)
) CHARSET=utf8;

CREATE TABLE `task_messages` (
    `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `creation_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `task_id` int unsigned NOT NULL,
    `from_id` int unsigned NOT NULL,
    `to_id` int unsigned NOT NULL,
    `text` text NOT NULL,
    KEY `idx_fk_task_messages_task` (`task_id`),
    CONSTRAINT `fk_task_messages_task` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`)
) CHARSET=utf8;
