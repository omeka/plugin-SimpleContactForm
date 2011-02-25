<?php
/**
 * @version $Id$
 * @copyright Center for History and New Media, 2007-2011
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @package SimpleContactForm
 */

/**
 * Tests for SimpleContactForm.
 *
 * @package SimpleContactForm
 * @copyright Center for History and New Media, 2007-2011
 */
class SimpleContactForm_Test extends Omeka_Test_AppTestCase {
    
    protected $mailHelper;
    protected $mailTo;
    protected $mailAdmin;
    protected $mailName;
    protected $mailMessage;
    protected $_isAdminTest = false;
    
    public function setUp()
    {
        parent::setUp();
        $integrationHelper = new SimpleContactForm_IntegrationHelper;
        $integrationHelper->setUpPlugin();

        // Override existing options to ensure that ReCaptcha 
        // config does not interfere with tests (CAPTCHA should be disabled in 
        // test environment, though not in development/production).
        $bootstrap = $this->core->getBootstrap();
        $options = $bootstrap->options;
        unset($options[Omeka_Captcha::PUBLIC_KEY_OPTION]);
        unset($options[Omeka_Captcha::PRIVATE_KEY_OPTION]);
        $bootstrap->getContainer()->options = $options;

        $this->mailHelper = Omeka_Test_Helper_Mail::factory();        
        $this->mailTo = Zend_Registry::get('test_config')->email->to;   
        $this->mailAdmin = Zend_Registry::get('test_config')->email->administrator;        
        $this->mailHelper->reset();
        $this->mailName = 'Jim Safley';
        $this->mailMessage = 'Lorem ipsum dolor sit amet.';
        
        $post = array('name'    =>  $this->mailName,
                      'email'   =>  $this->mailTo,
                      'message' =>  $this->mailMessage);
                      
        $this->getRequest()->setPost($post);
        $this->getRequest()->setMethod('post');
        $this->dispatch('contact');
    }
    
    public function testSendMailToContacter() {
        $mailText = $this->mailHelper->getMailText(1);
        $this->assertThat($mailText, $this->stringContains("From: ".get_option('administrator_email')));
        $this->assertThat($mailText, $this->stringContains("To: ".$this->mailName." <".$this->mailTo.">"));
        $this->assertThat($mailText, $this->stringContains("Subject: ".get_option('site_title')." - ".get_option('simple_contact_form_user_notification_email_subject')));
        $this->assertThat($mailText, $this->stringContains(get_option('simple_contact_form_user_notification_email_message_header')));
    }
    
    public function testSendMailToAdministrator() {
        $mailText = $this->mailHelper->getMailText();          
        $this->assertThat($mailText, $this->stringContains("From: ".$this->mailName." <".$this->mailTo.">"));
        $this->assertThat($mailText, $this->stringContains("To: ".get_option('administrator_email')));
        $this->assertThat($mailText, $this->stringContains("Subject: ".get_option('site_title')." - ".get_option('simple_contact_form_admin_notification_email_subject')));
        $this->assertThat($mailText, $this->stringContains(get_option('simple_contact_form_admin_notification_email_message_header')));
    }
    
    public function testContactFormRedirect() {
        $this->assertRedirectTo('/contact/thankyou');
    }
}
