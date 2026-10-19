<?php
/**
 * Title: Home
 * Slug: pediment-website/home
 * Categories: pediment
 * Description: Landing page for the Pediment demo site.
 * Inserter: no
 */
// phpcs:ignoreFile -- block pattern content
?>
<!-- wp:group {"align":"full","className":"starter-band is-style-band-surface","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull starter-band is-style-band-surface is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:0;margin-bottom:0">
<!-- wp:columns {"align":"wide","metadata":{"name":"Hero"}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"52%"} -->
<div class="wp-block-column" style="flex-basis:52%"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">Pediment</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">One engine, every client site</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">Pediment is a WordPress plugin that ships the shared site machinery — blocks, templates, design tokens, forms, seeding and AI-assisted authoring — while each site keeps its own lean, standalone theme.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-pill"} -->
<div class="wp-block-button is-style-pill"><a class="wp-block-button__link wp-element-button" href="/features/">Explore the features</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-pill-ghost"} -->
<div class="wp-block-button is-style-pill-ghost"><a class="wp-block-button__link wp-element-button" href="https://github.com/Bergert-Digital/pediment">View on GitHub</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>24 shared Gutenberg blocks</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Site structure versioned in git</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>AI-assisted page authoring</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"48%"} -->
<div class="wp-block-column" style="flex-basis:48%"><!-- wp:cover {"overlayColor":"primary","isUserOverlayColor":true,"contentPosition":"bottom center","isDark":false,"className":"is-style-media-card","style":{"dimensions":{"aspectRatio":"5/6"}},"layout":{"type":"constrained"},"metadata":{"name":"Hero media"}} -->
<div class="wp-block-cover is-light has-custom-content-position is-position-bottom-center is-style-media-card"><span aria-hidden="true" class="wp-block-cover__background has-primary-background-color has-background-dim-100 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"className":"is-style-card","layout":{"type":"constrained"},"metadata":{"name":"Hero stat"}} -->
<div class="wp-block-group is-style-card"><!-- wp:group {"className":"is-style-stat","layout":{"type":"constrained"},"metadata":{"name":"Stat"}} -->
<div class="wp-block-group is-style-stat"><!-- wp:paragraph -->
<p>24</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>shared blocks, maintained once, updated everywhere</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"},"metadata":{"name":"Metrics"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"align":"left"} -->
<p class="has-text-align-left"><strong>1</strong><br>Command to scaffold a site</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"left"} -->
<p class="has-text-align-left"><strong>0</strong><br>Build steps in a client theme</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"starter-band is-style-band-surface","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull starter-band is-style-band-surface is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:0;margin-bottom:0">
<!-- wp:group {"align":"wide","className":"pediment-section-head","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","justifyContent":"left"},"metadata":{"name":"Section head"}} -->
<div class="wp-block-group alignwide pediment-section-head" style="margin-bottom:var(--wp--preset--spacing--60)"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">How it fits together</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The engine lives in the plugin, the client owns the theme</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-lead"} -->
<p class="is-style-lead">WordPress installs one plugin. Each site pairs it with a standalone theme that carries nothing but branding, content patterns and a seed manifest.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
<!-- wp:group {"tagName":"section","align":"wide","layout":{"type":"grid","minimumColumnWidth":"max(16rem, 30%)"},"metadata":{"name":"Features"}} -->
<section class="wp-block-group alignwide"><!-- wp:group {"className":"is-style-card","layout":{"type":"constrained"},"metadata":{"name":"Feature"}} -->
<div class="wp-block-group is-style-card"><!-- wp:pediment/icon {"icon":"cube","className":"is-style-tile"} /-->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Shared blocks</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Heroes, feature grids, stats, steps, FAQs, testimonials, sliders and forms — server-rendered and sanitized, shipped by the plugin.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pediment-card-link"} -->
<p class="pediment-card-link"><a href="/features/">See the features</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-card","layout":{"type":"constrained"},"metadata":{"name":"Feature"}} -->
<div class="wp-block-group is-style-card"><!-- wp:pediment/icon {"icon":"database","className":"is-style-tile"} /-->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Seeded structure</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Pages, navigation and languages are declared in a manifest in git. A dry-run plan shows every change before it is applied.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pediment-card-link"} -->
<p class="pediment-card-link"><a href="/features/">See the features</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-card","layout":{"type":"constrained"},"metadata":{"name":"Feature"}} -->
<div class="wp-block-group is-style-card"><!-- wp:pediment/icon {"icon":"sparkle","className":"is-style-tile"} /-->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">AI-assisted authoring</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>An AI editor composes pages from the same block schemas the plugin registers, so generated content is real, editable block markup.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"pediment-card-link"} -->
<p class="pediment-card-link"><a href="/features/">See the features</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"starter-band is-style-band-elevated","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull starter-band is-style-band-elevated is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:0;margin-bottom:0">
<!-- wp:group {"align":"wide","className":"pediment-section-head","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","justifyContent":"left"},"metadata":{"name":"Section head"}} -->
<div class="wp-block-group alignwide pediment-section-head" style="margin-bottom:var(--wp--preset--spacing--60)"><!-- wp:paragraph {"className":"is-style-eyebrow"} -->
<p class="is-style-eyebrow">The workflow</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">From empty directory to client site</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->
<!-- wp:group {"align":"wide","className":"is-style-steps","layout":{"type":"grid","minimumColumnWidth":"max(12.5rem, 45%)"},"metadata":{"name":"Steps"}} -->
<div class="wp-block-group alignwide is-style-steps"><!-- wp:group {"layout":{"type":"constrained"},"metadata":{"name":"Step"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Scaffold</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>One command creates a standalone theme repo from the client template — style.css, patterns, manifest, CI and a local WordPress environment.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained"},"metadata":{"name":"Step"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Brand</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Pick an accent colour and typeface; the palette derives from it. Everything not overridden falls back to Pediment defaults.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained"},"metadata":{"name":"Step"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Seed</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The manifest plans pages, navigation and languages as a dry run first, then applies exactly what the plan showed.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"layout":{"type":"constrained"},"metadata":{"name":"Step"}} -->
<div class="wp-block-group"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Ship</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Tag a release and upload the theme zip. The plugin keeps updating itself through wp-admin from then on.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"starter-band is-style-band-surface","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull starter-band is-style-band-surface is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:0;margin-bottom:0">
<!-- wp:group {"tagName":"section","align":"wide","className":"is-style-panel","layout":{"type":"constrained"},"metadata":{"name":"Call to action"}} -->
<section class="wp-block-group alignwide is-style-panel"><!-- wp:heading -->
<h2 class="wp-block-heading">See what the engine ships</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every block, template and workflow on this site comes from the Pediment plugin — this demo is itself a scaffolded client theme.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-pill"} -->
<div class="wp-block-button is-style-pill"><a class="wp-block-button__link wp-element-button" href="/features/">Explore the features</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-pill-ghost"} -->
<div class="wp-block-button is-style-pill-ghost"><a class="wp-block-button__link wp-element-button" href="/about/">About the project</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></section>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
