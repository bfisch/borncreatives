<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
require_once( 'library/custom-post-type.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style();

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
  wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
  wp_enqueue_style( 'googleFonts');
}

add_action('wp_print_styles', 'bones_fonts');

/* Adding SS Social Icons */

function social_icon_font_enqueue() {
  wp_register_style( 'ss-font-stylesheets', get_stylesheet_directory_uri() . '/library/webfonts/ss-social-circle.css', array(), '', 'all' );
  wp_register_style( 'ss-symbol-stylesheets', get_stylesheet_directory_uri() . '/library/webfonts/ss-symbolicons-block.css', array(), '', 'all' );
  wp_enqueue_style( 'ss-font-stylesheets' );
  wp_enqueue_style( 'ss-symbol-stylesheets' );
}

add_action( 'wp_enqueue_scripts', 'social_icon_font_enqueue', 999 );


function post_specific_enqueue() {
  wp_register_style( 'post-css', get_stylesheet_directory_uri() . '/library/post_specific.css', array(), '', 'all' );
  wp_enqueue_style( 'post-css' );
}

add_action( 'wp_enqueue_scripts', 'post_specific_enqueue', 999 );


/************************* Read More Scroll Disable *************************/
function remove_more_link_scroll( $link ) {
  $link = preg_replace( '|#more-[0-9]+|', '', $link );
  return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_scroll' );

add_filter( 'the_content_more_link', 'modify_read_more_link' );
function modify_read_more_link() {
  return '<a class="more-link" href="' . get_permalink() . '"><br>Read More...</a>';
}

/************** Adding Social Network to the customize panel ****************/

// Add opt to custom panel
  function born_creative_customize_register($wp_customize){

    $wp_customize->add_section( 'born_creative_social_settings', array(
        'title'          => __( 'Social Networks', 'bonestheme' ),
        'priority'       => 1,
    ) );
    $wp_customize->add_setting( 'born_creative_social_settings[pinterest]', array(
      'type'           => 'option',
      'capability'     => 'edit_theme_options',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'pinterest', array(
      'label' => __( 'Pinterest', 'bonestheme' ),
      'section' => 'born_creative_social_settings',
      'settings' => 'born_creative_social_settings[pinterest]',
      'priority' => 1,
      'type'  =>  'text',
    )));

    $wp_customize->add_setting( 'born_creative_social_settings[instagram]', array(
      'type'           => 'option',
      'capability'     => 'edit_theme_options',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'instagram', array(
      'label' => __( 'Instagram', 'bonestheme' ),
      'section' => 'born_creative_social_settings',
      'settings' => 'born_creative_social_settings[instagram]',
      'priority' => 1,
      'type'  =>  'text',
    )));

    $wp_customize->add_setting( 'born_creative_social_settings[youtube]', array(
      'type'           => 'option',
      'capability'     => 'edit_theme_options',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'youtube', array(
      'label' => __( 'Youtube', 'bonestheme' ),
      'section' => 'born_creative_social_settings',
      'settings' => 'born_creative_social_settings[youtube]',
      'priority' => 1,
      'type'  =>  'text',
    )));

    $wp_customize->add_setting( 'born_creative_social_settings[twitter]', array(
      'type'           => 'option',
      'capability'     => 'edit_theme_options',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'twitter', array(
      'label' => __( 'Twitter', 'bonestheme' ),
      'section' => 'born_creative_social_settings',
      'settings' => 'born_creative_social_settings[twitter]',
      'priority' => 1,
      'type'  =>  'text',
    )));
    $wp_customize->add_setting( 'born_creative_social_settings[google_plus]', array(
      'type'           => 'option',
      'capability'     => 'edit_theme_options',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'google_plus', array(
      'label' => __( 'Google Plus', 'bonestheme' ),
      'section' => 'born_creative_social_settings',
      'settings' => 'born_creative_social_settings[google_plus]',
      'priority' => 1,
      'type'  =>  'text',
    )));
    $wp_customize->add_setting( 'born_creative_social_settings[facebook]', array(
      'type'           => 'option',
      'capability'     => 'edit_theme_options',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'facebook', array(
      'label' => __( 'Facebook', 'bonestheme' ),
      'section' => 'born_creative_social_settings',
      'settings' => 'born_creative_social_settings[facebook]',
      'priority' => 1,
      'type'  =>  'text',
    )));
  }

  add_action('customize_register', 'born_creative_customize_register');

/* DON'T DELETE THIS CLOSING TAG */ ?>
