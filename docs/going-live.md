# Going live at shop.nuvirahub.com (cPanel hosting)

This is a checklist for launching the real site on your cPanel hosting. I can't do this part myself since it needs your hosting login — but everything I *can* prepare (the theme, this guide) is ready to go.

## 1. Create the subdomain

In cPanel → **Domains** (or **Subdomains**, depending on your cPanel version):
- Subdomain: `shop`
- Domain: `nuvirahub.com`
- Document root: accept the default (usually `public_html/shop.nuvirahub.com` or `public_html/shop`)

If nuvirahub.com's nameservers already point at this host, the subdomain works immediately — no separate DNS step needed. If your DNS is managed elsewhere (e.g. Cloudflare, a registrar's DNS), add a **CNAME** record: `shop` → your host's domain (cPanel will tell you what to point it to), or an **A** record to your server's IP if cPanel gives you one.

## 2. Install WordPress

Most cPanel hosts have a one-click installer (**Softaculous**, **WP Toolkit**, or similar — look for a "WordPress" icon in cPanel). Install it into the `shop` subdomain's folder, with:
- Site title: Nuvira Shop
- An admin username/password you'll actually use (not a demo one)

If your host has no one-click installer: download WordPress from wordpress.org, upload/extract it into the subdomain folder via **File Manager**, create a MySQL database + user in cPanel's **MySQL Databases** tool, then visit the subdomain URL to run WordPress's install wizard.

## 3. Install WooCommerce

In the new site's `/wp-admin/` → **Plugins → Add New** → search "WooCommerce" → Install → Activate. Run through its setup wizard (store address, currency, payment methods — Stripe/PayPal/etc., shipping).

## 4. Install the theme

I've packaged the current theme as a zip — attached to this message (`nuvira-shop-theme.zip`).

In `/wp-admin/` → **Appearance → Themes → Add New → Upload Theme** → choose the zip → **Install Now** → **Activate**.

## 5. Set up products, menu, and pages

- Follow `adding-products.md` (sent earlier) to add your real products and categories.
- **Appearance → Menus** — create a "Primary Menu", add the Shop link, assign it to the "Primary Menu" location.
- **Settings → Permalinks** — select "Post name" and save (needed for clean URLs like `/shop/`, `/product/...`).
- WooCommerce should have auto-created Cart/Checkout/My Account pages during its setup wizard — verify at **Pages** in the sidebar.

## 6. SSL (HTTPS)

Most cPanel hosts offer free **AutoSSL** (Let's Encrypt) — in cPanel, look for **SSL/TLS Status** or **AutoSSL**, and run it for `shop.nuvirahub.com`. Once issued, in `/wp-admin/` → **Settings → General**, make sure both "WordPress Address" and "Site Address" start with `https://`.

## 7. Final checks

- Visit `https://shop.nuvirahub.com/shop/` — confirm products, add-to-cart, cart, and checkout all work with real payment settings.
- Log in as the shop owner account and confirm they land on Products (same setup as the local dev site).
- Consider disabling **WooCommerce → Settings → General → Coming soon mode** if it's on by default (it was on the local dev install).

## What I can help with from here

- I can walk through any specific cPanel screen with you if you share what you're seeing.
- If you'd rather I do the file upload directly, I'd need FTP/SFTP or cPanel API credentials from you — happy to use those if you want to provide them, but I won't ask for them unprompted.
- Once it's live, I can help debug anything that doesn't look right by comparing it against the local dev site.
