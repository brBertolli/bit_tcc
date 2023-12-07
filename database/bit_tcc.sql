-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/12/2023 às 11:22
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
-- Banco de dados: `bit_tcc`
--
CREATE DATABASE IF NOT EXISTS `bit_tcc` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bit_tcc`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `rg` varchar(12) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `cidade` varchar(30) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `rua` varchar(50) NOT NULL,
  `numero` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `data_nascimento`, `rg`, `cpf`, `celular`, `cep`, `estado`, `cidade`, `bairro`, `rua`, `numero`) VALUES
(1, 'ADMINISTRADOR', '2000-01-01', '00.000.000-0', '000.000.000-00', '(00) 00000-0000', '00000-00', 'PR', 'Cidade', 'Centro', 'Av. Tecnologias', '000000'),
(3, 'Maria Souza ', '1991-02-02', 'SP-20.234.56', '000.000.002-72', '(11) 90000-0002', '01000-00', 'SP', 'São Paulo', 'Brás', 'Rua São Caetano', '200'),
(4, 'Pedro Santos de Souza', '1992-03-03', 'RJ-30.345.67', '000.000.003-53', '(21) 90000-0003', '22000-00', '', 'Rio de Janeiro', 'Copacabana', 'Avenida Atlântica', '300'),
(5, 'Ana Costa', '1993-04-04', 'RS-40.456.78', '000.000.004-34', '(51) 90000-0004', '90000-00', 'RS', 'Porto Alegre', 'Centro', 'Rua dos Andradas', '400'),
(6, 'Lucas Martins', '1994-05-05', 'PR-50.567.89', '000.000.005-15', '(41) 90000-0005', '80000-00', 'PR', 'Curitiba', 'Batel', 'Avenida Sete de Setembro', '500'),
(10, 'Carlos Rodrigues', '1998-09-09', 'CE-90.901.23', '000.000.009-39', '(85) 90000-0009', '60000-00', 'CE', 'Fortaleza', 'Meireles', 'Avenida Beira Mar', '900');

-- --------------------------------------------------------

--
-- Estrutura para tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cargo` varchar(40) DEFAULT 'Funcionario',
  `usuario` varchar(20) NOT NULL,
  `senha` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(15) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `data_upload` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `funcionario`
--

INSERT INTO `funcionario` (`id`, `nome`, `cargo`, `usuario`, `senha`, `email`, `celular`, `path`, `data_upload`) VALUES
(1, 'Administrador', 'Administrador', 'Admin', '123abC', 'comercialexemplo@bit.com', '(00) 00000-0000', NULL, '2023-11-17');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordem_de_servico`
--

CREATE TABLE `ordem_de_servico` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `equipamento` varchar(255) NOT NULL,
  `problema_relatado` text DEFAULT NULL,
  `problema_constatado` text DEFAULT NULL,
  `servico_executado` text DEFAULT NULL,
  `servicos` varchar(255) DEFAULT NULL,
  `valor_servico` double(10,2) DEFAULT NULL,
  `valor_total` double(10,2) DEFAULT NULL,
  `valor_pago` double(10,2) NOT NULL DEFAULT 0.00,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'Ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ordem_de_servico`
--

INSERT INTO `ordem_de_servico` (`id`, `cliente_id`, `equipamento`, `problema_relatado`, `problema_constatado`, `servico_executado`, `servicos`, `valor_servico`, `valor_total`, `valor_pago`, `data_criacao`, `status`) VALUES
(16, 5, 'NOTEBOOK', 'SAS', 'SAS', 'SAS', '', 0.00, 100.00, 0.00, '2023-12-01 11:53:39', 'Finalizado'),
(21, 6, '', '', NULL, NULL, NULL, 1.00, 1.00, 0.00, '2023-12-05 14:09:38', 'Pendente'),
(24, 4, 'Computador', 'Está lento', 'O HD está danificado', 'Troca do HD por um SSD', '', 0.00, 100.25, 0.00, '2023-12-05 18:17:04', 'Ativo'),
(26, 10, 'Notebook Asus', 'Trocar tela', 'Touchscreen não funciona', 'Trocar a tela', 'Formatação, Troca de Peças', 100.00, 200.00, 0.00, '2023-12-06 12:46:39', 'Ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `ordem_de_servico_peca`
--

CREATE TABLE `ordem_de_servico_peca` (
  `ordem_de_servico_id` int(11) NOT NULL,
  `peca_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ordem_de_servico_peca`
--

INSERT INTO `ordem_de_servico_peca` (`ordem_de_servico_id`, `peca_id`, `quantidade`) VALUES
(16, 3, 1),
(24, 1, 1),
(24, 1, 6),
(24, 1, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `peca`
--

CREATE TABLE `peca` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(250) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `estoque_minimo` int(11) NOT NULL,
  `estoque_atual` int(11) NOT NULL,
  `valor_custo` double(10,2) NOT NULL,
  `valor_venda` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `peca`
--

INSERT INTO `peca` (`id`, `nome`, `descricao`, `marca`, `categoria`, `estoque_minimo`, `estoque_atual`, `valor_custo`, `valor_venda`) VALUES
(1, 'SSD 120 Gb Gigabyte', '', 'Kingston', 'Armazenamento', 1, 12, 200.00, 500.00),
(2, 'SSD 240Gb', 'State Solid Disk 240 Gigabytes Kingston', 'Kingston', 'Armazenamento', 5, 7, 6625.00, 15000.00),
(3, 'SSD 240Gb', 'State Solid Disk 240 Gigabytes Kingston', 'Kingston', 'Armazenamento', 5, 9, 90.00, 150.00),
(8, 'Teclado ASUS', 'Teclado para notebook', 'Logitech', 'Perifericos', 1, 1, 1.00, 2.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `recebimento`
--

CREATE TABLE `recebimento` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `ordem_servico_id` int(11) NOT NULL,
  `data_recebimento` datetime NOT NULL DEFAULT current_timestamp(),
  `valor_recebimento` double(10,2) NOT NULL DEFAULT 0.00,
  `forma_pagamento` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `recebimento`
--

INSERT INTO `recebimento` (`id`, `cliente_id`, `ordem_servico_id`, `data_recebimento`, `valor_recebimento`, `forma_pagamento`) VALUES
(2, 5, 16, '2023-11-15 19:09:01', 0.00, 'cartao_credito'),
(8, 6, 21, '2023-11-15 19:09:01', 0.00, 'cartao_credito');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Índices de tabela `ordem_de_servico_peca`
--
ALTER TABLE `ordem_de_servico_peca`
  ADD KEY `ordem_de_servico_id` (`ordem_de_servico_id`),
  ADD KEY `peca_id` (`peca_id`);

--
-- Índices de tabela `peca`
--
ALTER TABLE `peca`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `recebimento`
--
ALTER TABLE `recebimento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `os_idpk` (`ordem_servico_id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `peca`
--
ALTER TABLE `peca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `recebimento`
--
ALTER TABLE `recebimento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `ordem_de_servico`
--
ALTER TABLE `ordem_de_servico`
  ADD CONSTRAINT `ordem_de_servico_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `ordem_de_servico_peca`
--
ALTER TABLE `ordem_de_servico_peca`
  ADD CONSTRAINT `ordem_de_servico_peca_ibfk_1` FOREIGN KEY (`ordem_de_servico_id`) REFERENCES `ordem_de_servico` (`id`),
  ADD CONSTRAINT `ordem_de_servico_peca_ibfk_2` FOREIGN KEY (`peca_id`) REFERENCES `peca` (`id`);

--
-- Restrições para tabelas `recebimento`
--
ALTER TABLE `recebimento`
  ADD CONSTRAINT `os_idpk` FOREIGN KEY (`ordem_servico_id`) REFERENCES `ordem_de_servico` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
