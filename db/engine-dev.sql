-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2017. Sze 25. 17:14
-- Kiszolgáló verziója: 5.7.14
-- PHP verzió: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `engine-dev`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `_xyz_user`
--

CREATE TABLE `_xyz_user` (
  `id` int(11) UNSIGNED NOT NULL COMMENT 'user_id',
  `username` varchar(25) DEFAULT NULL COMMENT 'username',
  `password` text COMMENT 'password',
  `remember_token` varchar(255) DEFAULT NULL,
  `email` varchar(254) DEFAULT NULL COMMENT 'email',
  `country_code` char(2) DEFAULT NULL COMMENT 'country_code'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `_xyz_user`
--

INSERT INTO `_xyz_user` (`id`, `username`, `password`, `remember_token`, `email`, `country_code`) VALUES
(16, 'sno', 'admin', 'a3e6f3080b6763413f026d2a286655b72b40032fc8909a054086a3a5a00ac0ba', 'sno@sno.com', 'HU'),
(18, 'foo', NULL, NULL, 'foo@foo.foo', 'DE'),
(19, 'bar', NULL, NULL, 'bar@bar.bar', 'IT');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `_xyz_user`
--
ALTER TABLE `_xyz_user`
  ADD PRIMARY KEY (`id`) COMMENT 'user_id',
  ADD UNIQUE KEY `username` (`username`) COMMENT 'username',
  ADD UNIQUE KEY `email` (`email`) COMMENT 'email';

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `_xyz_user`
--
ALTER TABLE `_xyz_user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'user_id', AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
