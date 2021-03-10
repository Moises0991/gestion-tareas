CREATE DATABASE data_usuarios1;

use data_usuarios1;

CREATE TABLE usuarios (
    -- UNSIGNED sirve para permitir solo valores positivos (sin signo)
    id INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    nombre_usuario VARCHAR(30) NOT NULL,
    apellidos_usuario VARCHAR(40) NOT NULL,
    password_usuario VARCHAR(50) NOT NULL,
    edad_usuario INT(2) UNSIGNED NOT NULL, 
    correo_usuario VARCHAR(30) NOT NULL,
    profesion_usuario INT(2) UNSIGNED NOT NULL,
    -- TIMESTAMP es un tipo de dato que contiene fecha y hora
    -- La función CURRENT_TIMESTAMP devuelve la fecha y la hora local actual 
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

INSERT INTO usuarios (nombre_usuario, apellidos_usuario, password_usuario, edad_usuario, correo_usuario, profesion_usuario) values ('test', 'valencia', 'fa6a5a3224d7da66d9e0bdec25f62cf0', '12', 'wdafa@ejemplo.com', '1');

