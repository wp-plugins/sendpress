<?php

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

// Plugin paths, for including files
if ( ! defined( 'SENDPRESS_CLASSES' ) )
	define( 'SENDPRESS_CLASSES', plugin_dir_path( __FILE__ ) );

define( 'SENDPRESS_CLASSES_MODULES', trailingslashit( SENDPRESS_CLASSES . 'modules' ) );

class SendPress_Module {
	var $_title = '';
	var $_visible = true;
	var $_nonce_value = 'sendpress-is-awesome';
	//var $_active = false;

	function SendPress_View( $title='' ) {
		$this->title( $title );

		if ( $this->init() === false ) {
			$this->set_visible( false );
			return;
		}
	}

	/**
	 * Initializes the view.
	 */
	function init() {}

	function module_start(){
		echo '<div class="sendpress-module">';
		echo '<div class="inner-module">';
	}

	function module_end(){
		echo '</div>';
		echo '</div>';
	}

	function prerender() {}

	/**
	 * Renders the view.
	 */
	function render($sp) {
		$this->module_start();
		$this->html($sp);
		//$this->buttons('sendpress-pro/sendpress-pro.php');
		$this->module_end();
	}

	/*
	* Page HTML
	*/
	function html($sp){
		echo "Page not built yet.";
	}

	function buttons($plugin_path){
		if( !$this->is_pro($plugin_path) ){
			if( $this->is_pro_active() ){
				$btn = $this->get_button($plugin_path,true);
			}else{
				$btn = $this->get_button($plugin_path);
			}
		}else{
			$btn = $this->get_button($plugin_path);
		}

		echo '<div class="inline-buttons">'.$btn.'</div>';
	}

	function get_button($path, $from_pro = false){
		$button = array('class' => 'btn module-deactivate-plugin', 'href' => '#', 'target' => '', 'text' => 'Deactivate');
		if( $from_pro ){
			$pro_options = SendPress_Option::get('pro_plugins');
			$reg_plugin = substr($path, 14, strlen($path));
			
			if( file_exists(WP_PLUGIN_DIR.'/'.$reg_plugin) && is_plugin_active($reg_plugin) ){
				deactivate_plugins($reg_plugin); //deactivate seperate plugin
				$pro_options[$path] = true; //activate the pro version
				SendPress_Option::set($pro_options);
				$pro_options = SendPress_Option::get('pro_plugins');
			}

			if( !$pro_options[$path] ){
				$button['class'] = 'module-activate-plugin btn-success btn-activate btn';
				//$button['id'] = 'module-activate-plugin';
				$button['text'] = 'Activate';
			}else{
				$button['text'] = 'Deactivate';
			}

		}else{
			if( !file_exists(WP_PLUGIN_DIR.'/'.$path) ){
				$button['class'] = 'module-deactivate-plugin btn-primary btn-buy btn';
				$button['href'] = 'http://sendpress.com';
				$button['target'] = '_blank';
				$button['text'] = 'Buy Now';
				//$button['id'] = '';
			}elseif( !is_plugin_active($path) ){
				$button['class'] = 'module-activate-plugin btn-success btn-activate btn';
				//$button['id'] = 'module-activate-plugin';
				$button['text'] = 'Activate';
			}else{
				$button['text'] = 'Deactivate';
			}
		}

		return $this->build_button($button);

	}

	function build_button($btn){
		$button = '<a ';
		foreach( $btn as $key => $item ){
			if( strlen($btn[$key]) > 0 && $key !== 'text' ){
				$button .= $key.'="'.$item.'" ';
			}
		}
		$button .= '>'.$btn['text'].'</a>';

		return $button;
	}

	function is_pro($plugin){
		if( $plugin === 'sendpress-pro/sendpress-pro.php' ){
			return true;
		}
		return false;
	}

	function is_pro_active(){
		if( file_exists(WP_PLUGIN_DIR.'/sendpress-pro/sendpress-pro.php') && is_plugin_active('sendpress-pro/sendpress-pro.php') ){
			return true;
		}
		return false;
	}

	function is_visible() {
		return $this->_visible;
	}

	function set_visible( $visible ) {
		$this->_visible = $visible;
	}

	function title( $title=NULL ) {
		if ( ! isset( $title ) )
			return $this->_title;
		$this->_title = $title;
	}

}

class SdndPress_Plugin_State{

	const Active = 0;
	const Inactive = 1;
	const Active_Pro = 2;
	const Inactive_Pro = 3;

}
