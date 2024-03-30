-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2023 at 04:22 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

DROP DATABASE IF EXISTS filter_test ;
CREATE DATABASE filter_test ;
USE filter_test ;
DROP TABLE IF EXISTS cars ;

CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marque VARCHAR(255),
    boite VARCHAR(255), -- 'Auto' or 'Manuelle'
    annee YEAR,
    kilometrage INT,
    energie VARCHAR(255), -- Such as 'Essence', 'Diesel', 'Électrique', etc.
    prix DECIMAL(10, 2),
    hp INT -- Horsepower
);

USE filter_test;

INSERT INTO cars (marque, boite, annee, kilometrage, energie, prix, hp) VALUES
('Peugeot', 'Manuelle', 2015, 50000, 'Diesel', 15000.00, 120),
('Renault', 'Auto', 2018, 30000, 'Essence', 18000.00, 150),
('Citroen', 'Manuelle', 2017, 40000, 'Électrique', 22000.00, 100),
('Toyota', 'Auto', 2020, 10000, 'Hybride', 25000.00, 180),
('BMW', 'Auto', 2019, 20000, 'Diesel', 27000.00, 190),
('Tesla', 'Auto', 2021, 5000, 'Électrique', 45000.00, 300),
('Fiat', 'Manuelle', 2014, 60000, 'Essence', 8000.00, 90),
('Mercedes', 'Auto', 2020, 15000, 'Diesel', 35000.00, 220),
('Nissan', 'Manuelle', 2016, 55000, 'Essence', 12000.00, 110),
('Volkswagen', 'Auto', 2018, 25000, 'Hybride', 23000.00, 160);