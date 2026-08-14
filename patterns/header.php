<?php
/**
 * Title: Header
 * Slug: pediment-website/header
 * Categories: pediment
 * Description: Initial markup for the seeded header template part — the plugin reads this pattern once, when the theme activates; afterwards the header lives in the database.
 * Inserter: no
 */
// phpcs:ignoreFile -- block pattern content
?>
<!-- wp:group {"tagName":"header","className":"site-header","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20"},"blockGap":"0"},"border":{"bottom":{"color":"var:preset|color|border","width":"1px"}}},"backgroundColor":"surface","layout":{"type":"constrained"}} -->
<header class="wp-block-group site-header has-border-color has-surface-background-color has-background" style="border-bottom-color:var(--wp--preset--color--border);border-bottom-width:1px;padding-top:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20)">
<!-- wp:group {"align":"wide","layout":{"type":"flex","justifyContent":"space-between","flexWrap":"nowrap"},"style":{"spacing":{"blockGap":"0"}}} -->
<div class="wp-block-group alignwide">
<!-- wp:group {"className":"brand","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group brand">
<!-- wp:site-logo {"width":150,"shouldSyncIcon":false} /-->
</div>
<!-- /wp:group -->
<!-- wp:navigation {"overlayMenu":"mobile","layout":{"type":"flex","orientation":"horizontal","flexWrap":"nowrap"},"style":{"spacing":{"blockGap":"var:preset|spacing|30"},"typography":{"fontWeight":"600"}}} /-->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"accent","textColor":"surface","style":{"border":{"radius":"999px"}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-surface-color has-accent-background-color has-text-color has-background wp-element-button" href="/contact/" style="border-radius:999px">Contact</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</header>
<!-- /wp:group -->
