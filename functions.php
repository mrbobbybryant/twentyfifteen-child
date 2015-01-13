<?php

function dwwp_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'parent-style' ) );
}
add_action( 'wp_enqueue_scripts', 'dwwp_theme_enqueue_styles' );

function dwwp_footer_link() {
	echo '<p>Test</p>';
}
add_action( 'twentyfifteen_credits', 'dwwp_footer_link' );


/*-----------------------------------------------*
* Menus
/*-----------------------------------------------*/
function dwwp_register_theme_options_page(){
    add_options_page( 
    	'Theme Options', 
    	'Theme Options', 
    	'manage_options', 
    	'theme-options', 
    	'dwwp_render_theme_options'
    ); 
}

add_action( 'admin_menu', 'dwwp_register_theme_options_page' );

/*-----------------------------------------------*
* Sections, Settings, and Fields
/*-----------------------------------------------*/

function dwwp_initialize_theme_options() {
	add_settings_section(
		'social_settings_section',
		'Social Media Profiles',
		'social_settings_section_callback',
		'theme-options'
	);

	add_settings_field( 
	    'twitter-field',            // ID used to identify the field throughout the theme
	    'Twitter',                  // The label to the left of the option interface element
	    'twitter_field_callback',   // The name of the function responsible for rendering the option interface
	    'theme-options',            // The page on which this option will be displayed
	    'social_settings_section'   // The name of the section to which this field belongs
	);

	add_settings_field( 
	    'facebook-field',            // ID used to identify the field throughout the theme
	    'Facebook',
	    'facebook_field_callback',                  // The label to the left of the option interface element
	    'theme-options',            // The page on which this option will be displayed
	    'social_settings_section'   // The name of the section to which this field belongs
	);

	register_setting(
		'twitter_field',
		'social_media_options'
	);

	register_setting(
		'facebook_field',
		'social_media_options'
	);

}
add_action('admin_init', 'dwwp_initialize_theme_options');


/*-----------------------------------------------*
* Callbacks
/*-----------------------------------------------*/

function dwwp_render_theme_options(){
?>
	<div class="wrap">
		<h2>Theme Options Page</h2>
		<form method="post" action="options.php">
		<?php

			//Render
			settings_fields( 'twitter-field' );
			settings_fields( 'facebook-field' );

			//What page do you want to render these sections on?
			do_settings_sections( 'theme-options' );

			//Add a submit button to serialize the button.
			submit_button();

		?>
		</form>
	</div>
<?php
}

function social_settings_section_callback() {
	echo '<h5>Enter your social media profile information here.</h5>';
}

function twitter_field_callback() {

	$options = (array)get_option( 'social_media_options' );
	$twitter = $options['twitter-field'];

    echo '<input type="text" name="social_media_options[twitter-field]" id="twitter_options" value="'. $twitter . '" />';
 
}

function facebook_field_callback() {

	$options = (array)get_option( 'social_media_options' );
	$facebook = $options['facebook-field'];

    echo '<input type="text" name="social_media_options[facebook-field]" id="facebook_options" value="'. $facebook . '" />';
}





