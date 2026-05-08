<?php
/**
 * Pi Dentist Child Theme — Bootstrap
 * KHÔNG viết logic ở đây. Chỉ require các module từ /inc/
 */

defined( 'ABSPATH' ) || exit;

// 1. Constants
define( 'PIDENTIST_VERSION', '1.0.0' );
define( 'PIDENTIST_DIR', get_stylesheet_directory() );
define( 'PIDENTIST_URI', get_stylesheet_directory_uri() );

// 2. Require modules — thứ tự QUAN TRỌNG
require_once PIDENTIST_DIR . '/inc/theme-supports.php';
require_once PIDENTIST_DIR . '/inc/enqueue.php';
require_once PIDENTIST_DIR . '/inc/menus.php';
require_once PIDENTIST_DIR . '/inc/cpt.php';
require_once PIDENTIST_DIR . '/inc/taxonomies.php';
require_once PIDENTIST_DIR . '/inc/meta-fields.php';
require_once PIDENTIST_DIR . '/inc/customizer.php';
require_once PIDENTIST_DIR . '/inc/pattern-categories.php';
require_once PIDENTIST_DIR . '/inc/block-patterns.php';
require_once PIDENTIST_DIR . '/inc/synced-patterns-seed.php';
require_once PIDENTIST_DIR . '/inc/editor-config.php';
require_once PIDENTIST_DIR . '/inc/gp-hooks.php';
require_once PIDENTIST_DIR . '/inc/floating-elements.php';
require_once PIDENTIST_DIR . '/inc/shortcodes.php';
require_once PIDENTIST_DIR . '/inc/rank-math-defaults.php';
require_once PIDENTIST_DIR . '/inc/seed-data.php';
require_once PIDENTIST_DIR . '/inc/homepage-compose.php';
