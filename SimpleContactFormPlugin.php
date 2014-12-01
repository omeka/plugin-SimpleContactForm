<?php
/**
 * SimpleContactFormPlugin class - represents the Simple Contact Form plugin
 *
 * @copyright Copyright 2008-2013 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
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
    /**
     * @var array Hooks for the plugin.
     */
    protected $_hooks = array(
        'initialize',
        'install',
        'uninstall',
        'config_form',
        'config',
        'define_routes',
    );

    /**
     * @var array Options and their default values.
     */
    protected $_filters = array(
        'public_navigation_main',
    );

    /**
     * @var array Options and their default values.
     */
    protected $_options = array(
        'simple_contact_form_reply_from_email' => '',
        'simple_contact_form_forward_to_email' => '',
        'simple_contact_form_admin_notification_email_subject' => SIMPLE_CONTACT_FORM_ADMIN_NOTIFICATION_EMAIL_SUBJECT,
        'simple_contact_form_admin_notification_email_message_header' => SIMPLE_CONTACT_FORM_ADMIN_NOTIFICATION_EMAIL_MESSAGE_HEADER,
        'simple_contact_form_user_notification_email_subject' => SIMPLE_CONTACT_FORM_USER_NOTIFICATION_EMAIL_SUBJECT,
        'simple_contact_form_user_notification_email_message_header' => SIMPLE_CONTACT_FORM_USER_NOTIFICATION_EMAIL_MESSAGE_HEADER,
        'simple_contact_form_contact_page_title' => SIMPLE_CONTACT_FORM_CONTACT_PAGE_TITLE,
        'simple_contact_form_contact_page_instructions' => SIMPLE_CONTACT_FORM_CONTACT_PAGE_INSTRUCTIONS,
        'simple_contact_form_thankyou_page_title' => SIMPLE_CONTACT_FORM_THANKYOU_PAGE_TITLE,
        'simple_contact_form_thankyou_page_message' => SIMPLE_CONTACT_FORM_THANKYOU_PAGE_MESSAGE,
        'simple_contact_form_add_to_main_navigation' => SIMPLE_CONTACT_FORM_ADD_TO_MAIN_NAVIGATION,
    );

    /**
     * Initialize this plugin.
     */
    public function hookInitialize()
    {
        // Add translation.
        add_translation_source(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'languages');

        if (version_compare(OMEKA_VERSION, '2.2', '>=')) {
             add_shortcode('simple_contact', array($this, 'shortcodeSimpleContact'));
        }
    }

    /**
     * Installs the plugin.
     */
    public function hookInstall()
    {
        $this->_options['simple_contact_form_reply_from_email'] = get_option('administrator_email');
        $this->_options['simple_contact_form_forward_to_email'] = get_option('administrator_email');

        $this->_installOptions();
    }

    /**
     * Uninstalls the plugin.
     */
    public function hookUninstall()
    {
        $this->_uninstallOptions();
    }

    /**
     * Shows plugin configuration page.
     *
     * @return void
     */
    public function hookConfigForm()
    {
        include 'config_form.php';
    }

    /**
     * Processes the configuration form.
     *
     * @return void
     */
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

    /**
     * Adds 2 routes for the form and the thank you page.
     */
    function hookDefineRoutes($args)
    {
        // Don't add these routes on the admin side to avoid conflicts.
        if (is_admin_theme()) {
            return;
        }

        $router = $args['router'];

        $router->addRoute(
            'simple_contact_form_form',
            new Zend_Controller_Router_Route(
                SIMPLE_CONTACT_FORM_PAGE_PATH,
                array(
                    'module' => 'simple-contact-form',
                )
            )
        );

        $router->addRoute(
            'simple_contact_form_thankyou',
            new Zend_Controller_Router_Route(
                SIMPLE_CONTACT_FORM_PAGE_PATH . 'thankyou',
                array(
                    'module'       => 'simple-contact-form',
                    'controller'   => 'index',
                    'action'       => 'thankyou',
                )
            )
        );
    }

    /**
     * Adds contact us in navigation.
     */
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

    /**
     * Shortcode to a simple contact form.
     *
     * @param array $args
     * @param Omeka_View $view
     * @return string
     */
    public function shortcodeSimpleContact($args, $view)
    {
        return $view->simpleContactForm((array) $args);
    }
}
