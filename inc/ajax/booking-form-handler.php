<?php
/**
 * Pi Dentist — Booking Form AJAX Handler
 *
 * Handles form submission via wp_ajax / wp_ajax_nopriv:
 * 1. Verify nonce
 * 2. Honeypot check
 * 3. Rate limiting (3 submits/hour per IP)
 * 4. Sanitize + validate inputs
 * 5. Save lead to pi_lead CPT
 * 6. Send email notification via wp_mail()
 * 7. Return JSON response
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;


/* ═══════════════════════════════════════════════════════════════
 * 1. Register CPT: pi_lead (private — admin only)
 * ═══════════════════════════════════════════════════════════════ */
add_action( 'init', 'pi_register_lead_cpt' );

function pi_register_lead_cpt() {
	register_post_type( 'pi_lead', array(
		'labels'              => array(
			'name'               => 'Leads',
			'singular_name'      => 'Lead',
			'menu_name'          => 'Booking Leads',
			'all_items'          => 'Tất cả Leads',
			'view_item'          => 'Xem Lead',
			'search_items'       => 'Tìm Lead',
			'not_found'          => 'Không tìm thấy lead nào',
			'not_found_in_trash' => 'Không có lead nào trong thùng rác',
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-email-alt',
		'menu_position'       => 26,
		'supports'            => array( 'title' ),
		'capability_type'     => 'post',
		'has_archive'         => false,
		'show_in_rest'        => false, // No block editor needed.
		'exclude_from_search' => true,
	) );
}


/* ═══════════════════════════════════════════════════════════════
 * 2. Admin columns for pi_lead
 * ═══════════════════════════════════════════════════════════════ */
add_filter( 'manage_pi_lead_posts_columns', 'pi_lead_admin_columns' );

function pi_lead_admin_columns( $columns ) {
	$new = array(
		'cb'          => $columns['cb'],
		'title'       => 'Họ tên',
		'pi_phone'    => 'Số điện thoại',
		'pi_service'  => 'Dịch vụ',
		'pi_note'     => 'Ghi chú',
		'date'        => $columns['date'],
	);
	return $new;
}

add_action( 'manage_pi_lead_posts_custom_column', 'pi_lead_admin_column_data', 10, 2 );

function pi_lead_admin_column_data( $column, $post_id ) {
	switch ( $column ) {
		case 'pi_phone':
			echo esc_html( get_post_meta( $post_id, '_pi_lead_phone', true ) );
			break;
		case 'pi_service':
			echo esc_html( get_post_meta( $post_id, '_pi_lead_service', true ) );
			break;
		case 'pi_note':
			$note = get_post_meta( $post_id, '_pi_lead_note', true );
			echo esc_html( mb_strimwidth( $note, 0, 60, '…' ) );
			break;
	}
}


/* ═══════════════════════════════════════════════════════════════
 * 3. AJAX Actions (logged-in + non-logged-in)
 * ═══════════════════════════════════════════════════════════════ */
add_action( 'wp_ajax_pi_booking_submit', 'pi_handle_booking_submit' );
add_action( 'wp_ajax_nopriv_pi_booking_submit', 'pi_handle_booking_submit' );

/**
 * Main AJAX handler for booking form.
 */
function pi_handle_booking_submit() {

	// 3a. Verify nonce.
	if ( ! isset( $_POST['pi_booking_nonce'] )
		|| ! wp_verify_nonce( $_POST['pi_booking_nonce'], 'pi_booking_form_nonce' ) ) {
		wp_send_json_error( array( 'message' => 'Phiên làm việc hết hạn. Vui lòng tải lại trang.' ), 403 );
	}

	// 3b. Honeypot check.
	if ( ! empty( $_POST['pi_website'] ) ) {
		// Bot detected — fake success.
		wp_send_json_success( array( 'message' => 'OK' ) );
	}

	// 3c. Rate limiting (3 submits / hour / IP).
	$ip         = pi_get_client_ip();
	$rate_key   = 'pi_lead_rate_' . md5( $ip );
	$rate_count = (int) get_transient( $rate_key );

	if ( $rate_count >= 3 ) {
		wp_send_json_error( array(
			'message' => 'Bạn đã gửi quá nhiều yêu cầu. Vui lòng thử lại sau 1 giờ hoặc gọi trực tiếp ' . esc_html( get_theme_mod( 'pi_phone', '0909 XXX XXX' ) ) . '.',
		), 429 );
	}

	// 3d. Sanitize inputs.
	$fullname = isset( $_POST['pi_fullname'] ) ? sanitize_text_field( wp_unslash( $_POST['pi_fullname'] ) ) : '';
	$phone    = isset( $_POST['pi_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['pi_phone'] ) ) : '';
	$service  = isset( $_POST['pi_service'] ) ? sanitize_text_field( wp_unslash( $_POST['pi_service'] ) ) : '';
	$note     = isset( $_POST['pi_note'] ) ? sanitize_textarea_field( wp_unslash( $_POST['pi_note'] ) ) : '';

	// 3e. Validate.
	$errors = array();

	if ( mb_strlen( $fullname ) < 2 ) {
		$errors['pi_fullname'] = 'Vui lòng nhập họ và tên (ít nhất 2 ký tự).';
	}

	// Strip spaces/dashes from phone for validation.
	$phone_clean = preg_replace( '/[\s\-\.]/', '', $phone );
	if ( ! preg_match( '/^0[0-9]{9,10}$/', $phone_clean ) ) {
		$errors['pi_phone'] = 'Số điện thoại không hợp lệ (10–11 chữ số, bắt đầu bằng 0).';
	}

	if ( ! empty( $errors ) ) {
		wp_send_json_error( array(
			'message' => 'Vui lòng kiểm tra lại thông tin.',
			'fields'  => $errors,
		), 422 );
	}

	// 3f. Increment rate limit.
	set_transient( $rate_key, $rate_count + 1, HOUR_IN_SECONDS );

	// 3g. Save lead to CPT.
	$lead_id = wp_insert_post( array(
		'post_type'   => 'pi_lead',
		'post_title'  => $fullname . ' — ' . $phone_clean,
		'post_status' => 'publish',
	) );

	if ( ! is_wp_error( $lead_id ) ) {
		update_post_meta( $lead_id, '_pi_lead_phone', $phone_clean );
		update_post_meta( $lead_id, '_pi_lead_service', $service );
		update_post_meta( $lead_id, '_pi_lead_note', $note );
		update_post_meta( $lead_id, '_pi_lead_ip', $ip );
		update_post_meta( $lead_id, '_pi_lead_ua', isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( $_SERVER['HTTP_USER_AGENT'] ) : '' );
	}

	// 3h. Send email notification.
	$to = get_theme_mod( 'pi_lead_email', get_option( 'admin_email' ) );

	$subject = sprintf(
		'[Pi Dentist] Lead mới: %s - %s',
		$fullname,
		$phone_clean
	);

	$timestamp = wp_date( 'Y-m-d H:i:s' );

	$body = '
	<div style="font-family:\'Inter\',Arial,sans-serif;max-width:600px;margin:0 auto;">
		<div style="background:#002147;padding:24px 32px;border-radius:12px 12px 0 0;">
			<h2 style="color:#C9A96E;margin:0;font-size:20px;">🦷 Lead mới từ Pi Dentist</h2>
		</div>
		<div style="background:#ffffff;padding:32px;border:1px solid #eee;border-top:none;border-radius:0 0 12px 12px;">
			<table style="width:100%;border-collapse:collapse;">
				<tr>
					<td style="padding:12px 0;border-bottom:1px solid #f0f0f0;font-weight:600;width:140px;color:#002147;">Họ tên</td>
					<td style="padding:12px 0;border-bottom:1px solid #f0f0f0;">' . esc_html( $fullname ) . '</td>
				</tr>
				<tr>
					<td style="padding:12px 0;border-bottom:1px solid #f0f0f0;font-weight:600;color:#002147;">Số điện thoại</td>
					<td style="padding:12px 0;border-bottom:1px solid #f0f0f0;"><a href="tel:' . esc_attr( $phone_clean ) . '" style="color:#C9A96E;font-weight:600;">' . esc_html( $phone_clean ) . '</a></td>
				</tr>
				<tr>
					<td style="padding:12px 0;border-bottom:1px solid #f0f0f0;font-weight:600;color:#002147;">Dịch vụ</td>
					<td style="padding:12px 0;border-bottom:1px solid #f0f0f0;">' . esc_html( $service ?: '—' ) . '</td>
				</tr>
				<tr>
					<td style="padding:12px 0;font-weight:600;color:#002147;">Ghi chú</td>
					<td style="padding:12px 0;">' . nl2br( esc_html( $note ?: '—' ) ) . '</td>
				</tr>
			</table>
			<hr style="margin:24px 0;border:none;border-top:1px solid #f0f0f0;">
			<p style="font-size:12px;color:#999;">
				Thời gian: ' . esc_html( $timestamp ) . '<br>
				IP: ' . esc_html( $ip ) . '<br>
				User Agent: ' . esc_html( isset( $_SERVER['HTTP_USER_AGENT'] ) ? mb_strimwidth( $_SERVER['HTTP_USER_AGENT'], 0, 120, '…' ) : '—' ) . '
			</p>
		</div>
	</div>';

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: ' . get_bloginfo( 'name' ) . ' <' . get_option( 'admin_email' ) . '>',
	);

	wp_mail( $to, $subject, $body, $headers );

	// 3i. Success response.
	wp_send_json_success( array(
		'message' => 'Cảm ơn bạn! Pi Dentist sẽ liên hệ tư vấn trong vòng 30 phút.',
	) );
}


/* ═══════════════════════════════════════════════════════════════
 * 4. Helper: Get client IP
 * ═══════════════════════════════════════════════════════════════ */
function pi_get_client_ip() {
	$headers = array(
		'HTTP_CF_CONNECTING_IP', // Cloudflare
		'HTTP_X_FORWARDED_FOR',
		'REMOTE_ADDR',
	);

	foreach ( $headers as $header ) {
		if ( ! empty( $_SERVER[ $header ] ) ) {
			$ip = explode( ',', $_SERVER[ $header ] );
			return sanitize_text_field( trim( $ip[0] ) );
		}
	}

	return '0.0.0.0';
}
