# Otrium Report Generator - API

This project exposes an API where users can generate following two reports.
  
- 7 days turnover per brand (Brand Name, Total turnover (excluding VAT) per day for last 7 days)
- 7 days turnover per day. (Day, total turnover(excluding VAT) per day)

## How to setup
- Clone the project

- Build the project with docker
```shell
docker-compose up -d
```

- Make sure all the containers are up
```shell
CONTAINER ID   IMAGE                   COMMAND                  CREATED        STATUS        PORTS                                                                            NAMES
a5b3040572f4   nginx:alpine            "/docker-entrypoint.…"   18 hours ago   Up 18 hours   0.0.0.0:8000->80/tcp, :::8000->80/tcp, 0.0.0.0:3000->443/tcp, :::3000->443/tcp   otrium-code-challenge_web_1
38c3f5a91c15   phpmyadmin/phpmyadmin   "/docker-entrypoint.…"   18 hours ago   Up 18 hours   0.0.0.0:8080->80/tcp, :::8080->80/tcp                                            phpmyadmin
c95e96f90857   mysql:8.0.21            "docker-entrypoint.s…"   18 hours ago   Up 18 hours   33060/tcp, 0.0.0.0:8989->3306/tcp, :::8989->3306/tcp                             mysql
61c6b115eaca   php-fpm                 "docker-php-entrypoi…"   18 hours ago   Up 18 hours   9000/tcp                                                                         otrium-code-challenge_php_1 
```

- Install composer dependencies
```shell
docker run --rm -v $(pwd)/web/app:/app composer install
```

## How to generate reports 
Send a POST request to `http://localhost:8000/reports` along with `startDate="2018-05-01"` in the request body. 
Then the system will generate above mentioned two reports.

```shell
curl --location --request POST 'http://localhost:8000/reports' \
--form 'startDate="2018-05-01"'
```

### Reports
Generated reports will be saved in the `~/web/reports`

## How to run tests
```shell
docker-compose exec -T php ./app/vendor/bin/phpunit --colors=always --configuration ./app
```