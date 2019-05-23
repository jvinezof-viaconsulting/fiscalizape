-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.1.37-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para fiscalizape
CREATE DATABASE IF NOT EXISTS `fiscalizape` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `fiscalizape`;

-- Copiando estrutura para tabela fiscalizape.admin_login_log
CREATE TABLE IF NOT EXISTS `admin_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(45) NOT NULL,
  `mensagem` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela fiscalizape.admin_login_log: ~40 rows (aproximadamente)
/*!40000 ALTER TABLE `admin_login_log` DISABLE KEYS */;
INSERT INTO `admin_login_log` (`id`, `data`, `ip`, `mensagem`) VALUES
	(1, '2019-02-23 02:02:47', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(2, '2019-02-23 02:02:47', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(3, '2019-02-23 02:02:47', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(4, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(5, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(6, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(7, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(8, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(9, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(10, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(11, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(12, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(13, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(14, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(15, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(16, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(17, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(18, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(19, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(20, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(21, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(22, '2019-02-23 02:02:48', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(23, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(24, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(25, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(26, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(27, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(28, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(29, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(30, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(31, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(32, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(33, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(34, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(35, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(36, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(37, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(38, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(39, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login'),
	(40, '2019-02-23 02:02:49', '::1', 'Usuario que não é adminstrador tentou fazer login');
/*!40000 ALTER TABLE `admin_login_log` ENABLE KEYS */;

-- Copiando estrutura para tabela fiscalizape.admin_onlines
CREATE TABLE IF NOT EXISTS `admin_onlines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `data_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela fiscalizape.admin_onlines: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `admin_onlines` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_onlines` ENABLE KEYS */;

-- Copiando estrutura para tabela fiscalizape.cidades
CREATE TABLE IF NOT EXISTS `cidades` (
  `cidade_id` int(3) NOT NULL AUTO_INCREMENT,
  `cidade_nome` varchar(50) CHARACTER SET utf8 NOT NULL,
  `cidade_estado` char(2) NOT NULL DEFAULT '',
  `cidade_area` varchar(12) DEFAULT NULL,
  `cidade_populacao` varchar(12) DEFAULT NULL,
  `cidade_prefeito` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`cidade_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela fiscalizape.cidades: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `cidades` DISABLE KEYS */;
INSERT INTO `cidades` (`cidade_id`, `cidade_nome`, `cidade_estado`, `cidade_area`, `cidade_populacao`, `cidade_prefeito`) VALUES
	(1, 'Recife', 'PE', '454,452', '1,637,834', 'Geraldo J&uacute;lio'),
	(3, 'Jaboat&atilde;o dos Guararapes', 'PE', '258,694', '697,636', 'Anderson Ferreira'),
	(4, 'Cabo de Santo Agostinho', 'PE', '448,735', '204,653', 'Luiz Cabral');
/*!40000 ALTER TABLE `cidades` ENABLE KEYS */;

-- Copiando estrutura para tabela fiscalizape.email_enviados
CREATE TABLE IF NOT EXISTS `email_enviados` (
  `email_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_token` varchar(40) NOT NULL,
  `email_id_usuario` int(11) NOT NULL,
  `email_data_envio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email_data_validade` datetime NOT NULL,
  `email_utilizado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email_id`),
  KEY `email_id_usuario` (`email_id_usuario`),
  CONSTRAINT `email_id_usuario` FOREIGN KEY (`email_id_usuario`) REFERENCES `usuarios` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela fiscalizape.email_enviados: ~18 rows (aproximadamente)
/*!40000 ALTER TABLE `email_enviados` DISABLE KEYS */;
INSERT INTO `email_enviados` (`email_id`, `email_token`, `email_id_usuario`, `email_data_envio`, `email_data_validade`, `email_utilizado`) VALUES
	(2, 'e7213516603f737a908deddff0115e87', 1, '2019-02-25 23:56:27', '2019-02-27 23:56:27', 0),
	(3, 'b1c4983d60dd06c879ad1173e3888c2c', 1, '2019-02-25 23:56:45', '2019-02-27 23:56:45', 0),
	(4, 'e5df11e43e5c29ea1592df2490c66642', 1, '2019-02-25 23:57:14', '2019-02-27 23:57:14', 0),
	(5, '76466941ff2ec7f6703a4f422c3d46e3', 1, '2019-02-25 23:57:27', '2019-02-27 23:57:27', 0),
	(6, '3aa2a789486dd9977c14e83d68e488db', 1, '2019-02-25 23:57:43', '2019-02-27 23:57:43', 0),
	(7, '0a73919866d97f93fe5d918a34ac5842', 1, '2019-02-26 00:16:47', '2019-02-28 00:16:47', 0),
	(8, '890df85edbbbd1dd8a31da37a6bbd089', 1, '2019-02-26 00:32:54', '2019-02-28 00:32:54', 0),
	(9, '0642f13da36916fce35427830a603b71', 1, '2019-02-26 00:37:28', '2019-02-28 00:37:28', 0),
	(10, '512ff3186edd6e90f02544a710f1bf48', 1, '2019-02-28 23:34:04', '2019-03-02 23:34:04', 0),
	(11, '90187f6661480c677696731c92d1cf51', 1, '2019-02-28 23:50:01', '2019-03-02 23:50:01', 0),
	(12, '514664ed5ea88956a1f68f14aafeb7ed', 1, '2019-03-01 17:36:15', '2019-03-03 17:36:15', 0),
	(13, '3e804e32dcb838d0a7c1169dac2e5ccd', 1, '2019-03-01 17:36:39', '2019-03-03 17:36:39', 0),
	(14, '8f175317a72aa2b1da0cef3399dc424e', 1, '2019-03-01 19:43:05', '2019-03-03 19:43:05', 1),
	(15, '391ba7b0e2628fd4b7c8978d8ab3e66f', 1, '2019-03-01 23:30:18', '2019-03-03 23:30:18', 0),
	(16, '8e16cd1b0105e3723cc81a1346760c5d', 1, '2019-03-01 23:54:54', '2019-03-03 23:54:54', 1),
	(17, '551c06a8dff5d1d3298d159a0334b458', 1, '2019-03-01 23:55:26', '2019-03-03 23:55:26', 1),
	(18, '5b0dc02d776a794d4f1152c7083f6850', 1, '2019-03-02 00:11:41', '2019-03-04 00:11:41', 1),
	(19, '1a5f1e807eb10d07d13e471662c98b3e', 1, '2019-03-02 00:12:18', '2019-03-04 00:12:18', 1);
/*!40000 ALTER TABLE `email_enviados` ENABLE KEYS */;

-- Copiando estrutura para tabela fiscalizape.obras
CREATE TABLE IF NOT EXISTS `obras` (
  `obra_id` int(11) NOT NULL AUTO_INCREMENT,
  `obra_key` varchar(200) NOT NULL,
  `obra_titulo` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `obra_descricao` text CHARACTER SET utf8 NOT NULL,
  `obra_data_inicio_prevista` date NOT NULL,
  `obra_data_final_prevista` date NOT NULL,
  `obra_data_inicio` date DEFAULT NULL,
  `obra_data_final` date DEFAULT NULL,
  `obra_situacao` varchar(50) DEFAULT NULL,
  `obra_orgao_responsavel` varchar(50) DEFAULT NULL,
  `obra_empresa_responsavel` varchar(50) DEFAULT NULL,
  `obra_orcamento_previsto` decimal(10,2) NOT NULL,
  `obra_dinheiro_gasto` decimal(10,2) DEFAULT NULL,
  `obra_contribuidor_id` int(11) NOT NULL,
  `obra_cep` varchar(10) DEFAULT NULL,
  `obra_rua` varchar(60) CHARACTER SET utf8 NOT NULL,
  `obra_bairro` varchar(60) CHARACTER SET utf8 NOT NULL,
  `obra_id_cidade` int(3) NOT NULL,
  `obra_data_criacao` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`obra_id`),
  KEY `FK_id_cidade` (`obra_id_cidade`) USING BTREE,
  KEY `contribuidor_id` (`obra_contribuidor_id`),
  CONSTRAINT `FK_obras` FOREIGN KEY (`obra_id_cidade`) REFERENCES `cidades` (`cidade_id`),
  CONSTRAINT `contribuidor_id` FOREIGN KEY (`obra_contribuidor_id`) REFERENCES `usuarios` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela fiscalizape.obras: ~8 rows (aproximadamente)
/*!40000 ALTER TABLE `obras` DISABLE KEYS */;
INSERT INTO `obras` (`obra_id`, `obra_key`, `obra_titulo`, `obra_descricao`, `obra_data_inicio_prevista`, `obra_data_final_prevista`, `obra_data_inicio`, `obra_data_final`, `obra_situacao`, `obra_orgao_responsavel`, `obra_empresa_responsavel`, `obra_orcamento_previsto`, `obra_dinheiro_gasto`, `obra_contribuidor_id`, `obra_cep`, `obra_rua`, `obra_bairro`, `obra_id_cidade`, `obra_data_criacao`) VALUES
	(1, '19777eb38fc93821293fdc8187da4bd9', 'Primeira Obra', 'essa &eacute; a primeira obra que inserimos no banco de dados.', '2019-03-01', '2019-03-31', NULL, NULL, NULL, NULL, NULL, 6000000.00, NULL, 1, NULL, 'Rua 24', 'COHAB', 4, '2019-03-13 03:05:45'),
	(2, '8cff4690c62f801a71dcd6ec76320691', 'Obra 2', 'Segunda obra que inserimos no banco de dados.', '2019-03-06', '2019-03-13', NULL, '2019-03-13', 'Parada', NULL, NULL, 5000000.00, NULL, 1, NULL, 'Rua 24', 'COHAB', 4, '2019-03-13 03:07:36'),
	(3, '6485ccd1c7d4ecbddc4704f59c0eb969', 'Obra 3 ', 'terceira obra que adiciono.', '2019-03-04', '2019-03-20', '2019-03-12', '2019-03-15', 'Em Andamento', 'Eu mesmo LTDA.', NULL, 55.00, 10.50, 1, NULL, 'Rua 24', 'COHAB', 1, '2019-03-13 03:14:12'),
	(4, '11ad7467b20e71fe13d1b404ec18e0cd', 'Obra criaada por outro usuario', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed fringilla augue ut consequat ullamcorper. Donec vehicula mollis lorem, vel auctor mi rhoncus id. In tincidunt ex eget nisi porta feugiat. Maecenas posuere vulputate diam id aliquam.', '1998-10-26', '1999-05-04', '2018-01-01', '2020-02-20', 'Parada', 'Eu mesmo', NULL, 5455.00, 0.00, 5, NULL, 'R. do Triunfo', 'Arruda', 1, '2019-03-16 02:08:42'),
	(5, '035c2cc41add5a54ffe37b2468c45d27', 'Testando editor', 'egdsgd\r\n<p></p><a class="navbar-brand" href="http://localhost/fiscalizape/view/index.php" target="_blank">\r\n		 FiscalizaPE<p></p><p>Outro Link</p></a>', '1998-05-07', '2000-10-26', NULL, NULL, NULL, NULL, NULL, 546456.57, NULL, 1, NULL, 'Rua Nova Jeruzal&eacute;m', 'COHAB', 4, '2019-03-25 01:53:11'),
	(6, 'd4646cd1566d96b05263e07ebea3da8e', 'teste1', 'safasgagsfhdfhgjhfkhgk', '2019-04-26', '2019-04-29', '0000-00-00', '0000-00-00', NULL, '', NULL, 35467.57, 0.00, 1, '', 'Aurora', 'Centro', 1, '2019-04-15 21:56:38'),
	(7, '4151b9418a5a2c6114dd6420056f0ac3', 'teste1', 'safasgagsfhdfhgjhfkhgk', '2019-04-26', '2019-04-29', '0000-00-00', '0000-00-00', NULL, '', NULL, 35467.57, 0.00, 1, '', 'Aurora', 'Centro', 1, '2019-04-15 21:56:54'),
	(8, '046df4ec098f010ff4e1298eeee1eb9a', 'Obras de pavimenta&ccedil;&atilde;o em Garapu', '&lt;p&gt;\r\n\r\nA Prefeitura do Cabo de Santo Agostinho iniciou, nesta semana, mais uma etapa de obras nas 44 ruas, em Garapu. Ao todo, 100 ruas ser&atilde;o pavimentadas. As ruas Novo Tempo 1, Jaboat&atilde;o dos Guararapes, Ouricuri e Jabot&aacute; ser&atilde;o as primeiras beneficiadas com os servi&ccedil;os.&lt;/p&gt;&lt;p&gt;As vias fazem parte do segundo lote de Garapu. Elas est&atilde;o recebendo al&eacute;m da pavimenta&ccedil;&atilde;o, drenagem em tubos de concreto e canaletas com paredes e tampas tamb&eacute;m em concreto, meio, linha d&rsquo;&aacute;gua, acessibilidade e uma pra&ccedil;a com &aacute;rea de lazer com brinquedos (gangorra, gira gira, escorrego) e mesas.&nbsp;Ao todo, ser&atilde;o aproximadamente seis quil&ocirc;metros de pavimenta&ccedil;&atilde;o com recursos pr&oacute;prios. O prazo para entrega &eacute; de 180 dias.\r\n\r\n&lt;/p&gt;', '2018-03-27', '2018-09-23', '2018-03-27', '2018-09-23', NULL, 'Secretaria Executiva de Obras P&uacute;blicas', NULL, 26800000.00, 26800000.00, 1, '', 'lote 2', 'Garapu', 4, '2019-04-15 22:48:03');
/*!40000 ALTER TABLE `obras` ENABLE KEYS */;

-- Copiando estrutura para tabela fiscalizape.obras_denuncias
CREATE TABLE IF NOT EXISTS `obras_denuncias` (
  `denucia_id` int(11) NOT NULL AUTO_INCREMENT,
  `denuncia_id_obra` int(11) NOT NULL,
  `denuncia_id_usuario` int(11) NOT NULL,
  `denuncia_titulo` varchar(60) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `denuncia_descricao` text CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL,
  `denuncia_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `denuncia_data_problema` date NOT NULL,
  PRIMARY KEY (`denucia_id`),
  KEY `FK_id_usuario` (`denuncia_id_usuario`) USING BTREE,
  KEY `FK_id_obra` (`denuncia_id_obra`) USING BTREE,
  CONSTRAINT `FK_denuncias` FOREIGN KEY (`denuncia_id_obra`) REFERENCES `obras` (`obra_id`),
  CONSTRAINT `FK_denuncias_2` FOREIGN KEY (`denuncia_id_usuario`) REFERENCES `usuarios` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela fiscalizape.obras_denuncias: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `obras_denuncias` DISABLE KEYS */;
/*!40000 ALTER TABLE `obras_denuncias` ENABLE KEYS */;

-- Copiando estrutura para tabela fiscalizape.obras_imagens
CREATE TABLE IF NOT EXISTS `obras_imagens` (
  `obra_imagem_id` int(11) NOT NULL AUTO_INCREMENT,
  `obra_imagem_obra_id` int(11) NOT NULL,
  `obra_imagem_nome` varchar(100) NOT NULL,
  `obra_imagem_excluida` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`obra_imagem_id`),
  KEY `obra_id` (`obra_imagem_obra_id`),
  CONSTRAINT `obra_id` FOREIGN KEY (`obra_imagem_obra_id`) REFERENCES `obras` (`obra_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela fiscalizape.obras_imagens: ~17 rows (aproximadamente)
/*!40000 ALTER TABLE `obras_imagens` DISABLE KEYS */;
INSERT INTO `obras_imagens` (`obra_imagem_id`, `obra_imagem_obra_id`, `obra_imagem_nome`, `obra_imagem_excluida`) VALUES
	(1, 1, 'c4ca4238a0b923820dcc509a6f75849b_5826828995c889db9e57165.98464633.png', 0),
	(2, 1, 'c4ca4238a0b923820dcc509a6f75849b_14313815445c889dba01a926.54860046.png', 0),
	(3, 1, 'c4ca4238a0b923820dcc509a6f75849b_9433044485c889dba0dde52.97175058.png', 1),
	(5, 2, 'c81e728d9d4c2f636f067f89cc14862c_18623651625c889e2923f857.65849828.png', 1),
	(6, 3, 'eccbc87e4b5ce2fe28308fd9f2a7baf3_4768470445c889fb5360084.25111418.png', 1),
	(7, 3, 'eccbc87e4b5ce2fe28308fd9f2a7baf3_182682705c889fb5586d89.12964118.png', 1),
	(8, 3, 'eccbc87e4b5ce2fe28308fd9f2a7baf3_21382366095c889fb5846024.15278997.png', 1),
	(9, 4, 'a87ff679a2f3e71d9181a67b7542122c_1176826295c8fe7a10a5a60.79838290.png', 1),
	(10, 4, 'a87ff679a2f3e71d9181a67b7542122c_8977846055c8fe7c15ac551.57831253.png', 1),
	(11, 4, 'a87ff679a2f3e71d9181a67b7542122c_19139146855c8fe8950a57f4.86203884.png', 1),
	(12, 4, 'a87ff679a2f3e71d9181a67b7542122c_14942165005c8fe9bc9851e2.69985453.png', 0),
	(13, 3, 'eccbc87e4b5ce2fe28308fd9f2a7baf3_12939914815c8fec9c1c7051.29136472.png', 0),
	(14, 8, 'c9f0f895fb98ab9159f51fd0297e236d_15589023405cb53453c76e86.10456681.jpg', 0),
	(15, 8, 'c9f0f895fb98ab9159f51fd0297e236d_2193718175cb53453ce0629.04185215.jpg', 0),
	(16, 8, 'c9f0f895fb98ab9159f51fd0297e236d_10759403865cb53453d51ac7.47465823.jpg', 0),
	(17, 8, 'c9f0f895fb98ab9159f51fd0297e236d_10302935735cb53453e28871.21407490.jpg', 0),
	(18, 8, 'c9f0f895fb98ab9159f51fd0297e236d_19632408935cb5345407c8d8.15674139.jpg', 0);
/*!40000 ALTER TABLE `obras_imagens` ENABLE KEYS */;

-- Copiando estrutura para tabela fiscalizape.obras_verdades
CREATE TABLE IF NOT EXISTS `obras_verdades` (
  `obra_verdade_id` int(11) NOT NULL AUTO_INCREMENT,
  `obra_verdade_usuario_id` int(11) NOT NULL,
  `obra_verdade_obra_id` int(11) NOT NULL,
  `obra_verdade_voto` tinyint(1) NOT NULL,
  `obra_verdade_data_criacao` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `obra_verdade_excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`obra_verdade_id`),
  KEY `verdade_usuario_id` (`obra_verdade_usuario_id`),
  KEY `verdade_obra_id` (`obra_verdade_obra_id`),
  CONSTRAINT `verdade_obra_id` FOREIGN KEY (`obra_verdade_obra_id`) REFERENCES `obras` (`obra_id`),
  CONSTRAINT `verdade_usuario_id` FOREIGN KEY (`obra_verdade_usuario_id`) REFERENCES `usuarios` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela fiscalizape.obras_verdades: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `obras_verdades` DISABLE KEYS */;
INSERT INTO `obras_verdades` (`obra_verdade_id`, `obra_verdade_usuario_id`, `obra_verdade_obra_id`, `obra_verdade_voto`, `obra_verdade_data_criacao`, `obra_verdade_excluido`) VALUES
	(1, 1, 1, 1, '2019-03-14 02:26:12', 0),
	(2, 2, 1, 0, '2019-03-15 02:24:12', 0),
	(3, 4, 1, 1, '2019-03-15 02:24:43', 0),
	(9, 1, 4, 1, '2019-03-17 01:53:34', 0),
	(10, 1, 3, 1, '2019-03-18 22:31:57', 0),
	(11, 1, 5, 0, '2019-03-25 01:53:56', 0),
	(12, 1, 8, 1, '2019-04-15 22:48:30', 0);
/*!40000 ALTER TABLE `obras_verdades` ENABLE KEYS */;

-- Copiando estrutura para tabela fiscalizape.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_nome` varchar(25) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `usuario_sobrenome` varchar(25) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `usuario_cpf` varchar(11) NOT NULL,
  `usuario_nome_usuario` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `usuario_email` varchar(255) NOT NULL DEFAULT '',
  `usuario_email_pendente` varchar(255) DEFAULT NULL,
  `usuario_email_ativado` tinyint(1) DEFAULT '0',
  `usuario_senha` varchar(255) NOT NULL DEFAULT '',
  `usuario_token` varchar(255) NOT NULL,
  `usuario_cargo` char(1) DEFAULT '1',
  `usuario_registro_data` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario_registro_ip` varchar(72) NOT NULL DEFAULT '',
  `usuario_ultimo_acesso` datetime DEFAULT CURRENT_TIMESTAMP,
  `usuario_ultimo_ip` varchar(72) NOT NULL DEFAULT '',
  `usuario_online` enum('0','1') DEFAULT '0',
  `usuario_foto` varchar(255) DEFAULT NULL,
  `usuario_verificado` tinyint(1) DEFAULT '0',
  `usuario_estado` char(2) DEFAULT '',
  `usuario_cidade` varchar(40) CHARACTER SET utf8 DEFAULT '',
  `usuario_cep` varchar(9) DEFAULT '',
  PRIMARY KEY (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela fiscalizape.usuarios: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`usuario_id`, `usuario_nome`, `usuario_sobrenome`, `usuario_cpf`, `usuario_nome_usuario`, `usuario_email`, `usuario_email_pendente`, `usuario_email_ativado`, `usuario_senha`, `usuario_token`, `usuario_cargo`, `usuario_registro_data`, `usuario_registro_ip`, `usuario_ultimo_acesso`, `usuario_ultimo_ip`, `usuario_online`, `usuario_foto`, `usuario_verificado`, `usuario_estado`, `usuario_cidade`, `usuario_cep`) VALUES
	(1, 'Jo&atilde;o', 'Vinezof', '12387245407', 'vinezof2', 'joaovitorvinezof@gmail.com', NULL, 1, '$2y$10$ihMXUwbG6aX2HSoTuHiS1OrjoywCBEEh/n4X95gqPuUzedd6su/JC', '', 'A', '2019-02-13 14:47:26', '127.0.0.1', '0000-00-00 00:00:00', 'CURRENT_TIMESTAMP', '1', 'uploads/c4ca4238a0b923820dcc509a6f75849b_5c81e99cc11f3.png', 0, 'PE', '', '54520550'),
	(2, 'julis', 'beba', '37768555171', '', 'jucesaloba@mail-hub.info', NULL, 1, '$2y$10$ZHnu2tFaixA/BtNCmICu/.BoTwGMVhYiaCvBpfhNMQMffK3bbsGIi', '', '1', '2019-02-19 01:53:15', '::1', '0000-00-00 00:00:00', 'CURRENT_TIMESTAMP', '1', NULL, 0, '', '', ''),
	(3, 'Jo&atilde;o2', 'Amorim', '61271417960', '', 'avaz@ask-mail.com', '', 0, '$2y$10$agTtI9xZfqAPMf9InUPNReh8tiYz8dC9rRX3qo7VbXC8jsvl/Sn3C', 'b3ca98805d0776aeae25f56b125e8c8e', '1', '2019-02-24 12:26:54', '::1', '0000-00-00 00:00:00', 'CURRENT_TIMESTAMP', '1', 'NULL', 0, '', '', ''),
	(4, 'Teste', '2000', '49257160262', '', 'nahoj@directmail24.net', '', 1, '$2y$10$q3cooHe/HXgyyUOa2R4x9.llmS0xvkkK0zKNj.WuRLJGSNxm/ofVW', 'f8aa7b34934ed12a773cdb9dbe8d6111', '1', '2019-02-24 18:20:14', '::1', '0127-00-00 01:00:00', 'CURRENT_TIMESTAMP', '1', NULL, 0, '', '', ''),
	(5, 'Jo&atilde;o', 'AmorimOutr', '42768173746', 'Amorvin&atilde;', 'fignosurki@desoz.com', '', 1, '$2y$10$EkTEkG0XaqP0OHjeLXH5ge5QReNNYvrb5WSNwigX/yV6Zgq0qCBYW', '293bbfea40ff5ff17c4a606e045a6647', '1', '2019-02-25 21:20:59', '::1', '0000-00-00 00:00:00', 'CURRENT_TIMESTAMP', '1', 'JA.png', 0, 'PE', '', '54520550');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
