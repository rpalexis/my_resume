<?php 
	
	/* Font styles */
	
	$main_font = typology_get_font_option( 'main_font' );
	$h_font = typology_get_font_option( 'h_font' );
	$nav_font = typology_get_font_option( 'nav_font' );
	$font_size_p = absint( typology_get_option( 'font_size_p' ) )/10; 
	$font_size_h1 = absint( typology_get_option( 'font_size_h1' ) )/10;
	$font_size_h2 = absint( typology_get_option( 'font_size_h2' ) )/10;
	$font_size_h3 = absint( typology_get_option( 'font_size_h3' ) )/10;
	$font_size_h4 = absint( typology_get_option( 'font_size_h4' ) )/10;
	$font_size_h5 = absint( typology_get_option( 'font_size_h5' ) )/10;
	$font_size_h6 = absint( typology_get_option( 'font_size_h6' ) )/10;
	$font_size_cover = absint( typology_get_option( 'font_size_cover' ) )/10;
	$font_size_small = absint( typology_get_option( 'font_size_small' ) )/10;
	$font_size_nav = absint( typology_get_option( 'font_size_nav' ) )/10;
	$font_size_meta = absint( typology_get_option( 'font_size_meta' ) )/10;
	$font_size_cover_dropcap = absint( typology_get_option( 'font_size_cover_dropcap' ) )/10;
	$font_size_dropcap = absint( typology_get_option( 'font_size_dropcap' ) )/10;
	

	/* Colors & stylings */

	$color_content_bg = esc_attr( typology_get_option('color_content_bg') );
	$color_body_bg = typology_get_option('style') == 'material' ? esc_attr( typology_get_option('color_body_bg') ) : $color_content_bg;
	
	$header_height = absint( typology_get_option('header_height') );
	$color_cover_bg = esc_attr( typology_get_option('color_header_bg') );
	$color_cover_txt = esc_attr( typology_get_option('color_header_txt') );
	$cover_bg_opacity = esc_attr( typology_get_option('cover_bg_opacity') );

	$color_content_h = esc_attr( typology_get_option('color_content_h') );
	$color_content_txt = esc_attr( typology_get_option('color_content_txt') );
	$color_content_acc = esc_attr( typology_get_option('color_content_acc') );
	$color_content_meta = esc_attr( typology_get_option('color_content_meta') );

	$color_footer_bg = esc_attr( typology_get_option('color_footer_bg') );
	$color_footer_txt = esc_attr( typology_get_option('color_footer_txt') );
	$color_footer_acc= esc_attr( typology_get_option('color_footer_acc') );


?>

/* Typography styles */

body,
blockquote:before, q:before{
  font-family: <?php echo $main_font['font-family']; ?>;
  font-weight: <?php echo $main_font['font-weight']; ?>;
  <?php if ( isset( $main_font['font-style'] ) && !empty( $main_font['font-style'] ) ):?>
    font-style: <?php echo $main_font['font-style']; ?>;
  <?php endif; ?>	
}

body,
.typology-action-button .sub-menu{
	color:<?php echo $color_content_txt; ?>;
}

body{
	background:<?php echo $color_body_bg; ?>;
	font-size: <?php echo $font_size_p; ?>em;
}
.typology-fake-bg{
	background:<?php echo $color_body_bg; ?>;
}
.typology-sidebar,
.typology-section{
	background:<?php echo $color_content_bg; ?>;
}


h1, h2, h3, h4, h5, h6,
.h1, .h2, .h3, .h4, .h5, .h6,
.submit,
.mks_read_more a,
input[type="submit"],
a.mks_button,
.cover-letter,
.post-letter,
.woocommerce nav.woocommerce-pagination ul li span,
.woocommerce nav.woocommerce-pagination ul li a,
.woocommerce div.product .woocommerce-tabs ul.tabs li,
.typology-pagination a,
.typology-pagination span,
.comment-author .fn,
.post-date-month,
.typology-button-social,
.mks_autor_link_wrap a,
.entry-pre-title,
.typology-button,
button{
  font-family: <?php echo $h_font['font-family']; ?>;
  font-weight: <?php echo $h_font['font-weight']; ?>;
  <?php if ( isset( $h_font['font-style'] ) && !empty( $h_font['font-style'] ) ):?>
  font-style: <?php echo $h_font['font-style']; ?>;
  <?php endif; ?>
}

.typology-header .typology-nav{
  font-family: <?php echo $nav_font['font-family']; ?>;
  font-weight: <?php echo $nav_font['font-weight']; ?>;
  <?php if ( isset( $nav_font['font-style'] ) && !empty( $nav_font['font-style'] ) ):?>
  font-style: <?php echo $nav_font['font-style']; ?>;
  <?php endif; ?>
}
.typology-cover .entry-title,
.typology-cover h1 { 
	font-size: <?php echo $font_size_cover; ?>rem;
}

h1, .h1 {
  font-size: <?php echo $font_size_h1; ?>rem;
}

h2, .h2 {
  font-size: <?php echo $font_size_h2; ?>rem;
}

h3, .h3 {
  font-size: <?php echo $font_size_h3; ?>rem;
}

h4, .h4 {
  font-size: <?php echo $font_size_h4; ?>rem;
}

h5, .h5,
.typology-layout-c.post-image-on .entry-title {
  font-size: <?php echo $font_size_h5; ?>rem;
}

h6, .h6 {
  font-size: <?php echo $font_size_h6; ?>rem;
}
.widget{
	font-size: <?php echo $font_size_small; ?>rem;
}
.typology-header .typology-nav a{
	font-size: <?php echo $font_size_nav; ?>rem;
}

.typology-layout-b .post-date-hidden,
.meta-item{
	font-size: <?php echo $font_size_meta; ?>rem;
}

.post-letter {
	font-size: <?php echo $font_size_dropcap; ?>rem;
}

.cover-letter {
	font-size: <?php echo $font_size_cover_dropcap; ?>rem;
}


h1, h2, h3, h4, h5, h6,
.h1, .h2, .h3, .h4, .h5, .h6,
h1 a,
h2 a,
h3 a,
h4 a,
h5 a,
h6 a,
.post-date-month{
	color:<?php echo $color_content_h; ?>;
}
.typology-single-sticky a{
	color:<?php echo $color_content_txt; ?>;
}
.entry-title a:hover,
.typology-single-sticky a:hover{
		color:<?php echo $color_content_acc; ?>;
}
.bypostauthor .comment-author:before,
#cancel-comment-reply-link:after{
	background:<?php echo $color_content_acc; ?>;		
}

/* General styles */
a,
.widget .textwidget a,
.typology-layout-b .post-date-hidden{
	color: <?php echo $color_content_acc; ?>;
}


/* Header styles */

.typology-header{
	height:<?php echo $header_height; ?>px;
}

<?php if($header_height < 70): ?>
.typology-header.typology-header-sticky{
	height:<?php echo $header_height; ?>px;
}
<?php endif; ?>

.typology-header-sticky-on .typology-header{
	background:<?php echo $color_content_acc; ?>;
}

.site-title a,
.typology-site-description{
	color: <?php echo $color_cover_txt; ?>;	
}

.typology-header .typology-nav,
.typology-header .typology-nav > li > a{
	color: <?php echo $color_cover_txt; ?>;
}

.typology-header .typology-nav .sub-menu a{
 	color:<?php echo $color_content_txt; ?>;
}
.typology-header .typology-nav .sub-menu a:hover{
	color: <?php echo $color_content_acc; ?>;
}
.typology-action-button .sub-menu ul a:before{
	background: <?php echo $color_content_acc; ?>;	
}
.sub-menu .current-menu-item a{
	color:<?php echo $color_content_acc; ?>;
}
.dot,
.typology-header .typology-nav .sub-menu{
	background:<?php echo $color_content_bg; ?>;
}
.typology-header .typology-main-navigation .sub-menu .current-menu-ancestor > a,
.typology-header .typology-main-navigation .sub-menu .current-menu-item > a{
	color: <?php echo $color_content_acc; ?>;
}

.typology-header-wide .slot-l{
	left: <?php echo $header_height/2-20; ?>px;
}
.typology-header-wide .slot-r{
	right: <?php echo $header_height/2-35; ?>px;
}

/* Post styles */
.meta-item,
.meta-item span,
.meta-item a,
.comment-metadata a{
	color: <?php echo $color_content_meta; ?>;
}
.comment-meta .url,
.meta-item a:hover{
	color:<?php echo $color_content_h; ?>;
}
.typology-post:after,
.section-title:after,
.typology-pagination:before{
	background:<?php echo typology_hex2rgba($color_content_h, 0.2); ?>;
}


.typology-layout-b .post-date-day,
.typology-outline-nav li a:hover,
.style-timeline .post-date-day{
	color:<?php echo $color_content_acc; ?>;
}
.typology-layout-b .post-date:after,
blockquote:before,
q:before{
	background:<?php echo $color_content_acc; ?>;	
}
.typology-sticky-c,
.typology-sticky-to-top span,
.sticky-author-date{
	color: <?php echo $color_content_meta; ?>;
}

.typology-outline-nav li a{
	color: <?php echo $color_content_txt; ?>;
}

.typology-post.typology-layout-b:before{
	background:<?php echo typology_hex2rgba($color_content_txt, 0.1); ?>;
}

/* Buttons styles */
.submit,
.mks_read_more a,
input[type="submit"],
a.mks_button,
.typology-button,
.submit,
.typology-button-social,
.widget .mks_autor_link_wrap a,
.widget .mks_read_more a,
button{
	color:<?php echo $color_content_bg; ?>;
	background: <?php echo $color_content_acc; ?>;
	border:1px solid <?php echo $color_content_acc; ?>;
}
.button-invert{
	color:<?php echo $color_content_acc; ?>;
	background:transparent;
}
.widget .mks_autor_link_wrap a:hover,
.widget .mks_read_more a:hover{
	color:<?php echo $color_content_bg; ?>;
}


/* Cover styles */
.typology-cover{
	min-height: <?php echo $header_height + 130; ?>px;
}
.typology-cover-empty{
	height:<?php echo $header_height * 1.9; ?>px;
	min-height:<?php echo $header_height * 1.9; ?>px;
}
.typology-fake-bg .typology-section:first-child {
	top: -<?php echo ($header_height * 1.9) - $header_height; ?>px;
}
.typology-flat .typology-cover-empty{
	height:<?php echo $header_height; ?>px;
}
.typology-flat .typology-cover{
	min-height:<?php echo $header_height; ?>px;
}

.typology-cover-empty,
.typology-cover-item,
.typology-header-sticky{
	background:<?php echo $color_cover_bg; ?>;	
}
.typology-cover-overlay:after{
	background: <?php echo typology_hex2rgba($color_cover_bg, $cover_bg_opacity); ?>;
}
.typology-sidebar-header{
	background:<?php echo $color_content_acc; ?>;	
}

.typology-cover,
.typology-cover .entry-title,
.typology-cover .entry-title a,
.typology-cover .meta-item,
.typology-cover .meta-item span,
.typology-cover .meta-item a,
.typology-cover h1,
.typology-cover h2,
.typology-cover h3{
	color: <?php echo $color_cover_txt; ?>;
}


.typology-cover .typology-button{
	color: <?php echo $color_cover_bg; ?>;
	background:<?php echo $color_cover_txt; ?>;
	border:1px solid <?php echo $color_cover_txt; ?>;
}
.typology-cover .button-invert{
	color: <?php echo $color_cover_txt; ?>;
	background: transparent;
}
.typology-cover-slider .owl-dots .owl-dot span{
	background:<?php echo $color_cover_txt; ?>;
}


/* Widgets */
.typology-outline-nav li:before,
.widget ul li:before{
	background:<?php echo $color_content_acc; ?>;
}
.widget a{
	color:<?php echo $color_content_txt; ?>;
}
.widget a:hover,
.widget_calendar table tbody td a,
.entry-tags a:hover{
	color:<?php echo $color_content_acc; ?>;
}
.widget_calendar table tbody td a:hover,
.widget table td,
.entry-tags a{
	color:<?php echo $color_content_txt; ?>;
}
.widget table,
.widget table td,
.widget_calendar table thead th,
table,
td, th{
	border-color: <?php echo typology_hex2rgba($color_content_txt, 0.3); ?>;
}
.widget ul li,
.widget .recentcomments{
	color:<?php echo $color_content_txt; ?>;	
}
.widget .post-date{
	color:<?php echo $color_content_meta; ?>;
}
#today{
	background:<?php echo typology_hex2rgba($color_content_txt, 0.1); ?>;
}

/* Pagination styles */

.typology-pagination .current, .typology-pagination .infinite-scroll a, 
.typology-pagination .load-more a, 
.typology-pagination .nav-links .next, 
.typology-pagination .nav-links .prev, 
.typology-pagination .next a, 
.typology-pagination .prev a{
	color: <?php echo $color_content_bg; ?>;
	background:<?php echo $color_content_h; ?>;
}
.typology-pagination a, .typology-pagination span{
	color: <?php echo $color_content_h; ?>;
	border:1px solid <?php echo $color_content_h; ?>;
}

/* Footer styles */
.typology-footer{
	background:<?php echo $color_footer_bg; ?>;
	color:<?php echo $color_footer_txt; ?>;
}
.typology-footer h1,
.typology-footer h2,
.typology-footer h3,
.typology-footer h4,
.typology-footer h5,
.typology-footer h6,
.typology-footer .post-date-month{
	color:<?php echo $color_footer_txt; ?>;
}

.typology-count{
	background: <?php echo $color_content_acc; ?>;	
}

.typology-footer a, .typology-footer .widget .textwidget a{
	color: <?php echo $color_footer_acc; ?>;	
}


/* Border styles */

input[type="text"], input[type="email"], input[type="url"], input[type="tel"], input[type="number"], input[type="date"], input[type="password"], textarea, select{
	border-color:<?php echo typology_hex2rgba($color_content_txt, 0.2); ?>;
}

blockquote:after, blockquote:before, q:after, q:before{
    -webkit-box-shadow: 0 0 0 10px <?php echo $color_content_bg; ?>;	
    box-shadow: 0 0 0 10px <?php echo $color_content_bg; ?>;		
}

<?php if( $color_footer_bg !=  $color_body_bg ): ?>
.typology-footer .container > .col-lg-4{
	margin-top:8rem;
}
<?php endif; ?>

body.wp-editor{
	background:<?php echo $color_content_bg; ?>;
}

<?php

/* Apply uppercase options */

$uppercase = typology_get_option( 'uppercase' );
if ( !empty( $uppercase ) ) {
  foreach ( $uppercase as $text_class => $val ) {
    if ( $val ){
      echo $text_class.'{text-transform: uppercase;}';
    } else {
      echo $text_class.'{text-transform: none;}';
    }
  }
}

?>

<?php if(!array_key_exists('.typology-button', $uppercase) || $uppercase['.typology-button'] ): ?>
	
.submit,
.mks_read_more a,
input[type="submit"],
a.mks_button,
.typology-button,
.widget .mks_autor_link_wrap a,
.widget .mks_read_more a,
button,
.typology-button-social{
	text-transform: uppercase;
}

<?php endif; ?>

/* WooCommerce styles */
<?php if ( typology_is_woocommerce_active() ): ?>
.woocommerce ul.products li.product .button,
.woocommerce ul.products li.product .added_to_cart,
body.woocommerce .button,
body.woocommerce-page .button,
.woocommerce .widget_shopping_cart_content .buttons .button,
.woocommerce div.product div.summary .single_add_to_cart_button,
.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce-page #payment #place_order,
.woocommerce #review_form #respond .form-submit input,
.price, .amount,
.woocommerce .comment-reply-title{
	font-family: <?php echo $h_font['font-family']; ?>;
	font-weight: <?php echo $h_font['font-weight']; ?>;
	<?php if ( isset( $h_font['font-style'] ) && !empty( $h_font['font-style'] ) ):?>
	font-style: <?php echo $h_font['font-style']; ?>;
	<?php endif; ?> 	
}
.woocommerce ul.products li.product .button,
.woocommerce ul.products li.product .added_to_cart,
body.woocommerce .button,
body.woocommerce-page .button,
.woocommerce .widget_shopping_cart_content .buttons .button,
.woocommerce div.product div.summary .single_add_to_cart_button,
.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
.woocommerce-page #payment #place_order,
.woocommerce #review_form #respond .form-submit input{
	color:<?php echo $color_content_bg; ?>;
	background: <?php echo $color_content_acc; ?>;
	border:1px solid <?php echo $color_content_acc; ?>; 
}
.woocommerce div.product .woocommerce-tabs ul.tabs li.active a{
  border-bottom: 3px solid <?php echo $color_content_acc; ?>;
}
.product-categories li,
.product-categories .children li {
  color:<?php echo $color_content_meta; ?>;
}
.product-categories .children li {
  border-top: 1px solid <?php echo typology_hex2rgba( $color_content_txt, 0.1); ?>; 
}
.product-categories li{
   border-bottom: 1px solid <?php echo typology_hex2rgba( $color_content_txt, 0.1); ?>; 
}	

.woocommerce nav.woocommerce-pagination ul li a,
.woocommerce nav.woocommerce-pagination ul li span{
	color: <?php echo $color_content_bg; ?>;
	background:<?php echo $color_content_h; ?>;
}

.woocommerce nav.woocommerce-pagination ul li a,
.woocommerce nav.woocommerce-pagination ul li span{
	color: <?php echo $color_content_h; ?>;
	border:1px solid <?php echo $color_content_h; ?>;
	background: transparent;
}
.woocommerce nav.woocommerce-pagination ul li a:hover{
	color: <?php echo $color_content_h; ?>;
}
.woocommerce nav.woocommerce-pagination ul li span.current{
	color: <?php echo $color_content_bg; ?>;
	background:<?php echo $color_content_h; ?>;	
}
.woocommerce .comment-reply-title:after{
	background:<?php echo typology_hex2rgba($color_content_h, 0.2); ?>;	
}


<?php endif; ?>