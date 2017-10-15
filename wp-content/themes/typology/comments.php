<?php if ( !post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>

	
		<?php 
			ob_start();
			comments_number( __typology( 'no_comments' ), __typology( 'one_comment' ), __typology( 'multiple_comments' ) );
			$comments_title = ob_get_contents();
			ob_end_clean();
		?>
		
		<?php $comment_pagination = get_comment_pages_count() > 1 && get_option( 'page_comments' ) ? paginate_comments_links( array( 'echo' => false, 'prev_text' => '<i class="fa fa-chevron-left"></i>', 'next_text' => '<i class="fa fa-chevron-right"></i>', 'type' => 'list'  ) ) : ''; ?>
		
		<?php typology_section_heading( array( 'title' => $comments_title, 'pre' =>  $comment_pagination ) ); ?>

		<div id="comments" class="section-content typology-comments">

			<?php get_template_part('template-parts/single/comments-form'); ?>
			
			<?php if ( have_comments() ) : ?>

				<ul class="comment-list">
				<?php $args = array(
					'avatar_size' => 80,
					'reply_text' => __typology( 'comment_reply' )
				); ?>
					<?php wp_list_comments( $args ); ?>
				</ul>
			<?php endif; ?>

		</div>

<?php endif; ?>