# Pediment lean child-theme template — design

**Date:** 2026-06-09
**Status:** Draft for review
**Author:** Jonas Bergert (with Claude)

## Problem

The agency child theme is meant to be a reusable starter that the author **and
third parties** instantiate many times to build client sites. The current
reality is tangled:

- `pediment-website` is a standalone repo (not a real fork — GitHub shows
  `isFork: false`, `parent: null`) that was cloned from `pediment-child-theme`
  and given a manual `upstream` remote. This confuses `gh` (it resolves to the
  upstream repo) and misrepresents the relationship.
- `pediment-child-theme` (the repo with the "correct" name for a starter) is a
  **stale, pre-rebrand snapshot** (last commit 2026-05-15; still branded
  `wp-starter-child-theme`, `Template: wp-starter-theme`).
- All current, Pediment-branded work lives in `pediment-website`, including
  things that do **not** belong in a lean public starter (AI-plugin e2e tests,
  dev-session docs) and a CI pipeline that is **not self-contained**.

## Goals

1. Ship **one canonical, lean child theme** as a GitHub **template repository**
   that the author and others can instantiate via "Use this template" —
   unlimited independent client sites, clean history each.
2. The template must be **fully self-contained**: a third-party developer can
   develop, build, lint, test, and ship it **without checking out the parent
   theme repo** and **without any private secret/PAT**.
3. Keep `pediment-website` as a **genuine demo/showcase site** — the first
   instance built from the template — with its own (legitimately different) CI.

## Non-goals

- No GitHub *fork* (capped at one per org; can't model "many sites"; makes `gh`
  default to the parent). Template repo is the right primitive.
- No reusable workflows hosted in the parent (`uses: Bergert-Digital/pediment/...`).
  Rejected: it couples every instance's CI to the parent repo (must stay public
  forever, opaque CI, `@main` drift can silently break downstream). Conflicts
  with the self-containment goal.
- No shared dev-tooling npm package in this effort (deferred "Option B"). The
  custom tooling is small; per-instance copies are the correct model for a
  template.
- The parent theme repo (`pediment`) is **not modified** by this effort.

## End-state topology

| Repo | Role | Instantiated by others? | CI model |
|---|---|---|---|
| `pediment` (parent) | FSE framework theme, installed as a release zip. Unchanged. | No | its own (unchanged) |
| `pediment-child-theme` (**template**) | Lean, self-contained starter. `is_template=true`. Carries `pediment-child-theme-X.Y.Z.zip` releases. | **Yes** — "Use this template" | self-contained (release-zip based, no PAT) |
| `pediment-website` (**demo**) | Genuine showcase instance; keeps AI e2e + dev docs. Identity/remotes cleaned up. | No | agency integration CI (cross-repo + PAT, tests vs unreleased parent/plugin) |

The current `development` is a clean linear descendant of
`pediment-child-theme/main` (its tip is the merge-base), so updating the
template repo to current content is a near-fast-forward push, not a merge.

## File disposition for the template

### Kept (the lean theme + self-contained dev surface)
- Theme core: `style.css`, `functions.php`, `theme.json` (lean — inherits
  parent), `composer.json`, `package.json`, `tsconfig.json`.
- Example block: `src/blocks/promo-banner/*` (intentional worked example;
  README already says delete-per-client).
- Build/test config: `playwright.config.ts`, `phpcs.xml.dist`,
  `phpunit.xml.dist`, `.distignore`, `.gitignore`.
- wp-env: `.wp-env.json` (parent + plugin via **public release-zip URLs** →
  self-contained), `.wp-env.override.json` handling, `tools/wp-env-mode.mjs`,
  `tools/setup-env.mjs`, `tools/check-wpenv-deps.mjs` (kept as the **on-demand**
  `npm run check:wpenv-deps` command — self-contained, needs no PAT).
- Tests: `tests/phpunit/*` (Smoke, AutoLoader, ThemeJsonInheritsPediment,
  bootstrap), `tests/e2e/smoke.spec.ts`, **trimmed** `tests/e2e/utils.ts`.
- Docs: `README.md` (rewritten for template use), `AGENTS.md`, `docs/STYLING.md`.
- Workflows: `release.yml` (already self-contained) and a **new self-contained
  `ci.yml`** (see below).

### Stripped from template (remain only in the `pediment-website` demo)
- `docs/superpowers/plans/*` (2 files) + `docs/superpowers/specs/*` (1 file) —
  dev-session artifacts.
- `tests/e2e/ai-page-generation.live.spec.ts` — tests the **pediment-ai plugin**,
  not the theme; needs a live model.
- `tests/e2e/publish-permalink.spec.ts` — exists to support the AI test.
- AI-specific helpers in `tests/e2e/utils.ts` (`openAIChatPanel`,
  `waitForChatTurnComplete`, `publishAndGetPermalink`, and `openNewPage` if used
  only by the AI flow) — trim to what `smoke.spec.ts` needs.
- `.github/workflows/check-wpenv-deps.yml` — the weekly cron + auto-PR bump.
  Bound to `STARTER_THEME_PAT` (breaks for third parties) and is more machinery
  than a lean starter needs. Stays only in `pediment-website` (the dev repo,
  where the PAT exists). The underlying `tools/check-wpenv-deps.mjs` script is
  **kept** in the template as an on-demand command.

## Self-contained CI (the key technical change)

The current `ci.yml` `phpunit`/`e2e` jobs check out `Bergert-Digital/pediment`
and `Bergert-Digital/pediment-ai` using `secrets.STARTER_THEME_PAT`, build them
from their `development` branches, and point wp-env at the local checkouts. This
**cannot** run in a third-party instance.

**New template `ci.yml`:** boot wp-env from the committed `.wp-env.json` (which
already pulls parent + plugin from public release-zip URLs). No cross-repo
checkout, no PAT. Concretely:
- `phpcs` job: unchanged (`composer install && composer lint`).
- `lint-js` job: unchanged (`npm ci && npm run lint:js && npm run build`).
- `phpunit` job: checkout child only → `composer install && npm ci` →
  `npm run env:start` (publish-mode wp-env pulls parent/plugin zips) →
  `npm run build` → run PHPUnit via `wp-env run tests-wordpress`.
- `e2e` job: checkout child only → deps → `npm run env:start` → build → activate
  theme → `npm run e2e` (smoke only).

The cross-repo/PAT CI stays in `pediment-website` (demo), where testing the
child against **unreleased** parent/plugin `development` is the legitimate goal.

## README / template-ization

- Replace "fork or download as a zip" framing with **"Use this template"**.
- Keep the first-fork rename checklist (still applies after instantiating).
- Keep the dev-mode/publish-mode docs (they work via release zips, self-contained).

## Releases

- **Re-cut `v0.1.0` on `pediment-child-theme`** once content + `release.yml`
  land there. (Registering `workflow_dispatch` requires the touch-the-file
  re-index step we already validated.)
- **`v0.1.0` release + tag on `pediment-website` — DELETED** (2026-06-09). A demo
  site should not publish a distributable theme zip.

## Demo-site cleanup (`pediment-website`)

- Fix the description (drop "Fork of pediment-child-theme").
- Resolve the `upstream` / `DISABLE_NO_PUSH` remote tangle; set
  `gh repo set-default Bergert-Digital/pediment-website`.
- Keep its cross-repo/PAT CI, the `check-wpenv-deps.yml` cron, and dev docs.
  Drop `release.yml` (not distributed).
- `v0.1.0` release/tag already removed (see Releases).

## Migration sequence (safe order)

1. **Prepare content** on a branch of the current repo: strip cruft, author the
   self-contained `ci.yml`, rewrite `README.md`, trim `tests/e2e/utils.ts`.
2. **Validate the trimmed tree locally**: `composer install`, `npm ci`,
   `npm run build`, `composer lint`, PHPUnit, e2e smoke — and confirm **no**
   parent-repo checkout / PAT anywhere.
3. **Update the template repo**: push the prepared tree to
   `pediment-child-theme/main` (clean descendant update); ensure a push-enabled
   remote (the current `upstream` is push-disabled).
4. **Mark template + release**: `is_template=true`, fix description, register +
   dispatch `release.yml`, re-cut `v0.1.0`.
5. **Validate self-containment**: "Use this template" → fresh repo → `npm ci` +
   `npm run build` + CI green with **no parent repo present and no PAT**.
6. **Clean up the demo**: `pediment-website` description, remotes, drop
   `release.yml`. (Its `v0.1.0` release/tag is already deleted.)

## Risks / open questions

- **Push access to `pediment-child-theme`**: the existing `upstream` remote is
  `DISABLE_NO_PUSH`. Implementation needs a real push-enabled remote/clone.
- **Workflow registration dance**: re-cutting the release requires touching
  `release.yml` to force GitHub Actions to index the `workflow_dispatch`
  trigger (validated earlier this session).
- **Plugin in CI**: the template keeps `pediment-ai` in `.wp-env.json` as part
  of the stack, but template CI must not *depend* on AI functionality (AI tests
  are stripped). Confirm smoke e2e passes with the plugin present but unused.
- **`theme.json` inheritance test** needs the parent theme present; the
  self-contained wp-env provides it via the release zip — confirm it passes
  without the source checkout.
- **Local clones**: implementation will need working clones of
  `pediment-child-theme` (and possibly `pediment`) with correct remotes.

## Validation / definition of done

- `pediment-child-theme` is `is_template=true`, lean (cruft removed), and its
  CI is green using only public release zips (no PAT).
- A fresh "Use this template" repo builds and passes CI **with no parent repo
  checked out and no secrets configured**.
- `pediment-child-theme` has a `v0.1.0` release with
  `pediment-child-theme-0.1.0.zip`.
- `pediment-website` is cleanly identified as a demo instance (no "fork"
  language, no stray distributable release), CI still green.
