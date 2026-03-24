# Base de Datos de Motos

Proyecto PHP sencillo para gestionar motos y categorias con operaciones CRUD y una interfaz basada en Bootstrap.

## Ejecutar con Docker

El proyecto puede levantarse con dos contenedores:

- `web`: PHP 8.2 con Apache para servir la pagina.
- `db`: MySQL 8.0 para la base de datos `autecoDB`.

## Requisitos

- Docker
- Docker Compose

## Levantar el proyecto

```bash
docker compose up --build
```

## Accesos

- Aplicacion web: `http://localhost:8080`
- Base de datos MySQL: `localhost:3306`

## Estructura del proyecto

```text
Auteco/
|-- actions/
|   |-- categorias/
|   `-- motos/
|-- assets/
|   |-- css/
|   `-- js/
|-- config/
|-- docker/
|   `-- mysql/
|-- includes/
|-- views/
|   |-- modals/
|   `-- sections/
|-- Dockerfile
|-- docker-compose.yml
|-- index.php
`-- readme.md
```

## Que hace cada carpeta

- `actions/`: endpoints que reciben las peticiones `fetch` del frontend.
- `assets/`: archivos estaticos como estilos y JavaScript.
- `config/`: configuracion de conexion a la base de datos.
- `docker/mysql/init.sql`: crea las tablas al iniciar MySQL por primera vez.
- `includes/`: helpers reutilizables para bootstrap de la app, respuestas JSON y renderizado.
- `views/`: fragmentos de interfaz separados por secciones y modales.

## Tablas principales

### Tabla `categorias`

```sql
CREATE TABLE categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);
```

### Tabla `motos`

```sql
CREATE TABLE motos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);
```

## Flujo general

1. `index.php` carga las motos y categorias necesarias para pintar la vista inicial.
2. `assets/js/app.js` maneja eventos, modales, filtros y peticiones AJAX.
3. `actions/motos/*.php` y `actions/categorias/*.php` procesan cada operacion CRUD.
4. `includes/view_helpers.php` genera filas y opciones reutilizables para mantener la vista consistente.
