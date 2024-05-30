# Prueba Técnica de Aszende

Este proyecto ha sido escrito y dirigido por Augusto Lamona para Aszende. Puedes encontrar el proyecto en [http://localhost:8080/](http://localhost:8080/).

## Característica Principal del Proyecto:

- Symfony 6.1.2
- PHPUnit
- cs-fixer
- phpstan

## Provisionamiento

Para facilitar el desarrollo local, es necesario instalar las siguientes herramientas:

- [Docker CE](https://www.docker.com/) - Al menos la versión 18.06.0
- [Docker-Compose](https://docs.docker.com/compose/)

**Nota**: Se recomienda seguir [esta guía](https://docs.docker.com/install/linux/linux-postinstall/#manage-docker-as-a-non-root-user) para gestionar Docker como un usuario no administrador.

En la carpeta raíz del proyecto se encuentra el archivo principal `docker-compose.yml`, donde se describe la arquitectura. Aquí puedes encontrar todos los servicios configurados que obtendrás. Para que todo funcione correctamente debes copiar el archivo `.env.dist` al `.env`, el cual contiene todas las variables de entorno utilizadas por docker-compose para ejecutar todos los contenedores.

### Configuración del Proyecto:

- Ejecuta `make setup` para construir el proyecto.
- Ejecuta `make phpunit` para correr las pruebas.

Las pruebas simplemente realizan una llamada a un endpoint y obtienen los usuarios.
