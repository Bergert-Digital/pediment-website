<?php
/**
 * Pediment Website theme bootstrap.
 *
 * A Pediment client theme has almost no PHP: blocks, templates, tokens, seeding
 * and the AI editor all ship in the Pediment plugin. The one thing that must
 * live in the theme is its own update path — WordPress only auto-loads
 * functions.php for a theme, so this is the sole place to register it.
 *
 * @package Pediment
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// One-click theme updates from GitHub Releases (no manual zip uploads).
// The vendored Plugin Update Checker ships in the release zip; if it is ever
// absent, ThemeUpdater::register() no-ops and updates fall back to manual upload.
require_once __DIR__ . '/inc/plugin-update-checker/plugin-update-checker.php';
require_once __DIR__ . '/inc/ThemeUpdater.php';
\Pediment\ThemeUpdater::register();
