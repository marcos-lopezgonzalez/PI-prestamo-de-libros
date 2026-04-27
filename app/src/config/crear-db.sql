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
    anyo INT NOT NULL,
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
('Ana', 'García López', 'ana1@email.com', 'admin', 'ana1', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Luis', 'Martínez Pérez', 'luis2@email.com', 'user', 'luis2', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Carlos', 'Sánchez Ruiz', 'carlos3@email.com', 'user', 'carlos3', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('María', 'Fernández Gómez', 'maria4@email.com', 'user', 'maria4', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Elena', 'Torres Díaz', 'elena5@email.com', 'user', 'elena5', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Javier', 'Ruiz Moreno', 'javier6@email.com', 'user', 'javier6', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Lucía', 'Navarro Gil', 'lucia7@email.com', 'user', 'lucia7', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Pablo', 'Ortega Castro', 'pablo8@email.com', 'user', 'pablo8', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Sara', 'Romero Vega', 'sara9@email.com', 'user', 'sara9', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Diego', 'Herrera León', 'diego10@email.com', 'user', 'diego10', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Laura', 'Molina Cruz', 'laura11@email.com', 'user', 'laura11', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Raúl', 'Serrano Ortiz', 'raul12@email.com', 'user', 'raul12', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Carmen', 'Delgado Ríos', 'carmen13@email.com', 'user', 'carmen13', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Adrián', 'Castro Peña', 'adrian14@email.com', 'user', 'adrian14', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Marta', 'Vidal Soto', 'marta15@email.com', 'user', 'marta15', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Iván', 'Campos Núñez', 'ivan16@email.com', 'user', 'ivan16', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Paula', 'Iglesias Cano', 'paula17@email.com', 'user', 'paula17', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Hugo', 'Reyes Bravo', 'hugo18@email.com', 'user', 'hugo18', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Nerea', 'Flores Moya', 'nerea19@email.com', 'user', 'nerea19', '$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US'),
('Álvaro', 'Medina Soler', 'alvaro20@email.com', 'user', 'alvaro20', '1$2y$12$xzjFFxEHt8VrTfU1u4/39emK0dLvZchaBeGDPA8dx0Wdp/n9Dc3US234'),
('admin', 'admin', 'admin@admin.com', 'admin', 'admin', '$2y$12$sMZ97uLOjhr4.tkkkyAH0.45T9VDzcngBkd2c3.K8AXdxQpkX/N/O');

INSERT INTO libro (titulo, autor, genero, anyo, id_usuario) VALUES
('Cien años de soledad', 'Gabriel García Márquez', 'Realismo mágico', 1967, 1),
('Don Quijote de la Mancha', 'Miguel de Cervantes', 'Novela', 1923, 2),
('1984', 'George Orwell', 'Distopía', 1949, 3),
('El Hobbit', 'J.R.R. Tolkien', 'Fantasía', 1937, 4),
('Fahrenheit 451', 'Ray Bradbury', 'Distopía', 1953, 5),
('Orgullo y prejuicio', 'Jane Austen', 'Romance', 1921, 6),
('Crimen y castigo', 'Fiódor Dostoyevski', 'Drama', 1866, 7),
('La sombra del viento', 'Carlos Ruiz Zafón', 'Misterio', 2001, 8),
('El nombre del viento', 'Patrick Rothfuss', 'Fantasía', 2007, 9),
('Dune', 'Frank Herbert', 'Ciencia ficción', 1965, 10),
('It', 'Stephen King', 'Terror', 1986, 11),
('Drácula', 'Bram Stoker', 'Terror', 1897, 12),
('Los juegos del hambre', 'Suzanne Collins', 'Ciencia ficción', 2008, 13),
('El código Da Vinci', 'Dan Brown', 'Thriller', 2003, 14),
('La carretera', 'Cormac McCarthy', 'Postapocalíptico', 2006, 15),
('Ready Player One', 'Ernest Cline', 'Ciencia ficción', 2011, 16),
('El alquimista', 'Paulo Coelho', 'Ficción', 1988, 17),
('La isla del tesoro', 'R.L. Stevenson', 'Aventura', 1883, 18),
('Matar a un ruiseñor', 'Harper Lee', 'Drama', 1960, 19),
('El señor de los anillos', 'J.R.R. Tolkien', 'Fantasía', 1954, 20);

INSERT INTO prestamo (fecha_prestamo, fecha_devolucion, id_usuario, id_libro, devuelto) VALUES
('2026-04-01 10:00:00', '2026-04-08 12:00:00', 2, 1, 1),
('2026-04-02 11:30:00', NULL, 3, 2, 0),
('2026-04-03 09:00:00', '2026-04-10 10:00:00', 5, 3, 1),
('2026-04-04 16:45:00', NULL, 7, 4, 0),
('2026-04-05 13:20:00', NULL, 8, 5, 0),
('2026-04-06 18:10:00', '2026-04-15 09:30:00', 10, 6, 1),
('2026-04-07 12:00:00', NULL, 12, 7, 0),
('2026-04-08 14:00:00', '2026-04-18 11:00:00', 14, 8, 1),
('2026-04-09 10:30:00', NULL, 15, 9, 0),
('2026-04-10 17:00:00', NULL, 18, 10, 0);