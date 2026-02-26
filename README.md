<h1 align="center">DevHub Africa</h1>

<p align="center">
  <strong>A developer community platform connecting African developers with tools, businesses, and opportunities</strong>
</p>

<p align="center">
  <a href="#features">Features</a> •
  <a href="#getting-started">Getting Started</a> •
  <a href="#api">API</a> •
  <a href="#contributing">Contributing</a>
</p>

---

## Overview

DevHub Africa is a comprehensive developer community platform built with Laravel. It integrates with external services and tools, providing a unified hub for African developers.

## Features

- **Developer Profiles** — Complete profile management with skills and portfolios
- **Business Directory** — Connect with tech businesses across Africa
- **Tool Integration** — Access to KortexTools SEO and web utilities
- **Community Forums** — Discussion boards and knowledge sharing
- **API Authentication** — Secure API access with rate limiting
- **Email Verification** — Secure account verification system
- **Audit Logging** — Track all important actions
- **OAuth Support** — Social login integration

## Tech Stack

- **Framework:** Laravel 10.x
- **PHP:** 8.2+
- **Database:** MySQL 8.0
- **Cache/Queue:** Redis 7
- **Web Server:** Nginx
- **Containerization:** Docker & Docker Compose

## Getting Started

### Prerequisites

- Docker Desktop
- Git

### Quick Start

```bash
# Clone the repository
git clone https://github.com/dhtml/devhub-africa.git
cd devhub-africa

# Install with Make
make install

# Or manually
cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

Access the application at http://localhost:8080

### Commands

```bash
make dev      # Start development
make down     # Stop containers
make logs     # View logs
make shell    # App shell access
make fresh    # Fresh migration
make test     # Run tests
```

### Environment

```env
APP_NAME=AfricodersPortal
DB_HOST=mysql
DB_DATABASE=africoders
REDIS_HOST=redis
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

## API

### Authentication

```bash
POST /api/auth/login      # Login
POST /api/auth/register   # Register
POST /api/auth/logout     # Logout
```

### Developers

```bash
GET  /api/developers      # List developers
GET  /api/developers/{id} # Get profile
```

### Businesses

```bash
GET  /api/businesses      # List businesses
POST /api/businesses      # Register business
```

## Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing`)
3. Commit changes (`git commit -m 'Add feature'`)
4. Push (`git push origin feature/amazing`)
5. Open Pull Request

## License

MIT License - see [LICENSE](LICENSE)
