/*
 Navicat Premium Data Transfer

 Source Server         : localhostM
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : ccpv3

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 23/10/2020 19:28:58
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tbl_cities
-- ----------------------------
DROP TABLE IF EXISTS `tbl_cities`;
CREATE TABLE `tbl_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` bit(1) NOT NULL DEFAULT b'0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `ind_unique_city_name` (`city_name`) USING BTREE,
  KEY `fk_city_4_country` (`country_code`) USING BTREE,
  CONSTRAINT `fk_city_4_country` FOREIGN KEY (`country_code`) REFERENCES `tbl_countries` (`iso_code`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tbl_cities
-- ----------------------------
BEGIN;
INSERT INTO `tbl_cities` VALUES (1, 'Paris', 'FR', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (2, 'London', 'GB', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (3, 'New York', 'US', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (4, 'Berlin', 'DE', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (5, 'Istanbul', 'TR', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (6, 'Brussels', 'BE', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (7, 'Brasilia', 'BR', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (8, 'Roma', 'IT', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (9, 'Bursa', 'TR', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (10, 'Oslo', 'NO', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (11, 'Copenhagen', 'DK', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (12, 'Madrid', 'ES', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (13, 'Ankara', 'TR', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (14, 'Neverville', 'US', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (15, 'Clayton', 'AU', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (16, 'Liverpool', 'GB', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (17, 'Vienna', 'AT', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (18, 'San Diego', 'US', b'1', NULL);
INSERT INTO `tbl_cities` VALUES (19, 'Luxembourg', 'LU', b'1', NULL);
COMMIT;

-- ----------------------------
-- Table structure for tbl_countries
-- ----------------------------
DROP TABLE IF EXISTS `tbl_countries`;
CREATE TABLE `tbl_countries` (
  `iso_code` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `country_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` bit(1) NOT NULL DEFAULT b'1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`iso_code`) USING BTREE,
  UNIQUE KEY `IND_iso_code` (`iso_code`) USING BTREE,
  UNIQUE KEY `IND_country_name` (`country_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tbl_countries
-- ----------------------------
BEGIN;
INSERT INTO `tbl_countries` VALUES ('AT', 'Austria', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('AU', 'Australia', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('BE', 'Belgium', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('BR', 'Brazil', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('CH', 'Switzerland', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('DE', 'Germany', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('DK', 'Denmark', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('ES', 'Spain', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('FI', 'Finland', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('FR', 'France', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('GB', 'United Kingdom', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('IT', 'Italy', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('LT', 'Lithuania', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('LU', 'Luxembourg', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('MX', 'Mexico', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('NL', 'Netherlands', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('NO', 'Norway', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('NZ', 'New Zealand', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('PT', 'Portugal', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('RO', 'Romania', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('SE', 'Sweden', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('TR', 'Turkey', b'1', NULL);
INSERT INTO `tbl_countries` VALUES ('US', 'United States', b'1', NULL);
COMMIT;

-- ----------------------------
-- Table structure for tbl_people
-- ----------------------------
DROP TABLE IF EXISTS `tbl_people`;
CREATE TABLE `tbl_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `middle_name` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sex` char(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_address` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `person_type` enum('unspecified','colleague','employee','customer','friend') COLLATE utf8_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `age` smallint(6) DEFAULT NULL,
  `is_friend` bit(1) NOT NULL DEFAULT b'0',
  `notes` text COLLATE utf8_unicode_ci,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `enabled` bit(1) NOT NULL DEFAULT b'0',
  `score` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of tbl_people
-- ----------------------------
BEGIN;
INSERT INTO `tbl_people` VALUES (1, 'Elliot', NULL, 'Alderson', 'M', NULL, 'mrr@f-society.xyz', 'US', 3, NULL, '1980-01-02', 29, b'1', 'Hello friend.', NULL, b'1', 93.00, '2020-03-03 12:00:00', '2020-10-19 10:38:26', NULL);
INSERT INTO `tbl_people` VALUES (2, 'Nestor', NULL, 'Burma', 'M', NULL, NULL, 'FR', 1, 'friend', NULL, NULL, b'0', NULL, NULL, b'1', 50.00, '2020-03-03 12:00:00', '2020-10-23 11:18:37', NULL);
INSERT INTO `tbl_people` VALUES (3, 'Peggy', NULL, 'Mitchell', 'F', NULL, NULL, 'GB', 2, 'unspecified', NULL, NULL, b'0', NULL, NULL, b'1', 50.00, '2020-03-03 12:00:00', '2020-10-23 11:18:55', NULL);
INSERT INTO `tbl_people` VALUES (4, 'Otto', NULL, 'Hantzen', 'M', NULL, NULL, 'DE', 4, 'unspecified', NULL, NULL, b'0', NULL, NULL, b'0', 50.00, '2020-03-03 12:00:00', '2020-10-23 11:25:08', NULL);
INSERT INTO `tbl_people` VALUES (5, 'Meltem', NULL, 'Çetinoğlu', 'F', NULL, NULL, 'TR', 5, 'customer', NULL, NULL, b'0', NULL, NULL, b'1', 57.00, '2020-03-03 12:00:00', '2020-10-23 11:24:49', NULL);
INSERT INTO `tbl_people` VALUES (6, 'Gökhan', NULL, 'Ozar', 'M', '123-456-7890', 'inexistent@email.address', NULL, 9, 'friend', NULL, NULL, b'1', 'The only non-fictional person in this database. Maker of the code generator.', '', b'1', 100.00, '2020-03-03 12:00:00', '2020-10-23 11:25:35', NULL);
INSERT INTO `tbl_people` VALUES (7, 'Arsen', NULL, 'Lupen', 'M', NULL, 'arsenlupen@yahoo.fr', NULL, 1, NULL, NULL, NULL, b'0', NULL, '', b'1', 21.00, '2020-03-03 12:00:00', '2020-10-23 11:26:06', NULL);
INSERT INTO `tbl_people` VALUES (8, 'Bea', '', 'Smith', 'F', '', 'bea.smith@email.com', 'AU', 15, NULL, '1975-06-20', 0, b'0', '', '', b'1', 44.00, '2020-03-03 12:00:00', NULL, NULL);
INSERT INTO `tbl_people` VALUES (9, 'Wilma', NULL, 'Burley', 'F', '432432', NULL, 'FR', 1, 'friend', NULL, NULL, b'1', 'Another fictional character', NULL, b'1', 100.00, '2020-03-03 12:00:00', '2020-10-21 18:31:59', NULL);
INSERT INTO `tbl_people` VALUES (10, 'Raymond', NULL, 'Parker', 'M', NULL, 'raypark2@gmail.com', 'GB', 16, NULL, '1987-06-21', NULL, b'0', 'Most promising newcomer', NULL, b'1', 68.00, '2020-03-03 12:00:00', NULL, NULL);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
