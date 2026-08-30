# Adding & managing products — quick guide

## Log in

Go to `http://localhost/nuvira-shop/wp-admin/` (or your live site's `/wp-admin/`) and log in.
You'll land straight on the **Products** list — that's the main place you'll work.

## Add a new product

1. Click **Add new product** (top of the Products page, or in the left sidebar under Products).
2. **Product name** — type it at the top (e.g. "Ceylon Cinnamon Quills").
3. **Product description** — the big text box below the name. This is the full description shown on the product page.
4. Scroll to **Product data**:
   - **Product data** dropdown — leave as **Simple product** unless you're selling something with size/weight variations (see "Variable products" below).
   - **General** tab — set **Regular price** ($). If it's on sale, also set **Sale price**.
   - **Inventory** tab — check **Manage stock?** and enter a **Quantity** if you want WooCommerce to track how many you have and show "In stock" / "Out of stock" automatically.
5. **Product short description** (further down, below Product data) — a one-liner shown on the shop grid card. Keep it short — this is what shows on the product cards on the shop page.
6. **Product image** (right sidebar) — click **Set product image** and upload a photo. This is the main image shown everywhere.
7. **Product gallery** (right sidebar, below the main image) — add extra photos if you have them (shown as additional gallery images on the product page).
8. **Product categories** (right sidebar) — tick the spice category it belongs to (Cinnamon, Chilli, Cardamom, Curry Leaf, Pepper, Blends). Click **+ Add new category** if you need a new one.
9. Click **Publish** (top right, blue button). Your product is now live on the shop.

## Edit an existing product

Products list → click the product name → change anything → click **Update** (top right).

## Put a product on sale

Open the product → **Product data → General** tab → fill in **Sale price** (must be lower than the regular price) → **Update**. The "Sale!" badge appears automatically.

## Take a product off sale / temporarily hide it

- **Remove the sale**: clear the Sale price field → Update.
- **Hide from the shop without deleting**: open the product → top right **Status: Draft** (click Edit next to Status) → Update. A draft product won't show anywhere on the site until you publish it again.
- **Out of stock**: Inventory tab → set **Stock status** to "Out of stock", or set quantity to 0 if you're tracking stock — the product page will show "Out of stock" and disable Add to Cart automatically.

## Variable products (e.g. different sizes/weights, different prices)

1. **Product data** dropdown → switch to **Variable product**.
2. **Attributes** tab → add an attribute (e.g. "Size") → type values separated by `|` (e.g. `100g | 250g | 500g`) → check **Used for variations** → Save attributes.
3. **Variations** tab → **Generate variations** → set a price (and optionally stock) for each size that appears.
4. Publish/Update.

## Orders

**WooCommerce → Orders** in the sidebar. Click an order to see what was bought, mark it as processing/completed, and see the customer's details.

## Managing categories

**Products → Categories** — add, rename, or delete spice categories from here.

## Notes specific to this site

- After any theme code changes (not product/content changes — those are always live immediately), the developer needs to run `./sync-theme.sh` to push the theme files to the local server. Adding products, editing prices, uploading images — none of that needs a sync, it's saved straight to the database and shows up immediately.
- The homepage "From the counter today" section automatically shows your 8 most recently added products — no manual work needed there.
