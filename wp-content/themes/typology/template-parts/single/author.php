<?php if( typology_get_option( 'single_author' ) ): ?>

	<?php typology_section_heading( array( 'title' => __typology('about_author') ) ); ?>
		
	<div class="section-content typology-author">
			
		<div class="container">

			<div class="col-lg-2">
				<?php echo get_avatar( get_the_author_meta('ID'), 100); ?>
			</div>

			<div class="col-lg-10">

				<?php echo '<h5 class="typology-author-box-title">'.get_the_author_meta('display_name').'</h5>'; ?>

				<div class="typology-author-desc">
					<?php echo wpautop( get_the_author_meta('description') ); ?>
				</div>

				<div class="typology-author-links">
					<?php echo typology_get_author_links( get_the_author_meta('ID') ); ?>
				</div>

			</div>

		</div>

	</div>

<?php endif; ?>