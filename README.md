# Ajax Trading Corporation — Website Rebuild

Rebuild of ajaxtradingcorp.com, built against `ATC-Website-Rebuild-Spec.md`.

## Decision log

**No online prices or checkout.** Ajax hasn't sold a single product online yet, so a live-pricing/e-commerce site would be solving a problem that doesn't exist. This site's job is to look credible to both customers and technical/business partners, and to turn a visitor into a phone call or CRM lead — not to transact. The configurator lets a customer design a kitchen and request a quote, but never shows a price. The price is still computed server-side (via the ERP pricing bridge) and attached to the CRM inquiry so the sales team has real numbers before they call back — it's just never shown in the browser.

**Only one showroom is real right now.** San Pablo City, co-located with the factory. Manila is a genuine upcoming location but is NOT open yet — it's seeded with `is_upcoming = true` and shows an "Opening soon" badge rather than being presented as available.

## What's built

- **Fixed SEO/OG metadata** — the live site's title/description read "Ajax Trading Corporation. - Property Business"; corrected everywhere, plus a `LocalBusiness` JSON-LD schema that didn't exist before.
- **Admin login removed from the public nav.**
- **"Build Your Own" configurator** (`/build-your-own`) — a lead-capture design tool, not a checkout. No price shown to the customer; ends in "Request a quote — talk to sales," posting straight into the CRM's `Inquiry` API instead of Messenger.
- **Get a Quote form** (`/get-a-quote`) — same CRM-connected pattern.
- **Homepage highlights** condensed to a 6-item strip instead of the old 30+-post feed dump.
- **About, Portfolio, Products, Showrooms — real content, not shells:**
  - About: real company content (Makati HQ, San Pablo City production facility, 3,000 lm/month capacity)
  - Portfolio: **34 real projects seeded from the company's own portfolio PDF** (`2026_AJAX_TRADING_CORP_PORTFOLIO_REV_1.pdf`) — real titles, categories, and descriptions across kitchens/wardrobes/custom furniture/commercial. Photos were deliberately NOT extracted and committed here (the PDF is 89MB of embedded images — that has no business bloating a git repo); upload the real photos per project through `/admin/portfolio` instead
  - Products: seeded with real product categories, no price field
  - Showrooms: only the San Pablo location is listed as open; Manila is listed as "Opening soon" — see Decision log
- **ERP pricing bridge** — the configurator's server-side price estimate (sent to the CRM, never shown to the customer) comes from the ERP's own `/api/public/substrate-prices` feed, cached for an hour, with automatic fallback to placeholder rates if the ERP is unreachable. Companion change lives in the `Ajax-erp` repo: `public_substrate_prices` table, `PublicPricingController`, `VerifyPublicPricingApiKey` middleware.
- **Admin panel** (`/admin`) — session-auth-protected CRUD for Portfolio, Products, Showrooms, and Highlights, including photo upload (stored via Laravel's public disk, not committed to git). This is how real portfolio photos, new products, and showroom updates should be added going forward — not by editing seeders or the database directly.
- **Full Laravel framework scaffolding** — `bootstrap/`, `public/index.php`, `artisan`, and the standard `config/*.php` files, pulled from the official Laravel skeleton (currently tracking Laravel ^13.17) since earlier commits had only the application layer (controllers/models/views/routes) without the framework bootstrap itself.

## Setup (run on a machine with normal internet access — this sandbox can't reach packagist.org)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link          # required for uploaded admin photos to be publicly served
```

Then set in `.env`:
- `CRM_INQUIRY_API_URL` / `CRM_INQUIRY_API_KEY` — the actual CRM Inquiry API endpoint and credentials once exposed on the CRM side
- `ERP_PUBLIC_PRICING_URL` / `ERP_PUBLIC_PRICING_API_KEY` — matching the ERP's `public_pricing_api_key` config value
- `DB_*` — your database connection
- `COMPANY_*` — already defaulted from the live site's footer

**Create the first admin account** (do this once, then remove the two lines from `.env`):
```env
ADMIN_SEED_EMAIL=you@ajaxtradingcorp.com
ADMIN_SEED_PASSWORD=<a real password, not this text>
```
```bash
php artisan db:seed --class=AdminUserSeeder
```
Then log in at `/admin/login` and change the password. This route is intentionally not linked anywhere in the public site.

**Seed reference/demo data:**
```bash
php artisan db:seed
```
Populates Showrooms, Products, and the 34 real Portfolio projects (text only — see Decision log on photos).

## Uploading the real portfolio photos

1. Log in at `/admin/login`
2. Go to Portfolio — the 34 seeded projects are there by title (e.g. "Contemporary two-tone kitchen design"), matching `2026_AJAX_TRADING_CORP_PORTFOLIO_REV_1.pdf` page by page
3. Edit each one and upload its photo from the PDF/original source files

## What's intentionally NOT built yet

- True 3D/photorealistic rendering in the configurator — deferred to v2 on purpose; a fast, accurate 2D module layout beats a slow 3D tool
- The ERP admin needs to actually populate `public_substrate_prices` with real current rates (currently seeded with placeholder values) and rotate `ERP_PUBLIC_PRICING_API_KEY` to a real secret before this goes live
- The CRM's Inquiry API endpoint itself — `CrmInquiryService` assumes a REST endpoint accepting the Inquiry model's fields; confirm the actual route/auth scheme on the CRM side and adjust if it differs
- Any asset build pipeline (Vite/npm) — the site currently uses plain CSS/JS with no bundler, which is fine at this scope; add one if that changes
- Password reset flow for admin accounts — only login/logout exist today; if an admin forgets their password, reset it via `php artisan tinker` or a fresh `AdminUserSeeder` run for now

## Architecture notes

- `App\Services\ConfiguratorPricingService` — module widths follow the 32mm cabinetmaking system so combinations match what the factory can build. Constants here should stay in sync with the ERP's pricing tables, not drift into a second source of truth.
- `App\Services\CrmInquiryService` — every lead-capturing form funnels through here. A CRM post failure never breaks the customer's experience (logged, degrades gracefully) but should get a real fallback (e.g. email alert) before this goes live.
- Admin CRUD controllers (`app/Http/Controllers/Admin/`) all follow the same shape: `validated()` for field rules, `handleUpload()` for the optional photo. Adding a fifth manageable resource means copying that pattern, not inventing a new one.
