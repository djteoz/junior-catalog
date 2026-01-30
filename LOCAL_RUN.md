# How to run locally (development)

Quick start using Docker Compose (recommended):

```bash
# build and start containers
docker compose up --build -d

# run migrations
docker compose exec app php artisan migrate --force

# seed sample data (admin user, categories, products)
docker compose exec app php artisan db:seed --class=DatabaseSeeder --force

# build frontend assets (optional, development server also available)
docker compose exec node npm ci --silent
docker compose exec node npm run build --silent

# open app in browser (default nginx config)
http://localhost
```

Admin credentials (seeded):

- Email: admin@example.com
- Password: password

Notes:

- The app uses PostgreSQL by default (check `.env` or `.env.example` for DB settings).
- For production deployment see `DEPLOY.md` and `docker-compose.prod.yml`.
