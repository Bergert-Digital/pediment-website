# Auto-update for scaffolded Pediment client themes — upstream design

**Date:** 2026-08-14
**Status:** Design — ready to implement in the `Bergert-Digital/pediment` monorepo (the `pediment` Conductor workspace), NOT in `pediment-website`.
**Related:** Part 1 (self-update added to `pediment-website`) is done and verified; this spec lifts that same pattern into the upstream template + scaffolder so every future client theme inherits it.

---

## Problem

Standalone client themes scaffolded from `client-template/` (via `client-kit/scripts/scaffold.mjs`) ship with **no self-update path**. Updating a live site means downloading the release zip and re-uploading it through Appearance → Themes. The Pediment *plugin* already self-updates through wp-admin; client themes should too.

Part 1 solved this for one theme (`pediment-website`) with a self-contained, dependency-free updater. This spec makes it the default for all scaffolded themes.

## The reusable pattern (established and verified in Part 1)

- **Vendored Plugin Update Checker (PUC) v5.7** in `inc/plugin-update-checker/`, `require`d directly (no composer, no autoloader wiring). ~43 files, ~360 KB.
- **Generic `inc/ThemeUpdater.php`** — client-agnostic. Reads the repo URL from the theme's `Update URI:` header (`wp_get_theme()->get('UpdateURI')`) and the slug/asset name from `get_stylesheet()`. Skips in `local` env. Enables release-asset install matching `/<slug>\.zip$/`. **This file drops into the template unchanged** (namespace `Pediment`).
- **`functions.php`** requires the PUC loader + `ThemeUpdater` and calls `ThemeUpdater::register()`.
- **`Update URI:` header** in `style.css`.
- Ships through the existing `client-release.yml` rsync with **no release-workflow change** (rsync excludes neither `inc/` nor `functions.php`).

Verified end-to-end in wp-env: installed `0.1.0` → detected `1.1.0` → resolved `https://github.com/.../releases/download/v1.1.0/pediment-website.zip` (the built asset, not GitHub's source zip).

## Upstream decisions (the hard parts)

### Decision 1 — `functions.php` is deleted for no-blocks themes (MUST fix)

`scaffold.mjs`, in the `else` branch of `withBlocks`, currently runs:

```js
await rm(path.join(target, 'functions.php'), { force: true });
await rm(path.join(target, 'src'), { recursive: true, force: true });
```

`functions.php` is a theme's **only** auto-loaded PHP entry point, so an updater booted there is deleted for every no-blocks theme (which is the default, and is exactly why `pediment-website` had no `functions.php`).

**Recommended fix:** extract block registration out of `functions.php` into `inc/blocks.php`. Then:
- `client-template/functions.php` always boots the updater and *conditionally* `require`s `inc/blocks.php` (guarded by `file_exists`).
- The scaffolder's no-blocks branch deletes `inc/blocks.php` + `src/` and **keeps** `functions.php` + `inc/ThemeUpdater.php` + `inc/plugin-update-checker/`.

This mirrors the existing "add the build script only with `--with-blocks`" pattern and avoids fragile string surgery on `functions.php`.

### Decision 2 — `Update URI` value: convention vs. real token (NEEDS A CALL)

The scaffolder has no repo-URL token (`TOKENS` = SLUG / NAME / DESCRIPTION / PLUGIN_VERSION / TEMPLATE_VERSION) and `assertNoTokens` hard-fails on any stray `__FOO__`. At scaffold time the client's GitHub repo is genuinely unknown — the scaffolder only does a local `git init -b main`, no remote.

- **Option A — SLUG convention (zero scaffolder change).** Header becomes `Update URI: https://github.com/Bergert-Digital/__PEDIMENT_SLUG__`, using the existing SLUG token. Works for themes hosted at `Bergert-Digital/<slug>` (matches `pediment-website`). **Breaks** if a client theme lives in a different org or repo name.
- **Option B — real `__PEDIMENT_REPO_URL__` token.** Add it to `TOKENS`, to `scaffold.mjs`'s `values`, and to the `/pediment:start` answers schema so the repo is captured up front. Correct and flexible; larger surface (answers schema, `/start` skill, scaffolder tests).

**Recommendation:** B if client themes can live in arbitrary/ client-owned repos (likely for an agency); A as a safe baseline otherwise. Because `ThemeUpdater` reads the header at runtime and **no-ops on an empty/missing `Update URI`**, the mechanism is convention-agnostic — only the header *value* differs, so A can ship first and B can follow without touching `ThemeUpdater.php`.

### Decision 3 — vendor PUC in the template vs. composer in the shared workflow (RECOMMEND: vendor)

- **Option A — commit vendored PUC into `client-template/inc/plugin-update-checker/`** (mirrors Part 1). `copyTemplate` copies it verbatim; PHP files carry no tokens so token replacement and `assertNoTokens` are unaffected. Zero workflow change; release zip stays self-contained. Cost: third-party library committed to the template repo and every scaffolded repo; manual version bumps.
- **Option B — add `composer.json` (PUC dep) to the template + a `composer install --no-dev` step to `client-release.yml`** (and composer at scaffold time for local dev). "Cleaner" dependency management but touches the shared workflow and reintroduces a build dependency the themes otherwise don't have.

**Recommendation:** A. Keeps the "no build step" promise and matches Part 1.

## Files to touch upstream

- `client-template/style.css` — add `Update URI:` header (value per Decision 2).
- `client-template/functions.php` — always boot the updater; move block registration to `inc/blocks.php` and `require` it conditionally (Decision 1).
- `client-template/inc/ThemeUpdater.php` — the generic updater, lifted verbatim from Part 1 (namespace `Pediment`).
- `client-template/inc/plugin-update-checker/` — vendored PUC v5.7 (Decision 3A).
- `client-template/inc/blocks.php` — **new**; block registration extracted from `functions.php`.
- `client-kit/scripts/scaffold.mjs` — no-blocks branch deletes `inc/blocks.php` + `src/` instead of `functions.php`; if Decision 2B, add `__PEDIMENT_REPO_URL__` to `TOKENS` + `values`.
- `client-kit/scripts/*` answers schema + `/pediment:start` skill — only if Decision 2B (capture repo URL).
- `phpcs.xml` (if the monorepo lints the template) — exclude `inc/plugin-update-checker/` from CS.

## Testing upstream

- **Unit (scaffold.mjs is already unit-tested):**
  - No-blocks scaffold retains `functions.php`, `inc/ThemeUpdater.php`, `inc/plugin-update-checker/plugin-update-checker.php`; does **not** retain `inc/blocks.php` or `src/`.
  - `--with-blocks` scaffold retains `inc/blocks.php` + the build script + `src/`.
  - `assertNoTokens` passes with the new `Update URI` header for both variants.
- **Integration:** scaffold a theme → wp-env → force a non-`local` environment type → confirm an update is detected against a tagged release (the Part 1 probe: build a checker, `enableReleaseAssets`, `checkForUpdates()`, assert version + `download_url`).

## Migration note

A template change does **not** retroactively add the updater to already-scaffolded themes. Each existing theme needs the Part 1 change applied individually (`pediment-website` already has it). The upstream change benefits future scaffolds only.

## Non-goals

Auto-update on/off toggle UI; delta updates; non-GitHub hosts; the plugin's own updates (it self-updates already).

## Open questions before implementing

1. **Decision 2:** SLUG convention (A) or a real repo-URL token (B)? Drives whether the answers schema / `/start` skill change.
2. **Decision 1:** confirm the `inc/blocks.php` extraction as the way to keep `functions.php` for no-blocks themes.
3. **Decision 3:** confirm vendoring (A) over adding composer to the shared workflow (B).
