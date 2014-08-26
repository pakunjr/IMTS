# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.6.17)
# Database: db_imts
# Generation Time: 2014-08-26 08:44:48 +0000
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
  `account_password` varchar(100) DEFAULT NULL,
  `account_password_salt` varchar(100) DEFAULT NULL,
  `account_owner` bigint(20) unsigned DEFAULT NULL,
  `account_access_level` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table imts_accounts_access_level
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_accounts_access_level`;

CREATE TABLE `imts_accounts_access_level` (
  `access_level_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `access_level_label` varchar(50) DEFAULT NULL,
  `access_level_definition` text,
  PRIMARY KEY (`access_level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

LOCK TABLES `imts_departments` WRITE;
/*!40000 ALTER TABLE `imts_departments` DISABLE KEYS */;

INSERT INTO `imts_departments` (`department_id`, `department_head`, `department_description`, `department_name`, `department_name_short`)
VALUES
	(3,4,NULL,'College of Computer Studies and Engineering','CCSE'),
	(4,6,NULL,'College of Arts and Sciences','CAS'),
	(5,5,NULL,'College of Management and Accountancy','CMA'),
	(6,7,NULL,'College of Medical Laboratory Sciences','CMLS');

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

LOCK TABLES `imts_items` WRITE;
/*!40000 ALTER TABLE `imts_items` DISABLE KEYS */;

INSERT INTO `imts_items` (`item_id`, `item_name`, `item_serial_no`, `item_model_no`, `item_type`, `item_state`, `item_description`, `item_quantity`, `item_date_of_purchase`, `item_package`, `item_archive_state`, `item_has_components`, `item_component_of`, `item_log`)
VALUES
	(12,'Computer Unit #1','AKD-OWE-2349','LDK-EOW-2345',1,1,'This is a computer set used by the CCSE laboratory.','1 pc.','0000-00-00',0,0,1,0,'a:13:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"15:55:31\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"15:55:31\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"15:55:49\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"15:55:49\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:4;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:02:47\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:5;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:02:47\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:6;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:11:26\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:7;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:11:26\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:8;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:44:29\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:9;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:48:09\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:10;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:49:10\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:11;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:49:25\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:12;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:49:25\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(13,'Computer Unit #2','','',1,1,'','1 pc.','0000-00-00',6,0,0,15,'a:9:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"09:26:48\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"09:27:48\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"09:38:41\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"09:38:48\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:4;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"11:09:27\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:5;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"16:20:15\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:6;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"16:20:15\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:7;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"16:20:23\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:8;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"16:20:23\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}}'),
	(14,'Computer Unit #3','LKE-FBC-342','KDL-234-SLD',1,1,'','1 pc.','0000-00-00',5,0,1,12,'a:10:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:16:33\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:16:33\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:16:47\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:16:47\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:4;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:18:11\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:5;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:18:24\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:6;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:18:27\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:7;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:43:13\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:8;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:46:34\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:9;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:46:34\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(15,'Computer Unit #4',NULL,NULL,1,1,NULL,'1 pc.','0000-00-00',0,0,1,0,NULL),
	(16,'Computer Unit #5','','',1,1,'','1 pc.','0000-00-00',0,0,0,0,'a:16:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:05:45\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:05:49\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:43:14\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:43:22\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:4;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:51:31\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:5;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:51:31\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:6;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:51:42\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:7;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:51:42\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:8;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:56:08\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:9;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:56:08\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:10;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:56:31\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:11;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:56:31\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:12;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:56:42\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:13;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:56:42\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:14;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:57:12\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:15;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"14:57:12\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}}'),
	(17,'Computer Unit #6',NULL,NULL,1,1,NULL,'1 pc.','0000-00-00',0,0,1,0,NULL),
	(18,'Motherboard','UH81148641646','',1,1,'This is a motherboard.','1 pc.','0000-00-00',0,0,0,14,'a:6:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"15:28:36\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"15:28:36\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:26:53\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:26:53\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:4;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:28:46\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:5;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:28:46\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}}'),
	(19,'Motherboard','UH81148041201',NULL,1,1,NULL,'1 pc.','0000-00-00',0,0,0,13,NULL),
	(20,'Motherboard','UH81148641532','',1,1,'','1 pc.','0000-00-00',0,0,0,14,'a:4:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:29:06\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:29:06\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:29:20\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:29:20\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(21,'Motherboard','BTWW052002AB','',1,1,'','1 pc.','0000-00-00',0,0,0,15,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:02:42\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"11:02:42\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(22,'HDD Western Digital','WMAYU3261256','',1,3,'','1 pc.','0000-00-00',5,0,0,12,'a:10:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"15:47:15\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"15:47:15\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}i:2;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:16:52\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:3;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:16:52\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:4;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:55:20\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:5;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:55:20\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:6;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:56:52\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:7;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:56:52\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}i:8;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:57:00\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:27:\"This item has been updated.\";}i:9;a:4:{s:4:\"date\";s:10:\"2014-08-22\";s:4:\"time\";s:8:\"16:57:00\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:57:\"The ownership of this item has been updated successfully.\";}}'),
	(23,'HDD Western Digital','WMAYU3407601','',1,1,NULL,'1 pc.','0000-00-00',0,0,0,13,NULL),
	(24,'Computer Unit #7','','',1,1,'','1 pc.','0000-00-00',0,0,0,0,NULL),
	(25,'Computer Unit #8','','',1,1,'','1 pc.','0000-00-00',0,0,0,0,NULL),
	(26,'Ink','','',2,1,'','1 pc.','0000-00-00',0,0,0,12,'a:2:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"16:25:52\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}i:1;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"16:25:52\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:48:\"Successfully created an ownership for this item.\";}}'),
	(27,'Memory','','',1,1,'','1 pc.','0000-00-00',0,0,0,12,'a:1:{i:0;a:4:{s:4:\"date\";s:10:\"2014-08-26\";s:4:\"time\";s:8:\"16:26:23\";s:4:\"user\";s:22:\"Feature coming soon...\";s:3:\"log\";s:22:\"This item was created.\";}}');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

LOCK TABLES `imts_items_package` WRITE;
/*!40000 ALTER TABLE `imts_items_package` DISABLE KEYS */;

INSERT INTO `imts_items_package` (`package_id`, `package_serial_no`, `package_name`, `package_description`, `package_date_of_purchase`)
VALUES
	(1,'','Computer Set 1',NULL,'0000-00-00'),
	(2,'','Computer Set 2',NULL,'0000-00-00'),
	(3,'','Computer Set 3',NULL,'0000-00-00'),
	(4,'','Apple Set 1',NULL,'0000-00-00'),
	(5,'','Apple Set 2',NULL,'0000-00-00'),
	(6,'','Apple Set 3',NULL,'0000-00-00');

/*!40000 ALTER TABLE `imts_items_package` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_items_state
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_items_state`;

CREATE TABLE `imts_items_state` (
  `item_state_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_state_label` varchar(50) DEFAULT NULL,
  `item_state_description` text,
  PRIMARY KEY (`item_state_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

LOCK TABLES `imts_items_type` WRITE;
/*!40000 ALTER TABLE `imts_items_type` DISABLE KEYS */;

INSERT INTO `imts_items_type` (`item_type_id`, `item_type_label`, `item_type_description`)
VALUES
	(1,'Computer Peripherals',NULL),
	(2,'Consumables',NULL);

/*!40000 ALTER TABLE `imts_items_type` ENABLE KEYS */;
UNLOCK TABLES;


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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

LOCK TABLES `imts_ownership` WRITE;
/*!40000 ALTER TABLE `imts_ownership` DISABLE KEYS */;

INSERT INTO `imts_ownership` (`ownership_id`, `ownership_item`, `ownership_owner`, `ownership_owner_type`, `ownership_date_owned`, `ownership_date_released`)
VALUES
	(1,12,4,'Person','2014-08-05','2014-08-22'),
	(2,13,5,'Person','0000-00-00','0000-00-00'),
	(3,14,4,'Person','2014-08-20','2014-08-04'),
	(4,15,4,'Person','0000-00-00','0000-00-00'),
	(5,12,4,'Person','0000-00-00','1998-05-13'),
	(6,12,4,'Person','0000-00-00','1980-04-01'),
	(7,16,4,'Person','0000-00-00','2014-08-22'),
	(8,16,5,'Department','0000-00-00','2014-08-22'),
	(9,16,3,'Department','2014-08-05','0000-00-00'),
	(10,18,6,'Person','2014-08-12','0000-00-00'),
	(11,22,5,'Department','0000-00-00','0000-00-00'),
	(12,20,4,'Person','0000-00-00','2014-08-22'),
	(13,20,6,'Department','0000-00-00','0000-00-00'),
	(14,12,4,'Person','0000-00-00','0000-00-00'),
	(15,21,6,'Person','0000-00-00','0000-00-00'),
	(16,14,5,'Department','0000-00-00','0000-00-00'),
	(17,26,4,'Person','2014-08-11','0000-00-00');

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
  `person_gender` char(1) DEFAULT NULL,
  `person_birthdate` date DEFAULT '0000-00-00',
  `person_address_a` text,
  `person_address_b` text,
  `person_contact_a` varchar(25) DEFAULT NULL,
  `person_contact_b` varchar(25) DEFAULT NULL,
  `person_email` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

LOCK TABLES `imts_persons` WRITE;
/*!40000 ALTER TABLE `imts_persons` DISABLE KEYS */;

INSERT INTO `imts_persons` (`person_id`, `person_firstname`, `person_middlename`, `person_lastname`, `person_suffix`, `person_gender`, `person_birthdate`, `person_address_a`, `person_address_b`, `person_contact_a`, `person_contact_b`, `person_email`)
VALUES
	(4,'Nica','Miderson','Milferd',NULL,'f','1985-03-15',NULL,NULL,NULL,NULL,NULL),
	(5,'Samantha','Perez','Lucban',NULL,'f','1990-02-14',NULL,NULL,NULL,NULL,NULL),
	(6,'Joey','Hamilton','Henrey',NULL,'m','1980-05-08',NULL,NULL,NULL,NULL,NULL),
	(7,'Elija','Mami','Go',NULL,'f','1975-12-13',NULL,NULL,NULL,NULL,NULL),
	(8,'Sony','Go','Chu',NULL,'m','1968-11-03',NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `imts_persons` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_persons_employment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_persons_employment`;

CREATE TABLE `imts_persons_employment` (
  `employee_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_person` bigint(20) unsigned DEFAULT NULL,
  `employee_status` bigint(20) unsigned DEFAULT NULL,
  `employee_job_description` text,
  `employee_department` bigint(20) unsigned DEFAULT '0',
  `employee_employment_date` date DEFAULT '0000-00-00',
  `employee_resignation_date` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `imts_persons_employment` WRITE;
/*!40000 ALTER TABLE `imts_persons_employment` DISABLE KEYS */;

INSERT INTO `imts_persons_employment` (`employee_id`, `employee_person`, `employee_status`, `employee_job_description`, `employee_department`, `employee_employment_date`, `employee_resignation_date`)
VALUES
	(1,4,2,NULL,5,'0000-00-00','0000-00-00');

/*!40000 ALTER TABLE `imts_persons_employment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table imts_persons_employment_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `imts_persons_employment_status`;

CREATE TABLE `imts_persons_employment_status` (
  `employee_status_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee_status_label` varchar(50) DEFAULT NULL,
  `employee_stauts_description` text,
  PRIMARY KEY (`employee_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `imts_persons_employment_status` WRITE;
/*!40000 ALTER TABLE `imts_persons_employment_status` DISABLE KEYS */;

INSERT INTO `imts_persons_employment_status` (`employee_status_id`, `employee_status_label`, `employee_stauts_description`)
VALUES
	(1,'Contractual',NULL),
	(2,'Probationary',NULL),
	(3,'Permanent',NULL);

/*!40000 ALTER TABLE `imts_persons_employment_status` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
