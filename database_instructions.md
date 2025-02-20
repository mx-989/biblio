SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS `biblio`;
USE `biblio`;

CREATE TABLE `authors` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `is_admin` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `books` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `author_id` INT NOT NULL,
  `published_at` DATE DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `borrows` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `book_id` INT NOT NULL,
  `borrow_date` DATE NOT NULL,
  `return_date` DATE DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `book_id` (`book_id`),
  CONSTRAINT `borrows_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `borrows_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

INSERT INTO `authors` (`id`, `name`) VALUES
  (1, 'Jane Austen'),
  (2, 'Charles Dickens'),
  (3, 'Mark Twain'),
  (4, 'Jules Verne'),
  (5, 'H.G. Wells'),
  (6, 'George Orwell'),
  (7, 'Fyodor Dostoevsky'),
  (8, 'Leo Tolstoy'),
  (9, 'Ernest Hemingway'),
  (10, 'Haruki Murakami');

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`) VALUES
  (1, 'admin', 'admin@example.com', '$2y$10$C/4fg4HEp9BZSaJPiVdyWe/Y1lhz7jujm3Z0VFM2AVj2tgJlrvC1W', 1),
  (2, 'john',  'john@example.com',  '$2y$10$dJZkbmrfuZ6qujvHApXT9e5TKGHitfbNSJ1pAEVG1JFyvpWEqmc.W', 0),
  (3, 'jane',  'jane@example.com',  '$2y$10$onR9mELLAZQHI/Vt3gpgN.VHy5ypI6//PvTprJ66So.fxuMfJ2z9i', 0),
  (4, 'bob',   'bob@example.com',   '$2y$10$P3DCaFZvu5da4SQaH.OjfuLVNeOTnftEzS0uOIZBBU5pmd8v9anKW', 0);

INSERT INTO `books` (`id`, `title`, `author_id`, `published_at`) VALUES
  (1, 'Pride and Prejudice', 1, '2020-01-01'),
  (2, 'Sense and Sensibility', 2, '2020-01-01'),
  (3, 'Emma', 3, '2020-01-01'),
  (4, 'Mansfield Park', 4, '2020-01-01'),
  (5, 'Northanger Abbey', 5, '2020-01-01'),
  (6, 'Persuasion', 6, '2020-01-01'),
  (7, 'Great Expectations', 7, '2020-01-01'),
  (8, 'Oliver Twist', 8, '2020-01-01'),
  (9, 'David Copperfield', 9, '2020-01-01'),
  (10, 'A Tale of Two Cities', 10, '2020-01-01'),
  (11, 'Adventures of Huckleberry Finn', 1, '2020-01-01'),
  (12, 'Adventures of Tom Sawyer', 2, '2020-01-01'),
  (13, 'Twenty Thousand Leagues Under the Sea', 3, '2020-01-01'),
  (14, 'Around the World in Eighty Days', 4, '2020-01-01'),
  (15, 'Journey to the Center of the Earth', 5, '2020-01-01'),
  (16, 'The Mysterious Island', 6, '2020-01-01'),
  (17, 'The Time Machine', 7, '2020-01-01'),
  (18, 'The War of the Worlds', 8, '2020-01-01'),
  (19, 'Animal Farm', 9, '2020-01-01'),
  (20, '1984', 10, '2020-01-01'),
  (21, 'Crime and Punishment', 1, '2020-01-01'),
  (22, 'The Idiot', 2, '2020-01-01'),
  (23, 'The Brothers Karamazov', 3, '2020-01-01'),
  (24, 'Notes from Underground', 4, '2020-01-01'),
  (25, 'War and Peace', 5, '2020-01-01'),
  (26, 'Anna Karenina', 6, '2020-01-01'),
  (27, 'The Death of Ivan Ilyich', 7, '2020-01-01'),
  (28, 'The Old Man and the Sea', 8, '2020-01-01'),
  (29, 'For Whom the Bell Tolls', 9, '2020-01-01'),
  (30, 'A Farewell to Arms', 10, '2020-01-01'),
  (31, 'The Sun Also Rises', 1, '2020-01-01'),
  (32, 'Men Without Women', 2, '2020-01-01'),
  (33, 'Norwegian Wood', 3, '2020-01-01'),
  (34, 'Kafka on the Shore', 4, '2020-01-01'),
  (35, 'The Wind-Up Bird Chronicle', 5, '2020-01-01'),
  (36, '1Q84', 6, '2020-01-01'),
  (37, 'Hard-Boiled Wonderland and the End of the World', 7, '2020-01-01'),
  (38, 'Sputnik Sweetheart', 8, '2020-01-01'),
  (39, 'The Great Gatsby', 9, '2020-01-01'),
  (40, 'The Catcher in the Rye', 10, '2020-01-01'),
  (41, 'Fahrenheit 451', 1, '2020-01-01'),
  (42, 'Brave New World', 2, '2020-01-01'),
  (43, 'The Hobbit', 3, '2020-01-01'),
  (44, 'The Lord of the Rings', 4, '2020-01-01'),
  (45, 'The Silmarillion', 5, '2020-01-01'),
  (46, 'The Chronicles of Narnia', 6, '2020-01-01'),
  (47, 'The Lion, the Witch and the Wardrobe', 7, '2020-01-01'),
  (48, 'Prince Caspian', 8, '2020-01-01'),
  (49, 'The Voyage of the Dawn Treader', 9, '2020-01-01'),
  (50, 'The Silver Chair', 10, '2020-01-01'),
  (51, 'The Last Battle', 1, '2020-01-01'),
  (52, 'The Magician\'s Nephew', 2, '2020-01-01'),
  (53, 'The Horse and His Boy', 3, '2020-01-01'),
  (54, 'Moby-Dick', 4, '2020-01-01'),
  (55, 'Little Women', 5, '2020-01-01'),
  (56, 'Wuthering Heights', 6, '2020-01-01'),
  (57, 'Jane Eyre', 7, '2020-01-01'),
  (58, 'Frankenstein', 8, '2020-01-01'),
  (59, 'Dracula', 9, '2020-01-01'),
  (60, 'The Picture of Dorian Gray', 10, '2020-01-01'),
  (61, 'The Strange Case of Dr Jekyll and Mr Hyde', 1, '2020-01-01'),
  (62, 'Treasure Island', 2, '2020-01-01'),
  (63, 'Robinson Crusoe', 3, '2020-01-01'),
  (64, 'Gulliver\'s Travels', 4, '2020-01-01'),
  (65, 'The Adventures of Sherlock Holmes', 5, '2020-01-01'),
  (66, 'The Memoirs of Sherlock Holmes', 6, '2020-01-01'),
  (67, 'The Return of Sherlock Holmes', 7, '2020-01-01'),
  (68, 'A Study in Scarlet', 8, '2020-01-01'),
  (69, 'The Hound of the Baskervilles', 9, '2020-01-01'),
  (70, 'The Sign of Four', 10, '2020-01-01'),
  (71, 'The Valley of Fear', 1, '2020-01-01'),
  (72, 'The Count of Monte Cristo', 2, '2020-01-01'),
  (73, 'The Three Musketeers', 3, '2020-01-01'),
  (74, 'Les Misérables', 4, '2020-01-01'),
  (75, 'The Hunchback of Notre-Dame', 5, '2020-01-01'),
  (76, 'Don Quixote', 6, '2020-01-01'),
  (77, 'Madame Bovary', 7, '2020-01-01'),
  (78, 'The Stranger', 8, '2020-01-01'),
  (79, 'The Plague', 9, '2020-01-01'),
  (80, 'The Fall', 10, '2020-01-01'),
  (81, 'The Metamorphosis', 1, '2020-01-01'),
  (82, 'The Trial', 2, '2020-01-01'),
  (83, 'In Search of Lost Time', 3, '2020-01-01'),
  (84, 'Ulysses', 4, '2020-01-01'),
  (85, 'Dubliners', 5, '2020-01-01'),
  (86, 'The Odyssey', 6, '2020-01-01'),
  (87, 'The Iliad', 7, '2020-01-01'),
  (88, 'The Aeneid', 8, '2020-01-01'),
  (89, 'The Divine Comedy', 9, '2020-01-01'),
  (90, 'Paradise Lost', 10, '2020-01-01'),
  (91, 'The Canterbury Tales', 1, '2020-01-01'),
  (92, 'Faust', 2, '2020-01-01'),
  (93, 'The Tale of Genji', 3, '2020-01-01'),
  (94, 'One Hundred Years of Solitude', 4, '2020-01-01'),
  (95, 'Love in the Time of Cholera', 5, '2020-01-01'),
  (96, 'The Kite Runner', 6, '2020-01-01'),
  (97, 'A Thousand Splendid Suns', 7, '2020-01-01'),
  (98, 'The Book Thief', 8, '2020-01-01'),
  (99, 'Life of Pi', 9, '2020-01-01'),
  (100, 'Memoirs of a Geisha', 10, '2020-01-01');

INSERT INTO `borrows` (`id`, `user_id`, `book_id`, `borrow_date`, `return_date`) VALUES
  (1, 2, 1, '2023-01-10', NULL),
  (2, 2, 50, '2023-02-01', '2023-02-15'),
  (3, 3, 25, '2023-03-05', NULL),
  (4, 3, 99, '2023-04-01', NULL),
  (5, 2, 10, '2023-04-10', '2023-04-20');

COMMIT;

SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
