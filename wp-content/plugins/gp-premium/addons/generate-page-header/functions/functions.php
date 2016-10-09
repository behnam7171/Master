<?php
if ( ! function_exists( 'generate_page_header_admin_enqueue' ) ) :
add_action('admin_enqueue_scripts','generate_page_header_admin_enqueue');
function generate_page_header_admin_enqueue() {
	wp_enqueue_script('wp-color-picker');
    wp_enqueue_style( 'wp-color-picker' );
}
endif;

if ( ! function_exists( 'generate_page_header_enqueue' ) ) :
add_action( 'wp_enqueue_scripts','generate_page_header_enqueue' );
function generate_page_header_enqueue()
{
	wp_enqueue_script( 'generate-page-header-parallax', plugin_dir_url( __FILE__ ) . 'js/parallax.js', array('jquery'), '', true );
}
endif;


if ( ! defined( 'GP_IMAGE_RESIZER' ) && ! is_admin() ) :
/**
 * Load Image Resizer
 */
require plugin_dir_path( __FILE__ ) . 'otf_regen_thumbs.php';
endif;

/**
 * Load Page Header Admin
 */
require plugin_dir_path( __FILE__ ) . 'admin-options.php';

/**
 * Generate the CSS in the <head> section using the Theme Customizer
 * @since 0.1
 */
if ( !function_exists( 'generate_page_header_css' ) ) :
	function generate_page_header_css()
	{
	
		$options = get_option( 'generate_page_header_options', '' );
		
		global $post;

		if ( is_home() ) :
			$header_content = ( !empty( $options['page_header_content'] ) ) ? $options['page_header_content'] : '';
			$image_background = ( !empty( $options['page_header_image_background'] ) ) ? $options['page_header_image_background'] : '';
			$image_background_type = ( !empty( $options['page_header_container_type'] ) ) ? $options['page_header_container_type'] : '';
			$image_background_fixed = ( !empty( $options['page_header_add_parallax'] ) ) ? $options['page_header_add_parallax'] : '';
			$image_background_alignment = ( !empty( $options['page_header_text_alignment'] ) ) ? $options['page_header_text_alignment'] : '';
			$image_background_spacing = ( !empty( $options['page_header_padding'] ) ) ? $options['page_header_padding'] : '';
			$image_background_color = ( !empty( $options['page_header_background_color'] ) ) ? $options['page_header_background_color'] : '';
			$image_background_text_color = ( !empty( $options['page_header_text_color'] ) ) ? $options['page_header_text_color'] : '';
			$image_background_link_color = ( !empty( $options['page_header_link_color'] ) ) ? $options['page_header_link_color'] : '';
			$image_background_link_color_hover = ( !empty( $options['page_header_link_color_hover'] ) ) ? $options['page_header_link_color_hover'] : '';
			$page_header_image_custom = ( !empty( $options['page_header_image'] ) ) ? $options['page_header_image'] : '';
		else :
			$header_content = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-content', true ) : '';
			$image_background = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background', true ) : '';
			$image_background_type = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-type', true ) : '';
			$image_background_fixed = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-fixed', true ) : '';
			$image_background_alignment = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-alignment', true ) : '';
			$image_background_spacing = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-spacing', true ) : '';
			$image_background_color = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-color', true ) : '';
			$image_background_text_color = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-text-color', true ) : '';
			$image_background_link_color = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-link-color', true ) : '';
			$image_background_link_color_hover = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image-background-link-color-hover', true ) : '';
			$page_header_image_custom = ( isset( $post ) ) ? get_post_meta( $post->ID, '_meta-generate-page-header-image', true ) : '';
		endif;
		
		// If we don't have any content, we don't need any of the below
		if ( empty( $header_content ) )
			return;
		
		$space = ' ';

		// Start the magic
		$visual_css = array (
		
			// if fluid
			'.generate-content-header' => array(
				'background-color' => ( 'fluid' == $image_background_type && !empty( $image_background_color ) ) ? $image_background_color : null,
				'background-image' => ( 'fluid' == $image_background_type && !empty( $image_background ) ) ? 'url(' . $page_header_image_custom . ')' : null,
				'background-size' => ( 'fluid' == $image_background_type && !empty( $image_background ) ) ? 'cover' : null,
				'background-attachment' => ( 'fluid' == $image_background_type && !empty( $image_background ) && !empty( $image_background_fixed ) ) ? 'fixed' : null,
				'background-position' => ( 'fluid' == $image_background_type && !empty( $image_background ) && !empty( $image_background_fixed ) ) ? 'center top' : null,
			),
			
			'.separate-containers .generate-content-header' => array(
				'margin-top' => ( 'fluid' == $image_background_type ) ? '0px' : null,
			),
			
			'.inside-page-header' => array(
				'background-color' => ( !empty( $image_background ) || !empty( $image_background_color ) ) ? 'transparent' : null,
				'color' => ( !empty( $image_background_text_color ) ) ? $image_background_text_color : null,
			),
			
			// if contained
			
			'.inside-content-header' => array(
				'background-image' => ( 'contained' == $image_background_type && !empty( $image_background ) ) ? 'url(' . $page_header_image_custom . ')' : null,
				'background-color' => ( 'contained' == $image_background_type && !empty( $image_background_color ) ) ? $image_background_color : null,
				'background-size' => ( 'contained' == $image_background_type && !empty( $image_background ) ) ? 'cover' : null,
				'background-attachment' => ( 'contained' == $image_background_type && !empty( $image_background ) && !empty( $image_background_fixed ) ) ? 'fixed' : null,
				'background-position' => ( 'contained' == $image_background_type && !empty( $image_background ) && !empty( $image_background_fixed ) ) ? 'center top' : null,
				'text-align' => ( !empty( $image_background_alignment ) ) ? $image_background_alignment : null,
				'padding-top' => ( !empty( $image_background_spacing ) ) ? $image_background_spacing . 'px' : null,
				'padding-bottom' => ( !empty( $image_background_spacing ) ) ? $image_background_spacing . 'px' : null,
				'color' => ( !empty( $image_background_text_color ) ) ? $image_background_text_color : null,
			),
			
			'.inside-content-header a, .inside-content-header a:visited' => array(
				'color' => ( !empty( $image_background_link_color ) ) ? $image_background_link_color : null,
			),
			
			'.inside-content-header a:hover, .inside-content-header a:active' => array(
				'color' => ( !empty( $image_background_link_color_hover ) ) ? $image_background_link_color_hover : null,
			),
			
			'.separate-containers .inside-article .page-header-below-title, .one-container .inside-article .page-header-below-title' => array(
				'margin-top' => '2em'
			),
			
			'.inside-article .page-header-post-image' => array(
				'float' => 'none',
				'margin-right' => '0px'
			),
			
			'.vertical-center-container' => array(
				'display' => 'table',
				'width' => '100%'
			),
			
			'.vertical-center-enabled' => array(
				'display' => 'table-cell',
				'vertical-align' => 'middle'
			)
			
		);
		
		// Output the above CSS
		$output = '';
		foreach($visual_css as $k => $properties) {
			if(!count($properties))
				continue;

			$temporary_output = $k . ' {';
			$elements_added = 0;

			foreach($properties as $p => $v) {
				if(empty($v))
					continue;

				$elements_added++;
				$temporary_output .= $p . ': ' . $v . '; ';
			}

			$temporary_output .= "}";

			if($elements_added > 0)
				$output .= $temporary_output;
		}
		
		$output = str_replace(array("\r", "\n"), '', $output);
		return $output;
	}
	
	/**
	 * Enqueue scripts and styles
	 */
	add_action( 'wp_enqueue_scripts', 'generate_page_header_scripts', 100 );
	function generate_page_header_scripts() {

		wp_add_inline_style( 'generate-style', generate_page_header_css() );
	
	}
endif;

if ( ! function_exists( 'generate_page_header_area' ) ) :
function generate_page_header_area($image_class, $content_class)
{
	// Don't run the function unless we're on a page it applies to
	if ( ! is_singular() || is_attachment() )
		return;
		
	global $post;
	$featured_image = get_post_thumbnail_id( $post->ID, 'full' );
	$page_header_image_id = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-id', true );
	$page_header_image_custom = get_post_meta( get_the_ID(), '_meta-generate-page-header-image', true );
	
	// Get the ID of the image
	$image_id = null;
	if ( ! empty( $featured_image ) && empty( $page_header_image_custom ) ) :
		// Using featured image, and not the Page Header metabox, so we already have the ID
		$image_id = $featured_image;
	elseif ( ! empty( $page_header_image_custom ) && ! empty( $page_header_image_id ) ) :
		// We have a metabox URL and ID
		$image_id = $page_header_image_id;
	elseif ( empty( $page_header_image_id ) && ! empty( $page_header_image_custom ) ) :
		// We don't have the image ID of our metabox image, but we do have the URL
		$image_id = generate_get_attachment_id_by_url( esc_url( $page_header_image_custom ) );
	endif;
	
	// Get the other page header options
	$page_header_image_link = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-link', true );
	$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
	$page_header_content_autop = get_post_meta( get_the_ID(), '_meta-generate-page-header-content-autop', true );
	$page_header_content_padding = get_post_meta( get_the_ID(), '_meta-generate-page-header-content-padding', true );
	$page_header_crop = get_post_meta( get_the_ID(), '_meta-generate-page-header-enable-image-crop', true );
	$page_header_parallax = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-background-fixed', true );
	$page_header_full_screen = get_post_meta( get_the_ID(), '_meta-generate-page-header-full-screen', true );
	$page_header_vertical_center = get_post_meta( get_the_ID(), '_meta-generate-page-header-vertical-center', true );
	$page_header_image_width = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-width', true );
	$page_header_image_height = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-height', true );
	
	// Parallax variable
	$parallax = ( ! empty( $page_header_parallax ) ) ? ' parallax-enabled' : '';
	
	// Full screen variable
	$full_screen = ( ! empty( $page_header_full_screen ) ) ? ' fullscreen-enabled' : '';
	
	// Vertical center variable
	$vertical_center_container = ( ! empty( $page_header_vertical_center ) ) ? ' vertical-center-container' : '';
	$vertical_center = ( ! empty( $page_header_vertical_center ) ) ? ' vertical-center-enabled' : '';
	
	// Set our widths and height if crop is enabled
	if ( 'enable' == $page_header_crop ) :
		$image_width = ( ! empty( $page_header_image_width ) ) ? intval( $page_header_image_width ) : 1200;
		$image_height = ( '0' == $page_header_image_height ) ? '9999' : intval( $page_header_image_height );
		$crop = ( '0' == $page_header_image_height || '' == $page_header_image_height || '9999' == $page_header_image_height ) ? false : true;
		$crop = ( '0' == $page_header_image_width || '' == $page_header_image_width || '9999' == $page_header_image_width ) ? false : true;
	else :
		$image_width = '';
		$image_height = '';
	endif;
	
	// Create a filter for the link target
	$link_target = apply_filters( 'generate_page_header_link_target','' );
	
	// If we have a link set, let's build it
	if ( ! empty( $page_header_image_link ) ) :
		$start_link = '<a href="' . esc_url( $page_header_image_link ) . '"' . $link_target . '>';
		$end_link = '</a>';
	else :
		$start_link = '';
		$end_link = '';
	endif;
	
	// If an image is set and no content is set
	if ( '' == $page_header_content && ! empty( $image_id ) ) :
		echo '<div class="' . $image_class . ' grid-container grid-parent generate-page-header">';
			echo $start_link;
				if ( 'enable' == $page_header_crop ) :
					echo wp_get_attachment_image( $image_id, array( $image_width, $image_height, $crop ), '', array( 'itemprop' => 'image' ) );
				else :
					echo wp_get_attachment_image( $image_id, apply_filters( 'generate_page_header_default_size', 'full' ), '', array( 'itemprop' => 'image' ) );
				endif;
			echo $end_link;
		echo '</div>';
	endif;
		
	// If content is set, show it
	if ( '' !== $page_header_content && false !== $page_header_content ) :
		echo '<div class="' . $content_class . $parallax . $full_screen . $vertical_center_container . ' generate-page-header generate-content-header">';
			echo '<div class="inside-page-header-container inside-content-header grid-container grid-parent ' . $vertical_center . '">';
			if ( $page_header_content_padding == 'yes' ) echo '<div class="inside-page-header">';
				$content = $page_header_content;
				if ( $page_header_content_autop == 'yes' ) $content = wpautop($content);
				echo do_shortcode($content);
			if ( $page_header_content_padding == 'yes' ) echo '</div>';
			echo '</div>';
		echo '</div>';
	endif;
}
endif;

if ( ! function_exists( 'generate_blog_page_header_area' ) ) :
function generate_blog_page_header_area($image_class, $content_class)
{

	// Don't run the function unless we're on the blog
	if ( ! is_home() )
		return;
		
	$options = get_option( 'generate_page_header_options' );
		
	$page_header_image = ( !empty( $options['page_header_image'] ) ) ? $options['page_header_image'] : '';
	$page_header_image_link = ( !empty( $options['page_header_url'] ) ) ? $options['page_header_url'] : '';
	$page_header_content = ( !empty( $options['page_header_content'] ) ) ? $options['page_header_content'] : '';
	$page_header_content_autop = ( !empty( $options['page_header_add_paragraphs'] ) ) ? $options['page_header_add_paragraphs'] : '';
	$page_header_content_padding = ( !empty( $options['page_header_add_padding'] ) ) ? $options['page_header_add_padding'] : '';
	$page_header_crop = ( !empty( $options['page_header_hard_crop'] ) ) ? $options['page_header_hard_crop'] : '';
	$page_header_parallax = ( !empty( $options['page_header_add_parallax'] ) ) ? $options['page_header_add_parallax'] : '';
	$page_header_full_screen = ( !empty( $options['page_header_full_screen'] ) ) ? $options['page_header_full_screen'] : '';
	$page_header_vertical_center = ( !empty( $options['page_header_vertical_center'] ) ) ? $options['page_header_vertical_center'] : '';
	
	if ( ! empty( $page_header_parallax ) ) :
		$parallax = ' parallax-enabled';
	else :
		$parallax = '';
	endif;
	
	if ( ! empty( $page_header_full_screen ) ) :
		$full_screen = ' fullscreen-enabled';
	else :
		$full_screen = '';
	endif;
	
	if ( ! empty( $page_header_vertical_center ) ) :
		$vertical_center_container = ' vertical-center-container';
		$vertical_center = ' vertical-center-enabled';
	else :
		$vertical_center_container = '';
		$vertical_center = '';
	endif;
	
	if ( 'enable' == $page_header_crop ) :
		//$page_header_crop_position = $options['page_header_image_crop_position'];
		$page_header_image_width = $options['page_header_image_width'];
		if ( !empty( $page_header_image_width ) ) :
			$page_header_image_width = $options['page_header_image_width'];
		else :
			$page_header_image_width = 1200;
		endif;
		$page_header_image_height = ( isset( $options['page_header_image_height'] ) ) ? $options['page_header_image_height'] : '0';
		
		// If no height is set, set it to something stupid so WP ignores it
		if ( '0' == $page_header_image_height ) :
			$page_header_image_height = '9999';
		endif;
		
		$crop = ( '9999' == $page_header_image_height || '' == $page_header_image_height ) ? false : true;
	
	else :
		//$page_header_crop_position = '';
		$page_header_image_width = '';
		$page_header_image_height = '';
	endif;
	
	// Create a filter for the link target
	$link_target = apply_filters( 'generate_page_header_link_target','' );
	
	// If we have a link set, let's build it
	if ( ! empty( $page_header_image_link ) ) :
		$start_link = '<a href="' . esc_url( $page_header_image_link ) . '"' . $link_target . '>';
		$end_link = '</a>';
	else :
		$start_link = '';
		$end_link = '';
	endif;
	
	// If an image is set, no content is set and hard crop is enabled, show it
	if ( '' == $page_header_content && '' !== $page_header_image && 'enable' == $page_header_crop ) :
		echo '<div class="' . $image_class . ' grid-container grid-parent generate-page-header generate-blog-page-header generate-blog-page-header">';
			echo $start_link;
				if ( ! empty( $page_header_image ) ) :
					$image_id = generate_get_attachment_id_by_url( esc_url( $page_header_image ) );
					echo wp_get_attachment_image( $image_id, array( $page_header_image_width, $page_header_image_height, $crop ), '', array( 'itemprop' => 'image' ) );
				endif;
			echo $end_link;
		echo '</div>';
	endif;
		
	// If an image is set with no hard cropping and no content is set, show it
	if ( '' == $page_header_content && '' !== $page_header_image && false !== $page_header_image && 'enable' !== $page_header_crop ) :
		echo '<div class="' . $image_class . ' grid-container grid-parent generate-page-header">';
			echo $start_link;
				if ( ! empty( $page_header_image ) ) :
					$image_id = generate_get_attachment_id_by_url( esc_url( $page_header_image ) );
					echo wp_get_attachment_image( $image_id, apply_filters( 'generate_page_header_default_size', 'full' ), '', array( 'itemprop' => 'image' ) );
				endif;
			echo $end_link;
		echo '</div>';
	endif;
		
	// If content is set, show it
	if ( '' !== $page_header_content && false !== $page_header_content ) :
		echo '<div class="' . $content_class . $parallax . $full_screen . $vertical_center_container . ' generate-page-header generate-content-header generate-blog-page-header">';
			echo '<div class="inside-page-header-container inside-content-header grid-container grid-parent ' . $vertical_center . '">';
			if ( $page_header_content_padding == '1' ) echo '<div class="inside-page-header">';
				$content = $page_header_content;
				if ( $page_header_content_autop == '1' ) $content = wpautop($content);
				echo do_shortcode($content);
			if ( $page_header_content_padding == '1' ) echo '</div>';
			echo '</div>';
		echo '</div>';
	endif;
}
endif;

/**
 * Prints the Post Image to post excerpts
 */
if ( ! function_exists( 'generate_page_header_post_image' ) ) :
	add_action( 'generate_after_entry_header', 'generate_page_header_post_image' );
	function generate_page_header_post_image()
	{
		global $post;
		
		// If using the featured image, stop
		if ( has_post_thumbnail() )
			return;
			
		$page_header_add_to_excerpt = get_post_meta( get_the_ID(), '_meta-generate-page-header-add-to-excerpt', true );
		
		if ( $page_header_add_to_excerpt == '' )
			return;
			
		if ( 'post' == get_post_type() && !is_single() ) {
			global $post;
			$page_header_image_id = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-id', true );
			$page_header_image_custom = get_post_meta( get_the_ID(), '_meta-generate-page-header-image', true );
			
			// Get the ID of the image
			$image_id = null;
			if ( ! empty( $page_header_image_custom ) && ! empty( $page_header_image_id ) ) :
				// We have a metabox URL and ID
				$image_id = $page_header_image_id;
			elseif ( empty( $page_header_image_id ) && ! empty( $page_header_image_custom ) ) :
				// We don't have the image ID of our metabox image, but we do have the URL
				$image_id = generate_get_attachment_id_by_url( esc_url( $page_header_image_custom ) );
			endif;
	
			$page_header_image_link = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-link', true );
			$page_header_content = get_post_meta( get_the_ID(), '_meta-generate-page-header-content', true );
			$page_header_content_autop = get_post_meta( get_the_ID(), '_meta-generate-page-header-content-autop', true );
			$page_header_content_padding = get_post_meta( get_the_ID(), '_meta-generate-page-header-content-padding', true );
			$page_header_crop = get_post_meta( get_the_ID(), '_meta-generate-page-header-enable-image-crop', true );
			$page_header_image_width = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-width', true );
			$page_header_image_height = get_post_meta( get_the_ID(), '_meta-generate-page-header-image-height', true );
			
			// Set our widths and height if crop is enabled
			if ( 'enable' == $page_header_crop ) :
				$image_width = ( ! empty( $page_header_image_width ) ) ? $page_header_image_width : 1200;
				$image_height = ( '0' == $page_header_image_height ) ? '9999' : $page_header_image_height;
				$crop = ( '0' == $page_header_image_height || '' == $page_header_image_height ) ? false : true;
				$crop = ( '0' == $page_header_image_width || '' == $page_header_image_width || '9999' == $page_header_image_width ) ? false : true;
			else :
				$image_width = '';
				$image_height = '';
			endif;
			
			// Create a filter for the link target
			$link_target = apply_filters( 'generate_page_header_link_target','' );
			
			// If we have a link set, let's build it
			if ( ! empty( $page_header_image_link ) ) :
				$start_link = '<a href="' . esc_url( $page_header_image_link ) . '"' . $link_target . '>';
				$end_link = '</a>';
			else :
				$start_link = '<a href="' . get_the_permalink() . '" title="' . get_the_title() . '"' . $link_target . '>';
				$end_link = '</a>';
			endif;
				
			// If an image is set and no content is set
			if ( '' == $page_header_content && ! empty( $image_id ) ) :
				echo '<div class="post-image page-header-post-image">';
					echo $start_link;
						if ( 'enable' == $page_header_crop ) :
							echo wp_get_attachment_image( $image_id, array( $image_width, $image_height, $crop ), '', array( 'itemprop' => 'image' ) );
						else :
							echo wp_get_attachment_image( $image_id, apply_filters( 'generate_page_header_default_size', 'full' ), '', array( 'itemprop' => 'image' ) );
						endif;
					echo $end_link;
				echo '</div>';
			endif;
				
			// If content is set, show it
			if ( '' !== $page_header_content ) :
				echo '<div class="post-image generate-page-header generate-content-header page-header-post-image">';
					echo '<div class="inside-page-header-container inside-content-header grid-container grid-parent">';
					if ( $page_header_content_padding == 'yes' ) echo '<div class="inside-page-header">';
						$content = $page_header_content;
						if ( $page_header_content_autop == 'yes' ) $content = wpautop($content);
						echo do_shortcode($content);
					if ( $page_header_content_padding == 'yes' ) echo '</div>';
					echo '</div>';
				echo '</div>';
			endif;
			
		}
	}
endif;

if ( ! function_exists( 'generate_page_header' ) ) :
/**
 * Add page header above content
 * @since 0.3
 */
add_action('generate_after_header','generate_page_header', 10);
function generate_page_header()
{
	
	$generate_page_header_settings = wp_parse_args( 
		get_option( 'generate_page_header_settings', array() ), 
		generate_page_header_get_defaults() 
	);
	
	if ( '' == $generate_page_header_settings['page_header_position'] ) :
		$generate_page_header_settings['page_header_position'] = 'above-content';
	endif;

	if ( is_page() && 'above-content' == $generate_page_header_settings['page_header_position'] ) :
		
		generate_page_header_area('page-header-image', 'page-header-content');
	
	endif;
	
	if ( is_home() ) :
		
		generate_blog_page_header_area('page-header-image', 'page-header-content');
	
	endif;
}
endif;

if ( ! function_exists( 'generate_page_header_inside' ) ) :
/**
 * Add page header inside content
 * @since 0.3
 */
add_action('generate_before_content','generate_page_header_inside', 10);
function generate_page_header_inside()
{
		
	$generate_page_header_settings = wp_parse_args( 
		get_option( 'generate_page_header_settings', array() ), 
		generate_page_header_get_defaults() 
	);
	
	if ( '' == $generate_page_header_settings['page_header_position'] ) :
		$generate_page_header_settings['page_header_position'] = 'above-content';
	endif;

	if ( is_page() && 'inside-content' == $generate_page_header_settings['page_header_position'] ) :
		
		generate_page_header_area('page-header-image', 'page-header-content');
	
	endif;

}
endif;

if ( ! function_exists( 'generate_page_header_single' ) ) :
/**
 * Add post header inside content
 * @since 0.3
 */
add_action('generate_before_content','generate_page_header_single', 10);
function generate_page_header_single()
{
		
	$generate_page_header_settings = wp_parse_args( 
		get_option( 'generate_page_header_settings', array() ), 
		generate_page_header_get_defaults() 
	);
		
	if ( '' == $generate_page_header_settings['post_header_position'] ) :
		$generate_page_header_settings['post_header_position'] = 'inside-content';
	endif;

	if ( is_single() && 'inside-content' == $generate_page_header_settings['post_header_position'] ) :

		generate_page_header_area('page-header-image-single', 'page-header-content-single');
	
	endif;
}
endif;

if ( ! function_exists( 'generate_page_header_single_below_title' ) ) :
/**
 * Add post header below title
 * @since 0.3
 */
add_action('generate_after_entry_header','generate_page_header_single_below_title', 10);
function generate_page_header_single_below_title()
{
		
	$generate_page_header_settings = wp_parse_args( 
		get_option( 'generate_page_header_settings', array() ), 
		generate_page_header_get_defaults() 
	);

	if ( is_single() && 'below-title' == $generate_page_header_settings['post_header_position'] ) :
	
		generate_page_header_area('page-header-image-single page-header-below-title', 'page-header-content-single page-header-below-title');
	
	endif;
}
endif;

if ( ! function_exists( 'generate_page_header_single_above' ) ) :
/**
 * Add post header above content
 * @since 0.3
 */
add_action('generate_after_header','generate_page_header_single_above', 10);
function generate_page_header_single_above()
{
		
	$generate_page_header_settings = wp_parse_args( 
		get_option( 'generate_page_header_settings', array() ), 
		generate_page_header_get_defaults() 
	);
	
	
		
	if ( '' == $generate_page_header_settings['post_header_position'] ) :
		$generate_page_header_settings['post_header_position'] = 'inside-content';
	endif;

	if ( is_single() && 'above-content' == $generate_page_header_settings['post_header_position'] ) :
	
		generate_page_header_area('page-header-image-single', 'page-header-content-single');

	endif;
}
endif;

if ( ! function_exists( 'add_generate_page_header_meta_box' ) ) :
/**
 *
 *
 * Generate the page header metabox
 * @since 0.1
 *
 *
 */
add_action('add_meta_boxes', 'add_generate_page_header_meta_box');
function add_generate_page_header_meta_box() { 
	
	
	$post_types = get_post_types();
	foreach ($post_types as $type) {
		add_meta_box
		(  
			'generate_page_header_meta_box', // $id  
			__('Page Header','generate-page-header'), // $title   
			'show_generate_page_header_meta_box', // $callback  
			$type, // $page  
			'normal', // $context  
			'high' // $priority  
		); 
	}
} 
endif;

if ( ! function_exists( 'show_generate_page_header_meta_box' ) ) :
/**
 * Outputs the content of the metabox
 */
function show_generate_page_header_meta_box( $post ) {  

    wp_nonce_field( basename( __FILE__ ), 'generate_page_header_nonce' );
    $stored_meta = get_post_meta( $post->ID );
	
	// Set defaults to avoid PHP notices
	if ( isset($stored_meta['_meta-generate-page-header-image'][0]) ) :
		$stored_meta['_meta-generate-page-header-image'][0] = $stored_meta['_meta-generate-page-header-image'][0];
	else :
		$stored_meta['_meta-generate-page-header-image'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-id'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-id'][0] = $stored_meta['_meta-generate-page-header-image-id'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-id'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-link'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-link'][0] = $stored_meta['_meta-generate-page-header-image-link'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-link'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-enable-image-crop'][0]) ) :
		$stored_meta['_meta-generate-page-header-enable-image-crop'][0] = $stored_meta['_meta-generate-page-header-enable-image-crop'][0];
	else :
		$stored_meta['_meta-generate-page-header-enable-image-crop'][0] = '';
	endif;
	
	// if ( isset($stored_meta['_meta-generate-page-header-image-crop'][0]) ) :
		// $stored_meta['_meta-generate-page-header-image-crop'][0] = $stored_meta['_meta-generate-page-header-image-crop'][0];
	// else :
		// $stored_meta['_meta-generate-page-header-image-crop'][0] = '';
	// endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-width'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-width'][0] = $stored_meta['_meta-generate-page-header-image-width'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-width'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-height'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-height'][0] = $stored_meta['_meta-generate-page-header-image-height'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-height'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-content'][0]) ) :
		$stored_meta['_meta-generate-page-header-content'][0] = $stored_meta['_meta-generate-page-header-content'][0];
	else :
		$stored_meta['_meta-generate-page-header-content'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-content-autop'][0]) ) :
		$stored_meta['_meta-generate-page-header-content-autop'][0] = $stored_meta['_meta-generate-page-header-content-autop'][0];
	else :
		$stored_meta['_meta-generate-page-header-content-autop'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-content-padding'][0]) ) :
		$stored_meta['_meta-generate-page-header-content-padding'][0] = $stored_meta['_meta-generate-page-header-content-padding'][0];
	else :
		$stored_meta['_meta-generate-page-header-content-padding'][0] = '';
	endif;
	
	if ( 'post' == get_post_type() && !is_single() ) {
		if ( isset($stored_meta['_meta-generate-page-header-add-to-excerpt'][0]) ) :
			$stored_meta['_meta-generate-page-header-add-to-excerpt'][0] = $stored_meta['_meta-generate-page-header-add-to-excerpt'][0];
		else :
			$stored_meta['_meta-generate-page-header-add-to-excerpt'][0] = '';
		endif;
	}
	
	if ( isset($stored_meta['_meta-generate-page-header-image-background'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-background'][0] = $stored_meta['_meta-generate-page-header-image-background'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-background'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-background-type'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-background-type'][0] = $stored_meta['_meta-generate-page-header-image-background-type'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-background-type'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-background-fixed'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-background-fixed'][0] = $stored_meta['_meta-generate-page-header-image-background-fixed'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-background-fixed'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-full-screen'][0]) ) :
		$stored_meta['_meta-generate-page-header-full-screen'][0] = $stored_meta['_meta-generate-page-header-full-screen'][0];
	else :
		$stored_meta['_meta-generate-page-header-full-screen'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-vertical-center'][0]) ) :
		$stored_meta['_meta-generate-page-header-vertical-center'][0] = $stored_meta['_meta-generate-page-header-vertical-center'][0];
	else :
		$stored_meta['_meta-generate-page-header-vertical-center'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-background-alignment'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-background-alignment'][0] = $stored_meta['_meta-generate-page-header-image-background-alignment'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-background-alignment'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-background-spacing'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-background-spacing'][0] = $stored_meta['_meta-generate-page-header-image-background-spacing'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-background-spacing'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-background-text-color'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-background-text-color'][0] = $stored_meta['_meta-generate-page-header-image-background-text-color'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-background-text-color'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-background-color'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-background-color'][0] = $stored_meta['_meta-generate-page-header-image-background-color'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-background-color'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-background-link-color'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-background-link-color'][0] = $stored_meta['_meta-generate-page-header-image-background-link-color'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-background-link-color'][0] = '';
	endif;
	
	if ( isset($stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0]) ) :
		$stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0] = $stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0];
	else :
		$stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0] = '';
	endif;

    ?>
 
    <p>
		<div id="tabs">

			<h2 class="nav-tab-wrapper page-header">
				<a class="nav-tab image" href="#tabs-1"><?php _e('Image','generate-page-header');?></a>
				<a class="nav-tab content" href="#tabs-2"><?php _e('Content','generate-page-header');?></a>
			</h2>

			<div id="tabs-1">

				
				<div id="preview-image">
					<?php if( $stored_meta['_meta-generate-page-header-image'][0] != "") { ?>
						<img class="saved-image" src="<?php echo $stored_meta['_meta-generate-page-header-image'][0];?>" width="300" />
					<?php } ?>
				</div>
				<label for="upload_image" class="example-row-title"><strong><?php _e('Page Header Image','generate-page-header');?></strong></label><br />
				<input style="width:350px" id="upload_image" type="text" name="_meta-generate-page-header-image" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-image'][0]); ?>" />			   
				<button class="generate-upload-file button" type="button" data-title="<?php _e( 'Page Header Image','generate-page-header' );?>" data-insert="<?php _e( 'Insert Image','generate-page-header'); ?>" data-prev="true">
					<?php _e('Add Image','proframework') ;?>
				</button>
				<input id="_meta-generate-page-header-image-id" type="hidden" name="_meta-generate-page-header-image-id" value="<?php echo $stored_meta['_meta-generate-page-header-image-id'][0]; ?>" />
				
				<p>
					<label for="_meta-generate-page-header-image-link" class="example-row-title"><strong><?php _e('Page Header Link','generate-page-header');?></strong></label><br />
					<input style="width:350px" placeholder="http://" id="_meta-generate-page-header-image-link" type="text" name="_meta-generate-page-header-image-link" value="<?php echo esc_url($stored_meta['_meta-generate-page-header-image-link'][0]); ?>" />
				</p>
				
				<p>
					<label for="_meta-generate-page-header-enable-image-crop" class="example-row-title"><strong><?php _e('Hard Crop','generate-page-header');?></strong></label><br />
					<select name="_meta-generate-page-header-enable-image-crop" id="_meta-generate-page-header-enable-image-crop">
						<option value="disable" <?php selected( $stored_meta['_meta-generate-page-header-enable-image-crop'][0], 'disable' ); ?>><?php _e('Disable','generate-page-header');?></option>
						<option value="enable" <?php selected( $stored_meta['_meta-generate-page-header-enable-image-crop'][0], 'enable' ); ?>><?php _e('Enable','generate-page-header');?></option>
					</select>
				</p>
				
				<div id="crop-enabled" style="display:none">
					<!--<p>
						<label for="_meta-generate-page-header-image-crop" class="example-row-title"><strong><?php //_e('Image Crop Position','generate-page-header');?></strong></label><br />
						<select name="_meta-generate-page-header-image-crop" id="_meta-generate-page-header-image-crop">
							<option value="c" <?php //selected( $stored_meta['_meta-generate-page-header-image-crop'][0], 'c' ); ?>><?php //_e('Center','generate-page-header');?></option>
							<option value="tl" <?php //selected( $stored_meta['_meta-generate-page-header-image-crop'][0], 'tl' ); ?>><?php //_e('Top left','generate-page-header');?></option>
							<option value="tr" <?php //selected( $stored_meta['_meta-generate-page-header-image-crop'][0], 'tr' ); ?>><?php //_e('Top right','generate-page-header');?></option>
							<option value="bl" <?php //selected( $stored_meta['_meta-generate-page-header-image-crop'][0], 'bl' ); ?>><?php //_e('Bottom left','generate-page-header');?></option>
							<option value="br" <?php //selected( $stored_meta['_meta-generate-page-header-image-crop'][0], 'br' ); ?>><?php //_e('Bottom right','generate-page-header');?></option>
							<option value="l" <?php //selected( $stored_meta['_meta-generate-page-header-image-crop'][0], 'l' ); ?>><?php //_e('Left','generate-page-header');?></option>
							<option value="r" <?php //selected( $stored_meta['_meta-generate-page-header-image-crop'][0], 'r' ); ?>><?php //_e('Right','generate-page-header');?></option>
						</select>
					</p>-->
					
					<p>
						<?php
						// Set default value
						if ( '' == $stored_meta['_meta-generate-page-header-image-width'][0] || '0' == $stored_meta['_meta-generate-page-header-image-width'][0] ) :
							$stored_meta['_meta-generate-page-header-image-width'][0] = 1200;
						endif;
						?>
						<label for="_meta-generate-page-header-image-width" class="example-row-title"><strong><?php _e('Image Width','generate-page-header');?></strong></label><br />
						<input placeholder="1200" style="width:45px" type="text" name="_meta-generate-page-header-image-width" id="_meta-generate-page-header-image-width" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-width'][0] ); ?>" /><label for="_meta-generate-page-header-image-width"><span class="pixels">px</span></label>
					</p>
					
					<p>
						<label for="_meta-generate-page-header-image-height" class="example-row-title"><strong><?php _e('Image Height','generate-page-header');?></strong></label><br />
						<input placeholder="" style="width:45px" type="text" name="_meta-generate-page-header-image-height" id="_meta-generate-page-header-image-height" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-height'][0] ); ?>" /><label for="_meta-generate-page-header-image-height"><span class="pixels">px</span></label>
						<span class="small"><?php _e('Use "0" or leave blank for proportional resizing.','generate-page-header');?></span>
					</p>
				</div>
			</div>

			<div id="tabs-2">
				<p>
					<label for="_meta-generate-page-header-content" class="example-row-title"><strong><?php _e('Content','generate-page-header');?></strong></label><br />
					<textarea style="width:100%;min-height:200px;" name="_meta-generate-page-header-content" id="_meta-generate-page-header-content"><?php echo esc_html($stored_meta['_meta-generate-page-header-content'][0]); ?></textarea>
					<span class="description"><?php _e('HTML and shortcodes allowed.','generate-page-header');?></span>
				</p>
				<p>
					<input type="checkbox" name="_meta-generate-page-header-content-autop" id="_meta-generate-page-header-content-autop" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-content-autop'] ) ) checked( $stored_meta['_meta-generate-page-header-content-autop'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-content-autop"><?php _e('Automatically add paragraphs','generate-page-header');?></label>
				</p>
				<p>
					<input type="checkbox" name="_meta-generate-page-header-content-padding" id="_meta-generate-page-header-content-padding" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-content-padding'] ) ) checked( $stored_meta['_meta-generate-page-header-content-padding'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-content-padding"><?php _e('Add padding','generate-page-header');?></label>
				</p>
				
				<p>
					<input type="checkbox" name="_meta-generate-page-header-image-background" id="_meta-generate-page-header-image-background" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-image-background'] ) ) checked( $stored_meta['_meta-generate-page-header-image-background'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-image-background"><?php _e('Use image (from image tab) as a background image?','generate-page-header');?></label>
				</p>
				
				<div class="image-background-enabled">
				
					<p>
						<input type="checkbox" name="_meta-generate-page-header-image-background-fixed" id="_meta-generate-page-header-image-background-fixed" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-image-background-fixed'] ) ) checked( $stored_meta['_meta-generate-page-header-image-background-fixed'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-image-background-fixed"><?php _e('Add parallax effect to background image?','generate-page-header');?></label>
					</p>
					
					<p>
						<input type="checkbox" name="_meta-generate-page-header-full-screen" id="_meta-generate-page-header-full-screen" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-full-screen'] ) ) checked( $stored_meta['_meta-generate-page-header-full-screen'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-full-screen"><?php _e('Make background image full screen?','generate-page-header');?></label>
					</p>
					
					<p>
						<input type="checkbox" name="_meta-generate-page-header-vertical-center" id="_meta-generate-page-header-vertical-center" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-vertical-center'] ) ) checked( $stored_meta['_meta-generate-page-header-vertical-center'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-vertical-center"><?php _e('Center your content vertically?','generate-page-header');?></label>
					</p>
					
					<p>
						<label for="_meta-generate-page-header-image-background-type" class="example-row-title"><strong><?php _e('Container type','generate-page-header');?></strong></label><br />
						<select name="_meta-generate-page-header-image-background-type" id="_meta-generate-page-header-image-background-type">
							<option value="contained" <?php selected( $stored_meta['_meta-generate-page-header-image-background-type'][0], 'contained' ); ?>><?php _e('Contained','generate-page-header');?></option>
							<option value="fluid" <?php selected( $stored_meta['_meta-generate-page-header-image-background-type'][0], 'fluid' ); ?>><?php _e('Fluid','generate-page-header');?></option>
						</select>
					</p>
					
					
					
					<p>
						<label for="_meta-generate-page-header-image-background-alignment" class="example-row-title"><strong><?php _e('Text alignment','generate-page-header');?></strong></label><br />
						<select name="_meta-generate-page-header-image-background-alignment" id="_meta-generate-page-header-image-background-alignment">
							<option value="left" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], 'left' ); ?>><?php _e('Left','generate-page-header');?></option>
							<option value="center" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], 'center' ); ?>><?php _e('Center','generate-page-header');?></option>
							<option value="right" <?php selected( $stored_meta['_meta-generate-page-header-image-background-alignment'][0], 'right' ); ?>><?php _e('Right','generate-page-header');?></option>
						</select>
					</p>
					
					<p>
						<label for="_meta-generate-page-header-image-background-spacing" class="example-row-title"><strong><?php _e('Top/Bottom padding','generate-page-header');?></strong></label><br />
						<input placeholder="" style="width:45px" type="text" name="_meta-generate-page-header-image-background-spacing" id="_meta-generate-page-header-image-background-spacing" value="<?php echo intval( $stored_meta['_meta-generate-page-header-image-background-spacing'][0] ); ?>" /><label for="_meta-generate-page-header-image-background-spacing"><span class="pixels">px</span></label>
					</p>
					
					<p>
						<label for="_meta-generate-page-header-image-background-color" class="example-row-title"><strong><?php _e('Background color','generate-page-header');?></strong></label><br />
						<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-color" id="_meta-generate-page-header-image-background-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-color'][0]; ?>" />
					</p>
					
					<p>
						<label for="_meta-generate-page-header-image-background-text-color" class="example-row-title"><strong><?php _e('Text color','generate-page-header');?></strong></label><br />
						<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-text-color" id="_meta-generate-page-header-image-background-text-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-text-color'][0]; ?>" />
					</p>
					
					<p>
						<label for="_meta-generate-page-header-image-background-link-color" class="example-row-title"><strong><?php _e('Link color','generate-page-header');?></strong></label><br />
						<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-link-color" id="_meta-generate-page-header-image-background-link-color" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-link-color'][0]; ?>" />
					</p>
					
					<p>
						<label for="_meta-generate-page-header-image-background-link-color-hover" class="example-row-title"><strong><?php _e('Link color hover','generate-page-header');?></strong></label><br />
						<input class="color-picker" style="width:45px" type="text" name="_meta-generate-page-header-image-background-link-color-hover" id="_meta-generate-page-header-image-background-link-color-hover" value="<?php echo $stored_meta['_meta-generate-page-header-image-background-link-color-hover'][0]; ?>" />
					</p>
				</div>
			</div>
			<?php if ( 'post' == get_post_type() && !is_single() ) { ?>
				<div class="show-in-excerpt">
					<p>
						<input type="checkbox" name="_meta-generate-page-header-add-to-excerpt" id="_meta-generate-page-header-add-to-excerpt" value="yes" <?php if ( isset ( $stored_meta['_meta-generate-page-header-add-to-excerpt'] ) ) checked( $stored_meta['_meta-generate-page-header-add-to-excerpt'][0], 'yes' ); ?> /> <label for="_meta-generate-page-header-add-to-excerpt"><?php _e('Add to blog excerpt (if no Featured Image is set)','generate-page-header');?></label>
					</p>
				</div>
			<?php } ?>
		</div>
	</p>
	
	<script>
		jQuery(window).load(function($) {
		
			<?php if ( $stored_meta['_meta-generate-page-header-content'][0] == '' ) : ?>
				jQuery('#tabs-2').hide();
				jQuery('.nav-tab.image').addClass('active');
			<?php else : ?>
				jQuery('#tabs-1').hide();
				jQuery('.nav-tab.content').addClass('active');
			<?php endif; ?>
			
			jQuery('.nav-tab.image').click(function(e) {
				jQuery(this).addClass('active');
				jQuery('.nav-tab.content').removeClass('active');
				jQuery('#tabs-1').show();
				jQuery('#tabs-2').hide();
				return false;
			});
			jQuery('.nav-tab.content').click(function(e) {
				jQuery(this).addClass('active');
				jQuery('.nav-tab.image').removeClass('active');
				jQuery('#tabs-2').show();
				jQuery('#tabs-1').hide();
				return false;
			});
			if ( jQuery('#_meta-generate-page-header-enable-image-crop').val() == 'enable' ) {
				jQuery('#crop-enabled').show();
			}
            jQuery('#_meta-generate-page-header-enable-image-crop').change(function () {
                if (jQuery(this).val() === 'enable') {
                    jQuery('#crop-enabled').show();
                } else {
                    jQuery('#crop-enabled').hide();
                }
            });

			if (jQuery('#_meta-generate-page-header-image-background').is(':checked')) {
				jQuery('.image-background-enabled').show();
				jQuery('.show-in-excerpt').hide();
			}
			jQuery('#_meta-generate-page-header-image-background').on('click', function() {
				if( jQuery(this).is(':checked')) {
					//jQuery(".image-background-enabled").show();
					jQuery('.show-in-excerpt').hide();
				} else {
					//jQuery(".image-background-enabled").hide();
					jQuery('.show-in-excerpt').show();
				}
			}); 
			
			var $set_button = jQuery('.generate-upload-file');
			/**
			 * open the media manager
			 */
			$set_button.click(function (e) {
				e.preventDefault();
				
				var $thisbutton = jQuery(this);
				var frame = wp.media({
					title : $thisbutton.data('title'),
					multiple : false,
					library : { type : 'image' },
					button : { text : $thisbutton.data('insert') }
				});
				// close event media manager
				frame.on('select', function () {
					var attachment = frame.state().get('selection').first().toJSON();
					// set the file
					//set_dfi(attachment.url);
					$thisbutton.prev('input').val(attachment.url);
					$thisbutton.next('input').val(attachment.id);
					if ( $thisbutton.data('prev') === true ) {
						$thisbutton.prev('input').prev('#preview-image').children('.saved-image').remove();
						$thisbutton.prev('input').prev('#preview-image').append('<img src="' + attachment.url + '" width="100" class="saved-image" />');
					}
				});

				// everthing is set open the media manager
				frame.open();
			});
		});
		jQuery(document).ready(function($) {
			$('.color-picker').wpColorPicker();
		});
	</script>
	<style>
		.choose-content-options span {
			display:block;
			color:#222;
		}
		.choose-content-options div {
			margin-bottom:10px;
			border-bottom:1px solid #DDD;
			padding-bottom:10px;
		}
		.nav-tab.active {
			border-bottom:1px solid #fff;
			color:#124964;
			background:#FFF;
		}
		.nav-tab {
			margin-bottom: 0;
			position:relative;
			bottom: -1px;
		}
		#poststuff h2.nav-tab-wrapper {
			padding: 0;
		}
		.nav-tab:focus {
			outline: none;
		}
		h2.page-header .nav-tab {
			font-size:15px;
		}
		.small {
			display: block;
			font-size: 11px;
		}
	</style>
    <?php
}
endif;

if ( ! function_exists( 'save_generate_page_header_meta' ) ) :
// Save the Data  
add_action('save_post', 'save_generate_page_header_meta');
function save_generate_page_header_meta($post_id) {  
    
	// Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'generate_page_header_nonce' ] ) && wp_verify_nonce( $_POST[ 'generate_page_header_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
	
	// Checks for input and saves if needed
	if( isset( $_POST[ '_meta-generate-page-header-content' ] ) ) {
		update_post_meta( $post_id, '_meta-generate-page-header-content', $_POST[ '_meta-generate-page-header-content' ] );
	}
 
    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ '_meta-generate-page-header-image' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image', esc_url( $_POST[ '_meta-generate-page-header-image' ] ) );
    }
	
	// Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ '_meta-generate-page-header-image-id' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-id', intval( $_POST[ '_meta-generate-page-header-image-id' ] ) );
    }
	
	// Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ '_meta-generate-page-header-image-link' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-link', esc_url( $_POST[ '_meta-generate-page-header-image-link' ] ) );
    }
	
	// Checks for input and saves if needed
	if( isset( $_POST[ '_meta-generate-page-header-enable-image-crop' ] ) ) {
		update_post_meta( $post_id, '_meta-generate-page-header-enable-image-crop', $_POST[ '_meta-generate-page-header-enable-image-crop' ] );
	}
	
	// Checks for input and saves if needed
	if( isset( $_POST[ '_meta-generate-page-header-image-crop' ] ) ) {
		update_post_meta( $post_id, '_meta-generate-page-header-image-crop', $_POST[ '_meta-generate-page-header-image-crop' ] );
	}
	
	if( isset( $_POST[ '_meta-generate-page-header-content-autop' ] ) ) {
		update_post_meta( $post_id, '_meta-generate-page-header-content-autop', 'yes' );
	} else {
		update_post_meta( $post_id, '_meta-generate-page-header-content-autop', '' );
	}
	
	if( isset( $_POST[ '_meta-generate-page-header-content-padding' ] ) ) {
		update_post_meta( $post_id, '_meta-generate-page-header-content-padding', 'yes' );
	} else {
		update_post_meta( $post_id, '_meta-generate-page-header-content-padding', '' );
	}
	
	// Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ '_meta-generate-page-header-image-width' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-width', intval( $_POST[ '_meta-generate-page-header-image-width' ] ) );
    }
	
	// Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ '_meta-generate-page-header-image-height' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-height', intval( $_POST[ '_meta-generate-page-header-image-height' ] ) );
    }
	
	if ( 'post' == get_post_type() && !is_single() ) {
		if( isset( $_POST[ '_meta-generate-page-header-add-to-excerpt' ] ) ) {
			update_post_meta( $post_id, '_meta-generate-page-header-add-to-excerpt', 'yes' );
		} else {
			update_post_meta( $post_id, '_meta-generate-page-header-add-to-excerpt', '' );
		}
		
	}
	
	if( isset( $_POST[ '_meta-generate-page-header-image-background' ] ) ) {
		update_post_meta( $post_id, '_meta-generate-page-header-image-background', 'yes' );
	} else {
		update_post_meta( $post_id, '_meta-generate-page-header-image-background', '' );
	}
	
	if( isset( $_POST[ '_meta-generate-page-header-full-screen' ] ) ) {
		update_post_meta( $post_id, '_meta-generate-page-header-full-screen', 'yes' );
	} else {
		update_post_meta( $post_id, '_meta-generate-page-header-full-screen', '' );
	}
	
	if( isset( $_POST[ '_meta-generate-page-header-vertical-center' ] ) ) {
		update_post_meta( $post_id, '_meta-generate-page-header-vertical-center', 'yes' );
	} else {
		update_post_meta( $post_id, '_meta-generate-page-header-vertical-center', '' );
	}
	
	if( isset( $_POST[ '_meta-generate-page-header-image-background-type' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-background-type', $_POST[ '_meta-generate-page-header-image-background-type' ] );
    }
	
	if( isset( $_POST[ '_meta-generate-page-header-image-background-fixed' ] ) ) {
		update_post_meta( $post_id, '_meta-generate-page-header-image-background-fixed', 'yes' );
	} else {
		update_post_meta( $post_id, '_meta-generate-page-header-image-background-fixed', '' );
	}
	
	if( isset( $_POST[ '_meta-generate-page-header-image-background-alignment' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-background-alignment', $_POST[ '_meta-generate-page-header-image-background-alignment' ] );
    }
	
	if( isset( $_POST[ '_meta-generate-page-header-image-background-spacing' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-background-spacing', $_POST[ '_meta-generate-page-header-image-background-spacing' ] );
    }
	
	if( isset( $_POST[ '_meta-generate-page-header-image-background-color' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-background-color', $_POST[ '_meta-generate-page-header-image-background-color' ] );
    }
	
	if( isset( $_POST[ '_meta-generate-page-header-image-background-text-color' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-background-text-color', $_POST[ '_meta-generate-page-header-image-background-text-color' ] );
    }
	
	if( isset( $_POST[ '_meta-generate-page-header-image-background-link-color' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-background-link-color', $_POST[ '_meta-generate-page-header-image-background-link-color' ] );
    }
	
	if( isset( $_POST[ '_meta-generate-page-header-image-background-link-color-hover' ] ) ) {
        update_post_meta( $post_id, '_meta-generate-page-header-image-background-link-color-hover', $_POST[ '_meta-generate-page-header-image-background-link-color-hover' ] );
    }
}  
endif;

if ( ! function_exists( 'generate_page_header_get_defaults' ) ) :
/**
 * Set default options
 */
function generate_page_header_get_defaults()
{
	$generate_page_header_defaults = array(
		'page_header_position' => 'above-content',
		'post_header_position' => 'inside-content'
	);
	
	return apply_filters( 'generate_page_header_option_defaults', $generate_page_header_defaults );
}
endif;

if ( ! function_exists( 'generate_page_header_customize_register' ) ) :
add_action( 'customize_register', 'generate_page_header_customize_register' );
function generate_page_header_customize_register( $wp_customize ) {

	$defaults = generate_page_header_get_defaults();
	
	// Add Header Colors section
	$wp_customize->add_section(
		// ID
		'page_header_section',
		// Arguments array
		array(
			'title' => __( 'Page Header', 'generate-page-header' ),
			'capability' => 'edit_theme_options',
			'priority' => 50
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_page_header_settings[page_header_position]',
		// Arguments array
		array(
			'default' => $defaults['page_header_position'],
			'type' => 'option'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'page_header_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Page Header Position', 'generate-page-header' ),
			'section' => 'page_header_section',
			'choices' => array(
				'above-content' => __( 'Above Content Area', 'generate-page-header' ),
				'inside-content' => __( 'Inside Content Area', 'generate-page-header' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_page_header_settings[page_header_position]',
			'priority' => 37
		)
	);
	
	// Add Layout setting
	$wp_customize->add_setting(
		// ID
		'generate_page_header_settings[post_header_position]',
		// Arguments array
		array(
			'default' => $defaults['post_header_position'],
			'type' => 'option'
		)
	);
	
	// Add Layout control
	$wp_customize->add_control(
		// ID
		'post_header_control',
		// Arguments array
		array(
			'type' => 'select',
			'label' => __( 'Single Post Header Position', 'generate-page-header' ),
			'section' => 'page_header_section',
			'choices' => array(
				'above-content' => __( 'Above Content Area', 'generate-page-header' ),
				'inside-content' => __( 'Inside Content Area', 'generate-page-header' ),
				'below-title' => __( 'Below Post Title', 'generate-page-header' )
			),
			// This last one must match setting ID from above
			'settings' => 'generate_page_header_settings[post_header_position]',
			'priority' => 38
		)
	);
}
endif;

if ( ! function_exists( 'generate_page_header_admin_style' ) ) :
	add_action( 'admin_head','generate_page_header_admin_style' );
	function generate_page_header_admin_style()
	{
		echo '<style>.appearance_page_page_header #footer-upgrade {display: none;}</style>';
	}
endif;

if ( ! function_exists( 'generate_get_attachment_id_by_url' ) ) :
/**
* Return an ID of an attachment by searching the database with the file URL.
*
* First checks to see if the $url is pointing to a file that exists in
* the wp-content directory. If so, then we search the database for a
* partial match consisting of the remaining path AFTER the wp-content
* directory. Finally, if a match is found the attachment ID will be
* returned.
*
* @param string $url The URL of the image (ex: http://mysite.com/wp-content/uploads/2013/05/test-image.jpg)
*
* @return int|null $attachment Returns an attachment ID, or null if no attachment is found
*/
function generate_get_attachment_id_by_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	// Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		// Finally, run a custom database query to get the attachment ID from the modified attachment URL
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}
endif;