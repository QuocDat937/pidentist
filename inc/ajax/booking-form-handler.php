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
 * 4. Helper: Get client IP (hardened)
 *
 * - Only trusts CF-Connecting-IP when REMOTE_ADDR is a Cloudflare IP.
 * - X-Forwarded-For is NOT trusted (easily spoofable).
 * - Fallback: REMOTE_ADDR (cannot be spoofed at TCP level).
 * ═══════════════════════════════════════════════════════════════ */
function pi_get_client_ip() {

	$remote_addr = isset( $_SERVER['REMOTE_ADDR'] )
		? sanitize_text_field( $_SERVER['REMOTE_ADDR'] )
		: '0.0.0.0';

	// If request comes from Cloudflare, trust CF-Connecting-IP.
	// Ref: https://www.cloudflare.com/ips-v4/
	if ( ! empty( $_SERVER['HTTP_CF_CONNECTING_IP'] )
		&& pi_ip_in_cloudflare_range( $remote_addr ) ) {
		return sanitize_text_field( trim( $_SERVER['HTTP_CF_CONNECTING_IP'] ) );
	}

	// Fallback: always use REMOTE_ADDR.
	return $remote_addr;
}

/**
 * Check if an IP belongs to Cloudflare's IPv4 ranges.
 *
 * @param string $ip IP address to check.
 * @return bool True if IP is in a Cloudflare range.
 */
function pi_ip_in_cloudflare_range( $ip ) {
	// Cloudflare IPv4 ranges (updated 2024-12).
	// Source: https://www.cloudflare.com/ips-v4/
	$cf_ranges = array(
		'173.245.48.0/20',
		'103.21.244.0/22',
		'103.22.200.0/22',
		'103.31.4.0/22',
		'141.101.64.0/18',
		'108.162.192.0/18',
		'190.93.240.0/20',
		'188.114.96.0/20',
		'197.234.240.0/22',
		'198.41.128.0/17',
		'162.158.0.0/15',
		'104.16.0.0/13',
		'104.24.0.0/14',
		'172.64.0.0/13',
		'131.0.72.0/22',
	);

	$ip_long = ip2long( $ip );
	if ( false === $ip_long ) {
		return false;
	}

	foreach ( $cf_ranges as $cidr ) {
		list( $subnet, $mask ) = explode( '/', $cidr );
		$subnet_long = ip2long( $subnet );
		$mask_long   = -1 << ( 32 - (int) $mask );
		if ( ( $ip_long & $mask_long ) === ( $subnet_long & $mask_long ) ) {
			return true;
		}
	}

	return false;
}

