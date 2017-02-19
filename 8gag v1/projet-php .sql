-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 19 Février 2017 à 18:53
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet-php`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Music'),
(2, 'Landscape'),
(3, 'Mode'),
(4, 'Sport'),
(5, 'Games'),
(6, 'Animals'),
(7, 'Portrait'),
(8, 'Food'),
(9, 'City'),
(10, 'Others');

-- --------------------------------------------------------

--
-- Structure de la table `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `picture` text,
  `categories_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pictures`
--

INSERT INTO `pictures` (`id`, `name`, `picture`, `categories_id`, `user_id`) VALUES
(5, 'ane', 'anelel.jpg', 6, 2),
(6, 'chaton', 'chatonbox.jpg', 6, 2),
(7, 'loup', 'chienloup.jpg', 6, 2),
(8, 'Koala', 'koalalel.jpg', 6, 2),
(9, 'Panda', 'mimipanda.jpg', 6, 2),
(10, 'new york', '9a5eae1d4ca95280ea4c5b090f493082.jpg', 9, 2),
(11, 'NY', '76f655209deac4af4258592a6ba4f096.jpg', 9, 2),
(12, 'sunset', '153248-City-Sunset.jpg', 9, 2),
(13, 'pont', 'tumblr_n35y8cdzgj1sf0xh9o1_r1_500.gif', 9, 2),
(14, 'croque', 'tumblr_mvjdgmRYBe1qzhwvho1_1280.jpg', 8, 2),
(15, 'pancakes', 'tumblr_nblwi36PUN1qbqh5xo1_1280.jpg', 8, 2),
(19, 'Nouilles', 'tumblr_mgsm1qf73G1rc7vp6o1_500.jpg', 8, 2),
(20, 'route', 'tumblr_mgqewubz4Y1rck9pno1_1280.jpg', 2, 2),
(21, 'pont', 'tumblr_o7b4pyXB1D1ukofkbo1_1280.jpg', 2, 2),
(22, 'arbres', 'tumblr_o76otjOA9V1ukofkbo1_r2_1280.jpg', 2, 2),
(23, 'riviere', 'tumblr_o773qyTpid1sciduvo1_1280.jpg', 2, 2),
(24, 'tshirt', 'tumblr_lzzxpt7ktB1r0241jo1_500.jpg', 3, 2),
(25, 'nine', 'tumblr_m9zh1cGw621qefhxso1_1280.jpg', 3, 2),
(26, 'tenue', 'tumblr_m8x5n0l9vw1rvburbo1_500.jpg', 3, 2),
(27, 'pull', 'tumblr_m6cyknypHn1rr5g4so1_1280.jpg', 3, 2),
(28, 'montre', 'tumblr_mfqyo0sXJH1ronv5io1_1280.jpg', 3, 2),
(29, 'gateau', 'tumblr_nysxo81pTS1r1d04qo1_540.jpg', 8, 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(2, 'ghb', 'g@hotmail.com', '54fd1711209fb1c0781092374132c66e79e2241b'),
(7, 'dad', 'dad@gmail.com', 'cdd4f874095045f4ae6670038cbbd05fac9d4802');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`,`categories_id`,`user_id`),
  ADD KEY `fk_products_categories1_idx` (`categories_id`),
  ADD KEY `fk_products_user1_idx` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `fk_products_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_products_user1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
