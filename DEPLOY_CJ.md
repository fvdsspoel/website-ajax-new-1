# New Ajax website — update guide for CJ (21 November 2026)

**Only the test address `new.ajaxtradingcorp.com` changes.**
Do **not** touch the live website (`ajaxtradingcorp.com`), the ERP, the CRM, their test sites or their `.env` files.
The real `www.ajaxtradingcorp.com` is switched over later, only when Sir Ferdinand approves.

**Rules**
- No password, key or `.env` value in chat, e-mail or Viber.
- If anything gives an error: stop, send a photo of the screen and the last lines of `storage/logs/laravel.log`.

---

## A — Update the code (folder `public_html/new-website`)

The folder is a git clone of `github.com/fvdsspoel/website-ajax-new-1` (branch `main`).

```bash
cd ~/public_html/new-website
git status                       # must say "nothing to commit"; if not, stop and send a photo
git log -1 --oneline             # write this line down (before)
git pull --ff-only origin main
git log -1 --oneline             # write this line down (after)
```

`composer.lock` did not change: the `vendor` folder that is already there stays good. Do not run composer.

## B — Settings (`public_html/new-website/.env`)

Check these lines (add the ones that are missing). Today the page shows "500 Server Error":
the most likely reasons are a missing `.env`, an empty `APP_KEY` or wrong database lines.

```
APP_URL=https://new.ajaxtradingcorp.com
APP_ENV=production
APP_DEBUG=false
SITE_NOINDEX=true
DB_CONNECTION=mysql
DB_DATABASE=…   (the website's own database — NOT the CRM's or the ERP's)
DB_USERNAME=…
DB_PASSWORD=…
CRM_INQUIRY_API_URL=https://crm-sales.ajaxtradingcorp.com/api/inquiry
CRM_WEBCHAT_URL=https://crm-sales.ajaxtradingcorp.com/api/webchat
CRM_WEBCHAT_API_KEY=            ← leave EMPTY for now (the Maya chat stays off; Messenger/Viber/Call work)
COMPANY_FACEBOOK_PAGE=https://www.facebook.com/profile.php?id=61559238760421
META_PIXEL_ID=                  ← empty until marketing gives it
GA4_MEASUREMENT_ID=             ← empty until marketing gives it
```

The old line `CRM_INQUIRY_API_URL=https://crm.ajaxtradingcorp.com/...` was **wrong** (that is the old site) — it must be **crm-sales**.

## C — Database and cache

```bash
cd ~/public_html/new-website
php -v                                         # 8.2 or higher
php artisan key:generate --force               # ONLY if APP_KEY in .env is empty
php artisan migrate --force                    # adds the project gallery columns
php artisan db:seed --class=PortfolioItemSeeder --force   # the 20 real projects with their photos
php artisan storage:link                       # "already exists" is fine
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## D — Check on new.ajaxtradingcorp.com (Ctrl+F5)

1. Home opens: slideshow of Ajax kitchens, "We build … made to measure.", the numbers, "All kinds of furniture", the factory, "Our boards", projects, Facebook block, showroom with map.
2. Top right **EN / TL / BIS**: the texts change to Tagalog and Bisaya.
3. **Projects**: 20 projects; a click opens all photos (arrows, swipe on a phone).
4. **Colours**: Melamine boards 33 · Plywood 6 · HPL 26.
5. **Our factory**: all machine groups incl. Stone.
6. **Design your space**: the 6 steps work; on the last step **do not send** (it would make a real inquiry in the live CRM). Sir Ferdinand does the one real test himself.
7. Phone: open the site on your phone — the green/blue bar at the bottom (Messenger, Viber, Call) and the menu button work.
8. `storage/logs/laravel.log` — no new ERROR.

## E — If it goes wrong

```bash
cd ~/public_html/new-website
git reset --hard <the "before" line from A>
php artisan optimize:clear
```
and send a photo. Nothing else on the server is affected.

## F — Send back to Sir Ferdinand

- The two `git log -1 --oneline` lines (before and after).
- "new.ajaxtradingcorp.com opens: yes / no" and a phone photo of the home page.
