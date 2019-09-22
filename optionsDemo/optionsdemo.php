<?php

/**
 * @Author: Coder-Mehedi
 * @Date:   2019-09-22 15:04:12
 * @Last Modified by:   Coder-Mehedi
 * @Last Modified time: 2019-09-22 17:13:42
 */

/**
 * Plugin Name: Google Map Settings
 * Description: Google Map Settings
 * Plugin URI: http://#
 * Author: Mehedi
 * Author URI: http://#
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: optionsdemo
 * Domain Path: /languages/
 */


function actionsdemo_bootstrap() {
	load_plugin_textdomain( 'coldemo', false, dirname(__FILE__)."/languages" );
}

add_action( 'plugins_loaded', 'actionsdemo_bootstrap' );

add_action( 'admin_menu', 'optionsdemo_add_admin_menu' );
add_action( 'admin_init', 'optionsdemo_settings_init' );


function optionsdemo_add_admin_menu(  ) { 

	add_options_page( 'Google Maps Settings', 'Google Maps Settings', 'manage_options', 'options_demo', 'optionsdemo_options_page' );

}


function optionsdemo_settings_init(  ) { 

	register_setting( 'pluginPage', 'optionsdemo_settings' );

	add_settings_section(
		'optionsdemo_pluginPage_section', 
		__( 'Your section description', 'optionsdemo' ), 
		'optionsdemo_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'optionsdemo_text_field_0', 
		__( 'Place', 'optionsdemo' ), 
		'optionsdemo_text_field_0_render', 
		'pluginPage', 
		'optionsdemo_pluginPage_section' 
	);

	add_settings_field( 
		'optionsdemo_text_field_2', 
		__( 'Zoom Level', 'optionsdemo' ), 
		'optionsdemo_text_field_2_render', 
		'pluginPage', 
		'optionsdemo_pluginPage_section' 
	);

	add_settings_field( 
		'optionsdemo_text_field_3', 
		__( 'Width', 'optionsdemo' ), 
		'optionsdemo_text_field_3_render', 
		'pluginPage', 
		'optionsdemo_pluginPage_section' 
	);

	add_settings_field( 
		'optionsdemo_text_field_4', 
		__( 'Height', 'optionsdemo' ), 
		'optionsdemo_text_field_4_render', 
		'pluginPage', 
		'optionsdemo_pluginPage_section' 
	);


}


function optionsdemo_text_field_0_render(  ) { 

	$options = get_option( 'optionsdemo_settings' );
	?>
	<input type='text' name='optionsdemo_settings[optionsdemo_text_field_0]' value='<?php echo $options['optionsdemo_text_field_0']; ?>'>
	<?php

}


function optionsdemo_text_field_2_render(  ) { 

	$options = get_option( 'optionsdemo_settings' );
	?>
	<input type='text' name='optionsdemo_settings[optionsdemo_text_field_2]' value='<?php echo $options['optionsdemo_text_field_2']; ?>'>
	<?php

}


function optionsdemo_text_field_3_render(  ) { 

	$options = get_option( 'optionsdemo_settings' );
	?>
	<input type='text' name='optionsdemo_settings[optionsdemo_text_field_3]' value='<?php echo $options['optionsdemo_text_field_3']; ?>'>
	<?php

}


function optionsdemo_text_field_4_render(  ) { 

	$options = get_option( 'optionsdemo_settings' );
	?>
	<input type='text' name='optionsdemo_settings[optionsdemo_text_field_4]' value='<?php echo $options['optionsdemo_text_field_4']; ?>'>
	<?php

}


function optionsdemo_settings_section_callback(  ) { 

	echo __( 'This section description', 'optionsdemo' );

}


function optionsdemo_options_page(  ) { 

		?>
		<form action='options.php' method='post'>

			<h2>Google Maps Settings</h2>

			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>

		</form>
		<?php

}

function coldemo_settings_link($link) {
	$newLink = sprintf('<a href="%s">%s</a>','options-general.php?page=options_demo',__('Settings', 'optionsdemo'));
	$link[] = $newLink;
	return $link;
}

add_action( 'plugin_action_links_'.plugin_basename( __FILE__ ), 'coldemo_settings_link' );

