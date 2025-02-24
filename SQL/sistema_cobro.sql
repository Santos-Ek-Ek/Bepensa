/*
Navicat MySQL Data Transfer

Source Server         : Xampp Local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : sistema_cobro

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2025-02-23 16:23:52
*/
CREATE DATABASE nautica;
USE nautica;

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for detalle_transaccion
-- ----------------------------
DROP TABLE IF EXISTS `detalle_transaccion`;
CREATE TABLE `detalle_transaccion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaccion_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `transaccion_id` (`transaccion_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `detalle_transaccion_ibfk_1` FOREIGN KEY (`transaccion_id`) REFERENCES `transacciones` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detalle_transaccion_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of detalle_transaccion
-- ----------------------------

-- ----------------------------
-- Table structure for facturas
-- ----------------------------
DROP TABLE IF EXISTS `facturas`;
CREATE TABLE `facturas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('Pendiente','Pagado') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of facturas
-- ----------------------------
INSERT INTO `facturas` VALUES ('1', 'Cliente A', '500.00', 'Pendiente');
INSERT INTO `facturas` VALUES ('2', 'Cliente B', '1200.50', 'Pagado');
INSERT INTO `facturas` VALUES ('3', 'Cliente C', '750.75', 'Pendiente');
INSERT INTO `facturas` VALUES ('4', 'Cliente D', '200.00', 'Pagado');

-- ----------------------------
-- Table structure for productos
-- ----------------------------
DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of productos
-- ----------------------------
INSERT INTO `productos` VALUES ('1', 'P001', 'Coca Cola 600ml', '15.00');
INSERT INTO `productos` VALUES ('2', 'P002', 'Pepsi 600ml', '14.50');
INSERT INTO `productos` VALUES ('3', 'P003', 'Agua Ciel 1L', '10.00');
INSERT INTO `productos` VALUES ('4', 'P004', 'Fanta 600ml', '15.50');

-- ----------------------------
-- Table structure for transacciones
-- ----------------------------
DROP TABLE IF EXISTS `transacciones`;
CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of transacciones
-- ----------------------------
