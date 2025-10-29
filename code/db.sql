-- Ce fichier sert à initialiser la base de données
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Masquer les warnings "already exists" (MySQL 5.7)
SET @prev_sql_notes := @@sql_notes;
SET sql_notes = 0;

CREATE DATABASE IF NOT EXISTS blog
  DEFAULT CHARACTER SET utf8
  COLLATE utf8_general_ci;
USE blog;

-- POSTS
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Upsert (pas de warnings, met à jour si déjà présent)
INSERT INTO `posts` (`id`, `title`, `content`, `creation_date`) VALUES
(1, 'Bienvenue sur le blog de l''AVBN !',
   'Je vous souhaite à toutes et à tous la bienvenue sur le blog qui parlera de... l''Association de VolleyBall de Nuelly !',
   '2022-02-17 16:28:41'),
(2, 'L''AVBN à la conquête du monde !',
   'C''est officiel, le club a annoncé à la radio hier soir "J''ai l''intention de conquérir le monde !".\r\nIl a en outre précisé que le monde serait à sa botte en moins de temps qu''il n''en fallait pour dire "Association de VolleyBall de Nuelly". Pas dur, ceci dit entre nous...',
   '2022-02-17 16:28:42')
ON DUPLICATE KEY UPDATE
  `title` = VALUES(`title`),
  `content` = VALUES(`content`),
  `creation_date` = VALUES(`creation_date`);

-- COMMENTS
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `comment` text NOT NULL,
  `comment_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_comments_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `comments` (`id`, `post_id`, `author`, `comment`, `comment_date`) VALUES
(1, 1, 'Mathieu', 'Preum''s', '2022-03-03 13:00:42'),
(2, 1, 'Sam', 'Quelqu''un a un avis là-dessus ? Je ne sais pas quoi en penser.', '2022-03-03 13:01:42')
ON DUPLICATE KEY UPDATE
  `post_id` = VALUES(`post_id`),
  `author` = VALUES(`author`),
  `comment` = VALUES(`comment`),
  `comment_date` = VALUES(`comment_date`);

-- Réactiver l’état initial des notes
SET sql_notes = @prev_sql_notes;
