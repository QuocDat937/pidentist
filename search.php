<?php
/**
 * Pi Dentist — Search Results
 *
 * Trang kết quả tìm kiếm.
 * Layout: Page Hero → Results Grid → Pagination.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

<main class="pi-search" id="main-content">

	<?php
	// ─── Page Hero ────────────────────────────────────────────────────
	get_template_part( 'template-parts/section/page-hero', null, array(
		'label'   => 'TÌM KIẾM',
		'heading' => 'Kết quả cho "' . esc_html( get_search_query() ) . '"',
	) );
	?>

	<!-- ─── Search Results ─────────────────────────────────────── -->
	<section class="search-results">
		<div class="container">

			<?php if ( have_posts() ) : ?>

				<p class="search-results__count">
					<?php
					/* translators: %s: number of search results */
					printf(
						esc_html( 'Tìm thấy %s kết quả' ),
						'<strong>' . esc_html( $wp_query->found_posts ) . '</strong>'
					);
					?>
				</p>

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

				<div class="pi-no-results pi-no-results--search">
					<div class="pi-no-results__icon" aria-hidden="true">🔍</div>
					<h2>Không tìm thấy kết quả</h2>
					<p>Xin lỗi, không có kết quả nào phù hợp với từ khóa "<strong><?php echo esc_html( get_search_query() ); ?></strong>".</p>
					<p>Vui lòng thử lại với từ khóa khác hoặc quay về trang chủ.</p>

					<div class="pi-no-results__search">
						<?php get_search_form(); ?>
					</div>

					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-outline-navy">
						Về trang chủ
					</a>
				</div>

			<?php endif; ?>

		</div>
	</section>

</main>

<?php get_footer();
