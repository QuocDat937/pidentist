<?php
/**
 * Pi Dentist — Customizer Settings
 *
 * Đăng ký 4 sections trong Customizer:
 * 1. pi_general  — Thông tin chung (phone, email, address, hours)
 * 2. pi_social   — Mạng xã hội (facebook, instagram, youtube, tiktok, zalo)
 * 3. pi_promo    — Ưu đãi (banner toggle + text)
 * 4. pi_map      — Bản đồ Google (iframe embed)
 *
 * Tất cả settings dùng sanitize_callback phù hợp.
 * Truy cập trong template: get_theme_mod( 'pi_phone' ), etc.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', 'pi_customize_register' );

/**
 * Đăng ký sections, settings, controls cho Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager instance.
 */
function pi_customize_register( $wp_customize ) {

	/* ═══════════════════════════════════════════════
	 * SECTION 1: Pi - Thông tin chung (priority 30)
	 * ═══════════════════════════════════════════════ */
	$wp_customize->add_section( 'pi_general', array(
		'title'    => 'Pi - Thông tin chung',
		'priority' => 30,
	) );

	// --- Phone ---
	$wp_customize->add_setting( 'pi_phone', array(
		'default'           => '0909 XXX XXX',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'pi_phone', array(
		'label'   => 'Hotline',
		'section' => 'pi_general',
		'type'    => 'text',
	) );

	// --- Email ---
	$wp_customize->add_setting( 'pi_email', array(
		'default'           => 'info@pidentist.vn',
		'sanitize_callback' => 'sanitize_email',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'pi_email', array(
		'label'   => 'Email',
		'section' => 'pi_general',
		'type'    => 'email',
	) );

	// --- Address ---
	$wp_customize->add_setting( 'pi_address', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'pi_address', array(
		'label'   => 'Địa chỉ',
		'section' => 'pi_general',
		'type'    => 'textarea',
	) );

	// --- Working hours (3 fields) ---
	$hours_fields = array(
		'pi_hours_weekday'  => array(
			'label'   => 'Giờ làm việc — Thứ 2 – Thứ 6',
			'default' => '8:00 – 20:00',
		),
		'pi_hours_saturday' => array(
			'label'   => 'Giờ làm việc — Thứ 7',
			'default' => '8:00 – 17:00',
		),
		'pi_hours_sunday'   => array(
			'label'   => 'Giờ làm việc — Chủ nhật',
			'default' => 'Nghỉ',
		),
	);

	foreach ( $hours_fields as $key => $field ) {
		$wp_customize->add_setting( $key, array(
			'default'           => $field['default'],
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $field['label'],
			'section' => 'pi_general',
			'type'    => 'text',
		) );
	}

	/* ═══════════════════════════════════════════════
	 * SECTION 2: Pi - Mạng xã hội (priority 31)
	 * ═══════════════════════════════════════════════ */
	$wp_customize->add_section( 'pi_social', array(
		'title'    => 'Pi - Mạng xã hội',
		'priority' => 31,
	) );

	$social_networks = array(
		'pi_facebook_url'  => 'Facebook',
		'pi_instagram_url' => 'Instagram',
		'pi_youtube_url'   => 'YouTube',
		'pi_tiktok_url'    => 'TikTok',
		'pi_zalo_url'      => 'Zalo',
	);

	foreach ( $social_networks as $key => $label ) {
		$wp_customize->add_setting( $key, array(
			'default'           => '#',
			'sanitize_callback' => 'esc_url_raw',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( $key, array(
			'label'   => $label,
			'section' => 'pi_social',
			'type'    => 'url',
		) );
	}

	/* ═══════════════════════════════════════════════
	 * SECTION 3: Pi - Ưu đãi (priority 32)
	 * ═══════════════════════════════════════════════ */
	$wp_customize->add_section( 'pi_promo', array(
		'title'    => 'Pi - Ưu đãi',
		'priority' => 32,
	) );

	// --- Promo active toggle ---
	$wp_customize->add_setting( 'pi_promo_active', array(
		'default'           => true,
		'sanitize_callback' => 'pi_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'pi_promo_active', array(
		'label'   => 'Bật banner ưu đãi',
		'section' => 'pi_promo',
		'type'    => 'checkbox',
	) );

	// --- Promo text ---
	$wp_customize->add_setting( 'pi_promo_text', array(
		'default'           => 'Ưu đãi khai trương: Scan 3D miễn phí + Giảm 20% phí điều trị',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( 'pi_promo_text', array(
		'label'   => 'Nội dung ưu đãi',
		'section' => 'pi_promo',
		'type'    => 'textarea',
	) );

	/* ═══════════════════════════════════════════════
	 * SECTION 4: Pi - Bản đồ Google (priority 33)
	 * ═══════════════════════════════════════════════ */
	$wp_customize->add_section( 'pi_map', array(
		'title'    => 'Pi - Bản đồ Google',
		'priority' => 33,
	) );

	$wp_customize->add_setting( 'pi_map_embed', array(
		'default'           => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.394718041498!2d106.69916081534101!3d10.780114492318544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4670702e31%3A0xa5777fb3853960e!2zQuG7h25oIHZp4buHbiBOaGFuIGtob2EgVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBZIETGsOG7o2M!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Bản đồ vị trí Pi Dentist"></iframe>',
		'sanitize_callback' => 'pi_sanitize_map_embed',
	) );
	$wp_customize->add_control( 'pi_map_embed', array(
		'label'       => 'Iframe Google Maps embed',
		'description' => 'Vào Google Maps → Share → Embed a map → copy iframe paste vào đây',
		'section'     => 'pi_map',
		'type'        => 'textarea',
	) );

	/* ═══════════════════════════════════════════════
	 * SECTION 5: Pi - Booking / Lead (priority 34)
	 * ═══════════════════════════════════════════════ */
	$wp_customize->add_section( 'pi_booking', array(
		'title'    => 'Pi - Booking Form',
		'priority' => 34,
	) );

	// --- Lead email ---
	$wp_customize->add_setting( 'pi_lead_email', array(
		'default'           => get_option( 'admin_email' ),
		'sanitize_callback' => 'sanitize_email',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_control( 'pi_lead_email', array(
		'label'       => 'Email nhận Lead',
		'description' => 'Khi khách đặt lịch, email thông báo sẽ gửi về địa chỉ này.',
		'section'     => 'pi_booking',
		'type'        => 'email',
	) );
}

/* ───────────────────────────────────────────────
 * SANITIZE CALLBACKS
 * ─────────────────────────────────────────────── */

/**
 * Sanitize checkbox — trả về boolean.
 *
 * @param mixed $value Giá trị từ Customizer.
 * @return bool
 */
function pi_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Sanitize Google Maps embed.
 * Chỉ cho phép thẻ <iframe> với các attributes an toàn.
 * Từ chối mọi HTML khác.
 *
 * @param string $value Raw embed code từ admin.
 * @return string Sanitized iframe hoặc chuỗi rỗng.
 */
function pi_sanitize_map_embed( $value ) {
	return wp_kses( $value, array(
		'iframe' => array(
			'src'             => true,
			'width'           => true,
			'height'          => true,
			'style'           => true,
			'allowfullscreen' => true,
			'loading'         => true,
			'referrerpolicy'  => true,
			'frameborder'     => true,
			'title'           => true,
		),
	) );
}
