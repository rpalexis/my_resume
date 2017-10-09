<div class="section-content">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'typology-post typology-single-post' ); ?>>

        <?php if(!typology_get_option( 'single_cover' ) ) : ?>

            <header class="entry-header">

                <?php the_title( '<h1 class="entry-title entry-title-cover-empty">', '</h1>' ); ?>

                <?php if( $meta = typology_meta_display('single') ) : ?> 
                    <div class="entry-meta"><?php echo typology_get_meta_data( $meta ); ?></div>
                <?php endif; ?>

                <?php if( typology_get_option( 'single_dropcap' ) ) : ?>
                    <div class="post-letter"><?php echo typology_get_letter(); ?></div>
                <?php endif; ?>

            </header>

        <?php endif; ?>
        
        <div class="entry-content clearfix">
            <?php $share_option = typology_get_option('single_share_options'); ?>
            <?php if (  strpos($share_option, 'above') !== false ): ?>
                <?php get_template_part( 'template-parts/single/social' ); ?>
            <?php endif ?>

            <?php if( typology_get_option( 'single_fimg' ) == 'content' && has_post_thumbnail() ) : ?>
                <div class="typology-featured-image">
                    <?php the_post_thumbnail('typology-a'); ?>
                </div>
            <?php endif; ?>

            <?php the_content(); ?>

            <?php wp_link_pages( array('before' => '<div class="typology-link-pages">', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
            
            <?php if( typology_get_option( 'single_tags' ) && has_tag() ) : ?>
                <div class="entry-tags"><?php the_tags( false, ' ', false ); ?></div>
            <?php endif; ?>

        </div>
        
         <?php if (  strpos($share_option, 'below') !== false ): ?>
            <?php get_template_part( 'template-parts/single/social' ); ?>
        <?php endif ?>

    </article>
</div>