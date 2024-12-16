-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 01:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id_categorie` int(11) NOT NULL,
  `categorie_name` varchar(50) NOT NULL,
  `categorie_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_categorie`, `categorie_name`, `categorie_image`) VALUES
(1, 'Fruits', NULL),
(2, 'Vegetables', NULL),
(3, 'Seeds', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `idcommande` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `totalprice` int(11) DEFAULT NULL,
  `status` enum('on hold','approved','denied') DEFAULT 'on hold',
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`idcommande`, `iduser`, `totalprice`, `status`, `order_date`) VALUES
(23, 1, 75300, 'on hold', '2024-12-14 16:34:09'),
(24, 1, 57600, 'on hold', '2024-12-14 16:59:20'),
(25, 1, 21200, 'on hold', '2024-12-14 17:06:07'),
(26, 1, 9200, 'on hold', '2024-12-14 17:12:43'),
(27, 1, 9200, 'on hold', '2024-12-14 17:13:24'),
(28, 1, 18900, 'on hold', '2024-12-14 17:13:51'),
(29, 1, 32000, 'on hold', '2024-12-14 17:15:09'),
(30, 1, 32000, 'on hold', '2024-12-14 17:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `id_fermier` int(11) NOT NULL,
  `nom_event` varchar(20) NOT NULL,
  `location_event` varchar(20) NOT NULL,
  `describtion` varchar(20) NOT NULL,
  `Date` date NOT NULL,
  `heure` varchar(10) NOT NULL,
  `duration` varchar(10) NOT NULL,
  `Max_Tickets` int(11) NOT NULL,
  `Ticket_price` float NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id_event`, `id_fermier`, `nom_event`, `location_event`, `describtion`, `Date`, `heure`, `duration`, `Max_Tickets`, `Ticket_price`, `Status`, `image_url`) VALUES
(57, 15, 'AgriTech Summit', 'azer', 'Tunis, Tunisia', '2024-11-28', '12', '2', 100, 10, 1, 'uploads/675f526468b1b_20210323_1616515136-275519.jpg'),
(58, 333, 'Green Grow Expo', 'Sousse, Tunisia', 'An expo highlighting', '2024-12-02', '11', '450', 1221, 12, 1, 'uploads/675f5334a6576_4th-forum-on-best-practices.jpg.webp'),
(59, 44, 'AgriVision Tunisia C', 'Hammamet, Tunisia', 'A conference that br', '2024-12-11', '12', '21', 22, 11, 1, 'uploads/675f535a85a56_Screen-Shot-2021-09-21-at-10.31.00-AM-300x199.png'),
(60, 55, 'Harvest Horizons Tun', 'Monastir, Tunisia', 'A forward-thinking e', '2024-12-04', '11', '12', 12, 12, 1, 'uploads/675f537a91b1d_images (3).jpg'),
(61, 66, 'SustainAgri Forum Tu', 'Djerba, Tunisia', 'A forward-thinking e', '2024-12-17', '12', '12', 12, 12, 1, 'uploads/675f5391a0c86_images (2).jpg'),
(64, 333, 'SustainAgri Forum Tu', 'Djerba, Tunisia', 'A forum focusing on ', '2024-12-11', '11', '2', 1, 10, 1, 'uploads/675f53ad970f0_images (3).jpg');

-- --------------------------------------------------------

--
-- Table structure for table `panier`
--

CREATE TABLE `panier` (
  `idpanier` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `prixtotal` float NOT NULL,
  `iduser` int(11) NOT NULL,
  `idcommande` int(11) DEFAULT NULL,
  `id_product` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `panier`
--

INSERT INTO `panier` (`idpanier`, `quantity`, `prixtotal`, `iduser`, `idcommande`, `id_product`) VALUES
(4, 1, 1000, 1, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `id_farmer` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `name_product` varchar(100) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantite` decimal(10,2) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_product`, `id_farmer`, `id_categorie`, `name_product`, `product_price`, `quantite`, `product_image`) VALUES
(1, 1, 1, 'orange', 1000.00, 4.00, 'uploads/675f260c938cd_transparent-orange-apple5eacfeae85ac29.7815306015883956945475.png'),
(2, 4, 1, 'mango', 1000.00, 12.00, 'uploads/675f26204b783_product-packshot-mango.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_comments`
--

CREATE TABLE `product_comments` (
  `id_comment` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `rating` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reclamation`
--

CREATE TABLE `reclamation` (
  `id_rec` int(11) NOT NULL,
  `sujet` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reclamation`
--

INSERT INTO `reclamation` (`id_rec`, `sujet`, `date`, `description`) VALUES
(9, 'ffff', '2024-12-25', 'ddd'),
(10, 'ffff', '2024-12-24', 'ddd');

-- --------------------------------------------------------

--
-- Table structure for table `reponse`
--

CREATE TABLE `reponse` (
  `id_rep` int(11) NOT NULL,
  `idrec` int(11) NOT NULL,
  `reponse` varchar(500) NOT NULL,
  `date_reponse` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(11) NOT NULL,
  `id_event` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `nbr_tickets` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `id_event`, `name`, `last_name`, `email`, `phone_number`, `nbr_tickets`, `price`) VALUES
(97, 57, 'omar', 'belhaj', 'faresmanai05@gmail.com', '27287765', 2, 40.00),
(98, 58, 'omar', 'belhaj', 'obelhaj488@gmail.com', '27287765', 1, 20.00),
(99, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 4, 80.00),
(100, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 27, 540.00),
(101, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 27, 540.00),
(102, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 27, 540.00),
(103, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 1, 20.00),
(104, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 2, 40.00),
(105, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 2, 40.00),
(106, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 2, 40.00),
(107, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 2, 40.00),
(108, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 2, 40.00),
(109, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 2, 40.00),
(110, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 2, 40.00),
(111, 57, 'fares', 'manai', 'faresmanai05@gmail.com', '27287765', 2, 40.00),
(112, 57, 'aziz', 'abidi', 'Azizgamercr7@gmail.com', '12345678', 3, 60.00),
(113, 57, 'aziz', 'abidi', 'Azizgamercr7@gmail.com', '12345678', 3, 60.00),
(114, 58, 'omar', 'belhaj', 'obelhaj488@gmail.com', '27287765', 2, 40.00),
(115, 64, 'omar', 'belhaj', 'obelhaj488@gmail.com', '27287765', 1, 20.00),
(116, 64, 'omar', 'belhaj', 'obelhaj488@gmail.com', '27287765', 2, 40.00),
(117, 64, 'omar', 'belhaj', 'obelhaj488@gmail.com', '27287765', 2, 40.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telephone` int(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `conf` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`iduser`, `nom`, `prenom`, `email`, `telephone`, `type`, `pass`, `conf`) VALUES
(1, 'laabidi', 'hamadi', 'hamadilaabidi1234@gmail.com', 21548968, '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `iduser` int(10) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telephone` int(10) NOT NULL,
  `pass` varchar(20) NOT NULL,
  `conf` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`iduser`, `nom`, `prenom`, `type`, `email`, `telephone`, `pass`, `conf`) VALUES
(4462, 'omar', 'belhaj', 'farmer', 'obelhaj488@gmail.com', 27287765, '1234', '1234'),
(4466, 'omar', 'AZE', 'farmer', 'obelhaj455@gmail.com', 12345678, '1234', '1234'),
(4468, 'omar', 'zz', 'farmer', 'obelhaj433@gmail.com', 33333333, '1234', '1234'),
(4469, 'Akiko', 'Tabor', 'client', 'obelhaj411@gmail.com', 12345467, '1234', '1234'),
(4470, 'fares', 'manai', 'client', 'obelhaj422@gmail.com', 12345675, '1234', '1234'),
(4472, 'Akiko', 'Tabort', 'client', 'obelhaj477@gmail.com', 2132013761, '123', '123'),
(4474, 'fares', 'manaiI', 'farmer', 'obelhaj4@gmail.com', 272877653, '123', '123'),
(4476, 'aziz', 'abidi', 'client', 'obelhaj@gmail.com', 2147483647, '123', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`idcommande`),
  ADD KEY `iduser` (`iduser`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`idpanier`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idcommande` (`idcommande`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Indexes for table `product_comments`
--
ALTER TABLE `product_comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id_rec`);

--
-- Indexes for table `reponse`
--
ALTER TABLE `reponse`
  ADD PRIMARY KEY (`id_rep`),
  ADD KEY `idrec` (`idrec`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_event` (`id_event`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `unique_email` (`email`),
  ADD UNIQUE KEY `unique_telephone` (`telephone`),
  ADD UNIQUE KEY `unique_prenom` (`prenom`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `idcommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `panier`
--
ALTER TABLE `panier`
  MODIFY `idpanier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_comments`
--
ALTER TABLE `product_comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id_rec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reponse`
--
ALTER TABLE `reponse`
  MODIFY `id_rep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4477;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `fk_commande` FOREIGN KEY (`idcommande`) REFERENCES `commande` (`idcommande`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_product` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reponse`
--
ALTER TABLE `reponse`
  ADD CONSTRAINT `reponse_ibfk_1` FOREIGN KEY (`idrec`) REFERENCES `reclamation` (`id_rec`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`id_event`) REFERENCES `event` (`id_event`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
