<?php 
/**
* SimpleContactFormController
*/
class SimpleContactFormController extends Omeka_Controller_Action
{	
	public function init() {
		$this->session = new Zend_Session_Namespace('SimpleContactForm');
		$this->_modelClass = 'SimpleContactFormEntry';		
	}
		
	public function addAction() {
		$item = new Item;
		return $this->renderContributeForm($item);		
	}
	
	public function thankyouAction() {
		$this->render('simplecontactform/thankyou.php');
	}
	
	protected function renderContributeForm($item) {
		return $this->render('simplecontactform/add.php', compact('item'));		
	}
	
	/**
	 * Final submission redirect to a thank-you page
	 *
	 * @return void
	 **/
	public function submitAction() {		
		$session = $this->session;
		$item = $session->item;
		$item->name = $_POST['name'];
		$item->message = $_POST['message'];
		$item->email = $_POST['email'];
		$item->save();
		
		$this->sendEmailNotification($item);
		
		$this->_redirect('contribution/thankyou');
	}
	
	protected function sendEmailNotification($entry) {
		//notify the admin
		//use the admin email specified in the plugin configuration.  
		//if that does not exist, then use the admin email specified for the site.
		$to_email = get_option('simple_contact_form_notification_email');
		if (empty($to_email)) {
			$to_email = get_option('administrator_email'); // use the admin email defined in the site
		}
		$from_email = $item->email; //the user's email address
		$body = "A user has contacted the admin at " . get_option('site_title') . " with the following message:\n\n" . $item->message;
		$title = "User Has Contacted  " . get_option('site_title');
		$header = "From: " . $from_email . "\r\n" .'X-Mailer: PHP/' . phpversion();
		$res = mail( $to_email, $title, $body, $header);
	
		//notify the user who sent the message
		$from_email = get_option('simple_contact_form_notification_email');   
		$to_email = $item->email; // the user's email address
		//If this field is empty, don't send the email
		if(empty($from_email)) {
			return;
		}
		$body = "Thank you for contacting " . get_option('site_title') . " with the following message:\n\n" . $item->message;
		$title = "Thank You For Contacting " . get_option('site_title');
		$header = "From: " . $from_email . "\r\n" .'X-Mailer: PHP/' . phpversion();
		$res = mail($to_email, $title, $body, $header);		
	}
}
 
?>
