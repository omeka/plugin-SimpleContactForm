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
     * Controller-wide initialization. Sets the underlying model to use.
     */
    public function init()
    {
        $this->_helper->db->setDefaultModelName('SimpleContact');
    }

    /**
     * Display the contact form.
     */
    public function writeAction()
    {
        // TODO Use a true form and getValue().
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';
        $path = isset($_POST['path']) ? $_POST['path'] : '';

        $captchaObj = $this->_setupCaptcha();

        if ($this->getRequest()->isPost()) {
            // If the form submission is valid, then save message and, if
            // wanted, send out the email.
            if ($this->_validateFormSubmission($captchaObj)) {
                $this->_saveContact($email, $name, $message, $path);
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
        $message = $this->getRequest()->getPost('message');
        $email = $this->getRequest()->getPost('email');
        // ZF ReCaptcha ignores the 1st arg.
        if ($captcha and !$captcha->isValid('foo', $_POST)) {
            $this->_helper->flashMessenger(__('Your CAPTCHA submission was invalid, please try again.'));
            $valid = false;
        }
        elseif (!Zend_Validate::is($email, 'EmailAddress')) {
            $this->_helper->flashMessenger(__('Please enter a valid email address.'));
            $valid = false;
        }
        elseif (empty($message)) {
            $this->_helper->flashMessenger(__('Please enter a message.'));
            $valid = false;
        }

        return $valid;
    }

    protected function _setupCaptcha()
    {
        return Omeka_Captcha::getCaptcha();
    }

    /**
     * Save the contact in the base.
     */
    protected function _saveContact($email, $name, $message, $path)
    {
        if (get_option('simple_contact_save_into_base')) {
            $simpleContact = new SimpleContact;
            $simpleContact->status = 'received';
            $simpleContact->email = $email;
            $simpleContact->name = $name;
            $simpleContact->message = $message;
            $simpleContact->path = $path;
            // Need getValue to run the filter.
            $simpleContact->ip = $_SERVER['REMOTE_ADDR'];
            $simpleContact->user_agent = $_SERVER['HTTP_USER_AGENT'];
            if ($user = current_user()) {
                $simpleContact->user_id = $user->id;
            }
            $simpleContact->checkSpam();
            $simpleContact->save();
        }
    }

    /**
     * Send the email notification to admin and user.
     */
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

    /**
     * Browse records action.
     */
    public function browseAction()
    {
        if (!$this->_hasParam('sort_field')) {
            $this->_setParam('sort_field', 'added');
        }

        if (!$this->_hasParam('sort_dir')) {
            $this->_setParam('sort_dir', 'd');
        }
        parent::browseAction();
    }

    /**
     * Use global settings for determining browse page limits.
     *
     * @return int
     */
    public function _getBrowseRecordsPerPage()
    {
        return is_admin_theme()
            ? (int) get_option('per_page_admin')
            : (int) get_option('per_page_public');
    }
}
