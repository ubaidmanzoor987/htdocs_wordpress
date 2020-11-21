<?php
include_once get_template_directory() . '/theme-includes.php';

if ( ! function_exists( 'bazaar_qodef_styles' ) ) {
	/**
	 * Function that includes theme's core styles
	 */
	function bazaar_qodef_styles() {

		//include theme's core styles
		wp_enqueue_style( 'bazaar_qodef_default_style', QODE_ROOT . '/style.css' );
		wp_enqueue_style( 'bazaar_qodef_modules', QODE_ASSETS_ROOT . '/css/modules.min.css' );

		bazaar_qodef_icon_collections()->enqueueStyles();

		wp_enqueue_style( 'wp-mediaelement' );

		do_action( 'bazaar_qodef_enqueue_third_party_styles' );

		//is woocommerce installed?
		if ( bazaar_qodef_is_woocommerce_installed() && bazaar_qodef_load_woo_assets() ) {
			//include theme's woocommerce styles
			wp_enqueue_style( 'bazaar_qodef_woo', QODE_ASSETS_ROOT . '/css/woocommerce.min.css' );
		}

		//define files after which style dynamic needs to be included. It should be included last so it can override other files
		$style_dynamic_deps_array = array();
		if ( bazaar_qodef_load_woo_assets() ) {
			$style_dynamic_deps_array = array( 'bazaar_qodef_woo', 'bazaar_qodef_woo_responsive' );
		}

		if ( file_exists( QODE_ROOT_DIR . '/assets/css/style_dynamic.css' ) && bazaar_qodef_is_css_folder_writable() && ! is_multisite() ) {
			wp_enqueue_style( 'bazaar_qodef_style_dynamic', QODE_ASSETS_ROOT . '/css/style_dynamic.css', $style_dynamic_deps_array, filemtime( QODE_ROOT_DIR . '/assets/css/style_dynamic.css' ) ); //it must be included after woocommerce styles so it can override it
		} else if ( file_exists( QODE_ROOT_DIR . '/assets/css/style_dynamic_ms_id_' . bazaar_qodef_get_multisite_blog_id() . '.css' ) && bazaar_qodef_is_css_folder_writable() && is_multisite() ) {
			wp_enqueue_style( 'bazaar_qodef_style_dynamic', QODE_ASSETS_ROOT . '/css/style_dynamic_ms_id_' . bazaar_qodef_get_multisite_blog_id() . '.css', $style_dynamic_deps_array, filemtime( QODE_ROOT_DIR . '/assets/css/style_dynamic_ms_id_' . bazaar_qodef_get_multisite_blog_id() . '.css' ) ); //it must be included after woocommerce styles so it can override it
		}

		//is responsive option turned on?
		if ( bazaar_qodef_is_responsive_on() ) {
			wp_enqueue_style( 'bazaar_qodef_modules_responsive', QODE_ASSETS_ROOT . '/css/modules-responsive.min.css' );

			//is woocommerce installed?
			if ( bazaar_qodef_is_woocommerce_installed() && bazaar_qodef_load_woo_assets() ) {
				//include theme's woocommerce responsive styles
				wp_enqueue_style( 'bazaar_qodef_woo_responsive', QODE_ASSETS_ROOT . '/css/woocommerce-responsive.min.css' );
			}

			//include proper styles
			if ( file_exists( QODE_ROOT_DIR . '/assets/css/style_dynamic_responsive.css' ) && bazaar_qodef_is_css_folder_writable() && ! is_multisite() ) {
				wp_enqueue_style( 'bazaar_qodef_style_dynamic_responsive', QODE_ASSETS_ROOT . '/css/style_dynamic_responsive.css', array(), filemtime( QODE_ROOT_DIR . '/assets/css/style_dynamic_responsive.css' ) );
			} else if ( file_exists( QODE_ROOT_DIR . '/assets/css/style_dynamic_responsive_ms_id_' . bazaar_qodef_get_multisite_blog_id() . '.css' ) && bazaar_qodef_is_css_folder_writable() && is_multisite() ) {
				wp_enqueue_style( 'bazaar_qodef_style_dynamic_responsive', QODE_ASSETS_ROOT . '/css/style_dynamic_responsive_ms_id_' . bazaar_qodef_get_multisite_blog_id() . '.css', array(), filemtime( QODE_ROOT_DIR . '/assets/css/style_dynamic_responsive_ms_id_' . bazaar_qodef_get_multisite_blog_id() . '.css' ) );
			}
		}
	}

	add_action( 'wp_enqueue_scripts', 'bazaar_qodef_styles' );
}

if ( ! function_exists( 'bazaar_qodef_google_fonts_styles' ) ) {
	/**
	 * Function that includes google fonts defined anywhere in the theme
	 */
	function bazaar_qodef_google_fonts_styles() {
		$font_simple_field_array = bazaar_qodef_options()->getOptionsByType( 'fontsimple' );
		if ( ! ( is_array( $font_simple_field_array ) && count( $font_simple_field_array ) > 0 ) ) {
			$font_simple_field_array = array();
		}

		$font_field_array = bazaar_qodef_options()->getOptionsByType( 'font' );
		if ( ! ( is_array( $font_field_array ) && count( $font_field_array ) > 0 ) ) {
			$font_field_array = array();
		}

		$available_font_options = array_merge( $font_simple_field_array, $font_field_array );

		$google_font_weight_array = bazaar_qodef_options()->getOptionValue( 'google_font_weight' );
		if ( ! empty( $google_font_weight_array ) ) {
			$google_font_weight_array = array_slice( bazaar_qodef_options()->getOptionValue( 'google_font_weight' ), 1 );
		}

		$font_weight_str = '300,400,500,600,700';
		if ( ! empty( $google_font_weight_array ) && $google_font_weight_array !== '' ) {
			$font_weight_str = implode( ',', $google_font_weight_array );
		}

		$google_font_subset_array = bazaar_qodef_options()->getOptionValue( 'google_font_subset' );
		if ( ! empty( $google_font_subset_array ) ) {
			$google_font_subset_array = array_slice( bazaar_qodef_options()->getOptionValue( 'google_font_subset' ), 1 );
		}

		$font_subset_str = 'latin-ext';
		if ( ! empty( $google_font_subset_array ) && $google_font_subset_array !== '' ) {
			$font_subset_str = implode( ',', $google_font_subset_array );
		}

		//default fonts
		$default_font_family = array(
			'Poppins'
		);

		$modified_default_font_family = array();
		foreach ( $default_font_family as $default_font ) {
			$modified_default_font_family[] = $default_font . ':' . $font_weight_str;
		}

		$default_font_string = implode( '|', $modified_default_font_family );

		//define available font options array
		$fonts_array = array();
		foreach ( $available_font_options as $font_option ) {
			//is font set and not set to default and not empty?
			$font_option_value = bazaar_qodef_options()->getOptionValue( $font_option );

			if ( bazaar_qodef_is_font_option_valid( $font_option_value ) && ! bazaar_qodef_is_native_font( $font_option_value ) ) {
				$font_option_string = $font_option_value . ':' . $font_weight_str;

				if ( ! in_array( str_replace( '+', ' ', $font_option_value ), $default_font_family ) && ! in_array( $font_option_string, $fonts_array ) ) {
					$fonts_array[] = $font_option_string;
				}
			}
		}

		$fonts_array         = array_diff( $fonts_array, array( '-1:' . $font_weight_str ) );
		$google_fonts_string = implode( '|', $fonts_array );

		$protocol = is_ssl() ? 'https:' : 'http:';

		//is google font option checked anywhere in theme?
		if ( count( $fonts_array ) > 0 ) {

			//include all checked fonts
			$fonts_full_list      = $default_font_string . '|' . str_replace( '+', ' ', $google_fonts_string );
			$fonts_full_list_args = array(
				'family' => urlencode( $fonts_full_list ),
				'subset' => urlencode( $font_subset_str ),
			);

			$bazaar_qodef_fonts = add_query_arg( $fonts_full_list_args, $protocol . '//fonts.googleapis.com/css' );
			wp_enqueue_style( 'bazaar_qodef_google_fonts', esc_url_raw( $bazaar_qodef_fonts ), array(), '1.0.0' );

		} else {
			//include default google font that theme is using
			$default_fonts_args = array(
				'family' => urlencode( $default_font_string ),
				'subset' => urlencode( $font_subset_str ),
			);
			$bazaar_qodef_fonts = add_query_arg( $default_fonts_args, $protocol . '//fonts.googleapis.com/css' );
			wp_enqueue_style( 'bazaar_qodef_google_fonts', esc_url_raw( $bazaar_qodef_fonts ), array(), '1.0.0' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'bazaar_qodef_google_fonts_styles' );
}

if ( ! function_exists( 'bazaar_qodef_scripts' ) ) {
	/**
	 * Function that includes all necessary scripts
	 */
	function bazaar_qodef_scripts() {
		global $wp_scripts;

		//init theme core scripts
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'wp-mediaelement' );

		// 3rd party JavaScripts that we used in our theme
		wp_enqueue_script( 'appear', QODE_ASSETS_ROOT . '/js/modules/plugins/jquery.appear.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'modernizr', QODE_ASSETS_ROOT . '/js/modules/plugins/modernizr.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'hoverIntent', QODE_ASSETS_ROOT . '/js/modules/plugins/jquery.hoverIntent.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'jquery-plugin', QODE_ASSETS_ROOT . '/js/modules/plugins/jquery.plugin.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'owl-carousel', QODE_ASSETS_ROOT . '/js/modules/plugins/owl.carousel.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'waypoints', QODE_ASSETS_ROOT . '/js/modules/plugins/jquery.waypoints.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'chart', QODE_ASSETS_ROOT . '/js/modules/plugins/Chart.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'fluidvids', QODE_ASSETS_ROOT . '/js/modules/plugins/fluidvids.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'prettyphoto', QODE_ASSETS_ROOT . '/js/modules/plugins/jquery.prettyPhoto.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'nicescroll', QODE_ASSETS_ROOT . '/js/modules/plugins/jquery.nicescroll.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'perfectscrollbar', QODE_ASSETS_ROOT . '/js/modules/plugins/perfect-scrollbar.jquery.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'ScrollToPlugin', QODE_ASSETS_ROOT . '/js/modules/plugins/ScrollToPlugin.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'parallax', QODE_ASSETS_ROOT . '/js/modules/plugins/parallax.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'waitforimages', QODE_ASSETS_ROOT . '/js/modules/plugins/jquery.waitforimages.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'jquery-easing-1.3', QODE_ASSETS_ROOT . '/js/modules/plugins/jquery.easing.1.3.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'isotope', QODE_ASSETS_ROOT . '/js/modules/plugins/isotope.pkgd.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'packery', QODE_ASSETS_ROOT . '/js/modules/plugins/packery-mode.pkgd.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'parallax-scroll', QODE_ASSETS_ROOT . '/js/modules/plugins/jquery.parallax-scroll.js', array( 'jquery' ), false, true );

		do_action( 'bazaar_qodef_enqueue_third_party_scripts' );

		if ( bazaar_qodef_is_woocommerce_installed() ) {
			wp_enqueue_script( 'select2' );
		}

		if ( bazaar_qodef_is_page_smooth_scroll_enabled() ) {
			wp_enqueue_script( 'tweenLite', QODE_ASSETS_ROOT . '/js/modules/plugins/TweenLite.min.js', array( 'jquery' ), false, true );
			wp_enqueue_script( 'smoothPageScroll', QODE_ASSETS_ROOT . '/js/modules/plugins/smoothPageScroll.js', array( 'jquery' ), false, true );
		}

		//include google map api script
		$google_maps_api_key          = bazaar_qodef_options()->getOptionValue( 'google_maps_api_key' );
		$google_maps_extensions       = '';
		$google_maps_extensions_array = apply_filters( 'bazaar_qodef_google_maps_extensions_array', array() );
		if ( ! empty( $google_maps_extensions_array ) ) {
			$google_maps_extensions .= '&libraries=';
			$google_maps_extensions .= implode( ',', $google_maps_extensions_array );
		}
		if ( ! empty( $google_maps_api_key ) ) {
			wp_enqueue_script( 'bazaar_qodef_google_map_api', '//maps.googleapis.com/maps/api/js?key=' . esc_attr( $google_maps_api_key ) . $google_maps_extensions, array(), false, true );
		}

		wp_enqueue_script( 'bazaar_qodef_modules', QODE_ASSETS_ROOT . '/js/modules.min.js', array( 'jquery' ), false, true );

		//include comment reply script
		$wp_scripts->add_data( 'comment-reply', 'group', 1 );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	add_action( 'wp_enqueue_scripts', 'bazaar_qodef_scripts' );
}

if ( ! function_exists( 'bazaar_qodef_theme_setup' ) ) {
	/**
	 * Function that adds various features to theme. Also defines image sizes that are used in a theme
	 */
	function bazaar_qodef_theme_setup() {
		//add support for feed links
		add_theme_support( 'automatic-feed-links' );

		//add support for post formats
		add_theme_support( 'post-formats', array( 'gallery', 'link', 'quote', 'video', 'audio' ) );

		//add theme support for post thumbnails
		add_theme_support( 'post-thumbnails' );

		//add theme support for title tag
		add_theme_support( 'title-tag' );

		//defined content width variable
		$GLOBALS['content_width'] = apply_filters( 'bazaar_qodef_set_content_width', 1300 );

		//define thumbnail sizes
		add_image_size( 'bazaar_qodef_square', 550, 550, true );
		add_image_size( 'bazaar_qodef_landscape', 1100, 550, true );
		add_image_size( 'bazaar_qodef_portrait', 550, 1100, true );
		add_image_size( 'bazaar_qodef_huge', 1100, 1100, true );

		load_theme_textdomain( 'bazaar', get_template_directory() . '/languages' );
	}

	add_action( 'after_setup_theme', 'bazaar_qodef_theme_setup' );
}

if ( ! function_exists( 'bazaar_qodef_is_responsive_on' ) ) {
	/**
	 * Checks whether responsive mode is enabled in theme options
	 * @return bool
	 */
	function bazaar_qodef_is_responsive_on() {
		return bazaar_qodef_options()->getOptionValue( 'responsiveness' ) !== 'no';
	}
}

if ( ! function_exists( 'bazaar_qodef_rgba_color' ) ) {
	/**
	 * Function that generates rgba part of css color property
	 *
	 * @param $color string hex color
	 * @param $transparency float transparency value between 0 and 1
	 *
	 * @return string generated rgba string
	 */
	function bazaar_qodef_rgba_color( $color, $transparency ) {
		if ( $color !== '' && $transparency !== '' ) {
			$rgba_color = '';

			$rgb_color_array = bazaar_qodef_hex2rgb( $color );
			$rgba_color      .= 'rgba(' . implode( ', ', $rgb_color_array ) . ', ' . $transparency . ')';

			return $rgba_color;
		}
	}
}

if ( ! function_exists( 'bazaar_qodef_header_meta' ) ) {
	/**
	 * Function that echoes meta data if our seo is enabled
	 */
	function bazaar_qodef_header_meta() { ?>

		<meta charset="<?php bloginfo( 'charset' ); ?>"/>
		<link rel="profile" href="http://gmpg.org/xfn/11"/>
		<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
			<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php endif; ?>

	<?php }

	add_action( 'bazaar_qodef_header_meta', 'bazaar_qodef_header_meta' );
}

if ( ! function_exists( 'bazaar_qodef_user_scalable_meta' ) ) {
	/**
	 * Function that outputs user scalable meta if responsiveness is turned on
	 * Hooked to bazaar_qodef_header_meta action
	 */
	function bazaar_qodef_user_scalable_meta() {
		//is responsiveness option is chosen?
		if ( bazaar_qodef_is_responsive_on() ) { ?>
			<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=yes">
		<?php } else { ?>
			<meta name="viewport" content="width=1200,user-scalable=yes">
		<?php }
	}

	add_action( 'bazaar_qodef_header_meta', 'bazaar_qodef_user_scalable_meta' );
}

if ( ! function_exists( 'bazaar_qodef_smooth_page_transitions' ) ) {
	/**
	 * Function that outputs smooth page transitions html if smooth page transitions functionality is turned on
	 * Hooked to bazaar_qodef_after_body_tag action
	 */
	function bazaar_qodef_smooth_page_transitions() {
		$id = bazaar_qodef_get_page_id();

		if ( bazaar_qodef_get_meta_field_intersect( 'smooth_page_transitions', $id ) === 'yes' &&
			bazaar_qodef_get_meta_field_intersect( 'page_transition_preloader', $id ) === 'yes'
		) { ?>
			<div class="qodef-smooth-transition-loader qodef-mimic-ajax">
				<div class="qodef-st-loader">
					<div class="qodef-st-loader1">
						<?php bazaar_qodef_loading_spinners(); ?>
					</div>
				</div>
			</div>
		<?php }
	}

	add_action( 'bazaar_qodef_after_body_tag', 'bazaar_qodef_smooth_page_transitions', 10 );
}

if ( ! function_exists( 'bazaar_qodef_back_to_top_button' ) ) {
	/**
	 * Function that outputs back to top button html if back to top functionality is turned on
	 * Hooked to bazaar_qodef_after_header_area action
	 */
	function bazaar_qodef_back_to_top_button() {
		if ( bazaar_qodef_options()->getOptionValue( 'show_back_button' ) == 'yes' ) { ?>
			<a id='qodef-back-to-top' href='#'>
				<div class="qodef-btt-inner">
					<span class="qodef-btt-label"><?php esc_attr_e( 'back to top', 'bazaar' ) ?></span>
					<span class="qodef-icon-stack">
						<span class="dripicon-arrow-thin-up"></span>
	                </span>
				</div>
			</a>
		<?php }
	}

	add_action( 'bazaar_qodef_after_header_area', 'bazaar_qodef_back_to_top_button', 10 );
}

if ( ! function_exists( 'bazaar_qodef_get_page_id' ) ) {
	/**
	 * Function that returns current page / post id.
	 * Checks if current page is woocommerce page and returns that id if it is.
	 * Checks if current page is any archive page (category, tag, date, author etc.) and returns -1 because that isn't
	 * page that is created in WP admin.
	 *
	 * @return int
	 *
	 * @version 0.1
	 *
	 * @see bazaar_qodef_is_woocommerce_installed()
	 * @see bazaar_qodef_is_woocommerce_shop()
	 */
	function bazaar_qodef_get_page_id() {
		if ( bazaar_qodef_is_woocommerce_installed() && bazaar_qodef_is_woocommerce_shop() ) {
			return bazaar_qodef_get_woo_shop_page_id();
		}

		if ( bazaar_qodef_is_default_wp_template() ) {
			return - 1;
		}

		return get_queried_object_id();
	}
}

if ( ! function_exists( 'bazaar_qodef_get_multisite_blog_id' ) ) {
	/**
	 * Check is multisite and return blog id
	 *
	 * @return int
	 */
	function bazaar_qodef_get_multisite_blog_id() {
		if ( is_multisite() ) {
			return get_blog_details()->blog_id;
		}
	}
}

if ( ! function_exists( 'bazaar_qodef_is_default_wp_template' ) ) {
	/**
	 * Function that checks if current page archive page, search, 404 or default home blog page
	 * @return bool
	 *
	 * @see is_archive()
	 * @see is_search()
	 * @see is_404()
	 * @see is_front_page()
	 * @see is_home()
	 */
	function bazaar_qodef_is_default_wp_template() {
		return is_archive() || is_search() || is_404() || ( is_front_page() && is_home() );
	}
}

if ( ! function_exists( 'bazaar_qodef_has_shortcode' ) ) {
	/**
	 * Function that checks whether shortcode exists on current page / post
	 *
	 * @param string shortcode to find
	 * @param string content to check. If isn't passed current post content will be used
	 *
	 * @return bool whether content has shortcode or not
	 */
	function bazaar_qodef_has_shortcode( $shortcode, $content = '' ) {
		$has_shortcode = false;

		if ( $shortcode ) {
			//if content variable isn't past
			if ( $content == '' ) {
				//take content from current post
				$page_id = bazaar_qodef_get_page_id();
				if ( ! empty( $page_id ) ) {
					$current_post = get_post( $page_id );

					if ( is_object( $current_post ) && property_exists( $current_post, 'post_content' ) ) {
						$content = $current_post->post_content;
					}
				}
			}

			//does content has shortcode added?
			if ( stripos( $content, '[' . $shortcode ) !== false ) {
				$has_shortcode = true;
			}
		}

		return $has_shortcode;
	}
}

if ( ! function_exists( 'bazaar_qodef_get_unique_page_class' ) ) {
	/**
	 * Returns unique page class based on post type and page id
	 *
	 * $params int $id is page id
	 * $params bool $allowSingleProductOption
	 * @return string
	 */
	function bazaar_qodef_get_unique_page_class( $id, $allowSingleProductOption = false ) {
		$page_class = '';

		if ( bazaar_qodef_is_woocommerce_installed() && $allowSingleProductOption ) {

			if ( is_product() ) {
				$id = get_the_ID();
			}
		}

		if ( is_single() ) {
			$page_class = '.postid-' . $id;
		} elseif ( is_home() ) {
			$page_class .= '.home';
		} elseif ( is_archive() || $id === bazaar_qodef_get_woo_shop_page_id() ) {
			$page_class .= '.archive';
		} elseif ( is_search() ) {
			$page_class .= '.search';
		} elseif ( is_404() ) {
			$page_class .= '.error404';
		} else {
			$page_class .= '.page-id-' . $id;
		}

		return $page_class;
	}
}

if ( ! function_exists( 'bazaar_qodef_print_custom_css' ) ) {
	/**
	 * Prints out custom css from theme options
	 */
	function bazaar_qodef_print_custom_css() {
		$custom_css = bazaar_qodef_options()->getOptionValue( 'custom_css' );

		if ( ! empty( $custom_css ) ) {
			wp_add_inline_style( 'bazaar_qodef_modules', $custom_css );
		}
	}

	add_action( 'wp_enqueue_scripts', 'bazaar_qodef_print_custom_css' );
}

if ( ! function_exists( 'bazaar_qodef_page_custom_style' ) ) {
	/**
	 * Function that print custom page style
	 */
	function bazaar_qodef_page_custom_style() {
		$style = apply_filters( 'bazaar_qodef_add_page_custom_style', $style = '' );

		if ( $style !== '' ) {

			if ( bazaar_qodef_is_woocommerce_installed() && bazaar_qodef_load_woo_assets() ) {
				wp_add_inline_style( 'bazaar_qodef_woo', $style );
			} else {
				wp_add_inline_style( 'bazaar_qodef_modules', $style );
			}
		}
	}

	add_action( 'wp_enqueue_scripts', 'bazaar_qodef_page_custom_style' );
}

if ( ! function_exists( 'bazaar_qodef_container_style' ) ) {
	/**
	 * Function that return container style
	 */
	function bazaar_qodef_container_style( $style ) {
		$page_id      = bazaar_qodef_get_page_id();
		$class_prefix = bazaar_qodef_get_unique_page_class( $page_id, true );

		$container_selector = array(
			$class_prefix . ' .qodef-content .qodef-content-inner > .qodef-container',
			$class_prefix . ' .qodef-content .qodef-content-inner > .qodef-full-width'
		);

		$container_class       = array();
		$page_backgorund_color = get_post_meta( $page_id, 'qodef_page_background_color_meta', true );

		if ( $page_backgorund_color ) {
			$container_class['background-color'] = $page_backgorund_color;
		}

		$current_style = bazaar_qodef_dynamic_css( $container_selector, $container_class );
		$current_style = $current_style . $style;

		return $current_style;
	}

	add_filter( 'bazaar_qodef_add_page_custom_style', 'bazaar_qodef_container_style' );
}

if ( ! function_exists( 'bazaar_qodef_content_padding_top' ) ) {
	/**
	 * Function that return padding for content
	 */
	function bazaar_qodef_content_padding_top( $style ) {
		$page_id      = bazaar_qodef_get_page_id();
		$class_prefix = bazaar_qodef_get_unique_page_class( $page_id, true );

		$current_style = '';

		$content_selector = array(
			$class_prefix . ' .qodef-content .qodef-content-inner > .qodef-container > .qodef-container-inner',
			$class_prefix . ' .qodef-content .qodef-content-inner > .qodef-full-width > .qodef-full-width-inner',
		);

		$content_class = array();

		$page_padding_top = get_post_meta( $page_id, 'qodef_page_content_top_padding', true );

		if ( $page_padding_top !== '' ) {
			if ( get_post_meta( $page_id, 'qodef_page_content_top_padding_mobile', true ) == 'yes' ) {
				$content_class['padding-top'] = bazaar_qodef_filter_px( $page_padding_top ) . 'px !important';
			} else {
				$content_class['padding-top'] = bazaar_qodef_filter_px( $page_padding_top ) . 'px';
			}
			$current_style .= bazaar_qodef_dynamic_css( $content_selector, $content_class );
		}

		$current_style = $current_style . $style;

		return $current_style;
	}

	add_filter( 'bazaar_qodef_add_page_custom_style', 'bazaar_qodef_content_padding_top' );
}

if ( ! function_exists( 'bazaar_qodef_print_custom_js' ) ) {
	/**
	 * Prints out custom css from theme options
	 */
	function bazaar_qodef_print_custom_js() {
		$custom_js = bazaar_qodef_options()->getOptionValue( 'custom_js' );

		if ( ! empty( $custom_js ) ) {
			wp_add_inline_script( 'bazaar_qodef_modules', $custom_js );
		}
	}

	add_action( 'wp_enqueue_scripts', 'bazaar_qodef_print_custom_js' );
}

if ( ! function_exists( 'bazaar_qodef_get_global_variables' ) ) {
	/**
	 * Function that generates global variables and put them in array so they could be used in the theme
	 */
	function bazaar_qodef_get_global_variables() {
		$global_variables = array();

		$global_variables['qodefAddForAdminBar']      = is_admin_bar_showing() ? 32 : 0;
		$global_variables['qodefElementAppearAmount'] = - 100;
		$global_variables['qodefAjaxUrl']             = admin_url( 'admin-ajax.php' );

		$global_variables = apply_filters( 'bazaar_qodef_js_global_variables', $global_variables );

		wp_localize_script( 'bazaar_qodef_modules', 'qodefGlobalVars', array(
			'vars' => $global_variables
		) );
	}

	add_action( 'wp_enqueue_scripts', 'bazaar_qodef_get_global_variables' );
}

if ( ! function_exists( 'bazaar_qodef_per_page_js_variables' ) ) {
	/**
	 * Outputs global JS variable that holds page settings
	 */
	function bazaar_qodef_per_page_js_variables() {
		$per_page_js_vars = apply_filters( 'bazaar_qodef_per_page_js_vars', array() );

		wp_localize_script( 'bazaar_qodef_modules', 'qodefPerPageVars', array(
			'vars' => $per_page_js_vars
		) );
	}

	add_action( 'wp_enqueue_scripts', 'bazaar_qodef_per_page_js_variables' );
}

if ( ! function_exists( 'bazaar_qodef_content_elem_style_attr' ) ) {
	/**
	 * Defines filter for adding custom styles to content HTML element
	 */
	function bazaar_qodef_content_elem_style_attr() {
		$styles = apply_filters( 'bazaar_qodef_content_elem_style_attr', array() );

		bazaar_qodef_inline_style( $styles );
	}
}

if ( ! function_exists( 'bazaar_qodef_core_plugin_installed' ) ) {
	/**
	 * Function that checks if Qode Core plugin installed
	 * @return bool
	 */
	function bazaar_qodef_core_plugin_installed() {
		return defined( 'QODE_CORE_VERSION' );
	}
}

if ( ! function_exists( 'bazaar_qodef_is_woocommerce_installed' ) ) {
	/**
	 * Function that checks if Woocommerce plugin installed
	 * @return bool
	 */
	function bazaar_qodef_is_woocommerce_installed() {
		return function_exists( 'is_woocommerce' );
	}
}

if ( ! function_exists( 'bazaar_qodef_visual_composer_installed' ) ) {
	/**
	 * Function that checks if Visual Composer plugin installed
	 * @return bool
	 */
	function bazaar_qodef_visual_composer_installed() {
		return class_exists( 'WPBakeryVisualComposerAbstract' );
	}
}

if ( ! function_exists( 'bazaar_qodef_revolution_slider_installed' ) ) {
	/**
	 * Function that checks if Revolution Slider plugin installed
	 * @return bool
	 */
	function bazaar_qodef_revolution_slider_installed() {
		return class_exists( 'RevSliderFront' );
	}
}

if ( ! function_exists( 'bazaar_qodef_contact_form_7_installed' ) ) {
	/**
	 * Function that checks if Contact Form 7 plugin installed
	 * @return bool
	 */
	function bazaar_qodef_contact_form_7_installed() {
		return defined( 'WPCF7_VERSION' );
	}
}

if ( ! function_exists( 'bazaar_qodef_is_wpml_installed' ) ) {
	/**
	 * Function that checks if WPML plugin installed
	 * @return bool
	 */
	function bazaar_qodef_is_wpml_installed() {
		return defined( 'ICL_SITEPRESS_VERSION' );
	}
}

if ( ! function_exists( 'bazaar_qodef_max_image_width_srcset' ) ) {
	/**
	 * Set max width for srcset to 1920
	 *
	 * @return int
	 */
	function bazaar_qodef_max_image_width_srcset() {
		return 1920;
	}

	add_filter( 'max_srcset_image_width', 'bazaar_qodef_max_image_width_srcset' );
}

if ( ! function_exists( 'bazaar_qodef_is_gutenberg_installed' ) ) {
	/**
	 * Function that checks if Gutenberg plugin installed
	 * @return bool
	 */
	function bazaar_qodef_is_gutenberg_installed() {
		return function_exists( 'is_gutenberg_page' ) && is_gutenberg_page();
	}
}

if ( ! function_exists( 'bazaar_qodef_is_gutenberg_editor' ) ) {
	/**
	 * Function that checks if Gutenberg editor from core is active
	 * @return bool
	 */
	function bazaar_qodef_is_gutenberg_editor() {
		return class_exists( 'WP_Block_Type' );
	}
}

if ( ! function_exists( 'bazaar_qodef_get_module_part' ) ) {
	function bazaar_qodef_get_module_part( $module ) {
		return $module;
	}
}

if ( ! function_exists( 'bazaar_qodef_enqueue_editor_customizer_styles' ) ) {
	/**
	 * Enqueue supplemental block editor styles
	 */
	function bazaar_qodef_enqueue_editor_customizer_styles() {
		wp_enqueue_style( 'bazaar-style-modules-admin-styles', QODE_FRAMEWORK_ADMIN_ASSETS_ROOT . '/css/qodef-modules-admin.css' );
		wp_enqueue_style( 'bazaar-style-handle-editor-customizer-styles', QODE_FRAMEWORK_ADMIN_ASSETS_ROOT . '/css/editor-customizer-style.css' );
	}

	// add google font
	add_action( 'enqueue_block_editor_assets', 'bazaar_qodef_google_fonts_styles' );
	// add action
	add_action( 'enqueue_block_editor_assets', 'bazaar_qodef_enqueue_editor_customizer_styles' );
}