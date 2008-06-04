<?php 
/**
* SimpleContactFormController
*/
class SimpleContactFormController extends Omeka_Controller_Action {
			
	public function addAction() {
		if (!empty($_POST)) {
			$this->submitAction();
		}
		return $this->render('simplecontactform/add.php');					
	}
	
	public function thankyouAction() {
		$this->render('simplecontactform/thankyou.php');
	}
	
	/**
	 * add entry and redirect to a thank-you page
	 *
	 * @return void
	 **/
	
	public function submitAction() {		
		//$db = get_db();
		$message = $_POST['message'];
		$email = $_POST['email'];
		$name = $_POST['name'];
	
		if (array_key_exists('email', $_POST)) {
	
			$entry = new SimpleContactFormEntry();
	
			if(!empty($text)) {
				$entry->message = $message; 
				$entry->email = $email;
				$entry->name = $name;
				$this->sendEmailNotification($entry);
				$this->_redirect('simple-contact-form/thankyou'); //change for .10 version
			} 
		}		
	}
	
	protected function sendEmailNotification($entry) {
		
		//notify the admin
		//use the admin email specified in the plugin configuration.  
		$to_email = get_option('simple_contact_form_forward_to_email');
		if (empty($to_email)) {
			$to_email = get_option('administrator_email'); // use the admin email defined in the site
			$from_email = $entry->email; //the user's email address
			$body = "A user has contacted the admin at " . get_option('site_title') . " with the following message:\n\n" . $entry->message;
			$title = "User Has Contacted  " . get_option('site_title');
			$header = "From: " . $from_email . "\r\n" .'X-Mailer: PHP/' . phpversion();
			$res = mail( $to_email, $title, $body, $header);
		}
		
		//notify the user who sent the message
		$from_email = get_option('simple_contact_form_reply_to_email');   
		$to_email = $entry->email; // the user's email address
		//If this field is empty, don't send the email
		if(empty($from_email)) {	
			$body = "Thank you for contacting " . get_option('site_title') . " with the following message:\n\n" . $item->message;
			$title = "Thank You For Contacting " . get_option('site_title');
			$header = "From: " . $from_email . "\r\n" .'X-Mailer: PHP/' . phpversion();
			$res = mail($to_email, $title, $body, $header);		
		}
	}
}
 
?>
