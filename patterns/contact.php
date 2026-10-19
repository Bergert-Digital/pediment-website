<?php
/**
 * Title: Contact
 * Slug: pediment-website/contact
 * Categories: pediment
 * Description: Contact page for the Pediment demo site.
 * Inserter: no
 */
// phpcs:ignoreFile -- block pattern content
?>
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"},"metadata":{"name":"Hero"}} -->
<section class="wp-block-group"><!-- wp:heading {"textAlign":"center","level":1} -->
<h1 class="wp-block-heading has-text-align-center">Contact</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"is-style-lead"} -->
<p class="has-text-align-center is-style-lead">Questions about Pediment, or a project it would fit?</p>
<!-- /wp:paragraph --></section>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-prose","layout":{"type":"constrained"},"metadata":{"name":"Prose"}} -->
<div class="wp-block-group is-style-prose"><!-- wp:paragraph --><p>Found a bug or have a feature idea? The fastest route is an issue on <a href="https://github.com/Bergert-Digital/pediment/issues">GitHub</a>. For everything else — evaluating Pediment for your agency, or a client project — use the form below.</p><!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:pediment/form {"successMessage":"Thanks — we'll get back to you shortly."} -->
<!-- wp:pediment/form-field {"label":"Name","fieldName":"name","required":true} /-->
<!-- wp:pediment/form-field {"fieldType":"email","label":"Email","fieldName":"email","required":true} /-->
<!-- wp:pediment/form-field {"fieldType":"textarea","label":"Message","fieldName":"message","required":true} /-->
<!-- /wp:pediment/form -->
