
<div class="typology-flex-center">
	<div class="typology-sticky-author typology-sticky-l">
		<?php echo get_avatar( get_the_author_meta('ID'), 50); ?>
		<span class="sticky-author-title">
			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') ) ); ?>"><?php echo __typology( 'by' ) . ' ' . get_the_author_meta('display_name'); ?></a> 
			<span class="sticky-author-date"><?php echo get_the_date(); ?></span>
		</span>
	</div>
	<div class="typology-sticky-c">
		
	</div>

	<div class="typology-sticky-comments typology-sticky-r">
		<?php if ( comments_open() || get_comments_number() ) : ?>
					<?php 
						$icon = '<i class="fa fa-comments-o"></i>';
						comments_popup_link( $icon.__typology( 'no_comments' ), $icon.__typology( 'one_comment' ), $icon.__typology( 'multiple_comments' ) ); 
					?>
		<?php endif; ?>
	</div>

</div>
