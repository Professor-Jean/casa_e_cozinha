-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/12/2016 às 18:59
-- Versão do servidor: 5.7.11-log
-- Versão do PHP: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ccabd`
--
CREATE DATABASE IF NOT EXISTS `ccabd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ccabd`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código do agendamento',
  `projetos_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identifição do projeto que recebeu o agendamento.',
  `tipo` tinyint(1) NOT NULL COMMENT 'Tipo de agendamento que será feito.\n1 - Agendamento de recolhimento de informações\n2 - Agendamento de homologação de projeto\n3 - Agendamento de entrega de produto',
  `status` tinyint(1) NOT NULL COMMENT 'Status em que se encontra o agendamento.\n1 - Completo\n2 - Imcompleto\n3 - Cancelado',
  `data_marcada` date NOT NULL COMMENT 'Data marcada pelo funcionários no agendamento.',
  `horario` time NOT NULL COMMENT 'Hórario marcado pelo funcionários para o agendamento.',
  `data_criada` date NOT NULL COMMENT 'Data em que foi feito o registro.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela que armazena os agendamentos referentes a cada projeto de cada cliente.';

--
-- Fazendo dump de dados para tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `projetos_id`, `tipo`, `status`, `data_marcada`, `horario`, `data_criada`) VALUES
(000008, 0012, 1, 1, '2016-12-31', '23:59:00', '2016-12-01'),
(000009, 0011, 1, 1, '2016-12-02', '18:00:00', '2016-12-01'),
(000010, 0012, 2, 1, '2017-02-01', '10:00:00', '2016-12-01'),
(000011, 0011, 2, 1, '2016-12-03', '19:00:00', '2016-12-01'),
(000012, 0013, 1, 1, '2017-01-07', '20:16:00', '2016-12-01'),
(000013, 0013, 2, 3, '2017-01-04', '16:45:00', '2016-12-01'),
(000014, 0014, 1, 1, '2016-12-02', '15:00:00', '2016-12-01'),
(000015, 0014, 1, 0, '2016-12-02', '15:00:00', '2016-12-01'),
(000016, 0015, 1, 2, '2016-12-09', '15:15:00', '2016-12-01'),
(000017, 0015, 1, 3, '2016-12-14', '21:21:00', '2016-12-01'),
(000018, 0015, 1, 1, '2016-11-25', '21:21:00', '2016-12-01'),
(000019, 0015, 2, 1, '2017-02-03', '15:15:00', '2016-12-01'),
(000020, 0014, 2, 1, '2016-12-13', '18:00:00', '2016-12-01'),
(000021, 0016, 1, 3, '2017-02-28', '17:55:00', '2016-12-01'),
(000022, 0016, 1, 1, '2017-02-03', '19:30:00', '2016-12-01'),
(000023, 0015, 3, 1, '2016-12-31', '14:14:00', '2016-12-01'),
(000024, 0016, 2, 1, '2016-12-30', '14:14:00', '2016-12-01'),
(000025, 0016, 3, 0, '2016-12-23', '14:14:00', '2016-12-01'),
(000026, 0012, 3, 2, '2016-12-13', '18:00:00', '2016-12-01'),
(000027, 0012, 3, 3, '2016-12-19', '18:00:00', '2016-12-01'),
(000030, 0018, 1, 3, '2016-12-15', '21:21:00', '2016-12-01'),
(000031, 0017, 1, 3, '2016-12-20', '12:12:00', '2016-12-01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ambientes`
--

CREATE TABLE `ambientes` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do ambiente.',
  `nome` varchar(20) NOT NULL COMMENT 'Nome do ambiente que o funcionário registrou.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela armazena os ambientes que são afetados pelo projetos.';

--
-- Fazendo dump de dados para tabela `ambientes`
--

INSERT INTO `ambientes` (`id`, `nome`) VALUES
(001, 'Escritorio'),
(002, 'Cozinha'),
(003, 'Sala'),
(004, 'Quarto'),
(005, 'Banheiro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `arquivos`
--

CREATE TABLE `arquivos` (
  `id` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código do arquivo',
  `projetos_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do projeto associado.',
  `nome` varchar(45) NOT NULL COMMENT 'Nome descritivo do arquivo, usado para saber qual arquivo o funcionário escolhera.',
  `caminho` char(39) NOT NULL COMMENT 'Caminho do arquivo, usado para saber onde o arquivo se encontra no servidor.\nEntensão: ".promob"',
  `data` date NOT NULL COMMENT 'Data em que foi realizado o upload do arquivo.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela que armazena o nome e caminho do arquivos do projeto, que forem feitos upload.';

--
-- Fazendo dump de dados para tabela `arquivos`
--

INSERT INTO `arquivos` (`id`, `projetos_id`, `nome`, `caminho`, `data`) VALUES
(000007, 0011, 'estante_detalhada', 'f9027c7b4d4068520dc9ecfe7dc0cb8d.promob', '2016-12-01'),
(000008, 0012, 'Cozinha', '17d1a88fcf2ae36a64cf3207dca84f83.promob', '2016-12-01'),
(000009, 0015, 'Sala', 'f72d5bea7c22d1bedd8ccf894bb19bdd.promob', '2016-12-01');

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do cliente.',
  `nome` varchar(45) NOT NULL COMMENT 'Nome completo do cliente.',
  `telefone` bigint(14) NOT NULL COMMENT 'Numero telefonico do cliente para contato.',
  `cpf` bigint(11) DEFAULT NULL COMMENT 'CPF do cliente.',
  `rg` char(10) DEFAULT NULL COMMENT 'RG do cliente.',
  `email` varchar(100) DEFAULT NULL COMMENT 'email do cliente para contato.',
  `cidade` varchar(30) DEFAULT NULL COMMENT 'Cidade onde o cliente reside.',
  `bairro` varchar(20) DEFAULT NULL COMMENT 'Bairro onde o cliente reside.',
  `logradouro` varchar(45) DEFAULT NULL COMMENT 'Rua/Avenida onde o cliente reside.',
  `numero` int(5) DEFAULT NULL COMMENT 'Numero da residencia do cliente.',
  `complemento` varchar(40) DEFAULT NULL COMMENT 'Complemento da residencia do cliente.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela que armazena os clientes registrados do software.';

--
-- Fazendo dump de dados para tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `telefone`, `cpf`, `rg`, `email`, `cidade`, `bairro`, `logradouro`, `numero`, `complemento`) VALUES
(002, 'Marcos Aurélio', 231238971289, 12893892732, '8923812', 'marcosaurelio@gmail.com', 'Joinville', 'Costa e Silva', 'Avenida Jacinto', 921, 'Casa'),
(003, 'José Maria', 479487948748, 48974655466, '4895789', 'josemaria@gmail.com', 'Joinville', 'Iririu', 'Iririu', 167, 'Bloco C'),
(004, 'Roger Drogoberto', 47997897874, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(005, 'Roberval do Santos', 47998977894, 54597894985, '9498749', 'robertodoval@outlook.com', 'Joinville', 'Paraiso', ' Aquidaban', 16, 'Casa'),
(006, 'Eduardo Cunha', 219293128931, 29338941289, '2893834', 'swissprince@gmail.com', 'Joinville', 'Aventureiro', 'Avenida Albano Shmidt', 238, '238'),
(007, 'Luiz Inácio Lula da Silva', 321213131392, 23457546342, '1313131', 'triplex@gmail.com', 'Joinville', 'Iriríu', 'Rua Coronel Camacho', 142, 'Casa'),
(008, 'Craudiu Cracius', 666666666666, NULL, NULL, 'for_rome@legion.spqr', NULL, NULL, NULL, NULL, NULL),
(009, 'Ednaldo Pereira', 128213892138, 19283128937, '1923921', 'ednaldopereira@gmail.com', 'Joinville', 'Iriríu', 'Rua Xaxim', 150, '150'),
(010, 'Ronaldo Dibraldo', 974897489788, 84947894779, '7748974', 'ronaldodibraldinho@gmail.com', 'Joinville', 'Iririu', 'Rua Guaramirim', 10154, 'Casa'),
(011, 'Carlos Martel', 289371289371, 19731732731, '1973192', 'cruzades@gmail.com', 'Joinville', 'Iriríu', 'Rua Comandante Hassel', 142, 'Casa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do funcionário.',
  `usuarios_id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do usuário.',
  `nome` varchar(45) NOT NULL COMMENT 'Nome completo do funcionário.',
  `telefone` bigint(14) NOT NULL COMMENT 'Numero telefonico do funcionário.',
  `email` varchar(100) NOT NULL COMMENT 'Email do funcionário.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela que armazena os funcionários que são registrados no software.';

--
-- Fazendo dump de dados para tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `usuarios_id`, `nome`, `telefone`, `email`) VALUES
(02, 02, 'Administrador', 999999999999, 'adm@amd.com'),
(03, 03, 'Gustavo Habitzreiter', 666666666666, 'gugahabitz@gmail.com'),
(04, 04, 'Guilherme Foster', 666666666666, 'guilhermefoster50@gmail.com'),
(05, 05, 'Gustavo M de Camargo', 99962166025, 'guga.power@hotmail.com'),
(06, 06, 'Cradiu', 47997849784, 'cradiu@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `projetos`
--

CREATE TABLE `projetos` (
  `id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Codigo de identificação de projetos.',
  `funcionarios_id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do funcionário.',
  `clientes_id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do cliente.',
  `status` tinyint(1) NOT NULL COMMENT 'Status em que se encontra o projeto:\n1 - Aguardando recolhimento de informações\n2 - Desenvolvimento pré-molde\n3 - Em produção\n4 - Projeto finalizado\n5 - Projeto concluido\n6 - Projeto cancelado',
  `titulo` varchar(45) NOT NULL COMMENT 'Titulo do projeto.',
  `bairro` varchar(20) NOT NULL COMMENT 'Bairro onde o cliente reside.',
  `logradouro` varchar(45) NOT NULL COMMENT 'Rua/Avenida que o cliente reside.',
  `numero` int(5) NOT NULL COMMENT 'Numero da casa da residencia do cliente.',
  `complemento` varchar(40) NOT NULL COMMENT 'Complemento da residencia do cliente.',
  `cidade` varchar(30) DEFAULT NULL COMMENT 'Cidade que o cliente reside.',
  `descricao` text COMMENT 'Descrição do projeto, onde é registrado as informações/descrições que o cliente repassa para o funcionário.',
  `valor` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela que armazena os projetos registrados no software.';

--
-- Fazendo dump de dados para tabela `projetos`
--

INSERT INTO `projetos` (`id`, `funcionarios_id`, `clientes_id`, `status`, `titulo`, `bairro`, `logradouro`, `numero`, `complemento`, `cidade`, `descricao`, `valor`) VALUES
(0011, 03, 002, 3, 'Estante para sala de estar', 'Costa e Silva', 'Avenida Dona Francisca', 193, 'Casa', 'Joinville', 'Projeto para estante de sala de estar do cliente Marcos Aurélio', NULL),
(0012, 04, 008, 5, 'Cozinha Completa', 'Iririu', 'Rua Cegonha', 115, 'Bloco C ', 'Joinville', 'Cozinha preto e branco', '1500.00'),
(0013, 05, 008, 6, 'Cama do gladiador', 'Gloria', 'Rua Pavão Pacheco', 1410, 'Apartamento de numero 4', 'Joinville', 'Um Cama de Madeira podre e palha', '300.00'),
(0014, 03, 007, 3, 'Projeto para cozinha detalhada do Triplex', 'Iriríu', 'Rua Coronel Camacho', 228, 'Casa', 'Joinville', 'Projeto para o homem mais honesto do Brasil em sua humilde residência', NULL),
(0015, 04, 003, 5, 'Sala com detalhes musicais', 'Iririu', 'Rua Cegonha', 1199, 'Casa', 'Joinville', 'Sala com detalhes musicais ', '1999.00'),
(0016, 04, 004, 4, 'Quarto Rustico', 'Iririu', 'Guaratingueta', 999, 'Casa', 'Joinville', 'Quarto com estilo rustico', '1970.00'),
(0017, 06, 011, 1, 'tessste', 'teeeeeste', 'teeeeeeste', 3434, 'teste', 'teeeste', 'teste', '3434.00'),
(0018, 03, 009, 1, 'Ednaldo Pereira', 'Ednaldo Pereira', 'Ednaldo Pereira', 123, 'Ednaldo Pereira', 'Ednaldo Pereira', 'Ednaldo Pereira', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `projetos_tem_ambientes`
--

CREATE TABLE `projetos_tem_ambientes` (
  `ambientes_id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do ambiente.',
  `projetos_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do projeto.',
  `descricao` text COMMENT 'Descrição de como o ambiente será afetado, sendo nula já que é opcional. '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela armazena descrição e tambem os ids de projetos e ambientes.';

--
-- Fazendo dump de dados para tabela `projetos_tem_ambientes`
--

INSERT INTO `projetos_tem_ambientes` (`ambientes_id`, `projetos_id`, `descricao`) VALUES
(001, 0011, 'Estante com detalhes greco-romanos esculpida em madeira de oliva'),
(002, 0012, 'Cozinha com detalhes em marmore'),
(004, 0013, 'Cama no centro do quarto com detalhes muito bonitos'),
(002, 0014, 'Cozinha detalhada com detalhes em vermelho');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do usuário.',
  `usuario` varchar(20) NOT NULL COMMENT 'Usuário é usado para autenticar em conjunto com a senha.',
  `senha` char(32) NOT NULL COMMENT 'Senha é usado para autenticar em conjunto com o usuário e sera criptografada em MD5.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela que armazena os usuários que são registrados no software.';

--
-- Fazendo dump de dados para tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `senha`) VALUES
(02, 'adm', '9306168c9ad9919411f16d9c83f0598a'),
(03, 'gustavo_habitz', '83285e9ab4eb7ecf7b7bd78b94eb5b95'),
(04, 'Foster', '633e8989ab479790984e3575fadf3f08'),
(05, 'xxtituxx', '540d82b94efffecdd027f195e250d98e'),
(06, 'cradiu', '3acaf10ecc3ac5cd96f12c60487194d8');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_agendamentos_projetos1_idx` (`projetos_id`);

--
-- Índices de tabela `ambientes`
--
ALTER TABLE `ambientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_arquivos_projetos1_idx` (`projetos_id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_funcionarios_usuarios1_idx` (`usuarios_id`);

--
-- Índices de tabela `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_projetos_funcionarios1_idx` (`funcionarios_id`),
  ADD KEY `fk_projetos_clientes1_idx` (`clientes_id`);

--
-- Índices de tabela `projetos_tem_ambientes`
--
ALTER TABLE `projetos_tem_ambientes`
  ADD KEY `fk_projetos_ambientes_ambientes1_idx` (`ambientes_id`),
  ADD KEY `fk_projetos_ambientes_projetos1_idx` (`projetos_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código do agendamento', AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT de tabela `ambientes`
--
ALTER TABLE `ambientes`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código de identificação do ambiente.', AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de tabela `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código do arquivo', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código de identificação do cliente.', AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código de identificação do funcionário.', AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de tabela `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Codigo de identificação de projetos.', AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código de identificação do usuário.', AUTO_INCREMENT=7;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `fk_agendamentos_projetos1` FOREIGN KEY (`projetos_id`) REFERENCES `projetos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `fk_arquivos_projetos1` FOREIGN KEY (`projetos_id`) REFERENCES `projetos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `fk_funcionarios_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `projetos`
--
ALTER TABLE `projetos`
  ADD CONSTRAINT `fk_projetos_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projetos_funcionarios1` FOREIGN KEY (`funcionarios_id`) REFERENCES `funcionarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para tabelas `projetos_tem_ambientes`
--
ALTER TABLE `projetos_tem_ambientes`
  ADD CONSTRAINT `fk_projetos_ambientes_ambientes1` FOREIGN KEY (`ambientes_id`) REFERENCES `ambientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projetos_ambientes_projetos1` FOREIGN KEY (`projetos_id`) REFERENCES `projetos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
