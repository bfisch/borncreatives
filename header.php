<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php /*wp_title('');*/ echo 'Born Creative Blog'; ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">

		<?php // all apple icon sizes ?>
		<link rel="apple-touch-icon-precomposed" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/library/images//favicon-152.png">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/library/images//favicon-144.png">
		<link rel="apple-touch-icon-precomposed" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/library/images//favicon-120.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/library/images//favicon-114.png">
		<link rel="apple-touch-icon-precomposed" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/library/images//favicon-76.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/library/images//favicon-72.png">
		<link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/library/images//favicon-57.png">

		<?php // android icon?>
		<link rel="shortcut icon" sizes="196x196" href="<?php echo get_template_directory_uri(); ?>/library/images//favicon-196x196.png">


		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#A3DAD1">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php wp_head(); ?>

		<?php // drop Google Analytics Here ?>

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-38195228-2', 'auto');
		  ga('send', 'pageview');

		</script>

<style>
.home img.noHome {display: none;}
</style>
		
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?>>

		<div id="container">

			<header class="header" role="banner">

				<div id="logo-container">

					<div id="inner-logo-container" class="wrap cf">

						<a href="<?php echo home_url(); ?>" rel="nofollow">
							<img src="<?php echo get_template_directory_uri(); ?>/library/images/BC_Blog_Logo_Stacked_Big.png" id="logo">
						</a>

						<?php // if you'd like to use the site description you can un-comment it below ?>
						<?php // bloginfo('description'); ?>

					</div>

				</div>

				<div id="nav-container">

					<div id="inner-nav-container" class="wrap cf">

						<nav role="navigation" class="d-5of7 t-2of3 m-all">
							<?php wp_nav_menu(array(
	    					'container' => false,                           // remove nav container
	    					'container_class' => 'menu cf',                 // class of container (should you choose to use it)
	    					'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
	    					'menu_class' => 'nav top-nav cf',               // adding custom nav class
	    					'theme_location' => 'main-nav',                 // where it's located in the theme
	    					'before' => '',                                 // before the menu
	        			'after' => '',                                  // after the menu
	        			'link_before' => '',                            // before each link
	        			'link_after' => '',                             // after each link
	        			'depth' => 0,                                   // limit the depth of the nav
	    					'fallback_cb' => ''                             // fallback function (if there is one)
							)); ?>

						</nav>

						<div id="header-social" class="social-icons-circle d-2of7 t-1of3 m-all">

							<?php
								$social_options = get_option( 'born_creative_social_settings', array() );

								$pinterest = $social_options['pinterest'];
								$instagram = $social_options['instagram'];
								$youtube = $social_options['youtube'];
								$twitter = $social_options['twitter'];
								$google_plus = $social_options['google_plus'];
								$facebook = $social_options['facebook'];

								if ($pinterest != '') 	{ echo '<a href="' . $pinterest . '" target="_blank">&#xF650;</a>'; }
								if ($instagram != '') 	{ echo '<a href="' . $instagram . '" target="_blank">&#xF641;</a>'; }
								if ($youtube != '') 	{ echo '<a href="' . $youtube . '" target="_blank">&#xF630;</a>'; }
								if ($twitter != '') 	{ echo '<a href="' . $twitter . '" target="_blank">&#xF611;</a>'; }
								if ($google_plus != '') { echo '<a href="' . $google_plus . '" target="_blank">&#xF613;</a>'; }
								if ($facebook != '') 	{ echo '<a href="' . $facebook . '" target="_blank">&#xF610;</a>'; }

							?>

						</div>

					</div>

				</div>

			</header>

			<div id="header-spacing">
				<?php // This counteracts the height of making the .header fixed ?>
			</div>
