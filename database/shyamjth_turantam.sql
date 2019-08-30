-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 30, 2019 at 01:11 PM
-- Server version: 5.6.41-84.1-log
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shyamjth_turantam`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `address` longtext NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `state_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_address`
--

INSERT INTO `customer_address` (`id`, `type`, `address`, `pincode`, `state_id`, `customer_id`, `date_created`, `is_active`, `is_deleted`) VALUES
(1, '', 'Krishnapur, Chandeberia', '700102', 10, 21, '2018-11-02 12:48:18', '1', '0'),
(2, '', 'Krishnapur, Chandeberia , Kolkata', '700109', 1, 21, '2018-11-02 12:48:18', '1', '0'),
(3, '', 'Saltlake,Sec-V', '700009', 1, 21, '2018-11-02 13:12:25', '1', '0'),
(4, '', 'Saltlake,Sec-V', '700009', 1, 21, '2018-11-02 13:12:37', '1', '0'),
(5, 'business', 'Saltlake,Sec-V', '700009', 1, 21, '2018-11-03 11:00:13', '1', '0'),
(6, 'home', 'Saltlake,Sec-V', '700009', 1, 21, '2018-11-03 11:00:39', '1', '0'),
(7, 'sdfsd', 'dfgdfgdg', 'gdffdgf1', 33, 21, '2018-11-05 15:27:27', '1', '0'),
(8, 'Home', 'Saltlake , sector 1, Kolkata', '700001', 1, 28, '2018-11-09 06:53:12', '1', '0'),
(9, 'Home', 'Kolkata ', '700091', 1, 2, '2018-11-09 09:03:44', '1', '0'),
(10, 'Home', 'Saltlake , sector 1, Kolkata', '700001', 1, 31, '2018-11-09 11:15:36', '1', '0'),
(11, 'Home', 'Saltlake , sector 1, Kolkata', '700001', 1, 32, '2018-11-14 13:01:08', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `gallery_settings`
--

CREATE TABLE `gallery_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image_small` varchar(256) DEFAULT NULL,
  `image_large` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery_settings`
--

INSERT INTO `gallery_settings` (`id`, `name`, `image_small`, `image_large`, `date_created`, `is_active`, `is_deleted`) VALUES
(11, 'ssssss', 'gallery_images/image_small/large1541419343blog_gal_3_thumb.jpg', 'gallery_images/image_large/large1541419343blog_gal_3.jpg', '2018-11-05 12:02:23', '1', '0'),
(12, 'ssss', 'gallery_images/image_small/1541421084blog_grid_12_thumb.jpg', 'gallery_images/image_large/1541421084blog_grid_12.jpg', '2018-11-05 12:06:50', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `mail_templates`
--

CREATE TABLE `mail_templates` (
  `id` int(11) NOT NULL,
  `template_code` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mail_templates`
--

INSERT INTO `mail_templates` (`id`, `template_code`, `subject`, `content`, `is_active`, `is_deleted`, `created_at`, `modified_at`) VALUES
(1, 'user-register', 'New User Registration', '<table style=\"border: groove 1px red;\" border=\"0\" width=\"600px\" cellspacing=\"1\" cellpadding=\"5\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td bgcolor=\"red\" width=\"478\">\r\n<table border=\"0\" width=\"570\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\" valign=\"middle\" width=\"322\">&nbsp;</td>\r\n<td align=\"right\" valign=\"middle\" width=\"248\"><span class=\"style15\" style=\"color: #fff;\">Turantam</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>Hi, [[name]]</td>\r\n</tr>\r\n<tr>\r\n<td>Welcome to Turantam.Your sign-up details</td>\r\n</tr>\r\n<tr>\r\n<td>\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"8\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\"><span class=\"style22\">Username :</span></td>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\"><span class=\"style26\">[[email]]</span></td>\r\n</tr>\r\n<tr>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\"><span class=\"style22\">Password:</span></td>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\"><span class=\"style26\">[[password]]</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '1', '0', '2018-09-01 05:38:10', '2018-11-08 09:50:12'),
(2, 'subscribe-user', 'Subscribe Details', '<div dir=\"ltr\">\r\n<div class=\"gmail_quote\">You have been subscribed.</div>\r\n<div class=\"gmail_quote\">&nbsp;</div>\r\n<div class=\"gmail_quote\">Email : [[email]]</div>\r\n<div class=\"gmail_quote\">&nbsp;</div>\r\n<div dir=\"ltr\">&nbsp;<img src=\"http://192.168.24.208/pranav/uploads/blog_content_images/1537944460blog_grid_2.jpg\" alt=\"\" width=\"631\" height=\"453\" /></div>\r\n</div>', '0', '0', '2018-09-01 05:54:40', '2018-11-06 05:28:09'),
(3, 'contact-us', 'New Query', '<table style=\"border: groove 1px red;\" border=\"0\" width=\"600px\" cellspacing=\"1\" cellpadding=\"5\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td bgcolor=\"red\" width=\"478\">\r\n<table border=\"0\" width=\"570\" cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\" valign=\"middle\" width=\"322\">&nbsp;</td>\r\n<td align=\"right\" valign=\"middle\" width=\"248\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td bgcolor=\"red\">\r\n<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"8\">\r\n<tbody>\r\n<tr>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\" width=\"17%\"><span class=\"style22\"> Name :</span></td>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\" width=\"83%\"><span class=\"style26\">[[name]]</span></td>\r\n</tr>\r\n<tr>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\"><span class=\"style22\">E-Mail :</span></td>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\"><span class=\"style26\">[[email]]</span></td>\r\n</tr>\r\n<tr>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\"><span class=\"style22\">Phone :</span></td>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\"><span class=\"style26\">[[phone]]</span></td>\r\n</tr>\r\n<tr>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\"><span class=\"style22\">Message:</span></td>\r\n<td align=\"left\" valign=\"top\" bgcolor=\"#FFFFFF\"><span class=\"style26\">[[message]]</span></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', '1', '0', '2018-09-12 06:38:05', '2018-11-08 12:29:02');

-- --------------------------------------------------------

--
-- Table structure for table `master_country`
--

CREATE TABLE `master_country` (
  `id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL,
  `country_code` varchar(100) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` set('0','1') NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_country`
--

INSERT INTO `master_country` (`id`, `country_name`, `country_code`, `is_active`, `date_created`, `is_deleted`) VALUES
(1, 'India', 'IN', '1', '2018-11-01 12:14:48', '0'),
(2, 'Austrelia', 'AU', '1', '2018-11-01 12:39:51', '0'),
(3, 'Srilanka', 'SR', '0', '2018-11-01 12:40:39', '0');

-- --------------------------------------------------------

--
-- Table structure for table `master_location`
--

CREATE TABLE `master_location` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_location`
--

INSERT INTO `master_location` (`id`, `name`, `latitude`, `longitude`, `date_created`, `is_active`, `is_deleted`) VALUES
(1, 'Kolkata', '22.5726° N', '88.3639° E', '2018-10-23 09:43:11', '1', '0'),
(2, 'Howrah', '22.5958° N', '88.2636° E', '2018-10-23 09:43:19', '1', '0'),
(3, 'Saltlake', '334234', '423432423', '2018-11-01 18:46:31', '1', '0'),
(4, 'Rajarhat1', '3342341', '82.0691', '2018-11-01 18:47:00', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `master_state`
--

CREATE TABLE `master_state` (
  `id` int(11) NOT NULL,
  `state_name` varchar(100) NOT NULL,
  `state_code` varchar(100) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `country_id` int(11) NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `master_state`
--

INSERT INTO `master_state` (`id`, `state_name`, `state_code`, `is_active`, `country_id`, `is_deleted`, `date_created`) VALUES
(1, 'West Bengal', 'WB', '1', 1, '0', '2018-11-02 05:11:57'),
(2, 'Andaman and Nicobar Islands', 'AN', '1', 1, '0', '2018-11-02 05:11:57'),
(3, 'Andhra Pradesh', 'AD', '1', 1, '0', '2018-11-02 05:11:57'),
(4, 'Arunachal Pradesh', 'AR', '1', 1, '0', '2018-11-02 05:11:57'),
(5, 'Assam', 'AS', '1', 1, '0', '2018-11-02 05:11:57'),
(6, 'Bihar', 'BR', '1', 1, '0', '2018-11-02 05:11:57'),
(7, 'Chandigarh', 'CH', '1', 1, '0', '2018-11-02 05:11:57'),
(8, 'Chattisgarh', 'CG', '1', 1, '0', '2018-11-02 05:11:57'),
(9, 'Dadra and Nagar Haveli', 'DN', '1', 1, '0', '2018-11-02 05:11:57'),
(10, 'Daman and Diu', 'DD', '1', 1, '0', '2018-11-02 05:11:57'),
(11, 'Delhi', 'DL', '1', 1, '0', '2018-11-02 05:11:57'),
(12, 'Goa', 'GA', '1', 1, '0', '2018-11-02 05:11:57'),
(13, 'Gujarat', 'GJ', '1', 1, '0', '2018-11-02 05:11:57'),
(14, 'Haryana', 'HR', '1', 1, '0', '2018-11-02 05:11:57'),
(15, 'Himachal Pradesh', 'HP', '1', 1, '0', '2018-11-02 05:11:57'),
(16, 'Jammu and Kashmir', 'JK', '1', 1, '0', '2018-11-02 05:11:57'),
(17, 'Jharkhand', 'JH', '1', 1, '0', '2018-11-02 05:11:57'),
(18, 'Karnataka', 'KA', '1', 1, '0', '2018-11-02 05:11:57'),
(19, 'Kerala', 'KL', '1', 1, '0', '2018-11-02 05:11:57'),
(20, 'Lakshadweep Islands', 'LD', '1', 1, '0', '2018-11-02 05:11:57'),
(21, 'Madhya Pradesh', 'MP', '1', 1, '0', '2018-11-02 05:11:57'),
(22, 'Maharashtra', 'MH', '1', 1, '0', '2018-11-02 05:11:57'),
(23, 'Manipur', 'MN', '1', 1, '0', '2018-11-02 05:11:57'),
(24, 'Meghalaya', 'ML', '1', 1, '0', '2018-11-02 05:11:57'),
(25, 'Mizoram', 'MZ', '1', 1, '0', '2018-11-02 05:11:57'),
(26, 'Nagaland', 'NL', '1', 1, '0', '2018-11-02 05:11:57'),
(27, 'Odisha', 'OD', '1', 1, '0', '2018-11-02 05:11:57'),
(28, 'Pondicherry', 'PY', '1', 1, '0', '2018-11-02 05:11:57'),
(29, 'Punjab', 'PB', '1', 1, '0', '2018-11-02 05:11:57'),
(30, 'Rajasthan', 'RJ', '1', 1, '0', '2018-11-02 05:11:57'),
(31, 'Sikkim', 'SK', '1', 1, '0', '2018-11-02 05:11:57'),
(32, 'Tamil Nadu', 'TN', '1', 1, '0', '2018-11-02 05:11:57'),
(33, 'Telangana', 'TS', '1', 1, '0', '2018-11-02 05:11:57'),
(34, 'Tripura', 'TR', '1', 1, '0', '2018-11-02 05:11:57'),
(35, 'Uttar Pradesh', 'UP', '1', 1, '0', '2018-11-02 05:11:57'),
(36, 'Uttarakhand', 'UK', '1', 1, '0', '2018-11-02 05:11:57');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `total_price` decimal(20,2) NOT NULL,
  `is_paid` enum('0','1') NOT NULL DEFAULT '0',
  `order_no` varchar(255) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `checksumhash` text NOT NULL,
  `address_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `payment_type` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1 => Paytm, 2 => COD',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bank_txn_id` varchar(255) NOT NULL,
  `paytm_response` longtext NOT NULL,
  `txn_status` varchar(255) NOT NULL,
  `status` enum('0','1','2') NOT NULL COMMENT '0=pending, 1=completed, 2=canceled',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `total_price`, `is_paid`, `order_no`, `txn_id`, `checksumhash`, `address_id`, `customer_id`, `payment_type`, `date_created`, `bank_txn_id`, `paytm_response`, `txn_status`, `status`, `is_deleted`) VALUES
(1, '1.00', '0', 'ORDS16323652', '', 'wpzUE8qn2L1zXqq5jMOb7Qx1xOtbdvZlZkwJMhRUL81d4CwYD3WPuOvcopwRyXo65W0/O70DQdgKF22vtYeq+jWglbfnEp/PoDw0O+t3LM4=', 1, 15, '1', '2018-11-03 10:39:15', '', '', '', '0', '0'),
(2, '20.00', '', 'ORDS49214007', '', '3stulCGFPV5IU7D1o9C55xu4HJfxRLPnsKc1X+Z7DEfd3A0c7XUo3UKwXpUgISV8cBQTKd85A4NvfxhYXa5GF1POFbDgZWv07gbsT/3jvbA=', 1, 15, '1', '2018-11-05 10:01:01', '', '', '', '0', '0'),
(3, '249.00', '0', 'ORDS62281412', '', 'qkwr2l3KWJKrxcBp1UkWbD5500MZF74oPULFnk8LwfvotSF/5UKSUFYex1cZo1dCFIcxxaoYRBT5z9CuxRzC5NGwnThieZkm49v+gUW1wNc=', 8, 28, '2', '2018-11-09 06:53:55', '', '', '', '0', '0'),
(4, '1047.00', '0', 'ORDS12807059', '', 'QQ7r2uiGqeCrek+hEzuTXa47G0BcIJ46J70qHOM+Q/pssn5D3f1IpW4lp8YrrOrQEPbntngZ22062G0TTtGoW4vzzszmJDQrNrX33iefxnI=', 9, 2, '2', '2018-11-09 09:03:52', '', '', '', '0', '0'),
(5, '249.00', '0', 'ORDS71755478', '', 'ytAC1DXTruDO+bZcaRLH8IJvlnI2Limh3JSKM5hvo6Hf33xDJ7CVpZNFCQ+qKin8cCbZVR7KEdLU6lZHejIezmoZbvhibnnx+m2U98imNc0=', 10, 31, '2', '2018-11-09 11:15:37', '', '', '', '0', '0'),
(6, '1296.00', '0', 'ORDS96612094', '', 'XZ7uOYi744+KiEDXWxeH1tIpecyqaznSOK2Ge6gvG90mWDZeLXnHbtJJGWrPM/7IEfPkBFJ6ZA9IUCWsoegCfo2bSIwUCd6mK613JMgB6Ok=', 9, 2, '2', '2018-11-09 12:51:01', '', '', '', '0', '0'),
(7, '1047.00', '0', 'ORDS20806800', '', '5h75eedeLNDxGORL27bH58z0M80BAldyjnla91195HpOn0bU+vBWu88jCHW0lp1+96yCHmYUq645S559XBuWWAHS9e2y0JzPCCMQOkuQ+jE=', 9, 2, '2', '2018-11-10 07:58:42', '', '', '', '0', '0'),
(8, '249.00', '0', 'ORDS64383163', '', 'eUaYSImG3XHbLw38DbzO7Kpp+t9FEhFDTrmryBMBe56nEemZqKHJlizzGBILH6gDpZj0uNxVbSLZYi8rYKH+s4jDAs2E4NaiXHAd5PP/gTw=', 10, 31, '2', '2018-11-13 08:52:11', '', '', '', '0', '0'),
(9, '579.00', '0', 'ORDS28917080', '', 'LRunAwxxZ0kry8FinVcshlGOm7yzt/tMn+wR+Ep0cvoGaMXymmJvJbmY9947OV96fLkKjswp1xuAii9YqFPSNgk+LPbNUYGD4CpWgp/+3MY=', 10, 31, '2', '2018-11-13 11:08:00', '', '', '', '0', '0'),
(10, '6000.00', '0', 'ORDS77661704', '', '2gs/mEgtZNCX96IaL05wzT1ZNAlLKGChvsY2F2tucA38s5PCL6Dan2Mm6oPfRxivsA0eHzPwKIGAiIBE/sNeM+YLK0M7H/j+I08qf3RURUs=', 10, 31, '2', '2018-11-13 11:09:59', '', '', '', '0', '0'),
(11, '249.00', '0', 'ORDS34829530', '', '8u+gkvF33gxgSWo6Nt9nzHK3LGB5UYrjcDXC/VZd86aB86NdjMuOw846QVDBoS8wJ3r7n4e/F4iAf0yKIv88O2QiZ0Q5VUTTy5O6cDK5QxM=', 10, 31, '2', '2018-11-13 11:58:42', '', '', '', '0', '0'),
(12, '6000.00', '0', 'ORDS31568568', '', 'ImN+nQP5Sif8nRjtUqMVOhd1O0HMXROdxbJs7W+qG6GCz/jRkVUWICmo2t2wnWMugZ5f+oOYYsShmr2rsi8cAUqx0/h8GQNH1ucwE422XC0=', 10, 31, '2', '2018-11-13 11:59:10', '', '', '', '0', '0'),
(13, '949.00', '0', 'ORDS63659305', '', '7RPE99EaWpylX7aEDhKTWBl9joytxEF8p3kiGWWlVBUCmNXo/yd7B29CsTeJzx8ZD50ntSGPieNVGDsrFXkBsfbrcGVjjNA3RK6lFkKea8c=', 10, 31, '2', '2018-11-13 12:00:16', '', '', '', '0', '0'),
(14, '5000.00', '0', 'ORDS19968295', '', 'RTuQMCksKhIfkLs27er9Ebqs6U/wjF8U2L3srdwvBTbiBDgkOfOPvgbXgqa3FPaxtJGApL/IS+CZO0mePb8f9XQztt8GuKjiSdTXjmYUMn8=', 10, 31, '2', '2018-11-13 12:03:26', '', '', '', '0', '0'),
(15, '150.00', '0', 'ORDS24694378', '', 'CYvf4rECHr9024OkjbRjD03TGseBr9M53EFzmEfx2pdVUdJ2sxZL/N+pFAQF/WnurtrKdbSBazrMXdprawNybRppi+DuSXBox4ATShruFIg=', 11, 32, '2', '2018-11-14 13:01:10', '', '', '', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(20,2) NOT NULL,
  `IGST` decimal(20,2) DEFAULT NULL,
  `CGST` decimal(20,2) DEFAULT NULL,
  `GST` decimal(20,2) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `total_cost` decimal(20,2) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `package_id`, `quantity`, `unit_price`, `IGST`, `CGST`, `GST`, `order_id`, `total_cost`, `date_created`, `is_active`, `is_deleted`) VALUES
(1, 1, 2, '1.00', '0.00', '0.00', '0.00', 1, '2.00', '2018-11-03 10:39:15', '1', '0'),
(2, 2, 4, '1.00', '0.00', '0.00', '0.00', 1, '4.00', '2018-11-03 10:39:15', '1', '0'),
(3, 1, 2, '1.00', '0.00', '0.00', '0.00', 2, '2.00', '2018-11-05 10:01:01', '1', '0'),
(4, 2, 4, '1.00', '0.00', '0.00', '0.00', 2, '4.00', '2018-11-05 10:01:01', '1', '0'),
(5, 16, 5, '2.00', '1.00', '2.05', '3.06', 1, '10.00', '2018-11-05 12:01:52', '1', '0'),
(6, 1, 1, '249.00', '0.00', '0.00', '0.00', 3, '249.00', '2018-11-09 06:53:55', '1', '0'),
(7, 1, 1, '249.00', '0.00', '0.00', '0.00', 4, '249.00', '2018-11-09 09:03:52', '1', '0'),
(8, 2, 2, '399.00', '0.00', '0.00', '0.00', 4, '798.00', '2018-11-09 09:03:52', '1', '0'),
(9, 1, 1, '249.00', '0.00', '0.00', '0.00', 5, '249.00', '2018-11-09 11:15:37', '1', '0'),
(10, 1, 2, '249.00', '0.00', '0.00', '0.00', 6, '498.00', '2018-11-09 12:51:01', '1', '0'),
(11, 2, 2, '399.00', '0.00', '0.00', '0.00', 6, '798.00', '2018-11-09 12:51:01', '1', '0'),
(12, 1, 1, '249.00', '0.00', '0.00', '0.00', 7, '249.00', '2018-11-10 07:58:42', '1', '0'),
(13, 2, 2, '399.00', '0.00', '0.00', '0.00', 7, '798.00', '2018-11-10 07:58:42', '1', '0'),
(14, 1, 1, '249.00', '0.00', '0.00', '0.00', 8, '249.00', '2018-11-13 08:52:11', '1', '0'),
(15, 15, 1, '599.00', '0.00', '0.00', '0.00', 9, '599.00', '2018-11-13 11:08:00', '1', '0'),
(16, 5, 1, '6000.00', '0.00', '0.00', '0.00', 10, '6000.00', '2018-11-13 11:09:59', '1', '0'),
(17, 5, 1, '6000.00', '0.00', '0.00', '0.00', 12, '6000.00', '2018-11-13 11:59:10', '1', '0'),
(18, 16, 1, '1600.00', '0.00', '0.00', '0.00', 13, '1600.00', '2018-11-13 12:00:16', '1', '0'),
(19, 6, 1, '5000.00', '0.00', '0.00', '0.00', 14, '5000.00', '2018-11-13 12:03:26', '1', '0'),
(20, 17, 1, '200.00', '0.00', '0.00', '0.00', 15, '200.00', '2018-11-14 13:01:10', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `discounted_price` decimal(20,2) NOT NULL,
  `service_id` int(11) NOT NULL,
  `service_slug` varchar(200) NOT NULL,
  `image_small` varchar(256) DEFAULT NULL,
  `image_large` varchar(255) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `slug`, `price`, `discounted_price`, `service_id`, `service_slug`, `image_small`, `image_large`, `date_created`, `is_active`, `is_deleted`) VALUES
(1, 'AC not cooling properly/Repair', '1.Complete diagnosis & repair\r\n2.Final charges based on inspection\r\n\r\n', 'ac_not_cooling_properly_repair', '249.00', '0.00', 1, 'window-ac', NULL, '', '0000-00-00 00:00:00', '1', '0'),
(2, 'Wet Servicing', '1.Deep cleaning the AC for fresh air\r\n2.Filters,Colis etc.cleaned with water\r\n3.save upto 20% on your summer electricity bill with regular servicing', 'wet_servicing', '399.00', '0.00', 1, 'window-ac', NULL, '', '0000-00-00 00:00:00', '1', '0'),
(3, 'Repairs & Fixes', 'pay as hourly charges,follow rate-card shared next', 'repairs__fixes', '199.00', '0.00', 3, 'repairs-fixes', NULL, '', '0000-00-00 00:00:00', '1', '0'),
(4, 'New Furniture Making', 'Rs. 199 includes inspection and work quotation and is adjustable in the final service amount', 'new_furniture_making', '199.00', '0.00', 3, 'repairs-fixes', NULL, '', '0000-00-00 00:00:00', '1', '0'),
(5, 'My wedding/wedding functions', '1.Hassle-free makeup at your home or venue\r\n2.Hand-picked make-up artists,who use quality products', 'my_weeding_functions', '6000.00', '0.00', 5, 'bridal-makeup', NULL, '', '0000-00-00 00:00:00', '1', '0'),
(6, 'Attending a wedding', '1.Light makeup\r\n2.Standard makeup\r\n3.Detailed makeup\r\n4.Expert Detailed makeup', 'attending_a_wedding', '5000.00', '0.00', 5, 'bridal-makeup', NULL, '', '0000-00-00 00:00:00', '1', '0'),
(7, 'Light Makeup + Hairstyle', '1.Includes makeup,hairstyling,draping\r\n2.Hair:straightening,Blow-dry,Curls', 'light_makeup_hairstyle', '1500.00', '1300.00', 6, 'bridesmaids-makeup', NULL, '', '2018-10-25 05:56:31', '1', '0'),
(8, 'Light makeup + Fancy Hair + Draping', '1.Includes makeup,hairstyling,draping\r\n2.Hair:Buns,Braids', 'light_makeup_fancy_hair_draping', '2000.00', '1500.00', 6, 'bridesmaids-makeup', NULL, '', '2018-10-25 05:56:31', '1', '0'),
(9, 'Regular Packages - Wax & Groom', '1.waxing (full legs,arms,underarms)\r\n2.Threading(Eyebrows,Upperlips)', 'wax_groom', '776.00', '599.00', 7, 'offer-packages', NULL, '', '2018-10-25 06:48:32', '1', '0'),
(10, 'Rica Wax and Glow', '1.Rica Waxing(Full legs,Arms,Underarms)\r\n2.Threading(Eyebrows,Upperlips)', 'rica_wax_glow', '1296.00', '999.00', 7, 'offer-packages', NULL, '', '2018-10-25 06:48:32', '0', '0'),
(11, 'Half Arm Waxing', '15 minutes\r\nRica White Chocolate wax', 'half_arm_waxing', '249.00', '228.00', 8, 'rica-wax', NULL, '', '2018-10-25 06:56:57', '1', '0'),
(12, 'Half Legs Waxing', '20 minutes\r\nRica White Chocolate wax', 'half_legs_waxing', '399.00', '349.00', 8, 'rica-wax', NULL, '', '2018-10-25 06:56:57', '1', '0'),
(13, 'Half Arms Waxing', '15 minutes\r\nHoney Bee / Sleek', 'half_arms_waxing', '199.00', '179.00', 9, 'regular-wax', NULL, '', '2018-10-25 06:56:57', '1', '0'),
(14, 'Half Legs Waxing', '                                    \r\n20 minutes\r\nHoney Bee / Sleek                                ', 'half-legs-waxing', '249.00', '239.00', 9, 'regular-wax', 'package_images/image_small/1541055131blog_grid_7_thumb.jpg', 'package_images/image_large/1541055131blog_grid_7.jpg', '2018-10-25 06:56:57', '1', '0'),
(15, 'Sara Fruit Cleanup', '                                    \r\n30 minutes\r\nBy Sara                                ', 'sara-fruit-cleanup', '599.00', '579.00', 10, 'facial', 'package_images/image_small/1541054472blog_gal_5_thumb.jpg', 'package_images/image_large/1541054472blog_gal_5.jpg', '2018-10-25 06:56:57', '0', '0'),
(16, 'Oil-Control Treatment', '                                                                        \r\n45 minutes\r\nAgelock by O3+\r\nOil control to reduce acne formation                                                                ', 'oil-control-treatment', '1600.00', '949.00', 10, 'facial', 'package_images/image_small/1541054461blog_grid_3_thumb.jpg', 'package_images/image_large/1541054461blog_grid_3.jpg', '2018-10-25 06:56:57', '0', '0'),
(17, 'Computer fixes 111', '                                                                                                                                                                                                                                                               ', 'computer-fixes-111', '200.00', '150.00', 2, 'split-ac', 'package_images/image_small/1541054420blog_gal_3_thumb.jpg', 'package_images/image_large/1541054420blog_gal_3.jpg', '2018-11-01 06:12:34', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `package_entity`
--

CREATE TABLE `package_entity` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('short','long') NOT NULL,
  `package_id` int(11) NOT NULL,
  `package_slug` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package_entity`
--

INSERT INTO `package_entity` (`id`, `name`, `type`, `package_id`, `package_slug`, `date_created`, `is_active`, `is_deleted`) VALUES
(1, 'Package Includes', '', 9, '', '2018-10-25 07:12:50', '1', '0'),
(2, 'Brand', 'short', 1, '', '2018-10-25 07:12:50', '1', '0'),
(3, 'Benefits', 'long', 1, '', '2018-10-25 07:12:50', '1', '0'),
(4, 'Package Includes', '', 10, '', '2018-10-25 07:12:50', '1', '0'),
(5, 'Brands', 'long', 1, '', '2018-10-25 07:12:50', '1', '0'),
(6, 'Benefits', 'long', 2, '', '2018-10-25 07:12:50', '1', '0'),
(7, 'Please Note', 'short', 10, '', '2018-10-25 07:12:50', '1', '0'),
(8, 'Brand', 'short', 15, '', '2018-10-25 07:12:50', '0', '0'),
(9, 'Recommended For', 'short', 15, '', '2018-10-25 07:12:50', '0', '0'),
(10, 'Benefits', 'long', 15, '', '2018-10-25 07:12:50', '0', '1'),
(11, 'dfgfdg', 'long', 17, '', '2018-11-01 13:14:47', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `package_entity_value`
--

CREATE TABLE `package_entity_value` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `package_entity_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package_entity_value`
--

INSERT INTO `package_entity_value` (`id`, `value`, `package_entity_id`, `date_created`, `is_active`, `is_deleted`) VALUES
(1, 'Waxing (Full legs, Full arms,Underarms)', 1, '2018-10-25 07:12:44', '1', '0'),
(2, 'Regular Honey Wax (Honeybee/Sleek)', 2, '2018-10-25 07:12:44', '1', '0'),
(3, 'Every 25 days to get rid of your hair woes', 3, '2018-10-25 07:12:44', '1', '0'),
(4, 'Rica White Chocolate (Full legs, Full arms)', 3, '2018-10-25 07:12:44', '1', '0'),
(5, 'RICA White Chocolate Wax', 5, '2018-10-25 07:12:44', '1', '0'),
(6, 'To get rid of tanning and ingrown hair', 6, '2018-10-25 07:12:44', '1', '0'),
(7, '\r\nAC is highly recommended for waxing during summer and monsoo', 7, '2018-10-25 07:12:44', '1', '0'),
(8, 'Sara by O3+', 9, '2018-10-25 07:12:44', '0', '0'),
(9, 'All skin types', 9, '2018-10-25 07:12:44', '0', '0'),
(10, 'Skin whitening effect', 10, '2018-10-25 07:12:44', '0', '0'),
(11, 'Waxing (Full legs, Full arms, Underarms)', 11, '2018-10-25 07:12:44', '1', '0'),
(12, 'entity value111', 7, '2018-11-01 17:00:08', '1', '0'),
(13, 'Threading (Eyebrows, Upper lip)', 11, '2018-11-09 10:55:03', '1', '0'),
(14, 'Threading (Eyebrows, Upper lip)', 1, '2018-11-09 10:55:03', '1', '0'),
(15, 'Organica Thread', 2, '2018-11-09 10:55:50', '1', '0'),
(16, 'Rica Peel-Off (Underarms)', 3, '2018-11-09 10:58:37', '1', '0'),
(17, 'Threading (Upper Lip, Eyebrow)', 3, '2018-11-09 10:58:37', '1', '0'),
(18, 'Organica Thread', 5, '2018-11-09 10:59:19', '1', '0'),
(19, 'Every 25 days to get rid of your hair woes', 6, '2018-11-09 10:59:50', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `package_rating`
--

CREATE TABLE `package_rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package_rating`
--

INSERT INTO `package_rating` (`id`, `user_id`, `order_id`, `package_id`, `rating`, `service_id`, `date_created`, `is_active`, `is_deleted`) VALUES
(1, 2, 1, 1, 2, 1, '2018-11-09 17:20:58', '1', '0'),
(2, 2, 1, 1, 2, 1, '2018-11-09 11:56:46', '1', '0'),
(3, 2, 4, 8, 5, 6, '2018-11-09 12:02:56', '1', '0'),
(4, 2, 4, 8, 5, 6, '2018-11-09 12:02:56', '1', '0'),
(5, 2, 4, 8, 2, 6, '2018-11-09 12:05:50', '1', '0'),
(6, 2, 4, 7, 5, 6, '2018-11-09 12:06:33', '1', '0'),
(7, 2, 6, 11, 5, 8, '2018-11-09 12:51:10', '1', '0'),
(8, 2, 6, 10, 3, 7, '2018-11-09 12:51:11', '1', '0'),
(9, 2, 6, 2, 5, 1, '2018-11-09 12:57:19', '1', '0'),
(10, 31, 5, 1, 4, 1, '2018-11-13 07:36:19', '1', '0'),
(11, 31, 5, 1, 5, 1, '2018-11-13 07:36:28', '1', '0'),
(12, 31, 5, 1, 4, 1, '2018-11-13 08:52:28', '1', '0'),
(13, 31, 8, 1, 4, 1, '2018-11-13 08:54:20', '1', '0'),
(14, 31, 8, 1, 4, 1, '2018-11-13 08:54:20', '1', '0'),
(15, 31, 8, 1, 4, 1, '2018-11-13 10:37:05', '1', '0'),
(16, 31, 8, 1, 1, 1, '2018-11-13 11:06:45', '1', '0'),
(17, 31, 8, 1, 1, 1, '2018-11-13 11:06:58', '1', '0'),
(18, 31, 8, 1, 5, 1, '2018-11-13 11:08:23', '1', '0'),
(19, 31, 9, 15, 3, 10, '2018-11-13 11:09:24', '1', '0'),
(20, 31, 10, 5, 5, 5, '2018-11-13 11:10:11', '1', '0'),
(21, 31, 14, 6, 1, 5, '2018-11-13 12:03:43', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image_small` varchar(256) DEFAULT NULL,
  `image_large` varchar(255) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `category_slug` varchar(150) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `description`, `slug`, `image_small`, `image_large`, `category_id`, `category_slug`, `date_created`, `is_active`, `is_deleted`) VALUES
(1, 'Window AC', '', 'window-ac', 'service_images/image_small/1542258732window-ac-1_thumb.jpg', 'service_images/image_large/1542258732window-ac-1.jpg', 7, 'ac-service-and-repair', '2018-10-23 11:12:19', '1', '0'),
(2, 'Split AC', '', 'split-ac', NULL, '', 7, 'ac-service-and-repair', '2018-10-23 11:12:19', '1', '0'),
(3, 'Repairs & Fixes', '', 'repairs-fixes', NULL, '', 69, 'carpenters', '2018-10-23 11:14:37', '1', '0'),
(4, 'New Furniture Making', '', 'new-furniture-making', NULL, '', 69, 'carpenters', '2018-10-23 11:14:37', '1', '0'),
(5, 'Bridal Makeup', '', 'bridal-makeup', NULL, '', 88, 'bridal-makeup-artist', '2018-10-23 11:17:02', '1', '0'),
(6, 'Bridesmaids Makeup', '', 'bridesmaids-makeup', NULL, '', 88, 'bridal-makeup-artist', '2018-10-23 11:17:02', '1', '0'),
(7, 'Offer Packages', '', 'offer_packages', NULL, '', 12, 'salon-at-home-for-women', '2018-10-25 06:29:31', '1', '0'),
(8, 'Rica Wax', '', 'rica_wax', NULL, '', 12, 'salon-at-home-for-women', '2018-10-25 06:29:31', '1', '0'),
(9, 'Regular Wax', '', 'regular_wax', 'service_images/image_small/1542258642Make-Sugar-Wax-Step-10_thumb.jpg', 'service_images/image_large/1542258642Make-Sugar-Wax-Step-10.jpg', 12, 'salon-at-home-for-women', '2018-10-25 06:29:31', '1', '0'),
(10, 'Facial', '                                                                                                                                        ', 'facial', 'service_images/image_small/1541485726air_thumb.jpg', 'service_images/image_large/1541485726air.jpg', 12, 'salon-at-home-for-women', '2018-10-25 06:29:31', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `service_category`
--

CREATE TABLE `service_category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image_small` varchar(255) NOT NULL,
  `image_large` varchar(200) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `parent_slug` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_category`
--

INSERT INTO `service_category` (`id`, `name`, `description`, `image_small`, `image_large`, `slug`, `parent_id`, `parent_slug`, `date_created`, `is_active`, `is_deleted`) VALUES
(1, 'Tours and Travels', 'sfdsfsdff', 'service_cat_images/image_small/tours-travels.png', '', 'tours-travels', 0, '', '2018-10-23 10:22:23', '1', '0'),
(2, 'Beauty and Spa', '', 'service_cat_images/image_small/beauty-spa.png', '', 'beauty-spa', 0, '', '2018-10-23 10:22:23', '1', '0'),
(3, 'Repairs', '', 'service_cat_images/image_small/repairs.png', '', 'repairs', 0, '', '2018-10-23 10:22:23', '1', '0'),
(4, 'Delivery', '', 'service_cat_images/image_small/delivery.png', '', 'delivery', 0, '', '2018-10-23 10:22:23', '1', '0'),
(5, 'Paint', '', 'service_cat_images/image_small/paint.png', '', 'paint', 0, '', '2018-10-23 10:22:23', '1', '0'),
(6, 'Weddings and Events', '', 'service_cat_images/image_small/weddings-events.png', '', 'weddings-events', 0, '', '2018-10-23 10:22:23', '1', '0'),
(7, 'AC Service and Repair', '', '', '', 'ac-service-and-repair', 1, 'tours-travels', '2018-10-23 10:22:23', '1', '0'),
(8, 'Refrigerator Repair', '', '', '', 'refrigerator-repair', 1, 'tours-travels', '2018-10-23 10:22:23', '1', '0'),
(9, 'Washing Machine Repair', '', '', '', 'washing-machine-repair', 1, 'tours-travels', '2018-10-23 10:22:23', '1', '0'),
(10, 'RO or Water Purifier Repair', '', '', '', 'ro-or-water-purifier-repair', 1, 'tours-travels', '2018-10-23 10:22:23', '1', '0'),
(11, 'Microwave Repair', '', '', '', 'microwave-repair', 1, 'tours-travels', '2018-10-23 10:44:00', '1', '0'),
(12, 'Salon at home for Women', '', '', '', 'salon-at-home-for-women', 2, 'beauty-spa', '2018-10-23 10:44:00', '1', '0'),
(13, 'Makeup & Hairstyling', '', '', '', 'makeup-hairstyling', 2, 'beauty-spa', '2018-10-23 10:44:00', '1', '0'),
(14, 'Bridal Makeup Artist', '', '', '', 'bridal_makeup-artist', 2, 'beauty-spa', '2018-10-23 10:44:00', '1', '0'),
(67, 'Mehendi Artists', '', '', '', 'mehendi_artists', 2, 'beauty-spa', '2018-10-23 10:44:00', '1', '0'),
(68, 'Massage for Men', 'sssss', 'service_cat_images/image_small/1540962552blog_grid_4_thumb.jpg', 'service_cat_images/image_large/1540962552blog_grid_4.jpg', 'massage-for-men', 90, 'health-tips', '2018-10-23 10:44:00', '1', '0'),
(69, 'Carpenters', '', '', '', 'carpenters', 3, 'repairs', '2018-10-23 10:44:00', '1', '0'),
(70, 'Plumbers', '', '', '', 'plumbers', 3, 'repairs', '2018-10-23 10:44:00', '1', '0'),
(71, 'Bathroom Deep Cleaning', '', '', '', 'bathroom-deep-cleaning', 3, 'repairs', '2018-10-23 10:44:00', '1', '0'),
(72, 'Carpet Cleaning', '', '', '', 'carpet-cleaning', 3, 'repairs', '2018-10-23 10:44:00', '1', '0'),
(73, 'Home Deep Cleaning', '', '', '', 'home-deep-cleaning', 3, 'repairs', '2018-10-23 10:44:00', '1', '0'),
(74, 'Kitchen Deep Cleaning', '', '', '', 'kitchen-deep-cleaning', 3, 'repairs', '2018-10-23 10:44:00', '1', '0'),
(75, 'Sofa Cleaning', '', '', '', 'sofa-cleaning', 3, 'repairs', '2018-10-23 10:44:00', '1', '0'),
(76, 'Pest Control', '', '', '', 'pest-control', 3, 'repairs', '2018-10-23 10:44:00', '1', '0'),
(77, 'AC Service and Repair', '', '', '', 'ac_service_and_repair', 3, 'repairs', '2018-10-23 10:44:00', '1', '0'),
(78, 'i Phone,iPad,Mac Repair', '', '', '', 'i-phone-i-pad-mac-repair', 3, 'repairs', '2018-10-23 10:44:00', '1', '0'),
(79, 'CA for Income Tax Filing', '', '', '', 'ca-for-income-tax-filing', 4, 'delivery', '2018-10-23 10:44:00', '1', '0'),
(80, 'CCTV Cameras and Installation', 'dsdsdsdsd', 'service_cat_images/image_small/1540962329blog_grid_11_thumb.jpg', 'service_cat_images/image_large/1540962329blog_grid_11.jpg', 'cctv-cameras-and-installation', 4, 'delivery', '2018-10-23 10:44:00', '1', '0'),
(81, 'Web Desigener & Developer', 'sdsddsdd', 'service_cat_images/image_small/1540962259tour_grid_9_thumb.jpg', 'service_cat_images/image_large/1540962259tour_grid_9.jpg', 'web-desigener-and-developer', 4, 'delivery', '2018-10-23 10:44:00', '1', '0'),
(82, 'Baby Portfolio Photographer', '', '', '', 'baby-portfolio-photographer', 5, 'paint', '2018-10-23 10:44:00', '1', '0'),
(83, 'Home Tutor', '', '', '', 'home-tutor', 5, 'paint', '2018-10-23 10:44:00', '1', '0'),
(84, 'Divorce Lawyear', '', '', '', 'divorce-lawyear', 5, 'paint', '2018-10-23 10:44:00', '1', '0'),
(85, 'Astrologer', '', '', '', 'astrologer', 6, 'weddings-events', '2018-10-23 10:44:00', '1', '0'),
(86, 'Party Decorations', '', '', '', 'party-decorations', 6, 'weddings-events', '2018-10-23 10:44:00', '1', '0'),
(87, 'Mehendi Artists', '', '', '', 'mehendi-artists', 6, 'weddings-events', '2018-10-23 10:44:00', '1', '0'),
(88, 'Bridal Makeup Artist', 'sss', 'service_cat_images/image_small/1541483139air_thumb.jpg', 'service_cat_images/image_large/1541483139air.jpg', 'bridal-makeup-artist', 6, 'weddings-events', '2018-10-23 10:44:00', '1', '0'),
(89, 'Foods', 'foods', 'service_cat_images/image_small/foods.png', '', 'foods', 0, '', '2018-10-29 14:24:45', '1', '0'),
(90, 'Health Tips', 'Health Tips', 'service_cat_images/image_small/health-tips.png', '', 'health-tips', 0, '', '2018-10-29 14:24:45', '1', '0'),
(91, 'Cleaning', 'Cleaning', 'service_cat_images/image_small/cleaning.png', '', 'cleaning', 0, '', '2018-10-29 14:25:35', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `service_category_locality_map`
--

CREATE TABLE `service_category_locality_map` (
  `id` int(11) NOT NULL,
  `service_category_id` int(11) NOT NULL,
  `service_cat_slug` varchar(150) NOT NULL,
  `location_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_category_locality_map`
--

INSERT INTO `service_category_locality_map` (`id`, `service_category_id`, `service_cat_slug`, `location_id`) VALUES
(2, 2, 'beauty-spa', 2),
(3, 7, 'ac-service-and-repair', 2),
(4, 8, 'refrigerator-repair', 2),
(5, 9, 'washing-machine-repair', 2),
(6, 11, 'microwave-repair', 2),
(7, 12, 'salon-at-home-for-women', 1),
(8, 7, 'ac-service-and-repair', 1),
(9, 7, 'ac-service-and-repair', 2),
(10, 8, 'refrigerator-repair', 1),
(11, 1, 'tours-travels', 2),
(12, 1, 'tours-travels', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `settings_k` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `settings_v` text CHARACTER SET utf8 COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `settings_k`, `settings_v`) VALUES
(1, 'mail', '{\"mail_from_name\":\"contact\",\"mail_from_email\":\"rupamhazra@gmail.com\",\"username\":\"noreply@shyamfuture.com\",\"host\":\"smtp.gmail.com\",\"port\":\"465\",\"ssl_tls\":\"1\",\"password\":\"noreply123\"}');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `profile_image` text NOT NULL,
  `user_type` enum('1','2','3') NOT NULL DEFAULT '3' COMMENT '1 => Admin , 2=>User, 3=>Customer',
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `contact`, `password`, `name`, `profile_image`, `user_type`, `is_active`, `is_deleted`, `created_at`, `modified_at`) VALUES
(1, 'rupam@mail.com', '9038698175', 'e10adc3949ba59abbe56e057f20f883e', 'Rupam Hazra', 'profile_images/1539585185blog_gal_3.jpg', '1', '1', '0', '2018-09-25 06:31:49', '2018-11-06 09:40:36'),
(2, 'tonmoy@mail.com', '9830931758', 'e10adc3949ba59abbe56e057f20f883e', 'Tonmoy Sardar', 'profile_images/1539585185blog_gal_3.jpg', '3', '1', '0', '2018-09-25 06:31:49', '2018-11-08 12:55:19'),
(3, 'manna@mail.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'Biswajit Manna', 'profile_images/1539585185blog_gal_3.jpg', '3', '1', '0', '2018-09-25 06:31:49', '2018-11-05 10:19:36'),
(9, 'sdsd1@mail.com', '64545645646', 'e10adc3949ba59abbe56e057f20f883e', 'sdsdd', '', '3', '1', '0', '2018-10-22 09:52:54', '2018-11-05 10:19:34'),
(10, 'sdsd111@mail.com', '6454564564611', 'e10adc3949ba59abbe56e057f20f883e', 'sdsdd', '', '3', '1', '0', '2018-10-29 06:22:29', '2018-11-05 10:19:31'),
(11, 'milon@mail.com', '903689741', 'e10adc3949ba59abbe56e057f20f883e', 'milon', 'profile_images/1540794276blog_gal_3.jpg', '3', '1', '0', '2018-10-29 06:24:36', '2018-11-05 10:19:28'),
(12, 'test1@test.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'test1', '', '3', '1', '0', '2018-10-29 09:05:46', '2018-11-05 10:19:25'),
(13, 'test2@test.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'test2', '', '3', '1', '0', '2018-10-29 09:06:41', '2018-11-05 10:19:23'),
(14, 'test3@test.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'test3', '', '3', '1', '0', '2018-10-29 09:11:24', '2018-11-05 10:19:20'),
(15, 'customer@test.com', NULL, 'e10adc3949ba59abbe56e057f20f883e', 'customer', 'profile_images/1540805882blog_grid_11.jpg', '3', '1', '0', '2018-10-29 09:23:24', '2018-11-06 06:46:15'),
(21, 'hazra@mail.com', '9036897412', 'd41d8cd98f00b204e9800998ecf8427e', 'Hazra Rupam', 'profile_images/1540805882blog_grid_11.jpg', '3', '0', '0', '2018-10-29 09:38:02', '2018-11-06 08:35:38'),
(22, 'debdoot@mail.com', '8961002066', 'd41d8cd98f00b204e9800998ecf8427e', 'dfd', 'profile_images/1541493497blog_gal_3.jpg', '3', '1', '0', '2018-11-06 08:37:21', '2018-11-06 08:38:17'),
(27, 'rupamhazra@gmail.com', '9038698174', '8017d0408f41b75489701e3fb1c3e773', 'Hazra Rupam', '', '3', '1', '0', '2018-11-08 09:55:03', '2018-11-08 11:51:00'),
(29, 'tonmoy.1984@gmail.com', '9830931759', 'fcea920f7412b5da7be0cf42b8c93759', 'Tonmoy Sardar ', '', '3', '1', '0', '2018-11-08 13:20:12', '2018-11-08 14:17:05'),
(32, 'kalyanachar@gmail.com', '9163916750', 'e10adc3949ba59abbe56e057f20f883e', 'kalyan', 'profile_images/1542178673img1.png', '3', '1', '0', '2018-11-13 11:48:16', '2018-11-14 06:57:53'),
(31, 'kalyancse08@gmail.com', '8906325853', 'e10adc3949ba59abbe56e057f20f883e', 'Kalyan Acharya', 'profile_images/1542198781img1.jpg', '3', '1', '0', '2018-11-09 09:06:33', '2019-08-30 13:07:55'),
(33, 'shuvendu@shyamsteel.com', '9804523216', 'e10adc3949ba59abbe56e057f20f883e', 'shuvendu', '', '3', '1', '0', '2018-11-13 12:57:03', '2018-11-13 12:57:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_settings`
--
ALTER TABLE `gallery_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_templates`
--
ALTER TABLE `mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_country`
--
ALTER TABLE `master_country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_location`
--
ALTER TABLE `master_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_state`
--
ALTER TABLE `master_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_entity`
--
ALTER TABLE `package_entity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_entity_value`
--
ALTER TABLE `package_entity_value`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_rating`
--
ALTER TABLE `package_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_category`
--
ALTER TABLE `service_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `service_category_locality_map`
--
ALTER TABLE `service_category_locality_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`contact`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `gallery_settings`
--
ALTER TABLE `gallery_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `mail_templates`
--
ALTER TABLE `mail_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_country`
--
ALTER TABLE `master_country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_location`
--
ALTER TABLE `master_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_state`
--
ALTER TABLE `master_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `package_entity`
--
ALTER TABLE `package_entity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `package_entity_value`
--
ALTER TABLE `package_entity_value`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `package_rating`
--
ALTER TABLE `package_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `service_category`
--
ALTER TABLE `service_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `service_category_locality_map`
--
ALTER TABLE `service_category_locality_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
