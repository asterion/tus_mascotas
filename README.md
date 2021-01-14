# Install

## Clonar repositorio

```
git clone git@github.com:asterion/tus_mascotas.git
```

## Instalar bibliotecas

*En el directorio del proyecto**

```
composer install
```

### Solo si se desea modificar css

*En el directorio del proyecto**

```
yarn install
```

## Base de datos

**Configurar app/config/parameters.yml con la conexion a su base de datos**

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
