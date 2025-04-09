-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/04/2025 às 00:56
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
-- Estrutura para tabela `acesso`
--

CREATE TABLE `acesso` (
  `idAcesso` int(11) NOT NULL,
  `idCargo` int(11) NOT NULL,
  `idOpcao` int(11) NOT NULL,
  `statusAcesso` varchar(2) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `dataCadastro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ativo`
--

CREATE TABLE `ativo` (
  `idAtivo` int(11) NOT NULL,
  `descricaoAtivo` varchar(100) NOT NULL,
  `quantidadeAtivo` int(11) NOT NULL,
  `statusAtivo` varchar(50) NOT NULL,
  `observacaoAtivo` varchar(100) NOT NULL,
  `urlImg` varchar(100) NOT NULL,
  `quantidadeMinAtivo` int(11) NOT NULL,
  `obsQuantiAtivo` varchar(100) NOT NULL,
  `idTipo` int(11) NOT NULL,
  `dataCadastro` datetime NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idMarca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ativo`
--

INSERT INTO `ativo` (`idAtivo`, `descricaoAtivo`, `quantidadeAtivo`, `statusAtivo`, `observacaoAtivo`, `urlImg`, `quantidadeMinAtivo`, `obsQuantiAtivo`, `idTipo`, `dataCadastro`, `idUsuario`, `idMarca`) VALUES
(5, 'Teclado', 11, 'S', 'X', 'projeto/imgAtivo/67b6685a38fb3_teclado 1.jpg', 10, 'X', 1, '2025-02-19 20:25:14', 14, 1),
(6, 'Mouse', 100, 'S', 'x', 'projeto/imgAtivo/67b66868bc65d_mouse 1.jpg', 10, '', 3, '2025-02-19 20:25:28', 14, 25),
(7, 'Fone', 10, 'S', 'X', 'projeto/imgAtivo/67b7a2b8d76a8_fone1.jpg', 5, '', 3, '2025-02-20 18:46:32', 14, 1),
(11, 'MousePad', 11, 'S', 'X', 'projeto/imgAtivo/67d8be5f20c0f_download.jpg', 10, 'S', 3, '2025-03-17 21:29:19', 14, 26);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargo`
--

CREATE TABLE `cargo` (
  `idCargo` int(11) NOT NULL,
  `descricaoCargo` varchar(250) NOT NULL,
  `statusCargo` varchar(2) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `dataCadastro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cargo`
--

INSERT INTO `cargo` (`idCargo`, `descricaoCargo`, `statusCargo`, `idUsuario`, `dataCadastro`) VALUES
(1, 'Aluno', 'S', 14, '2025-03-27 00:11:26'),
(2, 'Coordenador', 'S', 14, '2025-03-27 00:13:10'),
(3, 'Diretor', 'S', 14, '2025-03-27 00:13:26'),
(4, 'Professor', 'S', 14, '2025-03-27 00:13:51');

-- --------------------------------------------------------

--
-- Estrutura para tabela `marca`
--

CREATE TABLE `marca` (
  `idMarca` int(11) NOT NULL,
  `descricaoMarca` varchar(100) NOT NULL,
  `statusMarca` varchar(50) NOT NULL,
  `dataCadastroMarca` datetime NOT NULL,
  `dataCadastro` datetime NOT NULL,
  `usuarioCadastro` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `marca`
--

INSERT INTO `marca` (`idMarca`, `descricaoMarca`, `statusMarca`, `dataCadastroMarca`, `dataCadastro`, `usuarioCadastro`) VALUES
(1, 'Lenovo', 'S', '2024-11-30 01:03:35', '2024-11-30 01:03:35', '4'),
(2, 'Dell', 'S', '2024-11-30 01:03:35', '2024-11-30 01:03:35', '4'),
(3, 'Positivo', 'S', '2024-11-30 01:04:05', '2024-11-30 01:04:05', '4'),
(25, ' Logitech', 'S', '0000-00-00 00:00:00', '2025-02-12 19:34:34', '7'),
(26, 'Apple', 'S', '0000-00-00 00:00:00', '2025-02-20 18:47:12', '14'),
(27, 'JBL', 'S', '0000-00-00 00:00:00', '2025-02-20 18:48:06', '14');

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
  `descricaoMovimentacao` varchar(100) NOT NULL,
  `quantidadeUso` int(11) NOT NULL,
  `quantidadeMov` int(11) NOT NULL,
  `tipoMov` varchar(20) NOT NULL,
  `statusMov` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacao`
--

INSERT INTO `movimentacao` (`idMovimentacao`, `idUsuario`, `idAtivo`, `localOrigem`, `localDestino`, `dataMovimentacao`, `descricaoMovimentacao`, `quantidadeUso`, `quantidadeMov`, `tipoMov`, `statusMov`) VALUES
(7, 14, 5, '', '', '2025-02-19 21:05:47', 'X', 100, 100, 'Adicionar', 'N'),
(8, 14, 5, '', '221', '2025-02-19 21:05:59', 'X', 100, 10, 'Realocar', 'N'),
(9, 14, 6, '', '', '2025-02-19 21:06:17', 'X', 100, 100, 'Adicionar', 'N'),
(10, 14, 6, '', '221', '2025-02-19 21:06:29', 'X', 100, 10, 'Realocar', 'N'),
(11, 14, 5, '', '', '2025-02-19 21:08:01', '', 101, 1, 'Adicionar', 'S'),
(12, 14, 6, 'Server', '221', '2025-02-19 21:15:28', 'X', 100, 1, 'Realocar', 'S'),
(13, 14, 7, '222', '222', '2025-02-20 19:53:21', 'X', 5, 5, 'Remover', 'N');

-- --------------------------------------------------------

--
-- Estrutura para tabela `movimentacoes`
--

CREATE TABLE `movimentacoes` (
  `idMovimentacao` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idAtivo` int(11) NOT NULL,
  `localOrigem` varchar(100) NOT NULL,
  `localDestino` varchar(100) NOT NULL,
  `dataMovimentacao` datetime NOT NULL,
  `descricaoMovimentacao` varchar(40) NOT NULL,
  `quantidadeUso` int(11) NOT NULL,
  `quantidadeMov` int(11) NOT NULL,
  `tipoMovimentacao` varchar(20) NOT NULL,
  `statusMov` varchar(2) NOT NULL DEFAULT 'S'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `movimentacoes`
--

INSERT INTO `movimentacoes` (`idMovimentacao`, `idUsuario`, `idAtivo`, `localOrigem`, `localDestino`, `dataMovimentacao`, `descricaoMovimentacao`, `quantidadeUso`, `quantidadeMov`, `tipoMovimentacao`, `statusMov`) VALUES
(1, 7, 1, '1', '1', '2025-01-29 21:11:46', '1', 1, 1, 'Adicionar', 'S'),
(2, 7, 2, '1', '1', '2025-01-29 21:12:19', '1', 30, 30, 'Adicionar', 'N'),
(3, 7, 2, '1', '1', '2025-01-29 21:13:12', '1', 0, 30, 'Remover', 'N'),
(4, 7, 2, '1', '1', '2025-01-29 21:13:45', '1', 30, 30, 'Adicionar', 'N'),
(5, 7, 2, '1', '1', '2025-01-29 21:16:14', '1', 20, 10, 'Remover', 'N'),
(6, 7, 2, '1', '1', '2025-01-29 21:16:28', '1', 20, 12, 'Realocar', 'S');

-- --------------------------------------------------------

--
-- Estrutura para tabela `nivel_acesso`
--

CREATE TABLE `nivel_acesso` (
  `idNivel` int(11) NOT NULL,
  `descricaoNivel` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `nivel_acesso`
--

INSERT INTO `nivel_acesso` (`idNivel`, `descricaoNivel`) VALUES
(1, 'Menu'),
(2, 'Submenu'),
(3, 'Ações');

-- --------------------------------------------------------

--
-- Estrutura para tabela `opcoes_menu`
--

CREATE TABLE `opcoes_menu` (
  `idOpcao` int(11) NOT NULL,
  `descricaoOpcao` varchar(255) NOT NULL,
  `nivelOpcao` int(2) NOT NULL,
  `idSuperior` int(11) NOT NULL,
  `urlOpcao` varchar(255) NOT NULL,
  `statusOpcao` varchar(1) NOT NULL DEFAULT 'S',
  `idUsuario` int(11) NOT NULL,
  `datacadastroOpcao` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `opcoes_menu`
--

INSERT INTO `opcoes_menu` (`idOpcao`, `descricaoOpcao`, `nivelOpcao`, `idSuperior`, `urlOpcao`, `statusOpcao`, `idUsuario`, `datacadastroOpcao`) VALUES
(1, 'TEste', 1, 1, 'AAAAAAAAA', 'S', 0, '0000-00-00 00:00:00'),
(2, 'teste2', 3, 1, '1', 'S', 0, '2025-04-02 00:00:00'),
(3, 'teste3', 2, 1, 'X', 'S', 0, '2025-04-02 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo`
--

CREATE TABLE `tipo` (
  `idTipo` int(11) NOT NULL,
  `descricaoTipo` varchar(100) NOT NULL,
  `statusTipo` varchar(50) NOT NULL,
  `dataCadastro` datetime NOT NULL,
  `usuarioCadastro` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipo`
--

INSERT INTO `tipo` (`idTipo`, `descricaoTipo`, `statusTipo`, `dataCadastro`, `usuarioCadastro`) VALUES
(1, 'Ferramentas', 'N', '2024-11-30 01:04:35', '4'),
(2, 'Hardware', 'S', '2024-11-30 01:04:35', '4'),
(3, 'Periféricos', 'S', '2024-11-30 01:05:02', '4'),
(5, '', 'S', '2025-02-21 19:29:30', '14');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `nomeUsuario` varchar(100) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `senhaUsuario` varchar(20) NOT NULL,
  `turmaUsuario` varchar(20) NOT NULL,
  `admin` varchar(2) NOT NULL DEFAULT 'N',
  `dataCadastro` datetime NOT NULL,
  `dataAlteracao` datetime NOT NULL,
  `idCargo` int(11) NOT NULL,
  `idUsuarioAlteracao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nomeUsuario`, `usuario`, `senhaUsuario`, `turmaUsuario`, `admin`, `dataCadastro`, `dataAlteracao`, `idCargo`, `idUsuarioAlteracao`) VALUES
(14, 'teste', 'bz', 'MTIz', '221', 'S', '2025-02-19 20:24:19', '0000-00-00 00:00:00', 0, 0),
(15, 'Ticiana Rodrigues ', 'tc', 'MTIz', '221', 'N', '2025-03-17 21:30:47', '0000-00-00 00:00:00', 0, 0),
(16, 'bruno', 'aa', 'dGc=', '221', 'N', '2025-03-27 19:32:18', '0000-00-00 00:00:00', 4, 0),
(17, 'gabe', 'gabe', 'Z2FiZQ==', '14', 'N', '2025-04-04 20:52:11', '0000-00-00 00:00:00', 1, 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `acesso`
--
ALTER TABLE `acesso`
  ADD PRIMARY KEY (`idAcesso`),
  ADD KEY `idCargo` (`idCargo`),
  ADD KEY `idOpcao` (`idOpcao`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices de tabela `ativo`
--
ALTER TABLE `ativo`
  ADD PRIMARY KEY (`idAtivo`),
  ADD KEY `idTipo` (`idTipo`,`idMarca`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Índices de tabela `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`idCargo`);

--
-- Índices de tabela `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`idMarca`),
  ADD KEY `usuarioCadastro` (`usuarioCadastro`);

--
-- Índices de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  ADD PRIMARY KEY (`idMovimentacao`);

--
-- Índices de tabela `movimentacoes`
--
ALTER TABLE `movimentacoes`
  ADD PRIMARY KEY (`idMovimentacao`),
  ADD KEY `idUsuario` (`idUsuario`,`idAtivo`);

--
-- Índices de tabela `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
  ADD PRIMARY KEY (`idNivel`);

--
-- Índices de tabela `opcoes_menu`
--
ALTER TABLE `opcoes_menu`
  ADD PRIMARY KEY (`idOpcao`);

--
-- Índices de tabela `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`idTipo`),
  ADD KEY `usuarioCadastro` (`usuarioCadastro`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `usuario` (`usuario`,`idUsuarioAlteracao`),
  ADD KEY `idCargo` (`idCargo`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acesso`
--
ALTER TABLE `acesso`
  MODIFY `idAcesso` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ativo`
--
ALTER TABLE `ativo`
  MODIFY `idAtivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `cargo`
--
ALTER TABLE `cargo`
  MODIFY `idCargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `marca`
--
ALTER TABLE `marca`
  MODIFY `idMarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de tabela `movimentacao`
--
ALTER TABLE `movimentacao`
  MODIFY `idMovimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `movimentacoes`
--
ALTER TABLE `movimentacoes`
  MODIFY `idMovimentacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
  MODIFY `idNivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `opcoes_menu`
--
ALTER TABLE `opcoes_menu`
  MODIFY `idOpcao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `tipo`
--
ALTER TABLE `tipo`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `ativo`
--
ALTER TABLE `ativo`
  ADD CONSTRAINT `fk_ativo_usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
