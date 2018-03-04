
--
-- Table structure for table customers
--

DROP TABLE IF EXISTS customers;
CREATE TABLE IF NOT EXISTS customers (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(100) DEFAULT NULL,
  discount decimal(10,2) DEFAULT NULL,
  user_id int(11) DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table customers
--

INSERT INTO customers (id, `name`, discount, user_id, created_at, updated_at) VALUES
(1, 'Owner', '100.00', 1, '2016-05-30 12:37:03', '2017-02-18 16:11:35'),
(2, 'VIP', '50.00', 1, '2017-02-18 16:05:34', '2018-03-01 11:03:19'),
(3, 'Best Customer', '30.00', 1, '2017-02-18 16:05:46', '2018-03-01 11:03:30'),
(4, 'Family', '100.00', 1, '2017-02-19 10:29:42', '2018-03-01 05:56:50');

-- --------------------------------------------------------

--
-- Table structure for table items
--

DROP TABLE IF EXISTS items;
CREATE TABLE IF NOT EXISTS items (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) DEFAULT NULL,
  item_category_id int(11) DEFAULT NULL,
  unit varchar(255) DEFAULT NULL,
  quantity float DEFAULT NULL,
  user_id int(11) DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table items
--

INSERT INTO items (id, `name`, item_category_id, unit, quantity, user_id, created_at, updated_at) VALUES
(4, 'សាច់ទា', 1, 'ក្បាល', NULL, 2, '2016-05-30 15:25:22', '2017-11-20 19:45:29'),
(5, 'សាច់មាន់', 1, 'kg', -0.1, 1, '2016-06-07 10:47:39', '2018-03-03 23:40:29');

-- --------------------------------------------------------

--
-- Table structure for table item_categories
--

DROP TABLE IF EXISTS item_categories;
CREATE TABLE IF NOT EXISTS item_categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(255) DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table item_categories
--

INSERT INTO item_categories (id, `name`, created_at, updated_at) VALUES
(1, 'Meat', '2015-12-20 20:58:06', '2016-12-26 20:28:00'),
(2, 'Vegetable', '2015-12-20 20:58:10', '2016-12-26 20:28:07'),
(3, 'Noodle', '2015-12-20 20:58:20', '2016-06-03 18:38:23');

-- --------------------------------------------------------

--
-- Table structure for table orders
--

DROP TABLE IF EXISTS orders;
CREATE TABLE IF NOT EXISTS orders (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  table_id int(11) DEFAULT NULL,
  status enum('Busy','Printed','Completed') DEFAULT 'Busy',
  customer_id int(11) DEFAULT NULL,
  discount int(11) DEFAULT '0',
  usd decimal(10,2) DEFAULT '0.00',
  user_id int(11) DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  checked_in datetime DEFAULT NULL,
  checked_out datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Dumping data for table orders
--

INSERT INTO orders (id, table_id, `status`, customer_id, discount, usd, user_id, created_at, updated_at, checked_in, checked_out) VALUES
(6, 11, 'Printed', NULL, 0, '0.00', 3, '2018-02-28 07:33:52', '2018-02-28 07:33:52', NULL, NULL),
(7, 16, 'Printed', 2, 100, '0.00', 3, '2018-02-28 07:38:22', '2018-02-28 07:38:40', '2018-02-28 07:38:22', NULL),
(8, 2, 'Printed', NULL, 0, '0.00', 3, '2018-02-28 08:49:58', '2018-02-28 09:21:55', '2018-02-28 08:49:58', '2018-02-28 09:21:55'),
(9, 2, 'Completed', 4, 100, '1000.00', 3, '2018-03-01 06:04:50', '2018-03-01 10:08:13', '2018-03-01 06:04:50', '2018-03-01 07:51:12'),
(10, 9, 'Completed', NULL, 0, '0.00', 3, '2018-03-01 06:19:13', '2018-03-01 06:19:13', '2018-03-01 06:19:13', NULL),
(11, 16, 'Printed', NULL, 0, '0.00', 3, '2018-03-01 06:19:51', '2018-03-01 10:11:49', '2018-03-01 06:19:51', '2018-03-01 10:11:49'),
(15, 17, 'Printed', NULL, 0, '0.00', 3, '2018-03-01 06:32:59', '2018-03-01 08:02:10', NULL, '2018-03-01 08:02:10'),
(16, 11, 'Printed', NULL, 0, '0.00', 3, '2018-03-01 09:08:54', '2018-03-01 10:09:06', '2018-03-01 09:08:54', '2018-03-01 10:09:06'),
(17, 12, 'Printed', NULL, 0, '0.00', 3, '2018-03-01 10:13:51', '2018-03-01 10:14:24', '2018-03-01 10:13:51', '2018-03-01 10:14:24'),
(18, 2, 'Busy', NULL, 0, '0.00', 3, '2018-03-01 10:19:29', '2018-03-01 10:19:29', '2018-03-01 10:19:29', NULL),
(19, 3, 'Completed', NULL, 0, '60.00', 3, '2018-03-02 03:11:14', '2018-03-02 05:11:26', '2018-03-02 03:11:14', NULL),
(20, 2, 'Completed', NULL, 0, '80.00', 3, '2018-03-02 04:58:55', '2018-03-02 05:10:27', '2018-03-02 04:58:55', NULL),
(21, 2, 'Completed', NULL, 0, '35.00', 3, '2018-03-02 05:11:45', '2018-03-02 05:11:53', '2018-03-02 05:11:45', NULL),
(22, 2, 'Completed', NULL, 0, '35.00', 3, '2018-03-02 05:12:34', '2018-03-02 05:12:47', '2018-03-02 05:12:34', '2018-03-02 05:12:37'),
(23, 2, 'Completed', NULL, 0, '35.00', 3, '2018-03-02 05:13:13', '2018-03-02 05:13:26', '2018-03-02 05:13:13', '2018-03-02 05:13:16'),
(24, 2, 'Completed', NULL, 0, '100.00', 3, '2018-03-02 20:26:08', '2018-03-02 20:26:15', '2018-03-02 20:26:08', NULL),
(25, 2, 'Completed', NULL, 0, '40.00', 3, '2018-03-02 20:28:05', '2018-03-02 20:28:24', '2018-03-02 20:28:05', NULL),
(26, 2, 'Completed', NULL, 0, '75.00', 3, '2018-03-03 08:13:00', '2018-03-03 23:38:23', '2018-03-03 08:13:00', '2018-03-03 23:37:56'),
(27, 2, 'Completed', NULL, 0, '200.00', 3, '2018-03-03 23:39:56', '2018-03-03 23:40:29', '2018-03-03 23:39:56', '2018-03-03 23:40:09');

-- --------------------------------------------------------

--
-- Table structure for table order_details
--

DROP TABLE IF EXISTS order_details;
CREATE TABLE IF NOT EXISTS order_details (
  id bigint(20) NOT NULL AUTO_INCREMENT,
  order_id bigint(20) DEFAULT NULL,
  product_id int(11) DEFAULT NULL,
  description varchar(500) DEFAULT NULL,
  quantity float DEFAULT NULL,
  price decimal(10,2) DEFAULT NULL,
  ordered_date datetime DEFAULT NULL,
  discount int(11) DEFAULT '0',
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  deleted_at datetime DEFAULT NULL,
  user_id int(11) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Dumping data for table order_details
--

INSERT INTO order_details (id, order_id, product_id, description, quantity, price, ordered_date, discount, created_at, updated_at, deleted_at, user_id) VALUES
(3, 6, 197, 'Americano', 1, '3.50', '2018-02-28 07:29:34', 0, '2018-02-28 07:29:34', '2018-02-28 07:33:52', NULL, 3),
(4, 7, 197, 'Americano', 1, '3.50', '2018-02-28 07:38:22', 0, '2018-02-28 07:38:22', '2018-02-28 07:38:22', NULL, 3),
(5, 7, 1041, 'Caramel Frappe', 1, '3.50', '2018-02-28 07:38:22', 0, '2018-02-28 07:40:50', '2018-02-28 07:40:50', NULL, 3),
(6, 8, 2, 'ก๊วยเตี๋ยวเรือ', 2, '4.00', '2018-02-28 08:49:58', 0, '2018-02-28 08:49:59', '2018-02-28 08:49:59', NULL, 3),
(7, 8, 5, 'ก๊วยเตี๋ยวไก่', 2, '3.50', '2018-02-28 08:49:58', 0, '2018-02-28 08:50:01', '2018-02-28 08:50:02', NULL, 3),
(8, 8, 232, 'Evian-1000ml', 2, '5.00', '2018-02-28 08:49:58', 0, '2018-02-28 08:50:05', '2018-02-28 08:50:06', NULL, 3),
(9, 9, 4, 'Capuchino', 1, '40.00', '2018-03-01 06:04:50', 0, '2018-03-01 06:04:50', '2018-03-01 06:10:17', '2018-03-01 06:10:17', 3),
(10, 10, 4, 'Capuchino', 1, '40.00', '2018-03-01 06:19:13', 0, '2018-03-01 06:19:14', '2018-03-01 06:19:18', '2018-03-01 06:19:18', 3),
(11, 11, 4, 'Capuchino', 1, '40.00', '2018-03-01 06:19:51', 0, '2018-03-01 06:19:51', '2018-03-01 06:19:55', '2018-03-01 06:19:55', 3),
(12, 11, 4, 'Capuchino', 1, '40.00', '2018-03-01 06:19:51', 0, '2018-03-01 06:23:21', '2018-03-01 06:24:23', '2018-03-01 06:24:23', 3),
(13, 15, 5, 'Latte', 1, '40.00', '2018-03-01 06:26:06', 0, '2018-03-01 06:26:06', '2018-03-01 07:38:18', '2018-03-01 07:38:18', 3),
(14, 12, NULL, 'tt', 1, '1.00', '2018-03-01 06:26:06', 0, '2018-03-01 06:32:14', '2018-03-01 06:32:26', '2018-03-01 06:32:26', 3),
(15, 9, 8, 'ข้าวผัดหมู', 1, '40.00', '2018-03-01 06:04:50', 0, '2018-03-01 07:50:36', '2018-03-01 07:50:36', NULL, 3),
(16, 9, 10, 'น้ำผลไม้ปั่น', 1, '35.00', '2018-03-01 06:04:50', 0, '2018-03-01 07:50:49', '2018-03-01 07:50:49', NULL, 3),
(17, 15, 1, 'Spring Roll', 1, '35.00', '2018-03-01 06:32:59', 0, '2018-03-01 07:54:45', '2018-03-01 07:54:45', NULL, 3),
(18, 15, 2, 'ข้าวเกรียบทอด', 1, '35.00', '2018-03-01 06:32:59', 0, '2018-03-01 08:02:09', '2018-03-01 08:02:09', NULL, 3),
(19, 11, 8, 'ข้าวผัดหมู', 1, '40.00', '2018-03-01 06:19:51', 0, '2018-03-01 08:04:30', '2018-03-01 08:05:48', '2018-03-01 08:05:48', 3),
(20, 11, 9, 'ข้าวผัดไก่', 1, '40.00', '2018-03-01 06:19:51', 0, '2018-03-01 08:04:32', '2018-03-01 08:05:51', '2018-03-01 08:05:51', 3),
(21, 11, 2, 'ข้าวเกรียบทอด', 1, '35.00', '2018-03-01 06:19:51', 0, '2018-03-01 08:05:53', '2018-03-01 08:17:07', '2018-03-01 08:17:07', 3),
(22, 16, 10, 'น้ำผลไม้ปั่น', 1, '35.00', '2018-03-01 09:08:54', 0, '2018-03-01 09:08:55', '2018-03-01 09:35:30', '2018-03-01 09:35:30', 3),
(23, 16, 1, 'Spring Roll', 1, '35.00', '2018-03-01 09:08:54', 0, '2018-03-01 10:08:31', '2018-03-01 10:08:31', NULL, 3),
(24, 11, 2, 'ข้าวเกรียบทอด', 1, '35.00', '2018-03-01 06:19:51', 0, '2018-03-01 10:11:06', '2018-03-01 10:11:06', NULL, 3),
(25, 11, 3, 'ยำวุ้นเส้น', 1, '60.00', '2018-03-01 06:19:51', 0, '2018-03-01 10:11:25', '2018-03-01 10:11:25', NULL, 3),
(26, 17, 1, 'Spring Roll', 2, '35.00', '2018-03-01 10:13:51', 0, '2018-03-01 10:13:51', '2018-03-01 10:19:18', '2018-03-01 10:19:18', 3),
(27, 17, 2, 'ข้าวเกรียบทอด', 2, '35.00', '2018-03-01 10:13:51', 0, '2018-03-01 10:13:52', '2018-03-01 10:19:20', '2018-03-01 10:19:20', 3),
(28, 18, 1, 'Spring Roll', 2, '35.00', '2018-03-01 10:19:29', 0, '2018-03-01 10:19:29', '2018-03-01 21:00:39', '2018-03-01 21:00:39', 3),
(29, 18, 2, 'ข้าวเกรียบทอด', 5, '35.00', '2018-03-01 10:19:29', 0, '2018-03-01 10:19:31', '2018-03-01 21:00:35', '2018-03-01 21:00:35', 3),
(30, 18, 3, 'ยำวุ้นเส้น', 2, '60.00', '2018-03-01 10:19:29', 0, '2018-03-01 10:19:41', '2018-03-01 21:00:32', '2018-03-01 21:00:32', 3),
(31, 18, 2, 'ข้าวเกรียบทอด', 1, '35.00', '2018-03-01 10:19:29', 0, '2018-03-01 21:00:40', '2018-03-01 21:22:07', '2018-03-01 21:22:07', 3),
(32, 18, 3, 'ยำวุ้นเส้น', 1, '60.00', '2018-03-01 10:19:29', 0, '2018-03-01 21:08:47', '2018-03-01 21:22:05', '2018-03-01 21:22:05', 3),
(33, 18, 7, 'Pancake', 1, '100.00', '2018-03-01 10:19:29', 0, '2018-03-01 21:14:05', '2018-03-01 21:22:12', '2018-03-01 21:22:12', 3),
(34, 18, 4, 'Capuchino', 1, '40.00', '2018-03-01 10:19:29', 0, '2018-03-01 21:15:40', '2018-03-01 21:22:14', '2018-03-01 21:22:14', 3),
(35, 18, 9, 'ข้าวผัดไก่', 1, '40.00', '2018-03-01 10:19:29', 0, '2018-03-01 21:15:44', '2018-03-01 21:22:10', '2018-03-01 21:22:10', 3),
(36, 18, 11, 'ต้มยำกุ้ง', 1, '100.00', '2018-03-01 10:19:29', 0, '2018-03-01 22:07:04', '2018-03-01 22:07:28', '2018-03-01 22:07:28', 3),
(37, 19, 13, 'ข้าวเหนียวมะม่วง', 2, '60.00', '2018-03-02 03:11:14', 0, '2018-03-02 03:11:14', '2018-03-02 03:12:58', '2018-03-02 03:12:58', 3),
(38, 19, 13, 'ผลไม้รวม', 1, '60.00', '2018-03-02 03:11:14', 0, '2018-03-02 03:13:00', '2018-03-02 03:13:00', NULL, 3),
(39, 20, 8, 'ข้าวผัดหมู', 2, '40.00', '2018-03-02 04:58:55', 0, '2018-03-02 04:58:55', '2018-03-02 05:00:16', NULL, 3),
(40, 21, 10, 'น้ำผลไม้ปั่น', 1, '35.00', '2018-03-02 05:11:45', 0, '2018-03-02 05:11:45', '2018-03-02 05:11:45', NULL, 3),
(41, 22, 10, 'น้ำผลไม้ปั่น', 1, '35.00', '2018-03-02 05:12:34', 0, '2018-03-02 05:12:34', '2018-03-02 05:12:34', NULL, 3),
(42, 23, 10, 'น้ำผลไม้ปั่น', 1, '35.00', '2018-03-02 05:13:13', 0, '2018-03-02 05:13:13', '2018-03-02 05:13:13', NULL, 3),
(43, 24, 10, 'น้ำผลไม้ปั่น', 1, '35.00', '2018-03-02 20:26:08', 0, '2018-03-02 20:26:09', '2018-03-02 20:26:09', NULL, 3),
(44, 25, 10, 'น้ำผลไม้ปั่น', 1, '35.00', '2018-03-02 20:28:05', 0, '2018-03-02 20:28:05', '2018-03-02 20:28:05', NULL, 3),
(45, 26, 10, 'น้ำผลไม้ปั่น', 1, '35.00', '2018-03-03 08:13:00', 0, '2018-03-03 08:13:01', '2018-03-03 08:13:01', NULL, 3),
(46, 26, 5, 'Latte', 1, '40.00', '2018-03-03 08:13:00', 0, '2018-03-03 08:13:03', '2018-03-03 08:13:03', NULL, 3),
(47, 27, 1, 'Spring Roll', 1, '35.00', '2018-03-03 23:39:56', 0, '2018-03-03 23:39:57', '2018-03-03 23:39:57', NULL, 3),
(48, 27, 6, 'Mocca', 1, '40.00', '2018-03-03 23:39:56', 0, '2018-03-03 23:40:01', '2018-03-03 23:40:01', NULL, 3),
(49, 27, 11, 'ต้มยำกุ้ง', 1, '100.00', '2018-03-03 23:39:56', 0, '2018-03-03 23:40:05', '2018-03-03 23:40:05', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table products
--

DROP TABLE IF EXISTS products;
CREATE TABLE IF NOT EXISTS products (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(500) DEFAULT NULL,
  product_category_id int(11) DEFAULT NULL,
  product_type_id int(11) DEFAULT NULL,
  unitprice decimal(10,2) DEFAULT '0.00',
  image varchar(255) DEFAULT NULL,
  user_id int(11) DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table products
--

INSERT INTO products (id, `name`, product_category_id, product_type_id, unitprice, image, user_id, created_at, updated_at) VALUES
(1, 'Spring Roll', 1, NULL, '35.00', NULL, 1, '2018-03-01 05:41:20', '2018-03-01 05:41:20'),
(2, 'ข้าวเกรียบทอด', 1, NULL, '35.00', NULL, 1, '2018-03-01 05:42:11', '2018-03-01 05:42:11'),
(3, 'ยำวุ้นเส้น', 1, NULL, '60.00', NULL, 1, '2018-03-01 05:42:33', '2018-03-01 05:42:33'),
(4, 'Capuchino', 3, NULL, '40.00', NULL, 1, '2018-03-01 05:42:57', '2018-03-01 05:42:57'),
(5, 'Latte', 3, NULL, '40.00', NULL, 1, '2018-03-01 05:43:09', '2018-03-01 05:43:19'),
(6, 'Mocca', 3, NULL, '40.00', NULL, 1, '2018-03-01 05:43:48', '2018-03-01 05:43:48'),
(7, 'Pancake', 6, NULL, '100.00', NULL, 1, '2018-03-01 05:44:19', '2018-03-01 05:44:19'),
(8, 'ข้าวผัดหมู', 4, NULL, '40.00', NULL, 1, '2018-03-01 05:45:05', '2018-03-01 05:45:05'),
(9, 'ข้าวผัดไก่', 4, NULL, '40.00', NULL, 1, '2018-03-01 05:45:37', '2018-03-01 05:45:37'),
(10, 'น้ำผลไม้ปั่น', 2, NULL, '35.00', NULL, 1, '2018-03-01 05:46:05', '2018-03-01 05:46:05'),
(11, 'ต้มยำกุ้ง', 5, NULL, '100.00', NULL, 1, '2018-03-01 05:46:51', '2018-03-01 05:46:51'),
(12, 'แกงจืด', 5, NULL, '80.00', NULL, 1, '2018-03-01 05:47:09', '2018-03-01 05:47:09'),
(13, 'ผลไม้รวม', 7, NULL, '60.00', NULL, NULL, NULL, NULL),
(14, 'Ice', 8, NULL, '20.00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table product_categories
--

DROP TABLE IF EXISTS product_categories;
CREATE TABLE IF NOT EXISTS product_categories (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(500) DEFAULT NULL,
  ordering int(11) DEFAULT '0',
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table product_categories
--

INSERT INTO product_categories (id, `name`, ordering, created_at, updated_at) VALUES
(1, 'Appetizer', 1, '2018-03-01 05:38:10', '2018-03-01 05:38:10'),
(2, 'Drink', 2, '2018-03-01 05:38:31', '2018-03-01 05:38:31'),
(3, 'Coffee&Tea', 3, '2018-03-01 05:38:59', '2018-03-01 05:38:59'),
(4, 'Food', 4, '2018-03-01 05:39:37', '2018-03-01 05:39:37'),
(5, 'Soup', 5, '2018-03-01 05:40:00', '2018-03-01 05:40:00'),
(6, 'Dessert', 6, '2018-03-01 05:40:19', '2018-03-01 05:40:19'),
(7, 'Fruit', 7, NULL, NULL),
(8, 'Others', 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table recipes
--

DROP TABLE IF EXISTS recipes;
CREATE TABLE IF NOT EXISTS recipes (
  id int(11) NOT NULL AUTO_INCREMENT,
  product_id int(11) DEFAULT NULL,
  item_id int(11) DEFAULT NULL,
  quantity decimal(10,2) DEFAULT '0.00',
  user_id int(11) DEFAULT NULL,
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table recipes
--

INSERT INTO recipes (id, product_id, item_id, quantity, user_id, created_at, updated_at) VALUES
(10, 14, 3, '0.10', 1, '2016-09-11 10:24:38', '2016-09-11 10:24:38'),
(11, 12, 5, '0.20', 1, '2016-09-11 10:24:55', '2016-09-11 10:24:55'),
(13, 1, 5, '0.10', 1, '2016-09-11 10:25:33', '2016-09-11 10:25:33'),
(14, 1167, 4, '1.00', 1, '2017-11-19 20:38:43', '2017-11-19 20:38:43');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS tables;
CREATE TABLE IF NOT EXISTS `tables` (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(50) DEFAULT NULL,
  status enum('Free','Busy','Printed') DEFAULT 'Free',
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (id, `name`, `status`, created_at, updated_at) VALUES
(2, '1', 'Free', NULL, '2018-03-03 23:40:29'),
(3, '2', 'Free', NULL, '2018-03-02 05:11:26'),
(4, '3', 'Free', NULL, '2017-04-09 07:57:46'),
(5, '4', 'Free', NULL, '2017-03-29 10:08:05'),
(6, '5', 'Free', NULL, '2017-04-09 08:38:24'),
(7, '6', 'Free', NULL, '2018-02-28 07:20:39'),
(8, '7', 'Free', NULL, '2017-11-21 13:16:07'),
(9, '8', 'Free', NULL, '2017-11-21 13:16:11'),
(10, '9', 'Free', NULL, '2018-02-28 07:33:40'),
(11, '10', 'Free', NULL, '2018-03-01 10:08:36'),
(12, '11', 'Free', NULL, '2018-03-01 10:14:24'),
(13, '12', 'Free', NULL, '2017-04-09 08:51:13'),
(14, '13', 'Free', NULL, '2017-04-09 07:52:55'),
(15, '14', 'Free', NULL, '2018-03-01 06:33:00'),
(16, '15', 'Free', NULL, '2018-03-01 10:11:49'),
(17, '16', 'Free', NULL, '2018-03-01 08:02:10'),
(18, '17', 'Free', NULL, '2018-02-28 07:33:52'),
(19, '18', 'Free', NULL, '2018-03-01 06:32:51');

-- --------------------------------------------------------

--
-- Table structure for table users
--

DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS users (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  username varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  password varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  remember_token varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  role enum('SuperAdmin','Admin','Cashier') COLLATE utf8_unicode_ci DEFAULT NULL,
  active tinyint(1) DEFAULT '0',
  created_at datetime DEFAULT NULL,
  updated_at datetime DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table users
--

INSERT INTO users (id, username, `password`, remember_token, role, active, created_at, updated_at) VALUES
(1, 'super', '$2y$10$Zy1XTuyhK3zxTdkkmFicmOXpIEtRpwzoNTZPuna/L9i08C/Bp8aCC', 'axPT2eGdGLjjbNwbLF9iNutjZ1FIEeIITqIYnSTYa8EV455qZ87iLKYrjgs2', 'SuperAdmin', 1, '2016-03-03 10:18:30', '2017-11-22 13:39:52'),
(2, 'admin', '$2y$10$OzvezM1JTpSyLjBnuxueg.NC9yDNovAGWSi1FFw6yZczE5y6tMpfO', 'hjCjjDeREQf1sc6DH4G6i8CDnOqB8BURraqoiUWXoO7HEk9bKC5MXH4pLRk7', 'Admin', 1, '2016-06-04 11:24:02', '2017-11-24 00:43:43'),
(3, 'cashier', '$2y$10$RGlUQWowwJ8ZCNcll9ByN.rvjp2ZN7HRMonM6wrF5T2ubIXLK8Sh.', 'FnN32C5uG7WCOZCmjOKFudvqkVrUBptNHlZT6HODqcknYUSESTCeCJhrEsmt', 'Cashier', 1, '2016-06-04 11:24:02', '2017-11-24 00:43:51');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
