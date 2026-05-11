<?php
/**
 * Pi Dentist — Trang Về Pi (Giới thiệu)
 *
 * Template Name: Trang Về Pi
 * Slug: page-ve-pi
 *
 * Custom page template cho /ve-pi/.
 * Render: page hero → philosophy → core values → doctor team → stats.
 * Không lấy section "Video từ Pi Dentist".
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<?php
// Page Hero — navy background with large π watermark
get_template_part( 'template-parts/section/page-hero', null, array(
	'label'      => 'VỀ PI DENTIST',
	'heading'    => 'Câu chuyện Pi Dentist',
	'sub'        => 'Nơi mỗi nụ cười được thiết kế với độ chính xác tuyệt đối — lấy cảm hứng từ hằng số π',
	'breadcrumb' => true,
) );
?>

<main class="pi-about-page" id="main-content">

	<!-- ══════════════════════════════════════════════
	     Section 1: Triết lý Pi — "Chính xác như hằng số π"
	     ══════════════════════════════════════════════ -->
	<section class="about-philosophy pi-section" id="philosophy" aria-label="Triết lý Pi Dentist">
		<div class="container">
			<div class="about-philosophy__grid">

				<!-- Left: Decorative π symbol -->
				<div class="about-philosophy__visual reveal">
					<div class="about-philosophy__pi-box">
						<span class="about-philosophy__pi-symbol" aria-hidden="true">π</span>
						<div class="about-philosophy__pi-glow" aria-hidden="true"></div>
					</div>
				</div>

				<!-- Right: Text content -->
				<div class="about-philosophy__content reveal">
					<p class="section-label">TRIẾT LÝ PI DENTIST</p>
					<h2 class="section-heading">Chính xác như hằng số π</h2>
					<div class="gold-line-left"></div>

					<p class="about-philosophy__desc">
						Pi (π) — hằng số vô tỉ, vô hạn, nhưng chính xác tuyệt đối. Đây chính là triết lý mà Pi Dentist mang vào từng ca chỉnh nha: mỗi milimet dịch chuyển, mỗi góc nghiêng răng đều được tính toán bằng công nghệ số hiện đại nhất.
					</p>
					<p class="about-philosophy__desc">
						Chúng tôi tin rằng một nụ cười đẹp không đến từ may mắn — mà đến từ sự chính xác trong từng bước điều trị, từ chẩn đoán đến hoàn thiện.
					</p>

					<!-- Feature items -->
					<div class="about-philosophy__features">
						<div class="about-philosophy__feature-item">
							<div class="about-philosophy__feature-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
							</div>
							<div>
								<h3>Tại sao tên Pi?</h3>
								<p>Cái tên "Pi" lấy cảm hứng từ hằng số toán học π (3.14159...) — một con số vô hạn nhưng chính xác tuyệt đối. Giống như π xuất hiện trong mọi đường tròn hoàn hảo, Pi Dentist cam kết mang đến sự hoàn hảo trong từng nụ cười.</p>
							</div>
						</div>

						<div class="about-philosophy__feature-item">
							<div class="about-philosophy__feature-icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="24" height="24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
							</div>
							<div>
								<h3>Ý nghĩa Logo</h3>
								<p>Logo Pi Dentist kết hợp ký hiệu π với biểu tượng nụ cười — thể hiện sự giao thoa giữa khoa học chính xác và nghệ thuật thẩm mỹ nha khoa.</p>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>

	<!-- ══════════════════════════════════════════════
	     Section 2: Ba giá trị nền tảng
	     ══════════════════════════════════════════════ -->
	<section class="about-values pi-section" id="values" aria-label="Giá trị cốt lõi">
		<div class="container">

			<!-- Section Header -->
			<div class="section-header">
				<p class="section-label">GIÁ TRỊ CỐT LÕI</p>
				<h2 class="section-heading">Ba giá trị nền tảng</h2>
				<p class="section-sub">Mỗi quyết định, mỗi hành động tại Pi Dentist đều được dẫn dắt bởi ba giá trị cốt lõi</p>
				<div class="gold-line"></div>
			</div>

			<!-- Values Grid -->
			<div class="about-values__grid">

				<!-- Value 1: Chính xác -->
				<div class="about-values__card reveal">
					<div class="about-values__icon-wrap">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28">
							<circle cx="12" cy="12" r="10"/>
							<circle cx="12" cy="12" r="6"/>
							<circle cx="12" cy="12" r="2"/>
							<line x1="12" y1="2" x2="12" y2="6"/>
							<line x1="12" y1="18" x2="12" y2="22"/>
							<line x1="2" y1="12" x2="6" y2="12"/>
							<line x1="18" y1="12" x2="22" y2="12"/>
						</svg>
					</div>
					<h3>Chính xác</h3>
					<p>Mỗi milimet dịch chuyển răng đều được tính toán bằng công nghệ 3D và phần mềm AI. Không phỏng đoán, chỉ có dữ liệu chính xác.</p>
				</div>

				<!-- Value 2: Tận tâm -->
				<div class="about-values__card reveal">
					<div class="about-values__icon-wrap">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28">
							<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
						</svg>
					</div>
					<h3>Tận tâm</h3>
					<p>Đặt sức khỏe và sự hài lòng của bệnh nhân lên hàng đầu. Cam kết đồng hành từ ngày đầu đến khi hoàn tất và theo dõi trọn đời.</p>
				</div>

				<!-- Value 3: Minh bạch -->
				<div class="about-values__card reveal">
					<div class="about-values__icon-wrap">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="28" height="28">
							<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
							<circle cx="12" cy="12" r="3"/>
						</svg>
					</div>
					<h3>Minh bạch</h3>
					<p>Chi phí rõ ràng, quy trình công khai, kết quả có thể mô phỏng trước. Không phát sinh, không chi phí ẩn.</p>
				</div>

			</div>

		</div>
	</section>

	<!-- ══════════════════════════════════════════════
	     Section 3: Đội ngũ bác sĩ chuyên sâu
	     ══════════════════════════════════════════════ -->
	<section class="about-team pi-section" id="team" aria-label="Đội ngũ bác sĩ">
		<div class="container">

			<!-- Section Header -->
			<div class="section-header">
				<p class="section-label">ĐỘI NGŨ BÁC SĨ</p>
				<h2 class="section-heading">Đội ngũ bác sĩ chuyên sâu</h2>
				<p class="section-sub">Được đào tạo tại các trường đại học và trung tâm chỉnh nha hàng đầu</p>
				<div class="gold-line"></div>
			</div>

			<!-- Doctors Grid (CPT query) -->
			<div class="about-team__grid">
				<?php
				$doctors_query = new WP_Query( array(
					'post_type'      => 'pi_doctor',
					'posts_per_page' => 3,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				) );

				if ( $doctors_query->have_posts() ) :
					while ( $doctors_query->have_posts() ) :
						$doctors_query->the_post();
						$doctor_title_meta = get_post_meta( get_the_ID(), '_pi_doctor_title', true );
						$specialties       = get_post_meta( get_the_ID(), '_pi_doctor_specialties', true );
						$permalink         = get_the_permalink();
						?>

						<article class="about-team__card reveal" id="about-doctor-<?php echo esc_attr( get_the_ID() ); ?>">
							<!-- Photo -->
							<a href="<?php echo esc_url( $permalink ); ?>" class="about-team__photo-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="about-team__photo">
										<?php the_post_thumbnail( 'medium_large', array(
											'alt'     => esc_attr( get_the_title() ),
											'loading' => 'lazy',
										) ); ?>
									</div>
								<?php else : ?>
									<div class="about-team__photo about-team__photo-placeholder">
										<svg class="doctor-avatar-svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
											<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1"/>
											<circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1"/>
										</svg>
									</div>
								<?php endif; ?>
							</a>

							<!-- Info -->
							<div class="about-team__info">
								<h3 class="about-team__name">
									<a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a>
								</h3>

								<?php if ( $doctor_title_meta ) : ?>
									<p class="about-team__title"><?php echo esc_html( $doctor_title_meta ); ?></p>
								<?php endif; ?>

								<?php if ( $specialties ) : ?>
									<ul class="about-team__specialties">
										<?php
										$specs = array_map( 'trim', explode( ',', $specialties ) );
										foreach ( $specs as $spec ) :
											?>
											<li>
												<span class="about-team__spec-dot" aria-hidden="true"></span>
												<?php echo esc_html( $spec ); ?>
											</li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>

								<a href="<?php echo esc_url( $permalink ); ?>" class="card-link">
									Xem hồ sơ <span aria-hidden="true">→</span>
								</a>
							</div>
						</article>

						<?php
					endwhile;
					wp_reset_postdata();
				else :
					// Fallback — hardcoded doctors when no CPT data
					$fallback_doctors = array(
						array(
							'name'        => 'TS. BS. Nguyễn Minh Đức',
							'title'       => 'Giám đốc chuyên môn — Chuyên gia chỉnh nha',
							'specialties' => array( 'Chỉnh nha người lớn', 'Niềng trong suốt', 'Ca phức tạp' ),
						),
						array(
							'name'        => 'ThS. BS. Trần Thanh Hà',
							'title'       => 'Bác sĩ chỉnh nha — Chuyên gia niềng trong suốt',
							'specialties' => array( 'Niềng trong suốt', 'Mắc cài sứ', 'Thẩm mỹ nụ cười' ),
						),
						array(
							'name'        => 'BS. Lê Hoàng Phúc',
							'title'       => 'Bác sĩ chỉnh nha — Chuyên gia niềng mặt trong',
							'specialties' => array( 'Niềng mặt trong', 'Mắc cài kim loại', 'Chỉnh nha trẻ em' ),
						),
					);

					foreach ( $fallback_doctors as $fb_doc ) :
						?>
						<article class="about-team__card reveal">
							<a href="<?php echo esc_url( home_url( '/bac-si/' ) ); ?>" class="about-team__photo-link" aria-label="<?php echo esc_attr( $fb_doc['name'] ); ?>">
								<div class="about-team__photo about-team__photo-placeholder">
									<svg class="doctor-avatar-svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
										<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1"/>
										<circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1"/>
									</svg>
								</div>
							</a>
							<div class="about-team__info">
								<h3 class="about-team__name">
									<a href="<?php echo esc_url( home_url( '/bac-si/' ) ); ?>"><?php echo esc_html( $fb_doc['name'] ); ?></a>
								</h3>
								<p class="about-team__title"><?php echo esc_html( $fb_doc['title'] ); ?></p>
								<ul class="about-team__specialties">
									<?php foreach ( $fb_doc['specialties'] as $spec ) : ?>
										<li>
											<span class="about-team__spec-dot" aria-hidden="true"></span>
											<?php echo esc_html( $spec ); ?>
										</li>
									<?php endforeach; ?>
								</ul>
								<a href="<?php echo esc_url( home_url( '/bac-si/' ) ); ?>" class="card-link">
									Xem hồ sơ <span aria-hidden="true">→</span>
								</a>
							</div>
						</article>
						<?php
					endforeach;
				endif;
				?>
			</div>

			<!-- View All Doctors CTA -->
			<div class="about-team__cta">
				<a href="<?php echo esc_url( home_url( '/bac-si/' ) ); ?>" class="btn btn-outline-navy">
					Xem chi tiết đội ngũ <span aria-hidden="true">→</span>
				</a>
			</div>

		</div>
	</section>

	<!-- ══════════════════════════════════════════════
	     Section 4: Con số ấn tượng — Thành quả tạo nên uy tín
	     ══════════════════════════════════════════════ -->
	<section class="about-stats pi-section pi-navy-bg" id="stats" aria-label="Con số ấn tượng">
		<!-- Decorative circles -->
		<div class="about-stats__decor" aria-hidden="true">
			<div class="about-stats__circle about-stats__circle--1"></div>
			<div class="about-stats__circle about-stats__circle--2"></div>
		</div>

		<div class="container">

			<!-- Section Header -->
			<div class="section-header">
				<p class="section-label-gold">CON SỐ ẤN TƯỢNG</p>
				<h2 class="section-heading-white">Thành quả tạo nên uy tín</h2>
				<div class="gold-line"></div>
			</div>

			<!-- Stats Grid -->
			<div class="about-stats__grid">

				<div class="about-stats__item reveal">
					<span class="about-stats__number" data-target="5000">5000<span class="about-stats__plus">+</span></span>
					<span class="about-stats__label">Ca điều trị thành công</span>
				</div>

				<div class="about-stats__item reveal">
					<span class="about-stats__number" data-target="15">15<span class="about-stats__plus">+</span></span>
					<span class="about-stats__label">Năm kinh nghiệm</span>
				</div>

				<div class="about-stats__item reveal">
					<span class="about-stats__number" data-target="98">98<span class="about-stats__plus">%</span></span>
					<span class="about-stats__label">Bệnh nhân hài lòng</span>
				</div>

				<div class="about-stats__item reveal">
					<span class="about-stats__number" data-target="4">4</span>
					<span class="about-stats__label">Bác sĩ chuyên sâu</span>
				</div>

			</div>

		</div>
	</section>

</main>

<?php get_footer();
