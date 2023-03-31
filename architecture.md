# Used technologies
## Backend

 - PHP version: 8.2 FPM
 - Composer version: 2.5.5
 - Database: PostgreSQL
 - Web server: nginx under fast-cgi
 - Adminer
 - Redis
 - RabbitMQ

## Frontend

- ReactJS
- TailwindCSS

# Microservices

## Application architecture
The whole architecture is based on the Docker's networking system. To allow relatively simple communication between them, we have two main services:
- ```ovc-admin``` -> Administration panel and REST API. Here, an adminstrator is allowed to manage all of the resources etc.
- ```ovc-client``` -> User interface application. Here, all of the user's goals are being made. This service, constanstly talks with REST API, to allow CMS to work properely

## Database and caches
In this project, we have database based on PostgreSQL with adminer as database UI management tool. Beacuse, the scale of this application is not as small as I thought it would be, we have
cache system like
- ```OPCache``` -> Caching system for saving precompiled script bytecode in a server’s memory,
- ```Redis``` -> Open source database tooling, that allows for saving data as Key - Value pairs.

For securty purposes, the application database is only served or rather available only in local network space.
The "local network space", in this case is understood as the local docker network system.

I don't want to make it public for each mask available in the network of the "main" host.

## Server Endpoints
- ```localhost:80``` -> User interface ReactJS application
- ```localhost:8080/admin``` -> Administration panel with nginx as reverse proxy
- ```localhost:81``` -> Adminer
- ```127.0.0.1:5432:5432``` -> Local networking for database (in-service communication only)
- ```localhost:6380``` -> Redis
- ```:[4369/tcp, 5671/tcp]``` -> Main proccess of rabbitmq
- ```localhost:5672``` -> GUI management rabbitmq tool