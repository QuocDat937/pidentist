<?php
/**
 * Pi Dentist — Trang Liên Hệ
 *
 * Template Name: Trang Liên Hệ
 * Slug: page-lien-he
 *
 * Custom page template cho /lien-he/.
 * Render: page hero → 2-col layout (form + contact info) → map section.
 * Không inject CTA Booking ở cuối (gp-hooks.php đã skip is_page('lien-he')).
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<?php
// Page Hero
get_template_part( 'template-parts/section/page-hero', null, array(
	'label'      => 'LIÊN HỆ',
	'heading'    => 'Đặt lịch tư vấn',
	'sub'        => 'Đội ngũ Pi Dentist sẵn sàng lắng nghe và tư vấn miễn phí cho bạn',
	'breadcrumb' => true,
) );
?>

<main class="pi-contact-page" id="main-content">

	<!-- ── Section 1: Form + Contact Info (2 columns) ── -->
	<section class="contact-section pi-section" aria-label="Form đặt lịch và thông tin liên hệ">
		<div class="container">
			<div class="contact-grid">

				<!-- Left: Booking Form -->
				<div class="contact-form-col">
					<div class="contact-form-card">
						<h2 class="contact-form-title">Đặt lịch tư vấn miễn phí</h2>
						<p class="contact-form-desc">Điền thông tin bên dưới, Pi Dentist sẽ liên hệ tư vấn trong vòng 30 phút (giờ hành chính).</p>
						<div class="gold-line-left"></div>

						<?php echo do_shortcode( '[pi_booking_form]' ); ?>
					</div>
				</div>

				<!-- Right: Contact Info -->
				<div class="contact-info-col">

					<!-- Thông tin liên hệ -->
					<div class="contact-info-card">
						<h2 class="contact-info-title">Thông tin liên hệ</h2>
						<div class="gold-line-left"></div>

						<?php
						$phone       = get_theme_mod( 'pi_phone', '0909 XXX XXX' );
						$email       = get_theme_mod( 'pi_email', 'info@pidentist.vn' );
						$address     = get_theme_mod( 'pi_address', '123 Đường ABC, Quận XYZ, TP. Hồ Chí Minh' );
						$hours       = get_theme_mod( 'pi_hours_weekday', '8:00 – 20:00' );
						$phone_clean = preg_replace( '/[^0-9+]/', '', $phone );
						?>

						<!-- Địa chỉ -->
						<div class="contact-info-item">
							<div class="contact-info-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
							</div>
							<div>
								<h3>Địa chỉ phòng khám</h3>
								<p><?php echo wp_kses_post( $address ); ?></p>
							</div>
						</div>

						<!-- Hotline -->
						<div class="contact-info-item">
							<div class="contact-info-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
							</div>
							<div>
								<h3>Hotline</h3>
								<p><a href="tel:<?php echo esc_attr( $phone_clean ); ?>"><?php echo esc_html( $phone ); ?></a></p>
							</div>
						</div>

						<!-- Email -->
						<div class="contact-info-item">
							<div class="contact-info-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
							</div>
							<div>
								<h3>Email</h3>
								<p><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></p>
							</div>
						</div>

						<!-- Giờ làm việc -->
						<div class="contact-info-item">
							<div class="contact-info-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
							</div>
							<div>
								<h3>Giờ làm việc</h3>
								<p>Thứ 2 – Chủ nhật: <?php echo esc_html( $hours ); ?></p>
							</div>
						</div>

						<!-- Social Links -->
						<div class="contact-social-section">
							<h3>Kết nối với chúng tôi</h3>
							<?php echo do_shortcode( '[pi_social_links]' ); ?>
						</div>
					</div>

					<!-- Google Map -->
					<div class="contact-map-card">
						<h3 class="contact-map-title">Bản đồ chỉ đường</h3>
						<?php
						$map = get_theme_mod( 'pi_map_embed', '' );
						if ( $map ) :
							$map_html = $map;
							if ( strpos( $map_html, 'title=' ) === false ) {
								$map_html = str_replace( '<iframe ', '<iframe title="Bản đồ vị trí Pi Dentist" ', $map_html );
							}
						?>
							<div class="contact-map-embed">
								<?php echo $map_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Sanitized by pi_sanitize_map_embed in customizer.php. ?>
							</div>
						<?php else : ?>
							<div class="contact-map-embed">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.394718041498!2d106.69916081534101!3d10.780114492318544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f4670702e31%3A0xa5777fb3853960e!2zQuG7h25oIHZp4buHbiBOaGFuIGtob2EgVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBZIETGsOG7o2M!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Bản đồ vị trí Pi Dentist"></iframe>
						</div>
						<?php endif; ?>
					</div>

				</div><!-- .contact-info-col -->

			</div><!-- .contact-grid -->
		</div>
	</section>

</main>

<?php get_footer();
