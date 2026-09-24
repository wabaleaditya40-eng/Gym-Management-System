-- =========================================================
-- Gym Management System - Clean Demo Database
-- Database: gym_management
-- =========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET NAMES utf8mb4;

-- =========================================================
-- TABLE: admins
-- =========================================================

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('SuperAdmin','Staff') DEFAULT 'Staff',
  `otp` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admins`
(`admin_id`, `username`, `email`, `password`, `full_name`, `role`, `otp`)
VALUES
(1, 'admin', 'admin@example.com', MD5('admin123'), 'Demo Admin', 'SuperAdmin', NULL);

-- =========================================================
-- TABLE: plans
-- =========================================================

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `duration_months` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `plans`
(`plan_id`, `plan_name`, `duration_months`, `price`, `description`)
VALUES
(1, 'Monthly Plan', 1, 1500.00,
 'Access to all gym equipment and group classes for 1 month.'),
(2, 'Quarterly Plan', 3, 4000.00,
 '3-month membership with trainer support.'),
(3, 'Yearly Plan', 12, 15000.00,
 '1-year unlimited membership with diet consultation.');

-- =========================================================
-- TABLE: trainers
-- =========================================================

CREATE TABLE `trainers` (
  `trainer_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `join_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `trainers`
(`trainer_id`, `full_name`, `specialization`, `image`,
 `phone`, `email`, `join_date`, `status`)
VALUES
(1, 'Rahul Sharma', 'Strength Training', NULL,
 '9000000003', 'rahul@example.com',
 '2025-08-16 10:00:00', 'Active'),

(2, 'Priya Singh', 'Yoga & Pilates', NULL,
 '9000000004', 'priya@example.com',
 '2025-08-16 10:00:00', 'Active'),

(3, 'Amit Verma', 'Cardio & Weight Loss', NULL,
 '9000000005', 'amit@example.com',
 '2025-08-16 10:00:00', 'Active');

-- =========================================================
-- TABLE: users
-- =========================================================

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `join_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `plan_id` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users`
(`user_id`, `full_name`, `email`, `password`, `phone`,
 `gender`, `dob`, `join_date`, `plan_id`, `status`)
VALUES
(1, 'Rahul Sharma', 'rahul@example.com',
 MD5('1234'), '9000000001', 'Male',
 '2000-01-15', '2025-08-16 18:11:31', NULL, 'Active'),

(2, 'Priya Singh', 'priya@example.com',
 MD5('1234'), '9000000002', 'Female',
 '2001-05-20', '2025-08-16 18:32:20', NULL, 'Active');

-- =========================================================
-- TABLE: attendance
-- =========================================================

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================================================
-- TABLE: payments
-- =========================================================

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` enum('Cash','Card','UPI','Online') DEFAULT NULL,
  `status` enum('Paid','Pending') DEFAULT 'Paid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================================================
-- TABLE: purchases
-- =========================================================

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `purchase_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================================================
-- TABLE: messages
-- =========================================================

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =========================================================
-- PRIMARY KEYS AND INDEXES
-- =========================================================

ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

ALTER TABLE `trainers`
  ADD PRIMARY KEY (`trainer_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

-- =========================================================
-- AUTO INCREMENT
-- =========================================================

ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT=2;

ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT=4;

ALTER TABLE `trainers`
  MODIFY `trainer_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT=4;

ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT=3;

ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

-- =========================================================
-- FOREIGN KEYS
-- =========================================================

ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1`
  FOREIGN KEY (`user_id`)
  REFERENCES `users` (`user_id`)
  ON DELETE CASCADE;

ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1`
  FOREIGN KEY (`user_id`)
  REFERENCES `users` (`user_id`)
  ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2`
  FOREIGN KEY (`plan_id`)
  REFERENCES `plans` (`plan_id`)
  ON DELETE CASCADE;

ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1`
  FOREIGN KEY (`user_id`)
  REFERENCES `users` (`user_id`)
  ON DELETE CASCADE,
  ADD CONSTRAINT `purchases_ibfk_2`
  FOREIGN KEY (`plan_id`)
  REFERENCES `plans` (`plan_id`)
  ON DELETE CASCADE;

COMMIT;