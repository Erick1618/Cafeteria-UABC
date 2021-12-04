# Cafeteria UABC

_Aplicacion para la cafeteria de UABC Sauzal (Lado de administrador compleatado)_

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

_Ahora necesitaremos un certificado_
Descargar el certificado mas reciente de la pagina
```
https://curl.se/docs/caextract.html
```

_Guardarlo en:_ 
```
C:\wamp64\bin\php\php7.4.9
```
_Que es la direccion de la version de PHP que usaremos en este proyecto_

_Despues en C:\wamp64\bin\php\php7.4.9 buscaremos el archivo php.ini_
_En este archivo buscaremos los campos [curl] y [openssl], e ingresamos la direccion de donde guardamos nuestro certificado_

```
[curl]
curl.cainfo = "C:\wamp64\bin\php\php7.4.9\extras\ssl\cacert-2021-10-26.pem"

[openssl]
openssl.cafile = "C:\wamp64\bin\php\php7.4.9\extras\ssl\cacert-2021-10-26.pem"
```

_Con todo esto, ya tenemos todo listo para correr el lado de administrador del proyecto en nuestro virtual host_



# VERSION 1.1

## Cambios
### (Mas informacion y detalle de los cambios en la seccion de [Detalles](#Detalles))

***
* Eliminacion del menú rotativo
***
> Se eliminaron los CRUD de menu rotativo del lado de administrador, a la par que la visualizacion del menu rotativo del lado de "Ver menu".
!![Cambio1](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/8.JPG)
!![Cambio1](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/11.JPG)

***
* Categoria y visualizacion del menu en una sola pestaña
***
> Ahora en el apartado de "Productos" (Anteriormente llamado "Platillos") podemos seleccionar categoria del producto y decidir si queremos mostrar u ocularla en la vista del menu.
!![Cambio2](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/9.JPG)
!![Cambio3](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/10.JPG)

***
* Carrito de compras (Pedidos)
***
> El apartado de pedidos ahora es funcional, hace el calculo del total por productos y da la opcion de eliminar un conjunto completo de un mismo tipo de producto.
!![Cambio2](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/12.JPG)

***
* Boton de paypal
***
> Se agrego el boton de paypal que redirecciona a la aplicacion de paypal para proceder al pego mediante la aplicacion.
!![Cambio2](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/13.JPG)
!![Cambio2](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/14.JPG)
!![Cambio2](https://github.com/Erick1618/Cafeteria-UABC/blob/pruebas/img/readme/15.JPG)
> Detalles sobre como usar esta funcionalidad en [Detalles](#Detalles)

## Errores y correcciones

#### Administracion de empleados
***
* Se resolvio el error que permitia crear empleados con correos que no fueran gmail o uabc.edu.mx
* Se resolvio el error que permitia tener mas de una cuenta de usuario con el mismo correo
***

#### Creacion de productos
***
* Ahora, al momento de crear o editar un producto, todos los campos son obligatorios
* Se cambio el nombre de la tabla de "platillos" a "productos"
* Cada que se crea o edita un producto, se requerira de una confirmacion para proceder a guardar los cambios
***

#### Vista menu
***
* Se resolvio el error que no permitia al administrador ni a los empleados volver a la seccion de administracion si estaban dentro de una categoria
* Se arreglaron los hipervinculos que redireccionaban a direcciones incorrecta y/o no existentes
***

## Detalles
***
* Se tomo la decision de la eliminacion del menu rotativo, ya que no se uso en el proyecto
* Las categorias de los productos solo pueden ser cambiadas si precionamos el boton de editar, no como en la version anterior donde en la seccion "Menu" se podian cambiar categorias directamente desde un dropdown list
* La visibilidad de los productos que se muestran en el menu estan definidas por los ultimos botones con el icono de un ojo, si el iocno tiene un ojo abierto, significa que el producto esta visible en el menu, si el icono tiene un ojo con un slash, significa que el producto no esta visible en el menu
* Cuando nosotros seleccionamos un producto del menu, se refrescara la pagina y saldra una alerta que nos dara la opcion de ir a la seccion de "Pedidos"
* Al presionar el boton de "Quitar", eliminaremos de la tabla de pedidos el conjunto de productos que seleccionamos
* IMPORTANTE: Para proceder al pago de esta aplicacion, se esta usando SandBox de Paypal, son cuentas con $50,000 para hacer la pruebas necesarias, el correo de la cuenta personal que hace las compras es "sb-7jecm8804711@personal.example.com" y la contraseña es "s*[qTs74"
* No puedo otorgar los detalles de la cuenta donde se reciben estos pagos ya que estan asociados a mi cuenta personal de PayPal. De necesitar pruebas de que los pagos estan pasando, comunicarse conmigo por Discord en el canal de "Desarrollo"
***