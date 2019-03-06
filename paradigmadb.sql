-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 07-Set-2017 às 15:20
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paradigmadb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `characters`
--

CREATE TABLE `characters` (
  `idchar` int(11) NOT NULL,
  `charname` varchar(50) NOT NULL,
  `classname` varchar(50) NOT NULL,
  `classlvl` int(11) NOT NULL,
  `classAP` int(11) NOT NULL,
  `classDP` int(11) NOT NULL,
  `idplayer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `characters`
--

INSERT INTO `characters` (`idchar`, `charname`, `classname`, `classlvl`, `classAP`, `classDP`, `idplayer`) VALUES
(20, 'admin char', 'Ranger', 60, 200, 310, 19),
(21, 'teste 1 char', 'Striker', 56, 120, 200, 20),
(22, 'teste 2 char', 'Valkyrie', 59, 180, 264, 21);

-- --------------------------------------------------------

--
-- Estrutura da tabela `players`
--

CREATE TABLE `players` (
  `idplayer` int(11) NOT NULL,
  `familyname` varchar(50) NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `players`
--

INSERT INTO `players` (`idplayer`, `familyname`, `iduser`) VALUES
(19, 'admin familia', 6),
(20, 'teste 1 familia', 7),
(21, 'teste 2 familia', 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `professions`
--

CREATE TABLE `professions` (
  `idprof` int(11) NOT NULL,
  `profname` varchar(50) NOT NULL,
  `proflvl` varchar(50) NOT NULL,
  `energy` int(11) NOT NULL,
  `idplayer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `professions`
--

INSERT INTO `professions` (`idprof`, `profname`, `proflvl`, `energy`, `idplayer`) VALUES
(19, 'Gathering', 'Master 4', 412, 19),
(20, 'Processing', 'Professional 10', 158, 20),
(21, 'Sailing', 'Skilled 4', 267, 21);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `iduser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`iduser`, `username`, `password`) VALUES
(6, 'Admin', '1234'),
(7, 'teste 1', '1234'),
(8, 'teste 2', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`idchar`),
  ADD KEY `fk_characterplayers` (`idplayer`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`idplayer`),
  ADD KEY `fk_playersusers` (`iduser`);

--
-- Indexes for table `professions`
--
ALTER TABLE `professions`
  ADD PRIMARY KEY (`idprof`),
  ADD KEY `fk_professionsplayers` (`idplayer`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `idchar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `idplayer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `professions`
--
ALTER TABLE `professions`
  MODIFY `idprof` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `fk_characterplayers` FOREIGN KEY (`idplayer`) REFERENCES `players` (`idplayer`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `fk_playersusers` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `professions`
--
ALTER TABLE `professions`
  ADD CONSTRAINT `fk_professionsplayers` FOREIGN KEY (`idplayer`) REFERENCES `players` (`idplayer`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
