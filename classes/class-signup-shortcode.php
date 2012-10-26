<?php
// SendPress Required Class: SendPress_Sugnup_Shortcode

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

class SendPress_Sugnup_Shortcode{

	function load_form( $attr, $content = null ) {

		global $load_signup_js, $sendpress_show_thanks, $sendpress_signup_error;
		$load_signup_js = true;

	    ob_start();

	   $args = array( 'post_type' => 'sendpress_list','numberposts'     => -1,
    'offset'          => 0,
    'orderby'         => 'post_title',
    'order'           => 'DESC', );

		$lists = get_posts( $args );
	    //$lists = $s->getData($s->lists_table());
	    $listids = array();

		foreach($lists as $list){
			if( get_post_meta($list->ID,'public',true) == 1 ){
				$default_list_id = $list->ID;
			}
		}

	    extract(shortcode_atts(array(
			'firstname_label' => 'First Name',
			'lastname_label' => 'Last Name',
			'email_label' => 'E-Mail',
			'listids' => '',
			'display_firstname' => false,
			'display_lastname' => false,
			'label_display' => false,
			'desc' => '',
			'label_width' => 100,
			'thank_you'=>'Thank you for subscribing!',
			'button_text' => 'Submit'
		), $attr));

		$label = filter_var($label_display, FILTER_VALIDATE_BOOLEAN);

		$widget_options = SENDPRESS::get_option('widget_options');
	    ?>
	    
	    <div class="sendpress-signup-form">
			<form id="sendpress_signup" method="POST" <?php if( !$widget_options['load_ajax'] ){ ?>class="sendpress-signup"<?php } ?>>
				<?php 
					if( $widget_options['load_ajax'] ){
						echo '<input type="hidden" name="action" value="signup-user" />';
						echo '<input type="hidden" name="redirect" value="'.get_permalink().'" />';
					}
				?>
				<input type="hidden" name="list" id="list" value="<?php echo $listids; ?>" />
				<div id="error"><?php echo $sendpress_signup_error; ?></div>
				<div id="thanks" <?php if( $sendpress_show_thanks ){ echo 'style="display:block;"'; }else{ echo 'style="display:none;"'; } ?>><?php echo $thank_you; ?></div>
				<div id="form-wrap" <?php if( $sendpress_show_thanks ){ echo 'style="display:none;"'; } ?>>
					<p><?php echo $desc; ?></p>
					<?php if( filter_var($display_firstname, FILTER_VALIDATE_BOOLEAN)  ): ?>
						<fieldset name="firstname">
							<?php if( !$label ): ?>
								<label for="firstname"><?php echo $firstname_label; ?>:</label>
							<?php endif; ?>
							<input type="text" id="firstname" orig="<?php echo $firstname_label; ?>" value="<?php if($label){ echo $firstname_label; } ?>" tabindex="50" name="firstname" />
						</fieldset>
					<?php endif; ?>

					<?php if( filter_var($display_lastname, FILTER_VALIDATE_BOOLEAN) ): ?>
						<fieldset name="lastname">
							<?php if( !$label ): ?>
								<label for="lastname"><?php echo $lastname_label; ?>:</label>
							<?php endif; ?>
							<input type="text" id="lastname" orig="<?php echo $lastname_label; ?>" value="<?php if($label){ echo $lastname_label; } ?>" tabindex="50" name="lastname" />
						</fieldset>
					<?php endif; ?>

					<fieldset name="email">
						<?php if( !$label ): ?>
							<label for="email"><?php echo $email_label; ?>:</label>
						<?php endif; ?>
						<input type="text" id="email" orig="<?php echo $email_label; ?>" value="<?php if($label){ echo $email_label; } ?>" tabindex="50" name="email" />
					</fieldset>

					<fieldset class="submit">
						<input value="<?php echo $button_text; ?>" class="signup-submit" type="submit" tabindex="53" id="submit" name="submit">
					</fieldset>
				</div>
			</form>
		</div> 
	
	    <?php

	    $output = ob_get_contents();
	    ob_end_clean();
	    return $output;
	}

}

add_shortcode('sendpress-signup', array('SendPress_Sugnup_Shortcode','load_form'));