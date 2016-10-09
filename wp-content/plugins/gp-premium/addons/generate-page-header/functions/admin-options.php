<?php
/**
 * Create the blog page header options page
 *
 * @category Generate Page Header
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */
if ( ! defined( 'CMB2_LOADED' ) ) :
	if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
		require_once dirname( __FILE__ ) . '/cmb2/init.php';
	} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
		require_once dirname( __FILE__ ) . '/CMB2/init.php';
	}
endif;

if ( ! function_exists( 'generate_cmb2_render_text_number' ) ) :
/**
 * Create text_number type
 */
add_action( 'cmb2_render_text_number', 'generate_cmb2_render_text_number', 10, 5 );
function generate_cmb2_render_text_number( $field_args, $escaped_value, $object_id, $object_type, $field_type_object ) {
    echo $field_type_object->input( array( 'class' => 'cmb2_text_small', 'type' => 'text', 'style' => 'width:75px;' ) );
}
endif;

if ( ! function_exists( 'generate_cmb2_validate_text_number' ) ) :
/**
 * Validate text_number type
 */
add_filter( 'cmb2_validate_text_number', 'generate_cmb2_validate_text_number' );
function generate_cmb2_validate_text_number( $new ) {
	
	if ( is_numeric( $new ) ) {
		$return = $new;
	} else {
		$return = null;
	}
    return $return;
}
endif;

if ( ! function_exists( 'generate_options_modify_cmb2_metabox_form_format' ) ) :
/**
 * Modify CMB2 Default Form Output
 *
 * @param  string  $form_format Form output format
 * @param  string  $object_id   In the case of an options page, this will be the option key
 * @param  object  $cmb         CMB2 object. Can use $cmb->cmb_id to retrieve the metabox ID
 *
 * @return string               Possibly modified form output
 */
add_filter( 'cmb2_get_metabox_form_format', 'generate_options_modify_cmb2_metabox_form_format', 10, 3 );
function generate_options_modify_cmb2_metabox_form_format( $form_format, $object_id, $cmb ) {

    if ( 'generate_page_header_options' == $object_id && 'option_metabox' == $cmb->cmb_id ) {

        return '<form class="cmb-form" method="post" id="%1$s" enctype="multipart/form-data" encoding="multipart/form-data">
					<input type="hidden" name="object_id" value="%2$s">
					<div id="poststuff">
						<div id="post-body" class="metabox-holder columns-2">
							<div id="post-body-content" style="position:relative;">
								<div class="postbox generate-metabox">
									<div class="inside" style="padding-top:0">%3$s</div>
								</div>
							</div>
							<div id="postbox-container-1" class="postbox-container">
								<div class="postbox">
									<h3 class="hndle">' . __( 'Blog Page Header','generate-page-header' ) . '</h3>
									<div class="inside">
										<p style="margin-top:0">' . __( 'Add a page header to your blog.','generate-page-header' ) . '</p>
										<p>' . __( 'This will only show up on the page you have set as your "Posts Page". To add a page header to specific pages, use the metabox included while adding your content.','generate-page-header' ) . '</p>
									</div>
								</div>
								<div class="postbox sticky-scroll-box">
									<h3 class="hndle">' . __( 'Publish','generate-page-header' ) . '</h3>
									<div class="inside">
										<input type="submit" name="submit-cmb" value="' . __( 'Save Settings', 'generate-page-header' ) . '" class="button-primary">
									</div>
								</div>
							</div>
						</div>
						<br class="clear" />
					</div>
					
				</form>';
    }

    return $form_format;
}
endif;

if ( ! class_exists( 'generate_page_header' ) ) :
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class generate_page_header {

    /**
     * Option key, and option page slug
     * @var string
     */
    private $key = 'generate_page_header_options';

    /**
     * Array of metaboxes/fields
     * @var array
     */
    protected $option_metabox = array();

    /**
     * Options Page title
     * @var string
     */
    protected $title = '';
	
	/**
     * Options Page description
     * @var string
     */
    protected $description = '';

    /**
     * Options Page hook
     * @var string
     */
    protected $options_page = '';

    /**
     * Constructor
     * @since 0.1.0
     */
    public function __construct() {
	
        // Set our title
        $this->title = __( 'Blog Page Header', 'generate-page-header' );
		
		// Set our description
        $this->description = __( 'Use these options to add a page header to your Blog. Add page headers to your pages by using the metabox while editing them.', 'generate-page-header' );

        // Set our CMB2 fields
        $this->fields = array(
			array(
				'name' => __( 'Image Options', 'generate-page-header' ),
				'desc' => __( 'Upload an image to use in your page header','generate-page-header' ),
				'type' => 'title',
				'id'   => 'page_header_image_options_title',
			),
            array(
                'name' => __( 'Image', 'generate-page-header' ),
                'desc' => __( 'Upload an image to be used as your page header.', 'generate-page-header' ),
                'id'   => 'page_header_image',
                'type' => 'file',
            ),
            array(
                'name'    => __( 'Page Header Link', 'generate-page-header' ),
                'desc'    => __( 'Make your page header image clickable by adding a URL. (optional)', 'generate-page-header' ),
                'id'      => 'page_header_url',
                'type'    => 'text_url',
                'default' => ''
            ),
			array(
				'name'    => __( 'Hard Crop', 'generate-page-header' ),
				'desc'    => __( 'Turn hard cropping or of off.', 'generate-page-header' ),
				'id'      => 'page_header_hard_crop',
				'type'    => 'select',
				'options' => array(
					'enable' => __( 'Enable', 'generate-page-header' ),
					'disable'   => __( 'Disable', 'generate-page-header' )
				),
				'default' => 'disable',
			),
			// array(
				// 'name'    => __( 'Hard Crop Position', 'generate-page-header' ),
				// 'desc'    => __( 'Choose where to crop the image.', 'generate-page-header' ),
				// 'id'      => 'page_header_image_crop_position',
				// 'type'    => 'select',
				// 'options' => array(
					// 'c' => __( 'Center', 'generate-page-header' ),
					// 'tl'   => __( 'Top Left', 'generate-page-header' ),
					// 'tr'   => __( 'Top Right', 'generate-page-header' ),
					// 'bl'   => __( 'Bottom Left', 'generate-page-header' ),
					// 'br'   => __( 'Bottom Right', 'generate-page-header' ),
					// 'l'   => __( 'Left', 'generate-page-header' ),
					// 'r'   => __( 'Right', 'generate-page-header' )
				// ),
				// 'default' => 'c',
			// ),
			array(
                'name'    => __( 'Image Width', 'generate-page-header' ),
                'desc'    => __( 'Choose your image width in pixels. (integer only, default is 1200)', 'generate-page-header' ),
                'id'      => 'page_header_image_width',
                'type'    => 'text_number',
                'default' => '1200'
            ),
			array(
                'name'    => __( 'Image Height', 'generate-page-header' ),
                'desc'    => __( 'Choose your image height in pixels. Use "0" or leave blank for proportional resizing. (integer only, default is 0) ', 'generate-page-header' ),
                'id'      => 'page_header_image_height',
                'type'    => 'text_number',
                'default' => '0'
            ),
			array(
				'name' => __( 'Content Options', 'generate-page-header' ),
				'desc' => __( 'Add content to your page header','generate-page-header' ),
				'type' => 'title',
				'id'   => 'page_header_content_options_title',
			),
			array(
				'name' => __( 'Content', 'generate-page-header' ),
				'desc' => __( 'Add your content to the page header. HTML and shortcodes allowed.', 'generate-page-header' ),
				'id' => 'page_header_content',
				'type' => 'textarea'
			),
			array(
				'name'    => __( 'Add Paragraphs', 'generate-page-header' ),
				'desc'    => __( 'Wrap your text in paragraph tags automatically.', 'generate-page-header' ),
				'id'      => 'page_header_add_paragraphs',
				'type'    => 'select',
				'options' => array(
					'1' => __( 'Enable', 'generate-page-header' ),
					'0'   => __( 'Disable', 'generate-page-header' )
				),
				'default' => 'disable',
			),
			array(
				'name'    => __( 'Add Padding', 'generate-page-header' ),
				'desc'    => __( 'Add padding around your content.', 'generate-page-header' ),
				'id'      => 'page_header_add_padding',
				'type'    => 'select',
				'options' => array(
					'1' => __( 'Enable', 'generate-page-header' ),
					'0'   => __( 'Disable', 'generate-page-header' )
				),
				'default' => 'disable',
			),
			array(
				'name'    => __( 'Image Background', 'generate-page-header' ),
				'desc'    => __( 'Use the image uploaded above as a background image for your content. (requires image uploaded above)', 'generate-page-header' ),
				'id'      => 'page_header_image_background',
				'type'    => 'select',
				'options' => array(
					'1' => __( 'Enable', 'generate-page-header' ),
					'0'   => __( 'Disable', 'generate-page-header' )
				),
				'default' => 'disable',
			),
			array(
				'name'    => __( 'Parallax Background', 'generate-page-header' ),
				'desc'    => __( 'Add a cool parallax effect to your background image. (requires the image background option to be checked)', 'generate-page-header' ),
				'id'      => 'page_header_add_parallax',
				'type'    => 'select',
				'options' => array(
					'1' => __( 'Enable', 'generate-page-header' ),
					'0'   => __( 'Disable', 'generate-page-header' )
				),
				'default' => 'disable',
			),
			array(
				'name'    => __( 'Full Screen', 'generate-page-header' ),
				'desc'    => __( 'Make your page header content area full screen.', 'generate-page-header' ),
				'id'      => 'page_header_full_screen',
				'type'    => 'select',
				'options' => array(
					'1' => __( 'Enable', 'generate-page-header' ),
					'0'   => __( 'Disable', 'generate-page-header' )
				),
				'default' => 'disable',
			),
			array(
				'name'    => __( 'Vertical Center', 'generate-page-header' ),
				'desc'    => __( 'Center your page header content vertically.', 'generate-page-header' ),
				'id'      => 'page_header_vertical_center',
				'type'    => 'select',
				'options' => array(
					'1' => __( 'Enable', 'generate-page-header' ),
					'0'   => __( 'Disable', 'generate-page-header' )
				),
				'default' => 'disable',
			),
			array(
				'name'    => __( 'Container Type', 'generate-page-header' ),
				'desc'    => __( 'Choose whether the page header is contained or fluid.', 'generate-page-header' ),
				'id'      => 'page_header_container_type',
				'type'    => 'select',
				'options' => array(
					'contained' => __( 'Contained', 'generate-page-header' ),
					'fluid'   => __( 'Fluid', 'generate-page-header' )
				),
				'default' => 'contained',
			),
			array(
				'name'    => __( 'Text Alignment', 'generate-page-header' ),
				'desc'    => __( 'Choose the horizontal alignment of your content.', 'generate-page-header' ),
				'id'      => 'page_header_text_alignment',
				'type'    => 'select',
				'options' => array(
					'left' => __( 'Left', 'generate-page-header' ),
					'center'   => __( 'Center', 'generate-page-header' ),
					'right'   => __( 'Right', 'generate-page-header' )
				),
				'default' => 'left',
			),
			array(
                'name'    => __( 'Top/Bottom Padding', 'generate-page-header' ),
                'desc'    => __( 'Choose your content padding in pixels. This will add space above and below your content. (integer only) ', 'generate-page-header' ),
                'id'      => 'page_header_padding',
                'type'    => 'text_number',
                'default' => ''
            ),
			array(
				'name'    => __( 'Background Color', 'generate-page-header' ),
				'id'   => 'page_header_background_color',
				'type' => 'colorpicker',
				'default'  => '',
			),
			array(
				'name'    => __( 'Text Color', 'generate-page-header' ),
				'id'   => 'page_header_text_color',
				'type' => 'colorpicker',
				'default'  => '',
			),
			array(
				'name'    => __( 'Link Color', 'generate-page-header' ),
				'id'   => 'page_header_link_color',
				'type' => 'colorpicker',
				'default'  => '',
			),
			array(
				'name'    => __( 'Link Hover Color', 'generate-page-header' ),
				'id'   => 'page_header_link_color_hover',
				'type' => 'colorpicker',
				'default'  => '',
			),
        );
    }

    /**
     * Initiate our hooks
     * @since 0.1.0
     */
    public function hooks() {
        add_action( 'admin_init', array( $this, 'init' ) );
        add_action( 'admin_menu', array( $this, 'add_options_page' ) );
    }

    /**
     * Register our setting to WP
     * @since  0.1.0
     */
    public function init() {
        register_setting( $this->key, $this->key );
    }

    /**
     * Add menu options page
     * @since 0.1.0
     */
    public function add_options_page() {
        //$this->options_page = add_menu_page( $this->title, $this->menu, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
        $this->options_page = add_submenu_page( 'themes.php', $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
    }

    /**
     * Admin page markup. Mostly handled by CMB2
     * @since  0.1.0
     */
    public function admin_page_display() {
        ?>
        <div class="wrap cmb2_options_page <?php echo $this->key; ?>">
            <?php cmb2_metabox_form( $this->option_metabox(), $this->key ); ?>
			<style>
				.generate-page-header-options-desc {
					margin-bottom: 1.5em;
				}
				.generate_page_header_options .cmb-type-title {
					padding: 20px 12px !important;
					margin: 20px 0 !important;
					border-top: 1px solid #eee;
					border-bottom: 1px solid #eee;
				}
				.generate_page_header_options .cmb-field-list .cmb-type-title:first-child {
					margin-top: 0 !important;
					border-top: 0;
				}
				.generate_page_header_options .inside {
					margin-top: 0 !important;
					padding: 12px;
				}
				.generate_page_header_options #poststuff .cmb-type-title .cmb2-metabox-description {
					padding: 0;
					color:#bbb;
				}
				.generate_page_header_options #poststuff .cmb-type-title h3 {
					padding: 0;
					font-size: 115%;
				}
				
				.generate_page_header_options #poststuff .cmb2-metabox-description:last-child {
					padding-bottom: 0;
				}
				.generate_page_header_options .cmb-row {
					border-bottom: 1px solid #eee;
					padding: 12px;
				}
				.generate_page_header_options .cmb2-id-page-header-hard-crop,
				.generate_page_header_options .cmb2-id-page-header-image-crop-position,
				.generate_page_header_options .cmb2-id-page-header-image-width,
				.generate_page_header_options .cmb2-id-page-header-image-height {
					border-bottom: 0;
				}
				#post-body-content .inside {
					padding: 0;
				}
				@media screen and (min-width: 852px) {
					.generate_page_header_options .sticky-scroll-box.fixed {
						position:fixed;
						right: 18px;
						top: 20px;
					}
					.admin-bar .generate_page_header_options .sticky-scroll-box.fixed {
						top: 52px;
					}
				}
			</style>
			<script>
				// Hard crop hide/show
				jQuery('.cmb2-id-page-header-image-crop-position').hide();
				jQuery('.cmb2-id-page-header-image-width').hide();
				jQuery('.cmb2-id-page-header-image-height').hide();
				if ( jQuery('#page_header_hard_crop').val() == 'enable' ) {
					jQuery('.cmb2-id-page-header-image-crop-position').show();
					jQuery('.cmb2-id-page-header-image-width').show();
					jQuery('.cmb2-id-page-header-image-height').show();
				}
				jQuery('#page_header_hard_crop').change(function () {
					if (jQuery(this).val() === 'enable') {
						jQuery('.cmb2-id-page-header-image-crop-position').show();
						jQuery('.cmb2-id-page-header-image-width').show();
						jQuery('.cmb2-id-page-header-image-height').show();
					} else {
						jQuery('.cmb2-id-page-header-image-crop-position').hide();
						jQuery('.cmb2-id-page-header-image-width').hide();
						jQuery('.cmb2-id-page-header-image-height').hide();
					}
				});
				
				// Image background hide/show
				jQuery('.cmb2-id-page-header-add-parallax').hide();
				if ( jQuery('#page_header_image_background').val() == '1' ) {
					jQuery('.cmb2-id-page-header-add-parallax').show();
					jQuery('.cmb2-id-page-header-image-background').css('border-width','0');
				}
				jQuery('#page_header_image_background').change(function () {
					if (jQuery(this).val() === '1') {
						jQuery('.cmb2-id-page-header-add-parallax').show();
						jQuery('.cmb2-id-page-header-image-background').css('border-width','0');
					} else {
						jQuery('.cmb2-id-page-header-add-parallax').hide();
						jQuery('.cmb2-id-page-header-image-background').css('border-width','1px');
					}
				});
				jQuery(document).ready(function($) {  
					var top = $('.sticky-scroll-box').offset().top;
					$(window).scroll(function (event) {
						var y = $(this).scrollTop();
						if (y >= top)
							$('.sticky-scroll-box').addClass('fixed');
						else
						$('.sticky-scroll-box').removeClass('fixed');
						$('.sticky-scroll-box').width($('.sticky-scroll-box').parent().width());
					});
				});
			</script>
        </div>
        <?php
    }

    /**
     * Defines the theme option metabox and field configuration
     * @since  0.1.0
     * @return array
     */
    public function option_metabox() {
        return array(
            'id'         => 'option_metabox',
            'show_on'    => array( 'key' => 'options-page', 'value' => array( $this->key, ), ),
            'show_names' => true,
            'fields'     => $this->fields,
        );
    }

    /**
     * Public getter method for retrieving protected/private variables
     * @since  0.1.0
     * @param  string  $field Field to retrieve
     * @return mixed          Field value or exception is thrown
     */
    public function __get( $field ) {

        // Allowed fields to retrieve
        if ( in_array( $field, array( 'key', 'fields', 'title', 'options_page' ), true ) ) {
            return $this->{$field};
        }
        if ( 'option_metabox' === $field ) {
            return $this->option_metabox();
        }

        throw new Exception( 'Invalid property: ' . $field );
    }

}

// Get it started
$generate_page_header = new generate_page_header();
$generate_page_header->hooks();
endif;

if ( ! function_exists( 'generate_page_header_get_option' ) ) :
/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function generate_page_header_get_option( $key = '' ) {
    global $generate_page_header;
    return cmb2_get_option( $generate_page_header->key, $key );
}
endif;