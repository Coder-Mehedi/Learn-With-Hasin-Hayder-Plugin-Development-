<h1>Demo Admin Options Page</h1>
<form method="POST" action="<?php echo admin_url( 'admin-post.php' ); ?>">
	<?php wp_nonce_field( 'optionsdemo' ); 
	$optionsdemo_longitude = get_option( 'optionsdemo_longitude' );
	?>


	<label for="optionsdemo_longitude"><?php _e('Longitude', 'optionsdemo') ?></label>
	<input type="text" name="optionsdemo_longitude" id="optionsdemo_longitude" value="<?php echo esc_attr( $optionsdemo_longitude ) ?>">
	<input type="hidden" name="action" value="optionsdemo_admin_page">
	<?php submit_button( 'Save' ); ?>


</form>