# Cafeteria UABC

_Aplicación para la cafeteria de UABC Sauzal, donde encontrarás el menú de la cafetería con precios especiales, comidas del día, el encargado de la cafetería o empleados podrán actualizar dicho menú tanto precios como las comidas, también se quiere implementar un sistema de cashback para cuando el cliente haga una compra genere un código QR y el empleado lo escaneara y le generará puntos de compra al cliente, tambien se podran hacer pedidos a domicilio unicamente dentro de la universidad junto con un chat para estar en contacto con el cliente por cualquier cosa, en sí solo existirán 2 roles, empleados y clientes en donde solo se puedan loguear con correo institucional UABC._

## Integrantes del equipo

- Jonathan Aviña Aviña 

- Erick Augusto Olachea Ortega

- Erick Gabriel Santiago Suenaga

- Joel Ernesto Lopez Verdugo

- Osmar Francisco Higuera Mendoza

- Maria Alicia Zarate Vasquez

- Johann Emanuel Peralta Mendoza

- Jonathan Jared Merlin Olmedo

## Comenzando con el proyecto

_Para poder hacer las pruebas, se requiere de un servidor web Apache, en lo personal, recomiendo WampServer._
```
https://wampserver.uptodown.com/windows
```

### Instalación 

_La version mas estable del proyecto es la de la rama de Pruebas, recomiento usar git para la clonacion del repositorio_
_Para clonar el repositorio usaremos_
```
git clone --branch pruebas https://github.com/Erick1618/Cafeteria-UABC.git
```
_o_
```
git clone -b pruebas https://github.com/Erick1618/Cafeteria-UABC.git
```

_Ya descargado el repositorio, crearemos un VirtualHost en Wampserver_
!![wampserver1](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/1.JPG)

_Accederemos al localhost y en la seccion de tools seleccionaremos "Add a Virtual Host"_
!![wampserver2](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/2.JPG)

_Una vez dentro, ingresaremos en el primer input "cafeteria-prueba.com"_
_En el segundo input la direccion de la carpeta en la que se encuentra el repositorio_
_Y por ultimo solo daremos click en "Start the creation of the VirtualHost"_
!![wampserver3](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/3.JPG)

_Para poder accerder a el virtual host, necesitamos reiniciar los DNS_
_Para ello, damos secundario en el simbolo de WampServer, seccion Tools y "Restart DNS"_
!![wampserver4](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/4.JPG)

_Ahora necesitamos la base de datos_
_De nuevo en LocalHost, ahora necesitamos acceder a phpMyAdmin_
!![DataBase1](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/5.JPG)

_Iniciamos sesion con root en MySql_
!![DataBase2](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/6.JPG)

_Una vez adentro del PhpMyAdmin, accedemos a SQL_
!![DataBase3](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/7.JPG)

_Ingresamos la siguiente sentencia SQL_

```

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(100) NOT NULL,
  `correo_cliente` varchar(255) NOT NULL,
  `puntos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `correo_cliente`, `puntos`) VALUES
(1, 'Joel Ernesto Lopez Verdugo', 'joel.ernesto.lopez.verdugo@uabc.edu.mx', 0);

DROP TABLE IF EXISTS `comida`;
CREATE TABLE IF NOT EXISTS `comida` (
  `id_platillo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_platillo` varchar(100) NOT NULL,
  `descripcion_platillo` varchar(255) DEFAULT NULL,
  `foto_platillo` longblob NOT NULL,
  `tipo_platillo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_platillo`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO `comida` (`id_platillo`, `nombre_platillo`, `descripcion_platillo`, `foto_platillo`, `tipo_platillo`) VALUES
(4, 'PECHUGAS DE POLLO A LA CREMA', '', 0x3339323733353932382e6a7067, 0),
(5, 'ALMENDRADO', '', 0x3736333231323531372e6a7067, 0),
(6, 'ARROZ TRES DELICIAS', '', 0x3536353835343239352e6a7067, 1),
(7, ' PurÃ© de papa con jamÃ³n', '', 0x3138323535393535312e6a7067, 1),
(8, 'Agua de fresa con coco', '', 0x313238343833343235312e6a7067, 3);

DROP TABLE IF EXISTS `desayuno`;
CREATE TABLE IF NOT EXISTS `desayuno` (
  `id_platillo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_platillo` varchar(90) NOT NULL,
  `descripcion_platillo` varchar(255) DEFAULT NULL,
  `foto_platillo` longblob NOT NULL,
  `tipo_platillo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_platillo`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

INSERT INTO `desayuno` (`id_platillo`, `nombre_platillo`, `descripcion_platillo`, `foto_platillo`, `tipo_platillo`) VALUES
(12, 'Medallones de res con setas a la soya', '', 0x3831333432383431312e6a7067, 0),
(13, 'pechugas de pollo rellenas con tocino y queso', '', 0x3335353334393533312e6a7067, 0),
(14, 'Verduras al gratin', '', 0x313937313234313032362e6a7067, 1),
(15, 'Patatas al horno asadas', '', 0x313138383834323330342e6a7067, 1),
(16, 'Crujiente pan de ajo a la italiana', '', 0x313031313834333931322e6a7067, 2),
(17, 'Aros de cebolla', '', 0x323034393632303935332e6a7067, 2),
(18, 'Cafe', '', 0x313239343031343835362e6a7067, 3),
(19, 'Jugo de naranja', '', 0x313535363437353436372e6a7067, 3);

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE IF NOT EXISTS `empleados` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_empleado` varchar(90) NOT NULL,
  `correo_empleado` varchar(90) NOT NULL,
  `telefono_empleado` varchar(15) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

INSERT INTO `empleados` (`id_empleado`, `nombre_empleado`, `correo_empleado`, `telefono_empleado`, `status`) VALUES
(1, 'LAMINATOTENSEI s', 'laminatotensei@gmail.com', '6151070062', 1),
(10, 'Johann', 'johann.peralta@uabc.edu.mx', '1234567890', 2),
(11, 'Erick Gabriel Santiago Suenaga', 'santiago.erick@uabc.edu.mx', NULL, 1);

DROP TABLE IF EXISTS `menu_rotativo`;
CREATE TABLE IF NOT EXISTS `menu_rotativo` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(90) NOT NULL,
  `precio` int(11) NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `menu_rotativo` (`id_menu`, `menu`, `precio`) VALUES
(1, 'desayuno', 120),
(2, 'comida', 150);

DROP TABLE IF EXISTS `platillos`;
CREATE TABLE IF NOT EXISTS `platillos` (
  `id_platillo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_platillo` varchar(40) NOT NULL,
  `descripcion_platillo` varchar(255) DEFAULT NULL,
  `precio_platillo` decimal(11,0) DEFAULT NULL,
  `categoria_platillo` int(11) DEFAULT NULL,
  `foto_platillo` longblob NOT NULL,
  `mostrar_platillo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_platillo`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

INSERT INTO `platillos` (`id_platillo`, `nombre_platillo`, `descripcion_platillo`, `precio_platillo`, `categoria_platillo`, `foto_platillo`, `mostrar_platillo`) VALUES
(21, 'Sandwich croque madame', '', '40', 3, 0x3438333432363434372e6a7067, 1),
(22, 'Sandwich de miga triple', 'Sandwich de tres pisos de jamon, queso, lechuga y tomate', '25', 3, 0x3437303436383832312e6a7067, 1),
(19, 'Avena', 'Sopero lleno de avena con fresas y frambuesas baÃ±adas en crema', '60', 4, 0x313531393233353031342e6a7067, 1),
(20, 'Sandwich de pavo', 'Sandwich de jamon de pavo con lechuga romana y tomatillos', '35', 3, 0x3737343933343337362e6a7067, 1),
(17, 'Pancakes', 'Pancakes acompaÃ±ados de fresa, platano y crema', '50', 4, 0x313230393434303638352e6a7067, 1),
(18, 'Chilaquiles', 'Chilaquiles servidos con salsa roja, cebolla y un huevo encima', '75', 4, 0x313032313837353836392e6a7067, 1),
(23, ' Sandwich croque monsieur', ' Sandwich de jamon con queso con un huevo frito encima', '40', 3, 0x3833363731383637312e6a7067, 1),
(24, 'Burrito de carne picada', 'Burrito lleno de carne de res picada con salsa bandera', '25', 5, 0x3431343139313731322e6a7067, 1),
(25, 'Burrito de pollo con arroz', 'Burrito lleno de pollo, arroz, lechuga y tomate', '15', 5, 0x313539313336313634312e6a7067, 1),
(26, 'Burritos de pollo con guacamole', 'Burritos de pollo acompaÃ±ados de una porcion de guacamole', '40', 5, 0x323131353035323639352e6a7067, 1),
(27, 'Limonada mineral', 'Limonada mineral con pequeÃ±os trozos de limon y hielo', '15', 2, 0x313239373134353536332e6a7067, 1),
(28, 'horchata de platano y amaranto', 'Cremosa horchata de plÃ¡tano y amaranto, sin lÃ¡cteos ni azÃºcar', '20', 2, 0x3139303136333735352e6a7067, 1),
(29, 'Pastel de las 3 leches con durazno', 'Rebanada de pastel de 3 leches con durazno y frutas encima', '50', 1, 0x313730313333343437332e6a7067, 1),
(30, 'Tacos', 'Son unos tacos de Asada', '15', 4, 0x3935363933373936392e6a7067, 1);
COMMIT;
```

_Con todo esto, ya tenemos todo listo para correr el lado de administrador del proyecto en nuestro virtual host_
