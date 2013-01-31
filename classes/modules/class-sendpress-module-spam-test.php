<?php

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

class SendPress_Module_Spam_Test extends SendPress_Module{
	
	function html($sp){
		$hide = false;
		$plugin_path = 'x';
		if( $this->is_pro_active() ){
			$plugin_path = 'sendpress-pro/extensions/class-sendpress-spam-test.php';
		}
	?>
		<h4><?php _e('Spam Testing','sendpress');?></h4>
		<form method="post" id="post">
			<div class="description">
				<?php echo sprintf(	__( 'Test your emails with %s.','sendpress' ), 'SpamAssassin' ); ?>
			</div>
			<?php $this->buttons($plugin_path);?>
			<input type="hidden" name="plugin_path" value="<?php echo $plugin_path; ?>" />
			<input class="action" type="hidden" name="action" value="module-activate-sendpress-pro" />
			<?php wp_nonce_field($sp->_nonce_value); ?>
		</form>

	<?php
	}

}