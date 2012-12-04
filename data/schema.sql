CREATE TABLE IF NOT EXISTS `cart_item_index` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value_string` varchar(255) DEFAULT NULL,
  `value_int` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_id`,`key`),
  KEY `int_string` (`key`,`value_string`),
  KEY `int_index` (`key`,`value_int`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `cart_item_index`
  ADD CONSTRAINT `cart_item_index_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `cart_item` (`item_id`);
