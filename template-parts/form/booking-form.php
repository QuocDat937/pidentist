<?php
/**
 * Pi Dentist — Booking Form Template
 *
 * Rendered via [pi_booking_form] shortcode.
 * Navy background context — all labels/inputs styled for dark bg.
 * Honeypot field for bot protection.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;
?>

<form class="pi-booking-form" id="piBookingForm" novalidate>

	<?php wp_nonce_field( 'pi_booking_form_nonce', 'pi_booking_nonce' ); ?>

	<!-- Honeypot — hidden from humans, bots fill it -->
	<div class="pi-hp-field" aria-hidden="true">
		<label for="pi_website">Website</label>
		<input type="text" name="pi_website" id="pi_website" tabindex="-1" autocomplete="off">
	</div>

	<!-- Success message (hidden by default) -->
	<div class="pi-form-success" id="piFormSuccess" role="alert" style="display:none;">
		<span class="pi-form-success__icon" aria-hidden="true">✓</span>
		<p class="pi-form-success__text">Cảm ơn bạn! Pi Dentist sẽ liên hệ tư vấn trong vòng 30 phút (giờ hành chính 8:00–18:00).</p>
	</div>

	<!-- Error banner (hidden by default) -->
	<div class="pi-form-error-banner" id="piFormErrorBanner" role="alert" style="display:none;"></div>

	<!-- Form fields wrapper -->
	<div class="pi-form-fields" id="piFormFields">

		<!-- 1. Họ và tên -->
		<div class="pi-form-group">
			<label for="pi_fullname">Họ và tên <span class="pi-required">*</span></label>
			<input
				type="text"
				id="pi_fullname"
				name="pi_fullname"
				placeholder="Nguyễn Văn A"
				required
				autocomplete="name"
			>
			<span class="pi-field-error" id="piErrorFullname"></span>
		</div>

		<!-- 2. Số điện thoại -->
		<div class="pi-form-group">
			<label for="pi_phone">Số điện thoại <span class="pi-required">*</span></label>
			<input
				type="tel"
				id="pi_phone"
				name="pi_phone"
				placeholder="0909 123 456"
				required
				autocomplete="tel"
				inputmode="numeric"
			>
			<span class="pi-field-error" id="piErrorPhone"></span>
		</div>

		<!-- 3. Dịch vụ quan tâm -->
		<div class="pi-form-group">
			<label for="pi_service">Dịch vụ quan tâm</label>
			<select id="pi_service" name="pi_service" autocomplete="off">
				<option value="">Chọn dịch vụ quan tâm</option>
				<option value="Niềng mắc cài kim loại">Niềng mắc cài kim loại</option>
				<option value="Niềng mắc cài sứ">Niềng mắc cài sứ</option>
				<option value="Niềng trong suốt">Niềng trong suốt</option>
				<option value="Niềng mặt trong">Niềng mặt trong</option>
				<option value="Chưa biết, cần tư vấn">Chưa biết, cần tư vấn</option>
			</select>
			<span class="pi-field-error" id="piErrorService"></span>
		</div>

		<!-- 4. Ghi chú -->
		<div class="pi-form-group">
			<label for="pi_note">Ghi chú</label>
			<textarea
				id="pi_note"
				name="pi_note"
				rows="4"
				placeholder="Mô tả tình trạng răng hoặc thời gian thuận tiện..."
				autocomplete="off"
			></textarea>
			<span class="pi-field-error" id="piErrorNote"></span>
		</div>

		<!-- Submit -->
		<div class="pi-form-submit">
			<button type="submit" class="pi-booking-btn" id="piBookingSubmit">
				Đặt lịch tư vấn miễn phí
			</button>
		</div>

		<p class="pi-form-note">
			Hoặc gọi ngay: <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', get_theme_mod( 'pi_phone', '0909000000' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'pi_phone', '0909 XXX XXX' ) ); ?></a>
		</p>

	</div><!-- .pi-form-fields -->

</form>
