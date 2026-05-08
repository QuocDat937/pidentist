<?php
/**
 * Pi Dentist — Meta Fields & Meta Boxes
 *
 * Register post meta cho 3 CPT: pi_service, pi_doctor, pi_case
 * + Meta Boxes truyền thống (add_meta_box) cho admin editor
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/* =====================================================================
   PART 1-3: REGISTER POST META
   ===================================================================== */

add_action( 'init', 'pi_register_post_meta_fields', 10 );

function pi_register_post_meta_fields() {

	// ─── Part 1: pi_service meta ──────────────────────────────────────

	$service_string_fields = array(
		'_pi_service_tagline',
		'_pi_service_duration',
		'_pi_service_suitable_for',
		'_pi_service_thumb_color',
	);

	foreach ( $service_string_fields as $key ) {
		register_post_meta( 'pi_service', $key, array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		) );
	}

	register_post_meta( 'pi_service', '_pi_service_price_from', array(
		'type'              => 'number',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'absint',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	) );

	register_post_meta( 'pi_service', '_pi_service_is_featured', array(
		'type'              => 'boolean',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	) );

	// ─── Part 2: pi_doctor meta ───────────────────────────────────────

	$doctor_string_fields = array(
		'_pi_doctor_title',
		'_pi_doctor_credentials',
		'_pi_doctor_specialties',
	);

	foreach ( $doctor_string_fields as $key ) {
		register_post_meta( 'pi_doctor', $key, array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		) );
	}

	register_post_meta( 'pi_doctor', '_pi_doctor_is_featured', array(
		'type'              => 'boolean',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	) );

	// ─── Part 3: pi_case meta ─────────────────────────────────────────

	$case_string_fields = array(
		'_pi_case_patient_age',
		'_pi_case_patient_gender',
		'_pi_case_duration',
		'_pi_case_diagnosis',
	);

	foreach ( $case_string_fields as $key ) {
		register_post_meta( 'pi_case', $key, array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		) );
	}

	$case_number_fields = array(
		'_pi_case_doctor_id',
		'_pi_case_service_id',
	);

	foreach ( $case_number_fields as $key ) {
		register_post_meta( 'pi_case', $key, array(
			'type'              => 'number',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'absint',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		) );
	}

	register_post_meta( 'pi_case', '_pi_case_is_featured', array(
		'type'              => 'boolean',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'rest_sanitize_boolean',
		'auth_callback'     => function () {
			return current_user_can( 'edit_posts' );
		},
	) );
}

/* =====================================================================
   PART 4-6: META BOXES
   ===================================================================== */

add_action( 'add_meta_boxes', 'pi_register_meta_boxes' );

function pi_register_meta_boxes() {

	// Part 4: pi_service meta box
	add_meta_box(
		'pi_service_details',
		'Chi tiết dịch vụ',
		'pi_render_service_meta_box',
		'pi_service',
		'side',
		'high'
	);

	// Part 5: pi_doctor meta box
	add_meta_box(
		'pi_doctor_details',
		'Chi tiết bác sĩ',
		'pi_render_doctor_meta_box',
		'pi_doctor',
		'side',
		'high'
	);

	// Part 6: pi_case meta box
	add_meta_box(
		'pi_case_details',
		'Chi tiết ca điều trị',
		'pi_render_case_meta_box',
		'pi_case',
		'side',
		'high'
	);
}

/* =====================================================================
   PART 4: META BOX — pi_service
   ===================================================================== */

/**
 * Render meta box cho pi_service.
 *
 * @param WP_Post $post Current post object.
 */
function pi_render_service_meta_box( $post ) {
	wp_nonce_field( 'pi_service_meta_nonce_action', 'pi_service_meta_nonce' );

	$tagline     = get_post_meta( $post->ID, '_pi_service_tagline', true );
	$price_from  = get_post_meta( $post->ID, '_pi_service_price_from', true );
	$duration    = get_post_meta( $post->ID, '_pi_service_duration', true );
	$suitable    = get_post_meta( $post->ID, '_pi_service_suitable_for', true );
	$thumb_color = get_post_meta( $post->ID, '_pi_service_thumb_color', true );
	$is_featured = get_post_meta( $post->ID, '_pi_service_is_featured', true );

	$color_options = array(
		''        => '— Chọn màu —',
		'metal'   => 'Kim loại (Metal)',
		'ceramic' => 'Sứ (Ceramic)',
		'clear'   => 'Trong suốt (Clear)',
		'lingual' => 'Mặt trong (Lingual)',
	);
	?>
	<p>
		<label for="pi_service_tagline"><strong>Tagline</strong></label><br>
		<input type="text" id="pi_service_tagline" name="_pi_service_tagline"
			value="<?php echo esc_attr( $tagline ); ?>" class="widefat">
	</p>
	<p>
		<label for="pi_service_price_from"><strong>Giá từ (triệu VNĐ)</strong></label><br>
		<input type="number" id="pi_service_price_from" name="_pi_service_price_from"
			value="<?php echo esc_attr( $price_from ); ?>" class="widefat" min="0" step="1">
	</p>
	<p>
		<label for="pi_service_duration"><strong>Thời gian điều trị</strong></label><br>
		<input type="text" id="pi_service_duration" name="_pi_service_duration"
			value="<?php echo esc_attr( $duration ); ?>" class="widefat"
			placeholder="VD: 18-24 tháng">
	</p>
	<p>
		<label for="pi_service_suitable_for"><strong>Phù hợp cho</strong></label><br>
		<input type="text" id="pi_service_suitable_for" name="_pi_service_suitable_for"
			value="<?php echo esc_attr( $suitable ); ?>" class="widefat"
			placeholder="VD: Mọi lứa tuổi">
	</p>
	<p>
		<label for="pi_service_thumb_color"><strong>Màu thumbnail</strong></label><br>
		<select id="pi_service_thumb_color" name="_pi_service_thumb_color" class="widefat">
			<?php foreach ( $color_options as $value => $label ) : ?>
				<option value="<?php echo esc_attr( $value ); ?>"
					<?php selected( $thumb_color, $value ); ?>>
					<?php echo esc_html( $label ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="pi_service_is_featured">
			<input type="checkbox" id="pi_service_is_featured" name="_pi_service_is_featured"
				value="1" <?php checked( $is_featured ); ?>>
			<strong>Nổi bật (Featured)</strong>
		</label>
	</p>
	<?php
}

/**
 * Save meta box cho pi_service.
 *
 * @param int $post_id Post ID.
 */
add_action( 'save_post_pi_service', 'pi_save_service_meta_box' );

function pi_save_service_meta_box( $post_id ) {

	// Verify nonce.
	if ( ! isset( $_POST['pi_service_meta_nonce'] )
		|| ! wp_verify_nonce( $_POST['pi_service_meta_nonce'], 'pi_service_meta_nonce_action' ) ) {
		return;
	}

	// Check autosave.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check capability.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// Sanitize & save string fields.
	$string_fields = array(
		'_pi_service_tagline',
		'_pi_service_duration',
		'_pi_service_suitable_for',
	);

	foreach ( $string_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}

	// Sanitize & save price_from (number).
	if ( isset( $_POST['_pi_service_price_from'] ) ) {
		update_post_meta( $post_id, '_pi_service_price_from', absint( $_POST['_pi_service_price_from'] ) );
	}

	// Sanitize & save thumb_color (whitelist).
	if ( isset( $_POST['_pi_service_thumb_color'] ) ) {
		$allowed_colors = array( '', 'metal', 'ceramic', 'clear', 'lingual' );
		$color          = sanitize_text_field( wp_unslash( $_POST['_pi_service_thumb_color'] ) );
		if ( in_array( $color, $allowed_colors, true ) ) {
			update_post_meta( $post_id, '_pi_service_thumb_color', $color );
		}
	}

	// Sanitize & save is_featured (boolean).
	$is_featured = isset( $_POST['_pi_service_is_featured'] ) ? true : false;
	update_post_meta( $post_id, '_pi_service_is_featured', $is_featured );
}

/* =====================================================================
   PART 5: META BOX — pi_doctor
   ===================================================================== */

/**
 * Render meta box cho pi_doctor.
 *
 * @param WP_Post $post Current post object.
 */
function pi_render_doctor_meta_box( $post ) {
	wp_nonce_field( 'pi_doctor_meta_nonce_action', 'pi_doctor_meta_nonce' );

	$title       = get_post_meta( $post->ID, '_pi_doctor_title', true );
	$credentials = get_post_meta( $post->ID, '_pi_doctor_credentials', true );
	$specialties = get_post_meta( $post->ID, '_pi_doctor_specialties', true );
	$is_featured = get_post_meta( $post->ID, '_pi_doctor_is_featured', true );
	?>
	<p>
		<label for="pi_doctor_title"><strong>Chức danh</strong></label><br>
		<input type="text" id="pi_doctor_title" name="_pi_doctor_title"
			value="<?php echo esc_attr( $title ); ?>" class="widefat"
			placeholder="VD: Bác sĩ chỉnh nha">
	</p>
	<p>
		<label for="pi_doctor_credentials"><strong>Bằng cấp</strong></label><br>
		<textarea id="pi_doctor_credentials" name="_pi_doctor_credentials"
			class="widefat" rows="3"
			placeholder="VD: Thạc sĩ RHM — ĐH Y Dược TP.HCM"><?php echo esc_textarea( $credentials ); ?></textarea>
	</p>
	<p>
		<label for="pi_doctor_specialties"><strong>Chuyên sâu</strong></label><br>
		<textarea id="pi_doctor_specialties" name="_pi_doctor_specialties"
			class="widefat" rows="3"
			placeholder="VD: Invisalign, Mắc cài tự khóa"><?php echo esc_textarea( $specialties ); ?></textarea>
	</p>
	<p>
		<label for="pi_doctor_is_featured">
			<input type="checkbox" id="pi_doctor_is_featured" name="_pi_doctor_is_featured"
				value="1" <?php checked( $is_featured ); ?>>
			<strong>Nổi bật (Featured)</strong>
		</label>
	</p>
	<?php
}

/**
 * Save meta box cho pi_doctor.
 *
 * @param int $post_id Post ID.
 */
add_action( 'save_post_pi_doctor', 'pi_save_doctor_meta_box' );

function pi_save_doctor_meta_box( $post_id ) {

	if ( ! isset( $_POST['pi_doctor_meta_nonce'] )
		|| ! wp_verify_nonce( $_POST['pi_doctor_meta_nonce'], 'pi_doctor_meta_nonce_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$string_fields = array(
		'_pi_doctor_title',
		'_pi_doctor_credentials',
		'_pi_doctor_specialties',
	);

	foreach ( $string_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}

	$is_featured = isset( $_POST['_pi_doctor_is_featured'] ) ? true : false;
	update_post_meta( $post_id, '_pi_doctor_is_featured', $is_featured );
}

/* =====================================================================
   PART 6: META BOX — pi_case
   ===================================================================== */

/**
 * Render meta box cho pi_case.
 *
 * @param WP_Post $post Current post object.
 */
function pi_render_case_meta_box( $post ) {
	wp_nonce_field( 'pi_case_meta_nonce_action', 'pi_case_meta_nonce' );

	$patient_age    = get_post_meta( $post->ID, '_pi_case_patient_age', true );
	$patient_gender = get_post_meta( $post->ID, '_pi_case_patient_gender', true );
	$duration       = get_post_meta( $post->ID, '_pi_case_duration', true );
	$diagnosis      = get_post_meta( $post->ID, '_pi_case_diagnosis', true );
	$doctor_id      = get_post_meta( $post->ID, '_pi_case_doctor_id', true );
	$service_id     = get_post_meta( $post->ID, '_pi_case_service_id', true );
	$is_featured    = get_post_meta( $post->ID, '_pi_case_is_featured', true );

	// Lấy danh sách bác sĩ cho dropdown.
	$doctors = get_posts( array(
		'post_type'      => 'pi_doctor',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	) );

	// Lấy danh sách dịch vụ cho dropdown.
	$services = get_posts( array(
		'post_type'      => 'pi_service',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	) );
	?>
	<p>
		<label for="pi_case_patient_age"><strong>Tuổi bệnh nhân</strong></label><br>
		<input type="text" id="pi_case_patient_age" name="_pi_case_patient_age"
			value="<?php echo esc_attr( $patient_age ); ?>" class="widefat"
			placeholder="VD: 25 tuổi">
	</p>
	<p>
		<label for="pi_case_patient_gender"><strong>Giới tính</strong></label><br>
		<select id="pi_case_patient_gender" name="_pi_case_patient_gender" class="widefat">
			<option value="" <?php selected( $patient_gender, '' ); ?>>— Chọn —</option>
			<option value="male" <?php selected( $patient_gender, 'male' ); ?>>Nam</option>
			<option value="female" <?php selected( $patient_gender, 'female' ); ?>>Nữ</option>
		</select>
	</p>
	<p>
		<label for="pi_case_duration"><strong>Thời gian điều trị</strong></label><br>
		<input type="text" id="pi_case_duration" name="_pi_case_duration"
			value="<?php echo esc_attr( $duration ); ?>" class="widefat"
			placeholder="VD: 18 tháng">
	</p>
	<p>
		<label for="pi_case_diagnosis"><strong>Chẩn đoán</strong></label><br>
		<textarea id="pi_case_diagnosis" name="_pi_case_diagnosis"
			class="widefat" rows="3"
			placeholder="VD: Hô vẩu xương hàm trên"><?php echo esc_textarea( $diagnosis ); ?></textarea>
	</p>
	<p>
		<label for="pi_case_doctor_id"><strong>Bác sĩ điều trị</strong></label><br>
		<select id="pi_case_doctor_id" name="_pi_case_doctor_id" class="widefat">
			<option value="0">— Chọn bác sĩ —</option>
			<?php foreach ( $doctors as $doctor ) : ?>
				<option value="<?php echo esc_attr( $doctor->ID ); ?>"
					<?php selected( $doctor_id, $doctor->ID ); ?>>
					<?php echo esc_html( $doctor->post_title ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="pi_case_service_id"><strong>Dịch vụ sử dụng</strong></label><br>
		<select id="pi_case_service_id" name="_pi_case_service_id" class="widefat">
			<option value="0">— Chọn dịch vụ —</option>
			<?php foreach ( $services as $service ) : ?>
				<option value="<?php echo esc_attr( $service->ID ); ?>"
					<?php selected( $service_id, $service->ID ); ?>>
					<?php echo esc_html( $service->post_title ); ?>
				</option>
			<?php endforeach; ?>
		</select>
	</p>
	<p>
		<label for="pi_case_is_featured">
			<input type="checkbox" id="pi_case_is_featured" name="_pi_case_is_featured"
				value="1" <?php checked( $is_featured ); ?>>
			<strong>Nổi bật (Featured)</strong>
		</label>
	</p>
	<?php
}

/**
 * Save meta box cho pi_case.
 *
 * @param int $post_id Post ID.
 */
add_action( 'save_post_pi_case', 'pi_save_case_meta_box' );

function pi_save_case_meta_box( $post_id ) {

	if ( ! isset( $_POST['pi_case_meta_nonce'] )
		|| ! wp_verify_nonce( $_POST['pi_case_meta_nonce'], 'pi_case_meta_nonce_action' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	// String fields.
	$string_fields = array(
		'_pi_case_patient_age',
		'_pi_case_duration',
		'_pi_case_diagnosis',
	);

	foreach ( $string_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}

	// Gender (whitelist).
	if ( isset( $_POST['_pi_case_patient_gender'] ) ) {
		$allowed_genders = array( '', 'male', 'female' );
		$gender          = sanitize_text_field( wp_unslash( $_POST['_pi_case_patient_gender'] ) );
		if ( in_array( $gender, $allowed_genders, true ) ) {
			update_post_meta( $post_id, '_pi_case_patient_gender', $gender );
		}
	}

	// Number fields (doctor_id, service_id).
	$number_fields = array(
		'_pi_case_doctor_id',
		'_pi_case_service_id',
	);

	foreach ( $number_fields as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, absint( $_POST[ $key ] ) );
		}
	}

	// Boolean.
	$is_featured = isset( $_POST['_pi_case_is_featured'] ) ? true : false;
	update_post_meta( $post_id, '_pi_case_is_featured', $is_featured );
}
