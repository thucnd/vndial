# SQL-Front 5.1  (Build 4.16)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: localhost    Database: __vndial
# ------------------------------------------------------
# Server version 5.5.16

#
# Source for table broadcast_application
#

DROP TABLE IF EXISTS `broadcast_application`;
CREATE TABLE `broadcast_application` (
  `app_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_id` int(11) NOT NULL DEFAULT '0',
  `current` int(11) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  `next` int(11) NOT NULL,
  PRIMARY KEY (`app_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

#
# Dumping data for table broadcast_application
#

LOCK TABLES `broadcast_application` WRITE;
/*!40000 ALTER TABLE `broadcast_application` DISABLE KEYS */;
/*!40000 ALTER TABLE `broadcast_application` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table broadcast_application_type
#

DROP TABLE IF EXISTS `broadcast_application_type`;
CREATE TABLE `broadcast_application_type` (
  `app_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`app_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Dumping data for table broadcast_application_type
#

LOCK TABLES `broadcast_application_type` WRITE;
/*!40000 ALTER TABLE `broadcast_application_type` DISABLE KEYS */;
INSERT INTO `broadcast_application_type` VALUES (1,'Dial',NULL);
INSERT INTO `broadcast_application_type` VALUES (2,'PlayAudio',NULL);
INSERT INTO `broadcast_application_type` VALUES (3,'Speak',NULL);
/*!40000 ALTER TABLE `broadcast_application_type` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table broadcast_survey_question
#

DROP TABLE IF EXISTS `broadcast_survey_question`;
CREATE TABLE `broadcast_survey_question` (
  `survey_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question` varchar(32) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `recording_id` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`survey_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;

#
# Dumping data for table broadcast_survey_question
#

LOCK TABLES `broadcast_survey_question` WRITE;
/*!40000 ALTER TABLE `broadcast_survey_question` DISABLE KEYS */;
/*!40000 ALTER TABLE `broadcast_survey_question` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table broadcast_survey_response
#

DROP TABLE IF EXISTS `broadcast_survey_response`;
CREATE TABLE `broadcast_survey_response` (
  `response_id` int(11) NOT NULL AUTO_INCREMENT,
  `key_digit` int(10) unsigned NOT NULL,
  `key_value` varchar(128) NOT NULL,
  `survey_type` int(10) unsigned NOT NULL,
  `survey_id` int(10) unsigned NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`response_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

#
# Dumping data for table broadcast_survey_response
#

LOCK TABLES `broadcast_survey_response` WRITE;
/*!40000 ALTER TABLE `broadcast_survey_response` DISABLE KEYS */;
/*!40000 ALTER TABLE `broadcast_survey_response` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table broadcast_tts
#

DROP TABLE IF EXISTS `broadcast_tts`;
CREATE TABLE `broadcast_tts` (
  `tts_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `text_data` text,
  `language` varchar(10) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`tts_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

#
# Dumping data for table broadcast_tts
#

LOCK TABLES `broadcast_tts` WRITE;
/*!40000 ALTER TABLE `broadcast_tts` DISABLE KEYS */;
/*!40000 ALTER TABLE `broadcast_tts` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table broadcast_voice_settings
#

DROP TABLE IF EXISTS `broadcast_voice_settings`;
CREATE TABLE `broadcast_voice_settings` (
  `key` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Dumping data for table broadcast_voice_settings
#

LOCK TABLES `broadcast_voice_settings` WRITE;
/*!40000 ALTER TABLE `broadcast_voice_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `broadcast_voice_settings` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table call_reports
#

DROP TABLE IF EXISTS `call_reports`;
CREATE TABLE `call_reports` (
  `call_report_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `campaign_id` int(10) unsigned NOT NULL,
  `calluuid` varchar(255) DEFAULT NULL,
  `callername` varchar(255) DEFAULT NULL,
  `caller` varchar(32) NOT NULL,
  `called` varchar(32) NOT NULL,
  `forwardedfrom` varchar(32) DEFAULT NULL,
  `direction` varchar(50) DEFAULT NULL,
  `aLeguuid` varchar(255) DEFAULT NULL,
  `aLegrequestuuid` varchar(255) DEFAULT NULL,
  `scheduledhangupid` varchar(255) DEFAULT NULL,
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `call_status` varchar(255) DEFAULT NULL,
  `hangupcause` text,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`call_report_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Dumping data for table call_reports
#

LOCK TABLES `call_reports` WRITE;
/*!40000 ALTER TABLE `call_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `call_reports` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table call_requests
#

DROP TABLE IF EXISTS `call_requests`;
CREATE TABLE `call_requests` (
  `call_request_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `campaign_id` int(10) unsigned NOT NULL,
  `caller` varchar(32) NOT NULL,
  `called` varchar(32) NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `retries` int(10) unsigned NOT NULL,
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hangup` varchar(255) NOT NULL,
  `requestuuid` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` varchar(40) NOT NULL,
  PRIMARY KEY (`call_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Dumping data for table call_requests
#

LOCK TABLES `call_requests` WRITE;
/*!40000 ALTER TABLE `call_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `call_requests` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table campaign_type
#

DROP TABLE IF EXISTS `campaign_type`;
CREATE TABLE `campaign_type` (
  `campaign_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`campaign_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Dumping data for table campaign_type
#

LOCK TABLES `campaign_type` WRITE;
/*!40000 ALTER TABLE `campaign_type` DISABLE KEYS */;
INSERT INTO `campaign_type` VALUES (1,'Voice','Voice Application');
INSERT INTO `campaign_type` VALUES (2,'Survey','Survey');
INSERT INTO `campaign_type` VALUES (3,'TTS','Text-To-Speech');
/*!40000 ALTER TABLE `campaign_type` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table campaigns
#

DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE `campaigns` (
  `campaign_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `name` varchar(40) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `caller` varchar(32) NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `start_at` datetime DEFAULT '0000-00-00 00:00:00',
  `stop_at` datetime DEFAULT '0000-00-00 00:00:00',
  `a_leg` varchar(150) NOT NULL,
  `camp_type_id` int(10) unsigned NOT NULL,
  `app_type_id` int(10) unsigned NOT NULL,
  `app_id` int(11) DEFAULT '0',
  `repeat_total` int(10) unsigned DEFAULT NULL,
  `repeat_done` int(10) unsigned DEFAULT NULL,
  `status_message` varchar(32) DEFAULT NULL,
  `flg_on` tinyint(1) DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`campaign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

#
# Dumping data for table campaigns
#

LOCK TABLES `campaigns` WRITE;
/*!40000 ALTER TABLE `campaigns` DISABLE KEYS */;
/*!40000 ALTER TABLE `campaigns` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table contact_groups
#

DROP TABLE IF EXISTS `contact_groups`;
CREATE TABLE `contact_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Dumping data for table contact_groups
#

LOCK TABLES `contact_groups` WRITE;
/*!40000 ALTER TABLE `contact_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_groups` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table contacts
#

DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `contact_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `company` varchar(32) DEFAULT NULL,
  `address` varchar(128) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Dumping data for table contacts
#

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table country
#

DROP TABLE IF EXISTS `country`;
CREATE TABLE `country` (
  `country_iso` char(2) NOT NULL DEFAULT '',
  `country_name` varchar(32) NOT NULL,
  PRIMARY KEY (`country_iso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Dumping data for table country
#

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES ('en','English');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table recordings
#

DROP TABLE IF EXISTS `recordings`;
CREATE TABLE `recordings` (
  `recording_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `type` text NOT NULL,
  `path` text NOT NULL,
  `size` varchar(15) NOT NULL DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`recording_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Dumping data for table recordings
#

LOCK TABLES `recordings` WRITE;
/*!40000 ALTER TABLE `recordings` DISABLE KEYS */;
/*!40000 ALTER TABLE `recordings` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table role
#

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `role_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(16) NOT NULL,
  `role_permissions` text,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Dumping data for table role
#

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Supper admin',null);
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table users
#

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `country_iso` varchar(2) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `phonenumber` varchar(20) DEFAULT NULL,
  `company_name` varchar(50) DEFAULT NULL,
  `company_website` varchar(50) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `gateway_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Dumping data for table users
#

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','e10adc3949ba59abbe56e057f20f883e ','1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table voice_gateways
#

DROP TABLE IF EXISTS `voice_gateways`;
CREATE TABLE `voice_gateways` (
  `gateway_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `gateways` varchar(128) NOT NULL,
  `gateway_codecs` varchar(40) DEFAULT NULL,
  `gateway_timeouts` varchar(10) DEFAULT NULL,
  `gateway_retries` varchar(10) DEFAULT NULL,
  `gateway_originates` varchar(255) DEFAULT NULL,
  `status` int(10) unsigned DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL,
  PRIMARY KEY (`gateway_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Dumping data for table voice_gateways
#

LOCK TABLES `voice_gateways` WRITE;
/*!40000 ALTER TABLE `voice_gateways` DISABLE KEYS */;
/*!40000 ALTER TABLE `voice_gateways` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
