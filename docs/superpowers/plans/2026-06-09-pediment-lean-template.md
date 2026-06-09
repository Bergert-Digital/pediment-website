# Pediment Lean Child-Theme Template — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Turn `Bergert-Digital/pediment-child-theme` into a lean, self-contained GitHub **template repository** (no parent-repo dependency, no PAT) that the author and third parties can instantiate into client sites, while keeping `pediment-website` as the demo/dev instance.

**Architecture:** Take the current (Pediment-rebranded) child-theme content from `pediment-website`, strip the demo-/process-specific cruft, swap in a self-contained CI that boots wp-env from public release zips, and publish it on `pediment-child-theme` as a template with a re-cut `v0.1.0`. Then clean up `pediment-website` as a plain demo instance.

**Tech Stack:** WordPress block theme, `@wordpress/env` (Docker-backed local WP), `@wordpress/scripts` (build/lint), Composer + WPCS (phpcs), PHPUnit, Playwright, GitHub Actions, `gh` CLI.

**Spec:** [docs/superpowers/specs/2026-06-09-pediment-lean-template-design.md](../specs/2026-06-09-pediment-lean-template-design.md)

---

## File matrix (what differs between the two repos)

| Path | Template (`pediment-child-theme`) | Demo (`pediment-website`) |
|---|---|---|
| `.github/workflows/ci.yml` | **NEW** self-contained (release-zip wp-env, no PAT) | keep existing cross-repo/PAT version |
| `.github/workflows/release.yml` | **keep** | drop |
| `.github/workflows/check-wpenv-deps.yml` | **drop** | keep |
| `docs/superpowers/**` | **drop** (all plans/specs) | keep |
| `docs/STYLING.md` | keep | keep |
| `tests/e2e/ai-page-generation.live.spec.ts` | **drop** | keep |
| `tests/e2e/publish-permalink.spec.ts` | **drop** | keep |
| `tests/e2e/utils.ts` | **delete** (smoke doesn't import it) | keep |
| `tests/e2e/smoke.spec.ts` | keep | keep |
| `tools/check-wpenv-deps.mjs` + `npm run check:wpenv-deps` | keep (on-demand, no PAT) | keep |
| everything else (theme core, blocks, tools, configs) | keep | keep |

---

## Phase 0 — Setup & remote inventory

### Task 0.1: Inventory the target repo's current remote state

**Files:** none (read-only).

- [ ] **Step 1: Record `pediment-child-theme`'s default branch, workflows, and branch protection**

Run:
```bash
gh repo view Bergert-Digital/pediment-child-theme --json defaultBranchRef,isTemplate,visibility -q '{default: .defaultBranchRef.name, template: .isTemplate, vis: .visibility}'
gh api repos/Bergert-Digital/pediment-child-theme/actions/workflows --jq '.workflows[] | "\(.name)\t\(.path)\t\(.state)"'
gh api repos/Bergert-Digital/pediment-child-theme/branches/main/protection 2>&1 | head -3 || echo "(no protection on main)"
```
Expected: note the default branch (likely `main`), that `isTemplate` is `false`, visibility `PUBLIC`, and whether `main` is protected (if protected, lift protection before the force-update in Task 2.1, restore after).

### Task 0.2: Create the working clone of the target repo

**Files:** working clone at `/Users/jonas/Entwicklung/pediment-child-theme` (outside this repo, not committed). The dir name **must** equal the theme slug `pediment-child-theme` so local wp-env mounts the theme at `wp-content/themes/pediment-child-theme` (matching the CI/README).

- [ ] **Step 1: Guard against an existing dir, clone the target, add the demo as a content source**

Run:
```bash
cd /Users/jonas/Entwicklung
test -e pediment-child-theme && { echo "ABORT: /Users/jonas/Entwicklung/pediment-child-theme already exists"; } || true
gh repo clone Bergert-Digital/pediment-child-theme pediment-child-theme
cd pediment-child-theme
git remote add demo /Users/jonas/Entwicklung/pediment-website
git fetch demo
```
Expected: no ABORT line; clone succeeds; `git fetch demo` pulls the current `development` history. (If the dir already exists and is unrelated, choose another slug-matching location and adjust paths.)

- [ ] **Step 2: Confirm the demo tip is a descendant of the target main**

Run:
```bash
git merge-base --is-ancestor origin/main demo/development && echo "FF-able" || echo "diverged — will force-update (intentional supersede)"
```
Expected: prints `FF-able` (or `diverged` — either is fine; Task 2.1 force-updates intentionally).

---

## Phase 1 — Build the lean template content (in `../pediment-child-theme-build`)

> All Phase 1 steps run in `/Users/jonas/Entwicklung/pediment-child-theme`.

### Task 1.1: Stage current content on a build branch

**Files:** none (git plumbing).

- [ ] **Step 1: Create a `templatize` branch at the demo's current tip**

Run:
```bash
git checkout -b templatize demo/development
```
Expected: branch `templatize` now holds the full current content (cruft included), ready to strip.

- [ ] **Step 2: Commit (checkpoint the pre-strip state)**

No commit needed yet — the branch points at an existing commit. Proceed.

### Task 1.2: Remove cruft files

**Files:**
- Delete: `docs/superpowers/` (whole dir), `tests/e2e/ai-page-generation.live.spec.ts`, `tests/e2e/publish-permalink.spec.ts`, `tests/e2e/utils.ts`, `.github/workflows/check-wpenv-deps.yml`

- [ ] **Step 1: Remove the cruft**

Run:
```bash
git rm -r docs/superpowers
git rm tests/e2e/ai-page-generation.live.spec.ts tests/e2e/publish-permalink.spec.ts tests/e2e/utils.ts
git rm .github/workflows/check-wpenv-deps.yml
```
Expected: 5 deletions staged (1 dir + 4 files). `docs/STYLING.md` remains.

- [ ] **Step 2: Verify only the intended e2e test remains**

Run: `ls tests/e2e/`
Expected: exactly `smoke.spec.ts`.

### Task 1.3: Replace `ci.yml` with the self-contained version

**Files:**
- Overwrite: `.github/workflows/ci.yml`

- [ ] **Step 1: Write the new self-contained CI**

Replace the entire contents of `.github/workflows/ci.yml` with:

```yaml
name: CI

on:
  pull_request:
  push:
    branches: [main]

jobs:
  phpcs:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
          tools: composer
      - run: composer install --prefer-dist --no-progress
      - run: composer lint

  lint-js:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: actions/setup-node@v4
        with:
          node-version: '20'
          cache: npm
      - run: npm ci
      - run: npm run lint:js
      - run: npm run build

  phpunit:
    runs-on: ubuntu-latest
    # Checkout to a FIXED directory so the wp-env theme slug is always
    # "pediment-child-theme" — independent of the instance repo's name.
    steps:
      - uses: actions/checkout@v4
        with:
          path: pediment-child-theme
      - uses: actions/setup-node@v4
        with:
          node-version: '20'
          cache: npm
          cache-dependency-path: pediment-child-theme/package-lock.json
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
          tools: composer
      - name: Install deps + build
        run: cd pediment-child-theme && composer install --prefer-dist --no-progress && npm ci && npm run build
      # Publish mode: .wp-env.json pulls parent + plugin from public release
      # zips; no .wp-env.override.json in CI. Fully self-contained — no
      # cross-repo checkout, no PAT.
      - name: Start wp-env
        run: cd pediment-child-theme && npm run env:start
      - name: Run PHPUnit
        run: cd pediment-child-theme && npx wp-env run tests-wordpress --env-cwd=wp-content/themes/pediment-child-theme vendor/bin/phpunit
      - if: always()
        run: cd pediment-child-theme && npm run env:stop

  e2e:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
        with:
          path: pediment-child-theme
      - uses: actions/setup-node@v4
        with:
          node-version: '20'
          cache: npm
          cache-dependency-path: pediment-child-theme/package-lock.json
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'
          tools: composer
      - name: Install deps + build
        run: cd pediment-child-theme && composer install --prefer-dist --no-progress && npm ci && npm run build
      - run: cd pediment-child-theme && npx playwright install --with-deps chromium
      - name: Start wp-env
        run: cd pediment-child-theme && npm run env:start
      - name: Activate child theme
        run: cd pediment-child-theme && npx wp-env run cli wp theme activate pediment-child-theme
      - run: cd pediment-child-theme && npm run e2e
      - if: always()
        run: cd pediment-child-theme && npm run env:stop
      - if: failure()
        uses: actions/upload-artifact@v4
        with:
          name: playwright-report
          path: pediment-child-theme/playwright-report/
```

- [ ] **Step 2: Verify no PAT / cross-repo reference remains in any workflow**

Run: `grep -rn "STARTER_THEME_PAT\|repository: Bergert-Digital" .github/workflows/`
Expected: **no output** (exit 1). If anything prints, remove it.

### Task 1.4: Re-point the README at "Use this template"

**Files:**
- Modify: `README.md`

- [ ] **Step 1: Replace the opening paragraph**

Find the intro paragraph (currently begins "The agency starting point. … Fork or download as a zip…") and replace it with:

```markdown
The agency starting point — a lean child theme of [Pediment](https://github.com/Bergert-Digital/pediment), published as a **GitHub template**. Click **"Use this template"** to create a fresh, independent repo for a client site (clean history, no fork relationship), then rename it and add your blocks and `theme.json` overrides. It is **self-contained**: you develop, build, and test it without checking out the parent theme — wp-env pulls the parent and the optional `pediment-ai` plugin from their published release zips.
```

- [ ] **Step 2: Add a "Create a new client site" section immediately after the intro**

Insert:

```markdown
## Create a new client site

1. Click **Use this template → Create a new repository** on GitHub.
2. Clone your new repo and run the rename checklist below.
3. `composer install && npm install`, then `npm run env:setup` to boot a local WordPress with the Pediment parent + plugin pulled from release zips.

You never need the parent theme repo locally — only its published releases, which wp-env downloads automatically.
```

- [ ] **Step 3: Remove any remaining "fork"/"clone the parent" framing**

Run: `grep -n "Fork or download\|fork this repo\|clone the parent" README.md`
Expected: no output. Edit out any remaining instances (keep the "first-fork rename checklist" heading — it still applies to instances).

### Task 1.5: Validate the template builds and passes CI-equivalent checks locally

> This proves self-containment: it must pass with **no parent repo present** and **no secrets**. Stop the user's main wp-env first to avoid an `:8890` port collision (`cd /Users/jonas/Entwicklung/pediment-website && npm run env:stop` if it's running).

**Files:** none (validation only).

- [ ] **Step 1: Install dependencies**

Run:
```bash
composer install --prefer-dist --no-progress
npm install
```
Expected: both succeed.

- [ ] **Step 2: Lint + build**

Run:
```bash
composer lint
npm run lint:js
npm run build
```
Expected: phpcs clean, eslint clean, build emits `build/blocks/...`.

- [ ] **Step 3: Confirm wp-env is in publish mode (no override pointing at local siblings)**

Run: `cat .wp-env.override.json 2>/dev/null || echo "(no override — base config, publish mode)"`
Expected: either no override file, or one with no `../pediment` paths. If it has local paths, run `npm run env:publish`.

- [ ] **Step 4: Boot wp-env and run PHPUnit (pulls parent zip — self-contained)**

Run:
```bash
npm run env:start
npx wp-env run tests-wordpress --env-cwd=wp-content/themes/pediment-child-theme vendor/bin/phpunit
```
Expected: wp-env downloads the `pediment` + `pediment-ai` release zips; PHPUnit passes (incl. `ThemeJsonInheritsPedimentTest`, which needs the parent present).

- [ ] **Step 5: Run the e2e smoke test**

Run:
```bash
npx playwright install chromium
npx wp-env run cli wp theme activate pediment-child-theme
npm run e2e
```
Expected: `smoke.spec.ts` passes (home page < 400, no fatal error).

- [ ] **Step 6: Stop wp-env**

Run: `npm run env:stop`
Expected: containers stop.

### Task 1.6: Commit the templatize change

**Files:** the staged deletions + `ci.yml` + `README.md`.

- [ ] **Step 1: Commit**

Run:
```bash
git add -A
git commit -m "feat: lean self-contained child-theme template

Strip demo/process cruft (superpowers docs, AI e2e suite, utils), drop the
PAT-bound check-wpenv-deps cron, replace CI with a self-contained pipeline
that boots wp-env from public release zips, and re-point the README at
'Use this template'.

Co-Authored-By: Claude Opus 4.8 (1M context) <noreply@anthropic.com>"
```
Expected: one commit on `templatize`.

---

## Phase 2 — Publish `pediment-child-theme` as the template

### Task 2.1: Update the target's `main` to the templatized content

**Files:** none (push).

- [ ] **Step 1: (If `main` is protected per Task 0.1) temporarily lift protection**

Run (only if protection exists):
```bash
gh api -X DELETE repos/Bergert-Digital/pediment-child-theme/branches/main/protection
```
Expected: protection removed (restore after Task 2.3 if it existed).

- [ ] **Step 2: Push the templatized content to `main`**

Run:
```bash
git push origin templatize:main --force-with-lease
```
Expected: `main` now points at the templatize commit. Force is intentional — the prior `main` was the stale pre-rebrand snapshot being superseded.

### Task 2.2: Mark it a template and fix metadata

**Files:** none (GitHub API).

- [ ] **Step 1: Set `is_template` and the description**

Run:
```bash
gh api -X PATCH repos/Bergert-Digital/pediment-child-theme \
  -f is_template=true \
  -f description='Lean, self-contained agency starter child theme for Pediment. Use this template to spin up a client site.'
```
Expected: response shows `"is_template": true`.

### Task 2.3: Register and cut the `v0.1.0` release

**Files:** none (workflow dispatch).

- [ ] **Step 1: Confirm `release.yml` is registered as a dispatchable workflow**

Run:
```bash
gh api repos/Bergert-Digital/pediment-child-theme/actions/workflows --jq '.workflows[] | select(.path==".github/workflows/release.yml") | "\(.id) \(.state)"'
```
Expected: an id prints. **If nothing prints**, force a re-index by touching the file:
```bash
# in /Users/jonas/Entwicklung/pediment-child-theme on the main branch
git checkout main && git pull
printf '\n# (registration nudge)\n' >> .github/workflows/release.yml
git commit -am "ci: force Actions to register release.yml"
git push origin main
# poll until it appears, then continue
```

- [ ] **Step 2: Dispatch the release for 0.1.0**

Run:
```bash
gh workflow run release.yml -R Bergert-Digital/pediment-child-theme --ref main -f version=0.1.0 -f ref=main
```
Expected: dispatch accepted (prints a run URL or succeeds silently).

- [ ] **Step 3: Wait for the run and verify the release + asset**

Run:
```bash
sleep 20; gh run list -R Bergert-Digital/pediment-child-theme --workflow=release.yml -L 1 --json status,conclusion,databaseId
# once completed:
gh release view v0.1.0 -R Bergert-Digital/pediment-child-theme --json tagName,assets --jq '.tagName, (.assets[].name)'
```
Expected: run `completed/success`; release `v0.1.0` exists with asset `pediment-child-theme-0.1.0.zip`.

- [ ] **Step 4: (If protection was lifted in Task 2.1) restore it.**

Re-apply the protection settings recorded in Task 0.1.

---

## Phase 3 — Validate self-containment from a fresh instance

### Task 3.1: Create a throwaway instance via the template

**Files:** none.

- [ ] **Step 1: Generate a new repo from the template**

Run:
```bash
gh repo create Bergert-Digital/pediment-tmpl-smoketest --template Bergert-Digital/pediment-child-theme --public
```
Expected: new repo created from the template (independent history, not a fork).

- [ ] **Step 2: Confirm its CI runs green with no PAT and no parent repo**

Run:
```bash
sleep 30
gh run list -R Bergert-Digital/pediment-tmpl-smoketest -L 4 --json name,status,conclusion
```
Expected: the `CI` workflow runs; once complete, all jobs `success`. (No `STARTER_THEME_PAT` exists in the new repo — proves self-containment.) If a job fails, read its log, fix the template `ci.yml` (Task 1.3), re-cut, and retry before declaring done.

### Task 3.2: Delete the throwaway

**Files:** none.

- [ ] **Step 1: Remove the smoketest repo**

Run:
```bash
gh repo delete Bergert-Digital/pediment-tmpl-smoketest --yes
```
Expected: repo deleted. (Requires `delete_repo` scope; if `gh` lacks it, run `gh auth refresh -s delete_repo` first, or delete via the web UI.)

---

## Phase 4 — Clean up `pediment-website` as the demo instance

> These run in the existing checkout `/Users/jonas/Entwicklung/pediment-website` on a short-lived worktree off `development`, merged back when green.

### Task 4.1: Drop the release workflow from the demo

**Files:**
- Delete: `.github/workflows/release.yml`

- [ ] **Step 1: Remove it**

Run:
```bash
cd /Users/jonas/Entwicklung/pediment-website
git rm .github/workflows/release.yml
```
Expected: deletion staged. (The demo site is not distributed as a zip; `check-wpenv-deps.yml` and the cross-repo `ci.yml` stay.)

- [ ] **Step 2: Commit**

Run:
```bash
git commit -m "chore: drop release workflow — pediment-website is a demo instance, not a distributable

Co-Authored-By: Claude Opus 4.8 (1M context) <noreply@anthropic.com>"
```
Expected: one commit.

### Task 4.2: Fix the demo's identity and remotes

**Files:** none (GitHub API + git remotes).

- [ ] **Step 1: Fix the description**

Run:
```bash
gh api -X PATCH repos/Bergert-Digital/pediment-website \
  -f description='Demo/showcase site built from the Pediment child-theme template.'
```
Expected: description updated (no "Fork of…" language).

- [ ] **Step 2: Remove the confusing push-disabled `upstream` remote and pin gh's default repo**

Run:
```bash
git remote remove upstream
gh repo set-default Bergert-Digital/pediment-website
git remote -v
```
Expected: only `origin` remains; `gh` now resolves to `pediment-website` (no more accidental upstream targeting).

- [ ] **Step 3: Push the cleanup branch and open/merge per the repo's normal flow**

Run:
```bash
git push origin HEAD
```
Expected: pushed; CI green; merge to `development` via the project's usual process.

---

## Definition of done

- [ ] `pediment-child-theme` is `is_template=true`, lean (cruft removed), with a self-contained `ci.yml` (no PAT, no cross-repo checkout).
- [ ] A fresh "Use this template" repo passes CI with **no secrets configured and no parent repo checked out** (verified in Task 3.1).
- [ ] `pediment-child-theme` has a `v0.1.0` release with `pediment-child-theme-0.1.0.zip`.
- [ ] `pediment-website` has no `release.yml`, no `upstream` remote, an accurate description, and green CI.
- [ ] Working clone `/Users/jonas/Entwicklung/pediment-child-theme` can be deleted after merge.
