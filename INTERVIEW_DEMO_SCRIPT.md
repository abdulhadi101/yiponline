# YipOnline E-Commerce Interview Demo Script

## 0) Opening (30-45 seconds)

"Hi team, thanks for having me. I built this as a Laravel 12 e-commerce prototype with Inertia + Vue for the storefront and Filament for admin operations. I also added a Smarty-rendered route as a bonus to match your framework expectations. I’ll walk through customer flow, admin flow, and then a quick technical summary."

---

## 1) Quick Environment Check (20-30 seconds)

Before screen-share, ensure:

- App running (`php artisan serve`)
- Frontend assets running (`npm run dev`)
- Seeded data present (`php artisan migrate:fresh --seed`)

Demo credentials:

- **Admin**: `admin@yiponline.com` / `password`
- **Customer**: `customer@example.com` / `password`

---

## 2) Customer Flow (3-4 minutes)

### A. Product Discovery

1. Open `/`
2. Say: "This is the product listing page with pagination and search."
3. Use the search bar to filter products.
4. Click into a product detail page.

Talking points:

- Product list + detail requirement is implemented.
- Search is server-side and query-based.
- Responsive layout for mobile/desktop.

### B. Cart Operations

1. On product detail, click **Add to Cart**.
2. Open `/cart`.
3. Update quantity, remove item, then add again.

Talking points:

- Cart supports add/update/remove/clear.
- Cart badge updates in the nav.
- User feedback via flash messages.

### C. Auth + Checkout

1. If logged out, click checkout and show auth requirement.
2. Log in as customer.
3. Go to `/checkout`.
4. Show prefilled user info and submit order.
5. Land on order confirmation page.
6. Go to **My Orders** and open order details.

Talking points:

- Checkout is protected by auth middleware.
- Validation errors are displayed at form + field level.
- Order creation includes line items and stock decrement.
- Customer order history is available.

---

## 3) Admin Flow (2-3 minutes)

### A. Authorization

1. Mention: "Admin routes are protected by `auth` + custom `admin` middleware."

### B. Dashboard + Orders

1. Open `/admin`.
2. Show dashboard cards (orders/revenue/etc.).
3. Open `/admin/orders`.
4. Filter by status.
5. Open an order detail modal.
6. Update order status (e.g., pending -> completed).

Talking points:

- Admin order management requirement is implemented.
- Status workflow and visibility are live.
- Filament resources support scalability for products/users/carts.

---

## 4) Smarty Bonus (1 minute)

1. Open `/smarty/products`.
2. Show search and listing rendering.
3. Say: "This route is server-rendered with Smarty templates to demonstrate compatibility with template-driven PHP stacks."

Talking points:

- Separate Smarty renderer service.
- Dedicated Smarty templates and layout.
- Works alongside the Inertia/Vue storefront.

---

## 5) Quality & Engineering Notes (1 minute)

Mention briefly:

- Laravel conventions (controllers, models, migrations, seeders)
- Role-based access control for admin
- Inertia shared middleware for auth/flash/cart state
- Security basics covered (CSRF, Eloquent ORM, validation)
- Automated tests added for critical flows

Suggested line:

"I added feature tests for storefront actions, checkout + stock updates, admin authorization, and Smarty route behavior. Current suite passes end-to-end."

---

## 6) Close (20-30 seconds)

"That’s the complete walkthrough against the case requirements, plus Smarty bonus integration. If helpful, I can now walk through key implementation decisions or open specific files to discuss architecture and tradeoffs."

---

## 7) Fast Backup Plan (if something breaks live)

If frontend build is not running:

- Continue with backend/admin + Smarty route first.
- Use `/smarty/products` and `/admin` to prove core backend behavior.

If seeded data is missing:

- Run: `php artisan migrate:fresh --seed`
- Re-login and continue.

---

## 8) Optional Q&A Answers (ready responses)

**Q: Why Laravel + Inertia instead of pure Blade?**

"It gives SPA-like UX while keeping Laravel routing, policies, validation, and server-side control."

**Q: How did you secure admin routes?**

"With `auth` plus custom `admin` middleware tied to `is_admin` on users."

**Q: How do you ensure maintainability?**

"Feature tests for business flows, modular controllers/services, explicit migrations/seeders, and consistent route naming."

**Q: How does this align with YIP/Smarty direction?**

"I implemented a working Smarty route to demonstrate immediate readiness for template-driven modules."
