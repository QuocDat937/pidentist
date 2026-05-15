<?php
/**
 * Pi Dentist — Shortcodes
 *
 * 10 shortcodes cho dynamic content trong Block Patterns, Synced Patterns,
 * và templates.
 *
 * Thông tin cơ bản (Customizer):
 *  1. [pi_phone]          → Hotline
 *  2. [pi_email]          → Email
 *  3. [pi_address]        → Địa chỉ
 *  4. [pi_hours]          → Bảng giờ làm việc (3 dòng)
 *  5. [pi_social_links]   → Icon links mạng xã hội (5 MXH)
 *  6. [pi_contact_block]  → Full block: phone + email + address + hours + social + map
 *  7. [pi_year]           → Năm hiện tại (dùng trong footer ©)
 *
 * Dynamic CPT queries:
 *  8. [pi_services_grid]       → Grid service cards (CPT pi_service)
 *  9. [pi_doctors_carousel]    → Carousel doctor cards (CPT pi_doctor)
 * 10. [pi_recent_posts count]  → Grid post cards (recent blog posts)
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;


/* ═══════════════════════════════════════════════════════════════════════
   1. [pi_phone] — Output số điện thoại từ Customizer
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_phone', 'pi_phone_shortcode' );

/**
 * @return string Phone number (escaped).
 */
function pi_phone_shortcode() {
	$phone = get_theme_mod( 'pi_phone', '0909 XXX XXX' );
	return esc_html( $phone );
}


/* ═══════════════════════════════════════════════════════════════════════
   2. [pi_email] — Output email từ Customizer
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_email', 'pi_email_shortcode' );

/**
 * @return string Email address (escaped).
 */
function pi_email_shortcode() {
	$email = get_theme_mod( 'pi_email', 'info@pidentist.vn' );
	return esc_html( $email );
}


/* ═══════════════════════════════════════════════════════════════════════
   3. [pi_address] — Output địa chỉ từ Customizer
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_address', 'pi_address_shortcode' );

/**
 * @return string Address (escaped, cho phép <br>).
 */
function pi_address_shortcode() {
	$address = get_theme_mod( 'pi_address', '' );
	return wp_kses_post( $address );
}


/* ═══════════════════════════════════════════════════════════════════════
   4. [pi_hours] — Bảng giờ làm việc 3 dòng từ Customizer
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_hours', 'pi_hours_shortcode' );

/**
 * @return string HTML table giờ làm việc.
 */
function pi_hours_shortcode() {
	$weekday  = get_theme_mod( 'pi_hours_weekday', '8:00 – 20:00' );
	$saturday = get_theme_mod( 'pi_hours_saturday', '8:00 – 17:00' );
	$sunday   = get_theme_mod( 'pi_hours_sunday', 'Nghỉ' );

	$is_closed = ( 'Nghỉ' === $sunday || 'nghỉ' === strtolower( $sunday ) );

	$html  = '<table class="pi-hours-table">';
	$html .= '<tbody>';
	$html .= '<tr>';
	$html .= '<td class="pi-hours-day">T2 – T6</td>';
	$html .= '<td class="pi-hours-time">' . esc_html( $weekday ) . '</td>';
	$html .= '</tr>';
	$html .= '<tr>';
	$html .= '<td class="pi-hours-day">Thứ 7</td>';
	$html .= '<td class="pi-hours-time">' . esc_html( $saturday ) . '</td>';
	$html .= '</tr>';
	$html .= '<tr' . ( $is_closed ? ' class="pi-hours-closed"' : '' ) . '>';
	$html .= '<td class="pi-hours-day">Chủ nhật</td>';
	$html .= '<td class="pi-hours-time">' . esc_html( $sunday ) . '</td>';
	$html .= '</tr>';
	$html .= '</tbody>';
	$html .= '</table>';

	return $html;
}


/* ═══════════════════════════════════════════════════════════════════════
   5. [pi_social_links] — Icon links mạng xã hội từ Customizer (5 MXH)
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_social_links', 'pi_social_links_shortcode' );

/**
 * @return string HTML danh sách social icon links.
 */
function pi_social_links_shortcode() {
	$networks = array(
		'pi_facebook_url'  => array(
			'label' => 'Facebook',
			'icon'  => '<svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
		),
		'pi_instagram_url' => array(
			'label' => 'Instagram',
			'icon'  => '<svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
		),
		'pi_youtube_url'   => array(
			'label' => 'YouTube',
			'icon'  => '<svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
		),
		'pi_tiktok_url'    => array(
			'label' => 'TikTok',
			'icon'  => '<svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>',
		),
		'pi_zalo_url'      => array(
			'label' => 'Zalo',
			'icon'  => '<svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><text x="2" y="18" font-family="Arial,sans-serif" font-size="16" font-weight="bold">Z</text></svg>',
		),
	);

	$html = '<div class="pi-social-links">';

	foreach ( $networks as $key => $network ) {
		$url = get_theme_mod( $key, '#' );

		// Bỏ qua nếu URL rỗng hoặc chỉ là '#'.
		if ( empty( $url ) || '#' === $url ) {
			continue;
		}

		$html .= sprintf(
			'<a href="%s" class="pi-social-link" aria-label="%s" target="_blank" rel="noopener noreferrer">%s</a>',
			esc_url( $url ),
			esc_attr( $network['label'] ),
			$network['icon'] // SVG markup — safe, hardcoded.
		);
	}

	$html .= '</div>';

	return $html;
}


/* ═══════════════════════════════════════════════════════════════════════
   6. [pi_contact_block] — Full contact block: phone + email + address
      + hours + social + map embed
      Styled card format với icon trước mỗi item.
      Dùng trong CTA Booking synced pattern (cột phải).
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_contact_block', 'pi_contact_block_shortcode' );

/**
 * @return string HTML full contact block.
 */
function pi_contact_block_shortcode() {
	$phone   = get_theme_mod( 'pi_phone', '0909 XXX XXX' );
	$email   = get_theme_mod( 'pi_email', 'info@pidentist.vn' );
	$address = get_theme_mod( 'pi_address', '123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh' );
	$map     = get_theme_mod( 'pi_map_embed', '' );

	// Giờ làm việc.
	$hours = get_theme_mod( 'pi_hours_weekday', '8:00 – 20:00' );

	$phone_clean = preg_replace( '/[^0-9+]/', '', $phone );

	ob_start();
	?>
	<div class="pi-contact-block">

		<!-- Địa chỉ -->
		<div class="info-block">
			<div class="info-icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
			</div>
			<div>
				<h3>Địa chỉ</h3>
				<p><?php echo wp_kses_post( $address ); ?></p>
			</div>
		</div>

		<!-- Giờ làm việc -->
		<div class="info-block">
			<div class="info-icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
			</div>
			<div>
				<h3>Giờ làm việc</h3>
				<p>Thứ 2 – Chủ nhật: <?php echo esc_html( $hours ); ?></p>
			</div>
		</div>

		<!-- Hotline -->
		<div class="info-block">
			<div class="info-icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="20" height="20"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
			</div>
			<div>
				<h3>Hotline</h3>
				<p>
					<a href="tel:<?php echo esc_attr( $phone_clean ); ?>"><?php echo esc_html( $phone ); ?></a><br>
					<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
				</p>
			</div>
		</div>

		<!-- Google Map -->
		<?php if ( $map ) : ?>
		<div class="pi-contact-map">
			<?php
			// Inject title attribute if missing for a11y.
			$map_html = $map;
			if ( strpos( $map_html, 'title=' ) === false ) {
				$map_html = str_replace( '<iframe ', '<iframe title="Bản đồ vị trí Pi Dentist" ', $map_html );
			}
			echo $map_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Sanitized by pi_sanitize_map_embed in customizer.php.
			?>
		</div>
		<?php else : ?>
		<div class="pi-contact-map">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.394718041498!2d106.69916081534101!3d10.780114492318544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4670702e31%3A0xa5777fb3853960e!2zQuG7h25oIHZp4buHbiBOaGFuIGtob2EgVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBZIETGsOG7o2M!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Bản đồ vị trí Pi Dentist"></iframe>
		</div>
		<?php endif; ?>

	</div>
	<?php

	return ob_get_clean();
}


/* ═══════════════════════════════════════════════════════════════════════
   7. [pi_year] — Output năm hiện tại (dùng trong footer ©)
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_year', 'pi_year_shortcode' );

/**
 * @return string Current year.
 */
function pi_year_shortcode() {
	return esc_html( date( 'Y' ) ); // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date -- Simple year display.
}


/* ═══════════════════════════════════════════════════════════════════════
   8. [pi_services_grid] — Grid service cards từ CPT pi_service
      Dùng trong Pattern 8 (Homepage section 6).
      Attrs: count (default 4)
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_services_grid', 'pi_services_grid_shortcode' );

/**
 * @param array $atts Shortcode attributes.
 * @return string HTML output.
 */
function pi_services_grid_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'count' => 4,
	), $atts, 'pi_services_grid' );

	$query = new WP_Query( array(
		'post_type'      => 'pi_service',
		'posts_per_page' => absint( $atts['count'] ),
		'meta_query'     => array(
			array(
				'key'     => '_pi_service_is_featured',
				'value'   => array( '1', 1, true ),
				'compare' => 'IN',
			),
		),
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	) );

	// Fallback: nếu không có featured, query tất cả.
	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		$query = new WP_Query( array(
			'post_type'      => 'pi_service',
			'posts_per_page' => absint( $atts['count'] ),
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		) );
	}

	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		return '<p class="pi-no-results">Chưa có dịch vụ nào.</p>';
	}

	ob_start();
	echo '<div class="services-grid">';

	while ( $query->have_posts() ) {
		$query->the_post();
		get_template_part( 'template-parts/card/service-card', null, array(
			'show_price' => true,
		) );
	}

	echo '</div>';
	wp_reset_postdata();

	return ob_get_clean();
}


/* ═══════════════════════════════════════════════════════════════════════
   9. [pi_doctors_carousel] — Carousel doctor cards từ CPT pi_doctor
      Dùng trong Homepage section 4.
      Wrapper .pi-carousel-container cho carousel JS.
      Attrs: count (default 6)
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_doctors_carousel', 'pi_doctors_carousel_shortcode' );

/**
 * @param array $atts Shortcode attributes.
 * @return string HTML output.
 */
function pi_doctors_carousel_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'count' => 6,
	), $atts, 'pi_doctors_carousel' );

	$query = new WP_Query( array(
		'post_type'      => 'pi_doctor',
		'posts_per_page' => absint( $atts['count'] ),
		'meta_key'       => '_pi_doctor_is_featured',
		'meta_value'     => '1',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	) );

	// Fallback: nếu không có featured, query tất cả.
	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		$query = new WP_Query( array(
			'post_type'      => 'pi_doctor',
			'posts_per_page' => absint( $atts['count'] ),
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post_status'    => 'publish',
		) );
	}

	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		return '<p class="pi-no-results">Chưa có bác sĩ nào.</p>';
	}

	ob_start();
	?>
	<section class="doctors pi-section" aria-label="Đội ngũ bác sĩ">
		<div class="container">
			<div class="section-header">
				<p class="section-label">ĐỘI NGŨ BÁC SĨ</p>
				<h2 class="section-heading">Chuyên gia chỉnh nha hàng đầu</h2>
				<div class="gold-line"></div>
			</div>

			<div class="pi-carousel-container" role="region" aria-label="Carousel bác sĩ">
				<div class="pi-carousel-track">
					<?php
					while ( $query->have_posts() ) {
						$query->the_post();
						get_template_part( 'template-parts/card/doctor-card' );
					}
					?>
				</div>

				<!-- Navigation: [←] [dots] [→] — below cards -->
				<div class="pi-carousel-nav">
					<button class="pi-carousel-prev" aria-label="Bác sĩ trước" type="button">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><polyline points="15 18 9 12 15 6"/></svg>
					</button>
					<div class="pi-carousel-dots" role="tablist" aria-label="Carousel navigation"></div>
					<button class="pi-carousel-next" aria-label="Bác sĩ tiếp theo" type="button">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><polyline points="9 18 15 12 9 6"/></svg>
					</button>
				</div>
			</div>

			<div class="compare-link">
				<a class="text-link text-link-navy" href="<?php echo esc_url( get_post_type_archive_link( 'pi_doctor' ) ); ?>">Xem tất cả bác sĩ →</a>
			</div>
		</div>
	</section>
	<?php

	wp_reset_postdata();

	return ob_get_clean();
}


/* ═══════════════════════════════════════════════════════════════════════
   10. [pi_recent_posts count="3"] — Grid recent blog posts
       Dùng trong Homepage section 10.
       Attrs: count (default 3)
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_recent_posts', 'pi_recent_posts_shortcode' );

/**
 * @param array $atts Shortcode attributes.
 * @return string HTML output.
 */
function pi_recent_posts_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'count' => 3,
	), $atts, 'pi_recent_posts' );

	$query = new WP_Query( array(
		'post_type'      => 'post',
		'posts_per_page' => absint( $atts['count'] ),
		'orderby'        => 'date',
		'order'          => 'DESC',
		'post_status'    => 'publish',
	) );

	if ( ! $query->have_posts() ) {
		wp_reset_postdata();
		return '<p class="pi-no-results">Chưa có bài viết nào.</p>';
	}

	ob_start();
	?>
	<section class="knowledge pi-off-white-bg pi-section" aria-label="Kiến thức chỉnh nha">
		<div class="container">
			<div class="section-header">
				<p class="section-label">KIẾN THỨC</p>
				<h2 class="section-heading">Bài viết mới nhất</h2>
				<p class="section-sub">Cập nhật kiến thức chỉnh nha từ đội ngũ bác sĩ Pi Dentist</p>
				<div class="gold-line"></div>
			</div>

			<div class="posts-grid">
				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					get_template_part( 'template-parts/card/post-card' );
				}
				?>
			</div>

			<div class="all-posts">
				<a class="text-link text-link-navy" href="<?php echo esc_url( home_url( '/kien-thuc/' ) ); ?>">Xem tất cả bài viết →</a>
			</div>
		</div>
	</section>
	<?php

	wp_reset_postdata();

	return ob_get_clean();
}


/* ═══════════════════════════════════════════════════════════════════════
   11. [pi_booking_form] — Custom booking form (no plugin)
   ═══════════════════════════════════════════════════════════════════════ */
add_shortcode( 'pi_booking_form', 'pi_booking_form_shortcode' );

/**
 * Render custom booking/consultation form.
 * Designed for navy-background CTA section.
 *
 * @return string HTML form markup.
 */
function pi_booking_form_shortcode() {
	ob_start();
	get_template_part( 'template-parts/form/booking-form' );
	return ob_get_clean();
}
