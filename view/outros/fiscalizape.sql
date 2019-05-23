-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 26-Jan-2019 às 18:53
-- Versão do servidor: 8.0.13
-- versão do PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fiscalizape`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cidades`
--

CREATE TABLE `cidades` (
  `cidade_id` int(3) NOT NULL,
  `cidade_nome` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `cidade_estado` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `cidade_area` decimal(10,1) DEFAULT NULL,
  `cidade_populacao` int(7) DEFAULT NULL,
  `cidade_prefeito` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `cidades`
--

INSERT INTO `cidades` (`cidade_id`, `cidade_nome`, `cidade_estado`, `cidade_area`, `cidade_populacao`, `cidade_prefeito`) VALUES
(1, 'Recife', 'PE', '218.0', 1555, 'Geraldo Júlio'),
(2, 'Jaboatão dos Guararapes', 'PE', '258.7', 335371, 'Anderson Ferreira');

-- --------------------------------------------------------

--
-- Estrutura da tabela `denuncias`
--

CREATE TABLE `denuncias` (
  `denucia_id` int(11) NOT NULL,
  `id_obra` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `denuncia_titulo` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `denuncia_descricao` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `denuncia_status` enum('Em andamento','Parada','Não informado') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Não informado',
  `denuncia_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `denuncia_data_problema` date DEFAULT NULL,
  `denuncia_verdades` int(11) DEFAULT '0',
  `denuncia_mentiras` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `obras`
--

CREATE TABLE `obras` (
  `obra_id` int(11) NOT NULL,
  `id_cidade` int(3) NOT NULL,
  `obra_titulo` varchar(60) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `obra_descricao` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `obra_data_inicio_prevista` date NOT NULL,
  `obra_data_inicio` date DEFAULT NULL,
  `obra_data_final_prevista` date DEFAULT NULL,
  `obra_data_final` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `usuario_nome` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `usuario_sobrenome` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `usuario_nome_usuario` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `usuario_email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `usuario_email_pendente` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '',
  `usuario_email_ativado` tinyint(1) DEFAULT '0',
  `usuario_senha` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `usuario_cargo` tinyint(1) DEFAULT '1',
  `usuario_registro_data` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario_registro_ip` varchar(72) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `usuario_ultimo_acesso` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario_ultimo_ip` varchar(72) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `usuario_online` enum('0','1') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '0',
  `usuario_foto` int(11) DEFAULT '1',
  `usuario_verificado` tinyint(1) DEFAULT '0',
  `usuario_estado` char(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '',
  `usuario_cidade` varchar(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '',
  `usuario_cep` varchar(9) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `usuario_nome`, `usuario_sobrenome`, `usuario_nome_usuario`, `usuario_email`, `usuario_email_pendente`, `usuario_email_ativado`, `usuario_senha`, `usuario_cargo`, `usuario_registro_ip`, `usuario_ultimo_ip`, `usuario_online`, `usuario_foto`, `usuario_verificado`, `usuario_estado`, `usuario_cidade`, `usuario_cep`) VALUES
(1, 'Administrador', '', 'admin', 'admin@example.com', '', 0, '', 1, '127.0.0.1', '127.0.0.1', '0', 1, NULL, 'PE', 'Jaboatão dos Guararapes', '54110-071');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`cidade_id`);

--
-- Indexes for table `denuncias`
--
ALTER TABLE `denuncias`
  ADD PRIMARY KEY (`denucia_id`),
  ADD KEY `FK_id_usuario` (`id_usuario`) USING BTREE,
  ADD KEY `FK_id_obra` (`id_obra`) USING BTREE;

--
-- Indexes for table `obras`
--
ALTER TABLE `obras`
  ADD PRIMARY KEY (`obra_id`),
  ADD KEY `FK_id_cidade` (`id_cidade`) USING BTREE;

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `UNI_nome_usuario` (`usuario_nome_usuario`) USING BTREE,
  ADD UNIQUE KEY `UNI_email` (`usuario_email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cidades`
--
ALTER TABLE `cidades`
  MODIFY `cidade_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `denuncias`
--
ALTER TABLE `denuncias`
  MODIFY `denucia_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `obras`
--
ALTER TABLE `obras`
  MODIFY `obra_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `denuncias`
--
ALTER TABLE `denuncias`
  ADD CONSTRAINT `FK_denuncias` FOREIGN KEY (`id_obra`) REFERENCES `obras` (`obra_id`),
  ADD CONSTRAINT `FK_denuncias_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`usuario_id`);

--
-- Limitadores para a tabela `obras`
--
ALTER TABLE `obras`
  ADD CONSTRAINT `FK_obras` FOREIGN KEY (`id_cidade`) REFERENCES `cidades` (`cidade_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
