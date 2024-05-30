# Aszende tech test
(no escribo en castellano porquè soy un desastre con los acentos, lol)
#### This project has been written and directed by Augusto Lamona for Aszende
## project can be found at http://localhost:8080/

### Project main feature:

- Symfony 6.1.2
- PHPUnit
- cs-fixer
- phpstan

## Provisioning

To ease local development you have to install these tools:

* [Docker CE](https://www.docker.com/) - At least version 18.06.0
* [Docker-Compose](https://docs.docker.com/compose/)

**Note**: It is recommended to follow [this guide](https://docs.docker.com/install/linux/linux-postinstall/#manage-docker-as-a-non-root-user) in order to manage Docker as a non-root user.

In the project's root folder there is the main file where the architecture is described: `docker-compose.yml`.
In there you can find all services configured that you'll get.
In order to have everything work correctly you have to copy the `.env.dist` file to the `.env`.
The latter holds all the environment variables used by docker-compose to run all the containers.

The Make file has several commands to easily access project's functionalities. How to setup the project:

- run make setup for project building
- run make phpunit to run the tests

This simple tests just calls an endpoint and fetches the users.





