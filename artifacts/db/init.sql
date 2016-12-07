/*
SQLyog Community v12.3.2 (64 bit)
MySQL - 10.1.19-MariaDB : Database - nishoknarasimhamohanasamy
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE `narasimh_decarato`;

USE `narasimh_decarato`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `email` varchar(150) NOT NULL,
  `password` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `admin` */

insert  into `admin`(`email`,`password`) values 

('admin','admin');

/*Table structure for table `cart` */

DROP TABLE IF EXISTS `cart`;

CREATE TABLE `cart` (
  `useremail` varchar(255) NOT NULL,
  `productid` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  KEY `cartuseremail` (`useremail`),
  KEY `cartproductid` (`productid`),
  CONSTRAINT `cartproductid` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `cartuseremail` FOREIGN KEY (`useremail`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cart` */

/*Table structure for table `owner` */

DROP TABLE IF EXISTS `owner`;

CREATE TABLE `owner` (
  `email` varchar(150) NOT NULL,
  `fname` varchar(150) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `number` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `sex` varchar(150) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `owner` */

insert  into `owner`(`email`,`fname`,`lname`,`password`,`number`,`address`,`sex`) values 

('owner@gmail.com','owner','owner','owner','9000981633','Montclair','Female');

/*Table structure for table `paymentinfo` */

DROP TABLE IF EXISTS `paymentinfo`;

CREATE TABLE `paymentinfo` (
  `useremail` varchar(255) NOT NULL,
  `cardnumber` int(255) NOT NULL,
  `cardtype` varchar(255) DEFAULT NULL,
  `cvv` int(255) DEFAULT NULL,
  `expiry` date DEFAULT NULL,
  PRIMARY KEY (`cardnumber`),
  KEY `paymentemail` (`useremail`),
  CONSTRAINT `paymentemail` FOREIGN KEY (`useremail`) REFERENCES `users` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `paymentinfo` */

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `title` varchar(150) NOT NULL,
  `imagefile` varchar(10000) NOT NULL,
  `type` varchar(150) NOT NULL,
  `owneremail` varchar(150) NOT NULL,
  `productid` int(255) NOT NULL AUTO_INCREMENT,
  `price` int(255) NOT NULL,
  PRIMARY KEY (`productid`),
  UNIQUE KEY `title` (`title`),
  KEY `email` (`owneremail`),
  CONSTRAINT `email` FOREIGN KEY (`owneremail`) REFERENCES `owner` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `product` */

insert  into `product`(`title`,`imagefile`,`type`,`owneremail`,`productid`,`price`) values 

('Table1','../images/products/table1.jpg','table','owner@gmail.com',8,20),

('Table2','../images/products/table2.jpg','table','owner@gmail.com',10,15),

('Chair1','../images/products/chair1.jpg','chair','owner@gmail.com',16,35),

('Chair2','../images/products/chair2.jpg','chair','owner@gmail.com',17,20),

('Table3','../images/products/table3.jpg','table','owner@gmail.com',18,20),

('Chair3','../images/products/chair3.jpg','chair','owner@gmail.com',19,60),

('Bed1','../images/products/bed1.jpg','bed','owner@gmail.com',20,80),

('Bed2','../images/products/bed2.jpg','bed','owner@gmail.com',21,100),

('Bed3','../images/products/bed3.jpg','bed','owner@gmail.com',22,400),

('Lamp1','../images/products/lamp1.jpg','lamp','owner@gmail.com',23,200),

('Lamp2','../images/products/lamp2.jpg','lamp','owner@gmail.com',24,100),

('Lamp3','../images/products/lamp3.jpg','lamp','owner@gmail.com',25,250);

/*Table structure for table `productowner` */

DROP TABLE IF EXISTS `productowner`;

CREATE TABLE `productowner` (
  `owneremail` varchar(150) DEFAULT NULL,
  `productid` int(255) DEFAULT NULL,
  KEY `paperid` (`productid`),
  KEY `reviewemail` (`owneremail`),
  CONSTRAINT `owneremail` FOREIGN KEY (`owneremail`) REFERENCES `owner` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `productid` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `productowner` */

insert  into `productowner`(`owneremail`,`productid`) values 

('owner@gmail.com',8);

/*Table structure for table `transactions` */

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `transactionid` int(255) NOT NULL AUTO_INCREMENT,
  `useremail` varchar(255) NOT NULL,
  `totalprice` int(255) NOT NULL,
  `card` int(255) NOT NULL,
  PRIMARY KEY (`transactionid`),
  KEY `transactionemail` (`useremail`),
  KEY `cardnumber` (`card`),
  CONSTRAINT `cardnumber` FOREIGN KEY (`card`) REFERENCES `paymentinfo` (`cardnumber`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transactionemail` FOREIGN KEY (`useremail`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `transactions` */

/*Table structure for table `userproduct` */

DROP TABLE IF EXISTS `userproduct`;

CREATE TABLE `userproduct` (
  `useremail` varchar(255) NOT NULL,
  `productid` int(255) NOT NULL,
  `transactionid` int(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  KEY `useremail` (`useremail`),
  KEY `userproductid` (`productid`),
  KEY `transactionid` (`transactionid`),
  CONSTRAINT `transactionid` FOREIGN KEY (`transactionid`) REFERENCES `transactions` (`transactionid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `useremail` FOREIGN KEY (`useremail`) REFERENCES `users` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `userproductid` FOREIGN KEY (`productid`) REFERENCES `product` (`productid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `userproduct` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `fname` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `lname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `number` varchar(150) NOT NULL,
  `address` varchar(150) NOT NULL,
  `company` varchar(150) NOT NULL,
  `sex` varchar(150) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `users` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
