<?php

class SendPressAjaxProcessor{

	var $ajax_nonce = "love-me-some-sendpress-ajax-2012";
	
	function &init() {
		static $instance = false;

		if ( !$instance ) {
			$instance = new SendPressAjaxProcessor;
			$instance->add_hooks();
		}

		return $instance;
	}

	function add_hooks(){
		error_log('What');
		// register the ajax process function with wordpress
		add_action("wp_ajax_sendpress_save_list", array(&$this,'save_list') );
		add_action("wp_ajax_nopriv_sendpress_save_list", array(&$this,'save_list') );

		add_action("wp_ajax_sendpress_subscribe_to_list", array(&$this,'subscribe_to_list') );
		add_action("wp_ajax_nopriv_sendpress_subscribe_to_list", array(&$this,'subscribe_to_list') );

		add_action('wp_ajax_sendpress-sendbatch', array(&$this, 'send_batch'));
		add_action('wp_ajax_sendpress-stopcron', array(&$this, 'cron_stop'));
		add_action('wp_ajax_sendpress-sendcount', array(&$this, 'sendcount'));
		add_action('sendpress_admin_scripts',array(&$this,'admin_scripts'));
	}

	function admin_scripts(){
		wp_localize_script( 'sendpress-admin-js', 'spvars', array(
	    // URL to wp-admin/admin-ajax.php to process the request
	    'ajaxurl'          => admin_url( 'admin-ajax.php' ),
	 
	    // generate a nonce with a unique ID "myajax-post-comment-nonce"
	    // so that you can check it later when an AJAX request is sent
	    'sendpressnonce' => wp_create_nonce( $this->ajax_nonce ),
	    )
		);
	}

	function verify_ajax_call(){
		$nonce = $_POST['spnonce'];
    	if ( ! wp_verify_nonce( $nonce, $this->ajax_nonce ) ){
        	die ( 'Busted!');
       	}
	}

	function save_list(){
		global $wpdb;

		// Create the response array
		$response = array(
			'success' => false
		);

		if($_POST) {
			$s = NEW SendPress;

			// get the credit card details submitted by the form
			$listid = $_POST['id'];
			$name = $_POST['name'];
			$public = ( $_POST['public'] === '1' ) ? 1 : 0;

			$list = $s->updateList($listid, array( 'name'=>$name, 'public'=>$public ) );

			if( false !== $list ){
				$response['success'] = true;
			}else{
				$response['error'] = $list;
			}
			
		}
		// Add additional processing here
		if($response['success']) {
			// Succeess
		} else {
			// Failed
		}
		
		// Serialize the response back as JSON
		echo json_encode($response);
		die();
	}

	function subscribe_to_list(){
		global $wpdb;

		// Create the response array
		$response = array(
			'success' => false
		);

		if($_POST) {
			$s = NEW SendPress;

			// get the credit card details submitted by the form
			$first = isset($_POST['first']) ? $_POST['first'] : '';
			$last = isset($_POST['last']) ? $_POST['last'] : '';
			$email = isset($_POST['email']) ? $_POST['email'] : '';
			$listid = isset($_POST['listid']) ? $_POST['listid'] : '';

			$subscriberID = $s->addSubscriber(array('firstname' => $first,'lastname' => $last,'email' => $email));

			$listids = explode(',', $listid);

			$lists = $s->getData($s->lists_table());
			foreach($lists as $list){
				if( $list->public == 1 && in_array($list->listID, $listids) ){
					$success = $s->linkListSubscriber($list->listID, $subscriberID, 2);
				}
			}

			if( false !== $success ){
				$response['success'] = true;
			}else{
				$response['error'] = 'User was not subscribed to the list.';
			}
			
		}
		// Add additional processing here
		if($response['success']) {
			// Succeess
		} else {
			// Failed
		}
		
		// Serialize the response back as JSON
		echo json_encode($response);
		die();
	}

	function cron_stop(){
		$this->verify_ajax_call();
		// Create the response array
		$response = array(
			'success' => false
		);
		
    	$upload_dir = wp_upload_dir();
		$filename = $upload_dir['basedir'].'/sendpress.pause';
		$Content = "Stop the cron form running\r\n";
		$handle = fopen($filename, 'w');
		fwrite($handle, $Content);
		fclose($handle);
		
		if(file_exists($filename)){
			$response['success'] = true;
		} 
	    echo json_encode($response);
 		exit;
	}

	function sendcount(){
		error_log('asdf');
		$this->verify_ajax_call();
		// Create the response array
		$sp = new SendPress;
		$response = array(
			'total' => $sp->countQueue()
		);
		echo json_encode($response);
		exit();
	}

	function send_batch(){
		$sp = new SendPress;
		$count = $sp->send_single_from_queue();
		
		echo json_encode($count);
		exit();
	}







}

add_action( 'init', array( 'SendPressAjaxProcessor', 'init' ) );


		





