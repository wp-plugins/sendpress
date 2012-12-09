<?php
// SendPress Required Class: SendPress_Option
defined( 'ABSPATH' ) || exit;
// Plugin paths, for including files

if(class_exists('SendPress_Option')){ return; }


/**
* SendPress_Options
*
* @uses     
*
* 
* @package  SendPRess
* @author   Josh Lyford
* @license  See SENPRESS
* @since 	0.8.7     
*/
class SendPress_Option {
	private static $key = 'sendpress_options';

    /**
     * get
     * 
     * @param mixed $name    Item to get out of SendPress option array.
     * @param mixed $default return value if option is not set.
     *
     * @access public
     *
     * @return mixed Value default or option value.
     */
	function get( $name, $default = false ) {
		$options = get_option( self::$key );
		if ( is_array( $options ) && isset( $options[$name] ) ) {
			return is_array( $options[$name] )  ? $options[$name] : stripslashes( $options[$name] );
		}
		return $default;
	}	
	

    /**
     * set
     * 
     * @param mixed $option String or Array of options to set.
     * @param mixed $value  if String name is passed us this to pass value to save.
     *
     * @access public
     *
     * @return bool Value succus or failure of option save.
     */
	function set($option, $value= null){
		$options = get_option( self::$key );
		
		//Set options with an array of values.
		if(is_array($option)){
			return update_option( self::$key, array_merge( $options, $option ) );
		}

		if ( !is_array( $options ) ) {
			$options = array();
		}
		$options[$option] = $value;
		return update_option( self::$key , $options );
	}
}
