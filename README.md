# Prueba Técnica Fidelizador

## Proyecto

Codigo en github [Tus mascotas](https://github.com/asterion/tus_mascotas) con rama principal **main** y rama desarollo **develop**

## Software requerido

|PHP|7.4.3|
|----|-----|
|Symfony|3.4.35|
|MariaDB|10.3.25|
|Bootstrap|v4.5.3|
|GIT|2.25.1|

## Requerimientos del proyecto

- [x] Login con security.yml, usuarios en memoria y form para login.
- [x] Crear mascota.
- [x] Editor de mascotas.
- [x] Eliminar con confirmación
- [x] Buscador por chip, nombre y RUT.
- [x] Endpoint REST /api/pet/{chip}
- [x] Base de datos normalizada: pet y human tablas.
- [x] Datepicker con bootstrap-datepicker para fecha de nacimiento
- [x] Decidí no usar SQL Nativo para el proyecto. Dejo ejemplos en el README para demostrar conocimiento.
- [x] La próxima versión tendrá un paginador para los listados.

## SQL Nativo

Cantidad de mascotas por RUT.

```
SELECT h.rut, COUNT(*) AS qty FROM human h, pet p WHERE h.id = p.human_id GROUP BY h.rut
```

Cantidad de mascotas por raza y sexo.

```
SELECT p.kind, p.gender, COUNT(*) AS qty FROM pet p GROUP BY p.kind, p.gender
```

Listado de humano asociado a mascota

```
SELECT CONCAT(h.firstname, ' ', h.lastname) AS human, p.firstname AS pet FROM human h JOIN pet p ON h.id = p.human_id ORDER BY h.firstname;
```

# Instalar

## Clonar repositorio

```
git clone git@github.com:asterion/tus_mascotas.git
```

## Instalar bibliotecas

*En el directorio del proyecto*

```
composer install
```

### Solo si se desea modificar css

*En el directorio del proyecto*

```
yarn install
```

## Base de datos

**Configurar app/config/parameters.yml con la conexión a su base de datos**

**En el directorio del proyecto**

Para crear la base de datos

```
php bin/console d:d:c
```

Para crear las tablas

```
php bin/console doctrine:schema:update
```

Para cargar datos de pruebas

```
php bin/console doctrine:fixtures:load -n
```

## Probar

**Correr servidor de pruebas**

```
php bin/console server:run
```

**Acceder a http://127.0.0.1:8000 o similiar que indico el comando anterior**

## Api Rest

**endpoint GET /api/pet/{chip}**
