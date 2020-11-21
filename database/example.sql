SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `privilege`
-- ----------------------------
DROP TABLE IF EXISTS `privilege`;
CREATE TABLE `privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of privilege
-- ----------------------------
INSERT INTO `privilege` VALUES ('1', 'admin');
INSERT INTO `privilege` VALUES ('2', 'editor');
INSERT INTO `privilege` VALUES ('3', 'moderator');
INSERT INTO `privilege` VALUES ('4', 'registered');
INSERT INTO `privilege` VALUES ('5', 'guest');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_access` timestamp NULL DEFAULT NULL,
  `expire_date` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `privilege_id` int(11) NOT NULL,
  `enabled` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_ibfk_1` (`privilege_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`privilege_id`) REFERENCES `privilege` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'password', null, null, '1', '1');
INSERT INTO `user` VALUES ('2', 'user1', 'password', null, '2022-01-01 00:00:00', '2', '1');
