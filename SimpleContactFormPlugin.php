<?php

/**
 * @version $Id$
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright Center for History and New Media, 2010
 * @package SimpleContactForm
 */

/**
 * SimpleContactForm plugin class
 *
 * @copyright Center for History and New Media, 2010
 * @package SimpleContactForm
 */
// Define Constants.
define('SIMPLE_CONTACT_FORM_PAGE_PATH', 'contact/');
define('SIMPLE_CONTACT_FORM_CONTACT_PAGE_TITLE', 'Contact Us');
define('SIMPLE_CONTACT_FORM_CONTACT_PAGE_INSTRUCTIONS', 'Please send us your comments and suggestions.');
define('SIMPLE_CONTACT_FORM_THANKYOU_PAGE_TITLE', 'Thank You For Your Feedback');
define('SIMPLE_CONTACT_FORM_THANKYOU_PAGE_MESSAGE', 'We appreciate your comments and suggestions.');
define('SIMPLE_CONTACT_FORM_ADMIN_NOTIFICATION_EMAIL_SUBJECT', 'A User Has Contacted You');
define('SIMPLE_CONTACT_FORM_ADMIN_NOTIFICATION_EMAIL_MESSAGE_HEADER', 'A user has sent you the following message:');
define('SIMPLE_CONTACT_FORM_USER_NOTIFICATION_EMAIL_SUBJECT', 'Thank You');
define('SIMPLE_CONTACT_FORM_USER_NOTIFICATION_EMAIL_MESSAGE_HEADER', 'Thank you for sending us the following message:');
define('SIMPLE_CONTACT_FORM_ADD_TO_MAIN_NAVIGATION', 1);


class SimpleContactFormPlugin extends Omeka_Plugin_AbstractPlugin
{
    // Define Hooks
    protected $_hooks = array(
        'install',
        'uninstall',
        'define_routes',
        'config_form',
        'config'
    );

    //Add filters
    protected $_filters = array(
        'public_navigation_main'
    );

   public function hookInstall()
    {
        set_option('simple_contact_form_reply_from_email', get_option('administrator_email'));
        set_option('simple_contact_form_forward_to_email', get_option('administrator_email'));    
        set_option('simple_contact_form_admin_notification_email_subject', SIMPLE_CONTACT_FORM_ADMIN_NOTIFICATION_EMAIL_SUBJECT);
        set_option('simple_contact_form_admin_notification_email_message_header', SIMPLE_CONTACT_FORM_ADMIN_NOTIFICATION_EMAIL_MESSAGE_HEADER);
        set_option('simple_contact_form_user_notification_email_subject', SIMPLE_CONTACT_FORM_USER_NOTIFICATION_EMAIL_SUBJECT);
        set_option('simple_contact_form_user_notification_email_message_header', SIMPLE_CONTACT_FORM_USER_NOTIFICATION_EMAIL_MESSAGE_HEADER);
        set_option('simple_contact_form_contact_page_title', SIMPLE_CONTACT_FORM_CONTACT_PAGE_TITLE);
        set_option('simple_contact_form_contact_page_instructions', SIMPLE_CONTACT_FORM_CONTACT_PAGE_INSTRUCTIONS);
        set_option('simple_contact_form_thankyou_page_title', SIMPLE_CONTACT_FORM_THANKYOU_PAGE_TITLE);
        set_option('simple_contact_form_thankyou_page_message', SIMPLE_CONTACT_FORM_THANKYOU_PAGE_MESSAGE);    
        set_option('simple_contact_form_add_to_main_navigation', SIMPLE_CONTACT_FORM_ADD_TO_MAIN_NAVIGATION);    
    }

    public function hookUninstall()
    {
        delete_option('simple_contact_form_reply_from_email');
        delete_option('simple_contact_form_forward_to_email');    
        delete_option('simple_contact_form_admin_notification_email_subject');
        delete_option('simple_contact_form_admin_notification_email_message_header');
        delete_option('simple_contact_form_user_notification_email_subject');
        delete_option('simple_contact_form_user_notification_email_message_header');
        delete_option('simple_contact_form_contact_page_title');
        delete_option('simple_contact_form_contact_page_instructions');
        delete_option('simple_contact_form_thankyou_page_title');
        delete_option('simple_contact_form_add_to_main_navigation');    
    }

    /**
     * Adds 2 routes for the form and the thank you page.
     **/
    function hookDefineRoutes($args)
    {
        $router = $args['router'];
        $router->addRoute(
            'simple_contact_form_form', 
            new Zend_Controller_Router_Route(
                SIMPLE_CONTACT_FORM_PAGE_PATH, 
                array('module'       => 'simple-contact-form')
            )
        );

        $router->addRoute(
            'simple_contact_form_thankyou', 
            new Zend_Controller_Router_Route(
                SIMPLE_CONTACT_FORM_PAGE_PATH.'thankyou', 
                array(
                    'module'       => 'simple-contact-form', 
                    'controller'   => 'index', 
                    'action'       => 'thankyou', 
                )
            )
        );
    }

    public function hookConfigForm() 
    {
        include 'config_form.php';
    }

    public function hookConfig($args)
    {
        $post = $args['post'];
        set_option('simple_contact_form_reply_from_email', $post['reply_from_email']);
        set_option('simple_contact_form_forward_to_email', $post['forward_to_email']);    
        set_option('simple_contact_form_admin_notification_email_subject', $post['admin_notification_email_subject']);
        set_option('simple_contact_form_admin_notification_email_message_header', $post['admin_notification_email_message_header']);
        set_option('simple_contact_form_user_notification_email_subject', $post['user_notification_email_subject']);
        set_option('simple_contact_form_user_notification_email_message_header', $post['user_notification_email_message_header']);
        set_option('simple_contact_form_contact_page_title', $post['contact_page_title']);
        set_option('simple_contact_form_contact_page_instructions',$post['contact_page_instructions']);
        set_option('simple_contact_form_thankyou_page_title', $post['thankyou_page_title']);
        set_option('simple_contact_form_thankyou_page_message', $post['thankyou_page_message']);
        set_option('simple_contact_form_add_to_main_navigation', $post['add_to_main_navigation']);
    }

    public function filterPublicNavigationMain($nav)
    {
        $contact_title = get_option('simple_contact_form_contact_page_title');
        $contact_add_to_navigation = get_option('simple_contact_form_add_to_main_navigation');
        if ($contact_add_to_navigation) {
            //$nav[$contact_title] = uri(array(), 'simple_contact_form_form');
                $nav[] = array(
                    'label'   => $contact_title,
                    'uri'     => url(array(),'simple_contact_form_form'),
                    'visible' => true
                );
        }
        return $nav;
    }
}