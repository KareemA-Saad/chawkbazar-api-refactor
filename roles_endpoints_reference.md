# ChawkBazar API - Roles & Endpoints Reference

## System Roles Overview

| Role | Description | Self-Register? | Assignment Method |
|------|-------------|----------------|-------------------|
| **super_admin** | Platform administrator with full system access | ❌ | `php artisan marvel:create-admin` or by super_admin |
| **editor** | CMS page editor with content management access | ❌ | Assigned by super_admin only |
| **store_owner** | Vendor/seller who owns one or more shops | ✅ | Register with `permission: "store_owner"` |
| **staff** | Shop employee with limited shop management access | ❌ | Created by store_owner via `POST /staffs` |
| **customer** | Regular buyer/shopper | ✅ | Default role on registration |

---

## Role Capabilities Matrix

| Capability | Customer | Staff | Store Owner | Editor | Super Admin |
|------------|:--------:|:-----:|:-----------:|:------:|:-----------:|
| Browse products/shops | ✅ | ✅ | ✅ | ✅ | ✅ |
| Place orders | ✅ | ✅ | ✅ | ✅ | ✅ |
| Write reviews/questions | ✅ | ✅ | ✅ | ✅ | ✅ |
| Manage own profile | ✅ | ✅ | ✅ | ✅ | ✅ |
| Manage products | ❌ | ✅* | ✅ | ❌ | ✅ |
| Manage orders | ❌ | ✅* | ✅ | ❌ | ✅ |
| View shop analytics | ❌ | ✅* | ✅ | ❌ | ✅ |
| Create/manage coupons | ❌ | ✅* | ✅ | ❌ | ✅ |
| Create shops | ❌ | ❌ | ✅ | ❌ | ✅ |
| Add/remove staff | ❌ | ❌ | ✅ | ❌ | ✅ |
| Manage withdrawals | ❌ | ❌ | ✅ | ✅ | ✅ |
| Edit CMS pages | ❌ | ❌ | ❌ | ✅ | ✅ |
| Manage categories/types | ❌ | ❌ | ❌ | ❌ | ✅ |
| Ban/activate users | ❌ | ❌ | ❌ | ❌ | ✅ |
| Approve shops | ❌ | ❌ | ❌ | ❌ | ✅ |
| System settings | ❌ | ❌ | ❌ | ❌ | ✅ |

*Staff can only access their assigned shop's data*

---

## Endpoints by Access Level

### 🌐 Public Endpoints (No Auth Required)

| Method | Endpoint | Description | Swagger? |
|--------|----------|-------------|:--------:|
| POST | `/register` | Register new user account | ✅ |
| POST | `/token` | Login and get access token | ✅ |
| POST | `/logout` | Revoke current token | ✅ |
| POST | `/forget-password` | Request password reset email | ✅ |
| POST | `/verify-forget-password-token` | Verify reset token | ✅ |
| POST | `/reset-password` | Set new password | ✅ |
| POST | `/social-login-token` | OAuth login (Facebook/Google) | ✅ |
| GET | `/products` | List all products | ✅ |
| GET | `/products/{slug}` | Get single product | ✅ |
| GET | `/categories` | List all categories | ✅ |
| GET | `/categories/{slug}` | Get single category | ✅ |
| GET | `/shops` | List all shops | ✅ |
| GET | `/shops/{slug}` | Get single shop | ✅ |
| GET | `/types` | List product types | ✅ |
| GET | `/types/{slug}` | Get single type | ✅ |
| GET | `/tags` | List all tags | ✅ |
| GET | `/tags/{slug}` | Get single tag | ✅ |
| GET | `/authors` | List all authors | ✅ |
| GET | `/authors/{slug}` | Get single author | ✅ |
| GET | `/manufacturers` | List all manufacturers | ✅ |
| GET | `/manufacturers/{slug}` | Get single manufacturer | ✅ |
| GET | `/top-authors` | Get top-rated authors | ✅ |
| GET | `/top-manufacturers` | Get top manufacturers | ✅ |
| GET | `/popular-products` | Get popular products | ✅ |
| GET | `/best-selling-products` | Get best sellers | ✅ |
| GET | `/coupons` | List available coupons | ✅ |
| POST | `/coupons/verify` | Verify coupon code | ✅ |
| GET | `/cms-pages` | List CMS pages | ✅ |
| GET | `/cms-pages/{slug}` | Get CMS page by slug | ✅ |
| GET | `/puck/page` | Get Puck page by path | ✅ |
| GET | `/flash-sale` | List flash sales | ❌ |
| GET | `/flash-sale/{id}` | Get flash sale details | ❌ |
| GET | `/faqs` | List FAQs | ✅ |
| GET | `/terms-and-conditions` | List T&C documents | ❌ |
| POST | `/orders` | Create new order | ❌ |
| GET | `/orders/{id}` | Get order details | ❌ |
| GET | `/settings` | Get app settings | ❌ |
| GET | `/reviews` | List product reviews | ❌ |
| GET | `/questions` | List product questions | ❌ |
| GET | `/near-by-shop/{lat}/{lng}` | Find shops by location | ✅ |

---

### 👤 Customer Endpoints (Auth + Customer Permission)

| Method | Endpoint | Description | Swagger? |
|--------|----------|-------------|:--------:|
| GET | `/me` | Get current user profile | ✅ |
| PUT | `/users/{id}` | Update user profile | ✅ |
| POST | `/change-password` | Change current password | ✅ |
| POST | `/update-email` | Update email address | ❌ |
| GET | `/orders` | List my orders | ✅ |
| GET | `/orders/tracking-number/{tracking}` | Track order | ✅ |
| POST | `/reviews` | Create product review | ✅ |
| PUT | `/reviews/{id}` | Update my review | ✅ |
| GET | `/wishlists` | List wishlist | ✅ |
| POST | `/wishlists` | Add to wishlist | ✅ |
| DELETE | `/wishlists/{id}` | Remove from wishlist | ✅ |
| GET | `/refunds` | List my refunds | ✅ |
| POST | `/refunds` | Request refund | ✅ |
| GET | `/conversations` | List conversations | ✅ |
| POST | `/conversations` | Start conversation | ✅ |
| POST | `/questions` | Ask product question | ❌ |
| GET | `/my-questions` | List my questions | ❌ |
| POST | `/wishlists` | Add to wishlist | ❌ |
| DELETE | `/wishlists/{id}` | Remove from wishlist | ❌ |
| POST | `/wishlists/toggle` | Toggle wishlist item | ❌ |
| GET | `/my-wishlists` | Get my wishlist products | ❌ |
| GET | `/refunds` | List my refund requests | ❌ |
| POST | `/refunds` | Request order refund | ❌ |
| GET | `/conversations` | List my conversations | ❌ |
| POST | `/conversations` | Start new conversation | ❌ |
| GET | `/followed-shops` | List shops I follow | ✅ |
| POST | `/follow-shop` | Follow/unfollow shop | ✅ |
| DELETE | `/address/{id}` | Delete address | ❌ |
| GET | `/cards` | List saved payment cards | ❌ |
| POST | `/cards` | Add payment card | ❌ |
| DELETE | `/cards/{id}` | Remove payment card | ❌ |
| GET | `/downloads` | List downloadable files | ❌ |
| GET | `/notify-logs` | List notifications | ❌ |

---

### 👷 Staff Endpoints (Auth + Staff/Store Owner Permission)

| Method | Endpoint | Description | Swagger? |
|--------|----------|-------------|:--------:|
| POST | `/products` | Create new product | ✅ |
| PUT | `/products/{id}` | Update product | ✅ |
| DELETE | `/products/{id}` | Delete product | ✅ |
| POST | `/attributes` | Create attribute | ✅ |
| PUT | `/attributes/{id}` | Update attribute | ✅ |
| DELETE | `/attributes/{id}` | Delete attribute | ✅ |
| PUT | `/orders/{id}` | Update order status | ✅ |
| PUT | `/questions/{id}` | Answer question | ✅ |
| POST | `/authors` | Create author | ✅ |
| POST | `/manufacturers` | Create manufacturer | ✅ |
| GET | `/analytics` | View shop analytics | ✅ |
| GET | `/low-stock-products` | List low stock items | ✅ |
| GET | `/draft-products` | List draft products | ✅ |
| PUT | `/coupons/{id}` | Update coupon | ✅ |
| POST | `/store-notices` | Create store notice | ✅ |
| PUT | `/store-notices/{id}` | Update store notice | ✅ |
| DELETE | `/store-notices/{id}` | Delete store notice | ✅ |
| POST | `/faqs` | Create FAQ | ✅ |
| PUT | `/faqs/{id}` | Update FAQ | ✅ |
| DELETE | `/faqs/{id}` | Delete FAQ | ✅ |

---

### 🏪 Store Owner Endpoints (Auth + Store Owner Permission)

| Method | Endpoint | Description | Swagger? |
|--------|----------|-------------|:--------:|
| POST | `/shops` | Create new shop | ✅ |
| PUT | `/shops/{id}` | Update shop | ✅ |
| DELETE | `/shops/{id}` | Delete shop | ✅ |
| GET | `/my-shops` | List my shops | ✅ |
| POST | `/staffs` | Add staff to shop | ✅ |
| DELETE | `/staffs/{id}` | Remove staff | ✅ |
| GET | `/staffs` | List shop staff | ✅ |
| POST | `/transfer-shop-ownership` | Transfer shop | ✅ |
| GET | `/withdraws` | List withdraw requests | ✅ |
| POST | `/withdraws` | Request withdrawal | ✅ |
| POST | `/coupons` | Create coupon | ✅ |
| DELETE | `/coupons/{id}` | Delete coupon | ✅ |
| POST | `/flash-sale` | Create flash sale | ❌ |
| PUT | `/flash-sale/{id}` | Update flash sale | ❌ |
| DELETE | `/flash-sale/{id}` | Delete flash sale | ❌ |
| POST | `/terms-and-conditions` | Create T&C | ❌ |
| PUT | `/terms-and-conditions/{id}` | Update T&C | ❌ |
| DELETE | `/terms-and-conditions/{id}` | Delete T&C | ❌ |
| GET | `/vendors/list` | List other vendors | ✅ |

---

### ✏️ Editor Endpoints (Auth + Editor/Super Admin Permission)

| Method | Endpoint | Description | Swagger? |
|--------|----------|-------------|:--------:|
| POST | `/cms-pages` | Create CMS page | ✅ |
| PUT | `/cms-pages/{id}` | Update CMS page | ✅ |
| DELETE | `/cms-pages/{id}` | Delete CMS page | ✅ |
| POST | `/puck/page` | Save Puck page (upsert) | ✅ |

---

### 🔐 Super Admin Endpoints (Auth + Super Admin Permission)

| Method | Endpoint | Description | Swagger? |
|--------|----------|-------------|:--------:|
| GET | `/admins` | List admin users | ✅ |
| GET | `/vendors` | List vendor users | ✅ |
| GET | `/customers` | List customer users | ✅ |
| GET | `/users` | List all users | ✅ |
| POST | `/users` | Create user (any role) | ✅ |
| PUT | `/users/{id}` | Update any user | ✅ |
| DELETE | `/users/{id}` | Delete user | ✅ |
| POST | `/ban-user` | Deactivate user | ✅ |
| POST | `/active-user` | Reactivate user | ✅ |
| POST | `/users/make-admin` | Toggle admin status | ✅ |
| POST | `/types` | Create product type | ✅ |
| PUT | `/types/{id}` | Update product type | ✅ |
| DELETE | `/types/{id}` | Delete product type | ✅ |
| POST | `/categories` | Create category | ✅ |
| PUT | `/categories/{id}` | Update category | ✅ |
| DELETE | `/categories/{id}` | Delete category | ✅ |
| POST | `/tags` | Create tag | ✅ |
| PUT | `/tags/{id}` | Update tag | ✅ |
| DELETE | `/tags/{id}` | Delete tag | ✅ |
| PUT | `/authors/{id}` | Update author | ✅ |
| DELETE | `/authors/{id}` | Delete author | ✅ |
| PUT | `/manufacturers/{id}` | Update manufacturer | ✅ |
| DELETE | `/manufacturers/{id}` | Delete manufacturer | ✅ |
| PUT | `/withdraws/{id}` | Approve/reject withdraw | ✅ |
| POST | `/approve-withdraw` | Approve withdrawal | ✅ |
| POST | `/approve-shop` | Approve new shop | ✅ |
| POST | `/disapprove-shop` | Reject shop | ✅ |
| GET | `/new-shops` | List pending shops | ✅ |
| POST | `/settings` | Update settings | ✅ |
| DELETE | `/reviews/{id}` | Delete review | ❌ |
| DELETE | `/questions/{id}` | Delete question | ❌ |
| POST | `/refund-policies` | Create refund policy | ❌ |
| POST | `/taxes` | Create tax rate | ✅ |
| POST | `/shippings` | Create shipping zone | ✅ |
| POST | `/add-points` | Add points to user | ✅ |
| POST | `/approve-coupon` | Approve vendor coupon | ✅ |
| POST | `/disapprove-coupon` | Reject vendor coupon | ✅ |
| GET | `/abusive_reports` | List abuse reports | ✅ |
| POST | `/abusive_reports/accept` | Accept abuse report | ✅ |
| POST | `/abusive_reports/reject` | Reject abuse report | ✅ |

---

## Swagger Documentation Coverage Summary

| Category | Documented | Not Documented | Coverage |
|----------|------------|----------------|----------|
| Authentication | 9 | 0 | **100%** |
| Products | 7 | 1 | 87% |
| Categories | 5 | 0 | **100%** |
| Shops | 10 | 5 | 66% |
| Types | 5 | 0 | **100%** |
| Tags | 5 | 0 | **100%** |
| Authors | 6 | 0 | **100%** |
| Manufacturers | 6 | 0 | **100%** |
| CMS Pages | 5 | 0 | **100%** |
| User Management | 17 | 0 | **100%** |
| Staff Management | 2 | 1 | 66% |
| Orders | 3 | 5 | 37% |
| Coupons | 4 | 2 | 66% |
| Reviews/Questions | 8 | 0 | **100%** |
| Wishlist/Refunds/Messages | 15 | 0 | **100%** |
| Addresses | 5 | 0 | **100%** |
| Withdrawals | 2 | 3 | 40% |
| Settings/Tax/Shipping | 11 | 0 | **100%** |

**Priority for next documentation phase:** Orders API, Products API (Vendor), Coupons API, Reviews/Questions API
