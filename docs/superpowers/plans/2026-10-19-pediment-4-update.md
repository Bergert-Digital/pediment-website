# Pediment 4.3.0 Update and Legacy-Block Conversion — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Move pediment-website from Pediment 3.3.0 to 4.3.0, convert its 18-block legacy
markup to core blocks (pattern files in git, stored content in dev and production), and keep
the look of every page.

**Architecture:** No theme PHP changes. The plugin pin changes in `.wp-env.json`; the
plugin's converter rewrites `patterns/*.php` and the stored pages; the theme adds CSS only
where a screenshot shows a difference that matters. Production converts through the wp-admin
tab, because production has no shell and no WP-CLI.

**Tech Stack:** WordPress 6.9, wp-env 10, Pediment plugin 4.3.0, MCP Adapter 0.7.0,
Playwright (throwaway, for screenshots), client-kit `validate-blocks.mjs`.

**Spec:** `/Users/jonas/Entwicklung/agent-channel/threads/2026-10-19-pediment-website-to-pediment-4/001-pediment.md`
plus the pediment repo's `docs/client-sites.md` ("Upgrade to 4.0") and `docs/convert.md`
(`origin/main` `3d16c75`, release 4.3.0).

## Global Constraints

- Plugin pin: `https://github.com/Bergert-Digital/pediment/releases/download/v4.3.0/pediment-plugin.zip`.
- MCP adapter pin: `https://downloads.wordpress.org/plugin/mcp-adapter.0.7.0.zip`.
- WordPress stays `WordPress/WordPress#6.9`, PHP 8.1.
- Colours only from `theme.json` presets (`var(--wp--preset--color--…)`), never literals (AGENTS.md).
- Never write pages with `wp post create` / `wp post update` (AGENTS.md).
- Never edit plugin files; client styling goes in `theme.json` / `style.css` (AGENTS.md).
- Screenshots at 375, 768 and 1440 px, full page, for `/`, `/about/`, `/features/`, `/contact/`.
- Screenshots use Playwright, never a resized Chrome window (global CLAUDE.md).
- Only one wp-env runs at a time on ports 8888/8889 (`.conductor/settings.toml`).
- No push, PR, release or production change before Jonas's review (thread R3).

## Review Focus

- The `stat` style on the navy band (`features.php:38-47`). The legacy stat had
  `.is-style-band-navy .starter-stat` rules in the plugin; the new `stat` group may show dark
  text on navy. Expect: light text, as before. Checked in Task 3 screenshots.
- The hero stat-card (`home.php:13`). Expect: two columns at 1440, stacked at 375, both CTAs,
  three ticks, the stat card with value, text and two metrics. Tick icons are dropped by
  design (`docs/convert.md`, "dropped"); every other part must be there.
- Section heads with an empty `lead` (`home.php:30`, `about.php:23`). Expect: no empty
  paragraph and no extra gap under the heading.
- The four-step grid (`home.php:31-36`). The converter writes 2 columns for four steps.
  Legacy showed 4 in a row at 1440. Expect: a visible change; Jonas decides (Task 4).
- Feature links (`home.php:21-23`). The hover arrow is dropped by design. Expect: the link
  text still shows and points to `/features/`.

---

## Open decisions for Jonas (answer before Task 4)

- **D1. Stale copy.** The pages describe 3.x: "AI-assisted authoring" / "AI editor"
  (`home.php:13,23`, `features.php:22`), "24 Gutenberg blocks" / "24 shared blocks"
  (`home.php:13`, `features.php:17,41`). In 4.x the AI chat is gone (MCP tools replace it),
  and 18 of the blocks are legacy. Options: (a) leave the copy, convert only; (b) update the
  copy in the patterns and on production in the same release. Recommendation: (b), but as a
  separate task after the conversion, so the screenshot comparison stays clean. Note: since
  4.0 a pattern edit does not change a live page; production copy changes in the editor.
- **D2. Steps layout.** Accept the converter's 2×2 steps grid, or add a theme rule for
  4 columns at wide screens. Decide after the Task 3 screenshots.
- **D3. MCP adapter.** Add it to dev (recommended, matches the 4.3.0 client template) and
  install it on production (optional; needs an application password over HTTPS).

## Files

- Modify: `.wp-env.json` — plugin pin, MCP adapter.
- Modify: `package.json` — `pediment.plugin` → `4.3.0`, `pediment.template` → `4.3.0`
  (the repo docs now follow the 4.3.0 template), `env:start` also activates `mcp-adapter`.
- Modify: `patterns/home.php`, `about.php`, `features.php`, `contact.php` — converter output.
- Modify: `AGENTS.md`, `README.md` — 4.x seeding wording from `pediment:client-template`.
- Modify: `functions.php:5-6` (comment names "the AI editor"), `.conductor/settings.toml:16-17`
  (comment says "existing pages are protected").
- Modify (only if Task 3 shows a difference to fix): `theme.json` `styles.css` or `style.css`.
- Not changed: `patterns/header.php`, `patterns/footer.php`, `templates/index.html`,
  `seed/manifest.php` (no legacy blocks; verified by grep in Task 2).
- Not committed: `.context/screenshot.mjs`, `.context/screens/` (gitignored).

---

### Task 1: Baseline screenshots of the 3.3.0 site

**Files:** Create `.context/screenshot.mjs` (gitignored).

- [ ] **Step 1:** Stop any other wp-env on 8888 (`docker ps`), then `npm run env:start`,
  `npm run seed:plan`, `npm run seed` on the current 3.3.0 pin.
  Expected: plan line `N to write, 0 protected, 0 orphan, …`; seed exits 0.
- [ ] **Step 2:** Write `.context/screenshot.mjs <outDir>`: Playwright Chromium, for each
  page × width in the Global Constraints, `waitUntil: 'networkidle'`, scroll to the bottom
  and back (so `reveal.js` shows all elements), then a full-page PNG
  `<outDir>/<page>-<width>.png`. Install with `npm install --no-save playwright` and
  `npx playwright install chromium`.
- [ ] **Step 3:** Run it to `.context/screens/old/`. Expected: 12 PNGs.
- [ ] **Step 4:** Keep the env running. Task 2 upgrades this database in place.

### Task 2: Rehearse the production path in dev (update plugin, convert stored content)

This repeats the production order on the 3.3.0 database from Task 1.

**Files:** Modify `.wp-env.json`, `package.json`.

- [ ] **Step 1:** Set the pins and scripts listed in "Files". Run `npx wp-env start --update`,
  then `npx wp-env run cli wp plugin activate mcp-adapter`.
  Expected: `wp plugin list` shows `pediment-plugin` 4.3.0 active, `mcp-adapter` 0.7.0 active.
- [ ] **Step 2:** Load `/` once as admin (`wp eval` or a browser request to `/wp-admin/`), so
  the 4.x cleanup runs. Expected: `wp post meta list <home-id>` has no `_pediment_seed_hash`;
  pages still render with legacy blocks.
- [ ] **Step 3:** `npx wp-env run cli wp pediment convert --dry-run`. Expected: 4 pages
  `preview`, 0 `failed`, `unmapped` empty. Save the output to `.context/convert-dry-run.txt`.
  Confirm header and footer have no legacy blocks:
  `grep -l 'wp:pediment/' patterns/header.php patterns/footer.php templates/*` prints nothing
  except form blocks.
- [ ] **Step 4:** Open wp-admin → Settings → Pediment Theme → Convert legacy blocks in a
  Playwright session. Expected: the same 4 posts in the preview, one batch.
- [ ] **Step 5:** `npx wp-env run cli wp pediment convert`. Expected: 4 `converted`, each with
  a `restoreRevision`.
- [ ] **Step 6:** Screenshots to `.context/screens/converted-db/`.

### Task 3: Compare and list every visible difference

- [ ] **Step 1:** For each of the 12 pairs (old vs converted-db), compare side by side
  (and pixel diff with Playwright/`pixelmatch` if sizes match).
- [ ] **Step 2:** Write `.context/differences.md`: one row per difference — page, width,
  element, old, new, cause (converter by design / missing theme style / bug), proposed action.
  Check every Review Focus line explicitly.
- [ ] **Step 3:** If a difference looks like a converter bug, write it to the thread for the
  pediment agent (Q3) instead of patching around it.

### Task 4: Theme styles for differences that matter

Only after Jonas has seen the list (D2) or for clear regressions (for example dark text on
navy).

**Files:** Modify `theme.json` (`styles.css`, the existing place for client CSS) or
`styles.blocks` partials; presets only.

- [ ] **Step 1:** Add the rule. Selectors use the plain classes the converter writes
  (`pediment-section-head`, `pediment-card-link`, `is-style-stat`, `is-style-steps`), never
  `starter-*` and never structural selectors.
- [ ] **Step 2:** Re-run the screenshots for the affected page at all 3 widths. Expected: the
  difference is gone; no other screenshot changes.
- [ ] **Step 3:** Commit: `fix(theme): style converted <block> like the legacy block`.

### Task 5: Convert the pattern files

**Files:** Modify `patterns/{home,about,features,contact}.php`.

- [ ] **Step 1:** `npx wp-env run cli wp pediment convert --patterns=wp-content/themes/pediment-website/patterns --dry-run`
  (the path is inside the container, `docs/convert.md` "Pattern files").
  Expected: 4 files would change, header/footer unchanged, 0 failed.
- [ ] **Step 2:** Run it without `--dry-run`. Expected: exit 0.
- [ ] **Step 3:** Validate each file:
  `node /Users/jonas/conductor/workspaces/pediment/cancun-v1/client-kit/scripts/validate-blocks.mjs --wp 6.9 --file patterns/<file>.php`.
  Expected: exit 0 for all 4.
- [ ] **Step 4:** `grep -nE 'wp:pediment/(hero|cta|section-head|feature|stat|step|pull-quote|faq|prose)' patterns/*.php`.
  Expected: no output (`form`, `form-field` stay).
- [ ] **Step 5:** Commit: `refactor(patterns): convert legacy Pediment blocks to core blocks`.

### Task 6: Fresh environment from the converted patterns (the CI path)

- [ ] **Step 1:** `npx wp-env clean all`, `npm run env:start`, `npm run seed:plan`, `npm run seed`.
  Expected: plan `N to write, 0 orphan, 0 unchanged.` (no `protected`), seed exit 0.
- [ ] **Step 2:** Repeat the seed-check assertions: front page HTTP 200, no "critical error",
  no "Template part has been deleted"; a second `npm run seed:plan` prints `0 to write,`.
- [ ] **Step 3:** Screenshots to `.context/screens/new/`. Expected: identical to
  `converted-db` (both come from the same converter). Any difference goes in
  `.context/differences.md`.

### Task 7: Docs

**Files:** `AGENTS.md`, `README.md`, `functions.php`, `.conductor/settings.toml`.

- [ ] **Step 1:** `AGENTS.md`: replace the "Structure goes in…" and "To capture an edit…"
  bullets and the first bullet's reason with the 4.3.0 `client-template/AGENTS.md` bullets
  (seed adds only what is missing; existing pages change through `pediment-write-page` or the
  editor; `npm run adopt -- <key>` refreshes the pattern). Keep "Pediment Website" as name.
- [ ] **Step 2:** `README.md`: replace "Changing content" and "Deploying" with the 4.3.0
  template sections, `__PEDIMENT_SLUG__` → `pediment-website`. Keep the note that the theme
  updates from GitHub releases (it has `inc/ThemeUpdater.php` since 1.1.0) instead of the
  template's "this theme does not, by design".
- [ ] **Step 3:** `functions.php:5-6`: "seeding and the AI editor" → "and seeding".
  `.conductor/settings.toml`: "existing pages are protected" → "it only creates what is missing".
- [ ] **Step 4:** `grep -rniE 'protected|re-seed|AI (chat|editor)|content hash' AGENTS.md README.md functions.php .conductor docs/brief.md`.
  Expected: no 3.x seeding claims left (`docs/brief.md` copy is D1).
- [ ] **Step 5:** Commit: `docs: describe the Pediment 4 bootstrap-only seeder`.

### Task 8: Report and stop (R3)

- [ ] **Step 1:** Write `002-pediment-website.md` / the next message in the thread with the
  screenshots table, the difference list, and the answers to Q1–Q3.
- [ ] **Step 2:** Show Jonas the old/new screenshots and the difference list. Wait for his go.
- [ ] **Step 3 (after the go):** Branch per the one-branch-per-PR rule, PR to `development`
  (CI = shared seed-check on the PR), merge, then `/pr-to-main`; release-please cuts the
  theme release (expected 1.2.2 or 1.3.0) with the converted patterns.

---

## Findings during execution (2026-10-19)

Jonas's decisions: D1 update the copy, D2 four steps in one row on wide screens, D3 install
the MCP adapter. Production URL: https://pedimenttheme.com/.

A public read of production (no login) changes the production part of this plan:

- Production runs **WordPress 7.1.3** and a plugin whose assets match **3.5.0–3.8.0**; dev
  rehearsed on 6.9 + 3.3.0. A second rehearsal on 7.1.3 + 3.8.0 + theme 1.2.1 is set up in
  `.wp-env.override.json` (gitignored).
- **Production content is not the pattern content.** Production is an AI-builder marketing site
  (Home, Features, How it works, Contact us, Blog, a blog post, a "Beispiel-Seite"). It uses
  legacy blocks dev never converted: `testimonial-grid`, `logo-cloud`, a stat-card hero with a
  photo, `prose` in a post. It still advertises the AI chat sidebar that 4.x removed.
- The manifest (home, about, features, contact) does not match production. **Never press
  "Apply plan" on production:** it would create an About page (production has none), and a
  Contact page too unless "Contact us" carries the seed key `contact`.
- D1 as built (patterns + MCP write) would replace the whole live site with the demo pages. It
  is **on hold** for production until Jonas decides which content is canonical.

Before production: Jonas exports production (Tools → Export → All content, WXR) into
`.context/`; the agent imports it into the 7.1.3 rehearsal env, converts it there, and compares
it with screenshots of the live site.

## Production runbook (after Jonas's go; Jonas or an agent in wp-admin)

Production has no shell and no WP-CLI. Every step is in wp-admin.

0. **Backup.** Take a host backup or a full export. Note the theme and plugin versions
   (Plugins, Appearance → Themes). Check revisions are on (the convert preview says so).
1. **Update the plugin.** Plugins → update Pediment to 4.3.0 (or upload
   `pediment-plugin.zip`). Load the home page, then one wp-admin page (the 4.x cleanup runs).
   Expect: pages look the same (legacy blocks still render).
2. **(D3) Install MCP Adapter 0.7.0** if the MCP tools should work on production.
3. **Update the theme** to the new release (Appearance → Themes, update from GitHub through
   `ThemeUpdater`; or upload `pediment-website.zip`). This brings the converted patterns and
   any Task 4 styles. The styles must be live before step 4.
4. **Preview.** Settings → Pediment Theme → Convert legacy blocks. Compare the preview list
   with dev (4 pages expected; production may differ, the preview is the inventory). Stop if
   the preview reports revisions disabled or `< 2`, or any `failed`.
5. **Convert** the batch. Keep the result table (Restore links).
6. **Check** each page at 375, 768, 1440 px against the rehearsal screenshots of the imported
   production content. A bad page: use its Restore link.
7. **Seeding tab:** do not press Apply plan (the manifest does not match production; see
   Findings).
8. **Copy (D1):** only after Jonas decides which content is canonical; change pages with
   `pediment-write-page` (application password over HTTPS) or in the editor.
