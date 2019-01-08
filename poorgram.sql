SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `comentario` (
  `Key_Comentario` bigint(20) NOT NULL,
  `Key_Publicacao` bigint(20) NOT NULL,
  `Key_Utilizador` bigint(20) NOT NULL,
  `Comentario` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `gosto` (
  `Key_Publicacao` bigint(20) NOT NULL,
  `Key_Utilizador` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `publicacao` (
  `Key_Publicacao` bigint(20) NOT NULL,
  `Publicacao` mediumblob NOT NULL,
  `Key_Utilizador` bigint(20) NOT NULL,
  `Data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `seguir` (
  `Key_Utilizador` bigint(20) NOT NULL,
  `Key_Seguir` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `utilizador` (
  `Key_Utilizador` bigint(20) NOT NULL,
  `NomeUnico` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `FotoPerfil` mediumblob,
  `Descricao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `comentario`
  ADD PRIMARY KEY (`Key_Comentario`),
  ADD KEY `Key_Publicacao` (`Key_Publicacao`),
  ADD KEY `Key_Utilizador` (`Key_Utilizador`);

ALTER TABLE `gosto`
  ADD PRIMARY KEY (`Key_Publicacao`,`Key_Utilizador`),
  ADD KEY `Key_Publicacao` (`Key_Publicacao`),
  ADD KEY `Key_Utilizador` (`Key_Utilizador`);

ALTER TABLE `publicacao`
  ADD PRIMARY KEY (`Key_Publicacao`),
  ADD KEY `Key_Utilizador` (`Key_Utilizador`);

ALTER TABLE `seguir`
  ADD PRIMARY KEY (`Key_Utilizador`,`Key_Seguir`),
  ADD KEY `Key_Utilizador` (`Key_Utilizador`),
  ADD KEY `Key_Seguir` (`Key_Seguir`) USING BTREE;

ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`Key_Utilizador`),
  ADD UNIQUE KEY `NomeUnico` (`NomeUnico`);


ALTER TABLE `comentario`
  MODIFY `Key_Comentario` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `publicacao`
  MODIFY `Key_Publicacao` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `utilizador`
  MODIFY `Key_Utilizador` bigint(20) NOT NULL AUTO_INCREMENT;


ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`Key_Publicacao`) REFERENCES `publicacao` (`Key_Publicacao`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`Key_Utilizador`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE;

ALTER TABLE `gosto`
  ADD CONSTRAINT `gosto_ibfk_1` FOREIGN KEY (`Key_Publicacao`) REFERENCES `publicacao` (`Key_Publicacao`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gosto_ibfk_2` FOREIGN KEY (`Key_Utilizador`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE;

ALTER TABLE `publicacao`
  ADD CONSTRAINT `publicacao_ibfk_1` FOREIGN KEY (`Key_Utilizador`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE;

ALTER TABLE `seguir`
  ADD CONSTRAINT `seguir_ibfk_1` FOREIGN KEY (`Key_Utilizador`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE,
  ADD CONSTRAINT `seguir_ibfk_2` FOREIGN KEY (`Key_Seguir`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
