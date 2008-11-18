<?php
class SimpleContactForm_IndexController extends Omeka_Controller_Action
{    
	public function indexAction()
	{	
	    $captchaObj = $this->_setupCaptcha();
	    
	    if ($this->getRequest()->isPost()) {
	        $name = $_POST['name'];
    		$email = $_POST['email'];
    		$message = $_POST['message'];
    		
    		// If the form submission is valid, then send out the email
    		if ($this->_validateFormSubmission($captchaObj)) {
    		    $entry = array();
    		    $entry['message'] = $message; 
				$entry['email'] = $email;
				$entry['name'] = $name;
				$this->sendEmailNotification($entry);
	            $this->redirect->gotoRoute(array(), 'simple_contact_form_thankyou');
    		}
	    }	
	    
	    // Render the HTML for the captcha itself.
	    // Pass this a blank Zend_View b/c ZF forces it.
		if ($captchaObj) {
		    $captcha = $captchaObj->render(new Zend_View);
		}
		
		
		$this->view->assign(compact('name','email','message', 'captcha'));
	}
	
	public function thankyouAction()
	{
		
	}
	
	protected function _validateFormSubmission($captcha = null)
	{
	    $valid = true;
	    $msg = $this->getRequest()->getPost('message');
	    $email = $this->getRequest()->getPost('email');
	    // ZF ReCaptcha ignores the 1st arg.
	    if ($captcha and !$captcha->isValid('foo', $_POST)) {
            $this->flashError('Your CAPTCHA submission was invalid, please try again.');
            $valid = false;
	    } else if (!Zend_Validate::is($email, 'EmailAddress')) {
            $this->flashError('Please enter a valid email address.');
            $valid = false;
	    } else if (empty($msg)) {
            $this->flashError('Please enter a message.');
            $valid = false;
	    }
	    
	    return $valid;
	}
	
	protected function _setupCaptcha()
	{
	    $publicKey = get_option('simple_contact_form_recaptcha_public_key');
	    $privateKey = get_option('simple_contact_form_recaptcha_private_key');
	    
	    if (empty($publicKey) or empty($privateKey)) {
	       return;
	    }
	    
        // Originating request:
        $captcha = new Zend_Captcha_ReCaptcha(array(
            'pubKey'=>$publicKey, 
            'privKey'=>$privateKey));

        return $captcha;
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