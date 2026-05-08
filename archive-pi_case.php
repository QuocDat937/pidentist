<?php
/**
 * Pi Dentist — Archive: Ca điều trị (pi_case)
 *
 * Listing tất cả ca điều trị tại /case/.
 * Layout: Page Hero → Tag Filter → Cases Grid → Pagination → CTA Booking.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main class="pi-archive pi-archive-cases" id="main-content">

	<?php
	// ─── Page Hero ────────────────────────────────────────────────────
	get_template_part( 'template-parts/section/page-hero', null, array(
		'label'      => 'CASE ĐIỀU TRỊ',
		'heading'    => 'Khoảnh khắc Pi — Trước & Sau',
		'sub'        => 'Những ca điều trị thực tế tại Pi Dentist',
		'breadcrumb' => true,
	) );
	?>

	<!-- ─── Cases Grid ───────────────────────────────────────────── -->
	<section class="cases-archive">
		<div class="container">

			<?php
			// ─── Tag Filter ──────────────────────────────────────────
			$case_tags = get_terms( array(
				'taxonomy'   => 'pi_case_tag',
				'hide_empty' => true,
			) );

			if ( ! empty( $case_tags ) && ! is_wp_error( $case_tags ) ) :
				$current_tag = get_queried_object();
			?>
				<div class="case-filter reveal">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'pi_case' ) ); ?>"
					   class="case-filter-tag <?php echo ! is_tax( 'pi_case_tag' ) ? 'active' : ''; ?>">
						Tất cả
					</a>
					<?php foreach ( $case_tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>"
						   class="case-filter-tag <?php echo ( is_tax( 'pi_case_tag' ) && $current_tag->term_id === $tag->term_id ) ? 'active' : ''; ?>">
							<?php echo esc_html( $tag->name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

				<div class="cases-grid">
					<?php
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/card/case-card' );
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
					<p>Chưa có ca điều trị nào được đăng. Vui lòng quay lại sau.</p>
				</div>

			<?php endif; ?>

		</div>
	</section>

	<!-- ─── CTA Booking ──────────────────────────────────────────── -->
	<?php get_template_part( 'template-parts/section/booking-cta' ); ?>

</main>

<?php get_footer();
