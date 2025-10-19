-- ⚠️ Efface la base si elle existe déjà
DROP DATABASE IF EXISTS blog;

-- Crée la base en UTF8 (pas utf8mb4)
CREATE DATABASE IF NOT EXISTS blog
  DEFAULT CHARACTER SET utf8
  COLLATE utf8_general_ci;

USE blog;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- Table billets
CREATE TABLE IF NOT EXISTS `billets` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `titre` VARCHAR(255) NOT NULL,
  `contenu` TEXT NOT NULL,
  `date_creation` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `billets` (`id`, `titre`, `contenu`, `date_creation`) VALUES
(1, 'Bienvenue sur le blog de l\'AVBN !', 'Je vous souhaite à toutes et à tous la bienvenue sur le blog qui parlera de... l\'Association de VolleyBall de Nuelly !', '2022-02-17 16:28:41'),
(2, 'L\'AVBN à la conquête du monde !', 'C\'est officiel, le club a annoncé à la radio hier soir \"J\'ai l\'intention de conquérir le monde !\".\r\nIl a en outre précisé que le monde serait à sa botte en moins de temps qu\'il n\'en fallait pour dire \"Association de VolleyBall de Nuelly\". Pas dur, ceci dit entre nous...', '2022-02-17 16:28:42');

-- Pour caler l'AUTO_INCREMENT après insertion
ALTER TABLE `billets` AUTO_INCREMENT = 3;