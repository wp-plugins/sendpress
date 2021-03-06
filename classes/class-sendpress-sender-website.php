<?php 


// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

if(!class_exists('SendPress_Sender_Website')){  

class SendPress_Sender_Website extends SendPress_Sender {

	var $emailText = '';
	var $sid = '' ;
	var $list_id = '';
	var $report_id = '';

	function label(){
		return __('Your Website','sendpress');
	}

	function save(){
		if(isset($_POST['hosting-provider'])){
			SendPress_Option::set('website-hosting-provider', $_POST['hosting-provider']);
		} else{
			SendPress_Option::set('website-hosting-provider', false);
		}

	}

	function settings(){ ?>
		This option uses your host's local mail server to send emails.

		<?php 

			$hosting = SendPress_Option::get('website-hosting-provider');



		?>
		<br><br>
		<input type="checkbox" value="godaddy" name="hosting-provider" <?php if($hosting=="godaddy"){  echo "checked='checked'"; }  ?> /> GoDaddy Hosting<br>
		This sets the smtp host to <b>relay-hosting.secureserver.net</b> for GoDaddy users.<br>GoDaddy limits emails to 1000 per day.
		<!--Send a max of <input type="text" name="emails-per-day" value="" class="sptext"  > Emails per day.-->


	<?php

}	

	function wpmail_init( $phpmailer ){
		/*
		$phpmailer->ClearCustomHeaders();
		$phpmailer->Body = $this->AltBody;
		$phpmailer->AltBody = $this->AltBody;
		$phpmailer->Subject = $this->Subject;
		$phpmailer->From = $this->From;
		$phpmailer->FromName = $this->FromName;
		$phpmailer->Sender = $this->Sender;
		$phpmailer->MessageID = $this->MessageID;

		$phpmailer->AddAddress( $this->to[0][0], $this->to[0][1] );
		$phpmailer->AddReplyTo( $this->ReplyTo[0][0], $this->ReplyTo[0][1] );
		*/
		$phpmailer->ClearCustomHeaders();
		$from_email = SendPress_Option::get('fromemail');
		$phpmailer->From = $from_email;
		$phpmailer->FromName = SendPress_Option::get('fromname');
		
		$phpmailer->AddCustomHeader('X-SP-METHOD: website wp_mail');
		$charset = SendPress_Option::get('email-charset','UTF-8');
		$encoding = SendPress_Option::get('email-encoding','8bit');
		
		$phpmailer->CharSet = $charset;
		$phpmailer->Encoding = $encoding;
		$phpmailer->ContentType = 'text/html';

		$phpmailer->AddCustomHeader('X-SP-LIST: ' . $this->list_id );
		$phpmailer->AddCustomHeader('X-SP-REPORT: ' . $this->report_id );
		$phpmailer->AddCustomHeader('X-SP-SUBSCRIBER: '. $this->sid );

		$phpmailer->AltBody = $this->emailText;
		$phpmailer->IsHTML( true );
		
		//$phpmailer->WordWrap = $this->WordWrap;

		return $phpmailer;
	}

	function send_email($to, $subject, $html, $text, $istest = false, $sid , $list_id, $report_id ){
		
		$this->emailText = $text;
		$this->sid = $sid;
		$this->list_id = $list_id;
		$this->report_id = $report_id;

		//add_filter( 'phpmailer_init' , array( $this , 'wpmail_init' ) , 90 );
		$link2 = array(
								"id"=>$sid,
								"report"=> $list_id,
								"view"=>"tracker",
								"url" => "{sp-unsubscribe-url}"
							);



							$code2 = SendPress_Data::encrypt( $link2 );
							$link2 = SendPress_Manager::public_url($code2);
		$headers = array(
			'Content-Type: text/html; charset=' . SendPress_Option::get('email-charset','UTF-8'), 
			'X-SP-LIST: ' . $this->list_id . ';',
			'X-SP-REPORT: ' . $this->report_id . ';',
			'X-SP-SUBSCRIBER: '. $this->sid . ';',
			'X-SP-METHOD: website wp_mail',
			'From: '. SendPress_Option::get('fromname') .' <'.SendPress_Option::get('fromemail').'>',
			'List-Unsubscribe: <'.$link2.'>'
			 );
		
		$r = wp_mail($to, $subject, $html, $headers);
		
		//remove_filter( 'phpmailer_init' , array( $this , 'wpmail_init' ) , 90 );

		return $r;
	}


	function send_emailx($to, $subject, $html, $text, $istest = false, $sid , $list_id, $report_id ){
		
		$phpmailer = new SendPress_PHPMailer;
		/*
		 * Make sure the mailer thingy is clean before we start,  should not
		 * be necessary, but who knows what others are doing to our mailer
		 */
		$phpmailer->ClearAddresses();
		$phpmailer->ClearAllRecipients();
		$phpmailer->ClearAttachments();
		$phpmailer->ClearBCCs();
		$phpmailer->ClearCCs();
		$phpmailer->ClearCustomHeaders();
		$phpmailer->ClearReplyTos();

		
		$charset = SendPress_Option::get('email-charset','UTF-8');
		$encoding = SendPress_Option::get('email-encoding','8bit');
		
		$phpmailer->CharSet = $charset;
		$phpmailer->Encoding = $encoding;


		if($charset != 'UTF-8'){
             $html = $this->change($html,'UTF-8',$charset);
             $text = $this->change($text,'UTF-8',$charset);
             $subject = $this->change($subject,'UTF-8',$charset);
                    
            }

            $from_email = SendPress_Option::get('fromemail');
		$phpmailer->From = $from_email;
		$phpmailer->FromName = SendPress_Option::get('fromname');

        //$subject = str_replace(array('â€™','â€œ','â€�','â€“'),array("'",'"','"','-'),$subject);
        //$html = str_replace(chr(194),chr(32),$html);
		//$text = str_replace(chr(194),chr(32),$text);
		//return $email;
		
		$phpmailer->AddAddress( trim( $to ) );
		$phpmailer->AltBody= $text;
		$phpmailer->Subject = $subject;
		$content_type = 'text/html';
		$phpmailer->MsgHTML( $html );
		$phpmailer->ContentType = $content_type;
		// Set whether it's plaintext, depending on $content_type
		//if ( 'text/html' == $content_type )
		$phpmailer->IsHTML( true );
		$hosting = SendPress_Option::get('website-hosting-provider');
		if($hosting == 'godaddy'){
			// We are sending SMTP mail
			$phpmailer->IsSMTP();
			// Set the other options
			$phpmailer->Host = 'relay-hosting.secureserver.net';
		}

		// If we don't have a charset from the input headers
		//if ( !isset( $charset ) )
		//$charset = get_bloginfo( 'charset' );
		// Set the content-type and charset

		/**
		* We'll let php init mess with the message body and headers.  But then
		* we stomp all over it.  Sorry, my plug-inis more important than yours :)
		*/
		do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );
		
		
		//$phpmailer->Sender = 'bounce@sendpress.com';//SendPress_Option::get('fromemail');
		
		$hdr = new SendPress_SendGrid_SMTP_API();
		$hdr->addFilterSetting('dkim', 'domain', SendPress_Manager::get_domain_from_email($from_email) );
		//$phpmailer->AddCustomHeader( sprintf( 'X-SP-MID: %s',$email->messageID ) );
		$phpmailer->AddCustomHeader(sprintf( 'X-SMTPAPI: %s', $hdr->asJSON() ) );
		$phpmailer->AddCustomHeader('X-SP-METHOD: website');
		// Set SMTPDebug to 2 will collect dialogue between us and the mail server
		$phpmailer->AddCustomHeader('X-SP-LIST: ' . $list_id );
		$phpmailer->AddCustomHeader('X-SP-REPORT: ' . $report_id );
		$phpmailer->AddCustomHeader('X-SP-SUBSCRIBER: '. $sid );
		if($istest == true){
			$phpmailer->SMTPDebug = 2;
		
			// Start output buffering to grab smtp output
			ob_start(); 
		}

		
		// Send!
		$result = true; // start with true, meaning no error
		$result = @$phpmailer->Send();

		//$phpmailer->SMTPClose();
		if($istest == true){
			// Grab the smtp debugging output
			$smtp_debug = ob_get_clean();
			SendPress_Option::set('phpmailer_error', $phpmailer->ErrorInfo);
			SendPress_Option::set('last_test_debug', $smtp_debug);
			//$this->last_send_smtp_debug = $smtp_debug;
		
		}
		
		if (  $result != true ){
			$log_message = 'Website <br>';
			$log_message .= $to . "<br>";
			
			if( $istest == true  ){
				$log_message .= "<br><br>";
				$log_message .= $smtp_debug;
			}
			//$phpmailer->ErrorInfo
			SPNL()->log->add(  $phpmailer->ErrorInfo , $log_message , 0 , 'sending' );

		}	


		if (  $result != true && $istest == true  ) {
			$hostmsg = 'host: '.($phpmailer->Host).'  port: '.($phpmailer->Port).'  secure: '.($phpmailer->SMTPSecure) .'  auth: '.($phpmailer->SMTPAuth).'  user: '.($phpmailer->Username)."  pass: *******\n";
		    $msg = '';
			$msg .= __('The result was: ','sendpress').$result."\n";
		    $msg .= __('The mailer error info: ','sendpress').$phpmailer->ErrorInfo."\n";
		    $msg .= $hostmsg;
		    $msg .= __("The SMTP debugging output is shown below:\n","sendpress");
		    $msg .= $smtp_debug."\n";
		    //$msg .= 'The full debugging output(exported mailer) is shown below:\n';
		    //$msg .= var_export($phpmailer,true)."\n";
			//$this->append_log($msg);								
		}

	
		
		return $result;

	}




















	


}


}