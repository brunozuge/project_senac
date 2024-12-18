-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/12/2024 às 17:30
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ativo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `ativo`
--

CREATE TABLE `ativo` (
  `idAtivo` int(11) NOT NULL,
  `idMarca` int(11) NOT NULL,
  `descricaoAtivo` varchar(100) NOT NULL,
  `quantidadeAtivo` int(11) NOT NULL,
  `statusAtivo` enum('Ativo','Inativo') NOT NULL,
  `observacaoAtivo` varchar(100) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `dataCadastro` datetime NOT NULL,
  `idUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `marca`
--

CREATE TABLE `marca` (
  `idMarca` int(11) NOT NULL,
  `descricaoMarca` varchar(100) NOT NULL,
  `statusMarca` enum('Ativo','Inativo') NOT NULL,
  `dataCadastro` datetime NOT NULL,
  `usuarcioCadastro` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `marca`
--

INSERT INTO `marca` (`idMarca`, `descricaoMarca`, `statusMarca`, `dataCadastro`, `usuarcioCadastro`) VALUES
(1, 'Apple ', 'Ativo', '2024-12-18 17:29:38', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacao`
--

CREATE TABLE `movimentacao` (
  `idMovimentacao` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idAtivo` int(11) NOT NULL,
  `localOrigem` varchar(100) NOT NULL,
  `localDestino` varchar(100) NOT NULL,
  `dataMovimentacao` datetime NOT NULL,
  `descricaoMovimentacao` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo`
--

CREATE TABLE `tipo` (
  `idTipo` int(11) NOT NULL,
  `descricaoTipo` varchar(100) NOT NULL,
  `statusTipo` enum('Ativo','Inativo') NOT NULL,
  `dataCadastro` datetime NOT NULL,
  `usuarioCadastro` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipo`
--

INSERT INTO `tipo` (`idTipo`, `descricaoTipo`, `statusTipo`, `dataCadastro`, `usuarioCadastro`) VALUES
(1, 'Periférico ', '', '2024-12-18 17:29:55', ''),
(2, 'Hardware', '', '2024-12-18 17:30:08', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nomeUsuario` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senhaUsuario` varchar(30) NOT NULL,
  `turmaUsuario` varchar(11) NOT NULL,
  `dataCadastro` datetime NOT NULL,
  `dataAlteracao` datetime NOT NULL,
  `idUsuarioAlteracao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nomeUsuario`, `usuario`, `senhaUsuario`, `turmaUsuario`, `dataCadastro`, `dataAlteracao`, `idUsuarioAlteracao`) VALUES
(1, 'Rafael Zuge', 'BZ', '$2y$10$izuzCXlEhoPSlzo60fA.9Om', '222', '2024-11-11 23:13:01', '0000-00-00 00:00:00', 0),
(3, 'Bruno Zuge', 'bz', 'MTIzMw==', '221', '2024-12-15 22:56:14', '0000-00-00 00:00:00', 0),
(4, 'tici', 'tc', 'MTIz', '221', '2024-12-15 22:56:35', '0000-00-00 00:00:00', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `ativo`
--
ALTER TABLE `ativo`
  ADD PRIMARY KEY (`idAtivo`),
  ADD KEY `idMarca` (`idMarca`),
  ADD KEY `idTipo` (`idTipo`);

--
-- Índices de tabela `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`idMarca`);

--
-- Índices de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`idMovimentacao`),
  ADD KEY `idUsuario` (`idUsuario`,`idAtivo`);

--
-- Índices de tabela `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`idTipo`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ativo`
--
ALTER TABLE `ativo`
  MODIFY `idAtivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `marca`
--
ALTER TABLE `marca`
  MODIFY `idMarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `idMovimentacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipo`
--
ALTER TABLE `tipo`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
