<?php
/**
 * Pi Dentist — Custom Taxonomies
 *
 * Register 2 taxonomies: pi_service_category, pi_case_tag
 * + Seed default terms (chạy 1 lần duy nhất)
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register all Custom Taxonomies.
 *
 * Hooked to 'init' at priority 10.
 */
add_action( 'init', 'pi_register_taxonomies', 10 );

function pi_register_taxonomies() {

	// ─── Taxonomy 1: pi_service_category — Loại dịch vụ ──────────────
	register_taxonomy( 'pi_service_category', array( 'pi_service' ), array(
		'label'        => 'Loại dịch vụ',
		'labels'       => array(
			'name'              => 'Loại dịch vụ',
			'singular_name'     => 'Loại dịch vụ',
			'search_items'      => 'Tìm loại dịch vụ',
			'all_items'         => 'Tất cả loại dịch vụ',
			'parent_item'       => 'Loại dịch vụ cha',
			'parent_item_colon' => 'Loại dịch vụ cha:',
			'edit_item'         => 'Sửa loại dịch vụ',
			'update_item'       => 'Cập nhật loại dịch vụ',
			'add_new_item'      => 'Thêm loại dịch vụ mới',
			'new_item_name'     => 'Tên loại dịch vụ mới',
			'menu_name'         => 'Loại dịch vụ',
			'not_found'         => 'Không tìm thấy loại dịch vụ nào',
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array(
			'slug'       => 'loai-dich-vu',
			'with_front' => false,
		),
	) );

	// ─── Taxonomy 2: pi_case_tag — Tag ca điều trị ───────────────────
	register_taxonomy( 'pi_case_tag', array( 'pi_case' ), array(
		'label'        => 'Tag ca',
		'labels'       => array(
			'name'                       => 'Tag ca',
			'singular_name'              => 'Tag ca',
			'search_items'               => 'Tìm tag ca',
			'all_items'                  => 'Tất cả tag ca',
			'edit_item'                  => 'Sửa tag ca',
			'update_item'                => 'Cập nhật tag ca',
			'add_new_item'               => 'Thêm tag ca mới',
			'new_item_name'              => 'Tên tag ca mới',
			'menu_name'                  => 'Tag ca',
			'not_found'                  => 'Không tìm thấy tag ca nào',
			'separate_items_with_commas' => 'Phân cách tag bằng dấu phẩy',
			'add_or_remove_items'        => 'Thêm hoặc xóa tag ca',
			'choose_from_most_used'      => 'Chọn từ tag phổ biến',
		),
		'hierarchical'      => false,
		'public'            => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array(
			'slug'       => 'tag-case',
			'with_front' => false,
		),
	) );
}

/**
 * Seed default terms — chạy 1 lần duy nhất.
 *
 * Kiểm tra option 'pi_terms_seeded' để tránh chạy lại.
 * Hooked to 'init' at priority 20 (sau khi taxonomies đã register).
 */
add_action( 'init', 'pi_seed_default_terms', 20 );

function pi_seed_default_terms() {

	// Chỉ chạy 1 lần.
	if ( get_option( 'pi_terms_seeded' ) ) {
		return;
	}

	// Chỉ seed khi taxonomy đã tồn tại.
	if ( ! taxonomy_exists( 'pi_service_category' ) || ! taxonomy_exists( 'pi_case_tag' ) ) {
		return;
	}

	// ─── Seed pi_service_category ─────────────────────────────────────
	$service_categories = array(
		'Mắc cài',
		'Trong suốt',
		'Mặt trong',
		'Trẻ em',
	);

	foreach ( $service_categories as $term_name ) {
		if ( ! term_exists( $term_name, 'pi_service_category' ) ) {
			wp_insert_term( $term_name, 'pi_service_category' );
		}
	}

	// ─── Seed pi_case_tag ─────────────────────────────────────────────
	$case_tags = array(
		'hô',
		'móm',
		'thưa',
		'khấp khểnh',
		'khớp cắn sâu',
		'khớp cắn hở',
		'tuổi teen',
		'người lớn',
	);

	foreach ( $case_tags as $term_name ) {
		if ( ! term_exists( $term_name, 'pi_case_tag' ) ) {
			wp_insert_term( $term_name, 'pi_case_tag' );
		}
	}

	// Đánh dấu đã seed — không chạy lại.
	update_option( 'pi_terms_seeded', true );
}
