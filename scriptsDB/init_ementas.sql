USE ementas_db;

CREATE TABLE IF NOT EXISTS Prato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    designacao VARCHAR(255) NOT NULL,
    alergeno_id JSON DEFAULT NULL
);

CREATE TABLE IF NOT EXISTS Ementas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data DATE NOT NULL,
    id_prato INT NOT NULL,
    FOREIGN KEY (id_Prato) REFERENCES Prato(id)
);

CREATE TABLE IF NOT EXISTS Utilizador (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(50) NOT NULL,
  password varchar(255) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO Utilizador (username, password) 
VALUES ('admin', '$2y$10$IqPK3W8zlELjF1yMNx6dU.56iO7noXcjGqSD3wlzzTUiz4oT0Vo46');