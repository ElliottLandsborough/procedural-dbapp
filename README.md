Procedural database editor with ajax/json/php/mysql/html5/css3
==============================================================

To do:
 - sort by all rows
 - display only rows containing specified categories
 - some nicer styles

Done:
 - add data to mysql
 - category,date,person,text,price
 - default sorted by category
 - editable rows
 - some cool frontend stuff

DB Structure:

-- Database: `work_test`

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` bigint(32) NOT NULL AUTO_INCREMENT,
  `category_name` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `table1` (
  `item_id` bigint(32) NOT NULL AUTO_INCREMENT,
  `category_id` bigint(32) NOT NULL,
  `item_date` date NOT NULL,
  `item_person` text NOT NULL,
  `item_text` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;
