# NewsApi

# Setup

####  1. Kindly add following entry in your `/etc/hosts` file:

```bash
127.0.0.1 news_api.localhost
```

####  2. Create docker containers:

```bash
$ docker-compose up -d
```

#### 3. Confirm three running containers for php, nginx:

```bash
$ docker-compose ps 
```

#### 4. Install composer packages:

```bash
$ docker-compose run php composer install 
```
#### 5. Generate  key:

```bash
$ docker-compose run php php arisan key:generate 
```
#### 5. Create Database schema:

```bash
$ docker-compose run php php artisan migrate 

```

#### 6. Seed data is Database:

```bash
$ docker-compose run php php artisan db:seed
```

#### 7. Run testcases:
```bash
$ docker-compose run php php artisan test
```

Application logs can be found on following locations:
```bash
  logs/nginx
  application/storage/logs
```
