# Ajax Trading Corporation — Website Rebuild

Rebuild of ajaxtradingcorp.com, built against `ATC-Website-Rebuild-Spec.md`.

## What's built in this first pass

- **Fixed SEO/OG metadata** (`resources/views/layouts/app.blade.php`) — the live site's title/description read "Ajax Trading Corporation. - Property Business"; this is corrected everywhere, plus a `LocalBusiness` JSON-LD schema that didn't exist before.
- **Admin login removed from public nav** — was previously sitting next to "Contact Us" in the main menu.
- **"Build Your Own" configurator** (`/build-your-own`) — real, working: add/remove cabinet modules, pick a board substrate, live price recalculation via `POST /build-your-own/price`, and submission goes straight to the CRM's `Inquiry` API (`App\Services\CrmInquiryService`) instead of Messenger.
- **Get a Quote form** (`/get-a-quote`) — also posts directly into the CRM, tagged `website_quote_form`.
- **Homepage highlights** condensed to a 6-item strip (`Highlight` model/migration) instead of the old 30+-post feed dump.
- Page shells for About, Portfolio, Products, and Showrooms — structured and routed, content/data wiring still to come (see below).

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
- Live product/board pricing pulled from the ERP's actual `BoardPrice`/`MaterialPrice` tables — the configurator currently uses placeholder rates in `ConfiguratorPricingService`; needs an actual data bridge from the ERP, not a second invented pricing source
- Full Products/Portfolio/Showrooms data and admin CRUD — page shells and routes exist, content management doesn't yet
- Framework upgrade path details beyond "use Laravel 11" — this project is scaffolded fresh on 11, so this only matters if content/data is being migrated from the old Laravel 7.2 codebase rather than re-entered
- The CRM's Inquiry API endpoint itself — `CrmInquiryService` assumes a REST endpoint accepting the Inquiry model's fields; confirm the actual route/auth scheme on the CRM side and adjust the service if it differs

## Architecture notes

- `App\Services\ConfiguratorPricingService` — module widths follow the 32mm cabinetmaking system so combinations match what the factory can build. Constants here should stay in sync with the ERP's pricing tables, not drift into a second source of truth.
- `App\Services\CrmInquiryService` — every lead-capturing form funnels through here. A CRM post failure never breaks the customer's experience (logged, degrades gracefully) but should get a real fallback (e.g. email alert) before this goes live.
