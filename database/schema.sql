--Création de la base de données
CREATE DATABASE IF NOT EXISTS election_guinee;
USE election_guinee;

-- Table des électeurs
CREATE TABLE voters (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nin VARCHAR(50) UNIQUE NOT NULL,  -- Numéro d'Identification Nationale
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    birth_date DATE NOT NULL,
    adresse TEXT NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    voter_card_number VARCHAR(50) UNIQUE NOT NULL,
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des régions
CREATE TABLE regions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nameRegions VARCHAR(100) NOT NULL,
    code VARCHAR(10) NOT NULL UNIQUE
);

-- Table des bureaux de vote
CREATE TABLE polling_stations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    region_id INT,
    capacity INT NOT NULL,
    FOREIGN KEY (region_id) REFERENCES regions(id)
);

-- Table des candidats
CREATE TABLE candidates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    party_name VARCHAR(100) NOT NULL,
    biography TEXT,
    photo_url VARCHAR(255),
    is_active BOOLEAN DEFAULT true,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des élections
CREATE TABLE elections (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description_elections TEXT,
    start_date_elections DATETIME NOT NULL,
    end_date DATETIME NOT NULL,
    status_elections ENUM('upcoming', 'active', 'closed') DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des votes
CREATE TABLE votes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    voter_id INT,
    candidate_id INT,
    election_id INT,
    polling_station_id INT,
    voted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (voter_id) REFERENCES voters(id),
    FOREIGN KEY (candidate_id) REFERENCES candidates(id),
    FOREIGN KEY (election_id) REFERENCES elections(id),
    FOREIGN KEY (polling_station_id) REFERENCES polling_stations(id),
    UNIQUE KEY unique_vote (voter_id, election_id)
);