# ChawkBazar Full-Stack E-Commerce Project Analysis

## 📊 Project Overview

ChawkBazar is a full-stack multivendor e-commerce platform built with:

- **Backend**: Laravel REST API
- **Frontend**: Two separate Next.js applications (Admin Dashboard + Customer Shop)
- **Architecture**: Monorepo setup with Yarn workspaces

## 🛠️ Technology Stack & Versions

### Backend (Laravel API)

| Technology | Version | Purpose |
|------------|---------|---------|
| PHP | 8.0/8.1 | Runtime |
| Laravel Framework | 10.30.1 | Backend framework |
| Composer | Latest | Dependency management |
| Guzzle | 7.8.0 | HTTP client |
| Laravel Socialite | 5.10.0 | OAuth authentication |
| Laravel Tinker | 2.8.2 | REPL |
| DomPDF | 2.0.1 | PDF generation |
| Doctrine DBAL | 3.7.1 | Database abstraction |
| Stevebauman/Purify | 6.0.2 | HTML sanitization |

**Development Dependencies:**
- PHPUnit 10.0.13 (Testing)
- Laravel Sail 1.21.0 (Docker environment)
- Faker 1.21.0 (Data seeding)
- Spatie Ignition 2.0.0 (Error pages)

**Payment Integrations:**
- Laravel Bkash Tokenize
- Laravel Rave (Flutterwave)
- Messagebird (SMS)

### Frontend - Admin Dashboard

| Technology | Version | Purpose |
|------------|---------|---------|
| Next.js | 13.5.6 | React framework |
| React | 18.3.1 | UI library |
| TypeScript | 5.6.3 | Type safety |
| Tailwind CSS | 3.4.14 | Styling |
| React Query | 3.39.3 | Server state management |
| Jotai | 2.10.1 | Client state management |
| React Hook Form | 7.53.1 | Form handling |
| Yup | 1.4.0 | Validation |
| Axios | 1.7.7 | HTTP client |
| ApexCharts | 3.44.0 | Data visualization |
| i18next | 23.16.4 | Internationalization |
| Framer Motion | 10.16.4 | Animations |

**Key Features:**
- Rich text editor (React Quill)
- Google Maps integration
- Image uploads (React Dropzone)
- Data tables (rc-table)
- Charts and analytics
- RTL support

**Dev Server**: Port 3002

### Frontend - Customer Shop

| Technology | Version | Purpose |
|------------|---------|---------|
| Next.js | 14.0.3 | React framework (newer) |
| React | 18.3.1 | UI library |
| TypeScript | 5.3.2 | Type safety |
| Tailwind CSS | 3.4.14 | Styling |
| React Query | 3.39.3 | Server state management |
| Jotai | 2.10.1 | Client state management |
| Next Auth | 4.24.10 | Authentication |
| Stripe | 2.2.0 / 2.8.1 | Payment processing |
| React Hook Form | 7.53.1 | Form handling |
| i18next | 23.16.4 | Internationalization |

**Key Features:**
- Payment integration (Stripe)
- Social sharing
- Product reviews/ratings
- Video player
- OTP input
- Mailchimp integration
- PWA support

**Dev Server**: Port 3003

## 📁 Current Folder Structure

```
chawkbazar-laravel/
├── 📦 package.json              # Root monorepo config
├── 🔧 babel.config.js
├── 🐕 .husky/                   # Git hooks
├── 📜 install.sh
│
├── 🎨 admin/                    # Admin Dashboard Frontend
│   └── rest/
│       ├── package.json
│       ├── next.config.js
│       ├── tailwind.config.js
│       ├── tsconfig.json
│       ├── public/
│       └── src/
│           ├── assets/
│           ├── components/      # (727 files)
│           ├── config/
│           ├── contexts/
│           ├── data/
│           ├── lib/
│           ├── pages/           # (163 files)
│           ├── settings/
│           ├── types/
│           └── utils/
│
├── 🛒 shop/                     # Customer Shop Frontend
│   ├── package.json
│   ├── next.config.js
│   ├── tailwind.config.js
│   ├── tsconfig.json
│   ├── public/
│   └── src/
│       ├── assets/
│       ├── components/          # (381 files)
│       ├── containers/
│       ├── contexts/
│       ├── data/
│       ├── framework/           # API integration
│       ├── lib/
│       ├── pages/               # (52 files)
│       ├── providers/
│       ├── settings/
│       ├── store/
│       ├── styles/
│       ├── types/
│       └── utils/
│
└── 🔌 chawkbazar-api/          # Laravel Backend
    ├── composer.json
    ├── package.json
    ├── artisan
    ├── docker-compose.yml
    ├── Dockerfile
    ├── webpack.mix.js
    ├── phpunit.xml
    ├── app/
    │   ├── Console/
    │   ├── Exceptions/
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   ├── Middleware/
    │   │   └── ...
    │   ├── Models/
    │   └── Providers/
    ├── bootstrap/
    ├── config/
    ├── database/
    │   ├── factories/
    │   ├── migrations/
    │   └── seeders/
    ├── lang/
    ├── packages/
    │   └── marvel/              # Custom package
    ├── public/
    ├── resources/
    ├── routes/
    │   ├── api.php
    │   ├── web.php
    │   ├── channels.php
    │   └── console.php
    ├── storage/
    └── tests/
```

## 🔄 How to Split Into Separate Repositories

### Strategy Overview

Split the monorepo into 3 independent repositories:

1. **chawkbazar-backend** (Laravel API)
2. **chawkbazar-admin** (Next.js Admin)
3. **chawkbazar-shop** (Next.js Shop)

## 📋 Detailed Migration Guide

### 1️⃣ Backend Repository Setup

#### Create New Repository
```bash
# Create new directory
mkdir chawkbazar-backend
cd chawkbazar-backend

# Initialize git
git init
```

#### Copy Backend Files
```bash
# Copy all Laravel files from chawkbazar-api/
cp -r /path/to/chawkbazar-laravel/chawkbazar-api/* .
cp /path/to/chawkbazar-laravel/chawkbazar-api/.* .
```

#### Backend Structure
```
chawkbazar-backend/
├── .env.example
├── .gitignore
├── composer.json
├── artisan
├── docker-compose.yml
├── Dockerfile
├── phpunit.xml
├── app/
├── bootstrap/
├── config/
├── database/
├── lang/
├── packages/
├── public/
├── resources/
├── routes/
├── storage/
└── tests/
```

#### Update Configuration

✅ Update `.env.example` with all required variables  
✅ Configure CORS settings in `config/cors.php`  
✅ Update `APP_URL` to backend domain  
✅ Set up allowed origins for frontend domains

**CORS Configuration Example:**

```php
// config/cors.php
'allowed_origins' => [
    env('ADMIN_URL', 'http://localhost:3002'),
    env('SHOP_URL', 'http://localhost:3003'),
],
```

#### Create README.md
```markdown
# ChawkBazar Backend API
Laravel 10 REST API for ChawkBazar E-commerce Platform

## Requirements
- PHP 8.0+
- Composer
- MySQL/PostgreSQL
- Redis (optional)

## Installation
1. composer install
2. cp .env.example .env
3. php artisan key:generate
4. php artisan migrate --seed
5. php artisan serve

## Documentation
API Documentation: /api/documentation
```

### 2️⃣ Admin Frontend Repository

#### Create New Repository
```bash
mkdir chawkbazar-admin
cd chawkbazar-admin
git init
```

#### Copy Admin Files
```bash
# Copy from admin/rest/
cp -r /path/to/chawkbazar-laravel/admin/rest/* .
cp /path/to/chawkbazar-laravel/admin/rest/.* .
```

#### Admin Structure
```
chawkbazar-admin/
├── .env.template → .env.example
├── .gitignore
├── package.json
├── next.config.js
├── tailwind.config.js
├── tsconfig.json
├── postcss.config.js
├── prettier.config.js
├── public/
└── src/
    ├── components/
    ├── pages/
    ├── utils/
    ├── config/
    └── ...
```

#### Update Configuration Files

**package.json** - Remove workspace reference:

```json
{
  "name": "chawkbazar-admin",
  "version": "6.8.0",
  "private": true,
  "scripts": {
    "dev": "next dev -p 3002",
    "build": "next build",
    "start": "next start -p 3002",
    "lint": "next lint"
  }
}
```

**.env.example** - Add API configuration:

```env
NEXT_PUBLIC_API_URL=http://localhost:8000/api
NEXT_PUBLIC_ADMIN_URL=http://localhost:3002
NEXT_PUBLIC_SHOP_URL=http://localhost:3003
```

**Update API configuration in `src/config/`:**

```typescript
// src/config/api.ts
export const API_BASE_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api';
```

#### Create README.md
```markdown
# ChawkBazar Admin Dashboard
Next.js 13 admin panel for managing the e-commerce platform

## Requirements
- Node.js 18+
- Yarn or npm

## Installation
1. yarn install
2. cp .env.template .env
3. Update API endpoint in .env
4. yarn dev

## Tech Stack
- Next.js 13.5.6
- React 18
- TypeScript
- Tailwind CSS
- React Query
```

### 3️⃣ Shop Frontend Repository

#### Create New Repository
```bash
mkdir chawkbazar-shop
cd chawkbazar-shop
git init
```

#### Copy Shop Files
```bash
# Copy from shop/
cp -r /path/to/chawkbazar-laravel/shop/* .
cp /path/to/chawkbazar-laravel/shop/.* .
```

#### Shop Structure
```
chawkbazar-shop/
├── .env.template → .env.example
├── .gitignore
├── package.json
├── next.config.js
├── tailwind.config.js
├── tsconfig.json
├── public/
└── src/
    ├── components/
    ├── pages/
    ├── framework/        # API integration
    ├── lib/
    └── ...
```

#### Update Configuration

**package.json:**

```json
{
  "name": "chawkbazar-shop",
  "version": "6.8.0",
  "private": true,
  "scripts": {
    "dev": "next dev -p 3003",
    "build": "next build",
    "start": "next start -p 3003"
  }
}
```

**.env.example:**

```env
NEXT_PUBLIC_API_URL=http://localhost:8000/api
NEXT_PUBLIC_SHOP_URL=http://localhost:3003
NEXTAUTH_URL=http://localhost:3003
NEXTAUTH_SECRET=your-secret-key

# Stripe
NEXT_PUBLIC_STRIPE_PUBLISHABLE_KEY=
STRIPE_SECRET_KEY=

# Google OAuth
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=

# Facebook OAuth
FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
```

#### Create README.md
```markdown
# ChawkBazar Shop
Next.js 14 customer-facing e-commerce storefront

## Requirements
- Node.js 18+
- Yarn or npm

## Installation
1. yarn install
2. cp .env.template .env
3. Configure API endpoint and auth settings
4. yarn dev

## Tech Stack
- Next.js 14
- React 18
- TypeScript
- Tailwind CSS
- NextAuth.js
- Stripe
```

## 🔧 Configuration Updates Needed

### Backend Configuration

**1. CORS Settings (config/cors.php):**

```php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => explode(',', env('ALLOWED_ORIGINS', 'http://localhost:3002,http://localhost:3003')),
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```

**2. Environment Variables (.env):**

```env
APP_URL=http://localhost:8000
ADMIN_URL=http://localhost:3002
SHOP_URL=http://localhost:3003
ALLOWED_ORIGINS=http://localhost:3002,http://localhost:3003

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chawkbazar
DB_USERNAME=root
DB_PASSWORD=

# Session & Auth
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Mail
MAIL_MAILER=smtp
```

### Frontend Configuration (Both Admin & Shop)

**API Service Pattern:**

```typescript
// src/framework/rest/client/api.ts
import axios from 'axios';

const API_URL = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api';

export const httpClient = axios.create({
  baseURL: API_URL,
  timeout: 30000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
  withCredentials: true, // Important for CORS with credentials
});

// Add auth token interceptor
httpClient.interceptors.request.use((config) => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});
```

## 🚀 Development Workflow

### Running All Services Locally

**Terminal 1 - Backend:**

```bash
cd chawkbazar-backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
# Runs on http://localhost:8000
```

**Terminal 2 - Admin:**

```bash
cd chawkbazar-admin
yarn install
cp .env.template .env
yarn dev
# Runs on http://localhost:3002
```

**Terminal 3 - Shop:**

```bash
cd chawkbazar-shop
yarn install
cp .env.template .env
yarn dev
# Runs on http://localhost:3003
```

## 📦 Deployment Considerations

### Backend Deployment

- **Hosting**: VPS, AWS EC2, DigitalOcean, Laravel Forge
- **Requirements**: PHP 8.0+, MySQL/PostgreSQL, Redis
- **Environment**: Production .env with secure credentials
- **Commands**:
  ```bash
  composer install --optimize-autoloader --no-dev
  php artisan config:cache
  php artisan route:cache
  php artisan migrate --force
  ```

### Frontend Deployment (Admin & Shop)

- **Hosting**: Vercel, Netlify, AWS Amplify, DigitalOcean App Platform
- **Environment Variables**: Configure in hosting provider
- **Build Commands**:
  ```bash
  yarn build
  yarn start
  ```
- **Vercel Config** (`vercel.json` already exists)

## 🔐 Important Security Considerations

**After Split:**

✅ Update CORS origins to production domains  
✅ Enable HTTPS for all services  
✅ Secure API keys - Never commit to git  
✅ Use environment variables for all secrets  
✅ Enable rate limiting on API  
✅ Configure CSP headers  
✅ Set secure cookie flags (httpOnly, secure, sameSite)

## 🗂️ Git Migration Strategy

### Option 1: Fresh Start (Recommended)

```bash
# Create 3 new repos on GitHub/GitLab
# Copy files as shown above
# Initialize and push separately
```

### Option 2: Preserve Git History

```bash
# Use git filter-branch or git subtree to split history
# More complex but preserves commit history
git subtree split -P chawkbazar-api -b backend-branch
# Create new repo and push backend-branch
```

## 📊 Summary Table

| Aspect | Current Monorepo | After Split |
|--------|------------------|-------------|
| Structure | Single repo with workspaces | 3 independent repos |
| Dependencies | Shared via workspace | Independent |
| Deployment | Complex monorepo deploy | Simple per-service deploy |
| CI/CD | Single pipeline | 3 separate pipelines |
| Versioning | Shared version | Independent versions |
| Team Work | Single repo permissions | Granular permissions |
| Development | Yarn workspaces | Independent install |

## 🎯 Benefits of Separation

✅ **Independent Deployment** - Deploy frontend/backend separately  
✅ **Clear Boundaries** - Better separation of concerns  
✅ **Team Autonomy** - Frontend/backend teams work independently  
✅ **Flexible Scaling** - Scale services independently  
✅ **Simplified CI/CD** - Separate pipelines per service  
✅ **Technology Freedom** - Easier to upgrade independently  
✅ **Security** - Better access control per repository

## ⚠️ Challenges to Address

🔸 **API Versioning** - Need clear API versioning strategy  
🔸 **Shared Types** - Consider NPM package for shared TypeScript types  
🔸 **Documentation** - Keep API docs in sync  
🔸 **Testing** - Integration tests across services  
🔸 **Local Development** - Docker Compose recommended  
🔸 **Environment Management** - More env files to manage

## 🐳 Docker Compose for Local Development

Create `docker-compose.yml` in a separate repo:

```yaml
version: '3.8'
services:
  backend:
    build: ./chawkbazar-backend
    ports:
      - "8000:8000"
    environment:
      - DB_HOST=db
    depends_on:
      - db
  
  admin:
    build: ./chawkbazar-admin
    ports:
      - "3002:3002"
    environment:
      - NEXT_PUBLIC_API_URL=http://localhost:8000/api
  
  shop:
    build: ./chawkbazar-shop
    ports:
      - "3003:3003"
    environment:
      - NEXT_PUBLIC_API_URL=http://localhost:8000/api
  
  db:
    image: mysql:8
    environment:
      MYSQL_DATABASE: chawkbazar
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

## 📝 Next Steps Checklist

- [ ] Backup current monorepo
- [ ] Create 3 new Git repositories
- [ ] Copy files to respective repos
- [ ] Update all configuration files
- [ ] Update environment variable templates
- [ ] Test API connectivity from frontends
- [ ] Update CORS configuration
- [ ] Create comprehensive READMEs
- [ ] Set up CI/CD pipelines
- [ ] Configure deployment environments
- [ ] Update DNS/domain configurations
- [ ] Migrate existing data/database
- [ ] Test authentication flow
- [ ] Test payment integrations
- [ ] Document API endpoints
- [ ] Train team on new structure

## 🆘 Need Help?

Feel free to ask for specific guidance on:

- Setting up specific configurations
- Creating migration scripts
- Docker compose setup
- CI/CD pipeline configuration
- API documentation
- Any other questions!
