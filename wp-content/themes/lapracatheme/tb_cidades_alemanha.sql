-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14-Dez-2021 às 08:03
-- Versão do servidor: 10.4.16-MariaDB
-- versão do PHP: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lapraca`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cidades_alemanha`
--

CREATE TABLE `tb_cidades_alemanha` (
  `id` int(11) NOT NULL,
  `cidade` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_cidades_alemanha`
--

INSERT INTO `tb_cidades_alemanha` (`id`, `cidade`) VALUES
(4, 'Berlim'),
(5, 'Hamburgo'),
(6, 'Munique'),
(7, 'Colônia'),
(8, 'Frankfurt'),
(9, 'Estugarda'),
(10, 'Düsseldorf'),
(11, 'Dortmund'),
(12, 'Essen'),
(13, 'Leipzig'),
(14, 'Bremen'),
(15, 'Dresden'),
(16, 'Hanôver'),
(17, 'Nuremberga'),
(18, 'Duisburgo'),
(19, 'Bochum'),
(20, 'Wuppertal'),
(21, 'Bielefeld'),
(22, 'Bona'),
(23, 'Münster'),
(24, 'Karlsruhe'),
(25, 'Mannheim'),
(26, 'Augsburgo'),
(27, 'Wiesbaden'),
(28, 'Mönchen'),
(29, 'Gelsenkirchen'),
(30, 'Brunsvique'),
(31, 'Kiel'),
(32, 'Chemnitz'),
(33, 'Aachen'),
(34, 'Halle (Saale)'),
(35, 'Magdeburgo'),
(36, 'Friburgo em Brisgóvia'),
(37, 'Krefeld'),
(38, 'Lübeck'),
(39, 'Mainz'),
(40, 'Erfurt'),
(41, 'Oberhausen'),
(42, 'Rostock'),
(43, 'Kassel'),
(44, 'Hagen'),
(45, 'Saarbrücken'),
(46, 'Hamm'),
(47, 'Potsdam'),
(48, 'Mülheim an der Ruhr'),
(49, 'Ludwigshafen am Rhein'),
(50, 'Oldenburgo'),
(51, 'Osnabruque'),
(52, 'Leverkusen'),
(53, 'Heidelberg'),
(54, 'Solingen'),
(55, 'Darmstadt'),
(56, 'Herne'),
(57, 'Neuss'),
(58, 'Ratisbona'),
(59, 'Paderborn'),
(60, 'Ingolstadt'),
(61, 'Offenbach am Main'),
(62, 'Würzburg'),
(63, 'Fürth'),
(64, 'Ulm'),
(65, 'Heilbronn'),
(66, 'Pforzheim'),
(67, 'Wolfsburg'),
(68, 'Gotinga'),
(69, 'Bottrop'),
(70, 'Reutlingen'),
(71, 'Koblenz'),
(72, 'Recklinghausen'),
(73, 'Bremer­haven'),
(74, 'Bergisch Gladbach'),
(75, 'Jena'),
(76, 'Erlangen'),
(77, 'Remscheid'),
(78, 'Tréveris'),
(79, 'Salzgitter'),
(80, 'Moers'),
(81, 'Siegen'),
(82, 'Hildesheim'),
(83, 'Cottbus');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_cidades_alemanha`
--
ALTER TABLE `tb_cidades_alemanha`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_cidades_alemanha`
--
ALTER TABLE `tb_cidades_alemanha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
