-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 13, 2022 alle 22:31
-- Versione del server: 10.4.27-MariaDB
-- Versione PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinema`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `bookings`
--

CREATE TABLE `bookings` (
  `Code` int(11) NOT NULL,
  `User_Id` int(11) DEFAULT NULL,
  `Payment_Code` int(11) DEFAULT NULL,
  `Projection_Id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `films`
--

CREATE TABLE `films` (
  `Id` int(11) NOT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Plot` varchar(1000) DEFAULT NULL,
  `Thumbnail` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `films`
--

INSERT INTO `films` (`Id`, `Title`, `Plot`, `Thumbnail`) VALUES
(1, 'IL GATTO CON GLI STIVALI 2 - L\'ULTIMO DESIDERIO', 'Quest’autunno, il vostro intenditore di leche preferito, il più spavaldo e impavido felino torna sugli schermi. Un nuovo capitolo delle favole di Shrek in cui il Gatto con gli Stivali pagherà un caro prezzo per la sua famigerata passione per il pericolo ed il suo disprezzo per la sicurezza. Infatti l’audace fuorilegge ha bruciato otto delle sue nove vite e per riaverle dovrà intraprendere un’impresa colossale.', 'assets/gatto.jpg'),
(2, 'AVATAR - LA VIA DELL\'ACQUA', 'Acquista online per mercoledì 14 dicembre e solo per te l’esclusivo poster del film. Diversi anni dopo gli eventi del primo film Avatar, Jake Sully e Neytiri sono diventati genitori. Nuove minacce incombono su Pandora, costringendo i protagonisti a lasciare la loro casa ed esplorare nuove regioni di Pandora.', 'assets/avatar.jpg'),
(3, 'BLACK PANTHER', 'Dopo la morte di suo padre T\'Chaka, T\'Challa, interpretato da Chadwick Boseman, eredita il trono della fittizia nazione africana di Wakanda, ma come insegna la storia le successioni sono momenti politicamente turbolenti.', 'assets/black_panther.jpg');

-- --------------------------------------------------------

--
-- Struttura della tabella `payments`
--

CREATE TABLE `payments` (
  `Code` int(11) NOT NULL,
  `User_Id` int(11) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Amount` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `projections`
--

CREATE TABLE `projections` (
  `Id` int(11) NOT NULL,
  `Film_Id` int(11) DEFAULT NULL,
  `Room` int(11) DEFAULT NULL,
  `Day` date DEFAULT NULL,
  `Time` time DEFAULT NULL,
  `Occupied` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `projections`
--

INSERT INTO `projections` (`Id`, `Film_Id`, `Room`, `Day`, `Time`, `Occupied`) VALUES
(1, 1, 1, '2022-12-20', '14:45:00', ',0,43,20'),
(2, 1, 2, '2022-12-20', '16:00:00', ''),
(4, 1, 3, '2022-12-20', '20:30:00', ''),
(6, 2, 2, '2022-12-20', '14:45:00', ''),
(7, 2, 1, '2022-12-20', '16:00:00', ',4,3,2,10,19,28,38,39,40'),
(8, 3, 3, '2022-12-20', '14:45:00', '');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Name` varchar(50) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`Id`, `Name`, `Email`, `Password`) VALUES
(1, 'Yuri', '6190137@itisrossi.vi.it', 'ciaociao'),
(6, 'Yuri', '6190138@itisrossi.vi.it', 'sdv');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`Code`),
  ADD KEY `User_Id` (`User_Id`),
  ADD KEY `Payment_Code` (`Payment_Code`),
  ADD KEY `Projection_Id` (`Projection_Id`);

--
-- Indici per le tabelle `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Title` (`Title`),
  ADD UNIQUE KEY `Plot` (`Plot`) USING HASH;

--
-- Indici per le tabelle `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`Code`),
  ADD KEY `User_Id` (`User_Id`);

--
-- Indici per le tabelle `projections`
--
ALTER TABLE `projections`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Room` (`Room`,`Day`,`Time`),
  ADD KEY `Film_Id` (`Film_Id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `bookings`
--
ALTER TABLE `bookings`
  MODIFY `Code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `films`
--
ALTER TABLE `films`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `payments`
--
ALTER TABLE `payments`
  MODIFY `Code` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `projections`
--
ALTER TABLE `projections`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`Payment_Code`) REFERENCES `payments` (`Code`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`Projection_Id`) REFERENCES `projections` (`Id`);

--
-- Limiti per la tabella `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`User_Id`) REFERENCES `users` (`Id`);

--
-- Limiti per la tabella `projections`
--
ALTER TABLE `projections`
  ADD CONSTRAINT `projections_ibfk_1` FOREIGN KEY (`Film_Id`) REFERENCES `films` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
