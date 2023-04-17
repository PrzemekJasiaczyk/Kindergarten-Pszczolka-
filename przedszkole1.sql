-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 16 Lut 2021, 15:05
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `przedszkole`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dzieci`
--

CREATE TABLE `dzieci` (
  `id_dziecka` int(11) NOT NULL,
  `Imie` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `Nazwisko` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `PESEL` varchar(11) COLLATE utf8_polish_ci NOT NULL,
  `id_grupy` int(11) DEFAULT NULL,
  `id_rodzica` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `grupy`
--

CREATE TABLE `grupy` (
  `id_grupy` int(11) NOT NULL,
  `id_wychowawcy` int(11) NOT NULL,
  `NazwaGrupy` varchar(3) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `oplaty`
--

CREATE TABLE `oplaty` (
  `id_oplaty` int(11) NOT NULL,
  `kwota` float DEFAULT NULL,
  `DataWplaty` date DEFAULT NULL,
  `id_dziecka` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rodzice`
--

CREATE TABLE `rodzice` (
  `id_rodzica` int(11) NOT NULL,
  `Imie` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `Nazwisko` varchar(45) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wychowawcy`
--

CREATE TABLE `wychowawcy` (
  `id_wychowawcy` int(11) NOT NULL,
  `Imie` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `Nazwisko` varchar(45) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dzieci`
--
ALTER TABLE `dzieci`
  ADD PRIMARY KEY (`id_dziecka`),
  ADD KEY `id_grupy` (`id_grupy`),
  ADD KEY `id_rodzica` (`id_rodzica`);

--
-- Indeksy dla tabeli `grupy`
--
ALTER TABLE `grupy`
  ADD PRIMARY KEY (`id_grupy`),
  ADD KEY `id_wychowawcy` (`id_wychowawcy`);

--
-- Indeksy dla tabeli `oplaty`
--
ALTER TABLE `oplaty`
  ADD PRIMARY KEY (`id_oplaty`),
  ADD KEY `id_dziecka` (`id_dziecka`);

--
-- Indeksy dla tabeli `rodzice`
--
ALTER TABLE `rodzice`
  ADD PRIMARY KEY (`id_rodzica`);

--
-- Indeksy dla tabeli `wychowawcy`
--
ALTER TABLE `wychowawcy`
  ADD PRIMARY KEY (`id_wychowawcy`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `dzieci`
--
ALTER TABLE `dzieci`
  MODIFY `id_dziecka` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `grupy`
--
ALTER TABLE `grupy`
  MODIFY `id_grupy` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `oplaty`
--
ALTER TABLE `oplaty`
  MODIFY `id_oplaty` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `rodzice`
--
ALTER TABLE `rodzice`
  MODIFY `id_rodzica` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `wychowawcy`
--
ALTER TABLE `wychowawcy`
  MODIFY `id_wychowawcy` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `dzieci`
--
ALTER TABLE `dzieci`
  ADD CONSTRAINT `dzieci_ibfk_1` FOREIGN KEY (`id_grupy`) REFERENCES `grupy` (`id_grupy`),
  ADD CONSTRAINT `dzieci_ibfk_2` FOREIGN KEY (`id_rodzica`) REFERENCES `rodzice` (`id_rodzica`);

--
-- Ograniczenia dla tabeli `grupy`
--
ALTER TABLE `grupy`
  ADD CONSTRAINT `grupy_ibfk_1` FOREIGN KEY (`id_wychowawcy`) REFERENCES `wychowawcy` (`id_wychowawcy`);

--
-- Ograniczenia dla tabeli `oplaty`
--
ALTER TABLE `oplaty`
  ADD CONSTRAINT `oplaty_ibfk_1` FOREIGN KEY (`id_dziecka`) REFERENCES `dzieci` (`id_dziecka`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
