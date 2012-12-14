<?php

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

/**
* SendPress_View_Queue
*
* @uses     SendPress_View
*
*/
class SendPress_View_Queue extends SendPress_View {
	
	function empty_queue( $get, $sp ){
		SendPress_Data::delete_queue_emails();
		SendPress_View_Queue::redirect();
	}

	function html($sp) {

	if(isset($_GET['cron'])){
		$sp->fetch_mail_from_queue();
	}	

		//Create an instance of our package class...
	$testListTable = new SendPress_Queue_Table();
	//Fetch, prepare, sort, and filter our data...
	$testListTable->prepare_items();
	SendPress_Option::set('no_cron_send', 'false');
	//$sp->fetch_mail_from_queue();
	$sp->cron_start();
	//echo $sp->get_key(). "<br>";

	$open_info = array(
				"id"=>13,
				"report"=> 10,
				"view"=>"open"
				);
	/*
			$x = $sp->encrypt_data($open_info);

		echo $x."<br>";
		$x = $sp->decrypt_data($x);

		print_r($x);
			echo "<br>";

		$d = $_GET['t'];
		$x = $sp->decrypt_data($d);

		print_r($x->id);
			echo "<br>";
			*/

	?>


	<div id="taskbar" class="lists-dashboard rounded group"> 

	<div id="button-area">  
	<a id="send-now" class="btn btn-primary btn-large " data-toggle="modal" href="#sendpress-sending"   ><i class="icon-white icon-refresh"></i> <?php _e('Send Emails Now','sendpress');?></a>
	</div>
	
		
		<h2><?php _e('Queue','sendpress');?></h2>
		</div>
	<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
	<form id="email-filter" method="get">
		<!-- For plugins, we also need to ensure that the form posts back to our current page -->
	    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
	    <!-- Now we can render the completed list table -->
	    <?php $testListTable->display() ?>
	    <?php wp_nonce_field($sp->_nonce_value); ?>
	</form>
	<br>
	<form  method='get'>
		<input type='hidden' value="<?php echo $_GET['page']; ?>" name="page" />
		
		<input type='hidden' value="empty-queue" name="action" />
		<a class="btn btn-large " data-toggle="modal" href="#sendpress-empty-queue" ><i class="icon-warning-sign "></i> <?php _e('Delete All Emails in the Queue','sendpress'); ?></a>
		<?php wp_nonce_field($sp->_nonce_value); ?>
	</form>
<div class="modal hide fade" id="sendpress-empty-queue">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3><?php _e('Really? Delete All Emails in the Queue.','sendpress');?></h3>
	</div>
	<div class="modal-body">
		<p><?php _e('This will remove all emails from the queue without attempting to send them','sendpress');?>.</p>
	</div>
	<div class="modal-footer">
	<a href="#" class="btn btn-primary" data-dismiss="modal"><?php _e('No! I was Joking','sendpress');?></a><a href="<?php echo self::link(); ?>&action=empty-queue" id="confirm-delete" class="btn btn-danger" ><?php _e('Yes! Delete All Emails','sendpress');?></a>
	</div>
</div>


	<div class="modal hide fade" id="sendpress-sending">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3><?php _e('Sending Emails','sendpress');?></h3>
  </div>
  <div class="modal-body">
    <div id="sendbar" class="progress progress-striped
     active">
  <div id="sendbar-inner" class="bar"
       style="width: 40%;"></div>
</div>
	Sent <span id="queue-sent">-</span> <?php _e('of','sendpress');?> <span id="queue-total">-</span> emails.
  </div>
  <div class="modal-footer">
   <?php _e('If you close this window sending will stop. ','sendpress');?><a href="#" class="btn btn-primary" data-dismiss="modal"><?php _e('Close','sendpress');?></a>
  </div>
</div>
<?php
	}

}
SendPress_View_Queue::cap('sendpress_queue');