-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 03-Dez-2018 às 20:26
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instagram`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario`
--

CREATE TABLE `comentario` (
  `Key_Comentario` bigint(20) NOT NULL,
  `Key_Publicacao` bigint(20) NOT NULL,
  `Key_Utilizador` bigint(20) NOT NULL,
  `Comentario` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `gosto`
--

CREATE TABLE `gosto` (
  `Key_Publicacao` bigint(20) NOT NULL,
  `Key_Utilizador` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `publicacao`
--

CREATE TABLE `publicacao` (
  `Key_Publicacao` bigint(20) NOT NULL,
  `Publicacao` mediumblob NOT NULL,
  `Key_Utilizador` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `seguidor`
--

CREATE TABLE `seguidor` (
  `Key_Utilizador` bigint(20) NOT NULL,
  `Key_Seguidor` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `seguindo`
--

CREATE TABLE `seguindo` (
  `Key_Utilizador` bigint(20) NOT NULL,
  `Key_Seguindo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

CREATE TABLE `utilizador` (
  `Key_Utilizador` bigint(20) NOT NULL,
  `NomeUnico` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Nome` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FotoPerfil` mediumblob,
  `Descricao` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`Key_Comentario`),
  ADD KEY `Key_Publicacao` (`Key_Publicacao`),
  ADD KEY `Key_Utilizador` (`Key_Utilizador`);

--
-- Indexes for table `gosto`
--
ALTER TABLE `gosto`
  ADD PRIMARY KEY (`Key_Publicacao`,`Key_Utilizador`),
  ADD KEY `Key_Publicacao` (`Key_Publicacao`),
  ADD KEY `Key_Utilizador` (`Key_Utilizador`);

--
-- Indexes for table `publicacao`
--
ALTER TABLE `publicacao`
  ADD PRIMARY KEY (`Key_Publicacao`),
  ADD KEY `Key_Utilizador` (`Key_Utilizador`);

--
-- Indexes for table `seguidor`
--
ALTER TABLE `seguidor`
  ADD PRIMARY KEY (`Key_Utilizador`,`Key_Seguidor`),
  ADD KEY `Key_Utilizador` (`Key_Utilizador`),
  ADD KEY `Key_Seguidor` (`Key_Seguidor`);

--
-- Indexes for table `seguindo`
--
ALTER TABLE `seguindo`
  ADD PRIMARY KEY (`Key_Utilizador`,`Key_Seguindo`),
  ADD KEY `Key_Utilizador` (`Key_Utilizador`),
  ADD KEY `Key_Seguindo` (`Key_Seguindo`);

--
-- Indexes for table `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`Key_Utilizador`),
  ADD UNIQUE KEY `NomeUnico` (`NomeUnico`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comentario`
--
ALTER TABLE `comentario`
  MODIFY `Key_Comentario` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `publicacao`
--
ALTER TABLE `publicacao`
  MODIFY `Key_Publicacao` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilizador`
--
ALTER TABLE `utilizador`
  MODIFY `Key_Utilizador` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`Key_Publicacao`) REFERENCES `publicacao` (`Key_Publicacao`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`Key_Utilizador`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `gosto`
--
ALTER TABLE `gosto`
  ADD CONSTRAINT `gosto_ibfk_1` FOREIGN KEY (`Key_Publicacao`) REFERENCES `publicacao` (`Key_Publicacao`) ON UPDATE CASCADE,
  ADD CONSTRAINT `gosto_ibfk_2` FOREIGN KEY (`Key_Utilizador`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `publicacao`
--
ALTER TABLE `publicacao`
  ADD CONSTRAINT `publicacao_ibfk_1` FOREIGN KEY (`Key_Utilizador`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `seguidor`
--
ALTER TABLE `seguidor`
  ADD CONSTRAINT `seguidor_ibfk_1` FOREIGN KEY (`Key_Utilizador`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE,
  ADD CONSTRAINT `seguidor_ibfk_2` FOREIGN KEY (`Key_Seguidor`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `seguindo`
--
ALTER TABLE `seguindo`
  ADD CONSTRAINT `seguindo_ibfk_1` FOREIGN KEY (`Key_Utilizador`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE,
  ADD CONSTRAINT `seguindo_ibfk_2` FOREIGN KEY (`Key_Seguindo`) REFERENCES `utilizador` (`Key_Utilizador`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
