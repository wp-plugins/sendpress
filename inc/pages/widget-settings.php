



<div style="float:right;" >
	<a href="?page=sp-templates&view=widget" class="btn btn-large" ><i class="icon-remove"></i> Cancel</a> <a href="#" id="save-update" class="btn btn-primary btn-large"><i class="icon-white icon-ok"></i> Save</a>
</div>
<br class="clear">
<div id="widget-options" class="boxer form-box clearfix">

	<div id="shortcode">
		<h3>Signup Shortcode</h3>
		<p>If you would rather add the SendPress signup form to a page, you can use the following short code.  If you want more detailed information on how to use the short code check out our <a href="http://manage.sendpress.com/support/knowledgebase/how-to-use-the-sign-up-shortcode/" target="_blank">knowledge base</a>.
		<pre>[sendpress-signup listids='1']</pre>
		<!-- <ul>
			<li>listids='1' </li>
			<li>firstname_label='First Name'</li>
			<li>lastname_label='Last Name' </li>
			<li>email_label='E-Mail' </li>
			<li>display_firstname='true' </li>
			<li>display_lastname='false' </li>
			<li>label_display='false' </li>
			<li>desc= '' </li>
			<li>label_width=100 </li>
			<li>thank_you='Thank you for subscribing!' </li>
			<li>button_text='Submit'</li>
		</ul> -->
		</p>
	</div>

	<div id="widget-settings">
		<h3>Signup Widget Settings</h3>
		<form method="post" id="post">
			<?php 
				$widget_options = $this->get_option('widget_options');
				//print_r($widget_options);
			?>
			<label for="load_css"><?php echo 'Disable front end CSS'; ?></label>
			<input class="turnoff-css-checkbox sendpress_checkbox" value="<?php echo $widget_options['load_css']; ?>" type="checkbox" <?php if( $widget_options['load_css'] == 1 ){ echo 'checked'; } ?> id="load_css" name="load_css"/><br><br>
			
			<label for="load_ajax"><?php echo 'Disable signup form ajax'; ?></label>
			<input class="turnoff-ajax-checkbox sendpress_checkbox" value="<?php echo $widget_options['load_ajax']; ?>" type="checkbox" <?php if( $widget_options['load_ajax'] == 1 ){ echo 'checked'; } ?> id="load_ajax" name="load_ajax"/> <br><br>

			<label for="load_scripts_in_footer"><?php echo 'Load Javascript in Footer'; ?></label>
			<input class="footer-scripts-checkbox sendpress_checkbox" value="<?php echo $widget_options['load_scripts_in_footer']; ?>" type="checkbox" <?php if( $widget_options['load_scripts_in_footer'] == 1 ){ echo 'checked'; } ?> id="load_scripts_in_footer" name="load_scripts_in_footer"/> 

			<input type="hidden" name="action" value="temaplte-widget-settings" />
			<!-- <button class="btn btn-primary" type="submit">Save</button> -->
			<?php wp_nonce_field($this->_nonce_value); ?>

		</form>
		<h4>Front end CSS</h4>
		<pre>
			<?php echo file_get_contents(SENDPRESS_PATH.'css/front-end.css'); ?>
		</pre>
	</div>

	

</div>