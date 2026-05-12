<?php
/**
 * Pi Dentist — Plugin Configuration
 *
 * Quản lý auto-update policies cho plugins và WordPress core.
 *
 * Auto-update enabled:
 *   - rank-math, wordfence, updraftplus, custom-post-type-ui
 *
 * Auto-update disabled (có thể break khi update tự động):
 *   - litespeed-cache, redis-cache, nginx-helper
 *
 * Core updates:
 *   - Minor (security patches): ✓ auto
 *   - Major (x.0 releases): ✗ manual review
 *
 * @package Pidentist
 */

defined('ABSPATH') || exit;


/* ═══════════════════════════════════════════════════════════════════════
   1. Plugin Auto-Update — Whitelist approach
   Chỉ auto-update các plugin an toàn; phần còn lại manual.
   ═══════════════════════════════════════════════════════════════════════ */
add_filter('auto_update_plugin', 'pi_auto_update_plugins', 10, 2);

/**
 * Quyết định plugin nào được auto-update.
 *
 * @param bool   $update Whether to auto-update.
 * @param object $item   Plugin update data.
 * @return bool
 */
function pi_auto_update_plugins($update, $item)
{
	// Danh sách plugin slugs được phép auto-update.
	$auto_update_slugs = array(
		'seo-by-rank-math',
		'wordfence',
		'updraftplus',
		'custom-post-type-ui',
	);

	if (in_array($item->slug, $auto_update_slugs, true)) {
		return true;
	}

	// Tất cả plugin khác: KHÔNG auto-update.
	return false;
}


/* ═══════════════════════════════════════════════════════════════════════
   2. WordPress Core Auto-Updates
   - Minor/security: auto (e.g. 6.4.1 → 6.4.2)
   - Major: manual (e.g. 6.4 → 6.5) — cần test compatibility trước
   ═══════════════════════════════════════════════════════════════════════ */
add_filter('allow_minor_auto_core_updates', '__return_true');
add_filter('allow_major_auto_core_updates', '__return_false');


/* ═══════════════════════════════════════════════════════════════════════
   3. Theme Auto-Updates — Tắt cho child theme
   GeneratePress parent có thể auto-update, nhưng child theme thì không.
   ═══════════════════════════════════════════════════════════════════════ */
add_filter('auto_update_theme', 'pi_auto_update_themes', 10, 2);

/**
 * Tắt auto-update cho pidentist child theme.
 *
 * @param bool   $update Whether to auto-update.
 * @param object $item   Theme update data.
 * @return bool
 */
function pi_auto_update_themes($update, $item)
{
	// Tắt auto-update cho child theme.
	if (isset($item->theme) && 'pidentist' === $item->theme) {
		return false;
	}

	// GeneratePress parent: cho phép auto-update.
	return $update;
}


/* ═══════════════════════════════════════════════════════════════════════
   4. Disable Translation Auto-Updates
   Tránh overwrite custom Vietnamese translations.
   ═══════════════════════════════════════════════════════════════════════ */
add_filter('auto_update_translation', '__return_false');


/* ═══════════════════════════════════════════════════════════════════════
   5. Admin Notice — Plugin Compliance Check
   Cảnh báo nếu có plugin ngoài whitelist được cài.
   ═══════════════════════════════════════════════════════════════════════ */
add_action('admin_notices', 'pi_check_plugin_compliance');

/**
 * Hiển thị cảnh báo nếu plugin ngoài danh sách approved được active.
 */
function pi_check_plugin_compliance()
{
	// Chỉ hiện cho admin.
	if (!current_user_can('activate_plugins')) {
		return;
	}

	// Danh sách plugin slugs được phép (folder names).
	$approved_plugins = array(
		'custom-post-type-ui',
		'seo-by-rank-math',
		'litespeed-cache',
		'wordfence',
		'updraftplus',
		'redis-cache',
		'nginx-helper',
	);

	$active_plugins = get_option('active_plugins', array());
	$unapproved = array();

	foreach ($active_plugins as $plugin_file) {
		// Extract slug from plugin path (e.g., "wordfence/wordfence.php" → "wordfence").
		$slug = dirname($plugin_file);
		if ('.' === $slug) {
			// Single-file plugin — use filename without extension.
			$slug = basename($plugin_file, '.php');
		}

		if (!in_array($slug, $approved_plugins, true)) {
			$unapproved[] = $slug;
		}
	}

	if (empty($unapproved)) {
		return;
	}

	$slugs_list = implode(', ', array_map('esc_html', $unapproved));
	?>
	<div class="notice notice-warning is-dismissible">
		<p>
			<strong>Pi Dentist:</strong>
			Plugin ngoài danh sách approved đang active:
			<code><?php echo $slugs_list; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped via esc_html in array_map above. ?></code>.
			Xem <code>GEMINI.md § 2.5</code> — chỉ 9 plugins được phê duyệt.
		</p>
	</div>
	<?php
}
