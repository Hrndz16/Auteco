# Base de Datos de Motos

Proyecto PHP sencillo para gestionar motos y categorias con operaciones CRUD y una interfaz basada en Bootstrap.

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
|-- includes/
|-- views/
|   |-- modals/
|   `-- sections/
|-- index.php
`-- readme.md
```

## Que hace cada carpeta

- `actions/`: endpoints que reciben las peticiones `fetch` del frontend.
- `assets/`: archivos estaticos como estilos y JavaScript.
- `config/`: configuracion de conexion a la base de datos.
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
