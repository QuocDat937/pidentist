<?php
/**
 * Pi Dentist — Single: Blog Post
 *
 * Chi tiết 1 bài viết blog tại /kien-thuc/{slug}/.
 * Layout: Page Hero → Post Meta → Content → Tags → Prev/Next → Related → CTA Booking.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	// ─── Post data ────────────────────────────────────────────────────
	$categories = get_the_category();
	$tags       = get_the_tags();

	// Ước tính read time (250 từ/phút).
	$word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
	$read_time  = max( 1, ceil( $word_count / 250 ) );
?>

<main class="pi-single pi-single-post" id="main-content">

	<?php
	// ─── 1. Page Hero ─────────────────────────────────────────────────
	get_template_part( 'template-parts/section/page-hero', null, array(
		'label'      => 'KIẾN THỨC',
		'heading'    => get_the_title(),
		'breadcrumb' => true,
	) );
	?>

	<!-- ─── 2. Post Detail ─────────────────────────────────────── -->
	<article class="post-detail">
		<div class="container">

			<?php // ─── Post Meta ──────────────────────────────────────── ?>
			<div class="post-meta reveal">
				<div class="post-meta__item">
					<span class="post-meta__icon" aria-hidden="true">📅</span>
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
						<?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
					</time>
				</div>

				<div class="post-meta__item">
					<span class="post-meta__icon" aria-hidden="true">✍️</span>
					<span><?php echo esc_html( get_the_author() ); ?></span>
				</div>

				<?php if ( ! empty( $categories ) ) : ?>
					<div class="post-meta__item">
						<span class="post-meta__icon" aria-hidden="true">📁</span>
						<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>">
							<?php echo esc_html( $categories[0]->name ); ?>
						</a>
					</div>
				<?php endif; ?>

				<div class="post-meta__item">
					<span class="post-meta__icon" aria-hidden="true">⏱️</span>
					<span><?php echo esc_html( $read_time ); ?> phút đọc</span>
				</div>
			</div>

			<?php // ─── Featured Image ─────────────────────────────────── ?>
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="post-featured-image reveal">
					<?php the_post_thumbnail( 'large', array(
						'alt' => esc_attr( get_the_title() ),
					) ); ?>
				</figure>
			<?php endif; ?>

			<?php // ─── Content ────────────────────────────────────────── ?>
			<div class="post-content prose reveal">
				<?php the_content(); ?>
			</div>

			<?php // ─── Tags ──────────────────────────────────────────── ?>
			<?php if ( ! empty( $tags ) ) : ?>
				<div class="post-tags reveal">
					<span class="post-tags__label">Tags:</span>
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="post-tags__item">
							<?php echo esc_html( $tag->name ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<?php // ─── Prev / Next Navigation ────────────────────────── ?>
			<?php
			$prev_post = get_previous_post();
			$next_post = get_next_post();

			if ( $prev_post || $next_post ) :
			?>
				<nav class="post-nav reveal" aria-label="Điều hướng bài viết">
					<?php if ( $prev_post ) : ?>
						<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="post-nav__link post-nav__prev">
							<span class="post-nav__direction">&larr; Bài trước</span>
							<span class="post-nav__title"><?php echo esc_html( $prev_post->post_title ); ?></span>
						</a>
					<?php else : ?>
						<span class="post-nav__link post-nav__placeholder"></span>
					<?php endif; ?>

					<?php if ( $next_post ) : ?>
						<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="post-nav__link post-nav__next">
							<span class="post-nav__direction">Bài tiếp &rarr;</span>
							<span class="post-nav__title"><?php echo esc_html( $next_post->post_title ); ?></span>
						</a>
					<?php else : ?>
						<span class="post-nav__link post-nav__placeholder"></span>
					<?php endif; ?>
				</nav>
			<?php endif; ?>

		</div>
	</article>

	<?php
	// ─── 3. Related Posts ─────────────────────────────────────────────
	$related_cat_id = ! empty( $categories ) ? $categories[0]->term_id : 0;

	if ( $related_cat_id ) :
		$related_posts = new WP_Query( array(
			'post_type'      => 'post',
			'posts_per_page' => 3,
			'post_status'    => 'publish',
			'post__not_in'   => array( get_the_ID() ),
			'category__in'   => array( $related_cat_id ),
			'orderby'        => 'date',
			'order'          => 'DESC',
		) );

		if ( $related_posts->have_posts() ) :
	?>
		<section class="related-posts pi-off-white-bg">
			<div class="container">
				<?php
				get_template_part( 'template-parts/section/section-header', null, array(
					'label'   => 'BÀI VIẾT LIÊN QUAN',
					'heading' => 'Có thể bạn quan tâm',
				) );
				?>
				<div class="posts-grid">
					<?php
					while ( $related_posts->have_posts() ) :
						$related_posts->the_post();
						get_template_part( 'template-parts/card/post-card' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
	<?php
		endif;
	endif;
	?>

	<!-- ─── CTA Booking ──────────────────────────────────────────── -->
	<?php get_template_part( 'template-parts/section/booking-cta' ); ?>

</main>

<?php
endwhile;

get_footer();
