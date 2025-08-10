-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 10/08/2025 às 12:57
-- Versão do servidor: 8.0.33
-- Versão do PHP: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `almoxarifado`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `entradas`
--

CREATE TABLE `entradas` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `data_entrada` datetime NOT NULL,
  `fornecedor` varchar(100) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `entradas`
--

INSERT INTO `entradas` (`id`, `item_id`, `quantidade`, `data_entrada`, `fornecedor`, `usuario`) VALUES
(1, 1, 10, '2025-06-08 12:59:24', 'Nordife', 'kenio'),
(2, 1, 15, '2025-06-08 12:59:37', 'Nordife', 'kenio'),
(3, 2, 100, '2025-06-08 13:03:28', 'Nordife', 'kenio'),
(4, 2, 100, '2025-06-08 13:03:46', 'Nordife', 'kenio'),
(5, 1, 7, '2025-06-08 13:12:02', 'Nordife', 'kenio'),
(6, 1, 100, '2025-06-08 13:45:13', 'Nordife', 'kenio'),
(7, 2, 200, '2025-06-08 13:45:34', 'Nordife', 'kenio'),
(8, 4, 200, '2025-06-08 20:04:10', 'Carajas', 'kenio'),
(9, 5, 700, '2025-07-28 10:28:34', '', 'kenio'),
(10, 6, 30, '2025-07-28 10:30:28', '', 'kenio'),
(11, 8, 1200, '2025-07-28 10:34:00', '', 'kenio'),
(12, 7, 50, '2025-07-28 10:37:44', '', 'kenio'),
(13, 19, 20, '2025-07-28 10:54:33', '', 'kenio'),
(14, 20, 108, '2025-07-28 10:55:15', '', 'kenio'),
(15, 22, 120, '2025-07-28 10:57:46', '', 'kenio'),
(16, 21, 5760, '2025-07-28 10:59:00', '', 'kenio'),
(17, 12, 1440, '2025-07-28 11:00:33', '', 'kenio'),
(18, 13, 50, '2025-07-28 11:00:57', '', 'kenio'),
(19, 14, 4500, '2025-07-28 11:01:23', '', 'kenio'),
(20, 15, 432, '2025-07-28 11:01:46', '', 'kenio'),
(21, 18, 144, '2025-07-28 11:02:08', '', 'kenio'),
(22, 34, 234, '2025-07-28 11:19:37', '', 'kenio'),
(23, 23, 180, '2025-07-28 11:20:22', '', 'kenio'),
(24, 29, 150, '2025-07-28 11:22:48', '', 'kenio'),
(25, 31, 20, '2025-07-28 11:23:45', '', 'kenio'),
(26, 32, 300, '2025-07-28 11:24:12', '', 'kenio'),
(27, 33, 300, '2025-07-28 11:24:27', '', 'kenio'),
(28, 40, 40, '2025-07-28 11:53:26', '', 'kenio'),
(29, 39, 360, '2025-07-28 11:53:41', '', 'kenio'),
(30, 41, 30, '2025-07-28 11:54:02', '', 'kenio'),
(31, 42, 50, '2025-07-28 11:54:16', '', 'kenio'),
(32, 43, 90, '2025-07-28 11:54:36', '', 'kenio'),
(33, 44, 90, '2025-07-28 11:54:49', '', 'kenio'),
(34, 45, 90, '2025-07-28 11:54:57', '', 'kenio'),
(35, 46, 90, '2025-07-28 11:55:17', '', 'kenio'),
(36, 47, 20, '2025-07-28 11:55:37', '', 'kenio'),
(37, 51, 80, '2025-07-28 12:03:23', '', 'lillia'),
(38, 52, 100, '2025-07-28 12:04:27', '', 'lillia'),
(39, 53, 100, '2025-07-28 12:06:40', '', 'lillia'),
(40, 54, 50, '2025-07-28 12:07:04', '', 'lillia'),
(41, 55, 50, '2025-07-28 12:07:19', '', 'lillia'),
(42, 56, 40, '2025-07-28 12:07:34', '', 'lillia'),
(43, 57, 40, '2025-07-28 12:07:45', '', 'lillia'),
(44, 58, 40, '2025-07-28 12:07:55', '', 'lillia'),
(45, 24, 90, '2025-07-28 12:15:15', '', 'lillia'),
(46, 25, 30, '2025-07-28 12:15:39', '', 'lillia'),
(47, 26, 80, '2025-07-28 12:16:09', '', 'lillia'),
(48, 30, 54, '2025-07-28 12:16:49', '', 'lillia'),
(49, 61, 120, '2025-07-28 12:44:29', '', 'lillia'),
(50, 63, 3, '2025-07-28 12:45:10', '', 'lillia'),
(51, 64, 20, '2025-07-28 12:45:22', '', 'lillia'),
(52, 65, 6, '2025-07-28 12:45:50', '', 'lillia'),
(53, 68, 180, '2025-07-28 12:46:38', '', 'lillia'),
(54, 69, 10, '2025-07-28 12:47:19', '', 'lillia'),
(55, 70, 5, '2025-07-28 12:47:32', '', 'lillia'),
(56, 72, 500, '2025-07-28 12:48:43', '', 'lillia'),
(57, 73, 5, '2025-07-28 12:49:08', '', 'lillia'),
(58, 74, 54, '2025-07-28 12:49:32', '', 'lillia'),
(59, 75, 90, '2025-07-28 12:51:02', '', 'lillia'),
(60, 76, 100, '2025-07-28 12:51:25', '', 'lillia'),
(61, 77, 90, '2025-07-28 12:51:44', '', 'lillia'),
(62, 78, 126, '2025-07-28 12:52:10', '', 'lillia'),
(63, 81, 100, '2025-07-28 12:55:41', '', 'lillia'),
(64, 82, 100, '2025-07-28 12:55:52', '', 'lillia'),
(65, 83, 100, '2025-07-28 12:56:13', '', 'lillia'),
(66, 84, 10, '2025-07-28 12:56:28', '', 'lillia'),
(67, 85, 40, '2025-07-28 12:57:41', '', 'lillia'),
(68, 62, 1080, '2025-07-28 12:59:21', '', 'lillia'),
(69, 66, 50, '2025-07-28 13:01:06', '', 'lillia'),
(70, 36, 54, '2025-07-29 11:27:38', '', 'lillia'),
(71, 79, 108, '2025-08-01 11:18:48', '', 'lillia'),
(72, 88, 5, '2025-08-01 11:19:51', '', 'lillia'),
(73, 89, 5, '2025-08-01 11:20:10', '', 'lillia'),
(74, 90, 50, '2025-08-01 11:20:35', '', 'lillia'),
(75, 91, 50, '2025-08-01 11:20:58', '', 'lillia'),
(76, 92, 15, '2025-08-01 11:21:37', '', 'lillia'),
(77, 96, 120, '2025-08-01 11:22:02', '', 'lillia'),
(78, 97, 120, '2025-08-01 11:22:27', '', 'lillia'),
(79, 100, 20, '2025-08-01 11:24:17', '', 'lillia'),
(80, 101, 3, '2025-08-01 11:24:33', '', 'lillia'),
(81, 102, 100, '2025-08-01 11:25:23', '', 'lillia'),
(82, 104, 40, '2025-08-01 11:26:05', '', 'lillia'),
(83, 105, 30, '2025-08-01 11:26:41', '', 'lillia'),
(84, 106, 100, '2025-08-01 11:27:15', '', 'lillia'),
(85, 107, 10, '2025-08-01 11:27:40', '', 'lillia'),
(86, 108, 10, '2025-08-01 11:28:02', '', 'lillia'),
(87, 110, 5, '2025-08-01 11:28:22', '', 'lillia'),
(88, 112, 100, '2025-08-01 11:28:38', '', 'lillia'),
(89, 113, 100, '2025-08-01 11:29:01', '', 'lillia'),
(90, 114, 100, '2025-08-01 11:29:35', '', 'lillia'),
(91, 117, 9, '2025-08-01 11:30:19', '', 'lillia'),
(92, 118, 50, '2025-08-01 11:30:46', '', 'lillia'),
(93, 119, 50, '2025-08-01 11:31:05', '', 'lillia'),
(94, 120, 50, '2025-08-01 11:31:17', '', 'lillia'),
(95, 122, 15, '2025-08-01 11:32:10', '', 'lillia'),
(96, 125, 40, '2025-08-01 11:34:13', '', 'lillia'),
(97, 126, 40, '2025-08-01 11:34:51', '', 'lillia'),
(98, 127, 6, '2025-08-01 11:35:24', '', 'lillia'),
(99, 129, 30, '2025-08-01 11:35:53', '', 'lillia'),
(100, 131, 2, '2025-08-01 11:36:25', '', 'lillia'),
(101, 132, 2, '2025-08-01 11:36:41', '', 'lillia'),
(102, 132, 2, '2025-08-01 11:38:10', '', 'lillia'),
(103, 9, 50, '2025-08-01 11:38:50', '', 'lillia'),
(104, 99, 12, '2025-08-01 12:06:33', '', 'lillia'),
(105, 60, 54, '2025-08-01 12:09:30', '', 'lillia');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens`
--

CREATE TABLE `itens` (
  `id` int NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descricao` text NOT NULL,
  `unidade` varchar(20) NOT NULL,
  `estoque_atual` int NOT NULL DEFAULT '0',
  `estoque_minimo` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `itens`
--

INSERT INTO `itens` (`id`, `codigo`, `descricao`, `unidade`, `estoque_atual`, `estoque_minimo`) VALUES
(1, '1', 'cabo', 'uni', 101, 10),
(2, '2', 'Cabo singelo 2,5 mm', 'metro', 277, 100),
(3, '3', 'alicate universal', 'und', 0, 5),
(4, '4', 'Ceramica 45x45', 'm²', 45, 50),
(5, '5', 'Papel Ofício A4', 'resma', 690, 100),
(6, '6', 'Pincel quadro branco', 'unid', 30, 10),
(7, '7', 'Apagador quadro branco', 'unid', 50, 10),
(8, '8', 'Apontador de lápis simples', 'unid', 1200, 10),
(9, '9', 'Apontador de lápis com coletor', 'unid', 50, 10),
(10, '10', 'Caderno brochura pequeno', 'unid', 0, 10),
(11, '11', 'Caderno brochura grande', 'unid', 0, 10),
(12, '12', 'Borracha apagadora', 'unid', 1440, 50),
(13, '13', 'Calculadora média', 'unid', 50, 10),
(14, '14', 'Caneta esfereográfica', 'unid', 4500, 50),
(15, '15', 'Caneta marca texto', 'unid', 432, 30),
(18, '16', 'Caneta para retroprojetor', 'unid', 144, 30),
(19, '17', 'Caneta permanente para CD', 'unid', 20, 5),
(20, '18', 'Caneta permanente ponta grossa', 'unid', 108, 5),
(21, '19', 'Lápis grafite sem borracha', 'unid', 5760, 50),
(22, '20', 'Lápis hidrocor', 'pct', 120, 20),
(23, '21', 'Cartolina', 'unid', 180, 50),
(24, '23', 'Clips 2/0', 'cx-100unid', 90, 20),
(25, '24', 'Clips 4/0', 'cx-50unid', 30, 20),
(26, '25', 'Clips 6/0', 'cx-25unid', 80, 20),
(27, '32', 'Cola instantânea (tek bond)', 'unid', 0, 10),
(28, '26', 'Cola Branca 500g', 'unid', 0, 10),
(29, '27', 'Cola Branca 90g', 'unid', 150, 20),
(30, '28', 'Cola gliter', 'cx - 6 unids', 54, 10),
(31, '29', 'Cola isopor 90gr', 'unid', 20, 5),
(32, '30', 'Cola bastão fino', 'unid', 300, 50),
(33, '31', 'Cola bastão grossa', 'unid', 300, 50),
(34, '22', 'Cartolina guache', 'unid', 234, 50),
(36, '33', 'Colher descartável', 'pct-50', 54, 10),
(38, '34', 'Copo descartável 180ml', 'pct', 0, 50),
(39, '35', 'corretivo líquido', 'unid', 360, 10),
(40, '36', 'Corretivo em fita', 'unid', 40, 5),
(41, '37', 'Estilete estreito', 'unid', 30, 5),
(42, '38', 'Estilete largo', 'unid', 50, 10),
(43, '39', 'EVA liso', 'unid', 90, 10),
(44, '40 ', 'EVA aveludado', 'unid', 90, 10),
(45, '41', 'EVA com glitter', 'unid', 90, 10),
(46, '42', 'EVA estampado', 'unid', 90, 10),
(47, '43', 'Extrator de grampos', 'unid', 20, 10),
(48, '44', 'Faca descartável', 'pct-50', 0, 10),
(49, '45', 'Fita adesiva transparente grossa', 'unid', 0, 30),
(50, '46', 'Fita adesiva bege fina', 'unid', 0, 10),
(51, '47', 'Fita adesiva bege grossa', 'unid', 80, 10),
(52, '48', 'Fita adesiva dupla face branca fina', 'unid', 100, 20),
(53, '49', 'Fita adesiva fina (12)', 'unid', 100, 10),
(54, '50', 'Fita de nylon 20mm', 'rolo', 50, 10),
(55, '51', 'Fita de nylon 30mm', 'rolo', 50, 10),
(56, '52', 'Folha de isopor 10mm', 'placa', 40, 10),
(57, '53', 'Folha de isopor 0,25mm', 'placa', 40, 10),
(58, '54', 'Folha de isopor 30mm', 'unid', 40, 10),
(59, '55', 'Garfos descartáveis para almoço', 'pct-50', 0, 10),
(60, '56', 'garfos descartáveis pequenos', 'pct-50', 54, 10),
(61, '57', 'Giz de cera c/ 12', 'cx', 120, 10),
(62, '58', 'Glitter ', 'unid', 1080, 10),
(63, '59', 'Grampeador alicate', 'unid', 3, 5),
(64, '60', 'Grampeador usual', 'unid', 20, 5),
(65, '61', 'Grampeador grande', 'unid', 6, 5),
(66, '62', 'Grampos para grampeador c/1.000', 'cx', 50, 5),
(67, '63', 'Livro de protocolo', 'unid', 0, 5),
(68, '64', 'Massa de modelar c/12', 'cx', 180, 10),
(69, '65', 'organizador acrílico 2 bandejas', 'unid', 10, 2),
(70, '66', 'organizador acrílico 3 bandejas', 'unid', 5, 2),
(71, '67', 'Papel 40kg', 'unid', 0, 50),
(72, '68', 'Papel Colorset', 'unid', 500, 10),
(73, '69', 'Papel Contact', 'unid', 5, 1),
(74, '70', 'Papel crepom', 'unid', 54, 10),
(75, '71', 'Papel lembrete grande autoadesivo 100fls', 'Bloco', 90, 5),
(76, '72', 'Papel madeira', 'unid', 100, 10),
(77, '73', 'papel lembrete P 100fs', 'bloco', 90, 5),
(78, '74', 'Papel camurça', 'unid', 0, 10),
(79, '75', 'Papel cartão', 'unid', 108, 10),
(80, '76', 'Papel laminado', 'unid', 0, 5),
(81, '77', 'Pasta flexivel 30mm com elastico', 'unid', 100, 10),
(82, '78', 'Pasta flexível fina com elástico', 'unid', 100, 10),
(83, '79', 'Pasta classificadora dupla', 'unid', 100, 5),
(84, '80', 'Pasta tipo A-Z', 'unid', 10, 5),
(85, '81', 'Pasta suspensa trilho', 'unid', 40, 5),
(86, '82', 'Percevejo c/100', 'cx', 0, 5),
(87, '83', 'Pendrive 16 Gg', 'unid', 0, 2),
(88, '84', 'Perfurador de papel 20fls', 'unid', 5, 2),
(89, '85', 'Perfurador de papel 30 fls', 'unid', 5, 2),
(90, '86', 'Pistola cola quente fino', 'unid', 50, 5),
(91, '87', 'Pistola cola quente grossa', 'unid', 50, 5),
(92, '88', 'Prancheta portatil', 'unid', 15, 5),
(93, '89', 'Pratos descartáveis fundo 15cm', 'pct-10unid', 0, 10),
(94, '90', 'Pratos descartáveis raso 18cm', 'pct-10unid', 0, 10),
(95, '91', 'Pratos descartáveis rasos 21cm', 'pct-10unid', 0, 10),
(96, '92', 'Prendedor de papel 32mm (M)', 'unid', 120, 50),
(97, '93', 'Prendedor de papel 41mm (G)', 'unid', 120, 50),
(98, '94', 'Quadro de aviso 1,2x0,9', 'unid', 0, 5),
(99, '95', 'TNT rolo 50m', 'metro', 12, 5),
(100, '96', 'Tesoura cabo anatômico', 'unid', 20, 5),
(101, '97', 'Tesoura de picotar', 'unid', 3, 5),
(102, '98', 'Tesoura inox', 'unid', 100, 5),
(103, '99', 'Tinta guache 15ml', 'unid', 0, 5),
(104, '100', 'Tinta para carimbo 40ml', 'uni', 40, 5),
(105, '101', 'Tinta para quadro 20ml', 'unid', 30, 5),
(106, '102', 'Pasta Canaleta com vareta', 'unid', 100, 10),
(107, '103', 'Pasta com divisórias', 'unid', 10, 5),
(108, '104', 'Pasta organizadora', 'unid', 10, 5),
(109, '105', 'Bloco de recado branco', 'unid', 0, 5),
(110, '106', 'Cola de Isopor 1kg', 'unid', 5, 2),
(111, '107', 'Cola de isopor em bastão', 'unid', 0, 2),
(112, '108', 'Cola Glitter', 'unid', 100, 10),
(113, '109', 'Papel ofício colorido', 'unid', 100, 10),
(114, '110', 'Fita adesiva marrom 48x45', 'unid', 100, 10),
(115, '111', 'Alfinete', 'cx', 0, 5),
(116, '112', 'Barbante nylon', 'rolo', 0, 5),
(117, '113', 'Barbante Algodão', 'rolo', 9, 10),
(118, '114', 'Tabuada', 'unid', 50, 5),
(119, '115', 'Caderno 10 matérias', 'unid', 50, 5),
(120, '116', 'Caderno 20 matérias', 'unid', 25, 5),
(121, '117', 'Cartolina microondulada', 'unid', 0, 5),
(122, '118', 'Papel foto', 'pct-20fls', 15, 5),
(123, '119', 'Pincel nº2', 'unid', 0, 10),
(124, '120', 'Pincel nº4', 'unid', 0, 10),
(125, '121', 'Pincel nº6', 'unid', 40, 10),
(126, '122', 'Pincel nº8', 'unid', 40, 10),
(127, '123', 'Kit Geométrico', 'unid', 6, 5),
(128, '124', 'Fita cetim fina', 'pct', 0, 5),
(129, '125', 'Lapiseira nº5', 'unid', 30, 5),
(130, '126', 'Lapiseira nº6', 'unid', 0, 5),
(131, '127', 'Jogo de dama', 'unid', 2, 5),
(132, '128', 'Jogo de Dominó', 'unid', 4, 5),
(133, '129', 'Jogo Pega vareta', 'unid', 0, 5),
(134, '130', 'Cola para tecido', 'unid', 0, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `locais`
--

CREATE TABLE `locais` (
  `id` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `tipo` enum('Escola','Creche','Setor Interno','Anexo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `locais`
--

INSERT INTO `locais` (`id`, `nome`, `tipo`) VALUES
(1, 'EMEF Moacir Dantas', 'Escola'),
(2, 'Creche Nossa Senhora Aparecida', 'Creche'),
(3, 'Creche Jaime Caetano  ', 'Creche'),
(4, 'EMEF Airton Ciraulo', 'Escola'),
(5, 'E.M.E.F. Senador Rui Carneiro', 'Escola'),
(6, 'E.M.E.F. Berenice Ribeiro Coutinho', 'Escola'),
(7, 'E.M.E.F. José Ribeiro De Morais ', 'Escola'),
(8, 'E.M.E.F. Joaquim Lafayette – INTEGRAL', 'Escola'),
(9, 'E.M.E.F. Dom Helder', 'Escola'),
(10, 'Creche Alice Suassuna', 'Creche'),
(11, 'E.M.E.F. Otílio Ciraulo', 'Escola'),
(12, 'E.M.E.F. Rita Alves', 'Escola'),
(13, 'E.M.E.F. Edgard Seager', 'Escola'),
(14, 'Creche Lar Luz e Vida', 'Creche'),
(15, 'E.M.E.F. Presidente Tancredo De Almeida Neves – INTEGRAL', 'Escola'),
(16, 'E.M.E.F. João Fernandes De Lima ', 'Escola'),
(17, 'E.M.E.F. Assis Chateaubriand', 'Escola'),
(18, 'E.M.E.F. Pascoal Massilio', 'Escola'),
(19, 'E.M.E.F. Flavio Ribeiro Coutinho', 'Escola'),
(20, 'E.M.E.F. Fernando Cunha Lima  - INTEGRAL', 'Escola'),
(21, 'Creche Nossa Senhora da Conceição', 'Creche'),
(22, 'E.M.E.F. Petrônio De Figueiredo ', 'Escola'),
(23, 'E.M.E.F. Maria Das Neves Lins ', 'Escola'),
(24, 'E.M.E.F. Francisco Joaquim De Brito', 'Escola'),
(25, 'Creche Cristiano Martins De Lima', 'Creche'),
(26, 'E.M.E.F. Luciano Ribeiro De Morais - ', 'Escola'),
(27, 'E.M.E.F. Vereador João Belmiro Dos Santos', 'Escola'),
(28, 'Creche Vovó Genésia', 'Creche'),
(29, 'E.M.E.F. Sandra Maria Carneiro De Souza', 'Escola'),
(30, 'E.M.E.F. Maria Do Carmo Da Silveira Lima', 'Escola'),
(31, 'Creche Mãe Manda', 'Creche'),
(32, 'Creche Municipal Clotilde Rodrigues Catão', 'Creche'),
(33, 'Creche Solar Joana de Angelis', 'Creche'),
(34, 'E.M.E.F. Maria José Pinto de Lima', 'Escola'),
(35, 'E.M.E.F. Joana Fortunato', 'Escola'),
(36, 'E.M.E.F. João Jacinto', 'Escola'),
(37, 'E.M.E.F. Jaidê Rodrigues', 'Escola');

-- --------------------------------------------------------

--
-- Estrutura para tabela `saidas`
--

CREATE TABLE `saidas` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `data_saida` datetime NOT NULL,
  `destino` varchar(100) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `saidas`
--

INSERT INTO `saidas` (`id`, `item_id`, `quantidade`, `data_saida`, `destino`, `usuario`) VALUES
(1, 1, 1, '2025-06-08 12:59:55', 'Gabinete Secretario', 'kenio'),
(2, 1, 30, '2025-06-08 13:00:49', 'Gabinete Secretario', 'kenio'),
(3, 2, 120, '2025-06-08 13:04:12', 'Gabinete Secretario', 'kenio'),
(4, 2, 3, '2025-06-08 13:12:46', 'Gabinete Secretario', 'kenio'),
(5, 4, 150, '2025-06-08 20:04:48', '1', 'kenio'),
(6, 4, 5, '2025-06-08 20:05:16', '2', 'kenio'),
(7, 120, 25, '2025-08-07 08:49:37', '13', 'lillia');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `nome_completo` varchar(200) DEFAULT NULL,
  `ultimo_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `nome_completo`, `ultimo_login`) VALUES
(1, 'kenio', 'Kenio', '2025-06-08 12:58:14'),
(25, 'visitante', 'Visitante', '2025-06-08 20:12:42'),
(34, 'silvia', 'Silvia Sales', '2025-06-10 13:34:01'),
(43, 'lillia', 'Lillia', '2025-07-28 12:01:45');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Índices de tabela `itens`
--
ALTER TABLE `itens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Índices de tabela `locais`
--
ALTER TABLE `locais`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `saidas`
--
ALTER TABLE `saidas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de tabela `itens`
--
ALTER TABLE `itens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT de tabela `locais`
--
ALTER TABLE `locais`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `saidas`
--
ALTER TABLE `saidas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `entradas_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `itens` (`id`);

--
-- Restrições para tabelas `saidas`
--
ALTER TABLE `saidas`
  ADD CONSTRAINT `saidas_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `itens` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
