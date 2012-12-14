<?php

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

class SendPress_View_Pro extends SendPress_View{
	
	function html($sp){
		
		$modules = array('pro','reports', 'empty', 'empty');
		echo '<div class="sendpress-addons">';
		foreach ($modules as $mod) {
			$mod_class = $this->get_module_class($mod);
			if($mod_class){
				$mod_class = NEW $mod_class;
				$mod_class->render( $this );
			}
			
		}
		echo '</div>';

	}

	function get_module_class( $module = false ){
		if($module !== false){
			$module = str_replace('-',' ',$module);
			$module  = ucwords( $module );
			$module = str_replace(' ','_',$module);
			$class = "SendPress_Module_{$module}";

			if ( class_exists( $class ) )
				return $class;
		}
		return false;
	}

}
SendPress_View_Pro::cap('sendpress_addons');