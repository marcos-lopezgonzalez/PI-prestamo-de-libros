DROP DATABASE IF EXISTS prestamo_libros;

CREATE DATABASE prestamo_libros
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

USE prestamo_libros;

-- -------------------------------------------------
-- TABLA USUARIOS
-- -------------------------------------------------
CREATE TABLE usuario (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- -------------------------------------------------
-- TABLA LIBROS
-- -------------------------------------------------
CREATE TABLE libro (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    autor VARCHAR(150) NOT NULL,
    genero VARCHAR(100) NOT NULL,
    anyo YEAR NOT NULL,
    id_usuario INT UNSIGNED NOT NULL,
    CONSTRAINT fk_libro_usuario FOREIGN KEY (id_usuario) REFERENCES usuario (id) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- -------------------------------------------------
-- TABLA PRESTAMOS
-- -------------------------------------------------
CREATE TABLE prestamo (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fecha_prestamo DATETIME NOT NULL,
    fecha_devolucion DATETIME,
    id_usuario INT UNSIGNED NOT NULL,
    id_libro INT UNSIGNED NOT NULL,
    devuelto TINYINT (1) NOT NULL, -- 0 = en préstamo, 1 = devuelto
    CONSTRAINT fk_prestamo_usuario FOREIGN KEY (id_usuario) REFERENCES usuario (id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_prestamo_libro FOREIGN KEY (id_libro) REFERENCES libro (id) ON DELETE RESTRICT ON UPDATE CASCADE
);