-- MySQL dump 10.13  Distrib 5.6.39, for Linux (x86_64)
--
-- Host: localhost    Database: marbotediciones_kms
-- ------------------------------------------------------
-- Server version	5.6.39

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
-- Table structure for table `kms_cat_autors`
--

DROP TABLE IF EXISTS `kms_cat_autors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_cat_autors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `bio` text,
  `picture` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_cat_autors`
--

LOCK TABLES `kms_cat_autors` WRITE;
/*!40000 ALTER TABLE `kms_cat_autors` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_cat_autors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_cat_clients`
--

DROP TABLE IF EXISTS `kms_cat_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_cat_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `postalcode` varchar(150) DEFAULT NULL,
  `country` varchar(150) DEFAULT NULL,
  `phone` varchar(150) DEFAULT NULL,
  `comments` text,
  `address` varchar(150) DEFAULT NULL,
  `idioma` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_cat_clients`
--

LOCK TABLES `kms_cat_clients` WRITE;
/*!40000 ALTER TABLE `kms_cat_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_cat_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_cat_comandes`
--

DROP TABLE IF EXISTS `kms_cat_comandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_cat_comandes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `ipaddress` varchar(150) DEFAULT NULL,
  `base` varchar(150) DEFAULT NULL,
  `iva` varchar(150) DEFAULT NULL,
  `shipping` varchar(150) DEFAULT NULL,
  `total` varchar(150) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_method` varchar(150) DEFAULT NULL,
  `payment_id` varchar(150) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `card_country` varchar(150) DEFAULT NULL,
  `currency` varchar(150) DEFAULT NULL,
  `amount_paid` varchar(150) DEFAULT NULL,
  `payment_intent` varchar(150) DEFAULT NULL,
  `full_response` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_cat_comandes`
--

LOCK TABLES `kms_cat_comandes` WRITE;
/*!40000 ALTER TABLE `kms_cat_comandes` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_cat_comandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_cat_productes`
--

DROP TABLE IF EXISTS `kms_cat_productes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_cat_productes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(30) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `picture` varchar(150) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `idioma` varchar(255) DEFAULT NULL,
  `autor_id` int(11) DEFAULT NULL,
  `autor2_id` int(11) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `subtitle` varchar(150) DEFAULT NULL,
  `description` text,
  `isbn` varchar(150) DEFAULT NULL,
  `pages` varchar(150) DEFAULT NULL,
  `preu` varchar(150) DEFAULT NULL,
  `format` varchar(150) DEFAULT NULL,
  `disseny` varchar(150) DEFAULT NULL,
  `translation` varchar(150) DEFAULT NULL,
  `original_title` varchar(150) DEFAULT NULL,
  `illustracio` varchar(150) DEFAULT NULL,
  `coberta` varchar(150) DEFAULT NULL,
  `link` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_cat_productes`
--

LOCK TABLES `kms_cat_productes` WRITE;
/*!40000 ALTER TABLE `kms_cat_productes` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_cat_productes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_cat_sales`
--

DROP TABLE IF EXISTS `kms_cat_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_cat_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `customer` int(11) DEFAULT NULL,
  `item` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` varchar(150) DEFAULT NULL,
  `ipaddress` varchar(150) DEFAULT NULL,
  `operation` int(11) DEFAULT NULL,
  `subtotal` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_cat_sales`
--

LOCK TABLES `kms_cat_sales` WRITE;
/*!40000 ALTER TABLE `kms_cat_sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_cat_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_docs_articles`
--

DROP TABLE IF EXISTS `kms_docs_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_docs_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL DEFAULT '',
  `creation_date` datetime NOT NULL DEFAULT '2019-07-10 00:00:00',
  `userid` varchar(50) NOT NULL,
  `blogid` int(11) NOT NULL DEFAULT '1',
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(555) NOT NULL,
  `category` varchar(100) NOT NULL,
  `picture` varchar(100) NOT NULL,
  `short_body` text NOT NULL,
  `body` text NOT NULL,
  `tags` text NOT NULL,
  `readmore_url` varchar(150) NOT NULL DEFAULT '',
  `lectures` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_docs_articles`
--

LOCK TABLES `kms_docs_articles` WRITE;
/*!40000 ALTER TABLE `kms_docs_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_docs_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom`
--

DROP TABLE IF EXISTS `kms_ecom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `status` varchar(10) NOT NULL,
  `catalog_id` int(11) DEFAULT NULL,
  `currency` varchar(5) NOT NULL DEFAULT '',
  `shippment` varchar(45) DEFAULT NULL,
  `download` int(11) DEFAULT NULL,
  `admin_email` varchar(100) DEFAULT '',
  `enable_paypal` int(11) DEFAULT NULL,
  `tpv_id` varchar(100) NOT NULL DEFAULT '',
  `enable_cod` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom`
--

LOCK TABLES `kms_ecom` WRITE;
/*!40000 ALTER TABLE `kms_ecom` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_budgets`
--

DROP TABLE IF EXISTS `kms_ecom_budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL DEFAULT '',
  `sr_client` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `import` varchar(100) NOT NULL DEFAULT '',
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `attachment` varchar(100) NOT NULL DEFAULT '',
  `end_date` varchar(100) NOT NULL,
  `number` varchar(100) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_budgets`
--

LOCK TABLES `kms_ecom_budgets` WRITE;
/*!40000 ALTER TABLE `kms_ecom_budgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_budgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_catalogs`
--

DROP TABLE IF EXISTS `kms_ecom_catalogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_catalogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_folder` varchar(100) NOT NULL DEFAULT '',
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `status` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `product_id` int(10) NOT NULL,
  `family_id` int(10) NOT NULL,
  `subfamily_id` int(10) NOT NULL,
  `type` varchar(100) NOT NULL DEFAULT '',
  `content_type` varchar(100) NOT NULL DEFAULT '',
  `view_mode` varchar(100) NOT NULL DEFAULT '',
  `items_per_page` int(11) NOT NULL,
  `max_pages` int(11) NOT NULL,
  `enable_request_form` int(1) NOT NULL,
  `enable_shopping_cart` int(1) NOT NULL,
  `enable_tpv` int(1) NOT NULL,
  `enable_facebook_ilikeit` int(1) NOT NULL,
  `enable_facebook` int(1) NOT NULL,
  `enable_twitter` int(1) NOT NULL,
  `show_menu_families` int(1) NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `default_page_catalog` varchar(30) NOT NULL,
  `default_page_family` varchar(30) NOT NULL,
  `default_page_subfamily` varchar(30) NOT NULL,
  `search_fields` varchar(100) NOT NULL,
  `orderby` varchar(45) DEFAULT NULL,
  `sortdir` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_catalogs`
--

LOCK TABLES `kms_ecom_catalogs` WRITE;
/*!40000 ALTER TABLE `kms_ecom_catalogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_catalogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_delivery_costs`
--

DROP TABLE IF EXISTS `kms_ecom_delivery_costs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_delivery_costs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_folder` varchar(100) NOT NULL DEFAULT '',
  `zone` varchar(100) NOT NULL DEFAULT '',
  `min_weight` varchar(100) NOT NULL DEFAULT '',
  `max_weight` varchar(10) NOT NULL,
  `pvp` varchar(6) NOT NULL,
  `pvd` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_delivery_costs`
--

LOCK TABLES `kms_ecom_delivery_costs` WRITE;
/*!40000 ALTER TABLE `kms_ecom_delivery_costs` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_delivery_costs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_invoices`
--

DROP TABLE IF EXISTS `kms_ecom_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ordernum` varchar(20) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT '2019-07-10 00:00:00',
  `payment_date` date NOT NULL DEFAULT '2019-07-10',
  `serie` varchar(2) NOT NULL DEFAULT 'A',
  `client_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `number` varchar(100) NOT NULL DEFAULT '',
  `client_data` text,
  `concept` text NOT NULL,
  `price_values` text NOT NULL,
  `units_values` text,
  `base` double NOT NULL,
  `tax_percent` int(2) NOT NULL,
  `tax_values` text NOT NULL,
  `total_tax` double NOT NULL,
  `discount` varchar(100) NOT NULL DEFAULT '',
  `total` double NOT NULL,
  `payment_method` varchar(100) NOT NULL DEFAULT '',
  `bank` varchar(20) NOT NULL,
  `bank_account_number` varchar(20) NOT NULL,
  `bank_charges` varchar(255) NOT NULL,
  `remittance_id` int(5) NOT NULL,
  `sent_email` varchar(50) NOT NULL,
  `sent_date` datetime NOT NULL,
  `check_sent` tinyint(1) NOT NULL,
  `notes` text NOT NULL,
  `internal_notes` text NOT NULL,
  `status_terminator` int(1) DEFAULT NULL,
  `delivery_fee` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=100 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_invoices`
--

LOCK TABLES `kms_ecom_invoices` WRITE;
/*!40000 ALTER TABLE `kms_ecom_invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_payment_methods`
--

DROP TABLE IF EXISTS `kms_ecom_payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_payment_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `payment_name` varchar(60) NOT NULL,
  `payment_type` varchar(1) NOT NULL,
  `payment_quota` int(2) NOT NULL,
  `payment_days` varchar(30) NOT NULL,
  `bank_charges` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_payment_methods`
--

LOCK TABLES `kms_ecom_payment_methods` WRITE;
/*!40000 ALTER TABLE `kms_ecom_payment_methods` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_products`
--

DROP TABLE IF EXISTS `kms_ecom_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sortorder` int(11) NOT NULL,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `status` varchar(100) NOT NULL DEFAULT '',
  `show_in_shop` tinyint(1) NOT NULL,
  `highlight` tinyint(1) NOT NULL,
  `ref` varchar(20) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `family` varchar(100) NOT NULL,
  `subfamily` varchar(100) NOT NULL,
  `picture` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_products`
--

LOCK TABLES `kms_ecom_products` WRITE;
/*!40000 ALTER TABLE `kms_ecom_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_sales`
--

DROP TABLE IF EXISTS `kms_ecom_sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL DEFAULT '',
  `id_user` varchar(100) NOT NULL DEFAULT '',
  `ref` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL DEFAULT '',
  `creation_date` datetime NOT NULL DEFAULT '2019-07-10 00:00:00',
  `priceunit` varchar(10) DEFAULT NULL,
  `totalimport` varchar(10) DEFAULT NULL,
  `ordernum` varchar(20) NOT NULL,
  `deliverycosts` varchar(10) NOT NULL,
  `usertype` varchar(10) NOT NULL,
  `options` varchar(100) NOT NULL,
  `country` varchar(2) NOT NULL,
  `zone` varchar(100) NOT NULL,
  `labels` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_sales`
--

LOCK TABLES `kms_ecom_sales` WRITE;
/*!40000 ALTER TABLE `kms_ecom_sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_services`
--

DROP TABLE IF EXISTS `kms_ecom_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL DEFAULT '',
  `dr_folder` varchar(100) NOT NULL DEFAULT '',
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `family` varchar(100) NOT NULL DEFAULT '',
  `subfamily` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(100) NOT NULL,
  `price` varchar(200) NOT NULL,
  `ref` varchar(20) NOT NULL,
  `highlight` int(11) NOT NULL,
  `sortorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_services`
--

LOCK TABLES `kms_ecom_services` WRITE;
/*!40000 ALTER TABLE `kms_ecom_services` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_services_limits`
--

DROP TABLE IF EXISTS `kms_ecom_services_limits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_services_limits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service` varchar(100) NOT NULL,
  `from_value` varchar(50) NOT NULL,
  `to_value` varchar(50) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `price` varchar(100) NOT NULL DEFAULT '',
  `category` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_services_limits`
--

LOCK TABLES `kms_ecom_services_limits` WRITE;
/*!40000 ALTER TABLE `kms_ecom_services_limits` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_services_limits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_shoppingcart`
--

DROP TABLE IF EXISTS `kms_ecom_shoppingcart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_shoppingcart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_folder` varchar(100) NOT NULL DEFAULT '',
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `status` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `tpv_id` varchar(100) NOT NULL DEFAULT '',
  `currency` varchar(5) NOT NULL DEFAULT '',
  `items_per_page` int(11) NOT NULL,
  `max_pages` int(11) NOT NULL,
  `payment_methods` varchar(100) DEFAULT '',
  `admin_email` varchar(100) DEFAULT '',
  `sales_folder` int(11) NOT NULL,
  `enable_sharethis` int(11) NOT NULL,
  `enable_facebook` int(11) NOT NULL,
  `enable_twitter` int(11) NOT NULL,
  `show_menu_families` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_shoppingcart`
--

LOCK TABLES `kms_ecom_shoppingcart` WRITE;
/*!40000 ALTER TABLE `kms_ecom_shoppingcart` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_shoppingcart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_tpv`
--

DROP TABLE IF EXISTS `kms_ecom_tpv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_tpv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_folder` varchar(100) NOT NULL DEFAULT '',
  `tpv_url` varchar(100) NOT NULL DEFAULT '',
  `tpv_key` varchar(100) NOT NULL DEFAULT '',
  `tpv_merchantname` varchar(100) NOT NULL,
  `tpv_code` varchar(10) NOT NULL,
  `tpv_terminal` int(11) NOT NULL,
  `tpv_currency` int(11) NOT NULL,
  `tpv_transactiontype` int(11) NOT NULL,
  `tpv_urlMerchant` varchar(100) NOT NULL DEFAULT '',
  `tpv_description` varchar(100) NOT NULL,
  `tpv_merchant_UrlOK` varchar(100) NOT NULL,
  `tpv_merchant_UrlKO` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_tpv`
--

LOCK TABLES `kms_ecom_tpv` WRITE;
/*!40000 ALTER TABLE `kms_ecom_tpv` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_tpv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_tpv_transactions`
--

DROP TABLE IF EXISTS `kms_ecom_tpv_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_tpv_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `order` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(10) DEFAULT NULL,
  `tpv_response` varchar(10) DEFAULT NULL,
  `amount` varchar(45) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `card_country` int(5) DEFAULT NULL,
  `merchant_code` varchar(100) NOT NULL,
  `signature` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_tpv_transactions`
--

LOCK TABLES `kms_ecom_tpv_transactions` WRITE;
/*!40000 ALTER TABLE `kms_ecom_tpv_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_tpv_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ecom_vat`
--

DROP TABLE IF EXISTS `kms_ecom_vat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ecom_vat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_folder` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `value` int(2) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `default` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ecom_vat`
--

LOCK TABLES `kms_ecom_vat` WRITE;
/*!40000 ALTER TABLE `kms_ecom_vat` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ecom_vat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ent_clients`
--

DROP TABLE IF EXISTS `kms_ent_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ent_clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dr_folder` int(11) DEFAULT '0',
  `creation_date` date DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0',
  `payment_status` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `treatment` int(10) DEFAULT NULL,
  `sr_client` int(11) NOT NULL,
  `sr_provider` varchar(100) NOT NULL,
  `sr_user` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `billing_email` varchar(100) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `password_plain` varchar(100) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `zipcode` varchar(8) DEFAULT NULL,
  `location` varchar(80) DEFAULT NULL,
  `province` varchar(80) DEFAULT NULL,
  `state` varchar(80) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `discount_pc` int(11) NOT NULL DEFAULT '0',
  `sr_payment_method` varchar(50) NOT NULL,
  `default_payment_day` int(11) NOT NULL,
  `force_payment_day` varchar(30) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `bank_accountNumber` varchar(100) NOT NULL,
  `credit_card` varchar(16) DEFAULT NULL,
  `credit_card_name` varchar(45) DEFAULT NULL,
  `credit_card_expiration_date` varchar(7) DEFAULT NULL,
  `credit_card_vcs` varchar(3) DEFAULT NULL,
  `comAgent` varchar(100) NOT NULL,
  `comments` text NOT NULL,
  `cif` varchar(45) DEFAULT NULL,
  `cancellation_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ent_clients`
--

LOCK TABLES `kms_ent_clients` WRITE;
/*!40000 ALTER TABLE `kms_ent_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ent_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ent_contacts`
--

DROP TABLE IF EXISTS `kms_ent_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ent_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(10) NOT NULL,
  `creation_date` date DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `treatment` int(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `sector` varchar(80) DEFAULT NULL,
  `activity` varchar(155) DEFAULT NULL,
  `contact_role` varchar(40) DEFAULT NULL,
  `groups` varchar(100) DEFAULT NULL,
  `newsletter` varchar(1) NOT NULL DEFAULT '1',
  `photo` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT '',
  `email2` varchar(100) DEFAULT NULL,
  `email3` varchar(50) DEFAULT NULL,
  `cpassword` varchar(100) DEFAULT NULL,
  `language` varchar(2) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `cellphone` varchar(15) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `zipcode` varchar(8) DEFAULT NULL,
  `location` varchar(80) DEFAULT NULL,
  `province` varchar(80) DEFAULT NULL,
  `state` varchar(80) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `stars` varchar(5) DEFAULT NULL,
  `unsubscribe_reason` varchar(100) DEFAULT NULL,
  `unsubscribe_datetime` datetime DEFAULT NULL,
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ent_contacts`
--

LOCK TABLES `kms_ent_contacts` WRITE;
/*!40000 ALTER TABLE `kms_ent_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ent_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_ent_creditors`
--

DROP TABLE IF EXISTS `kms_ent_creditors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_ent_creditors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dr_folder` int(11) DEFAULT '0',
  `creation_date` date DEFAULT NULL,
  `entity_id` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0',
  `comments` text NOT NULL,
  `emr_email` varchar(100) NOT NULL,
  `fact_email` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `sr_payment_method` varchar(100) NOT NULL,
  `sr_bank_name` varchar(100) NOT NULL,
  `bank_accountNumber` varchar(100) NOT NULL,
  `comAgent` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `venciment` int(2) NOT NULL,
  `fixed_cost` varchar(15) NOT NULL,
  `estimated_cost` varchar(15) NOT NULL,
  `credit` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_ent_creditors`
--

LOCK TABLES `kms_ent_creditors` WRITE;
/*!40000 ALTER TABLE `kms_ent_creditors` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_ent_creditors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_accounting`
--

DROP TABLE IF EXISTS `kms_erp_accounting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_accounting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_id` int(11) DEFAULT NULL,
  `account` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `group` varchar(100) DEFAULT NULL,
  `subgroup` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_accounting`
--

LOCK TABLES `kms_erp_accounting` WRITE;
/*!40000 ALTER TABLE `kms_erp_accounting` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_accounting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_accounting_bookentries`
--

DROP TABLE IF EXISTS `kms_erp_accounting_bookentries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_accounting_bookentries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date DEFAULT NULL,
  `bookentry` int(11) DEFAULT NULL,
  `bookentry_type` varchar(75) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `operation` varchar(45) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `object_id` int(11) DEFAULT NULL,
  `object_type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_accounting_bookentries`
--

LOCK TABLES `kms_erp_accounting_bookentries` WRITE;
/*!40000 ALTER TABLE `kms_erp_accounting_bookentries` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_accounting_bookentries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_accounting_plans`
--

DROP TABLE IF EXISTS `kms_erp_accounting_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_accounting_plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_accounting_plans`
--

LOCK TABLES `kms_erp_accounting_plans` WRITE;
/*!40000 ALTER TABLE `kms_erp_accounting_plans` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_accounting_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_contracts`
--

DROP TABLE IF EXISTS `kms_erp_contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_contracts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creation_date` date DEFAULT NULL,
  `initial_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0',
  `billing_period` varchar(10) NOT NULL,
  `auto_renov` varchar(2) NOT NULL,
  `sr_client` int(10) unsigned NOT NULL DEFAULT '0',
  `sr_ecom_service` int(10) unsigned NOT NULL DEFAULT '0',
  `hosting_type` varchar(45) DEFAULT NULL,
  `new_hosting` varchar(1) DEFAULT NULL,
  `hosting_id` int(11) DEFAULT NULL,
  `new_vhost` varchar(1) DEFAULT NULL,
  `domain` varchar(45) DEFAULT NULL,
  `authcode` varchar(45) DEFAULT NULL,
  `alta` varchar(5) NOT NULL,
  `price` varchar(5) NOT NULL DEFAULT '0',
  `price_discount_pc` tinyint(4) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `invoice_pending` tinyint(4) NOT NULL DEFAULT '1',
  `paypal_subscr_id` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_contracts`
--

LOCK TABLES `kms_erp_contracts` WRITE;
/*!40000 ALTER TABLE `kms_erp_contracts` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_contracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_contracts_providers`
--

DROP TABLE IF EXISTS `kms_erp_contracts_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_contracts_providers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creation_date` date DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0',
  `sr_provider` int(10) unsigned NOT NULL DEFAULT '0',
  `number` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL DEFAULT '',
  `family` varchar(100) NOT NULL DEFAULT '0',
  `price` varchar(7) NOT NULL DEFAULT '0',
  `billing_period` varchar(10) NOT NULL,
  `auto_renov` varchar(2) NOT NULL,
  `initial_date` date NOT NULL,
  `end_date` date NOT NULL,
  `attachment` varchar(100) NOT NULL DEFAULT '',
  `payment_method` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `file` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_contracts_providers`
--

LOCK TABLES `kms_erp_contracts_providers` WRITE;
/*!40000 ALTER TABLE `kms_erp_contracts_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_contracts_providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_finance`
--

DROP TABLE IF EXISTS `kms_erp_finance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_finance` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `serie` varchar(3) NOT NULL,
  `number` int(10) NOT NULL,
  `from_doc` varchar(10) NOT NULL,
  `family` varchar(100) NOT NULL DEFAULT '',
  `entity` varchar(100) NOT NULL DEFAULT '',
  `concept` varchar(100) NOT NULL DEFAULT '',
  `import` int(11) NOT NULL DEFAULT '0',
  `bank` varchar(100) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `attachment` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(100) NOT NULL DEFAULT '',
  `periodicitat` varchar(10) NOT NULL,
  `pay_date` date NOT NULL,
  `tags` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_finance`
--

LOCK TABLES `kms_erp_finance` WRITE;
/*!40000 ALTER TABLE `kms_erp_finance` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_finance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_finance_banks`
--

DROP TABLE IF EXISTS `kms_erp_finance_banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_finance_banks` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `digit_code` varchar(4) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_finance_banks`
--

LOCK TABLES `kms_erp_finance_banks` WRITE;
/*!40000 ALTER TABLE `kms_erp_finance_banks` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_finance_banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_finance_banks_accounts`
--

DROP TABLE IF EXISTS `kms_erp_finance_banks_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_finance_banks_accounts` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `description` varchar(100) NOT NULL,
  `type` varchar(30) NOT NULL,
  `notes` text NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `entity_number` varchar(4) NOT NULL,
  `office_number` varchar(4) NOT NULL,
  `dc_number` varchar(2) NOT NULL,
  `account_number` varchar(10) NOT NULL,
  `account` varchar(23) NOT NULL,
  `iban` varchar(30) NOT NULL,
  `iban_paper` varchar(30) NOT NULL,
  `bic-swift` varchar(20) NOT NULL,
  `divisa` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_finance_banks_accounts`
--

LOCK TABLES `kms_erp_finance_banks_accounts` WRITE;
/*!40000 ALTER TABLE `kms_erp_finance_banks_accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_finance_banks_accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_finance_banks_transactions`
--

DROP TABLE IF EXISTS `kms_erp_finance_banks_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_finance_banks_transactions` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `bank_id` int(11) NOT NULL,
  `entity` varchar(150) NOT NULL,
  `concept` varchar(150) NOT NULL,
  `import` varchar(100) NOT NULL,
  `balance` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_finance_banks_transactions`
--

LOCK TABLES `kms_erp_finance_banks_transactions` WRITE;
/*!40000 ALTER TABLE `kms_erp_finance_banks_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_finance_banks_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_invoices`
--

DROP TABLE IF EXISTS `kms_erp_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `payment_date` date NOT NULL DEFAULT '2019-07-10',
  `serie` varchar(2) NOT NULL DEFAULT 'A',
  `type` varchar(20) NOT NULL,
  `proforma` varchar(1) NOT NULL DEFAULT '0',
  `sr_client` int(11) NOT NULL,
  `number` varchar(100) NOT NULL DEFAULT '',
  `concept` text NOT NULL,
  `price_values` text NOT NULL,
  `base` double NOT NULL,
  `discount` varchar(100) NOT NULL DEFAULT '',
  `irpf` varchar(100) NOT NULL DEFAULT '',
  `tax_percent` int(2) NOT NULL DEFAULT '18',
  `total_tax` double NOT NULL,
  `total` double NOT NULL,
  `notes` text NOT NULL,
  `internal_notes` text NOT NULL,
  `payment_method` varchar(100) NOT NULL DEFAULT '',
  `bank` varchar(20) NOT NULL,
  `bank_account_number` varchar(20) NOT NULL,
  `bank_charges` varchar(255) NOT NULL,
  `tax_values` text NOT NULL,
  `total_values` text NOT NULL,
  `sent_email` varchar(50) NOT NULL,
  `sent_date` datetime NOT NULL,
  `check_sent` tinyint(1) NOT NULL,
  `sr_remittance` int(5) NOT NULL,
  `status_terminator` int(1) DEFAULT NULL,
  `acc_status` int(5) NOT NULL,
  `paypal_subscr_id` varchar(60) NOT NULL,
  `paypal_txn_id` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_invoices`
--

LOCK TABLES `kms_erp_invoices` WRITE;
/*!40000 ALTER TABLE `kms_erp_invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_invoices_providers`
--

DROP TABLE IF EXISTS `kms_erp_invoices_providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_invoices_providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `type` varchar(20) NOT NULL,
  `sr_provider` varchar(100) NOT NULL DEFAULT '',
  `number` varchar(100) NOT NULL DEFAULT '',
  `concept` text NOT NULL,
  `base` varchar(100) NOT NULL DEFAULT '',
  `tax_percent` int(2) NOT NULL DEFAULT '16',
  `total_tax` varchar(100) NOT NULL,
  `total` varchar(100) NOT NULL DEFAULT '',
  `irpf` varchar(100) NOT NULL DEFAULT '',
  `payment_method` varchar(100) NOT NULL DEFAULT '',
  `payment_date` date NOT NULL DEFAULT '2019-07-10',
  `sr_bank` varchar(20) NOT NULL,
  `bank_account_number` varchar(20) NOT NULL,
  `bank_charges` varchar(255) NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_invoices_providers`
--

LOCK TABLES `kms_erp_invoices_providers` WRITE;
/*!40000 ALTER TABLE `kms_erp_invoices_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_invoices_providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_invoices_sending_log`
--

DROP TABLE IF EXISTS `kms_erp_invoices_sending_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_invoices_sending_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(1) NOT NULL,
  `sr_client` varchar(100) NOT NULL DEFAULT '',
  `sr_invoice` int(5) NOT NULL,
  `number` varchar(15) NOT NULL,
  `sent_date` datetime NOT NULL,
  `sent_to` varchar(50) NOT NULL,
  `sent_cc` varchar(50) NOT NULL,
  `total` double NOT NULL,
  `payment_date` date NOT NULL DEFAULT '2019-07-10',
  `payment_method` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_invoices_sending_log`
--

LOCK TABLES `kms_erp_invoices_sending_log` WRITE;
/*!40000 ALTER TABLE `kms_erp_invoices_sending_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_invoices_sending_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_options`
--

DROP TABLE IF EXISTS `kms_erp_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `main_entity` int(10) NOT NULL,
  `default_vat` int(10) NOT NULL,
  `venciment_day` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_options`
--

LOCK TABLES `kms_erp_options` WRITE;
/*!40000 ALTER TABLE `kms_erp_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_paysheets`
--

DROP TABLE IF EXISTS `kms_erp_paysheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_paysheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `incidence_bonus` int(11) DEFAULT NULL,
  `incidence_gratification` varchar(45) DEFAULT NULL,
  `incidence_extraHours` varchar(45) DEFAULT NULL,
  `incidence_commissions` varchar(45) DEFAULT NULL,
  `incidence_incentives` varchar(45) DEFAULT NULL,
  `incidence_diets` varchar(45) DEFAULT NULL,
  `incidence_gasoil` varchar(45) DEFAULT NULL,
  `incidence_unjustifiedAbsenteeism_days` varchar(45) DEFAULT NULL,
  `irpf` varchar(45) DEFAULT NULL,
  `import` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_paysheets`
--

LOCK TABLES `kms_erp_paysheets` WRITE;
/*!40000 ALTER TABLE `kms_erp_paysheets` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_paysheets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_erp_remittances`
--

DROP TABLE IF EXISTS `kms_erp_remittances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_erp_remittances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT '2019-07-10 00:00:00',
  `from_date` date NOT NULL,
  `to_date` date NOT NULL DEFAULT '2019-07-10',
  `billing_date` date NOT NULL,
  `description` varchar(100) NOT NULL DEFAULT '0',
  `import` varchar(10) NOT NULL,
  `records` int(10) NOT NULL,
  `notes` text NOT NULL,
  `sr_bank_account` varchar(20) NOT NULL,
  `file` varchar(100) NOT NULL,
  `generated_date` datetime NOT NULL,
  `type` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_erp_remittances`
--

LOCK TABLES `kms_erp_remittances` WRITE;
/*!40000 ALTER TABLE `kms_erp_remittances` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_erp_remittances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_imark_banners`
--

DROP TABLE IF EXISTS `kms_imark_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_imark_banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_imark_banners`
--

LOCK TABLES `kms_imark_banners` WRITE;
/*!40000 ALTER TABLE `kms_imark_banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_imark_banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_imark_campaigns`
--

DROP TABLE IF EXISTS `kms_imark_campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_imark_campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_imark_campaigns`
--

LOCK TABLES `kms_imark_campaigns` WRITE;
/*!40000 ALTER TABLE `kms_imark_campaigns` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_imark_campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_imark_crowdfunding_donations`
--

DROP TABLE IF EXISTS `kms_imark_crowdfunding_donations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_imark_crowdfunding_donations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `project_id` varchar(45) DEFAULT NULL,
  `fullname` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `dni` varchar(45) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `location` varchar(45) DEFAULT NULL,
  `money` varchar(45) DEFAULT NULL,
  `comments` text,
  `dr_folder` int(11) DEFAULT NULL,
  `reward_id` int(11) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `cellphone` varchar(45) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_imark_crowdfunding_donations`
--

LOCK TABLES `kms_imark_crowdfunding_donations` WRITE;
/*!40000 ALTER TABLE `kms_imark_crowdfunding_donations` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_imark_crowdfunding_donations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_imark_crowdfunding_projects`
--

DROP TABLE IF EXISTS `kms_imark_crowdfunding_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_imark_crowdfunding_projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_folder` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `project_name` varchar(150) DEFAULT NULL,
  `project_headline` varchar(255) DEFAULT NULL,
  `project_picture` varchar(100) DEFAULT NULL,
  `project_description` text,
  `money_goal` int(11) DEFAULT NULL,
  `money_adquired` int(11) DEFAULT NULL,
  `project_authors` varchar(150) DEFAULT NULL,
  `project_url` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_imark_crowdfunding_projects`
--

LOCK TABLES `kms_imark_crowdfunding_projects` WRITE;
/*!40000 ALTER TABLE `kms_imark_crowdfunding_projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_imark_crowdfunding_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_imark_crowdfunding_rewards`
--

DROP TABLE IF EXISTS `kms_imark_crowdfunding_rewards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_imark_crowdfunding_rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `money` int(11) DEFAULT NULL,
  `description` text,
  `creation_date` datetime DEFAULT NULL,
  `dr_folder` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_imark_crowdfunding_rewards`
--

LOCK TABLES `kms_imark_crowdfunding_rewards` WRITE;
/*!40000 ALTER TABLE `kms_imark_crowdfunding_rewards` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_imark_crowdfunding_rewards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_imark_mailings`
--

DROP TABLE IF EXISTS `kms_imark_mailings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_imark_mailings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_folder` varchar(10) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `template` varchar(100) DEFAULT NULL,
  `language` varchar(2) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  `auto_send` int(11) DEFAULT '0',
  `send_datetime` datetime DEFAULT NULL,
  `fromemail` varchar(100) DEFAULT NULL,
  `fromname` varchar(100) DEFAULT NULL,
  `replyto` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `to_group` varchar(255) DEFAULT NULL,
  `to_sector` text,
  `to_location` text,
  `to_province` text,
  `to_state` text,
  `to_country` text,
  `to_language` varchar(2) DEFAULT NULL,
  `to_zipcode` varchar(5) DEFAULT NULL,
  `to_email` varchar(255) DEFAULT NULL,
  `to_from_creation_date` date DEFAULT NULL,
  `url_body` varchar(100) DEFAULT NULL,
  `body` text,
  `report_total_contacts` int(6) DEFAULT '0',
  `report_total_emails` int(6) DEFAULT NULL,
  `report_total_opened` int(6) DEFAULT NULL,
  `report_total_delivered` int(6) DEFAULT NULL,
  `report_total_bounced` int(6) DEFAULT NULL,
  `report_total_pending` int(6) DEFAULT NULL,
  `report_total_bounced_invalid` int(6) DEFAULT NULL,
  `report_total_bounced_spam` int(6) DEFAULT NULL,
  `report_total_bounced_fullbox` int(6) DEFAULT NULL,
  `report_total_bounced_others` int(6) DEFAULT NULL,
  `show_unsubscribe` varchar(1) DEFAULT '1',
  `show_brandname` varchar(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_imark_mailings`
--

LOCK TABLES `kms_imark_mailings` WRITE;
/*!40000 ALTER TABLE `kms_imark_mailings` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_imark_mailings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_imark_mailings_config`
--

DROP TABLE IF EXISTS `kms_imark_mailings_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_imark_mailings_config` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `dr_folder` smallint(6) NOT NULL,
  `constant` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `value_ct` varchar(100) NOT NULL,
  `value_es` varchar(100) NOT NULL,
  `value_en` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_imark_mailings_config`
--

LOCK TABLES `kms_imark_mailings_config` WRITE;
/*!40000 ALTER TABLE `kms_imark_mailings_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_imark_mailings_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_imark_social`
--

DROP TABLE IF EXISTS `kms_imark_social`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_imark_social` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `network` varchar(100) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_imark_social`
--

LOCK TABLES `kms_imark_social` WRITE;
/*!40000 ALTER TABLE `kms_imark_social` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_imark_social` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_imark_stats`
--

DROP TABLE IF EXISTS `kms_imark_stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_imark_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dr_folder` int(11) NOT NULL,
  `relay_ip` varchar(15) NOT NULL,
  `status` varchar(30) NOT NULL,
  `url` varchar(255) NOT NULL,
  `click_datetime` datetime NOT NULL,
  `click_on` varchar(40) NOT NULL,
  `click_city` varchar(40) NOT NULL,
  `click_country` varchar(40) NOT NULL,
  `mailing_id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_imark_stats`
--

LOCK TABLES `kms_imark_stats` WRITE;
/*!40000 ALTER TABLE `kms_imark_stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_imark_stats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_imark_templates`
--

DROP TABLE IF EXISTS `kms_imark_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_imark_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `content_type` varchar(20) DEFAULT NULL,
  `template` text,
  `centerpage` varchar(2) DEFAULT NULL,
  `pagewidth` varchar(4) DEFAULT NULL,
  `font` varchar(100) DEFAULT NULL,
  `fontsize` varchar(4) DEFAULT NULL,
  `line-height` varchar(4) DEFAULT NULL,
  `bgcolor` varchar(7) DEFAULT NULL,
  `bgimage` varchar(100) DEFAULT NULL,
  `fontcolor` varchar(7) DEFAULT NULL,
  `linkscolor` varchar(7) DEFAULT NULL,
  `openlinkcolor` varchar(7) DEFAULT NULL,
  `bandabg_color` varchar(7) NOT NULL,
  `bandatext_color` varchar(7) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_imark_templates`
--

LOCK TABLES `kms_imark_templates` WRITE;
/*!40000 ALTER TABLE `kms_imark_templates` DISABLE KEYS */;
INSERT INTO `kms_imark_templates` VALUES (1,'2019-07-10 00:00:00','_KMS_TEMPLATES_DEFAULT','html','\r\n<p>[body]</p>\r\n','1','600','Tahoma, arial, helvetica, sans-serif','13','130%','FFFFFF','','1C1C1C','003BA1','003BA1','','444444');
/*!40000 ALTER TABLE `kms_imark_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_lib_files`
--

DROP TABLE IF EXISTS `kms_lib_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_lib_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL DEFAULT '',
  `folder_id` int(11) DEFAULT NULL,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `owner` varchar(45) DEFAULT '',
  `group` varchar(45) DEFAULT '',
  `permissions` varchar(45) DEFAULT '',
  `name` text NOT NULL,
  `description` text NOT NULL,
  `file` varchar(100) NOT NULL DEFAULT '',
  `size` varchar(100) NOT NULL DEFAULT '',
  `downloadCount` varchar(100) NOT NULL DEFAULT '',
  `external_url` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_lib_files`
--

LOCK TABLES `kms_lib_files` WRITE;
/*!40000 ALTER TABLE `kms_lib_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_lib_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_lib_folders`
--

DROP TABLE IF EXISTS `kms_lib_folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_lib_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `owner` varchar(45) DEFAULT NULL,
  `group` varchar(45) DEFAULT NULL,
  `permissions` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `icon` varchar(45) DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_lib_folders`
--

LOCK TABLES `kms_lib_folders` WRITE;
/*!40000 ALTER TABLE `kms_lib_folders` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_lib_folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_lib_pictures`
--

DROP TABLE IF EXISTS `kms_lib_pictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_lib_pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL DEFAULT '',
  `mod` varchar(50) NOT NULL DEFAULT '',
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `fieldname` varchar(100) NOT NULL DEFAULT '',
  `origin_id` int(11) DEFAULT NULL,
  `file` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `album_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `tags` text,
  `owner` varchar(45) DEFAULT '',
  `group` varchar(45) DEFAULT '',
  `permissions` varchar(45) DEFAULT '',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_lib_pictures`
--

LOCK TABLES `kms_lib_pictures` WRITE;
/*!40000 ALTER TABLE `kms_lib_pictures` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_lib_pictures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_lib_pictures_albums`
--

DROP TABLE IF EXISTS `kms_lib_pictures_albums`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_lib_pictures_albums` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `status` int(1) NOT NULL,
  `owner` varchar(45) DEFAULT NULL,
  `group` varchar(45) DEFAULT NULL,
  `permissions` varchar(45) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `gallery` int(11) NOT NULL,
  `private` int(1) NOT NULL,
  `max_resize_width` int(11) NOT NULL,
  `max_resize_height` int(11) NOT NULL,
  `max_thumb_width` int(11) NOT NULL,
  `max_thumb_height` int(11) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_lib_pictures_albums`
--

LOCK TABLES `kms_lib_pictures_albums` WRITE;
/*!40000 ALTER TABLE `kms_lib_pictures_albums` DISABLE KEYS */;
INSERT INTO `kms_lib_pictures_albums` VALUES (1,'2020-02-04 00:00:00',1,'','','','web',0,1,0,0,0,0,'','');
/*!40000 ALTER TABLE `kms_lib_pictures_albums` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_lib_videos`
--

DROP TABLE IF EXISTS `kms_lib_videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_lib_videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL DEFAULT '',
  `mod` varchar(50) NOT NULL DEFAULT '',
  `fieldname` varchar(100) NOT NULL DEFAULT '',
  `origin_id` int(11) DEFAULT NULL,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `file` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL,
  `caption` varchar(100) NOT NULL DEFAULT '',
  `album_id` int(11) NOT NULL,
  `link` varchar(100) NOT NULL,
  `tags` text,
  `owner` varchar(45) DEFAULT '',
  `group` varchar(45) DEFAULT '',
  `permissions` varchar(45) DEFAULT '',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_lib_videos`
--

LOCK TABLES `kms_lib_videos` WRITE;
/*!40000 ALTER TABLE `kms_lib_videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_lib_videos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_planner_surveys`
--

DROP TABLE IF EXISTS `kms_planner_surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_planner_surveys` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dr_folder` varchar(100) NOT NULL DEFAULT '',
  `creation_date` date DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `show_progress` int(1) NOT NULL DEFAULT '1',
  `show_backbut` int(1) NOT NULL DEFAULT '0',
  `show_restartbut` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_planner_surveys`
--

LOCK TABLES `kms_planner_surveys` WRITE;
/*!40000 ALTER TABLE `kms_planner_surveys` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_planner_surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_planner_surveys_answers`
--

DROP TABLE IF EXISTS `kms_planner_surveys_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_planner_surveys_answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `dr_folder` varchar(100) NOT NULL DEFAULT '',
  `survey_id` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_planner_surveys_answers`
--

LOCK TABLES `kms_planner_surveys_answers` WRITE;
/*!40000 ALTER TABLE `kms_planner_surveys_answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_planner_surveys_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_planner_surveys_questions`
--

DROP TABLE IF EXISTS `kms_planner_surveys_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_planner_surveys_questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dr_folder` varchar(100) NOT NULL DEFAULT '',
  `status` varchar(30) DEFAULT 'active',
  `survey_id` varchar(100) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `options` text NOT NULL,
  `position` varchar(100) NOT NULL,
  `section_id` int(11) NOT NULL,
  `required` int(1) NOT NULL DEFAULT '1',
  `mcase_order` int(11) NOT NULL COMMENT 'multiple case order',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_planner_surveys_questions`
--

LOCK TABLES `kms_planner_surveys_questions` WRITE;
/*!40000 ALTER TABLE `kms_planner_surveys_questions` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_planner_surveys_questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_planner_surveys_sections`
--

DROP TABLE IF EXISTS `kms_planner_surveys_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_planner_surveys_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dr_folder` varchar(100) NOT NULL DEFAULT '',
  `survey_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `sortorder` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_planner_surveys_sections`
--

LOCK TABLES `kms_planner_surveys_sections` WRITE;
/*!40000 ALTER TABLE `kms_planner_surveys_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_planner_surveys_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites`
--

DROP TABLE IF EXISTS `kms_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `status` varchar(15) NOT NULL DEFAULT 'online',
  `domain` varchar(50) NOT NULL DEFAULT '',
  `url_base` varchar(100) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `default_lang` varchar(2) NOT NULL,
  `multilanguage` char(1) NOT NULL DEFAULT '1',
  `available_languages` varchar(255) NOT NULL DEFAULT '',
  `charset` varchar(100) NOT NULL DEFAULT '',
  `robots` varchar(100) NOT NULL DEFAULT '',
  `cookies` varchar(1) NOT NULL DEFAULT '0',
  `meta_title` varchar(100) NOT NULL,
  `meta_organization` varchar(100) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_locality` varchar(255) NOT NULL,
  `default_page` varchar(100) NOT NULL,
  `theme` varchar(50) NOT NULL,
  `favicon` varchar(100) NOT NULL DEFAULT '',
  `logo` varchar(100) NOT NULL DEFAULT '',
  `footer` varchar(100) NOT NULL,
  `multiuser` char(1) NOT NULL DEFAULT '0',
  `login` varchar(15) NOT NULL,
  `copyright` varchar(100) NOT NULL,
  `widgets_left_sidebar` varchar(255) NOT NULL,
  `widgets_right_sidebar` varchar(255) NOT NULL,
  `widgets_topright_sidebar` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites`
--

LOCK TABLES `kms_sites` WRITE;
/*!40000 ALTER TABLE `kms_sites` DISABLE KEYS */;
INSERT INTO `kms_sites` VALUES (1,'2014-11-24','manteinance','website.com','http://www.website.com/','suport@intergrid.cat','ca','0','ca,es,en,fr,it,eu,de,pl,cn,jp,nl,pt,ru','utf-8','all','0','website.com','website.com','Intergrid KMS Sites','Enter your keywords here','Your location','1','basic','','','','0','disabled','','','','');
/*!40000 ALTER TABLE `kms_sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_agenda`
--

DROP TABLE IF EXISTS `kms_sites_agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_agenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) NOT NULL,
  `creation_date` datetime NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '',
  `category` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `place` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `picture` varchar(100) NOT NULL,
  `lectures` int(11) NOT NULL DEFAULT '0',
  `file` varchar(100) NOT NULL,
  `tags` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_agenda`
--

LOCK TABLES `kms_sites_agenda` WRITE;
/*!40000 ALTER TABLE `kms_sites_agenda` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_blogs`
--

DROP TABLE IF EXISTS `kms_sites_blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `name` varchar(100) NOT NULL DEFAULT '',
  `show_shareopt` varchar(1) NOT NULL DEFAULT '1',
  `show_comments` varchar(1) NOT NULL DEFAULT '1',
  `show_useravatar` varchar(1) NOT NULL DEFAULT '1',
  `posts_per_page` int(11) NOT NULL DEFAULT '10',
  `rss_utm_tags` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_blogs`
--

LOCK TABLES `kms_sites_blogs` WRITE;
/*!40000 ALTER TABLE `kms_sites_blogs` DISABLE KEYS */;
INSERT INTO `kms_sites_blogs` VALUES (1,'2019-07-10','blog','1','1','1',10,'');
/*!40000 ALTER TABLE `kms_sites_blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_comments`
--

DROP TABLE IF EXISTS `kms_sites_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mod` varchar(45) NOT NULL,
  `id_post` varchar(100) NOT NULL DEFAULT '',
  `creation_date` datetime NOT NULL DEFAULT '2019-07-10 00:00:00',
  `status` varchar(45) NOT NULL DEFAULT 'published',
  `name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `website` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_comments`
--

LOCK TABLES `kms_sites_comments` WRITE;
/*!40000 ALTER TABLE `kms_sites_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_components`
--

DROP TABLE IF EXISTS `kms_sites_components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `status` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` text,
  `params` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_components`
--

LOCK TABLES `kms_sites_components` WRITE;
/*!40000 ALTER TABLE `kms_sites_components` DISABLE KEYS */;
INSERT INTO `kms_sites_components` VALUES (1,'2019-07-10','online','application','webpage','',''),(2,'2019-07-10','online','application','webform','',''),(3,'2019-07-10','online','application','webphp','',''),(4,'2019-07-10','online','application','uaams','',''),(5,'2019-07-10','online','application','ecommerce','',''),(6,'2019-07-10','online','application','photogallery','',''),(7,'2019-07-10','online','application','blog','',''),(8,'2019-07-10','online','widget','sidemenu','',''),(9,'2019-07-10','online','widget','loginbox','',''),(10,'2019-07-10','online','widget','links','',''),(11,'2019-07-10','online','widget','usersonline','',''),(12,'2019-07-10','online','widget','categories','',''),(13,'2019-07-10','online','widget','tagcloud','',''),(14,'2019-07-10','online','widget','whatshot','',''),(15,'2019-07-10','online','widget','topposts','',''),(16,'2019-07-10','online','widget','banner','',''),(17,'2019-07-10','online','widget','twitter','',''),(18,'2019-07-10','online','widget','flickr','',''),(19,'2019-07-10','online','widget','youtubevideo','',''),(20,'2019-07-10','online','widget','ifollow','',''),(21,'2019-07-10','online','widget','googleconnect','',''),(22,'2019-07-10','online','widget','google_search','',''),(23,'2019-07-10','online','application','links','',''),(24,'2019-07-10','online','application','catalog','',''),(25,'2019-07-10','online','widget','picture','',''),(26,'2019-07-10','online','widget','news','',''),(27,'2019-07-10','online','application','agenda','',''),(28,'2019-07-10','online','widget','agenda','',''),(29,'2019-07-10','online','widget','page','',''),(30,'2019-07-10','online','widget','slideshow','',''),(31,'2019-07-10','online','application','slideshow','',''),(32,'2019-07-10','online','widget','text','',''),(33,'2019-07-10','online','application','crowdfunding','',''),(34,'2019-07-10','online','application','downloads','',''),(35,'2019-07-10','online','application','guestbook','',''),(36,'2019-07-10','online','application','object-oriented-interface','',''),(37,'2019-07-10','online','application','redirect','',''),(38,'2019-07-10','online','application','survey','',''),(39,'2019-07-10','online','application','wiki','',''),(40,'2019-07-10','online','application','survey','',''),(41,'2019-07-10','online','application','search','','');
/*!40000 ALTER TABLE `kms_sites_components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_conf`
--

DROP TABLE IF EXISTS `kms_sites_conf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `creation_date` date DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_conf`
--

LOCK TABLES `kms_sites_conf` WRITE;
/*!40000 ALTER TABLE `kms_sites_conf` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_conf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_countries`
--

DROP TABLE IF EXISTS `kms_sites_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `area` varchar(20) NOT NULL,
  `delivery_zone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_countries`
--

LOCK TABLES `kms_sites_countries` WRITE;
/*!40000 ALTER TABLE `kms_sites_countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_files`
--

DROP TABLE IF EXISTS `kms_sites_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL DEFAULT '',
  `external_url` varchar(100) NOT NULL DEFAULT '',
  `dr_folder` varchar(100) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `size` varchar(100) NOT NULL DEFAULT '',
  `downloadCount` varchar(100) NOT NULL DEFAULT '',
  `file` varchar(100) NOT NULL DEFAULT '',
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_files`
--

LOCK TABLES `kms_sites_files` WRITE;
/*!40000 ALTER TABLE `kms_sites_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_galleries`
--

DROP TABLE IF EXISTS `kms_sites_galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_galleries` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `play_album` int(11) NOT NULL,
  `theme` varchar(20) NOT NULL DEFAULT 'clever',
  `player_size` varchar(30) NOT NULL DEFAULT 'fixed',
  `effect` varchar(20) NOT NULL,
  `animSpeed` int(11) NOT NULL,
  `pauseTime` int(11) NOT NULL,
  `directionNav` int(1) NOT NULL DEFAULT '0',
  `controlNav` int(1) NOT NULL DEFAULT '0',
  `controlNavThumbs` int(1) NOT NULL DEFAULT '0',
  `pauseOnHover` int(1) NOT NULL DEFAULT '1',
  `manualAdvance` int(1) NOT NULL DEFAULT '0',
  `randomStart` int(1) NOT NULL DEFAULT '1',
  `showCaption` int(1) NOT NULL DEFAULT '0',
  `zoomOnClick` int(1) NOT NULL DEFAULT '1',
  `showResized` int(1) NOT NULL DEFAULT '1',
  `htmlCaption` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_galleries`
--

LOCK TABLES `kms_sites_galleries` WRITE;
/*!40000 ALTER TABLE `kms_sites_galleries` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_guestbook`
--

DROP TABLE IF EXISTS `kms_sites_guestbook`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL DEFAULT '2019-07-10 00:00:00',
  `name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `website` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `dr_folder` int(11) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_guestbook`
--

LOCK TABLES `kms_sites_guestbook` WRITE;
/*!40000 ALTER TABLE `kms_sites_guestbook` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_guestbook` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_lang`
--

DROP TABLE IF EXISTS `kms_sites_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `const` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(30) DEFAULT NULL,
  `ca` text NOT NULL,
  `es` text NOT NULL,
  `en` text NOT NULL,
  `de` text NOT NULL,
  `fr` text NOT NULL,
  `it` text NOT NULL,
  `pt` text NOT NULL,
  `eu` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_lang`
--

LOCK TABLES `kms_sites_lang` WRITE;
/*!40000 ALTER TABLE `kms_sites_lang` DISABLE KEYS */;
INSERT INTO `kms_sites_lang` VALUES (1,'_KMS_WEB_TXT_HOME','pages','Text de benvinguda i presentació','Texto de bienvenida y presentación','Welcome and presentation text','\r\n\r\n','\r\n\r\n','\r\n\r\n','',''),(2,'_KMS_WEB_MENU_HOME',NULL,'Inici','Inicio','Home','','','','',''),(3,'_self',NULL,'','','','','','','',''),(4,'_KMS_WEB_MENU_ABOUT',NULL,'Presentació','Presentación','About us','','','','',''),(5,'_KMS_WEB_MENU_CATALOG',NULL,'Catàleg','Catálogo','Catalog','','','','',''),(6,'_KMS_WEB_MENU_CONTACT',NULL,'Contacte','Contacto','Contact us','','','','',''),(7,'_KMS_WEB_MENU_NEWS',NULL,'Notícies','Noticias','News','','','','',''),(8,'_KMS_WEB_BLOG_READFULLPOST','pages','Llegeix-ne més','Leer más','Read full post','\r\n\r\n','\r\n\r\n','\r\n\r\n','','');
/*!40000 ALTER TABLE `kms_sites_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_links`
--

DROP TABLE IF EXISTS `kms_sites_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_links` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `dr_folder` varchar(5) NOT NULL,
  `name` varchar(200) NOT NULL,
  `url` varchar(100) NOT NULL,
  `description` varchar(200) NOT NULL,
  `count` int(5) NOT NULL,
  `creation_date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `target` varchar(20) NOT NULL DEFAULT 'blank',
  `labels` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_links`
--

LOCK TABLES `kms_sites_links` WRITE;
/*!40000 ALTER TABLE `kms_sites_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_menus`
--

DROP TABLE IF EXISTS `kms_sites_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `status` int(1) NOT NULL DEFAULT '1',
  `location` varchar(100) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `style` varchar(100) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_menus`
--

LOCK TABLES `kms_sites_menus` WRITE;
/*!40000 ALTER TABLE `kms_sites_menus` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_pages`
--

DROP TABLE IF EXISTS `kms_sites_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `status` varchar(100) NOT NULL DEFAULT '',
  `type` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `menu_id` int(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT '1',
  `name` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `meta_description` varchar(100) NOT NULL,
  `meta_keywords` text NOT NULL,
  `show_title` tinyint(1) NOT NULL,
  `nomargin` tinyint(1) NOT NULL,
  `private` varchar(1) NOT NULL DEFAULT '',
  `remove_website_widgets` tinyint(1) NOT NULL,
  `widgets_left_sidebar` varchar(255) NOT NULL,
  `widgets_right_sidebar` varchar(255) NOT NULL,
  `hide_leftcol` int(1) DEFAULT NULL,
  `hide_rightcol` int(1) DEFAULT NULL,
  `custom_url` varchar(100) DEFAULT NULL,
  `target` varchar(100) DEFAULT NULL,
  `alias_id` int(11) DEFAULT '0',
  `sort_order` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_pages`
--

LOCK TABLES `kms_sites_pages` WRITE;
/*!40000 ALTER TABLE `kms_sites_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_plugins`
--

DROP TABLE IF EXISTS `kms_sites_plugins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `status` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `network` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL DEFAULT '',
  `web_site` varchar(100) NOT NULL DEFAULT '',
  `callback_url` varchar(100) NOT NULL DEFAULT '',
  `access_type` varchar(100) NOT NULL DEFAULT '',
  `icon` varchar(100) NOT NULL DEFAULT '',
  `api_consumer_key` varchar(100) NOT NULL,
  `api_secret_key` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_plugins`
--

LOCK TABLES `kms_sites_plugins` WRITE;
/*!40000 ALTER TABLE `kms_sites_plugins` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_plugins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sites_themes`
--

DROP TABLE IF EXISTS `kms_sites_themes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sites_themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `template` varchar(100) NOT NULL DEFAULT 'standard',
  `centerpage` varchar(2) DEFAULT NULL,
  `header_height` varchar(6) NOT NULL DEFAULT '140px',
  `font-family` varchar(100) DEFAULT NULL,
  `font-size` varchar(6) DEFAULT NULL,
  `line_height` varchar(6) DEFAULT NULL,
  `corp_color1` varchar(6) DEFAULT NULL,
  `corp_color2` varchar(6) DEFAULT NULL,
  `corp_color3` varchar(6) DEFAULT NULL,
  `anchor_color` varchar(6) NOT NULL,
  `anchor_hover_color` varchar(6) NOT NULL,
  `anchor_bg_hover_color` varchar(6) NOT NULL,
  `width_unit` varchar(2) DEFAULT NULL,
  `page_margin` varchar(6) DEFAULT NULL,
  `page_width` varchar(6) DEFAULT NULL,
  `page_border` varchar(45) DEFAULT NULL,
  `leftcol_width` varchar(6) DEFAULT NULL,
  `rightcol_width` varchar(6) DEFAULT NULL,
  `menu_background_image` varchar(100) NOT NULL,
  `menu_font_size` varchar(6) NOT NULL,
  `menu_text_color` varchar(6) NOT NULL,
  `menu_text_hover_color` varchar(6) NOT NULL,
  `menu_bg_hover_color` varchar(6) NOT NULL,
  `menu_text_selected_color` varchar(6) NOT NULL,
  `menu_bg_selected_color` varchar(6) NOT NULL,
  `menu_margin_top` varchar(6) NOT NULL,
  `menu_margin_bottom` varchar(6) NOT NULL,
  `menu_margin_left` varchar(6) NOT NULL,
  `button_style` varchar(10) NOT NULL,
  `web_background_image` varchar(100) NOT NULL,
  `web_background_image_attachment` varchar(10) NOT NULL,
  `header_background_image` varchar(100) NOT NULL,
  `page_background_image` varchar(100) NOT NULL,
  `footer_background_image` varchar(100) NOT NULL,
  `web_background_color` varchar(6) NOT NULL,
  `top_background_color` varchar(6) NOT NULL,
  `top_wide_bg_color` varchar(6) NOT NULL,
  `header_background_color` varchar(6) DEFAULT NULL,
  `menu_background_color` varchar(6) DEFAULT NULL,
  `page_background_color` varchar(6) DEFAULT NULL,
  `footer_background_color` varchar(6) NOT NULL,
  `header_wide_background_color` varchar(6) NOT NULL,
  `page_wide_background_color` varchar(6) NOT NULL,
  `footer_wide_background_color` varchar(6) NOT NULL,
  `menu_wide_background_color` varchar(6) NOT NULL,
  `border_radius` varchar(3) NOT NULL,
  `page_bg_opacity` varchar(3) NOT NULL,
  `footer_style` varchar(40) NOT NULL,
  `logo_text_color` varchar(6) NOT NULL,
  `accessibility_options` varchar(1) NOT NULL,
  `static_sitebackground` varchar(1) NOT NULL,
  `leftcol_bgcolor` varchar(6) NOT NULL,
  `rightcol_bgcolor` varchar(6) NOT NULL,
  `sidemenu_text_color` varchar(6) NOT NULL,
  `sidemenu_text_hover_color` varchar(6) NOT NULL,
  `sidemenu_bg_hover_color` varchar(6) NOT NULL,
  `sidemenu_text_selected_color` varchar(6) NOT NULL,
  `sidemenu_bg_selected_color` varchar(6) NOT NULL,
  `sidemenu_option_bg_color` varchar(6) NOT NULL,
  `sidemenu_autocollapse` varchar(1) NOT NULL,
  `sidemenu_forceupper` varchar(1) NOT NULL,
  `language_selector` varchar(30) NOT NULL,
  `sitesearch` varchar(30) NOT NULL,
  `search_style` varchar(15) DEFAULT NULL,
  `searchengine` varchar(15) DEFAULT NULL,
  `menu_height` varchar(6) NOT NULL,
  `menu_padding` int(11) NOT NULL,
  `background_repeat_x` varchar(10) NOT NULL,
  `background_repeat_y` varchar(10) NOT NULL,
  `logo_position_y` varchar(5) DEFAULT NULL,
  `logo_position_x` varchar(5) DEFAULT NULL,
  `top_text_color` varchar(6) DEFAULT NULL,
  `menu_float` varchar(45) DEFAULT NULL,
  `top_height` varchar(6) DEFAULT NULL,
  `page_minheight` varchar(6) DEFAULT NULL,
  `h1_style` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sites_themes`
--

LOCK TABLES `kms_sites_themes` WRITE;
/*!40000 ALTER TABLE `kms_sites_themes` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sites_themes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_apps`
--

DROP TABLE IF EXISTS `kms_sys_apps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_apps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `keyname` varchar(45) DEFAULT NULL,
  `type` varchar(40) NOT NULL DEFAULT '',
  `owner` varchar(10) NOT NULL DEFAULT '',
  `group` varchar(10) NOT NULL DEFAULT '',
  `interface` varchar(40) NOT NULL DEFAULT '',
  `show_sidemenu` varchar(1) NOT NULL DEFAULT '1',
  `show_menu_xml` varchar(45) DEFAULT NULL,
  `show_modules` varchar(1) NOT NULL DEFAULT '1',
  `show_views` varchar(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) DEFAULT NULL,
  `modules` varchar(255) NOT NULL,
  `ext_modules` varchar(255) NOT NULL,
  `default_module` varchar(40) NOT NULL DEFAULT '',
  `menu_xml` text,
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_apps`
--

LOCK TABLES `kms_sys_apps` WRITE;
/*!40000 ALTER TABLE `kms_sys_apps` DISABLE KEYS */;
INSERT INTO `kms_sys_apps` VALUES (1,'2019-07-10','active','Sites','sites','application','','1','','1','1','0','0',1,'sites,sites_themes,sites_menus,sites_pages,sites_comments,sites_blogs,sites_forms,sites_galleries,sites_lang,sites_stats,sites_components','','sites_pages','<menu_xml><menu>\r\n<title>_KMS_GL_CONFIG</title>\r\n<submenu>\r\n   <title>_KMS_TY_WEBSITES</title>\r\n   <action>/?app=sites&mod=sites</action>\r\n   <mod>sites</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_SITES_THEMES</title>\r\n   <action>/?app=sites&mod=sites_themes</action>\r\n   <mod>sites_themes</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_SITES_MENUS</title>\r\n   <action>/?app=sites&mod=sites_menus</action>\r\n   <mod>sites_menus</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_SITES_PAGES</title>\r\n   <action>/?app=sites&mod=sites_pages</action>\r\n   <mod>sites_menus</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_SITES_BLOGS</title>\r\n   <action>/?app=sites&mod=sites_blogs</action>\r\n   <mod>sites_blogs</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_SITES_GALLERIES</title>\r\n   <action>/?app=sites&mod=sites_galleries</action>\r\n   <mod>sites_galleries</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_ECOM_CATALOGS</title>\r\n   <action>/?app=sites&mod=ecom_catalogs</action>\r\n   <mod>ecom_catalogs</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_SITES_COMPONENTS</title>\r\n   <action>/?app=sites&mod=sites_components</action>\r\n   <mod>sites_components</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_SITES_PLUGINS</title>\r\n   <action>/?app=sites&mod=sites_plugins</action>\r\n   <mod>sites_plugins</mod>\r\n</submenu>\r\n</menu>\r\n<menu>\r\n<title>_KMS_TY_SITES_STATS</title>\r\n<submenu>\r\n   <title>_KMS_TY_SITES_STATS</title>\r\n   <action>/?app=sites&mod=sites_stats</action>\r\n   <mod>sites_stats</mod>\r\n</submenu>\r\n</menu>\r\n</menu_xml>',NULL),(2,'2012-11-28','active','iMarketing','imarketing','application','','1','','1','','1','1',2,'imark_mailings,imark_templates,lib_pictures,lib_files,ent_contacts,sys_groups','','imark_mailings','',''),(3,'2019-07-10','active','Gestor de continguts','db','application','','2','','1','1','0','1',4,'','','cat_productes','<menu_xml>\r\n<menu>\r\n<title>_KMS_SITES_CMS</title>\r\n<submenu>\r\n   <title>Productes</title>\r\n   <action>/?app=db&mod=cat_productes&v2=*</action>\r\n   <mod>cat_productes</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>Autors</title>\r\n   <action>/?app=db&mod=cat_autors&v2=*</action>\r\n   <mod>cat_autors</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>Comandes</title>\r\n   <action>/?app=db&mod=cat_comandes&v2=*</action>\r\n   <mod>cat_comandes</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>Clients</title>\r\n   <action>/?app=db&mod=cat_clients&v2=*</action>\r\n   <mod>cat_clients</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_SITES_LANG</title>\r\n   <action>/?app=db&mod=sites_lang&v2=*</action>\r\n   <mod>sites_lang</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_SITES_PAGES</title>\r\n   <action>/?app=db&mod=sites_pages&v2=*</action>\r\n   <mod>sites_pages</mod>\r\n</submenu>\r\n</menu>\r\n  <menu>\r\n<title>_KMS_TY_LIBRARY</title>\r\n<submenu>\r\n   <title>_KMS_TY_LIB_PICTURES</title>\r\n   <action>/?app=db&mod=lib_pictures&v2=*</action>\r\n   <mod>lib_pictures</mod>\r\n</submenu>\r\n<submenu>\r\n   <title>_KMS_TY_LIB_FILES</title>\r\n   <action>/?app=db&mod=lib_files&v2=*</action>\r\n   <mod>lib_files</mod>\r\n</submenu>\r\n</menu>\r\n</menu_xml>',NULL),(4,'2019-07-10','inactive','Ecommerce','ecom','application','','1','','1','0','1','1',6,'ecom_products,ent_clients,ecom_sales,ecom_invoices,ecom_tpv_transactions,ecom_delivery_costs,ecom_payment_methods,ecom_tpv','','',NULL,'Això ania dins de Preferencies > Ecommerce'),(5,'2019-07-10','active','Preferences','pref','application','','1','','1','0','1','1',9,'sys_users,sys_groups,sites_countries,sys_views,sys_sessions,sys_extranet,sys_apps,sys_mod,ecom,ecom_tpv,ecom_payment_methods,sys_lang,sys_interfaces','','',NULL,'Crear categories');
/*!40000 ALTER TABLE `kms_sys_apps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_bookmarks`
--

DROP TABLE IF EXISTS `kms_sys_bookmarks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_bookmarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '',
  `userid` int(11) NOT NULL,
  `description` varchar(40) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `interface` varchar(40) NOT NULL DEFAULT '',
  `sort_order` int(11) DEFAULT NULL,
  `application` varchar(255) NOT NULL,
  `notes` text,
  `parent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_bookmarks`
--

LOCK TABLES `kms_sys_bookmarks` WRITE;
/*!40000 ALTER TABLE `kms_sys_bookmarks` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_bookmarks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_conf`
--

DROP TABLE IF EXISTS `kms_sys_conf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `value` text NOT NULL,
  `rule` varchar(255) DEFAULT NULL,
  `def_value` varchar(255) DEFAULT NULL,
  `family` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_conf`
--

LOCK TABLES `kms_sys_conf` WRITE;
/*!40000 ALTER TABLE `kms_sys_conf` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_conf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_cronjobs`
--

DROP TABLE IF EXISTS `kms_sys_cronjobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_cronjobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creation_date` date DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0',
  `time` varchar(300) DEFAULT NULL,
  `job` varchar(300) DEFAULT NULL,
  `jobParams` varchar(300) DEFAULT NULL,
  `notifyParams` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_cronjobs`
--

LOCK TABLES `kms_sys_cronjobs` WRITE;
/*!40000 ALTER TABLE `kms_sys_cronjobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_cronjobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_extranet`
--

DROP TABLE IF EXISTS `kms_sys_extranet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_extranet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '1',
  `domain` varchar(100) NOT NULL DEFAULT '',
  `default_lang` varchar(40) NOT NULL DEFAULT '',
  `admin_username` varchar(20) NOT NULL DEFAULT '',
  `admin_password` varchar(10) NOT NULL DEFAULT '',
  `admin_email` varchar(100) NOT NULL,
  `theme` varchar(100) NOT NULL DEFAULT '',
  `style` varchar(30) NOT NULL,
  `logo` varchar(100) NOT NULL DEFAULT '',
  `bg_image` varchar(100) NOT NULL,
  `text_color` varchar(7) NOT NULL DEFAULT '666',
  `autorun_app` varchar(45) DEFAULT NULL,
  `header_style` varchar(30) NOT NULL,
  `client_color1` varchar(7) NOT NULL,
  `client_color2` varchar(7) NOT NULL,
  `client_color3` varchar(7) NOT NULL,
  `client_color4` varchar(7) NOT NULL,
  `client_color_schema` varchar(30) NOT NULL,
  `debug_mode` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_extranet`
--

LOCK TABLES `kms_sys_extranet` WRITE;
/*!40000 ALTER TABLE `kms_sys_extranet` DISABLE KEYS */;
INSERT INTO `kms_sys_extranet` VALUES (1,'2019-07-10','1','marbotediciones.com','ca','admin','dj9fvMBa29','sistemes@intergrid.cat','extranet','aqua','','clear','666',NULL,'classic','333333','','','','',0);
/*!40000 ALTER TABLE `kms_sys_extranet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_folders`
--

DROP TABLE IF EXISTS `kms_sys_folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deleted` varchar(100) NOT NULL DEFAULT '',
  `parent` int(11) NOT NULL DEFAULT '0',
  `shortcut_to` int(11) NOT NULL DEFAULT '0',
  `external_url` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `owner` varchar(100) NOT NULL DEFAULT '',
  `group` varchar(100) NOT NULL,
  `permisions` varchar(100) NOT NULL DEFAULT '60',
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `content_type` varchar(100) NOT NULL DEFAULT '',
  `default_view` varchar(100) NOT NULL,
  `show_as` varchar(30) NOT NULL,
  `custom_icon` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_folders`
--

LOCK TABLES `kms_sys_folders` WRITE;
/*!40000 ALTER TABLE `kms_sys_folders` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_groups`
--

DROP TABLE IF EXISTS `kms_sys_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `sql` varchar(500) DEFAULT NULL,
  `creation_date` date NOT NULL,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_groups`
--

LOCK TABLES `kms_sys_groups` WRITE;
/*!40000 ALTER TABLE `kms_sys_groups` DISABLE KEYS */;
INSERT INTO `kms_sys_groups` VALUES (1,'_KMS_GROUPS_ADMIN','','2019-07-10','sys_users'),(2,'_KMS_GROUPS_EDITORS','','2019-07-10','sys_users'),(3,'_KMS_TY_CONTACTS','','2019-07-10','ent_contacts');
/*!40000 ALTER TABLE `kms_sys_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_interfaces`
--

DROP TABLE IF EXISTS `kms_sys_interfaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_interfaces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `interface_app` varchar(40) NOT NULL,
  `interface_mod` varchar(40) NOT NULL,
  `action` varchar(40) NOT NULL DEFAULT '',
  `type` varchar(10) NOT NULL,
  `definition` text NOT NULL,
  `visible` varchar(1) NOT NULL DEFAULT '1',
  `default` varchar(1) NOT NULL DEFAULT '1',
  `owner` varchar(40) NOT NULL DEFAULT '',
  `group` varchar(40) NOT NULL DEFAULT '',
  `show_tags` varchar(1) NOT NULL DEFAULT '1',
  `show_views` varchar(1) NOT NULL DEFAULT '1',
  `sort_order` int(11) DEFAULT NULL,
  `allowed_tagtypes` varchar(255) NOT NULL,
  `default_view` varchar(100) NOT NULL DEFAULT '',
  `notes` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_interfaces`
--

LOCK TABLES `kms_sys_interfaces` WRITE;
/*!40000 ALTER TABLE `kms_sys_interfaces` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_interfaces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_lang`
--

DROP TABLE IF EXISTS `kms_sys_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `const` varchar(255) NOT NULL,
  `ca` text,
  `es` text,
  `en` text,
  `eu` text,
  `de` text,
  `fr` text,
  `it` text,
  `pt` text,
  `oc` text,
  `type` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `const` (`const`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_lang`
--

LOCK TABLES `kms_sys_lang` WRITE;
/*!40000 ALTER TABLE `kms_sys_lang` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_languages`
--

DROP TABLE IF EXISTS `kms_sys_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `code` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_languages`
--

LOCK TABLES `kms_sys_languages` WRITE;
/*!40000 ALTER TABLE `kms_sys_languages` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_mod`
--

DROP TABLE IF EXISTS `kms_sys_mod`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_mod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `status` varchar(100) NOT NULL DEFAULT '',
  `parent` int(11) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `orderby` varchar(20) NOT NULL,
  `sortdir` varchar(45) DEFAULT NULL,
  `page_rows` int(11) DEFAULT '100',
  `can_add` int(1) DEFAULT NULL,
  `can_delete` int(1) DEFAULT NULL,
  `can_edit` int(1) DEFAULT NULL,
  `can_duplicate` int(1) DEFAULT NULL,
  `can_import` int(1) DEFAULT NULL,
  `can_export` int(1) DEFAULT NULL,
  `perm` varchar(20) NOT NULL,
  `main_field` varchar(80) DEFAULT NULL,
  `show_fields` varchar(150) DEFAULT NULL,
  `show_tags` varchar(45) DEFAULT NULL,
  `show_views` varchar(45) DEFAULT NULL,
  `default_view` varchar(45) DEFAULT NULL,
  `allowed_tagtypes` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `class` varchar(150) DEFAULT NULL,
  `style` varchar(150) DEFAULT NULL,
  `clearfix` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_mod`
--

LOCK TABLES `kms_sys_mod` WRITE;
/*!40000 ALTER TABLE `kms_sys_mod` DISABLE KEYS */;
INSERT INTO `kms_sys_mod` VALUES (1,'2019-07-10','active',NULL,'cat','productes','Productes','creation_date','desc',100,1,1,1,1,0,0,'',NULL,'id,status,creation_date,picture,title,autor_id,category,idioma,preu',NULL,NULL,NULL,NULL,'',NULL,NULL,NULL),(2,'2019-07-10','active',NULL,'cat','autors','Autors','id','desc',100,1,1,1,1,0,0,'','','id,status,name,picture,creation_date','','','','',' ','','',NULL),(3,'2020-02-04','active',0,'cat','clients','Clients','id','desc',100,1,1,1,0,0,0,'','','id,creation_date,name,email,phone,location,idioma,country','','','','','','','',0),(4,'2020-02-04','active',0,'cat','sales','Vendes','id','desc',100,1,1,1,0,0,0,'','','id,customer,creation_date,item,price,quantity,subtotal,ipaddress,vr_manage','','','','','','','',0),(5,'2020-02-04','active',0,'cat','comandes','Comandes','id','desc',100,1,1,1,0,0,0,'','','id,creation_date,status,payment_method,vr_customer,vr_country,base,iva,shipping,total,vr_manage,ipaddress','','','','','','','',0);
/*!40000 ALTER TABLE `kms_sys_mod` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_mod_actions`
--

DROP TABLE IF EXISTS `kms_sys_mod_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_mod_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_id` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `order_num` int(11) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `params` varchar(255) DEFAULT NULL,
  `target` varchar(45) DEFAULT NULL,
  `checkFunction` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_mod_actions`
--

LOCK TABLES `kms_sys_mod_actions` WRITE;
/*!40000 ALTER TABLE `kms_sys_mod_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_mod_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_mod_attributes`
--

DROP TABLE IF EXISTS `kms_sys_mod_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_mod_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_id` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `size` varchar(11) DEFAULT NULL,
  `class` varchar(150) DEFAULT NULL,
  `style` varchar(150) DEFAULT NULL,
  `defvalue` varchar(45) DEFAULT NULL,
  `required` int(1) DEFAULT NULL,
  `readonly` int(1) DEFAULT NULL,
  `editable` int(1) DEFAULT NULL,
  `hidden` int(1) DEFAULT NULL,
  `humanize` varchar(80) DEFAULT NULL,
  `rule` varchar(255) DEFAULT NULL,
  `events` text,
  `options` text,
  `rel_table` varchar(45) DEFAULT NULL,
  `rel_field` varchar(45) DEFAULT NULL,
  `rel_field_show` varchar(45) DEFAULT NULL,
  `rel_orderby` varchar(45) DEFAULT NULL,
  `max_col_size` varchar(45) DEFAULT NULL,
  `sort_order` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_mod_attributes`
--

LOCK TABLES `kms_sys_mod_attributes` WRITE;
/*!40000 ALTER TABLE `kms_sys_mod_attributes` DISABLE KEYS */;
INSERT INTO `kms_sys_mod_attributes` VALUES (1,1,'status','openlist',NULL,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(2,1,'creation_date','datetime',NULL,NULL,NULL,NULL,0,0,0,0,'Data de publicació',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(3,1,'picture','image',NULL,NULL,NULL,NULL,0,0,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3),(8,1,'isbn','textfield',NULL,NULL,NULL,NULL,0,0,0,0,'ISBN',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,11),(9,1,'pages','textfield',NULL,NULL,NULL,NULL,0,0,NULL,0,'Pàgines',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12),(10,1,'format','textfield',NULL,NULL,NULL,NULL,0,0,NULL,0,'Format',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,14),(11,1,'disseny','textfield',NULL,NULL,NULL,NULL,0,0,NULL,0,'Disseny col·leció',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,16),(12,1,'preu','textfield',NULL,NULL,NULL,NULL,0,0,NULL,0,'Preu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13),(13,NULL,'creation_date','datetime',NULL,'productes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(14,NULL,'status','openlist',NULL,'productes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(16,1,'translation','textfield','','','','',0,0,0,0,'Traducció de','','','','','','','','',17),(18,1,'original_title','textfield','','','','',0,0,0,0,'Títol original','','','','','','','','',18),(28,1,'subtitle','textfield','','','','',0,0,0,0,'Subtítol','','','','','','','','',9),(29,1,'title','textfield','','','','',0,0,0,0,'Títol','','','','','','','','',4),(30,1,'description','richtext','','','','',0,0,0,0,'Descripció','','','','','','','','',10),(31,1,'idioma','openlist','','','','',0,0,0,0,'Idioma','','','','','','','','',5),(33,NULL,'creation_date','datetime',NULL,'autors',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(34,NULL,'status','openlist',NULL,'autors',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(38,2,'name','textfield','','','','',0,0,0,0,'Nom','','','','','','','','',0),(39,2,'picture','image','','','','',0,0,0,0,'Foto','','','','','','','','',0),(40,2,'bio','richtext','','','','',0,0,0,0,'Biografia','','','','','','','','',0),(41,1,'autor_id','relation','','','','',0,0,0,0,'Autor','','','','kms_cat_autors','id','name','','',6),(42,1,'category','openlist','','','','',0,0,0,0,'Categoria','','','','','','','','',8),(43,1,'autor2_id','relation','','','','',0,0,0,0,'Autor 2','','','','kms_cat_autors','id','name','','',7),(44,1,'illustracio','textfield','','','','',0,0,0,0,'Il·lustració','','','','','','','','',14),(45,1,'coberta','textfield','','','','',0,0,0,0,'Disseny de coberta','','','','','','','','',14),(46,NULL,'creation_date','datetime',NULL,'clients',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(47,NULL,'status','openlist',NULL,'clients',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(48,3,'name','textfield','','','','',1,0,0,0,'Nom i cognoms','','','','','','','','',0),(49,3,'email','textfield','','','','',1,0,0,0,'Email','','','','','','','','',0),(51,3,'location','textfield','','','','',1,0,0,0,'Població','','','','','','','','',0),(52,3,'postalcode','textfield','','','','',1,0,0,0,'Codi Postal','','','','','','','','',0),(53,3,'country','textfield','','','','',1,0,0,0,'País','','','','','','','','',0),(54,3,'phone','textfield','','','','',1,0,0,0,'Telèfon de contacte','','','','','','','','',0),(55,3,'comments','text','','','','',1,0,0,0,'Comentaris','','','','','','','','',0),(56,NULL,'creation_date','datetime',NULL,'sales',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(57,NULL,'status','openlist',NULL,'sales',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(58,4,'customer','relation','','','','',0,0,0,0,'Client','','','','kms_cat_clients','id','name','','',0),(60,4,'item','relation','','','','',0,0,0,0,'Article','','','','kms_cat_productes','id','title','','',0),(61,4,'quantity','integer','','','','',0,0,0,0,'Quantitat','','','','','','','','',0),(62,4,'price','textfield','','','','',0,0,0,0,'Preu/unitat','','','','','','','','',0),(64,4,'ipaddress','textfield','','','','',0,0,0,0,'IP client','','','','','','','','',0),(65,4,'operation','relation','','','','',0,0,0,0,'Comanda','','','','kms_cat_comandes','id','id','','',0),(66,NULL,'creation_date','datetime',NULL,'comandes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(67,NULL,'status','openlist',NULL,'comandes',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0),(68,5,'status','openlist','','','','',0,0,0,0,'','','','','','','','','',0),(69,5,'customer','relation','','','','',0,0,0,0,'Client','','','','kms_cat_clients','id','name','','',1),(70,5,'total','textfield','','','','',0,0,0,0,'Total','','','','','','','','',6),(71,5,'ipaddress','textfield','','','','',0,0,0,0,'Adreça IP','','','','','','','','',2),(72,3,'address','textfield','','','','',1,0,0,0,'Adreça','','','','','','','','',0),(73,1,'link','textfield','','','','',0,0,0,0,'Enllaç més informació','','','','','','','','',18),(74,5,'shipping','textfield','','','','',0,0,0,0,'Despeses d\'enviament','','','','','','','','',5),(75,5,'iva','textfield','','','','',0,0,0,0,'IVA 4%','','','','','','','','',4),(76,5,'base','textfield','','','','',0,0,0,0,'Base imposable','','','','','','','','',3),(77,4,'creation_date','date','','','','',0,0,0,0,'Data de compra','','','','kms_cat_clients','id','name','','',0),(78,5,'creation_date','datetime','','','','',0,0,0,0,'Data de la comanda','','','','','','','','',0),(79,3,'idioma','textfield','','','','',1,0,0,0,'Idioma','','','','','','','','',0),(80,5,'payment_date','datetime','','','','',0,1,0,0,'Data i hora de pagament','','','','','','','','',0),(81,5,'payment_method','textfield','','','','',0,0,0,0,'Mètode de pagament','','','','','','','','',0),(82,5,'payment_id','textfield','','','','',0,1,0,0,'ID de pagament','','','','','','','','',0),(83,5,'description','textfield','','','','',0,1,0,0,'Descripció','','','','','','','','',0),(85,5,'card_country','textfield','','','','',0,0,0,0,'País de la targeta','','','','','','','','',0),(86,5,'currency','textfield','','','','',0,0,0,0,'Moneda','','','','','','','','',0),(87,5,'amount_paid','textfield','','','','',0,0,0,0,'Import pagat','','','','','','','','',6),(88,5,'payment_intent','textfield','','','','',0,1,0,0,'Detall pagament','','','','','','','','',0),(89,5,'full_response','text','','','','',0,1,0,0,'Resposta completa','','','','','','','','',0),(90,4,'subtotal','textfield','','','','',0,0,0,0,'Subtotal','','','','','','','','',0);
/*!40000 ALTER TABLE `kms_sys_mod_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_nmem`
--

DROP TABLE IF EXISTS `kms_sys_nmem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_nmem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` datetime NOT NULL,
  `u` int(11) NOT NULL DEFAULT '1' COMMENT 'user_id',
  `type` varchar(100) NOT NULL,
  `o` varchar(100) NOT NULL COMMENT 'related objects',
  `que` varchar(100) NOT NULL,
  `pq` varchar(100) NOT NULL,
  `com` varchar(100) NOT NULL,
  `quan` varchar(100) NOT NULL,
  `quant` varchar(100) NOT NULL,
  `amb_qui` varchar(100) NOT NULL,
  `per_a_qui` varchar(100) NOT NULL,
  `de_que` varchar(100) NOT NULL,
  `temps` varchar(100) NOT NULL,
  `qui` varchar(100) NOT NULL,
  `a on` varchar(100) NOT NULL,
  `per a qui` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_nmem`
--

LOCK TABLES `kms_sys_nmem` WRITE;
/*!40000 ALTER TABLE `kms_sys_nmem` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_nmem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_reports`
--

DROP TABLE IF EXISTS `kms_sys_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_reports` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `status` varchar(100) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `report` varchar(100) NOT NULL,
  `template` int(11) NOT NULL,
  `params` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL DEFAULT '',
  `sendreport` varchar(255) NOT NULL DEFAULT '',
  `sendreport_email` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_reports`
--

LOCK TABLES `kms_sys_reports` WRITE;
/*!40000 ALTER TABLE `kms_sys_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_sessions`
--

DROP TABLE IF EXISTS `kms_sys_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_sessions` (
  `action` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `ip_address` varchar(15) CHARACTER SET ascii NOT NULL DEFAULT '',
  `datetime` datetime NOT NULL,
  `sess_id` varchar(100) DEFAULT '',
  `type` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_sessions`
--

/*!40000 ALTER TABLE `kms_sys_sessions` DISABLE KEYS */;
INSERT INTO `kms_sys_sessions` VALUES ('','admin','81.0.57.125','2019-07-10 12:07:24','','login'),('','admin','81.0.57.125','2019-07-10 12:07:24','','b'),('','admin','81.0.57.125','2019-07-10 12:07:32','','login'),('','admin','81.0.57.125','2019-07-10 12:07:32','','b'),('','admin','81.0.57.125','2019-07-10 12:07:41','','b'),('app=db&menu=1','admin','81.0.57.125','2019-07-10 12:07:50','','b'),('app=db&mod=cat_catalog&app=db&menu=1','admin','81.0.57.125','2019-07-10 12:07:58','','b'),('','admin','81.0.57.125','2019-07-10 12:07:24','','b'),('app=pref&menu=1','admin','81.0.57.125','2019-07-10 12:07:30','','b'),('app=pref&mod=sys_mod&menu=1&view=','admin','81.0.57.125','2019-07-10 12:07:37','','b'),('app=pref&mod=sys_mod&_=i','admin','81.0.57.125','2019-07-10 12:07:50','','i'),('app=pref&mod=sys_mod&_=e&id=','admin','81.0.57.125','2019-07-10 12:07:37','','e'),('app=pref&mod=sys_mod&_=e&id=','admin','81.0.57.125','2019-07-10 12:07:54','','e'),('','admin','81.0.57.125','2019-07-10 12:07:04','','b'),('app=pref&menu=1','admin','81.0.57.125','2019-07-10 12:07:13','','b'),('app=pref&mod=sys_mod&menu=1&view=','admin','81.0.57.125','2019-07-10 12:07:23','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','admin','81.0.57.125','2019-07-10 12:07:30','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','admin','81.0.57.125','2019-07-10 12:07:31','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=i','admin','81.0.57.125','2019-07-10 12:07:39','','i'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=','admin','81.0.57.125','2019-07-10 12:07:57','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=&_=b','admin','81.0.57.125','2019-07-10 12:07:04','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=1&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:12','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=1','admin','81.0.57.125','2019-07-10 12:07:26','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=1&_=b','admin','81.0.57.125','2019-07-10 12:07:35','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=2&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:53','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=2','admin','81.0.57.125','2019-07-10 12:07:10','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=2&_=b','admin','81.0.57.125','2019-07-10 12:07:22','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=3&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:27','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=3','admin','81.0.57.125','2019-07-10 12:07:06','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=3&_=b','admin','81.0.57.125','2019-07-10 12:07:13','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:29','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4','admin','81.0.57.125','2019-07-10 12:07:42','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4&_=b','admin','81.0.57.125','2019-07-10 12:07:57','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:05','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','admin','81.0.57.125','2019-07-10 12:07:17','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_=b','admin','81.0.57.125','2019-07-10 12:07:23','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=6&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:28','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=6','admin','81.0.57.125','2019-07-10 12:07:56','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=6&_=b','admin','81.0.57.125','2019-07-10 12:07:04','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=7&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:14','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=7','admin','81.0.57.125','2019-07-10 12:07:30','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=7&_=b','admin','81.0.57.125','2019-07-10 12:07:38','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=8&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:46','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=8','admin','81.0.57.125','2019-07-10 12:07:57','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=8&_=b','admin','81.0.57.125','2019-07-10 12:07:10','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=9&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:19','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=9','admin','81.0.57.125','2019-07-10 12:07:36','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=9&_=b','admin','81.0.57.125','2019-07-10 12:07:40','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=10&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:05','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=10','admin','81.0.57.125','2019-07-10 12:07:25','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=10&_=b','admin','81.0.57.125','2019-07-10 12:07:37','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=11&_action=Duplicate','admin','81.0.57.125','2019-07-10 12:07:45','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=11','admin','81.0.57.125','2019-07-10 12:07:09','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=11&_=b','admin','81.0.57.125','2019-07-10 12:07:45','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','admin','81.0.57.125','2019-07-10 12:07:58','','b'),('app=pref&mod=sys_mod&_=i','admin','81.0.57.125','2019-07-10 12:07:04','','i'),('app=pref&mod=sys_mod&_=e&id=','admin','81.0.57.125','2019-07-10 12:07:22','','e'),('app=pref&mod=sys_mod&_=i','admin','81.0.57.125','2019-07-10 12:07:37','','i'),('app=pref&mod=sys_mod&_=e&id=','admin','81.0.57.125','2019-07-10 12:07:33','','e'),('app=pref&mod=sys_mod&_=b','admin','81.0.57.125','2019-07-10 12:07:34','','b'),('app=pref&mod=sys_mod&_=e&id=1','admin','81.0.57.125','2019-07-10 12:07:12','','e'),('app=pref&mod=sys_mod&_=e&id=1','admin','81.0.57.125','2019-07-10 12:07:22','','e'),('app=pref&mod=sys_mod&_=b','admin','81.0.57.125','2019-07-10 12:07:26','','b'),('app=pref&mod=sys_mod&_=e&id=2','admin','81.0.57.125','2019-07-10 12:07:31','','e'),('app=pref&mod=sys_mod&_=e&id=2','admin','81.0.57.125','2019-07-10 12:07:38','','e'),('app=pref&mod=sys_mod&_=b','admin','81.0.57.125','2019-07-10 12:07:42','','b'),('app=pref&mod=sys_mod&_=e&id=2&_action=delete_confirm','admin','81.0.57.125','2019-07-10 12:07:49','','e'),('app=pref&mod=sys_mod&_=e&id=2','admin','81.0.57.125','2019-07-10 12:07:54','','e'),('app=pref&mod=sys_mod&_=b','admin','81.0.57.125','2019-07-10 13:07:00','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','admin','81.0.57.125','2019-07-10 13:07:09','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','admin','81.0.57.125','2019-07-10 13:07:10','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=12&_action=Duplicate','admin','81.0.57.125','2019-07-10 13:07:35','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=12','admin','81.0.57.125','2019-07-10 13:07:42','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=12&_=b','admin','81.0.57.125','2019-07-10 13:07:48','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=15&_action=delete_confirm','admin','81.0.57.125','2019-07-10 13:07:55','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=15','admin','81.0.57.125','2019-07-10 13:07:01','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','admin','81.0.57.125','2019-07-10 13:07:08','','b'),('','admin','81.0.57.125','2019-07-10 13:07:23','','b'),('app=pref&menu=1','admin','81.0.57.125','2019-07-10 13:07:27','','b'),('app=pref&mod=sys_mod&menu=1&view=','admin','81.0.57.125','2019-07-10 13:07:48','','b'),('app=pref&mod=sys_mod&_=e&id=1','admin','81.0.57.125','2019-07-10 13:07:52','','e'),('_=b&app=pref&mod=sys_mod&menu=1&view=','admin','81.0.57.125','2019-07-10 13:07:07','','b'),('_=b&app=pref&mod=sys_apps&menu=1&view=','admin','81.0.57.125','2019-07-10 13:07:11','','b'),('app=pref&mod=sys_apps&_=e&id=3','admin','81.0.57.125','2019-07-10 13:07:15','','e'),('app=pref&mod=sys_apps&_=e&id=3','admin','81.0.57.125','2019-07-10 13:07:08','','e'),('app=pref&mod=sys_apps&_=b','admin','81.0.57.125','2019-07-10 13:07:09','','b'),('','admin','81.0.57.125','2019-07-10 13:07:14','','b'),('','admin','81.0.57.125','2019-07-10 13:07:31','','b'),('app=db&menu=1','admin','81.0.57.125','2019-07-10 13:07:38','','b'),('app=db&mod=cat_catalog&app=db&menu=1','admin','81.0.57.125','2019-07-10 13:07:47','','b'),('','admin','81.0.57.125','2019-07-10 13:07:15','','b'),('app=pref&menu=1','admin','81.0.57.125','2019-07-10 13:07:22','','b'),('app=pref&mod=sys_mod&menu=1&view=','admin','81.0.57.125','2019-07-10 13:07:31','','b'),('_=b&app=pref&mod=sys_apps&menu=1&view=','admin','81.0.57.125','2019-07-10 13:07:37','','b'),('app=pref&mod=sys_apps&_=e&id=3','admin','81.0.57.125','2019-07-10 13:07:43','','e'),('app=pref&mod=sys_apps&_=e&id=3','admin','81.0.57.125','2019-07-10 13:07:16','','e'),('app=pref&mod=sys_apps&_=b','admin','81.0.57.125','2019-07-10 13:07:20','','b'),('app=db&mod=cat_catalog&app=db&menu=1','admin','81.0.57.125','2019-07-10 13:07:27','','b'),('app=db&mod=cats_productes','admin','81.0.57.125','2019-07-10 13:07:34','','b'),('app=pref&mod=sys_apps&_=e&id=3','admin','81.0.57.125','2019-07-10 13:07:47','','e'),('app=pref&mod=sys_apps&_=e&id=3','admin','81.0.57.125','2019-07-10 13:07:02','','e'),('app=pref&mod=sys_apps&_=b','admin','81.0.57.125','2019-07-10 13:07:04','','b'),('','admin','81.0.57.125','2019-07-10 13:07:05','','b'),('app=db&menu=1','admin','81.0.57.125','2019-07-10 13:07:15','','b'),('app=db&mod=cat_productes&app=db&menu=1','admin','81.0.57.125','2019-07-10 13:07:19','','b'),('app=db&mod=cat_productes&_=i','admin','81.0.57.125','2019-07-10 13:07:33','','i'),('app=db&mod=cat_productes&_=e&id=','admin','81.0.57.125','2019-07-10 13:07:40','','e'),('app=db&mod=cat_productes&_=b','admin','81.0.57.125','2019-07-10 13:07:41','','b'),('app=db&mod=cat_productes&_=b','admin','81.0.57.125','2019-07-10 13:07:25','','b'),('app=db&mod=cat_productes&_=b','admin','81.0.57.125','2019-07-10 13:07:33','','b'),('app=db&mod=cat_productes&_=b','admin','81.0.57.125','2019-07-10 13:07:40','','b'),('app=db&mod=cat_productes&_=b','admin','81.0.57.125','2019-07-10 13:07:53','','b'),('','admin','81.0.57.125','2019-07-10 13:07:01','','b'),('app=db&menu=1','admin','81.0.57.125','2019-07-10 13:07:11','','b'),('app=db&mod=cat_productes&app=db&menu=1','admin','81.0.57.125','2019-07-10 13:07:16','','b'),('','admin','81.0.57.125','2019-07-10 13:07:25','','b'),('app=pref&menu=1','admin','81.0.57.125','2019-07-10 13:07:32','','b'),('app=pref&mod=sys_mod&menu=1&view=','admin','81.0.57.125','2019-07-10 13:07:40','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','admin','81.0.57.125','2019-07-10 13:07:38','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','admin','81.0.57.125','2019-07-10 13:07:38','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4','admin','81.0.57.125','2019-07-10 13:07:46','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4','admin','81.0.57.125','2019-07-10 13:07:58','','e'),('','admin','81.0.57.125','2019-07-10 13:07:18','','login'),('','admin','81.0.57.125','2019-07-10 13:07:18','','b'),('app=db&menu=1','admin','81.0.57.125','2019-07-10 13:07:25','','b'),('app=pref&menu=1','admin','81.0.57.125','2019-07-10 13:07:31','','b'),('_=b&app=pref&mod=ecom&menu=1&view=','admin','81.0.57.125','2019-07-10 13:07:39','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','admin','81.0.57.125','2019-07-10 13:07:41','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','admin','81.0.57.125','2019-07-10 13:07:48','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','admin','81.0.57.125','2019-07-10 13:07:48','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4','admin','81.0.57.125','2019-07-10 13:07:57','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4','admin','81.0.57.125','2019-07-10 13:07:20','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','admin','81.0.57.125','2019-07-10 13:07:20','','b'),('','admin','81.0.57.125','2019-07-10 13:07:28','','b'),('app=db&menu=1','admin','81.0.57.125','2019-07-10 13:07:36','','b'),('app=db&mod=cat_productes&app=db&menu=1','admin','81.0.57.125','2019-07-10 13:07:44','','b'),('app=db&mod=cat_productes&_=e&id=1','admin','81.0.57.125','2019-07-10 13:07:48','','e'),('app=db&mod=cat_productes&_=e&id=1','admin','81.0.57.125','2019-07-10 13:07:25','','e'),('app=db&mod=cat_productes&_=e&id=1','admin','81.0.57.125','2019-07-10 13:07:37','','e'),('app=db&mod=cat_productes&_=b','admin','81.0.57.125','2019-07-10 13:07:37','','b'),('app=pref&menu=1','admin','81.0.57.125','2019-07-10 13:07:50','','b'),('app=pref&mod=sys_mod&menu=1&view=','admin','81.0.57.125','2019-07-10 13:07:03','','b'),('app=pref&mod=sys_mod&_=e&id=1&_action=Duplicate','admin','81.0.57.125','2019-07-10 13:07:07','','e'),('app=pref&mod=sys_mod&_=e&id=1','admin','81.0.57.125','2019-07-10 13:07:26','','e'),('app=pref&mod=sys_mod&_=e&id=1&_action=Duplicate','admin','81.0.57.125','2019-07-10 13:07:43','','e'),('app=pref&mod=sys_mod&_=e&id=1','admin','81.0.57.125','2019-07-10 13:07:15','','e'),('','admin','81.0.57.125','2019-07-15 09:07:35','','login'),('','admin','81.0.57.125','2019-07-15 09:07:36','','b'),('app=db&menu=1','admin','81.0.57.125','2019-07-15 09:07:53','','b'),('app=db&mod=cat_productes&app=db&menu=1','admin','81.0.57.125','2019-07-15 09:07:01','','b'),('app=db&mod=sites_pages','admin','81.0.57.125','2019-07-15 10:07:10','','b'),('app=db&mod=cat_productes','admin','81.0.57.125','2019-07-15 10:07:30','','b'),('','root','81.0.57.125','2019-12-16 12:12:14','','login'),('','root','81.0.57.125','2019-12-16 12:12:14','','b'),('app=db&menu=1','root','81.0.57.125','2019-12-16 12:12:22','','b'),('app=db&mod=cat_productes&app=db&menu=1','root','81.0.57.125','2019-12-16 12:12:25','','b'),('app=db&mod=cat_productes&_=e&id=1&_action=Duplicate','root','81.0.57.125','2019-12-16 12:12:42','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2019-12-16 12:12:14','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2019-12-16 12:12:32','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2019-12-16 12:12:43','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2019-12-16 13:12:06','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2019-12-16 13:12:29','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2019-12-16 13:12:54','','e'),('','root','81.0.57.125','2019-12-16 17:12:47','','login'),('','root','81.0.57.125','2019-12-16 17:12:47','','b'),('app=db&menu=1','root','81.0.57.125','2019-12-16 17:12:51','','b'),('app=db&mod=cat_productes&app=db&menu=1','root','81.0.57.125','2019-12-16 17:12:53','','b'),('app=db&mod=cat_productes&_=i','root','81.0.57.125','2019-12-16 17:12:59','','i'),('app=db&mod=cat_productes&_=e&id=','root','81.0.57.125','2019-12-16 17:12:05','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2019-12-16 17:12:05','','b'),('','root','81.0.57.125','2020-02-03 16:02:32','','login'),('','root','81.0.57.125','2020-02-03 16:02:33','','b'),('','root','81.0.57.125','2020-02-03 16:02:35','','login'),('','root','81.0.57.125','2020-02-03 16:02:35','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 16:02:40','','b'),('app=db&mod=cat_productes&app=db&menu=1','root','81.0.57.125','2020-02-03 16:02:43','','b'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 16:02:00','','e'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 16:02:49','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:49','','b'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 16:02:21','','e'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 16:02:42','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:43','','b'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:55','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:11','','b'),('app=db&mod=cat_productes&_=e&id=2&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:21','','e'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 16:02:23','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:23','','b'),('app=db&mod=cat_productes&_=e&id=3&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:37','','e'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 16:02:17','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:17','','b'),('','root','81.0.57.125','2020-02-03 16:02:20','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 16:02:25','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 16:02:29','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 16:02:33','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:34','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=9','root','81.0.57.125','2020-02-03 16:02:40','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=10','root','81.0.57.125','2020-02-03 16:02:41','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=7','root','81.0.57.125','2020-02-03 16:02:44','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:46','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:49','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=9','root','81.0.57.125','2020-02-03 16:02:59','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:00','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=10','root','81.0.57.125','2020-02-03 16:02:05','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:05','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=7','root','81.0.57.125','2020-02-03 16:02:16','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:16','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:50','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:59','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:03','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:00','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:24','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:34','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:38','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:38','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:44','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:54','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:54','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:26','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:31','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:45','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:41','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:08','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:12','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:05','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=8','root','81.0.57.125','2020-02-03 16:02:11','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=8','root','81.0.57.125','2020-02-03 16:02:16','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:17','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=6','root','81.0.57.125','2020-02-03 16:02:21','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=6','root','81.0.57.125','2020-02-03 16:02:25','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:25','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=15&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:30','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=15','root','81.0.57.125','2020-02-03 16:02:44','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:44','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:56','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:06','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:31','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:32','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:37','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:40','','e'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:02','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:02','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:05','','e'),('_=b&app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-03 16:02:16','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 16:02:17','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 16:02:19','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:20','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=15&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:24','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=15','root','81.0.57.125','2020-02-03 16:02:26','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=15&_=b','root','81.0.57.125','2020-02-03 16:02:27','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=i','root','81.0.57.125','2020-02-03 16:02:29','','i'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=15&_=b','root','81.0.57.125','2020-02-03 16:02:31','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:34','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:41','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:41','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:44','','e'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:50','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:50','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:52','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:37','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:40','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:54','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:02','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:02','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:05','','e'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 16:02:31','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:50','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:06','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:06','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=19&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:12','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=19','root','81.0.57.125','2020-02-03 16:02:22','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:22','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=20&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:25','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=20','root','81.0.57.125','2020-02-03 16:02:33','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:33','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:35','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5','root','81.0.57.125','2020-02-03 16:02:45','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:45','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=19','root','81.0.57.125','2020-02-03 16:02:48','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=19','root','81.0.57.125','2020-02-03 16:02:57','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:58','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=17&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:10','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=17','root','81.0.57.125','2020-02-03 16:02:19','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:20','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=22&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:23','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=22','root','81.0.57.125','2020-02-03 16:02:32','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:32','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=23&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:35','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=23','root','81.0.57.125','2020-02-03 16:02:41','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:41','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=17&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:45','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=17','root','81.0.57.125','2020-02-03 16:02:47','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:47','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:58','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:05','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:05','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=25&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:09','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=25','root','81.0.57.125','2020-02-03 16:02:14','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:14','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=26&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:18','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=26','root','81.0.57.125','2020-02-03 16:02:25','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:25','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:33','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:35','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:35','','b'),('_=b&app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-03 16:02:39','','b'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-03 16:02:46','','e'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 16:02:53','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:56','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:02','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-03 16:02:02','','b'),('','root','81.0.57.125','2020-02-03 16:02:05','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 16:02:07','','b'),('app=db&mod=cat_productes&app=db&menu=1','root','81.0.57.125','2020-02-03 16:02:07','','b'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:12','','e'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 16:02:47','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 16:02:49','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:50','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=22&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:55','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=22','root','81.0.57.125','2020-02-03 16:02:01','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:01','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=19&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:04','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=19','root','81.0.57.125','2020-02-03 16:02:13','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:13','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=19&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:16','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=19','root','81.0.57.125','2020-02-03 16:02:18','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:18','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=22&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:21','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=22','root','81.0.57.125','2020-02-03 16:02:23','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:23','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=20&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:25','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=20','root','81.0.57.125','2020-02-03 16:02:26','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:27','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=21&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:29','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=21','root','81.0.57.125','2020-02-03 16:02:30','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:30','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=24&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:33','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=24','root','81.0.57.125','2020-02-03 16:02:34','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:34','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=23&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:37','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=23','root','81.0.57.125','2020-02-03 16:02:39','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:39','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=25&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:42','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=25','root','81.0.57.125','2020-02-03 16:02:52','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:52','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=25&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:56','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=25','root','81.0.57.125','2020-02-03 16:02:58','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:58','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=26&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:00','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=26','root','81.0.57.125','2020-02-03 16:02:02','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:03','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=27&_action=delete_confirm','root','81.0.57.125','2020-02-03 16:02:05','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=27','root','81.0.57.125','2020-02-03 16:02:06','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:06','','b'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:15','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:25','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:25','','b'),('','root','81.0.57.125','2020-02-03 16:02:27','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 16:02:30','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 16:02:32','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 16:02:34','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:35','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:37','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:43','','b'),('','root','81.0.57.125','2020-02-03 16:02:48','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 16:02:50','','b'),('app=db&mod=cat_productes&app=db&menu=1','root','81.0.57.125','2020-02-03 16:02:50','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 16:02:53','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 16:02:59','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:01','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:05','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-03 16:02:05','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 16:02:08','','b'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 16:02:11','','e'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 16:02:31','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:31','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:38','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=5&_action=Duplicate&_=b','root','81.0.57.125','2020-02-03 16:02:40','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:43','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:46','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:48','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:52','','b'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 16:02:56','','e'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 16:02:07','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:07','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:12','','e'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:21','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:21','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=11&_action=Duplicate','root','81.0.57.125','2020-02-03 16:02:25','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=11','root','81.0.57.125','2020-02-03 16:02:37','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 16:02:37','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:40','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 16:02:14','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:16','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:30','','e'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 16:02:36','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:37','','b'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 16:02:50','','e'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 16:02:02','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:02','','b'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 16:02:07','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:16','','b'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:25','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:33','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 16:02:33','','b'),('','root','81.0.57.125','2020-02-03 16:02:58','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 16:02:00','','b'),('','root','81.0.57.125','2020-02-03 16:02:02','','b'),('app=sites&menu=1','root','81.0.57.125','2020-02-03 16:02:03','','b'),('app=sites&mod=sites_pages&app=sites&menu=1','root','81.0.57.125','2020-02-03 16:02:03','','b'),('','root','81.0.57.125','2020-02-03 16:02:13','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 16:02:15','','b'),('app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-03 16:02:17','','b'),('app=pref&mod=sys_apps&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:19','','e'),('app=pref&mod=sys_apps&_=e&id=1','root','81.0.57.125','2020-02-03 16:02:53','','e'),('app=pref&mod=sys_apps&_=b','root','81.0.57.125','2020-02-03 16:02:53','','b'),('app=sites&mod=sites_pages&app=sites&menu=1','root','81.0.57.125','2020-02-03 16:02:56','','b'),('app=sites&mod=sites_menus','root','81.0.57.125','2020-02-03 16:02:59','','b'),('app=sites&mod=sites_pages','root','81.0.57.125','2020-02-03 16:02:01','','b'),('','root','81.0.57.125','2020-02-03 17:02:07','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 17:02:09','','b'),('app=db&mod=cat_productes&app=db&menu=1','root','81.0.57.125','2020-02-03 17:02:09','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 17:02:10','','b'),('','root','81.0.57.125','2020-02-03 17:02:19','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:20','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 17:02:22','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 17:02:26','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:27','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=1&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:31','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:11','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 17:02:11','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:14','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:18','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 17:02:21','','e'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:22','','e'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 17:02:23','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:23','','e'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 17:02:30','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 17:02:30','','b'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:34','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 17:02:34','','b'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 17:02:38','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 17:02:38','','b'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:42','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 17:02:42','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=31','root','81.0.57.125','2020-02-03 17:02:48','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=31','root','81.0.57.125','2020-02-03 17:02:52','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 17:02:53','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:55','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:58','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:59','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:19','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 17:02:22','','e'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 17:02:48','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 17:02:48','','b'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:57','','e'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:04','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 17:02:04','','b'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 17:02:15','','e'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 17:02:33','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 17:02:33','','b'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:41','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:46','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 17:02:46','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 17:02:48','','e'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 17:02:52','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 17:02:01','','e'),('app=db&mod=sites_pages','root','81.0.57.125','2020-02-03 17:02:31','','b'),('app=db&mod=sites_pages&_=i','root','81.0.57.125','2020-02-03 17:02:34','','i'),('app=db&mod=sites_pages&_=e&id=','root','81.0.57.125','2020-02-03 17:02:34','','e'),('app=db&mod=sites_pages&_=b','root','81.0.57.125','2020-02-03 17:02:35','','b'),('','root','81.0.57.125','2020-02-03 17:02:04','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:06','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 17:02:08','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:11','','e'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 17:02:14','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 17:02:15','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:16','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=30','root','81.0.57.125','2020-02-03 17:02:18','','e'),('app=db&mod=sites_pages&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:16','','e'),('app=db&mod=sites_pages&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:34','','e'),('app=db&mod=sites_pages&_=b','root','81.0.57.125','2020-02-03 17:02:34','','b'),('app=db&mod=sites_pages&_=e&id=1&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:45','','e'),('app=db&mod=sites_pages&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:54','','e'),('app=db&mod=sites_pages&_=b','root','81.0.57.125','2020-02-03 17:02:54','','b'),('app=db&mod=sites_pages&_=b','root','81.0.57.125','2020-02-03 17:02:28','','b'),('app=db&mod=sites_pages&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:26','','e'),('app=db&mod=sites_pages&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:46','','e'),('app=db&mod=sites_pages&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:48','','e'),('app=db&mod=sites_pages&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:35','','e'),('app=db&mod=sites_pages&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:53','','e'),('app=db&mod=sites_pages&_=b','root','81.0.57.125','2020-02-03 17:02:53','','b'),('','root','81.0.57.125','2020-02-03 17:02:07','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:09','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:13','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:11','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:12','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:37','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:39','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:51','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:53','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 17:02:58','','b'),('app=pref&mod=sys_mod&_=e&id=1&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:01','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 17:02:23','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-03 17:02:23','','b'),('_=f&id=2&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 17:02:32','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=autors&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:33','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=i','root','81.0.57.125','2020-02-03 17:02:35','','i'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=','root','81.0.57.125','2020-02-03 17:02:05','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 17:02:05','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=35&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:07','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=35','root','81.0.57.125','2020-02-03 17:02:41','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 17:02:41','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=36&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:52','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=36','root','81.0.57.125','2020-02-03 17:02:07','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 17:02:08','','b'),('','root','81.0.57.125','2020-02-03 17:02:10','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:12','','b'),('app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-03 17:02:20','','b'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:25','','e'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:45','','e'),('app=pref&mod=sys_apps&_=b','root','81.0.57.125','2020-02-03 17:02:46','','b'),('','root','81.0.57.125','2020-02-03 17:02:48','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 17:02:50','','b'),('','root','81.0.57.125','2020-02-03 17:02:53','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 17:02:55','','b'),('','root','81.0.57.125','2020-02-03 17:02:35','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 17:02:39','','b'),('','root','81.0.57.125','2020-02-03 17:02:54','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:56','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 17:02:02','','b'),('app=pref&mod=sys_mod&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:13','','e'),('app=pref&mod=sys_mod&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:19','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-03 17:02:19','','b'),('app=pref&mod=sys_mod&_=e&id=3&_action=delete_confirm','root','81.0.57.125','2020-02-03 17:02:21','','e'),('app=pref&mod=sys_mod&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:24','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-03 17:02:24','','b'),('_=b&app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-03 17:02:26','','b'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:30','','e'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:54','','e'),('app=pref&mod=sys_apps&_=b','root','81.0.57.125','2020-02-03 17:02:54','','b'),('','root','81.0.57.125','2020-02-03 17:02:57','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 17:02:59','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-03 17:02:44','','b'),('','root','81.0.57.125','2020-02-03 17:02:47','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 17:02:49','','b'),('','root','81.0.57.125','2020-02-03 17:02:52','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 17:02:54','','b'),('','root','81.0.57.125','2020-02-03 17:02:57','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 17:02:58','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-03 17:02:00','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-03 17:02:37','','b'),('','root','81.0.57.125','2020-02-03 17:02:39','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 17:02:41','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-03 17:02:45','','b'),('app=db&mod=cat_autors','root','81.0.57.125','2020-02-03 17:02:49','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:52','','i'),('','root','81.0.57.125','2020-02-03 17:02:00','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 17:02:02','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 17:02:04','','b'),('_=f&id=2&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 17:02:07','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=autors&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:08','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 17:02:12','','b'),('_=f&id=2&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 17:02:14','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=autors&queryfield=mod_id','root','81.0.57.125','2020-02-03 17:02:14','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=i','root','81.0.57.125','2020-02-03 17:02:16','','i'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=','root','81.0.57.125','2020-02-03 17:02:28','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=&_=b','root','81.0.57.125','2020-02-03 17:02:31','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=38&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:34','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=38','root','81.0.57.125','2020-02-03 17:02:42','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=38&_=b','root','81.0.57.125','2020-02-03 17:02:44','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=39&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:45','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=39','root','81.0.57.125','2020-02-03 17:02:54','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=autors&sortby=sort_order&_=e&id=39&_=b','root','81.0.57.125','2020-02-03 17:02:55','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:57','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:14','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:14','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:21','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:39','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:39','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:42','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:58','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:58','','b'),('app=db&mod=cat_autors&_=e&id=3&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:10','','e'),('app=db&mod=cat_autors&_=e&id=3','root','81.0.57.125','2020-02-03 17:02:20','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:20','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:27','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:40','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:40','','b'),('app=db&mod=cat_autors&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:51','','e'),('app=db&mod=cat_autors&_=e&id=5','root','81.0.57.125','2020-02-03 17:02:04','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:04','','b'),('app=db&mod=cat_autors&_=e&id=6&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:07','','e'),('app=db&mod=cat_autors&_=e&id=6','root','81.0.57.125','2020-02-03 17:02:26','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:26','','b'),('app=db&mod=cat_autors&_=e&id=7&_action=Duplicate','root','81.0.57.125','2020-02-03 17:02:33','','e'),('app=db&mod=cat_autors&_=e&id=7','root','81.0.57.125','2020-02-03 17:02:46','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:46','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:56','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:11','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:11','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:20','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:31','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:32','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:34','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:59','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:59','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:07','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:18','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:18','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:36','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:48','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:48','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:55','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:08','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:08','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:21','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:34','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:34','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:45','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:56','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:56','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:06','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:18','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:18','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:27','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:39','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:39','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:47','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:59','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:59','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:09','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:27','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:27','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:33','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:49','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:49','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:57','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:10','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:10','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:17','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:31','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:31','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:38','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:49','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:49','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:57','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:08','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:09','','b'),('app=db&mod=cat_autors&_=e&id=23','root','81.0.57.125','2020-02-03 17:02:14','','e'),('app=db&mod=cat_autors&_=e&id=23','root','81.0.57.125','2020-02-03 17:02:17','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:18','','b'),('app=db&mod=cat_autors&_=e&id=23','root','81.0.57.125','2020-02-03 17:02:22','','e'),('app=db&mod=cat_autors&_=e&id=23','root','81.0.57.125','2020-02-03 17:02:38','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:39','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:52','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:08','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:08','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:35','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:46','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:46','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:56','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 17:02:09','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:09','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:20','','i'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 17:02:25','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 17:02:58','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:49','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:49','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:02','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:14','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:14','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:26','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:40','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:40','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:50','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:05','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:05','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:12','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:24','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:24','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:33','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:44','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:44','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:54','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:11','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:11','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:19','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:31','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:31','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:40','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:52','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:52','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:59','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:14','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:14','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:23','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:38','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:39','','b'),('app=db&mod=cat_autors&_=i','root','81.0.57.125','2020-02-03 18:02:40','','i'),('app=db&mod=cat_autors&_=e&id=','root','81.0.57.125','2020-02-03 18:02:07','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:07','','b'),('app=db&mod=cat_autors&_=e&id=40','root','81.0.57.125','2020-02-03 18:02:10','','e'),('app=db&mod=cat_autors&_=e&id=40','root','81.0.57.125','2020-02-03 18:02:16','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:16','','b'),('app=db&mod=cat_autors&_=e&id=40','root','81.0.57.125','2020-02-03 18:02:20','','e'),('app=db&mod=cat_autors&_=e&id=40','root','81.0.57.125','2020-02-03 18:02:43','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:43','','b'),('','root','81.0.57.125','2020-02-03 18:02:40','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 18:02:42','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-03 18:02:46','','b'),('app=db&mod=cat_autors','root','81.0.57.125','2020-02-03 18:02:49','','b'),('','root','81.0.57.125','2020-02-03 18:02:46','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 18:02:47','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 18:02:50','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 18:02:56','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 18:02:57','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=1&_action=Duplicate','root','81.0.57.125','2020-02-03 18:02:05','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=1','root','81.0.57.125','2020-02-03 18:02:33','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 18:02:34','','b'),('','root','81.0.57.125','2020-02-03 18:02:37','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 18:02:38','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-03 18:02:41','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 18:02:46','','e'),('','root','81.0.57.125','2020-02-03 18:02:20','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 18:02:23','','b'),('','root','81.0.57.125','2020-02-03 18:02:27','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 18:02:28','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 18:02:34','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 18:02:38','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 18:02:38','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 18:02:40','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 18:02:50','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 18:02:53','','e'),('app=db&mod=cat_autors','root','81.0.57.125','2020-02-03 18:02:01','','b'),('app=db&mod=cat_autors&_=e&id=40&_action=Duplicate','root','81.0.57.125','2020-02-03 18:02:05','','e'),('app=db&mod=cat_autors&_=e&id=40','root','81.0.57.125','2020-02-03 18:02:39','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 18:02:39','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 18:02:45','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 18:02:50','','e'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 18:02:59','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:59','','b'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 18:02:02','','e'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 18:02:16','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:16','','b'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 18:02:24','','e'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 18:02:41','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:42','','b'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 18:02:51','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 18:02:58','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:58','','b'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=6&_action=delete_confirm','root','81.0.57.125','2020-02-03 18:02:05','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=6','root','81.0.57.125','2020-02-03 18:02:07','','e'),('app=pref&mod=sys_mod_attributes&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 18:02:08','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 18:02:37','','b'),('','root','81.0.57.125','2020-02-03 18:02:05','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 18:02:07','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 18:02:14','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 18:02:16','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 18:02:17','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=28&_action=Duplicate','root','81.0.57.125','2020-02-03 18:02:22','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=28','root','81.0.57.125','2020-02-03 18:02:33','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 18:02:33','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 18:02:36','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 18:02:42','','b'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 18:02:55','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 18:02:08','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:08','','b'),('_=b&app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-03 18:02:20','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 18:02:24','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 18:02:27','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 18:02:46','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-03 18:02:46','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:48','','b'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 18:02:57','','e'),('app=db&mod=cat_productes&_=e&id=2','root','81.0.57.125','2020-02-03 18:02:02','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:03','','b'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 18:02:05','','e'),('app=db&mod=cat_productes&_=e&id=3','root','81.0.57.125','2020-02-03 18:02:13','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:14','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 18:02:24','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 18:02:30','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-03 18:02:30','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:31','','b'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 18:02:39','','e'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 18:02:43','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:43','','b'),('app=db&mod=cat_productes&_=e&id=4&_action=Duplicate','root','81.0.57.125','2020-02-03 18:02:50','','e'),('app=db&mod=cat_productes&_=e&id=4','root','81.0.57.125','2020-02-03 18:02:16','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:16','','b'),('app=db&mod=cat_productes&_=e&id=5','root','81.0.57.125','2020-02-03 18:02:19','','e'),('app=db&mod=cat_productes&_=e&id=5','root','81.0.57.125','2020-02-03 18:02:48','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 18:02:48','','b'),('app=db&mod=cat_productes&_=e&id=5','root','81.0.57.125','2020-02-03 18:02:12','','e'),('','root','81.0.57.125','2020-02-03 20:02:48','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 20:02:52','','b'),('','root','81.0.57.125','2020-02-03 20:02:54','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 20:02:27','','b'),('','root','81.0.57.125','2020-02-03 20:02:17','','b'),('','root','81.0.57.125','2020-02-03 20:02:18','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 20:02:20','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-03 20:02:20','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 20:02:44','','b'),('app=db&mod=cat_productes&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:01','','e'),('app=db&mod=cat_productes&_=e&id=5','root','81.0.57.125','2020-02-03 20:02:36','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:36','','b'),('app=db&mod=cat_productes&_=e&id=6','root','81.0.57.125','2020-02-03 20:02:40','','e'),('app=db&mod=cat_productes&_=e&id=6','root','81.0.57.125','2020-02-03 20:02:52','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:53','','b'),('app=db&mod=cat_productes&_=e&id=6','root','81.0.57.125','2020-02-03 20:02:56','','e'),('app=db&mod=cat_productes&_=e&id=6','root','81.0.57.125','2020-02-03 20:02:20','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:21','','b'),('app=db&mod=cat_productes&_=e&id=6&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:23','','e'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 20:02:32','','b'),('app=db&mod=cat_productes&_=i','root','81.0.57.125','2020-02-03 20:02:35','','i'),('app=db&mod=cat_productes&_=e&id=','root','81.0.57.125','2020-02-03 20:02:29','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:29','','b'),('app=db&mod=cat_productes&_=i','root','81.0.57.125','2020-02-03 20:02:37','','i'),('app=db&mod=cat_productes&_=e&id=','root','81.0.57.125','2020-02-03 20:02:57','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:57','','b'),('app=db&mod=cat_productes&_=e&id=8&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:01','','e'),('app=db&mod=cat_productes&_=e&id=8','root','81.0.57.125','2020-02-03 20:02:40','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:41','','b'),('app=db&mod=cat_productes&_=e&id=9&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:44','','e'),('app=db&mod=cat_productes&_=e&id=9','root','81.0.57.125','2020-02-03 20:02:56','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:57','','b'),('app=db&mod=cat_productes&_=e&id=10&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:59','','e'),('app=db&mod=cat_productes&_=e&id=10','root','81.0.57.125','2020-02-03 20:02:10','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:10','','b'),('app=db&mod=cat_productes&_=e&id=11&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:14','','e'),('app=db&mod=cat_productes&_=e&id=11','root','81.0.57.125','2020-02-03 20:02:22','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:23','','b'),('app=db&mod=cat_productes&_=e&id=12&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:28','','e'),('app=db&mod=cat_productes&_=e&id=12','root','81.0.57.125','2020-02-03 20:02:41','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:41','','b'),('app=db&mod=cat_productes&_=e&id=13&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:29','','e'),('app=db&mod=cat_productes&_=e&id=13','root','81.0.57.125','2020-02-03 20:02:47','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:47','','b'),('app=db&mod=cat_productes&_=e&id=14&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:22','','e'),('app=db&mod=cat_productes&_=e&id=14','root','81.0.57.125','2020-02-03 20:02:40','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:40','','b'),('app=db&mod=cat_productes&_=e&id=15&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:35','','e'),('app=db&mod=cat_productes&_=e&id=15','root','81.0.57.125','2020-02-03 20:02:47','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:48','','b'),('app=db&mod=cat_productes&_=e&id=16&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:51','','e'),('app=db&mod=cat_productes&_=e&id=16','root','81.0.57.125','2020-02-03 20:02:38','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:39','','b'),('app=db&mod=cat_productes&_=e&id=17&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:50','','e'),('app=db&mod=cat_productes&_=e&id=17','root','81.0.57.125','2020-02-03 20:02:07','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:07','','b'),('app=db&mod=cat_productes&_=e&id=18&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:11','','e'),('app=db&mod=cat_productes&_=e&id=18','root','81.0.57.125','2020-02-03 20:02:37','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:37','','b'),('app=db&mod=cat_productes&_=e&id=19&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:49','','e'),('app=db&mod=cat_productes&_=e&id=19','root','81.0.57.125','2020-02-03 20:02:03','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:04','','b'),('app=db&mod=cat_productes&_=e&id=20&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:06','','e'),('app=db&mod=cat_productes&_=e&id=20','root','81.0.57.125','2020-02-03 20:02:22','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:23','','b'),('app=db&mod=cat_productes&_=e&id=21&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:26','','e'),('app=db&mod=cat_productes&_=e&id=21','root','81.0.57.125','2020-02-03 20:02:36','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:37','','b'),('app=db&mod=cat_productes&_=e&id=22&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:40','','e'),('app=db&mod=cat_productes&_=e&id=22','root','81.0.57.125','2020-02-03 20:02:49','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:49','','b'),('app=db&mod=cat_productes&_=e&id=23&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:54','','e'),('app=db&mod=cat_productes&_=e&id=23','root','81.0.57.125','2020-02-03 20:02:10','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:11','','b'),('app=db&mod=cat_productes&_=e&id=24&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:14','','e'),('app=db&mod=cat_productes&_=e&id=24','root','81.0.57.125','2020-02-03 20:02:26','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:26','','b'),('app=db&mod=cat_productes&_=e&id=25&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:29','','e'),('app=db&mod=cat_productes&_=e&id=25','root','81.0.57.125','2020-02-03 20:02:57','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:57','','b'),('app=db&mod=cat_productes&_=e&id=26&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:00','','e'),('app=db&mod=cat_productes&_=e&id=26','root','81.0.57.125','2020-02-03 20:02:13','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:13','','b'),('app=db&mod=cat_productes&_=e&id=27&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:17','','e'),('app=db&mod=cat_productes&_=e&id=27','root','81.0.57.125','2020-02-03 20:02:30','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:31','','b'),('app=db&mod=cat_productes&_=e&id=28&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:36','','e'),('app=db&mod=cat_productes&_=e&id=28','root','81.0.57.125','2020-02-03 20:02:50','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:50','','b'),('app=db&mod=cat_productes&_=e&id=29&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:55','','e'),('app=db&mod=cat_productes&_=e&id=29','root','81.0.57.125','2020-02-03 20:02:14','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:14','','b'),('app=db&mod=cat_productes&_=e&id=30&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:17','','e'),('app=db&mod=cat_productes&_=e&id=30','root','81.0.57.125','2020-02-03 20:02:28','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:28','','b'),('app=db&mod=cat_productes&_=e&id=31&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:33','','e'),('app=db&mod=cat_productes&_=e&id=31','root','81.0.57.125','2020-02-03 20:02:39','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:40','','b'),('app=db&mod=cat_productes&_=e&id=32&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:43','','e'),('app=db&mod=cat_productes&_=e&id=32','root','81.0.57.125','2020-02-03 20:02:00','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:00','','b'),('app=db&mod=cat_productes&_=e&id=33&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:03','','e'),('app=db&mod=cat_productes&_=e&id=33','root','81.0.57.125','2020-02-03 20:02:14','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:15','','b'),('app=db&mod=cat_productes&_=e&id=34&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:21','','e'),('app=db&mod=cat_productes&_=e&id=34','root','81.0.57.125','2020-02-03 20:02:28','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:28','','b'),('app=db&mod=cat_productes&_=e&id=35&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:33','','e'),('app=db&mod=cat_productes&_=e&id=35','root','81.0.57.125','2020-02-03 20:02:49','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:49','','b'),('app=pref&mod=sys_mod&_=e&id=1&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:55','','e'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 20:02:00','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 20:02:02','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 20:02:03','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=41&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:07','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=41','root','81.0.57.125','2020-02-03 20:02:18','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 20:02:18','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 20:02:20','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 20:02:24','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 20:02:25','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 20:02:29','','b'),('app=db&mod=cat_productes&_=e&id=36','root','81.0.57.125','2020-02-03 20:02:34','','e'),('app=db&mod=cat_productes&_=e&id=36','root','81.0.57.125','2020-02-03 20:02:41','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:41','','b'),('app=db&mod=cat_productes&_=e&id=36&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:45','','e'),('app=db&mod=cat_productes&_=e&id=36','root','81.0.57.125','2020-02-03 20:02:02','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:02','','b'),('app=db&mod=cat_productes&_=e&id=37&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:05','','e'),('app=db&mod=cat_productes&_=e&id=37','root','81.0.57.125','2020-02-03 20:02:15','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:15','','b'),('app=db&mod=cat_productes&_=e&id=38&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:18','','e'),('app=db&mod=cat_productes&_=e&id=38','root','81.0.57.125','2020-02-03 20:02:30','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:30','','b'),('app=db&mod=cat_productes&_=e&id=39&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:41','','e'),('app=db&mod=cat_productes&_=e&id=39','root','81.0.57.125','2020-02-03 20:02:01','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:01','','b'),('app=db&mod=cat_productes&_=e&id=40&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:05','','e'),('app=db&mod=cat_productes&_=e&id=40','root','81.0.57.125','2020-02-03 20:02:19','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:19','','b'),('app=db&mod=cat_productes&_=e&id=41&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:22','','e'),('app=db&mod=cat_productes&_=e&id=41','root','81.0.57.125','2020-02-03 20:02:35','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:35','','b'),('app=db&mod=cat_productes&_=e&id=42&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:39','','e'),('app=db&mod=cat_productes&_=e&id=42','root','81.0.57.125','2020-02-03 20:02:50','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:50','','b'),('app=db&mod=cat_productes&_=e&id=43&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:54','','e'),('app=db&mod=cat_productes&_=e&id=43','root','81.0.57.125','2020-02-03 20:02:10','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:10','','b'),('app=db&mod=cat_productes&_=e&id=42&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:15','','e'),('app=db&mod=cat_productes&_=e&id=42','root','81.0.57.125','2020-02-03 20:02:25','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:25','','b'),('app=db&mod=cat_productes&_=e&id=16&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:41','','e'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 20:02:06','','b'),('app=db&mod=cat_productes&_=e&id=45&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:12','','e'),('app=db&mod=cat_productes&_=e&id=45','root','81.0.57.125','2020-02-03 20:02:21','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:21','','b'),('app=db&mod=cat_productes&_=e&id=46&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:27','','e'),('app=db&mod=cat_productes&_=e&id=46','root','81.0.57.125','2020-02-03 20:02:54','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:54','','b'),('app=db&mod=cat_autors','root','81.0.57.125','2020-02-03 20:02:05','','b'),('app=db&mod=cat_autors&_=e&id=41&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:15','','e'),('app=db&mod=cat_autors&_=e&id=41','root','81.0.57.125','2020-02-03 20:02:34','','e'),('app=db&mod=cat_autors&_=b','root','81.0.57.125','2020-02-03 20:02:34','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 20:02:38','','b'),('app=db&mod=cat_productes&_=e&id=47','root','81.0.57.125','2020-02-03 20:02:47','','e'),('app=db&mod=cat_productes&_=e&id=47','root','81.0.57.125','2020-02-03 20:02:57','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:57','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 20:02:04','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 20:02:07','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 20:02:25','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-03 20:02:25','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:27','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 20:02:35','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-03 20:02:43','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-03 20:02:44','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:46','','b'),('app=db&mod=cat_productes&_=e&id=47','root','81.0.57.125','2020-02-03 20:02:52','','e'),('app=db&mod=cat_productes&_=e&id=47','root','81.0.57.125','2020-02-03 20:02:02','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:02','','b'),('app=db&mod=cat_productes&_=e&id=46&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:12','','e'),('app=db&mod=cat_productes&_=e&id=46','root','81.0.57.125','2020-02-03 20:02:27','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:27','','b'),('app=db&mod=cat_productes&_=e&id=48&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:33','','e'),('app=db&mod=cat_productes&_=e&id=48','root','81.0.57.125','2020-02-03 20:02:46','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:46','','b'),('app=db&mod=cat_productes&_=e&id=49&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:11','','e'),('app=db&mod=cat_productes&_=e&id=49','root','81.0.57.125','2020-02-03 20:02:45','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:45','','b'),('app=db&mod=cat_productes&_=e&id=50&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:48','','e'),('app=db&mod=cat_productes&_=e&id=50','root','81.0.57.125','2020-02-03 20:02:05','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:05','','b'),('app=db&mod=cat_productes&_=e&id=51&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:09','','e'),('app=db&mod=cat_productes&_=e&id=51','root','81.0.57.125','2020-02-03 20:02:18','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:19','','b'),('app=db&mod=cat_productes&_=e&id=52&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:22','','e'),('app=db&mod=cat_productes&_=e&id=52','root','81.0.57.125','2020-02-03 20:02:32','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:32','','b'),('app=db&mod=cat_productes&_=e&id=53&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:41','','e'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 20:02:46','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 20:02:57','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 20:02:57','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=42','root','81.0.57.125','2020-02-03 20:02:01','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=42','root','81.0.57.125','2020-02-03 20:02:10','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 20:02:11','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 20:02:16','','b'),('app=db&mod=cat_productes&_=e&id=53','root','81.0.57.125','2020-02-03 20:02:21','','e'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 20:02:27','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 20:02:33','','b'),('app=db&mod=cat_productes&op=like&queryfield=*&query=Semmelweiss&_=b','root','81.0.57.125','2020-02-03 20:02:38','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=Semmelweiss&_=e&id=53&_action=delete_confirm','root','81.0.57.125','2020-02-03 20:02:41','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=Semmelweiss&_=e&id=53','root','81.0.57.125','2020-02-03 20:02:44','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=Semmelweiss&_=b','root','81.0.57.125','2020-02-03 20:02:44','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=Semmelweiss&_=e&id=13','root','81.0.57.125','2020-02-03 20:02:47','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=Semmelweiss&_=e&id=13','root','81.0.57.125','2020-02-03 20:02:56','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=Semmelweiss&_=b','root','81.0.57.125','2020-02-03 20:02:57','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=Semmelweiss&_=b','root','81.0.57.125','2020-02-03 20:02:13','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=edocj&_=b','root','81.0.57.125','2020-02-03 20:02:18','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=edic&_=e&id=52&_action=delete_confirm','root','81.0.57.125','2020-02-03 20:02:22','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=edic&_=e&id=52','root','81.0.57.125','2020-02-03 20:02:28','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=edic&_=b','root','81.0.57.125','2020-02-03 20:02:29','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=edic&_=e&id=11','root','81.0.57.125','2020-02-03 20:02:31','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=edic&_=e&id=11','root','81.0.57.125','2020-02-03 20:02:38','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=edic&_=b','root','81.0.57.125','2020-02-03 20:02:38','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=edic&_=b','root','81.0.57.125','2020-02-03 20:02:43','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=hielo&_=e&id=51&_action=delete_confirm','root','81.0.57.125','2020-02-03 20:02:49','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=hielo&_=e&id=51','root','81.0.57.125','2020-02-03 20:02:53','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=hielo&_=b','root','81.0.57.125','2020-02-03 20:02:53','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=hielo&_=e&id=10','root','81.0.57.125','2020-02-03 20:02:56','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=hielo&_=e&id=10','root','81.0.57.125','2020-02-03 20:02:03','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=hielo&_=b','root','81.0.57.125','2020-02-03 20:02:03','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=hielo&_=b','root','81.0.57.125','2020-02-03 20:02:08','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=princesa&_=e&id=50&_action=delete_confirm','root','81.0.57.125','2020-02-03 20:02:11','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=princesa&_=e&id=50','root','81.0.57.125','2020-02-03 20:02:13','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=princesa&_=b','root','81.0.57.125','2020-02-03 20:02:14','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=princesa&_=e&id=8','root','81.0.57.125','2020-02-03 20:02:18','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=princesa&_=e&id=8','root','81.0.57.125','2020-02-03 20:02:25','','e'),('app=db&mod=cat_productes&op=like&queryfield=title&query=princesa&_=b','root','81.0.57.125','2020-02-03 20:02:25','','b'),('app=db&mod=cat_productes&op=like&queryfield=title&query=princesa&_=b','root','81.0.57.125','2020-02-03 20:02:34','','b'),('app=db&mod=cat_productes&op=like&_=e&id=20','root','81.0.57.125','2020-02-03 20:02:42','','e'),('app=db&mod=cat_productes&op=like&_=e&id=20','root','81.0.57.125','2020-02-03 20:02:49','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:49','','b'),('app=db&mod=cat_productes&op=like&_=e&id=22','root','81.0.57.125','2020-02-03 20:02:57','','e'),('app=db&mod=cat_productes&op=like&_=e&id=22','root','81.0.57.125','2020-02-03 20:02:03','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:03','','b'),('app=db&mod=cat_productes&op=like&_=e&id=23','root','81.0.57.125','2020-02-03 20:02:09','','e'),('app=db&mod=cat_productes&op=like&_=e&id=23','root','81.0.57.125','2020-02-03 20:02:16','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:16','','b'),('app=db&mod=cat_productes&op=like&_=e&id=28','root','81.0.57.125','2020-02-03 20:02:23','','e'),('app=db&mod=cat_productes&op=like&_=e&id=28','root','81.0.57.125','2020-02-03 20:02:29','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:29','','b'),('app=db&mod=cat_productes&op=like&_=e&id=29','root','81.0.57.125','2020-02-03 20:02:34','','e'),('app=db&mod=cat_productes&op=like&_=e&id=29','root','81.0.57.125','2020-02-03 20:02:40','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:40','','b'),('app=db&mod=cat_productes&op=like&_=e&id=35','root','81.0.57.125','2020-02-03 20:02:48','','e'),('app=db&mod=cat_productes&op=like&_=e&id=35','root','81.0.57.125','2020-02-03 20:02:56','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:56','','b'),('app=db&mod=cat_productes&op=like&_=e&id=36','root','81.0.57.125','2020-02-03 20:02:00','','e'),('app=db&mod=cat_productes&op=like&_=e&id=36','root','81.0.57.125','2020-02-03 20:02:07','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:08','','b'),('app=db&mod=cat_productes&op=like&_=e&id=38','root','81.0.57.125','2020-02-03 20:02:56','','e'),('app=db&mod=cat_productes&op=like&_=e&id=38','root','81.0.57.125','2020-02-03 20:02:02','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:02','','b'),('app=db&mod=cat_productes&op=like&_=e&id=40','root','81.0.57.125','2020-02-03 20:02:08','','e'),('app=db&mod=cat_productes&op=like&_=e&id=40','root','81.0.57.125','2020-02-03 20:02:14','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:14','','b'),('app=db&mod=cat_productes&op=like&_=e&id=42','root','81.0.57.125','2020-02-03 20:02:18','','e'),('app=db&mod=cat_productes&op=like&_=e&id=42','root','81.0.57.125','2020-02-03 20:02:24','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:24','','b'),('app=db&mod=cat_productes&op=like&_=e&id=45','root','81.0.57.125','2020-02-03 20:02:30','','e'),('app=db&mod=cat_productes&op=like&_=e&id=45','root','81.0.57.125','2020-02-03 20:02:40','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:40','','b'),('app=db&mod=cat_productes&op=like&_=e&id=49','root','81.0.57.125','2020-02-03 20:02:46','','e'),('app=db&mod=cat_productes&op=like&_=e&id=49','root','81.0.57.125','2020-02-03 20:02:51','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:52','','b'),('app=db&mod=cat_productes&op=like&_=e&id=7','root','81.0.57.125','2020-02-03 20:02:03','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=42','root','81.0.57.125','2020-02-03 20:02:48','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=42','root','81.0.57.125','2020-02-03 20:02:56','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 20:02:56','','b'),('app=db&mod=cat_productes&op=like&_=e&id=7','root','81.0.57.125','2020-02-03 20:02:58','','e'),('app=db&mod=cat_productes&op=like&_=e&id=7','root','81.0.57.125','2020-02-03 20:02:15','','e'),('app=db&mod=cat_productes&op=like&_=e&id=7','root','81.0.57.125','2020-02-03 20:02:21','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:21','','b'),('app=db&mod=cat_productes&op=like&_=e&id=16','root','81.0.57.125','2020-02-03 20:02:31','','e'),('app=db&mod=cat_productes&op=like&_=e&id=16','root','81.0.57.125','2020-02-03 20:02:40','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:40','','b'),('app=db&mod=cat_productes&op=like&_=e&id=37','root','81.0.57.125','2020-02-03 20:02:46','','e'),('app=db&mod=cat_productes&op=like&_=e&id=37','root','81.0.57.125','2020-02-03 20:02:52','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:52','','b'),('app=db&mod=cat_productes&op=like&_=e&id=16&_action=Duplicate','root','81.0.57.125','2020-02-03 20:02:07','','e'),('app=db&mod=cat_productes&op=like&_=e&id=16','root','81.0.57.125','2020-02-03 20:02:15','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:15','','b'),('app=db&mod=cat_productes&op=like&_=e&id=46','root','81.0.57.125','2020-02-03 20:02:21','','e'),('app=db&mod=cat_productes&op=like&_=e&id=46','root','81.0.57.125','2020-02-03 20:02:27','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:28','','b'),('app=db&mod=cat_productes&op=like&_=e&id=47','root','81.0.57.125','2020-02-03 20:02:39','','e'),('app=db&mod=cat_productes&op=like&_=e&id=47','root','81.0.57.125','2020-02-03 20:02:46','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:47','','b'),('app=db&mod=cat_productes&op=like&_=e&id=48','root','81.0.57.125','2020-02-03 20:02:53','','e'),('app=db&mod=cat_productes&op=like&_=e&id=48','root','81.0.57.125','2020-02-03 20:02:00','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:00','','b'),('app=db&mod=cat_productes&op=like&_=e&id=2','root','81.0.57.125','2020-02-03 20:02:11','','e'),('app=db&mod=cat_productes&op=like&_=e&id=2','root','81.0.57.125','2020-02-03 20:02:57','','e'),('app=db&mod=cat_productes&op=like&_=e&id=2','root','81.0.57.125','2020-02-03 20:02:08','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:08','','b'),('app=db&mod=cat_productes&op=like&_=e&id=12','root','81.0.57.125','2020-02-03 20:02:14','','e'),('app=db&mod=cat_productes&op=like&_=e&id=12','root','81.0.57.125','2020-02-03 20:02:24','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 20:02:25','','b'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:49','','b'),('app=db&mod=cat_productes&op=like&_=e&id=17','root','81.0.57.125','2020-02-03 21:02:07','','e'),('app=db&mod=cat_productes&op=like&_=e&id=17','root','81.0.57.125','2020-02-03 21:02:13','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:13','','b'),('app=db&mod=cat_productes&op=like&_=e&id=18','root','81.0.57.125','2020-02-03 21:02:19','','e'),('app=db&mod=cat_productes&op=like&_=e&id=18','root','81.0.57.125','2020-02-03 21:02:26','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:26','','b'),('app=db&mod=cat_productes&op=like&_=e&id=32','root','81.0.57.125','2020-02-03 21:02:30','','e'),('app=db&mod=cat_productes&op=like&_=e&id=32','root','81.0.57.125','2020-02-03 21:02:37','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:37','','b'),('app=db&mod=cat_productes&op=like&_=e&id=34','root','81.0.57.125','2020-02-03 21:02:43','','e'),('app=db&mod=cat_productes&op=like&_=e&id=34','root','81.0.57.125','2020-02-03 21:02:50','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:50','','b'),('app=db&mod=cat_productes&op=like&_=e&id=41','root','81.0.57.125','2020-02-03 21:02:02','','e'),('app=db&mod=cat_productes&op=like&_=e&id=41','root','81.0.57.125','2020-02-03 21:02:13','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:13','','b'),('app=db&mod=cat_productes&op=like&_=e&id=44','root','81.0.57.125','2020-02-03 21:02:19','','e'),('app=db&mod=cat_productes&op=like&_=e&id=44','root','81.0.57.125','2020-02-03 21:02:28','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:28','','b'),('app=db&mod=cat_productes&op=like&_=e&id=17','root','81.0.57.125','2020-02-03 21:02:34','','e'),('app=db&mod=cat_productes&op=like&_=e&id=17','root','81.0.57.125','2020-02-03 21:02:41','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:41','','b'),('app=db&mod=cat_productes&op=like&_=e&id=32','root','81.0.57.125','2020-02-03 21:02:46','','e'),('app=db&mod=cat_productes&op=like&_=e&id=32','root','81.0.57.125','2020-02-03 21:02:54','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:54','','b'),('app=db&mod=cat_productes&op=like&_=e&id=18','root','81.0.57.125','2020-02-03 21:02:14','','e'),('app=db&mod=cat_productes&op=like&_=e&id=18','root','81.0.57.125','2020-02-03 21:02:25','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:26','','b'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:58','','b'),('app=db&mod=cat_productes&op=like&_=e&id=12','root','81.0.57.125','2020-02-03 21:02:19','','e'),('app=db&mod=cat_productes&op=like&_=e&id=12','root','81.0.57.125','2020-02-03 21:02:25','','e'),('app=db&mod=cat_productes&op=like&_=b','root','81.0.57.125','2020-02-03 21:02:26','','b'),('app=db&mod=cat_productes&_=b&sortby=category&sortdir=desc&xid=','root','81.0.57.125','2020-02-03 21:02:29','','b'),('app=db&mod=cat_productes&_=b&sortby=category&sortdir=desc&xid=','root','81.0.57.125','2020-02-03 21:02:58','','b'),('app=db&mod=cat_productes&_=b&sortby=category&sortdir=desc&xid=','root','81.0.57.125','2020-02-03 21:02:19','','b'),('app=db&mod=cat_productes&_=b&sortby=category&sortdir=desc&xid=','root','81.0.57.125','2020-02-03 21:02:38','','b'),('','root','81.0.57.125','2020-02-03 21:02:49','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 21:02:03','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 21:02:04','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 21:02:08','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 21:02:08','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=42','root','81.0.57.125','2020-02-03 21:02:14','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=42','root','81.0.57.125','2020-02-03 21:02:21','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 21:02:21','','b'),('app=db&mod=cat_productes&_=b&sortby=category&sortdir=desc&xid=','root','81.0.57.125','2020-02-03 21:02:24','','b'),('app=db&mod=cat_productes&_=b&sortby=title&sortdir=desc&xid=','root','81.0.57.125','2020-02-03 21:02:39','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=5','root','81.0.57.125','2020-02-03 21:02:59','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=5','root','81.0.57.125','2020-02-03 21:02:09','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:09','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=6','root','81.0.57.125','2020-02-03 21:02:24','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=6','root','81.0.57.125','2020-02-03 21:02:19','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:19','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=10&_action=Duplicate','root','81.0.57.125','2020-02-03 21:02:23','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=10','root','81.0.57.125','2020-02-03 21:02:42','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 21:02:43','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:46','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=6','root','81.0.57.125','2020-02-03 21:02:50','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=10&_action=Duplicate','root','81.0.57.125','2020-02-03 21:02:59','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 21:02:02','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=44','root','81.0.57.125','2020-02-03 21:02:05','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=44','root','81.0.57.125','2020-02-03 21:02:10','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 21:02:10','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=6','root','81.0.57.125','2020-02-03 21:02:12','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=6','root','81.0.57.125','2020-02-03 21:02:20','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:20','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=6','root','81.0.57.125','2020-02-03 21:02:25','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=6','root','81.0.57.125','2020-02-03 21:02:36','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:37','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=7','root','81.0.57.125','2020-02-03 21:02:46','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=7','root','81.0.57.125','2020-02-03 21:02:57','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:57','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=44&_action=Duplicate','root','81.0.57.125','2020-02-03 21:02:02','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=44','root','81.0.57.125','2020-02-03 21:02:12','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-03 21:02:12','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=7','root','81.0.57.125','2020-02-03 21:02:14','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=7','root','81.0.57.125','2020-02-03 21:02:24','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:24','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=8','root','81.0.57.125','2020-02-03 21:02:36','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=8','root','81.0.57.125','2020-02-03 21:02:09','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:09','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=8','root','81.0.57.125','2020-02-03 21:02:12','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=8','root','81.0.57.125','2020-02-03 21:02:25','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:25','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=9','root','81.0.57.125','2020-02-03 21:02:44','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=9','root','81.0.57.125','2020-02-03 21:02:40','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:41','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=10','root','81.0.57.125','2020-02-03 21:02:50','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=10','root','81.0.57.125','2020-02-03 21:02:42','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:42','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=16','root','81.0.57.125','2020-02-03 21:02:51','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=16','root','81.0.57.125','2020-02-03 21:02:43','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:43','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=50','root','81.0.57.125','2020-02-03 21:02:15','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=50','root','81.0.57.125','2020-02-03 21:02:10','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:10','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=17','root','81.0.57.125','2020-02-03 21:02:25','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=17','root','81.0.57.125','2020-02-03 21:02:20','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:20','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=18','root','81.0.57.125','2020-02-03 21:02:32','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=18','root','81.0.57.125','2020-02-03 21:02:21','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:22','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=19','root','81.0.57.125','2020-02-03 21:02:31','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=19','root','81.0.57.125','2020-02-03 21:02:18','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:19','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=13','root','81.0.57.125','2020-02-03 21:02:54','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=13','root','81.0.57.125','2020-02-03 21:02:43','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:43','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=14','root','81.0.57.125','2020-02-03 21:02:53','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=14','root','81.0.57.125','2020-02-03 21:02:42','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:42','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=15','root','81.0.57.125','2020-02-03 21:02:54','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=15','root','81.0.57.125','2020-02-03 21:02:43','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:43','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=20','root','81.0.57.125','2020-02-03 21:02:37','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=20','root','81.0.57.125','2020-02-03 21:02:30','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:31','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=21','root','81.0.57.125','2020-02-03 21:02:47','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=21','root','81.0.57.125','2020-02-03 21:02:15','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:15','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=22','root','81.0.57.125','2020-02-03 21:02:28','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=22','root','81.0.57.125','2020-02-03 21:02:17','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:17','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=23','root','81.0.57.125','2020-02-03 21:02:35','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=23','root','81.0.57.125','2020-02-03 21:02:18','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:19','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=24','root','81.0.57.125','2020-02-03 21:02:27','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=24','root','81.0.57.125','2020-02-03 21:02:10','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:10','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=25','root','81.0.57.125','2020-02-03 21:02:19','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=25','root','81.0.57.125','2020-02-03 21:02:02','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:02','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=26','root','81.0.57.125','2020-02-03 21:02:10','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=26','root','81.0.57.125','2020-02-03 21:02:07','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:07','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=27','root','81.0.57.125','2020-02-03 21:02:17','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=27','root','81.0.57.125','2020-02-03 21:02:00','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:00','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=28','root','81.0.57.125','2020-02-03 21:02:09','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=28','root','81.0.57.125','2020-02-03 21:02:09','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:09','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=29','root','81.0.57.125','2020-02-03 21:02:21','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=29','root','81.0.57.125','2020-02-03 21:02:07','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:07','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=30','root','81.0.57.125','2020-02-03 21:02:20','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=30','root','81.0.57.125','2020-02-03 21:02:51','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:52','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=31','root','81.0.57.125','2020-02-03 21:02:04','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=31','root','81.0.57.125','2020-02-03 21:02:49','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:49','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=41','root','81.0.57.125','2020-02-03 21:02:03','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=41','root','81.0.57.125','2020-02-03 21:02:53','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:53','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=33','root','81.0.57.125','2020-02-03 21:02:11','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=33','root','81.0.57.125','2020-02-03 21:02:46','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:47','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=34','root','81.0.57.125','2020-02-03 21:02:04','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=34','root','81.0.57.125','2020-02-03 21:02:43','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:44','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=35','root','81.0.57.125','2020-02-03 21:02:00','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=35','root','81.0.57.125','2020-02-03 21:02:55','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:55','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=36','root','81.0.57.125','2020-02-03 21:02:06','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=36','root','81.0.57.125','2020-02-03 21:02:40','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:40','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=37','root','81.0.57.125','2020-02-03 21:02:53','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=37','root','81.0.57.125','2020-02-03 21:02:35','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:35','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=38','root','81.0.57.125','2020-02-03 21:02:49','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=38','root','81.0.57.125','2020-02-03 21:02:31','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:31','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=39','root','81.0.57.125','2020-02-03 21:02:45','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=39','root','81.0.57.125','2020-02-03 21:02:21','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:21','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=40','root','81.0.57.125','2020-02-03 21:02:46','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=40','root','81.0.57.125','2020-02-03 21:02:38','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:38','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=41','root','81.0.57.125','2020-02-03 21:02:49','','e'),('','root','81.0.57.125','2020-02-03 21:02:19','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-03 21:02:22','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-03 21:02:22','','b'),('app=db&mod=cat_productes&_=e&id=32','root','81.0.57.125','2020-02-03 21:02:28','','e'),('app=db&mod=cat_productes&_=e&id=32','root','81.0.57.125','2020-02-03 21:02:39','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 21:02:39','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=41','root','81.0.57.125','2020-02-03 21:02:22','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:23','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=42','root','81.0.57.125','2020-02-03 21:02:31','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=42','root','81.0.57.125','2020-02-03 21:02:22','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:22','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=43','root','81.0.57.125','2020-02-03 21:02:36','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=43','root','81.0.57.125','2020-02-03 21:02:17','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:17','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=44','root','81.0.57.125','2020-02-03 21:02:29','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=44','root','81.0.57.125','2020-02-03 21:02:06','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:06','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=45','root','81.0.57.125','2020-02-03 21:02:22','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=45','root','81.0.57.125','2020-02-03 21:02:08','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:08','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=27','root','81.0.57.125','2020-02-03 21:02:30','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:32','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=46','root','81.0.57.125','2020-02-03 21:02:36','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=46','root','81.0.57.125','2020-02-03 21:02:33','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:33','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=47','root','81.0.57.125','2020-02-03 21:02:43','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=47','root','81.0.57.125','2020-02-03 21:02:18','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:19','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=48','root','81.0.57.125','2020-02-03 21:02:31','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=48','root','81.0.57.125','2020-02-03 21:02:15','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:15','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=49','root','81.0.57.125','2020-02-03 21:02:26','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=49','root','81.0.57.125','2020-02-03 21:02:00','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:00','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=11','root','81.0.57.125','2020-02-03 21:02:30','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=e&id=11','root','81.0.57.125','2020-02-03 21:02:06','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=desc&_=b','root','81.0.57.125','2020-02-03 21:02:06','','b'),('app=db&mod=cat_productes&_=b&sortby=title&sortdir=asc&xid=','root','81.0.57.125','2020-02-03 21:02:15','','b'),('app=db&mod=cat_productes&sortby=title&sortdir=asc&_=e&id=47','root','81.0.57.125','2020-02-03 21:02:27','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=asc&_=e&id=47','root','81.0.57.125','2020-02-03 21:02:11','','e'),('app=db&mod=cat_productes&sortby=title&sortdir=asc&_=b','root','81.0.57.125','2020-02-03 21:02:11','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 22:02:31','','b'),('app=db&mod=cat_productes&_=e&id=12','root','81.0.57.125','2020-02-03 22:02:36','','e'),('app=db&mod=cat_productes&_=e&id=12','root','81.0.57.125','2020-02-03 22:02:32','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 22:02:32','','b'),('','root','81.0.57.125','2020-02-03 23:02:05','','login'),('','root','81.0.57.125','2020-02-03 23:02:05','','b'),('app=db&mod=cat_productes&_=e&id=50','root','81.0.57.125','2020-02-03 23:02:06','','e'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-03 23:02:44','','b'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 23:02:50','','e'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-03 23:02:01','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-03 23:02:01','','b'),('app=db&mod=cat_productes&_=e&id=50','root','81.0.57.125','2020-02-03 23:02:31','','e'),('','root','81.0.57.125','2020-02-03 23:02:34','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-03 23:02:36','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-03 23:02:38','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-03 23:02:40','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-03 23:02:41','','b'),('','root','81.0.57.125','2020-02-04 00:02:11','','b'),('app=sites&menu=1','root','81.0.57.125','2020-02-04 00:02:12','','b'),('app=sites&mod=sites_pages&menu=1','root','81.0.57.125','2020-02-04 00:02:12','','b'),('','root','81.0.57.125','2020-02-04 00:02:15','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-04 00:02:16','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-04 00:02:17','','b'),('app=db&mod=sites_pages','root','81.0.57.125','2020-02-04 00:02:19','','b'),('app=db&mod=sites_pages&_=e&id=1','root','81.0.57.125','2020-02-04 00:02:23','','e'),('app=db&mod=lib_pictures','root','81.0.57.125','2020-02-04 00:02:54','','b'),('_=f&app=db&mod=lib_pictures&action=mupload&view=','root','81.0.57.125','2020-02-04 00:02:56','','f'),('app=db&mod=lib_pictures','root','81.0.57.125','2020-02-04 00:02:02','','b'),('_=f&app=db&mod=lib_pictures&action=mupload&view=','root','81.0.57.125','2020-02-04 00:02:07','','f'),('app=db&mod=lib_pictures','root','81.0.57.125','2020-02-04 00:02:10','','b'),('app=db&mod=lib_pictures_albums&id=&app=db&mod=lib_pictures&mod=lib_pictures_albums','root','81.0.57.125','2020-02-04 00:02:11','','b'),('app=db&mod=lib_pictures_albums&_=i','root','81.0.57.125','2020-02-04 00:02:13','','i'),('app=db&mod=lib_pictures_albums&_=e&id=','root','81.0.57.125','2020-02-04 00:02:20','','e'),('app=db&mod=lib_pictures_albums&_=b','root','81.0.57.125','2020-02-04 00:02:20','','b'),('app=db&mod=lib_pictures','root','81.0.57.125','2020-02-04 00:02:21','','b'),('_=f&app=db&mod=lib_pictures&action=mupload&view=','root','81.0.57.125','2020-02-04 00:02:23','','f'),('app=db&mod=lib_pictures','root','81.0.57.125','2020-02-04 00:02:30','','b'),('app=db&mod=lib_pictures','root','81.0.57.125','2020-02-04 00:02:33','','b'),('_=b&app=db&mod=lib_pictures&view=4&v2=0','root','81.0.57.125','2020-02-04 00:02:33','','b'),('_=b&app=db&mod=lib_pictures&view=4&v2=0','root','81.0.57.125','2020-02-04 00:02:57','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-04 00:02:35','','b'),('app=db&mod=cat_productes&_=e&id=6','root','81.0.57.125','2020-02-04 00:02:42','','e'),('app=db&mod=cat_productes&_=e&id=5','root','81.0.57.125','2020-02-04 00:02:43','','e'),('app=db&mod=cat_productes&_=e&id=6','root','81.0.57.125','2020-02-04 00:02:49','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-04 00:02:49','','b'),('app=db&mod=cat_productes&_=e&id=5','root','81.0.57.125','2020-02-04 00:02:54','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-04 00:02:54','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-04 00:02:22','','b'),('','root','81.0.57.125','2020-02-04 12:02:26','','login'),('','root','81.0.57.125','2020-02-04 12:02:26','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-04 12:02:28','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-04 12:02:28','','b'),('app=db&mod=cat_productes&_=b&sortby=id&sortdir=asc&xid=','root','81.0.57.125','2020-02-04 12:02:31','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=1','root','81.0.57.125','2020-02-04 12:02:34','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=1','root','81.0.57.125','2020-02-04 12:02:10','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:10','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=2','root','81.0.57.125','2020-02-04 12:02:24','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=2','root','81.0.57.125','2020-02-04 12:02:31','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:31','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=3','root','81.0.57.125','2020-02-04 12:02:52','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=3','root','81.0.57.125','2020-02-04 12:02:01','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:01','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=4','root','81.0.57.125','2020-02-04 12:02:27','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=4','root','81.0.57.125','2020-02-04 12:02:36','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:36','','b'),('','root','81.0.57.125','2020-02-04 12:02:42','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-04 12:02:43','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 12:02:46','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-04 12:02:50','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-04 12:02:05','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 12:02:05','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:07','','b'),('','root','81.0.57.125','2020-02-04 12:02:13','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-04 12:02:15','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 12:02:16','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-04 12:02:19','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-04 12:02:19','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 12:02:25','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-04 12:02:27','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-04 12:02:36','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 12:02:36','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:38','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=7','root','81.0.57.125','2020-02-04 12:02:46','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=7','root','81.0.57.125','2020-02-04 12:02:11','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:11','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=6','root','81.0.57.125','2020-02-04 12:02:18','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=6','root','81.0.57.125','2020-02-04 12:02:24','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:24','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=6','root','81.0.57.125','2020-02-04 12:02:39','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=6','root','81.0.57.125','2020-02-04 12:02:46','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:46','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=5','root','81.0.57.125','2020-02-04 12:02:50','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=5','root','81.0.57.125','2020-02-04 12:02:02','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:03','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=8','root','81.0.57.125','2020-02-04 12:02:12','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=8','root','81.0.57.125','2020-02-04 12:02:18','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:18','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=9','root','81.0.57.125','2020-02-04 12:02:30','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=9','root','81.0.57.125','2020-02-04 12:02:37','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:37','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=10','root','81.0.57.125','2020-02-04 12:02:51','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=10','root','81.0.57.125','2020-02-04 12:02:57','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:57','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=11','root','81.0.57.125','2020-02-04 12:02:09','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=11','root','81.0.57.125','2020-02-04 12:02:15','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:15','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=12','root','81.0.57.125','2020-02-04 12:02:33','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=12','root','81.0.57.125','2020-02-04 12:02:40','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:40','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=13','root','81.0.57.125','2020-02-04 12:02:51','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=13','root','81.0.57.125','2020-02-04 12:02:01','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:02','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=14','root','81.0.57.125','2020-02-04 12:02:37','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=14','root','81.0.57.125','2020-02-04 12:02:02','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:02','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=15','root','81.0.57.125','2020-02-04 12:02:23','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=15','root','81.0.57.125','2020-02-04 12:02:30','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:30','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=16','root','81.0.57.125','2020-02-04 12:02:10','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:25','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=50','root','81.0.57.125','2020-02-04 12:02:31','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=50','root','81.0.57.125','2020-02-04 12:02:37','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:37','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=17','root','81.0.57.125','2020-02-04 12:02:54','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=17','root','81.0.57.125','2020-02-04 12:02:02','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:02','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=18','root','81.0.57.125','2020-02-04 12:02:19','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=18','root','81.0.57.125','2020-02-04 12:02:25','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:25','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=19','root','81.0.57.125','2020-02-04 12:02:43','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=19','root','81.0.57.125','2020-02-04 12:02:51','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:51','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=20','root','81.0.57.125','2020-02-04 12:02:29','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=20','root','81.0.57.125','2020-02-04 12:02:36','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:36','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=21','root','81.0.57.125','2020-02-04 12:02:51','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=21','root','81.0.57.125','2020-02-04 12:02:58','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:58','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=22','root','81.0.57.125','2020-02-04 12:02:15','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=22','root','81.0.57.125','2020-02-04 12:02:25','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:25','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=23','root','81.0.57.125','2020-02-04 12:02:45','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=23','root','81.0.57.125','2020-02-04 12:02:50','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:51','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=24','root','81.0.57.125','2020-02-04 12:02:07','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=24','root','81.0.57.125','2020-02-04 12:02:14','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:14','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=25','root','81.0.57.125','2020-02-04 12:02:30','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=25','root','81.0.57.125','2020-02-04 12:02:36','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:36','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=26','root','81.0.57.125','2020-02-04 12:02:53','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=26','root','81.0.57.125','2020-02-04 12:02:59','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:59','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=27','root','81.0.57.125','2020-02-04 12:02:17','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=27','root','81.0.57.125','2020-02-04 12:02:22','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:23','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=28','root','81.0.57.125','2020-02-04 12:02:39','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=28','root','81.0.57.125','2020-02-04 12:02:47','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:47','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=29','root','81.0.57.125','2020-02-04 12:02:07','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=29','root','81.0.57.125','2020-02-04 12:02:13','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:13','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=30','root','81.0.57.125','2020-02-04 12:02:42','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=30','root','81.0.57.125','2020-02-04 12:02:51','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:51','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=31','root','81.0.57.125','2020-02-04 12:02:05','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=31','root','81.0.57.125','2020-02-04 12:02:13','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:13','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=32','root','81.0.57.125','2020-02-04 12:02:30','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=32','root','81.0.57.125','2020-02-04 12:02:38','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:38','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=33','root','81.0.57.125','2020-02-04 12:02:52','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=33','root','81.0.57.125','2020-02-04 12:02:59','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:59','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=34','root','81.0.57.125','2020-02-04 12:02:17','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=34','root','81.0.57.125','2020-02-04 12:02:25','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:26','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=35','root','81.0.57.125','2020-02-04 12:02:39','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=35','root','81.0.57.125','2020-02-04 12:02:45','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:46','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=36','root','81.0.57.125','2020-02-04 12:02:59','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=36','root','81.0.57.125','2020-02-04 12:02:05','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:05','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=37','root','81.0.57.125','2020-02-04 12:02:18','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=37','root','81.0.57.125','2020-02-04 12:02:24','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:24','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=38','root','81.0.57.125','2020-02-04 12:02:39','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=38','root','81.0.57.125','2020-02-04 12:02:44','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:44','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=39','root','81.0.57.125','2020-02-04 12:02:57','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=39','root','81.0.57.125','2020-02-04 12:02:06','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:06','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=40','root','81.0.57.125','2020-02-04 12:02:22','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=40','root','81.0.57.125','2020-02-04 12:02:30','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:31','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=41','root','81.0.57.125','2020-02-04 12:02:45','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=41','root','81.0.57.125','2020-02-04 12:02:54','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:55','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=42','root','81.0.57.125','2020-02-04 12:02:15','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=42','root','81.0.57.125','2020-02-04 12:02:23','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:23','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=43','root','81.0.57.125','2020-02-04 12:02:37','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=43','root','81.0.57.125','2020-02-04 12:02:42','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:42','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=44','root','81.0.57.125','2020-02-04 12:02:58','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=44','root','81.0.57.125','2020-02-04 12:02:06','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:06','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=45','root','81.0.57.125','2020-02-04 12:02:19','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=45','root','81.0.57.125','2020-02-04 12:02:25','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:25','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=16','root','81.0.57.125','2020-02-04 12:02:46','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=16','root','81.0.57.125','2020-02-04 12:02:54','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:54','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=16','root','81.0.57.125','2020-02-04 12:02:04','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:13','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=46','root','81.0.57.125','2020-02-04 12:02:25','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=46','root','81.0.57.125','2020-02-04 12:02:32','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:32','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=47','root','81.0.57.125','2020-02-04 12:02:47','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=47','root','81.0.57.125','2020-02-04 12:02:52','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 12:02:52','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=48','root','81.0.57.125','2020-02-04 13:02:08','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=48','root','81.0.57.125','2020-02-04 13:02:14','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 13:02:14','','b'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=49','root','81.0.57.125','2020-02-04 13:02:28','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=e&id=49','root','81.0.57.125','2020-02-04 13:02:36','','e'),('app=db&mod=cat_productes&sortby=id&sortdir=asc&_=b','root','81.0.57.125','2020-02-04 13:02:36','','b'),('','root','81.0.57.125','2020-02-04 13:02:28','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-04 13:02:30','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-04 13:02:30','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-04 13:02:44','','b'),('','root','81.0.57.125','2020-02-04 13:02:18','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-04 13:02:20','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 13:02:23','','b'),('app=pref&mod=sys_mod&_=i','root','81.0.57.125','2020-02-04 13:02:38','','i'),('app=pref&mod=sys_mod&_=e&id=','root','81.0.57.125','2020-02-04 13:02:31','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 13:02:31','','b'),('_=f&id=3&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-04 13:02:36','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=clients&queryfield=mod_id','root','81.0.57.125','2020-02-04 13:02:37','','b'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 13:02:46','','b'),('_=f&id=3&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-04 13:02:52','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=clients&queryfield=mod_id','root','81.0.57.125','2020-02-04 13:02:52','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=35&_action=delete_confirm','root','81.0.57.125','2020-02-04 13:02:57','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=35','root','81.0.57.125','2020-02-04 13:02:59','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=35&_=b','root','81.0.57.125','2020-02-04 13:02:01','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=36&_action=delete_confirm','root','81.0.57.125','2020-02-04 13:02:03','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=36','root','81.0.57.125','2020-02-04 13:02:05','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=36&_=b','root','81.0.57.125','2020-02-04 13:02:08','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=37&_action=delete_confirm','root','81.0.57.125','2020-02-04 13:02:10','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=37','root','81.0.57.125','2020-02-04 13:02:12','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=37&_=b','root','81.0.57.125','2020-02-04 13:02:15','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=i','root','81.0.57.125','2020-02-04 13:02:17','','i'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=','root','81.0.57.125','2020-02-04 13:02:39','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:39','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=48&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:41','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=48','root','81.0.57.125','2020-02-04 13:02:02','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:02','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=49&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:05','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=49','root','81.0.57.125','2020-02-04 13:02:29','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:29','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=50&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:33','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=50','root','81.0.57.125','2020-02-04 13:02:53','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:53','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=51&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:57','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=51','root','81.0.57.125','2020-02-04 13:02:06','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:07','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=52&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:10','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=52','root','81.0.57.125','2020-02-04 13:02:24','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:24','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=53&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:27','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=53','root','81.0.57.125','2020-02-04 13:02:40','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:40','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=54&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:05','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=54','root','81.0.57.125','2020-02-04 13:02:21','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:21','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 13:02:28','','b'),('app=pref&mod=sys_mod&_=e&id=3','root','81.0.57.125','2020-02-04 13:02:33','','e'),('app=pref&mod=sys_mod&_=e&id=3','root','81.0.57.125','2020-02-04 13:02:17','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 13:02:17','','b'),('app=pref&mod=sys_mod&_=e&id=3&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:20','','e'),('app=pref&mod=sys_mod&_=e&id=3','root','81.0.57.125','2020-02-04 13:02:15','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 13:02:16','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-04 13:02:18','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-04 13:02:19','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=i','root','81.0.57.125','2020-02-04 13:02:22','','i'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=','root','81.0.57.125','2020-02-04 13:02:55','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:56','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=58&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:01','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=58','root','81.0.57.125','2020-02-04 13:02:25','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=58&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:36','','e'),('','root','81.0.57.125','2020-02-04 13:02:53','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-04 13:02:55','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 13:02:56','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=58','root','81.0.57.125','2020-02-04 13:02:14','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:14','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=i','root','81.0.57.125','2020-02-04 13:02:19','','i'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=','root','81.0.57.125','2020-02-04 13:02:36','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:36','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=59','root','81.0.57.125','2020-02-04 13:02:45','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=59','root','81.0.57.125','2020-02-04 13:02:48','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=59&_=b','root','81.0.57.125','2020-02-04 13:02:51','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=59&_action=delete_confirm','root','81.0.57.125','2020-02-04 13:02:53','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=59','root','81.0.57.125','2020-02-04 13:02:56','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=59&_=b','root','81.0.57.125','2020-02-04 13:02:59','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=61&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:02','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=61','root','81.0.57.125','2020-02-04 13:02:01','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:01','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=62&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:06','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=62','root','81.0.57.125','2020-02-04 13:02:24','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=62&_=b','root','81.0.57.125','2020-02-04 13:02:27','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=63&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:48','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=63','root','81.0.57.125','2020-02-04 13:02:07','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:08','','b'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-04 13:02:14','','e'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-04 13:02:45','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 13:02:45','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-04 13:02:48','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-04 13:02:48','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=64&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:58','','e'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 13:02:08','','b'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-04 13:02:12','','e'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-04 13:02:13','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 13:02:13','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-04 13:02:25','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-04 13:02:26','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=i','root','81.0.57.125','2020-02-04 13:02:28','','i'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=','root','81.0.57.125','2020-02-04 13:02:40','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 13:02:41','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 13:02:44','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-04 13:02:40','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-04 13:02:41','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 13:02:46','','b'),('app=pref&mod=sys_mod&_=i','root','81.0.57.125','2020-02-04 13:02:05','','i'),('app=pref&mod=sys_mod&_=e&id=','root','81.0.57.125','2020-02-04 13:02:56','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 13:02:57','','b'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-04 13:02:01','','e'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-04 13:02:10','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 13:02:10','','b'),('_=f&id=5&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-04 13:02:19','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=comandes&queryfield=mod_id','root','81.0.57.125','2020-02-04 13:02:20','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=i','root','81.0.57.125','2020-02-04 13:02:22','','i'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=','root','81.0.57.125','2020-02-04 13:02:35','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=&_=b','root','81.0.57.125','2020-02-04 13:02:38','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=68&_action=Duplicate','root','81.0.57.125','2020-02-04 13:02:40','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=68','root','81.0.57.125','2020-02-04 14:02:23','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 14:02:24','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=69&_action=Duplicate','root','81.0.57.125','2020-02-04 14:02:30','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=69','root','81.0.57.125','2020-02-04 14:02:01','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-04 14:02:01','','b'),('','root','81.0.57.125','2020-02-04 14:02:06','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-04 14:02:08','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 14:02:09','','b'),('_=b&app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-04 14:02:16','','b'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-04 14:02:20','','e'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-04 14:02:50','','e'),('app=pref&mod=sys_apps&_=b','root','81.0.57.125','2020-02-04 14:02:50','','b'),('','root','81.0.57.125','2020-02-04 14:02:52','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-04 14:02:53','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-04 14:02:53','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-04 14:02:56','','b'),('','root','81.0.57.125','2020-02-04 16:02:12','','login'),('','root','81.0.57.125','2020-02-04 16:02:12','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-04 16:02:14','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 16:02:16','','b'),('','root','81.0.57.125','2020-02-04 16:02:46','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-04 16:02:47','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-04 16:02:47','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-04 16:02:50','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-04 16:02:47','','b'),('','root','81.0.57.125','2020-02-04 16:02:03','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-04 16:02:05','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 16:02:06','','b'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-04 16:02:11','','e'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-04 16:02:19','','b'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-04 16:02:23','','e'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-04 16:02:38','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-04 16:02:38','','b'),('_=f&id=5&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-04 16:02:40','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=comandes&queryfield=mod_id','root','81.0.57.125','2020-02-04 16:02:41','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=i','root','81.0.57.125','2020-02-04 16:02:42','','i'),('','root','81.0.57.125','2020-02-04 16:02:53','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-04 16:02:56','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-04 16:02:56','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-04 16:02:56','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-04 16:02:58','','b'),('','root','81.0.57.125','2020-02-05 12:02:41','','login'),('','root','81.0.57.125','2020-02-05 12:02:41','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-05 12:02:43','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-05 12:02:43','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 12:02:46','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:50','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:31','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:39','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=order_id&query=','root','81.0.57.125','2020-02-05 13:02:43','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:05','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=order_id&query=','root','81.0.57.125','2020-02-05 13:02:07','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:11','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:12','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:36','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:46','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:08','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=order_id&query=6','root','81.0.57.125','2020-02-05 13:02:11','','b'),('app=db&mod=cat_sales&queryfield=order_id&query=6&_=b','root','81.0.57.125','2020-02-05 13:02:21','','b'),('app=db&mod=cat_sales&queryfield=order_id&query=6&_=b','root','81.0.57.125','2020-02-05 13:02:33','','b'),('app=db&mod=cat_sales&queryfield=order_id&query=6&_=b','root','81.0.57.125','2020-02-05 13:02:39','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:29','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=6','root','81.0.57.125','2020-02-05 13:02:31','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:43','','b'),('','root','81.0.57.125','2020-02-05 13:02:59','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-05 13:02:01','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-05 13:02:03','','b'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-05 13:02:23','','e'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-05 13:02:30','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-05 13:02:30','','b'),('_=f&id=5&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-05 13:02:34','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=comandes&queryfield=mod_id','root','81.0.57.125','2020-02-05 13:02:34','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=70&_action=Duplicate','root','81.0.57.125','2020-02-05 13:02:41','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=70','root','81.0.57.125','2020-02-05 13:02:50','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-05 13:02:50','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-05 13:02:21','','b'),('','root','81.0.57.125','2020-02-05 13:02:24','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:28','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:31','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-05 13:02:09','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-05 13:02:11','','b'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-05 13:02:14','','e'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-05 13:02:34','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-05 13:02:34','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:35','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:53','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:11','','b'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-05 13:02:24','','e'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-05 13:02:34','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-05 13:02:34','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:24','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:50','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:52','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:21','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:39','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=1','root','81.0.57.125','2020-02-05 13:02:44','','b'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-05 13:02:53','','e'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-05 13:02:06','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-05 13:02:06','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=1','root','81.0.57.125','2020-02-05 13:02:15','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=1','root','81.0.57.125','2020-02-05 13:02:51','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=1','root','81.0.57.125','2020-02-05 13:02:54','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=1','root','81.0.57.125','2020-02-05 13:02:56','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=1','root','81.0.57.125','2020-02-05 13:02:58','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=1','root','81.0.57.125','2020-02-05 13:02:15','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:20','','b'),('app=db&mod=cat_comandes&_=b','root','81.0.57.125','2020-02-05 13:02:29','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:32','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=1','root','81.0.57.125','2020-02-05 13:02:36','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:38','','b'),('_=b&app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-05 13:02:46','','b'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-05 13:02:55','','e'),('app=db&mod=cat_comandes&_=b','root','81.0.57.125','2020-02-05 13:02:08','','b'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-05 13:02:26','','e'),('app=pref&mod=sys_apps&_=b','root','81.0.57.125','2020-02-05 13:02:26','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:30','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=1','root','81.0.57.125','2020-02-05 13:02:32','','b'),('app=db&mod=cat_comandes&_=b','root','81.0.57.125','2020-02-05 13:02:34','','b'),('app=db&mod=cat_comandes&_=b','root','81.0.57.125','2020-02-05 13:02:36','','b'),('app=db&mod=cat_comandes&_=b','root','81.0.57.125','2020-02-05 13:02:42','','b'),('app=db&mod=cat_comandes&_=b','root','81.0.57.125','2020-02-05 13:02:51','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-05 13:02:53','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=1','root','81.0.57.125','2020-02-05 13:02:54','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=1','root','81.0.57.125','2020-02-05 13:02:57','','b'),('app=db&mod=cat_comandes&_=b','root','81.0.57.125','2020-02-05 13:02:02','','b'),('app=db&mod=cat_comandes&_=b&queryfield=id&query=','root','81.0.57.125','2020-02-05 13:02:20','','b'),('app=db&mod=cat_comandes&_=b&queryfield=id&query=*','root','81.0.57.125','2020-02-05 13:02:46','','b'),('app=db&mod=cat_comandes&_=b&queryfield=*&query=*','root','81.0.57.125','2020-02-05 13:02:53','','b'),('app=db&mod=cat_comandes&_=b&queryfield=*&query=','root','81.0.57.125','2020-02-05 13:02:57','','b'),('app=db&mod=cat_comandes&_=b&queryfield=*&query=%27%27','root','81.0.57.125','2020-02-05 13:02:01','','b'),('app=db&mod=cat_comandes&_=b&queryfield=*&query=%27%27','root','81.0.57.125','2020-02-05 13:02:07','','b'),('app=db&mod=cat_comandes&_=b&queryfield=*','root','81.0.57.125','2020-02-05 13:02:10','','b'),('app=db&mod=cat_comandes&_=b','root','81.0.57.125','2020-02-05 13:02:20','','b'),('app=db&mod=cat_comandes&_=b&v2=*','root','81.0.57.125','2020-02-05 13:02:13','','b'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-05 13:02:23','','e'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-05 13:02:43','','e'),('app=pref&mod=sys_apps&_=b','root','81.0.57.125','2020-02-05 13:02:44','','b'),('app=db&mod=cat_comandes&_=b','root','81.0.57.125','2020-02-05 13:02:46','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:49','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=1','root','81.0.57.125','2020-02-05 13:02:51','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 13:02:55','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:47','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=9','root','81.0.57.125','2020-02-05 13:02:58','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 13:02:06','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 13:02:08','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 13:02:12','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 13:02:05','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=10','root','81.0.57.125','2020-02-05 13:02:08','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=10','root','81.0.57.125','2020-02-05 13:02:25','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 13:02:27','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 13:02:43','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 13:02:47','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 13:02:05','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=11','root','81.0.57.125','2020-02-05 13:02:09','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 13:02:27','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=11','root','81.0.57.125','2020-02-05 13:02:32','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-05 13:02:23','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 14:02:56','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=11','root','81.0.57.125','2020-02-05 14:02:00','','b'),('app=db&mod=cat_sales&queryfield=operation&query=11&_=e&id=5','root','81.0.57.125','2020-02-05 14:02:03','','e'),('app=db&mod=cat_sales&queryfield=operation&query=11&_=b','root','81.0.57.125','2020-02-05 14:02:07','','b'),('app=db&mod=cat_sales&queryfield=operation&query=11&_=e&id=5','root','81.0.57.125','2020-02-05 14:02:10','','e'),('','root','81.0.57.125','2020-02-05 18:02:06','','login'),('','root','81.0.57.125','2020-02-05 18:02:06','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-05 18:02:08','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-05 18:02:09','','b'),('','root','81.0.57.125','2020-02-05 18:02:17','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-05 18:02:20','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-05 18:02:21','','b'),('_=b&app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-05 18:02:23','','b'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-05 18:02:25','','e'),('app=pref&mod=sys_apps&_=e&id=3','root','81.0.57.125','2020-02-05 18:02:47','','e'),('app=pref&mod=sys_apps&_=b','root','81.0.57.125','2020-02-05 18:02:48','','b'),('','root','81.0.57.125','2020-02-05 18:02:50','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-05 18:02:51','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-05 18:02:52','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-05 18:02:54','','b'),('_=b&app=pref&mod=ecom&menu=1&view=','root','81.0.57.125','2020-02-05 18:02:38','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-05 18:02:39','','b'),('_=f&id=3&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-05 18:02:42','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=clients&queryfield=mod_id','root','81.0.57.125','2020-02-05 18:02:43','','b'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=clients&queryfield=mod_id','root','81.0.57.125','2020-02-05 18:02:49','','b'),('_=b&app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-05 18:02:31','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-05 18:02:33','','b'),('','root','81.0.57.125','2020-02-05 18:02:49','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-05 18:02:51','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-05 18:02:51','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:53','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=12','root','81.0.57.125','2020-02-05 18:02:57','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-05 18:02:29','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-05 18:02:29','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-05 18:02:04','','b'),('_=f&id=5&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-05 18:02:20','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=comandes&queryfield=mod_id','root','81.0.57.125','2020-02-05 18:02:20','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:00','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:02','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-05 18:02:12','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-05 18:02:19','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-05 18:02:56','','b'),('','root','81.0.57.125','2020-02-05 18:02:30','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-05 18:02:32','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-05 18:02:33','','b'),('_=f&id=3&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-05 18:02:40','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=clients&queryfield=mod_id','root','81.0.57.125','2020-02-05 18:02:40','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=50&_action=Duplicate','root','81.0.57.125','2020-02-05 18:02:45','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=50','root','81.0.57.125','2020-02-05 18:02:48','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-05 18:02:49','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=50&_action=delete_confirm','root','81.0.57.125','2020-02-05 18:02:53','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=50','root','81.0.57.125','2020-02-05 18:02:54','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-05 18:02:54','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-05 18:02:00','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:09','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=12','root','81.0.57.125','2020-02-05 18:02:13','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:21','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:02','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=11&_action=delete_confirm','root','81.0.57.125','2020-02-05 18:02:07','','e'),('app=db&mod=cat_comandes&v2=*&_=e&id=11','root','81.0.57.125','2020-02-05 18:02:10','','e'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-05 18:02:10','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=12&_action=delete_confirm','root','81.0.57.125','2020-02-05 18:02:13','','e'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-05 18:02:15','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=12','root','81.0.57.125','2020-02-05 18:02:17','','b'),('app=db&mod=cat_sales&queryfield=operation&query=12&_=e&id=22&_action=delete_confirm','root','81.0.57.125','2020-02-05 18:02:19','','e'),('app=db&mod=cat_sales&queryfield=operation&query=12&_=e&id=22','root','81.0.57.125','2020-02-05 18:02:21','','e'),('app=db&mod=cat_sales&queryfield=operation&query=12&_=b','root','81.0.57.125','2020-02-05 18:02:21','','b'),('app=db&mod=cat_sales&queryfield=operation&query=12&_=e&id=21&_action=delete_confirm','root','81.0.57.125','2020-02-05 18:02:23','','e'),('app=db&mod=cat_sales&queryfield=operation&query=12&_=e&id=21','root','81.0.57.125','2020-02-05 18:02:24','','e'),('app=db&mod=cat_sales&queryfield=operation&query=12&_=b','root','81.0.57.125','2020-02-05 18:02:25','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:27','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=12&_action=delete_confirm','root','81.0.57.125','2020-02-05 18:02:28','','e'),('app=db&mod=cat_comandes&v2=*&_=e&id=12','root','81.0.57.125','2020-02-05 18:02:30','','e'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-05 18:02:31','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:17','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=1','root','81.0.57.125','2020-02-05 18:02:21','','e'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:23','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=1','root','81.0.57.125','2020-02-05 18:02:30','','b'),('app=db&mod=cat_sales&queryfield=operation&query=1&_=e&id=7','root','81.0.57.125','2020-02-05 18:02:13','','e'),('app=db&mod=cat_sales&queryfield=operation&query=1&_=e&id=6','root','81.0.57.125','2020-02-05 18:02:14','','e'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:32','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=1','root','81.0.57.125','2020-02-05 18:02:35','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-05 18:02:39','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-05 18:02:42','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-05 18:02:50','','b'),('app=db&mod=cat_clients&v2=*&_=e&id=1&_action=delete_confirm','root','81.0.57.125','2020-02-05 18:02:57','','e'),('app=db&mod=cat_clients&v2=*&_=e&id=1','root','81.0.57.125','2020-02-05 18:02:59','','e'),('app=db&mod=cat_clients&v2=*&_=b','root','81.0.57.125','2020-02-05 18:02:59','','b'),('app=db&mod=cat_clients&v2=*&_=e&id=2&_action=delete_confirm','root','81.0.57.125','2020-02-05 18:02:01','','e'),('app=db&mod=cat_clients&v2=*&_=e&id=2','root','81.0.57.125','2020-02-05 18:02:03','','e'),('app=db&mod=cat_clients&v2=*&_=b','root','81.0.57.125','2020-02-05 18:02:03','','b'),('','admin','83.52.6.124','2020-02-06 11:02:46','','login'),('','admin','83.52.6.123','2020-02-06 11:02:46','','b'),('app=sites&menu=1','admin','83.52.6.123','2020-02-06 11:02:56','','b'),('app=sites&mod=sites_pages&menu=1','admin','83.52.6.124','2020-02-06 11:02:56','','b'),('','admin','83.52.6.123','2020-02-06 11:02:00','','b'),('app=db&menu=1','admin','83.52.6.123','2020-02-06 11:02:03','','b'),('app=db&mod=cat_productes&menu=1','admin','83.52.6.124','2020-02-06 11:02:03','','b'),('app=db&mod=cat_productes&menu=1','admin','83.52.6.124','2020-02-06 11:02:02','','b'),('app=db&mod=cat_productes&_=e&id=1','admin','83.52.6.124','2020-02-06 11:02:06','','e'),('','admin','212.106.235.26','2020-02-06 17:02:58','','login'),('','admin','212.106.235.26','2020-02-06 17:02:59','','b'),('app=db&menu=1','admin','212.106.235.26','2020-02-06 17:02:14','','b'),('app=db&mod=cat_productes&menu=1','admin','212.106.235.26','2020-02-06 17:02:14','','b'),('app=db&mod=cat_productes&menu=1','admin','212.106.235.26','2020-02-06 17:02:22','','b'),('app=db&mod=cat_productes&_=e&id=49','admin','212.106.235.26','2020-02-06 17:02:26','','e'),('','root','81.0.57.125','2020-02-06 17:02:45','','login'),('','root','81.0.57.125','2020-02-06 17:02:45','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-06 17:02:47','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-06 17:02:47','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-06 18:02:22','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-06 18:02:33','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-06 18:02:29','','b'),('','root','81.0.57.125','2020-02-06 18:02:59','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-06 18:02:01','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-06 18:02:01','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-06 18:02:27','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-06 18:02:31','','b'),('','root','81.0.57.125','2020-02-07 10:02:33','','login'),('','root','81.0.57.125','2020-02-07 10:02:33','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-07 10:02:35','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-07 10:02:35','','b'),('app=db&mod=sites_pages&v2=*','root','81.0.57.125','2020-02-07 10:02:38','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=1&_action=Duplicate','root','81.0.57.125','2020-02-07 10:02:48','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=1','root','81.0.57.125','2020-02-07 10:02:34','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-07 10:02:34','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=3&_action=Duplicate','root','81.0.57.125','2020-02-07 10:02:40','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=3','root','81.0.57.125','2020-02-07 10:02:22','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-07 10:02:22','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=3&_action=Duplicate','root','81.0.57.125','2020-02-07 10:02:16','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=3','root','81.0.57.125','2020-02-07 10:02:25','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-07 10:02:25','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=5&_action=Duplicate','root','81.0.57.125','2020-02-07 10:02:30','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=5','root','81.0.57.125','2020-02-07 10:02:37','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-07 10:02:38','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=6','root','81.0.57.125','2020-02-07 10:02:55','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=6','root','81.0.57.125','2020-02-07 10:02:59','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-07 10:02:59','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=5','root','81.0.57.125','2020-02-07 10:02:11','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=5','root','81.0.57.125','2020-02-07 10:02:14','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-07 10:02:15','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=6','root','81.0.57.125','2020-02-07 10:02:36','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-07 10:02:44','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-07 10:02:54','','b'),('','root','81.0.57.125','2020-02-07 10:02:07','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-07 10:02:09','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 10:02:11','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 10:02:14','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-07 10:02:14','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=32&_action=delete_confirm','root','81.0.57.125','2020-02-07 10:02:22','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=32','root','81.0.57.125','2020-02-07 10:02:24','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-07 10:02:24','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=18&_action=Duplicate','root','81.0.57.125','2020-02-07 10:02:29','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=18','root','81.0.57.125','2020-02-07 10:02:48','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-07 10:02:48','','b'),('_=b&app=pref&mod=sys_apps&menu=1&view=','root','81.0.57.125','2020-02-07 10:02:59','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 10:02:01','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-07 10:02:04','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-07 10:02:10','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 10:02:10','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-07 10:02:13','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-07 10:02:27','','e'),('','root','81.0.57.125','2020-02-07 10:02:38','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-07 10:02:40','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 10:02:41','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 10:02:45','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-07 10:02:46','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-07 11:02:20','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 11:02:20','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-07 11:02:23','','b'),('','root','81.0.57.125','2020-02-07 11:02:53','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-07 11:02:55','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-07 11:02:55','','b'),('app=db&mod=cat_productes&_=e&id=23','root','81.0.57.125','2020-02-07 11:02:05','','e'),('app=db&mod=cat_productes&_=e&id=23','root','81.0.57.125','2020-02-07 11:02:43','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-07 11:02:43','','b'),('app=db&mod=cat_productes&_=e&id=33','root','81.0.57.125','2020-02-07 11:02:49','','e'),('app=db&mod=cat_productes&_=e&id=33','root','81.0.57.125','2020-02-07 11:02:44','','e'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-07 11:02:44','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-07 11:02:04','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-07 11:02:09','','b'),('app=db&mod=cat_productes&_=b&sortby=creation_date&sortdir=desc&xid=','root','81.0.57.125','2020-02-07 11:02:15','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-07 11:02:28','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-07 11:02:36','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 11:02:36','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-07 11:02:38','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 11:02:58','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-07 11:02:58','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=2','root','81.0.57.125','2020-02-07 11:02:02','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=2','root','81.0.57.125','2020-02-07 11:02:10','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-07 11:02:10','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-07 11:02:27','','b'),('app=db&mod=cat_productes&v2=*&_=b','root','81.0.57.125','2020-02-07 11:02:20','','b'),('app=db&mod=cat_productes&v2=*&op=like&_=b','root','81.0.57.125','2020-02-07 11:02:28','','b'),('app=db&mod=cat_productes&v2=*&op=like&_=b','root','81.0.57.125','2020-02-07 11:02:33','','b'),('app=db&mod=cat_productes&v2=*&op=like&_=e&id=2','root','81.0.57.125','2020-02-07 11:02:37','','e'),('app=db&mod=cat_productes&v2=*&op=like&_=e&id=2','root','81.0.57.125','2020-02-07 11:02:17','','e'),('app=db&mod=cat_productes&v2=*&op=like&_=b','root','81.0.57.125','2020-02-07 11:02:18','','b'),('','root','81.0.57.125','2020-02-07 12:02:42','','login'),('','root','81.0.57.125','2020-02-07 12:02:42','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-07 12:02:43','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 12:02:45','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 12:02:48','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-07 12:02:49','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=7&_action=delete_confirm','root','81.0.57.125','2020-02-07 12:02:53','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=e&id=7','root','81.0.57.125','2020-02-07 12:02:55','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=productes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-07 12:02:55','','b'),('','root','81.0.57.125','2020-02-07 14:02:37','','login'),('','root','81.0.57.125','2020-02-07 14:02:38','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-07 14:02:39','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-07 14:02:39','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 14:02:43','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=5','root','81.0.57.125','2020-02-07 14:02:48','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=5','root','81.0.57.125','2020-02-07 14:02:19','','b'),('app=db&mod=cat_sales&queryfield=operation&query=5&_=e&id=37&_action=delete_confirm','root','81.0.57.125','2020-02-07 14:02:46','','e'),('app=db&mod=cat_sales&queryfield=operation&query=5&_=e&id=37','root','81.0.57.125','2020-02-07 14:02:49','','e'),('app=db&mod=cat_sales&queryfield=operation&query=5&_=b','root','81.0.57.125','2020-02-07 14:02:49','','b'),('app=db&mod=cat_sales&queryfield=operation&query=5&_=b','root','81.0.57.125','2020-02-07 14:02:16','','b'),('app=db&mod=cat_sales&queryfield=operation&query=5&_=b','root','81.0.57.125','2020-02-07 14:02:35','','b'),('app=db&mod=cat_sales&queryfield=operation&query=5&_=b','root','81.0.57.125','2020-02-07 14:02:43','','b'),('app=db&mod=cat_sales&queryfield=operation&query=5&_=e&id=39','root','81.0.57.125','2020-02-07 14:02:55','','e'),('app=db&mod=cat_sales&queryfield=operation&query=5&_=e&id=39','root','81.0.57.125','2020-02-07 14:02:32','','e'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-07 14:02:55','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-07 14:02:00','','b'),('app=db&mod=cat_autors&v2=*','root','81.0.57.125','2020-02-07 14:02:04','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-07 14:02:06','','b'),('app=db&mod=cat_productes','root','81.0.57.125','2020-02-07 14:02:29','','b'),('app=db&mod=cat_productes&_=b','root','81.0.57.125','2020-02-07 14:02:32','','b'),('','root','81.0.57.125','2020-02-07 14:02:35','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-07 14:02:37','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 14:02:39','','b'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-07 14:02:43','','e'),('app=pref&mod=sys_mod&_=e&id=1','root','81.0.57.125','2020-02-07 14:02:48','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 14:02:48','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 14:02:53','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-07 14:02:54','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 14:02:47','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=5','root','81.0.57.125','2020-02-07 14:02:52','','b'),('','root','81.0.57.125','2020-02-07 16:02:30','','login'),('','root','81.0.57.125','2020-02-07 16:02:31','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-07 16:02:32','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-07 16:02:33','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 16:02:42','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=6','root','81.0.57.125','2020-02-07 16:02:44','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=6','root','81.0.57.125','2020-02-07 16:02:52','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=6','root','81.0.57.125','2020-02-07 16:02:20','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-07 16:02:24','','b'),('app=db&mod=cat_productes&v2=*&_=e&id=1','root','81.0.57.125','2020-02-07 16:02:28','','e'),('','root','81.0.57.125','2020-02-07 18:02:18','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-07 18:02:19','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 18:02:21','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 18:02:26','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-07 18:02:26','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 18:02:35','','b'),('_=f&id=5&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 18:02:40','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=comandes&queryfield=mod_id','root','81.0.57.125','2020-02-07 18:02:40','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=70&_action=Duplicate','root','81.0.57.125','2020-02-07 18:02:48','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=70','root','81.0.57.125','2020-02-07 18:02:06','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-07 18:02:06','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=74&_action=Duplicate','root','81.0.57.125','2020-02-07 18:02:11','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=74','root','81.0.57.125','2020-02-07 18:02:24','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-07 18:02:24','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=70&_action=Duplicate','root','81.0.57.125','2020-02-07 18:02:59','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=70','root','81.0.57.125','2020-02-07 18:02:08','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-07 18:02:09','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=1&sortby=sort_order&sortdir=asc&query=comandes&queryfield=mod_id','root','81.0.57.125','2020-02-07 18:02:13','','b'),('_=b&app=pref&mod=sys_mod_attributes&menu=1&view=&v2=&sortable=0&sortby=sort_order&query=comandes&queryfield=mod_id','root','81.0.57.125','2020-02-07 18:02:28','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 18:02:31','','b'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-07 18:02:36','','e'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-07 18:02:58','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 18:02:58','','b'),('','root','81.0.57.125','2020-02-07 18:02:02','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-07 18:02:04','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-07 18:02:04','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:06','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:02','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:22','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:23','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:58','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:50','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:21','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:27','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:53','','b'),('','root','81.0.57.125','2020-02-07 18:02:06','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-07 18:02:08','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 18:02:09','','b'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-07 18:02:29','','e'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-07 18:02:38','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 18:02:38','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:56','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:15','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:50','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:10','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:23','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:32','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:45','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:48','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:54','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:12','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:39','','b'),('app=db&mod=cat_clients&app=db&menu=1&_=e&id=4','root','81.0.57.125','2020-02-07 18:02:42','','e'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:46','','b'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-07 18:02:00','','e'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-07 18:02:17','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 18:02:17','','b'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 18:02:52','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:55','','b'),('app=db&mod=cat_clients&app=db&menu=1&_=e&id=4','root','81.0.57.125','2020-02-07 18:02:06','','e'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:09','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:18','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-07 18:02:26','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:31','','b'),('app=db&mod=cat_autors&v2=*','root','81.0.57.125','2020-02-07 18:02:34','','b'),('app=db&mod=cat_autors&v2=*&_=e&id=42','root','81.0.57.125','2020-02-07 18:02:45','','e'),('app=db&mod=cat_autors&v2=*&_=b','root','81.0.57.125','2020-02-07 18:02:51','','b'),('app=pref&mod=sys_mod&_=e&id=2','root','81.0.57.125','2020-02-07 18:02:06','','e'),('app=pref&mod=sys_mod&_=e&id=2','root','81.0.57.125','2020-02-07 18:02:22','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 18:02:23','','b'),('app=db&mod=cat_autors&v2=*','root','81.0.57.125','2020-02-07 18:02:25','','b'),('app=pref&mod=sys_mod&_=e&id=2','root','81.0.57.125','2020-02-07 18:02:37','','e'),('app=pref&mod=sys_mod&_=e&id=2','root','81.0.57.125','2020-02-07 18:02:44','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 18:02:44','','b'),('app=db&mod=cat_autors&v2=*','root','81.0.57.125','2020-02-07 18:02:45','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 18:02:53','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-07 18:02:58','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-07 19:02:01','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 19:02:04','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=3','root','81.0.57.125','2020-02-07 19:02:09','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 19:02:12','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-07 19:02:12','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=63&_action=delete_confirm','root','81.0.57.125','2020-02-07 19:02:16','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=63','root','81.0.57.125','2020-02-07 19:02:18','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=b','root','81.0.57.125','2020-02-07 19:02:18','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 19:02:13','','b'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-07 19:02:18','','e'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-07 19:02:23','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 19:02:24','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=3','root','81.0.57.125','2020-02-07 19:02:30','','b'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-07 19:02:40','','e'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-07 19:02:01','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 19:02:01','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=3','root','81.0.57.125','2020-02-07 19:02:03','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 19:02:13','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-07 19:02:13','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=58&_action=Duplicate','root','81.0.57.125','2020-02-07 19:02:16','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=58','root','81.0.57.125','2020-02-07 19:02:46','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=58&_=b','root','81.0.57.125','2020-02-07 19:02:51','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=3','root','81.0.57.125','2020-02-07 19:02:52','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 19:02:58','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=3','root','81.0.57.125','2020-02-07 19:02:12','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 19:02:18','','b'),('_=f&id=5&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 19:02:23','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=comandes&queryfield=mod_id','root','81.0.57.125','2020-02-07 19:02:23','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=68&_action=Duplicate','root','81.0.57.125','2020-02-07 19:02:26','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=68','root','81.0.57.125','2020-02-07 19:02:57','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=68&_=b','root','81.0.57.125','2020-02-07 19:02:59','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=3','root','81.0.57.125','2020-02-07 19:02:01','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-07 19:02:02','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 19:02:58','','b'),('_=f&id=1&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 19:02:05','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=productes&queryfield=mod_id','root','81.0.57.125','2020-02-07 19:02:05','','b'),('app=db&mod=sites_pages&v2=*','root','81.0.57.125','2020-02-07 19:02:27','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=5','root','81.0.57.125','2020-02-07 19:02:30','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=5','root','81.0.57.125','2020-02-07 19:02:05','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-07 19:02:05','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=6','root','81.0.57.125','2020-02-07 19:02:09','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=6','root','81.0.57.125','2020-02-07 19:02:29','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-07 19:02:29','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=5','root','81.0.57.125','2020-02-07 19:02:41','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=5','root','81.0.57.125','2020-02-07 19:02:49','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-07 19:02:49','','b'),('','root','81.0.57.125','2020-02-07 20:02:20','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-07 20:02:22','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 20:02:23','','b'),('_=f&id=3&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 20:02:28','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=clients&queryfield=mod_id','root','81.0.57.125','2020-02-07 20:02:28','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=72&_action=Duplicate','root','81.0.57.125','2020-02-07 20:02:32','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=e&id=72','root','81.0.57.125','2020-02-07 20:02:41','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=clients&sortby=sort_order&_=b','root','81.0.57.125','2020-02-07 20:02:41','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-07 21:02:14','','b'),('app=pref&mod=sys_mod&_=e&id=3','root','81.0.57.125','2020-02-07 21:02:20','','e'),('app=pref&mod=sys_mod&_=e&id=3','root','81.0.57.125','2020-02-07 21:02:27','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-07 21:02:27','','b'),('_=f&id=3&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-07 21:02:29','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=clients&queryfield=mod_id','root','81.0.57.125','2020-02-07 21:02:30','','b'),('','root','81.0.57.125','2020-02-07 21:02:37','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-07 21:02:39','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-07 21:02:39','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-07 21:02:41','','b'),('','root','81.0.57.125','2020-02-10 13:02:07','','login'),('','root','81.0.57.125','2020-02-10 13:02:08','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-10 13:02:09','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-10 13:02:10','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-10 13:02:12','','b'),('','root','81.0.57.125','2020-02-10 13:02:05','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-10 13:02:07','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-10 13:02:09','','b'),('_=f&id=5&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-10 13:02:12','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=comandes&queryfield=mod_id','root','81.0.57.125','2020-02-10 13:02:12','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=78&_action=Duplicate','root','81.0.57.125','2020-02-10 13:02:15','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=78','root','81.0.57.125','2020-02-10 13:02:36','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:36','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=78&_action=Duplicate','root','81.0.57.125','2020-02-10 13:02:58','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=78','root','81.0.57.125','2020-02-10 13:02:19','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:20','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=80&_action=Duplicate','root','81.0.57.125','2020-02-10 13:02:52','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=80','root','81.0.57.125','2020-02-10 13:02:13','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:13','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=82&_action=Duplicate','root','81.0.57.125','2020-02-10 13:02:52','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=82','root','81.0.57.125','2020-02-10 13:02:02','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:03','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=83&_action=Duplicate','root','81.0.57.125','2020-02-10 13:02:17','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=83','root','81.0.57.125','2020-02-10 13:02:27','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:28','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=81&_action=Duplicate','root','81.0.57.125','2020-02-10 13:02:57','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=81','root','81.0.57.125','2020-02-10 13:02:13','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:13','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=85&_action=Duplicate','root','81.0.57.125','2020-02-10 13:02:20','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=85','root','81.0.57.125','2020-02-10 13:02:29','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:30','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=70&_action=Duplicate','root','81.0.57.125','2020-02-10 13:02:39','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=70','root','81.0.57.125','2020-02-10 13:02:54','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:54','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=82&_action=Duplicate','root','81.0.57.125','2020-02-10 13:02:15','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=82','root','81.0.57.125','2020-02-10 13:02:47','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:47','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=88&_action=Duplicate','root','81.0.57.125','2020-02-10 13:02:55','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=88','root','81.0.57.125','2020-02-10 13:02:12','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:13','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=84&_action=delete_confirm','root','81.0.57.125','2020-02-10 13:02:41','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=e&id=84','root','81.0.57.125','2020-02-10 13:02:44','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=comandes&sortby=sort_order&_=b','root','81.0.57.125','2020-02-10 13:02:44','','b'),('','root','81.0.57.125','2020-02-10 13:02:02','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-10 13:02:04','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-10 13:02:04','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-10 13:02:07','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-10 13:02:11','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-10 13:02:26','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=10','root','81.0.57.125','2020-02-10 13:02:28','','e'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-10 13:02:10','','b'),('app=db&mod=cat_clients&v2=*&_=e&id=52','root','81.0.57.125','2020-02-10 13:02:14','','e'),('','root','81.0.57.125','2020-02-11 10:02:39','','login'),('','root','81.0.57.125','2020-02-11 10:02:40','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-11 10:02:41','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-11 10:02:42','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-11 10:02:47','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-11 10:02:53','','b'),('app=db&mod=cat_autors&v2=*','root','81.0.57.125','2020-02-11 10:02:56','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-11 10:02:59','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-11 10:02:01','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-11 10:02:08','','b'),('','root','81.0.57.125','2020-02-11 10:02:10','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-11 10:02:11','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-11 10:02:13','','b'),('','root','81.0.57.125','2020-02-11 10:02:35','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-11 10:02:36','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-11 10:02:37','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-11 10:02:40','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-11 10:02:53','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=','root','81.0.57.125','2020-02-11 10:02:04','','b'),('','root','81.0.57.125','2020-02-11 13:02:52','','login'),('','root','81.0.57.125','2020-02-11 13:02:52','','b'),('','root','81.0.57.125','2020-02-11 13:02:52','','login'),('','root','81.0.57.125','2020-02-11 13:02:52','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-11 13:02:54','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-11 13:02:54','','b'),('app=db&mod=cat_sales&queryfield=operation&_=e&id=3','root','81.0.57.125','2020-02-11 13:02:18','','e'),('','root','81.0.57.125','2020-02-12 12:02:50','','login'),('','root','81.0.57.125','2020-02-12 12:02:50','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-12 12:02:52','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-12 12:02:53','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:57','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:33','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:51','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-12 12:02:59','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-12 12:02:05','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=','root','81.0.57.125','2020-02-12 12:02:11','','b'),('','root','81.0.57.125','2020-02-12 12:02:19','','login'),('','root','81.0.57.125','2020-02-12 12:02:19','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-12 12:02:22','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-12 12:02:22','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:25','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:29','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:13','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:26','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=1','root','81.0.57.125','2020-02-12 12:02:03','','e'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:04','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:16','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:22','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:42','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:45','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:53','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=1&_action=delete_confirm','root','81.0.57.125','2020-02-12 12:02:03','','e'),('app=db&mod=cat_comandes&v2=*&_=e&id=1','root','81.0.57.125','2020-02-12 12:02:06','','e'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:06','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:09','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:27','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:57','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=1&_action=delete_confirm','root','81.0.57.125','2020-02-12 12:02:59','','e'),('app=db&mod=cat_comandes&v2=*&_=e&id=1','root','81.0.57.125','2020-02-12 12:02:01','','e'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:02','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 12:02:22','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=1&_action=delete_confirm','root','81.0.57.125','2020-02-12 12:02:42','','e'),('app=db&mod=cat_comandes&v2=*&_=e&id=1','root','81.0.57.125','2020-02-12 12:02:45','','e'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:45','','b'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:58','','b'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:27','','b'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:40','','b'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:30','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-12 12:02:49','','b'),('app=db&mod=cat_sales&queryfield=operation&_=e&id=5','root','81.0.57.125','2020-02-12 12:02:58','','e'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 12:02:33','','b'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:51','','b'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 12:02:47','','b'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:54','','b'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:06','','b'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 12:02:30','','b'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 12:02:43','','b'),('','root','81.0.57.125','2020-02-12 12:02:55','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-12 12:02:57','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-12 12:02:59','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-12 12:02:04','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-12 12:02:05','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=62','root','81.0.57.125','2020-02-12 12:02:09','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=62','root','81.0.57.125','2020-02-12 12:02:19','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=b','root','81.0.57.125','2020-02-12 12:02:19','','b'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 12:02:25','','b'),('_=b&app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-12 12:02:00','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-12 12:02:03','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-12 12:02:04','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=62&_action=Duplicate','root','81.0.57.125','2020-02-12 12:02:10','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=62','root','81.0.57.125','2020-02-12 12:02:19','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=b','root','81.0.57.125','2020-02-12 12:02:19','','b'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=62','root','81.0.57.125','2020-02-12 12:02:23','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=e&id=62','root','81.0.57.125','2020-02-12 12:02:31','','e'),('app=pref&mod=sys_mod_attributes&op=equal&queryfield=mod_id&query=sales&sortby=sort_order&_=b','root','81.0.57.125','2020-02-12 12:02:31','','b'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 13:02:04','','b'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 13:02:07','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=1&_action=delete_confirm','root','81.0.57.125','2020-02-12 13:02:22','','e'),('app=db&mod=cat_comandes&v2=*&_=e&id=1','root','81.0.57.125','2020-02-12 13:02:24','','e'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-12 13:02:24','','b'),('app=db&mod=cat_sales&_=b','root','81.0.57.125','2020-02-12 13:02:48','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:56','','b'),('app=db&mod=cat_sales&_=b','root','81.0.57.125','2020-02-12 13:02:07','','b'),('','root','81.0.57.125','2020-02-12 13:02:14','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-12 13:02:16','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-12 13:02:18','','b'),('_=f&id=4&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-12 13:02:27','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=sales&queryfield=mod_id','root','81.0.57.125','2020-02-12 13:02:28','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-12 13:02:29','','b'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-12 13:02:32','','e'),('app=pref&mod=sys_mod&_=e&id=4','root','81.0.57.125','2020-02-12 13:02:44','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-12 13:02:44','','b'),('app=db&mod=cat_sales&_=b','root','81.0.57.125','2020-02-12 13:02:48','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:04','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-12 13:02:07','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:11','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-12 13:02:25','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:29','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-12 13:02:48','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-12 13:02:51','','b'),('app=db&mod=cat_sales&queryfield=operation&_=e&id=6','root','81.0.57.125','2020-02-12 13:02:55','','e'),('app=db&mod=cat_sales&queryfield=operation&_=e&id=6','root','81.0.57.125','2020-02-12 13:02:00','','e'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 13:02:01','','b'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 13:02:17','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:40','','b'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 13:02:19','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:29','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:58','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:07','','b'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 13:02:02','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:06','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:13','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:55','','b'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 13:02:44','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:46','','b'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 13:02:59','','b'),('app=db&mod=cat_sales&queryfield=operation&_=b','root','81.0.57.125','2020-02-12 13:02:49','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:52','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:02','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:15','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:31','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:03','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:13','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:43','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:11','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 13:02:20','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 14:02:52','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-12 14:02:50','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=','root','81.0.57.125','2020-02-12 14:02:04','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=','root','81.0.57.125','2020-02-12 14:02:02','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=','root','81.0.57.125','2020-02-12 14:02:13','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=','root','81.0.57.125','2020-02-12 14:02:21','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=','root','81.0.57.125','2020-02-12 14:02:51','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=','root','81.0.57.125','2020-02-12 14:02:01','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-12 14:02:06','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b&queryfield=id&query=','root','81.0.57.125','2020-02-12 14:02:11','','b'),('app=db&mod=cat_comandes&queryfield=id&_=e&id=1','root','81.0.57.125','2020-02-12 14:02:59','','e'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 14:02:20','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=1','root','81.0.57.125','2020-02-12 14:02:39','','e'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 14:02:01','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 14:02:32','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 14:02:14','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 14:02:36','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 14:02:21','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-12 14:02:26','','b'),('app=db&mod=cat_comandes&_=b&queryfield=*&query=%27%27','root','81.0.57.125','2020-02-12 14:02:39','','b'),('app=db&mod=cat_comandes&_=b','root','81.0.57.125','2020-02-12 14:02:43','','b'),('app=db&mod=cat_comandes&_=b&queryfield=*&query=%27%27','root','81.0.57.125','2020-02-12 14:02:49','','b'),('app=db&mod=cat_comandes','root','81.0.57.125','2020-02-12 14:02:52','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 14:02:54','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=','root','81.0.57.125','2020-02-12 14:02:24','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-12 14:02:42','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b','root','81.0.57.125','2020-02-12 14:02:46','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b','root','81.0.57.125','2020-02-12 14:02:22','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b','root','81.0.57.125','2020-02-12 14:02:52','','b'),('app=db&mod=cat_comandes&app=db&menu=1&_=b','root','81.0.57.125','2020-02-12 14:02:58','','b'),('','root','81.0.57.125','2020-02-13 11:02:28','','login'),('','root','81.0.57.125','2020-02-13 11:02:29','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-13 11:02:31','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-13 11:02:32','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 11:02:35','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 11:02:02','','b'),('','root','81.0.57.125','2020-02-13 11:02:13','','b'),('app=pref&menu=1','root','81.0.57.125','2020-02-13 11:02:15','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-13 11:02:17','','b'),('_=f&id=5&app=pref&mod=sys_mod&action=mod_edit_attributes','root','81.0.57.125','2020-02-13 11:02:21','','f'),('app=pref&mod=sys_mod_attributes&menu=1&view=&op=equal&query=comandes&queryfield=mod_id','root','81.0.57.125','2020-02-13 11:02:22','','b'),('app=pref&mod=sys_mod&menu=1&view=','root','81.0.57.125','2020-02-13 11:02:27','','b'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-13 11:02:33','','e'),('app=pref&mod=sys_mod&_=e&id=5','root','81.0.57.125','2020-02-13 11:02:52','','e'),('app=pref&mod=sys_mod&_=b','root','81.0.57.125','2020-02-13 11:02:53','','b'),('','root','81.0.57.125','2020-02-13 11:02:55','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-13 11:02:56','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-13 11:02:57','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 11:02:59','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 12:02:42','','b'),('','root','81.0.57.125','2020-02-13 13:02:30','','login'),('','root','81.0.57.125','2020-02-13 13:02:30','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-13 13:02:32','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-13 13:02:33','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 13:02:34','','b'),('','root','81.0.57.125','2020-02-13 14:02:33','','login'),('','root','81.0.57.125','2020-02-13 14:02:33','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-13 14:02:35','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-13 14:02:35','','b'),('app=db&mod=cat_autors&v2=*','root','81.0.57.125','2020-02-13 14:02:37','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-13 14:02:41','','b'),('app=db&mod=cat_clients&v2=*&_=e&id=23','root','81.0.57.125','2020-02-13 14:02:43','','e'),('','root','81.0.57.125','2020-02-13 18:02:56','','login'),('','root','81.0.57.125','2020-02-13 18:02:56','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-13 18:02:58','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-13 18:02:58','','b'),('app=db&mod=cat_autors&v2=*','root','81.0.57.125','2020-02-13 18:02:02','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 18:02:04','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-13 18:02:51','','b'),('app=db&mod=cat_productes&v2=*&_=b','root','81.0.57.125','2020-02-13 18:02:56','','b'),('app=db&mod=cat_productes&v2=*&op=like&_=b','root','81.0.57.125','2020-02-13 18:02:02','','b'),('app=db&mod=cat_productes&v2=*&op=like&_=b','root','81.0.57.125','2020-02-13 18:02:08','','b'),('app=db&mod=cat_productes&v2=*&op=like&_=b','root','81.0.57.125','2020-02-13 18:02:31','','b'),('app=db&mod=cat_productes&v2=*&op=like&_=e&id=4','root','81.0.57.125','2020-02-13 18:02:34','','e'),('app=db&mod=cat_productes&v2=*&op=like&_=e&id=4','root','81.0.57.125','2020-02-13 18:02:19','','e'),('app=db&mod=cat_productes&v2=*&op=like&_=b','root','81.0.57.125','2020-02-13 18:02:20','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 19:02:25','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 19:02:28','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 19:02:35','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 19:02:31','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 19:02:07','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 19:02:57','','b'),('app=db&mod=cat_clients&app=db&menu=1&_=e&id=35','root','81.0.57.125','2020-02-13 19:02:04','','e'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-13 19:02:07','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 19:02:10','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-13 19:02:14','','b'),('','root','81.0.57.125','2020-02-13 19:02:32','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-13 19:02:45','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-13 19:02:45','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-13 19:02:47','','b'),('','root','81.0.57.125','2020-02-14 10:02:41','','login'),('','root','81.0.57.125','2020-02-14 10:02:42','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-14 10:02:44','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-14 10:02:45','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-14 10:02:48','','b'),('','root','81.0.57.125','2020-02-14 18:02:11','','login'),('','root','81.0.57.125','2020-02-14 18:02:11','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-14 18:02:12','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-14 18:02:13','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-14 18:02:15','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=11','root','81.0.57.125','2020-02-14 18:02:37','','b'),('app=db&mod=cat_sales&queryfield=operation&query=11&_=e&id=41','root','81.0.57.125','2020-02-14 18:02:10','','e'),('','root','81.0.57.125','2020-02-18 11:02:53','','login'),('','root','81.0.57.125','2020-02-18 11:02:54','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-18 11:02:57','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-18 11:02:58','','b'),('app=db&mod=sites_pages&v2=*','root','81.0.57.125','2020-02-18 11:02:02','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=3','root','81.0.57.125','2020-02-18 11:02:10','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=3','root','81.0.57.125','2020-02-18 11:02:08','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-18 11:02:10','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=3','root','81.0.57.125','2020-02-18 11:02:35','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=3','root','81.0.57.125','2020-02-18 11:02:51','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-18 11:02:53','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=3','root','81.0.57.125','2020-02-18 11:02:48','','e'),('app=db&mod=sites_pages&v2=*&_=e&id=3','root','81.0.57.125','2020-02-18 11:02:12','','e'),('app=db&mod=sites_pages&v2=*&_=b','root','81.0.57.125','2020-02-18 11:02:13','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:54','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:07','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=15&_action=delete_confirm','root','81.0.57.125','2020-02-18 11:02:10','','e'),('app=db&mod=cat_comandes&v2=*&_=e&id=15','root','81.0.57.125','2020-02-18 11:02:12','','e'),('app=db&mod=cat_comandes&v2=*&_=b','root','81.0.57.125','2020-02-18 11:02:12','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-18 11:02:14','','b'),('app=db&mod=cat_autors&v2=*','root','81.0.57.125','2020-02-18 11:02:17','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:19','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:56','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=1','root','81.0.57.125','2020-02-18 11:02:04','','b'),('app=db&mod=cat_sales&queryfield=operation&query=1&_=e&id=51','root','81.0.57.125','2020-02-18 11:02:28','','e'),('app=db&mod=cat_sales&queryfield=operation&query=1&_=b','root','81.0.57.125','2020-02-18 11:02:57','','b'),('app=db&mod=cat_sales&queryfield=operation&query=1&_=e&id=51','root','81.0.57.125','2020-02-18 11:02:01','','e'),('app=db&mod=cat_sales&queryfield=operation&query=1&_=e&id=51','root','81.0.57.125','2020-02-18 11:02:04','','e'),('app=db&mod=cat_sales&queryfield=operation&query=1&_=b','root','81.0.57.125','2020-02-18 11:02:04','','b'),('app=db&mod=cat_sales&queryfield=operation&query=1&_=b','root','81.0.57.125','2020-02-18 11:02:29','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:32','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=1','root','81.0.57.125','2020-02-18 11:02:36','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:41','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=2','root','81.0.57.125','2020-02-18 11:02:51','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:07','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:05','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=2','root','81.0.57.125','2020-02-18 11:02:14','','e'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:21','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:34','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:47','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:15','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=3','root','81.0.57.125','2020-02-18 11:02:15','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:25','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:34','','b'),('app=db&mod=cat_comandes&v2=*&_=e&id=3','root','81.0.57.125','2020-02-18 11:02:42','','e'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:16','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:49','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:07','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:14','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=3','root','81.0.57.125','2020-02-18 11:02:18','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 11:02:06','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 12:02:52','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 12:02:05','','b'),('app=db&mod=cat_sales&app=db&menu=1&_=b&queryfield=operation&query=5','root','81.0.57.125','2020-02-18 12:02:38','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 12:02:48','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 12:02:04','','b'),('app=db&mod=cat_comandes&v2=*','root','81.0.57.125','2020-02-18 12:02:13','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-18 12:02:05','','b'),('app=db&mod=cat_clients&v2=*','root','81.0.57.125','2020-02-18 12:02:16','','b'),('app=db&mod=cat_productes&v2=*','root','81.0.57.125','2020-02-18 12:02:18','','b'),('','root','81.0.57.125','2020-02-25 12:02:05','','login'),('','root','81.0.57.125','2020-02-25 12:02:08','','b'),('','root','81.0.57.125','2020-02-25 12:02:10','','b'),('','admin','83.52.3.250','2020-02-25 13:02:25','','login'),('','admin','83.52.3.248','2020-02-25 13:02:26','','b'),('app=db&menu=1','admin','83.52.3.248','2020-02-25 13:02:29','','b'),('app=db&mod=cat_productes&menu=1','admin','83.52.3.250','2020-02-25 13:02:29','','b'),('app=db&mod=sites_lang&v2=*','admin','83.52.3.250','2020-02-25 13:02:35','','b'),('app=db&mod=sites_lang&v2=*','admin','83.52.3.248','2020-02-25 13:02:39','','b'),('app=db&mod=sites_pages&v2=*','admin','83.52.3.250','2020-02-25 13:02:43','','b'),('app=db&mod=sites_pages&v2=*&_=e&id=5','admin','83.52.3.250','2020-02-25 13:02:53','','e'),('','root','81.0.57.125','2020-02-25 13:02:31','','login'),('','root','81.0.57.125','2020-02-25 13:02:32','','b'),('app=db&menu=1','root','81.0.57.125','2020-02-25 13:02:33','','b'),('app=db&mod=cat_productes&menu=1','root','81.0.57.125','2020-02-25 13:02:34','','b'),('app=db&mod=cat_productes&_=e&id=1','root','81.0.57.125','2020-02-25 13:02:39','','e');
/*!40000 ALTER TABLE `kms_sys_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_tags`
--

DROP TABLE IF EXISTS `kms_sys_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_date` date NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `type` varchar(40) NOT NULL DEFAULT '',
  `object_id` int(11) DEFAULT NULL,
  `module` varchar(50) NOT NULL DEFAULT '',
  `color` varchar(50) NOT NULL DEFAULT '',
  `icon` varchar(50) NOT NULL DEFAULT '',
  `owner` varchar(10) NOT NULL DEFAULT '',
  `group` varchar(10) NOT NULL DEFAULT '',
  `description` text,
  `properties` text,
  `reads` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_tags`
--

LOCK TABLES `kms_sys_tags` WRITE;
/*!40000 ALTER TABLE `kms_sys_tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_templates`
--

DROP TABLE IF EXISTS `kms_sys_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `content_type` varchar(20) DEFAULT NULL,
  `template` text,
  `centerpage` varchar(2) DEFAULT NULL,
  `pagewidth` varchar(4) DEFAULT NULL,
  `font` varchar(100) DEFAULT NULL,
  `fontsize` varchar(4) DEFAULT NULL,
  `line-height` varchar(4) DEFAULT NULL,
  `bgcolor` varchar(7) DEFAULT NULL,
  `fontcolor` varchar(7) DEFAULT NULL,
  `linkscolor` varchar(7) DEFAULT NULL,
  `openlinkcolor` varchar(7) DEFAULT NULL,
  `bandabg_color` varchar(7) NOT NULL,
  `bandatext_color` varchar(7) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_templates`
--

LOCK TABLES `kms_sys_templates` WRITE;
/*!40000 ALTER TABLE `kms_sys_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_tickets`
--

DROP TABLE IF EXISTS `kms_sys_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_datetime` date NOT NULL,
  `origin` varchar(30) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_tickets`
--

LOCK TABLES `kms_sys_tickets` WRITE;
/*!40000 ALTER TABLE `kms_sys_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_users`
--

DROP TABLE IF EXISTS `kms_sys_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `creation_date` date DEFAULT NULL,
  `username` varchar(20) NOT NULL DEFAULT '',
  `upassword` varchar(100) NOT NULL,
  `password_type` varchar(45) DEFAULT 'plain',
  `groups` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `notes` text NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '0',
  `language` varchar(2) DEFAULT NULL,
  `autorun_app` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_users`
--

LOCK TABLES `kms_sys_users` WRITE;
/*!40000 ALTER TABLE `kms_sys_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `kms_sys_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kms_sys_views`
--

DROP TABLE IF EXISTS `kms_sys_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kms_sys_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `type` varchar(10) NOT NULL,
  `module` varchar(100) NOT NULL,
  `app` varchar(50) NOT NULL,
  `fields` varchar(200) NOT NULL DEFAULT '',
  `where` varchar(255) NOT NULL,
  `page_rows` int(11) NOT NULL DEFAULT '0',
  `orderby` varchar(20) NOT NULL,
  `groupby` varchar(50) NOT NULL,
  `sort` varchar(4) NOT NULL,
  `code` text NOT NULL,
  `creation_date` date NOT NULL DEFAULT '2019-07-10',
  `extended` text NOT NULL,
  `owner` varchar(20) NOT NULL,
  `group` varchar(20) NOT NULL,
  `sort_order` int(10) NOT NULL,
  `sort_column` varchar(50) NOT NULL,
  `default_view2` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kms_sys_views`
--

LOCK TABLES `kms_sys_views` WRITE;
/*!40000 ALTER TABLE `kms_sys_views` DISABLE KEYS */;
INSERT INTO `kms_sys_views` VALUES (1,'_KMS_CONTACTS_SUBSCRIBERS','top','ent_contacts','imark','','newsletter=\'1\'',100,'','','','','2019-07-10','','','',1,'sort_order',0),(2,'_KMS_CONTACTS_UNSUBSCRIBERS','top','ent_contacts','imark','status,creation_date,fullname,email,location,groups,newsletter,unsubscribe_datetime,unsubscribe_reason','newsletter!=\'1\' and email not like \'INVALID %\'',100,'','','','','2019-07-10','','','',2,'sort_order',0),(3,'_KMS_CONTACTS_INVALID','top','ent_contacts','imark','','email like \"INVALID %\"',100,'','','','','2019-07-10','','','',3,'sort_order',0),(4,'web','left','lib_pictures','','id,description,file,album_id,creation_date,sort_order','album_id=1',0,'id','','desc','','2020-02-04','','','',0,'',0);
/*!40000 ALTER TABLE `kms_sys_views` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-25 14:02:13
