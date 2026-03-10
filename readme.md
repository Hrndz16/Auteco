# Base de Datos de Motos 🏍️

Este proyecto contiene un ejemplo simple de una base de datos relacional para gestionar **motos y sus categorías** utilizando SQL.

La estructura incluye dos tablas principales:

* **categoria**: almacena los tipos o categorías de motos.
* **moto**: almacena la información de cada moto y se relaciona con la tabla `categoria`.

---

# Estructura de la Base de Datos

## Tabla `categorias`

Esta tabla almacena las categorías de las motos.

Campos:

* `id_categoria`: identificador único de la categoría (clave primaria).
* `nombre`: nombre de la categoría de moto.

```sql
CREATE TABLE categoria (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);
```

### Insertar categorías

```sql
INSERT INTO categorias (nombre) VALUES
('Deportiva'),
('Scooter'),
('Enduro'),
('Naked'),
('Touring'),
('Custom');
```

---

## Tabla `motos`

Esta tabla almacena la información de las motos.

Campos:

* `id_moto`: identificador único de la moto (clave primaria autoincremental).
* `marca`: marca de la moto.
* `modelo`: modelo de la moto.
* `precio`: precio de la moto.
* `id_categoria`: referencia a la categoría de la moto (clave foránea).

```sql
CREATE TABLE motos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    id_categoria INT,
    FOREIGN KEY (id_categoria) REFERENCES categoria(id_categoria)
);
```

---

# Relación entre tablas

La base de datos tiene una relación **uno a muchos**:

```
categoria (1) ---- (N) moto
```

Esto significa que:

* Una **categoría** puede tener muchas **motos**.
* Cada **moto** pertenece a una sola **categoría**.

---

# Ejemplo de inserción de datos

```sql
INSERT INTO motos (marca, modelo, precio, id_categoria) VALUES
('Yamaha', 'R3', 28000000, 1),
('Honda', 'CB 190R', 14500000, 4),
('Suzuki', 'DR 650', 32000000, 3),
('AKT', 'Dynamic Pro', 6500000, 2);
```

---

# Consulta con JOIN

Para obtener las motos junto con su categoría:

```sql
SELECT m.marca, m.modelo, m.precio, c.nombre AS categoria
FROM moto m
JOIN categoria c ON m.id_categoria = c.id_categoria;
```

---

# Tecnologías utilizadas

* SQL
* MySQL / MariaDB
* Git / GitHub

---

# Autor

Proyecto académico para práctica de **bases de datos relacionales y uso de llaves foráneas**.
