<?php
/**
 * Controller for Contact form.
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2014
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package SimpleContact
 */

class SimpleContact_IndexController extends Omeka_Controller_AbstractActionController
{
    /**
     * Display the contact form.
     */
    public function indexAction()
    {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        $path = isset($_POST['path']) ? $_POST['path'] : '';

        $captchaObj = $this->_setupCaptcha();

        if ($this->getRequest()->isPost()) {
            // If the form submission is valid, then save message and, if
            // wanted, send out the email.
            if ($this->_validateFormSubmission($captchaObj)) {
                $this->_sendEmailNotification($email, $name, $message);
                $url = SIMPLE_CONTACT_PATH . '/thankyou';
                $this->_helper->redirector->goToUrl($url);
            }
        }

        // Render the HTML for the captcha itself.
        // Pass this a blank Zend_View b/c ZF forces it.
        if ($captchaObj) {
            $captcha = $captchaObj->render(new Zend_View);
        } else {
            $captcha = '';
        }

        $this->view->assign(compact('name', 'email', 'message', 'path', 'captcha'));
    }

    /**
     * Display the thank you page.
     */
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
            $this->_helper->flashMessenger(__('Your CAPTCHA submission was invalid, please try again.'));
            $valid = false;
        } else if (!Zend_Validate::is($email, 'EmailAddress')) {
            $this->_helper->flashMessenger(__('Please enter a valid email address.'));
            $valid = false;
        } else if (empty($msg)) {
            $this->_helper->flashMessenger(__('Please enter a message.'));
            $valid = false;
        }

        return $valid;
    }

    protected function _setupCaptcha()
    {
        return Omeka_Captcha::getCaptcha();
    }

    protected function _sendEmailNotification($email, $name, $message)
    {
        // Notify the admin.
        // Use the admin email specified in the plugin configuration.
        $forwardToEmail = get_option('simple_contact_notification_admin_to');
        if (!empty($forwardToEmail)) {
            $mail = new Zend_Mail('UTF-8');
            $mail->setFrom($email, $name);
            $mail->addTo($forwardToEmail);
            $mail->setSubject(get_option('site_title') . ' - ' . get_option('simple_contact_notification_admin_subject'));
            $mail->setBodyText(get_option('simple_contact_notification_admin_header') . "\n\n" . $message);
            $mail->send();
        }

        // Notify the user who sent the message.
        $replyToEmail = get_option('simple_contact_notification_user_from');
        if (!empty($replyToEmail)) {
            $mail = new Zend_Mail('UTF-8');
            $mail->setFrom($replyToEmail);
            $mail->addTo($email, $name);
            $mail->setSubject(get_option('site_title') . ' - ' . get_option('simple_contact_notification_user_subject'));
            $mail->setBodyText(get_option('simple_contact_notification_user_header') . "\n\n" . $message);
            $mail->send();
        }
    }
}
