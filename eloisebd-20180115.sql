CREATE DATABASE  IF NOT EXISTS `eloisebd` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `eloisebd`;
-- MySQL dump 10.13  Distrib 5.5.55, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: eloisebd
-- ------------------------------------------------------
-- Server version	5.5.55-0+deb8u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `agente`
--

DROP TABLE IF EXISTS `agente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `sigla` varchar(25) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agente`
--


--
-- Table structure for table `aproveitamento`
--

DROP TABLE IF EXISTS `aproveitamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aproveitamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estagio_id` int(11) DEFAULT NULL,
  `tipo_aproveitamento` int(11) DEFAULT NULL,
  `horas_aproveitadas` int(11) DEFAULT NULL,
  `observacao` text,
  PRIMARY KEY (`id`),
  KEY `fk_apr_egio` (`estagio_id`),
  CONSTRAINT `fk_apr_egio` FOREIGN KEY (`estagio_id`) REFERENCES `estagio` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aproveitamento`
--

LOCK TABLES `aproveitamento` WRITE;
/*!40000 ALTER TABLE `aproveitamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `aproveitamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setor_id` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `tipo_turno` int(11) DEFAULT NULL,
  `situacao_turno` int(11) DEFAULT NULL,
  `tipo_modalidade` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cur_set` (`setor_id`),
  CONSTRAINT `fk_cur_set` FOREIGN KEY (`setor_id`) REFERENCES `setor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--



--
-- Table structure for table `demanda_empresa`
--

DROP TABLE IF EXISTS `demanda_empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `demanda_empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) DEFAULT NULL,
  `servidor_id` int(11) DEFAULT NULL,
  `data_demanda` date DEFAULT '0000-00-00',
  `data_atendido` date DEFAULT '0000-00-00',
  `servidor_recebedor` int(11) DEFAULT NULL,
  `servidor_resolvedor` int(11) DEFAULT NULL,
  `descricao` text,
  `tipo_demanda` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_dem_emp` (`empresa_id`),
  KEY `fk_dem_ser` (`servidor_id`),
  CONSTRAINT `fk_dem_emp` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`),
  CONSTRAINT `fk_dem_ser` FOREIGN KEY (`servidor_id`) REFERENCES `servidor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `demanda_empresa`
--


--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `pessoa_id` int(11) DEFAULT NULL,
  `setor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pes_emp` (`pessoa_id`),
  KEY `fk_pes_set` (`setor_id`),
  CONSTRAINT `fk_pes_emp` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`),
  CONSTRAINT `fk_pes_set` FOREIGN KEY (`setor_id`) REFERENCES `setor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

--
-- Table structure for table `encaminhamento`
--

DROP TABLE IF EXISTS `encaminhamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encaminhamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) DEFAULT NULL,
  `servidor_id` int(11) DEFAULT NULL,
  `data_encaminhamento` date DEFAULT '0000-00-00',
  `observacao` text,
  PRIMARY KEY (`id`),
  KEY `fk_enc_emp` (`empresa_id`),
  KEY `fk_enc_ser` (`servidor_id`),
  CONSTRAINT `fk_enc_emp` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`),
  CONSTRAINT `fk_enc_ser` FOREIGN KEY (`servidor_id`) REFERENCES `servidor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encaminhamento`
--

LOCK TABLES `encaminhamento` WRITE;
/*!40000 ALTER TABLE `encaminhamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `encaminhamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estagiario`
--

DROP TABLE IF EXISTS `estagiario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estagiario` (
  `id` int(11) NOT NULL,
  `pessoa_id` int(11) DEFAULT NULL,
  `coeficiente` int(11) DEFAULT NULL,
  `matricula` varchar(255) DEFAULT NULL,
  `tipo_pne` int(11) DEFAULT NULL,
  `ano_diploma` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_erio_pes` (`pessoa_id`),
  CONSTRAINT `fk_erio_pes` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estagiario`
--

--
-- Table structure for table `estagio`
--

DROP TABLE IF EXISTS `estagio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estagio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa_id` int(11) DEFAULT NULL,
  `estagiario_id` int(11) DEFAULT NULL,
  `servidor_id` int(11) DEFAULT NULL,
  `agente_id` int(11) DEFAULT NULL,
  `coeficiente` int(11) DEFAULT NULL,
  `situacao_estagio` int(11) DEFAULT NULL,
  `matricula` varchar(255) DEFAULT NULL,
  `tipo_pne` int(11) DEFAULT NULL,
  `ano_diploma` int(11) DEFAULT NULL,
  `data_inicio` date DEFAULT '0000-00-00',
  `data_termino` date DEFAULT '0000-00-00',
  `data_distrato` date DEFAULT '0000-00-00',
  `data_prorrogado` date DEFAULT '0000-00-00',
  `data_estagioavaliado` date DEFAULT '0000-00-00',
  `numero_termo` int(11) DEFAULT NULL,
  `carga_horario` int(11) DEFAULT NULL,
  `lista_telefones` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_egio_emp` (`empresa_id`),
  KEY `fk_egio_erio` (`estagiario_id`),
  KEY `fk_egio_ser` (`servidor_id`),
  KEY `fk_egio_age` (`agente_id`),
  CONSTRAINT `fk_egio_age` FOREIGN KEY (`agente_id`) REFERENCES `agente` (`id`),
  CONSTRAINT `fk_egio_emp` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`),
  CONSTRAINT `fk_egio_erio` FOREIGN KEY (`estagiario_id`) REFERENCES `estagiario` (`id`),
  CONSTRAINT `fk_egio_ser` FOREIGN KEY (`servidor_id`) REFERENCES `servidor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estagio`
--

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date DEFAULT '0000-00-00',
  `hora` time DEFAULT '00:00:00',
  `operacao` text,
  `tipo_usuario` int(11) DEFAULT '-1',
  `tipo_operacao` int(11) DEFAULT '-1',
  `login` varchar(255) DEFAULT '-1',
  `ip` varchar(255) DEFAULT '-1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--


--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `nivel` varchar(25) DEFAULT NULL,
  `pessoa_id` int(11) NOT NULL,
  `ativo` int(11) DEFAULT NULL,
  `autenticador` bigint(15) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lgn_pes` (`pessoa_id`),
  CONSTRAINT `fk_lgn_pes` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--


--
-- Table structure for table `ocorrencia`
--

DROP TABLE IF EXISTS `ocorrencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ocorrencia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `estagiario_id` int(11) DEFAULT NULL,
  `servidor_id` int(11) DEFAULT NULL,
  `descricao` text,
  `data_ocorrecia` date DEFAULT '0000-00-00',
  `tipo_ocorrencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_oco_ser` (`servidor_id`),
  KEY `fk_oco_erio` (`estagiario_id`),
  CONSTRAINT `fk_oco_erio` FOREIGN KEY (`estagiario_id`) REFERENCES `estagiario` (`id`),
  CONSTRAINT `fk_oco_ser` FOREIGN KEY (`servidor_id`) REFERENCES `servidor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ocorrencia`
--

LOCK TABLES `ocorrencia` WRITE;
/*!40000 ALTER TABLE `ocorrencia` DISABLE KEYS */;
/*!40000 ALTER TABLE `ocorrencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoa`
--

DROP TABLE IF EXISTS `pessoa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pessoa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `cadastro` varchar(255) DEFAULT NULL,
  `sexo` char(1) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT '-1',
  `data_nascimento` date DEFAULT '0000-00-00',
  `cep` varchar(255) DEFAULT NULL,
  `bairro` varchar(255) DEFAULT NULL,
  `telefones` varchar(255) DEFAULT NULL,
  `tipo_cadastro` int(11) DEFAULT '-1',
  `site` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tipo_contato` int(11) DEFAULT '-1',
  `id_bdanterior` int(11) DEFAULT '-1',
  `pessoa_id` int(11) DEFAULT '-1',
  `tipo_papel` int(11) DEFAULT '3',
  `hash` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoa`
--



--
-- Table structure for table `servidor`
--

DROP TABLE IF EXISTS `servidor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `servidor` (
  `id` int(11) NOT NULL,
  `pessoa_id` int(11) DEFAULT NULL,
  `matricula` varchar(255) DEFAULT NULL,
  `tipo_servidor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pes_ser` (`pessoa_id`),
  CONSTRAINT `fk_pes_ser` FOREIGN KEY (`pessoa_id`) REFERENCES `pessoa` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `servidor`
--

--
-- Table structure for table `setor`
--

DROP TABLE IF EXISTS `setor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `sigla` varchar(25) DEFAULT NULL,
  `tipo_setor` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setor`
--

--
-- Table structure for table `telefone`
--

DROP TABLE IF EXISTS `telefone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `telefone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `telefone` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `telefone`
--

--
-- Table structure for table `tipo_situacao`
--

DROP TABLE IF EXISTS `tipo_situacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_situacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) DEFAULT NULL,
  `nome_tabela` varchar(255) DEFAULT NULL,
  `nome_coluna` varchar(255) DEFAULT NULL,
  `valor_char` varchar(255) DEFAULT NULL,
  `valor_int` int(11) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_situacao`
--

--
-- Table structure for table `turma_curso`
--

DROP TABLE IF EXISTS `turma_curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `turma_curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curso_id` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `ano_conclusao` int(11) DEFAULT NULL,
  `sequencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tcu_cur` (`curso_id`),
  CONSTRAINT `fk_tcu_cur` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `turma_curso`
--

LOCK TABLES `turma_curso` WRITE;
/*!40000 ALTER TABLE `turma_curso` DISABLE KEYS */;
/*!40000 ALTER TABLE `turma_curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `vw_pessoa`
--

DROP TABLE IF EXISTS `vw_pessoa`;
/*!50001 DROP VIEW IF EXISTS `vw_pessoa`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `vw_pessoa` (
  `id` tinyint NOT NULL,
  `nome` tinyint NOT NULL,
  `cadastro` tinyint NOT NULL,
  `tipo_papel` tinyint NOT NULL,
  `tipo_cadastro` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `vw_pessoa`
--

/*!50001 DROP TABLE IF EXISTS `vw_pessoa`*/;
/*!50001 DROP VIEW IF EXISTS `vw_pessoa`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vw_pessoa` AS select `pessoa`.`id` AS `id`,`pessoa`.`nome` AS `nome`,`pessoa`.`cadastro` AS `cadastro`,`pessoa`.`tipo_papel` AS `tipo_papel`,`pessoa`.`tipo_cadastro` AS `tipo_cadastro` from `pessoa` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-15 15:12:32
