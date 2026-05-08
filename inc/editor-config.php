<?php
/**
 * Pi Dentist — Editor Config
 *
 * Cấu hình Block Editor:
 * - Load CSS vào editor để preview đúng frontend
 * - Disable core block patterns mặc định
 * - Custom color palette 9 màu Pi (khoá custom color picker)
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/* ───────────────────────────────────────────────
 * 1. EDITOR STYLES — Load design tokens + pattern CSS vào editor
 * ─────────────────────────────────────────────── */
add_action( 'after_setup_theme', 'pi_editor_config_styles' );

function pi_editor_config_styles() {

	// Load tokens + base + components + tất cả pattern CSS để editor render đúng
	add_editor_style( [
		'assets/css/tokens.css',
		'assets/css/base.css',
		'assets/css/buttons.css',
		'assets/css/sections.css',
		'assets/css/cards.css',
		'assets/css/patterns/hero.css',
		'assets/css/patterns/commitments.css',
		'assets/css/patterns/philosophy.css',
		'assets/css/patterns/services-grid.css',
		'assets/css/patterns/pricing-table.css',
		'assets/css/patterns/doctors-grid.css',
		'assets/css/patterns/cases-grid.css',
		'assets/css/patterns/blog.css',
		'assets/css/patterns/single-service.css',
		'assets/css/editor.css',
	] );

	// Disable Block Editor "Pattern Library" remote (core patterns)
	remove_theme_support( 'core-block-patterns' );
}

/* ───────────────────────────────────────────────
 * 2. COLOR PALETTE — Chỉ cho phép 9 màu Pi
 * ─────────────────────────────────────────────── */
add_action( 'after_setup_theme', 'pi_editor_color_palette' );

function pi_editor_color_palette() {
	add_theme_support( 'editor-color-palette', [
		[ 'name' => 'Navy',       'slug' => 'navy',       'color' => '#002147' ],
		[ 'name' => 'Navy nhạt',  'slug' => 'navy-light', 'color' => '#003366' ],
		[ 'name' => 'Navy đậm',   'slug' => 'navy-dark',  'color' => '#001a33' ],
		[ 'name' => 'Vàng gold',  'slug' => 'gold',       'color' => '#C9A96E' ],
		[ 'name' => 'Vàng nhạt',  'slug' => 'gold-light', 'color' => '#E8D5A8' ],
		[ 'name' => 'Trắng',      'slug' => 'white',      'color' => '#FFFFFF' ],
		[ 'name' => 'Trắng warm', 'slug' => 'off-white',  'color' => '#F8F7F4' ],
		[ 'name' => 'Text',       'slug' => 'text',       'color' => '#1A1A1A' ],
		[ 'name' => 'Text nhạt',  'slug' => 'text-soft',  'color' => '#666666' ],
	] );

	// Khoá custom color picker — admin chỉ dùng được 9 màu palette Pi
	add_theme_support( 'disable-custom-colors' );
}
