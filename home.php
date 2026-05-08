<?php
/**
 * Pi Dentist — Home: Blog Archive (/kiến thức/)
 *
 * Template cho trang Posts page (page_for_posts).
 * WordPress dùng home.php (KHÔNG phải archive.php) cho blog listing.
 * Layout: Page Hero → Posts Grid → Pagination → CTA Booking.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main class="pi-archive pi-archive-blog" id="main-content">

	<?php
	// ─── Page Hero ────────────────────────────────────────────────────
	get_template_part( 'template-parts/section/page-hero', null, array(
		'label'      => 'KIẾN THỨC',
		'heading'    => 'Blog chỉnh nha',
		'sub'        => 'Cập nhật kiến thức chỉnh nha, chăm sóc răng miệng từ đội ngũ Pi Dentist',
		'breadcrumb' => true,
	) );
	?>

	<!-- ─── Posts Grid ──────────────────────────────────────────── -->
	<section class="blog-archive">
		<div class="container">

			<?php if ( have_posts() ) : ?>

				<div class="posts-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/card/post-card' );
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
					<p>Chưa có bài viết nào. Vui lòng quay lại sau.</p>
				</div>

			<?php endif; ?>

		</div>
	</section>

	<!-- ─── CTA Booking ──────────────────────────────────────────── -->
	<?php get_template_part( 'template-parts/section/booking-cta' ); ?>

</main>

<?php get_footer();
