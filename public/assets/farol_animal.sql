-- FARO ANIMAL

DROP DATABASE IF EXISTS faro_animal;
CREATE DATABASE faro_animal;

USE faro_animal;

-- USERS (USUÁRIOS)
-- CRUD #1

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT,
    
    name VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,

    reset_token VARCHAR(100) NULL,
    reset_expires_at DATETIME NULL, 

    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    deleted_at DATETIME NULL,

    PRIMARY KEY (id)
);

-- SPECIES (ESPÉCIES)
-- CRUD #2

CREATE TABLE species (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    name VARCHAR(100) NOT NULL UNIQUE,

    created_at DATETIME NULL,
    updated_at DATETIME NULL, 
    deleted_at DATETIME NULL,

    PRIMARY KEY (id)
);

-- BREEDS (RAÇAS)
-- CRUD #3

CREATE TABLE breeds (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,

    species_id INT UNSIGNED NOT NULL,

    name VARCHAR(100) NOT NULL,

    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    deleted_at DATETIME NULL,

    PRIMARY KEY (id),

    CONSTRAINT uq_breed_species_name
        UNIQUE (species_id, name),

    CONSTRAINT fk_breeds_species
        FOREIGN KEY (species_id)
        REFERENCES species(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- PETS
-- CRUD #4

CREATE TABLE pets (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    breed_id INT UNSIGNED NOT NULL,

    name VARCHAR(100) NOT NULL,
    sex ENUM("M", "F") NOT NULL,
    birth_date DATE NULL,
    weight DECIMAL(5,2) NULL,
    notes TEXT NULL,
    owner_name VARCHAR(120) NOT NULL,
    owner_phone VARCHAR(20) NULL,

    created_at DATETIME NULL,
    updated_at DATETIME NULL, 
    deleted_at DATETIME NULL,

    PRIMARY KEY (id),
    CONSTRAINT fk_pets_breed
        FOREIGN KEY (breed_id)
        REFERENCES breeds(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- APPOINTMENTS (CONSULTAS)
-- CRUD #5

CREATE TABLE appointments (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    pet_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,

    appointment_date DATETIME NOT NULL,
    reason VARCHAR(255) NOT NULL,
    diagnosis TEXT NULL,
    prescription TEXT NULL,
    notes TEXT NULL,
    status ENUM(
        'scheduled',
        'completed',
        'cancelled'
    ) NOT NULL DEFAULT 'scheduled',

    created_at DATETIME NULL,
    updated_at DATETIME NULL, 
    deleted_at DATETIME NULL,

    PRIMARY KEY (id),
    CONSTRAINT fk_appointment_pet
        FOREIGN KEY (pet_id)
        REFERENCES pets(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_appointment_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);

-- INSERTS

-- SPECIES
INSERT INTO species (name, created_at, updated_at) VALUES
('Cachorro', NOW(), NOW()),
('Gato', NOW(), NOW()),
('Pássaro', NOW(), NOW()),
('Coelho', NOW(), NOW());

-- BREEDS
INSERT INTO breeds (species_id, name, created_at, updated_at) VALUES
(1, 'Labrador Retriever', NOW(), NOW()),
(1, 'Golden Retriever', NOW(), NOW()),
(1, 'Poodle', NOW(), NOW()),
(1, 'Shih Tzu', NOW(), NOW()),
(1, 'Beagle', NOW(), NOW()),
(1, 'Bulldog Francês', NOW(), NOW()),
(1, 'Pastor Alemão', NOW(), NOW()),
(1, 'SRD (Sem Raça Definida)', NOW(), NOW()),
(2, 'Persa', NOW(), NOW()),
(2, 'Siamês', NOW(), NOW()),
(2, 'Maine Coon', NOW(), NOW()),
(2, 'Angorá', NOW(), NOW()),
(2, 'British Shorthair', NOW(), NOW()),
(2, 'SRD (Sem Raça Definida)', NOW(), NOW()),
(3, 'Calopsita', NOW(), NOW()),
(3, 'Periquito Australiano', NOW(), NOW()),
(3, 'Canário', NOW(), NOW()),
(3, 'Agapornis', NOW(), NOW()),
(4, 'Mini Lop', NOW(), NOW()),
(4, 'Lionhead', NOW(), NOW()),
(4, 'Nova Zelândia', NOW(), NOW()),
(4, 'Holandês', NOW(), NOW());

-- USER
-- admin123
INSERT INTO users ( name, email, password, created_at, updated_at ) VALUES
( 'Administrador', 'admin@faroanimal.com', '$2y$10$4ajD0egB6WX3SSzmqsfZTOG1MsEicPvcGg4HraDYP4lXLXlLucX6u', NOW(), NOW());