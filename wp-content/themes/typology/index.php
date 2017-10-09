<?php get_header(); ?>

<?php $cover_class = !typology_get_option( 'archive_cover' ) ? 'typology-cover-empty' : ''; ?>
<div id="typology-cover" class="typology-cover <?php echo esc_attr($cover_class); ?>">
	<?php get_template_part('template-parts/cover/cover-archive'); ?>
</div>

<div class="typology-fake-bg">
	<div class="typology-section">
		
		<?php if( !typology_get_option('archive_cover') ) : ?>
			<?php $heading = typology_get_archive_heading(); ?>
			<?php typology_section_heading( array( 'title' => $heading['title'],  'pre' => $heading['pre'], 'element' => 'h1' , 'avatar' => $heading['avatar']) ); ?>
		<?php endif; ?>
		
		<?php $archive_layout = typology_get_option( 'archive_layout'); ?>

		<?php if( have_posts() ) : ?>

			<div class="section-content section-content-<?php echo esc_attr( $archive_layout ); ?>">

				<div class="typology-posts">

					<?php while( have_posts() ) : the_post(); ?>
						<?php get_template_part('template-parts/layouts/content-'. $archive_layout ); ?>
					<?php endwhile; ?>

				</div>
			
				<?php get_template_part('template-parts/pagination/'. typology_get_option( 'archive_pagination') ); ?>

			</div>

		<?php else: ?>

			<?php get_template_part('template-parts/layouts/content-none' ); ?>

		<?php endif; ?>

	</div>

<?php get_footer(); ?>