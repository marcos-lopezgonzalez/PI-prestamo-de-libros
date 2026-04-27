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
    role VARCHAR(50) NOT NULL DEFAULT 'user',
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

-- -------------------------------------------------
-- DATA SETS
-- -------------------------------------------------
INSERT INTO usuario (nombre, apellidos, email, role, username, password) VALUES
('Ana', 'García López', 'ana.garcia@email.com', 'admin', 'anag', '1234'),
('Luis', 'Martínez Pérez', 'luis.martinez@email.com', 'user', 'luism', '1234'),
('Carlos', 'Sánchez Ruiz', 'carlos.sanchez@email.com', 'user', 'carloss', '1234'),
('María', 'Fernández Gómez', 'maria.fernandez@email.com', 'user', 'mariaf', '1234'),
('Elena', 'Torres Díaz', 'elena.torres@email.com', 'user', 'elenat', '1234'),
('admin', 'admin', 'admin@admin.com', 'admin', 'admin', '$2y$12$sMZ97uLOjhr4.tkkkyAH0.45T9VDzcngBkd2c3.K8AXdxQpkX/N/O');

INSERT INTO libro (titulo, autor, genero, anyo, id_usuario) VALUES
('Cien años de soledad', 'Gabriel García Márquez', 'Realismo mágico', 1967, 1),
('Don Quijote de la Mancha', 'Miguel de Cervantes', 'Novela', 1901, 2),
('La sombra del viento', 'Carlos Ruiz Zafón', 'Misterio', 2001, 3),
('El nombre del viento', 'Patrick Rothfuss', 'Fantasía', 2007, 4),
('1984', 'George Orwell', 'Distopía', 1949, 5),
('El Hobbit', 'J.R.R. Tolkien', 'Fantasía', 1937, 1),
('Los juegos del hambre', 'Suzanne Collins', 'Ciencia ficción', 2008, 2);

INSERT INTO prestamo (fecha_prestamo, fecha_devolucion, id_usuario, id_libro, devuelto) VALUES
('2026-04-01 10:00:00', '2026-04-10 12:00:00', 2, 1, 1),
('2026-04-05 09:30:00', NULL, 3, 2, 0),
('2026-04-07 11:15:00', '2026-04-15 16:00:00', 4, 3, 1),
('2026-04-10 18:20:00', NULL, 5, 4, 0),
('2026-04-12 14:00:00', '2026-04-20 10:30:00', 1, 5, 1),
('2026-04-15 17:45:00', NULL, 2, 6, 0),
('2026-04-18 08:10:00', NULL, 3, 7, 0);