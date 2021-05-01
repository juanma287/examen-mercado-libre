# 🐳 Docker + PHP 7.4 + MySQL + Nginx + Symfony 5.2 

## Descripción

Pila completa para ejecutar Symfony 5.2 en contenedores Docker, usando la herramienta docker-compose.

El proyecto está compuesto por 3 containers:

- `nginx`, servidor web.
- `php`, contenedor PHP-FPM,version 7.4 de PHP.
- `db` contenedor de MySQL, con la imagen **MySQL 8.0**.

## Pasos para la instalación

1. Clonar el repo.

2. Run `docker-compose up -d`

3. Se despliegan 3 containers: 

```
Creating examen-meli_db_1    ... done
Creating examen-meli_php_1   ... done
Creating examen-meli_nginx_1 ... done
```
4. Acceder al container donde se encuentra PHP mediante el comando: 

```
docker exec -it  examen-meli_php_1 bash
```

5.  instalar Symfony mediante el comando: 
```
composer install 
```

6. URL del proyecto NIVEL 1: http://localhost:80/mutant
7. URL del proyecto NIVEL 2: http://localhost:80/api/mutant
8. URL del proyecto NIVEL 3: http://localhost:80/api/stats

## Extras

1. Para correr los test:
- Me conecto al bash en el contenedor PHP en ejecución:
```
docker exec -it  examen-meli_php_1 bash
```
- Ejecuto el comando:

```
php bin/phpunit
```
2. Acceder a la base de datos por consola:
- Me conecto al bash en el contenedor MySQL en ejecución:
```
docker exec -it  examen-meli_db_1 bash
```
- Ejecuto el cliente MySQL desde el contenedor bash MySQL:

```
mysql -utest_user -ptest_ps
```


Good luck 😀