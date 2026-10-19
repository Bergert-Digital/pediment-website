<?php
/**
 * Title: About
 * Slug: pediment-website/about
 * Categories: pediment
 * Description: About page for the Pediment demo site.
 * Inserter: no
 */
// phpcs:ignoreFile -- block pattern content
?>
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"metadata":{"name":"Hero"}} -->
<section class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":1} -->
<h1 class="wp-block-heading has-text-align-center">About</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"is-style-lead"} -->
<p class="has-text-align-center is-style-lead">Why Pediment exists and how it is put together.</p>
<!-- /wp:paragraph --></section>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-prose","layout":{"type":"constrained"},"metadata":{"name":"Prose"}} -->
<div class="wp-block-group is-style-prose"><!-- wp:paragraph --><p>Agencies rebuild the same website machinery for every client: the hero block, the FAQ accordion, the contact form, the deployment pipeline. Each copy drifts, and every fix has to be applied as many times as there are sites.</p><!-- /wp:paragraph -->

<!-- wp:paragraph --><p>Pediment moves that machinery into a single WordPress plugin, developed in one repository and updated in one place. A client site is reduced to what actually makes it that client's site: a standalone theme carrying brand tokens, content patterns and a seed manifest — no build step, no framework code, no copies of anything shared.</p><!-- /wp:paragraph -->

<!-- wp:paragraph --><p>This site is the demonstration of that split. It was scaffolded from the client template, and every block, template and form on it is served by the plugin.</p><!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:quote {"className":"is-style-pull-quote"} -->
<blockquote class="wp-block-quote is-style-pull-quote"><!-- wp:paragraph -->
<p>Structure lives in git, content lives in the database — and the seeder arbitrates between the two instead of letting either overwrite the other.</p>
<!-- /wp:paragraph --><cite>The Pediment seeding contract</cite></blockquote>
<!-- /wp:quote -->

<!-- wp:group {"align":"full","className":"starter-band is-style-band-surface","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull starter-band is-style-band-surface is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:0;margin-bottom:0">
<!-- wp:group {"align":"wide","className":"pediment-section-head","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","justifyContent":"left"},"metadata":{"name":"Section head"}} -->
<div class="wp-block-group alignwide pediment-section-head" style="margin-bottom:var(--wp--preset--spacing--60)"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">FAQ</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Common questions about the architecture</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"},"metadata":{"name":"FAQ"}} -->
<section class="wp-block-group"><!-- wp:details {"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion"><summary>Is Pediment a theme or a plugin?</summary><!-- wp:paragraph -->
<p>A plugin. It ships the shared engine — blocks, templates, tokens, forms, seeding and AI authoring. Each site pairs it with its own standalone block theme.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion"><summary>What lives in a client theme?</summary><!-- wp:paragraph -->
<p>Only what is specific to the client: the theme header, brand token overrides in theme.json, content patterns, a seed manifest and any client-owned blocks. Most themes need no build step at all.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion"><summary>How do updates reach a site?</summary><!-- wp:paragraph -->
<p>The plugin updates itself through wp-admin, so engine fixes arrive on every site automatically. The theme only changes when its own repo tags a new release.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion"><summary>Can a site add its own blocks?</summary><!-- wp:paragraph -->
<p>Yes. A client theme may register client/* blocks under the same rendering, sanitization and design-token rules the shared blocks follow, without touching the plugin.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details -->

<!-- wp:details {"className":"is-style-accordion"} -->
<details class="wp-block-details is-style-accordion"><summary>Can an existing site move onto Pediment?</summary><!-- wp:paragraph -->
<p>Yes. The plugin can claim existing pages by identity first, then seed only the structure that is missing — a dry-run plan gates every step so nothing is duplicated or overwritten.</p>
<!-- /wp:paragraph --></details>
<!-- /wp:details --></section>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"starter-band is-style-band-surface","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull starter-band is-style-band-surface is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:0;margin-bottom:0">
<!-- wp:group {"tagName":"section","align":"wide","className":"is-style-panel","layout":{"type":"constrained"},"metadata":{"name":"Call to action"}} -->
<section class="wp-block-group alignwide is-style-panel"><!-- wp:heading -->
<h2 class="wp-block-heading">Look under the hood</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The plugin, client template and developer kit are developed together in one monorepo.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-pill"} -->
<div class="wp-block-button is-style-pill"><a class="wp-block-button__link wp-element-button" href="https://github.com/Bergert-Digital/pediment">View on GitHub</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-pill-ghost"} -->
<div class="wp-block-button is-style-pill-ghost"><a class="wp-block-button__link wp-element-button" href="/contact/">Get in touch</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></section>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
