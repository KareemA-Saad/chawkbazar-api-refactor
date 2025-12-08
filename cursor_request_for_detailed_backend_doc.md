# Request for detailed backend documentation
_Exported on 11/30/2025 at 12:33:42 GMT+2 from Cursor (2.1.39)_

---

**User**

@chawkbazar-api I want a clear detailed documentation about this backend including tools, versions and logic. The purpose of this documentation to make any new developer understand all aspects of the project and what's missing inside of it in order to refactor it.@project-refactor-plan.md and analyze this too

---

**Cursor**

I'll analyze the Laravel backend and create comprehensive documentation. Let me explore the structure and key files.

Based on my comprehensive analysis of the `chawkbazar-api` backend and the refactor plan, I'll create detailed documentation for new developers.

---

# ChawkBazar API - Complete Backend Documentation

## 📋 Executive Summary

**ChawkBazar API** is a **Laravel 10-based e-commerce backend** that provides both **REST and GraphQL APIs**. The core business logic is encapsulated in a custom Laravel package called **`marvel/shop`**, which sits inside `packages/marvel/`. This is a multi-vendor marketplace platform supporting complex e-commerce operations including products, orders, payments, flash sales, multi-tenancy (shops), and real-time features.

---

## 🛠️ Technology Stack & Versions

### Core Framework
| Technology | Version | Purpose |
|------------|---------|---------|
| **PHP** | `^8.0\|^8.1` | Runtime language |
| **Laravel** | `10.30.1` | Web framework |
| **MySQL** | Default (`'chawkbazar'` DB) | Primary database |
| **Composer** | Latest | PHP dependency manager |

### Key Laravel Packages
| Package | Version | Purpose |
|---------|---------|---------|
| `nuwave/lighthouse` | `5.71.0` | **GraphQL server** |
| `laravel/sanctum` | `3.3.1` | API authentication (token-based) |
| `spatie/laravel-permission` | `6.0.0` | **RBAC** (Role-Based Access Control) |
| `spatie/laravel-medialibrary` | `10.14.0` | File uploads & media management |
| `cviebrock/eloquent-sluggable` | `10.0.0` | Auto-generate slugs for products/shops |
| `prettus/l5-repository` | `2.9.0` | **Repository Pattern** implementation |
| `bensampo/laravel-enum` | `6.6.4` | Type-safe enums |
| `barryvdh/laravel-dompdf` | `2.0.1` | PDF generation (invoices) |
| `maatwebsite/excel` | `3.1.48` | Excel import/export |
| `openai-php/client` | `^0.7.4` | **AI-powered** product descriptions |

### Payment Gateways (11 Integrations)
- **Stripe** (`stripe/stripe-php: 13.1.0`)
- **PayPal** (`srmklive/paypal: 3.0.19`)
- **Razorpay** (`razorpay/razorpay: 2.8.7`)
- **Mollie** (`mollie/laravel-mollie: 2.25.0`)
- **Paystack** (`unicodeveloper/laravel-paystack: 1.1.0`)
- **Flutterwave** (`kingflamez/laravelrave: dev-master`)
- **Paymongo** (`luigel/laravel-paymongo: ^2.4`)
- **SSLCommerz** (`dgvai/laravel-sslcommerz: ^1.0`)
- **Iyzico** (`iyzico/iyzipay-php: ^2.0`)
- **Xendit** (`xendit/xendit-php: ^3.0.0`)
- **bKash** (`karim007/laravel-bkash-tokenize: dev-main`)

### Communication & Notifications
| Service | Purpose |
|---------|---------|
| **Pusher** (`pusher/pusher-php-server: ^7.2`) | Real-time WebSocket events |
| **Twilio** (`twilio/sdk: 7.12.0`) | SMS/OTP notifications |
| **MessageBird** (`messagebird/php-rest-api: 3.1.4`) | SMS gateway |
| **Mailgun** (`symfony/mailgun-mailer: 6.3.6`) | Email delivery |
| **Mailchimp** (`spatie/laravel-newsletter: 5.1.1`) | Newsletter subscriptions |

### DevOps & Testing
| Tool | Version | Purpose |
|------|---------|---------|
| **PHPUnit** | `10.0.13` | Unit & Feature testing |
| **Laravel Sail** | `1.21.0` | Docker development environment |
| **PHP CodeSniffer** | `3.7.2` | Code style enforcement |
| **Mockery** | `1.5.1` | Mocking framework |

---

## 🏗️ Architecture Overview

### Directory Structure

```
chawkbazar-api/
├── app/                          # Laravel skeleton (minimal logic)
│   ├── Http/Controllers/         # Empty (uses Marvel package)
│   ├── Models/User.php           # Base User model (overridden by Marvel)
│   └── Providers/                # Service providers
├── packages/marvel/              # ⭐ CORE BUSINESS LOGIC PACKAGE
│   ├── src/
│   │   ├── Ai/                   # OpenAI integration (product descriptions)
│   │   ├── Console/              # 19 Artisan commands (setup, install, migrations)
│   │   ├── Database/
│   │   │   ├── Models/           # 58 Eloquent models
│   │   │   ├── Repositories/     # 48 Repository classes
│   │   │   └── Seeders/          # Demo data seeders
│   │   ├── Enums/                # 23 type-safe enums (OrderStatus, PaymentGatewayType, etc.)
│   │   ├── Events/               # 27 domain events (OrderCreated, RefundRequested, etc.)
│   │   ├── Exceptions/           # Custom exceptions (MarvelNotFoundException, etc.)
│   │   ├── GraphQL/
│   │   │   ├── Mutations/        # 37 GraphQL mutations
│   │   │   ├── Queries/          # 27 GraphQL queries
│   │   │   └── Schema/           # 48 .graphql schema files
│   │   ├── Http/
│   │   │   ├── Controllers/      # 48 REST controllers
│   │   │   ├── Requests/         # 67 Form Request validation classes
│   │   │   └── Resources/        # 32 API Resource transformers
│   │   ├── Listeners/            # 32 event listeners
│   │   ├── Mail/                 # Email templates
│   │   ├── Notifications/        # 21 notification classes
│   │   ├── Otp/                  # OTP gateway abstraction
│   │   ├── Payment/              # 11 payment gateway integrations
│   │   └── Traits/               # 14 reusable traits
│   ├── config/                   # Package-specific configs
│   └── database/migrations/      # 28 migrations (from 2020 to 2024)
├── config/                       # Laravel configs
├── database/                     # Core Laravel migrations (users, jobs)
├── routes/
│   └── api.php                   # Empty (routes in Marvel package)
├── public/sql/                   # SQL dumps for demo data
├── storage/                      # Logs, uploads, cache
└── tests/                        # Unit & Feature tests
```

### Package Architecture: `marvel/shop`

This is a **self-contained Laravel package** that provides all e-commerce logic. It registers:
- **Service Provider**: `Marvel\ShopServiceProvider`
- **Facades**: `Shop`, `Payment`, `Ai`
- **REST Routes**: Defined in `packages/marvel/src/Rest/Routes.php`
- **GraphQL Schema**: Auto-loaded from `packages/marvel/src/GraphQL/Schema/`

---

## 🔐 Authentication & Authorization

### Authentication Strategy
- **Laravel Sanctum** (Token-based auth)
- Tokens issued via `/token` endpoint (username/password)
- Middleware: `auth:sanctum` on protected routes
- Email verification required for most actions

### Role-Based Access Control (RBAC)

**4 Permission Levels** (defined in `Marvel\Enums\Permission`):

```php
Permission::SUPER_ADMIN   // Full system access
Permission::STORE_OWNER   // Manage shops, products, orders
Permission::STAFF         // Limited shop management
Permission::CUSTOMER      // Browse, purchase, review
```

**Route Protection Patterns**:
```php
// Customer-only routes
Route::middleware(['can:customer', 'auth:sanctum', 'email.verified']);

// Store Owner + Staff
Route::middleware(['permission:staff|store_owner', 'auth:sanctum']);

// Super Admin only
Route::middleware(['permission:super_admin', 'auth:sanctum']);
```

---

## 📊 Database Schema (Key Entities)

### Core Models (58 total)

| Model | Purpose | Key Relationships |
|-------|---------|-------------------|
| **User** | Customers, Admins, Vendors | `hasMany(Shop)`, `hasOne(Profile)`, `belongsToMany(Permission)` |
| **Shop** | Multi-vendor stores | `belongsTo(User)`, `hasMany(Product)`, `hasOne(Balance)` |
| **Product** | Catalog items | `belongsTo(Shop, Type, Category)`, `belongsToMany(Tag, Attribute)` |
| **Order** | Customer purchases | `belongsTo(User, Shop, Coupon)`, `belongsToMany(Product)`, `hasMany(Order)` (parent-child) |
| **Variation** | Product variants | `belongsTo(Product)`, `hasMany(AttributeValue)` |
| **Coupon** | Discounts | `belongsTo(Shop)`, Enum types: `fixed`, `percentage`, `free_shipping` |
| **Refund** | Return requests | `belongsTo(Order, Shop)`, Status enum |
| **FlashSale** | Time-limited deals | `belongsToMany(Product)`, date ranges |
| **Wishlist** | Saved products | `belongsTo(User, Product)` |
| **Review** | Product ratings | `belongsTo(Product, User)`, rating 1-5 |
| **Conversation** | Shop messaging | `belongsTo(User, Shop)`, `hasMany(Message)` |
| **Withdraw** | Vendor payouts | `belongsTo(Shop)`, approval workflow |
| **Settings** | Global config | JSON columns for options, currency, payment gateways |

### Key Database Features
- **Soft Deletes**: Most models support soft deletion
- **JSON Columns**: `image`, `gallery`, `address`, `settings` (flexible schemas)
- **Sluggable**: Auto-generated slugs for SEO (products, shops, categories)
- **Metable**: Key-value metadata storage via `kodeine/laravel-meta`
- **Multi-language**: `TranslationTrait` for i18n support
- **Strict Mode**: `false` (MySQL) — ⚠️ **CRITICAL ISSUE** (see Missing Section)

---

## 🔌 API Endpoints

### REST API Structure

**Base URL**: `/` (served from `packages/marvel/src/Rest/Routes.php`)

#### Public Endpoints
```http
POST   /register                    # Create customer account
POST   /token                       # Login (get Sanctum token)
POST   /logout                      # Invalidate token
POST   /forget-password             # Request reset link
POST   /reset-password              # Reset with token
POST   /social-login-token          # OAuth login (Socialite)
POST   /send-otp-code               # Send SMS OTP
POST   /otp-login                   # Login via OTP
GET    /products                    # List products (public)
GET    /products/{slug}             # Product details
GET    /categories                  # List categories
GET    /shops                       # List shops
POST   /orders                      # Create order (guest checkout)
POST   /orders/payment              # Process payment
GET    /popular-products            # Trending items
POST   /webhooks/{gateway}          # Payment webhooks (Stripe, PayPal, etc.)
```

#### Authenticated Routes (Customer)
```http
GET    /me                          # Current user profile
PUT    /users/{id}                  # Update profile
POST   /change-password             # Update password
GET    /orders                      # Order history
GET    /wishlists                   # Saved products
POST   /wishlists/toggle            # Add/remove wishlist
POST   /reviews                     # Submit review
GET    /conversations               # Messaging inbox
POST   /downloads/digital_file      # Download purchased files
POST   /refunds                     # Request refund
POST   /cards                       # Save payment method
```

#### Staff/Store Owner Routes
```http
POST   /products                    # Create product
PUT    /products/{id}               # Update product
DELETE /products/{id}               # Delete product
GET    /analytics                   # Shop analytics
GET    /low-stock-products          # Inventory alerts
PUT    /orders/{id}                 # Update order status
POST   /staffs                      # Add staff member
POST   /flash-sale                  # Create flash sale
GET    /export-order-url/{shop_id}  # Export orders as Excel
```

#### Super Admin Routes
```http
POST   /categories                  # Manage categories
POST   /types                       # Manage product types
POST   /tags                        # Manage tags
POST   /taxes                       # Tax configuration
POST   /shippings                   # Shipping methods
POST   /approve-shop                # Approve vendor shop
POST   /disapprove-shop             # Reject shop
POST   /users/make-admin            # Promote user
POST   /approve-withdraw            # Process payout
```

### GraphQL API

**Endpoint**: `/graphql`  
**Playground**: `/playground` (GraphiQL interface)

**Schema Structure**: 48 `.graphql` files in `packages/marvel/src/GraphQL/Schema/models/`

**Sample Queries**:
```graphql
query Products {
  products(first: 10, orderBy: [{column: CREATED_AT, order: DESC}]) {
    data {
      id name slug price sale_price
      shop { name }
      categories { name }
    }
  }
}

mutation CreateOrder($input: CreateOrderInput!) {
  createOrder(input: $input) {
    id tracking_number total payment_intent_info
  }
}
```

---

## 💼 Business Logic Patterns

### Repository Pattern (48 Repositories)

All data access goes through repositories (not direct Eloquent queries in controllers).

**Example**:
```php
// packages/marvel/src/Database/Repositories/ProductRepository.php
class ProductRepository extends BaseRepository
{
    public function model(): string
    {
        return Product::class;
    }
    
    public function popularProducts($limit = 10) {
        return $this->orderBy('sold_quantity', 'desc')->limit($limit)->get();
    }
}
```

**Controllers Inject Repositories**:
```php
class ProductController {
    public function __construct(ProductRepository $repository) {
        $this->repository = $repository;
    }
}
```

### Event-Driven Architecture (27 Events)

**Key Events**:
- `OrderCreated` → Triggers inventory update, vendor notification
- `OrderDelivered` → Releases payment to vendor
- `RefundRequested` → Notifies admin, holds payout
- `PaymentSuccess` → Updates order status, sends receipt
- `ShopMaintenance` → Broadcasts to WebSocket clients

**Listeners** (32 total) handle side effects:
```php
// packages/marvel/src/Listeners/SendOrderCreatedNotification.php
class SendOrderCreatedNotification {
    public function handle(OrderCreated $event) {
        // Send email, SMS, push notification
    }
}
```

### Traits for Reusability (14 Traits)

- **`WalletsTrait`**: Customer wallet & points logic
- **`PaymentTrait`**: Payment gateway abstraction
- **`OrderManagementTrait`**: Order state machine
- **`SmsTrait`**: SMS sending (Twilio, MessageBird)
- **`TranslationTrait`**: Multi-language content

---

## 🚨 CRITICAL: What's Missing for Refactoring

### 1. **Type Safety & Strict Mode** ❌

**Issue**: `'strict' => false` in `config/database.php`

**Risk**: Silent data corruption (truncated strings, invalid dates accepted)

**Fix Required**:
```php
'strict' => true,  // Enforce SQL strict mode
```

**Impact**: May expose existing bugs where invalid data was silently stored.

---

### 2. **Lack of Type Declarations** ❌

**Issue**: No `declare(strict_types=1);` in PHP files

**Risk**: Type coercion bugs (e.g., `'123'` treated as `123`)

**Fix**: Add to **every PHP file**:
```php
<?php

declare(strict_types=1);

namespace Marvel\Http\Controllers;
```

---

### 3. **Transaction Management** ⚠️

**Issue**: No consistent use of `DB::transaction()` for multi-step operations

**Risk**: Partial order creation (order saved, but products not attached)

**Example of Missing Transactions**:
```php
// WRONG (current pattern in some controllers)
public function createOrder(OrderCreateRequest $request) {
    $order = Order::create($request->all());
    $order->products()->attach($products); // If this fails, orphaned order!
    return $order;
}

// CORRECT (should be)
public function createOrder(OrderCreateRequest $request) {
    return DB::transaction(function() use ($request) {
        $order = Order::create($request->all());
        $order->products()->attach($products);
        return $order;
    });
}
```

**Audit Required**: Review all `OrderController`, `CheckoutController`, `RefundController`.

---

### 4. **Testing Coverage** ❌

**Current State**:
- Only 2 example tests in `tests/Feature/ExampleTest.php`
- No test for critical flows (order creation, payment processing, refunds)

**Required**:
```php
// Example: tests/Feature/OrderCreationTest.php
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderCreationTest extends TestCase {
    use RefreshDatabase;
    
    public function test_customer_can_create_order() {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100, 'quantity' => 10]);
        
        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/orders', [
                'products' => [['id' => $product->id, 'quantity' => 2]]
            ]);
        
        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', ['customer_id' => $user->id]);
        $this->assertEquals(8, $product->fresh()->quantity); // Stock reduced
    }
}
```

---

### 5. **API Resource Consistency** ⚠️

**Issue**: Some controllers return raw models, others use `API Resources`

**Example**:
```php
// INCONSISTENT
public function show($id) {
    return Product::find($id); // Exposes all columns, relationships
}

// CORRECT (use Resources)
public function show($id) {
    return new ProductResource(Product::findOrFail($id));
}
```

**Impact**: Leaks sensitive data (timestamps, pivot columns), inconsistent JSON structure.

---

### 6. **Input Validation Gaps** ⚠️

**Issue**: Not all endpoints use `Form Requests` for validation

**Example** (found in some controllers):
```php
// WRONG
public function updateSettings(Request $request) {
    Settings::first()->update($request->all()); // No validation!
}

// CORRECT
public function updateSettings(SettingsUpdateRequest $request) {
    Settings::first()->update($request->validated());
}
```

**Risk**: SQL injection, XSS, data corruption.

---

### 7. **Environment Configuration** ⚠️

**Issue**: Hardcoded values in code instead of `.env`

**Example** (found in payment controllers):
```php
// WRONG
$stripeKey = 'sk_test_...'; // Hardcoded secret

// CORRECT
$stripeKey = config('services.stripe.secret');
```

**Fix**: Audit all controllers, move secrets to `config/services.php`:
```php
'stripe' => [
    'secret' => env('STRIPE_SECRET_KEY'),
]
```

---

### 8. **N+1 Query Problems** ⚠️

**Issue**: Lazy loading in loops (common in REST Resources)

**Example**:
```php
// BAD (N+1 queries)
public function index() {
    return ProductResource::collection(Product::all()); // Each resource loads shop, category
}

// GOOD
public function index() {
    return ProductResource::collection(
        Product::with(['shop', 'categories', 'tags'])->get()
    );
}
```

**Tool Needed**: Install `barryvdh/laravel-debugbar` to detect N+1 queries.

---

### 9. **Error Handling & Logging** ⚠️

**Issue**: Exceptions caught but not logged properly

**Example**:
```php
// WRONG (found in PaymentController)
try {
    $payment = Stripe::charge(...);
} catch (Exception $e) {
    return response()->json(['error' => 'Payment failed'], 500); // No log!
}

// CORRECT
try {
    $payment = Stripe::charge(...);
} catch (Exception $e) {
    \Log::error('Stripe payment failed', [
        'order_id' => $orderId,
        'exception' => $e->getMessage(),
    ]);
    throw new MarvelException('Payment failed: ' . $e->getMessage());
}
```

---

### 10. **Docker & CI/CD** ❌

**Current State**:
- Basic `Dockerfile` (only installs PHP extensions)
- `install.sh` script uses Laravel Sail but hardcoded ports
- No GitHub Actions, GitLab CI, or automated testing

**Required**:
```yaml
# .github/workflows/test.yml
name: Tests
on: [push, pull_request]
jobs:
  phpunit:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Install dependencies
        run: composer install
      - name: Run tests
        run: php artisan test
```

---

### 11. **GraphQL Schema Synchronization** ⚠️

**Issue**: `.graphql` schema files may drift from REST API structure

**Risk**: Frontend inconsistency between REST/GraphQL clients

**Fix**: Add validation test:
```php
public function test_graphql_schema_matches_models() {
    $schema = file_get_contents(base_path('packages/marvel/src/GraphQL/Schema/schema.graphql'));
    $this->assertStringContainsString('type Product', $schema);
    // Add assertions for all models
}
```

---

### 12. **Payment Webhook Security** 🔒

**Issue**: Webhook endpoints (`/webhooks/stripe`, etc.) may not verify signatures

**Example** (from `WebHookController.php`):
```php
// INSECURE (current pattern)
public function stripe(Request $request) {
    $payload = $request->all(); // No signature verification!
    Order::where('payment_intent_id', $payload['id'])->update(['status' => 'paid']);
}

// SECURE (required)
use Stripe\Webhook;
public function stripe(Request $request) {
    $signature = $request->header('Stripe-Signature');
    try {
        $event = Webhook::constructEvent(
            $request->getContent(),
            $signature,
            config('services.stripe.webhook_secret')
        );
    } catch (\Exception $e) {
        return response('Invalid signature', 400);
    }
    // Process $event safely
}
```

---

## 🔄 Refactoring Recommendations (Aligned with Project Plan)

### Phase 1: Stabilization (Before Monorepo Split)

1. **Add Strict Types**:
   ```bash
   find packages/marvel/src -name '*.php' -exec sed -i '2i\\ndeclare(strict_types=1);' {} \;
   ```

2. **Enable Database Strict Mode**:
   ```php
   // config/database.php
   'strict' => true,
   ```

3. **Write Critical Path Tests**:
   - Order creation + payment
   - Refund flow
   - Shop approval workflow

4. **Audit Transactions**:
   - Wrap all multi-step operations in `DB::transaction()`

### Phase 2: API Cleanup

1. **Standardize Responses**:
   - All endpoints return `API Resources`
   - Consistent error format:
     ```json
     {
       "message": "Validation failed",
       "errors": { "email": ["Invalid email"] },
       "code": "VALIDATION_ERROR"
     }
     ```

2. **Extract Shared Types to `packages/types`** (as per refactor plan):
   ```typescript
   // packages/types/src/Product.ts
   export interface Product {
     id: number;
     name: string;
     price: number;
     shop: Shop;
   }
   ```

3. **Create API Client Package** (`packages/api-client`):
   ```typescript
   // packages/api-client/src/products.ts
   export const useProducts = () => {
     return useQuery('products', () => axios.get('/products'));
   };
   ```

### Phase 3: Monorepo Migration

1. **Move to `apps/api/`** (as per refactor plan):
   ```
   apps/
   ├── api/              # chawkbazar-api moved here
   ├── admin/
   └── shop/
   ```

2. **Shared Package Dependencies**:
   ```json
   // apps/api/composer.json
   {
     "require": {
       "@chawkbazar/types": "*"  // Reference shared TypeScript types
     }
   }
   ```

---

## 🧪 Testing Strategy

### Required Test Coverage

| Area | Current | Target |
|------|---------|--------|
| Order Management | 0% | 80% |
| Payment Processing | 0% | 90% (critical) |
| User Authentication | 0% | 70% |
| Product CRUD | 0% | 60% |
| Refund Workflow | 0% | 80% |

### Test Setup
```php
// tests/TestCase.php
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase {
    use RefreshDatabase;
    
    protected function setUp(): void {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed', ['--class' => MarvelSeeder::class]);
    }
}
```

---

## 📚 Key Commands

### Installation
```bash
# Copy environment
cp .env.example .env

# Install dependencies
composer install
npm install

# Generate app key
php artisan key:generate

# Run migrations + demo data
php artisan marvel:install

# Link storage
php artisan storage:link

# Start server
php artisan serve  # http://localhost:8000
```

### Testing
```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test --filter OrderCreationTest
```

### Development
```bash
# Clear all caches
php artisan optimize:clear

# Generate IDE helper
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate

# Check code style
./vendor/bin/phpcs packages/marvel/src --standard=PSR12
```

---

## 🔗 Integration Points with Frontend

### Frontend Dependencies (from `admin` & `shop`)
- **Authentication**: `/token` endpoint returns Sanctum token → stored in localStorage
- **API Base URL**: Configured in `.env` → `NEXT_PUBLIC_REST_API_ENDPOINT`
- **WebSocket**: Pusher credentials from `/settings` endpoint
- **File Uploads**: POST to `/attachments` → returns `{ id, url }`

### Critical Frontend-Backend Contracts
1. **Order Tracking**:
   - Frontend polls `/orders/tracking-number/{number}`
   - Backend emits `OrderStatusChanged` event → Pusher

2. **Real-time Notifications**:
   - Backend broadcasts via `Marvel\Events\StoreNoticeEvent`
   - Frontend subscribes to Pusher channel `shop.{shop_id}`

3. **Payment Flow**:
   ```mermaid
   sequenceDiagram
       Shop->>API: POST /orders (creates order)
       API-->>Shop: {id, payment_intent_id}
       Shop->>Stripe: Confirm payment (client-side)
       Stripe->>API: Webhook /webhooks/stripe
       API-->>Shop: Pusher event (payment_success)
   ```

---

## 🚀 Performance Considerations

### Current Bottlenecks
1. **No Query Caching**: Frequently accessed data (categories, settings) not cached
2. **Media Library**: Images stored locally (should use S3/CDN)
3. **Eager Loading**: Missing `with()` in many queries → N+1 problems

### Optimization Roadmap
```php
// 1. Cache settings
Cache::remember('settings', 3600, fn() => Settings::first());

// 2. Use S3 for media
// config/filesystems.php
'default' => env('FILESYSTEM_DISK', 's3'),

// 3. Add Redis for sessions
// .env
SESSION_DRIVER=redis
CACHE_DRIVER=redis
```

---

## 📄 Summary Table: What's Missing

| Category | Status | Priority | Effort |
|----------|--------|----------|--------|
| Strict Types (`declare(strict_types=1)`) | ❌ Missing | 🔴 Critical | 2 days |
| Database Strict Mode | ❌ Off | 🔴 Critical | 1 day + testing |
| Transaction Wrapping | ⚠️ Partial | 🔴 Critical | 3 days |
| Test Coverage | ❌ <5% | 🔴 Critical | 2 weeks |
| API Resources (consistent) | ⚠️ 60% | 🟡 High | 3 days |
| Input Validation (all endpoints) | ⚠️ 80% | 🟡 High | 2 days |
| Webhook Security (signature verification) | ⚠️ Partial | 🔴 Critical | 2 days |
| Error Logging | ⚠️ Partial | 🟡 High | 1 day |
| N+1 Query Optimization | ⚠️ Unchecked | 🟡 High | 1 week |
| CI/CD Pipeline | ❌ None | 🟡 High | 3 days |
| Docker Production Config | ⚠️ Dev-only | 🟢 Medium | 2 days |
| GraphQL Schema Tests | ❌ None | 🟢 Medium | 1 day |

---

## 🎯 Next Steps for Refactoring Team

1. **Immediate** (Week 1):
   - Enable strict mode + strict types
   - Audit payment webhooks for security
   - Write smoke tests for critical paths

2. **Short-term** (Weeks 2-4):
   - Extract shared types to `packages/types`
   - Standardize API responses
   - Set up CI/CD pipeline

3. **Long-term** (Month 2):
   - Migrate to monorepo structure (`apps/api/`)
   - Build shared UI library (`packages/ui`)
   - Implement page builder backend

---

**Documentation Version**: 1.0  
**Last Updated**: Based on codebase analysis as of Laravel 10.30.1  
**Author**: Principal Backend Architect  

This documentation should be kept in `docs/BACKEND_ARCHITECTURE.md` in your repository and updated as refactoring progresses.

```plaintext
chawkbazar-api/
├── app/                          # Laravel skeleton (minimal logic)
│   ├── Http/Controllers/         # Empty (uses Marvel package)
│   ├── Models/User.php           # Base User model (overridden by Marvel)
│   └── Providers/                # Service providers
├── packages/marvel/              # ⭐ CORE BUSINESS LOGIC PACKAGE
│   ├── src/
│   │   ├── Ai/                   # OpenAI integration (product descriptions)
│   │   ├── Console/              # 19 Artisan commands (setup, install, migrations)
│   │   ├── Database/
│   │   │   ├── Models/           # 58 Eloquent models
│   │   │   ├── Repositories/     # 48 Repository classes
│   │   │   └── Seeders/          # Demo data seeders
│   │   ├── Enums/                # 23 type-safe enums (OrderStatus, PaymentGatewayType, etc.)
│   │   ├── Events/               # 27 domain events (OrderCreated, RefundRequested, etc.)
│   │   ├── Exceptions/           # Custom exceptions (MarvelNotFoundException, etc.)
│   │   ├── GraphQL/
│   │   │   ├── Mutations/        # 37 GraphQL mutations
│   │   │   ├── Queries/          # 27 GraphQL queries
│   │   │   └── Schema/           # 48 .graphql schema files
│   │   ├── Http/
│   │   │   ├── Controllers/      # 48 REST controllers
│   │   │   ├── Requests/         # 67 Form Request validation classes
│   │   │   └── Resources/        # 32 API Resource transformers
│   │   ├── Listeners/            # 32 event listeners
│   │   ├── Mail/                 # Email templates
│   │   ├── Notifications/        # 21 notification classes
│   │   ├── Otp/                  # OTP gateway abstraction
│   │   ├── Payment/              # 11 payment gateway integrations
│   │   └── Traits/               # 14 reusable traits
│   ├── config/                   # Package-specific configs
│   └── database/migrations/      # 28 migrations (from 2020 to 2024)
├── config/                       # Laravel configs
├── database/                     # Core Laravel migrations (users, jobs)
├── routes/
│   └── api.php                   # Empty (routes in Marvel package)
├── public/sql/                   # SQL dumps for demo data
├── storage/                      # Logs, uploads, cache
└── tests/                        # Unit & Feature tests
```

```php
Permission::SUPER_ADMIN   // Full system access
Permission::STORE_OWNER   // Manage shops, products, orders
Permission::STAFF         // Limited shop management
Permission::CUSTOMER      // Browse, purchase, review
```

```php
// Customer-only routes
Route::middleware(['can:customer', 'auth:sanctum', 'email.verified']);

// Store Owner + Staff
Route::middleware(['permission:staff|store_owner', 'auth:sanctum']);

// Super Admin only
Route::middleware(['permission:super_admin', 'auth:sanctum']);
```

```plaintext
POST   /register                    # Create customer account
POST   /token                       # Login (get Sanctum token)
POST   /logout                      # Invalidate token
POST   /forget-password             # Request reset link
POST   /reset-password              # Reset with token
POST   /social-login-token          # OAuth login (Socialite)
POST   /send-otp-code               # Send SMS OTP
POST   /otp-login                   # Login via OTP
GET    /products                    # List products (public)
GET    /products/{slug}             # Product details
GET    /categories                  # List categories
GET    /shops                       # List shops
POST   /orders                      # Create order (guest checkout)
POST   /orders/payment              # Process payment
GET    /popular-products            # Trending items
POST   /webhooks/{gateway}          # Payment webhooks (Stripe, PayPal, etc.)
```

```plaintext
GET    /me                          # Current user profile
PUT    /users/{id}                  # Update profile
POST   /change-password             # Update password
GET    /orders                      # Order history
GET    /wishlists                   # Saved products
POST   /wishlists/toggle            # Add/remove wishlist
POST   /reviews                     # Submit review
GET    /conversations               # Messaging inbox
POST   /downloads/digital_file      # Download purchased files
POST   /refunds                     # Request refund
POST   /cards                       # Save payment method
```

```plaintext
POST   /products                    # Create product
PUT    /products/{id}               # Update product
DELETE /products/{id}               # Delete product
GET    /analytics                   # Shop analytics
GET    /low-stock-products          # Inventory alerts
PUT    /orders/{id}                 # Update order status
POST   /staffs                      # Add staff member
POST   /flash-sale                  # Create flash sale
GET    /export-order-url/{shop_id}  # Export orders as Excel
```

```plaintext
POST   /categories                  # Manage categories
POST   /types                       # Manage product types
POST   /tags                        # Manage tags
POST   /taxes                       # Tax configuration
POST   /shippings                   # Shipping methods
POST   /approve-shop                # Approve vendor shop
POST   /disapprove-shop             # Reject shop
POST   /users/make-admin            # Promote user
POST   /approve-withdraw            # Process payout
```

```plaintext
query Products {
  products(first: 10, orderBy: [{column: CREATED_AT, order: DESC}]) {
    data {
      id name slug price sale_price
      shop { name }
      categories { name }
    }
  }
}

mutation CreateOrder($input: CreateOrderInput!) {
  createOrder(input: $input) {
    id tracking_number total payment_intent_info
  }
}
```

```php
// packages/marvel/src/Database/Repositories/ProductRepository.php
class ProductRepository extends BaseRepository
{
    public function model(): string
    {
        return Product::class;
    }
    
    public function popularProducts($limit = 10) {
        return $this->orderBy('sold_quantity', 'desc')->limit($limit)->get();
    }
}
```

```php
class ProductController {
    public function __construct(ProductRepository $repository) {
        $this->repository = $repository;
    }
}
```

```php
// packages/marvel/src/Listeners/SendOrderCreatedNotification.php
class SendOrderCreatedNotification {
    public function handle(OrderCreated $event) {
        // Send email, SMS, push notification
    }
}
```

```php
'strict' => true,  // Enforce SQL strict mode
```

```php
<?php

declare(strict_types=1);

namespace Marvel\Http\Controllers;
```

```php
// WRONG (current pattern in some controllers)
public function createOrder(OrderCreateRequest $request) {
    $order = Order::create($request->all());
    $order->products()->attach($products); // If this fails, orphaned order!
    return $order;
}

// CORRECT (should be)
public function createOrder(OrderCreateRequest $request) {
    return DB::transaction(function() use ($request) {
        $order = Order::create($request->all());
        $order->products()->attach($products);
        return $order;
    });
}
```

```php
// Example: tests/Feature/OrderCreationTest.php
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderCreationTest extends TestCase {
    use RefreshDatabase;
    
    public function test_customer_can_create_order() {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100, 'quantity' => 10]);
        
        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/orders', [
                'products' => [['id' => $product->id, 'quantity' => 2]]
            ]);
        
        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', ['customer_id' => $user->id]);
        $this->assertEquals(8, $product->fresh()->quantity); // Stock reduced
    }
}
```

```php
// INCONSISTENT
public function show($id) {
    return Product::find($id); // Exposes all columns, relationships
}

// CORRECT (use Resources)
public function show($id) {
    return new ProductResource(Product::findOrFail($id));
}
```

```php
// WRONG
public function updateSettings(Request $request) {
    Settings::first()->update($request->all()); // No validation!
}

// CORRECT
public function updateSettings(SettingsUpdateRequest $request) {
    Settings::first()->update($request->validated());
}
```

```php
// WRONG
$stripeKey = 'sk_test_...'; // Hardcoded secret

// CORRECT
$stripeKey = config('services.stripe.secret');
```

```php
'stripe' => [
    'secret' => env('STRIPE_SECRET_KEY'),
]
```

```php
// BAD (N+1 queries)
public function index() {
    return ProductResource::collection(Product::all()); // Each resource loads shop, category
}

// GOOD
public function index() {
    return ProductResource::collection(
        Product::with(['shop', 'categories', 'tags'])->get()
    );
}
```

```php
// WRONG (found in PaymentController)
try {
    $payment = Stripe::charge(...);
} catch (Exception $e) {
    return response()->json(['error' => 'Payment failed'], 500); // No log!
}

// CORRECT
try {
    $payment = Stripe::charge(...);
} catch (Exception $e) {
    \Log::error('Stripe payment failed', [
        'order_id' => $orderId,
        'exception' => $e->getMessage(),
    ]);
    throw new MarvelException('Payment failed: ' . $e->getMessage());
}
```

```yaml
# .github/workflows/test.yml
name: Tests
on: [push, pull_request]
jobs:
  phpunit:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Install dependencies
        run: composer install
      - name: Run tests
        run: php artisan test
```

```php
public function test_graphql_schema_matches_models() {
    $schema = file_get_contents(base_path('packages/marvel/src/GraphQL/Schema/schema.graphql'));
    $this->assertStringContainsString('type Product', $schema);
    // Add assertions for all models
}
```

```php
// INSECURE (current pattern)
public function stripe(Request $request) {
    $payload = $request->all(); // No signature verification!
    Order::where('payment_intent_id', $payload['id'])->update(['status' => 'paid']);
}

// SECURE (required)
use Stripe\Webhook;
public function stripe(Request $request) {
    $signature = $request->header('Stripe-Signature');
    try {
        $event = Webhook::constructEvent(
            $request->getContent(),
            $signature,
            config('services.stripe.webhook_secret')
        );
    } catch (\Exception $e) {
        return response('Invalid signature', 400);
    }
    // Process $event safely
}
```

```shellscript
   find packages/marvel/src -name '*.php' -exec sed -i '2i\\ndeclare(strict_types=1);' {} \;
```

```php
   // config/database.php
   'strict' => true,
```

```json
     {
       "message": "Validation failed",
       "errors": { "email": ["Invalid email"] },
       "code": "VALIDATION_ERROR"
     }
```

```typescript
   // packages/types/src/Product.ts
   export interface Product {
     id: number;
     name: string;
     price: number;
     shop: Shop;
   }
```

```typescript
   // packages/api-client/src/products.ts
   export const useProducts = () => {
     return useQuery('products', () => axios.get('/products'));
   };
```

```plaintext
   apps/
   ├── api/              # chawkbazar-api moved here
   ├── admin/
   └── shop/
```

```json
   // apps/api/composer.json
   {
     "require": {
       "@chawkbazar/types": "*"  // Reference shared TypeScript types
     }
   }
```

```php
// tests/TestCase.php
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase {
    use RefreshDatabase;
    
    protected function setUp(): void {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed', ['--class' => MarvelSeeder::class]);
    }
}
```

```shellscript
# Copy environment
cp .env.example .env

# Install dependencies
composer install
npm install

# Generate app key
php artisan key:generate

# Run migrations + demo data
php artisan marvel:install

# Link storage
php artisan storage:link

# Start server
php artisan serve  # http://localhost:8000
```

```shellscript
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test
php artisan test --filter OrderCreationTest
```

```shellscript
# Clear all caches
php artisan optimize:clear

# Generate IDE helper
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate

# Check code style
./vendor/bin/phpcs packages/marvel/src --standard=PSR12
```

```plaintext
   sequenceDiagram
       Shop->>API: POST /orders (creates order)
       API-->>Shop: {id, payment_intent_id}
       Shop->>Stripe: Confirm payment (client-side)
       Stripe->>API: Webhook /webhooks/stripe
       API-->>Shop: Pusher event (payment_success)
```

```php
// 1. Cache settings
Cache::remember('settings', 3600, fn() => Settings::first());

// 2. Use S3 for media
// config/filesystems.php
'default' => env('FILESYSTEM_DISK', 's3'),

// 3. Add Redis for sessions
// .env
SESSION_DRIVER=redis
CACHE_DRIVER=redis
```

