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
<!-- wp:pediment/hero {"variant":"centered","headline":"About","subheadline":"Why Pediment exists and how it is put together."} /-->

<!-- wp:pediment/prose -->
<!-- wp:paragraph --><p>Agencies rebuild the same website machinery for every client: the hero block, the FAQ accordion, the contact form, the deployment pipeline. Each copy drifts, and every fix has to be applied as many times as there are sites.</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>Pediment moves that machinery into a single WordPress plugin, developed in one repository and updated in one place. A client site is reduced to what actually makes it that client's site: a standalone theme carrying brand tokens, content patterns and a seed manifest — no build step, no framework code, no copies of anything shared.</p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p>This site is the demonstration of that split. It was scaffolded from the client template, and every block, template and form on it is served by the plugin.</p><!-- /wp:paragraph -->
<!-- /wp:pediment/prose -->

<!-- wp:pediment/pull-quote {"quote":"Structure lives in git, content lives in the database — and the seeder arbitrates between the two instead of letting either overwrite the other.","citation":"The Pediment seeding contract"} /-->

<!-- wp:group {"align":"full","className":"starter-band is-style-band-surface","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull starter-band is-style-band-surface is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:0;margin-bottom:0">
<!-- wp:pediment/section-head {"align":"wide","alignment":"start","eyebrow":"FAQ","headline":"Common questions about the architecture","lead":""} /-->
<!-- wp:pediment/faq -->
<!-- wp:pediment/faq-item {"question":"Is Pediment a theme or a plugin?","answer":"A plugin. It ships the shared engine — blocks, templates, tokens, forms, seeding and AI authoring. Each site pairs it with its own standalone block theme."} /-->
<!-- wp:pediment/faq-item {"question":"What lives in a client theme?","answer":"Only what is specific to the client: the theme header, brand token overrides in theme.json, content patterns, a seed manifest and any client-owned blocks. Most themes need no build step at all."} /-->
<!-- wp:pediment/faq-item {"question":"How do updates reach a site?","answer":"The plugin updates itself through wp-admin, so engine fixes arrive on every site automatically. The theme only changes when its own repo tags a new release."} /-->
<!-- wp:pediment/faq-item {"question":"Can a site add its own blocks?","answer":"Yes. A client theme may register client/* blocks under the same rendering, sanitization and design-token rules the shared blocks follow, without touching the plugin."} /-->
<!-- wp:pediment/faq-item {"question":"Can an existing site move onto Pediment?","answer":"Yes. The plugin can claim existing pages by identity first, then seed only the structure that is missing — a dry-run plan gates every step so nothing is duplicated or overwritten."} /-->
<!-- /wp:pediment/faq -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"starter-band is-style-band-surface","style":{"spacing":{"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull starter-band is-style-band-surface is-layout-constrained wp-block-group-is-layout-constrained" style="margin-top:0;margin-bottom:0">
<!-- wp:pediment/cta {"align":"wide","title":"Look under the hood","body":"The plugin, client template and developer kit are developed together in one monorepo.","primaryText":"View on GitHub","primaryUrl":"https://github.com/Bergert-Digital/pediment","secondaryText":"Get in touch","secondaryUrl":"/contact/"} /-->
</div>
<!-- /wp:group -->
