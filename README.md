# PHP Docker

A simple starter kit to run php-mysql with Docker.

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
   ```bash
   git clone https://github.com/raflizocky/php-docker.git
   cd php-docker
   ```

2. Copy the environment example file:
   ```bash
   cp .env.example .env
   ```

3. Start the containers:
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

## License

Code released under the [MIT License](https://github.com/raflizocky/e-voting/blob/main/LICENSE). Attribution appreciated.