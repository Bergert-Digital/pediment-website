# Pediment Website

A standalone WordPress block theme built on [Pediment](https://github.com/Bergert-Digital/pediment).
The design system, blocks, templates and seeding engine ship in the **Pediment plugin**; this repo
holds only what is specific to Pediment Website: brand tokens, page content, and the seed manifest.

## Local development

```bash
npm install
npm run env:start     # http://localhost:8888
npm run seed:plan     # see what a seed would create
npm run seed
```

## Changing content

The seed bootstraps the site: it creates the pages, posts, menus and media that
`seed/manifest.php` and `patterns/*.php` declare and the site does not have yet. It never
changes the content, title or slug of a page that exists, never rewrites a menu, and keeps the
reading settings and logo you chose. It only fills gaps: an empty front page, posts page or
logo, a missing language tag, and the translation links of pages it creates.

- **New page:** declare it in `seed/manifest.php`, add `patterns/<key>.php`, run `npm run seed`.
- **Existing page:** change it in the block editor, or with the Pediment MCP tools (see the
  Pediment repo's `docs/mcp.md`). Editing its pattern file does not change the site.
- **New environments should match a live page:** run `npm run adopt -- <page-key>` and commit
  the pattern file.

## Deploying

Release Please opens a release PR on every push to `main`; merging it tags the release and
attaches `pediment-website.zip`. The theme updates itself from GitHub releases in
Appearance → Themes (`inc/ThemeUpdater.php`), or install the zip via Appearance → Themes →
Add New → Upload.

**Production (https://pedimenttheme.com/): do not press Apply plan.** The manifest does not match
the live site (it has no About page, and its contact page is "Contact us"), so Apply plan would
create pages next to the live ones. Elsewhere, Settings → Pediment Theme → Seeding → Preview
plan, then Apply plan, creates any page or menu a release added; it adds only what is missing
and never changes anything a person made.

The Pediment plugin updates itself through wp-admin. Pediment 4 hides the legacy `pediment/*`
blocks and Pediment 5 deletes them: convert a site in Settings → Pediment Theme → Convert legacy
blocks (preview first) before it gets 5.0. The steps for this site are in
`docs/superpowers/plans/2026-10-19-pediment-4-update.md` ("Production runbook").
