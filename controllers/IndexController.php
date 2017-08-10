<?php
/**
 * @copyright Roy Rosenzweig Center for History and New Media, 2007-2014
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package SimpleContactForm
 */

/**
 * Controller for Contact form.
 *
 * @package SimpleContactForm
 */
class SimpleContactForm_IndexController extends Omeka_Controller_AbstractActionController
{
    public function indexAction()
    {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';;
        $message = isset($_POST['message']) ? $_POST['message'] : '';;

        $captchaObj = $this->_setupCaptcha();

        if ($this->getRequest()->isPost()) {
            $additionalFields = SimpleContactFormPlugin::prepareAdditionalFields();
            // If the form submission is valid, then send out the email
            if ($this->_validateFormSubmission($captchaObj, $additionalFields)) {
                $this->sendEmailNotification($_POST['email'], $_POST['name'], $_POST['message'], $additionalFields);
                $url = WEB_ROOT."/".SIMPLE_CONTACT_FORM_PAGE_PATH."thankyou";
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

        $this->view->assign(compact('name','email','message', 'captcha'));
    }

    public function thankyouAction()
    {
    }

    protected function _validateFormSubmission($captcha = null, $additionalFields)
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
        } else {
          foreach($additionalFields as $additionalField) {
            if ($additionalField["mandatoryField"]) {
              $empty = (
                $additionalField["fieldType"] == "dropdown"
                  ? ($additionalField["fieldValue"] == -1)
                  : (empty($additionalField["fieldValue"]))
              );
              if ($empty) {
                $this->_helper->flashMessenger( sprintf(__('You may not leave the "%s" field undefined.'), $additionalField["fieldLabel"]) );
                $valid = false;
                break;
              }
            }
          }
        }

        return $valid;
    }

    protected function _setupCaptcha()
    {
        return Omeka_Captcha::getCaptcha();
    }

    protected function sendEmailNotification($formEmail, $formName, $formMessage, $additionalFields)
    {

        // compose text from additional fields (if present)
        $additionalText = "";
        foreach($additionalFields as $additionalField) {
          $additionalText .=
            "\n\n"
            . $additionalField["fieldLabel"] . ": "
            . ($additionalField["fieldType"] == "multi" ? "\n\n" : "")
            . $additionalField["fieldValue"]
          ;
        }

        //notify the admin
        //use the admin email specified in the plugin configuration.
        $forwardToEmail = get_option('simple_contact_form_forward_to_email');
        if (!empty($forwardToEmail)) {
            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyText(get_option('simple_contact_form_admin_notification_email_message_header') . "\n\n" . $formMessage . $additionalText);
            $mail->setFrom($formEmail, $formName);
            $mail->addTo($forwardToEmail);
            $mail->setSubject(get_option('site_title') . ' - ' . get_option('simple_contact_form_admin_notification_email_subject'));
            $mail->send();
        }

        //notify the user who sent the message
        $replyToEmail = get_option('simple_contact_form_reply_from_email');
        if (!empty($replyToEmail)) {
            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyText(get_option('simple_contact_form_user_notification_email_message_header') . "\n\n" . $formMessage . $additionalText);
            $mail->setFrom($replyToEmail);
            $mail->addTo($formEmail, $formName);
            $mail->setSubject(get_option('site_title') . ' - ' . get_option('simple_contact_form_user_notification_email_subject'));
            $mail->send();
        }
    }
}
