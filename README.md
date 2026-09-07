# Ajax Trading Corporation — Website Rebuild

Rebuild of ajaxtradingcorp.com, built against `ATC-Website-Rebuild-Spec.md`.

## Decision log

**No online prices or checkout.** Ajax hasn't sold a single product online yet, so a live-pricing/e-commerce site would be solving a problem that doesn't exist. This site's job is to look credible to both customers and technical/business partners, and to turn a visitor into a phone call or CRM lead — not to transact. Concretely: the configurator lets a customer design a kitchen and request a quote, but never shows a price. The price is still computed server-side (via the ERP pricing bridge) and attached to the CRM inquiry so the sales team has real numbers before they call back — it's just never shown in the browser.

## What's built in this first pass

- **Fixed SEO/OG metadata** (`resources/views/layouts/app.blade.php`) — the live site's title/description read "Ajax Trading Corporation. - Property Business"; this is corrected everywhere, plus a `LocalBusiness` JSON-LD schema that didn't exist before.
- **Admin login removed from public nav** — was previously sitting next to "Contact Us" in the main menu.
- **"Build Your Own" configurator** (`/build-your-own`) — real, working: add/remove cabinet modules, pick a board substrate, live price recalculation via `POST /build-your-own/price`, and submission goes straight to the CRM's `Inquiry` API (`App\Services\CrmInquiryService`) instead of Messenger.
- **Get a Quote form** (`/get-a-quote`) — also posts directly into the CRM, tagged `website_quote_form`.
- **Homepage highlights** condensed to a 6-item strip (`Highlight` model/migration) instead of the old 30+-post feed dump.
- **About, Portfolio, Products, Showrooms — now real, not shells.** About has actual company content (HQ, San Pablo City production facility, 3,000 lm/month capacity). Portfolio has a working category filter (`PortfolioItem` model) — deliberately left unseeded, since real project photos need to come from the company, not placeholder claims. Products lists actual product categories (`Product` model, seeded). Showrooms pulls from `ShowroomLocation`, seeded ONLY with confirmed locations (head office, San Pablo production facility) — the two showroom sites still under lease review (Bamberton Center/Arca South, near SM San Pablo) are deliberately not listed as open; add them once a lease is actually signed.
- **ERP pricing bridge** — rates come from the ERP's own `/api/public/substrate-prices` feed (`App\Services\ConfiguratorPricingService::substrateRates()`), cached for an hour, with an automatic fallback to placeholder rates if the ERP is unreachable. Used only server-side now (see Decision log above) — never displayed to the customer. This required a small addition on the ERP side too — see the `Ajax-erp` repo: `public_substrate_prices` table, `PublicPricingController`, and `VerifyPublicPricingApiKey` middleware. That table is admin-maintained on the ERP side, deliberately separate from job-specific production costing.

## Setup (run these on a machine with normal internet access — this environment can't reach packagist.org)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install && npm run build   # once a build pipeline/asset bundler is added — currently plain CSS/JS, no bundler required yet
```

Then set in `.env`:
- `CRM_INQUIRY_API_URL` / `CRM_INQUIRY_API_KEY` — the actual CRM Inquiry API endpoint and credentials once that's exposed on the CRM side
- `DB_*` — your database connection
- `COMPANY_*` — already defaulted from the live site's footer, override if anything's changed

## What's intentionally NOT built yet (see spec Sections 6 and 9 for reasoning)

- True 3D/photorealistic rendering in the configurator — deliberately deferred to v2; a fast, accurate 2D module layout beats a slow 3D tool
- ~~Live product/board pricing pulled from the ERP~~ — done, see "ERP pricing bridge" above. Still needed: the ERP admin needs to actually populate/maintain `public_substrate_prices` with real current rates (seeded with placeholder values for now) and rotate `ERP_PUBLIC_PRICING_API_KEY` to a real secret before this goes live
- Full Products/Portfolio/Showrooms **admin CRUD** — the models, migrations, and seeders exist and the public pages read from them, but there's no admin UI yet to add/edit entries without touching the database directly
- Framework upgrade path details beyond "use Laravel 11" — this project is scaffolded fresh on 11, so this only matters if content/data is being migrated from the old Laravel 7.2 codebase rather than re-entered
- The CRM's Inquiry API endpoint itself — `CrmInquiryService` assumes a REST endpoint accepting the Inquiry model's fields; confirm the actual route/auth scheme on the CRM side and adjust the service if it differs

## Architecture notes

- `App\Services\ConfiguratorPricingService` — module widths follow the 32mm cabinetmaking system so combinations match what the factory can build. Constants here should stay in sync with the ERP's pricing tables, not drift into a second source of truth.
- `App\Services\CrmInquiryService` — every lead-capturing form funnels through here. A CRM post failure never breaks the customer's experience (logged, degrades gracefully) but should get a real fallback (e.g. email alert) before this goes live.
