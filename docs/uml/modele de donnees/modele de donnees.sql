CREATE TABLE `User` (
  `id` int PRIMARY KEY,
  `username` varchar(255),
  `password` varchar(255),
  `email` varchar(255),
  `roles` json
);

CREATE TABLE `Task` (
  `id` int PRIMARY KEY,
  `title` varchar(255),
  `content` varchar(255),
  `created_at` datetime,
  `toggle` boolean
);

ALTER TABLE `User` ADD FOREIGN KEY (`id`) REFERENCES `Task` (`id`);
