<?php
/**
 * GitHub-release auto-updates for a Pediment client theme.
 *
 * Points Plugin Update Checker at the theme's own public GitHub repo so updates
 * arrive through wp-admin's normal one-click flow (Dashboard → Updates /
 * Appearance → Themes) instead of manual zip uploads.
 *
 * Deliberately generic: the repo URL is read from the theme's `Update URI:`
 * header and the slug from the stylesheet directory name, so this file is
 * identical across every client theme and can live in the upstream template
 * unchanged. Nothing here is specific to any one client.
 *
 * @package Pediment
 */

declare(strict_types=1);

namespace Pediment;

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class ThemeUpdater {
	/**
	 * Wire the update checker to this theme's GitHub releases.
	 *
	 * No-ops (rather than fatals) whenever a precondition is missing, so a theme
	 * shipped without its vendored library, or without an `Update URI:` header,
	 * simply falls back to manual zip uploads instead of breaking wp-admin.
	 */
	public static function register(): void {
		if ( ! class_exists( PucFactory::class ) ) {
			return;
		}

		// Skip update checks in local/dev environments (wp-env, CI). There is no
		// point hitting the GitHub API on every admin load there, and the
		// synchronous check slows the block editor enough to flake e2e tests.
		// Real client sites default to the 'production' environment type.
		if ( function_exists( 'wp_get_environment_type' ) && 'local' === wp_get_environment_type() ) {
			return;
		}

		// The active theme's own repo drives its updates. Reading the repo from
		// the `Update URI:` header (rather than a hard-coded constant) is what
		// keeps this file identical across clients.
		$theme    = wp_get_theme();
		$repo_url = $theme->get( 'UpdateURI' );
		if ( ! is_string( $repo_url ) || '' === $repo_url ) {
			return;
		}

		// get_stylesheet(): the active theme's directory name. It must equal the
		// slug WP matches updates against, and — because the release workflow
		// names the built asset "<Text Domain>.zip" and the Text Domain equals
		// the folder name — it also equals the release-asset basename.
		$slug = get_stylesheet();

		$checker = PucFactory::buildUpdateChecker(
			$repo_url,
			get_stylesheet_directory() . '/style.css',
			$slug
		);

		// Fallback branch for reading the version header if a release is ever absent.
		if ( method_exists( $checker, 'setBranch' ) ) {
			$checker->setBranch( 'main' );
		}

		// Install the built release asset (<slug>.zip) rather than GitHub's
		// auto-generated "Source code" zip, which has the wrong folder name.
		$api = $checker->getVcsApi();
		if ( method_exists( $api, 'enableReleaseAssets' ) ) {
			$api->enableReleaseAssets( '/' . preg_quote( $slug, '/' ) . '\.zip$/' );
		}
	}
}
