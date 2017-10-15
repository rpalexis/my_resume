<?php get_header(); ?>

	<?php if( have_posts() ): ?>
		
		<?php while( have_posts() ) : the_post(); ?>

			<?php $cover_class = !typology_get_option( 'page_cover' ) ? 'typology-cover-empty' : ''; ?>
			<div id="typology-cover" class="typology-cover <?php echo esc_attr($cover_class); ?>">
				<?php get_template_part('template-parts/cover/cover-page'); ?>
			</div>
			<div class="typology-fake-bg">
				<div class="typology-section">

					<?php get_template_part('template-parts/page/content'); ?>

					<?php comments_template(); ?>

				</div>

		<?php endwhile; ?>

	<?php endif; ?>

<?php get_footer(); ?>