# Image Detail Gallery with cms

Create and manage content for a one page web gallery of images with points of interest details.

Add a folder of jpg images to the `projects` folder of the repo and visit index.php to start creating your gallery.


## PHP Docker

Uses PHP Docker as a starting point.
https://github.com/raflizocky/php-docker/tree/main

## Project Structure

```
.
├── docker-compose.yml
├── Dockerfile
├── .env.example
├── README.md
└── src/
    └── index.php
```

## Commands

- Start containers: `docker-compose up -d`
- Stop containers: `docker-compose down -v`
- Rebuild Dockerfile: `docker-compose up -d --build`
- Check db container logs: `docker logs php_db`
- Check container logs: `docker-compose logs -f`

## Setup

1. Clone this repository:

2. Start the containers:
   ```bash
   docker-compose up -d
   ```

## Access

- **PHP**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
  - Root access
    - Server: `db`
    - Username: `root`
    - Password: `rootpassword`
