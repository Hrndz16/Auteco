CREATE DATABASE IF NOT EXISTS autecoDB;
USE autecoDB;

CREATE TABLE IF NOT EXISTS categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS motos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    id_categoria INT NOT NULL,
    CONSTRAINT fk_motos_categoria
        FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

INSERT INTO categorias (id_categoria, nombre)
SELECT 1, 'Scooter' WHERE NOT EXISTS (SELECT 1 FROM categorias WHERE id_categoria = 1);
INSERT INTO categorias (id_categoria, nombre)
SELECT 2, 'Deportiva' WHERE NOT EXISTS (SELECT 1 FROM categorias WHERE id_categoria = 2);
INSERT INTO categorias (id_categoria, nombre)
SELECT 3, 'Doble Proposito' WHERE NOT EXISTS (SELECT 1 FROM categorias WHERE id_categoria = 3);
INSERT INTO categorias (id_categoria, nombre)
SELECT 4, 'Naked' WHERE NOT EXISTS (SELECT 1 FROM categorias WHERE id_categoria = 4);

INSERT INTO motos (id, marca, modelo, precio, id_categoria)
SELECT 1, 'Yamaha', 'NMAX 155', 16490000, 1
WHERE NOT EXISTS (SELECT 1 FROM motos WHERE id = 1);

INSERT INTO motos (id, marca, modelo, precio, id_categoria)
SELECT 2, 'Suzuki', 'GSX-R150', 17190000, 2
WHERE NOT EXISTS (SELECT 1 FROM motos WHERE id = 2);

INSERT INTO motos (id, marca, modelo, precio, id_categoria)
SELECT 3, 'Honda', 'XR 190L', 13950000, 3
WHERE NOT EXISTS (SELECT 1 FROM motos WHERE id = 3);

INSERT INTO motos (id, marca, modelo, precio, id_categoria)
SELECT 4, 'Bajaj', 'Pulsar N250', 15499000, 4
WHERE NOT EXISTS (SELECT 1 FROM motos WHERE id = 4);
