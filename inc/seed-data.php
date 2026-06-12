<?php
/**
 * Pi Dentist — Seed Data (chạy 1 lần qua admin_init)
 *
 * Tạo dữ liệu test: 4 services, 3 doctors, 3 cases, 5 blog posts.
 * Kiểm tra option 'pi_seed_data_v1' để chỉ chạy 1 lần.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

/*
 * SAFETY (2026-06): Seed + cleanup CHỈ chạy ngoài production.
 * Lý do: pi_cleanup_duplicate_seed() XÓA VĨNH VIỄN post trùng title —
 * nếu chạy trên production và sau này có 2 bài viết thật trùng tên,
 * 1 bài sẽ bị xóa không vào thùng rác. Production đã seed xong
 * (flag pi_seed_data_v1 + pi_seed_cleanup_done trong DB) nên không cần nữa.
 *
 * Lưu ý: wp_get_environment_type() mặc định trả 'production' nếu
 * WP_ENVIRONMENT_TYPE chưa define — muốn seed ở môi trường local mới,
 * thêm vào wp-config.php local: define( 'WP_ENVIRONMENT_TYPE', 'local' );
 */
if ( 'production' !== wp_get_environment_type() ) {

	add_action( 'admin_init', 'pi_seed_test_data' );

	/**
	 * Cleanup: Xóa duplicate posts do seed chạy 2 lần (admin_init race condition).
	 * Chạy 1 lần rồi tự xóa flag.
	 */
	add_action( 'admin_init', 'pi_cleanup_duplicate_seed', 5 );
}

function pi_cleanup_duplicate_seed() {

	if ( get_option( 'pi_seed_cleanup_done' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// Đánh dấu ngay để tránh chạy lại.
	update_option( 'pi_seed_cleanup_done', true );

	$post_types = array( 'pi_service', 'pi_doctor', 'pi_case', 'post' );

	foreach ( $post_types as $pt ) {
		$posts = get_posts( array(
			'post_type'      => $pt,
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'ID',
			'order'          => 'ASC',
		) );

		$seen_titles = array();

		foreach ( $posts as $p ) {
			if ( isset( $seen_titles[ $p->post_title ] ) ) {
				// Duplicate → xóa vĩnh viễn.
				wp_delete_post( $p->ID, true );
			} else {
				$seen_titles[ $p->post_title ] = $p->ID;
			}
		}
	}
}

function pi_seed_test_data() {

	if ( get_option( 'pi_seed_data_v1' ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	// ĐẶT FLAG NGAY ĐẦU để tránh race condition khi admin_init fire nhiều lần.
	update_option( 'pi_seed_data_v1', true );

	// ─── 1. SERVICES ──────────────────────────────────────────────────
	$services_data = array(
		array(
			'title'   => 'Niềng mắc cài kim loại',
			'slug'    => 'nieng-mac-cai-kim-loai',
			'content' => '<p>Niềng răng mắc cài kim loại là phương pháp chỉnh nha truyền thống, sử dụng mắc cài và dây cung bằng hợp kim để dịch chuyển răng về đúng vị trí. Đây là giải pháp hiệu quả nhất cho mọi trường hợp sai lệch khớp cắn từ nhẹ đến phức tạp.</p><h2>Ưu điểm nổi bật</h2><p>Hiệu quả cao, phù hợp mọi trường hợp, chi phí hợp lý nhất trong các phương pháp chỉnh nha.</p>',
			'meta'    => array(
				'_pi_service_tagline'      => 'Giải pháp kinh điển, hiệu quả vượt thời gian',
				'_pi_service_price_from'   => 25,
				'_pi_service_duration'     => '18-24 tháng',
				'_pi_service_suitable_for' => 'Mọi lứa tuổi, mọi tình trạng',
				'_pi_service_thumb_color'  => 'metal',
				'_pi_service_is_featured'  => true,
			),
			'category' => 'Mắc cài',
		),
		array(
			'title'   => 'Niềng mắc cài sứ',
			'slug'    => 'nieng-mac-cai-su',
			'content' => '<p>Mắc cài sứ sử dụng chất liệu ceramic trong suốt, gần như hòa lẫn với màu răng tự nhiên. Đây là lựa chọn hoàn hảo cho người cần tính thẩm mỹ cao trong suốt quá trình điều trị.</p><h2>Thẩm mỹ vượt trội</h2><p>Mắc cài ceramic có màu sắc tương tự men răng, giúp bạn tự tin trong giao tiếp.</p>',
			'meta'    => array(
				'_pi_service_tagline'      => 'Thẩm mỹ cao, gần như vô hình',
				'_pi_service_price_from'   => 35,
				'_pi_service_duration'     => '18-24 tháng',
				'_pi_service_suitable_for' => 'Người cần thẩm mỹ cao',
				'_pi_service_thumb_color'  => 'ceramic',
				'_pi_service_is_featured'  => true,
			),
			'category' => 'Mắc cài',
		),
		array(
			'title'   => 'Niềng trong suốt',
			'slug'    => 'nieng-trong-suot',
			'content' => '<p>Niềng răng trong suốt (Clear Aligners) sử dụng hệ thống khay nhựa trong suốt được thiết kế riêng theo số hóa 3D. Không mắc cài, không dây cung — thoải mái tối đa trong suốt quá trình điều trị.</p><h2>Công nghệ số hóa</h2><p>Mô phỏng kết quả trước khi bắt đầu bằng phần mềm 3D tiên tiến.</p>',
			'meta'    => array(
				'_pi_service_tagline'      => 'Tự do tháo lắp, thoải mái tuyệt đối',
				'_pi_service_price_from'   => 45,
				'_pi_service_duration'     => '12-18 tháng',
				'_pi_service_suitable_for' => 'Người trưởng thành, Gen Z',
				'_pi_service_thumb_color'  => 'clear',
				'_pi_service_is_featured'  => true,
			),
			'category' => 'Trong suốt',
		),
		array(
			'title'   => 'Niềng mặt trong',
			'slug'    => 'nieng-mat-trong',
			'content' => '<p>Niềng mặt trong (Lingual Braces) gắn mắc cài ở mặt trong của răng, hoàn toàn ẩn khi nói chuyện hay cười. Đây là giải pháp chỉnh nha "vô hình thực sự" cho người có yêu cầu thẩm mỹ tuyệt đối.</p><h2>Hoàn toàn ẩn</h2><p>Không ai biết bạn đang niềng răng — mắc cài nằm hoàn toàn ở mặt trong.</p>',
			'meta'    => array(
				'_pi_service_tagline'      => 'Hoàn toàn ẩn, vô hình tuyệt đối',
				'_pi_service_price_from'   => 65,
				'_pi_service_duration'     => '18-30 tháng',
				'_pi_service_suitable_for' => 'Người cần thẩm mỹ tuyệt đối',
				'_pi_service_thumb_color'  => 'lingual',
				'_pi_service_is_featured'  => true,
			),
			'category' => 'Mặt trong',
		),
	);

	$service_ids = array();

	foreach ( $services_data as $s ) {
		$post_id = wp_insert_post( array(
			'post_title'   => $s['title'],
			'post_name'    => $s['slug'],
			'post_content' => $s['content'],
			'post_status'  => 'publish',
			'post_type'    => 'pi_service',
		) );

		if ( ! is_wp_error( $post_id ) ) {
			foreach ( $s['meta'] as $key => $val ) {
				update_post_meta( $post_id, $key, $val );
			}
			wp_set_object_terms( $post_id, $s['category'], 'pi_service_category' );
			$service_ids[ $s['slug'] ] = $post_id;
		}
	}

	// ─── 2. DOCTORS ───────────────────────────────────────────────────
	$doctors_data = array(
		array(
			'title'   => 'BS. Nguyễn Văn A',
			'slug'    => 'bs-nguyen-van-a',
			'content' => '<p>BS. Nguyễn Văn A là bác sĩ chỉnh nha với hơn 10 năm kinh nghiệm, chuyên sâu về mắc cài tự khóa và niềng trong suốt. Anh tốt nghiệp Thạc sĩ Răng Hàm Mặt tại Đại học Y Dược TP.HCM và đã điều trị thành công hơn 2000 ca chỉnh nha.</p>',
			'meta'    => array(
				'_pi_doctor_title'       => 'Bác sĩ chỉnh nha',
				'_pi_doctor_credentials' => 'Thạc sĩ RHM — ĐH Y Dược TP.HCM',
				'_pi_doctor_specialties' => 'Invisalign, Mắc cài tự khóa, Ca phức tạp',
				'_pi_doctor_is_featured' => true,
				'_pi_doctor_services'    => array(),
			),
		),
		array(
			'title'   => 'BS. Trần Thị B',
			'slug'    => 'bs-tran-thi-b',
			'content' => '<p>BS. Trần Thị B chuyên về niềng răng trẻ em và niềng mắc cài sứ thẩm mỹ. Chị tốt nghiệp Chuyên khoa I Chỉnh nha tại Đại học Y Dược Hà Nội, với phong cách điều trị tỉ mỉ và nhẹ nhàng.</p>',
			'meta'    => array(
				'_pi_doctor_title'       => 'Bác sĩ chỉnh nha',
				'_pi_doctor_credentials' => 'CKI Chỉnh nha — ĐH Y Dược Hà Nội',
				'_pi_doctor_specialties' => 'Mắc cài sứ, Chỉnh nha trẻ em',
				'_pi_doctor_is_featured' => true,
				'_pi_doctor_services'    => array(),
			),
		),
		array(
			'title'   => 'BS. Lê Văn C',
			'slug'    => 'bs-le-van-c',
			'content' => '<p>BS. Lê Văn C là chuyên gia niềng mặt trong (lingual) và các ca chỉnh nha phối hợp phẫu thuật. Anh đã tu nghiệp tại Hàn Quốc và có chứng chỉ Incognito Lingual System.</p>',
			'meta'    => array(
				'_pi_doctor_title'       => 'Bác sĩ chỉnh nha chuyên sâu',
				'_pi_doctor_credentials' => 'Thạc sĩ RHM — Tu nghiệp Hàn Quốc',
				'_pi_doctor_specialties' => 'Niềng mặt trong, Ca phẫu thuật chỉnh hàm',
				'_pi_doctor_is_featured' => true,
				'_pi_doctor_services'    => array(),
			),
		),
	);

	$doctor_ids = array();

	foreach ( $doctors_data as $d ) {
		$post_id = wp_insert_post( array(
			'post_title'   => $d['title'],
			'post_name'    => $d['slug'],
			'post_content' => $d['content'],
			'post_status'  => 'publish',
			'post_type'    => 'pi_doctor',
		) );

		if ( ! is_wp_error( $post_id ) ) {
			foreach ( $d['meta'] as $key => $val ) {
				if ( '_pi_doctor_services' === $key ) {
					// Sẽ cập nhật sau khi có service IDs.
					continue;
				}
				update_post_meta( $post_id, $key, $val );
			}
			$doctor_ids[ $d['slug'] ] = $post_id;
		}
	}

	// Cập nhật _pi_doctor_services (JSON array chứa service IDs).
	$all_svc_ids = array_values( $service_ids );

	if ( ! empty( $doctor_ids ) && ! empty( $all_svc_ids ) ) {
		// BS A: tất cả dịch vụ.
		if ( isset( $doctor_ids['bs-nguyen-van-a'] ) ) {
			update_post_meta(
				$doctor_ids['bs-nguyen-van-a'],
				'_pi_doctor_services',
				wp_json_encode( array_map( 'strval', $all_svc_ids ) )
			);
		}
		// BS B: mắc cài kim loại + mắc cài sứ.
		if ( isset( $doctor_ids['bs-tran-thi-b'] ) ) {
			$b_svcs = array_filter( array(
				isset( $service_ids['nieng-mac-cai-kim-loai'] ) ? (string) $service_ids['nieng-mac-cai-kim-loai'] : '',
				isset( $service_ids['nieng-mac-cai-su'] ) ? (string) $service_ids['nieng-mac-cai-su'] : '',
			) );
			update_post_meta( $doctor_ids['bs-tran-thi-b'], '_pi_doctor_services', wp_json_encode( array_values( $b_svcs ) ) );
		}
		// BS C: niềng mặt trong + trong suốt.
		if ( isset( $doctor_ids['bs-le-van-c'] ) ) {
			$c_svcs = array_filter( array(
				isset( $service_ids['nieng-trong-suot'] ) ? (string) $service_ids['nieng-trong-suot'] : '',
				isset( $service_ids['nieng-mat-trong'] ) ? (string) $service_ids['nieng-mat-trong'] : '',
			) );
			update_post_meta( $doctor_ids['bs-le-van-c'], '_pi_doctor_services', wp_json_encode( array_values( $c_svcs ) ) );
		}
	}

	// ─── 3. CASES ─────────────────────────────────────────────────────
	$first_doctor_id  = ! empty( $doctor_ids ) ? reset( $doctor_ids ) : 0;
	$first_service_id = isset( $service_ids['nieng-mac-cai-kim-loai'] ) ? $service_ids['nieng-mac-cai-kim-loai'] : 0;

	$cases_data = array(
		array(
			'title'   => 'Case hô vẩu 18 tháng',
			'slug'    => 'case-ho-vau-18-thang',
			'content' => '<p>Bệnh nhân nữ 25 tuổi, tình trạng hô vẩu hàm trên do xương, răng chen chúc nhẹ. Điều trị bằng mắc cài kim loại tự khóa trong 18 tháng, kết quả profil cải thiện rõ rệt, khớp cắn ổn định.</p>',
			'meta'    => array(
				'_pi_case_patient_age'    => '25 tuổi',
				'_pi_case_patient_gender' => 'female',
				'_pi_case_duration'       => '18 tháng',
				'_pi_case_diagnosis'      => 'Hô vẩu hàm trên, chen chúc nhẹ',
				'_pi_case_doctor_id'      => $first_doctor_id,
				'_pi_case_service_id'     => $first_service_id,
				'_pi_case_is_featured'    => true,
			),
			'tags' => array( 'hô', 'người lớn' ),
		),
		array(
			'title'   => 'Case móm 24 tháng',
			'slug'    => 'case-mom-24-thang',
			'content' => '<p>Bệnh nhân nam 30 tuổi, móm xương hàm dưới (Class III). Điều trị phối hợp niềng trong suốt và mini-screw trong 24 tháng. Kết quả khớp cắn đúng, khuôn mặt cân đối hơn.</p>',
			'meta'    => array(
				'_pi_case_patient_age'    => '30 tuổi',
				'_pi_case_patient_gender' => 'male',
				'_pi_case_duration'       => '24 tháng',
				'_pi_case_diagnosis'      => 'Móm xương hàm dưới, Class III skeletal',
				'_pi_case_doctor_id'      => isset( $doctor_ids['bs-le-van-c'] ) ? $doctor_ids['bs-le-van-c'] : $first_doctor_id,
				'_pi_case_service_id'     => isset( $service_ids['nieng-trong-suot'] ) ? $service_ids['nieng-trong-suot'] : $first_service_id,
				'_pi_case_is_featured'    => true,
			),
			'tags' => array( 'móm', 'người lớn' ),
		),
		array(
			'title'   => 'Case thưa 12 tháng',
			'slug'    => 'case-thua-12-thang',
			'content' => '<p>Bệnh nhân nữ 22 tuổi, răng thưa kẽ hàm trên. Điều trị bằng mắc cài sứ thẩm mỹ trong 12 tháng, kết quả các kẽ thưa được đóng hoàn toàn, nụ cười tự nhiên và hài hòa.</p>',
			'meta'    => array(
				'_pi_case_patient_age'    => '22 tuổi',
				'_pi_case_patient_gender' => 'female',
				'_pi_case_duration'       => '12 tháng',
				'_pi_case_diagnosis'      => 'Răng thưa kẽ hàm trên, spacing',
				'_pi_case_doctor_id'      => isset( $doctor_ids['bs-tran-thi-b'] ) ? $doctor_ids['bs-tran-thi-b'] : $first_doctor_id,
				'_pi_case_service_id'     => isset( $service_ids['nieng-mac-cai-su'] ) ? $service_ids['nieng-mac-cai-su'] : $first_service_id,
				'_pi_case_is_featured'    => false,
			),
			'tags' => array( 'thưa', 'người lớn' ),
		),
	);

	foreach ( $cases_data as $c ) {
		$post_id = wp_insert_post( array(
			'post_title'   => $c['title'],
			'post_name'    => $c['slug'],
			'post_content' => $c['content'],
			'post_status'  => 'publish',
			'post_type'    => 'pi_case',
		) );

		if ( ! is_wp_error( $post_id ) ) {
			foreach ( $c['meta'] as $key => $val ) {
				update_post_meta( $post_id, $key, $val );
			}
			if ( ! empty( $c['tags'] ) ) {
				wp_set_object_terms( $post_id, $c['tags'], 'pi_case_tag' );
			}
		}
	}

	// ─── 4. BLOG POSTS ────────────────────────────────────────────────
	// Tạo category "Kiến thức" nếu chưa có.
	$cat = term_exists( 'Kiến thức', 'category' );
	if ( ! $cat ) {
		$cat = wp_insert_term( 'Kiến thức', 'category', array( 'slug' => 'kien-thuc' ) );
	}
	$cat_id = is_array( $cat ) ? $cat['term_id'] : $cat;

	$posts_data = array(
		array(
			'title'   => 'Niềng răng mất bao lâu? Yếu tố ảnh hưởng thời gian chỉnh nha',
			'slug'    => 'nieng-rang-mat-bao-lau',
			'excerpt' => 'Thời gian niềng răng trung bình từ 12-36 tháng tùy mức độ phức tạp. Tìm hiểu các yếu tố ảnh hưởng đến thời gian điều trị chỉnh nha tại Pi Dentist.',
			'content' => '<p>Một trong những câu hỏi phổ biến nhất khi tìm hiểu về chỉnh nha là "Niềng răng mất bao lâu?". Thực tế, thời gian điều trị phụ thuộc vào nhiều yếu tố khác nhau.</p><h2>Các yếu tố ảnh hưởng</h2><p>Mức độ sai lệch khớp cắn, tuổi bệnh nhân, phương pháp niềng, và sự tuân thủ của bệnh nhân là những yếu tố chính quyết định thời gian điều trị.</p><h2>Thời gian trung bình theo phương pháp</h2><p>Mắc cài kim loại: 18-24 tháng. Mắc cài sứ: 18-24 tháng. Niềng trong suốt: 12-18 tháng. Niềng mặt trong: 18-30 tháng.</p>',
		),
		array(
			'title'   => 'Chi phí niềng răng 2024: Bảng giá chi tiết từ Pi Dentist',
			'slug'    => 'chi-phi-nieng-rang-2024',
			'excerpt' => 'Cập nhật bảng giá niềng răng mới nhất 2024 tại Pi Dentist. So sánh chi phí các phương pháp chỉnh nha phổ biến và các yếu tố ảnh hưởng giá.',
			'content' => '<p>Chi phí niềng răng là mối quan tâm hàng đầu của nhiều bệnh nhân. Bài viết này cung cấp thông tin chi tiết về bảng giá tại Pi Dentist.</p><h2>Bảng giá tổng quan</h2><p>Mắc cài kim loại: từ 25 triệu. Mắc cài sứ: từ 35 triệu. Niềng trong suốt: từ 45 triệu. Niềng mặt trong: từ 65 triệu.</p><h2>Yếu tố ảnh hưởng chi phí</h2><p>Mức độ phức tạp, loại khí cụ, thương hiệu, và phác đồ điều trị đều ảnh hưởng đến tổng chi phí cuối cùng.</p>',
		),
		array(
			'title'   => 'Niềng răng có đau không? Giải đáp từ chuyên gia Pi Dentist',
			'slug'    => 'nieng-rang-co-dau-khong',
			'excerpt' => 'Nhiều người lo lắng niềng răng sẽ đau. Bác sĩ Pi Dentist giải đáp chi tiết về cảm giác khi niềng và cách giảm đau hiệu quả.',
			'content' => '<p>Nỗi lo về đau đớn khi niềng răng là hoàn toàn bình thường. Tuy nhiên, với công nghệ hiện đại, quá trình niềng răng ngày nay đã thoải mái hơn rất nhiều.</p><h2>Cảm giác khi mới gắn mắc cài</h2><p>Trong 3-5 ngày đầu, bạn có thể cảm thấy ê nhức nhẹ. Đây là phản ứng bình thường khi răng bắt đầu dịch chuyển.</p><h2>Cách giảm đau hiệu quả</h2><p>Ăn mềm, dùng sáp bảo vệ, thuốc giảm đau khi cần, và tuân thủ lịch hẹn tái khám đều đặn.</p>',
		),
		array(
			'title'   => 'So sánh niềng trong suốt và mắc cài: Nên chọn loại nào?',
			'slug'    => 'so-sanh-nieng-trong-suot-va-mac-cai',
			'excerpt' => 'Phân tích chi tiết ưu nhược điểm của niềng trong suốt và mắc cài truyền thống. Hướng dẫn chọn phương pháp chỉnh nha phù hợp.',
			'content' => '<p>Niềng trong suốt hay mắc cài? Đây là câu hỏi nhiều bệnh nhân đặt ra. Mỗi phương pháp đều có ưu nhược điểm riêng.</p><h2>Niềng trong suốt</h2><p>Ưu điểm: thẩm mỹ cao, tháo lắp được, vệ sinh dễ. Nhược điểm: đòi hỏi kỷ luật đeo, chi phí cao hơn, không phù hợp ca phức tạp.</p><h2>Mắc cài truyền thống</h2><p>Ưu điểm: hiệu quả cao mọi trường hợp, chi phí thấp hơn. Nhược điểm: thẩm mỹ kém hơn, khó vệ sinh hơn.</p>',
		),
		array(
			'title'   => 'Quy trình niềng răng tại Pi Dentist: 5 bước đơn giản',
			'slug'    => 'quy-trinh-nieng-rang-pi-dentist',
			'excerpt' => 'Tìm hiểu quy trình niềng răng 5 bước chuyên nghiệp tại Pi Dentist: từ tư vấn, chẩn đoán, lên kế hoạch đến gắn khí cụ và theo dõi.',
			'content' => '<p>Tại Pi Dentist, quy trình niềng răng được chuẩn hóa thành 5 bước rõ ràng, minh bạch để bệnh nhân an tâm suốt hành trình.</p><h2>Bước 1: Tư vấn miễn phí</h2><p>Khám tổng quát, chụp X-quang, đánh giá tình trạng ban đầu.</p><h2>Bước 2: Chẩn đoán chuyên sâu</h2><p>Phân tích phim sọ, lấy dấu số hóa 3D, xây dựng phác đồ cá nhân hóa.</p><h2>Bước 3: Lên kế hoạch điều trị</h2><p>Trình bày kế hoạch, chi phí, thời gian dự kiến. Bệnh nhân đồng thuận trước khi bắt đầu.</p>',
		),
	);

	foreach ( $posts_data as $p ) {
		$post_id = wp_insert_post( array(
			'post_title'   => $p['title'],
			'post_name'    => $p['slug'],
			'post_content' => $p['content'],
			'post_excerpt' => $p['excerpt'],
			'post_status'  => 'publish',
			'post_type'    => 'post',
		) );

		if ( ! is_wp_error( $post_id ) && $cat_id ) {
			wp_set_post_categories( $post_id, array( absint( $cat_id ) ) );
		}
	}

	// Flush rewrite rules.
	flush_rewrite_rules();

	// Admin notice.
	add_action( 'admin_notices', function () {
		echo '<div class="notice notice-success is-dismissible"><p><strong>Pi Dentist:</strong> Seed data đã được tạo thành công! (4 services, 3 doctors, 3 cases, 5 blog posts)</p></div>';
	} );
}
