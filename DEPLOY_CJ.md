# Ajax website — deploy guide for CJ

**Goal:** put the new website on a **temporary test address** (`new.ajaxtradingcorp.com`) on our GoDaddy cPanel, check everything there, and switch the real `www.ajaxtradingcorp.com` over only when Sir Ferdinand approves.

The old website keeps running untouched until the go-live step (Part E).

**What you received**
- `ajax-website-full.zip` — the complete new website, ready to upload (the Laravel `vendor` folder is already included, no Composer needed).
- `crm-website-chat-update.zip` — 10 changed CRM files that add the website chat with Maya (also on GitHub, `crm-sales` commit "Website live chat…").

**Requirements:** PHP **8.2 or newer** for the subdomain (cPanel → *MultiPHP Manager*), MySQL, and the extensions `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `curl`, `intl` (normally already on).

---

## Part A — Create the test address

1. cPanel → **Domains** → **Create A New Domain**
   - Domain: `new.ajaxtradingcorp.com`
   - Untick "Share document root"
   - Document root: `ajax-website/public`  ← must end in **/public**
2. cPanel → **SSL/TLS Status** → select `new.ajaxtradingcorp.com` → **Run AutoSSL** (so it opens with https).
3. cPanel → **MultiPHP Manager** → set `new.ajaxtradingcorp.com` to **PHP 8.2** (or 8.3).

## Part B — Database

cPanel → **MySQL Database Wizard**
1. Database: `ajax_website` (cPanel adds a prefix, e.g. `cpuser_ajax_website`)
2. User: `ajax_web` + a strong password (save it)
3. Privileges: **ALL PRIVILEGES** → Finish

This is a **new, separate database**. Do not use the CRM's database.

## Part C — Upload and set up the website

1. cPanel → **File Manager** → go to your home folder (`/home/<cpanel-user>/`, the one that contains `public_html`).
2. **Upload** `ajax-website-full.zip` there, then right-click → **Extract**. You should now have `/home/<cpanel-user>/ajax-website/` with `app`, `public`, `vendor`, … inside.
3. In `ajax-website/`, copy `.env.example` → rename the copy to **`.env`**, then **Edit** it:

   ```
   APP_URL=https://new.ajaxtradingcorp.com
   SITE_NOINDEX=true
   DB_DATABASE=cpuser_ajax_website      (full name with prefix)
   DB_USERNAME=cpuser_ajax_web
   DB_PASSWORD=the password from Part B
   CRM_WEBCHAT_API_KEY=                 (fill in at Part D step 3)
   COMPANY_EMAIL=                       (Ajax sales email, optional)
   ADMIN_SEED_EMAIL=admin email for /admin
   ADMIN_SEED_PASSWORD=a strong password
   ```

4. cPanel → **Terminal** (copy-paste line by line):

   ```bash
   cd ~/ajax-website
   php -v                                   # must say 8.2 or higher
   php artisan key:generate --force
   php artisan migrate --force
   php artisan db:seed --force
   php artisan db:seed --class=AdminUserSeeder --force
   php artisan storage:link
   chmod -R 775 storage bootstrap/cache
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

   If `php -v` shows an old version, use the full path instead, e.g. `/opt/cpanel/ea-php82/root/usr/bin/php artisan …`.

5. Edit `.env` again and **delete** the two `ADMIN_SEED_…` lines, then run `php artisan config:cache`.

6. Open **https://new.ajaxtradingcorp.com**. The homepage should show.

## Part D — CRM update (website chat with Maya)

1. Back up the CRM folder, then update it: `git pull` in the CRM folder, **or** upload `crm-website-chat-update.zip` into the CRM folder and **Extract** (overwrite = yes).
2. Terminal:

   ```bash
   cd ~/ajax-crm            # your CRM folder
   php artisan migrate --force
   ```
   (adds one column `webchat_token` to `inquiries`; nothing else changes)
3. Make one secret key for the chat and put the **same** value in both `.env` files:

   ```bash
   php -r "echo bin2hex(random_bytes(20)), PHP_EOL;"
   ```
   - CRM `.env`: `WEBCHAT_API_KEY=<that key>`
   - Website `.env`: `CRM_WEBCHAT_API_KEY=<same key>`
4. Clear the caches:

   ```bash
   cd ~/ajax-crm && php artisan config:clear && php artisan config:cache
   cd ~/ajax-website && php artisan config:cache
   ```

**How the chat works:** a visitor clicks "Chat with us" on the website and types. Maya answers straight away, in English or Tagalog. The chat appears in the CRM **Inquiries** list with channel **"Website chat"**. Staff can answer by clicking **Reply** there, and the visitor sees the reply in the website chat within a few seconds. After a person replies, Maya stops answering that chat.

Optional CRM `.env` settings:
- `ATC_TIMER_WEBCHAT=60` gives staff 60 seconds to answer first before Maya answers.
- `ATC_AI_WEBCHAT_ENABLED=false` turns Maya off for the website chat.

## Part E — Test checklist (on new.ajaxtradingcorp.com)

- [ ] Every menu page opens: Portfolio, Our Factory, Accessories, About, Showroom, Contact
- [ ] **EN / TL** switch changes the language and stays when you change pages
- [ ] Phone view: menu button opens and closes the menu
- [ ] **Chat:** send "hello" → Maya answers → the chat shows in CRM Inquiries as *Website chat* → reply from the CRM → the reply appears on the website
- [ ] **Get a quote** form → green "Thank you" message → the inquiry shows in the CRM (channel *Web*)
- [ ] **Design your kitchen** → add cabinets → send → the inquiry shows in the CRM with layout, colour and cabinets
- [ ] `/admin/login` works → upload a few portfolio photos and accessory photos
- [ ] Photos in `public/images/` (see `public/images/README.txt`): logo, hero, factory, machines
- [ ] Old links redirect: `/portfolios`, `/show-rooms`, `/contact-us`, `/products/list`

Send screenshots to Sir Ferdinand. Go live only after his OK.

## Part F — Go live (switch the real domain)

1. **Back up the old site:** File Manager → zip `public_html` → download it. Also export its database in phpMyAdmin.
2. cPanel → **Domains** → `ajaxtradingcorp.com` → **Manage** → change the document root to `ajax-website/public`.
   (If cPanel does not allow changing the main domain's root, move the old `public_html` contents into a folder `old-site`. Then copy everything from `ajax-website/public` into `public_html`, and edit `public_html/index.php` so both paths point to `__DIR__.'/../ajax-website/…'`. Ask Claude for the exact lines if needed.)
3. Website `.env`:
   ```
   APP_URL=https://www.ajaxtradingcorp.com
   SITE_NOINDEX=false
   ```
   then `php artisan config:cache`
4. Test the checklist again on www.ajaxtradingcorp.com.
5. Keep `new.ajaxtradingcorp.com` for a week, then delete that domain.

## If something goes wrong

- **White page / "500 error":** set `APP_DEBUG=true` in `.env`, run `php artisan config:cache`, and reload to see the error. Set it back to `false` afterwards. The log is at `storage/logs/laravel.log`.
- **Chat says "isn't connecting":** the `CRM_WEBCHAT_API_KEY` doesn't match `WEBCHAT_API_KEY`, or the CRM migration wasn't run. Check `storage/logs/laravel.log` on the website.
- **Quote form shows the red error:** check that `CRM_INQUIRY_API_URL=https://crm.ajaxtradingcorp.com/api/inquiry`. The lead details are always saved in the website log, so nothing is lost.
- **Changed `.env` but nothing changed:** run `php artisan config:cache` again.
