<?php
/**
 * Pi Dentist — Custom Roles
 *
 * Tạo role custom `pi_marketing` cho team marketing/sales:
 * - Clone từ Editor capabilities
 * - Thêm quyền Fluent Forms (view forms, view entries, export)
 * - Thêm quyền edit/publish/delete cho CPT custom
 *
 * Chạy 1 lần qua option flag 'pi_roles_registered_v1'.
 * Nếu cần update role → tăng version flag lên v2, v3...
 *
 * Ref: PROJECT_SPEC_WP.md section 19.2
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'pi_register_custom_roles' );

/**
 * Register custom role pi_marketing.
 *
 * Clone Editor capabilities + thêm quyền Fluent Forms + CPT custom.
 * Chỉ chạy 1 lần — kết quả lưu vào DB (wp_options → wp_user_roles).
 */
function pi_register_custom_roles() {
	// Chạy 1 lần (theo flag option).
	if ( get_option( 'pi_roles_registered_v1' ) ) {
		return;
	}

	// Clone Editor capabilities.
	$editor = get_role( 'editor' );
	if ( ! $editor ) {
		return;
	}

	// Tạo role pi_marketing với base capabilities từ Editor.
	add_role(
		'pi_marketing',
		'Pi Marketing',
		$editor->capabilities
	);

	$marketing = get_role( 'pi_marketing' );
	if ( ! $marketing ) {
		return;
	}

	/* ─── Quyền Fluent Forms ─── */
	$marketing->add_cap( 'fluentform_view_forms' );
	$marketing->add_cap( 'fluentform_view_form_entries' );
	$marketing->add_cap( 'fluentform_export_forms' );

	/* ─── Quyền CPT custom ─── */
	// Nếu CPT dùng capability_type = 'post' (default CPTUI), Editor đã có
	// sẵn quyền. Thêm explicit caps cho trường hợp đổi sang custom
	// capability_type trong tương lai.
	$cpt_slugs = array( 'pi_service', 'pi_doctor', 'pi_case' );

	foreach ( $cpt_slugs as $cpt ) {
		$marketing->add_cap( "edit_{$cpt}s" );
		$marketing->add_cap( "edit_others_{$cpt}s" );
		$marketing->add_cap( "edit_published_{$cpt}s" );
		$marketing->add_cap( "publish_{$cpt}s" );
		$marketing->add_cap( "delete_{$cpt}s" );
		$marketing->add_cap( "delete_others_{$cpt}s" );
		$marketing->add_cap( "delete_published_{$cpt}s" );
		$marketing->add_cap( "read_private_{$cpt}s" );
	}

	// Đánh dấu đã chạy — không chạy lại.
	update_option( 'pi_roles_registered_v1', true );
}

/**
 * Helper: Reset roles (dùng khi develop/debug).
 *
 * Gọi hàm này 1 lần (ví dụ thêm vào init tạm) rồi xóa:
 *   pi_reset_custom_roles();
 *
 * Hoặc qua WP-CLI:
 *   wp eval "pi_reset_custom_roles();"
 */
function pi_reset_custom_roles() {
	remove_role( 'pi_marketing' );
	delete_option( 'pi_roles_registered_v1' );
}
