<?php
/**
 * Pi Dentist — Rank Math Defaults
 *
 * SEO defaults: meta description, schema, title templates.
 * Rank Math plugin phải active để hooks hoạt động.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;


/* ═══════════════════════════════════════════════════════════════════════
   1. Default Meta Description cho Front Page
   Nếu admin chưa set meta description trong Rank Math,
   hook này inject default description cho trang chủ.
   ═══════════════════════════════════════════════════════════════════════ */
add_filter( 'rank_math/frontend/description', 'pi_default_front_page_description' );

/**
 * Cung cấp meta description mặc định cho trang chủ.
 *
 * @param string $description Current description từ Rank Math.
 * @return string Description đã bổ sung nếu thiếu.
 */
function pi_default_front_page_description( $description ) {
	if ( ! is_front_page() ) {
		return $description;
	}

	// Nếu admin đã set description trong Rank Math, giữ nguyên.
	if ( ! empty( $description ) ) {
		return $description;
	}

	return 'Pi Dentist — Phòng khám chỉnh nha chuyên sâu tại TP. Hồ Chí Minh. Bác sĩ đào tạo quốc tế, công nghệ CBCT 3D & scan kỹ thuật số. Đặt lịch tư vấn miễn phí.';
}


/* ═══════════════════════════════════════════════════════════════════════
   2. Fallback <meta name="description"> khi Rank Math không active
   Đảm bảo trang chủ luôn có meta description dù chưa cài plugin.
   ═══════════════════════════════════════════════════════════════════════ */
add_action( 'wp_head', 'pi_fallback_meta_description', 1 );

/**
 * In meta description nếu Rank Math không active.
 */
function pi_fallback_meta_description() {
	// Chỉ chạy khi Rank Math KHÔNG active.
	if ( class_exists( 'RankMath' ) ) {
		return;
	}

	if ( ! is_front_page() ) {
		return;
	}

	$desc = 'Pi Dentist — Phòng khám chỉnh nha chuyên sâu tại TP. Hồ Chí Minh. Bác sĩ đào tạo quốc tế, công nghệ CBCT 3D & scan kỹ thuật số. Đặt lịch tư vấn miễn phí.';

	echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
}
