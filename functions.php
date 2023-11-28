<?php
//Theme Translation
  load_theme_textdomain('daneshyar', get_template_directory() . '/languages');
  $locale = get_locale();
  $locale_file = TEMPLATEPATH . '/languages/' . $locale . '.php';
  if(is_readable($locale_file)) {
  require_once($locale_file);
  }

// Get Elementor Footer
if ( ! function_exists( 'daneshyar_get_footer_list' ) ) {
	function daneshyar_get_footer_list() {
  
	  $footers = array(
		'no-footer' => esc_html__( 'فوتر پیش فرض قالب', 'daneshyar' ),
	  );
  
	  $footers_args = array(
		'post_type'     => 'footer',
		'post_status'   => 'publish',
		'posts_per_page'=> -1,
	  );
  
	  $footers_query = new WP_Query( $footers_args );
  
	  foreach( $footers_query->posts as $footer ){
		$footers[$footer->ID] = $footer->post_title;
	  }
  
	  return $footers;
	}
  }

// Get Elementor Header
if ( ! function_exists( 'daneshyar_get_header_list' ) ) {
	function daneshyar_get_header_list() {
  
	  $headers = array(
		'no-header' => esc_html__( 'هدر پیش فرض قالب', 'daneshyar' ),
	  );
  
	  $header_args = array(
		'post_type'     => 'header',
		'post_status'   => 'publish',
		'posts_per_page'=> -1,
	  );
  
	  $header_query = new WP_Query( $header_args );
  
	  foreach( $header_query->posts as $header ){
		$headers[$header->ID] = $header->post_title;
	  }
  
	  return $headers;
	}
  }

require_once get_template_directory().'/inc/plugins/TGM-plugin/class-tgm-plugin-activation.php';

function daneshyar_register_required_plugins() {
	$plugins = array(

	array(
		'name'               => esc_html__('Daneshyar Core','daneshyar' ), // The plugin name.
		'slug'               => 'daneshyar-core', // The plugin slug (typically the folder name).
		'source'             => get_template_directory() . '/inc/plugins/daneshyar-core.zip', // The plugin source.
		'required'           => true, // If false, the plugin is only 'recommended' instead of required.
		'version'            => $theme_version, // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
	),
	array(
		'name'               => esc_html__('Redux Framework','daneshyar' ), 
		'slug'               => 'redux-framework', 
		'required'           => true, 
	),
    array(
			'name'               => esc_html__('Elementor','daneshyar' ), 
			'slug'               => 'elementor', 
			'required'           => true, 
		),
		array(
			'name'               => esc_html__('تکه‌مسیر NavXT','daneshyar' ), 
			'slug'               => 'breadcrumb-navxt', 
			'required'           => true, 
		),
    array(
			'name'               => esc_html__('Mailchimp','daneshyar' ), 
			'slug'               => 'mailchimp-for-wp', 
			'required'           => false, 
		),
    array(
			'name'               => esc_html__('Woocommerce','daneshyar' ), 
			'slug'               => 'woocommerce', 
			'required'           => true, 
		),
    array(
			'name'               => esc_html__('Woo Wallet','daneshyar' ),
			'slug'               => 'woo-wallet', 
			'required'           => false, 
		),


	);

	$config = array(
		'id'           => 'daneshyar',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'daneshyar_register_required_plugins' );

//redux
if ( !class_exists( 'ReduxFramework' ) && file_exists( WP_PLUGIN_DIR.'/redux-framework/redux-core/framework.php' ) ) {
    require_once( WP_PLUGIN_DIR . '/redux-framework/redux-core/framework.php' );
}
if (class_exists( 'ReduxFramework' )) {
    require_once(get_parent_theme_file_path('/inc/panel-settings.php'));
    require_once(get_parent_theme_file_path('/inc/call_files.php'));
}


if (!function_exists('is_plugin_active')) {
  include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}
//require files
require_once get_parent_theme_file_path('/inc/mega-menus.php');
require get_parent_theme_file_path('/inc/woocommerce_function.php');
require get_parent_theme_file_path('/inc/daneshyar_function.php');

//after setup theme
function daneshar_after_theme_setup(){
  add_theme_support( 'post-formats', array( 'audio', 'video' ) );
  //dynamic title
  add_theme_support('title-tag');
  add_theme_support('woocommerce');
  add_image_size('daneshyar-420x294', 420,294,true);
  add_image_size('daneshyar-120x120', 120,120,true);
  add_image_size('daneshyar-370x270', 370,270,true);
}
add_action( 'after_setup_theme','daneshar_after_theme_setup' );

  //top bar left menu
  function daneshyar_tob_bar_menu(){
    register_nav_menus(
        array(
            'main-menu' => esc_html__('Main Header Menu','daneshyar'),
			'mobile-menu' => esc_html__('Mobile Side Menu', 'daneshyar' ),
            'top-bar-menu' => esc_html__('Top Bar Menu','daneshyar')
        )
    );

    //add teacher post type
    register_post_type('teacher',
    array(
      'labels'  => array(
        'name' => __('مدرسین'),
        'singular_name' => __('مدرس'),
        'add_new'               => __( 'افزودن مدرس'),
        'add_new_item'          => __( 'افزودن مدرس'),
		'edit_item'           => __( 'ویرایش مدرس', 'daneshyar' ),
		'update_item'         => __( 'بروزرسانی مدرس', 'daneshyar' ),
      ),
      'menu_icon' =>'dashicons-businesswoman',
      'public'  => true,
      'has_archive' =>false,
      'supports'  => array('title','editor','thumbnail','link','excerpt'),
    ));
	//add header post type
	register_post_type('header',
	array(
		'labels'  => array(
		'name'                => _x( 'هدرها', 'Post Type General Name', 'daneshyar' ),
		'singular_name'       => _x( 'هدر', 'Post Type Singular Name', 'daneshyar' ),
		'menu_name'           => __( 'هدرها', 'daneshyar' ),
		'parent_item_colon'   => __( 'هدر والد:', 'daneshyar' ),
		'all_items'           => __( 'همه هدرها', 'daneshyar' ),
		'view_item'           => __( 'مشاهده هدر', 'daneshyar' ),
		'add_new_item'        => __( 'افزودن هدر جدید', 'daneshyar' ),
		'add_new'             => __( 'افزودن جدید', 'daneshyar' ),
		'edit_item'           => __( 'ویرایش هدر', 'daneshyar' ),
		'update_item'         => __( 'بروزرسانی هدر', 'daneshyar' ),
		'search_items'        => __( 'جستجوی هدر', 'daneshyar' ),
		'not_found'           => __( 'یافت نشد', 'daneshyar' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'daneshyar' ),
	),
		'public'  => true,
		'has_archive' =>false,
		'menu_icon' =>'dashicons-arrow-up-alt2',
		'supports'  => array('title','editor'),
		'description'         => __( 'نوشته نوع هدر', 'daneshyar' ),
	));
	//add footer post type
	register_post_type('footer',
	array(
		'labels'  => array(
		'name'                => _x( 'فوترها', 'Post Type General Name', 'daneshyar' ),
		'singular_name'       => _x( 'فوتر', 'Post Type Singular Name', 'daneshyar' ),
		'menu_name'           => __( 'فوترها', 'daneshyar' ),
		'parent_item_colon'   => __( 'فوتر والد:', 'daneshyar' ),
		'all_items'           => __( 'همه فوترها', 'daneshyar' ),
		'view_item'           => __( 'مشاهده فوتر', 'daneshyar' ),
		'add_new_item'        => __( 'افزودن فوتر جدید', 'daneshyar' ),
		'add_new'             => __( 'افزودن جدید', 'daneshyar' ),
		'edit_item'           => __( 'ویرایش فوتر', 'daneshyar' ),
		'update_item'         => __( 'بروزرسانی فوتر', 'daneshyar' ),
		'search_items'        => __( 'جستجوی فوتر', 'daneshyar' ),
		'not_found'           => __( 'یافت نشد', 'daneshyar' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'daneshyar' ),
	),
		'public'  => true,
		'has_archive' =>false,
		'menu_icon' =>'dashicons-arrow-down-alt2',
		'supports'  => array('title','editor'),
		'description'         => __( 'نوشته نوع فوتر', 'daneshyar' ),
	));

  }
  add_action('init','daneshyar_tob_bar_menu');

  # Mobile Navigation
if ( ! function_exists( 'daneshyar_mobile_nav' ) ) {
    function daneshyar_mobile_nav() {
        get_template_part( 'inc/templates/mobile-nav' );
    }

    add_action( 'daneshyar_before_body', 'daneshyar_mobile_nav', 20 );
}

// Enqueue styles
function daneshyar_theme_scripts() {
	global $theme_version;
	$theme_obj = wp_get_theme();
	$theme_version = $theme_obj->get('Version');

    wp_enqueue_style( 'main-style', get_stylesheet_uri() );
    wp_enqueue_style( 'fontawesome', get_template_directory_uri().'/assets/css/fontawesome.min.css' );
    wp_enqueue_style( 'fontawesome2', get_template_directory_uri().'/assets/css/font-awesome.min.css' );
    wp_enqueue_style( 'daneshyar', get_template_directory_uri().'/assets/css/daneshyar.css' );
    wp_enqueue_style( 'carousel', get_template_directory_uri().'/assets/css/owl.carousel.min.css' );
    wp_enqueue_style( 'theme_carousel', get_template_directory_uri().'/assets/css/owl.theme.default.min.css' );
	
    wp_enqueue_script( 'carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array("jquery"), $theme_version, true );
    wp_enqueue_script( 'daneshyar', get_template_directory_uri() . '/assets/js/daneshyar.js', array("jquery"), $theme_version, true );
    wp_enqueue_script( 'sticky-sidebar', get_template_directory_uri() . '/assets/js/theia-sticky-sidebar.min.js', array("jquery"), $theme_version, true );
    wp_enqueue_script( 'countdown', get_template_directory_uri() . '/assets/js/countdown.min.js', array("jquery"), $theme_version, true );
    wp_enqueue_script( 'accordion-lib', get_template_directory_uri() . '/assets/js/jquery-ui.min.js', array("jquery"), $theme_version, true );
}
add_action( 'wp_enqueue_scripts', 'daneshyar_theme_scripts' );

# Enqueue admin styles
function daneshyar_enqueue_admin_styles() {

	if ( is_admin() ) {
		wp_enqueue_style( 'admin-style', get_theme_file_uri('/assets/css/theme-admin.css' ));
	}
}
add_action( 'admin_enqueue_scripts', 'daneshyar_enqueue_admin_styles' );

//breadcrumb
if(! function_exists('denshyar_breadcrumb')){
  function denshyar_breadcrumb(){
    if(function_exists('bcn_display')){ ?>
      <div class="breadcrumb">
        <?php bcn_display(); ?>
      </div>
    <?php
    }
  }
}

//post view count
  function denshyar_post_view_counter(){
    if(is_single( )){
      global $post;
      $count_post = esc_attr(get_post_meta($post->ID,'_post_view_count',true));
      if($count_post == ''){
        $count_post = 1;
        add_post_meta( $post->ID,'_post_view_count',$count_post );
      }else{
        $count_post = (int)$count_post+1;
        update_post_meta($post->ID,'_post_view_count',$count_post);
      }

    }
  }
add_action( 'wp_head', 'denshyar_post_view_counter');

if(! function_exists('denshyar_post_view_count')){
  function denshyar_post_view_count(){
    global $post;
    $visitor_count = get_post_meta($post->ID,'_post_view_count',true);
    if($visitor_count == ''){$visitor_count = 0;}
    if($visitor_count>= 1000){
      $visitor_count = round(($visitor_count/1000),2);
      $visitor_count = $visitor_count.'k';
    }
    echo esc_attr( $visitor_count ).' بازدید ';

  }
}

//Register widgets
add_action( 'widgets_init', 'daneshyar_widgets_init' );

function daneshyar_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'daneshyar' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'daneshyar' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		)
	);

  register_sidebar(
		array(
			'name'          => esc_html__( 'فوتر 1', 'daneshyar' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'daneshyar' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
    ),
	);
   register_sidebar( 
    array(
			'name'          => esc_html__( 'فوتر 2', 'daneshyar' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'daneshyar' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		),
  );
  register_sidebar( 
    array(
			'name'          => esc_html__( 'فوتر 3', 'daneshyar' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'daneshyar' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		),
  );
  register_sidebar( 
    array(
			'name'          => esc_html__( 'فوتر 4', 'daneshyar' ),
			'id'            => 'footer-4',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'daneshyar' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		),
  );
  register_sidebar( 
    array(
			'name'          => esc_html__( 'صفحات دوره ها', 'daneshyar' ),
			'id'            => 'course_page',
			'description'   => esc_html__( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'daneshyar' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		),
  );
}

if(class_exists('Redux')){

	function shortcode_social_networks(){

		$facebook = daneshyar_settings('social_network_link_fb');
		$telegram = daneshyar_settings('social_network_link_tlg');
		$whatsapp = daneshyar_settings('social_network_link_wpp');
		$twitter = daneshyar_settings('social_network_link_tw');
		$linkedin = daneshyar_settings('social_network_link_lin');
		$youtube = daneshyar_settings('social_network_link_yt');
		$vimeo = daneshyar_settings('social_network_link_vm');
		$dribbble = daneshyar_settings('social_network_link_drb');
		$dribbble = daneshyar_settings('social_network_link_drb');
		$instagram = daneshyar_settings('social_network_link_ig');
		$pinterest = daneshyar_settings('social_network_link_pi');
		$VKontakte = daneshyar_settings('social_network_link_vk');
		$flickr = daneshyar_settings('social_network_link_fl');
		$behance = daneshyar_settings('social_network_link_be');
		$foursquare = daneshyar_settings('social_network_link_fs');
		$skype = daneshyar_settings('social_network_link_sk');
		$tumblr = daneshyar_settings('social_network_link_tu');
		$deviantart = daneshyar_settings('social_network_link_da');
		$github = daneshyar_settings('social_network_link_gh');
		$houzz = daneshyar_settings('social_network_link_hz');
		$px500 = daneshyar_settings('social_network_link_px');
		$xing = daneshyar_settings('social_network_link_xing');
		$vine = daneshyar_settings('social_network_link_vi');
		$snapchat = daneshyar_settings('social_network_link_sn');
		$email = daneshyar_settings('social_network_link_em');
		$yelp = daneshyar_settings('social_network_link_yp');
		$tripadvisor = daneshyar_settings('social_network_link_ta');

		$social_order_list  =  array(
			'fb'      => array(
				'title'  => 'Facebook',
				'icon'   => 'fa fa-facebook-f',
				'href'	 =>$facebook,
			),
			'tlg'      => array(
				'title'  => 'Telegram',
				'icon'   => 'fa fa-telegram',
				'href'	 =>$telegram,
			),
			'wpp'      => array(
				'title'  => 'Whatsapp',
				'icon'   => 'fa fa-whatsapp',
				'href'	 =>$whatsapp,
			),
			'tw'      => array(
				'title'  => 'Twitter',
				'icon'   => 'fa fa-twitter',
				'href'	 =>$twitter,
			),
			'lin'     => array(
				'title'  => 'LinkedIn',
				'icon'   => 'fa fa-linkedin',
				'href'	 =>$linkedin,
			),
			'yt'      => array(
				'title'  => 'YouTube',
				'icon'   => 'fa fa-youtube-play',
				'href'	 =>$youtube,
			),
			'vm'      => array(
				'title'  => 'Vimeo',
				'icon'   => 'fa fa-vimeo',
				'href'	 =>$vimeo,
			),
			'drb'     => array(
				'title'  => 'Dribbble',
				'icon'   => 'fa fa-dribbble',
				'href'	 =>$dribbble,
			),
			'ig'      => array(
				'title'  => 'Instagram',
				'icon'   => 'fa fa-instagram',
				'href'	 =>$instagram,
			),
			'pi'      => array(
				'title'  => 'Pinterest',
				'icon'   => 'fa fa-pinterest',
				'href'	 =>$pinterest,
			),
			'vk'      => array(
				'title'  => 'VKontakte',
				'icon'   => 'fa fa-vk',
				'href'	 =>$VKontakte,
			),
			'fl'      => array(
				'title'  => 'Flickr',
				'icon'   => 'fa fa-flickr',
				'href'	 =>$flickr,
			),
			'be'      => array(
				'title'  => 'Behance',
				'icon'   => 'fa fa-behance',
				'href'	 =>$behance,
			),
			'fs'      => array(
				'title'  => 'Foursquare',
				'icon'   => 'fa fa-foursquare',
				'href'	 =>$foursquare,
			),
			'sk'      => array(
				'title'  => 'Skype',
				'icon'   => 'fa fa-skype',
				'href'	 =>$skype,
			),
			'tu'      => array(
				'title'  => 'Tumblr',
				'icon'   => 'fa fa-tumblr',
				'href'	 =>$tumblr,
			),
			'da'      => array(
				'title'  => 'DeviantArt',
				'icon'   => 'fa fa-deviantart',
				'href'	 =>$deviantart,
			),
			'gh'      => array(
				'title'  => 'GitHub',
				'icon'   => 'fa fa-github',
				'href'	 =>$github,
			),
			'hz'      => array(
				'title'  => 'Houzz',
				'icon'   => 'fa fa-houzz',
				'href'	 =>$houzz,
			),
			'px'      => array(
				'title'  => '500px',
				'icon'   => 'fa fa-500px',
				'href'	 =>$px500,
			),
			'xi'      => array(
				'title'  => 'Xing',
				'icon'   => 'fa fa-xing',
				'href'	 =>$xing,
			),
			'vi'      => array(
				'title'  => 'Vine',
				'icon'   => 'fa fa-vine',
				'href'	 =>$vine,
			),
			'sn'      => array(
				'title'  => 'Snapchat',
				'icon'   => 'fa fa-snapchat-ghost',
				'href'	 =>$snapchat,
			),
			'em'      => array(
				'title'  => esc_html__( 'Email', 'daneshyar' ),
				'icon'   => 'fa fa-envelope',
				'href'	 =>'mailto:'.$email,
			),
			'yp'      => array(
				'title'  => 'Yelp',
				'icon'   => 'fa fa-yelp',
				'href'	 =>$yelp,
			),
			'ta'      => array(
				'title'  => 'TripAdvisor',
				'icon'   => 'fa fa-tripadvisor',
				'href'	 =>$tripadvisor,
			),
			'custom'  => array(
				'title'  => daneshyar_settings( 'social_network_custom_link_title' ),
				'href'   => daneshyar_settings( 'social_network_custom_link_link' ),
				'icon'   => daneshyar_settings( 'social_network_custom_link_icon' ),
			),
			'aparat'  => array(
				'title'   => 'Aparat',
				'href'   => daneshyar_settings( 'social_network_link_aparat' ),
				'icon'   => daneshyar_settings('social_network_aparat_link_icon'),
			),
		);

		$social_order = daneshyar_settings('social_order')['enabled'];
		$link_target = daneshyar_settings('social_networks_target_attr');
		 ?>
		<ul> 
			<?php foreach($social_order as $key => $social){ ?>
				<li><a target="<?php echo esc_attr($link_target ); ?>" href="<?php echo esc_url($social_order_list[$key]['href']); ?>" title="<?php echo esc_attr($social_order_list[$key]['title'] ); ?>"><i class="<?php echo esc_attr( $social_order_list[$key]['icon']); ?>"></i></a></li>
			<?php } ?>
		</ul>
	<?php }
	add_shortcode('social_networks','shortcode_social_networks');
}