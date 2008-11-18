<?php
class SimpleContactForm_ContactController extends Omeka_Controller_Action
{    
	public function formAction()
	{		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$message = $_POST['message'];
		$renderVars = array('name'=>$name, 'email'=>$email, 'message'=>$message);
				
		if (array_key_exists('email', $_POST)) {
	
			$entry = array();
	
			if(!empty($message) && !empty($email)) {
				$entry['message'] = $message; 
				$entry['email'] = $email;
				$entry['name'] = $name;
				$this->sendEmailNotification($entry);
	            $this->redirect->gotoRoute(array(), 'simple_contact_form_thankyou');
			} 
		}
		
		return $renderVars;
	}
	
	public function thankyouAction()
	{
		
	}
	
	protected function sendEmailNotification($entry) {
				
		//notify the admin
		//use the admin email specified in the plugin configuration.  
		$to_email = get_option('simple_contact_form_forward_to_email');
		if (!empty($to_email)) {
			$from_email = $entry['email']; //the user's email address
				$body = get_option('simple_contact_form_admin_notification_email_message_header') . "\n\n" . $entry['message'];
				$title = get_option('site_title') . ' - ' . get_option('simple_contact_form_admin_notification_email_subject');
			$header = "From: " . $from_email . "\r\n" .'X-Mailer: PHP/' . phpversion();
			$res = mail( $to_email, $title, $body, $header);
		}
		
		//notify the user who sent the message
		$from_email = get_option('simple_contact_form_reply_from_email');   
		$to_email = $entry['email']; // the user's email address
		if(!empty($from_email)) {	
			$body = get_option('simple_contact_form_user_notification_email_message_header') . "\n\n" . $entry['message'];
			$title = get_option('site_title') . ' - ' . get_option('simple_contact_form_user_notification_email_subject');
			$header = "From: " . $from_email . "\r\n" .'X-Mailer: PHP/' . phpversion();
			$res = mail($to_email, $title, $body, $header);		
		}
	}
}