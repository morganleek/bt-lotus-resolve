<?php
	// Require the composer autoload for getting conflict-free access to enqueue
	require_once __DIR__ . '/vendor/autoload.php';

	// Other functions
	require get_template_directory() . '/inc/block-patterns.php';
	// WEI Images tools
	require get_template_directory() . '/inc/images.php';
	// Extra tools
	require get_template_directory() . '/inc/tools.php';

	// Do stuff through this plugin
	class BoneThemeInit {
		public $enqueue;

		public function __construct() {
			$theme_version = wp_get_theme()->get( 'Version' );
			$version_string = is_string( $theme_version ) ? $theme_version : '1.0.0';

			// It is important that we init the Enqueue class right at the plugin/theme load time
			$this->enqueue = new \WPackio\Enqueue(
				// Name of the project, same as `appName` in wpackio.project.js
				'bonesTheme',
				// Output directory, same as `outputPath` in wpackio.project.js
				'dist',
				// Version of your plugin
				$version_string,
				// Type of your project, same as `type` in wpackio.project.js
				'theme',
				// Plugin location, pass false in case of theme.
				false,
				// Theme type
				'regular'
			);
			// Enqueue a few of our entry points
			add_action( 'wp_enqueue_scripts', [ $this, 'plugin_enqueue' ] );
			add_action( 'after_setup_theme', [ $this, 'bones_theme_support' ] );
			add_action( 'admin_init', [$this, 'bones_theme_editor_styles' ] );
			add_action( 'wp_head', [ $this, 'bones_theme_preload_webfonts' ] );
			add_action( 'wp_head', [ $this, 'bones_theme_ga' ] );
			add_action( 'wp_head', [ $this, 'bones_theme_load_favicons' ] );
			add_action( 'admin_head', [ $this, 'bones_theme_preload_webfonts' ] );
			add_action( 'init', [ $this, 'bones_name_register_block_styles' ], 100 );
			add_action( 'init', [ $this, 'bones_theme_register_acf_blocks' ] );

			// Gallery Sliders
			add_action( 'wp_print_styles', [ $this, 'update_styles' ] );

			// Override core assets
			add_filter( 'should_load_separate_core_block_assets', '__return_true' );
			add_action( 'wp_enqueue_scripts', [ $this, 'bones_use_custom_styles' ] );
		}

		public function plugin_enqueue() {
			$this->enqueue->enqueue( 'app', 'main', [] );

			// Inline styles for fonts
			wp_add_inline_style( 'bones-theme-style', $this->bones_theme_get_font_face_styles() );
		}
		
		public function bones_theme_support() {
			// Add support for block styles.
			add_theme_support( 'wp-block-styles' );

			// Add post thumbnails
			add_theme_support( 'post-thumbnails', array( 'post' ) );

			// Add responsive embedded content
			add_theme_support( 'responsive-embeds' );
			
			// Add editor styles
			add_theme_support( 'editor-styles' );

			add_theme_support( 'custom-spacing' );

			// add_editor_style( 'style.css' );

			// Enqueue editor styles.
			$assets = $this->enqueue->getAssets( 'app', 'main', [
				'js' => true,
				'css' => true,
				'js_dep' => [],
				'css_dep' => [],
				'in_footer' => true,
				'media' => 'all',
			] );

			if( !empty( $assets['css' ] ) ) {
				foreach( $assets['css'] as $css ) {
					$url = str_replace( trailingslashit( get_template_directory_uri() ), '', $css['url'] );
					add_editor_style( $url );
				}
			}
		}

		public function bones_use_custom_styles() {
			$blocks = array(
				'navigation',
			);

			foreach ( $blocks as $block) {
				wp_deregister_style( 'wp-block-' . $block );
			}
		}

		public function bones_theme_register_acf_blocks() {
			register_block_type( __DIR__ . '/blocks/uranium-price' );
		}

		public function bones_theme_load_favicons() {
			print '<link rel="icon" href="' . get_theme_file_uri( 'assets/favicon.ico' ) . '" sizes="any">';
			print '<link rel="icon" href="' . get_theme_file_uri( 'assets/favicon.svg' ) . '" type="image/svg+xml">';
		}

		public function bones_theme_ga() {
			print '<!-- Global site tag (gtag.js) - Google Analytics -->
				<script async src="https://www.googletagmanager.com/gtag/js?id=UA-89195302-1"></script>
				<script>
					window.dataLayer = window.dataLayer || [];
					function gtag(){dataLayer.push(arguments);}
					gtag(\'js\', new Date());
			
					gtag(\'config\', \'UA-89195302-1\');
				</script>
			';
		}

		public function bones_theme_editor_styles() {
			wp_add_inline_style( 'wp-block-library', $this->bones_theme_get_font_face_styles() );
		}

		public function bones_theme_get_font_face_styles() {
			return "";
			// return "
			// @font-face{
			// 	font-family: 'Source Serif Pro';
			// 	font-weight: 200 900;
			// 	font-style: normal;
			// 	font-stretch: normal;
			// 	font-display: swap;
			// 	src: url('" . get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) . "') format('woff2');
			// }
			// ";
		}

		public function bones_theme_preload_webfonts() {
			print '<link rel="preconnect" href="https://fonts.googleapis.com">';
			print '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
			print '<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">';
			// print '<link rel="preload" href="' . esc_url( get_theme_file_uri( 'assets/fonts/SourceSerif4Variable-Roman.ttf.woff2' ) ) . '" as="font" type="font/woff2" crossorigin>';
		}

		public function bones_name_register_block_styles() {
			// Group Rows
			register_block_style( 'core/group', [
				'name' => 'three-columns',
				'label' => __( 'Three Columns', 'bones_name' )
			] );

			// Heading
			register_block_style( 'core/heading', [
				'name' => 'underline',
				'label' => __( 'Underline', 'bones_name' )
			] );

			// Media & Text
			// register_block_style( 'core/media-text', [
			// 	'name' => 'stacked',
			// 	'label' => __( 'Stacked', 'bones_name' )
			// ] );
	
			// Cover
			// register_block_style( 'core/cover', [
			//   'name' => 'banner-reversed',
			//   'label' => __( 'Reversed', 'bones_name' ),
			// ] );
	
			// Columns
			// register_block_style( 'core/columns', [
			//   'name' => 'no-bottom-margin',
			//   'label' => __( 'No bottom margin', 'bones_name' ),
			// ] );
			// register_block_style( 'core/columns', [
			//   'name' => 'columns-border',
			//   'label' => __( 'Columns border', 'bones_name' ),
			// ] );
	
			// Gallery
			// register_block_style( 'core/gallery', [
			// 	'name' => 'gallery-slider',
			// 	'label' => __( 'Slider', 'bones_name' ),
			// ] );
	
			// Buttons
			// register_block_style( 'core/button', [
			//   'name' => 'play',
			//   'label' => __( 'Play', 'bones_name' ),
			// ] );
		}

		public function update_gallery_styles( $styles ) {
			$regex = '/(.wp-block-gallery[\S\w]*)/i';
			return preg_replace( $regex, '${1}:not(.is-style-gallery-slider) ', $styles );
		}
		
		public function update_styles() {
			// Extends upon wp-includes/script-loader.php/wp_maybe_inline_styles()
			global $wp_styles;
			if( isset( $wp_styles->registered['wp-block-gallery'] ) ) {
				// `src` is set to false when it's already inlined
				if( $wp_styles->registered['wp-block-gallery']->src !== false ) {
					// based on code from inclues `wp_maybe_inline_styles` line:2818
					$css = file_get_contents( $wp_styles->registered['wp-block-gallery']->extra['path'] );

					// update relative urls
					$css = _wp_normalize_relative_css_links( $css, $wp_styles->registered['wp-block-gallery']->src );

					// set `src` to `false` and add styles inline
					$wp_styles->registered[ 'wp-block-gallery' ]->src = false;
					if ( empty( $wp_styles->registered[ 'wp-block-gallery' ]->extra['after'] ) ) {
						$wp_styles->registered[ 'wp-block-gallery' ]->extra['after'] = array();
					}
					array_unshift( $wp_styles->registered[ 'wp-block-gallery' ]->extra['after'], $css );
				}
				
				// update `src` using regex to exclude our `.is-style-gallery-slider` class 
				if( isset( $wp_styles->registered['wp-block-gallery']->extra['after'] ) ) {
					$wp_styles->registered['wp-block-gallery']->extra['after'] = array_map( [ $this, 'update_gallery_styles' ], $wp_styles->registered['wp-block-gallery']->extra['after'] );
				}	
			}
		}
	}

	// Init
	new BoneThemeInit();

	// function prefix_remove_core_block_styles() {
	// 	global $wp_styles;

	// 	___( $wp_styles ); die();
	
	// 	// foreach ( $wp_styles->queue as $key => $handle ) {
	// 	// 	if ( strpos( $handle, 'wp-block-' ) === 0 ) {
	// 	// 		wp_dequeue_style( $handle );
	// 	// 	}
	// 	// }
	// }
	// add_action( 'wp_enqueue_scripts', 'prefix_remove_core_block_styles' );

	// function custom_render( $a, $b ) {
	// 	___( $a );
	// 	___( $b );
	// 	die();
	// }

	// add_filter( 'render_block', 'custom_render', 10, 2 );

	// function bones_update_gallery_styles( $styles ) {
	// 	$regex = '/(.wp-block-gallery[\S\w]*)/i';
	// 	return preg_replace( $regex, '${1}:not(.is-style-gallery-slider) ', $styles );
	// }
	
	// function update_styles() {
	// 	global $wp_styles;

	// 	___( $wp_styles->registered['wp-block-gallery']->extra['after'] );
	// 	die();

	// 	if( isset( $wp_styles->registered['wp-block-gallery'] ) ) {
	// 		if( isset( $wp_styles->registered['wp-block-gallery']->extra['after'] ) ) {
	// 			$wp_styles->registered['wp-block-gallery']->extra['after'] = array_map( 'bones_update_gallery_styles', $wp_styles->registered['wp-block-gallery']->extra['after'] );
	// 		}	
	// 	}
	// }

	// add_action( 'wp_print_styles', 'update_styles' );