<?php
/**
 * Pi Dentist — Archive: Dịch vụ (pi_service)
 *
 * Listing tất cả dịch vụ chỉnh nha tại /dich-vu/.
 * Layout: Page Hero → Services Grid → Pagination → CTA Booking.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main class="pi-archive pi-archive-services" id="main-content">

	<?php
	// ─── Page Hero ────────────────────────────────────────────────────
	get_template_part( 'template-parts/section/page-hero', null, array(
		'label'      => 'DỊCH VỤ',
		'heading'    => 'Phương pháp chỉnh nha phù hợp cho bạn',
		'breadcrumb' => true,
	) );
	?>

	<!-- ─── Services Grid ──────────────────────────────────────────── -->
	<section class="services-archive">
		<div class="container">

			<?php if ( have_posts() ) : ?>

				<div class="services-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/card/service-card' );
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
					<p>Chưa có dịch vụ nào được đăng. Vui lòng quay lại sau.</p>
				</div>

			<?php endif; ?>

		</div>
	</section>

	<!-- ─── CTA Booking ────────────────────────────────────────────── -->
	<?php get_template_part( 'template-parts/section/booking-cta' ); ?>

</main>

<?php get_footer();
