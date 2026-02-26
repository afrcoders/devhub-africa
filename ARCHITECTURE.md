# DevHub Africa — Architecture & Technical Overview

## Project Summary

**DevHub Africa** is a developer community platform built to connect African developers with tools, businesses, and opportunities. It features API authentication, social integrations, business directory services, and integrations with external platforms.

---

## Technology Stack

| Layer | Technology |
|-------|------------|
| **Backend Framework** | Laravel 10.x (PHP 8.1+) |
| **Database** | MySQL 8.0 |
| **Caching** | Redis 7 |
| **Queue System** | Laravel Queue with Redis driver |
| **Authentication** | Laravel Sanctum + JWT + OAuth (Socialite) |
| **Web Server** | Nginx (Alpine) |
| **Containerization** | Docker & Docker Compose |
| **PDF Generation** | TCPDF + FPDI |
| **QR Codes** | chillerlan/php-qrcode |
| **Email Validation** | Kickbox API |
| **Code Quality** | Laravel Pint, PHPUnit |

---

## Architecture Patterns

### 1. Service Layer Pattern
Dedicated services handle complex business logic:

- **JWTService** — Custom JWT token generation and validation
- **TokenService** — API token management and refresh
- **EmailVerificationService** — Email verification workflows
- **PasswordResetService** — Secure password reset handling
- **DisposableEmailService** — Detection and blocking of disposable emails
- **RateLimitService** — API rate limiting logic
- **SessionManagerService** — Multi-device session tracking
- **AIContentGenerator** — AI-powered content generation
- **CourseImageService** — Image processing for courses

### 2. Event-Driven Architecture
Leverages Laravel's event system with:
- Custom events for user actions
- Listeners for cross-cutting concerns
- Observers for model lifecycle events

### 3. Policy-Based Authorization
Fine-grained access control using Laravel Policies for resource protection.

### 4. Multi-Domain Models
Organized model structure across different domains:

| Domain | Models |
|--------|--------|
| **Core** | User, Session, AuditLog |
| **Auth** | AuthNonce, LogoutNonce, EmailVerificationToken, PasswordResetToken |
| **Africoders** | Community-specific models |
| **Business** | Business directory models |
| **Community** | Social interaction models |
| **Help** | Support and documentation |

---

## Key Features Implemented

### Authentication & Security
- **Multi-Factor Auth** — Nonce-based verification
- **OAuth Integration** — Social login via Laravel Socialite
- **JWT Tokens** — Stateless API authentication
- **Session Management** — Track and manage active sessions across devices
- **Rate Limiting** — Protect APIs from abuse
- **Audit Logging** — Track all sensitive operations

### Email System
- **Verification Workflow** — Token-based email confirmation
- **Disposable Email Detection** — Block temporary email services
- **Kickbox Integration** — Professional email validation

### External Integrations
- **KortexTools** — SEO and web utility services
- **QR Code Generation** — Dynamic QR codes for profiles/links
- **PDF Generation** — Create downloadable documents

### Developer Features
- **Tool Ratings** — Community ratings for tools
- **Verification System** — Verify developer identities
- **API Access** — RESTful API with rate limiting

---

## Infrastructure

### Docker Services
```
┌─────────────────────────────────────────────────┐
│                 Docker Network                   │
├──────────┬──────────┬──────────┬───────────────┤
│   App    │  Nginx   │  MySQL   │    Redis      │
│ PHP-FPM  │  Proxy   │   8.0    │    7.x        │
├──────────┴──────────┴──────────┴───────────────┤
│              Queue Worker (PHP)                  │
├─────────────────────────────────────────────────┤
│              Mailpit (Dev Email)                 │
└─────────────────────────────────────────────────┘
```

### Background Processing
- Email notifications
- Verification workflows
- Audit log processing
- External API calls

---

## Code Organization

```
app/
├── Contracts/          # Interface definitions
├── Events/             # Custom event classes
├── Jobs/               # Queued job handlers
├── Listeners/          # Event listeners
├── Models/
│   ├── Africoders/     # Platform-specific models
│   ├── Business/       # Business directory
│   ├── Community/      # Social features
│   └── Help/           # Support system
├── Notifications/      # Notification classes
├── Observers/          # Model observers
├── Policies/           # Authorization policies
├── Rules/              # Custom validation rules
├── Services/           # Business logic services
└── Traits/             # Reusable traits
```

---

## Development Practices

- **Contract-Based Design** — Interfaces define service contracts
- **Custom Validation Rules** — Domain-specific validation
- **Reusable Traits** — DRY principle for common functionality
- **Observer Pattern** — Model lifecycle hooks
- **Event Sourcing Basics** — Audit trail for actions

---

## Skills Demonstrated

- **PHP/Laravel** — Advanced authentication flows, custom JWT implementation
- **Security** — Multi-layered security with nonces, rate limiting, audit logs
- **OAuth Integration** — Social authentication with Laravel Socialite
- **API Design** — Secure RESTful APIs with token management
- **Docker/DevOps** — Full containerization with multi-service orchestration
- **Redis** — Session management, caching, and queues
- **Third-Party APIs** — Kickbox email validation, QR code generation
- **Event-Driven Architecture** — Decoupled system design
