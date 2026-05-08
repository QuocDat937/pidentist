<?php
/**
 * Pi Dentist — Custom Post Types
 *
 * Register 3 CPT: pi_service, pi_doctor, pi_case
 * + Đổi blog permalink base sang /kien-thuc/
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register all Custom Post Types.
 *
 * Hooked to 'init' at priority 10.
 */
add_action( 'init', 'pi_register_post_types', 10 );

function pi_register_post_types() {

	// ─── CPT 1: pi_service — Dịch vụ chỉnh nha ───────────────────────
	register_post_type( 'pi_service', array(
		'label'         => 'Dịch vụ',
		'labels'        => array(
			'name'               => 'Dịch vụ',
			'singular_name'      => 'Dịch vụ',
			'add_new'            => 'Thêm mới',
			'add_new_item'       => 'Thêm dịch vụ mới',
			'edit_item'          => 'Sửa dịch vụ',
			'new_item'           => 'Dịch vụ mới',
			'view_item'          => 'Xem dịch vụ',
			'view_items'         => 'Xem tất cả dịch vụ',
			'search_items'       => 'Tìm dịch vụ',
			'not_found'          => 'Không tìm thấy dịch vụ nào',
			'not_found_in_trash' => 'Không có dịch vụ nào trong thùng rác',
			'all_items'          => 'Tất cả dịch vụ',
			'archives'           => 'Danh sách dịch vụ',
			'menu_name'          => 'Dịch vụ',
		),
		'public'        => true,
		'has_archive'   => 'dich-vu',
		'rewrite'       => array(
			'slug'       => 'dich-vu',
			'with_front' => false,
		),
		'menu_icon'     => 'dashicons-smiley',
		'menu_position' => 20,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'show_in_rest'  => true,
		'rest_base'     => 'services',
		'taxonomies'    => array( 'pi_service_category' ),
	) );

	// ─── CPT 2: pi_doctor — Bác sĩ ───────────────────────────────────
	register_post_type( 'pi_doctor', array(
		'label'         => 'Bác sĩ',
		'labels'        => array(
			'name'               => 'Bác sĩ',
			'singular_name'      => 'Bác sĩ',
			'add_new'            => 'Thêm mới',
			'add_new_item'       => 'Thêm bác sĩ mới',
			'edit_item'          => 'Sửa bác sĩ',
			'new_item'           => 'Bác sĩ mới',
			'view_item'          => 'Xem bác sĩ',
			'view_items'         => 'Xem tất cả bác sĩ',
			'search_items'       => 'Tìm bác sĩ',
			'not_found'          => 'Không tìm thấy bác sĩ nào',
			'not_found_in_trash' => 'Không có bác sĩ nào trong thùng rác',
			'all_items'          => 'Tất cả bác sĩ',
			'archives'           => 'Danh sách bác sĩ',
			'menu_name'          => 'Bác sĩ',
		),
		'public'        => true,
		'has_archive'   => 'bac-si',
		'rewrite'       => array(
			'slug'       => 'bac-si',
			'with_front' => false,
		),
		'menu_icon'     => 'dashicons-businessperson',
		'menu_position' => 21,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'show_in_rest'  => true,
		'rest_base'     => 'doctors',
	) );

	// ─── CPT 3: pi_case — Ca điều trị ────────────────────────────────
	register_post_type( 'pi_case', array(
		'label'         => 'Ca điều trị',
		'labels'        => array(
			'name'               => 'Ca điều trị',
			'singular_name'      => 'Ca điều trị',
			'add_new'            => 'Thêm mới',
			'add_new_item'       => 'Thêm ca điều trị mới',
			'edit_item'          => 'Sửa ca điều trị',
			'new_item'           => 'Ca điều trị mới',
			'view_item'          => 'Xem ca điều trị',
			'view_items'         => 'Xem tất cả ca điều trị',
			'search_items'       => 'Tìm ca điều trị',
			'not_found'          => 'Không tìm thấy ca điều trị nào',
			'not_found_in_trash' => 'Không có ca điều trị nào trong thùng rác',
			'all_items'          => 'Tất cả ca điều trị',
			'archives'           => 'Danh sách ca điều trị',
			'menu_name'          => 'Ca điều trị',
		),
		'public'        => true,
		'has_archive'   => 'case',
		'rewrite'       => array(
			'slug'       => 'case',
			'with_front' => false,
		),
		'menu_icon'     => 'dashicons-images-alt2',
		'menu_position' => 22,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest'  => true,
		'rest_base'     => 'cases',
	) );
}

/**
 * Đổi blog permalink base sang /kien-thuc/.
 *
 * Hooked to 'init' at priority 10.
 */
add_action( 'init', 'pi_blog_permalink_base', 10 );

function pi_blog_permalink_base() {
	global $wp_rewrite;
	$wp_rewrite->permalink_structure = '/kien-thuc/%postname%/';
}
