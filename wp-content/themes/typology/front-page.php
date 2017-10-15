<?php get_header(); ?>


<?php $cover_class = !typology_get_option( 'front_page_cover' ) ? 'typology-cover-empty' : ''; ?>
<div id="typology-cover" class="typology-cover <?php echo esc_attr($cover_class); ?>">
	<?php if( $front_page_cover = typology_get_option( 'front_page_cover' ) ) :  ?>
		<?php get_template_part('template-parts/cover/cover-'. $front_page_cover ); ?>
	<?php endif; ?>
</div>

<div class="typology-fake-bg">
	<div class="typology-section">

		<?php if( have_posts() ): ?>

			<?php while( have_posts() ) : the_post(); ?>

				<?php if( strpos( typology_get_option( 'front_page_intro' ), 'title' ) !== false ) :  ?>
					<?php typology_section_heading( array( 'title' => get_the_title() ) ); ?>
				<?php endif; ?>

				<?php if( strpos( typology_get_option( 'front_page_intro' ), 'content' ) !== false ) :  ?>
					<div class="section-content">
						<?php the_content(); ?>
					</div>
				<?php endif; ?>

			<?php endwhile; ?>

		<?php endif; ?>


		<?php if( typology_get_option( 'front_page_posts') ) : ?>

			<?php typology_section_heading( array( 'title' => __typology('latest_stories') ) ); ?>
			<?php $front_page_layout = typology_get_option( 'front_page_posts_layout'); ?>
			<?php $front_page_query = typology_get_front_page_posts(); ?>
			
			<?php if( $front_page_query->have_posts() ): ?>

				<div class="section-content section-content-<?php echo esc_attr( $front_page_layout ); ?>">
					
					<div class="typology-posts">

						<?php while( $front_page_query->have_posts() ) : $front_page_query->the_post(); ?>

								<?php get_template_part('template-parts/layouts/content-'. $front_page_layout ); ?>
							
						<?php endwhile; ?>

					</div>

					<?php
						$temp_query = $wp_query;
						$wp_query = $front_page_query;
						get_template_part('template-parts/pagination/'. typology_get_option( 'front_page_posts_pagination') );
						$wp_query = $temp_query;
					?>

				</div>

			<?php endif; ?>

			<?php wp_reset_postdata(); ?>

		<?php endif; ?>

	</div>


<?php get_footer(); ?>
