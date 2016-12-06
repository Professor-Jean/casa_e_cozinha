-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30-Nov-2016 às 19:13
-- Versão do servidor: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccabd`
--
CREATE DATABASE IF NOT EXISTS `ccabd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ccabd`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamentos`
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `ambientes`
--

CREATE TABLE `ambientes` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do ambiente.',
  `nome` varchar(20) NOT NULL COMMENT 'Nome do ambiente que o funcionário registrou.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela armazena os ambientes que são afetados pelo projetos.';

-- --------------------------------------------------------

--
-- Estrutura da tabela `arquivos`
--

CREATE TABLE `arquivos` (
  `id` int(6) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código do arquivo',
  `projetos_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do projeto associado.',
  `nome` varchar(45) NOT NULL COMMENT 'Nome descritivo do arquivo, usado para saber qual arquivo o funcionário escolhera.',
  `caminho` char(39) NOT NULL COMMENT 'Caminho do arquivo, usado para saber onde o arquivo se encontra no servidor.\nEntensão: ".promob"',
  `data` date NOT NULL COMMENT 'Data em que foi realizado o upload do arquivo.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela que armazena o nome e caminho do arquivos do projeto, que forem feitos upload.';

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionarios`
--

CREATE TABLE `funcionarios` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do funcionário.',
  `usuarios_id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do usuário.',
  `nome` varchar(45) NOT NULL COMMENT 'Nome completo do funcionário.',
  `telefone` bigint(14) NOT NULL COMMENT 'Numero telefonico do funcionário.',
  `email` varchar(100) NOT NULL COMMENT 'Email do funcionário.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela que armazena os funcionários que são registrados no software.';

--
-- Extraindo dados da tabela `funcionarios`
--

INSERT INTO `funcionarios` (`id`, `usuarios_id`, `nome`, `telefone`, `email`) VALUES
(02, 02, 'Administrador', 999999999999, 'adm@amd.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos`
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `projetos_tem_ambientes`
--

CREATE TABLE `projetos_tem_ambientes` (
  `ambientes_id` tinyint(3) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do ambiente.',
  `projetos_id` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do projeto.',
  `descricao` text COMMENT 'Descrição de como o ambiente será afetado, sendo nula já que é opcional. '
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela armazena descrição e tambem os ids de projetos e ambientes.';

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL COMMENT 'Código de identificação do usuário.',
  `usuario` varchar(20) NOT NULL COMMENT 'Usuário é usado para autenticar em conjunto com a senha.',
  `senha` char(32) NOT NULL COMMENT 'Senha é usado para autenticar em conjunto com o usuário e sera criptografada em MD5.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabela que armazena os usuários que são registrados no software.';

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `senha`) VALUES
(02, 'adm', '9306168c9ad9919411f16d9c83f0598a');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_agendamentos_projetos1_idx` (`projetos_id`);

--
-- Indexes for table `ambientes`
--
ALTER TABLE `ambientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_arquivos_projetos1_idx` (`projetos_id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_funcionarios_usuarios1_idx` (`usuarios_id`);

--
-- Indexes for table `projetos`
--
ALTER TABLE `projetos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_projetos_funcionarios1_idx` (`funcionarios_id`),
  ADD KEY `fk_projetos_clientes1_idx` (`clientes_id`);

--
-- Indexes for table `projetos_tem_ambientes`
--
ALTER TABLE `projetos_tem_ambientes`
  ADD KEY `fk_projetos_ambientes_ambientes1_idx` (`ambientes_id`),
  ADD KEY `fk_projetos_ambientes_projetos1_idx` (`projetos_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código do agendamento';
--
-- AUTO_INCREMENT for table `ambientes`
--
ALTER TABLE `ambientes`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código de identificação do ambiente.';
--
-- AUTO_INCREMENT for table `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id` int(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código do arquivo';
--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código de identificação do cliente.', AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `funcionarios`
--
ALTER TABLE `funcionarios`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código de identificação do funcionário.', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `projetos`
--
ALTER TABLE `projetos`
  MODIFY `id` int(4) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Codigo de identificação de projetos.', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` tinyint(2) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT COMMENT 'Código de identificação do usuário.', AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `fk_agendamentos_projetos1` FOREIGN KEY (`projetos_id`) REFERENCES `projetos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD CONSTRAINT `fk_arquivos_projetos1` FOREIGN KEY (`projetos_id`) REFERENCES `projetos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `funcionarios`
--
ALTER TABLE `funcionarios`
  ADD CONSTRAINT `fk_funcionarios_usuarios1` FOREIGN KEY (`usuarios_id`) REFERENCES `usuarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `projetos`
--
ALTER TABLE `projetos`
  ADD CONSTRAINT `fk_projetos_clientes1` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projetos_funcionarios1` FOREIGN KEY (`funcionarios_id`) REFERENCES `funcionarios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `projetos_tem_ambientes`
--
ALTER TABLE `projetos_tem_ambientes`
  ADD CONSTRAINT `fk_projetos_ambientes_ambientes1` FOREIGN KEY (`ambientes_id`) REFERENCES `ambientes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_projetos_ambientes_projetos1` FOREIGN KEY (`projetos_id`) REFERENCES `projetos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
