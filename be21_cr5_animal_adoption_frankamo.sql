-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2024 at 12:55 AM
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
-- Database: `be21_cr5_animal_adoption_frankamo`
--

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `size` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `vaccinated` enum('yes','no','','') NOT NULL,
  `breed` varchar(100) NOT NULL,
  `status` enum('Adopted','Available') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `photo`, `location`, `description`, `size`, `age`, `vaccinated`, `breed`, `status`) VALUES
(1, 'Billy(Dog)', 'https://cdn.pixabay.com/photo/2024/02/05/16/23/labrador-8554882_1280.jpg', 'Rennbanweg 100', ' Labs are friendly, outgoing, and high-spirited companions who have more than enough affection to go around for a family looking for a medium-to-large dog.', 'big', 9, 'yes', 'labrador', 'Available'),
(2, 'Tommy', 'https://cdn.pixabay.com/photo/2024/02/17/00/18/cat-8578562_1280.jpg', 'Ottakringerstrasse 4', 'They do not belong to a specific breed, because it has a mixed ancestral history. The DSH varies in color and size, from white to black, grey, ginger or tabby. They can be patchy, calico or stripey – anything goes with the alley cat', 'big', 1, 'yes', 'Alley Cat', 'Adopted'),
(5, 'Lilly', 'https://cdn.pixabay.com/photo/2021/08/01/20/31/dog-6515295_1280.jpg', 'Seestadtsrasse 3', 'Lilly is a powerful, compactly built dogs standing as high as 20 inches at the shoulder. Her distinctive traits include a lion\'s-mane ruff around the head and shoulders; a blue-black tongue; deep-set almond eyes that add to a scowling, snobbish expression; and a stiff-legged gait.', 'big', 10, 'yes', 'chow chow dog', 'Available'),
(6, 'Kitty', 'https://cdn.pixabay.com/photo/2014/11/30/14/11/cat-551554_1280.jpg', 'redtenbachergasse 2', 'Lithe and long, with a lean, muscular build and moderately wedge-shaped head and large, almond shaped eyes, the Abyssinian is a supermodel of a cat. From the large ears, small oval feet and long slender tail, the Abyssinian is covered in a fine, short and glossy coat.', 'small', 1, 'no', 'Abyssinian ', 'Available'),
(7, 'Chi', 'https://cdn.pixabay.com/photo/2024/01/25/03/16/capuchin-monkey-8530884_1280.jpg', 'maria-tusch-strasse 7', 'This monkey is round-headed and stockily built, with fully haired prehensile tails and opposable thumbs. The body is 30–55 cm (12–22 inches) long, with a tail of about the same length. Coloration ranges from pale to dark brown or black, with white facial markings in some of the four species.', 'small', 6, 'yes', 'Capuchin monkey', 'Available'),
(8, 'Bobby', 'https://cdn.pixabay.com/photo/2023/11/26/21/11/dog-8414313_1280.jpg', 'Janis-Joplin-Promenade 6', 'Bobby is Weimaraner ,she is  an all-purpose gun dog, and possesses traits such as speed, stamina, great sense of smell, great eyes, courage, and intelligence. The breed is sometimes referred to as the \"grey ghost\" of the dog world because of its ghostly coat and eye color along with its stealthy hunting style.', 'big', 12, 'yes', 'Weimaraner Dog', 'Adopted'),
(9, 'Alaska', 'https://cdn.pixabay.com/photo/2020/09/24/23/24/alaskan-malamute-5600134_1280.jpg', 'sonnenalley 23', ' is an affectionate, loyal, and playful but dignified dog recognizable by his well-furred plumed tail carried over the back, erect ears, and substantial bone. she stands 23 to 25 inches at the shoulder and weighs 75 to 85 pounds.', 'big', 12, 'yes', ' Alaskan Malamute', 'Available'),
(10, 'betty', 'https://cdn.pixabay.com/photo/2016/02/18/18/37/puppy-1207816_1280.jpg', 'kaisermuhlen 3', 'outgoing, trustworthy, and eager-to-please family dogs, and relatively easy to train. They take a joyous and playful approach to life and maintain this puppyish behavior into adulthood.', 'small', 0, 'no', 'Golden retriever dog', 'Available'),
(11, 'Eminem', 'https://cdn.pixabay.com/photo/2023/03/16/14/22/rabbit-7856837_1280.jpg', 'Thaliastrasse 2', 'a short, deep body with a wide head close to its shoulders. They have lop ears and are covered with at least two-inch long fur all over their bodies. ', 'small', 3, '', '\r\nAmerican Fuzzy Lop', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pet_id` int(11) DEFAULT NULL,
  `adoption_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_adoption`
--

INSERT INTO `pet_adoption` (`id`, `user_id`, `pet_id`, `adoption_date`) VALUES
(1, 3, 8, '2024-04-05 21:42:55'),
(2, 5, 5, '2024-04-05 22:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone_number`, `address`, `picture`, `password`, `is_admin`) VALUES
(3, 'Rob', 'Doe', 'rdd@ymail.com', '068854321777', 'Vorgartenstrasse 1', 'https://cdn.pixabay.com/photo/2016/11/21/14/53/man-1845814_1280.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 0),
(4, 'joyce', 'Blessing', 'fii@gmail.com', '43227167874', 'linzerstrasse 2', 'https://cdn.pixabay.com/photo/2015/07/09/00/29/woman-837156_1280.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 0),
(5, 'liz', 'Thompson', 'fliz@gmail.com', '0674634535267', 'linzerstrasse 6', 'https://cdn.pixabay.com/photo/2017/05/11/08/48/woman-2303361_1280.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 0),
(6, 'Betty', 'Doe', 'bett@gmail.com', '075365737', 'Praterstrasse 6', 'https://cdn.pixabay.com/photo/2018/03/06/22/57/portrait-3204843_1280.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 0),
(7, 'Frank', 'Amo', 'franka@yahoo.com', '688634445427', 'Janis-Joplin-Promenade 5', 'https://cdn.pixabay.com/photo/2016/11/21/14/30/man-1845715_1280.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 1),
(8, 'Frank', 'Amo', 'franka@gmail.com', '688634445427', 'Janis-Joplin-Promenade 5', 'https://cdn.pixabay.com/photo/2016/11/18/17/08/fashion-1835871_1280.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 0),
(9, 'job', 'Daniels', 'jds@gmail.com', '6347562727893', 'Karlsplatz 33', 'https://cdn.pixabay.com/photo/2019/09/21/18/25/male-4494491_1280.jpg', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `animals` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
