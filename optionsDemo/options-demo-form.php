<?php

class OptionDemoForm {
	
	public function __construct() {
		add_action( 'admin_menu', array($this, 'optionsdemo_create_admin_page') );
		add_action( 'admin_post_optionsdemo_admin_page', array($this, 'optionsdemo_save_form' ));
	}

	public function optionsdemo_create_admin_page() {
		$page_title = __('Options Admin Page', 'optionsdemo');
		$menu_title = __('Options Admin Page', 'optionsdemo');
		$capability = 'manage_options';
		$menu_slug = 'optionsdemopage';
		$callback = array($this, 'optionsdemo_page_content');
		add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $callback);
	}
	public function optionsdemo_page_content() {
		require_once 'form.php';
	}
	public function optionsdemo_save_form() {
		check_admin_referer( 'optionsdemo' );
		if(isset($_POST['optionsdemo_longitude'])) {
			update_option( 'optionsdemo_longitude', sanitize_text_field( $_POST['optionsdemo_longitude']) );
		}
		wp_redirect( 'admin.php?page=optionsdemopage' );
	}
}

new OptionDemoForm();