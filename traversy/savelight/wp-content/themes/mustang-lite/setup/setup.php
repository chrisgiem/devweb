<?php
/**
 * Theme Setup
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Theme Setup
 * @copyright   2014 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.9.3
 *
 * CONTENT:
 * - 1) Required files
 * - 10) Actions and filters
 * - 20) Globals
 * - 30) Theme installation
 * - 40) Assets and design
 * - 50) Website sections markup
 * - 60) Others
 */





/**
 * 1) Required files
 */

	//Theme options arrays
		require get_theme_file_path( WM_SETUP_DIR . 'setup-theme-options.php' );





/**
 * 10) Actions and filters
 */

	/**
	 * Actions
	 */

		//Theme upgrade action
			add_action( 'wmhook_theme_upgrade', 'wm_generate_all_css' );
			add_action( 'after_setup_theme', 'wm_update_legacy_options', 998 ); //@todo  Move this into 'wmhook_theme_upgrade' in the future.
		//Styles and scripts
			add_action( 'init',               'wm_register_assets', 10 );
			add_action( 'wp_enqueue_scripts', 'wm_site_assets',     98 );
		//Theme installation
			add_action( 'after_setup_theme',              'wm_install',       10 );
			add_action( 'wmhook_wmamp_plugin_activation', 'wm_default_setup', 10 );
		//Register widget areas
			add_action( 'widgets_init', 'wm_register_widget_areas', 1 );
		//JetPack plugin infinite scroll
			add_action( 'after_setup_theme', 'wm_jp_infinit_scroll', 20 );
		//Pagination fallback
			if ( ! function_exists( 'wma_pagination' ) ) {
				add_action( 'wmhook_postslist_after', 'wm_pagination', 10 );
			}
		//Website sections
			//DOCTYPE
				add_action( 'wmhook_html_before', 'wm_doctype', 10 );
			//HEAD
				add_action( 'wmhook_head_bottom', 'wm_head',                  10   );
				add_action( 'wp_footer',          'wm_footer_custom_scripts', 9998 );
			//Body
				add_action( 'wmhook_body_top',       'wm_body_top',               10  );
				add_action( 'wmhook_body_bottom',    'wm_body_bottom',            100 );
			//Topbar
				add_action( 'wmhook_header_before',  'wm_section_topbar',         10 );
				add_action( 'wmhook_header_before',  'wm_section_topbar_extra',   20 );
			//Header
				add_action( 'wmhook_header_top',     'wm_section_header_top',     10 );
				add_action( 'wmhook_header',         'wm_logo',                   10 );
				add_action( 'wmhook_header',         'wm_navigation_special',     20 );
				add_action( 'wmhook_header',         'wm_section_navigation',     30 );
				add_action( 'wmhook_header',         'wm_header_search_form',     40 );
				add_action( 'wmhook_header_bottom',  'wm_section_header_bottom',  10 );
			//After header (slider and main heading)
				add_action( 'wmhook_header_after',   'wm_section_slider',         10 );
				add_action( 'wmhook_header_after',   'wm_section_heading',        20 );
			//Content
				add_action( 'wmhook_content_top',    'wm_section_content_top',    10 );
				add_action( 'wmhook_entry_top',      'wm_entry_top',              10 );
				add_action( 'wmhook_entry_bottom',   'wm_entry_bottom',           10 );
				add_action( 'wmhook_entry_bottom',   'wm_hatom_microformats',     20 );
				add_action( 'wmhook_content_bottom', 'wm_section_content_bottom', 10 );
			//Footer
				add_action( 'wmhook_footer_before',  'wm_prevnext_post',          10 );
				add_action( 'wmhook_footer_top',     'wm_section_footer_top',     10 );
				add_action( 'wmhook_footer',         'wm_section_footer',         10 );
				add_action( 'wmhook_footer_bottom',  'wm_section_footer_bottom',  10 );

		//Remove actions
			remove_action( 'wp_head', 'wp_generator'     );
			remove_action( 'wp_head', 'wlwmanifest_link' );



	/**
	 * Filters
	 */

		//Admin body class
			add_filter( 'admin_body_class', 'wm_admin_body_class' );
		//Logo URL
			add_filter( 'wmhook_wm_logo_args', 'wm_logo_url' );
		//BODY classes
			add_filter( 'body_class', 'wm_body_classes', 98 );
		//Remove header and footer on blank page template
			add_filter( 'wmhook_disable_header', 'wm_no_header_footer', 10 );
			add_filter( 'wmhook_disable_footer', 'wm_no_header_footer', 10 );
		//Placeholder images
			add_filter( 'wmhook_wm_thumb_placeholder_image', '__return_empty_string' );
		//Navigation improvements
			add_filter( 'nav_menu_css_class',       'wm_nav_item_classes', 10, 4 );
			add_filter( 'walker_nav_menu_start_el', 'wm_nav_item_process', 10, 4 );
			add_filter( 'wp_nav_menu_objects',      'wm_nav_item_position_class' );
			add_filter( 'wmhook_wm_navigation_special_one_page_disable', '__return_true' );
		//Static slider image captions
			add_filter( 'wmhook_wm_section_slider_image_caption', 'wm_default_content_filters', 10 );
		//Gallery shortcode modifications (works with Jetpack Tiled Gallery too - that's why "1999")
			add_filter( 'post_gallery', 'wm_shortcode_gallery', 1999, 2 );
		//Forcing page layout
			add_filter( 'wmhook_wmamp_wma_meta_option_output_premature', 'wm_force_page_layout', 10, 3 );
		//Inner wrappers markup
			add_filter( 'wmhook_section_inner_wrappers',       'wm_section_inner_wrappers'       );
			add_filter( 'wmhook_section_inner_wrappers_close', 'wm_section_inner_wrappers_close' );
		//Blog page template
			add_filter( 'wmhook_wmamp_wma_pagination_atts', 'wm_pagination_blog', 10 );
		//Media uploader and media library
			add_filter( 'image_size_names_choose', 'wm_media_uploader_image_sizes' );
		//WordPress register_sidebar() default args (required for WooSidebars plugin)
			add_filter( 'dynamic_sidebar_params', 'wm_ws_default_sidebar_params', 10 );
		//JetPack plugin infinite scroll
			add_action( 'infinite_scroll_js_settings', 'wm_jp_infinit_scroll_button_text', 10 );
		//Contact Form 7 plugin enhancements
			add_filter( 'wpcf7_form_elements', 'wm_cf7_shortcode_support' );
		//Breadcrumbs NavXT modifications
			add_filter( 'bcn_show_cpt_private', 'wm_bcn_settings', 10, 2 );
		//Post Views Count / Love It (Pro) / ZillaLikes plugin
			if (
					function_exists( 'bawpvc_views_sc' )
					|| function_exists( 'lip_love_it_link' )
					|| function_exists( 'zilla_likes' )
				) {
				add_filter( 'wmhook_wm_post_meta', 'wm_post_custom_metas', 10, 3 );
			}
		//Fallback when not using WebMan Amplifier
			if ( ! class_exists( 'WM_Amplifier' ) ) {
				add_filter( 'wmhook_admin_modifications_enabled', '__return_false' );
			}





/**
 * 20) Globals
 */

	/**
	 * Max content width
	 *
	 * @since    1.0
	 * @version  1.1.1
	 */

		if ( ! isset( $content_width ) || ! $content_width ) {
			global $content_width; //Required for we don't set it in functions.php file
			$content_width = ( ! wm_option( 'skin-website-width' ) ) ? ( 1400 ) : ( absint( apply_filters( 'wmhook_global_content_width', ( wm_option( 'skin-website-width' ) - ( 2 * 80 ) ) ) ) );
		}




	/**
	 * Theme helper variables
	 *
	 * @since    1.0
	 * @version  1.9.3
	 *
	 * @param  string $variable Helper variables array key to return
	 * @param  string $key Additional key if the variable is array
	 */
	if ( ! function_exists( 'wm_helper_var' ) ) {
		function wm_helper_var( $variable, $key = '' ) {
			//Helper variables
				$output = array();

				//Background CSS settings
					$output['bg-css'] = array(
							'position' => array(
									'0 0'       => '<span class="position-option">' . __( 'Left, top', 'mustang-lite' ) . '</span>',
									'50% 0'     => '<span class="position-option">' . __( 'Center horizontally, top', 'mustang-lite' ) . '</span>',
									'100% 0'    => '<span class="position-option">' . __( 'Right, top', 'mustang-lite' ) . '</span>',
									'0 50%'     => '<span class="position-option">' . __( 'Left, center vertically', 'mustang-lite' ) . '</span>',
									'50% 50%'   => '<span class="position-option">' . __( 'Center', 'mustang-lite' ) . '</span>',
									'100% 50%'  => '<span class="position-option">' . __( 'Right, center vertically', 'mustang-lite' ) . '</span>',
									'0 100%'    => '<span class="position-option">' . __( 'Left, bottom', 'mustang-lite' ) . '</span>',
									'50% 100%'  => '<span class="position-option">' . __( 'Center horizontally, bottom', 'mustang-lite' ) . '</span>',
									'100% 100%' => '<span class="position-option">' . __( 'Right, bottom', 'mustang-lite' ) . '</span>',
								),
							'repeat'   => array(
									'no-repeat' => __( 'Do not repeat', 'mustang-lite' ),
									'repeat-x'  => __( 'Repeat horizontally', 'mustang-lite' ),
									'repeat-y'  => __( 'Repeat vertically', 'mustang-lite' ),
									'repeat'    => __( 'Repeat (tile)', 'mustang-lite' ),
								),
							'scroll'   => array(
									'scroll' => __( 'Move on scrolling', 'mustang-lite' ),
									'fixed'  => __( 'Fixed position', 'mustang-lite' ),
								),
							'size'     => array(
									''        => __( 'Default', 'mustang-lite' ),
									'cover'   => __( 'Cover', 'mustang-lite' ),
									'contain' => __( 'Contain', 'mustang-lite' ),
								),
						);

				//Google Fonts
					$output['google-fonts'] = array(
							' '                         => __( ' - do not use Google Font', 'mustang-lite' ),
							'Abril Fatface'             => 'Abril Fatface',
							'Arvo'                      => 'Arvo',
							'Comfortaa:400,300'         => 'Comfortaa',
							'Domine'                    => 'Domine',
							'Droid Sans'                => 'Droid Sans',
							'Droid Serif'               => 'Droid Serif',
							'Duru Sans'                 => 'Duru Sans',
							'Inconsolata'               => 'Inconsolata',
							'Josefin Slab:400,300'      => 'Josefin Slab',
							'Lato:400,300,100'          => 'Lato',
							'Lobster'                   => 'Lobster',
							'Merriweather:400,300'      => 'Merriweather',
							'Merriweather Sans:400,300' => 'Merriweather Sans',
							'Metamorphous'              => 'Metamorphous',
							'Michroma'                  => 'Michroma',
							'Monoton'                   => 'Monoton',
							'Montserrat'                => 'Montserrat',
							'Nixie One'                 => 'Nixie One',
							'Noto Sans'                 => 'Noto Sans',
							'Nunito:400,300'            => 'Nunito',
							'Old Standard TT'           => 'Old Standard TT',
							'Open Sans:400,300'         => 'Open Sans',
							'Open Sans Condensed:300'   => 'Open Sans Condensed',
							'Oswald:400,300'            => 'Oswald',
							'PT Sans'                   => 'PT Sans',
							'PT Serif'                  => 'PT Serif',
							'Quicksand:400,300'         => 'Quicksand',
							'Raleway:400,300,200'       => 'Raleway',
							'Roboto:400,300'            => 'Roboto',
							'Rokkitt'                   => 'Rokkitt',
							'Source Sans Pro:400,300'   => 'Source Sans Pro',
							'Tenor Sans'                => 'Tenor Sans',
							'Ubuntu:400,300'            => 'Ubuntu',
							'Ubuntu Condensed'          => 'Ubuntu Condensed',
							'Vollkorn'                  => 'Vollkorn',
							'Yanone Kaffeesatz:400,300' => 'Yanone Kaffeesatz',
						);

				//Google Fonts subsets
					$output['google-fonts-subset'] = array(
							'latin'        => 'Latin',
							'latin-ext'    => 'Latin Extended',
							'cyrillic'     => 'Cyrillic',
							'cyrillic-ext' => 'Cyrillic Extended',
							'greek'        => 'Greek',
							'greek-ext'    => 'Greek Extended',
							'vietnamese'   => 'Vietnamese',
						);

				//Image ratio
					$output['image-ratio'] = array(
							'ratio-11'    => __( 'Square', 'mustang-lite' ),
							//Landscapes
								'ratio-43'  => __( 'Landscape 4 to 3', 'mustang-lite' ),
								'ratio-32'  => __( 'Landscape 3 to 2', 'mustang-lite' ),
								'ratio-169' => __( 'Landscape 16 to 9', 'mustang-lite' ),
								'ratio-21'  => __( 'Landscape 2 to 1', 'mustang-lite' ),
								'ratio-31'  => __( 'Landscape 3 to 1', 'mustang-lite' ),
							//Portraits
								'ratio-34'  => __( 'Portrait 3 to 4', 'mustang-lite' ),
								'ratio-23'  => __( 'Portrait 2 to 3', 'mustang-lite' ),
						);

				//Layouts
					$output['layouts'] = array(
							'sidebars' => array(
									''         => __( 'Default', 'mustang-lite' ),
									'right'    => __( 'Right sidebar', 'mustang-lite' ),
									'left'     => __( 'Left sidebar', 'mustang-lite' ),
									'none'     => __( 'No sidebar', 'mustang-lite' ),
									'sections' => __( 'Fullwidth sections', 'mustang-lite' ),
								),
							'website'  => array(
									''          => __( 'Default', 'mustang-lite' ),
									'fullwidth' => __( 'Fullwidth', 'mustang-lite' ),
									'boxed'     => __( 'Boxed', 'mustang-lite' ),
								),
						);

				//Widget areas
					$output['widget-areas'] = array(
							'general'              => array(
								'name'          => __( 'General Sidebar', 'mustang-lite' ),
								'id'            => 'general',
								'description'   => __( 'The default general sidebar.', 'mustang-lite' ),
								'before_widget' => '<section class="widget %1$s %2$s">',
								'after_widget'  => '</section>',
								'before_title'  => '<h3 class="widget-heading">',
								'after_title'   => '</h3>'
							),
							'topbar'          => array(
								'name'          => __( 'Topbar Widgets', 'mustang-lite' ),
								'id'            => 'topbar',
								'description'   => __( 'Widget area displayed as topbar of the website.', 'mustang-lite' ),
								'before_widget' => '<section class="widget %1$s %2$s">',
								'after_widget'  => '</section>',
								'before_title'  => '<p class="widget-heading">',
								'after_title'   => '</p>'
							),
							'topbar-extra'    => array(
								'name'          => __( 'Topbar Extra Widgets', 'mustang-lite' ),
								'id'            => 'topbar-extra',
								'description'   => __( 'Widget area displayed as extra topbar. It rolls out from top of the website when a button is clicked.', 'mustang-lite' ),
								'before_widget' => '<section class="widget %1$s %2$s">',
								'after_widget'  => '</section>',
								'before_title'  => '<h4 class="widget-heading">',
								'after_title'   => '</h4>'
							),
							'main-heading-widgets' => array(
								'name'          => __( 'Main Heading Widgets', 'mustang-lite' ),
								'id'            => 'main-heading-widgets',
								'description'   => __( 'Widget area displayed in the Main Heading section.', 'mustang-lite' ),
								'before_widget' => '<section class="widget %1$s %2$s">',
								'after_widget'  => '</section>',
								'before_title'  => '<p class="widget-heading">',
								'after_title'   => '</p>'
							),
							'footer-widgets'       => array(
								'name'          => __( 'Footer Widgets', 'mustang-lite' ),
								'id'            => 'footer-widgets',
								'description'   => __( 'Masonry footer layout. Set up the columns number in theme admin panel.', 'mustang-lite' ),
								'before_widget' => '<section class="widget %1$s %2$s">',
								'after_widget'  => '</section>',
								'before_title'  => '<h3 class="widget-heading">',
								'after_title'   => '</h3>'
							),
							'footer-credits'       => array(
								'name'          => __( 'Credits Widgets', 'mustang-lite' ),
								'id'            => 'credits',
								'description'   => __( 'Credits or copyright area in the footer. Takes up to 3 widgets. When you insert 1 widget, it will be displayed fullwidth. When 2 widgets are in the area, first is displayed on left, the second on right. In case of 3 widgets in the area, first is displayed fullwidth, second and third below, on the left and on the right.', 'mustang-lite' ),
								'before_widget' => '<section class="widget %1$s %2$s">',
								'after_widget'  => '</section>',
								'before_title'  => '<h4 class="widget-heading">',
								'after_title'   => '</h4>'
							),
						);

					if ( function_exists( 'wm_is_woocommerce' ) ) {
						$output['widget-areas']['floating-cart'] = array(
								'name'          => __( 'Floating cart', 'mustang-lite' ),
								'id'            => 'floating-cart',
								'description'   => __( 'Widget area displayed as floating shoping cart.', 'mustang-lite' ),
								'before_widget' => '<section class="widget %1$s %2$s">',
								'after_widget'  => '</section>',
								'before_title'  => '<h4 class="widget-heading">',
								'after_title'   => '</h4>'
							);
					}

					if ( ! class_exists( 'WM_Amplifier' ) ) {
						unset( $output['widget-areas']['topbar'] );
						unset( $output['widget-areas']['topbar-extra'] );
						unset( $output['widget-areas']['main-heading-widgets'] );
						unset( $output['widget-areas']['footer-credits'] );
					}

			//Output
				$output = apply_filters( 'wmhook_wm_helper_var_output', $output );

				if ( isset( $output[ $variable ] ) ) {
					$output = $output[ $variable ];
					if ( isset( $output[ $key ] ) ) {
						$output = $output[ $key ];
					}
				} else {
					$output = '';
				}

				return $output;
		}
	} // /wm_helper_var





/**
 * 30) Theme installation
 */

	/**
	 * Updating legacy theme options
	 *
	 * Copies a theme options from old (pre v1.4) theme options
	 * database record to new one
	 *
	 * @since    1.4
	 * @version  1.4
	 */
	if ( ! function_exists( 'wm_update_legacy_options' ) ) {
		function wm_update_legacy_options() {
			//Helper variables
				$options_old = get_option( WM_THEME_SETTINGS . '-skin' );

			//Processing
				if ( ! empty( $options_old ) ) {
					//Get new options - there might be some, like menu locations setup,...
						$options_new = (array) get_option( WM_THEME_SETTINGS_SKIN );

					//Update the new options - append the old ones
						update_option( WM_THEME_SETTINGS_SKIN, array_merge( $options_new, $options_old ) );

					//Delete the old option when we upgraded
						delete_option( WM_THEME_SETTINGS . '-skin' );
				}
		}
	} // /wm_update_legacy_options



	/**
	 * Theme installation
	 *
	 * @since    1.0
	 * @version  1.9.3
	 */
	if ( ! function_exists( 'wm_install' ) ) {
		function wm_install() {

			//Helper variables
				global $content_width, $wp_customize;

				$coeficient = apply_filters( 'wmhook_wm_install_image_sizes_coeficient', 1 );

				//Mobile image width is half the content width, but max $mobile_width_max
					$mobile_width_max = absint( apply_filters( 'wmhook_wm_install_image_sizes_mobile_width_max', 520 ) );
					$mobile_width     = apply_filters( 'wmhook_wm_install_image_sizes_mobile_width', min( absint( $content_width / 2 ), $mobile_width_max ) );

				//Image ratios
					$image_sizes = array(
							'content-width' => array(
								//Landscape
									'ratio-11'  => array( $content_width * $coeficient, $content_width * $coeficient ),
									'ratio-43'  => array( $content_width * $coeficient, floor( 3 * $content_width * $coeficient / 4 ) ),
									'ratio-32'  => array( $content_width * $coeficient, floor( 2 * $content_width * $coeficient / 3 ) ),
									'ratio-169' => array( $content_width * $coeficient, floor( 9 * $content_width * $coeficient / 16 ) ),
									'ratio-21'  => array( $content_width * $coeficient, floor( $content_width * $coeficient / 2 ) ),
									'ratio-31'  => array( $content_width * $coeficient, floor( $content_width * $coeficient / 3 ) ),
								//Portrait
									'ratio-34'  => array( $content_width * $coeficient, floor( 4 * $content_width * $coeficient / 3 ) ),
									'ratio-23'  => array( $content_width * $coeficient, floor( 3 * $content_width * $coeficient / 2 ) ),
								),
							'mobile' => array(
								//Landscape
									'ratio-11'  => array( $mobile_width * $coeficient, $mobile_width * $coeficient ),
									'ratio-43'  => array( $mobile_width * $coeficient, intval( 3 * $mobile_width * $coeficient / 4 ) ),
									'ratio-32'  => array( $mobile_width * $coeficient, intval( 2 * $mobile_width * $coeficient / 3 ) ),
									'ratio-169' => array( $mobile_width * $coeficient, intval( 9 * $mobile_width * $coeficient / 16 ) ),
									'ratio-21'  => array( $mobile_width * $coeficient, intval( $mobile_width * $coeficient / 2 ) ),
									'ratio-31'  => array( $mobile_width * $coeficient, intval( $mobile_width * $coeficient / 3 ) ),
								//Portrait
									'ratio-34'  => array( $mobile_width * $coeficient, intval( 4 * $mobile_width * $coeficient / 3 ) ),
									'ratio-23'  => array( $mobile_width * $coeficient, intval( 3 * $mobile_width * $coeficient / 2 ) ),
								)
						);
					$image_sizes = apply_filters( 'wmhook_wm_install_image_sizes', $image_sizes );

				//WordPress visual editor CSS stylesheets
					$visual_editor_css = array();
					if ( wm_google_fonts() ) {
						$http = ( is_ssl() ) ? ( 'https:' ) : ( 'http' );
						$visual_editor_css[] = esc_url_raw( str_replace( ',', '%2C', $http . '://fonts.googleapis.com/css' . wm_google_fonts() ) );
					}
					$visual_editor_css[] = get_option( WM_THEME_SETTINGS_PREFIX . WM_THEME_SHORTNAME . '-ve-css' );
					$visual_editor_css   = apply_filters( 'wmhook_wm_install_visual_editor_css', array_filter( $visual_editor_css ) );

			/**
			 * Localization
			 *
			 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
			 */

				//wp-content/languages/theme-name/it_IT.mo
					load_theme_textdomain( 'mustang-lite', trailingslashit( WP_LANG_DIR ) . 'themes/' . WM_THEME_SHORTNAME );

				//wp-content/themes/child-theme-name/languages/it_IT.mo
					load_theme_textdomain( 'mustang-lite', get_stylesheet_directory() . '/languages' );

				//wp-content/themes/theme-name/languages/it_IT.mo
					load_theme_textdomain( 'mustang-lite', get_template_directory() . '/languages' );

			// Declare support for child theme stylesheet automatic enqueuing

				add_theme_support( 'child-theme-stylesheet' );

			// Title tag

				/**
				 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
				 */
				add_theme_support( 'title-tag' );

			//Visual editor styles
				add_editor_style( $visual_editor_css );

			//Feed links
				add_theme_support( 'automatic-feed-links' );

			//Enable HTML5 markup
				add_theme_support( 'html5', array(
						'comment-list',
						'comment-form',
						'search-form',
						'gallery',
						'caption',
					) );

			//Post formats
				add_theme_support( 'post-formats', apply_filters( 'wmhook_wm_install_post_formats', array(
						'audio',
						'gallery',
						'link',
						'quote',
						'status',
						'video',
					) ) );

			//Custom menus
				register_nav_menus( apply_filters( 'wmhook_wm_install_menus', array(
						'main' => __( 'Main navigation', 'mustang-lite' ),
					) ) );

			//Custom header and background (do not integrate yet...)
				// add_theme_support( 'custom-header' );
				// add_theme_support( 'custom-background' );

			//Thumbnails support
				add_theme_support( 'post-thumbnails' );

				//Get image ratios from theme options
					$create_images = array_filter( array(
							wm_option( 'skin-image-posts' ),
							wm_option( 'skin-image-blog' ),
							wm_option( 'skin-image-gallery' ),
						) );
					if ( empty( $create_images ) ) {
						$create_images = array( WM_DEFAULT_IMAGE_SIZE );
					}
					$create_images = array_unique( $create_images );
					$create_images = apply_filters( 'wmhook_wm_install_image_sizes', $create_images );

				//Add image sizes (x, y, crop)
					add_image_size( 'full-hd', 1920, 9999, false );
					add_image_size( 'admin-thumbnail', 100, 100, true );
					add_image_size( 'content-width', $content_width * $coeficient, 9999, false );
					add_image_size( 'mobile', $mobile_width * $coeficient, 9999, false );
					foreach ( $create_images as $ratio ) {
						add_image_size( $ratio, $image_sizes['content-width'][$ratio][0], $image_sizes['content-width'][$ratio][1], true );
						add_image_size( 'mobile-' . $ratio, $image_sizes['mobile'][$ratio][0], $image_sizes['mobile'][$ratio][1], true );
					}

			//Run theme installation
				if ( ! get_option( WM_THEME_SETTINGS_INSTALL ) ) {
					/**
					 * Theme installation: Step 1
					 */
					update_option( WM_THEME_SETTINGS_INSTALL, 1 );

					do_action( 'wmhook_wm_install_step_1' );
				}

				/**
				 * Theme installation: Step 2
				 *
				 * This step is hooked onto WebMan Amplifier plugin activation.
				 */

				/**
				 * Theme installation: Step 3
				 */
				if (
						2 === absint( get_option( WM_THEME_SETTINGS_INSTALL ) )
						&& get_option( WM_THEME_SETTINGS_SKIN )
					) {

					//Generate global CSS file
						if ( wm_generate_main_css() ) {
							update_option( WM_THEME_SETTINGS_INSTALL, 3 );
							wm_generate_rtl_css();
							wm_generate_ve_css();

							//Save default skin path
								update_option( WM_THEME_SETTINGS_PREFIX . WM_THEME_SHORTNAME . '-skins', array_unique( array( WM_SKINS, WM_SKINS_CHILD ) ) );
						}

					//Save theme version number in DB
						update_option( WM_THEME_SETTINGS_VERSION, WM_THEME_VERSION );

					do_action( 'wmhook_wm_install_step_3' );

				}

		}
	} // /wm_install



	/**
	 * Apply default theme options
	 *
	 * This function must run after WebMan Amplifier is active!
	 *
	 * @since    1.0
	 * @version  1.8.2
	 */
	if ( ! function_exists( 'wm_default_setup' ) ) {
		function wm_default_setup() {

			// Processing

				/**
				 * Theme installation: Step 2
				 */
				if ( 2 > absint( get_option( WM_THEME_SETTINGS_INSTALL ) ) ) {
					$file_path = WM_SKINS . 'default.php';

					if ( file_exists( $file_path ) ) {
						$replacements = (array) apply_filters( 'wmhook_generate_css_replacements', array() );

						$skin_json = '';
						include_once $file_path;

						$skin_json = strtr( $skin_json, $replacements );
						$skin_json = json_decode( trim( $skin_json ), true );

						update_option( WM_THEME_SETTINGS_SKIN, $skin_json );
						update_option( WM_THEME_SETTINGS_INSTALL, 2 );

						do_action( 'wmhook_wm_install_step_2' );
					}
				}

		}
	} // /wm_default_setup





/**
 * 40) Assets and design
 */

	/**
	 * Registering theme styles and scripts
	 *
	 * @since    1.0
	 * @version  1.9.3
	 */
	if ( ! function_exists( 'wm_register_assets' ) ) {
		function wm_register_assets() {
			//Helper variables
				$wp_upload_dir    = wp_upload_dir();
				$theme_upload_dir = trailingslashit( $wp_upload_dir['basedir'] . get_option( 'wm-' . WM_THEME_SHORTNAME . '-files' ) );
				$dev_suffix       = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? ( '.dev' ) : ( '' );

				$stylesheets = array(
						'global' => ( ! file_exists( $theme_upload_dir . 'global.css' ) || isset( $_GET['__fallback'] ) ) ? ( wm_get_stylesheet_directory_uri( 'assets/css/__fallback.css' ) ) : ( str_replace( array( 'http:', 'https:', '.css' ), array( '', '', $dev_suffix . '.css' ), get_option( WM_THEME_SETTINGS_PREFIX . WM_THEME_SHORTNAME . '-css' ) ) ),
						'rtl'    => ( ! file_exists( $theme_upload_dir . 'global-rtl.css' ) ) ? ( '' ) : ( str_replace( array( 'http:', 'https:', '.css' ), array( '', '', $dev_suffix . '.css' ), get_option( WM_THEME_SETTINGS_PREFIX . WM_THEME_SHORTNAME . '-rtl-css' ) ) ),
						'main'   => get_stylesheet_directory_uri() . '/style.css',
						'print'  => wm_get_stylesheet_directory_uri( 'assets/css/print.css' ),
					);
				if ( ! $stylesheets['global'] ) {
					$stylesheets['global'] = get_stylesheet_directory_uri() . '/style.css';
				}
				$stylesheets = apply_filters( 'wmhook_wm_register_assets_stylesheets', $stylesheets );

			/**
			 * Styles
			 */

				$http = ( is_ssl() ) ? ( 'https:' ) : ( 'http' );

				$register_styles = apply_filters( 'wmhook_wm_register_assets_register_styles', array(
					//Frontend
						'stylesheet'            => array(
								'src'  => $stylesheets['main'],
								'deps' => array( 'stylesheet-global' ),
							),
						'stylesheet-global'     => array( $stylesheets['global'] ),
						'stylesheet-global-rtl' => array(
								'src'  => $stylesheets['rtl'],
								'deps' => array( 'stylesheet-global' ),
							),
						'stylesheet-print'      => array(
								'src'   => $stylesheets['print'],
								'media' => 'print',
							),
					//Backend
						'wm-about'            => array( wm_get_stylesheet_directory_uri( 'library/assets/css/about.css' ) ),
						'wm-about-custom'     => ( file_exists( WM_SETUP_CHILD . 'about/about-custom.css' ) ) ? ( array( trailingslashit( get_stylesheet_directory_uri() ) . WM_SETUP_DIR . 'about/about-custom.css' ) ) : ( array( trailingslashit( get_template_directory_uri() ) . WM_SETUP_DIR . 'about/about-custom.css' ) ),
						'wm-about-rtl'        => array( wm_get_stylesheet_directory_uri( 'library/assets/css/rtl-about.css' ) ),
						'wm-admin'            => array( wm_get_stylesheet_directory_uri( 'library/assets/css/admin.css' ) ),
						'wm-admin-rtl'        => array( wm_get_stylesheet_directory_uri( 'library/assets/css/rtl-admin.css' ) ),
						'wm-admin-wc-rtl'     => array( wm_get_stylesheet_directory_uri( 'library/assets/css/rtl-admin-woocommerce.css' ) ),
						'wm-theme-customizer' => array( wm_get_stylesheet_directory_uri( 'library/assets/css/theme-customizer.css' ) ),
					//Google Fonts
						'wm-google-fonts' => array( esc_url_raw( $http . '://fonts.googleapis.com/css' . wm_google_fonts() ) ),
					), $stylesheets );

				foreach ( $register_styles as $handle => $atts ) {
					$src   = ( isset( $atts['src'] ) ) ? ( $atts['src'] ) : ( $atts[0] );
					$deps  = ( isset( $atts['deps'] ) ) ? ( $atts['deps'] ) : ( false );
					$ver   = ( isset( $atts['ver'] ) ) ? ( $atts['ver'] ) : ( WM_SCRIPTS_VERSION );
					$media = ( isset( $atts['media'] ) ) ? ( $atts['media'] ) : ( 'screen' );

					wp_register_style( $handle, $src, $deps, $ver, $media );
				}

			/**
			 * Scripts
			 */

				$register_scripts = array(
					//Frontend
						'wm-scripts-global' => array(
								'src'  => wm_get_stylesheet_directory_uri( 'assets/js/scripts-global.js' ),
								'deps' => array( 'jquery', 'imagesloaded' ),
							),
					//jQuery plugins
						'jquery-appear' => array( wm_get_stylesheet_directory_uri( 'assets/js/appear/jquery.appear.min.js' ) ),
						'jquery-prettyphoto' => array( wm_get_stylesheet_directory_uri( 'assets/js/prettyphoto/jquery.prettyPhoto.min.js' ) ),
					//Backend
						'wm-customizer' => array(
								'src'  => wm_get_stylesheet_directory_uri( 'library/assets/js/customizer.js' ),
								'deps' => array( 'customize-controls' ),
							),
						'wm-wp-admin' => array( wm_get_stylesheet_directory_uri( 'library/assets/js/wm-scripts.js' ) ),
					);

				$register_scripts = apply_filters( 'wmhook_wm_register_assets_register_scripts', $register_scripts );

				foreach ( $register_scripts as $handle => $atts ) {
					$src       = ( isset( $atts['src'] )       ) ? ( $atts['src']       ) : ( $atts[0]           );
					$deps      = ( isset( $atts['deps'] )      ) ? ( $atts['deps']      ) : ( array( 'jquery' )  );
					$ver       = ( isset( $atts['ver'] )       ) ? ( $atts['ver']       ) : ( WM_SCRIPTS_VERSION );
					$in_footer = ( isset( $atts['in_footer'] ) ) ? ( $atts['in_footer'] ) : ( true               );

					wp_register_script( $handle, $src, $deps, $ver, $in_footer );
				}

		}
	} // /wm_register_assets



	/**
	 * Frontend HTML head assets
	 *
	 * @since    1.0
	 * @version  1.5
	 */
	if ( ! function_exists( 'wm_site_assets' ) ) {
		function wm_site_assets() {
			//Helper variables
				$enqueue_styles = $enqueue_scripts = array();

			/**
			 * Styles
			 */

				//Google Fonts
					if ( wm_google_fonts() ) {
						$enqueue_styles[] = 'wm-google-fonts';
					}

				//Global stylesheet
					$enqueue_styles[] = 'stylesheet-global';

				//RTL
					if ( is_rtl() ) {
						$enqueue_styles[] = 'stylesheet-global-rtl';
					}

				//Print
					// $enqueue_styles[] = 'stylesheet-print';

				//Default theme/child theme style.css file
					$enqueue_styles[] = 'stylesheet';

				$enqueue_styles = apply_filters( 'wmhook_wm_site_assets_enqueue_styles', $enqueue_styles );

				foreach ( $enqueue_styles as $handle ) {
					wp_enqueue_style( $handle );
				}

			/**
			 * Styles - inline
			 */

				if (
						is_singular()
						&& $output = get_post_meta( get_the_id(), 'custom-css', true )
					) {
					$output = apply_filters( 'wmhook_wm_site_assets_inline_styles', "\r\n/* Custom singular styles */\r\n" . $output . "\r\n" );

					wp_add_inline_style( 'stylesheet', apply_filters( 'wmhook_esc_css', $output ) );
				}

			/**
			 * Scripts
			 */

				//PrettyPhoto lightbox
					if ( ! wm_option( 'skin-disable-lightbox' ) ) {
						$enqueue_scripts[] = 'jquery-prettyphoto';
					}

				//Masonry footer only if there are more widgets in footer than columns settings
					$footer_widgets = wp_get_sidebars_widgets();
					if (
							is_array( $footer_widgets )
							&& isset( $footer_widgets['footer-widgets'] )
							&& count( $footer_widgets['footer-widgets'] ) > absint( wm_option( 'skin-footer-widgets-layout' ) )
						) {
						$enqueue_scripts[] = 'jquery-masonry';
					}

				//Global theme scripts
					$enqueue_scripts[] = 'jquery-appear';
					$enqueue_scripts[] = 'wm-scripts-global';

				$enqueue_scripts = apply_filters( 'wmhook_wm_site_assets_enqueue_scripts', $enqueue_scripts );

				foreach ( $enqueue_scripts as $handle ) {
					wp_enqueue_script( $handle );
				}

				//Put comments reply scripts into footer
					if (
							is_singular()
							&& comments_open()
							&& get_option( 'thread_comments' )
						) {
						wp_enqueue_script( 'comment-reply', false, false, false, true );
					}

		}
	} // /wm_site_assets



	/**
	 * Get Google Fonts link
	 *
	 * @since    1.0
	 * @version  1.8.2
	 */
	if ( ! function_exists( 'wm_google_fonts' ) ) {
		function wm_google_fonts() {

			// Helper variables

				$output = array();
				$subset = wm_option( 'skin-font-subset' );

				$fonts_sections = array(
					wm_option( 'skin-font-body' ),
					wm_option( 'skin-font-headings' )
				);

				if (
					! wm_option( 'skin-logo' )
					&& wm_option( 'skin-font-logo' )
				) {
					$fonts_sections[] = wm_option( 'skin-font-logo' );
				}

				$fonts_sections = array_unique( array_filter( (array) apply_filters( 'wmhook_wm_google_fonts_sections', $fonts_sections ) ) );


			// Processing

				foreach ( $fonts_sections as $section ) {
					if ( $font = trim( $section ) ) {
						$output[] = str_replace( ' ', '+', $font );
					}
				}

				$output = implode( '|', array_unique( $output ) );

				if ( $output ) {
					$output = '?family=' . $output;
					if ( is_array( $subset ) ) {
						$output .= '&amp;subset=' . esc_attr( implode( ',', $subset ) );
					} elseif ( $subset ) {
						$output .= '&amp;subset=' . esc_attr( (string) $subset );
					}
				}

				/**
				 * All of the above will return a string such as:
				 * ?family=Alegreya+Sans:300,400|Exo+2:400,700|Allan&subset=latin,latin-ext
				 */


			// Output

				return apply_filters( 'wmhook_wm_google_fonts_output', $output );

		}
	} // /wm_google_fonts



	/**
	 * HTML Body classes
	 *
	 * @since    1.0
	 * @version  1.9.1
	 *
	 * @param  array $classes
	 */
	if ( ! function_exists( 'wm_body_classes' ) ) {
		function wm_body_classes( $classes ) {
			//Helper variables
				global $post, $paged, $page;

				$paginated = max( absint( $page ), absint( $paged ) );
				$body_classes = array();
				$post_id      = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );

				//WooCommerce support
					$wc_shop = false;
					if ( function_exists( 'wm_is_woocommerce' ) && is_shop() ) {
						$post_id = wc_get_page_id( 'shop' );
						$wc_shop = true;
					}

			//Preparing output
				//Website layout
					$body_classes[0] = trim( wm_option( 'skin-layout' ) );

					if (
							(
								( ! is_search() && ! is_archive() )
								|| $wc_shop
							)
							&& ( function_exists( 'wma_meta_option' ) && wma_meta_option( 'layout', $post_id ) )
						) {
						$body_classes[0]  = trim( wma_meta_option( 'layout', $post_id ) );
						$body_classes[10] = 'post-meta-layout';
					}

					if ( wm_no_header_footer() ) {
						$body_classes[0] = 'fullwidth';
					}

				//Topbar
					if ( ! apply_filters( 'wmhook_disable_header', false ) ) {
						if ( is_active_sidebar( 'topbar' ) ) {
							$body_classes[20] = 'topbar-enabled';
						}
						if ( is_active_sidebar( 'topbar-extra' ) && ! apply_filters( 'wmhook_wm_section_topbar_extra_disable', false ) ) {
							$body_classes[30] = 'topbar-extra-enabled';
						}
					}

				//Header layout
					if ( wm_option( 'skin-header-sticky' ) ) {
						$body_classes[40] = 'sticky-header';
						$body_classes[50] = 'sticky-header-global';
					}

				//Slider type
					if (
							function_exists( 'wma_meta_option' ) && wma_meta_option( 'slider', $post_id )
							&& 2 > $paginated
						) {
						$body_classes[40] = 'sticky-header';
						$body_classes[60] = 'slider-enabled slider-fade-out slider-type-' . wma_meta_option( 'slider', $post_id );
					}

				//One page layout
					if ( is_page_template( 'page-template/one-page.php' ) ) {
						$body_classes[40] = 'sticky-header';
						$body_classes[70] = 'one-page-layout';
					}

				//Full posts
					if ( apply_filters( 'wmhook_enable_blog_full_posts', false ) && is_home() ) {
						$body_classes[80] = 'list-articles-full';
					} else {
						$body_classes[80] = 'list-articles-short';
					}

				//Theme lightbox used
					if ( ! wm_option( 'skin-disable-lightbox' ) ) {
						$body_classes[90] = 'theme-lightbox-enabled';
					}

				//Requirements check
				//Premature output if WebMan Amplifier not used
					if ( ! function_exists( 'wma_meta_option' ) ) {
						$body_classes = apply_filters( 'wmhook_wm_body_classes_output', $body_classes );
						$classes      = array_merge( $classes, $body_classes );

						asort( $classes );

						return $classes;
					}

				//No sidebar on blog and archives
					if (
							( is_home() && 'none' == wma_meta_option( 'sidebar', $post_id ) )
							|| ( is_page_template( 'home.php' ) && 'none' == wma_meta_option( 'sidebar', $post_id ) )
							|| ( is_archive() && apply_filters( 'wmhook_archive_disable_sidebar', false ) )
						) {
						$body_classes[100] = 'no-sidebar';
					}

				//bbPress support
					if (
							function_exists( 'wm_is_bbpress' )
							&& bbp_is_single_topic()
							&& apply_filters( 'wmhook_enable_large_topic', true )
						) {
						$body_classes[130] = 'bbpress-large-topic';
					}

				//Page layout
					if ( wma_meta_option( 'sidebar' ) ) {
						$body_classes[140] = 'page-layout-' . wma_meta_option( 'sidebar' );
					}

				//Responsiveness
					$body_classes[150] = 'responsive-design';

			//Output
				$body_classes = apply_filters( 'wmhook_wm_body_classes_output', $body_classes );
				$classes      = array_merge( $classes, $body_classes );

				asort( $classes );

				return $classes;
		}
	} // /wm_body_classes





/**
 * 50) Website sections markup
 */

	/**
	 * Remove header and footer condition
	 *
	 * @since  1.1
	 */
	if ( ! function_exists( 'wm_no_header_footer' ) ) {
		function wm_no_header_footer() {
			return is_page_template( 'page-template/blank.php' );
		}
	} // /wm_no_header_footer



		/**
		 * Force page layout
		 *
		 * @since  1.1
		 */
		if ( ! function_exists( 'wm_force_page_layout' ) ) {
			function wm_force_page_layout( $output, $name, $post_id ) {
				//Preparing output
					if (
							'sidebar' === $name
							&& wm_no_header_footer()
						) {
						$output = 'sections';
					}

				//Output
					return apply_filters( 'wmhook_wm_force_page_layout_output', $output );
			}
		} // /wm_force_page_layout



	/**
	 * Website DOCTYPE
	 */
	if ( ! function_exists( 'wm_doctype' ) ) {
		function wm_doctype() {
			//Helper variables
				$output = '<!doctype html>';

			//Output
				echo apply_filters( 'wmhook_wm_doctype_output', $output );
		}
	} // /wm_doctype



	/**
	 * Website HEAD
	 *
	 * @since    1.1
	 * @version  1.5
	 */
	if ( ! function_exists( 'wm_head' ) ) {
		function wm_head() {
			//Helper variables
				$output = array();

			//Preparing output
				$output[10] = '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';

				// $output[20] = apply_filters( 'wmhook_meta_author', '<meta name="author" content="WebMan, ' . WM_DEVELOPER_URL . '" />' );
				$output[30] = '<link rel="profile" href="http://gmpg.org/xfn/11" />';
				$output[40] = '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />';

				//Filter output array
					$output = apply_filters( 'wmhook_wm_head_output_array', $output );

			//Output
				echo apply_filters( 'wmhook_wm_head_output', implode( "\r\n\t", $output ) );
		}
	} // /wm_head



	/**
	 * Section inner wrappers
	 */
	if ( ! function_exists( 'wm_section_inner_wrappers' ) ) {
		function wm_section_inner_wrappers() {
			//Helper variables
				$output = '<div class="wrap-inner"><div class="pane twelve">';

			//Output
				return apply_filters( 'wm_section_inner_wrappers_output', $output );
		}
	} // /wm_section_inner_wrappers



		/**
		 * Section inner wrappers - close
		 */
		if ( ! function_exists( 'wm_section_inner_wrappers_close' ) ) {
			function wm_section_inner_wrappers_close() {
				//Helper variables
					$output = '</div></div>';

				//Output
					return apply_filters( 'wm_section_inner_wrappers_close_output', $output );
			}
		} // /wm_section_inner_wrappers_close



	/**
	 * Body top
	 */
	if ( ! function_exists( 'wm_body_top' ) ) {
		function wm_body_top() {
			//Helper variables
				$output = '<div class="website-container">' . "\r\n";

			//Output
				echo apply_filters( 'wmhook_wm_body_top_output', $output );
		}
	} // /wm_body_top



		/**
		 * Body bottom
		 */
		if ( ! function_exists( 'wm_body_bottom' ) ) {
			function wm_body_bottom() {
				//Helper variables
					$output = "\r\n" . '</div> <!-- /website-container -->' . "\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_body_bottom_output', $output );
			}
		} // /wm_body_bottom



	/**
	 * Topbar
	 */
	if ( ! function_exists( 'wm_section_topbar' ) ) {
		function wm_section_topbar() {
			//Helper variables
				$output = $widgets = '';

				$widget_area_atts = apply_filters( 'wmhook_wm_section_topbar_widget_area_atts', array(
						'max_widgets_count' => 4,
						'sidebar'           => 'topbar',
					) );

				if ( function_exists( 'wma_sidebar' ) ) {
					$widgets = wma_sidebar( $widget_area_atts );
				}

			//Preparing output
				if ( $widgets ) {
					$output .= '<div id="topbar" class="topbar wrap clearfix topbar-basic">';
						$output .= apply_filters( 'wmhook_section_inner_wrappers', '' );
						$output .= wm_accessibility_skip_link( 'to_navigation' );
						$output .= $widgets;
						$output .= apply_filters( 'wmhook_section_inner_wrappers_close', '' );
					$output .= "\r\n" . '</div>' . "\r\n";
				}

			//Output
				echo apply_filters( 'wmhook_wm_section_topbar_output', $output );
		}
	} // /wm_section_topbar



		/**
		 * Topbar extra
		 *
		 * For SEO purposes it would be better to place it just before the footer in DOM.
		 * Just like it was originally meant to be. However, moved to top to retain the
		 * smooth responsiveness of the theme.
		 */
		if ( ! function_exists( 'wm_section_topbar_extra' ) ) {
			function wm_section_topbar_extra() {
				//Requirements check
					if ( apply_filters( 'wmhook_wm_section_topbar_extra_disable', false ) ) {
						return;
					}

				//Helper variables
					$output = $widgets = '';

					$widget_area_atts = apply_filters( 'wmhook_wm_section_topbar_extra_widget_area_atts', array(
							'class'             => 'widget-area widget-columns',
							'max_widgets_count' => 5,
							'sidebar'           => 'topbar-extra',
						) );

					if ( function_exists( 'wma_sidebar' ) ) {
						$widgets = wma_sidebar( $widget_area_atts );
					}

				//Preparing output
					if ( $widgets ) {
						$output .= '<section id="topbar-extra" class="topbar-extra wrap clearfix">';
							$output .= apply_filters( 'wmhook_section_inner_wrappers', '' );
							$output .= $widgets;
							$output .= apply_filters( 'wmhook_section_inner_wrappers_close', '' );
							$output .= '<a href="#topbar-extra" class="topbar-extra-switch no-scroll-link">' . apply_filters( 'wmhook_wm_section_topbar_extra_switch', '<span class="screen-reader-text">' . __( 'Open extra topbar', 'mustang-lite' ) . '</span>' ) . '</a>';
						$output .= "\r\n" . '</section>' . "\r\n";
					}

				//Output
					echo apply_filters( 'wmhook_wm_section_topbar_extra_output', $output );
			}
		} // /wm_section_topbar_extra



	/**
	 * Header top
	 */
	if ( ! function_exists( 'wm_section_header_top' ) ) {
		function wm_section_header_top() {
			//Preparing output
				$output  = "\r\n\r\n";
				$output .= ( wm_option( 'skin-header-sticky' ) ) ? ( '<header class="header-wrapper"><div id="header" class="header wrap clearfix">' . "\r\n" ) : ( '<header id="header" class="header wrap clearfix">' . "\r\n" );
				$output .= apply_filters( 'wmhook_section_inner_wrappers', '' );
				$output .= '<div class="header-container clearfix">';

			//Output
				echo apply_filters( 'wmhook_wm_section_header_top_output', $output );
		}
	} // /wm_section_header_top



		/**
		 * Header bottom
		 */
		if ( ! function_exists( 'wm_section_header_bottom' ) ) {
			function wm_section_header_bottom() {
				//Helper variables
					$output  = '</div>';
					$output .= apply_filters( 'wmhook_section_inner_wrappers_close', '' );
					$output .= ( wm_option( 'skin-header-shadow' ) ) ? ( '<img src="' . wm_get_stylesheet_directory_uri( 'assets/img/shadow-bottom.png' ) . '" alt="" class="header-shadow" />' ) : ( '' );
					$output .= ( wm_option( 'skin-header-sticky' ) ) ? ( "\r\n" . '</div></header>' . "\r\n" ) : ( "\r\n" . '</header>' . "\r\n" );

				//Output
					echo apply_filters( 'wmhook_wm_section_header_bottom_output', $output );
			}
		} // /wm_section_header_bottom



		/**
		 * Search form
		 */
		if ( ! function_exists( 'wm_header_search_form' ) ) {
			function wm_header_search_form() {
				//Preparing output
					$output = '<div id="search-container" class="menu-search-form">' . get_search_form( false ) . '<a href="#search-container" class="form-close search-form-close-switch no-scroll-link"><span class="screen-reader-text">' . __( 'Close search form', 'mustang-lite' ) . '</span></a></div>';

				//Output
					echo apply_filters( 'wmhook_wm_header_search_form_output', $output );
			}
		} // /wm_header_search_form



	/**
	 * Navigation
	 *
	 * @version  1.9.3
	 */
	if ( ! function_exists( 'wm_section_navigation' ) ) {
		function wm_section_navigation() {
			//Helper variables
				$output = $navigation = '';

				if ( function_exists( 'wma_meta_option' ) ) {
					$navigation = wma_meta_option( 'navigation' );
				}

				$args = array(
						'theme_location' => 'main',
						'container'      => false,
						'echo'           => false,
						'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
					);
				if ( $navigation ) {
					$args['menu'] = $navigation;
				}
				$args = apply_filters( 'wmhook_wm_section_navigation_args', $args );

			//Preparing output
				$output .= '<nav id="nav-main" class="nav-main clearfix">';
				$output .= wm_accessibility_skip_link( 'to_content' );
				$output .= wp_nav_menu( $args );
				$output .= '</nav>';
				$output .= '<a href="#nav-main" id="mobile-nav" class="mobile-nav"><span class="screen-reader-text">' . __( 'Menu', 'mustang-lite' ) . '</span></a>';

			//Output
				echo apply_filters( 'wmhook_wm_section_navigation_output', $output );
		}
	} // /wm_section_navigation



		/**
		 * Navigation addons
		 *
		 * @since    1.0
		 * @version  1.7
		 */
		if ( ! function_exists( 'wm_navigation_special' ) ) {
			function wm_navigation_special() {
				//Requirements check
					if (
							apply_filters( 'wmhook_wm_navigation_special_disable', false )
							|| (
								is_page_template( 'page-template/one-page.php' )
								&& apply_filters( 'wmhook_wm_navigation_special_one_page_disable', false )
							)
						) {
						return;
					}

				//Helper variables
					$output     = array();
					$custom_nav = '';

					if ( function_exists( 'wma_meta_option' ) ) {
						$custom_nav = wma_meta_option( 'navigation' );
					}

				//Preparing output
						//WooCommerce support
							if ( function_exists( 'wm_is_woocommerce' ) ) {
								$output[10] = apply_filters( 'wmhook_wm_navigation_special_cart', '<li id="menu-cart" class="menu-cart"><a href="' . get_permalink( wc_get_page_id( 'cart' ) ) . '"><span class="screen-reader-text">' . __( 'Show cart', 'mustang-lite' ) . '</span></a></li>', $custom_nav );
							}

						//Search button
							$output[20] = apply_filters( 'wmhook_wm_navigation_special_search', '<li id="menu-search" class="menu-search"><a href="#search-container" class="menu-search-switch no-scroll-link"><span class="screen-reader-text">' . __( 'Search', 'mustang-lite' ) . '</span></a></li>', $custom_nav );

						//Allow filtering the output array
							$output = implode( '', (array) apply_filters( 'wmhook_wm_navigation_special_output_array', $output, $custom_nav ) );

					//Wrapping output
						if ( $output ) {
							$output = '<div id="navigation-special" class="navigation-special nav-main"><ul>' . $output . '</ul></div>';
						}

				//Output
					echo apply_filters( 'wmhook_wm_navigation_special_output', $output, $custom_nav );
			}
		} // /wm_navigation_special



		/**
		 * Navigation item classes
		 *
		 * This is global for all menus, not just main navigation.
		 *
		 * @since    1.0
		 * @version  1.3
		 *
		 * @param  array  $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param  object $item    The current menu item.
		 * @param  array  $args    An array of wp_nav_menu() arguments.
		 * @param  int    $depth   Depth of menu item. Used for padding. Since WordPress 4.1.
		 */
		if ( ! function_exists( 'wm_nav_item_classes' ) ) {
			function wm_nav_item_classes( $classes, $item, $args, $depth = 0 ) {
				//Requirements check
					if ( ! isset( $item->title ) ) {
						return $classes;
					}

				//Preparing output
					$classes = implode( ' ', $classes );

					//Icon class
						$classes = str_replace( array( 'icon-', 'iconwm-' ), 'iconmenu-', $classes );

					//General class for active menu
						if (
								false !== strpos( $classes, 'current-menu' )
								// || false !== strpos( $classes, 'current_page' )
							) {
							$classes .= ' active-menu-item';
						}

					//Class if description text used
						if (
									trim( $item->post_content )
									&& $item->menu_item_parent
								) {
									$classes .= ' menu-entry-content-container';
							}

					//Empty item (value of "-" is considered being empty)
						if ( ! trim( str_replace( '-', '', $item->title ) ) ) {
							$classes .= ' empty-menu-item';
						}

					$classes = explode( ' ', $classes );

				//Output
					return $classes;
			}
		} // /wm_nav_item_classes



		/**
		 * Navigation item position classes
		 */
		if ( ! function_exists( 'wm_nav_item_position_class' ) ) {
			function wm_nav_item_position_class( $items ) {
				//Preparing output
					$items[1]->classes[] = 'menu-item-first';

				//Output
					return $items;
			}
		} // /wm_nav_item_position_class



		/**
		 * Navigation item improvements
		 *
		 * @since    1.0
		 * @version  1.5.2
		 */
		if ( ! function_exists( 'wm_nav_item_process' ) ) {
			function wm_nav_item_process( $item_output, $item, $depth, $args ) {

				// Requirements check

					if (
							! is_object( $args )
							|| ! isset( $args->theme_location )
							|| 'main' !== $args->theme_location
							|| ! isset( $item->title )
						) {
						return $item_output;
					}


				// Helper variables

					$classes       = 'inner';
					$allowed_tags  = apply_filters( 'wmhook_wm_nav_item_process_allowed_tags', '<br><code><em><i><img><mark><span><strong>' );
					$classes_array = (array) $item->classes;


				// Processing

					// Get font icon class if applied

						foreach ( $classes_array as $class ) {
							if ( 0 === strpos( $class, 'icon-' ) || 0 === strpos( $class, 'iconwm-' ) ) {
								$classes .= ' ' . $class;
							}
						}

					// Link and title processing

						if (
								'#' !== $item->url
								&& 2 > strlen( str_replace( array( 'http://', 'https://' ), '', $item->url ) )
							) {

							// Replacing link tag with span.inner if no url set

								$item_output = '<span class="' . $classes . '">' . strip_tags( $item_output, $allowed_tags ) . '</span>';

							// Remove link or span.inner for empty menu titles (value of "-" is considered being empty)

								if ( ! trim( str_replace( '-', '', $item->title ) ) ) {
									$item_output = '';
								}

						} else {

							// Applying classes on menu item link

								$item_output = str_replace( '<a ', '<a class="' . trim( $classes ) . '" ', $item_output );

						}

					// Display item description (overwrites the item title)

						if (
								trim( $item->post_content )
								&& 0 < $depth
							) {

								$item_output = '<div class="menu-entry-content inner">' . apply_filters( 'wmhook_content_filters', trim( $item->post_content ) ) . '</div>';

						}


				// Output

					return $item_output;

			}
		} // /wm_nav_item_process



	/**
	 * Slider
	 *
	 * @since    1.0
	 * @version  1.9.3
	 */
	if ( ! function_exists( 'wm_section_slider' ) ) {
		function wm_section_slider() {
			//Helper variables
				global $paged, $page;

				$paginated = max( absint( $page ), absint( $paged ) );

				$output      = $slider_width = $image_title = $image_caption = $image_link = '';
				$page_id     = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
				$slider_type = 'none';
				$image_size  = apply_filters( 'wmhook_wm_section_slider_image_size', 'full-hd' );

				//WooCommerce support
					$wc_shop = false;
					if ( function_exists( 'wm_is_woocommerce' ) && is_shop() ) {
						$page_id = wc_get_page_id( 'shop' );
						$wc_shop = true;
					}

			//Requirements check
				if (
						( ! is_singular( 'page' ) && ! is_home() && ! $wc_shop ) //check for singular pages; WooCommerce support
						|| 1 < $paginated
					) {
					return;
				}

			//Slider type
				if (
						function_exists( 'wma_meta_option' )
						&& wma_meta_option( 'slider', $page_id )
					) {
					//Custom, per page slider setup
					$slider_type = wma_meta_option( 'slider', $page_id );
				} elseif (
						! function_exists( 'wma_meta_option' )
						&& is_front_page()
					) {
					//Slider on front page fallback
					$slider_type = 'static';
				}

				//Return, if no slider type selected
					if ( 'none' === $slider_type ) {
						return;
					}

			//Preparing output
				switch ( $slider_type ) {

					//Custom slider (use shortcodes)
						case 'custom':

							$output .= '<div class="custom-slider slider-content">';
							$output .= do_shortcode( wma_meta_option( 'slider-shortcode', $page_id ) );
							$output .= '</div>';

						break;

					//Static featured image
						case 'static':

							if ( has_post_thumbnail( $page_id ) ) {

								$attachment = get_post( get_post_thumbnail_id( $page_id ) );

								$image_title = $image_alt = $image_link = $image_caption = '';

								if (
										is_object( $attachment )
										&& isset( $attachment->post_title )
										&& isset( $attachment->post_excerpt )
									) {
									$image_title = apply_filters( 'wmhook_wm_section_slider_image_title', $attachment->post_title );
									$image_alt   = apply_filters( 'wmhook_wm_section_slider_image_alt',   $attachment->post_title );

									if ( function_exists( 'wma_meta_option' ) ) {
										$caption_pos = wma_meta_option( 'slider-static', $page_id );
									} else {
										$caption_pos = 'center';
									}
									$caption_pos = apply_filters( 'wmhook_wm_section_slider_caption_pos', $caption_pos );

									$image_caption = ( $attachment->post_excerpt ) ? ( '<div class="caption position-' . $caption_pos . '"><div class="wrap-inner"><div class="caption-table"><div class="caption-cell">' . $attachment->post_excerpt . '</div></div></div></div>' ) : ( '' );
									$image_caption = apply_filters( 'wmhook_wm_section_slider_image_caption', $image_caption );

									/**
									 * To use links on images, add a link tag into a description field of the image.
									 * The first link found in description field will be used as custom link for the image.
									 * The link must be in HTML format to allow WordPress users to easily add target attribute.
									 */
									$image_link = preg_match( '/<a(.*?)>(.*?)<\/a>/', trim( $attachment->post_content ), $matches );
									if ( isset( $matches[1] ) && $matches[1] ) {
										$image_link = '<a' . $matches[1] . '>';
									} else {
										$image_link = '';
									}
									$image_link = apply_filters( 'wmhook_wm_section_slider_image_link', $image_link );
								}

								$output .= '<div class="static-slider slider-content img-content">';
								$output .= $image_link;
								$output .= get_the_post_thumbnail( $page_id, $image_size, array( 'title' => esc_attr( $image_title ), 'alt' => esc_attr( $image_alt ) ) );
								if ( $image_link ) {
									$output .= '</a>';
								}
								$output .= $image_caption;
								$output .= '</div>';

							}

						break;

					//Default fallbacks
						case 'none':
						break;

						default:
						break;

				} // /switch

			//Output
				echo apply_filters( 'wmhook_wm_section_slider_output', "\r\n\r\n" . '<section id="slider" class="slider wrap clearfix slider-main-wrap">' . "\r\n" . $output . "\r\n" . '</section>' . "\r\n" );
		}
	} // /wm_section_slider



	/**
	 * Main heading (title)
	 *
	 * @since    1.0
	 * @version  1.9.1
	 *
	 * @param  array $args Heading setup arguments
	 */
	if ( ! function_exists( 'wm_section_heading' ) ) {
		function wm_section_heading( $args = array() ) {
			//Helper variables
				global $post, $page, $paged, $wp_query;

				$paginated = max( absint( $page ), absint( $paged ) );

				$blog_page_id = get_option( 'page_for_posts' );
				$page_id      = ( is_home() ) ? ( $blog_page_id ) : ( null );

				$disable_heading = false;
				if (
						(
							function_exists( 'wma_meta_option' )
							&& wma_meta_option( 'disable-heading', $page_id )
						)
						|| (
							! function_exists( 'wma_meta_option' )
							&& is_front_page()
						)
					) {
					$disable_heading = true;
				}

				//WooCommerce support
					$wc_shop = false;
					if ( function_exists( 'wm_is_woocommerce' ) ) {
						if ( is_woocommerce() || is_cart() || is_checkout() ) {
							$wc_shop = true;
						}
						if ( is_shop() ) {
							$page_id = wc_get_page_id( 'shop' );
						}
					}

				//Requirements check
					if (
							( is_home() && ! $blog_page_id )
							|| $disable_heading
						) {
						return;
					}

				$output = '';

				$defaults = array(
						'addons'  => '',
						'class'   => 'main-heading entry-header wrap clearfix',
						'link'    => get_permalink( $page_id ),
						'page_id' => $page_id,
						'paged'   => array( $paginated, absint( $paged ), absint( $page ) ),
						'output'  => "\r\n\r\n" . '<header id="main-heading" class="{class}">' . "\r\n" . apply_filters( 'wmhook_section_inner_wrappers', '' ) . '<{tag} class="entry-title"' . wm_schema_org( 'name' ) . '>{title}</{tag}>{addons}' . apply_filters( 'wmhook_section_inner_wrappers_close', '' ) . "\r\n" . '</header>' . "\r\n",
						'tag'     => 'h1',
						'title'   => ( 2 > $paginated ) ? ( get_the_title( $page_id ) ) : ( '<a href="' . get_permalink( $page_id ) . '">' . get_the_title( $page_id ) . '</a>' ),
					);

				//Link on tax, category and tag archive
					if ( is_tax() || is_category() || is_tag() ) {
						global $wp_query;
						$term = $wp_query->get_queried_object();
						$defaults['link'] = get_term_link( $term );
					} elseif ( is_archive() ) {
						$defaults['link'] = '';
					}

				$defaults = apply_filters( 'wmhook_wm_section_heading_defaults', $defaults );
				$args     = wp_parse_args( $args, $defaults );

			//Preparing output
				//Archives
					if ( is_day() ) {
						$args['title'] = sprintf( __( 'Daily Archives: <strong>%s</strong>', 'mustang-lite' ), get_the_date() );
					} elseif ( is_month() ) {
						$args['title'] = sprintf( __( 'Monthly Archives: <strong>%s</strong>', 'mustang-lite' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'mustang-lite' ) ) );
					} elseif ( is_year() ) {
						$args['title'] = sprintf( __( 'Yearly Archives: <strong>%s</strong>', 'mustang-lite' ), get_the_date( _x( 'Y', 'yearly archives date format', 'mustang-lite' ) ) );
					} elseif ( is_category() ) {
						$args['title'] = sprintf( __( 'Category Archives: <strong>%s</strong>', 'mustang-lite' ), single_cat_title( '', false ) );
					} elseif ( is_tag() ) {
						$args['title'] = sprintf( __( 'Tag Archives: <strong>%s</strong>', 'mustang-lite' ), single_tag_title( '', false ) );
					} elseif ( is_search() ) {
						$args['title'] = sprintf( __( 'Search Results for: <strong>%s</strong>', 'mustang-lite' ), get_search_query() );
					} elseif ( is_author() ) {
						$author = get_userdata( get_query_var( 'author' ) );
						$args['title'] = sprintf( __( '<strong>%s</strong> archives', 'mustang-lite' ), $author->display_name );
					} elseif ( is_tax() ) {
						$args['title'] = single_term_title( '', false );
					} elseif ( is_archive() ) {
						$args['title'] = __( 'Archives', 'mustang-lite' );
					}

					if ( is_category() || is_tag() || is_tax() ) {
						$term_description = term_description();
						if ( ! empty( $term_description ) ) {
							$args['addons'] .= sprintf( '<div class="taxonomy-description" title="%2$s">%1$s</div>',
									$term_description,
									esc_attr( sprintf( 'Description of "%s"', single_term_title( '', false ) ) )
								);
						}
					}

				//Single post
					if ( is_singular( 'post' ) && $blog_page_id ) {
						$args['title']  = '<a href="' . get_permalink( $blog_page_id ) . '">' . get_the_title( $blog_page_id ) . '</a>';
						$args['class']  = str_replace( ' entry-header', '', $args['class'] );
						$args['output'] = str_replace( ' class="entry-title"', '', $args['output'] );
					}

				//Parted article / pagination suffix
					if ( ! ( is_singular( 'post' ) && $blog_page_id ) ) {
						if ( 1 < $args['paged'][2] ) {
							$args['title'] = '<a href="' . $args['link'] . '">' . $args['title'] . '</a>' . wm_paginated_suffix( 'small' );
						} elseif ( 1 < $args['paged'][1] ) {
							$args['title'] .= wm_paginated_suffix( 'small' );
						}
					}

				//404 page
					if ( is_404() ) {
						$args['title']  = __( 'Error 404', 'mustang-lite' );
					}

				//bbPress support
					if ( function_exists( 'wm_is_bbpress' ) ) {
						if ( bbp_is_forum_archive() ) {
							$args['title'] = sprintf( __( '%s forums', 'mustang-lite' ), get_bloginfo( 'name' ) );
						}
						if ( bbp_is_single_forum() && ! bbp_is_forum_category() ) {
							$args['title'] = sprintf( __( 'Forum: %s', 'mustang-lite' ), $args['title'] );
						}
						if ( bbp_is_single_topic() ) {
							$args['title'] = sprintf( __( 'Topic: %s', 'mustang-lite' ), $args['title'] );
						}
					}

				//WooCommerce support
					if ( $wc_shop && ! is_tax() ) {
						$args['title'] = ( 2 > $paginated ) ? ( get_the_title( $page_id ) ) : ( '<a href="' . get_permalink( $page_id ) . '">' . get_the_title( $page_id ) . '</a>' );
						if ( is_search() ) {
							$args['title'] .= sprintf( __( ' / Results for: <strong>%s</strong>', 'mustang-lite' ), get_search_query() );
						}
					}

				//Addons
					$widget_area_atts = apply_filters( 'wmhook_wm_section_heading_widget_area_atts', array(
							'max_widgets_count' => 2,
							'sidebar'           => 'main-heading-widgets',
						) );
					$widget_area = '';

					if ( function_exists( 'wma_sidebar' ) ) {
						$widget_area = wma_sidebar( $widget_area_atts );
					}

					if ( $widget_area ) {
						$args['addons'] .= '<div class="main-heading-widgets">' . $widget_area . '</div>';
						$args['class']  .= ' has-widgets';
					}

				//Filter processed $args
					$args = apply_filters( 'wmhook_wm_section_heading_args', $args );

				//Generating output HTML
					$replacements = array(
							'{addons}' => do_shortcode( $args['addons'] ),
							'{class}'  => esc_attr( $args['class'] ),
							'{tag}'    => esc_attr( $args['tag'] ),
							'{title}'  => do_shortcode( $args['title'] ),
						);
					$output = strtr( $args['output'], $replacements );

			//Output
				echo apply_filters( 'wmhook_wm_section_heading_output', $output );
		}
	} // /wm_section_heading



		/**
		 * Post title heading
		 *
		 * @param  boolean $title Whether to display the title H1 tag.
		 */
		if ( ! function_exists( 'wm_post_title' ) ) {
			function wm_post_title( $title = true ) {
				//Helper variables
					$output    = '';
					$is_single = ( is_home() && wm_option( 'blog-full-posts' ) ) ? ( true ) : ( is_single() );
					$link      = array( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' );
					$suffix    = wm_paginated_suffix( 'small', 'post' );

					$top_meta    = apply_filters( 'wmhook_wm_post_title_top_meta', array(
							'class' => 'entry-meta entry-meta-categories clearfix',
							'meta'  => array( 'categories' )
						) );
					$bottom_meta = array(
							'meta' => array( 10 => 'date', 20 => 'author', 30 => 'comments' )
						);
					if ( function_exists( 'bawpvc_views_sc' ) ) {
						$bottom_meta['meta'][40] = 'views';
					}
					if ( function_exists( 'lip_love_it_link' ) || function_exists( 'zilla_likes' ) ) {
						$bottom_meta['meta'][50] = 'likes';
					}
					ksort( $bottom_meta['meta'] );
					$bottom_meta = apply_filters( 'wmhook_wm_post_title_bottom_meta', $bottom_meta );

				//Output
					$output .= '<header class="entry-header">';

						$output .= wm_post_meta( $top_meta );

						if ( $title ) {
							if ( $is_single ) {

								if ( ! $suffix && ! apply_filters( 'wmhook_enable_blog_full_posts', false ) ) {
									$link = array( '', '' );
								}
								$output .= the_title( '<h1 class="entry-title"' . wm_schema_org( 'name' ) . '>' . $link[0], $link[1] . $suffix . '</h1>', false );

							} else {

								$output .= the_title( '<h1 class="entry-title"' . wm_schema_org( 'name' ) . '>' . $link[0], $link[1] . '</h1>', false );

							}
						}

						$output .= wm_post_meta( $bottom_meta );

					$output .= '</header>';

			//Output
				echo apply_filters( 'wmhook_wm_post_title_output', $output );
			}
		} // /wm_post_title



	/**
	 * Content top
	 *
	 * @version  1.9.3
	 */
	if ( ! function_exists( 'wm_section_content_top' ) ) {
		function wm_section_content_top() {
			//Helper variables
				$output = "\r\n\r\n" . '<div id="content-section" class="content-section wrap clearfix"' . wm_schema_org( 'main_content' ) . '>' . "\r\n";

			//Output
				echo apply_filters( 'wmhook_wm_section_content_top_output', $output );
		}
	} // /wm_section_content_top



		/**
		 * Content bottom
		 */
		if ( ! function_exists( 'wm_section_content_bottom' ) ) {
			function wm_section_content_bottom() {
				//Helper variables
					$output = "\r\n" . '</div> <!-- /#content-section -->' . "\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_section_content_bottom_output', $output );
			}
		} // /wm_section_content_bottom



		/**
		 * Entry top
		 */
		if ( ! function_exists( 'wm_entry_top' ) ) {
			function wm_entry_top() {
				//Helper variables
					$output = '';

				//Preparing output
					if (
							is_home() && apply_filters( 'wmhook_enable_blog_full_posts', false )
							|| in_array( get_post_format(), array( 'link', 'quote', 'status' ) )
						) {
						$output .= '<div class="full-post-content">';
					}

				//Output
					echo apply_filters( 'wmhook_wm_entry_top_output', $output );
			}
		} // /wm_entry_top



		/**
		 * Entry bottom
		 */
		if ( ! function_exists( 'wm_entry_bottom' ) ) {
			function wm_entry_bottom() {
				//Helper variables
					$is_full_posts = ( is_home() && apply_filters( 'wmhook_enable_blog_full_posts', false ) );
					$is_single     = ( $is_full_posts ) ? ( true ) : ( is_singular( 'post' ) );

				//Post tags
					if ( $is_single ) {
						echo wm_post_meta( apply_filters( 'wmhook_wm_entry_bottom_meta', array(
								'class' => 'entry-meta entry-meta-bottom clearfix',
								'meta'  => array( 'tags' )
							) ) );
					}

				//Comments
					comments_template( null, true );

				//Preparing output
					if (
							$is_full_posts
							|| in_array( get_post_format(), array( 'link', 'quote', 'status' ) )
						) {
						echo '</div> <!-- /full-post-content -->';
					}
			}
		} // /wm_entry_bottom



	/**
	 * Footer
	 *
	 * @since    1.0
	 * @version  1.7
	 */
	if ( ! function_exists( 'wm_section_footer' ) ) {
		function wm_section_footer() {
			//Helper variables
				$output  = array();
				$post_id = null;

				//WooCommerce support
					if ( function_exists( 'wm_is_woocommerce' ) && is_shop() ) {
						$post_id = wc_get_page_id( 'shop' );
					}

			//Requirements check
				if (
						! function_exists( 'wma_meta_option' )
						|| 'none' === wma_meta_option( 'footer', $post_id )
					) {
					get_sidebar( 'footer' );
					return;
				}

			//Preparing output
				//Footer widgets
					if ( 'credits' !== wma_meta_option( 'footer', $post_id ) ) {
						$widget_area_atts = apply_filters( 'wmhook_wm_section_footer_widget_area_atts', array(
								'class'   => 'widget-area footer-widgets-container',
								'sidebar' => 'footer-widgets',
							) );
						$widget_area = '';

						if ( function_exists( 'wma_sidebar' ) ) {
							$widget_area = wma_sidebar( $widget_area_atts );
						}

						if ( $widget_area ) {
							$columns = absint( wm_option( 'skin-footer-widgets-layout' ) );

							//Count widgets for special class when no masonry applied
								$masonry_class  = ' masonry-disabled';
								$footer_widgets = wp_get_sidebars_widgets();
								if (
										is_array( $footer_widgets )
										&& isset( $footer_widgets['footer-widgets'] )
										&& count( $footer_widgets['footer-widgets'] )
										&& count( $footer_widgets['footer-widgets'] ) > absint( wm_option( 'skin-footer-widgets-layout' ) )
									) {
									$masonry_class  = ' masonry-enabled';
								}

							$output[10]  = "\r\n\r\n" . '<div class="footer-widgets clearfix columns-' . $columns . $masonry_class . '" data-columns="' . $columns . '">';
							$output[10] .= ( wm_option( 'skin-footer-shadow' ) ) ? ( '<img src="' . wm_get_stylesheet_directory_uri( 'assets/img/shadow-bottom.png' ) . '" alt="" class="footer-shadow" />' ) : ( '' );
							$output[10] .= apply_filters( 'wmhook_section_inner_wrappers', '' );
							$output[10] .= $widget_area;
							$output[10] .= apply_filters( 'wmhook_section_inner_wrappers_close', '' );
							$output[10] .= "\r\n" . '</div>' . "\r\n";
						}
					}

				//Credits
					if ( 'widgets' !== wma_meta_option( 'footer', $post_id ) ) {
						$output[20] = wm_credits();
					}

				//Top of page button
					$output[30] = '<a href="#top" class="top-of-page" title="' . __( 'Back to top of the page', 'mustang-lite' ) . '"></a>';

			//Output
				$output = apply_filters( 'wmhook_wm_section_footer_output', $output );
				echo implode( '', $output );
		}
	} // /wm_section_footer



		/**
		 * Footer top
		 *
		 * @since    1.0
		 * @version  1.7
		 */
		if ( ! function_exists( 'wm_section_footer_top' ) ) {
			function wm_section_footer_top() {
				//Helper variables
					$output  = '';
					$post_id = null;

					//WooCommerce support
						if ( function_exists( 'wm_is_woocommerce' ) && is_shop() ) {
							$post_id = wc_get_page_id( 'shop' );
						}

				//Requirements check
					if (
							! function_exists( 'wma_meta_option' )
							|| 'none' === wma_meta_option( 'footer', $post_id )
						) {
						return;
					}

				//Preparing output
					$output = "\r\n\r\n" . '<footer id="footer" class="footer wrap clearfix">' . "\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_section_footer_top_output', $output );
			}
		} // /wm_section_footer_top



		/**
		 * Footer bottom
		 *
		 * @since    1.0
		 * @version  1.7
		 */
		if ( ! function_exists( 'wm_section_footer_bottom' ) ) {
			function wm_section_footer_bottom() {
				//Helper variables
					$output  = '';
					$post_id = null;

					//WooCommerce support
						if ( function_exists( 'wm_is_woocommerce' ) && is_shop() ) {
							$post_id = wc_get_page_id( 'shop' );
						}

				//Requirements check
					if (
							! function_exists( 'wma_meta_option' )
							|| 'none' === wma_meta_option( 'footer', $post_id )
						) {
						return;
					}

				//Preparing output
					$output .= "\r\n" . '</footer>' . "\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_section_footer_bottom_output', $output );
			}
		} // /wm_section_footer_bottom



		/**
		 * Credits (copyright) text
		 */
		if ( ! function_exists( 'wm_credits' ) ) {
			function wm_credits() {
				//Helper variables
					$output = $copy_text = '';

					$widget_area_atts = apply_filters( 'wmhook_wm_credits_widget_area_atts', array(
							'class'             => 'widget-area clearfix',
							'max_widgets_count' => 3,
							'sidebar'           => 'credits',
						) );

					if ( function_exists( 'wma_sidebar' ) ) {
						$copy_text = wma_sidebar( $widget_area_atts );
					}

					if ( empty( $copy_text ) ) {
						$copy_text = '&copy; ' . get_bloginfo( 'name' );
					}

				//Preparing output
					$replacements = array(
						'(C)'  => '&copy;',
						'YEAR' => date( 'Y' ),
					);
					$copy_text = strtr( $copy_text, $replacements );

					$output .= "\r\n\r\n" . '<div class="credits clearfix">';
					$output .= ( wm_option( 'skin-footer-shadow' ) ) ? ( '<img src="' . wm_get_stylesheet_directory_uri( 'assets/img/shadow-bottom.png' ) . '" alt="" class="footer-shadow" />' ) : ( '' );
					$output .= apply_filters( 'wmhook_section_inner_wrappers', '' );
					$output .= $copy_text;
					$output .= apply_filters( 'wmhook_section_inner_wrappers_close', '' );
					$output .= "\r\n" . '</div>' . "\r\n";

				//Output
					return apply_filters( 'wmhook_wm_credits_output', $output );
			}
		} // /wm_credits



		/**
		 * Website footer custom scripts
		 *
		 * @since    1.0
		 * @version  1.2.7
		 */
		if ( ! function_exists( 'wm_footer_custom_scripts' ) ) {
			function wm_footer_custom_scripts() {
				//Requirements check
					if (
							! is_singular()
							|| ! ( $output = get_post_meta( get_the_id(), 'custom-js', true ) )
						) {
						return;
					}

				//Helper variables
					$output = "\r\n\r\n<!--Custom singular JS -->\r\n<script type='text/javascript'>\r\n/* <![CDATA[ */\r\n" . wp_unslash( esc_js( str_replace( array( "\r", "\n", "\t" ), '', $output ) ) ) . "\r\n/* ]]> */\r\n</script>\r\n";

				//Output
					echo apply_filters( 'wmhook_wm_footer_custom_scripts_output', $output );
			}
		} // /wm_footer_custom_scripts





/**
 * 60) Others
 */

	/**
	 * Register predefined widget areas (sidebars)
	 *
	 * @since  1.2.2
	 */
	if ( ! function_exists( 'wm_register_widget_areas' ) ) {
		function wm_register_widget_areas() {
			foreach( wm_helper_var( 'widget-areas' ) as $area ) {
				register_sidebar( array(
						'name'          => $area['name'],
						'id'            => $area['id'],
						'description'   => $area['description'],
						'before_widget' => $area['before_widget'],
						'after_widget'  => $area['after_widget'],
						'before_title'  => $area['before_title'],
						'after_title'   => $area['after_title']
					) );
			}
		}
	} // /wm_register_widget_areas



	/**
	 * Admin body classes
	 *
	 * @since    1.0
	 * @version  1.7
	 *
	 * @param  string $classes
	 */
	if ( ! function_exists( 'wm_admin_body_class' ) ) {
		function wm_admin_body_class( $classes ) {
			//Preparing output
				$classes .= ' vc-remove-licence-notice';
				$classes .= ' bbp-hide-content-container';

				if ( function_exists( 'wm_is_woocommerce' ) ) {
					$classes .= ' wc-remove-frontend_css_secondary';
					$classes .= ' wc-remove-frontend_css_content_bg';
				}

			//Output
				return $classes;
		}
	} // /wm_admin_body_class



	/**
	 * Logo URL modifications
	 *
	 * @param  array $args
	 */
	if ( ! function_exists( 'wm_logo_url' ) ) {
		function wm_logo_url( $args ) {
			//Preparing output
				if ( is_page_template( 'page-template/one-page.php' ) ) {
					$args['url'] = '#top';
				}

			//Output
				return $args;
		}
	} // /wm_logo_url



	/**
	 * Navigation ative item shadow calculation
	 *
	 * @param  absint $color_brightness [0,255]
	 * @param  absint $min Minimal value of the output
	 *
	 * @return  absint CSS opacity value, but in percent [0,100]
	 */
	if ( ! function_exists( 'wm_nav_shadow_opacity' ) ) {
		function wm_nav_shadow_opacity( $color_brightness = 0, $min = 0 ) {
			//Helper variable
				$output = 50;

			//Preparing output
				//Brightness value into percents [0,100]
					$color_brightness = absint( round( $color_brightness / 2.55 ) );

				//Calculation
					$output = ( 120 * pow( .965, $color_brightness ) ) + 5;

				//Make sure the output is inside [0,100]
					$output = absint( round( $output ) );
					if ( absint( $min ) >= $output ) {
						$output = $min;
					}
					if ( 100 < $output ) {
						$output = 100;
					}

			//Output
				return apply_filters( 'wmhook_wm_nav_shadow_opacity_output', $output, $color_brightness, $min );
		}
	} // /wm_nav_shadow_opacity



	/**
	 * Media uploader image sizes
	 *
	 * @param  array $sizes
	 */
	if ( ! function_exists( 'wm_media_uploader_image_sizes' ) ) {
		function wm_media_uploader_image_sizes( $sizes ) {
			//Modify sizes array
				$sizes['content-width'] = __( 'Content width', 'mustang-lite' );
				$sizes['mobile']        = __( 'Mobile width', 'mustang-lite' );

			//Output
				return apply_filters( 'wmhook_wm_media_uploader_image_sizes_output', $sizes );
		}
	} // /wm_media_uploader_image_sizes



	/**
	 * Schema.org function wrapper
	 *
	 * @version  1.6
	 *
	 * @param  string $element
	 * @param  boolean $output_meta_tag
	 */
	if ( ! function_exists( 'wm_schema_org' ) ) {
		function wm_schema_org( $element = '', $output_meta_tag = false ) {
			return;
		}
	} // /wm_schema_org



	/**
	 * Previous and next post/project links
	 */
	if ( ! function_exists( 'wm_prevnext_post' ) ) {
		function wm_prevnext_post() {
			//Requirements check
				if ( ! ( is_singular( 'post' ) || is_singular( 'wm_projects' ) ) ) {
					return;
				}

			//Helper variables
				$excluded_categories = $output = '';
				$in_same_cat         = true;
				$taxonomy            = ( 'wm_projects' == get_post_type() ) ? ( 'project_category' ) : ( 'category' );
				$taxonomy            = apply_filters( 'wmhook_wm_prevnext_post_taxonomy', $taxonomy );
				$posts               = array(
						get_previous_post( $in_same_cat, $excluded_categories, $taxonomy ),
						get_next_post( $in_same_cat, $excluded_categories, $taxonomy ),
					);

			//Preparing output
				if ( $posts[0] ) {
					$output .= '<a href="' . get_permalink( $posts[0]->ID ) . '" title="' . sprintf( __( 'Previous item: %s', 'mustang-lite' ), esc_attr( strip_tags( get_the_title( $posts[0]->ID ) ) ) ) . '" class="prev"><span class="screen-reader-text">' . trim( get_the_title( $posts[0]->ID ) ) . '</span></a>';
				}
				if ( $posts[1] ) {
					$output .= '<a href="' . get_permalink( $posts[1]->ID ) . '" title="' . sprintf( __( 'Next item: %s', 'mustang-lite' ), esc_attr( strip_tags( get_the_title( $posts[1]->ID ) ) ) ) . '" class="next"><span class="screen-reader-text">' . trim( get_the_title( $posts[1]->ID ) ) . '</span></a>';
				}

				if ( $output ) {
					$output = '<div id="next-prev-post-in-tax" class="next-prev-post-in-tax">' . $output . '</div>';
				}

			//Output
				echo apply_filters( 'wmhook_wm_prevnext_post_output', $output );
		}
	} // /wm_prevnext_post



	/**
	 * Sidebar setup array
	 *
	 * @since    1.0
	 * @version  1.9.3
	 *
	 * @param  string $return Specify which output array key to return.
	 * @param  array $atts
	 */
	if ( ! function_exists( 'wm_sidebar_setup' ) ) {
		function wm_sidebar_setup( $return = false, $atts = array() ) {
			//Helper variables
				$output = apply_filters( 'wmhook_wm_sidebar_setup_output_defaults', array(
						'class_main'    => ' twelve pane',
						'class_sidebar' => '',
						'output'        => '',
						'position'      => 'none',
					) );

				//Requirements check
					if ( ! function_exists( 'wma_sidebar' ) ) {
						if ( ! $return ) {
							return $output;
						} else {
							if ( isset( $output[ $return ] ) ) {
								return $output[ $return ];
							} else {
								return;
							}
						}
					}

				$defaults = array(
						'page_id'  => null,
						'position' => ( wm_option( 'skin-sidebar-position' ) ) ? ( wm_option( 'skin-sidebar-position' ) ) : ( WM_DEFAULT_SIDEBAR_POSITION ),
					);

				$sidebar_none_posts = apply_filters( 'wmhook_sidebar_none_posts', array(
						'wm_projects',
						'page',
					) );

				if (
						( is_archive() && apply_filters( 'wmhook_archive_disable_sidebar', false ) )
						|| ( is_singular( $sidebar_none_posts ) && ! is_page_template( 'home.php' ) )
					) {
					$defaults['position'] = 'none';
				}

				$defaults = apply_filters( 'wmhook_wm_sidebar_setup_defaults', $defaults );
				$atts     = wp_parse_args( $atts, $defaults );

				if (
						(
							( is_home() || is_singular() )
							|| ( function_exists( 'wm_is_woocommerce' ) && is_shop() ) //WooCommerce support
						)
						&& function_exists( 'wma_meta_option' )
						&& wma_meta_option( 'sidebar', $atts['page_id'] )
					) {
					$atts['position'] = wma_meta_option( 'sidebar', $atts['page_id'] );
				}

				if (
						is_singular()
						&& 'sections' == wma_meta_option( 'sidebar', $atts['page_id'] )
					) {
					$defaults['position'] = 'none';
				}

				$atts = apply_filters( 'wmhook_wm_sidebar_setup_atts', $atts );

			//Preparing output
				if ( 'none' !== $atts['position'] ) {
					$classes = ( wm_option( 'skin-sidebar-width' ) ) ? ( wm_option( 'skin-sidebar-width' ) ) : ( WM_DEFAULT_SIDEBAR_WIDTH );
					//First array value is for sidebar width, the second for content width
						$classes = explode( ';', $classes );

					if ( isset( $classes[0] ) ) {
						$output['class_sidebar'] = $classes[0];
					}
					if ( isset( $classes[1] ) ) {
						if ( 'left' === $atts['position'] ) {
							$classes[1] .= ' sidebar-left';
						}
						$output['class_main'] = $classes[1];
					}
				}

				$output['position'] = $atts['position'];

				//Actuall sidebar HTML output
					if ( 'none' !== $output['position'] ) {
						$output['output'] = wma_sidebar( apply_filters( 'wmhook_wm_sidebar_setup_sidebar_atts', array(
								'attributes' => '',
								'class'      => 'sidebar widget-area clearfix sidebar-' . esc_attr( $output['position'] . $output['class_sidebar'] ),
								'sidebar'    => 'general',
							), $atts ) );
					}

				//If no sidebar to output, set fullwidth layout
					if ( ! $output['output'] ) {
						$output = array(
								'class_main'    => ' twelve pane',
								'class_sidebar' => '',
								'output'        => '',
								'position'      => 'none',
							);
					}

			//Output
				$output = apply_filters( 'wmhook_wm_sidebar_setup_output', $output, $atts );

				if ( ! $return ) {
					return $output;
				} else {
					if ( isset( $output[ $return ] ) ) {
						return $output[ $return ];
					} else {
						return;
					}
				}
		}
	} // /wm_sidebar_setup



	/**
	 * Blog page template
	 */

		/**
		 * Blog page template query setup
		 *
		 * @version  1.9.1
		 *
		 * @return  object WordPress query
		 */
		if ( ! function_exists( 'wm_blog_page_query' ) ) {
			function wm_blog_page_query() {
				//Helper variables
					global $paged, $wm_blog_page_id;

					//Requirements check
						if (
								! function_exists( 'wma_meta_option' )
								|| ! $wm_blog_page_id
							) {
							return;
						}

					$page = get_query_var( 'page' );
					$paginated = max( absint( $page ), absint( $paged ) );
					$pagination_page = max( 1, $paginated );

					$article_count = wma_meta_option( 'blog-posts-count', $wm_blog_page_id );
					$cats_action   = ( wma_meta_option( 'blog-categories-action', $wm_blog_page_id ) ) ? ( wma_meta_option( 'blog-categories-action', $wm_blog_page_id ) ) : ( 'category__in' );
					$cats          = ( wma_meta_option( 'blog-categories', $wm_blog_page_id ) ) ? ( array_filter( wma_meta_option( 'blog-categories', $wm_blog_page_id ) ) ) : ( array() );

					//Get categories IDs in array
						if ( 0 < count( $cats ) ) {
							$cat_temp = array();

							foreach ( $cats as $cat ) {
								if ( isset( $cat['category'] ) && $cat['category'] ) {
									$cat = $cat['category'];

									if ( ! is_numeric( $cat ) ) {
									//Category slugs to IDs

										$cat_object = get_category_by_slug( $cat );
										$cat_temp[] = ( is_object( $cat_object ) && isset( $cat_object->term_id ) ) ? ( $cat_object->term_id ) : ( null );

									} else {

										$cat_temp[] = $cat;

									}
								}
							}

							array_filter( $cat_temp ); //remove empty (if any)

							$cats = $cat_temp;
						}

					//Preparing output
						$query_args = array(
								'posts_per_page' => absint( $article_count ),
								'paged'          => absint( $pagination_page )
							);
						if ( 0 < count( $cats ) ) {
							$query_args[ $cats_action ] = $cats;
						}

						$blog_posts = new WP_Query( apply_filters( 'wmhook_wm_blog_page_query_args', $query_args, $wm_blog_page_id ) );

				//Output
					return apply_filters( 'wmhook_wm_blog_page_query_output', $blog_posts );
			}
		} // /wm_blog_page_query



		/**
		 * Blog page template pagination query
		 *
		 * @param  array $atts
		 */
		if ( ! function_exists( 'wm_pagination_blog' ) ) {
			function wm_pagination_blog( $atts ) {
				//Preparing output
					if ( is_page_template( 'home.php' ) && ! is_home() ) {
						$atts['query'] = wm_blog_page_query();
					}

				//Output
					return $atts;
			}
		} // /wm_pagination_blog



	/**
	 * hAtom microformats
	 */

		/**
		 * Adding required hAttom microformats for better SEO
		 */
		if ( ! function_exists( 'wm_hatom_microformats' ) ) {
			function wm_hatom_microformats() {
				//Helper variables
					$output = '';

				//Preparing output
					if ( is_singular( array( 'wm_projects', 'page' ) ) ) {
					//For projects and pages only, posts are fine already
						$output .= '<div class="hatom-microformats hide">';
						$output .= '<h1 class="entry-title">' . get_the_title() . '</h1>';
						$output .= '<p>' . sprintf( 'Updated on %1$s, by %2$s.', '<span class="updated"> ' . get_the_modified_time( 'c' ) .'</span>', '<span class="author vcard"><span class="fn">' . get_the_author() . '</span></span>' ) . '</p>';
						$output .= '</div>';
					}

				//Output
					echo apply_filters( 'wmhook_wm_hatom_microformats_output', $output );
			}
		} // /wm_hatom_microformats



	/**
	 * Pagination fallback
	 *
	 * This pagination function is used only if the WebMan Amplifier not active.
	 *
	 * @since    1.1.1
	 * @version  1.4
	 */
	if ( ! function_exists( 'wm_pagination' ) ) {
		function wm_pagination() {
			//Helper variables
				global $wp_query, $wp_rewrite;

				$output = '';

				$pagination = array(
						'prev_text' => '&laquo;',
						'next_text' => '&raquo;',
					);

			//Output
				echo '<div class="wm-pagination">' . paginate_links( $pagination ) . '</div>';
		}
	} // /wm_pagination



	/**
	 * Plugins integration
	 */

		/**
		 * WebMan Amplifier plugin integration
		 */

			if ( class_exists( 'WM_Amplifier' ) ) {
				require get_theme_file_path( WM_SETUP_DIR . 'setup-webman-amplifier.php' );
			}



		/**
		 * Breadcrumb NavXT
		 */

			/**
			 * Don't display breadcrumbs settings for posts with no single view
			 *
			 * @param  boolean $display
			 * @param  string $post_type
			 */
			if ( ! function_exists( 'wm_bcn_settings' ) ) {
				function wm_bcn_settings( $display = true, $post_type = '' ) {
					//Helper variables
						$redirects = apply_filters( 'wmhook_custom_post_redirects', array(
								'wm_logos'        => home_url(),
								'wm_modules'      => home_url(),
								'wm_staff'        => home_url(),
								'wm_testimonials' => home_url(),
							) );

					//Preparing output
						if ( in_array( $post_type, array_keys( $redirects ) ) ) {
							$display = false;
						}

					//Output
						return $display;
				}
			} // /wm_bcn_settings



		/**
		 * WooSidebars integration
		 */

			/**
			 * Altering default sidebar args
			 *
			 * Hooking onto 'dynamic_sidebar_params' filter to alter the default
			 * WordPress args for registered sidebars. This way we can make the
			 * default wrapper around the sidebar widget a DIV for example
			 * and change the widget heading tag.
			 *
			 * @param  string $params
			 */
			if ( ! function_exists( 'wm_ws_default_sidebar_params' ) ) {
				function wm_ws_default_sidebar_params( $params ) {
					//Preparing output
						if (
								! isset( $params[0]['after_widget'] )
								|| '</li>' === trim( $params[0]['after_widget'] )
							) {
							global $wp_registered_widgets;

							$theme_default_args = wm_helper_var( 'widget-areas', 'general' );

							//Substitute HTML id and class attributes into before_widget
								$id         = $params[0]['widget_id'];
								$classname_ = '';

								foreach ( (array) $wp_registered_widgets[$id]['classname'] as $cn ) {
									if ( is_string( $cn ) ) {
										$classname_ .= '_' . $cn;
									} elseif ( is_object( $cn ) ) {
										$classname_ .= '_' . get_class( $cn );
									}
								}

								$classname_ = ltrim( $classname_, '_' );

							$params[0]['before_widget'] = sprintf( $theme_default_args['before_widget'], $id, $classname_ );
							$params[0]['after_widget']  = $theme_default_args['after_widget'];
							$params[0]['before_title']  = $theme_default_args['before_title'];
							$params[0]['after_title']   = $theme_default_args['after_title'];
						}

					//Output
						return $params;
				}
			} // /wm_ws_default_sidebar_params



		/**
		 * Contact Form 7 integration
		 */

			/**
			 * Contact Form 7 plugin enhancements
			 *
			 * Do shortcodes in the Contact Form 7 forms.
			 *
			 * @param  string $form
			 */
			if ( ! function_exists( 'wm_cf7_shortcode_support' ) ) {
				function wm_cf7_shortcode_support( $form ) {
					return do_shortcode( $form );
				}
			} // /wm_cf7_shortcode_support



		/**
		 * JetPack integration
		 */

			/**
			 * Enables JetPack infinite scroll support
			 */
			if ( ! function_exists( 'wm_jp_infinit_scroll' ) ) {
				function wm_jp_infinit_scroll() {
					add_theme_support( 'infinite-scroll', array(
							'type'           => 'click',
							'container'      => 'list-articles',
							'posts_per_page' => 5,
						) );
				}
			} // /wm_jp_infinit_scroll



			/**
			 * JetPack infinite scroll button text
			 *
			 * @version  1.6
			 *
			 * @param  array $js_settings
			 */
			if ( ! function_exists( 'wm_jp_infinit_scroll_button_text' ) ) {
				function wm_jp_infinit_scroll_button_text( $js_settings ) {

					// Processing

						$js_settings['text'] = '<span class="iconwm-plus-circle" title="' . __( 'Load more...', 'mustang-lite' ) . '"></span>';


					// Output

						return $js_settings;

				}
			} // /wm_jp_infinit_scroll_button_text



		/**
		 * Love It (Pro) integration
		 * Post Views Count integration
		 * ZillaLikes integration
		 */

			/**
			 * Post custom meta
			 *
			 * @param  string $empty
			 * @param  string $meta
			 * @param  array  $args
			 */
			if ( ! function_exists( 'wm_post_custom_metas' ) ) {
				function wm_post_custom_metas( $empty, $meta, $args ) {
					//Requirements check
						if ( ! in_array( $meta, array( 'likes', 'views' ) ) ) {
							return $empty;
						}

					//Helper variables
						$meta_output = $output = $title = '';

						if ( 'likes' === $meta ) {

							if ( function_exists( 'zilla_likes' ) ) {
							//ZillaLikes is prioritized as Love It does work 100% only on single post page

								global $zilla_likes;
								$meta_output = $zilla_likes->do_likes();

							} elseif ( function_exists( 'lip_love_it_link' ) ) {

								$meta_output = lip_love_it_link( null, __( 'Like it!', 'mustang-lite' ), __( 'Liked already!', 'mustang-lite' ), false );

							}

						} elseif ( 'views' === $meta ) {

							$title       = __( 'Views count', 'mustang-lite' );
							$meta_output = bawpvc_views_sc( array() );

						}

					//Add new meta
						$replacements = array(
								'{attributes}' => ' title="' . $title . '"',
								'{class}'      => 'entry-' . $meta . ' entry-meta-element',
								'{content}'    => $meta_output,
							);
						$replacements = apply_filters( 'wmhook_wm_post_custom_metas_replacements_' . $meta, $replacements );

						if ( isset( $args['html_custom'][$meta] ) ) {
							$output .= strtr( $args['html_custom'][$meta], $replacements );
						} else {
							$output .= strtr( $args['html'], $replacements );
						}

					//Output
						return apply_filters( 'wmhook_wm_post_custom_metas_output', $empty . $output, $meta );
				}
			} // /wm_post_custom_metas



		/**
		 * Beaver Builder integration
		 *
		 * @since    1.6
		 * @version  1.9.3
		 */

			if ( class_exists( 'FLBuilder' ) ) {
				require get_theme_file_path( WM_SETUP_DIR . 'setup-beaver-builder.php' );
			}



		/**
		 * One Click Demo Import
		 *
		 * @since    1.6
		 * @version  1.9.3
		 */

			if ( ( class_exists( 'OCDI_Plugin' ) || class_exists( 'PT_One_Click_Demo_Import' ) ) && is_admin() ) {
				require get_theme_file_path( WM_SETUP_DIR . 'setup-one-click-demo-import.php' );
			}



		/**
		 * Premium features?
		 *
		 * @since    1.7
		 * @version  1.9.3
		 */
		$premium_file = get_theme_file_path( WM_SETUP_DIR . 'premium/setup-premium.php' );
		if ( file_exists( $premium_file ) ) {
			require $premium_file;
		}
