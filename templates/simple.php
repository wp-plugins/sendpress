<?php
/**
 * SendPress: Simple Single Column
 * Regions: Main
 * Description: A killer default email template.
 *
 */
// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}
global $post;

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>*|SP:SUBJECT|*</title>
	<style type="text/css">
		/* Based on The MailChimp Reset INLINE: Yes. */  
		/* Client-specific Styles */
		#outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
		body{height: 100%; width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;} 
		html{height: 100%;}
		/* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/ 
		.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */  
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		/* Forces Hotmail to display normal line spacing.  More on that: http://www.emailonacid.com/forum/viewthread/43/ */ 
		#backgroundTable {height: 100%; margin:0; padding:0; width:100% !important; line-height: 100% !important;}
		/* End reset */

		/* Some sensible defaults for images
		Bring inline: Yes. */
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;} 
		a img {border:none;} 
		.image_fix {display:block;}

		/* Yahoo paragraph fix
		Bring inline: Yes. */
		p {margin: 1em 0;}

		/* Hotmail header color reset
		Bring inline: Yes. */
		h1, h2, h3, h4, h5, h6 {color: black !important;}

		/*h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {color: blue !important;}*/
/*
		
			h1, .h1{
				 color:#202020;
				display:block;
				 font-family:Arial;
				 font-size:34px;
				 font-weight:bold;
				 line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}

			
			h2, .h2{
				color:#202020;
				display:block;
				font-family:Arial;
				font-size:30px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}

			
			h3, .h3{
				color:#202020;
				display:block;
				font-family:Arial;
				font-size:26px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}

			
			h4, .h4{
				color:#202020;
				display:block;
				font-family:Arial;
				font-size:22px;
				font-weight:bold;
				line-height:100%;
				margin-top:0;
				margin-right:0;
				margin-bottom:10px;
				margin-left:0;
				text-align:left;
			}

 h5, .h5{
                color:#202020;
                display:block;
                font-family:Arial;
                font-size:18px;
                font-weight:bold;
                line-height:100%;
                margin-top:0;
                margin-right:0;
                margin-bottom:10px;
                margin-left:0;
                text-align:left;
            }

 h6, .h6{
                color:#202020;
                display:block;
                font-family:Arial;
                font-size:16px;
                font-weight:bold;
                line-height:100%;
                margin-top:0;
                margin-right:0;
                margin-bottom:10px;
                margin-left:0;
                text-align:left;
            }
	*/
           /* 
		h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {
		color: red !important;  Preferably not the same color as the normal header link color.  There is limited support for psuedo classes in email clients, this was added just for good measure. 
		}
	*//*
		h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited {
		color: purple !important;  Preferably not the same color as the normal header link color. There is limited support for psuedo classes in email clients, this was added just for good measure. 
		}
*/
		/* Outlook 07, 10 Padding issue fix
		Bring inline: No.*/
		table td {border-collapse: collapse;}

		/* Styling your links has become much simpler with the new Yahoo.  In fact, it falls in line with the main credo of styling in email and make sure to bring your styles inline.  Your link colors will be uniform across clients when brought inline.
		Bring inline: Yes. */
		a {color: orange;}


		.bodyContent img{
			display:inline;
			height:auto;
		}
	

		/***************************************************
		****************************************************
		MOBILE TARGETING
		****************************************************
		***************************************************/
		@media only screen and (max-device-width: 480px) {
			/* Part one of controlling phone number linking for mobile. */
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue; /* or whatever your want */
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important;
						pointer-events: auto;
						cursor: default;
					}

		}

		/* More Specific Targeting */

		@media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
		/* You guessed it, ipad (tablets, smaller screens, etc) */
			/* repeating for the ipad */
			a[href^="tel"], a[href^="sms"] {
						text-decoration: none;
						color: blue; /* or whatever your want */
						pointer-events: none;
						cursor: default;
					}

			.mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
						text-decoration: default;
						color: orange !important;
						pointer-events: auto;
						cursor: default;
					}
		}

		@media only screen and (-webkit-min-device-pixel-ratio: 2) {
		/* Put your iPhone 4g styles in here */ 
		}

		/* Android targeting */
		@media only screen and (-webkit-device-pixel-ratio:.75){
		/* Put CSS for low density (ldpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1){
		/* Put CSS for medium density (mdpi) Android layouts in here */
		}
		@media only screen and (-webkit-device-pixel-ratio:1.5){
		/* Put CSS for high density (hdpi) Android layouts in here */
		}
		/* end Android targeting */

	</style>

	<!-- Targeting Windows Mobile -->
	<!--[if IEMobile 7]>
	<style type="text/css">
	
	</style>
	<![endif]-->   

	<!-- ***********************************************
	****************************************************
	END MOBILE TARGETING
	****************************************************
	************************************************ -->

	<!--[if gte mso 9]>
		<style>
		/* Target Outlook 2007 and 2010 */
		</style>
	<![endif]-->
</head>
<body height="100%" width="100%" margin="0" padding="0"><!-- Email Generated by WordPress using SendPress -->
<!-- Wrapper/Container Table: Use a wrapper table to control the width and the background color consistently of your email. Use this approach instead of setting attributes on the body tag. -->
<table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" height="100%" width="100%" style="margin: 0; padding: 10px; background-color: *|SP:BODYBG|*">
	<tr>
		<td valign="top"> 
		<table cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
				<td width="602" valign="top" style="text-align:center;" class="browserContent">
					<table cellpadding="20" cellspacing="0"  width="100%" border="0" align="center">
						<tr>
							<td width="100%" valign="top" style="font-size: 13px; font-family: arial,sans-serif; color: *|SP:BODYTEXT|*;">
							*|SP:BROWSER|*
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<!-- Tables are the most common way to format your email consistently. Set your table widths inside cells and in most cases reset cellpadding, cellspacing, and border to zero. Use nested tables as a way to space effectively in your message. -->
		<table cellpadding="0" cellspacing="0" border="0" align="center" style="border: solid 1px *|SP:CONTENTBORDER|*; background-color: *|SP:CONTENTBG|*; color: *|SP:CONTENTTEXT|*;">
			<tr>
				<td width="602" valign="top" class="bodyContent">
					<table cellpadding="0" cellspacing="0"  width="100%" border="0" align="center" style="font-size: 13px; font-family: arial,sans-serif;  background-color: *|SP:HEADERBG|*; color: *|SP:HEADERTEXT|*;">
									<tr>
										<td width="100%" valign="top" align="center"  >
										*|SP:HEADERCONTENT|*
										</td>
									</tr>
								</table>
					<table cellpadding="10" cellspacing="0"  width="100%" border="0" align="left">
						<tr>
							<td width="100%" valign="top" style="font-size: 13px; font-family: arial,sans-serif; color: *|SP:CONTENTTEXT|*;">
								<?php 
									add_filter('the_content', 'do_shortcode', 11);
									$content = apply_filters('the_content', $post->post_content);
									$content = str_replace(']]>', ']]&gt;', $content);
									echo $content;
									//echo nl2br($content);
								?>
							</td>
						</tr>
					</table>

				</td>
			</tr>
		</table>
		<table cellpadding="0" cellspacing="0" border="0" align="center">
			<tr>
				<td width="602" valign="top" style="text-align:center;" class="footerContent">
					<table cellpadding="10" cellspacing="0"  width="100%" border="0" align="center">
						<tr>
							<td width="100%" valign="top" style="font-size: 13px; font-family: arial,sans-serif; color: *|SP:BODYTEXT|*;">
							*|SP:SOCIAL|*
							</td>
						</tr>
						<tr>
							<td width="100%" valign="top" style="font-size: 13px; font-family: arial,sans-serif; color: *|SP:BODYTEXT|*;">
							*|SP:CANSPAM|*
							</td>
						</tr>
						<tr>
							<td width="100%" valign="top" style="font-size: 13px; font-family: arial,sans-serif; color: *|SP:BODYTEXT|*;">
							*|SP:UNSUBSCRIBE|*
							*|SP:MANAGE|*
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

		<!-- End example table -->
		</td>
	</tr>
</table>  

<!-- End of wrapper table -->
</body>
</html>