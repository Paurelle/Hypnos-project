CREATE TABLE users
(
    id_user INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE establishments
(
    id_establishment INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_user INT,
    name VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    description TEXT NOT NULL, 
    establishment_picture_name VARCHAR(100) NOT NULL,
    establishment_picture MEDIUMBLOB NOT NULL,   
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);
CREATE TABLE contact_subjects
(
    id_subject INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    subject VARCHAR(255) NOT NULL
);
CREATE TABLE contacts
(
    id_contact INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_subject INT NOT NULL,
    id_establishment INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    FOREIGN KEY (id_subject) REFERENCES contact_subjects(id_subject),
    FOREIGN KEY (id_establishment) REFERENCES establishments(id_establishment) ON DELETE CASCADE
);

CREATE TABLE suites
(
    id_suite INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_establishment INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    description TEXT NOT NULL,
    featured_img_name VARCHAR(100) NOT NULL,
    featured_img MEDIUMBLOB NOT NULL,
    link VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_establishment) REFERENCES establishments(id_establishment) ON DELETE CASCADE
);
CREATE TABLE suite_pictures
(
    id_suite_picture INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_suite INT NOT NULL,
    suite_picture_name VARCHAR(100) NOT NULL,
    suite_picture MEDIUMBLOB NOT NULL,
    FOREIGN KEY (id_suite) REFERENCES suites(id_suite) ON DELETE CASCADE
);

CREATE TABLE reservations
(
    id_reservation INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    id_user INT NOT NULL,
    id_establishment INT NOT NULL,
    id_suite INT NOT NULL,
    price INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (id_establishment) REFERENCES establishments(id_establishment) ON DELETE CASCADE,
    FOREIGN KEY (id_suite) REFERENCES suites(id_suite)
);

INSERT INTO `contact_subjects` (`id_subject`, `subject`) VALUES
(1, 'Je souhaite poser une réclamation'),
(2, 'Je souhaite commander un service supplémentaire'),
(3, 'Je souhaite en savoir plus sur une suite'),
(4, 'J’ai un souci avec cette application');