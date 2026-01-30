# Deploy

This repository includes `docker-compose.prod.yml` and an example GitHub Actions workflow to build and publish a Docker image to Docker Hub.

Manual deploy (example):

```bash
# build image locally
docker build -t your-dockerhub-username/junior-catalog:latest .

# push to Docker Hub
docker push your-dockerhub-username/junior-catalog:latest

# on the server: pull and run using the included compose
docker pull your-dockerhub-username/junior-catalog:latest
docker compose -f docker-compose.prod.yml up -d --force-recreate
```

GitHub Actions (CD) notes:

1. Create Docker Hub repository `your-dockerhub-username/junior-catalog`.
2. In GitHub repository Settings -> Secrets, add `DOCKERHUB_USERNAME` and `DOCKERHUB_TOKEN`.
3. The workflow `.github/workflows/cd.yml` will build and push the image on pushes to `main`.

Security & tips:

- Do not commit production `.env`. Use GitHub Secrets or a vault for production env vars.
- Consider using GHCR (GitHub Container Registry) if you prefer a GitHub-native registry; adapt the workflow accordingly.
-- For production, ensure `APP_ENV=production`, `APP_DEBUG=false`, and `APP_KEY` is set.

## CORS & Sanctum

- In `config/cors.php` the app now reads `CORS_ALLOWED_ORIGINS` (or `FRONTEND_URL`) from the environment. Set this to your frontend host(s) in production (comma-separated).
- If you use Laravel Sanctum with cookie-based auth, set `CORS_SUPPORTS_CREDENTIALS=true` and configure `SANCTUM_STATEFUL_DOMAINS` and `SESSION_DOMAIN` accordingly.

## Performance notes

- Vite is configured to extract `node_modules` into a `vendor` chunk to reduce the main bundle size. You can further split large features using dynamic `import()` in Vue components.
- The build will warn on large chunks; consider code-splitting or lazy-loading admin pages.
