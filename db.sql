

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cars`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE IF NOT EXISTS `ads` (
  `ads_id` int(11) NOT NULL auto_increment,
  `model` int(4) NOT NULL,
  `passvand` varchar(20) collate utf8_persian_ci NOT NULL,
  `karkerd` int(10) NOT NULL,
  `vaziyat` enum('صفر','دسته دوم') collate utf8_persian_ci NOT NULL,
  `gheymat` int(11) NOT NULL,
  `rang` varchar(80) collate utf8_persian_ci NOT NULL,
  `rangtodozi` varchar(80) collate utf8_persian_ci NOT NULL,
  `sokht` enum('بنزین','گازسوز','دوگانه سوز') collate utf8_persian_ci NOT NULL,
  `dande` enum('دستی','اتومات') collate utf8_persian_ci NOT NULL,
  `ezafi` text collate utf8_persian_ci NOT NULL,
  `sub_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `clicks` int(11) NOT NULL,
  PRIMARY KEY  (`ads_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`ads_id`, `model`, `passvand`, `karkerd`, `vaziyat`, `gheymat`, `rang`, `rangtodozi`, `sokht`, `dande`, `ezafi`, `sub_id`, `user_id`, `date`, `clicks`) VALUES
(1, 1380, 'ELX', 1000000, 'دسته دوم', 1000000, 'قرمز', 'آبی', 'دوگانه سوز', 'اتومات', 'تست موارد اضافی', 14, 1, '2010-01-26', 1),
(2, 1381, 'Super', 0, 'صفر', 2000000, 'مشکی', 'سفید', 'گازسوز', 'اتومات', 'تست موارد اضافی', 19, 1, '2010-01-26', 27),
(3, 1383, 'SXE', 0, 'صفر', 5000000, 'قرمز', 'آبی', 'بنزین', 'دستی', 'تست', 15, 2, '2010-01-26', 3),
(4, 1384, 'UEE', 0, 'صفر', 6000000, 'آبی', 'قرمز', 'گازسوز', 'اتومات', 'تست مطالب', 15, 2, '2010-01-26', 58),
(5, 1385, 'RAR', 1234555, 'دسته دوم', 7000000, 'آبی', 'آبی', 'گازسوز', 'اتومات', 'تست مظالب', 16, 2, '2010-01-26', 14),
(6, 1380, '123335', 2500, 'دسته دوم', 2600000, 'گرمز', 'سفید', 'بنزین', 'دستی', 'تست', 14, 4, '2011-03-26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(11) NOT NULL auto_increment,
  `catname` varchar(50) collate utf8_persian_ci NOT NULL,
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `catname`) VALUES
(1, 'بی ام دابلو'),
(2, 'هی یون دای'),
(3, 'تویو تا'),
(4, 'آ او دی'),
(5, 'تار بانت');

-- --------------------------------------------------------

--
-- Table structure for table `haraji`
--

CREATE TABLE IF NOT EXISTS `haraji` (
  `haraji_id` int(10) unsigned NOT NULL auto_increment,
  `ads_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `comment` text collate utf8_persian_ci NOT NULL,
  PRIMARY KEY  (`haraji_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `haraji`
--

INSERT INTO `haraji` (`haraji_id`, `ads_id`, `user_id`, `price`, `comment`) VALUES
(1, 2, 3, 3000000, 'نظر من اینه'),
(2, 2, 2, 4000000, 'تست نظر من'),
(3, 2, 1, 5000000, 'تست نظر مدیر');

-- --------------------------------------------------------

--
-- Table structure for table `subcat`
--

CREATE TABLE IF NOT EXISTS `subcat` (
  `sub_id` int(11) NOT NULL auto_increment,
  `cat_id` int(11) NOT NULL,
  `subname` varchar(50) collate utf8_persian_ci NOT NULL,
  PRIMARY KEY  (`sub_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `subcat`
--

INSERT INTO `subcat` (`sub_id`, `cat_id`, `subname`) VALUES
(13, 4, 'محصول شماره 1'),
(12, 5, 'محصول شماره 2'),
(11, 5, 'محصول شماره 1'),
(14, 1, 'محصول شماره 2'),
(15, 3, 'محصول شماره 1'),
(16, 3, 'محصول شماره 2'),
(17, 2, 'محصول شماره 1'),
(18, 2, 'محصول شماره 2'),
(19, 1, 'محصول شماره 1'),
(20, 4, 'محصول شماره 2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL auto_increment,
  `firstname` varchar(50) collate utf8_persian_ci NOT NULL,
  `lastname` varchar(50) collate utf8_persian_ci NOT NULL,
  `province` varchar(50) collate utf8_persian_ci NOT NULL,
  `city` varchar(50) collate utf8_persian_ci NOT NULL,
  `website` varchar(60) collate utf8_persian_ci NOT NULL,
  `email` varchar(80) collate utf8_persian_ci NOT NULL,
  `phone` varchar(12) collate utf8_persian_ci NOT NULL,
  `address` text collate utf8_persian_ci NOT NULL,
  `password` varchar(40) collate utf8_persian_ci NOT NULL,
  `access` int(11) NOT NULL default '1',
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `province`, `city`, `website`, `email`, `phone`, `address`, `password`, `access`) VALUES
(1, 'احمدرضا', 'س.خ', 'فارس', 'کمیاب اسکریپت', 'https://kamyabscript.ir', 'info@kamyabscript.com', '09216590980', 'کمیاب اسکریپت باران', 'admin', 2);

-- --------------------------------------------------------

--
-- Table structure for table `vp`
--

CREATE TABLE IF NOT EXISTS `vp` (
  `vp_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(80) collate utf8_persian_ci NOT NULL,
  `family` varchar(80) collate utf8_persian_ci NOT NULL,
  `phone` int(12) NOT NULL,
  `email` varchar(80) collate utf8_persian_ci NOT NULL,
  `subject` text collate utf8_persian_ci NOT NULL,
  `comment` text collate utf8_persian_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY  (`vp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `vp`
--

INSERT INTO `vp` (`vp_id`, `name`, `family`, `phone`, `email`, `subject`, `comment`, `user_id`, `date`) VALUES
(1, 'حسین', 'جوووون', 1234567891, 'hossein@gmail.com', 'سلام تست پیغام کلی', 'پیغام های کاربران ثبت نام نشده', 0, '2010-01-26 15:48:48'),
(2, '', '', 0, '', 'تست پیغام کاربران', 'تست پیغام های کاربران ثبت نام شده', 2, '2010-01-26 15:49:13');
