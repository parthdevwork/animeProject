# Clone project from github

```bash
git clone https://github.com/parthdevwork/animeProject.git
```

```bash
cd animeProject
```

# create .env file

```bash
cp .env.example .env
```
# composer update(optional)
```bash

composer update
```


# setup database name in .env

```bash
DB_CONNECTION=mysql
```

```bash
DB_HOST=127.0.0.1
```

```bash
DB_PORT=3306
```

```bash
DB_DATABASE=your_database_name
```

```bash
DB_USERNAME=root
```

```bash
DB_PASSWORD=
```

# Run migration for create Table

```bash
php artisan migrate
```

# Run project

```bash
php artisan serve
```

# Run both API in postman

# Call Anime API and Add data

```bash
 http://127.0.0.1:8000/api/import-anime

```

# Fetch data using slug

```bash
http://127.0.0.1:8000/api/anime/sousou-no-frieren
```
