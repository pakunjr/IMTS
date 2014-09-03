# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.17)
# Database: db_imts
# Generation Time: 2014-09-03 09:10:45 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table imts_accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_accounts`;

CREATE TABLE `imts_accounts` (
  `account_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `account_username` varchar(150) DEFAULT NULL,
  `account_password_hash` varchar(100) DEFAULT NULL,
  `account_owner` bigint(20) unsigned DEFAULT NULL,
  `account_access_level` bigint(20) unsigned DEFAULT NULL,
  `account_deactivated` int(1) DEFAULT '0',
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_accounts` WRITE;
/*!40000 ALTER TABLE `imts_accounts` DISABLE KEYS */;

INSERT INTO `imts_accounts` (`account_id`, `account_username`, `account_password_hash`, `account_owner`, `account_access_level`, `account_deactivated`)
VALUES
	(8,'admin','sha256:1000:GA5gFIaCCswXuhl4bszbr+AqYccOgcPU:w2yFVuFGLs9W9foqwfbNqrrwDR5+CnhX',13,5,0),
	(9,'pakunjr','sha256:1000:iwMmFJ1X7I8N/qL+8l+QEjr4aKOHNFCR:TA+t12DOCsDqzsPPtjvcGTGyiX6hoLcQ',13,6,0);

/*!40000 ALTER TABLE `imts_accounts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_accounts_access_level
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_accounts_access_level`;

CREATE TABLE `imts_accounts_access_level` (
  `access_level_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `access_level_label` varchar(50) DEFAULT NULL,
  `access_level_definition` text,
  PRIMARY KEY (`access_level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_accounts_access_level` WRITE;
/*!40000 ALTER TABLE `imts_accounts_access_level` DISABLE KEYS */;

INSERT INTO `imts_accounts_access_level` (`access_level_id`, `access_level_label`, `access_level_definition`)
VALUES
	(5,'Administrator',NULL),
	(6,'Supervisor',NULL),
	(7,'Content Provider',NULL),
	(8,'Viewer',NULL);

/*!40000 ALTER TABLE `imts_accounts_access_level` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_departments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_departments`;

CREATE TABLE `imts_departments` (
  `department_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `department_head` bigint(20) unsigned DEFAULT '0',
  `department_description` text,
  `department_name` varchar(150) DEFAULT NULL,
  `department_name_short` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_departments` WRITE;
/*!40000 ALTER TABLE `imts_departments` DISABLE KEYS */;

INSERT INTO `imts_departments` (`department_id`, `department_head`, `department_description`, `department_name`, `department_name_short`)
VALUES
	(7,10,'This is a department that cater major computer courses.','College of Computer Studies and Engineering','CCSE'),
	(8,0,'','College of Medical Laboratory Science','MLS'),
	(9,0,'','Information Technology Services','ITS');

/*!40000 ALTER TABLE `imts_departments` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_items`;

CREATE TABLE `imts_items` (
  `item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) DEFAULT '',
  `item_serial_no` varchar(150) DEFAULT '',
  `item_model_no` varchar(150) DEFAULT '',
  `item_type` bigint(20) unsigned DEFAULT '0',
  `item_state` bigint(20) unsigned DEFAULT '0',
  `item_description` text,
  `item_quantity` varchar(15) DEFAULT '1 pc.',
  `item_date_of_purchase` date DEFAULT '0000-00-00',
  `item_package` bigint(20) unsigned DEFAULT '0',
  `item_archive_state` int(1) unsigned NOT NULL DEFAULT '0',
  `item_has_components` int(1) unsigned NOT NULL DEFAULT '0',
  `item_component_of` bigint(20) unsigned DEFAULT '0',
  `item_log` longtext,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_items` WRITE;
/*!40000 ALTER TABLE `imts_items` DISABLE KEYS */;

INSERT INTO `imts_items` (`item_id`, `item_name`, `item_serial_no`, `item_model_no`, `item_type`, `item_state`, `item_description`, `item_quantity`, `item_date_of_purchase`, `item_package`, `item_archive_state`, `item_has_components`, `item_component_of`, `item_log`)
VALUES
	(30,'310A Unit #1','','',1,1,'','1 pc.','0000-00-00',0,0,1,0,'a:8:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:50:34\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:50:34\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"13:45:00\";s:4:\"user\";s:5:\"admin\";s:3:\"log\";s:27:\"This item has been updated.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"13:45:00\";s:4:\"user\";s:5:\"admin\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:4;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"13:45:40\";s:4:\"user\";s:34:\"admin -> Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:27:\"This item has been updated.\";}i:5;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"13:45:40\";s:4:\"user\";s:34:\"admin -> Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:6;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"13:46:34\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:27:\"This item has been updated.\";}i:7;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"13:46:34\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}}'),
	(31,'Motherboard Foxconn TPD','UH81148641646','',1,1,'','1 pc.','0000-00-00',0,0,0,30,'a:4:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:53:57\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:53:57\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:54:06\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:54:06\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}}'),
	(32,'CPU INTEL ATOM D525 1.80 GHZ','','',1,1,'','1 pc.','0000-00-00',0,0,0,30,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:54:49\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:54:49\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(33,'POWER SUPPLY TOM MADE MATX-500W','','',1,1,'','1 pc.','0000-00-00',0,0,0,30,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:58:15\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:58:15\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(34,'HDD WESTERN DIGITAL  500GB ','WMAYU3261256','',1,1,'','1 pc.','0000-00-00',0,0,0,30,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:59:20\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:59:20\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(35,'MEMORY DDR3 2GB ','','',1,1,'','1 pc.','0000-00-00',0,0,0,30,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:59:59\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"10:59:59\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(36,'MONITOR ANBONN','L5ESHAXITAOLIMA35BOOQQ2','',1,1,'','1 pc.','0000-00-00',0,0,0,30,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:01:08\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:01:08\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(37,'310A Unit #2','','',1,1,'','1 pc.','0000-00-00',0,1,1,0,'a:8:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:09:25\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:09:25\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:43:52\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:43:52\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:4;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:52:37\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:5;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:52:37\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:6;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"14:57:08\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:7;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"14:57:08\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(38,'310A Unit #3','','',1,1,'','1 pc.','0000-00-00',0,0,1,0,'a:5:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:09:50\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:10:45\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:10:45\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:44:04\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:4;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:44:04\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}}'),
	(39,'310A Unit #4','','',1,1,'','1 pc.','0000-00-00',0,0,1,0,'a:5:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:09:59\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:10:06\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:10:06\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:44:15\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:4;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:44:15\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}}'),
	(40,'MOTHERBOARD Foxconn TPD','UH81148041201','',1,1,'','1 pc.','0000-00-00',0,0,0,37,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:44:25\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:44:25\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(41,'CPU INTEL ATOM D525 1.80 GHZ','','',1,1,'','1 pc.','0000-00-00',0,0,0,37,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:45:38\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:45:38\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(42,'POWER SUPPLY TOM MADE MATX-500W','','',1,1,'','1 pc.','0000-00-00',0,0,0,37,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:46:35\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:46:35\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(43,'HDD601 WESTERN DIGITAL 500GB ','WMAYU3407601','',1,1,'','1 pc.','0000-00-00',0,0,0,37,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:47:15\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:47:15\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(44,'MEMORY DDR3 2GB','','',1,1,'','1 pc.','0000-00-00',0,0,0,37,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:47:43\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:47:43\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(45,'MONITOR PHILIPS LED','AU2A1042006634','',1,1,'','1 pc.','0000-00-00',0,0,0,37,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:48:29\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:48:29\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(46,'MOTHERBOARD Foxconn TPD','UH81148641532','',1,1,'','1 pc.','0000-00-00',0,0,0,38,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:49:13\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:49:13\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(47,'CPU INTEL ATOM D525 1.80 GHZ','','',1,1,'','1 pc.','0000-00-00',0,0,0,38,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:49:38\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:49:38\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(48,'POWER SUPPLY TOM MADE MATX-500W','','',1,1,'','1 pc.','0000-00-00',0,1,0,38,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:49:57\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:49:57\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(49,'HDD601 WESTERN DIGITAL 500GB','WMAYU3260786','',1,1,'','1 pc.','0000-00-00',0,0,0,38,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:50:29\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:50:29\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(50,'MEMORY DDR 2GB','','',1,1,'','1 pc.','0000-00-00',0,0,0,38,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:50:55\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:50:55\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(51,'MONITOR PHILIPS LED','AU2A1042006677','',1,1,'','1 pc.','0000-00-00',0,0,0,38,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:51:28\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-29\";s:4:\"time\";s:8:\"11:51:28\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(52,'310A Unit #5','','',1,1,'','1 pc.','0000-00-00',0,0,1,0,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:28:15\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:28:15\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(53,'310A Unit #6','','',1,1,'','1 pc.','0000-00-00',0,0,1,0,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:29:38\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:29:38\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(54,'310A Unit #7','','',1,1,'','1 pc.','0000-00-00',0,0,1,0,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:29:45\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:29:45\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(55,'310A Unit #8','','',1,1,'','1 pc.','0000-00-00',0,0,1,0,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:29:51\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:29:51\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(56,'310A Unit #9','','',1,1,'','1 pc.','0000-00-00',0,0,1,0,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:29:57\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:29:57\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(57,'310A Unit #10','','',1,1,'','1 pc.','0000-00-00',0,0,1,0,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:30:03\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-09-02\";s:4:\"time\";s:8:\"15:30:03\";s:4:\"user\";s:34:\"admin -- Gawaban, Palmer Cacdac Jr\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}');

/*!40000 ALTER TABLE `imts_items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_items_package
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_items_package`;

CREATE TABLE `imts_items_package` (
  `package_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `package_serial_no` varchar(150) DEFAULT '',
  `package_name` varchar(100) DEFAULT '',
  `package_description` text,
  `package_date_of_purchase` date DEFAULT '0000-00-00',
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table imts_items_state
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_items_state`;

CREATE TABLE `imts_items_state` (
  `item_state_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_state_label` varchar(50) DEFAULT NULL,
  `item_state_description` text,
  PRIMARY KEY (`item_state_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_items_state` WRITE;
/*!40000 ALTER TABLE `imts_items_state` DISABLE KEYS */;

INSERT INTO `imts_items_state` (`item_state_id`, `item_state_label`, `item_state_description`)
VALUES
	(1,'Working',NULL),
	(2,'Broken',NULL),
	(3,'Stored',NULL),
	(4,'Disposed',NULL);

/*!40000 ALTER TABLE `imts_items_state` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_items_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_items_type`;

CREATE TABLE `imts_items_type` (
  `item_type_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_type_label` varchar(50) DEFAULT NULL,
  `item_type_description` text,
  PRIMARY KEY (`item_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_items_type` WRITE;
/*!40000 ALTER TABLE `imts_items_type` DISABLE KEYS */;

INSERT INTO `imts_items_type` (`item_type_id`, `item_type_label`, `item_type_description`)
VALUES
	(1,'Computer Peripherals',NULL);

/*!40000 ALTER TABLE `imts_items_type` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_logs_errors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_logs_errors`;

CREATE TABLE `imts_logs_errors` (
  `error_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `error_logged_account` bigint(20) DEFAULT NULL,
  `error_description` mediumtext,
  `error_date` date DEFAULT NULL,
  `error_time` varchar(8) DEFAULT NULL,
  `error_archived` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`error_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table imts_maintenance
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_maintenance`;

CREATE TABLE `imts_maintenance` (
  `maintenance_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `maintenance_item` bigint(20) unsigned DEFAULT '0',
  `maintenance_item_owner` bigint(20) unsigned DEFAULT '0',
  `maintenance_assigned_staff` bigint(20) unsigned DEFAULT '0',
  `maintenance_date_submitted` date DEFAULT NULL,
  `maintenance_date_returned` date DEFAULT NULL,
  `maintenance_status` int(11) unsigned DEFAULT '0',
  `maintenance_detailed_report` mediumtext,
  PRIMARY KEY (`maintenance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table imts_maintenance_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_maintenance_status`;

CREATE TABLE `imts_maintenance_status` (
  `maintenance_status_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `maintenance_status_label` varchar(100) DEFAULT NULL,
  `maintenance_status_description` text,
  PRIMARY KEY (`maintenance_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table imts_ownership
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_ownership`;

CREATE TABLE `imts_ownership` (
  `ownership_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ownership_item` bigint(20) unsigned DEFAULT '0',
  `ownership_owner` bigint(20) unsigned DEFAULT '0',
  `ownership_owner_type` enum('Person','Department') DEFAULT 'Person',
  `ownership_date_owned` date DEFAULT '0000-00-00',
  `ownership_date_released` date DEFAULT '0000-00-00',
  PRIMARY KEY (`ownership_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_ownership` WRITE;
/*!40000 ALTER TABLE `imts_ownership` DISABLE KEYS */;

INSERT INTO `imts_ownership` (`ownership_id`, `ownership_item`, `ownership_owner`, `ownership_owner_type`, `ownership_date_owned`, `ownership_date_released`)
VALUES
	(19,30,7,'Department','0000-00-00','0000-00-00'),
	(20,31,7,'Department','0000-00-00','0000-00-00'),
	(21,32,7,'Department','0000-00-00','0000-00-00'),
	(22,33,7,'Department','0000-00-00','0000-00-00'),
	(23,34,7,'Department','0000-00-00','0000-00-00'),
	(24,35,7,'Department','0000-00-00','0000-00-00'),
	(25,36,7,'Department','0000-00-00','0000-00-00'),
	(26,37,7,'Department','0000-00-00','2014-08-25'),
	(27,39,7,'Department','0000-00-00','0000-00-00'),
	(28,38,7,'Department','0000-00-00','0000-00-00'),
	(29,40,7,'Department','0000-00-00','0000-00-00'),
	(30,41,7,'Department','0000-00-00','0000-00-00'),
	(31,42,7,'Department','0000-00-00','0000-00-00'),
	(32,43,7,'Department','0000-00-00','0000-00-00'),
	(33,44,7,'Department','0000-00-00','0000-00-00'),
	(34,45,7,'Department','0000-00-00','0000-00-00'),
	(35,46,7,'Department','0000-00-00','0000-00-00'),
	(36,47,7,'Department','0000-00-00','0000-00-00'),
	(37,48,7,'Department','0000-00-00','0000-00-00'),
	(38,49,7,'Department','0000-00-00','0000-00-00'),
	(39,50,7,'Department','0000-00-00','0000-00-00'),
	(40,51,7,'Department','0000-00-00','0000-00-00'),
	(41,37,7,'Department','0000-00-00','0000-00-00'),
	(42,52,7,'Department','0000-00-00','0000-00-00'),
	(43,53,7,'Department','0000-00-00','0000-00-00'),
	(44,54,7,'Department','0000-00-00','0000-00-00'),
	(45,55,7,'Department','0000-00-00','0000-00-00'),
	(46,56,7,'Department','0000-00-00','0000-00-00'),
	(47,57,7,'Department','0000-00-00','0000-00-00');

/*!40000 ALTER TABLE `imts_ownership` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_persons
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_persons`;

CREATE TABLE `imts_persons` (
  `person_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `person_firstname` varchar(150) DEFAULT NULL,
  `person_middlename` varchar(150) DEFAULT NULL,
  `person_lastname` varchar(150) DEFAULT NULL,
  `person_suffix` varchar(20) DEFAULT NULL,
  `person_gender` char(1) DEFAULT 'm',
  `person_birthdate` date DEFAULT '0000-00-00',
  `person_address_a` text,
  `person_address_b` text,
  `person_contact_a` varchar(25) DEFAULT NULL,
  `person_contact_b` varchar(25) DEFAULT NULL,
  `person_email` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_persons` WRITE;
/*!40000 ALTER TABLE `imts_persons` DISABLE KEYS */;

INSERT INTO `imts_persons` (`person_id`, `person_firstname`, `person_middlename`, `person_lastname`, `person_suffix`, `person_gender`, `person_birthdate`, `person_address_a`, `person_address_b`, `person_contact_a`, `person_contact_b`, `person_email`)
VALUES
	(10,'Ana Belen','O','Noble','','f','0000-00-00','','','','','abnoble@lorma.edu'),
	(12,'Palmer','Cacdac','Gawaban','Jr','m','1993-04-01','Gana Auto Parts, Caba, La Union','','09165511889','708-01-49','palmer.gawaban@lorma.edu'),
	(13,'admin',NULL,NULL,NULL,'m','0000-00-00',NULL,NULL,NULL,NULL,'admin@admin.com');

/*!40000 ALTER TABLE `imts_persons` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_persons_employment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_persons_employment`;

CREATE TABLE `imts_persons_employment` (
  `employee_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_no` varchar(100) DEFAULT NULL,
  `employee_person` bigint(20) unsigned DEFAULT NULL,
  `employee_status` bigint(20) unsigned DEFAULT NULL,
  `employee_job` bigint(20) DEFAULT NULL,
  `employee_department` bigint(20) DEFAULT NULL,
  `employee_employment_date` date DEFAULT '0000-00-00',
  `employee_resignation_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_persons_employment` WRITE;
/*!40000 ALTER TABLE `imts_persons_employment` DISABLE KEYS */;

INSERT INTO `imts_persons_employment` (`employee_id`, `employee_no`, `employee_person`, `employee_status`, `employee_job`, `employee_department`, `employee_employment_date`, `employee_resignation_date`)
VALUES
	(7,'',10,1,3,7,'0000-00-00','2014-09-02'),
	(8,'1553',12,1,4,9,'2013-10-15','0000-00-00');

/*!40000 ALTER TABLE `imts_persons_employment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_persons_employment_jobs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_persons_employment_jobs`;

CREATE TABLE `imts_persons_employment_jobs` (
  `employee_job_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_job_label` varchar(150) DEFAULT NULL,
  `employee_job_description` text,
  PRIMARY KEY (`employee_job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_persons_employment_jobs` WRITE;
/*!40000 ALTER TABLE `imts_persons_employment_jobs` DISABLE KEYS */;

INSERT INTO `imts_persons_employment_jobs` (`employee_job_id`, `employee_job_label`, `employee_job_description`)
VALUES
	(3,'Dean','Head of an academic department.'),
	(4,'Systems Developer','Develop systems.');

/*!40000 ALTER TABLE `imts_persons_employment_jobs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_persons_employment_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_persons_employment_status`;

CREATE TABLE `imts_persons_employment_status` (
  `employee_status_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_status_label` varchar(50) DEFAULT NULL,
  `employee_stauts_description` text,
  PRIMARY KEY (`employee_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `imts_persons_employment_status` WRITE;
/*!40000 ALTER TABLE `imts_persons_employment_status` DISABLE KEYS */;

INSERT INTO `imts_persons_employment_status` (`employee_status_id`, `employee_status_label`, `employee_stauts_description`)
VALUES
	(1,'Contractual',NULL),
	(2,'Probationary',NULL),
	(3,'Permanent',NULL),
	(4,'Volunteer',NULL);

/*!40000 ALTER TABLE `imts_persons_employment_status` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_routine_check
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_routine_check`;

CREATE TABLE `imts_routine_check` (
  `routine_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `routine_item` bigint(20) NOT NULL DEFAULT '0',
  `routine_item_owner` bigint(20) NOT NULL DEFAULT '0',
  `routine_checker` bigint(20) NOT NULL DEFAULT '0',
  `routine_summary` longtext,
  PRIMARY KEY (`routine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
