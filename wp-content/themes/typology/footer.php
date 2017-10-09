
			<footer id="typology-footer" class="typology-footer">

				<div class="container">
					<?php if( is_active_sidebar( 'typology_footer_sidebar_left' ) ) : ?>
						<div class="col-lg-4"><?php dynamic_sidebar( 'typology_footer_sidebar_left' );?></div>
					<?php endif; ?>

					<?php if( is_active_sidebar( 'typology_footer_sidebar_center' ) ) : ?>
						<div class="col-lg-4"><?php dynamic_sidebar( 'typology_footer_sidebar_center' );?></div>
					<?php endif; ?>

					<?php if( is_active_sidebar( 'typology_footer_sidebar_right' ) ) : ?>
						<div class="col-lg-4"><?php dynamic_sidebar( 'typology_footer_sidebar_right' );?></div>
					<?php endif; ?>
				</div>

			</footer>

		</div>

		<?php get_sidebar(); ?>
		
		<?php wp_footer(); ?>

	</body>
</html>