<?php
/**
 * Title: Footer
 * Slug: pediment/footer
 * Categories: pediment
 * Description: Site footer for the Pediment demo site. Overrides the plugin's placeholder footer pattern — the plugin skips any slug the theme has already registered.
 * Inserter: no
 */
// phpcs:ignoreFile -- block pattern content
?>
<!-- wp:group {"tagName":"footer","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|40"}},"border":{"top":{"color":"var:preset|color|border","width":"1px"}}},"backgroundColor":"surface-elevated","layout":{"type":"constrained","contentSize":"1200px"}} -->
<footer class="wp-block-group has-border-color has-surface-elevated-background-color has-background" style="border-top-color:var(--wp--preset--color--border);border-top-width:1px;padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--40)">
  <!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|50"}}}} -->
  <div class="wp-block-columns">
    <!-- wp:column {"width":"40%"} -->
    <div class="wp-block-column" style="flex-basis:40%">
      <!-- wp:site-title {"level":0,"fontSize":"m"} /-->
      <!-- wp:paragraph {"fontSize":"xs","textColor":"foreground-muted","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
      <p class="has-foreground-muted-color has-text-color has-xs-font-size" style="margin-top:var(--wp--preset--spacing--20)">The shared site engine for agency WordPress builds — one plugin, a lean standalone theme per site. This demo is itself a scaffolded Pediment client theme.</p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:heading {"level":4,"textColor":"foreground","fontSize":"xs","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"700"},"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}}} -->
      <h4 class="wp-block-heading has-foreground-color has-text-color has-xs-font-size" style="margin-bottom:var(--wp--preset--spacing--20);font-weight:700;text-transform:uppercase;letter-spacing:0.1em">Explore</h4>
      <!-- /wp:heading -->
      <!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"},"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"fontSize":"xs"} /-->
    </div>
    <!-- /wp:column -->
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:heading {"level":4,"textColor":"foreground","fontSize":"xs","style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.1em","fontWeight":"700"},"spacing":{"margin":{"bottom":"var:preset|spacing|20"}}}} -->
      <h4 class="wp-block-heading has-foreground-color has-text-color has-xs-font-size" style="margin-bottom:var(--wp--preset--spacing--20);font-weight:700;text-transform:uppercase;letter-spacing:0.1em">Project</h4>
      <!-- /wp:heading -->
      <!-- wp:paragraph {"fontSize":"xs","textColor":"foreground-muted"} -->
      <p class="has-foreground-muted-color has-text-color has-xs-font-size"><a href="https://github.com/Bergert-Digital/pediment">Source on GitHub</a><br><a href="https://github.com/Bergert-Digital/pediment/issues">Issue tracker</a><br><a href="https://github.com/Bergert-Digital/pediment/releases">Releases</a><br><a href="https://bergert.digital">Bergert Digital</a></p>
      <!-- /wp:paragraph -->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
  <!-- wp:group {"style":{"spacing":{"margin":{"top":"var:preset|spacing|50"},"padding":{"top":"var:preset|spacing|30"}}},"layout":{"type":"flex","justifyContent":"space-between","flexWrap":"wrap"}} -->
  <div class="wp-block-group" style="margin-top:var(--wp--preset--spacing--50);padding-top:var(--wp--preset--spacing--30)">
    <!-- wp:paragraph {"fontSize":"xs","textColor":"foreground-muted"} -->
    <p class="has-foreground-muted-color has-text-color has-xs-font-size">© Bergert Digital. GPL-2.0-or-later.</p>
    <!-- /wp:paragraph -->
    <!-- wp:paragraph {"fontSize":"xs","textColor":"foreground-muted"} -->
    <p class="has-foreground-muted-color has-text-color has-xs-font-size">Built with Pediment — blocks, tokens and templates served by the plugin.</p>
    <!-- /wp:paragraph -->
  </div>
  <!-- /wp:group -->
</footer>
<!-- /wp:group -->
