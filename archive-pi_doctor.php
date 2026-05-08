<?php
/**
 * Pi Dentist — Archive: Bác sĩ (pi_doctor)
 *
 * Listing tất cả bác sĩ tại /bac-si/.
 * Layout: Page Hero → Doctors Grid → Pagination → CTA Booking.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main class="pi-archive pi-archive-doctors" id="main-content">

	<?php
	// ─── Page Hero ────────────────────────────────────────────────────
	get_template_part( 'template-parts/section/page-hero', null, array(
		'label'      => 'ĐỘI NGŨ BÁC SĨ',
		'heading'    => 'Đội ngũ bác sĩ Pi Dentist',
		'sub'        => 'Đội ngũ bác sĩ chỉnh nha giàu kinh nghiệm, tận tâm vì nụ cười của bạn',
		'breadcrumb' => true,
	) );
	?>

	<!-- ─── Doctors Grid ─────────────────────────────────────────── -->
	<section class="doctors-archive">
		<div class="container">

			<?php if ( have_posts() ) : ?>

				<div class="doctors-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/card/doctor-card' );
					endwhile;
					?>
				</div>

				<?php
				the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => '&larr; Trước',
					'next_text' => 'Tiếp &rarr;',
				) );
				?>

			<?php else : ?>

				<div class="pi-no-results">
					<p>Chưa có thông tin bác sĩ. Vui lòng quay lại sau.</p>
				</div>

			<?php endif; ?>

		</div>
	</section>

	<!-- ─── CTA Booking ──────────────────────────────────────────── -->
	<?php get_template_part( 'template-parts/section/booking-cta' ); ?>

</main>

<?php get_footer();
