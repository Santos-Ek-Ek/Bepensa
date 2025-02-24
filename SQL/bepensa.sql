/*
Navicat MySQL Data Transfer

Source Server         : Xampp Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : bepensa

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2025-02-23 16:24:46
*/
CREATE DATABASE bepensa;
USE bepensa;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for categorias
-- ----------------------------
DROP TABLE IF EXISTS `categorias`;
CREATE TABLE `categorias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `id_tipo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_tipo` (`id_tipo`) USING BTREE,
  CONSTRAINT `categorias_ibfk_1` FOREIGN KEY (`id_tipo`) REFERENCES `tipos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categorias
-- ----------------------------
INSERT INTO `categorias` VALUES ('1', '12 OZ', '1');
INSERT INTO `categorias` VALUES ('2', 'CC 500 ML', '1');
INSERT INTO `categorias` VALUES ('3', '500 ML', '1');
INSERT INTO `categorias` VALUES ('4', '1 LT RET VR', '1');
INSERT INTO `categorias` VALUES ('5', '1.5 LT RET', '1');
INSERT INTO `categorias` VALUES ('6', '2.5 LT RET', '1');
INSERT INTO `categorias` VALUES ('7', 'CC 3 LTS', '1');
INSERT INTO `categorias` VALUES ('8', 'AP 20 LTS', '1');
INSERT INTO `categorias` VALUES ('9', 'MONSTER', '2');
INSERT INTO `categorias` VALUES ('10', 'PREDADOR', '2');
INSERT INTO `categorias` VALUES ('11', '235 NRV', '2');
INSERT INTO `categorias` VALUES ('12', '300 NR', '2');
INSERT INTO `categorias` VALUES ('13', '355 NR', '2');
INSERT INTO `categorias` VALUES ('14', '450 ML', '2');
INSERT INTO `categorias` VALUES ('15', '600 NR 24 P', '2');
INSERT INTO `categorias` VALUES ('16', '600 12 P', '2');
INSERT INTO `categorias` VALUES ('17', '600 12 P CC', '2');
INSERT INTO `categorias` VALUES ('18', '600 9PACK CC', '2');
INSERT INTO `categorias` VALUES ('19', '600 6PACK', '2');
INSERT INTO `categorias` VALUES ('20', 'BEVI', '2');
INSERT INTO `categorias` VALUES ('21', '1LT', '2');
INSERT INTO `categorias` VALUES ('22', 'AGUA PURIFICADA', '2');
INSERT INTO `categorias` VALUES ('23', '1.35', '2');
INSERT INTO `categorias` VALUES ('24', '1.75', '2');
INSERT INTO `categorias` VALUES ('25', '2.5 NR', '2');
INSERT INTO `categorias` VALUES ('26', '3 LTS', '2');
INSERT INTO `categorias` VALUES ('27', 'PULPY', '2');
INSERT INTO `categorias` VALUES ('28', 'GENEROSA', '2');
INSERT INTO `categorias` VALUES ('29', 'VALLE 355', '2');
INSERT INTO `categorias` VALUES ('30', 'VALLE 600', '2');
INSERT INTO `categorias` VALUES ('31', 'VALLE 1.2 LT', '2');
INSERT INTO `categorias` VALUES ('32', 'VALLE 2 LTS', '2');
INSERT INTO `categorias` VALUES ('33', 'VALLE 3 LTS', '2');
INSERT INTO `categorias` VALUES ('34', 'POWER 500', '2');
INSERT INTO `categorias` VALUES ('35', 'POWER LT', '2');
INSERT INTO `categorias` VALUES ('36', 'OXXO', '2');
INSERT INTO `categorias` VALUES ('37', 'TPF', '2');
INSERT INTO `categorias` VALUES ('38', 'DVK 250', '2');
INSERT INTO `categorias` VALUES ('39', 'FUZE 600', '2');
INSERT INTO `categorias` VALUES ('40', 'CIEL LT', '2');
INSERT INTO `categorias` VALUES ('41', 'ADES', '2');
INSERT INTO `categorias` VALUES ('42', 'SANTA CLARA', '2');
INSERT INTO `categorias` VALUES ('43', '750', '2');
INSERT INTO `categorias` VALUES ('44', 'VACIOS', '3');
INSERT INTO `categorias` VALUES ('45', '500 ML', '3');
INSERT INTO `categorias` VALUES ('46', 'VAC 1 LT RV', '3');
INSERT INTO `categorias` VALUES ('47', 'PET', '3');
INSERT INTO `categorias` VALUES ('48', 'VACIO BOTELLON', '3');
INSERT INTO `categorias` VALUES ('49', 'PLÁSTICOS', '3');

-- ----------------------------
-- Table structure for facturas
-- ----------------------------
DROP TABLE IF EXISTS `facturas`;
CREATE TABLE `facturas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('Pendiente','Pagado') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of facturas
-- ----------------------------

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for inventarios
-- ----------------------------
DROP TABLE IF EXISTS `inventarios`;
CREATE TABLE `inventarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int(10) unsigned NOT NULL,
  `paletas` varchar(255) NOT NULL,
  `saldos_c_tarimas` varchar(255) NOT NULL,
  `saldos_s_tarimas` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `id_tipo` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_producto_inventario` (`id_producto`),
  KEY `id_tipo` (`id_tipo`),
  CONSTRAINT `id_producto_inventario` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `id_tip` FOREIGN KEY (`id_tipo`) REFERENCES `tipos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of inventarios
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2019_08_19_000000_create_failed_jobs_table', '1');
INSERT INTO `migrations` VALUES ('4', '2019_12_14_000001_create_personal_access_tokens_table', '1');
INSERT INTO `migrations` VALUES ('5', '2025_02_14_144914_create_facturas_table', '2');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_categoria` int(10) unsigned DEFAULT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categoria` (`id_categoria`),
  CONSTRAINT `id_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES ('1', '1', '2', 'CC 12 OZ', null);
INSERT INTO `productos` VALUES ('2', '1', '2227', 'MINERALIZADA', null);
INSERT INTO `productos` VALUES ('3', '1', '3812', 'CC 235 RV', null);
INSERT INTO `productos` VALUES ('4', '2', '1868', 'COCA 500', null);
INSERT INTO `productos` VALUES ('5', '3', '1015', 'FANTA 500', null);
INSERT INTO `productos` VALUES ('6', '3', '1915', 'MUNDET 500', null);
INSERT INTO `productos` VALUES ('7', '3', '2152', 'CR NEGRA 500', null);
INSERT INTO `productos` VALUES ('8', '3', '3586', 'CC SA 500', null);
INSERT INTO `productos` VALUES ('9', '3', '3723', '18 CC - 6 CCSA', null);
INSERT INTO `productos` VALUES ('10', '3', '3845', 'SPRITE 500', null);
INSERT INTO `productos` VALUES ('11', '4', '3994', 'CC 1LT VR 12P', null);
INSERT INTO `productos` VALUES ('12', '5', '18', 'CC 1.5 RP', null);
INSERT INTO `productos` VALUES ('13', '5', '3749', 'FANTA 1.5 BOT UNI', null);
INSERT INTO `productos` VALUES ('14', '5', '3750', 'MUNDET 1.5 BOT UNI', null);
INSERT INTO `productos` VALUES ('15', '5', '3751', 'CC SIN AZ BOT UNI', null);
INSERT INTO `productos` VALUES ('16', '5', '3752', 'VALLE FRT 1.5 BOT UNI', null);
INSERT INTO `productos` VALUES ('17', '5', '3833', 'SURT CC FTA+MUND 1.5', null);
INSERT INTO `productos` VALUES ('18', '5', '5159', 'CRISTAL T?? 1.5L RP UV 12P', null);
INSERT INTO `productos` VALUES ('19', '6', '131', 'CC 2.5 RP', null);
INSERT INTO `productos` VALUES ('20', '7', '3885', 'CC 3 LTS RP', null);
INSERT INTO `productos` VALUES ('21', '8', '1191', 'AP 20 LTS', null);
INSERT INTO `productos` VALUES ('22', '9', '3808', 'MONSTER ENERGY', null);
INSERT INTO `productos` VALUES ('23', '9', '3880', 'MONSTER ZERO ULTRA', null);
INSERT INTO `productos` VALUES ('24', '9', '4546', 'MONSTER ULT PARADISE', null);
INSERT INTO `productos` VALUES ('25', '10', '3961', 'PREDATOR 355 LTA', null);
INSERT INTO `productos` VALUES ('26', '10', '4598', 'PREDATOR MEANGREAN 355', null);
INSERT INTO `productos` VALUES ('27', '10', '4575', 'PREDATOR MEANGREEN 473', null);
INSERT INTO `productos` VALUES ('28', '11', '2922', 'CC235 NRV', null);
INSERT INTO `productos` VALUES ('29', '11', '3758', 'CC 235 NRP 12 P', null);
INSERT INTO `productos` VALUES ('30', '11', '3899', 'CCSA 235 NR', null);
INSERT INTO `productos` VALUES ('31', '12', '2457', 'SURT CR', null);
INSERT INTO `productos` VALUES ('32', '12', '2462', 'FANTA', null);
INSERT INTO `productos` VALUES ('33', '12', '2463', 'SPRITE', null);
INSERT INTO `productos` VALUES ('34', '12', '2464', 'MUNDET', null);
INSERT INTO `productos` VALUES ('35', '12', '3583', 'MINERALIZADA', null);
INSERT INTO `productos` VALUES ('36', '12', '5183', 'FANTA UVA 6P', null);
INSERT INTO `productos` VALUES ('37', '12', '5184', 'FANTA PI?A 6P', null);
INSERT INTO `productos` VALUES ('38', '13', '2991', 'CC 355 12 P', null);
INSERT INTO `productos` VALUES ('39', '13', '3058', 'CC SA 355', null);
INSERT INTO `productos` VALUES ('40', '13', '3068', 'CC LIGHT 355', null);
INSERT INTO `productos` VALUES ('41', '13', '5185', 'CC CONTORTIONS 355', null);
INSERT INTO `productos` VALUES ('42', '14', '3759', 'CC 450 24P', null);
INSERT INTO `productos` VALUES ('43', '15', '815', 'CC 600 24 P', null);
INSERT INTO `productos` VALUES ('44', '16', '2224', 'MINERALIZADA 600', null);
INSERT INTO `productos` VALUES ('45', '16', '1056', 'FRESA 600', null);
INSERT INTO `productos` VALUES ('46', '16', '1057', 'NEGRA', null);
INSERT INTO `productos` VALUES ('47', '16', '1058', 'CEBADA 600', null);
INSERT INTO `productos` VALUES ('48', '16', '3868', 'TOPO CHIICO 600 12P', null);
INSERT INTO `productos` VALUES ('49', '17', '1076', 'CC LIGHT 600 12P', null);
INSERT INTO `productos` VALUES ('50', '17', '1156', 'CC 600 12', null);
INSERT INTO `productos` VALUES ('51', '17', '3059', 'CCSA 12', null);
INSERT INTO `productos` VALUES ('52', '18', '3819', 'FANTA 9 P', null);
INSERT INTO `productos` VALUES ('53', '18', '3823', 'SPRITE 9 P', null);
INSERT INTO `productos` VALUES ('54', '18', '3820', 'FRESCA 9P', null);
INSERT INTO `productos` VALUES ('55', '18', '3821', 'MUNDET 9 P', null);
INSERT INTO `productos` VALUES ('56', '18', '3900', 'FANTA UVA 600', null);
INSERT INTO `productos` VALUES ('57', '18', '4607', 'MUNDET MANDARINA', null);
INSERT INTO `productos` VALUES ('58', '18', '5176', 'DEL VALLE FIZZ LIMON', null);
INSERT INTO `productos` VALUES ('59', '18', '5177', 'DEL VALLE FIZZ NARANJA', null);
INSERT INTO `productos` VALUES ('60', '18', '4606', 'MUNDET SANGRIA', null);
INSERT INTO `productos` VALUES ('61', '19', '1698', 'NEGRA 600 6 PACK', null);
INSERT INTO `productos` VALUES ('62', '19', '1699', 'FRESA 600 6 PACK', null);
INSERT INTO `productos` VALUES ('63', '19', '1700', 'CEBADA 600 6 PACK', null);
INSERT INTO `productos` VALUES ('64', '20', '423', 'BEVI 12', null);
INSERT INTO `productos` VALUES ('65', '20', '990', 'BEVI BOT 24P', null);
INSERT INTO `productos` VALUES ('66', '20', '2951', 'BEVI TETRA', null);
INSERT INTO `productos` VALUES ('67', '20', '3866', 'TOPO CHICO 355 RV', null);
INSERT INTO `productos` VALUES ('68', '21', '2842', 'CR TE LT 6P', null);
INSERT INTO `productos` VALUES ('69', '22', '194', 'AP 1.5 LTS', null);
INSERT INTO `productos` VALUES ('70', '22', '1187', 'AP 5 LTS 4P', null);
INSERT INTO `productos` VALUES ('71', '22', '1244', 'AP 600 24P', null);
INSERT INTO `productos` VALUES ('72', '22', '5039', 'AP NR 600 12 P', null);
INSERT INTO `productos` VALUES ('73', '22', '2058', 'AP 1.2 LT', null);
INSERT INTO `productos` VALUES ('74', '23', '3964', 'CC 1.35', null);
INSERT INTO `productos` VALUES ('75', '23', '3982', 'CCSA 1.35', null);
INSERT INTO `productos` VALUES ('76', '23', '3982', 'CC LIGHT 1.35', null);
INSERT INTO `productos` VALUES ('77', '23', '3966', 'CEBADA 1.35', null);
INSERT INTO `productos` VALUES ('78', '23', '3968', 'FRESA 1.35', null);
INSERT INTO `productos` VALUES ('79', '23', '3970', 'NEGRA 1.35', null);
INSERT INTO `productos` VALUES ('80', '23', '3972', 'FANTA 1.35', null);
INSERT INTO `productos` VALUES ('81', '23', '3974', 'FRESCA 1.35', null);
INSERT INTO `productos` VALUES ('82', '23', '3976', 'MUNDET 1.35', null);
INSERT INTO `productos` VALUES ('83', '23', '3978', 'SPRITE 1.35', null);
INSERT INTO `productos` VALUES ('84', '23', '4609', 'MUNDET MANDARINA 1.35', null);
INSERT INTO `productos` VALUES ('85', '24', '2920', 'CC 1.75 9P', null);
INSERT INTO `productos` VALUES ('86', '24', '3893', 'CC LIGHT 1.75', null);
INSERT INTO `productos` VALUES ('87', '24', '4539', 'CEBADA 1.75', null);
INSERT INTO `productos` VALUES ('88', '24', '4540', 'FRESA 1.75', null);
INSERT INTO `productos` VALUES ('89', '24', '4541', 'NEGRA 1.75', null);
INSERT INTO `productos` VALUES ('90', '24', '3984', 'FANTA 1.75', null);
INSERT INTO `productos` VALUES ('91', '24', '3986', 'FRESCA 1.75', null);
INSERT INTO `productos` VALUES ('92', '24', '3988', 'MUNDET 1.75', null);
INSERT INTO `productos` VALUES ('93', '24', '3990', 'SPRITE 1.75', null);
INSERT INTO `productos` VALUES ('94', '24', '4574', 'MINERAL 1.75 9P', null);
INSERT INTO `productos` VALUES ('95', '24', '3867', 'TOPO CHICO ', null);
INSERT INTO `productos` VALUES ('96', '25', '3030', 'NEGRA 2.5', null);
INSERT INTO `productos` VALUES ('97', '25', '3031', 'CEBADA 2.5', null);
INSERT INTO `productos` VALUES ('98', '25', '3032', 'FRESA 2.5', null);
INSERT INTO `productos` VALUES ('99', '25', '3065', 'CC SA 2.5', null);
INSERT INTO `productos` VALUES ('100', '25', '3585', 'MINERALIZADA 2.5', null);
INSERT INTO `productos` VALUES ('101', '25', '3633', 'CC 2.5 NR', null);
INSERT INTO `productos` VALUES ('102', '25', '736', 'FANTA 2.5', null);
INSERT INTO `productos` VALUES ('103', '25', '796', 'SPRITE 2.5', null);
INSERT INTO `productos` VALUES ('104', '25', '797', 'FRESCA 2.5', null);
INSERT INTO `productos` VALUES ('105', '25', '1934', 'MUNDET 2.5', null);
INSERT INTO `productos` VALUES ('106', '26', '189', 'CC 3LTS', null);
INSERT INTO `productos` VALUES ('107', '26', '1221', 'NEGRA', null);
INSERT INTO `productos` VALUES ('108', '26', '1770', 'FANTA', null);
INSERT INTO `productos` VALUES ('109', '26', '1771', 'FRESCA', null);
INSERT INTO `productos` VALUES ('110', '26', '1807', 'FRESA', null);
INSERT INTO `productos` VALUES ('111', '26', '2206', 'SPRITE', null);
INSERT INTO `productos` VALUES ('112', '26', '2405', 'MUNDET', null);
INSERT INTO `productos` VALUES ('113', '27', '2709', 'PULPY', null);
INSERT INTO `productos` VALUES ('114', '27', '3579', 'PULPY MANGO', null);
INSERT INTO `productos` VALUES ('115', '27', '3753', 'PULPY SABILA', null);
INSERT INTO `productos` VALUES ('116', '28', '2648', 'MANGO 6P', null);
INSERT INTO `productos` VALUES ('117', '28', '2650', 'MANZANA 6 P', null);
INSERT INTO `productos` VALUES ('118', '29', '2758', 'CTPCH 355', null);
INSERT INTO `productos` VALUES ('119', '30', '2747', 'VFT UVA 600', null);
INSERT INTO `productos` VALUES ('120', '30', '2749', 'VFT CTPCH 600', null);
INSERT INTO `productos` VALUES ('121', '30', '5161', 'VFT MANDARINA 600', null);
INSERT INTO `productos` VALUES ('122', '31', '3814', 'CTPCH 1.2 LTS', null);
INSERT INTO `productos` VALUES ('123', '32', '2714', 'CTPCH 2 LTS', null);
INSERT INTO `productos` VALUES ('124', '32', '2754', 'VFT UVA 2LTS', null);
INSERT INTO `productos` VALUES ('125', '32', '5160', 'VFT MANDARINA 2L', null);
INSERT INTO `productos` VALUES ('126', '33', '2768', 'CTPCH 3 LTS', null);
INSERT INTO `productos` VALUES ('127', '33', '3992', 'VALLE UVA 3 LTS', null);
INSERT INTO `productos` VALUES ('128', '33', '3991', 'VALLE PI?A 3 LTS', null);
INSERT INTO `productos` VALUES ('129', '34', '1528', 'POWER MORA 500', null);
INSERT INTO `productos` VALUES ('130', '34', '1531', 'POWER LIMON 500', null);
INSERT INTO `productos` VALUES ('131', '34', '1677', 'POWER UVA 500', null);
INSERT INTO `productos` VALUES ('132', '34', '2915', 'POWER NARANJA 500', null);
INSERT INTO `productos` VALUES ('133', '35', '1635', 'POWER MORA LT', null);
INSERT INTO `productos` VALUES ('134', '35', '1638', 'POWER LIMON LT', null);
INSERT INTO `productos` VALUES ('135', '35', '2916', 'POWER NARANJA LT', null);
INSERT INTO `productos` VALUES ('136', '35', '2837', 'POWER UVA LT', null);
INSERT INTO `productos` VALUES ('137', '36', '1327', 'CC 6 PACK 355', null);
INSERT INTO `productos` VALUES ('138', '36', '2393', 'CC LATA 235 8 PACK', null);
INSERT INTO `productos` VALUES ('139', '36', '3056', 'CC SA 235 8 PACK', null);
INSERT INTO `productos` VALUES ('140', '36', '1687', 'BIPACK CC 2.5', null);
INSERT INTO `productos` VALUES ('141', '37', '4595', 'VALLE FRUT CONG UVA-FSA', null);
INSERT INTO `productos` VALUES ('142', '37', '4589', 'VALLE FRUT FRESA 1.35 L', null);
INSERT INTO `productos` VALUES ('143', '37', '4590', 'VALLE FRUT UVA 1.35 L', null);
INSERT INTO `productos` VALUES ('144', '37', '4586', 'VALLE FRUT FRESA 2.5 L', null);
INSERT INTO `productos` VALUES ('145', '37', '4587', 'VALLE FRUT UVA 2.5 L', null);
INSERT INTO `productos` VALUES ('146', '38', '2723', 'DVK MANZANA', null);
INSERT INTO `productos` VALUES ('147', '38', '3882', 'DV 100% JUGO MANZANA', null);
INSERT INTO `productos` VALUES ('148', '38', '3881', 'DV 100% JUGO NARANJA', null);
INSERT INTO `productos` VALUES ('149', '38', '2637', 'FRUTSI UVA', null);
INSERT INTO `productos` VALUES ('150', '38', '3902', 'DEL VALLE PI?A 1.89', null);
INSERT INTO `productos` VALUES ('151', '39', '3523', 'FUZE NEGRO 600', null);
INSERT INTO `productos` VALUES ('152', '39', '3524', 'FUZE VERDE 600', null);
INSERT INTO `productos` VALUES ('153', '39', '1969', 'FUZE 600 ml NRP TE DURAZNO', null);
INSERT INTO `productos` VALUES ('154', '39', '2359', 'FUZE 600 ml NRP TE FRUTOS ROJOS', null);
INSERT INTO `productos` VALUES ('155', '39', '2406', 'FUZE 600 ml MGO-MANZANILLA', null);
INSERT INTO `productos` VALUES ('156', '40', '2883', 'CIEL JAMAICA 1 L', null);
INSERT INTO `productos` VALUES ('157', '41', '3403', 'MANZANA 200', null);
INSERT INTO `productos` VALUES ('158', '41', '3405', 'GUANABANA 946', null);
INSERT INTO `productos` VALUES ('159', '41', '3406', 'NATURAL 946', null);
INSERT INTO `productos` VALUES ('160', '41', '3408', 'MANZANA 946', null);
INSERT INTO `productos` VALUES ('161', '42', '3339', 'STC CHOC 4P', null);
INSERT INTO `productos` VALUES ('162', '42', '3341', 'STC CAPUC 4P', null);
INSERT INTO `productos` VALUES ('163', '42', '3340', 'STC VAINILLA 4P', null);
INSERT INTO `productos` VALUES ('164', '42', '3359', 'STC FRESA 4P', null);
INSERT INTO `productos` VALUES ('165', '43', '3361', 'STC ENTERA 750', null);
INSERT INTO `productos` VALUES ('166', '43', '3363', 'STC DESLA 750', null);
INSERT INTO `productos` VALUES ('167', '43', '3367', 'STC CHOC 750', null);
INSERT INTO `productos` VALUES ('168', '43', '3745', 'STC FRESA 750', null);
INSERT INTO `productos` VALUES ('169', '44', '202', 'CC GRANDE', null);

-- ----------------------------
-- Table structure for productos_entradas
-- ----------------------------
DROP TABLE IF EXISTS `productos_entradas`;
CREATE TABLE `productos_entradas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int(10) unsigned NOT NULL,
  `id_entrada` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_entrada` (`id_entrada`),
  KEY `id_producto_entrada` (`id_producto`),
  CONSTRAINT `id_entrada` FOREIGN KEY (`id_entrada`) REFERENCES `entradas` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `id_producto_entrada` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of productos_entradas
-- ----------------------------

-- ----------------------------
-- Table structure for productos_salidas
-- ----------------------------
DROP TABLE IF EXISTS `productos_salidas`;
CREATE TABLE `productos_salidas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_producto` int(10) unsigned NOT NULL,
  `id_salida` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_salida` (`id_salida`),
  KEY `id_producto_salida` (`id_producto`),
  CONSTRAINT `id_producto_salida` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `id_salida` FOREIGN KEY (`id_salida`) REFERENCES `salidas` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of productos_salidas
-- ----------------------------

-- ----------------------------
-- Table structure for proveedores
-- ----------------------------
DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `proveedor` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `tipo_producto` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of proveedores
-- ----------------------------
INSERT INTO `proveedores` VALUES ('1', 'EMBE Pacabtun', 'Kilometro 2 tap catastral 4186, carretera Valladolid, Merida, parque Industrial, C.P: 97780', 'Refrescos');
INSERT INTO `proveedores` VALUES ('2', 'EMBE Valladolid', 'Calle 7 #96 x 12 y 22, colonia:Mekchor Ocampos II, C.P:971065', 'Aguas');

-- ----------------------------
-- Table structure for salidas
-- ----------------------------
DROP TABLE IF EXISTS `salidas`;
CREATE TABLE `salidas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cantidad` varchar(300) NOT NULL,
  `fecha` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of salidas
-- ----------------------------

-- ----------------------------
-- Table structure for tipos
-- ----------------------------
DROP TABLE IF EXISTS `tipos`;
CREATE TABLE `tipos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tipos
-- ----------------------------
INSERT INTO `tipos` VALUES ('1', 'Retornable');
INSERT INTO `tipos` VALUES ('2', 'No retornable');
INSERT INTO `tipos` VALUES ('3', 'Vacíos');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apellidos` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES ('1', 'Manuel ', 'Roser Alcocer', 'mjRosel', 'Bepensa2023-2030*', '2023-08-03 08:25:48', '2023-08-03 08:25:48');
INSERT INTO `usuarios` VALUES ('2', 'Juan Esteban', 'Rodriguez Canul', 'jeRodriguez', 'Bepensa2024+', null, null);
INSERT INTO `usuarios` VALUES ('3', 'Mary Jeanine', 'Ek Oxte', 'mJeanine', '123456789', '2023-07-25 08:13:43', '2023-07-25 08:13:43');
