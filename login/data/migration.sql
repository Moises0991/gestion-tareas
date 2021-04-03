CREATE DATABASE data_users;

use data_users;

CREATE TABLE managers (
  -- UNSIGNED sirve para permitir solo valores positivos (sin signo)
  -- userid int(11) NOT NULL,
  userid INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  nickname VARCHAR(30) NOT NULL,
  username VARCHAR(40) NOT NULL,
  pass_user VARCHAR(50) NOT NULL,
  user_age INT(2) UNSIGNED NOT NULL, 
  email VARCHAR(30) NOT NULL,
  phone BIGINT(55) UNSIGNED NOT NULL, 
  avatar varchar(255) NOT NULL,
  current_session int(11) NOT NULL,
  online int(11) NOT NULL,
  -- TIMESTAMP es un tipo de dato que contiene fecha y hora
  -- La función CURRENT_TIMESTAMP devuelve la fecha y la hora local actual 
  create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 

)ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO managers (nickname, username, pass_user, user_age, email, phone, avatar, current_session, online) values ('moises0991', 'moises soler zetina', 'soler', '21', 'moises0991@gmail.com', '9981584073','moises0991.jpg', 2, 1);
INSERT INTO managers (nickname, username, pass_user, user_age, email, phone, avatar, current_session, online) values ('jeff0991', 'jeff malone peralta', 'manolo', '23', 'malone@gmail.com', '9988391319','jeff0991.jpg', 1, 1);


CREATE TABLE employees (
    -- UNSIGNED sirve para permitir solo valores positivos (sin signo)
    id INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    nickname VARCHAR(30) NOT NULL,
    username VARCHAR(40) NOT NULL,
    pass_user VARCHAR(50) NOT NULL,
    user_age INT(2) UNSIGNED NOT NULL, 
    email VARCHAR(30) NOT NULL,
    phone BIGINT(55) UNSIGNED NOT NULL, 
    avatar varchar(255) NOT NULL,
    -- TIMESTAMP es un tipo de dato que contiene fecha y hora
    -- La función CURRENT_TIMESTAMP devuelve la fecha y la hora local actual 
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);
INSERT INTO employees (nickname, username, pass_user, user_age, email, phone, avatar) values ('ramona0991', 'ramona salazar mendiola', 'soler', '21', 'ramona@gmail.com', '9988674739','ramona0991.jpg');
INSERT INTO employees (nickname, username, pass_user, user_age, email, phone, avatar) values ('raul0991', 'raul cordoba medina', 'raul', '22', 'raul@gmail.com', '9981497748','raul0991.jpg');


-- creacion de tablas para chat
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


-- Estructura de tabla para la tabla `chat`
CREATE TABLE `chat` (
  `chatid` int(11) NOT NULL,
  `sender_userid` int(11) NOT NULL,
  `reciever_userid` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Estructura de tabla para la tabla `chat_login_details`
CREATE TABLE `chat_login_details` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_typing` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Índices para tablas volcadas
-- Indices de la tabla `chat`
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chatid`);


-- Indices de la tabla `chat_login_details`
ALTER TABLE `chat_login_details`
  ADD PRIMARY KEY (`id`);


-- AUTO_INCREMENT de las tablas volcadas
-- AUTO_INCREMENT de la tabla `chat`
ALTER TABLE `chat`
  MODIFY `chatid` int(11) NOT NULL AUTO_INCREMENT;


-- AUTO_INCREMENT de la tabla `chat_login_details`
ALTER TABLE `chat_login_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;


CREATE TABLE tareas_asignadas (
  -- UNSIGNED sirve para permitir solo valores positivos (sin signo)
  id INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
  nombre_tarea VARCHAR(30) NOT NULL,
  id_usuario INT(12) NOT NULL,
  descripcion_tarea VARCHAR(50) NOT NULL,
  importancia_tarea VARCHAR(20)  NOT NULL, 
  estado_tarea varchar(20) NOT NULL,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  fecha_expira VARCHAR(10) NOT NULL,
  hora_expira time,

  update_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  constraint fk_id_usuario foreign KEY (id_usuario)
    REFERENCES employees(id)
);


CREATE TABLE archivos_tareas (
id_archivo  INT(12) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
nombre_archivo varchar(100) not null,
id_tareas int(12) not null,
     constraint fk_id_tares foreign KEY (id_tareas)
    REFERENCES tareas_asignadas(id)

);