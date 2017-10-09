(function($) {

    "use strict";

    var typology_app = {

        settings: {
            admin_bar_height: 0,
            cover_height: 'auto'
        },

        pushes: {
            url: [],
            up: 0,
            down: 0
        },

        init: function() {
            this.sidebar();
            this.cover_slider();
            this.reverse_menu();
            this.push_state_for_loading();
            this.load_more();
            this.infinite_scroll();
            this.accordion_widget();
            this.responsive_videos($('.entry-content'));
            this.single_sticky_bottom();
            this.scroll_to_top();
            this.read_later();
            this.share();
            this.scroll_to_comments();
            this.logo_setup();
            this.admin_bar_check();
            this.cover_height();
            this.gallery_slider($('.entry-content'));
            this.gallery_popup($('.entry-content'));
            this.sticky_header();
            this.center_layout_items();
            this.responsive_navigation();
        },

        resize: function() {
            this.admin_bar_check();
            this.responsive_navigation();
            if ($(window).width() > 500) {
                this.cover_height();
            }
        },

        admin_bar_check: function() {

            if ($('#wpadminbar').length && $('#wpadminbar').is(':visible')) {
                this.settings.admin_bar_height = $('#wpadminbar').height();
                $('.typology-header').css('top', this.settings.admin_bar_height);
            }



        },

        cover_height: function() {

            if (!$('.typology-cover-empty').length) {

                var cover_height = $(window).height() - this.settings.admin_bar_height + Math.abs(parseInt($('.typology-section:first').css('top'), 10));
                var cover_content_height = $('.cover-item-container').height();
                var header_height = $('#typology-header').height();
                var cover_auto = true;

                if (cover_height < 450) {
                    cover_height = 450;
                }

                if (cover_content_height > cover_height - header_height) {
                    cover_height = cover_content_height + header_height + 100;
                    cover_auto = false;
                }


                if ($(window).width() <= 1366) {

                    this.settings.cover_height = cover_height;
                    $('.typology-cover-item').css('height', cover_height);
                    $('.typology-cover').css('height', cover_height);

                } else {
                    $('.typology-cover-item').css('height', $('.typology-cover').height());
                    $('.typology-cover').css('height', $('.typology-cover').height());
                    this.settings.cover_height = $('.typology-cover').height();
                }

                if (cover_auto) {
                    if (!$('.typology-cover-slider').length) {
                        $('.typology-cover-item').css('position', 'fixed');
                    } else {
                        $('.typology-slider-wrapper-fixed').css('position', 'fixed');
                    }
                }

            }
        },

        cover_slider: function() {

            $(".typology-cover-slider").owlCarousel({
                rtl: typology_js_settings.rtl_mode ? true : false,
                loop: true,
                autoHeight: true,
                autoWidth: false,
                items: 1,
                margin: 0,
                nav: true,
                center: false,
                fluidSpeed: 100,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
                responsive: {
                    0: {
                        autoHeight: false
                    },
                    1000: {
                        autoHeight: true
                    }
                }
            });

        },

        gallery_slider: function(obj) {
            if (typology_js_settings.use_gallery) {
                obj.find('.gallery-columns-1').addClass('owl-carousel').owlCarousel({
                    rtl: typology_js_settings.rtl_mode ? true : false,
                    loop: true,
                    nav: true,
                    autoWidth: false,
                    center: false,
                    fluidSpeed: 100,
                    margin: 0,
                    items: 1,
                    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
                });
            }
        },

        gallery_popup: function(obj) {
            if (typology_js_settings.use_gallery) {
                obj.find('.gallery').each(function() {
                    $(this).find('.gallery-icon a.typology-popup').magnificPopup({
                        type: 'image',
                        gallery: {
                            enabled: true
                        },

                        image: {
                            titleSrc: function(item) {
                                var $caption = item.el.closest('.gallery-item').find('.gallery-caption');
                                if ($caption != 'undefined') {
                                    return $caption.text();
                                }
                                return '';
                            }
                        }
                    });
                });
            }
        },

        sidebar: function() {

            var class_open = 'typology-sidebar-open typology-lock';

            $('body').on('click', '.typology-action-sidebar', function() {
                $('body').addClass(class_open);
                $('.typology-sidebar').css('top', typology_app.settings.admin_bar_height);
            });

            $('body').on('click', '.typology-sidebar-close, .typology-sidebar-overlay', function() {
                $('body').removeClass(class_open);
            });

            $(document).keyup(function(e) {
                if (e.keyCode == 27 && $('body').hasClass(class_open)) {
                    $('body').removeClass(class_open);
                }
            });

        },

        reverse_menu: function() {

            $('.typology-header .typology-nav li').hover(function(e) {

                if ($(this).find('ul').length) {

                    var rt = ($(window).width() - ($(this).find('ul').offset().left + $(this).find('ul').outerWidth()));

                    if (rt < 0) {
                        $(this).find('ul').addClass('typology-rev');
                    }

                }

            }, function() {
                $(this).find('ul').removeClass('typology-rev');
            });

        },

        logo_setup: function() {

            //Retina logo
            if (window.devicePixelRatio > 1 && typology_js_settings.logo_retina && $('.typology-logo').length) {

                $('.typology-logo').imagesLoaded(function() {

                    $('.typology-logo').each(function() {
                        if ($(this).is(':visible')) {
                            var width = $(this).width();
                            $(this).attr('src', typology_js_settings.logo_retina).css('width', width + 'px');
                        }
                    });
                });

            }
        },

        sticky_header: function() {


            var cover_offset = $('.typology-section').first().offset().top - typology_app.settings.admin_bar_height + Math.abs(parseInt($('.typology-section').first().css('top'))) + 400;
            var section_offset = cover_offset - 400 - Math.abs(parseInt($('.typology-section').first().css('top'))) - ($('.typology-header').height() / 2);
            var opacity_offset = $('.typology-cover-empty').length ? 0 : cover_offset - 400;
            var cover_item_container = $('.cover-item-container');
            var header = $('.typology-header');
            var sticky_on = false;
            var z_index_on = true;

            $(window).scroll(function() {

                if (typology_js_settings.header_sticky) {

                    if ($(window).scrollTop() < cover_offset) {
                        if (sticky_on) {
                            header.animate({
                                top: -70 + typology_app.settings.admin_bar_height
                            }, 200, function() {
                                $(this).removeClass('typology-header-sticky');
                                $(this).css('top', 0 + typology_app.settings.admin_bar_height);
                                $(this).css('z-index', 1000);
                            });
                            sticky_on = false;
                        }

                    } else {
                        if (!sticky_on) {
                            header.css('top', -70 + typology_app.settings.admin_bar_height).addClass('typology-header-sticky').animate({
                                top: 0 + typology_app.settings.admin_bar_height
                            }, 200);
                            header.css('z-index', 9001);
                            sticky_on = true;
                        }
                    }
                }

                if ($(window).scrollTop() < section_offset) {


                    if (!z_index_on) {
                        header.css('z-index', 9001);
                        z_index_on = true;
                    }

                } else {
                    if (z_index_on) {
                        header.css('z-index', 1000);
                        z_index_on = false;
                    }
                }

                if ($(window).scrollTop() < opacity_offset) {
                    var opacity_value = (100 - (100 * $(window).scrollTop() / opacity_offset)) / 100;
                    cover_item_container.css('opacity', opacity_value);

                }


            });

            $.fn.scrollEnd = function(callback, timeout) {
                $(this).scroll(function() {
                    var $this = $(this);
                    if ($this.data('scrollTimeout')) {
                        clearTimeout($this.data('scrollTimeout'));
                    }
                    $this.data('scrollTimeout', setTimeout(callback, timeout));
                });
            };

            $(window).scrollEnd(function() {
                if ($(window).scrollTop() < section_offset) {

                    header.css('z-index', 9001);
                    z_index_on = true;


                } else {
                    if (z_index_on) {
                        header.css('z-index', 1000);
                        z_index_on = false;
                    }
                }
            }, 1000);

        },

        accordion_widget: function() {


            /* Add Accordion menu arrows */

            $(".typology-responsive-menu .typology-nav").each(function() {

                var menu_item = $(this).find('.menu-item-has-children > a');
                menu_item.after('<span class="typology-nav-widget-acordion"><i class="fa fa-angle-down"></i></span>');

            });

            /* Accordion menu click functionality*/

            $('.typology-responsive-menu .typology-nav-widget-acordion').click(function() {
                $(this).next('ul.sub-menu:first, ul.children:first').slideToggle('fast').parent().toggleClass('active');

            });


        },

        single_sticky_bottom: function() {

            if ($('#typology-single-sticky').length) {

                var sticky_meta_offset = $('.typology-single-post').offset().top + 300;
                var sticky_prevnext_offset = $('.typology-single-post').offset().top + $('.typology-single-post').height() - $(window).height();
                var footer_offset = $('#typology-footer').offset().top - $('#typology-footer').height() - $(window).height();

                $(window).scroll(function() {

                    if ($(window).scrollTop() > sticky_meta_offset) {

                        $('.typology-sticky-content.meta').parent().addClass('typology-single-sticky-show typology-show-meta');

                    } else {
                        $('.typology-sticky-content.meta').parent().removeClass('typology-single-sticky-show');
                    }

                    if ($(window).scrollTop() > sticky_prevnext_offset) {

                        $('.typology-sticky-content.meta').parent().removeClass('typology-show-meta');

                        if ($(window).scrollTop() < footer_offset) {
                            $('.typology-sticky-content.prev-next').parent().addClass('typology-show-prev-next');
                        } else {
                            $('.typology-sticky-content.meta').parent().removeClass('typology-single-sticky-show typology-show-meta');
                        }

                    } else {
                        $('.typology-sticky-content.prev-next').parent().removeClass('typology-show-prev-next');
                    }


                });

            }

        },

        scroll_to_top: function() {

            if ($('.typology-sticky-to-top').length) {

                $('body').on('click', '.typology-sticky-to-top', function(e) {
                    e.preventDefault();
                    $('body,html').animate({
                        scrollTop: 0
                    }, 800);
                    return false;
                });
            }

        },

        scroll_to_comments: function() {

            $('body').on('click', '.typology-single-post .meta-comments a, .typology-cover-single .meta-comments a, .typology-sticky-comments a', function(e) {

                e.preventDefault();
                var hash = this.hash;
                var target = $(hash);
                //var offset = typology_js_settings.header_sticky ? 100 : 0;
                var offset = 100;

                $('html, body').stop().animate({
                    'scrollTop': target.offset().top - offset
                }, 800, 'swing', function() {
                    window.location.hash = hash;
                });

            });

        },

        share: function() {

            $('body').on('click', '.typology-share-item', function(e) {
                e.preventDefault();
                typology_app.share_popup($(this).attr('data-url'));
            });
        },

        read_later: function() {

            $("body").on('click', '.typology-rl', function(e) {
                e.preventDefault();

                if ($(this).hasClass('pocket')) {
                    typology_app.share_popup($(this).attr('data-url'));
                }

            });

        },

        responsive_videos: function(obj) {
            obj.fitVids({
                customSelector: "iframe[src^='https://www.dailymotion.com'], iframe[src^='https://player.twitch.tv'], iframe[src^='https://vine.co'], iframe[src^='https://videopress.com'], iframe[src^='https://www.facebook.com'],iframe[src^='//content.jwplatform.com']"
            });
        },

        center_layout_items: function() {

            if ($('.section-content-c .typology-posts .typology-layout-c').length % 2 != 0) {
                $('.section-content-c').addClass('layout-even').removeClass('layout-odd');
            } else {
                $('.section-content-c').addClass('layout-odd').removeClass('layout-even');
            }

        },

        push_state_for_loading: function() {

            /* Handling URL on ajax call for load more and infinite scroll case */
            if ($('.typology-pagination .load-more a').length || $('.typology-pagination .infinite-scroll').length) {

                var push_obj = {
                    prev: window.location.href,
                    next: '',
                    offset: $(window).scrollTop(),
                    prev_title: window.document.title,
                    next_title: window.document.title
                };

                typology_app.pushes.url.push(push_obj);
                window.history.pushState(push_obj, '', window.location.href);

                var last_up, last_down = 0;

                $(window).scroll(function() {
                    if (typology_app.pushes.url[typology_app.pushes.up].offset != last_up && $(window).scrollTop() < typology_app.pushes.url[typology_app.pushes.up].offset) {

                        last_up = typology_app.pushes.url[typology_app.pushes.up].offset;
                        last_down = 0;
                        window.document.title = typology_app.pushes.url[typology_app.pushes.up].prev_title;
                        window.history.replaceState(typology_app.pushes.url, '', typology_app.pushes.url[typology_app.pushes.up].prev); //1

                        typology_app.pushes.down = typology_app.pushes.up;
                        if (typology_app.pushes.up != 0) {
                            typology_app.pushes.up--;
                        }
                    }
                    if (typology_app.pushes.url[typology_app.pushes.down].offset != last_down && $(window).scrollTop() > typology_app.pushes.url[typology_app.pushes.down].offset) {

                        last_down = typology_app.pushes.url[typology_app.pushes.down].offset;
                        last_up = 0;

                        window.document.title = typology_app.pushes.url[typology_app.pushes.down].next_title;
                        window.history.replaceState(typology_app.pushes.url, '', typology_app.pushes.url[typology_app.pushes.down].next);

                        typology_app.pushes.up = typology_app.pushes.down;
                        if (typology_app.pushes.down < typology_app.pushes.url.length - 1) {
                            typology_app.pushes.down++;
                        }

                    }
                });

            }
        },

        load_more: function() {

            /* Load more button handler */

            var typology_load_more_count = 0;

            $("body").on('click', '.typology-pagination .load-more a', function(e) {
                e.preventDefault();
                var start_url = window.location.href;
                var prev_title = window.document.title;
                var link = $(this);
                var page_url = link.attr("href");

                link.parent().addClass('load-more-active');

                $("<div>").load(page_url, function() {
                    var n = typology_load_more_count.toString();
                    var container = $('.typology-posts').last();
                    var this_div = $(this);
                    var new_posts = this_div.find('.typology-posts').last().children().addClass('typology-new-' + n);

                    new_posts.imagesLoaded(function() {

                        new_posts.hide().appendTo(container).fadeIn(400);
                        typology_app.center_layout_items();

                        if (this_div.find('.typology-pagination').length) {
                            $('.typology-pagination').html(this_div.find('.typology-pagination').html());
                        } else {
                            $('.typology-pagination').fadeOut('fast').remove();
                        }

                        if (page_url != window.location) {
                            typology_app.pushes.up++;
                            typology_app.pushes.down++;
                            var next_title = this_div.find('title').text();

                            var push_obj = {
                                prev: start_url,
                                next: page_url,
                                offset: $(window).scrollTop(),
                                prev_title: prev_title,
                                next_title: next_title
                            }

                            typology_app.pushes.url.push(push_obj);
                            window.document.title = next_title;
                            window.history.pushState(push_obj, '', page_url);
                        }

                        typology_load_more_count++;

                        return false;
                    });

                });

            });
        },

        share_popup: function(data) {
            window.open(data, "Share", 'height=500,width=760,top=' + ($(window).height() / 2 - 250) + ', left=' + ($(window).width() / 2 - 380) + 'resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0');
        },


        infinite_scroll: function() {

            /* Infinite scroll handler */

            if ($('.typology-pagination .infinite-scroll').length) {

                var typology_infinite_allow = true;
                var typology_load_more_count = 0;

                $(window).scroll(function() {

                    if (typology_infinite_allow && ($(this).scrollTop() > ($('.typology-pagination').offset().top - $(this).height() - 200))) {

                        typology_infinite_allow = false;

                        var start_url = window.location.href;
                        var prev_title = window.document.title;
                        var link = $('.typology-pagination .infinite-scroll a');
                        var page_url = link.attr("href");

                        link.parent().addClass('load-more-active');

                        if (page_url !== undefined) {

                            $("<div>").load(page_url, function() {
                                var n = typology_load_more_count.toString();
                                var container = $('.typology-posts').last();
                                var this_div = $(this);
                                var new_posts = this_div.find('.typology-posts').last().children().addClass('typology-new-' + n);

                                new_posts.imagesLoaded(function() {

                                    new_posts.hide().appendTo(container).fadeIn(400);
                                    typology_app.center_layout_items();

                                    if (this_div.find('.typology-pagination').length) {
                                        $('.typology-pagination').html(this_div.find('.typology-pagination').html());
                                        typology_infinite_allow = true;
                                    } else {
                                        $('.typology-pagination').fadeOut('fast').remove();
                                    }

                                    if (page_url != window.location) {
                                        typology_app.pushes.up++;
                                        typology_app.pushes.down++;
                                        var next_title = this_div.find('title').text();

                                        var push_obj = {
                                            prev: start_url,
                                            next: page_url,
                                            offset: $(window).scrollTop(),
                                            prev_title: prev_title,
                                            next_title: next_title
                                        }

                                        typology_app.pushes.url.push(push_obj);
                                        window.document.title = next_title;
                                        window.history.pushState(push_obj, '', page_url);
                                    }

                                    typology_load_more_count++;

                                    return false;
                                });

                            });
                        }

                    }
                });
            }
        },

        responsive_navigation: function(){

            if( $('#typology-header .typology-main-navigation' ).length && $(window).width() > 480){

                var header_width = $('#typology-header .container:first').width();
                var logo_width =  $('#typology-header .typology-site-branding' ).length ? $('#typology-header .typology-site-branding').width() : 0;
                var nav_width = $('#typology-header .typology-main-navigation').width();
                
                if( logo_width + nav_width > header_width - 50){
                    $('#typology-header .typology-main-navigation').css('opacity', 0);
                    $('.typology-responsive-menu').show();
                } else {
                    $('#typology-header .typology-main-navigation').css('opacity', 1);
                    $('.typology-responsive-menu').hide();
                }

            }
            
        }

    };


    $(document).ready(function() {
        typology_app.init();
    });

    $(window).resize(function() {
        typology_app.resize();
    });


})(jQuery);