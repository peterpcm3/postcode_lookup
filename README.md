# Uk postcode lookup
Import all uk postcodes and look for nearest post code by location

## Install instructions

### Build and start docker containers

- cd docker
- docker-compose up --build -d
- docker exec -it php-fpm bin/console doctrine:migrations:migrate

### Access to main route
http://{baseurl}/