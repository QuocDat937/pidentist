<?php
/**
 * template-parts/footer/footer-links.php
 * Footer columns 2 & 3: "Dịch vụ" + "Thông tin" link lists.
 * Uses wp_nav_menu with fallback to hardcoded links.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;
?>

<!-- Column 2 — Dịch vụ -->
<div class="footer-col">
	<h4><?php esc_html_e( 'Dịch vụ', 'pidentist' ); ?></h4>
	<?php
	if ( has_nav_menu( 'footer-services' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'footer-services',
			'container'      => false,
			'menu_class'     => 'footer-links',
			'depth'          => 1,
			'fallback_cb'    => false,
		) );
	} else {
		// Fallback — hardcoded service links
		?>
		<ul class="footer-links">
			<li><a href="<?php echo esc_url( home_url( '/dich-vu/nieng-mac-cai-kim-loai/' ) ); ?>"><?php esc_html_e( 'Mắc cài kim loại', 'pidentist' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/dich-vu/nieng-mac-cai-su/' ) ); ?>"><?php esc_html_e( 'Mắc cài sứ', 'pidentist' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/dich-vu/nieng-trong-suot/' ) ); ?>"><?php esc_html_e( 'Niềng trong suốt', 'pidentist' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/dich-vu/nieng-mat-trong/' ) ); ?>"><?php esc_html_e( 'Niềng mặt trong', 'pidentist' ); ?></a></li>
		</ul>
		<?php
	}
	?>
</div>

<!-- Column 3 — Thông tin -->
<div class="footer-col">
	<h4><?php esc_html_e( 'Thông tin', 'pidentist' ); ?></h4>
	<?php
	if ( has_nav_menu( 'footer-info' ) ) {
		wp_nav_menu( array(
			'theme_location' => 'footer-info',
			'container'      => false,
			'menu_class'     => 'footer-links',
			'depth'          => 1,
			'fallback_cb'    => false,
		) );
	} else {
		// Fallback — hardcoded info links
		?>
		<ul class="footer-links">
			<li><a href="<?php echo esc_url( home_url( '/ve-pi/' ) ); ?>"><?php esc_html_e( 'Về Pi Dentist', 'pidentist' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/bac-si/' ) ); ?>"><?php esc_html_e( 'Đội ngũ bác sĩ', 'pidentist' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/bang-gia/' ) ); ?>"><?php esc_html_e( 'Bảng giá', 'pidentist' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/kien-thuc/' ) ); ?>"><?php esc_html_e( 'Kiến thức', 'pidentist' ); ?></a></li>
			<li><a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>"><?php esc_html_e( 'Liên hệ', 'pidentist' ); ?></a></li>
		</ul>
		<?php
	}
	?>
</div>

<!-- Column 4 — Liên hệ -->
<div class="footer-col">
	<h4><?php esc_html_e( 'Liên hệ', 'pidentist' ); ?></h4>
	<?php
	$phone   = get_theme_mod( 'pi_phone', '0909 XXX XXX' );
	$email   = get_theme_mod( 'pi_email', 'info@pidentist.vn' );
	$address = get_theme_mod( 'pi_address', '' );
	$hours_weekday  = get_theme_mod( 'pi_hours_weekday', '8:00 – 20:00' );
	$hours_saturday = get_theme_mod( 'pi_hours_saturday', '8:00 – 17:00' );
	?>
	<ul class="footer-contact">
		<?php if ( $address ) : ?>
			<li>
				<span class="fc-icon" aria-hidden="true">📍</span>
				<span><?php echo wp_kses_post( $address ); ?></span>
			</li>
		<?php endif; ?>
		<li>
			<span class="fc-icon" aria-hidden="true">📞</span>
			<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
		</li>
		<li>
			<span class="fc-icon" aria-hidden="true">✉</span>
			<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
		</li>
		<li>
			<span class="fc-icon" aria-hidden="true">🕐</span>
			<span>
				<?php esc_html_e( 'Thứ 2 – Chủ nhật: 8:00 – 20:00', 'pidentist' ); ?>
			</span>
		</li>
	</ul>
</div>
