<?php
/**
 * Pi Dentist — Card: Bài viết (post-card)
 *
 * Hiển thị 1 post card trong grid.
 * Dùng trong: archive.php, search.php, front-page section 10, single.php (related).
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

$permalink  = get_the_permalink();
$categories = get_the_category();

// Ước tính read time (250 từ/phút).
$word_count = str_word_count( wp_strip_all_tags( get_the_content() ) );
$read_time  = max( 1, ceil( $word_count / 250 ) );
?>

<article class="post-card reveal" id="post-<?php echo esc_attr( get_the_ID() ); ?>">

	<!-- Thumbnail -->
	<a href="<?php echo esc_url( $permalink ); ?>" class="post-card__thumb-link" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
		<div class="post-card__thumb">
			<?php if ( has_post_thumbnail() ) : ?>
				<?php the_post_thumbnail( 'medium_large', array(
					'alt'     => esc_attr( get_the_title() ),
					'loading' => 'lazy',
				) ); ?>
			<?php else : ?>
				<div class="post-card__thumb-placeholder" aria-hidden="true">
					<span>π</span>
				</div>
			<?php endif; ?>
		</div>
	</a>

	<!-- Card Body -->
	<div class="post-card__body">

		<?php if ( ! empty( $categories ) ) : ?>
			<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="post-card__category">
				<?php echo esc_html( $categories[0]->name ); ?>
			</a>
		<?php endif; ?>

		<h3 class="post-card__title">
			<a href="<?php echo esc_url( $permalink ); ?>"><?php the_title(); ?></a>
		</h3>

		<p class="post-card__excerpt">
			<?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '…' ) ); ?>
		</p>

		<div class="post-card__meta">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
				<?php echo esc_html( get_the_date( 'd/m/Y' ) ); ?>
			</time>
			<span class="post-card__meta-sep" aria-hidden="true">·</span>
			<span><?php echo esc_html( $read_time ); ?> phút đọc</span>
		</div>

		<a href="<?php echo esc_url( $permalink ); ?>" class="card-link">
			Đọc thêm <span aria-hidden="true">→</span>
		</a>
	</div>

</article>
